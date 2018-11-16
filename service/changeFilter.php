<?php
include_once($_SERVER['DOCUMENT_ROOT']."/service/Sessions.php");
$session = new Sessions();
$session->startSession();

/**
 * Created by PhpStorm.
 * User: gimvit
 * Date: 09.10.2018
 * Time: 17:40
 */
    if (isset($_POST['filterType'])&&(!empty($_POST['filterType']))){
        $filterType = $_POST['filterType'];
        $value  = $_POST['value'];
        $_SESSION[$filterType]=$value;
        $page=$_SESSION['page'];
        //Временно, пока нет авторизации
        if($value=="Все продавцы..."){
            $_SESSION['id_prod']=null;
        }
    echo $page;//Возвращаем страницу, которую нужно перегрузить (например, rashody.php)
    }

/*    if (isset($_POST['prod'])&&(!empty($_POST['prod']))){
        $_SESSION['prod'] = $_POST['prod'];
    }
    if (isset($_POST['mag'])&&(!empty($_POST['mag']))){
        $_SESSION['mag']= $_POST['mag'];
    }
    if (isset($_POST['dateFrom'])&&(!empty($_POST['dateFrom']))){
        $_SESSION['dateFrom'] = $_POST['dateFrom'];
    }
    if (isset($_POST['dateTo'])&&(!empty($_POST['dateTo']))){
        $_SESSION['dateTo']= $_POST['dateTo'];
    }*/