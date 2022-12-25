<?php

namespace Api\Traits;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Api\Traits\Logger;

/**
 * Este Trait de PHP es una función que utiliza la librería PHPMailer para enviar correos electrónicos. El trait incluye funciones para configurar la conexión SMTP, establecer los destinatarios y el contenido del correo, y enviar el correo. Si hay algún error durante el envío del correo, se lanza una excepción y se muestra un mensaje de error.
 */
trait Email {

	private array $account;

	private function setEmail(?int $account = 0): object {
		$this->setFromOwner($account);
		$this->defineLogPath(debug_backtrace()[0]);

		// Crea una nueva instancia de PHPMailer
		$this->mail = new PHPMailer();

		// Desactiva el depurador de SMTP (envía información de depuración al navegador del cliente)
		$this->mail->SMTPDebug = 0;

		// Establece que se utilizará SMTP para enviar el correo
		$this->mail->isSMTP();

		// Establece el servidor SMTP que se utilizará para enviar el correo
		$this->mail->Host = 'smtp.gmail.com';

		// Habilita la autenticación SMTP
		$this->mail->SMTPAuth = true;

		// Establece el nombre de usuario y contraseña para la autenticación SMTP
		$this->mail->Username = $this->account['email'];
		$this->mail->Password = $this->account['password'];

		// Establece el método de seguridad utilizado para la conexión SMTP (SSL o TLS)
		$this->mail->SMTPSecure = "TLS";

		// Establece el puerto SMTP que se utilizará para la conexión
		$this->mail->Port = 587;

		// Establece la dirección de correo y el nombre del remitente del correo
		$this->mail->setFrom($this->account['email'], $this->account['name']);

		// Establece que el contenido del correo estará en formato HTML
		$this->mail->isHTML(true);

		// Establece la codificación de caracteres del correo
		$this->mail->CharSet = 'UTF-8';

		return $this;
	}

	public function setFromOwner(?int $account = 0): void {
		$accounts = [];
		$emails = explode(", ", $_ENV['ACCOUNTS_EMAIL']);
		$names = explode(", ", $_ENV['NAMES_EMAIL']);
		$passwords = explode(", ", $_ENV['PASSWORDS_EMAIL']);

		foreach ($emails as $key => $email) {
			array_push($accounts, ['email' => $email, 'name' => $names[$key], 'password' => $passwords[$key]]);
		}

		$this->account = $accounts[$account];
	}

	public function setRecipents($receivers): object {
		// Agrega una o más direcciones de correo destinatarias al correo
		foreach ($receivers as $key => $receiver) {
			$this->mail->addAddress($receiver);
		}

		return $this;
	}


	public function setContent(string $subject, string $body): object {
		// Establece el asunto del correo
		$this->mail->Subject = $subject;

		// Establece el cuerpo del correo
		$this->mail->Body = $body;

		return $this;
	}


	public function sendEmail(): array {
		// Intentamos enviar el correo y devolvemos un mensaje de éxito o un mensaje de error
		try {
			// Envía el correo y devuelve un mensaje de éxito
			$send = $this->mail->send();
			if ($send) {
			 	return ["status" => 200, "message" => "Se ha enviado el mensaje con éxito."];
			} else {
				$this->warning('No se ha podido enviar el mensaje. Error "' . $this->mail->ErrorInfo . '"');
				return ["status" => 500, "message" => "No se ha podido enviar el mensaje.", "data" => ["error" => $this->mail->ErrorInfo]];
			}
		} catch (Exception $e) {
			// Si hay un error al enviar el correo, devuelve un mensaje de error y la excepción
				$this->warning('No se ha podido enviar el mensaje. Error "' . $e . '"');
			return ["status" => 500, "message" => "No se ha podido enviar el mensaje.", "data" => ["error" => $e]];
		}
	}

}