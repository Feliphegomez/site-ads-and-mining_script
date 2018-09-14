<?php

include('models/global.php');

define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "site_ads_and_mining_script");

error_reporting(-1);
ini_set('display_errors', 'on');
setlocale(LC_TIME,"es_CO"); // Configurar Hora para Colombia
setlocale(LC_TIME, 'es_CO.UTF-8'); // Configurar Hora para Colombia en UTF-8
date_default_timezone_set('America/Bogota'); // Configurar Zona Horaria



define('site_name', 'deMedallo.com - El mejor contenido al alcance de un clic!'); // Titulo X defecto de la aplicacion
define('site_name_md', 'deMedallo.com'); // Titulo X defecto small

define('folderSitio', '/site-ads-and-mining_script'); // Ruta de la carpeta del Sitio
define('folderAPI', '/site-ads-and-mining_script//api'); // Ruta de la carpeta de la API


define("SERVER_NAME", $_SERVER['SERVER_NAME']); // Definir nombre del servidor
define("SERVER_HOST", $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME']); // Definir nombre del servidor con host -> ORGANIZAR -> $_SERVER['REQUEST_SCHEME'].
define('url_api', SERVER_HOST.folderAPI); // Definir url de la API
define('url_site', SERVER_HOST.folderSitio); // Definir url del aplicativo/sitio
define('site_author_name', 'FelipheGomez'); // Nombre del desarrollador del Sitio
define('site_author_url', 'wWw.FelipheGomez.Info'); // URL del creador del Sitio
session_set_cookie_params(0, url_site);
session_start(['cookie_lifetime' => 86400,'read_and_close'  => false,]); // 86400 -> 1 Dia /// Tiempo de expiracion de la sesion en el servidor // Lectura y Cierre de la sessio e servidor 
header('Access-Control-Allow-Origin: *'); // Control de acceso Permitir origen de:


############### ---- DEFINIR TABLAS ---- ###############
define('TBL_WALLET', 'wallet'); // tabla de 
define('TBL_JOB', 'job'); // tabla de 
define('TBL_FOUND', 'found'); // tabla de 
define('TBL_BALANCE', 'balance'); // tabla de 
define('TBL_WITHDRAW', 'withdraw'); // tabla de 
define('TBL_ADMIN', 'admins'); // tabla de 






/* --------------- FUNCIONES ------------- */

## Consulta SQL SELECT
function datosSQL($sql){
	$rawdata = new stdClass();
	$rawdata->error = true;
	$rawdata->data = array();
	$rawdata->sql = $sql;
	try {
		$conn = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare($sql); 
		$stmt->execute();
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		
		$result = $stmt->fetchAll();
		$rawdata->error = false;
		if(count($result)>0){
			$rawdata->data = $result;
		}else{
			$rawdata->data = array();
		}
	}
	catch(PDOException $e) { $rawdata->data = "Error: " . $e->getMessage(); }
	$conn = null;	
	return $rawdata;
};

## Consulta SQL INSERT // EJEMPLO -> "INSERT INTO ".TBL_IMAGENES_GLOBAL." ( data ) VALUES (?)"
## Consulta SQL UPDATE // EJEMPLO -> $change = crearSQL("UPDATE ".TBL_CALENDARIO." SET trash=? WHERE id='{$data['id']}' ",array(1))
function crearSQL($comando,$array){
	$rawdata = new stdClass();
	$rawdata->error = true;
	$rawdata->last_id = 0;
	$rawdata->sql = $comando;
	try {
		$conn = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$sentencia = $conn->prepare($comando);
		$insert = $sentencia->execute($array);
		$last_id = $conn->lastInsertId();
		if($insert==true){
			$rawdata->error = false;
			$rawdata->last_id = $last_id;
		}else{
			$rawdata->error_message = "Intenta nuevamente";
		}
	}
	catch(PDOException $e)
	{
		$rawdata->error_message = $e->getMessage();
	}
	$conn = null;
	return $rawdata;
};

## Consulta SQL DELETE
function eliminarSQL($sql){
	$rawdata = new stdClass();
	$rawdata->error = true;
	$rawdata->sql = $sql;
	try {
		$conn = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn->exec($sql);
		$rawdata->error = false;
	}
	catch(PDOException $e)
	{
		$rawdata->error_message = $sql . "<br>" . $e->getMessage();
	}
	$conn = null;
	return $rawdata;
};

#################### ------------------------------------- ------------------------------------- ####################

function createToken($id, $address, $coin){
	return base64_encode($id.':'.$address.':'.$coin);
}

function decodeToken($token){
	return explode(':', base64_decode($token));
}
	
function walletForId($idWallet){
	$wallet = new stdClass();
	$wallet->address = "";
	$wallet->coin = "";
	
	$check = datosSQL("Select * from ".TBL_WALLET." where id='{$idWallet}' ");
	if(isset($check->error) && $check->error == false && isset($check->data[0])){
		if($check->data[0]['address'] == ''){ $check->data[0]['address'] = 'Donation'; }
		$wallet->address = $check->data[0]['address'];
		$wallet->coin = $check->data[0]['coin'];
	}
	return $wallet;
}

function infoWallet($coin, $wallet){
	$check = datosSQL("Select * from ".TBL_WALLET." where address='{$wallet}' and coin='{$coin}'");
	
	if(isset($check->error) && $check->error == false && isset($check->data[0])){
		$check->data[0]['token'] = createToken($check->data[0]['id'], $check->data[0]['address'], $check->data[0]['coin']);
		
		
		$checkb = datosSQL("Select * from ".TBL_BALANCE." where wallet_id='{$check->data[0]['id']}' ");
		if(isset($checkb->error) && $checkb->error == false && isset($checkb->data[0])){}else{ $checkb = crearSQL("INSERT INTO ".TBL_BALANCE." (wallet_id) VALUES (?) ", array($check->data[0]['id'])); }
		
		return ($check->data[0]);
	}else{
		$checkb = crearSQL("INSERT INTO ".TBL_WALLET." (address, coin) VALUES (?,?) ", array(
			$wallet
			, $coin
		));
		if(isset($checkb->error) && $checkb->error == false && isset($checkb->data[0])){
			return infoWallet($coin, $wallet);
		}
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

function AdminEstadisticasDate($dateinicio, $datefin){	
	$ret = new stdClass();
	$ret->jobs = array();
	$ret->founds = array();
	$ret->orphan = 0;
	$ret->users = 0;
	$ret->total_hashes = 0;
	$ret->payment = 0;
	$ret->payment_pdte = 0;
	$ret->payment_pdte_value = 0;
	$ret->payment_value = 0;
	
	$check = datosSQL("Select * from ".TBL_FOUND." where `create` >= ('{$datefin}') OR wallet_id='1' AND `create` <= ('{$dateinicio}')");
	if(isset($check->error) && $check->error == false && isset($check->data[0])){
		foreach($check->data As $item){
			$ret->founds[] = new FoundInfo($item);
			$ret->total_hashes = $ret->total_hashes + (float) $item['hashes'];
		}
	}
	
	$check = datosSQL("Select * from ".TBL_JOB." where `create` >= ('{$datefin}') OR wallet_id='1' AND `create` <= ('{$dateinicio}')");
	if(isset($check->error) && $check->error == false && isset($check->data[0])){
		foreach($check->data As $item){ $ret->jobs[] = new JobInfo($item); }
	}
	$ret->orphan = 100 - ((count($ret->founds) * 100) / count($ret->jobs));
		
	$check = datosSQL("Select * from ".TBL_BALANCE." where `update` >= ('{$datefin}') OR `update` <= ('{$dateinicio}') group by wallet_id");
	if(isset($check->error) && $check->error == false && isset($check->data[0])){ $ret->users = count($check->data); }
	
	$check = datosSQL("Select * from ".TBL_WITHDRAW." where `status` = ('1')");
	if(isset($check->error) && $check->error == false && isset($check->data[0])){
		$ret->payment = count($check->data);
		foreach($check->data As $item){
			$item['request'] = (float) $item['request'];
			
			$ret->payment_value = $ret->payment_value + $item['request'];
		}
	}
	
	$check = datosSQL("Select * from ".TBL_WITHDRAW." where `status` = ('0')");
	if(isset($check->error) && $check->error == false && isset($check->data[0])){
		$ret->payment_pdte = count($check->data);
		foreach($check->data As $item){
			$item['request'] = (float) $item['request'];
			
			$ret->payment_pdte_value = $ret->payment_pdte_value + $item['request'];
		}
	}
	return $ret;
}

function EstadisticasMesCoin($coin){
	$dt = new DateTime();
	$dateinicio = $dt->format('Y-m-d H:i:s');
	$datefin = date('Y-m-d H:i:s', strtotime('-1 month', strtotime($dateinicio)));

	$ret = new stdClass();
	$ret->jobs = array();
	$ret->total_jobs = 0;
	$ret->founds = array();
	$ret->total_found_hashes = 0;
	$ret->total_founds = 0;
	$ret->payment = array();
	$ret->total_payment = 0;
	$ret->total_payment_value = 0;
	$ret->pdtePayment = array();
	$ret->total_pdtePayment = 0;
	$ret->total_pdtePayment_value = 0;
	$ret->users = 0;
	$ret->orphan = 0;
	
	$check = datosSQL("Select COUNT(`".TBL_WALLET."`.`id`) As `total_users` from `".TBL_WALLET."` where `".TBL_WALLET."`.`coin` = '{$coin}'");
	
	if(isset($check->error) && $check->error == false && isset($check->data[0])){
		$ret->users = (int) $check->data[0]['total_users'];
	};
	
	$check = datosSQL("Select (`".TBL_WALLET."`.`id`) As wallet_id
		, `".TBL_WALLET."`.`coin` As `wallet_coin`
		, `".TBL_WALLET."`.`address` As `wallet_address`
		, (`".TBL_FOUND."`.id) as found_id
		, (`".TBL_FOUND."`.hashes) as found_hashes
		, (`".TBL_FOUND."`.hashesPerSecond) as found_hashesPerSecond
	from `".TBL_FOUND."`
	INNER JOIN `".TBL_WALLET."` ON 
		`".TBL_WALLET."`.coin='{$coin}' AND `".TBL_FOUND."`.wallet_id = `".TBL_WALLET."`.id AND `".TBL_FOUND."`.`create` <= ('{$dateinicio}')
		OR `".TBL_WALLET."`.coin='{$coin}' AND `".TBL_FOUND."`.wallet_id = `".TBL_WALLET."`.id AND `".TBL_FOUND."`.`create` >= ('{$datefin}')
	");
	
	if(isset($check->error) && $check->error == false && isset($check->data[0])){
		foreach($check->data As $item){
			$itemn = new stdClass();
			$itemn->wallet_id = (int) $item['wallet_id'];
			$itemn->wallet_coin = $item['wallet_coin'];
			$itemn->wallet_address = $item['wallet_address'];
			$itemn->found_id = (int) $item['found_id'];
			$itemn->found_hashes = (float) $item['found_hashes'];
			$itemn->found_hashesPerSecond = (float) $item['found_hashesPerSecond'];
			
			$ret->total_found_hashes = $ret->total_found_hashes + $itemn->found_hashes;
			$ret->total_founds++;
			$ret->founds[] = $itemn;
		}
	};
	
	$check = datosSQL("Select (`".TBL_WALLET."`.`id`) As wallet_id
		, `".TBL_WALLET."`.`coin` As `wallet_coin`
		, `".TBL_WALLET."`.`address` As `wallet_address`
		, (`".TBL_JOB."`.id) as job_id
		, (`".TBL_JOB."`.throttle) as job_throttle
	from `".TBL_JOB."`
	INNER JOIN `".TBL_WALLET."` ON 
		`".TBL_WALLET."`.coin='{$coin}' AND `".TBL_JOB."`.wallet_id = `".TBL_WALLET."`.id AND `".TBL_JOB."`.`create` <= ('{$dateinicio}')
		OR `".TBL_WALLET."`.coin='{$coin}' AND `".TBL_JOB."`.wallet_id = `".TBL_WALLET."`.id AND `".TBL_JOB."`.`create` >= ('{$datefin}')
	");
	
	if(isset($check->error) && $check->error == false && isset($check->data[0])){
		foreach($check->data As $item){
			$itemn = new stdClass();
			$itemn->wallet_id = (int) $item['wallet_id'];
			$itemn->wallet_coin = $item['wallet_coin'];
			$itemn->wallet_address = $item['wallet_address'];
			$itemn->job_id = $item['job_id'];
			$itemn->job_throttle = (float) $item['job_throttle'];
			$ret->total_jobs++;
			$ret->jobs[] = $itemn;
		}
	};
	
	if($ret->total_founds > 0 && $ret->total_jobs > 0){
		$ret->orphan = 100 - (($ret->total_founds * 100) / $ret->total_jobs);
	}
	
	$check = datosSQL("Select (`".TBL_WALLET."`.`id`) As wallet_id 
		, `".TBL_WALLET."`.`coin` As `wallet_coin` 
		, `".TBL_WALLET."`.`address` As `wallet_address`
		, (`".TBL_WITHDRAW."`.id) as withdraw_id 
		, (`".TBL_WITHDRAW."`.request) as withdraw_request
		, (`".TBL_WITHDRAW."`.fee) as withdraw_fee
		, (`".TBL_WITHDRAW."`.totalPaid) as withdraw_totalPaid
		, (`".TBL_WITHDRAW."`.tx) as withdraw_tx
	from `".TBL_WITHDRAW."` 
	INNER JOIN `".TBL_WALLET."` ON 
		`".TBL_WALLET."`.coin='{$coin}' 
		AND `".TBL_WITHDRAW."`.status = '1' 
		AND `".TBL_WITHDRAW."`.wallet_id = `".TBL_WALLET."`.id 
		AND `".TBL_WITHDRAW."`.`create` <= ('{$dateinicio}') 
	OR `".TBL_WALLET."`.coin='{$coin}' 
		AND `".TBL_WITHDRAW."`.status = '1' 
		AND `".TBL_WITHDRAW."`.wallet_id = `".TBL_WALLET."`.id 
		AND `".TBL_WITHDRAW."`.`create` >= ('{$datefin}')");
	
	if(isset($check->error) && $check->error == false && isset($check->data[0])){
		foreach($check->data As $item){
			$itemn = new stdClass();
			$itemn->wallet_id = (int) $item['wallet_id'];
			$itemn->wallet_coin = $item['wallet_coin'];
			$itemn->wallet_address = $item['wallet_address'];
			$itemn->withdraw_id = (int) $item['withdraw_id'];
			$itemn->withdraw_request = (float) $item['withdraw_request'];
			$itemn->withdraw_fee = (float) $item['withdraw_fee'];
			$itemn->withdraw_totalPaid = (float) $item['withdraw_totalPaid'];
			$itemn->withdraw_tx = $item['withdraw_tx'];
			$ret->total_payment++;
			
			$ret->total_payment_value = $ret->total_payment_value + $itemn->withdraw_request;
			$ret->payment[] = $itemn;
		}
	};
	
	$check = datosSQL("Select (`".TBL_WALLET."`.`id`) As wallet_id 
		, `".TBL_WALLET."`.`coin` As `wallet_coin` 
		, `".TBL_WALLET."`.`address` As `wallet_address`
		, (`".TBL_WITHDRAW."`.id) as withdraw_id 
		, (`".TBL_WITHDRAW."`.request) as withdraw_request
		, (`".TBL_WITHDRAW."`.fee) as withdraw_fee
		, (`".TBL_WITHDRAW."`.totalPaid) as withdraw_totalPaid
		, (`".TBL_WITHDRAW."`.tx) as withdraw_tx
	from `".TBL_WITHDRAW."` 
	INNER JOIN `".TBL_WALLET."` ON 
		`".TBL_WALLET."`.coin='{$coin}' 
		AND `".TBL_WITHDRAW."`.status = '0' 
		AND `".TBL_WITHDRAW."`.wallet_id = `".TBL_WALLET."`.id 
		AND `".TBL_WITHDRAW."`.`create` <= ('{$dateinicio}') 
	OR `".TBL_WALLET."`.coin='{$coin}' 
		AND `".TBL_WITHDRAW."`.status = '0' 
		AND `".TBL_WITHDRAW."`.wallet_id = `".TBL_WALLET."`.id 
		AND `".TBL_WITHDRAW."`.`create` >= ('{$datefin}')");
	
	if(isset($check->error) && $check->error == false && isset($check->data[0])){
		foreach($check->data As $item){
			$itemn = new stdClass();
			$itemn->wallet_id = (int) $item['wallet_id'];
			$itemn->wallet_coin = $item['wallet_coin'];
			$itemn->wallet_address = $item['wallet_address'];
			$itemn->withdraw_id = (int) $item['withdraw_id'];
			$itemn->withdraw_request = (float) $item['withdraw_request'];
			$itemn->withdraw_fee = (float) $item['withdraw_fee'];
			$itemn->withdraw_totalPaid = (float) $item['withdraw_totalPaid'];
			$itemn->withdraw_tx = $item['withdraw_tx'];
			$ret->total_pdtePayment++;
			
			$ret->total_pdtePayment_value = $ret->total_pdtePayment_value + $itemn->withdraw_request;
			$ret->pdtePayment[] = $itemn;
		}
	};
	return $ret;
}
#################### ------------------------------------- ------------------------------------- ####################


























