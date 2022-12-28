<?php

// Se define el namespace de los controladores.
namespace Api\Controllers;

// Se llama a la interfaz general.
use Api\Interfaces\iConstructor;

// Se llama `AllController` y sus traits y funciones.
use Api\Controllers\AllController;

// Se llama el modelo.
use Api\Models\UsersModel;

// Se llama la entidad.
use Api\Models\Entities\Users;

/**
 * Se define una clase controladora final llamada `UsersController` que extiende de `AllController` (el cuál hereda de todas las funciones almacenadas en './src/functions/' y traits almacenados en './src/traits/') e implementa la interfaz `iConstructor`. La clase tiene un método constructor que llama al método constructor de la clase padre y luego llama al método `defineLogPath` que definirá la ruta en donde se almacenarán los logs creados (por defecto se almacenan en './src/logs/') con el resultado de la función `debug_backtrace()[0]` (que envía información como el nombre de la clase, el archivo, ubicación, etc.) como argumento.
 */
final class UsersController extends AllController implements iConstructor {

	private UsersModel $model;

	public function __construct() {
		parent::__construct(); // Se ejecuta el constructor de `AllController`.
		$this->defineLogPath(debug_backtrace()[0]); // Se define la ruta por defecto de los logs y se envía la información de la clase.
		$this->model = new UsersModel();
	}

	public function createUser(): array {
		$user = new Users(null, $this->request->nameUser);
		$response = $this->model->createUserDB($user);

		if ($response['status']) {
			$this->info("Se creó un nuevo registro con ID {$user->getIdUser()}", debug_backtrace()[0]['function']);
			return $this->messsageCreated($response['info']);
		} else {
			$this->error("No se ha podido crear el registro ({$response['error']})", debug_backtrace()[0]['function']);
			return $this->messageInternalServerError($response['info']);
		}
	}

	public function readUsers(): array {
		$user = new Users($this->request->idUser, $this->request->nameUser);
		$response = $this->model->readUsersDB($user);

		if ($response['status']) {
			return $this->messageOk('Esta es la lista completa de los registros.', $response['info']);
		} else {
			$this->error("No se ha podido actualizar el registro ({$response['error']})", debug_backtrace()[0]['function']);
			return $this->messageInternalServerError($response['info'], $response['info']);
		}
	}

	public function readUser(): array {
		$user = new Users($this->request->idUser, $this->request->nameUser);
		$response = $this->model->readUserDB($user);

		if ($response['status']) {
			return $this->messageOk('Esta es la información el registro solicitado.', $response['info']);
		} else {
			$this->error("No se ha podido leer el registro ({$response['error']})", debug_backtrace()[0]['function']);
			return $this->messageInternalServerError($response['info'], $response['error']);
		}
	}

	public function updateUser(): array {
		$user = new Users($this->request->idUser, $this->request->nameUser);
		$response = $this->model->updateUserDB($user);

		if ($response['status']) {
			return $this->messsageCreated($response['info']);
		} else {
			$this->error("No se ha podido actualizar el registro ({$response['error']})", debug_backtrace()[0]['function']);
			return $this->messageInternalServerError($response['info']);
		}
	}

	public function deleteUser(): array {
		$user = new Users($this->request->idUser, $this->request->nameUser);
		$response = $this->model->updateUserDB($user);

		if ($response['status']) {
			$this->info("Se ha eliminado el registro con ID '{$user->getIdUser()}'", debug_backtrace()[0]['function']);
			return $this->messsageCreated($response['info']);
		} else {
			$this->error("No se ha podido eliminar el registro ({$response['error']})", debug_backtrace()[0]['function']);
			return $this->messageInternalServerError($response['info']);
		}
	}

}