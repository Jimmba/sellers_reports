<?php

/**
 * Created by PhpStorm.
 * User: gimvit
 * Date: 14.10.2018
 * Time: 15:40
 */
    class Auth{
        /**
         * @return mixed
         */

        private $id_prod;
        private $authName;
        private $permissions;
        //Для регистрации
        private $surname;
        private $email;
        private $password;
        private $confirmPassword;

        private $action;

        function __construct(){
            if (isset($_POST['login'])){
                $this->email=$_POST['login'];
            }
            if (isset($_POST['password'])){
                $this->password=$_POST['password'];
            }
            if (isset($_POST['firstName'])){
                $this->authName=$_POST['firstName'];
            }
            if (isset($_POST['secondName'])){
                $this->surname=$_POST['secondName'];
            }
            if (isset($_POST['email'])){
                $this->email=$_POST['email'];
            }
            if (isset($_POST['password2'])){
                $this->confirmPassword=$_POST['password2'];
            }
            if (isset($_POST['action'])){
                $this->action=$_POST['action'];
            }

        }
        function init(){
           /* $this->authName = "Паша";
            $this->permissions="use";
            $this->id_prod="1";*/

            $this->permissions=$_SESSION["permissions"];
            $this->authName=$_SESSION["prod"];
            $this->id_prod=$_SESSION["id_prod"];
        }
        public function check(){
            // по умолчанию не авторизован
            //   $_SESSION['authorisied']=false;
            $query="SELECT
              id_prod,
              email,
              name as prod,
              is_prodavec,
              is_admin
            FROM sotrudniki where email = \"$this->email\" AND password = \"$this->password\"";

            require($_SERVER['DOCUMENT_ROOT']."/service/connection.php");
            $DBH = new PDO("mysql:host =$host;dbname=$database",$user,$password);
            $STH=$DBH->query($query);
            if ($STH==true){
                $row = $STH->fetch();
                if ($row<>false){
                    //Записывать в сессию имя, id, права
                    $this->permissions($row['is_admin']);
                    $_SESSION['prod']=$row['prod'];
                    $_SESSION['id_prod']=$row['id_prod'];
                    $_SESSION['authorisied']=true;
                    if ($this->permissions=="admin"){
                        $_SESSION['prod']="Все продавцы...";
                    }
                    $_SESSION['mag'] = "Все магазины...";
                    $result= "sucsess";
                }else{
                    $result="error";
                }
            }
            return $result;
        }
        private function permissions($isAdmin){
            if ($isAdmin==1){
                $this->permissions = "admin";
            }else{
                $this->permissions="user";
            }
            $_SESSION["permissions"]=$this->permissions;
        }
        public function getAuthName(){
            return $this->authName;
        }
        public function getPermissions(){
            return $this->permissions;
        }
        public function getAuthId(){
            return $this->authId;
        }

        public function getAction()
        {
            return $this->action;
        }
    }
?>