<?php
	require_once("../action/CommonAction.php");
	require_once("../action/DAO/BadgeDAO.php");

	class BadgesAjaxAction extends CommonAction {

		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_CUSTOMER_USER,'badges-ajax');
		}

		protected function executeAction() {
			$this->results = [];
			if(!empty($_POST["id"]))
			{
				$this->results["badge"] = BadgeDAO::getBadgeByID($_POST["id"]);
			}
			if(isset($_POST["add"]))
			{
				$this->results["types"] = BadgeDAO::getBadgesType();
				BadgeDAO::addBadge();
				$this->results["id"] = BadgeDAO::getIdFromLastCreated();

			}
			if(isset($_POST["update"]))
			{
				$id = $_POST["id"];
				$badge = BadgeDAO::getBadgeByID($id);

				$params = $_POST["params"];
				$this->results["badge"] = $badge;
				$this->results["params"] = $params;
				foreach ($params as $key => $value) {
					$badge[$key] = $value;

				}

				BadgeDAO::updateBadge($id,$badge["name"],$badge["id_badge_type"], $badge["value_needed"],$badge["media_path"],$badge["media_type"]);
			}
			if(isset($_POST["delete"]))
			{
				$selected = json_decode($_POST["selected"],true);
				foreach ($selected as $badge) {
					BadgeDAO::deleteBadge($badge);
				}
			}
		}
	}