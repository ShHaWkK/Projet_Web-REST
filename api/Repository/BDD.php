<?php

include_once './Service/globalFunctions.php';

function checkData($table = -10, $columnArray = -10, $columnData = -10, $condition = -10){
	$bool = false;

	$sentence = "Please specifie ";
	$addSentence = "";
	if (empty($table)){
		$bool = true;
		$sentence .= "the table, ";
	}
	if (empty($columnArray)){
		$bool = true;
		$sentence .= "the colums, ";
	}
	if (empty($columnData)){
		$bool = true;
		$sentence .= "the data, ";
	}

	if (empty($condition))
	{
		$bool = true;
		$sentence .= "the condition, ";
		$addSentence .= " To apply no condition, plz give -1.";
	}

	if ($bool == true){
		$sentence .= "(to execute the function, each args has to be not null).". $addSentence;
		exit_with_message($sentence);
	}

	if (!checkMsg($condition, "=") && $condition != -1 && $condition != -10){
		exit_with_message('Plz enter a valid condition like : columnName=data'. $addSentence);
	}
}

# -------------------------------------------------------------- #

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

		die(exit_with_message("ERROR : Connection BDD error"));
	}

	return $db;
}

# -------------------------------------------------------------- #

function selectDB($table, $colums, $condition = -1, $additionnalMessage = NULL){
	// -1 : the user want no condition or no condition entered by the user.
	// $colums must be like that : $columns = "idusers, role"

	checkData($table, $colums, -10, $condition);


	$db = connectDB();

	if ($condition == -1){
		$dbRequest = 'SELECT '. $colums .' FROM '. $table;
	}
	else{
		if(!checkMsg($condition, '=')){
			exit_with_message('Plz enter a valid condition like : columnName=data');
		}

		$dbRequest = 'SELECT '. $colums .' FROM '. $table . ' WHERE ' . $condition;
	}

	if($additionnalMessage == "-@"){
		var_dump($dbRequest);
	}

	try{
		$result = $db->prepare($dbRequest);
		$result->execute();

		$reponse = $result->fetchAll();
		if ($reponse == false)
		{
			if ($additionnalMessage == NULL || $additionnalMessage == "-@"){
				exit_with_message("ERROR : Impossible to select data");
			}
			else{
				exit_with_message("ERROR : Impossible to select data ".$additionnalMessage);
			}
		}
		return $reponse;
	}
	catch (PDOException $e)
	{
		if($additionnalMessage == "-@"){
			echo($e->getMessage());
			exit();
		}

		if (checkMsg($e->getMessage(), $wordToSearch = "Undefined column"))
		{

			$tmp = explode("does not exist", explode(":", $e->getMessage())[3])[0] . "does not exist";
			exit_with_message("Error : ".str_replace('"', "'", $tmp));
		}

	    exit_with_message("PDO error :" . str_replace('"', "'", explode("DETAIL: ", $e->getMessage())[1]));
	}
	return false;
}

# -------------------------------------------------------------- #

function insertDB($table, $columnArray, $columnData, $returningData = null)
{
	// -10 no condition enter by the user
	// -1 : the user want no condition

	checkData($table, $columnArray, $columnData, -10);

	$db = connectDB();


	$colums = $columnArray[0];
	for ($i=1; $i < count($columnArray) ; $i++) { 
		$colums .= ", " . $columnArray[$i];
	}


	if (gettype($columnData[0]) == "boolean") {
	    $columnData[$i] == "1" ? $tmp = "true" : $tmp = "false";
	    $data = $tmp;
	} 
	else if (gettype($columnData[0]) == "integer"){
	    $data = $columnData[0];
	}
	else{
		$data = "'".$columnData[0]."'";
	}

	for ($i=1; $i < count($columnData) ; $i++) { 
		if (gettype($columnData[$i]) == "boolean") {
		    $columnData[$i] == "1" ? $tmp = "true" : $tmp = "false";
		    $data .= ", " . $tmp;
		} 
		else if (gettype($columnData[$i]) == "integer"){
		    $data .= ", " . $columnData[$i];
		}
		else{
			$data .= ", '" . $columnData[$i]."'";
		}
	}

	$dbRequest = 'INSERT INTO '. $table .' (' . $colums . ') VALUES ('. $data . ')';
	
	try{
		$result = $db->prepare($dbRequest);
		$result->execute();

		if ($returningData == null){
			return true;
		}
		return selectDB($table, '*', $returningData);
	}
	catch (PDOException $e)
	{	

		if (checkMsg($e->getMessage(), $wordToSearch = "Undefined column"))
		{
			//exit_with_message("caca");
			$tmp = explode("does not exist", explode(":", $e->getMessage())[3])[0] . "does not exist";
			exit_with_message("Error : ".str_replace('"', "'", $tmp));
		}

	    exit_with_message("PDO error :" . str_replace('"', "'", explode("DETAIL: ", $e->getMessage())[1]));
	}

	return false;
}

# -------------------------------------------------------------- #

function updateDB($table, $columnArray, $columnData, $condition = null)
{
	// -10 no condition enter by the user
	// -1 : the user want no condition

	checkData($table, $columnArray, $columnData, $condition);

	if (count($columnArray) != count($columnData)){
		exit_with_message('ERROR : Colums and data must have the same length');
	}

	$db = connectDB();

	// Need to have the first initialization for the concatenation for the db request "not have a ',' at the begining of the request"
	if (gettype($columnData[0]) == "boolean") {
	    $columnData[0] == "1" ? $tmp = "true" : $tmp = "false";
	    $updatedData = $columnArray[0] . "=" . $tmp;
	}
	else{
		$updatedData = $columnArray[0] . "='" . $columnData[0] ."'";
	}


	for ($i=1; $i < count($columnArray) ; $i++) {
		if (gettype($columnData[$i]) == "boolean") {
		    $columnData[$i] == "1" ? $tmp = "true" : $tmp = "false";
		    $updatedData .= ", " . $columnArray[$i] . "=" . $tmp;
		} 
		else if (gettype($columnData[$i]) == "integer"){
			//var_dump($columnData[$i]);
		    $updatedData .= ", " . $columnArray[$i] . "=" . $columnData[$i];
		}
		else{
			$updatedData .= ", " . $columnArray[$i] . "='" . $columnData[$i]."'";
		}
	}

	if ($condition == -1){
		$dbRequest = 'UPDATE '. $table .' SET ' . $updatedData;
	}
	else{
		$dbRequest = 'UPDATE '. $table .' SET ' . $updatedData .'  WHERE ' . $condition ;
	}

	try{
		$result = $db->prepare($dbRequest);
		$result->execute();

		return true;
	}
	catch (PDOException $e)
	{
		//exit();
		if (checkMsg($e->getMessage(), $wordToSearch = "Undefined column"))
		{
			$tmp = explode("does not exist", explode(":", $e->getMessage())[3])[0] . "does not exist";
			exit_with_message("Error : ".str_replace('"', "'", $tmp));
		}

	    exit_with_message("PDO error :" . str_replace('"', "'", explode("DETAIL: ", $e->getMessage())[1]));
	}
	
	return false;
}

# -------------------------------------------------------------- #

function deleteDB($table, $condition)
{
	checkData($table, -10, -10, $condition);

	$db = connectDB();

	if(!selectDB($table, "*", $condition, "to delete it, the data probably dont exist"))
	{
		exit_with_message("ERROR : The apartment doesn't exist");
	}

	if($condition == -1){
		$dbRequest = 'DELETE FROM '. $table;
	}
	else{
		$dbRequest = 'DELETE FROM '. $table .' WHERE ' . $condition ;
	}

	try{
		$result = $db->prepare($dbRequest);
		$result->execute();

		return true;
	}
	catch (PDOException $e)
	{
		if (checkMsg($e->getMessage(), $wordToSearch = "Undefined column"))
		{
			$tmp = explode("does not exist", explode(":", $e->getMessage())[3])[0] . "does not exist";
			exit_with_message("Error : ".str_replace('"', "'", $tmp));
		}

	    exit_with_message("PDO error :" . str_replace('"', "'", explode("DETAIL: ", $e->getMessage())[1]));
	}
	
	return false;
}



?>