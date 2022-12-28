<?php

// Se define el namespace del modelo.
namespace Api\Models;

// Se llama a la interfaz general.
use Api\Interfaces\iConstructor;

// Se llama la conexión a la base de datos.
use Api\Models\Connection\Connection;

// Se llama la entidad.
use Api\Models\Entities\Users;

/**
 * El modelo `UsersModel` es una clase de PHP que se encarga de establecer una conexión a una base de datos. Esta clase tiene un atributo privado llamado `connection` que es una instancia de la clase `Connection`, que se encarga de realizar la conexión a la base de datos. La clase `UsersModel` tiene un constructor que se encarga de inicializar el atributo `connection` al invocar al método `getInstance()` de la clase `Connection`. Este método es un método estático que se encarga de crear una única instancia de la clase `Connection` para toda la aplicación y devolverla al invocarlo.
 */
final class UsersModel implements iConstructor {

	// Se declara una atributo de tipo `Connection`.
	private Connection $connection;

	public function __construct() {
		// Se crear una nueva instancia de la clase `Connection` y se almacena en el atributo `$connection`.
		$this->connection = Connection::getInstance();
	}

	// Crear un nuevo {registro}.
	public function createUserDB(Users $user): bool {
		$ps = $this->connection->getPrepareStatement($user->create("createUser"));
		$ps = $this->connection->getBindParam($ps, $user, ['getNameUser']);
		
		return $ps->execute() ? ['status' => true, 'info' => 'Se ha creado el {registro} correctamente.'] : ['status' => false, 'info' => 'No se ha podido crear el {registro}. Ya hemos enviado el reporte.', 'error' => $ps->errorInfo()];
	}

	// Lee la lista completa de los {registro}s.
	public function readUsersDB(Users $user): array {
		$ps = $this->connection->getPrepareStatement($user->read("readUsers"));

		$response = $this->connection->getFetch($ps);

		return $response['status'] ? $response : ['status' => false, 'info' => 'Ha ocurrido un error al leer los {registro}s. Ya hemos reportado el problema.', 'error' => $response['info']];
	}

	// Lee la información de 1 sólo {registro}.
	public function readUserDB(Users $user): array {
		$ps = $this->connection->getPrepareStatement($user->read("readUser"));

		$response = $this->connection->getFetch($ps);

		return $response['status'] ? $response : ['status' => false, 'info' => 'Ha ocurrido un error al leer el {registro}. Ya hemos reportado el problema.', 'error' => $response['info']];
	}

	// Actualizar un {registro}.
	public function updateUserDB(Users $user): bool {
		$ps = $this->connection->getPrepareStatement($user->update("updateUser"));
		$ps = $this->connection->getBindParam($ps, $user, ['getNameUser', 'getIdUser']);
		
		return $ps->execute() ? ['status' => true, 'info' => 'Se ha actualizado el {registro} correctamente.'] : ['status' => false, 'info' => 'No se ha podido actualizar el {registro}. Ya hemos enviado el reporte.', 'error' => $ps->errorInfo()];
	}

	// Eliminar un {registro}.
	public function deleteUserDB(Users $user): bool {
		$ps = $this->connection->getPrepareStatement($user->delete("deleteUser"));
		$ps = $this->connection->getBindParam($ps, $user, ['getIdUser']);
		
		return $ps->execute() ? ['status' => true, 'info' => 'Se ha eliminado el {registro} correctamente.'] : ['status' => false, 'info' => 'No se ha podido eliminar el {registro}. Ya hemos enviado el reporte.', 'error' => $ps->errorInfo()];
	}

}