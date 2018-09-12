<?php 
include('autoload.php');

$jsonFinal = new stdClass();
$jsonFinal->error = true;
$jsonFinal->data = null;

Class JobInfo{
	var $id = 0;
	var $wallet_id = 0;
	var $blob = '';
	var $job_id = '';
	var $target = '';
	var $throttle = 0;
	var $create = 0;
	
	function __construct($args) {
		if(isset($args['id'])){ $this->id = (int) $args['id']; }
		if(isset($args['wallet_id'])){ $this->wallet_id = (int) $args['wallet_id']; }
		if(isset($args['blob'])){ $this->blob = $args['blob']; }
		if(isset($args['job_id'])){ $this->job_id = $args['job_id']; }
		if(isset($args['target'])){ $this->target = $args['target']; }
		if(isset($args['throttle'])){ $this->throttle = $args['throttle']; }
		if(isset($args['create'])){ $this->create = $args['create']; }
	}
	
}

function jobsWallet($token){
	$token = decodeToken($token);
	
	$check = datosSQL("Select * from ".TBL_JOB." where wallet_id='{$token[0]}'");
	if(isset($check->error) && $check->error == false && isset($check->data[0])){
		$r = array();
		foreach($check->data As $item){
			$r[] = new JobInfo($item);
		}
		return $r;
	}else{
		return (array());
	}
}

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