<?php

/**
 * Created by PhpStorm.
 * User: gimvit
 * Date: 08.10.2018
 * Time: 12:52
 */
class Modal{
public $data;
    function init($modalAction,$path){
        include_once($_SERVER['DOCUMENT_ROOT'] . "/service/Sessions.php");
        $session = new Sessions();
        $session->startSession();
        require_once($_SERVER['DOCUMENT_ROOT'] . "/service/Database.php");
        $db = new DataBase();
        $db->init();

        require_once ($_SERVER['DOCUMENT_ROOT']."/model/$path/modalForm.php");
        if ($modalAction =="add"){
            $modal = new ModalForm("add", null);
            $this->data=$modal->getModalForm();
        }
        if ($modalAction =="change"){
            $id = ($_POST['id']);
            $modal = new ModalForm("change", $id);
            $this->data=$modal->getModalForm();
        }
        return $this->data;
    }

}