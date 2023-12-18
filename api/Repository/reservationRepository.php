<?php
include_once './Repository/BDD.php';
include_once './Models/ToBookModel.php';
include_once './exceptions.php';

class ReservationRepository {
    private $connection = null;

    // I'm not sure about this function lol (unuse)
    function __construct() {
        try {
            $this->connection = pg_connect("host=restpastropapi-database-1 port=5432 dbname=apiDev_db user=apiDev password=password");
            if (  $this->connection == null ) {
                throw new BDDException("Could not connect to database.");
            }
        } catch (Exception $e) {
            throw new BDDException("Could not connect db: ". $e->getMessage());
        }
    }
    
    //-------------------------------------

    public function getReservations(){
        $reservationArray = selectDB("RESERVATION", "*");

        $reservation = [];
        $usersTest = [];

        for ($i=0; $i < count($reservationArray); $i++) { 
            $reservation[$i] = new ReservationModel($reservationArray[$i]['id_reservation'], $reservationArray[$i]['date_entry'], $reservationArray[$i]['date_exit'], $reservationArray[$i]['price_stay'], $reservationArray[$i]['id_users']);
        }

        return $reservation;
    }

    //-------------------------------------

    public function getReservation($id){

        $reservation = selectDB("RESERVATION", "*", "id_reservation=".$id)[0];

        return new ReservationModel($reservation['id_reservation'], $reservation['date_entry'], $reservation['date_exit'], $reservation['price_stay'], $reservation['id_users']);
    }

    //-------------------------------------

    public function getToBook($id_reservation){

        $reservation = selectDB("TO_BOOK", "*", "id_reservation=".$id_reservation)[0];

        return new ToBookModel($reservation['id_reservation'], $reservation['id_apartement']);
    }

    //-------------------------------------
    
    public function createReservation(UserModel $user){
        insertDB("USERS", ["role", "apiKey"], [$user->role, $user->apiKey]);

        return $this->getUser($user->id_users);
    }

    //-------------------------------------
    
    public function updateReservation(UserModel $user){
        
        updateDB("USERS", ["role"], [$user->role], 'id_users='.$user->id_users);

        return $this->getUser($user->id_users);
    }

    //-------------------------------------

    public function deleteReservation($id){
        deleteDB("USERS", "id_users=".$id);
    }



}


?>