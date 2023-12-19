<?php
include_once './Repository/BDD.php';
include_once './Models/userModel.php';
include_once './exceptions.php';

class UserRepository {
    private $connection = null;

    // I'm not sure about this function lol (unuse)
    function __construct() {
        try {
            $this->connection = pg_connect("host=restpastropapi-database-1 port=5432 dbname=apiDev_db user=apiDev password=password");
            if (  $this->connection == null ) {
                throw new BDDException("Could not connect to database.");
            }
        } catch (Exception $e) {
            throw new BDDException("Could not connect db: ". $e->getMessage());
        }
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
            $user[$i] = new UserModel($usersArray[$i]['id_users'], $usersArray[$i]['role'], $usersArray[$i]['pseudo'], $usersArray[$i]['user_index'], $usersArray[$i]['apiKey']);
        }

        return $user;
    }

    //-------------------------------------

    public function getUser($id){

        $user = selectDB("USERS", "*", "id_users=".$id);

        return new UserModel($user[0]['id_users'], $user[0]['role'], $user[0]['pseudo'], $user[0]['user_index'], $user[0]['apiKey']);
    }

    //-------------------------------------

    public function getUserApi($api){

        $user = selectDB("USERS", "*", "apiKey=".$api);

        return new UserModel($user[0]['id_users'], $user[0]['role'], $user[0]['pseudo'], $user[0]['user_index'], $user[0]['apiKey']);
    }

    //-------------------------------------
    
    public function createUser(UserModel $user){
        $tmp = insertDB("USERS", ["role", "user_index", "pseudo", "apiKey"], [$user->role, 1, $user->pseudo, $user->apiKey] );// , "apiKey='".$user->apiKey."'");
        
        return selectDB('USERS', '*', 'user_index=1 ORDER BY id_users DESC LIMIT 1')[0];//$this->getUserApi($user->apiKey);
    }

    //-------------------------------------

    public function updateUser(UserModel $user){
        
        updateDB("USERS", ["role", "pseudo", "user_index"], [$user->role, $user->pseudo, $user->user_index], 'id_users='.$user->id_users);

        return $this->getUser($user->id_users);
    }

    //-------------------------------------

    public function unreferenceUser($id){
        return updateDB("USERS", ['user_index'], [-1], "id_users=".$id);
        //deleteDB("USERS", "id_users=".$id);
    }
    

}


?>