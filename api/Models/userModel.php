<?php

include_once './Repository/BDD.php';

class UserModel {
    public $id_users;
    public $role;
    public $apiKey;

    public function __construct($id_users, $role, $apiKey = null) {
        $this->id_users = $id_users;
        $this->role = $role;
        $this->apiKey = $apiKey;
    }
}

?>
