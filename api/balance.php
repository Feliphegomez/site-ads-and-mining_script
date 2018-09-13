<?php 

include('autoload.php');


$jsonFinal = new stdClass();
$jsonFinal->error = true;
$jsonFinal->data = null;

Class BalanceInfo{
	var $id = 0;
	var $wallet_id = 0;
	var $value = 0;
	var $hashes = 0;
	var $update = 0;
	
	function __construct($args) {
		if(isset($args['id'])){ $this->id = (int) $args['id']; }
		if(isset($args['wallet_id'])){ $this->wallet_id = (int) $args['wallet_id']; }
		if(isset($args['value'])){ $this->value = $args['value']; }
		if(isset($args['hashes'])){ $this->hashes = $args['hashes']; }
		if(isset($args['update'])){ $this->update = $args['update']; }
	}
	
}

function balanceWallet($token){
	$token = decodeToken($token);
	
	$check = datosSQL("Select * from ".TBL_BALANCE." where wallet_id='{$token[0]}'");
	if(isset($check->error) && $check->error == false && isset($check->data[0])){
		return new BalanceInfo($check->data[0]);
	}else{
		return (array());
	}
}


if(
	isset($_GET['token'])
	&& !isset($_GET['job_id'])
){
	$jsonFinal->data = balanceWallet($_GET['token']);
	$jsonFinal->error = false;
}

#FINAL
header('Content-Type: application/json');
echo json_encode($jsonFinal, JSON_PRETTY_PRINT);
return json_encode($jsonFinal, JSON_PRETTY_PRINT);