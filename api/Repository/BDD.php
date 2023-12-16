<?php

include_once './Service/globalFunctions.php';

function connectDB(){
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


function selectDB($table, $colums){
	// $colums must be like that : $columns = "idusers, role"

	$db = connectDB();

	$dbRequest = 'SELECT '. $colums .' FROM '. $table;

	try{
		$result = $db->prepare($dbRequest);
		$result->execute();

		$reponse = $result->fetchAll();
		if ($reponse == false)
		{

			exit_with_message("ERROR : Impossible to select data");
			//header('location: Accueil.php?message=' . $msg);
			exit();
		}
		return $reponse;
	}
	catch (PDOException $e)
	{
		if (checkError($e->getMessage(), $wordToSearch = "Undefined column"))
		{
			exit_with_message(explode("does not exist", explode(":", $e->getMessage())[3])[0] . "does not exist");
			exit();
		}

	    exit_with_message("PDO error :" . $e->getMessage());
	}

}



//var_dump($_SESSION);




?>