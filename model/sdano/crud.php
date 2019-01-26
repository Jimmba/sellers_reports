<?php
/**
 * Created by PhpStorm.
 * User: gimvit
 * Date: 02.10.2018
 * Time: 14:47
 */


    include_once($_SERVER['DOCUMENT_ROOT']."/service/Sessions.php");
    $session = new Sessions();
    $session->startSession();
    /*Проверяем, нужно ли фильтровать данные*/
    if (isset($_SESSION['prod'])&&(!empty($_SESSION['prod']))){
        $prod = $_SESSION['prod'];
    }
    if (isset($_SESSION['mag'])&&(!empty($_SESSION['mag']))){
        $mag= $_SESSION['mag'];
    }
    if (isset($_SESSION['dateFrom'])&&(!empty($_SESSION['dateFrom']))){
        $dateFrom = $_SESSION['dateFrom'];
    }
    if (isset($_SESSION['dateTo'])&&(!empty($_SESSION['dateTo']))){
        $dateTo = $_SESSION['dateTo'];
    }


    require_once ($_SERVER['DOCUMENT_ROOT']."/service/Database.php");
    require_once ($_SERVER['DOCUMENT_ROOT']."/service/arrayOptionsModal.php");
    /* сделать hidden action/modal */

    $db = new DataBase();
    $db->init();

    require($_SERVER['DOCUMENT_ROOT']."/service/connection.php");
    $DBH = new PDO("mysql:host =$host;dbname=$database",$user,$password);


    if (isset($_POST['modal']) && ($_POST['modal'])!= null){
        $modalAction = ($_POST['modal']);
        require_once($_SERVER['DOCUMENT_ROOT'] . "/service/Modal.php");
        $modal = new Modal();
        echo $modal->init($modalAction, "sdano");
    }else{
        if (isset($_POST['action']) && ($_POST['action'])!= null) {
            $action = ($_POST['action']);
        }
        if ($action == "add") {
            //Добавление данных в БД
            $date = $_POST['date'];
            $mag = $_POST['mag'];
            $prod = $_POST['prod'];
            $sum = $_POST['sum']*100;
            include_once ($_SERVER['DOCUMENT_ROOT']."/service/idDsm.php");//Получаем idDsm, если его нет - создаем.
            $dsm = new idDsm($date, $prod, $mag);
            $dsm = $dsm->getId();
            $id=null;
            $query = "Insert INTO ostatki values (?,?,?)";
            $data = array($id, $dsm, $sum);
            $STH=$DBH->prepare($query);
            $STH->execute($data);
        }
        if ($action == "delete") {
            //Удаление данных в БД
            $id = $_POST['id'];
            $db->setQuery("DELETE FROM ostatki WHERE id_ostatki = $id");
            $result = $db->doQuery();

        }

        if ($action == "change") {
            //Добавление данных в БД
            $id = $_POST['id'];
            $date = $_POST['date'];
            $mag = $_POST['mag'];
            $prod = $_POST['prod'];
            $sum = $_POST['sum']*100;
            include_once ($_SERVER['DOCUMENT_ROOT']."/service/idDsm.php");//Получаем idDsm, если его нет - создаем.
            $dsm = new idDsm($date, $prod, $mag);
            $dsm = $dsm->getId();

            $query = "UPDATE ostatki SET dsm_id_dsm=?, `sdano(x100)`=? WHERE id_ostatki=?";
            $data = array($dsm, $sum, $id);
            $STH=$DBH->prepare($query);
            $STH->execute($data);
        }

    }
?>