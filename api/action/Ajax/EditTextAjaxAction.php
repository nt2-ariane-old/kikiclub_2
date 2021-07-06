<?php
require_once("../action/CommonAction.php");

class EditTextAjaxAction extends CommonAction
{

    public function __construct()
    {
        parent::__construct(CommonAction::$VISIBILITY_PUBLIC, 'edit-text-ajax');
    }

    protected function executeAction()
    {
        if (!empty($_POST['fr'])) {
            $valuefr = $_POST['fr'];
            $valueen = $_POST['en'];
            $page = $_POST['page'];
            $word = $_POST['word'];
    
            $this->trans->edit($page,$word,$valuefr,$valueen);
        }
       
    }
}
