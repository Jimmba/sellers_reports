<?php

/**
 * Created by PhpStorm.
 * User: gimvit
 * Date: 08.10.2018
 * Time: 12:52
 */
class Modal{
public $data;
    function init($modalAction){
        include_once($_SERVER['DOCUMENT_ROOT']."/service/Sessions.php");
        $session = new Sessions();
        $session->startSession();
        require_once ($_SERVER['DOCUMENT_ROOT']."/service/Database.php");
        $db = new DataBase();
        $db->init();

        require_once ($_SERVER['DOCUMENT_ROOT']."/model/rashody/modalForm.php");
        if ($modalAction =="add"){
            $modal = new ModalForm("add", null);
            $this->data=$modal->getModalForm();
        }
        if ($modalAction =="change"){
            $id = ($_POST['id']);
            $modal = new ModalForm("change", $id);
            $this->data=$modal->getModalForm();

			/*$this->data="
				<div class=\"modal fade change-modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myLargeModalLabel\" aria-hidden=\"true\">
					<div class=\"modal-dialog\" role=\"document\">
						<div class=\"modal-content\">
							<div class=\"modal-header\">
								<h5 class=\"modal-title\">Изменение расхода</h5>
								<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
									<span aria-hidden=\"true\">&times;</span>
								</button>
							</div>
							<div class=\"modal-body\">
								<form action=\"crud.php\" method=\"post\" id=\"changeForm\">
									<div class=\"form-group input\">
										<label for=\"date\">Дата</label>
										<input type=\"date\" name = \"date\" value = \"$res[1]\" class=\"form-control\">
									</div>
									<div class=\"form-group input\">
										<label for=\"mag\">Магазин</label>    
										<select class=\"form-control\" id=\"mag\" name = \"mag\">
											$mags
										</select>
									</div>
									<div class=\"form-group input\">
										<label for=\"sotr\">Продавцы</label>
										<select class=\"form-control\" id=\"prod\" name = \"prod\">
											$sotr
										</select>
									</div>
									<div class=\"form-group Input\">
										<label for=\"sum\">Сумма</label>
										<input type=\"text\" name = \"sum\" value = \"$sum\" class=\"form-control\" id=\"sum\">
									</div>
									<div class=\"form-group input\">
										<label for=\"nachto\">На что</label>
										<input type=\"text\" name = \"nachto\" value = \"$res[7]\" class=\"form-control\" id=\"nachto\">
									</div>
									<input type=\"hidden\" name = \"action\" value = \"change\" class=\"form-control\">
									<input type=\"hidden\" name = \"id\" value = \"$id\" class=\"form-control\">
                                    <div class=\"modal-footer\">
                                        <button type=\"submit\" class=\"btn btn-info\" id=\"requestChangeData\">Изменить</button>
                                        <button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Отмена</button>
                                    </div>
							    </form>
							</div>
						</div>
					</div>
				</div>
				 <script>
					$(\"#changeForm\").submit(function (e) {
						e.preventDefault();
						console.log('form change submit clicked');
						var data_review = $(this).serialize();
						console.log($(this));
						$.ajax({
							type: \"POST\",
							url: \"model/rashody/crud.php\",
							data: data_review,
							async: false,
							success: function () {
								  $(\".modal\").hide();
								  $(\".modal-backdrop\").hide();
								  $(\"#content\").load('model/rashody/data.php'); // скроллбар не добавляется
								
								console.log(\"change sucsess\");
							},
							error: function () {
								console.log(\"change ERROR\");
							}
						});
						console.log(\"end\");
					});
				</script>  
			";*/
        }
        return $this->data;
    }

}