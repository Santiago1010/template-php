<?php

namespace Api\Functions;

// Se llama a la interfaz general.
use Api\Interfaces\iConstructor;

use Api\Models\Connection\Connection;

/**
 * 
 */
class DataBase implements iConstructor {
	
	private Connection $connection;
	
	public function __construct() {
		$this->connection = Connection::getInstance();
	}

	public function readColumns(string $table): array {
		$ps = $this->connection->getPrepareStatement("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '{$_ENV['NAME_DB']}' AND TABLE_NAME = '{$table}'");
		return $this->connection->getFetch($ps, true);
	}

}