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
    if (isset($_SESSION['sumTotal'])&&(!empty($_SESSION['sumTotal']))){
        $_POST['sumTotal']= $_SESSION['sumTotal'];
        //Удалить переменную сесиии
        unset($_SESSION['sumTotal']);
    }
    if (isset($_SESSION['sumTotal'])&&(!empty($_SESSION['sumTotal']))){
        $_POST['sumTotal']= $_SESSION['sumTotal'];
        //Удалить переменную сесиии
        unset($_SESSION['sumTotal']);
    }
    if (isset($_SESSION['opisanie'])&&(!empty($_SESSION['opisanie']))){
        $_POST['opisanie']= $_SESSION['opisanie'];
        //Удалить переменную сесиии
        unset($_SESSION['opisanie']);
    }
    if (isset($_SESSION['sumPredopl'])&&(!empty($_SESSION['sumPredopl']))){
        $_POST['sumPredopl']= $_SESSION['sumPredopl'];
        //Удалить переменную сесиии
        unset($_SESSION['sumPredopl']);
    }

    if (isset($_SESSION['id'])&&(!empty($_SESSION['id']))){
        $id= $_SESSION['id'];
        //Удалить переменную сесиии
        unset($_SESSION['id']);
    }


    if (isset($_SESSION['sumOstatok'])&&(!empty($_SESSION['sumOstatok']))){
        $_POST['sumOstatok']= $_SESSION['sumOstatok'];
        //Удалить переменную сесиии
        unset($_SESSION['sumOstatok']);
    }else{
        $_POST['sumOstatok']=0;
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
        echo $modal->init($modalAction, "prihody/predoplata");
    }else{
        if (isset($_POST['action']) && ($_POST['action'])!= null) {
            $action = ($_POST['action']);
        }
        if ($action == "add") {
            //Добавление данных в БД
            $date = $_POST['date'];
            $mag = $_POST['mag'];
            $prod = $_POST['prod'];
            $sumTotal = $_POST['sumTotal']*100;
            $sumPredopl = $_POST['sumPredopl']*100;
            $opisanie = $_POST['opisanie'];
            include_once ($_SERVER['DOCUMENT_ROOT']."/service/idDsm.php");//Получаем idDsm, если его нет - создаем.
            $dsm = new idDsm($date, $prod, $mag);
            $dsm = $dsm->getId();

            if ($_POST['sumOstatok']==0){
                //Добавляем новую строку
                $id=null;
                $dsm_ostatok=0;
                $pogasheno = 0;
                $query = "Insert INTO prihPredoplata values (?,?,?,?,?,?,?,?)";
                $data = array($id, $dsm, $opisanie, $prod, $sumPredopl, $sumTotal, $pogasheno, $dsm_ostatok);
                $STH=$DBH->prepare($query);
                $STH->execute($data);
            }else{
                //Закрываем предоплату
                // $id=$id;
                $pogasheno=$_POST['sumOstatok']*100;
                $dsm_ostatok=$dsm;
                //$query = "UPDATE prihPredoplata SET dsm_id_dsm=?, opisanie=?, id_prod = ?, `predoplata(x100)`=?, `vsego_k_oplate(x100)`= ?, `pogasheno(x100)` = ?, dsm_ostatok = ? WHERE idprih=?";
                //$data = array($dsm, $opisanie, $prod, $sumPredopl, $sumTotal, $pogasheno, $id, $dsmClose);
                $query = "UPDATE prihPredoplata SET `pogasheno(x100)` = ?, dsm_ostatok = ? WHERE idprih=?";
                $data = array($pogasheno, $dsm_ostatok, $id);
                $STH=$DBH->prepare($query);
                $STH->execute($data);
            }
        }
        if ($action == "delete") {
            //Удаление данных в БД
            $id = $_POST['id'];
            $db->setQuery("DELETE FROM prihPredoplata WHERE idprih = $id");
            $result = $db->doQuery();

        }

        if ($action == "change") {
            //Добавление данных в БД
            $id = $_POST['id'];
            $date = $_POST['date'];
            $mag = $_POST['mag'];
            $prod = $_POST['prod'];
            $sumTotal = $_POST['sumTotal']*100;
            $sumPredopl = $_POST['sumPredopl']*100;
            $opisanie = $_POST['opisanie'];
            $pogasheno = 0;
            include_once ($_SERVER['DOCUMENT_ROOT']."/service/idDsm.php");//Получаем idDsm, если его нет - создаем.
            $dsm = new idDsm($date, $prod, $mag);
            $dsm = $dsm->getId();
            /*$db->setQuery("Update rashod SET dsm_id_dsm=\"$dsm\", `rashod(x100)`=\"$sum\", kuda=\"$nachto\" WHERE id_rashod = \"$id\"");
            //$db->setQuery("UPDATE rashod SET dsm_id_dsm = 13, `rashod(x100)` = 121212, kuda = '11 патриот Дима' WHERE id_rashod = 12");
            $db->doQuery();*/

            $query = "UPDATE prihPredoplata SET dsm_id_dsm=?, opisanie=?, id_prod = ?, `predoplata(x100)`=?, `vsego_k_oplate(x100)`= ?, `pogasheno(x100)` = ? WHERE idprih=?";
            $data = array($dsm, $opisanie, $prod, $sumPredopl, $sumTotal, $pogasheno, $id);
            $STH=$DBH->prepare($query);
            $STH->execute($data);
        }

    }
?>