
<?php
include_once './Models/apartmentService.php';

function appartement_controller($uri) {
    $apartementService = new ApartementService();
    
    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            apartment_get($uri, $apartementService);
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