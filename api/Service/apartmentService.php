<?php
include_once '../Repository/apartmentRepository.php'; 




class ApartmentService
{
	
	/*
    //Construction du service 
    public function __construct(ApartmentRepository $apartmentRepository) {
        $this->apartmentRepository = $ApartmentRepository();
    }
	
	*/
	$apartmentRepository = new apartmentRepository();


    //Récupère tous les appartements
    public function getAllApartments() {
        return $this->apartmentRepository->getApartments();
    }

    //Récupère un appartement par son id
    public function getApartmentById($id_apartement) {
        return $this->apartmentRepository->getApartment($id_apartement);
    }


    //Créer un appartement
     function addApartment($id_apartement, $place, $address, $complement_address, $availability, $price_night, $area, $id_users) {
        $newApartment = new ApartmentModel( 12, $place, $address, $complement_address, $availability, $price_night, $area, $id_users);
        return $this->apartmentRepository->addApartment($newApartment);
    }


    //Met à jour un appartement
    public function updateApartment(($id_apartement, $place, $address, $complement_address, $availability, $price_night, $area, $id_users) {
        $newUser = new ApartementModel($id_apartement, $place, $address, $complement_address, $availability, $price_night, $area, $id_users);
        return $this->apartmentRepository->updateApartment($id_apartement, ["id_apartement", "place", "address", "complement_address", "availability", "price_night", "area", "id_users"], [$id_apartement, $place, $address, $complement_address, $availability, $price_night, $area, $id_users]);
    }

  	// Met à jour la disponibilte d'un appartement
    public function updateApartmentAvail($id_apartement, $availability) {
        // Validation 
        return $this->apartmentRepository->updateApartment($id_apartement, "availability", $availability);
    }


    //Supprime un appartement
    public function deleteApartment($id_apartement) {
        return $this->apartmentRepository->delete($id_apartement);
    }


}


?>