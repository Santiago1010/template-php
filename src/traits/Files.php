<?php

namespace Api\Traits;

/**
 * Trait que controlará los archivos tanto internos, como externos.
 */

trait Files {

	private ?string $local = null;
	private ?string $external = null;

	public function defineLocalRoute(string $route) {
		$this->local = $route;
	}

	public function defineExternalPath(string $route) {
		$this->external = $route;
	}

	public function saveFile(string $path, string $fileName, string $content) {
  		// Verificar si la ruta existe. Si no existe, crearla.
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}

		$fileType = explode('.', $fileName);

  		// Guardar el archivo en la ruta especificada
		if (end($fileType) !== 'log') {
			$archivo = fopen($ruta . "/" . $nombre_archivo, "w");
			fwrite($archivo, $contenido);
			fclose($archivo);
		}else {
			$this->saveLogRecord($fileName, $content);
		}
	}

	public function saveLogRecord(string $fileName, string $message, ?string $logFilePath = "./src/logs/") {
		$path = rtrim($logFilePath, '/');
		$route = $path . "/" . $fileName;

		// Verificar si el archivo .log existe. Si no existe, crearlo.
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}

		if (!file_exists($route)) {
			$routerPath = fopen($route, "w");
			fclose($routerPath);
		}

  		// Obtener la fecha y hora actual
		$dateTime = date("d/m/Y - H:i:s");

  		// Generar el registro en formato "fecha y hora - mensaje"
		$record = $dateTime . ": " . $message;

  		// Agregar el registro al archivo .log
		file_put_contents($route, $record . "\n", FILE_APPEND);
	}

}