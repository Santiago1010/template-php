<?php

// Se declara el namespace de las funciones.
namespace Api\Functions;

use \Firebase\JWT\JWT;

/**
 * 
 */
class Security {

	protected function decodeAES(string $encryptedPassword): ?string {
  		// Desencriptar la contraseña utilizando AES y devolver el resultado como una cadena de texto
		$decryptedPassword = openssl_decrypt(base64_decode($encryptedPassword), 'aes-256-cbc', md5($_ENV['AES_KEY']), OPENSSL_RAW_DATA, $_ENV['AES_IV']);

		return $decryptedPassword;
	}

	protected function hashPassword(string $string): ?string {
		$first = md5($string);
		$password = crypt($string, $first);

		return password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
	}

	protected function encryptToken(string $string): string {
		$string = preg_replace('/[^A-Za-z0-9]/', '', $string);

		return strtoupper($string);
	}

	protected function validPassword(string $password, string $hash): bool {
		return password_verify($password, $hash);
	}

	protected function setInternalId(string $type): string {
		return strtoupper(uniqid(strtoupper(str_replace(' ', '_', $_ENV['APP_NAME'])) . '_' . strtoupper($type) . '_'));
	}

	protected function createJWT(array $data): string {
		$payload = [
			'code' => $data['code'],
			'document' => $data['document'],
			'name' => $data['name'],
			'lastName' => $data['lastName'],
			'rol' => $data['rol']
		];

		return JWT::encode($payload, $_ENV['AES_KEY'], 'HS256');
	}

	protected function decodeJWT(strin $jwt): array {
		try {
			return JWT::decode($jwt, $_ENV['AES_KEY'], 'HS256');
		} catch (Exception $e) {
			return null;
		}
	}

}