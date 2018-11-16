<?php

/**
 * Created by PhpStorm.
 * User: gimvit
 * Date: 14.10.2018
 * Time: 15:40
 */
    class auth{
        /**
         * @return mixed
         */

        private $id_prod;
        private $authName;
        private $permissions;

        function init(){
            $this->authName = "Паша";
            $this->permissions="use";
            $this->id_prod="1";

            $_SESSION["permissions"]=$this->permissions;
            if ($this->permissions=="user"){
                $_SESSION["prod"]=$this->authName;
                $_SESSION["id_prod"]=$this->id_prod;
            }
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
    }
?>