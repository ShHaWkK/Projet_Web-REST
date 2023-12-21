<?php
include_once './Service/userService.php';
include_once './Models/userModel.php';
include_once './exceptions.php';



function userController($uri) {
    
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':

        	$userService = new UserService($uri);

            if($uri[3]){
                exit_with_content($userService->getUserById($uri[3]));
            }
            else{
                exit_with_content($userService->getAllUsers());
            }
            
            break;


        // Create the user
        case 'POST':
         	$userService = new UserService($uri);

            $body = file_get_contents("php://input");
            $json = json_decode($body, true);

            if (!isset($json['role']) || !isset($json['pseudo']))
            {
                exit_with_message("Plz give the role and the pseudo of the user");
            }

            // Valider les données reçues ici
            exit_with_content($userService->createUser($json["role"], $json["pseudo"]));

            break;


        // update the user
        case 'PUT':
        	$userService = new UserService($uri);

            $body = file_get_contents("php://input");
            $json = json_decode($body, true);
            if (!isset($json["role"]) || !isset($json["pseudo"]) || !isset($json["user_index"])){
                exit_with_message("Plz give, at least, the role, pseudo and the user_index");
            }
            // Valider les données reçues ici
            exit_with_content($userService->updateUser($uri[3], $json["role"], $json["pseudo"], $json["user_index"]));
            break;


        case 'DELETE':
            // Gestion des requêtes DELETE pour supprimer un utilisateur
            $userService = new UserService($uri);
            $userService->deleteUser($uri[3]);
            break;

        default:
            // Gestion des requêtes OPTIONS pour le CORS
            header("HTTP/1.1 200 OK");
            exit();
    }
}

?>