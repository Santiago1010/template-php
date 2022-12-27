<?php

namespace Api\Interfaces;

interface iEntity {

	public function create(string $query); string
	public function read(string $query): string
	public function update(string $query): string
	public function delete(string $query): string

}