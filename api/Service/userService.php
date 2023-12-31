<?php
include_once './Repository/userRepository.php'; 
include_once './Models/userModel.php';

class UserService {
    
    public $uri;

    public function __construct($uri)
    {       
        $this->uri = $uri;
    }

    /*
     *  Récupère tous les utilisateurs
    */
    public function getAllUsers() {
        $userRepository = new UserRepository();

        /*
        if (admin){
            return $userRepository->getUsers(0);
        }
        */
        return $userRepository->getUsers();
    }

    /*
     *  Récupère un utilisateur par son id
    */

    public function getUserById($id) {
        $userRepository = new UserRepository();
        return $userRepository->getUser($id);
    }

    /*
     *  Créer un utilisateur
    */

    public function createUser($role, $pseudo) {
        $userRepository = new UserRepository();
        $newUser = new UserModel(12, $role, $pseudo);
        return $userRepository->createUser($newUser);
    }

    /*
     *  Met à jour un utilisateur
    */

    public function updateUser($id_users, $role, $pseudo, $user_index) {
        $userRepository = new UserRepository();
        $newUser = new UserModel($id_users, $role, $pseudo, $user_index, null);
        return $userRepository->updateUser($newUser);
    }


    /*
     *  Supprime un utilisateur
    */
    public function deleteUser($id) {
        $userRepository = new UserRepository();
        if ($userRepository->unreferenceUser($id)){
            exit_with_message("Unreference Succeed !");
        }
    }


    public function isValidRole($role) {
        $validRoles = [1 => 'admin', 2 => 'modo', 3 => 'propriétaire', 4 => 'client'];
        return array_key_exists($role, $validRoles);
    }
    
}
?>
