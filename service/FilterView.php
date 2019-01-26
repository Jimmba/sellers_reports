<?php

/**
 * Created by PhpStorm.
 * User: gimvit
 * Date: 14.10.2018
 * Time: 16:20
 */
class FilterView{
    private $data;
    private $filterModel;
    private $inputDateFrom;
    private $inputDateTo;
    private $inputMags;
    private $inputProds;
    private $money;

    function __construct($model){
        //include_once($_SERVER['DOCUMENT_ROOT'] . "/service/FilterModel.php");
        //$this->filterModel=new Model();
        $this->filterModel = $model;
    }

    function init(){
//        include_once($_SERVER['DOCUMENT_ROOT']."/service/FilterModel.php");
        include_once ($_SERVER['DOCUMENT_ROOT']."/service/ArrayOptionsModal.php");
        $m = new ArrayOptionsModal();
        if ($_SESSION["permissions"]=="user"){
            $prod = $_SESSION["prod"];
        }
        $mags=$m->getArray("mag",$mag);
        $sotr=$m->getArray("prod",$prod);
        $this->inputDateFrom = $this->getFromData();
        $this->inputDateTo = $this->getToData();
        $this->inputProds = $this->getProdData($sotr);

        include_once($_SERVER['DOCUMENT_ROOT'] . "/service/Money.php");
        $this->money = new Money();
        $this->money = $this->money->getResult();

        $this->getView($mags, $sotr);


    }

    /**
     * @return mixed
     */

    function getView($mags,$sotr){
        $this->data="
            <div class=\"row pickers\">
                <div class=\"col-xl-6 col-lg-6 col-md-6 col-sm-9 col-xs-10 pickers-coloumn\">
                    <div class=\"row date-picker\" id=\"date-picker\">
                        <div class=\"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12\">
                            <div class=\"input-group mb-3\">
                                <div class=\"input-group-prepend\">
                                    <label class=\"input-group-text\" for=\"start-date\">
                                        <b>от</b>
                                    </label>
                                </div>
                                $this->inputDateFrom
                            </div>
                        </div>
                        <div class=\"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12\">
                            <div class=\"input-group mb-3\">
                                <div class=\"input-group-prepend\">
                                    <label class=\"input-group-text\" for=\"end-date\">
                                        <b>до</b>
                                    </label>
                                </div>
                                $this->inputDateTo
                            </div>
                        </div>
                    </div>
                    <div class=\"row seller-picker\" id=\"seller-picker\">
                        <div class=\"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12\">
                            <div class=\"input-group mb-3\">
                                <div class=\"input-group-prepend\">
                                    <label class=\"input-group-text\" for=\"seller\">
                                        <i class=\"fas fa-user\"></i>
                                    </label>
                                </div>
                                $this->inputProds
                            </div>
                        </div>
                        <div class=\"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12\">
                            <div class=\"input-group mb-3\">
                                <div class=\"input-group-prepend\">
                                    <label class=\"input-group-text\" for=\"building\">
                                        <i class=\"fas fa-building\"></i>
                                    </label>
                                </div>
                                <select class=\"custom-select\" id=\"building\">
                                    <option selected>Все магазины...</option>
                                        $mags
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
               
               
                <div class=\"col-xl-6 col-lg-6 col-md-6 col-sm-3 col-xs-2 log-out\">
                    <button type=\"button\" class=\"btn btn-danger log-out-button\" id=\"logout\">
                        <i class=\"fas fa-sign-out-alt\"></i>
                        <span>Выйти</span>
                    </button>
                    <div>
                        <button type=\"button\" class=\"btn btn-info active\">Остаток денежных средств: 
                            <span class=\"badge badge-light\" id=\"money\">$this->money</span>
                        </button>
                    </div>
                </div>
            </div>
         ";
    }


    public function getData(){
        return $this->data;
    }
    private function getFromData(){
        $dateFrom=$_SESSION["dateFrom"];
        if ($_SESSION["permissions"]=="user"){
            $text = "<input type=\"date\" disabled class=\"form-control\" id=\"start-date\" name=\"start-date\" placeholder=\"Дата начала\" value =\"$dateFrom\" required>";
        }else{
            $text = "<input type=\"date\" class=\"form-control\" id=\"start-date\" name=\"start-date\" placeholder=\"Дата начала\" value =\"$dateFrom\" required>";
        }
        return $text;
    }
    private function getToData(){
        $dateTo=$_SESSION["dateTo"];
        if ($_SESSION["permissions"]=="user"){
            $text="<input type=\"date\" disabled class=\"form-control\" id=\"end-date\" name=\"end-date\" placeholder=\"Дата окончания\" value =\"$dateTo\"required>";
        }else{
            $text="<input type=\"date\" class=\"form-control\" id=\"end-date\" name=\"end-date\" placeholder=\"Дата окончания\" value =\"$dateTo\"required>";
        }
        return $text;
    }
    private function getProdData($sotr){
        $text="
            <select class=\"custom-select\" id=\"seller\">
                <option selected>Все продавцы...</option>
                $sotr
            </select>";
        if ($_SESSION["permissions"]=="user") {
            $user = $_SESSION["prod"];
            $text = "
                <select disabled class=\"custom-select\" id=\"seller\">
                <option selected>$user</option>
                </select>";
        }
        return $text;
    }
}