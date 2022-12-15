<?php

namespace Api\Traits;

trait Response {

	private function jsonParser(array $response): string {
		return json_encode($response, JSON_UNESCAPED_UNICODE);
	}

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

}