<?php

# Cet objet sert à transporter les données d'une entité Music de facon standard et indépendante de http ou de la BDD.
class UserModel {
    public $id_users;
    public $role;
    public $apiKey;
    
    public
    function __construct($id_users, $role, $apiKey)
    {       
        $this->id_users = $id_users;
        $this->role = $role;
        $this->apiKey = $apiKey;
    }
}



?>