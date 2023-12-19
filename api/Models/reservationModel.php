<?php

include_once './Repository/BDD.php';

class ReservationDataModel {
    public $date_entry;
    public $date_exit;
    public $price_stay;
    public $id_users;
    public $id_apartement;
    public $id_reservation;

    public function __construct($date_entry, $date_exit, $price_stay, $id_users, $id_apartement, $id_reservation = null) {
        $this->date_entry = $date_entry;
        $this->date_exit = $date_exit;
        $this->price_stay = $price_stay;
        $this->id_users = $id_users;
        $this->id_apartement = $id_apartement;
        $this->id_reservation = $id_reservation;
    }
}


class ReservationModel {
    public $id_reservation;
    public $date_entry;
    public $date_exit;
    public $price_stay;
    public $id_users;
    public $etat;

    public function __construct($id_reservation, $date_entry, $date_exit, $price_stay, $id_users, $etat) {
        $this->id_reservation = $id_reservation;
        $this->date_entry = $date_entry;
        $this->date_exit = $date_exit;
        $this->price_stay = $price_stay;
        $this->id_users = $id_users;
        $this->etat = $etat;
    }
}

?>

