<?php
include_once './BDD.php';
include_once '../Models/apartementModel.php';
include_once '../exception.php';

class ApartmentRepository {
    private $connection = null;

    // I'm not sure about this function lol (unuse)
    function __construct() {
        try {
            $this->connection = pg_connect("host=restpastropapi-database-1 port=5432 dbname=apiDev_db user=apiDev password=password");
            if (  $this->connection == null ) {
                throw new BDDException("Could not connect to database.");
            }
        } catch (Exception $e) {
            throw new BDDException("Could not connect db: ". $e->getMessage());
        }
    }
    //-------------------------------------

    public function getApartments(){
        $apartArray = selectDB("APARTMENT", "*");

        $apart = [];
        $apartTest = [];

        for ($i=0; $i < count($apartArray); $i++) { 
            $apartTest[$i] = new ApartementModel($apartArray[$i]['id_apartement'], $apartArray[$i]['place'], $apartArray[$i]['address'], $apartArray[$i]['complement_address'], $apartArray[$i]['availability'], $apartArray[$i]['price_night'], $apartArray[$i]['area'], $apartArray[$i]['id_users'])
        }

        return $apartTest;
    }

    public function getApartment($id){

        $apart = selectDB("APARTMENT", "*", "id_apartement=".$id);

        return new ApartementModel($apartArray[0]['id_apartement'], $apartArray[0]['place'], $apartArray[0]['address'], $apartArray[0]['complement_address'], $apartArray[0]['availability'], $apartArray[0]['price_night'], $apartArray[0]['area'], $apartArray[0]['id_users']);
    }

    public function deleteApartment($id){
        deleteDB("APARTEMENT", "id_apartement=".$id);
    }

    
    public function addApartment(ApartmentModel $apartment){
        insertDB("APARTMENT", ["place", "address", "complement_address", "availability", "price_night", "area", "id_users"], [$apartment->place, $apartment->address, $apartment->complement_address, $apartment->availability, $apartment->price_night, $apartment->area, $apartment->id_users]);

        return getApartment($apartment->id_apartement);
    }

    
    public function updateApartment($id, $colunm, $values){
        
        updateDB("APARTMENT", $colunm, $values, "id_apartement=".$id);

        return getApartment($apartment->id_apartement); 
    }
}


?>