<?php 

include('autoload.php');


$jsonFinal = new stdClass();
$jsonFinal->error = true;
$jsonFinal->data = null;



if(isset($_GET['coin']) && isset($_GET['address'])){
	$wallet = infoWallet($_GET['coin'], $_GET['address']);
	

	if(isset($wallet['id']) && $wallet['id'] > 0){
		$jsonFinal->error = false;
		$jsonFinal->data = new WalletInfo($wallet);
	}
}
else if(isset($_GET['token'])){
	$token = decodeToken($_GET['token']);
	if(isset($token[2]) && isset($token[1])){
		$wallet = infoWallet($token[2], $token[1]);
		if(isset($wallet['id']) && $wallet['id'] > 0){
			$jsonFinal->error = false;
			$balance = balanceWallet($_GET['token']);
			$wallet['balance'] = $balance->value;
			
			$jsonFinal->data = new WalletInfo($wallet);
		}
	}
}


#FINAL
header('Content-Type: application/json');
echo json_encode($jsonFinal, JSON_PRETTY_PRINT);
return json_encode($jsonFinal, JSON_PRETTY_PRINT);