<?php
	require_once("../action/CommonAction.php");
	require_once("../action/DAO/BadgeDAO.php");

	class ReferenceAction extends CommonAction {
		public function __construct() {
            parent::__construct(CommonAction::$VISIBILITY_PUBLIC,'plan-du-site');
    
		}

		protected function executeAction() {
        
		}
       
        
    }
