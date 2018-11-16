<?php

/**
 * Created by PhpStorm.
 * User: gimvit
 * Date: 02.10.2018
 * Time: 11:20
 */
class arrayOptionsModal{
    private $db;
    private $value;

    function getArray($value, $num){
        $html="";
        $this->value=$value;
        $this->db = new DataBase();
        $this->db->init();
        if ($value == "mag"){
            $query = "SELECT mags.idmag, mags.magname FROM mags order by magname";
        }
        if ($value == "prod"){
            $query = "SELECT sotrudniki.id_prod, sotrudniki.name, sotrudniki.surname FROM sotrudniki WHERE sotrudniki.is_prodavec = 1 ORDER BY surname, name  ";
        }
        if ($value == "sotr"){
            $query = "SELECT sotrudniki.id_prod, sotrudniki.name, sotrudniki.surname  FROM sotrudniki ORDER BY id_prod";
        }
        $this->db->setQuery($query);
        $result = $this->db->doQuery();
        $rows = mysqli_num_rows($result);
        for($i=0; $i<$rows; $i++) {
            $data = mysqli_fetch_row($result);
            if ($num == $data[0]) {
                $html .= "<option selected value = \"$data[0]\">$data[1]</option>";
            }else{
                $html .= "<option value = \"$data[0]\">$data[1]</option>";
            }
        }
        return $html;
    }
    function getIdByName($name){
        $db = new DataBase();
        $db->init();
        $query = "SELECT sotrudniki.id_prod FROM sotrudniki WHERE sotrudniki.name = \"$name\"";
        $db->setQuery($query);
        return mysqli_fetch_row($db->doQuery())[0];
    }
}