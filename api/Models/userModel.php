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

    /*
    public function save() {
        if ($this->id_users === null) {
            $columnArray = ['role'];
            $columnData = ["'{$this->role}'"]; 
            insertDB('users', $columnArray, $columnData);
        } else {
            $columnArray = ['role'];
            $columnData = ["'{$this->role}'"];
            $condition = "id_users={$this->id_users}";
            updateDB('users', $columnArray, $columnData, $condition);
        }
    }

    public function delete() {
        if ($this->id_users !== null) {
            $condition = "id_users={$this->id_users}";
            deleteDB('users', $condition);
        }
    }

    public static function getAllUsers() {
        return selectDB('users', '*');
    }

    public static function getUserById($id) {
        $condition = "id_users={$id}";
        return selectDB('users', '*', $condition);
    }
    */
}

?>
