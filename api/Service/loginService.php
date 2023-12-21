<?php
include_once './Repository/loginRepository.php';

class LoginService {
    
    public $uri;

    public function __construct($uri)
    {       
        $this->uri = $uri;
    }

    public function getApiKey($username, $password) {
        $loginRepository = new loginRepository();
        return $loginRepository->getPersonnalApiKey($username, $password);
    }
    
}
?>
