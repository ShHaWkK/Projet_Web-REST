<?php

include_once './Service/globalFunctions.php';

function checkData($table = -10, $columnArray = -10, $columData = -10, $condition = -10){
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
	if (empty($columData)){
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

function selectDB($table, $colums, $condition = -1){
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

	try{
		$result = $db->prepare($dbRequest);
		$result->execute();

		$reponse = $result->fetchAll();
		if ($reponse == false)
		{
			exit_with_message("ERROR : Impossible to select data");
		}
		return $reponse;
	}
	catch (PDOException $e)
	{
		if (checkMsg($e->getMessage(), $wordToSearch = "Undefined column"))
		{

			exit_with_message(explode("does not exist", explode(":", $e->getMessage())[3])[0] . "does not exist");
		}

	    exit_with_message("PDO error :" . $e->getMessage());
	}
	return true;
}

# -------------------------------------------------------------- #

function insertDB($table, $columnArray, $columData)
{
	// -10 no condition enter by the user
	// -1 : the user want no condition

	checkData($table, $columnArray, $columData, -10);

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
		if (checkMsg($e->getMessage(), $wordToSearch = "Undefined column"))
		{
			exit_with_message(explode("does not exist", explode(":", $e->getMessage())[3])[0] . "does not exist");
		}

	    exit_with_message("PDO error :" . $e->getMessage());
	}

	return true;
}

# -------------------------------------------------------------- #

function updateDB($table, $columnArray, $columData, $condition = null)
{
	// -10 no condition enter by the user
	// -1 : the user want no condition

	checkData($table, $columnArray, $columData, $condition);

	if (count($columnArray) != count($columData)){
		exit_with_message('ERROR : Colums and data must have the same length');
	}

	$db = connectDB();

	$updatedData = $columnArray[0] . "=" . $columData[0];
	for ($i=1; $i < count($columnArray) ; $i++) {
		$updatedData .= ", " . $columnArray[$i] . "=" . $columData[$i];
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

		return false;
	}
	catch (PDOException $e)
	{
		if (checkMsg($e->getMessage(), $wordToSearch = "Undefined column"))
		{
			exit_with_message(explode("does not exist", explode(":", $e->getMessage())[3])[0] . "does not exist");
		}

	    exit_with_message("PDO error :" . explode("DETAIL: ", $e->getMessage())[1]);
	}
	
	return true;
}

# -------------------------------------------------------------- #

function deleteDB($table, $condition)
{
	checkData($table, -10, -10, $condition);

	$db = connectDB();

	if($condition == -1){
		$dbRequest = 'DELETE FROM '. $table;
	}
	else{
		$dbRequest = 'DELETE FROM '. $table .' WHERE ' . $condition ;
	}

	try{
		$result = $db->prepare($dbRequest);
		$result->execute();

		return false;
	}
	catch (PDOException $e)
	{
		if (checkMsg($e->getMessage(), $wordToSearch = "Undefined column"))
		{
			exit_with_message(explode("does not exist", explode(":", $e->getMessage())[3])[0] . "does not exist");
		}

	    exit_with_message("PDO error :" . explode("DETAIL: ", $e->getMessage())[1]);
	}
	
	return true;
}



?>