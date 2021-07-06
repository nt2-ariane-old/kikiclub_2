<?php
require_once("../action/DAO/Connection.php");

	class UsersConnexionDAO {

		public static function getUserConnexion($id_user,$last=false,$id_connexion=null)
		{
			$request = "SELECT * FROM users_connexion WHERE id_user = ? ";
            if(!empty($id_connexion))
            {
                $request .= "AND id=? ";
            }
            if($last)
            {
				$request .= " ORDER BY date DESC LIMIT 1";
            }
			
			$connection = Connection::getConnection();
			$statement = $connection->prepare($request);
            $statement->bindParam(1, $id_user);
			if(!empty($id_connexion))
			{
				$statement->bindParam(2, $id_connexion);
			}

			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
        }
        public static function insertUserConnexion($id_user)
		{
			$request = "INSERT INTO users_connexion(id_user) VALUES (?)";
			$connection = Connection::getConnection();
			$statement = $connection->prepare($request);
            $statement->bindParam(1, $id_user);
			$statement->execute();
        }
        public static function testRegisterToken($token)
		{
			$request = "SELECT * FROM users WHERE token=?";
            
			$connection = Connection::getConnection();
			$statement = $connection->prepare($request);
            $statement->bindParam(1, $token);

			$statement->setFetchMode(PDO::FETCH_ASSOC);
            $statement->execute();
            
            $content = null;
            if($row = $statement->fetch())
            {
                $content = $row;
            }
            return $content;
        }
        public static function addReferance($id_referrer, $id_referral)
        {
            $request = "INSERT INTO referral(referrer,referree) VALUES(?,?)";
            
			$connection = Connection::getConnection();
			$statement = $connection->prepare($request);
            $statement->bindParam(1, $id_referrer);
            $statement->bindParam(2, $id_referral);
            
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $valide = $statement->execute();
            return $valide;
        }
    }