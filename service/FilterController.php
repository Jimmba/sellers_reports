<!--Фильтры-->
<?php
    class FilterController{
        private $filterModel;
        private $filterView;
        function init(){
            include_once($_SERVER['DOCUMENT_ROOT']."/service/Sessions.php");
            $session = new Sessions();
            $session->startSession();
            include_once($_SERVER['DOCUMENT_ROOT'] . "/service/FilterModel.php");
            include_once($_SERVER['DOCUMENT_ROOT'] . "/service/FilterView.php");
            $this->filterModel = new FilterModel();
            $this->filterModel->init();
            $this->filterView = new FilterView($this->filterModel);
            $this->filterView->init();
            $data = $this->filterView->getData();
            echo $data;
        }
    }
?>