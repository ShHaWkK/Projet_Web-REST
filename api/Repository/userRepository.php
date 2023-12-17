<?php
include_once './BDD.php';
include_once '../Models/userModel.php';
include_once '../exception.php';

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

        for ($i=0; $i < count($usersTest); $i++) { 
            $apartTest[$i] = new UserModel($usersTest[$i]['id_users'], $usersTest[$i]['role'], $usersTest[$i]['apiKey']);
        }

        return $usersTest;
    }

    public function getUser($id){

        $user = selectDB("USERS", "*", "id_users=".$id);

        return new UserModel($user[0]['id_users'], $user[0]['role'], $user[0]['apiKey'];
    }

    public function deleteUser($id){
        deleteDB("USERS", "id_users=".$id);
    }

    
    public function createUser(UserModel $user){
        insertDB("USERS", ["id_users", "role", "apiKey"], [$user->id_users, $user->role, $user->apiKey]);

        return getUser($user->id_users);
    }

}


?>