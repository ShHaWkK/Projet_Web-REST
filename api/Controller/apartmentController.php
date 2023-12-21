
<?php
include_once './Service/apartmentService.php';

function apartmentController($uri, $apikey) {
    $apartementService = new ApartmentService($uri);
    
    if ($apikey == null && $_SERVER['REQUEST_METHOD'] != 'GET'){
        exit_with_message("You need to be connected to create, update or delete an apartment");
    }

    $role = getRoleFromApiKey($apikey);

    if ($role > 3 && $_SERVER['REQUEST_METHOD'] != 'GET'){
        exit_with_message("You need to be have an owner / moderator or admin account to create, update or delete an apartment");
    }   

    switch($_SERVER['REQUEST_METHOD']) {

        // Retrieve apartments
        case 'GET':

            if($uri[3]){
                exit_with_content($apartementService->getApartmentById($uri[3]));
            }
            else{
                exit_with_content($apartementService->getAllApartments());
            }
            
            break;


        // Create apartment
        case 'POST':
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);

            if (count($data) < 7){
                exit_with_message("Plz give at least the 6 args : place, address, complement_address, availability, price_night, area, id_user (owner)");
            }

            try{
                exit_with_content($apartementService->addApartment(null, $data['place'], $data['address'], $data['complement_address'], $data['availability'], $data['price_night'], $data['area'], $data['id_users']));
            }
            catch(err){
                exit_with_message("Plz give at least the 6 args : place, address, complement_address, availability, price_night, area");
            }
            break;


        // Update apartment
        case 'PUT':
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);

            if (isset($data['apartment_index']) && $data["apartment_index"] == -1){
                exit_with_message("You can't update the apartment index, user the DELETE methode to unreference it");
            }
            if (count($data) < 6){
                exit_with_message("Plz give at least the 6 args : place, address, complement_address, availability, price_night, area");
            }

            try{
                exit_with_content($apartementService->updateApartment($uri[3], $data['place'], $data['address'], $data['complement_address'], $data['availability'], $data['price_night'], $data['area']));
            }
            catch(err){
                exit_with_message("Plz give at least the 6 args : place, address, complement_address, availability, price_night, area");
            }

            break;


        // Update the availability of the apartment
        case 'PATCH':

            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);

            if(!isset($data["availability"])){
                exit_with_message("Plz give the availability of the apartment (boolean)");
            }

            exit_with_content($apartementService->updateApartmentAvail($uri[3], $data["availability"], $apikey));
            break;


        // Delete the apartment
        case 'DELETE':
            if($uri[3]){
                exit_with_content($apartementService->deleteApartment($uri[3], $apikey));
            }
            else{
                exit_with_message("ERROR : Plz specifie the id of the apartment you want to delete.");
            }
            
            break;


        default:        
            header("HTTP/1.1 200 OK");
            exit();
    }
}
?>