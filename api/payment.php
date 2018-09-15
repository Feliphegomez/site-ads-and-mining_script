<?php 

include('autoload.php');

$jsonFinal = new stdClass();
$jsonFinal->error = true;
$jsonFinal->data = null;

if(
	isset($_GET['token'])
){
	$token = decodeToken($_GET['token']);
	$wallet = infoWallet($token[2], $token[1]);
	$balance = balanceWallet($_GET['token']);
	$wallet['balance'] = $balance->value;
	
	$wallet = new WalletInfo($wallet);
	
	if($wallet->balance >= ($wallet->minPay + 0.00000001)){
		$payme = $wallet->balance - $wallet->fee;
		$wallet->payme = $payme;
		
		$checkb = datosSQL("Select * from ".TBL_BALANCE." where wallet_id='{$token[0]}' ");
		if(isset($checkb->error) && $checkb->error == false && isset($checkb->data[0])){
			
			$valuenew = $checkb->data[0]['value'] - $wallet->balance;
			$update_balance = crearSQL("UPDATE ".TBL_BALANCE." SET value=? WHERE wallet_id='{$token[0]}' ",array($valuenew));
			
			
			if(isset($update_balance->error) && $update_balance->error == false){
				$create = crearSQL("INSERT INTO ".TBL_WITHDRAW." (wallet_id, request, fee, totalPaid) VALUES (?, ?, ?, ?) ", array(
					$token[0], $wallet->balance, $wallet->fee, $wallet->payme
				));
				
			
				if(isset($create->error) && $create->error == false){
					$jsonFinal->error = false;
					$jsonFinal->data = (int) $create->last_id;					
				}				
			}
		}else{};
	}
	
}else{
	
	$dt = new DateTime();
	$dateinicio = $dt->format('Y-m-d H:i:s');
	$datefin = date('Y-m-d H:i:s', strtotime('-1 month', strtotime($dateinicio)));

	$ret = new stdClass();
	$ret->jobs = array();
	$ret->total_jobs = 0;
	$ret->founds = array();
	$ret->total_found_hashes = 0;
	$ret->total_founds = 0;
	$ret->payment = array();
	$ret->total_payment = 0;
	$ret->total_payment_value = 0;
	$ret->pdtePayment = array();
	$ret->total_pdtePayment = 0;
	$ret->total_pdtePayment_value = 0;
	$ret->users = 0;
	$ret->orphan = 0;
	
	$check = datosSQL("Select COUNT(`".TBL_WALLET."`.`id`) As `total_users` from `".TBL_WALLET."` ");
	
	if(isset($check->error) && $check->error == false && isset($check->data[0])){
		$ret->users = (int) $check->data[0]['total_users'];
	};
	
	$check = datosSQL("Select (`".TBL_WALLET."`.`id`) As wallet_id
		, `".TBL_WALLET."`.`coin` As `wallet_coin`
		, `".TBL_WALLET."`.`address` As `wallet_address`
		, (`".TBL_FOUND."`.id) as found_id
		, (`".TBL_FOUND."`.hashes) as found_hashes
		, (`".TBL_FOUND."`.hashesPerSecond) as found_hashesPerSecond
	from `".TBL_FOUND."`
	INNER JOIN `".TBL_WALLET."` ON 
		`".TBL_FOUND."`.wallet_id = `".TBL_WALLET."`.id AND `".TBL_FOUND."`.`create` <= ('{$dateinicio}')
		OR `".TBL_FOUND."`.wallet_id = `".TBL_WALLET."`.id AND `".TBL_FOUND."`.`create` >= ('{$datefin}') order by `".TBL_FOUND."`.`create` desc
	");
	
	if(isset($check->error) && $check->error == false && isset($check->data[0])){
		foreach($check->data As $item){
			$itemn = new stdClass();
			$itemn->wallet_id = (int) $item['wallet_id'];
			$itemn->wallet_coin = $item['wallet_coin'];
			$itemn->wallet_address = $item['wallet_address'];
			$itemn->found_id = (int) $item['found_id'];
			$itemn->found_hashes = (float) $item['found_hashes'];
			$itemn->found_hashesPerSecond = (float) $item['found_hashesPerSecond'];
			
			$ret->total_found_hashes = $ret->total_found_hashes + $itemn->found_hashes;
			$ret->total_founds++;
			$ret->founds[] = $itemn;
		}
	};
	
	$check = datosSQL("Select (`".TBL_WALLET."`.`id`) As wallet_id
		, `".TBL_WALLET."`.`coin` As `wallet_coin`
		, `".TBL_WALLET."`.`address` As `wallet_address`
		, (`".TBL_JOB."`.id) as job_id
		, (`".TBL_JOB."`.throttle) as job_throttle
	from `".TBL_JOB."`
	INNER JOIN `".TBL_WALLET."` ON 
		`".TBL_JOB."`.wallet_id = `".TBL_WALLET."`.id AND `".TBL_JOB."`.`create` <= ('{$dateinicio}')
		OR `".TBL_JOB."`.wallet_id = `".TBL_WALLET."`.id AND `".TBL_JOB."`.`create` >= ('{$datefin}') order by `".TBL_JOB."`.`create` desc
	");
	
	if(isset($check->error) && $check->error == false && isset($check->data[0])){
		foreach($check->data As $item){
			$itemn = new stdClass();
			$itemn->wallet_id = (int) $item['wallet_id'];
			$itemn->wallet_coin = $item['wallet_coin'];
			$itemn->wallet_address = $item['wallet_address'];
			$itemn->job_id = $item['job_id'];
			$itemn->job_throttle = (float) $item['job_throttle'];
			$ret->total_jobs++;
			$ret->jobs[] = $itemn;
		}
	};
	
	if($ret->total_founds > 0 && $ret->total_jobs > 0){
		$ret->orphan = 100 - (($ret->total_founds * 100) / $ret->total_jobs);
	}
	
	$check = datosSQL("Select (`".TBL_WALLET."`.`id`) As wallet_id 
		, `".TBL_WALLET."`.`coin` As `wallet_coin` 
		, `".TBL_WALLET."`.`address` As `wallet_address`
		, (`".TBL_WITHDRAW."`.id) as withdraw_id 
		, (`".TBL_WITHDRAW."`.request) as withdraw_request
		, (`".TBL_WITHDRAW."`.fee) as withdraw_fee
		, (`".TBL_WITHDRAW."`.totalPaid) as withdraw_totalPaid
		, (`".TBL_WITHDRAW."`.tx) as withdraw_tx
	from `".TBL_WITHDRAW."` 
	INNER JOIN `".TBL_WALLET."` ON 
		`".TBL_WITHDRAW."`.status = '1' 
		AND `".TBL_WITHDRAW."`.wallet_id = `".TBL_WALLET."`.id 
		AND `".TBL_WITHDRAW."`.`create` <= ('{$dateinicio}') 
	OR `".TBL_WITHDRAW."`.status = '1' 
		AND `".TBL_WITHDRAW."`.wallet_id = `".TBL_WALLET."`.id 
		AND `".TBL_WITHDRAW."`.`create` >= ('{$datefin}') order by `".TBL_WITHDRAW."`.`create` desc");
	
	if(isset($check->error) && $check->error == false && isset($check->data[0])){
		foreach($check->data As $item){
			$itemn = new stdClass();
			$itemn->wallet_id = (int) $item['wallet_id'];
			$itemn->wallet_coin = $item['wallet_coin'];
			$itemn->wallet_address = $item['wallet_address'];
			$itemn->withdraw_id = (int) $item['withdraw_id'];
			$itemn->withdraw_request = (float) $item['withdraw_request'];
			$itemn->withdraw_fee = (float) $item['withdraw_fee'];
			$itemn->withdraw_totalPaid = (float) $item['withdraw_totalPaid'];
			$itemn->withdraw_tx = $item['withdraw_tx'];
			$ret->total_payment++;
			
			$ret->total_payment_value = $ret->total_payment_value + $itemn->withdraw_request;
			$ret->payment[] = $itemn;
		}
	};
	
	$check = datosSQL("Select (`".TBL_WALLET."`.`id`) As wallet_id 
		, `".TBL_WALLET."`.`coin` As `wallet_coin` 
		, `".TBL_WALLET."`.`address` As `wallet_address`
		, (`".TBL_WITHDRAW."`.id) as withdraw_id 
		, (`".TBL_WITHDRAW."`.request) as withdraw_request
		, (`".TBL_WITHDRAW."`.fee) as withdraw_fee
		, (`".TBL_WITHDRAW."`.totalPaid) as withdraw_totalPaid
		, (`".TBL_WITHDRAW."`.tx) as withdraw_tx
	from `".TBL_WITHDRAW."` 
	INNER JOIN `".TBL_WALLET."` ON 
		`".TBL_WITHDRAW."`.status = '0' 
		AND `".TBL_WITHDRAW."`.wallet_id = `".TBL_WALLET."`.id 
		AND `".TBL_WITHDRAW."`.`create` <= ('{$dateinicio}') 
	OR `".TBL_WITHDRAW."`.status = '0' 
		AND `".TBL_WITHDRAW."`.wallet_id = `".TBL_WALLET."`.id 
		AND `".TBL_WITHDRAW."`.`create` >= ('{$datefin}') order by `".TBL_WITHDRAW."`.`create` desc");
	
	if(isset($check->error) && $check->error == false && isset($check->data[0])){
		foreach($check->data As $item){
			$itemn = new stdClass();
			$itemn->wallet_id = (int) $item['wallet_id'];
			$itemn->wallet_coin = $item['wallet_coin'];
			$itemn->wallet_address = $item['wallet_address'];
			$itemn->withdraw_id = (int) $item['withdraw_id'];
			$itemn->withdraw_request = (float) $item['withdraw_request'];
			$itemn->withdraw_fee = (float) $item['withdraw_fee'];
			$itemn->withdraw_totalPaid = (float) $item['withdraw_totalPaid'];
			$itemn->withdraw_tx = $item['withdraw_tx'];
			$ret->total_pdtePayment++;
			
			$ret->total_pdtePayment_value = $ret->total_pdtePayment_value + $itemn->withdraw_request;
			$ret->pdtePayment[] = $itemn;
		}
	};
	
	$jsonFinal->error = false;
	$jsonFinal->data = $ret;
}

#FINAL
header('Content-Type: application/json');
echo json_encode($jsonFinal, JSON_PRETTY_PRINT);
return json_encode($jsonFinal, JSON_PRETTY_PRINT);