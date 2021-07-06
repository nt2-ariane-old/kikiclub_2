<?php
	require_once("../action/CommonAction.php");
	require_once("../action/DAO/WorkshopDAO.php");

	class MaterialsAction extends CommonAction {
        public $materials;

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_ADMIN_USER,'materials');
			
		}

		protected function executeAction() {
            $this->materials = WorkshopDAO::getMaterials();
        }

	}