<?php
include_once './Service/reservationService.php';
include_once './Models/reservationModel.php';
include_once './exceptions.php';



function ReservationController($uri) {
    
    switch ($_SERVER['REQUEST_METHOD']) {

        // Retrieve Reservation(s)
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


        // Create Reservation
        case 'POST':
         	$reservationService = new ReservationService($uri);

            $body = file_get_contents("php://input");
            $json = json_decode($body, true);

            if (!isset($json["id_apartement"]) || !isset($json["date_entry"]) || !isset($json["date_exit"]) || !isset($json["id_users"])){
                exit_with_message("Plz give id_apartement, date_entry, date_exit_ price_stay and id_users to create a new reservation");
            }

            $reservModel = new ReservationDataModel($json["date_entry"], $json["date_exit"], NULL, $json["id_users"], $json["id_apartement"]);

            // Valider les données reçues ici
            exit_with_content($reservationService->createReservation($reservModel));

            break;


        // Cancel Reservation
        case 'DELETE':
            // Gestion des requêtes DELETE pour supprimer
            $reservationService = new ReservationService($uri);
            exit_with_content($reservationService->cancelReservation($uri[3]));
            break;

        default:
            // Gestion des requêtes OPTIONS pour le CORS
            header("HTTP/1.1 200 OK");
            exit();
    }
}

?>