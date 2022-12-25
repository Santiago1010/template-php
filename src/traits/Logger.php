<?php

namespace Api\Traits;

use Api\Traits\Files;
use Api\Traits\Email;

/**
 * Este código define un Trait llamado `Logger`, que puede ser utilizado por cualquier clase para llevar un registro de mensajes de depuración y errores. El Trait `Logger` utiliza el Trait `Files` para escribir los mensajes de depuración y errores en archivos de registro.
 */
trait Logger {

	use Files;
	use Email;

	private ?string $route = null;
	private array $info;
	private string $newMessage;

	protected function defineLogPath(array $info) {
		$this->info = $info;

		$logPath = rtrim($_ENV['LOG_PATH'], '/');

		if (file_exists($logPath) || filter_var($logPath, FILTER_VALIDATE_URL)) {
			$this->route = $logPath;
		} else {
			throw new Exception('URL inválida: ' . $logPath . '. Por favor, inténtalo de nuevo.');
		}
	}

	private function setMessage(string $message, ?string $function = null): string {
		$m = $message . " en `" . $_ENV['APP_NAME'] . "\\" .$this->info['class'];
		$m .= $function !== null ? '->' . $function . '()`.' : '`.';
		$this->newMessage = $m;
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
		$this->setEmail()->setRecipents(json_decode($_ENV['TEAM_ACCOUNTS']))->setContent(strtoupper(debug_backtrace()[0]['function']) . ' EN ' . strtoupper($_ENV['APP_NAME']), $this->newMessage)->sendEmail();
	}

	protected function critical(?string $message = "Hay un fallo crítico que requiere mantenimiento inmediato", ?string $function = null) {
		$this->createLog($message, $function, debug_backtrace()[0]['function']);
		$this->setEmail()->setRecipents(explode(", ", $_ENV['TEAM_ACCOUNTS']))->setContent('¡ERROR CRÍTICO EN ' . strtoupper($_ENV['APP_NAME']) . "!", $this->newMessage)->sendEmail();
	}

	private function createFile(string $type): string {
		$date = date('d_m_Y');
		return $date . '_' . $type . '.log';
	}

}