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

	public function getBindValue(bool $inverted, $ps, Object $object, array $function) {
    	$methods = get_class_methods($object);
		$count = 1;
    	
    	if (!$inverted) { // Para traer los que s equieren.
    		foreach ($function as $key => $value) {
    			$ps->bindValue($count++, $object->$value(), $this->setType($object->$value()));
    		}
    	}else { // Para ignorar los otros.
    		$index = null;

    		for ($i = 0; $i < count($function); $i++) { 
    			$index = array_search($function[$i], $methods);
    			unset($methods[$index]);
    		}

    		$methods = array_values($methods);

    		foreach ($methods as $key => $value) {
    			$ps->bindValue($count++, $object->$value());
    			//echo $count++ . " - " . $value . " ";
    		}
    	}

    	return $ps;
    }

    private function setType($var) {
		$type = gettype($var);
		switch ($type) {
			case 'integer':
				case 'boolean':
					return PDO::PARAM_INT;
					break;

			case 'string':
				return PDO::PARAM_STR;
				break;
			
			default:
				return PDO::PARAM_STR;
				break;
		}
	}

	public function getFetch($PreparedStatement, $option) {
		return $PreparedStatement->execute() ? (!$option ? $PreparedStatement->fetch() : $PreparedStatement->fetchAll()) : $PreparedStatement->errorInfo();
	}

	public function getExecute($PreparedStatement) {
		return $PreparedStatement->execute() ? true : $PreparedStatement->errorInfo();
	}

}