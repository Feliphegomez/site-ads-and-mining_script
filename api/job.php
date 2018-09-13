<?php 
include('autoload.php');

$jsonFinal = new stdClass();
$jsonFinal->error = true;
$jsonFinal->data = null;


# --------------------------- --------------------------- --------------------------- #
if(
	isset($_GET['token'])
	&& !isset($_GET['blob'])
){
	$jsonFinal->data = jobsWallet($_GET['token']);
	$jsonFinal->error = false;
}else if(
	isset($_GET['token'])
	&& isset($_GET['blob'])
	&& isset($_GET['job_id'])
	&& isset($_GET['target'])
	&& isset($_GET['throttle'])
){
	$token = decodeToken($_GET['token']);
	$create = crearSQL("INSERT INTO ".TBL_JOB." (wallet_id, job_id, target, throttle, `blob`) VALUES (?, ?, ?, ?, ?) ", array(
		$token[0], $_GET['job_id'], $_GET['target'], $_GET['throttle'], $_GET['blob']
	));
	
	if(isset($create->error) && $create->error == false){
		$jsonFinal->error = false;
		$jsonFinal->data = (int) $create->last_id;
	}
}







#FINAL
header('Content-Type: application/json');
echo json_encode($jsonFinal, JSON_PRETTY_PRINT);
return json_encode($jsonFinal, JSON_PRETTY_PRINT);