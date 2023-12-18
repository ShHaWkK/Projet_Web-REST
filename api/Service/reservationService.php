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

    public function createReservation($role) {
        $reservationRepository = new ReservationRepository();
        $newReservation = new ReservationModel(12, $role, null);
        return $reservationRepository->createReservation($newReservation);
    }

    /*
    public function updateReservation($id_users, $role) {
        $reservationRepository = new reservationRepository();
        $newUser = new UserModel($id_users, $role, null);
        return $reservationRepository->updateUser($newUser);
    }
    */


    /*
     *  Supprime un utilisateur
    */
    public function deleteReservation($id) {
        $reservationRepository = new reservationRepository();
        return $reservationRepository->deleteReservation($id);
    }
    
}
?>
