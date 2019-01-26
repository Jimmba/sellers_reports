<?php

/**
 * Created by PhpStorm.
 * User: gimvit
 * Date: 14.10.2018
 * Time: 18:41
 */
class ModalForm{
    private $classModal;
    private $title;
    private $idForm;
    private $predoplaty;
    private $inputDate;
    private $mags;
    private $prod;
    private $opisanie;
    private $sumTotal;
    private $sumPredopl;
    private $action;
    private $changeId;
    private $buttonClass;
    private $buttonText;
    private $buttonId;
    function __construct($action, $id){
        if ($action=="add"){
            $this->createAddForm();
        }
        if ($action=="change"){
            $this->createChangeForm($id);
        }
        $this->getModalForm();
    }
    private function createAddForm(){
        $this->classModal="add-modal";
        $this->title="Добавить продажу по предоплате";
        $this->idForm="addForm";
        $m = new ArrayOptionsModal;
        $this->predoplaty = $this->getPredoplaty();
        $this->mags=$m->getArray("mag",null);
        $this->prod=$m->getArray("prod",$_SESSION['id_prod']);
        $this->opisanie=null;
        $this->sumTotal=null;
        $this->sumPredopl=null;
        $this->action="add";
        $this->changeId=null;
        $this->buttonClass="btn-success";
        $this->buttonId="requestAddData";
        $this->buttonText="Добавить";
        $this->inputDate = $today = date("Y-m-d");
        $this->getDisabled($_SESSION['permissions']=="user");
    }
    private function createChangeForm($id){
        $db = new DataBase();
        $db->init();
        $db->setQuery("SELECT
          dsm.id_dsm,
          dsm.date,
          mags.magname,
          sotrudniki.name,
          prihPredoplata.opisanie,
          prihPredoplata.id_prod,
          prihPredoplata.`predoplata(x100)`,
          prihPredoplata.`vsego_k_oplate(x100)`,
          prihPredoplata.`pogasheno(x100)`
        FROM prihPredoplata
          INNER JOIN dsm
            ON prihPredoplata.dsm_id_dsm = dsm.id_dsm
          INNER JOIN sotrudniki
            ON dsm.sotrudniki_id_prod = sotrudniki.id_prod
          INNER JOIN mags
            ON dsm.mags_idmag = mags.idmag
          WHERE prihPredoplata.idprih = $id");
        $db->doQuery();
        $result = $db->doQuery();
        $res = mysqli_fetch_row($result);
        require_once ($_SERVER['DOCUMENT_ROOT']."/service/arrayOptionsModal.php");
        $m=new arrayOptionsModal();
        $this->predoplaty = $this->getPredoplaty();
        $this->mags=$m->getArray("mag",$res[2]);
        $this->prod=$m->getArray("prod",$res[4]);
        $this->sumTotal = $res[7]/100;
        $this->sumPredopl = $res[6]/100;
        $this->opisanie = $res[4];
        $this->classModal="change-modal";
        $this->title="Изменить";
        $this->idForm="changeForm";
        $this->inputDate=$res[1];
        require_once ($_SERVER['DOCUMENT_ROOT']."/service/arrayOptionsModal.php");
        //$m = new ArrayOptionsModal;
        //$this->mags=$m->getArray("mag",null);
        $this->action="change";
        $this->changeId=$id;
        $this->buttonClass="btn-info";
        $this->buttonId="requestChangeData";
        $this->buttonText="Изменить";
        $this->getDisabled($_SESSION['permissions']=="user");
    }

    function getDisabled($permissions){
        //Включаем/выключаем инпуты в зависимости от прав
        $today = date("Y-m-d");
        $p = new ArrayOptionsModal();
        //$this->prod = $p->getArray("prod",null);
        if($permissions=="user"){
            $this->inputDate=$today;
            $name=$_SESSION["prod"];
            //$prod=$p->getArray("prod",$id);
            $id=$p->getIdByName($name);
            $this->inputDate="<input type=\"date\" disabled name = \"date\" value = \"$this->inputDate\" class=\"form-control\">
                <input type=\"date\" hidden name = \"date\" value = \"$this->inputDate\" class=\"form - control\">
            ";
            /*$this->prod="
            <select disabled class=\"form-control\" name = \"prod\">
                <option selected value = \"$id\">$name</option>
            </select>*/
            $this->prod="
            <select disabled class=\"form-control\" name = \"prod\">
                $this->prod
            </select>
            <input type=\"text\" hidden name = \"prod\" value = \"$id\" class=\"form - control\">
            ";
        }else{
            $this->inputDate="<input type=\"date\" name = \"date\" value = \"$this->inputDate\" class=\"form-control\">";
            $prod=$this->prod;
            $this->prod="
            <select class=\"form-control\" name = \"prod\">
                $prod
            </select>";

        }
    }
    private function getPredoplaty(){

        $html= "<option selected value = \"addPredoplata\">Добавить продажу по предоплате</option>";
        require($_SERVER['DOCUMENT_ROOT']."/service/connection.php");
        $query = "
        SELECT
          prihPredoplata.idprih,
          prihPredoplata.opisanie,
          prihPredoplata.`predoplata(x100)`,
          prihPredoplata.`vsego_k_oplate(x100)`
        FROM prihPredoplata
        WHERE prihPredoplata.`pogasheno(x100)`=0
        ORDER BY prihPredoplata.idprih";

        $DBH = new PDO("mysql:host =$host;dbname=$database",$user,$password);
        $STH=$DBH->query($query);
        while ($row = $STH->fetch()) {
            $html.="
            <option value = \"$row[idprih]\"> $row[opisanie]</option>";
        }
        return $html;

    }
    function getModalForm(){
        $data="
                <div class=\"modal fade $this->classModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myLargeModalLabel\" aria-hidden=\"true\">
                    <div class=\"modal-dialog\" role=\"document\">
                        <div class=\"modal-content\">
                            <div class=\"modal-header\">
                                <h5 class=\"modal-title\">$this->title</h5>
                                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                    <span aria-hidden=\"true\">&times;</span>
                                </button>
                            </div>
                            <div class=\"modal-body\">
                                <form action='crud.php' method='post' id = \"$this->idForm\">
                                     <div class=\"form-group input\">
                                        <label for=\"predoplaty\">Внесение остатка по предоплате:</label>
                                        <select class=\"form-control\" name = \"predoplaty\" id = \"predoplata\">
                                            $this->predoplaty
                                        </select>
                                    </div>
                                
                                     <div class=\"form-group input\">
                                        <label for=\"date\">Дата</label>
                                        $this->inputDate
                                    </div>
                                     <div class=\"form-group input\">
                                        <label for=\"mag\">Магазин</label>
                                        <select class=\"form-control\" name = \"mag\">
                                            $this->mags
                                        </select>
                                    </div>
                                     <div class=\"form-group input\">
                                        <label for=\"prod\">Продавцы</label>
                                            $this->prod
                                    </div>
                                     <div class=\"form-group Input\">
                                        <label for=\"opisanie\">Описание (на что предоплата)</label>
                                        <input type=\"text\" name = \"opisanie\" value = \"$this->opisanie\" class=\"form-control\" id=\"opisanie\">
                                    </div>
                                     <div class=\"form-group Input\">
                                        <label for=\"sumTotal\">Всего к оплате</label>
                                        <input type=\"number\" step=\"0.01\" name = \"sumTotal\" value = \"$this->sumTotal\" class=\"form-control\" id=\"sumTotal\">
                                    </div>
                                    <div class=\"form-group input\">
                                        <label for=\"sumPredopl\">Внесено предоплаты</label>
                                        <input type=\"number\" step=\"0.01\" name = \"sumPredopl\" value = \"$this->sumPredopl\" class=\"form-control\" id=\"sumPredopl\">
                                    </div>
                                    <div class=\"form-group input\" type=\"hidden\">
                                        <label for=\"sumOstatok\">Конечный расчет</label>
                                        <input disabled type=\"number\" step=\"0.01\" name = \"sumOstatok\" class=\"form-control\" id=\"sumOstatok\">
                                    </div>
                                    <input type=\"hidden\" name = \"action\" value = \"$this->action\" class=\"form-control\">
                                    <input type=\"hidden\" name = \"id\" value = \"$this->changeId\" class=\"form-control\">
                                    <div class=\"modal-footer\">
                                        <button type=\"submit\" class=\"btn $this->buttonClass\" id=\"$this->buttonId\">$this->buttonText</button>
                                        <button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Отмена</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <script>
                    $(\"#addForm\").submit(function (e) {
                        e.preventDefault();
                        console.log('form add submit clicked');
                        var data_review = $(this).serialize();
                        console.log($(this));
                        $.ajax({
                            type: \"POST\",
                            url: \"model/prihody/predoplata/crud.php\",
                            data: data_review,
                            async: false,
                            success: function () {
                                  $(\".modal\").hide();
                                  $(\".modal-backdrop\").hide();
                                  $(\"#content\").load('model/prihody/predoplata/data.php'); // скроллбар не добавляется
                                    
                                console.log(\"add data sucsess\");
                            },
                            error: function () {
                                console.log(\"add data ERROR\");
                            }
                        });
                        console.log(\"end\");
                    });
                        
                    $(\"#changeForm\").submit(function (e) {
                        e.preventDefault();
                        console.log('form change submit clicked');
                        var data_review = $(this).serialize();
                        console.log($(this));
                        $.ajax({
                            type: \"POST\",
                            url: \"model/prihody/predoplata/crud.php\",
                            data: data_review,
                            async: false,
                            success: function (){
                                $(\".modal\").hide();
                                $(\".modal-backdrop\").hide();
                                $(\"#content\").load('model/prihody/predoplata/data.php'); // скроллбар не добавляется
                                console.log(\"change sucsess\");
                            },
                            error: function (){
                            console.log(\"change ERROR\");
                            }
                        });
                        console.log(\"end\");
                    });
                        
                    $(\"#predoplata\").change(function (e){
                        e.preventDefault();
                        //console.log('selected');
                        var id= $('#predoplata').val();
                        var method=\"predoplata\";
                        //console.log($(this));
                        $.ajax({
                            type: \"POST\",
                            url: \"model/prihody/predoplata/selectPredoplata.php\",
                            data: {
                                'id': id
                            },
                            async: false,
                            dataType: \"json\",
                            success: function(data){
                                // в случае, когда пришло success. Отработало без ошибок
                                if(data.result == 'success'){
                                    //console.log(data.sumPredoplata);
                                    $('#opisanie').val(data.opisanie);
                                    $('#sumTotal').val(data.sumTotal);
                                    $('#sumPredopl').val(data.sumPredoplata);
                                    $('#sumOstatok').val(data.sumOstatok);
                                    $('#opisanie').prop('disabled', true);
                                    $('#sumTotal').prop('disabled', true);
                                    $('#sumPredopl').prop('disabled', true);
                                    $('#sumOstatok').prop('disabled', true);
                                }else{
                                    $('#opisanie').val('');
                                    $('#sumTotal').val('');
                                    $('#sumPredopl').val('');
                                    $('#sumOstatok').val('');
                                    $('#opisanie').prop('disabled', false);
                                    $('#sumTotal').prop('disabled', false);
                                    $('#sumPredopl').prop('disabled', false);
                                    $('#sumOstatok').prop('disabled', true);
                                }
                            }
                        });
                    });
                </script>
            ";
        return $data;
    }
}