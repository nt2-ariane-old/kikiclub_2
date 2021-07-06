<?php
	require_once("../action/DAO/Connection.php");

	/**
	 * Access to all the member's workshops related informations in the database
	 *
	 * @link       https://kikicode.club/action/DAO/MemberWorkshopDAO
	 * @since      Class available since Alpha 1.0.0
	 */
	class MemberWorkshopDAO {

		/**
		 * Select all member's workshop sorted with the different parameters
		 *
		 * @param integer   $id_member  id of the member you wanna see the workshops
		 * @param string   $orderby with columns you want it ordered
		 * 						none : don't order by
		 * 						NAME : ordered by name
		 *						ID 	 : ordered by ID
		 * @param bool   $ascendant ordered ascendant(true) or decendant(false)
		 * @param bool   $deployed do you want only the deployed workshops ?
		 * @param integer   $page page of the workshop (12 workshops per pages)
		 * 						-1 : do not limit
		 * 						else : limit per pages
		 *
		 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
		 * @return Array return all the member workshops sorted with the parameters
		 */
		public static function getMemberWorkshopsSorted($id_member,$orderby="none",$ascendant=false, $deployed=true, $page=-1) { //RECEVOIR TOUTES LES PAGES
			$connection = Connection::getConnection();

			$request = "SELECT * FROM workshops WHERE id IN (SELECT ID_WORKSHOP FROM member_workshops WHERE ID_MEMBER=?) ";

			if($deployed)
			{
				$request .= "AND deployed = TRUE ";
			}

			if($orderby != "none")
			{
				if($orderby == "name")
				{
					$request .= "ORDER BY NAME ";
				}
				else if($orderby == "id")
				{
					$request .= "ORDER BY ID ";
				}

				if($ascendant)
				{
					$request .= "ASC ";
				}
				else
				{
					$request .= "DESC ";
				}
			}
			if($page >= 0)
			{
				$request .= " LIMIT ?,12";
			}
			$statement = $connection->prepare($request);
			$statement->setFetchMode(PDO::FETCH_ASSOC);

			$statement->bindParam(1, $id_member);
			if($page >= 0)
			{
				$limit = $page * 12;
				$statement->bindParam(2, $limit);

			}
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
		}

		/**
		 * Select all informations about a member's workshops
		 * 		ex : statut : if it's new, in-progress or completed
		 *
		 * @param integer   $id_member  id of the member you wanna see the workshops
		 *
		 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
		 * @return Array return all information about the member workshops
		 */
		public static function selectMemberWorkshop($id_member)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT * FROM member_workshops WHERE ID_MEMBER=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id_member);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[$row["id_workshop"]] = $row;
			}

			return $content;
		}

		public static function selectMemberWorkshopByCategories($id_member)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT w.id as id, ws.name_fr as statut, id_workshop, w.name as name, w.media_path as media_path, w.media_type as media_type FROM member_workshops as mw JOIN workshop_statut as ws JOIN workshops as w WHERE ID_MEMBER=? AND mw.id_statut = ws.id AND mw.id_workshop = w.id ");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id_member);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[$row["statut"]][] = $row;
			}

			return $content;
		}

		/**
		 * Select all new workshops from a member
		 *
		 * @param integer   $id_member  id of the member you wanna see the new workshops
		 *
		 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
		 * @return Array return all information about the new workshops
		 */
		public static function selectMemberNewWorkshop($id_member)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT * FROM workshops WHERE ID IN (SELECT id_workshop FROM member_workshops WHERE id_member=? AND id_statut = 1 )  AND deployed = TRUE");

			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id_member);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
		}

		/**
		 * Assign a workshop to a member
		 *
		 * @param integer   $id_member  id of the member you wanna assign a workshop
		 * @param integer   $id_workshop  id of the workshop
		 * @param integer   $id_statut  id of the statut of the workshop (ex : new, in-progress, completed)
		 *
		 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
		 * @return void
		 */
		public static function addMemberWorkshop($id_member,$id_workshop, $id_statut)
		{
			$connection = Connection::getConnection();

			$request = "INSERT INTO member_workshops(id_member, id_workshop, id_statut) VALUES (?,?,?)";
			$statement = $connection->prepare($request);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id_member);
			$statement->bindParam(2, $id_workshop);
			$statement->bindParam(3, $id_statut);

			$valide = $statement->execute();
			$valide = $statement->errorInfo();
			
			return $valide;
		}

		/**
		 * Update a member's workshop
		 *
		 * @param integer   $id_member  id of the member you wanna assign a workshop
		 * @param integer   $id_workshop  id of the workshop
		 * @param integer   $id_statut  id of the statut of the workshop (ex : new, in-progress, completed)
		 *
		 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
		 * @return void
		 */
		public static function updateMemberWorkshop($id_member,$id_workshop, $statut)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("UPDATE member_workshops SET ID_STATUT = ?, LAST_MODIFICATION=CURRENT_TIMESTAMP WHERE ID_MEMBER = ? AND ID_WORKSHOP=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $statut);
			$statement->bindParam(2, $id_member);
			$statement->bindParam(3, $id_workshop);
			$statement->execute();
		}

	}