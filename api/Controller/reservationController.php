<?php
include_once './Service/reservationService.php';
include_once './Models/reservationModel.php';
include_once './exceptions.php';



function ReservationController($uri, $apikey) {

    if ($apikey == null){
        exit_with_message("You need to be connected (have an apikey) to book an apart.");
    }

    $role = getRoleFromApiKey($apikey);
    
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

            if($role != 4){
                exit_with_message("You can't book, unless if your client");
            }

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


         // Update the state of the reservation
        case 'PATCH':

            // Only
            if($role != 4){
                exit_with_message("Casse burnes");
            }

            $reservationService = new ReservationService($uri);

            $body = file_get_contents("php://input");
            $json = json_decode($body, true);

            if (!isset($json["etat"])){
                exit_with_message("Plz give the state of the reservation");
            }
            if(gettype($json["etat"]) != "integer"){
                exit_with_message("Plz give an integer. You can't go back after have updated the state of the reservation.");
            }
            if ($json["etat"] != 2){
                exit_with_message("You can't update the state of the reservation as 'not took nor canceled (plz use DELETE METHOD)' : 1 => reserved, 2 => took, -1 => canceled");
            }

            // Valider les données reçues ici
            exit_with_content($reservationService->updateStateReservation($uri[3], $json["etat"], $apikey));

            break;


        // Cancel Reservation
        case 'DELETE':
            // Gestion des requêtes DELETE pour supprimer

            if($role == 3){
                exit_with_message("Plz ask an admin to cancel a client reservation");
            }

            $reservationService = new ReservationService($uri);
            exit_with_content($reservationService->cancelReservation($uri[3], $apikey));
            break;

        default:
            // Gestion des requêtes OPTIONS pour le CORS
            header("HTTP/1.1 200 OK");
            exit();
    }
}

?>