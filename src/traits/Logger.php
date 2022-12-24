<?php

namespace Api\Traits;

use Api\Traits\Files;

/**
 * Clase que controla todos los logs de la API.
 */
trait Logger {

	use Files;

	private ?string $route = null;
	private array $info;

	protected function defineLogPath(array $info, ?string $path = "./src/logs") {
		$this->info = $info;

		$logPath = rtrim($path, '/');

		if (file_exists($logPath) || filter_var($logPath, FILTER_VALIDATE_URL)) {
			$this->route = $logPath;
		} else {
			throw new Exception('URL inválida: ' . $logPath . '. Por favor, inténtalo de nuevo.');
		}
	}

	private function setMessage(string $message, ?string $function = null): string {
		$m = $message . " en `" .$this->info['class'];
		$m .= $function !== null ? '->' . $function . '()`.' : '`.';
		return $m;
	}

	protected function createLog(string $message, ?string $function = null, ?string $type = "error") {
		$this->saveLogRecord(
			$this->createFile($type),
			$this->setMessage($message, $function),
			$this->route . '/' . $type . 's'
		);
	}

	protected function info(?string $message = "Ha habido alguna información relevante", ?string $function = null) {
		$this->createLog($message, $function, debug_backtrace()[0]['function']);
	}

	protected function warning(?string $message = "Hay algo peligroso", ?string $function = null) {
		$this->createLog($message, $function, debug_backtrace()[0]['function']);
	}

	protected function error(?string $message = "Hay un error", ?string $function = null) {
		$this->createLog($message, $function, debug_backtrace()[0]['function']);
	}

	protected function critial(?string $message = "Hay un fallo crítico que requiere mantenimiento inmediato", ?string $function = null) {
		$this->createLog($message, $function, debug_backtrace()[0]['function']);
	}

	private function createFile(string $type): string {
		$date = date('d_m_Y');
		return $date . '_' . $type . '.log';
	}

}