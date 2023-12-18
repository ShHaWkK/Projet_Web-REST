
<?php
include_once './Service/apartmentService.php';

function apartmentController($uri) {
    $apartementService = new ApartmentService($uri);

    switch($_SERVER['REQUEST_METHOD']) {

        case 'GET':

            if($uri[3]){
                exit_with_content($apartementService->getApartmentById($uri[3]));
            }
            else{
                exit_with_content($apartementService->getAllApartments());
            }
            
            break;

        case 'POST':
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);

            exit_with_content($apartementService->addApartment($data['id_apartement'], $data['place'], $data['address'], $data['complement_address'], $data['availability'], $data['price_night'], $data['area'], $data['id_users']));
            break;


        case 'PUT':
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);

            exit_with_content($apartementService->updateApartment($data['id_apartement'], $data['place'], $data['address'], $data['complement_address'], $data['availability'], $data['price_night'], $data['area'], $data['id_users']));
            break;


        case 'PATCH':

            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);

            exit_with_content($apartementService->updateApartmentAvail($data["id_apartment"], $data["availability"]));
            break;


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