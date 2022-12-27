<?php

// Se define el namespace de la entidad.
namespace Api\Entities;

// Usar la interfaz de las entidades.
use Api\Interfaces\iEntity;

/**
 * La clase `Users` es una clase de PHP que se encarga de realizar operaciones CRUD (crear, leer, actualizar y eliminar) en una tabla de usuarios en una base de datos. Esta clase implementa una interfaz llamada "iEntity" que define los métodos necesarios para realizar estas operaciones. La clase `Users` proporciona una implementación para estos métodos y también tiene un constructor y varios métodos de acceso y modificación (`getters` y `setters`) para los atributos de la clase. Los métodos `create()`, `read()`, `update()` y `delete()` tienen un parámetro llamado `query` que indica la operación a realizar y devuelven una cadena con la consulta SQL correspondiente a la operación especificada.
 */
class Users implements iEntity {
	
	private string $table = $_ENV['NAME_DB'] . ".users";
	private int $id;
	private string $documentType;
	private int $document;
	private string $name;
	private string $lastName;
	private string $email;
	private ?int $phone;
	private string $gender;
	private string $account;

	public function __construct(int $id = NULL, string $documentType = NULL, int $document = NULL, string $name = NULL, string $lastName = NULL, string $email = NULL, ?int $phone = NULL, string $gender = NULL, string $account = NULL) {
		$this->id = $id;
		$this->documentType = $documentType;
		$this->document = $document;
		$this->name = $name;
		$this->lastName = $lastName;
		$this->email = $email;
		$this->phone = $phone;
		$this->gender = $gender;
		$this->account = $account;
	}

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): Users {
        $this->id = $id;
        return $this;
    }

    public function getDocumentType() {
        return $this->documentType;
    }

    public function setDocumentType($documentType) {
        $this->documentType = $documentType;
        return $this;
    }

    public function getDocument() {
        return $this->document;
    }

    public function setDocument($document) {
        $this->document = $document;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }

    public function getGender() {
        return $this->gender;
    }

    public function setGender($gender) {
        $this->gender = $gender;
        return $this;
    }

    public function getAccount() {
        return $this->account;
    }

    public function setAccount($account) {
        $this->account = $account;
        return $this;
    }

    public function create(string $query); string {
    	$create = [
    		"createUser" => "INSERT INTO {$this->table} (?, ?, ?, ?, ?, ?)"
    	];
    }

    public function read(string $query): string {
    	$read = [
    		"readUsers" => "SELECT * FROM {$this->table}"
    	];

    	return $read[$query];
    }

    public function update(string $query): string {
    	$update = [
    		"updateUsers" => "UPDATE {$this->table} SET name = ?"
    	];

    	return $update[$query];
    }


    public function delete(string $query): string {
    	$delete = [
    		"deleteUsers" => "DELETE FROM {$this->table} WHERE {$this->table}.id = ?"
    	];

    	return $delete[$query];
    }

}