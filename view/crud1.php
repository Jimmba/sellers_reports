<?php
/**
 * Created by PhpStorm.
 * User: gimvit
 * Date: 02.10.2018
 * Time: 14:47
 */
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
        $prod = $_SESSION['dateTo'];
    }


    require_once ("Database.php");
    require_once ("arrayOptionsModal.php");
    /* сделать hidden action/modal */

    $db = new DataBase();
    $db->init();
    if (isset($_POST['modal']) && ($_POST['modal'])!= null){
        $modalAction = ($_POST['modal']);
        require_once ("modal.php");
        $modal = new Modal();
        echo $modal->init($modalAction);
    }else{
        if (isset($_POST['action']) && ($_POST['action'])!= null) {
            $action = ($_POST['action']);
        }
        if ($action == "add") {
            //Добавление данных в БД
            $date = $_POST['date'];
            $mag = $_POST['mag'];
            $prod = $_POST['prod'];
            $sum = $_POST['sum'];
            $nachto = $_POST['nachto'];
            include_once ("idDsm.php");//Получаем idDsm, если его нет - создаем.
            $dsm = new idDsm($date, $prod, $mag);
            $dsm = $dsm->getId();
            $db->setQuery("Insert into rashod values (\"null\", \"$dsm\", \"$sum\", \"$nachto\")");
            $db->doQuery();
        }
        if ($action == "delete") {
            //Удаление данных в БД
            $id = $_POST['id'];
            $db->setQuery("DELETE FROM rashod WHERE id_rashod = $id");
            $result = $db->doQuery();
        }

        if ($action == "change") {
            //Добавление данных в БД
            $id = $_POST['id'];
            $date = $_POST['date'];
            $mag = $_POST['mag'];
            $prod = $_POST['prod'];
            $sum = $_POST['sum'];
            $nachto = $_POST['nachto'];
            include_once ("idDsm.php");//Получаем idDsm, если его нет - создаем.
            $dsm = new idDsm($date, $prod, $mag);
            $dsm = $dsm->getId();
            $db->setQuery("Update rashod SET dsm_id_dsm=$dsm, rashod(x100)=$sum WHERE id_rashod = $id");
            $db->doQuery();
        }

    }
?>