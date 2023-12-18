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

    public function getUsers(){
        $usersArray = selectDB("USERS", "*");

        $user = [];
        $usersTest = [];

        for ($i=0; $i < count($usersArray); $i++) { 
            $user[$i] = new UserModel($usersArray[$i]['id_users'], $usersArray[$i]['role'], $usersArray[$i]['apiKey']);
        }

        return $user;
    }

    //-------------------------------------

    public function getUser($id){

        $user = selectDB("USERS", "*", "id_users=".$id);

        return new UserModel($user[0]['id_users'], $user[0]['role'], $user[0]['apiKey']);
    }

    //-------------------------------------
    
    public function createUser(UserModel $user){
        insertDB("USERS", ["role", "apiKey"], [$user->role, $user->apiKey]);

        return $this->getUser($user->id_users);
    }

    //-------------------------------------

    public function updateUser(UserModel $user){
        
        updateDB("USERS", ["role"], [$user->role], 'id_users='.$user->id_users);

        return $this->getUser($user->id_users);
    }

    //-------------------------------------

    public function deleteUser($id){
        deleteDB("USERS", "id_users=".$id);
    }
    

}


?>