<?php
include_once($_SERVER['DOCUMENT_ROOT']."/service/Sessions.php");
$session = new Sessions();
$session->startSession();
$session->destroySession();
?>

