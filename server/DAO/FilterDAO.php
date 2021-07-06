<?php
require_once("../action/DAO/Connection.php");

/**
 * Access to all filter related informations in the database
 *
 * @link       https://kikicode.club/action/DAO/FilterDAO
 * @since      Class available since Alpha 1.0.0
 */
class FilterDAO
{
	/**
	 * Insert a new workshop's filter
	 *
	 * @param integer   $id_workshop id of the workshop
	 * @param integer   $id_type type of the filter
	 * @param integer   $id_filter id of the filter (ex : if id_type is difficulty, id of a difficulty)
	 *
	 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
	 * @return void
	 */
	public static function insertWorkshopFilters($id_workshop, $id_type, $id_filter)
	{
		$connection = Connection::getConnection();

		$statement = $connection->prepare("INSERT INTO workshop_filters(id_workshop,id_type,id_filter) VALUES(?,?,?)");
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->bindParam(1, $id_workshop);
		$statement->bindParam(2, $id_type);
		$statement->bindParam(3, $id_filter);

		$statement->execute();
	}

	/**
	 * Update a workshop's filter
	 *
	 * @param integer   $id id of the filter
	 * @param integer   $id_workshop id of the workshop
	 * @param integer   $id_type type of the filter
	 * @param integer   $id_filter id of the filter (ex : if id_type is difficulty, id of a difficulty)
	 *
	 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
	 * @return void
	 */
	public static function updateWorkshopFilters($id, $id_workshop, $id_type, $id_filter)
	{
		$connection = Connection::getConnection();

		$statement = $connection->prepare("UPDATE workshop_filters SET id_workshop=?,id_type=?,id_filter=? WHERE id=?");
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->bindParam(1, $id_workshop);
		$statement->bindParam(2, $id_type);
		$statement->bindParam(3, $id_filter);
		$statement->bindParam(4, $id);

		$statement->execute();
	}

	/**
	 * Delete a workshop's filter
	 *
	 * @param integer   $id id of the filter
	 *
	 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
	 * @return void
	 */
	public static function deleteWorkshopFilters($id)
	{
		$connection = Connection::getConnection();

		$statement = $connection->prepare("DELETE FROM workshop_filters WHERE id=?");
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->bindParam(1, $id);

		$statement->execute();
	}

	public static function getFilters()
	{
		$connection = Connection::getConnection();

		$request = "SELECT ft.name as type, ";
		$request .= "CASE
						WHEN ft.name = 'difficulty' THEN fd.name_fr
						WHEN ft.name = 'grade' THEN fg.name_fr
						WHEN ft.name = 'robot' THEN fr.name
         				ELSE 'Inconnu'
					END AS filter ";
		$request .=	"FROM  filter_type as ft
						LEFT JOIN difficulty as fd ON (ft.name = 'difficulty')
						LEFT JOIN robot as fr ON ( ft.name = 'robot')
						LEFT JOIN scholar_level as fg ON (ft.name = 'grade')
					WHERE wt.id_workshop = ?";

		$statement = $connection->prepare($request);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->bindParam(1, $id_workshop);
		$statement->execute();

		$content = null;

		while ($row = $statement->fetch()) {
			$content[$row["type"]][$row["filter"]] = $row;
		}
		return $content;
	}
	/**
	 * Select all filters of a workshops
	 * 		ex : grade required, difficulty, etc.
	 *
	 * @param integer   $id_workshop id of the workshops you wanna see the filters
	 *
	 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
	 * @return Array return all information about the workshop's filters
	 */
	public static function getWorkshopFilters($id_workshop, $nameType = false, $nameFilter = false)
	{
		$connection = Connection::getConnection();
		if ($nameType || $nameFilter) {
			if ($nameType) {
				$request = "SELECT ft.name as type, ";
			} else {
				$request = "SELECT ft.id as type, ";
			}

			if ($nameFilter) {
				$request .= " CASE
									WHEN ft.name = 'difficulty' THEN fd.name_fr
									WHEN ft.name = 'grade' THEN fg.name_fr
									WHEN ft.name = 'robot' THEN fr.name
         							ELSE 'Inconnu'
								END AS filter ";
			} else {
				$request .= " CASE
									WHEN ft.name = 'difficulty' THEN fd.id
									WHEN ft.name = 'grade' THEN fg.id
									WHEN ft.name = 'robot' THEN fr.id
					 				ELSE -1
								END AS filter ";
			}

			$request .=	"FROM workshop_filters as wt
								LEFT JOIN filter_type as ft ON ft.id = wt.id_type
								LEFT JOIN difficulty as fd ON (fd.id = wt.id_filter AND ft.name = 'difficulty')
								LEFT JOIN robot as fr ON (fr.id = wt.id_filter AND ft.name = 'robot')
								LEFT JOIN scholar_level as fg ON (fg.id = wt.id_filter AND ft.name = 'grade')
							WHERE wt.id_workshop = ?";
		} else {
			$request = "SELECT * FROM workshop_filters WHERE id_workshop = ?";
		}
		$statement = $connection->prepare($request);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->bindParam(1, $id_workshop);
		$statement->execute();

		$content = null;

		while ($row = $statement->fetch()) {
			if ($nameType || $nameFilter) {
				$content[$row["type"]][$row["filter"]] = $row;
			} else {
				$content[$row["id_type"]][$row["id_filter"]] = $row;
			}
		}
		return $content;
	}

	/**
	 *  Get all the grades : Name in English
	 *
	 *
	 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
	 * @return Array return all the grades name in English + ID
	 */
	public static function getGradesEN($withKeys = false)
	{
		$connection = Connection::getConnection();
		$statement = $connection->prepare("SELECT id,name_en as name,age FROM scholar_level");
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();

		$content = [];

		while ($row = $statement->fetch()) {
			if ($withKeys) {
				$content[$row["id"]] = $row;
			} else {
				$content[] = $row;
			}
		}

		return $content;
	}

	/**
	 *  Get all the grades : Name in French
	 *
	 *
	 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
	 * @return Array return all the grades name in French + ID
	 */
	public static function getGradesFR($withKeys = false)
	{
		$connection = Connection::getConnection();
		$statement = $connection->prepare("SELECT id,name_fr as name,age FROM scholar_level");
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();

		$content = [];

		while ($row = $statement->fetch()) {
			if ($withKeys) {
				$content[$row["id"]] = $row;
			} else {
				$content[] = $row;
			}
		}

		return $content;
	}
	/**
	 *  Get a Grade's informations
	 *
	 * @param integer   $id  id of the grade
	 *
	 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
	 * @return Array informations about grade
	 */
	public static function getGradeById($id)
	{
		$connection = Connection::getConnection();
		$statement = $connection->prepare("SELECT id,name_fr as name,age FROM scholar_level WHERE id = ?");
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->bindParam(1, $id);
		$statement->execute();

		$content = [];

		if ($row = $statement->fetch()) {
			$content = $row;
			// $content[$row["id"]] = $row;
		}

		return $content;
	}

	/**
	 *  Get all the difficulties : Name in English
	 *
	 *
	 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
	 * @return Array return all the difficulties name in English + ID
	 */
	public static function getDifficultiesEN()
	{
		$connection = Connection::getConnection();
		$statement = $connection->prepare("SELECT id,name_en as name FROM difficulty");
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();

		$content = [];

		while ($row = $statement->fetch()) {
			//$content[$row["id"]] = $row;
			$content[] = $row;
		}

		return $content;
	}

	/**
	 *  Get all the difficulties : Name in French
	 *
	 *
	 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
	 * @return Array return all the difficulties name in French + ID
	 */
	public static function getDifficultiesFR()
	{
		$connection = Connection::getConnection();
		$statement = $connection->prepare("SELECT id,name_fr as name FROM difficulty");
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();

		$content = [];

		while ($row = $statement->fetch()) {
			$content[] = $row;
			//$content[$row["id"]] = $row;
		}

		return $content;
	}

	/**
	 *  Get all the workshop states : Name in English
	 *		new, in-progress, completed, etc
	 *
	 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
	 * @return Array return all the states in English + ID
	 */
	public static function getWorkshopStatesEN()
	{
		$connection = Connection::getConnection();
		$statement = $connection->prepare("SELECT id,name_en as name FROM workshop_statut");
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();

		$content = [];

		while ($row = $statement->fetch()) {
			$content[$row["id"]] = $row;
		}

		return $content;
	}

	/**
	 *  Get all the workshop states : Name in French
	 *		new, in-progress, completed, etc
	 *
	 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
	 * @return Array return all the states in French + ID
	 */
	public static function getWorkshopStatesFR()
	{
		$connection = Connection::getConnection();
		$statement = $connection->prepare("SELECT id,name_fr as name FROM workshop_statut");
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();

		$content = [];

		while ($row = $statement->fetch()) {
			$content[$row["id"]] = $row;
		}

		return $content;
	}

	/**
	 *  Get a Filter's type id by name
	 *
	 * @param string   $name  name of the type
	 *
	 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
	 * @return integer id of the type
	 */
	public static function getFilterTypeIdByName($name)
	{
		$connection = Connection::getConnection();

		$statement = $connection->prepare("SELECT id FROM filter_type WHERE name=?");
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->bindParam(1, $name);

		$statement->execute();

		$content = 0;

		if ($row = $statement->fetch()) {
			$content = $row["id"];
		}

		return $content;
	}
}
