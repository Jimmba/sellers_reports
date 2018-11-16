<?php
	echo "
		<table class=\"table table-hover\">
			<thead>
				<tr>
					<th rowspan = \"2\">№п/п (скрытое поле)</th>
					<th rowspan = \"2\">Дата</th>
					<th rowspan = \"2\">Магазин</th>
					<th rowspan = \"2\">Пробито плюс карточки</th>
					<th rowspan = \"2\">Безнал</th>
					<th rowspan = \"2\">Переводы на СТО</th>
					<th rowspan = \"2\">Наличные</th>
					<th colspan=\"2\">Предоплата</th>
					<th rowspan = \"2\">Изменить</th>
					<th rowspan = \"2\">Удалить</th>
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
						<button type=\"button\" class=\"btn btn-warning\" data-toggle=\"modal\" data-target=\"какое-то значение\">
							<i class=\"fas fa-edit\">Изменить</i>
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
								<i class=\"fas fa-trash-alt\">Удалить</i>
							</button>
						</form>
					</td>
				</tr>
        </tbody>
	</table>
	<button type=\"button\" class=\"btn btn-success\" id=\"add\" data-toggle=\"modal\" data-target=\"#calc_card\">
		<i class=\"fas fa-plus-square\"></i>
		Добавить
	</button>
";
?>




<!--Форма для изменения: в ячейках с id добавлен класс dBId, в button добавлены атрибуты data-toggle="modal" data-target="#changesModalForm"-->

<div class="modal fade" id="changesModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Изменить</h5>
                <button type="button" class="close  cancel" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="index.php">
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="ajax" value="ajax" id="ajax">
                    <input type="hidden" name="action" value="update" id="action">
                    <input type="hidden" name="table" value="dishes" id="table">
                    <button type="button" class="btn btn-danger cancel" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-success">Изменить</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!--<div class="modal fade" id="changesModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Изменить</h5>
                <button type="button" class="close  cancel" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="index.php">
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="ajax" value="ajax" id="ajax">
                    <input type="hidden" name="action" value="update" id="action">
                    <input type="hidden" name="table" value="dishes" id="table">
                    <button type="button" class="btn btn-danger cancel" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-success">Изменить</button>
                </div>
            </form>
        </div>
    </div>
</div>
-->