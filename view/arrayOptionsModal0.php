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
    private $html;

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
        if ($num==null){$first=true;}
        for($i=0; $i<$rows; $i++) {
            $data = mysqli_fetch_row($result);
            if ($num == $data[0] || $first==true) {
                $first=false;
                if ($value == "mag"){
                    $html .= "<option selected value = \"$data[0]\">$data[1]</option>";
                }else{
                    $html .= "<option selected value = \"$data[0]\">$data[2] $data[1]</option>";
                }
            }else{
                if ($value == "mag") {
                    $html .= "<option value = \"$data[0]\">$data[1]</option>";
                }else{
                    $html .= "<option value = \"$data[0]\">$data[2] $data[1]</option>";
                }
            }
        }
        return $html;
    }
}