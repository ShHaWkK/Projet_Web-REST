<?php
include_once './Service/reservationService.php';
include_once './Models/reservationModel.php';
include_once './exceptions.php';



function ReservationController($uri) {
    
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':

        	$reservationService = new ReservationService($uri);

            if($uri[3]){
                $tmp = $reservationService->getReservationById($uri[3]);                
                exit_with_content([$tmp, $reservationService->getToBookIdApartment($tmp->id_reservation)]);
            }
            else{
                exit_with_content($reservationService->getAllReservations());
            }
            
            break;


        case 'POST':
         	$reservationService = new ReservationService($uri);

            $body = file_get_contents("php://input");
            $json = json_decode($body, true);

            // Valider les données reçues ici
            exit_with_content($reservationService->createUser($json["role"]));

            break;


        case 'PUT':
        	$reservationService = new ReservationService($uri);

            $body = file_get_contents("php://input");
            $json = json_decode($body, true);
            // Valider les données reçues ici
            exit_with_content($reservationService->updateUser($uri[3], $json["role"]));
            break;


        case 'DELETE':
            // Gestion des requêtes DELETE pour supprimer
            $reservationService = new ReservationService($uri);
            exit_with_content($reservationService->deleteUser($uri[3]));
            break;

        default:
            // Gestion des requêtes OPTIONS pour le CORS
            header("HTTP/1.1 200 OK");
            exit();
    }
}

?>