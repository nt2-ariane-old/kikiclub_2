<?php
require_once("../action/DAO/Connection.php");
require_once("../action/DAO/UsersConnexionDAO.php");
require_once("../action/DAO/MailChimpDAO.php");

class UsersDAO
{

	public static function getAllUsers()
	{
		$connection = Connection::getConnection();
		$statement = $connection->prepare("SELECT * FROM users");
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();

		$contents = [];

		while ($row = $statement->fetch()) {
			$contents[] = $row;
		}
		return $contents;
	}

	public static function getLastConnection($id)
	{
		$connection = Connection::getConnection();
		$statement = $connection->prepare("SELECT * FROM users WHERE id_user=? ORDER BY date DESC LIMIT 1");
		$statement->bindParam(1, $id);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();

		$contents = null;

		if ($row = $statement->fetch()) {
			$contents = $row;
		}
		return $contents;
	}

	public static function getUsersLikeType($value, $type)
	{
		$connection = Connection::getConnection();
		$value = $value . '%';
		$request = "SELECT * FROM users ";
		if ($type == 'firstname') {
			$request .= "WHERE firstname LIKE ?";
		} else if ($type == 'lastname') {
			$request .= "WHERE lastname LIKE ?";
		} else if ($type == 'email') {
			$request .= "WHERE email LIKE ?";
		}

		$statement = $connection->prepare($request);
		$statement->bindParam(1, $value);

		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();

		$contents = [];

		while ($row = $statement->fetch()) {
			$temp["label"] = $row[$type];
			$temp["value"] = $row["id"];
			$contents[] = $temp;
		}

		return $contents;
	}

	public static function getUserWithID($id)
	{
		$connection = Connection::getConnection();
		$statement = $connection->prepare("SELECT * FROM users WHERE id=?");
		$statement->bindParam(1, $id);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();

		$contents = null;

		if ($row = $statement->fetch()) {
			$contents = $row;
		}
		return $contents;
	}

	public static function getUserWithEmail($email)
	{
		$connection = Connection::getConnection();
		$statement = $connection->prepare("SELECT * FROM users WHERE email=?");
		$statement->bindParam(1, $email);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();

		$contents = [];

		if ($row = $statement->fetch()) {
			$contents = $row;
		}
		return $contents;
	}

	public static function getAllLoginType()
	{
		$connection = Connection::getConnection();

		$statement = $connection->prepare("SELECT * FROM login_type");
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();

		$contents = [];

		while ($row = $statement->fetch()) {
			$contents[] = $row;
		}
		return $contents;
	}
	public static function setTokenForUser($id_user, $token)
	{
		$connection = Connection::getConnection();

		$statement = $connection->prepare("INSERT INTO connect_token (id_user,token) VALUES (?,?)");
		$statement->bindParam(1, $id_user);
		$statement->bindParam(2, $token);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();
	}

	public static function deleteToken($token)
	{
		$connection = Connection::getConnection();

		$statement = $connection->prepare("DELETE FROM connect_token WHERE token=?");
		$statement->bindParam(1, $token);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();
	}

	public static function deleteUser($id)
	{
		$connection = Connection::getConnection();

		$statement = $connection->prepare("DELETE FROM users WHERE id=?");
		$statement->bindParam(1, $id);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();
	}

	public static function getUserFromToken($token)
	{
		$connection = Connection::getConnection();

		$statement = $connection->prepare("SELECT id_user FROM connect_token WHERE token=?");
		$statement->bindParam(1, $token);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();
		$id = null;
		if ($row = $statement->fetch()) {
			$id = $row["id_user"];
		}
		return $id;
	}
	public static function getLoginTypeIdByName($name)
	{
		$connection = Connection::getConnection();

		$statement = $connection->prepare("SELECT id FROM login_type WHERE NAME=?");
		$statement->bindParam(1, $name);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();

		$id = null;

		if ($row = $statement->fetch()) {
			$id = $row["id"];
		}
		return $id;
	}

	public static function addLoginInfosForUser($id_user, $id_type, $password)
	{
		$connection = Connection::getConnection();

		$statementLogin = $connection->prepare("INSERT INTO users_login(id_user,id_login_type,password) VALUES (?,?,?)");
		$statementLogin->bindParam(1, $id_user);
		$statementLogin->bindParam(2, $id_type);
		$statementLogin->bindParam(3, $password);
		$statementLogin->setFetchMode(PDO::FETCH_ASSOC);
		$statementLogin->execute();
	}


	public static function registerUser($email, $firstname, $lastname, $visibility, $token)
	{
		$connection = Connection::getConnection();

		$statement = $connection->prepare("INSERT INTO users(email,firstname,lastname,visibility,token) VALUES(?,?,?,?,?)");
		$statement->bindParam(1, $email);
		$statement->bindParam(2, $firstname);
		$statement->bindParam(3, $lastname);
		$statement->bindParam(4, $visibility);
		$statement->bindParam(5, $token);
		$statement->setFetchMode(PDO::FETCH_ASSOC);

		$statement->execute();
		
		// MailChimpDAO::addSubscriber($email, $firstname, $lastname);
	}

	public static function ConnectUser($email, $firstname, $lastname, $visibility, $token)
	{

		$connection = Connection::getConnection();
		$user = null;

		if (empty(UsersDAO::getUserWithEmail($email))) {
			UsersDAO::registerUser($email, $firstname, $lastname, $visibility, $token);
			$user = UsersDAO::getUserWithEmail($email);
		} else {
			$user = UsersDAO::getUserWithEmail($email);
		}

		return $user;
	}
	public static function updateUser($id, $email, $firstname, $lastname, $visibility)
	{
		$connection = Connection::getConnection();
		$statement = $connection->prepare("UPDATE users SET email=?,firstname=?,lastname=?,visibility=? WHERE id=?");
		$statement->bindParam(1, $email);
		$statement->bindParam(2, $firstname);
		$statement->bindParam(3, $lastname);
		$statement->bindParam(4, $visibility);
		$statement->bindParam(5, $id);

		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();
	}
}
