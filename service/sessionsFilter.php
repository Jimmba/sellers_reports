<?php
/**
 * Created by PhpStorm.
 * User: gimvit
 * Date: 14.10.2018
 * Time: 11:24
 */
    class sessionsFilter{
        private $prod;
        private $mag;
        private $dateFrom;
        private $dateTo;

        function __construct(){
            if (isset($_SESSION['prod'])&&(($_SESSION['prod'])!="Все продавцы...")){
                $this->prod = $_SESSION['prod'];
            }else{
                $this->prod = "*";//Для выборки из БД
            }
            if (isset($_SESSION['mag'])&&(($_SESSION['mag'])!="Все магазины...")){
                $this->mag= $_SESSION['mag'];
            }else{
                $this->mag= "*";
            }
            if (isset($_SESSION['dateFrom'])&&(!empty($_SESSION['dateFrom']))){
                $this->dateFrom = $_SESSION['dateFrom'];
            }else{
                $this->dateFrom= "01.10.2018";
            }
            if (isset($_SESSION['dateTo'])&&(!empty($_SESSION['dateTo']))){
                $this->dateTo = $_SESSION['dateTo'];
            }else{
                $this->dateTo = "31.12.2100";
            }
            $this->getSelectFilter();
        }
        function getSelectFilter(){
            $text = "WHERE ";
            if ($this->prod!="*"){
                $text.= "sotrudniki.name = \"$this->prod\" AND ";
            }
            if ($this->mag!="*"){
                $text.= "mags.magname = \"$this->mag\" AND ";
            }
            $text.= "dsm.date BETWEEN \"$this->dateFrom\" AND \"$this->dateTo\"";
            return $text;
        }
    }
?>