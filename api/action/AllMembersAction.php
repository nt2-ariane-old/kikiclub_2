<?php
require_once("../action/CommonAction.php");

class AllMembersAction extends CommonAction
{
	public $admin_members;
	public $min;
	public $max;
	public $page;
	public function __construct()
	{
		parent::__construct(CommonAction::$VISIBILITY_ANIMATOR, 'all-users');
	}

	protected function executeAction()
	{
		$this->admin_members = MemberDAO::getAllMember();
		$nb_per_page = 10;
		$this->min = 0;
		$this->max = $nb_per_page;

		if (!empty($_GET['page'])) {
			$this->page = $_GET['page'];
		} else {
			$this->page = 0;
		}
		$this->min = $this->page * $nb_per_page;
		$this->max = ($this->page + 1) * $nb_per_page;
		if ($this->max >= sizeof($this->admin_members)) {
			$this->max = sizeof($this->admin_members) ;
		}
	}
}
