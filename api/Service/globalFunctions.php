<?php
function checkError($msg){
	if (strpos(strtolower($msg), "error") !== false){
		return true;
	}

	return false;
}

# -------------------------------------------------------------- #




?>