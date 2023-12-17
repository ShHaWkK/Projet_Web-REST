<?php
require_once 'UserRepository.php'; 


class UserService {
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $UserRepository();
    }

    public function getAllUsers() {
        return $this->userRepository->findAll();
    }

    public function getUserById($id) {
        return $this->userRepository->findById($id);
    }

    public function createUser($role) {
        // Validation 
        return $this->userRepository->save(['role' => $role]);
    }

    public function updateUserRole($id, $newRole) {
        // Validation 
        return $this->userRepository->updateRole($id, $newRole);
    }

    public function deleteUser($id) {
        return $this->userRepository->delete($id);
    }

    public function createUser($role) {
        if (!$this->isValidRole($role)) {
            throw new Exception("Invalid role specified.");
        }
        return $this->userRepository->save(['role' => $role]);
    }

    public function updateUserRole($id, $newRole) {
        if (!$this->isValidRole($newRole)) {
            throw new Exception("Invalid role specified.");
        }
        return $this->userRepository->updateRole($id, $newRole);
    }

}