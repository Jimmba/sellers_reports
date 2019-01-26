<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/service/Sessions.php");
    $session = new Sessions();
    $session->startSession();
    include_once($_SERVER['DOCUMENT_ROOT'] . "/service/Money.php");
    $money = new Money();
    $money = $money->getResult();
    echo $money;
?>