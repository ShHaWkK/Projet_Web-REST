<?php
include_once './Service/userService.php';
include_once './Models/userModel.php';
include_once './exceptions.php';



function userController($uri, $apiKey) {
    
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':

        	$userService = new UserService($uri);
            $role = getRoleFromApiKey($apiKey);

            //$role = selectDB("USERS", 'role', "apikey='".$apiKey."'")[0]["role"];

            if($uri[3] && $role != 1){
                exit_with_content($userService->getUserById($uri[3], $apiKey));
            }
            elseif($uri[3] && $role < 3){
                exit_with_content($userService->getUserById($uri[3], $apiKey));
            }
            elseif(!$uri[3] && $role < 3){
                exit_with_content($userService->getAllUsers());
            }
            else{
                exit_with_message("You need to be admin to see all the users");
            }
            
            break;


        // Create the user
        case 'POST':
         	$userService = new UserService($uri);

            $body = file_get_contents("php://input");
            $json = json_decode($body, true);

            if ( !isset($json['role']) || !isset($json['pseudo']) || !isset($json['password']) )
            {
                exit_with_message("Plz give the role, the pseudo and the password of the user");
            }

            // Valider les données reçues ici
            exit_with_content($userService->createUser($json["role"], $json["pseudo"], $json["password"]));

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
            exit_with_content($userService->updateUser($uri[3], $apiKey, $json["role"], $json["pseudo"], $json["user_index"]));
            break;


        case 'DELETE':
            // Gestion des requêtes DELETE pour supprimer un utilisateur
            $userService = new UserService($uri);
            $userService->deleteUser($uri[3], $apiKey);
            break;

        default:
            // Gestion des requêtes OPTIONS pour le CORS
            header("HTTP/1.1 200 OK");
            exit();
    }
}

?>