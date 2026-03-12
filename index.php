<?php
     /**
     * @author : Gaellan
     * @link : https://github.com/Gaellan
     */
    
    session_start();
    
    require "config/autoload.php";
    
    if(!isset($_SESSION["token"])){
        $csrfManager = new CSRFTokenManager();
        $csrf = $csrfManager -> generateCSRFToken();
        $_SESSION["token"] = $csrf;
    }
    
    
    // var_dump($_SESSION);
    
    $router = new Router();
    
    $router->handleRequest($_GET);

?>