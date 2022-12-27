<?php

// Se define el namespace de la entidad.
namespace Api\Models\Entities;

// Usar la interfaz de las entidades.
use Api\Interfaces\iEntity;

/**
 * La entidad `Users` es una clase de PHP que se encarga de realizar operaciones CRUD (crear, leer, actualizar y eliminar) en una tabla de usuarios en una base de datos. Esta clase implementa una interfaz llamada 'iEntity' que define los métodos necesarios para realizar estas operaciones. La clase `Users` proporciona una implementación para estos métodos y también tiene un constructor y varios métodos de acceso y modificación (`getters` y `setters`) para los atributos de la clase. Los métodos `create()`, `read()`, `update()` y `delete()` tienen un parámetro llamado `query` que indica la operación a realizar y devuelven una cadena con la consulta SQL correspondiente a la operación especificada.
 */

class Users implements iEntity {

	private string $table;
	private ?string $idUser = null;
	private ?string $nameUser = null;

	public function __construct(?string $idUser = null, ?string $nameUser = null) {
		$this->table = "template.users";

		$this->idUser = $idUser;
		$this->nameUser = $nameUser;
	}

	public function getIdUser(): ?string {
		return $this->idUser;
	}

	public function setIdUser(?string $idUser = null): self {
		$this->idUser = $idUser;
		return $this;
	}

	public function getNameUser(): ?string {
		return $this->nameUser;
	}

	public function setNameUser(?string $nameUser = null): self {
		$this->nameUser = $nameUser;
		return $this;
	}

	public function create(string $query): string {
    	$create = [
    		"createUser" => "CALL createUser(?)"
    	];

    	return $create[$query];
    }

    public function read(string $query): string {
    	$read = [
    		"readUsers" => "SELECT * FROM `{$this->table}`",
    		"readUser" => "SELECT * FROM `{$this->table}` WHERE id_user = ?",
    	];

    	return $read[$query];
    }

    public function update(string $query): string {
    	$update = [
    		"updateUser" => "UPDATE `{$this->table}` SET name_user = ? WHERE id_user = ?"
    	];

    	return $update[$query];
    }


    public function delete(string $query): string {
    	$delete = [
    		"deleteUser" => "DELETE FROM `{$this->table}` WHERE id_user = ?"
    	];

    	return $delete[$query];
    }

}