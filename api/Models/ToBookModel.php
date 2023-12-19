<?php

include_once './Repository/BDD.php';

class ToBookModel {
    public $id_apartement;
    public $id_reservation;

    public function __construct($id_apartement, $id_reservation) {
        $this->id_apartement = $id_apartement;
        $this->id_reservation = $id_reservation;
    }
}

?>

