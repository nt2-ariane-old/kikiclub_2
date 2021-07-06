<?php
    require_once("../action/CommonAction.php");

    class EditTextAction extends CommonAction {

        public function __construct() {
            // parent::__construct(CommonAction::$VISIBILITY_ADMIN_USER, 'EDIT TEXT');
            parent::__construct(CommonAction::$VISIBILITY_PUBLIC, 'edit-text');
        }

        protected function executeAction() {
            
        }
    }