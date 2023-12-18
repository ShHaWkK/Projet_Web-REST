<?php

# Cet objet sert à transporter les données d'une entité Music de facon standard et indépendante de http ou de la BDD.
class ApartmentModel {
    public $id_apartement;
    public $place;
    public $address;
    public $complement_address;
    public $availability;
    public $price_night;
    public $area;
    public $id_users;

    public
    function __construct($id_apartement, $place, $address, $complement_address, $availability, $price_night, $area, $id_users)
    {       
        $this->id_apartement = $id_apartement;
        $this->place = $place;
        $this->address = $address;
        $this->complement_address = $complement_address;
        $this->availability = $availability;
        $this->price_night = $price_night;
        $this->area = $area;
        $this->id_users = $id_users;
    }
}



?>