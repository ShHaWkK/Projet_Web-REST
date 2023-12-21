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

    public function getUserById($id, $apiKey = null) {
        $userRepository = new UserRepository();
        return $userRepository->getUser($id, $apiKey);
    }

    /*
     *  Créer un utilisateur
    */

    public function createUser($role, $pseudo, $password) {
        $userRepository = new UserRepository();
        $newUser = new UserModel(12, $role, $pseudo, $password);
        return $userRepository->createUser($newUser);
    }

    /*
     *  Met à jour un utilisateur
    */

    public function updateUser($id_users, $apiKey, $role, $pseudo, $user_index) {
        $userRepository = new UserRepository();
        $newUser = new UserModel($id_users, $role, $pseudo, '1234', $user_index, null);
        return $userRepository->updateUser($newUser, $apiKey);
    }


    /*
     *  Supprime un utilisateur
    */
    public function deleteUser($id, $apiKey) {
        $userRepository = new UserRepository();
        if ($userRepository->unreferenceUser($id, $apiKey)){
            exit_with_message("Unreference Succeed !");
        }
    }
    
}
?>
