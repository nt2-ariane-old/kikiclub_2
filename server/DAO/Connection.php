<?php
	require_once('../action/constante.php');
	class Connection {

		private static $connection;

		public static function getConnection() {
			try
			{
				if (Connection::$connection == null) {
					Connection::$connection = new PDO("mysql:host=" . DB_HOST . ";dbname=". DB_NAME .";charset=UTF8", DB_USER, DB_PASS);

					Connection::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
					Connection::$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				}

			} catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}

			return Connection::$connection;
		}
	}