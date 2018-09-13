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



#################### ------------------------------------- ------------------------------------- ####################


























