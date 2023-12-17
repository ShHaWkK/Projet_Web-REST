<?php
include_once 'UserRepository.php'; 


class UserService {
    private $userRepository;

    /*
    * Construction du service 
    */

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $UserRepository();
    }

    /*
     *  Récupère tous les utilisateurs
    */
    public function getAllUsers() {
        return $this->userRepository->getUsers();
    }

    /*
     *  Récupère un utilisateur par son id
    */

    public function getUserById($id) {
        return $this->userRepository->getUser($id);
    }

    /*
     *  Créer un utilisateur
    */

    public function createUser($id_users, $role, $apiKey) {
        $newUser = new UserModel($id_users, $role, $apiKey);
        return $this->userRepository->createUser($newUser);
    }

    /*
     *  Met à jour un utilisateur
    */

    public function updateUser($id_users, $role, $apiKey) {
        $newUser = new UserModel($id_users, $role, $apiKey);
        return $this->userRepository->updateUser($newUser);
    }

    /*
     *  Met à jour le role d'un utilisateur
    */

    public function updateUserRole($id, $newRole) {
        // Validation 
        return $this->userRepository->updateRole($id, $newRole);
    }

    /*
     *  Supprime un utilisateur
    */
    public function deleteUser($id) {
        return $this->userRepository->delete($id);
    }

    /*
     *  Vérifie si le role est valide
    */
    
    public function updateUserRole($id, $newRole) {
        if (!$this->isValidRole($newRole)) {
            throw new Exception("Invalid role specified.");
        }
        return $this->userRepository->updateRole($id, $newRole);
    }

    /*
     *  Vérifie si la clé API est valide
    */

    public function isValidRole($role) {
        return in_array($role, ['admin', 'user']);
    }
    /*
    *  La clé API est un hash md5 de l'identifiant de l'utilisateur
    */
    public function isValidApiKey($apiKey) {
        return preg_match('/^[a-zA-Z0-9]{32}$/', $apiKey);
    }
}

/*
<?php

include_once './Repository/UserRepository.php';

class UserService {
    private $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function getAllUsers() {
        return $this->userRepository->getUsers();
    }

    public function getUserById($id) {
        return $this->userRepository->getUser($id);
    }

    public function createUser($id_users, $role, $apiKey) {
        $newUser = new UserModel($id_users, $role, $apiKey);
        return $this->userRepository->createUser($newUser);
    }

    public function deleteUser($id) {
        $this->userRepository->deleteUser($id);
    }

    public function updateUser($id_users, $role, $apiKey) {
        $newUser = new UserModel($id_users, $role, $apiKey);
        return $this->userRepository->updateUser($newUser);
    }
*/