<?php
include_once './Repository/BDD.php';
include_once './Models/userModel.php';
include_once './exceptions.php';

class UserRepository {
    private $connection = null;

    // I'm not sure about this function lol (unuse)
    function __construct() {
       
    }
    
    //-------------------------------------

    public function getUsers($index = 1){
        if($index == 1){
            $usersArray = selectDB("USERS", "*", "user_index=".$index);
        }
        else{
            // If admin request all the users
            $usersArray = selectDB("USERS", "*");
        }

        $user = [];
        $usersTest = [];

        for ($i=0; $i < count($usersArray); $i++) { 
            $user[$i] = new UserModel($usersArray[$i]['id_users'], $usersArray[$i]['role'], $usersArray[$i]['pseudo'], "hidden", $usersArray[$i]['user_index'], $usersArray[$i]['apikey']);
        }

        return $user;
    }

    //-------------------------------------

    public function getUser($id, $apiKey){

        $role = getRoleFromApiKey($apiKey);

        if($apiKey != null && $role > 2){
            $user = selectDB("USERS", "*", "id_users=".$id." AND apikey='".$apiKey."'", "bool");
        }
        elseif ($role < 3){
            $user = selectDB("USERS", "*", "id_users=".$id);
        }

        if ($user == false){
            exit_with_message("Error, you can't have any information for this user, it's not you :/");
        }

        if($role < 2){
            return new UserModel($user[0]['id_users'], $user[0]['role'], $user[0]['pseudo'], "hidden", $user[0]['user_index'], $user[0]['apikey']);    
        }
        return new UserModel($user[0]['id_users'], $user[0]['role'], $user[0]['pseudo'], "hidden", $user[0]['user_index'], "hidden");
    }

    //-------------------------------------

    public function getUserApi($api){

        $user = selectDB("USERS", "*", "apiKey=".$api);

        return new UserModel($user[0]['id_users'], $user[0]['role'], $user[0]['pseudo'], "hidden", $user[0]['user_index'], $user[0]['apikey']);
    }

    //-------------------------------------
    
    public function createUser(UserModel $user){
        $tmp = insertDB("USERS", ["role", "user_index", "pseudo", "mdp", "apikey"], [$user->role, 1, $user->pseudo, strtoupper(hash('sha256', $user->password)), $user->apiKey]);// , "apiKey='".$user->apiKey."'");

        $userTmp = selectDB("USERS", 'id_users, pseudo', "pseudo='".$user->pseudo."'");

        $string = $userTmp[0]['id_users'].$userTmp[0]['pseudo'];

        if(!updateDB("USERS", ["apikey"], [strtoupper(hash('sha256', $string))], "id_users='".$userTmp[0]['id_users']."'")){
            exit_with_message("Impossible to create your apiKey :/");
        }

        $user = selectDB('USERS', '*', 'id_users='.$userTmp[0]['id_users']);

        return new UserModel($user[0]['id_users'], $user[0]['role'], $user[0]['pseudo'], "hidden", $user[0]['user_index'], $user[0]['apikey']);//$this->getUserApi($user->apiKey);
    }

    //-------------------------------------

    public function updateUser(UserModel $user, $apiKey){
        
        $idUSer = selectDB("USERS", 'id_users', "apikey='".$apiKey."'")[0]["id_users"];
        if ($idUSer != $user->id_users){
            exit_with_message("You can't update an user which is not you");
        }

        updateDB("USERS", ["role", "pseudo", "user_index"], [$user->role, $user->pseudo, $user->user_index], 'id_users='.$user->id_users." AND apikey='".$apiKey."'");

        return $this->getUser($user->id_users, null);
    }

    //-------------------------------------

    public function unreferenceUser($id, $apiKey){

        $role = getRoleFromApiKey($apiKey);

        $apiToRole = selectDB("USERS", "id_users", "apikey='".$apiKey."'")[0]['id_users'];
        // var_dump($apiKey, $apiToRole);
        // exit();

        if ($id != $id_users && $role != 1){
            exit_with_message("You can't unrefence a user wich is not you");
        }

        return updateDB("USERS", ['user_index'], [-1], "id_users=".$id);
        //deleteDB("USERS", "id_users=".$id);
    }
    

}


?>