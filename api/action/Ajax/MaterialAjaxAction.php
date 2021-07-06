<?php
	require_once("../action/CommonAction.php");
	require_once("../action/DAO/WorkshopDAO.php");

	class MaterialAjaxAction extends CommonAction {
		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC,'material-ajax');
		}

		protected function executeAction() {
			$this->results = WorkshopDAO::getMaterials();
			if(!empty($_POST['type']))
			{
				$type = $_POST['type'];
				if($type == 'delete')
				{
					$id = $_POST['id'];
					$this->results = WorkshopDAO::deleteMaterial($id);
				}
				else if($type == 'update')
				{
					$id = $_POST['id'];
					$value =$_POST['value'];
					$this->results = WorkshopDAO::updateMaterial($id,$value);
				}
				else if($type == 'create')
				{
					$value =$_POST['value'];
					WorkshopDAO::insertMaterial($value);
					$this->results = WorkshopDAO::getMaterialByValue($value);
				}
			}
			
		}
	}