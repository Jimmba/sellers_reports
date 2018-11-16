<?php

/**
 * Created by PhpStorm.
 * User: gimvit
 * Date: 10.10.2018
 * Time: 22:36
 */
class idDsm{
    private $id;
    function __construct($date, $prod, $mag){
        include_once ("Database.php");
        $db=new DataBase();
        $db->init();
        $db->setQuery("SELECT DSM.id_dsm FROM dsm WHERE date = \"$date\" and sotrudniki_id_prod = \"$prod\" and mags_idmag = \"$mag\"");
        $result = $db->doQuery();
        $rows = mysqli_num_rows($result);
        if ($rows != 0) {
            $dsm = mysqli_fetch_row($result)[0];
        } else {
            $db->setQuery("Insert INTO dsm values (\"null\", \"$date\", \"$prod\", \"$mag\")");
            $db->doQuery();
            $db->setQuery("SELECT DSM.id_dsm FROM dsm WHERE date = \"$date\" and sotrudniki_id_prod = \"$prod\" and mags_idmag = \"$mag\"");
            $result = $db->doQuery();
            $dsm = mysqli_fetch_row($result)[0];
        }
        $this->id = $dsm;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

}