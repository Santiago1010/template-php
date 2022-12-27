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

	public function createUser(): string {
		$user = new Users(null, $this->request->nameUser);
		return $this->model->createUserDB($user) ? $this->messsageCreated('Se ha creado el usuario.', $user) : $this->messageInternalServerError('No se ha podido crear el registro.');
	}

	public function readUsers(): string {
		$user = new Users($this->request->idUser, $this->request->nameUser);
		return $this->messageOk('Esta es la lista completa de los registros.', $this->model->readUsersDB($user));
	}

	public function readUser(): string {
		$user = new Users($this->request->idUser, $this->request->nameUser);
		return $this->messageOk('Esta es la información del registro que buscaste.', $this->model->readUserDB($user));
	}

	public function updateUser(): string {
		$user = new Users($this->request->idUser, $this->request->nameUser);
		return $this->model->updateUserDB($user) ? $this->messsageCreated('Se ha actualizado el registro.') : $this->messageInternalServerError('No se ha podido actualizar el registro.');
	}

	public function deleteUser(): string {
		$user = new Users($this->request->idUser, $this->request->nameUser);
		return $this->model->deleteUserDB($user) ? $this->messsageCreated('Se ha eliminado el registro.') : $this->messageInternalServerError('No se ha podido eliminar el registro.');
	}

}