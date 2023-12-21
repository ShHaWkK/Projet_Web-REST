<?php
include_once './Service/loginService.php';
include_once './exceptions.php';



function loginController($uri) {
    
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':

            $loginClass = new LoginService($uri);
            $body = file_get_contents("php://input");
            $json = json_decode($body, true);

            if (!isset($json['pseudo']) || !isset($json['password']))
            {
                exit_with_message("Plz give the pseudo and the password of the user");
            }

            exit_with_content($loginClass->getApiKey($json['pseudo'], ($json['password'])));
            
            break;


        
        case 'POST':
         	exit_with_message('you don t have the right to make a POST');
            break;


        
        case 'PUT':
        	exit_with_message('you don t have the right to make a PUT');
            break;


        case 'DELETE':
            exit_with_message('you don t have the right to make a DELETE');
            break;

        default:
            // Gestion des requêtes OPTIONS pour le CORS
            header("HTTP/1.1 200 OK");
            exit();
    }
}

?>