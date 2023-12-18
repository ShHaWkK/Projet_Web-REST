
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
            apartment_post($uri, $apartementService);
            break;

        case 'PATCH':
            apartment_patch($uri, $apartementService);
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