<?php
class Money{
    private $ostatok;
    private $mag;
    private $prod;
    private $dateFrom;
    private $dateTo;
    private $result;

    function __construct(){
        $this->ostatok['Патриот'] ="1000";
        $this->ostatok['Форсаж'] ="2000";
        $this->ostatok['Техномикс'] ="3000";
        $this->mag = $_SESSION['mag'];
        $this->prod = $_SESSION['prod'];
        $this->dateFrom= $_SESSION['dateFrom'];
        $this->dateTo= $_SESSION['dateTo'];
        $this->doRequest();
        return $this->result;
    }
    private function doRequest(){
        $sum = $this->querySum();
        $minus = $this->queryMinus();
        if ($_SESSION['mag']=="Все магазины..."){
            $ost = 0;
            foreach ($this->ostatok as $item) {
                $ost=$ost+$item;
            }
        }else{
            $ost = $this->ostatok[$_SESSION['mag']];
        }
        $ost =$ost/100;

        $this->result= $ost+$sum-$minus;

    }

    private function querySum(){
        $where = $this->where();
        $query = "SELECT DISTINCT 
          prihNal.id_prih AS ID, 
          prihnal.`nal(x100)`AS SUMMA
        FROM
          dsm
        Inner Join mags ON 
          dsm.mags_idmag = mags.idmag
        Inner Join sotrudniki ON 
          dsm.sotrudniki_id_prod = sotrudniki.id_prod
        Inner Join prihNal ON 
          prihNal.dsm_id_dsm = dsm.id_dsm
          $where";
        
          $query1 = "SELECT DISTINCT
          prihPerevod.id_prih AS ID,
          prihPerevod.`perevod_sto(x100)` AS SUMMA
        FROM mags
          INNER JOIN dsm
            ON dsm.mags_idmag = mags.idmag
          INNER JOIN sotrudniki
            ON sotrudniki.id_prod = dsm.sotrudniki_id_prod
          INNER JOIN prihPerevod
            ON dsm.id_dsm = prihPerevod.dsm_id_dsm
          $where";
        
          $query2="SELECT DISTINCT
          prihPredoplata.idprih AS ID,
          prihPredoplata.`predoplata(x100)` AS SUMMA
          FROM mags
          INNER JOIN dsm
          ON dsm.mags_idmag=mags.idmag
          INNER JOIN sotrudniki
              ON sotrudniki.id_prod = dsm.sotrudniki_id_prod
            INNER JOIN prihPredoplata
              ON dsm.id_dsm = prihPredoplata.dsm_id_dsm
            $where";
        
            $query3="SELECT DISTINCT
          prihPredoplata.idprih AS ID,
          prihPredoplata.`pogasheno(x100)` AS SUMMA
          FROM mags
          INNER JOIN dsm
          ON dsm.mags_idmag=mags.idmag
          INNER JOIN sotrudniki
              ON sotrudniki.id_prod = dsm.sotrudniki_id_prod
            INNER JOIN prihPredoplata
              ON dsm.id_dsm = prihPredoplata.dsm_ostatok
            $where";

        $query4 = "SELECT DISTINCT 
          ostatki.id_ostatki AS ID, 
          ostatki.`sdano(x100)`AS SUMMA
        FROM
          dsm
        Inner Join mags ON 
          dsm.mags_idmag = mags.idmag
        Inner Join sotrudniki ON 
          dsm.sotrudniki_id_prod = sotrudniki.id_prod
        Inner Join ostatki ON 
          ostatki.dsm_id_dsm = dsm.id_dsm
          $where";
            
        require($_SERVER['DOCUMENT_ROOT']."/service/connection.php");
        $DBH = new PDO("mysql:host =$host;dbname=$database",$user,$password);

        $s=0;
        $STH=$DBH->query($query);
        while ($row = $STH->fetch()) {
            $s += $row['SUMMA'];
        }
        $STH=$DBH->query($query1);
        while ($row = $STH->fetch()) {
            $s += $row['SUMMA'];
        }
        $STH=$DBH->query($query2);
        while ($row = $STH->fetch()) {
            $s += $row['SUMMA'];
        }
        $STH=$DBH->query($query3);
        while ($row = $STH->fetch()) {
            $s += $row['SUMMA'];
        }
        $STH=$DBH->query($query4);
        while ($row = $STH->fetch()) {
            $s -= $row['SUMMA'];
        }
        $s=$s/100;
        return $s;
    }

    private function queryMinus(){
        $where = $this->where();
        $query = "SELECT DISTINCT 
          rashod.id_rashod AS ID, 
          rashod.`rashod(x100)` AS SUMMA
        FROM
          dsm
        Inner Join mags ON 
          dsm.mags_idmag = mags.idmag
        Inner Join sotrudniki ON 
          dsm.sotrudniki_id_prod = sotrudniki.id_prod
        Inner Join rashod ON 
            rashod.dsm_id_dsm = dsm.id_dsm
          $where";

        $query1 = "SELECT DISTINCT 
            vozvrat.id_vozvrat AS ID,
            vozvrat.`vozvrat(x100)` AS SUMMA
        FROM
          dsm
        INNER JOIN mags
        ON dsm.mags_idmag = mags.idmag
      INNER JOIN sotrudniki
        ON dsm.sotrudniki_id_prod = sotrudniki.id_prod
      INNER JOIN vozvrat
        ON vozvrat.dsm_id_dsm = dsm.id_dsm
          $where";

        require($_SERVER['DOCUMENT_ROOT']."/service/connection.php");
        $DBH = new PDO("mysql:host =$host;dbname=$database",$user,$password);
        $s=0;
        $STH=$DBH->query($query);
        while ($row = $STH->fetch()) {
            $s += $row['SUMMA'];
        }
        $STH=$DBH->query($query1);
        while ($row = $STH->fetch()) {
            $s += $row['SUMMA'];
        }
        $s=$s/100;
        return $s;
    }


    private function where(){
        $text = "WHERE ";

        //Вычисляем остаток по магазину - не учитываем продавца!
        /*  if ($this->prod!="Все продавцы..."){
              $text.= "sotrudniki.name = \"$this->prod\" AND ";
          }*/

        if ($this->mag!="Все магазины..."){
            $text.= "mags.magname = \"$this->mag\" AND ";
        }
        $text.= "dsm.date <= \"$this->dateTo\"";
        return $text;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

}