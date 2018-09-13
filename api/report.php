<?php 

include('autoload.php');


$jsonFinal = new stdClass();
$jsonFinal->error = true;
$jsonFinal->data = null;


if(
	isset($_GET['token'])
){
	$token = decodeToken($_GET['token']);
	$jobs = jobsWallet($_GET['token']);
	$founds = foundsWallet($_GET['token']);
	
	
	
	$dt = new DateTime();
	$today = $dt->format('Y-m-d H:i:s');
	
	$old = strtotime('-1 month', strtotime($today));
	$old = date('Y-m-d H:i:s', $old);
	
	$check = datosSQL("Select * from ".TBL_FOUND." where wallet_id='{$token[0]}' and `create` >= ('{$old}') OR wallet_id='1' AND `create` <= ('{$today}')");
	$founds = (array());
	if(isset($check->error) && $check->error == false && isset($check->data[0])){
		foreach($check->data As $item){
			$founds[] = new FoundInfo($item);
		}
	}
	
	$check = datosSQL("Select * from ".TBL_JOB." where wallet_id='{$token[0]}' and `create` >= ('{$old}') OR wallet_id='1' AND `create` <= ('{$today}')");
	$jobs = array();
	if(isset($check->error) && $check->error == false && isset($check->data[0])){
		foreach($check->data As $item){
			$jobs[] = new JobInfo($item);
		}
	}
	
	
	$final = new stdClass();
	$final->jobs = $jobs;
	$final->founds = $founds;
	$final->total_founds = count($founds);
	$final->total_jobs = count($jobs);
	$final->orphans = $final->total_jobs - $final->total_founds;
	$final->orphans_porc = ($final->orphans * 100) / $final->total_jobs;
	
	$jsonFinal->data = $final;
	#if(isset($jobs[0])){ $jsonFinal->data = $jobs; };
	
	
	$jsonFinal->error = false;
}

#FINAL
header('Content-Type: application/json');
echo json_encode($jsonFinal, JSON_PRETTY_PRINT);
return json_encode($jsonFinal, JSON_PRETTY_PRINT);