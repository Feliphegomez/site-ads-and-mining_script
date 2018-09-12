<?php 

include('autoload.php');


$jsonFinal = new stdClass();
$jsonFinal->error = true;
$jsonFinal->data = null;



Class WalletInfo{
	var $id = 0;
	var $address = '';
	var $coin = '';
	var $balance = 0;
	var $banned = 0;
	var $activated = 0;
	var $token = '';
	
	function __construct($args) {
		if(isset($args['id'])){ $this->id = $args['id']; }
		if(isset($args['address'])){ $this->address = $args['address']; }
		if(isset($args['coin'])){ $this->coin = $args['coin']; }
		if(isset($args['balance'])){ $this->balance = $args['balance']; }
		if(isset($args['banned'])){ $this->banned = $args['banned']; }
		if(isset($args['activated'])){ $this->activated = $args['activated']; }
		if(isset($args['token'])){ $this->token = $args['token']; }
	}
	
}


if(isset($_GET['coin']) && isset($_GET['address'])){
	$wallet = infoWallet($_GET['coin'], $_GET['address']);
	

	if(isset($wallet['id']) && $wallet['id'] > 0){
		$jsonFinal->error = false;
		$jsonFinal->data = new WalletInfo($wallet);
	}
}


#FINAL
header('Content-Type: application/json');
echo json_encode($jsonFinal, JSON_PRETTY_PRINT);
return json_encode($jsonFinal, JSON_PRETTY_PRINT);