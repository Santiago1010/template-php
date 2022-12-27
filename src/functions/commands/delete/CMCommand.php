<?php

namespace Api\Functions\Commands\Delete;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{ InputInterface, InputArgument };
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Helper\QuestionHelper;

use Api\Traits\Files;

class CMCommand extends Command {
	
	use Files;

	protected static $defaultName = 'delete:cm';

	protected function configure() {
		$this->setDescription('Eliminar un controlador, modelo y entidad')->setHelp('Este comando te permite eliminar un controlador, modelo y entidad...')->addArgument('name', InputArgument::REQUIRED, 'Nombre del controlador, modelo y entidad');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		// Obtener el nombre del archivo ingresado por el usuario
		$name = $input->getArgument('name');

		// Definir la ruta local donde se guardará el archivo de la función
		$this->defineLocalRoute('./src/models/');

		if ($this->confirmDelete($input, $output) && $this->safeDelete($name, $output)) {
			// Eliminar el archivo.
			if ($this->deleteFile("./src/models/entities/" . $this->getEntityName($name) . ".php")) {
				$output->writeln("La entidad '" . $this->getEntityName($name) . "' ha sido eliminada.");

				if ($this->deleteFile("./src/models/" . $this->getModelName($name) . ".php")) {
					$output->writeln("El modelo '" . $this->getModelName($name) . "' ha sido eliminado.");

					if ($this->deleteFile("./src/controllers/" . $this->getControllerName($name) . ".php")) {
						$output->writeln("El controlador " . $this->getControllerName($name) . " ha sido eliminado.");

						$index = file_get_contents('index.php');
						preg_match('/' . $this->getControllerName($name) . '/', $index, $delete);
						

						$deleteLine = "\nuse Api\\Controllers\\{$delete[0]};";
						$index = str_replace($deleteLine, "", $index);

						file_put_contents('index.php', $index);
					} else { $output->writeln("El controlador '" . $this->getModelName($name) . "' no existe."); }
				} else { $output->writeln("El modelo '" . $this->getModelName($name) . "' no existe."); }
			} else { $output->writeln("La entidad '" . $this->getEntityName($name) . "' no existe."); }
		}

		return Command::SUCCESS;
	}

	private function safeDelete(string $name, OutputInterface $output): bool {
		$safe = ['allcontroller'];

		if (in_array(strtolower($this->getEntityName($name)), $safe)) {
			$output->writeln("La entidad '{$name}' no puede ser eliminada, ya que forma parte del núcleo del framework.");
			return false;
		}

		if (in_array(strtolower($this->getControllerName($name)), $safe)) {
			$output->writeln("El controlador '{$name}' no puede ser eliminado, ya que forma parte del núcleo del framework.");
			return false;
		}

		if (in_array(strtolower($this->getModelName($name)), $safe)) {
			$output->writeln("El modelo '{$name}' no puede ser eliminado, ya que forma parte del núcleo del framework.");
			return false;
		}

		return true;
	}

	private function confirmDelete(InputInterface $input, OutputInterface $output): bool {
		$questionHelper = $this->getHelper('question');

		$question = new ConfirmationQuestion('¿Deseas eliminar este controlador, modelo y entidad? (y/n) ', false);


		if ($questionHelper->ask($input, $output, $question)) {
			return true;
		} else {
			$output->writeln('No se ha eliminado el controlador, modelo ni entidad.');
			return false;
		}
	}


	private function getEntityName(string $input): string {
		$name = $input;

		// Hacer un TitleCase al nombre
		$name = ucwords($name);

		// Retirar caracteres especiales.
		$name = str_replace([' ', '_', '-', ':'], '', $name);

		return $name;
	}

	private function getControllerName(string $input) {
		$name = $input;

		// Remover espacios y caracteres especiales
		$name = preg_replace('/\s+/', '', $name);
		$name = preg_replace('/[^A-Za-z0-9]/', '', $name);

		// Verificar si el nombre ya contiene 'Controller', 'Controllers' o variantes
		if (preg_match('/Controller$|Controllers$/i', $name) !== 1) {
			$name .= 'Controller';
		} else {
			$name = preg_replace('/Controller$|Controllers$/i', 'Controller', $name);
		}

		// Hacer un TitleCase al nombre
		$name = ucwords($name);

		return $name;
	}

	private function getModelName(string $input) {
		$name = $input;

		// Remover espacios y caracteres especiales
		$name = preg_replace('/\s+/', '', $name);
		$name = preg_replace('/[^A-Za-z0-9]/', '', $name);

		// Verificar si el nombre ya contiene 'Controller', 'Controllers' o variantes
		if (preg_match('/Model$|Models$/i', $name) !== 1) {
			$name .= 'Model';
		} else {
			$name = preg_replace('/Model$|Models$/i', 'Model', $name);
		}

		// Hacer un TitleCase al nombre
		$name = ucwords($name);

		return $name;
	}

}