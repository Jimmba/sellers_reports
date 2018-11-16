<?php 
require_once("database.php");
$query = "SELECT
  dsm.id_dsm,
  dsm.date,
  mags.magname,
  sotrudniki.name,
  rashod.`rashod(x100)`,
  rashod.kuda,
  rashod.id_rashod
FROM rashod
  INNER JOIN dsm
    ON rashod.dsm_id_dsm = dsm.id_dsm
  INNER JOIN sotrudniki
    ON dsm.sotrudniki_id_prod = sotrudniki.id_prod
  INNER JOIN mags
    ON dsm.mags_idmag = mags.idmag
GROUP BY rashod.id_rashod,
         sotrudniki.name";
$db = new DataBase();
$db->init();
$db->setQuery($query);
$result = $db->doQuery();
$rows = mysqli_num_rows($result);	
?>
<div class="tab-pane" id="expenses" role="tabpanel">
	<table class="table table-bordered table-striped">
	<thead>
	<tr>
		<th>Дата</th>
		<th>Магазин</th>
		<th>Продавец</th>
		<th>Сумма</th>
		<th>На что</th>
		<th>Изменить</th>
		<th>Удалить</th>
	</tr>
	</thead>
		<tbody>
			<?php 
				for($i=0; $i<$rows; $i++){
					$data = mysqli_fetch_row($result);
						printf("<tr>
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
					</tr>",$data[1],$data[2],$data[3],$data[4],$data[5],$data[6],$data[6]);
				}
			?>
		</tbody>
	</table>
	<button type="button" class="btn btn-success" id="loadAddForm" data-toggle="modal" data-target=".add-modal">
		<i class="fas fa-plus-square"></i>
		<span>Добавить</span>
	</button>
</div>
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
            url: "view/crud.php",
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
            url: "view/crud.php",
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
            url: "view/crud.php",
            data: data_review,
            async: false,
            success: function () {
                console.log("delete sucsess");
                $("#content").load('view/rashody.php');

            },
            error: function () {
                console.log("delete ERROR");
            }
        });
    });

</script>
