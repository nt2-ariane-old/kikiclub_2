<?php
	require_once("../action/DAO/Connection.php");

	class BadgeDAO {

		public static function getBadges($id_type=null)
		{
			$request = "SELECT  * FROM badges ";

			if(!empty($id_type))
			{
				$request .= "WHERE ID_BADGE_TYPE=? ";
			}
			$request .= "ORDER BY value_needed ASC";
			$connection = Connection::getConnection();
			$statement = $connection->prepare($request);
			if(!empty($id_type))
			{
				$statement->bindParam(1, $id_type);
			}

			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
		}


		public static function getMemberBadge($id_member)
		{
			$connection = Connection::getConnection();

			$request = "SELECT ";
			$request .= "b.ID AS id_badge, b.name AS name, b.media_path AS media_path, b.MEDIA_TYPE AS media_type, m.firstname AS owner, DATE_FORMAT(mb.won_on, '%Y-%m-%d') AS won_on ";
			$request .= "FROM member_badges AS mb INNER JOIN badges AS b INNER JOIN member as m ";
			$request .= "WHERE mb.ID_BADGE = b.ID AND mb.id_member = ? AND m.id = mb.id_member ";


			$statement = $connection->prepare($request);
			$statement->bindParam(1, $id_member);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[$row["id_badge"]] = $row;
			}

			return $content;
		}

		public static function addBadgeToMember($id_badge,$id_member,$id_user)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("INSERT INTO member_badges(id_badge,id_member,id_user,won_on) VALUES (?,?,?,CURDATE())");

			$statement->bindParam(1, $id_badge);
			$statement->bindParam(2, $id_member);
			$statement->bindParam(3, $id_user);

			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
		}

		public static function addBadge($name=null,$id_type=1, $value_needed=null,$media_path=null,$media_type=null)
		{
			$connection = Connection::getConnection();
			$request = "INSERT INTO badges(name,value_needed,id_badge_type,media_path,media_type) VALUES (?,?,?,?,?)";
			$statement = $connection->prepare($request);
			$statement->bindParam(1, $name);
			$statement->bindParam(2, $value_needed);
			$statement->bindParam(3, $id_type);
			$statement->bindParam(4, $media_path);
			$statement->bindParam(5, $media_type);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
		}

		public static function updateBadge($id,$name=null,$id_type=null, $value_needed=null,$media_path=null,$media_type=null)
		{
			$connection = Connection::getConnection();
			$request = "UPDATE badges SET name=?,value_needed=?,id_badge_type=?,media_path=?,media_type=? WHERE id=?";
			$statement = $connection->prepare($request);
			$statement->bindParam(1, $name);
			$statement->bindParam(2, $value_needed);
			$statement->bindParam(3, $id_type);
			$statement->bindParam(4, $media_path);
			$statement->bindParam(5, $media_type);
			$statement->bindParam(6, $id);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
		}

		public static function deleteBadge($id)
		{
			$connection = Connection::getConnection();
			$request = "DELETE FROM badges WHERE id=?";
			$statement = $connection->prepare($request);
			$statement->bindParam(1, $id);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
		}
		public static function getIdFromLastCreated()
		{
			$connection = Connection::getConnection();
			$request = "SELECT id FROM badges ORDER BY id DESC LIMIT 1;";
			$statement = $connection->prepare($request);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$id = 0;

			if($row = $statement->fetch())
			{
				$id = $row["id"];
			}
			return $id;
		}
		public static function getBadgeByID($id)
		{
			$connection = Connection::getConnection();
			$request = "SELECT * FROM badges WHERE id=?;";
			$statement = $connection->prepare($request);
			$statement->bindParam(1, $id);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = null;

			if($row = $statement->fetch())
			{
				$content = $row;
			}
			return $content;
		}
		public static function getBadgesType()
		{
			$connection = Connection::getConnection();
			$request = "SELECT * FROM badge_type ";
			$statement = $connection->prepare($request);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = null;

			while($row = $statement->fetch())
			{
				$content[] = $row;
			}
			return $content;
		}
}