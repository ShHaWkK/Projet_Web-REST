<?php
include_once './Repository/BDD.php';
include_once './Models/userModel.php';
include_once './exceptions.php';

class LoginRepository {
    private $connection = null;

    // I'm not sure about this function lol (unuse)
    function __construct() {
    }

    //-------------------------------------

    public function getPersonnalApiKey($username, $password){
		$hashedString = hash('sha256', $password);
        $user = selectDB("USERS", "*", "pseudo='".$username."' AND (mdp='".strtoupper($hashedString)."' OR mdp='". strtolower($hashedString) ."')", "bool");
        if(!$user){
        	exit_with_message("Wrong username or password");
        }

        return new UserModel($user[0]['id_users'], $user[0]['role'], $user[0]['pseudo'], "hidden", $user[0]['user_index'], $user[0]['apikey']);
    }   

}


?>