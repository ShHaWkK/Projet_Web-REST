<?php
include_once './Repository/reservationRepository.php'; 
include_once './Models/userModel.php';

class ReservationService {
    
    public $uri;

    public function __construct($uri)
    {       
        $this->uri = $uri;
    }

    public function getAllReservations() {
        $reservationRepository = new ReservationRepository();
        return $reservationRepository->getReservations();
    }

    public function getReservationById($id) {
        $reservationRepository = new ReservationRepository();
        return $reservationRepository->getReservation($id);
    }

    public function getToBookIdApartment($id_reservation){
        $reservationRepository = new ReservationRepository();
        return $reservationRepository->getToBook($id_reservation);
    }

    public function createReservation(ReservationDataModel $ReservModel) {
        $reservationRepository = new ReservationRepository();


        // Retrieve all the reserved appart with the same ID
        $id_Reserv = (selectDB('TO_BOOK', "id_reservation", "id_apartement=".$ReservModel->id_apartement));

        for ($i=0; $i < count($id_Reserv); $i++) { 

            $tmp = selectDB("RESERVATION", "id_reservation, date_entry, date_exit, id_users", "id_reservation=".$id_Reserv[$i]["id_reservation"]." AND etat=1", "bool")[0];

            if ($tmp){

                if (strtotime($ReservModel->date_entry) > strtotime($ReservModel->date_exit) ){
                    exit_with_message("Error : date_entry > date_exit :/");
                }
                
                if (strtotime($ReservModel->date_entry) >= strtotime($tmp["date_entry"]) && strtotime($ReservModel->date_entry) <= strtotime($tmp["date_exit"])){
                    if ($tmp["id_users"] != $ReservModel->id_users){
                        exit_with_message("Error : You can't reserv this appartment (id : ". $ReservModel->id_apartement ."), it already reserved during this period : ". $tmp["date_entry"] . " to " . $tmp["date_exit"]);
                    }
                    exit_with_message("You already have booked this apartment at this time. Id_apartment : ".$ReservModel->id_apartement." id_reservation : ".$tmp["id_reservation"]);
                }

                if (strtotime($ReservModel->date_exit) >= strtotime($tmp["date_entry"]) && strtotime($ReservModel->date_exit) <= strtotime($tmp["date_exit"])){
                    if ($tmp["id_users"] != $ReservModel->id_users){
                        exit_with_message("Error : You can't reserv this appartment (id : ". $ReservModel->id_apartement ."), it already reserved during this period : ". $tmp["date_entry"] . " to " . $tmp["date_exit"]);
                    }
                    exit_with_message("You already have booked this apartment at this time. Id_apartment : ".$ReservModel->id_apartement." id_reservation : ".$tmp["id_reservation"]);
                }

                if (strtotime($ReservModel->date_entry) <= strtotime($tmp["date_entry"]) && strtotime($ReservModel->date_exit) >= strtotime($tmp["date_exit"])){
                    if ($tmp["id_users"] != $ReservModel->id_users){    
                        exit_with_message("Error : You can't reserv this appartment (id : ". $ReservModel->id_apartement ."), it already reserved during this period : ". $tmp["date_entry"] . " to " . $tmp["date_exit"]);
                    }
                    exit_with_message("You already have booked this apartment at this time. Id_apartment : ".$ReservModel->id_apartement." id_reservation : ".$tmp["id_reservation"]);
                }

                if (strtotime($ReservModel->date_entry) == strtotime($ReservModel->date_exit) ){
                    if ($tmp["id_users"] != $ReservModel->id_users){    
                        exit_with_message("Error : You can't reserv this appartment (id : ". $ReservModel->id_apartement .") just for one day, you need one night with it.");
                    }
                    exit_with_message("You already have booked this apartment at this time. Id_apartment : ".$ReservModel->id_apartement." id_reservation : ".$tmp["id_reservation"]);
                }
            }
        }

        $price = selectDB('APARTMENT', 'price_night', "id_apartement=".$ReservModel->id_apartement)[0]["price_night"]+0;
        $ReservModel->price_stay = $price*((strtotime($ReservModel->date_exit) - strtotime($ReservModel->date_entry)) / (60 * 60 * 24));

        return $reservationRepository->createReservation($ReservModel);
    }

    public function updateStateReservation($id, $etat, $apikey){

        if(selecDB("USERS", "id_user", "apikey='".$apikey."'", "bool")){
            $id_user = selecDB("USERS", "id_user", "apikey='".$apikey."'")[0]['id_users'];
        }
        else{
            exit_with_message("What a strange place...");
        }

        if(selectDB("RESERVATION",["etat"],[2], "id_users=".$id_user)){

        }

        $reservationRepository = new reservationRepository();
        return $reservationRepository->updateReservation($id, $etat);
    }

    public function cancelReservation($id, $apikey) {
        $reservationRepository = new reservationRepository();
        return $reservationRepository->cancelReservation($id, $apikey);
    }
    
}
?>
