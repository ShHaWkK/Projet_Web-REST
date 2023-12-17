<?php
include_once 'services/UserService.php';
include_once 'models/UserModel.php';
include_once 'exceptions/HTTPException.php';

function userController($uri) {
    $userModel = new UserModel();

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            // Gestion des requêtes GET pour les utilisateurs
            if (sizeof($uri) == 4) {
                try {
                    $result = $userModel->getUser($uri[3]); 
                } catch (HTTPException $e) {
                    exitWithMessage($e->getMessage(), $e->getCode());
                }
            } else {
                $result = $userModel->getUsers();
            }
            exitWithContent($result);
            break;

        case 'POST':
            // Gestion des requêtes POST pour créer un utilisateur
            $body = file_get_contents("php://input");
            $json = json_decode($body);
            // Valider les données reçues ici
            try {
                $result = $userModel->addUser($json);
                exitWithMessage("User Created!", 201);
            } catch (HTTPException $e) {
                exitWithMessage($e->getMessage(), $e->getCode());
            }
            break;

        case 'PATCH':
            // Gestion des requêtes PATCH pour mettre à jour un utilisateur
            if (sizeof($uri) < 4) {
                exitWithMessage("Bad Request", 400);
            }
            $body = file_get_contents("php://input");
            $json = json_decode($body);
            // Valider les données reçues ici
            try {
                $userModel->updateUser($uri[3], $json);
                exitWithMessage("User Updated", 200);
            } catch (HTTPException $e) {
                exitWithMessage($e->getMessage(), $e->getCode());
            }
            break;

        case 'DELETE':
            // Gestion des requêtes DELETE pour supprimer un utilisateur
            if (sizeof($uri) < 4) {
                exitWithMessage("Bad Request", 400);
            }
            try {
                $userModel->deleteUser($uri[3]);
                exitWithMessage("User Deleted", 200);
            } catch (HTTPException $e) {
                exitWithMessage($e->getMessage(), $e->getCode());
            }
            break;

        default:
            // Gestion des requêtes OPTIONS pour le CORS
            header("HTTP/1.1 200 OK");
            exit();
    }
}
?>
