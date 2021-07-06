<?php
session_start();

require_once("../action/constante.php");
require_once("../action/Tools/Translator.php");

require_once("../action/DAO/MemberDAO.php");
require_once("../action/DAO/MemberWorkshopDAO.php");
require_once("../action/DAO/UsersConnexionDAO.php");
require_once("../action/DAO/UsersDAO.php");

abstract class CommonAction
{
	public static $VISIBILITY_PUBLIC = 0;
	public static $VISIBILITY_CUSTOMER_USER = 1;
	public static $VISIBILITY_ANIMATOR = 2;
	public static $VISIBILITY_ADMIN_USER = 3;

	public $default_visibility;
	public $page_visibility;
	public $page_name;
	public $complete_name;

	public $user_name;
	public $member_name;
	public $member_avatar;

	public $members;
	public $avatars;
	public $trans;
	public $url;

	public $admin_mode;
	public $anim_mode;
	public $previous_page;

	public function __construct($page_visibility, $page_name)
	{
		$this->page_visibility = $page_visibility;
		$this->page_name = $page_name;
		$this->default_visibility = 1;
		$this->url = $_SERVER['HTTP_HOST'];
		$this->admin_mode = false;
		$this->anim_mode = false;
	}

	protected function generateString($nb)
	{
		$final_string = "";

		$range = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$length = strlen($range);

		for ($i = 0; $i < $nb; $i++) {
			$index = rand(0, $length - 1);
			$final_string .= $range[$index];
		}

		return $final_string;
	}

	public function isLoggedIn()
	{
		return $_COOKIE["visibility"] > CommonAction::$VISIBILITY_PUBLIC;
	}
	public function isMember()
	{
		return !empty($_SESSION["member_id"]);
	}
	public function isAnim()
	{
		return $_COOKIE["visibility"] >= CommonAction::$VISIBILITY_ANIMATOR;
	}

	public function isAdmin()
	{
		return $_COOKIE["visibility"] >= CommonAction::$VISIBILITY_ADMIN_USER;
	}

	public function execute()
	{
		//check if user want to logout
		error_reporting(E_ALL);
		ini_set('display_errors', 1);

		if (!empty($_GET["logout"])) {
			session_unset();
			session_destroy();
			session_start();
			setcookie('id', NULL, time() + 60 * 60 * 24 * 30);
			setcookie('visibility', NULL, time() + 60 * 60 * 24 * 30);

			foreach ($_COOKIE as $c_id => $c_value) {
				setcookie($c_id, NULL, time() + 60 * 60 * 24 * 30, "/", ".domain.name");
			}
			header("location:index.php");
			exit;
		}


		//check what is the current visibility and
		// if the page visibility is greater than the user visibility redirect to home page
		if (empty($_COOKIE["visibility"])) {
			$_COOKIE["visibility"] = CommonAction::$VISIBILITY_PUBLIC;
		}

		if ($_COOKIE["visibility"] < $this->page_visibility) {
			header("location:index.php");
			exit;
		}

		if (!empty($_GET["token"])) {
			$_SESSION["referral"] = $_GET["token"];
			header('Location:reference.php');
		}
		//check if they're is a connection token and test it
		if (!empty($_GET["user_t"])) {
			$id = UsersDAO::getUserFromToken($_GET["user_t"]);

			//if token is working
			if (!empty($id)) {

				//get user info
				$user = UsersDAO::getUserWithID($id);
				if (count($_COOKIE) > 0) {
					setcookie('visibility', intval($user['visibility']), time() + 60 * 60 * 24 * 365, '/');
					setcookie('id', intval($user['id']), time() + 60 * 60 * 24 * 365, '/');
				} else {
?>
					<script>
						alert("Veuillez activez les cookies... Le Kikiclub n''est pas fonctionnel sinon...")
					</script>
<?php
				}
				//delete token
				UsersDAO::deleteToken($_GET["user_t"]);
				UsersConnexionDAO::insertUserConnexion($user["id"]);
				header('location:users.php');
			}
			UsersDAO::deleteToken($_GET["user_t"]);
		}


		if (!empty($_SESSION["referral"]) && $this->page_name != "reference") {
			header('location:reference.php');
		}


		//Check if admin want to be in admin mode
		if ($this->isAnim()) {
			if (!isset($_SESSION["anim_mode"])) {
				$_SESSION["anim_mode"] = false;
			}
			if (!isset($_SESSION["admin_mode"])) {
				$_SESSION["admin_mode"] = false;
			}

			if (!empty($_GET["admin"])) {
				if ($_GET["admin"] === "true") {

					if ($this->isAnim()) {
						$_SESSION["anim_mode"] = true;
					}
					if ($this->isAdmin()) {
						$_SESSION["admin_mode"] = true;
					}
				} else {
					$_SESSION["admin_mode"] = false;
					$_SESSION["anim_mode"] = false;
				}
			}

			$this->anim_mode = $_SESSION['anim_mode'];
			$this->admin_mode = $_SESSION['admin_mode'];
		}
		//translate page name
		if (strpos($this->page_name, 'error') === false && strpos($this->page_name, 'ajax') === false) {
			$this->complete_name = $this->trans->read("pages_name", $this->page_name);
		}

		if ($this->isLoggedIn()) {
			$this->user_name = UsersDAO::getUserWithID($_COOKIE["id"])['firstname'];
			$this->members = MemberDAO::selectFamily($_COOKIE["id"]);
		}

		$this->avatars = MemberDAO::loadAvatar();;
		//check if the family member exist, and if yes, show is name
		if ($this->isMember()) {
			$member = MemberDAO::selectMember($_SESSION["member_id"]);
			if ($member == null) {
				unset($_SESSION["member_id"]);
			} else {
				$this->member_name = $member["firstname"];
				$this->member_pts = $member["score"];
				$avatar = null;
				if (empty($this->avatars[$member["id_avatar"]])) {
					$avatar =  $this->avatars[0];
				} else {
					$avatar = $this->avatars[$member["id_avatar"]];
				}
				$this->member_avatar =  $avatar;
				$this->member_workshops = MemberWorkshopDAO::selectMemberWorkshopByCategories($_SESSION["member_id"]);
				if (!empty($this->member_workshops["== Yeah! J'ai réussi ces ateliers!"])) {
					$this->member_nb_completed = sizeof($this->member_workshops["== Yeah! J'ai réussi ces ateliers!"]);
				} else {
					$this->member_nb_completed = 0;
				}
			}
		}



		//execute page action
		$this->executeAction();
	}

	protected abstract function executeAction();
}
