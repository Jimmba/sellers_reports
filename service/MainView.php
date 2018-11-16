<?php

/**
 * Created by PhpStorm.
 * User: gimvit
 * Date: 11.02.2018
 * Time: 16:40
 */
class MainView{
    private $data;
    private $method;
    function ViewData(){
        // Отображение данных.
        //echo 'MainView - viewdata()<br>';
        //echo $this->data;
        include("view/index.php");

    }
    function init($d, $m)
    {
        //echo 'init MainView<br>';
        $this->data = $d;
        $this->method = $m;
    }
    public function getData(){
        return $this->data;
    }

    public function getMethod()
    {
        return $this->method;
    }
}