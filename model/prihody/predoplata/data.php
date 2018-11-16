<?php
    $hello2 = Null;
    include_once($_SERVER['DOCUMENT_ROOT']."/service/Sessions.php");
    $session = new Sessions();
    $session->startSession();

    $_SESSION['page']="prihody/predoplata";
    require_once ($_SERVER['DOCUMENT_ROOT']."/service/sessionsFilter.php");
    // Получаем из сессии $prod, $mag, $dateFrom, $dateTo
    $sessionFilter = new sessionsFilter();
    $where = $sessionFilter->getSelectFilter();//Генерируем where...
    $query = "SELECT
      dsm.id_dsm,
      dsm.date,
      mags.magname,
      sotrudniki.name,
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
      $where
    GROUP BY prihPredoplata.idprih,
             sotrudniki.name
    ORDER BY dsm.date DESC, sotrudniki.name";
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
                    <th>Сумма предоплаты</th>
                    <th>Всего оплатить</th>
                    <th>Изменить</th>
                    <th>Удалить</th>
                </tr>
            </thead>
            <tbody>";
            while ($row = $STH->fetch()) {
                $sum += $row["prihPredoplata(x100)"] / 100;
                printf("
                <tr>
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
                        <form action='crud.php' method='post' class='deletePredoptala'>
                            <input type=\"hidden\" name=\"action\" value=\"delete\">
                            <input type=\"hidden\" name=\"id\" value=\"%s\">
                            <button type=\"submit\" class=\"btn btn-danger\">
                                <i class=\"fas fa-trash-alt\"></i>
                                <span>Удалить</span>
                            </button>
                        </form>
                    </td>
                </tr>", $row["date"], $row["magname"], $row["name"], $row["predoplata(x100)"] / 100, $row["vsego_k_oplate(x100)"] / 100, $row["id_prih"], $row["id_prih"]);
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
            url: "model/prihody/predoplata/crud.php",
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
            url: "model/prihody/predoplata/crud.php",
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

    $(".deletePredoptala").submit(function (e) {
        e.preventDefault();
        //console.log('delete clicked');
        var data_review = $(this).serialize();
        //console.log($(this));
        $.ajax({
            type: "POST",
            url: "model/prihody/predoplata/crud.php",
            data: data_review,
            async: false,
            success: function () {
                console.log("delete sucsess");
                $("#content").load('model/prihody/predoplata/data.php');

            },
            error: function () {
                console.log("delete ERROR");
            }
        });
    });

</script>
