<?php

/**
 * Created by PhpStorm.
 * User: gimvit
 * Date: 11.02.2018
 * Time: 19:50
 */
class MainModel{
    protected $data;
    private $method;
    private $error;

    public function init(){
        //echo 'MainModel init<br>';
        $this->data = "Главная страница. Сделать запрос к БД, выбрать поля";

    }
    public function getData(){            // Получаем данные о странице

        return $this->data;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getError()
    {
        return $this->error;
    }
}