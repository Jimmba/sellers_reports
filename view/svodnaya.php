<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/service/database.php");
$query = "SELECT
  dsm.date,
  sotrudniki.name,
  mags.magname,
  dsm.id_dsm,
  SUM(prihProbito.`probito+cart(x10)`) AS probito,
  SUM(prihBeznal.`beznal(x100)`) AS beznal,
  SUM(prihNal.`nal(x100)`) AS nal,
  SUM(prihPerevod.`perevod_sto(x100)`) AS perevod,
  SUM(prihPredoplata.`predoplata(x100)`) AS predoplata
FROM dsm
  INNER JOIN mags
    ON dsm.mags_idmag = mags.idmag
  INNER JOIN sotrudniki
    ON dsm.sotrudniki_id_prod = sotrudniki.id_prod
  LEFT OUTER JOIN prihBeznal
    ON prihBeznal.dsm_id_dsm = dsm.id_dsm
  LEFT OUTER JOIN prihNal
    ON dsm.id_dsm = prihNal.dsm_id_dsm
  LEFT OUTER JOIN prihPerevod
    ON prihPerevod.dsm_id_dsm = dsm.id_dsm
  LEFT OUTER JOIN prihPredoplata
    ON prihPredoplata.dsm_id_dsm = dsm.id_dsm
  LEFT OUTER JOIN prihProbito
    ON prihProbito.dsm_id_dsm = dsm.id_dsm
GROUP BY dsm.id_dsm,
         dsm.date,
         mags.magname,
         sotrudniki.name";
$db = new DataBase();
$db->init();
$db->setQuery($query);
$result = $db->doQuery();
$rows = mysqli_num_rows($result);	
?>

<div class="tab-pane active" id="svodnaya" role="tabpanel">
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Дата</th>
				<th>Продавец</th>
				<th>Магазин</th>
				<th>Приходы</th>
				<th>Расходы</th>
				<th>Возвраты</th>
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
						<td>%s</td>
					</tr>",$data[0],$data[1],$data[2],$data[4],$data[5],$data[6]);
				}
			?>
		</tbody>
	</table>
</div>
<button type="button" class="btn btn-success" id="addForm" data-toggle="modal" data-target=".add-modal">
    <i class="fas fa-plus-square"></i>
    <span>Добавить</span>
</button>
<!--<div class="modal fade change-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Изменить</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Здесь будут находиться данные, которые нужно изменить</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">Изменить</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade add-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавить</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Здесь будут находиться данные, которые нужно добавить</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">Добавить</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>-->