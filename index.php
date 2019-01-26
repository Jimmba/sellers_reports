<?php
//header('Content-Type:text/html; charset=utf-8');
include_once($_SERVER['DOCUMENT_ROOT']."/service/Sessions.php");
$session = new Sessions();
$session->startSession();

if ( $_SESSION['authorisied']==true){
    include('service/Controller.php');
    $controller = new Controller();
    $controller->run();
}else{
    include_once($_SERVER['DOCUMENT_ROOT']."/authorisation/authorisation.php");
}

/*include('service/Controller.php');
$controller = new Controller();
$controller->run();*/
?>