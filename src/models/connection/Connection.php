<?php

namespace Api\Models\Connection;

use PDO;

/**
 * 
 */
class Connection {

	private $options = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
	];

	private static ?self $conn = null;
	private PDO|bool $connection;
	
	private function __construct(string $user, string $password) {
		try {
			$this->connection = new PDO("mysql:host=" . ($_ENV['HOST_DB']) . ";dbname=" . ($_ENV['NAME_DB']) . ";" . "charset=utf8", $user, $password, $this->options);
		} catch (PDOException $e) {
			$this->connection = false;
		}
	}

	public static function getInstance() {
		if(!self::$conn) {
			self::$conn = new connection($_ENV['USER_DB'], $_ENV['PASSWORD_DB']);
		}

		return self::$conn;
	}

	public function getPrepareStatement($sql) {
		return $this->connection->prepare($sql);
	}

	public function getBindParam($ps, $object, ?array $methods = []) {
  		// Filtramos sólo los métodos que empiecen con "get"
		$methods = array_filter(empty($methods) ? get_class_methods($object) : $methods, function($method) {
			return strpos($method, 'get') === 0;
		});

  		// Iteramos sobre los métodos y asignamos sus valores devueltos a los parámetros del prepared statement
		foreach ($methods as $method) {
			// Almacenamos el valor de la función en la variable `$valor`.
			$value = $object->$method();
    		// Asignamos el valor devuelto al parámetro del prepared statement con el mismo nombre que el método
			$ps->bindParam(":" . lcfirst(substr($method, 3)), $value, $this->setTypes($value));
		}

  		// Devolvemos el resultado
		return $ps;
	}

	private function setTypes(string $value): int {

  		// Comprobamos el tipo de dato de $value
		switch (gettype($value)) {

			case 'integer':
			return PDO::PARAM_INT;

			case 'boolean':
			return PDO::PARAM_BOOL;

			case 'NULL':
			return PDO::PARAM_NULL;

			default:
			return PDO::PARAM_STR;

		}

	}

	public function getFetch($preparedStatement): array {
		// Ejecutamos la consulta preparada
		$execute = $preparedStatement->execute();

		// Si la ejecución fue exitosa, devolvemos el resultado en un array con el status y la información
		if ($execute) {
			$info = $preparedStatement->rowCount() === 1 ? $preparedStatement->fetch() : ($preparedStatement->rowCount() > 1 ? $preparedStatement->fetchAll() : $preparedStatement->errorInfo());
			return ['status' => true, 'info' => $info];
		}
		// Si hubo un error, devolvemos el status y el error
		else {
			return ['status' => false, 'info' => $preparedStatement->errorInfo()];
		}
	}

}