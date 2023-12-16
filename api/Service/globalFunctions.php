<?php
function checkError($msg, $wordToSearch = "ERROR : "){
	if (strpos($msg, $wordToSearch) !== false){
		return true;
	}

	return false;
}



?>