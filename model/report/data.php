<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/service/Sessions.php");
    $session = new Sessions();
    $session->startSession();

    $_SESSION['page']="report";
    require_once ($_SERVER['DOCUMENT_ROOT']."/service/sessionsFilter.php");
    // Получаем из сессии $prod, $mag, $dateFrom, $dateTo
    $sessionFilter = new sessionsFilter();
    $where = $sessionFilter->getSelectFilter();//Генерируем where...
    $query = "SELECT DISTINCT
          dsm.id_dsm,
          dsm.date,
          sotrudniki.name,
          mags.magname,
          prihBeznal.`beznal(x100)`,
          prihNal.`nal(x100)`,
          prihPerevod.`perevod_sto(x100)`,
          prihProbito.`probito+cart(x100)`,
          rashod.`rashod(x100)`,
          vozvrat.`vozvrat(x100)`,
          v_zp.`vzp(x100)`
        FROM dsm
          LEFT OUTER JOIN mags
            ON dsm.mags_idmag = mags.idmag
          LEFT OUTER JOIN sotrudniki
            ON dsm.sotrudniki_id_prod = sotrudniki.id_prod
          LEFT OUTER JOIN prihBeznal
            ON prihBeznal.dsm_id_dsm = dsm.id_dsm
          LEFT OUTER JOIN prihNal
            ON prihNal.dsm_id_dsm = dsm.id_dsm
          LEFT OUTER JOIN prihPerevod
            ON prihPerevod.dsm_id_dsm = dsm.id_dsm
          LEFT OUTER JOIN prihProbito
            ON prihProbito.dsm_id_dsm = dsm.id_dsm
          LEFT OUTER JOIN rashod
            ON rashod.dsm_id_dsm = dsm.id_dsm
          LEFT OUTER JOIN vozvrat
            ON vozvrat.dsm_id_dsm = dsm.id_dsm
          LEFT OUTER JOIN v_zp
            ON v_zp.dsm_id_dsm = dsm.id_dsm
            $where
        GROUP BY dsm.id_dsm
        ORDER BY dsm.date, sotrudniki.name, mags.magname";
    require($_SERVER['DOCUMENT_ROOT']."/service/connection.php");
    $DBH = new PDO("mysql:host =$host;dbname=$database",$user,$password);
    $STH=$DBH->query($query);

    echo"<div class=\"tab-pane\" id=\"expenses\" role=\"tabpanel\">
        <table class=\"table table-bordered table-striped\">
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Продавец</th>
                    <th>Магазин</th>
                    <th>Безнал</th>
                    <th>Нал</th>
                    <th>Перевод</th>
                    <th>Пробито</th>
                    <th>Расход</th>
                    <th>Возврат</th>
                    <th>В з/п</th>
                </tr>
            </thead>
            <tbody>";
            while ($row = $STH->fetch()) {
                $beznal+=$row[4]/100;
                $nal+=$row[5]/100;
                $perevod+=$row[6]/100;
                $probito+=$row[7]/100;
                $rashody+=$row[8]/100;
                $vozvrat+=$row[9]/100;
                $vzp+=$row[10]/100;
                printf("
                <tr>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                </tr>", $row[1], $row[2], $row[3], $row[4]/100, $row[5]/100, $row[6]/100, $row[7]/100, $row[8]/100, $row[9]/100, $row[10]/100);
            }
            echo"
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>$beznal</td>
                    <td>$nal</td>
                    <td>$perevod</td>
                    <td>$probito</td>
                    <td>$rashody</td>
                    <td>$vozvrat</td>
                    <td>$vzp</td>
                </tr>
            </tbody>
        </table>
    </div>";
?>
<div id="modal">

    <!--Модальное окно придет через ajax-->
</div>