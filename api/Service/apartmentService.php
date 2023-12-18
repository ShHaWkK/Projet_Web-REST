<?php
require_once '../Repository/apartmentRepository.php'; 


class AppartmentService {
    private $apartmentRepository;

    //Construction du service 
    public function __construct(ApartmentRepository $apartmentRepository) {
        $this->apartmentRepository = $ApartmentRepository();
    }

    //Récupère tous les appartements
    public function getAllApartements() {
        return $this->apartmentRepository->getApartments();
    }

    //Récupère un appartement par son id
    public function getApartementById($id_apartement) {
        return $this->apartmentRepository->getApartment($id_apartement);
    }


    //Créer un appartement
     function addApartment($id_apartement, $place, $address, $complement_address, $availability, $price_night, $area, $id_users) {
        $newApartment = new ApartementModelApartementModel( $id_apartement, $place, $address, $complement_address, $availability, $price_night, $area);
        return $this->apartmentRepository->addApartment($newUser);
    }


    //Met à jour un appartement
    public function updateApartment(($id_apartement, $place, $address, $complement_address, $availability, $price_night, $area) {
        $newUser = new ApartementModel($id_apartement, $place, $address);
        return $this->apartmentRepository->updateUser($newUser);
    }

  	// Met à jour la disponibilte d'un appartement
    public function updateApartmentAvail($id_apartement, $availability) {
        // Validation 
        return $this->apartmentRepository->updateRole($id, $availability);
    }


    //Supprime un appartement
    public function deleteApartment($id_apartement) {
        return $this->apartmentRepository->delete($id_apartement);
    }

}


?>