<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/service/Sessions.php");
    $session = new Sessions();
    $session->startSession();

    $_SESSION['page']="vozvraty";
    require_once ($_SERVER['DOCUMENT_ROOT']."/service/sessionsFilter.php");
    // Получаем из сессии $prod, $mag, $dateFrom, $dateTo
    $sessionFilter = new sessionsFilter();
    $where = $sessionFilter->getSelectFilter();//Генерируем where...
    $query = "SELECT
          dsm.id_dsm,
          dsm.date,
          mags.magname,
          sotrudniki.name AS prod,
          vozvrat.`vozvrat(x100)`,
          vozvrat.prichina,
          vozvrat.id_vozvrat,
          sotrudniki_1.name
        FROM vozvrat
          INNER JOIN dsm
            ON vozvrat.dsm_id_dsm = dsm.id_dsm
          INNER JOIN sotrudniki
            ON dsm.sotrudniki_id_prod = sotrudniki.id_prod
          INNER JOIN mags
            ON dsm.mags_idmag = mags.idmag
          INNER JOIN sotrudniki sotrudniki_1
            ON vozvrat.komuVozvrat = sotrudniki_1.id_prod
        $where 
        AND vozvrat.komuVozvrat = sotrudniki_1.id_prod
        GROUP BY vozvrat.id_vozvrat,
                 sotrudniki.name,
                 sotrudniki_1.name
        ORDER BY dsm.date DESC, prod";
    require($_SERVER['DOCUMENT_ROOT']."/service/connection.php");
    $DBH = new PDO("mysql:host =$host;dbname=$database",$user,$password);
    $STH=$DBH->query($query);

    echo"<div class=\"tab-pane\" id=\"expenses\" role=\"tabpanel\">
        <table class=\"table table-bordered table-striped\">
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Магазин</th>
                    <th>Продавец</th>
                    <th>Сумма</th>
                    <th>Причина</th>
                    <th>Кто продавал</th>
                    <th>Изменить</th>
                    <th>Удалить</th>
                </tr>
            </thead>
            <tbody>";
            while ($row = $STH->fetch()) {
                $sum += $row["vozvrat(x100)"] / 100;
                printf("
                <tr>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>
                        <button type=\"button\" class=\"btn btn-info loadChangeForm\" data-toggle=\"modal\" data-target=\".change-modal\" id=\"%s\">
                            <i class=\"fas fa-edit\"></i>
                            <span>Изменить</span>
                        </button>
                    </td>
                    <td>
                        <form action='crud.php' method='post' class='deleteRashod'>
                            <input type=\"hidden\" name=\"action\" value=\"delete\">
                            <input type=\"hidden\" name=\"id\" value=\"%s\">
                            <button type=\"submit\" class=\"btn btn-danger\">
                                <i class=\"fas fa-trash-alt\"></i>
                                <span>Удалить</span>
                            </button>
                        </form>
                    </td>
                </tr>", $row["date"], $row["magname"], $row["prod"], $row["vozvrat(x100)"] / 100, $row["prichina"], $row["name"], $row["id_vozvrat"], $row["id_vozvrat"]);
            }
            echo"
            </tbody>
        </table>
        <button type=\"button\" class=\"btn btn-success\" id=\"loadAddForm\" data-toggle=\"modal\" data-target=\".add-modal\">
            <i class=\"fas fa-plus-square\"></i>
            <span>Добавить</span>
        </button>
        <button type=\"button\" class=\"btn btn-primary\">
            <span>Сумма: $sum</span>
        </button>
    </div>";
?>
<div id="modal">

    <!--Модальное окно придет через ajax-->
</div>

<script>

    $('.loadChangeForm').click(function () {
        var idValue;
        var modal = "change";
        idValue = $(this).attr('id');
        console.log(idValue);
        $.ajax({
            type: "POST",
            url: "model/vozvraty/crud.php",
            data: {
                "id" : idValue,
                "modal" : modal
            },
            async: false,
            success: function ($result) {
               //console.log($result);
                $("#modal").html($result);
                $("#modal").show();
                console.log("change sucsess");
            },
            error: function () {
                console.log("add data ERROR");
            }
        });
    });

    $('#loadAddForm').click(function () {
        var modal = "add";
        $.ajax({
            type: "POST",
            url: "model/vozvraty/crud.php",
            data: {
                "modal" : modal
            },
            async: false,
            success: function ($result) {
                //console.log($result);
                $("#modal").html($result);
                $("#modal").show();
                console.log("modalAdd completed");
            },
            error: function () {
                console.log("add data ERROR");
            }
        });
    });

    $(".deleteRashod").submit(function (e) {
        e.preventDefault();
        //console.log('delete clicked');
        var data_review = $(this).serialize();
        //console.log($(this));
        $.ajax({
            type: "POST",
            url: "model/vozvraty/crud.php",
            data: data_review,
            async: false,
            success: function () {
                console.log("delete sucsess");
                $("#content").load('model/vozvraty/data.php');

            },
            error: function () {
                console.log("delete ERROR");
            }
        });
    });

</script>
