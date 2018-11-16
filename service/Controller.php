<?php

/**
 * Created by PhpStorm.
 * User: gimvit
 * Date: 11.02.2018
 * Time: 16:37
 */
class Controller{
    private $controller;
    private $model;
    public function run(){//Принимает данные, анализирует их и передает дальше

        //echo 'MainController init<br>';
        include_once("service/MainModel.php");



        $this->model = new MainModel();
        $this->model->init();
        if ($error = $this->model->getError()){//Реализовать обработчик ошибок
            var_dump($error);
        }else{
            //view($data, $number, $pagesCount);
            include_once ("service/MainView.php");
            $this->view = new MainView();
            //$this->view->init($this->model->getContent(),$this->model->getMethod());
            $this->view->init($this->model->getData(),$this->model->getMethod());
            //echo $this->model->getMethod();
            $this->view->viewData();
        }
    }


}