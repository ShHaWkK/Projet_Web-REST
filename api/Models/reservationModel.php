<?php

include_once './Repository/BDD.php';

class ReservationModel {
    public $id_reservation;
    public $date_entry;
    public $date_exit;
    public $price_stay;
    public $id_users;

    public function __construct($id_reservation, $date_entry, $date_exit, $price_stay, $id_users) {
        $this->id_reservation = $id_reservation;
        $this->date_entry = $date_entry;
        $this->date_exit = $date_exit;
        $this->price_stay = $price_stay;
        $this->id_users = $id_users;
    }
}

?>

