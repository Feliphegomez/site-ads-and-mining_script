<?php 

include('autoload.php');


$jsonFinal = new stdClass();
$jsonFinal->error = true;
$jsonFinal->data = null;


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