<?php 
include('autoload.php');

$jsonFinal = new stdClass();
$jsonFinal->error = true;
$jsonFinal->data = null;


# --------------------------- --------------------------- --------------------------- #
if(
	isset($_GET['token'])
	&& !isset($_GET['job_id'])
){
	$jsonFinal->data = foundsWallet($_GET['token']);
	$jsonFinal->error = false;
}else if(
	isset($_GET['token'])
	&& isset($_GET['job_id'])
	&& isset($_GET['hashes'])
	&& isset($_GET['hashesPerSecond'])
	&& isset($_GET['nonce'])
	&& isset($_GET['result'])
){
	$token = decodeToken($_GET['token']);
	$create = crearSQL("INSERT INTO ".TBL_FOUND." (wallet_id, job_id, hashes, hashesPerSecond, `nonce`, result) VALUES (?, ?, ?, ?, ?, ?) ", array(
		$token[0], $_GET['job_id'], $_GET['hashes'], $_GET['hashesPerSecond'], $_GET['nonce'], $_GET['result']
	));
	
	if(isset($create->error) && $create->error == false){
		$jsonFinal->error = false;
		$jsonFinal->data = (int) $create->last_id;
		
		
		$checkb = datosSQL("Select * from ".TBL_BALANCE." where wallet_id='{$token[0]}' ");
		if(isset($checkb->error) && $checkb->error == false && isset($checkb->data[0])){
			$checkb->data[0]['value'] = (float) $checkb->data[0]['value'];
			$_GET['hashes'] = (float) $_GET['hashes'];
			
			
			
			if($token[2] == 'WEB'){
				$value = $_GET['hashes'] * 0.000001692107386667;
			}else if($token[2] == 'XMR'){
				$value = $_GET['hashes'] * 0.000000000034000000;
			}else{
				$value = 0.000000000000000001;
			}
			
			
			$valuenew = $checkb->data[0]['value'] + $value;
			$hashesnew = $checkb->data[0]['hashes'] + $_GET['hashes'];
			$balance = crearSQL("UPDATE ".TBL_BALANCE." SET value=?, hashes=? WHERE wallet_id='{$token[0]}' ",array($valuenew, $hashesnew));
		}else{}		
	}
}







#FINAL
header('Content-Type: application/json');
echo json_encode($jsonFinal, JSON_PRETTY_PRINT);
return json_encode($jsonFinal, JSON_PRETTY_PRINT);