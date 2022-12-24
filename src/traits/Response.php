<?php

namespace Api\Traits;

trait Response {

	private function jsonParser(array $response): string {
		return json_encode($response, JSON_UNESCAPED_UNICODE);
	}

	// Códigos de estado de éxito.

	protected function messageOk(?string $text = "La solicitud ha tenido éxito y el recurso solicitado se ha proporcionado en la respuesta.", ?array $data = null): string {
		$message = ['status' => 200, 'message' => $text, 'data' => $data];
		return $this->jsonParser($message);
	}

	protected function messsageCreated(?string $text = "La solicitud ha tenido éxito y se ha creado un nuevo recurso como resultado. La respuesta incluye una URL que puede utilizarse para acceder al recurso creado.", ?array $data = null): string {
		$message = ['status' => 201, 'message' => $text, 'data' => $data];
		return $this->jsonParser($message);
	}

	protected function messageAccepted(?string $text = "La solicitud ha sido aceptada pero aún no se ha procesado. Esto puede ocurrir si la solicitud implica un procesamiento prolongado o si se requiere la intervención manual de un ser humano.", ?array $data = null) {
		$message = ['status' => 202, 'message' => $text, 'data' => $data];
		return $this->jsonParser($message);
	}

	protected function messageNoContent(?string $text = "La solicitud ha tenido éxito pero no hay contenido que devolver en la respuesta. Por lo general, se utiliza después de realizar una operación de actualización o eliminación para confirmar que la operación se ha realizado correctamente.", ?array $data = null) {
		$message = ['status' => 204, 'message' => $text, 'data' => $data];
		return $this->jsonParser($message);
	}

	protected function messagePartialContent(?string $text = "La solicitud ha tenido éxito, pero sólo se ha devuelto una parte del recurso solicitado. Esto se utiliza a menudo cuando se realizan solicitudes de descarga parcial de recursos grandes.", ?array $data = null) {
		$message = ['status' => 206, 'message' => $text, 'data' => $data];
		return $this->jsonParser($message);
	}

	// Códigos de estado de redirección

	protected function messageMovedPermanently(?string $text = "El recurso se ha movido permanentemente a una nueva URL. El mensaje de actualización ya ha sido enviado al equipo de desarrollo.", ?array $data = null) {
		$message = ['status' => 301, 'message' => $text, 'data' => $data];
		return $this->jsonParser($message);
	}

	protected function messageFound(?string $text = "El recurso se ha movido temporalmente a una nueva URL. El recurso puede volver a su ubicación original en cualquier momento.", ?array $data = null) {
		$message = ['status' => 302, 'message' => $text, 'data' => $data];
		return $this->jsonParser($message);
	}

	protected function messageSeeOther(?string $text = "El recurso se ha movido a una nueva URL. Deberías redirigirte a esa URL en su lugar.", ?array $data = null) {
		$message = ['status' => 303, 'message' => $text, 'data' => $data];
		return $this->jsonParser($message);
	}

	// Códigos de estado de error del cliente

	protected function messageBadRequest(?string $text = "La solicitud no se ha podido procesar debido a que su sintaxis es incorrecta o no se puede entender.", ?array $data = null) {
		$message = ['status' => 400, 'message' => $text, 'data' => $data];
		return $this->jsonParser($message);
	}

	protected function messageUnauthorized(?string $text = "La solicitud no se ha podido procesar porque no se ha proporcionado una autenticación válida. La respuesta incluye una cabecera WWW-Authenticate que puede utilizarse para proporcionar las credenciales necesarias.", ?array $data = null) {
		$message = ['status' => 401, 'message' => $text, 'data' => $data];
		return $this->jsonParser($message);
	}

	protected function messageForbidden(?string $text = "La solicitud se ha realizado correctamente pero el servidor no tiene permiso para proporcionar el recurso solicitado. Esto puede ocurrir si el usuario no tiene los permisos necesarios para acceder al recurso o si el recurso está prohibido por cualquier otro motivo.", ?array $data = null) {
		$message = ['status' => 403, 'message' => $text, 'data' => $data];
		return $this->jsonParser($message);
	}

	protected function messageRequestTimeout(?string $text = "L solicitud ha excedido el tiempo de espera establecido por el servidor. Esto puede ocurrir si la solicitud tarda demasiado en completarse o si el servidor está demasiado ocupado para procesarla en el momento.", ?array $data = null) {
		$message = ['status' => 408, 'message' => $text, 'data' => $data];
		return $this->jsonParser($message);
	}

	// Códigos de estado de error del servidor

	protected function messageInternalServerError(?string $text = "La solicitud no se ha podido procesar debido a un error interno del servidor. Esto puede ocurrir por una variedad de razones, como un fallo en un script o un problema con la configuración del servidor.", ?array $data = null) {
		$message = ['status' => 500, 'message' => $text, 'data' => $data];
		return $this->jsonParser($message);
	}

	protected function messageInternal(?string $text = "La solicitud se ha realizado correctamente pero el servidor no tiene la capacidad de procesarla. Esto puede ocurrir si la solicitud utiliza una operación o un protocolo que el servidor no admite.", ?array $data = null) {
		$message = ['status' => 501, 'message' => $text, 'data' => $data];
		return $this->jsonParser($message);
	}

	protected function messageServiceUnavailable(?string $text = "Ll servidor no está disponible temporalmente debido a sobrecarga o mantenimiento. La respuesta incluye una cabecera Retry-After que indica cuándo se espera que el servidor vuelva a estar disponible.", ?array $data = null) {
		$message = ['status' => 501, 'message' => $text, 'data' => $data];
		return $this->jsonParser($message);
	}

}