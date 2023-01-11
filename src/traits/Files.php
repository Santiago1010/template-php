<?php

namespace Api\Traits;

/**
 * 
 */
trait Files {

	public function saveFile(string $path, string $fileName, string $content): bool {
    	// Verificar si la ruta existe. Si no existe, crearla.
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}

		$fileType = pathinfo($fileName, PATHINFO_EXTENSION);

		if (!file_exists($path . "/" . $fileName)) {
    		// Guardar el archivo en la ruta especificada
			if ($fileType !== 'log') {
				$file = fopen($path . "/" . $fileName, "w");
				fwrite($file, $content);
				fclose($file);
				return true;
			} else {
				$this->saveLogRecord($fileName, $content);
				return true;
			}
		} else {
			return false;
		}
	}

	protected function deleteFile(string $path): bool {
		if (file_exists($path)) {
			return unlink($path);
		}
		return false;
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
		$record = $dateTime . "---> " . $message;

  		// Agregar el registro al archivo .log
		file_put_contents($route, $record . "\n", FILE_APPEND);
	}

}