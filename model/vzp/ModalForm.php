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
    private $inputDate;
    private $mags;
    private $prod;
    private $sum;
    private $prichina;
    private $komu;
    private $name;

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
        $this->title="Добавить";
        $this->idForm="addForm";
        $m = new ArrayOptionsModal;
        $this->mags=$m->getArray("mag",null);
        $this->prod=$m->getArray("prod",$_SESSION['id_prod']);
        $this->komu=$m->getArray("prod",null);
        $this->sum=null;
        $this->prichina=null;
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
              mags.idmag,
              mags.magname,
              sotrudniki.id_prod,
              sotrudniki.name AS prod,
              v_zp.`vzp(x100)`,
              v_zp.osnovanie,
              v_zp.sotrudniki_id_prod,
              sotrudniki_1.name,
              v_zp.id_v_zp
            FROM v_zp
              INNER JOIN dsm
                ON v_zp.dsm_id_dsm = dsm.id_dsm
              INNER JOIN sotrudniki
                ON dsm.sotrudniki_id_prod = sotrudniki.id_prod
              INNER JOIN mags
                ON dsm.mags_idmag = mags.idmag
              INNER JOIN sotrudniki sotrudniki_1
                ON v_zp.sotrudniki_id_prod= sotrudniki_1.id_prod
            WHERE v_zp.sotrudniki_id_prod = sotrudniki_1.id_prod
            AND v_zp.id_v_zp= $id
            GROUP BY v_zp.id_v_zp,
                     sotrudniki.name
            ORDER BY dsm.date DESC, prod");
        $db->doQuery();
        $result = $db->doQuery();
        $res = mysqli_fetch_row($result);
        require_once ($_SERVER['DOCUMENT_ROOT']."/service/arrayOptionsModal.php");
        $m=new arrayOptionsModal();
        $this->mags=$m->getArray("mag",$res[2]);
        $this->prod=$m->getArray("prod",$res[4]);
        $this->komu=$m->getArray("prod",$res[8]);
        $sum = $res[6]/100;

        $this->classModal="change-modal";
        $this->title="Изменить";
        $this->idForm="changeForm";
        $this->inputDate=$res[1];
        require_once ($_SERVER['DOCUMENT_ROOT']."/service/arrayOptionsModal.php");
        //$m = new ArrayOptionsModal;
        //$this->mags=$m->getArray("mag",null);
        $this->sum=$sum;
        $this->prichina=$res[7];
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
        $this->komu="
            <select class=\"form-control\" name = \"sotr\">
                $this->komu
            </select>
            ";
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
                                        <label for=\"prod\">Продавец</label>
                                            $this->prod
                                    </div>
                                    
                                     <div class=\"form-group Input\">
                                        <label for=\"sum\">Сумма</label>
                                        <input type=\"text\" name = \"sum\" value = \"$this->sum\" class=\"form-control\" id=\"sum\">
                                    </div>
                                    <div class=\"form-group input\">
                                        <label for=\"prichina\">Основание</label>
                                        <input type=\"text\" name = \"prichina\" value = \"$this->prichina\" class=\"form-control\" id=\"prichina\">
                                    </div>
                                    <div class=\"form-group input\">
                                        <label for=\"sotr\">Кому в зарплату</label>
                                            $this->komu
                                    </div>
                                    
                                    <input type=\"hidden\" name = \"action\" value = \"$this->action\" class=\"form-control\">
                                    <input type=\"hidden\" name = \"id\" value = \"$this->changeId\" class=\"form - control\">
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
                            url: \"model/vzp/crud.php\",
                            data: data_review,
                            async: false,
                            success: function () {
                                  $(\".modal\").hide();
                                  $(\".modal-backdrop\").hide();
                                  $(\"#content\").load('model/vzp/data.php'); // скроллбар не добавляется
                                    
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
                            url: \"model/vzp/crud.php\",
                            data: data_review,
                            async: false,
                            success: function (){
                                $(\".modal\").hide();
                                $(\".modal-backdrop\").hide();
                                $(\"#content\").load('model/vzp/data.php'); // скроллбар не добавляется
                                console.log(\"change sucsess\");
                            },
                            error: function (){
                            console.log(\"change ERROR\");
                            }
                        });
                        console.log(\"end\");
                    });
                </script>
            ";
        return $data;
    }
}