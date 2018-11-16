<?php
/**
 * Created by PhpStorm.
 * User: gimvit
 * Date: 16.11.2018
 * Time: 18:10
 */
    $id = $_POST['id'];
    if ($id <> addPredoplata){
        $query = "SELECT
          dsm.id_dsm,
          dsm.date,
          mags.magname,
          sotrudniki.name,
          prihPredoplata.opisanie,
          prihPredoplata.`predoplata(x100)`,
          prihPredoplata.`vsego_k_oplate(x100)`,
          prihPredoplata.pogasheno
        FROM prihPredoplata
          INNER JOIN dsm
            ON prihPredoplata.dsm_id_dsm = dsm.id_dsm
          INNER JOIN sotrudniki
            ON dsm.sotrudniki_id_prod = sotrudniki.id_prod
          INNER JOIN mags
            ON dsm.mags_idmag = mags.idmag
          WHERE prihPredoplata.idprih = $id";
        require($_SERVER['DOCUMENT_ROOT']."/service/connection.php");
        $DBH = new PDO("mysql:host =$host;dbname=$database",$user,$password);
        $STH=$DBH->query($query);
        $row = $STH->fetch();
        $opisanie = $row[4];
        $sumTotal = $row[6]/100;
        $sumPredoplata = $row[5]/100;
        $sumOstatok = $sumTotal-$sumPredoplata;
        echo json_encode(array('result' => 'success', 'opisanie' => $opisanie, 'sumTotal' => $sumTotal, 'sumPredoplata' => $sumPredoplata, 'sumOstatok' =>$sumOstatok));
    }else{
        echo json_encode(array('result' => 'error'));
    }

?>