<?php

// Se define el namespace de la entidad.
namespace Api\Entities;

// Usar la interfaz de las entidades.
use Api\Interfaces\iEntity;

/**
 * La entidad `Users` es una clase de PHP que se encarga de realizar operaciones CRUD (crear, leer, actualizar y eliminar) en una tabla de usuarios en una base de datos. Esta clase implementa una interfaz llamada 'iEntity' que define los métodos necesarios para realizar estas operaciones. La clase `Users` proporciona una implementación para estos métodos y también tiene un constructor y varios métodos de acceso y modificación (`getters` y `setters`) para los atributos de la clase. Los métodos `create()`, `read()`, `update()` y `delete()` tienen un parámetro llamado `query` que indica la operación a realizar y devuelven una cadena con la consulta SQL correspondiente a la operación especificada.
 */

class Users implements iEntity {

	private string $table = $_ENV['NAME_DB'] . ".users";
	private string $idUser;
	private string $name;

	public function __construct(string $idUser, string $name): void {
		$this->idUser = $idUser;
		$this->name = $name;
	}

	public function getIdUser(): string {
		return $this->idUser;
	}

	public function setIdUser(string $idUser): self {
		$this->idUser = $idUser;
		return $this;
	}

	public function getName(): string {
		return $this->name;
	}

	public function setName(string $name): self {
		$this->name = $name;
		return $this;
	}

	public function create(string $query); string {
    	$create = [
    		"createuser" => "INSERT INTO users (?, ?, ?, ?)"
    	];

    	return $create[$query];
    }

    public function read(string $query): string {
    	$read = [
    		"readUsers" => "SELECT * FROM users"
    	];

    	return $read[$query];
    }

    public function update(string $query): string {
    	$update = [
    		"updateUsers" => "UPDATE users SET name = ? WHERE id = ?"
    	];

    	return $update[$query];
    }


    public function delete(string $query): string {
    	$delete = [
    		"deleteuser" => "DELETE FROM users WHERE id = ?"
    	];

    	return $delete[$query];
    }

}