<?php

include_once './Service/globalFunctions.php';

function connectBDD(){
	try {
	    $db = new PDO(
	        'pgsql:host=restpastropapi-database-1;
	        port=5432;
	        dbname=apiDev_db;
	        user=apiDev;
	        password=password',
	        null,
	        null,
	        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
	    );
	} catch (Exception $e) {

		die(exit_with_message("Connection BDD error"));
	    //die("{'Erreur PDO' :" . "'" . $e->getMessage() . "'}");
	}

	return $db;
}





//var_dump($_SESSION);




?>