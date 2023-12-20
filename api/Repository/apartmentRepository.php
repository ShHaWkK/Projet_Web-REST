<?php
include_once './Repository/BDD.php';
include_once './Models/apartmentModel.php';
include_once './exceptions.php';

class ApartmentRepository {
    private $connection = null;

    // I'm not sure about this function lol (unuse)
    function __construct() {

    }
    //-------------------------------------

    public function getApartments(){
        $apartArray = selectDB("APARTMENT", "*", "apartment_index=1");

        $apart = [];
        $apartTest = [];

        for ($i=0; $i < count($apartArray); $i++) { 
            $apartTest[$i] = new ApartmentModel($apartArray[$i]['id_apartement'], $apartArray[$i]['place'], $apartArray[$i]['address'], $apartArray[$i]['complement_address'], $apartArray[$i]['availability'], $apartArray[$i]['price_night'], $apartArray[$i]['area'], $apartArray[$i]['id_users'], $apartArray[$i]['apartment_index']);
        }

        return $apartTest;
    }

    public function getApartment($id){

        $apart = selectDB("APARTMENT", "*", "id_apartement=".$id." AND apartment_index=1");

        return new ApartmentModel($apart[0]['id_apartement'], $apart[0]['place'], $apart[0]['address'], $apart[0]['complement_address'], $apart[0]['availability'], $apart[0]['price_night'], $apart[0]['area'], $apart[0]['id_users'], $apart[0]['apartment_index']);
    }

    public function unreferenceApartment($id){
        if(selectDB("APARTMENT", "*", "id_apartement=".$id." AND apartment_index=1", "bool")){
            if (updateDB("APARTMENT", ['apartment_index'], [-1], "id_apartement=".$id)){
                exit_with_message("Unreferencement successful");
            }
            exit_with_message("Failed to delete");
        }
        exit_with_message("This apartment doesn't exist or is already unreferenced..");
        
        exit();
        
    }

    
    public function addApartment(ApartmentModel $apartment){
        if ($apartment->apartment_index != 1){
            exit_with_message("You can't add a new unreferenced apartment");
        }
        insertDB("APARTMENT", ["place", "address", "complement_address", "availability", "price_night", "area", "id_users", "apartment_index"], [$apartment->place, $apartment->address, $apartment->complement_address, $apartment->availability, $apartment->price_night, $apartment->area, $apartment->id_users, $apartment->apartment_index]);

        //SELECT * FROM APARTMENT WHERE id_apartment = (SELECT MAX(id_apartment) FROM APARTMENT WHERE id_users = 'your_user_id');
        $maxID = selectDB('APARTMENT', 'MAX("id_apartement")', "id_users=".$apartment->id_users)[0]['max'];
        return selectDB('APARTMENT', '*', "id_apartement=".$maxID);
    }

    
    public function updateApartment($id_apartement, $colunm, $values){

        // var_dump($colunm);
        // var_dump($values);
        //exit();
        
        
        if (updateDB("APARTMENT", $colunm, $values, "id_apartement=".$id_apartement)){

            return true;
            //exit_with_message("Updated successful");
        }
        exit_with_message("Updated failed");
        

        
    }
}


?>