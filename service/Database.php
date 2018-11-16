<?php

/**
 * Created by PhpStorm.
 * User: gimvit
 * Date: 03.02.2018
 * Time: 1:51
 */
class DataBase {
    private $link;
    private $query;
    private $queryResult;
    private $error;

    function init(){
        require($_SERVER['DOCUMENT_ROOT']."/service/connection.php");
        try{
            $this->link = mysqli_connect($host, $user, $password, $database);
            if ($this->link == false){
                $this->error="Ошибка подключения к базе данных\r\n";
            }
        }catch (Exception $e){
            $this->error.="Ошибка подключения к базе данных";
        }
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }
    public function setQuery($query){
        $this->query = $query;
    }

    public function getQuery(){
        return $this->query;
    }

    function doQuery(){
        try{
            $this->queryResult = mysqli_query($this->link, $this->query);
            if ($this->queryResult==false){
                $this->error.= "Ошибка выполнения запроса.\r\n";
            }
            return $this->queryResult;
        }catch(Exception $e){
            $this->error.= "Ошибка выполнения запроса.\r\n";
        }
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

}
?>