
<?php
include_once './Service/apartmentService.php';

function apartmentController($uri) {
    $apartementService = new ApartmentService($uri);
    
    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            exit_with_content($apartementService->getAllApartments());
            //apartment_get($uri, $apartementService);
            break;

        case 'POST':
            apartment_post($uri, $apartementService);
            break;

        case 'PATCH':
            apartment_patch($uri, $apartementService);
            break;

        case 'DELETE':
            apartment_delete($uri, $apartementService);
            break;

        default:        
            header("HTTP/1.1 200 OK");
            exit();
    }
}
?>