<?php
include_once($_SERVER['DOCUMENT_ROOT']."/service/Sessions.php");
$session = new Sessions();
$session->startSession();

include_once($_SERVER['DOCUMENT_ROOT']."/service/Auth.php");
$auth = new Auth();
$action = $auth->getAction();
$result = $auth->$action();
echo $result;
?>