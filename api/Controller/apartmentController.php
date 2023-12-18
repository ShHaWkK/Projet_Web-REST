<?php

function apartmentController($uri){
    if ($uri === '/list-apartments') {
        listApartments();
    } elseif ($uri === '/view-apartment') {
        $apartmentId = $_GET['id'];
        viewApartment($apartmentId);
    } elseif ($uri === '/create-apartment') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        createApartment($name, $description, $price);
    } elseif ($uri === '/update-apartment') {
        $apartmentId = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        updateApartment($apartmentId, $name, $description, $price);
    } elseif ($uri === '/delete-apartment') {
        $apartmentId = $_GET['id'];
        deleteApartment($apartmentId);
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "Page not found";
    }
}
/*
 * Récupère tous les appartements
 */
function listApartments() {
	$apartmentService = new ApartmentService();
	$apartments = $apartmentService->getAllApartments();
	echo json_encode($apartments);
}

/*
 * Récupère un appartement par son id
 */
function viewApartment($apartmentId) {
	$apartmentService = new ApartmentService();
	$apartment = $apartmentService->getApartmentById($apartmentId);
	echo json_encode($apartment);
}

/*
 * Créer un appartement
 */

function createApartment($name, $description, $price) {
	$apartmentService = new ApartmentService();
	$apartment = $apartmentService->createApartment($name, $description, $price);
	echo json_encode($apartment);
}

/*
 * Met à jour un appartement
 */

function updateApartment($apartmentId, $name, $description, $price) {
	$apartmentService = new ApartmentService();
	$apartment = $apartmentService->updateApartment($apartmentId, $name, $description, $price);
	echo json_encode($apartment);
}

/*
 * Supprime un appartement
 */
function deleteApartment($apartmentId) {
	$apartmentService = new ApartmentService();
	$apartment = $apartmentService->deleteApartment($apartmentId);
	echo json_encode($apartment);
}

?>
