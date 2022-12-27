<?php

// Se define el namespace del modelo.
namespace Api\Models;

// Se llama a la interfaz general.
use Api\Interfaces\iConstructor;

// Se llama la conexión a la base de datos.
use Api\Models\Connection\Connection;

// Se llama `AllController` y sus traits y funciones.
use Api\Controllers\AllController;

// Se llama la entidad.
use Api\Models\Entities\Users;

/**
 * El modelo `UsersModel` es una clase de PHP que se encarga de establecer una conexión a una base de datos. Esta clase tiene un atributo privado llamado `connection` que es una instancia de la clase `Connection`, que se encarga de realizar la conexión a la base de datos. La clase `UsersModel` tiene un constructor que se encarga de inicializar el atributo `connection` al invocar al método `getInstance()` de la clase `Connection`. Este método es un método estático que se encarga de crear una única instancia de la clase `Connection` para toda la aplicación y devolverla al invocarlo.
 */
final class UsersModel extends AllController implements iConstructor {

	// Se declara una atributo de tipo `Connection`.
	private Connection $connection;

	public function __construct() {
		// Se crear una nueva instancia de la clase `Connection` y se almacena en el atributo `$connection`.
		$this->connection = Connection::getInstance();
	}

	// Crear un nuevo registro.
	public function createUserDB(Users $user): bool {
		$ps = $this->connection->getPrepareStatement($user->create("createUser"));
		return $this->connection->getBindValue(true, $ps, $user, ['']);
	}

	// Lee la lista completa de los registros.
	public function readUsersDB(Users $user): array {
		$ps = $this->connection->getPrepareStatement($user->read("readUsers"));
		return $this->connection->getFetch($ps, true);
	}

	// Lee la información de 1 sólo registro.
	public function readUserDB(Users $user): array {
		$ps = $this->connection->getPrepareStatement($user->read("readUser"));
		return $this->connection->getFetch($this->connection->getBindValue(false, $ps, $user, ['getIdUser']), true);
	}

	public function updateUserDB(Users $user): bool {
		$ps = $this->connection->getPrepareStatement($user->update("updateUser"));
		return $this->connection->getFetch($this->connection->getBindValue(false, $ps, $user, ['getName', 'getIdUser']), true);
	}

	public function deleteUserDB(Users $user): bool {
		$ps = $this->connection->getPrepareStatement($user->delete("deleteUser"));
		return $this->connection->getFetch($this->connection->getBindValue(false, $ps, $user, ['getIdUser']), true);
	}

}