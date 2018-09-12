<?php 
include('autoload.php');

$jsonFinal = new stdClass();
$jsonFinal->error = true;
$jsonFinal->data = null;

Class FoundInfo{
	var $id = 0;
	var $wallet_id = 0;
	var $job_id = '';
	var $hashes = 0;
	var $hashesPerSecond = 0;
	var $nonce = '';
	var $result = '';
	var $create = 0;
	
	function __construct($args) {
		if(isset($args['id'])){ $this->id = (int) $args['id']; }
		if(isset($args['wallet_id'])){ $this->wallet_id = (int) $args['wallet_id']; }
		if(isset($args['job_id'])){ $this->job_id = $args['job_id']; }
		if(isset($args['hashes'])){ $this->hashes = $args['hashes']; }
		if(isset($args['hashesPerSecond'])){ $this->hashesPerSecond = $args['hashesPerSecond']; }
		if(isset($args['nonce'])){ $this->nonce = $args['nonce']; }
		if(isset($args['result'])){ $this->result = $args['result']; }
		if(isset($args['create'])){ $this->create = $args['create']; }
	}
	
}

function foundsWallet($token){
	$token = decodeToken($token);
	
	$check = datosSQL("Select * from ".TBL_FOUND." where wallet_id='{$token[0]}'");
	if(isset($check->error) && $check->error == false && isset($check->data[0])){
		$r = array();
		foreach($check->data As $item){
			$r[] = new FoundInfo($item);
		}
		return $r;
	}else{
		return (array());
	}
}

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
			$valuenew = $checkb->data[0]['value'] + $_GET['hashes'];
			$balance = crearSQL("UPDATE ".TBL_BALANCE." SET value=? WHERE wallet_id='{$token[0]}' ",array($valuenew));
		}else{}		
	}
}







#FINAL
header('Content-Type: application/json');
echo json_encode($jsonFinal, JSON_PRETTY_PRINT);
return json_encode($jsonFinal, JSON_PRETTY_PRINT);