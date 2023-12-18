<?php
include_once './Repository/userRepository.php'; 
include_once './Models/userModel.php';

class UserService {
    private $userRepository;

    /*
    * Construction du service 
    */

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository();
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
     *  Met à jour le rôle d'un utilisateur
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
     *  Vérifie si le rôle est valide
    */

    public function createUserWithRole($role, $apiKey) {
        if (!$this->isValidRole($role)) {
            throw new Exception("Invalid role specified.");
        }
        $newUser = new UserModel(null, $role, $apiKey); 
        return $this->userRepository->createUser($newUser);
    }

    
    public function updateUserWithRole($id_users, $role, $apiKey) {
        // Même validation pour le rôle
        if (!$this->isValidRole($role)) {
            throw new Exception("Invalid role specified.");
        }
        $updatedUser = new UserModel($id_users, $role, $apiKey);
        return $this->userRepository->updateUser($updatedUser);
    }

    /*
     *  Vérifie si la clé API est valide
    */

    public function isValidRole($role) {
        $validRoles = [1 => 'admin', 2 => 'modo', 3 => 'propriétaire', 4 => 'client'];
        return array_key_exists($role, $validRoles);
    }
    /*
    *  La clé API est un hash md5 de l'identifiant de l'utilisateur
    */
    public function isValidApiKey($apiKey) {
        return preg_match('/^[a-zA-Z0-9]{32}$/', $apiKey);
    }
}
?>
