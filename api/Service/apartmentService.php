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
    public function addApartment($id_appartement, $place, $address, $complement_address, $availability, $price_night, $area, $id_users, $apartment_index = 1) {
        $apartmentRepository = new ApartmentRepository();
        $newApartment = new ApartmentModel(12, $place, $address, $complement_address, $availability, $price_night, $area, $id_users, $apartment_index);
        
        $id_apprt = $apartmentRepository->addApartment($newApartment);
        return $apartmentRepository->getApartment($id_apprt[0]["id_apartement"]);
    }


    //Met à jour un appartement
    public function updateApartment($id_apartement, $place, $address, $complement_address, $availability, $price_night, $area) {
        $apartmentRepository = new ApartmentRepository();
        if ($apartmentRepository->updateApartment($id_apartement, ["place", "address", "complement_address", "availability", "price_night", "area"], [$place, $address, $complement_address, $availability, $price_night, $area]))
        {
            return $apartmentRepository->getApartment($id_apartement);
        }
        exit_with_message('Updated ok, failed to retrieve the apartment updated');
    }

    
  	// Met à jour la disponibilte d'un appartement
    public function updateApartmentAvail($id_apartement, $availability) {
        // Validation
        if ($availability != true && $availability != false)
        {
            exit_with_message("You need to have a boolean to update the availability of the apartment");
        }
        $apartmentRepository = new ApartmentRepository();

        $apartmentRepository->updateApartment($id_apartement, ["availability"], [$availability]);
        return $apartmentRepository->getApartment($id_apartement);
    }
    


    //Supprime un appartement
    public function deleteApartment($id_apartement) {
        $apartmentRepository = new ApartmentRepository();
        $apartmentRepository->unreferenceApartment($id_apartement);
        return;
    }

}


?>

