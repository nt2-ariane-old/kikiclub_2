<?php
require_once("../action/CommonAction.php");
require_once("../action/DAO/MailChimpDAO.php");

class AllUsersAction extends CommonAction
{
	public $users;
	public $min;
	public $max;
	public $page;
	public function __construct()
	{
		parent::__construct(CommonAction::$VISIBILITY_ANIMATOR, 'all-users');
	}

	protected function executeAction()
	{
		$this->users = UsersDAO::getAllUsers();

		foreach ($this->users as $key => $user) {
			$user_connex = UsersConnexionDAO::getUserConnexion($user['id'], true);
			
			$date = null;
			if (!empty($user_connex)) {
				
				$date = $user_connex[0]['date'];
				if (empty($date)) {
					$date = '- Jamais -';
				}
				
			} else {
				$date = '- Jamais -';
			}
			$this->users[$key]['last_connected'] = $date;
		}
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
		// MailChimpDAO::addAllSubscriber($email, $firstname, $lastname);
	}
}
