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
	
}

#FINAL
header('Content-Type: application/json');
echo json_encode($jsonFinal, JSON_PRETTY_PRINT);
return json_encode($jsonFinal, JSON_PRETTY_PRINT);