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

        if(selectDB("APARTMENT", "*", "id_apartement=".$id." AND apartment_index=1", "bool")){
            $apart = selectDB("APARTMENT", "*", "id_apartement=".$id." AND apartment_index=1", "-@");
        }
        else{
            exit_with_message("The apart is unreferenced");
        }

        return new ApartmentModel($apart[0]['id_apartement'], $apart[0]['place'], $apart[0]['address'], $apart[0]['complement_address'], $apart[0]['availability'], $apart[0]['price_night'], $apart[0]['area'], $apart[0]['id_users'], $apart[0]['apartment_index']);
    }

    public function unreferenceApartment($id, $apikey){

        $role = getRoleFromApiKey($apikey);

        $iduser = selectDB("USERS", "id_users", "apikey='".$apikey."'")[0]["id_users"];

        if(!selectDB("APARTMENT", "id_users", "id_users='".$iduser."'", "bool") && $role > 3)
        {
            exit_with_message("You can't unreference an apartment if you're not the owner or a modo or an admin");
        }


        if(selectDB("APARTMENT", "*", "id_apartement=".$id." AND apartment_index=1 AND id_users=".$iduser, "bool")){
            if (updateDB("APARTMENT", ['apartment_index'], [-1], "id_apartement=".$id)){
                exit_with_message("Unreferencement successful");
            }
            exit_with_message("Failed to delete");
        }
        else{
            exit_with_message("This apartment doesn't exist or is already unreferenced.. / You can't unreferenced an apartment, if your not the owner of it");
        }
        exit_with_message("This apartment doesn't exist or is already unreferenced..");
        
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

    
    public function updateApartment($id_apartement, $colunm, $values, $apikey){
        
        $role = getRoleFromApiKey($apikey);

        if ($role > 2){
            if (selectDB("USERS", 'id_users', "apikey='".$apikey."'", "bool"))
            {
                $iduser = selectDB("USERS", 'id_users', "apikey='".$apikey."'", "bool")[0]['id_users'];
                if(!selectDB('APARTMENT', 'id_users', "id_apartement=".$id_apartement." AND id_users=".$iduser, "bool"))
                {
                    exit_with_message("It's not your apart..");
                }
            }
            else{
                exit_with_message("It's not your apart..");
            }

            if (updateDB("APARTMENT", $colunm, $values, "id_apartement=".$id_apartement)){

                return true;
            }
        }
        

        
        if (updateDB("APARTMENT", $colunm, $values, "id_apartement=".$id_apartement)){

            return true;
        }
        exit_with_message("Updated failed");
        

        
    }
}


?>