<?php
	require_once("../action/DAO/Connection.php");

	class RobotDAO {

		public static function getRobots($keys=false)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT * FROM robot");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				if($keys)
				{
					$content[$row["id"]] = $row;
				}
				else
				{
					$content[] = $row;
				}
			}

			return $content;
			return 'hello';
		}

		// public static function deleteRobot($id)
		// {
		// 	$connection = Connection::getConnection();
		// 	$statement = $connection->prepare("DELETE FROM robot WHERE ID=?");
		// 	$statement->bindParam(1, $id);
		// 	$statement->execute();
		// }
		// public static function insertRobot($name,$gradeRecommanded,$media_path,$media_type,$description)
		// {
		// 	$connection = Connection::getConnection();
		// 	$statementRobots = $connection->prepare("INSERT INTO robot(NAME,ID_GRADE,MEDIA_PATH,MEDIA_TYPE,DESCRIPTION) VALUES (?,?,?,?,?)");
		// 	$statementRobots->bindParam(1, $name);
		// 	$statementRobots->bindParam(2, $gradeRecommanded);
		// 	$statementRobots->bindParam(3, $media_path);
		// 	$statementRobots->bindParam(4, $media_type);
		// 	$statementRobots->bindParam(5, $description);

		// 	$statementRobots->setFetchMode(PDO::FETCH_ASSOC);
		// 	$statementRobots->execute();
		// }
		// public static function updateRobot($id,$name,$gradeRecommanded,$media_path,$media_type,$description)
		// {
		// 	$connection = Connection::getConnection();
		// 	$statementRobots = $connection->prepare("UPDATE robot SET NAME=?,ID_GRADE=?,media_path=?,media_type=?,description=? WHERE ID=?");
		// 	$statementRobots->bindParam(1, $name);
		// 	$statementRobots->bindParam(2, $gradeRecommanded);
		// 	$statementRobots->bindParam(3, $media_path);
		// 	$statementRobots->bindParam(4, $media_type);
		// 	$statementRobots->bindParam(5, $description);
		// 	$statementRobots->bindParam(6, $id);

		// 	$statementRobots->setFetchMode(PDO::FETCH_ASSOC);
		// 	$statementRobots->execute();
		// }
		// public static function getRobotsAndDifficultiesByNAME($name)
		// {
		// 	$name = '%'.$name.'%';
		// 	$connection = Connection::getConnection();
		// 	$statementRobots = $connection->prepare("SELECT * FROM robot WHERE name LIKE ?");
		// 	$statementRobots->bindParam(1, $name);
		// 	$statementRobots->setFetchMode(PDO::FETCH_ASSOC);
		// 	$statementRobots->execute();

		// 	$content = [];

		// 	while ($row = $statementRobots->fetch()) {
		// 		$temp = [] ;
		// 		$temp["robots"] = $row;
		// 		$temp["scores"] = RobotDAO::getDifficultyScoresForRobot($row["id"]);
		// 		$content[] = $temp;
		// 	}

		// 	return $content;
		// }

		// public static function getRobotsAndDifficultiesByID($id)
		// {
		// 	$connection = Connection::getConnection();
		// 	$statementRobots = $connection->prepare("SELECT * FROM robot WHERE id = ?");
		// 	$statementRobots->bindParam(1, $id);
		// 	$statementRobots->setFetchMode(PDO::FETCH_ASSOC);
		// 	$statementRobots->execute();

		// 	$content = [];

		// 	if ($row = $statementRobots->fetch()) {
		// 		$content["robots"] = $row;
		// 		$content["scores"] = RobotDAO::getDifficultyScoresForRobot($row["id"]);
		// 	}

		// 	return $content;
		// }

		// public static function getRobotByName($name)
		// {
		// 	$connection = Connection::getConnection();
		// 	$statementRobots = $connection->prepare("SELECT * FROM robot WHERE name=?");
		// 	$statementRobots->bindParam(1, $name);
		// 	$statementRobots->setFetchMode(PDO::FETCH_ASSOC);
		// 	$statementRobots->execute();

		// 	$content = [];

		// 	if ($row = $statementRobots->fetch()) {

		// 		$content = $row;
		// 	}

		// 	return $content;
		// }
		// public static function getRobotByID($id)
		// {
		// 	$connection = Connection::getConnection();
		// 	$statementRobots = $connection->prepare("SELECT * FROM robot WHERE id=?");
		// 	$statementRobots->bindParam(1, $id);
		// 	$statementRobots->setFetchMode(PDO::FETCH_ASSOC);
		// 	$statementRobots->execute();

		// 	$content = [];

		// 	if ($row = $statementRobots->fetch()) {

		// 		$content = $row;
		// 	}

		// 	return $content;
		// }
		// public static function insertRobotScoreByDifficulty($id_robot,$id_difficulty,$score)
		// {
		// 	$connection = Connection::getConnection();

		// 	$statementRobots = $connection->prepare("INSERT INTO workshop_score(id_robot,id_difficulty,score) VALUES (?,?,?)");

		// 	$statementRobots->bindParam(1, $id_robot);
		// 	$statementRobots->bindParam(2, $id_difficulty);
		// 	$statementRobots->bindParam(3, $score);

		// 	$statementRobots->execute();
		// }

		// public static function updateRobotScoreByDifficulty($id_robot,$id_difficulty,$score)
		// {
		// 	$connection = Connection::getConnection();

		// 	$statementRobots = $connection->prepare("UPDATE workshop_score SET score=? WHERE id_robot = ? AND id_difficulty=?");

		// 	$statementRobots->bindParam(1, $score);
		// 	$statementRobots->bindParam(2, $id_robot);
		// 	$statementRobots->bindParam(3, $id_difficulty);

		// 	$statementRobots->execute();
		// }

		// public static function getScoreOfRobotByDifficulty($id_robot,$id_difficulty)
		// {
		// 	$connection = Connection::getConnection();

		// 	$statement = $connection->prepare("SELECT score FROM workshop_score WHERE id_robot = ? AND id_difficulty = ?");

		// 	$statement->bindParam(1, $id_robot);
		// 	$statement->bindParam(2, $id_difficulty);

		// 	$statement->setFetchMode(PDO::FETCH_ASSOC);
		// 	$statement->execute();

		// 	$score = 0;

		// 	if ($row = $statement->fetch()) {
		// 		$score = $row["score"];
		// 	}

		// 	return $score;
		// }
		// public static function getDifficultyScoresForRobot($id)
		// {
		// 	$connection = Connection::getConnection();

		// 	$statementRobots = $connection->prepare("SELECT d.name_en AS difficulty, s.id_difficulty AS id_difficulty, s.score AS score FROM workshop_score AS s INNER JOIN difficulty AS d WHERE s.id_difficulty = d.id AND s.id_robot = ?");

		// 	$statementRobots->bindParam(1, $id);

		// 	$statementRobots->setFetchMode(PDO::FETCH_ASSOC);
		// 	$statementRobots->execute();

		// 	$content = [];

		// 	while ($row = $statementRobots->fetch()) {
		// 		$content[] = $row;
		// 	}

		// 	return $content;
		// }

}