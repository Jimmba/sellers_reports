<?php

/**
 * Created by PhpStorm.
 * User: gimvit
 * Date: 14.10.2018
 * Time: 16:08
 */
class FilterModel{
    private $dateFrom;
    private $dateTo;
    private $prod;
    function init(){
        include_once($_SERVER['DOCUMENT_ROOT']."/service/Auth.php");
        $auth = new Auth();
        $auth->init();
        $authName = $auth->getAuthName();
        $authId = $auth->getAuthId();
        $authPermissions = $auth->getPermissions();
        require_once ($_SERVER['DOCUMENT_ROOT']."/service/Database.php");
        $db = new DataBase();
        $db->init();

        require_once ($_SERVER['DOCUMENT_ROOT']."/service/arrayOptionsModal.php");
        /*
         * вё сессию записываем даты (с начала месяца до сегодня для админа и только сегодня для юзера
         * для юзера устанавливаем его имя пользователя в фильтре
         * дальше обработкой сессии занимается sessionsFilter
         */
        $this->dateTo= date("Y-m-d");
        if (!isset($_SESSION['prod'])&& $authPermissions=="user"){
            $_SESSION['prod']=$authName;
        }
        if ($authPermissions=="user"){
            $this->dateFrom= date("Y-m-d");
            $this->prod= $auth->getAuthName();
        }else{
            $this->dateFrom=date("Y-m-01");
        }
        $_SESSION['dateTo']=$this->dateTo;
        $_SESSION['dateFrom']=$this->dateFrom;
    }
}