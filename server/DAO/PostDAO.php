<?php
	require_once("../action/DAO/Connection.php");

	class PostDAO {

		public static function getPosts($min=0,$nb=null)
		{
			$connection = Connection::getConnection();
			$request = "SELECT shared_posts.id AS id, shared_posts.title AS title,shared_posts.content AS content,shared_posts.media_path AS media_path,shared_posts.media_type AS media_type , shared_posts.id_user AS id_user, CONCAT(users.firstname, ' ',users.lastname) AS username FROM shared_posts INNER JOIN users ON shared_posts.id_user =users.id ";
			if($nb != null)
			{
				$request .= "LIMIT ?,?";
			}
			$statement = $connection->prepare($request);

			if($nb != null)
			{
				$statement->bindParam(1, $min);
				$statement->bindParam(2, $nb);
			}
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
		}
		public static function deletePost($id)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("DELETE FROM shared_posts WHERE ID=?");
			$statement->bindParam(1, $id);
			$statement->execute();
		}
		public static function insertPost($id_user,$title,$content,$media_path, $media_type)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("INSERT INTO shared_posts(TITLE,CONTENT,MEDIA_PATH,MEDIA_TYPE,ID_USER) VALUES (?,?,?,?,?)");
			$statement->bindParam(1, $title);
			$statement->bindParam(2, $content);
			$statement->bindParam(3, $media_path);
			$statement->bindParam(4, $media_type);
			$statement->bindParam(5, $id_user);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
		}
		public static function updatePost($id,$title,$content,$media_path, $media_type)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("UPDATE shared_posts SET TITLE=?,CONTENT=?,MEDIA_PATH=?,MEDIA_TYPE=? WHERE ID=?");
			$statement->bindParam(1, $title);
			$statement->bindParam(2, $content);
			$statement->bindParam(3, $media_path);
			$statement->bindParam(4, $media_type);
			$statement->bindParam(5, $id);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
		}

}