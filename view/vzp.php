<?php 
require_once("database.php");
$query = "SELECT
  v_zp.id_v_zp,
  dsm.date,
  mags.magname,
  sotrudniki.name,
  v_zp.`vozvrat(x100)`,
  v_zp.osnovanie,
  v_zp.dsm_id_dsm
FROM dsm
  CROSS JOIN mags
  INNER JOIN v_zp
    ON v_zp.dsm_id_dsm = dsm.id_dsm
  INNER JOIN sotrudniki
    ON dsm.sotrudniki_id_prod = sotrudniki.id_prod
GROUP BY v_zp.id_v_zp,
         sotrudniki.name";
$db = new DataBase();
$db->init();
$db->setQuery($query);
$result = $db->doQuery();
$rows = mysqli_num_rows($result);	
?>

<div class="tab-pane" id="vzp" role="tabpanel">
	<table class="table table-bordered table-striped">
	<thead>
	<tr>
		<th>Дата</th>
		<th>Магазин</th>
		<th>Продавец</th>
		<th>Сумма</th>
		<th>Сотрудник</th>
		<th>Причина</th>
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
						<td><strong>Доработать</strong></td>
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
					</tr>",$data[1],$data[2],$data[3],$data[4],$data[5]);
				}
			?>
		</tbody>
	</table>
	<button type="button" class="btn btn-success" id="add" data-toggle="modal" data-target=".add-modal">
		<i class="fas fa-plus-square"></i>
		<span>Добавить</span>
	</button>
</div>