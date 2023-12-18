
<?php
include_once './Service/apartmentService.php';

function apartmentController($uri) {
    $apartementService = new ApartmentService($uri);

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

            exit_with_content($apartementService->addApartment(null, $data['place'], $data['address'], $data['complement_address'], $data['availability'], $data['price_night'], $data['area'], $data['id_users']));
            break;


        // Update apartment
        case 'PUT':
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);

            exit_with_content($apartementService->updateApartment($data['id_apartement'], $data['place'], $data['address'], $data['complement_address'], $data['availability'], $data['price_night'], $data['area']));
            break;


        // Update the availability of the apartment
        case 'PATCH':

            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);

            exit_with_content($apartementService->updateApartmentAvail($data["id_apartment"], $data["availability"]));
            break;


        // Delete the apartment
        case 'DELETE':
            if($uri[3]){
                exit_with_content($apartementService->deleteApartment($uri[3]));
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