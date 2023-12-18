<?php
include_once './Repository/apartmentRepository.php'; 
include_once './Models/apartmentModel.php';

class ApartmentService {
    //private $apartmentRepository;
    public $uri;

    public function __construct($uri)
    {       
        $this->uri = $uri;
    }

    //Récupère tous les appartements
    public function getAllApartments() {
        $apartmentRepository = new ApartmentRepository();
        return $apartmentRepository->getApartments();
    }

    //Récupère un appartement par son id
    public function getApartmentById($id_apartement) {
        $apartmentRepository = new ApartmentRepository();
        return $apartmentRepository->getApartment($id_apartement);
    }


    //Créer un appartement
    public function addApartment($id_appartement, $place, $address, $complement_address, $availability, $price_night, $area, $id_users) {
        $apartmentRepository = new ApartmentRepository();
        $newApartment = new ApartmentModel(null, $place, $address, $complement_address, $availability, $price_night, $area, $id_users, $id_appartement);
        return $apartmentRepository->addApartment($newApartment);
    }


    //Met à jour un appartement
    public function updateApartment($id_apartement, $place, $address, $complement_address, $availability, $price_night, $area) {
        $apartmentRepository = new ApartmentRepository();
        $newApart = new ApartementModel($id_apartement, $place, $address);
        return $apartmentRepository->updateUser($newApart);
    }

  	// Met à jour la disponibilte d'un appartement
    public function updateApartmentAvail($id_apartement, $availability) {
        // Validation 
        $apartmentRepository = new ApartmentRepository();
        return $apartmentRepository->updateRole($id_apartement, $availability);
    }


    //Supprime un appartement
    public function deleteApartment($id_apartement) {
        $apartmentRepository = new ApartmentRepository();
        return $apartmentRepository->deleteApartment($id_apartement);
    }

}


?>

