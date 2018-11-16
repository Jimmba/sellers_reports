<?php 
require_once("database.php");
$query = "SELECT
  dsm.date,
  mags.magname,
  sotrudniki.name,
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

<div class="tab-pane" id="income" role="tabpanel">
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Дата</th>
				<th>Магазин</th>
				<th>Продавец</th>
				<th>Пробито плюс карточки</th>
				<th>Безнал</th>
				<th>Переводы на СТО</th>
				<th>Наличные</th>
				<th>Предоплата</th>
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
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>
							<button type=\"button\" class=\"btn btn-info\" data-toggle=\"modal\" data-target=\".change-modal\">
								<i class=\"fas fa-edit\"></i>
								<span>Изменить</span>
							</button>
						</td>
						<td>
							<form action='index.php' method='post'>
								<input type=\"hidden\" name=\"action\" value=\"delete\">
								<input type=\"hidden\" name=\"menu\" value=\"tab\">
								<input type=\"hidden\" name=\"table\" value=\"table\">
								<input type=\"hidden\" name=\"param\" value=\"param\">
								<input type=\"hidden\" name=\"id_dishes\" value=\"param\">
								<button type=\"submit\" class=\"btn btn-danger\">
									<i class=\"fas fa-trash-alt\"></i>
									<span>Удалить</span>
								</button>
							</form>
						</td>
					</tr>",$data[0],$data[1],$data[2],$data[4],$data[5],$data[6],$data[7],$data[8]);
				}
			?>
		</tbody>
	</table>
</div>