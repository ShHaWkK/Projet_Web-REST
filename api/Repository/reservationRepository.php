<?php
include_once './Repository/BDD.php';
include_once './Models/ToBookModel.php';
include_once './exceptions.php';

class ReservationRepository {
    private $connection = null;

    // I'm not sure about this function lol (unuse)
    function __construct() {

    }
    
    //-------------------------------------

    public function getReservations(){
        $reservationArray = selectDB("RESERVATION", "*");

        $reservation = [];
        $usersTest = [];

        for ($i=0; $i < count($reservationArray); $i++) { 
            $reservation[$i] = new ReservationModel($reservationArray[$i]['id_reservation'], $reservationArray[$i]['date_entry'], $reservationArray[$i]['date_exit'], $reservationArray[$i]['price_stay'], $reservationArray[$i]['id_users'], $reservationArray[$i]['etat']);
        }

        return $reservation;
    }

    //-------------------------------------

    public function getReservation($id){

        $reservation = selectDB("RESERVATION", "*", "id_reservation=".$id)[0];

        return new ReservationModel($reservation['id_reservation'], $reservation['date_entry'], $reservation['date_exit'], $reservation['price_stay'], $reservation['id_users'], $reservation['etat']);
    }

    //-------------------------------------

    public function getToBook($id_reservation){

        $reservation = selectDB("TO_BOOK", "*", "id_reservation=".$id_reservation)[0];

        return new ToBookModel($reservation['id_apartement'], $reservation['id_reservation']);
    }

    //-------------------------------------
    
    public function createReservation(ReservationDataModel $ReservModel){
        insertDB('RESERVATION', ["date_entry", "date_exit", "price_stay", "id_users", "etat"], [$ReservModel->date_entry, $ReservModel->date_exit, $ReservModel->price_stay, $ReservModel->id_users, 1]);

        $id_reserv = selectDB('RESERVATION', "id_reservation", "date_exit='".$ReservModel->date_exit."' AND id_users=".$ReservModel->id_users)[0]["id_reservation"];

        insertDB("TO_BOOK", ["id_reservation", "id_apartement"], [$id_reserv, $ReservModel->id_apartement]);

        return $this->getReservation($id_reserv);
    }

    //-------------------------------------
    
    public function updateReservation($id_reservation, $etat){
        
        updateDB("RESERVATION", ["etat"], [$etat], 'id_reservation='.$id_reservation);

        return $this->getReservation($id_reservation);
    }

    //-------------------------------------

    public function cancelReservation($id, $apikey){


        $role_deleter = getRoleFromApiKey($apikey);

        $id_user_deleter = selectDB("USERS", "id_users", "apikey='".$apikey."'");

        if($role_deleter == 3){
            //Vérif de m****
            if(selectDB('APARTMENT', "*", "id_users=".$id_user_deleter, "bool")){
                $id_apartement = selectDB('APARTMENT', "*", "id_users=".$id_user_deleter)[0]["id_apartement"];
            }

            if($id_apartement != $id){
                exit_with_message("Bah kes tu fou mon reuf, pourquoi tu veux cancel une reservation qui n'est pas à toi ?");
            }
        }

        // Execute les trucs
        updateDB("RESERVATION", ["etat"], [-1], "id_reservation=".$id);
        $data = selectDB("RESERVATION", "*", "id_reservation=".$id)[0];
        exit_with_message("Unreferencement Succeed !");

    }



}



// Ps : c'est pas Chat GPT




























// Vraiment hein




































// Non, je force pas









































// C'est une vanne lol.
?>