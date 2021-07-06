<?php
	require_once("../action/DAO/Connection.php");

	class WorkshopDAO {

		/**
		 * Select all member's workshop sorted with the different parameters
		 *
		 * @param integer   $id  null for the moment, to match MemberWorkshop::getMemberWorkshopsSorted
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
		 * @return Array return all the workshops sorted with the parameters
		 */
		public static function getWorkshops($id=null,$orderby="none",$ascendant=false, $deployed=true, $page=-1) { //RECEVOIR TOUTES LES PAGES
			$connection = Connection::getConnection();
			$request = "SELECT * FROM workshops ";

			if($deployed)
			{
				$request .= "WHERE deployed = TRUE ";
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

			if($page >= 0)
			{
				$limit = $page * 12;
				$statement->bindParam(1, $limit);

			}
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}
			return $content;
		}

		/**
		 * Select all informations about a workshop
		 *
		 * @param integer   $id  id of the workshop you wanna get
		 *
		 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
		 * @return Array return all information about the workshop
		 */
		public static function getWorkshop($id)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT * FROM workshops WHERE id=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id);
			$statement->execute();

			$content = [];

			if ($row = $statement->fetch()) {
				$content = $row;
			}

			return $content;
		}

		public static function getMaterials()
		{
			$connection = Connection::getConnection();


			$statement = $connection->prepare("SELECT * FROM material");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
		}
		public static function getMaterialByID($id)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT * FROM material WHERE id=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id);
			$statement->execute();

			$content = [];

			if ($row = $statement->fetch()) {
				$content = $row;
			}

			return $content;
		}
		public static function getMaterialByValue($value)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT * FROM material WHERE name=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $value);
			$statement->execute();

			$content = [];

			if ($row = $statement->fetch()) {
				$content = $row;
			}

			return $content;
		}
		public static function insertMaterial($name)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("INSERT INTO material(name) VALUES (?)");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $name);
			$existe = $statement->execute();
			return $existe;
		}
		public static function updateMaterial($id_material,$value)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("UPDATE material SET name=? WHERE id = ?");
			$statement->bindParam(1, $value);
			$statement->bindParam(2, $id_material);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$valide = $statement->execute();
			return $valide;
		}
		public static function deleteMaterial($id)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("DELETE FROM material WHERE id=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id);
			$valide = $statement->execute();
			return $valide;
		}
		public static function getWorkshopsMaterial($id,$with_name=false)
		{
			$connection = Connection::getConnection();

			if($with_name)
			{
				$request = "SELECT m.name as material, wm.id_workshop as workshop, wm.nb as nb FROM workshop_materials as wm INNER JOIN material as m WHERE id_workshop=? AND wm.id_material = m.id";
			}
			else
			{
				$request = "SELECT id_material as material, id_workshop as workshop, nb as nb FROM workshop_materials WHERE id_workshop=?";
			}
			$statement = $connection->prepare($request);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
		}

		public static function insertWorkshopMaterial($id_material,$id_workshop,$value)
		{
			$connection = Connection::getConnection();
			
			$statement = $connection->prepare("INSERT INTO workshop_materials(id_material,id_workshop,nb) VALUES (?,?,?)");
			$statement->bindParam(1, $id_material);
			$statement->bindParam(2, $id_workshop);
			$statement->bindParam(3, $value);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$valide = $statement->execute();
			return $valide;
		}
		public static function updateWorkshopMaterial($id_material,$id_workshop,$value)
		{
			$connection = Connection::getConnection();
			
			$statement = $connection->prepare("UPDATE workshop_materials SET nb=? WHERE id_material=? AND id_workshop=?");
			
			$statement->bindParam(1, $value);
			$statement->bindParam(2, $id_material);
			$statement->bindParam(3, $id_workshop);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$valide = $statement->execute();
			return $valide;
		}
		
		public static function deleteWorkshopMaterial($id_material,$id_workshop)
		{
		
			
			$connection = Connection::getConnection();
			
			$statement = $connection->prepare("DELETE FROM workshop_materials WHERE id_material=? and id_workshop=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id_material);
			$statement->bindParam(2, $id_workshop);

			$statement->execute();

		}
		/**
		 * Select all informations about a workshop by Name and Content (ex : when you don't have the id)
		 *
		 * @param string   $name  name of the workshop you wanna get
		 * @param string   $content  content of the workshop you wanna get
		 *
		 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
		 * @return Array return all information about the workshop
		 */
		public static function getWorkshopByNameAndContent($name,$content)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT * FROM workshops WHERE name=? AND content=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $name);
			$statement->bindParam(2, $content);

			$statement->execute();

			$content = [];

			if ($row = $statement->fetch()) {
				$content= $row;
			}

			return $content;
		}

		/**
		 * Select all workshops that matche the name
		 *
		 * @param string   $name  name of the workshop you wanna get
		 * @param bool   $deployed  do you only want deployed workshops? : Default -> true
		 *
		 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
		 * @return Array return all information about the workshops
		 */
		public static function getWorkshopsLikeName($name, $deployed=true) { //RECEVOIR TOUTES LES PAGES
			$connection = Connection::getConnection();
			$name = '%' . $name . '%';

			$request = "SELECT * FROM workshops WHERE NAME LIKE ? ";
			if($deployed)
			{
				$request .= "AND deployed = TRUE";
			}
			$statement = $connection->prepare($request);
			$statement->bindParam(1, $name);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
		}

		/**
		 * Create a new workshop
		 *
		 * @param string   $name  name of the workshop
		 * @param string   $content  content of the workshop
		 * @param string   $media_path  path of the media
		 * @param string   $media_type  type of the media
		 * @param bool   $deployed  is it deployed?
		 *
		 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
		 * @return void
		 */
		public static function addWorkshop($name, $content, $media_path, $media_type,$deployed){
			$connection = Connection::getConnection();
			$request = "INSERT INTO workshops(name,content,media_path, media_type,deployed) VALUES (?,?,?,?,";
			if($deployed)
			{
				$request .= "TRUE";
			}
			else
			{
				$request .= "FALSE";
			}
			$request .= ")";
			$statement = $connection->prepare($request);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $name);
			$statement->bindParam(2, $content);
			$statement->bindParam(3, $media_path);
			$statement->bindParam(4, $media_type);

			$statement->execute();
		}

		/**
		 * Update a workshop infos
		 *
		 * @param string   $id  id of the workshop
		 * @param string   $name  name of the workshop
		 * @param string   $content  content of the workshop
		 * @param string   $media_path  path of the media
		 * @param string   $media_type  type of the media
		 * @param bool   $deployed  is it deployed?
		 *
		 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
		 * @return void
		 */
		public static function updateWorkshop($id,$name, $content, $MEDIA_PATH, $MEDIA_TYPE){
			$connection = Connection::getConnection();

			$statement = $connection->prepare("UPDATE workshops SET name=?,content=?,media_path=? , media_type=? WHERE id=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $name);
			$statement->bindParam(2, $content);
			$statement->bindParam(3, $MEDIA_PATH);
			$statement->bindParam(4, $MEDIA_TYPE);
			$statement->bindParam(5, $id);
			$statement->execute();
		}

		/**
		 * Delete a workshop
		 *
		 * @param string   $id  id of the workshop
		 *
		 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
		 * @return void
		 */
		public static function deleteWorkshop($id){
			$connection = Connection::getConnection();

			$statement = $connection->prepare("DELETE FROM workshops WHERE id=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id);
			$statement->execute();
		}

		/**
		 * Check if the workshop is deployed
		 *
		 * @param string   $id  id of the workshop
		 *
		 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
		 * @return bool
		 */
		public static function isDeployed($id)
		{
			$connection = Connection::getConnection();

			$request = "SELECT deployed FROM workshops WHERE id=?";

			$statement = $connection->prepare($request);
			$statement->bindParam(1, $id);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = null;

			if($row = $statement->fetch())
			{
				$content = $row["deployed"];
			}

			return $content;
		}

		/**
		 *  Set if the workshop is deployed or not
		 *
		 * @param string   $id  id of the workshop
		 * @param bool   $deployed  is the workshop deployed?
		 *
		 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
		 * @return void
		 */
		public static function setDeployed($id,$deployed)
		{
			$connection = Connection::getConnection();

			$request = "UPDATE workshops SET ";
			if($deployed == "true")
			{
				$request .= "deployed=TRUE ";
			}
			else
			{
				$request .= "deployed=FALSE ";
			}
			$request.="WHERE id=?";

			$statement = $connection->prepare($request);
			$statement->bindParam(1, $id);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
		}

	}
