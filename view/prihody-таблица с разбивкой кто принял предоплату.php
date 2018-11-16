<div class="tab-pane" id="income" role="tabpanel">
	<table class="table table-bordered table-striped">
	<thead>
	<tr>
		<th rowspan = "2">№ п/п (скрытое поле)</th>
		<th rowspan = "2">Дата</th>
		<th rowspan = "2">Магазин</th>
		<th rowspan = "2">Пробито плюс карточки</th>
		<th rowspan = "2">Безнал</th>
		<th rowspan = "2">Переводы на СТО</th>
		<th rowspan = "2">Наличные</th>
		<th colspan="2">Предоплата</th>
		<th rowspan = "2">Изменить</th>
		<th rowspan = "2">Удалить</th>
	</tr>
	<tr>
		<th>Сумма предоплаты</th>
		<th>Продавец</th>
	</tr>
	</thead>
		<tbody>
			<tr>
				<td>1</td>
				<td>29.09.2018</td>
				<td>Форсаж</td>
				<td>15 руб</td>
				<td>20 руб</td>
				<td>25 руб</td>
				<td>30 руб</td>
				<td>35 руб</td>
				<td>Паша</td>
				<td>
					<button type="button" class="btn btn-info" data-toggle="modal" data-target=".change-modal">
						<i class="fas fa-edit"></i>
						<span>Изменить</span>
					</button>
				</td>
				<td>
					<form action='index.php' method='post'>
						<input type="hidden" name="action" value="delete">
						<input type="hidden" name="menu" value="tab">
						<input type="hidden" name="table" value="table">
						<input type="hidden" name="param" value="param">
						<input type="hidden" name="id_dishes" value="param">
						<button type="submit" class="btn btn-danger">
							<i class="fas fa-trash-alt"></i>
							<span>Удалить</span>
						</button>
					</form>
				</td>
			</tr>
		</tbody>
	</table>
	<button type="button" class="btn btn-success" id="add" data-toggle="modal" data-target=".add-modal">
		<i class="fas fa-plus-square"></i>
		<span>Добавить</span>
	</button>
</div>
