<?php

include_once './Repository/BDD.php';

class UserModel {
    public $id_users;
    public $role;
    public $pseudo;
    public $password;
    public $user_index;
    public $apiKey;

    public function __construct($id_users, $role, $pseudo, $password = null, $user_index = null, $apiKey = null) {
        $this->id_users = $id_users;
        $this->role = $role;
        $this->apiKey = $apiKey;
        $this->pseudo = $pseudo;
        $this->password = $password;
        $this->user_index = $user_index;
    }
}

?>
