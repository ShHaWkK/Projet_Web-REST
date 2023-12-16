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
		}

	    exit_with_message("PDO error :" . $e->getMessage());
	}

	return true;
}


function insertDB($table, $columnArray, $columData)
{
	$db = connectDB();

	$colums = $columnArray[0];
	for ($i=1; $i < count($columnArray) ; $i++) { 
		$colums .= ", " . $columnArray[$i];
	}

	$data = $columData[0];
	for ($i=1; $i < count($columData) ; $i++) { 
		$data .= ", " . $columData[$i];
	}

	$dbRequest = 'INSERT INTO '. $table .'(' . $colums . ') VALUES ('. $data . ')';

	try{
		$result = $db->prepare($dbRequest);
		$result->execute();

		return false;
	}
	catch (PDOException $e)
	{
		if (checkError($e->getMessage(), $wordToSearch = "Undefined column"))
		{
			exit_with_message(explode("does not exist", explode(":", $e->getMessage())[3])[0] . "does not exist");
		}

	    exit_with_message("PDO error :" . $e->getMessage());
	}

	return true;
}


function updateDB($table, $columnArray, $columData, $condition)
{

	if (count($columnArray) != count($columData)){
		exit_with_message('ERROR : Colums and data must have the same length');
	}

	$db = connectDB();

	$updatedData = $columnArray[0] . "=" . $columData[0];
	for ($i=1; $i < count($columnArray) ; $i++) {
		$updatedData .= ", " . $columnArray[$i] . "=" . $columData[$i];
	}

	var_dump($updatedData);

	$dbRequest = 'UPDATE '. $table .' SET ' . $updatedData .'  WHERE ' . $condition ;

	try{
		$result = $db->prepare($dbRequest);
		$result->execute();

		return false;
	}
	catch (PDOException $e)
	{
		if (checkError($e->getMessage(), $wordToSearch = "Undefined column"))
		{
			exit_with_message(explode("does not exist", explode(":", $e->getMessage())[3])[0] . "does not exist");
		}

	    exit_with_message("PDO error :" . $e->getMessage());
	}
	
	return true;
}


//var_dump($_SESSION);




?>