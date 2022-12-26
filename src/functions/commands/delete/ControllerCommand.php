<?php

namespace Api\Functions\Commands\Delete;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{ InputInterface, InputArgument };
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Helper\QuestionHelper;

use Api\Traits\Files;

class ControllerCommand extends Command {
	
	use Files;

	protected static $defaultName = 'delete:controller';

	protected function configure() {
		$this->setDescription('Eliminar un controlador')->setHelp('Este comando te permite eliminar un controlador...')->addArgument('name', InputArgument::REQUIRED, 'Nombre del controlador');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		// Obtener el nombre del archivo ingresado por el usuario
		$name = $this->getControllerName($input);

		// Definir la ruta local donde se guardará el archivo de la función
		$this->defineLocalRoute('./src/controllers/');

		if ($this->confirmDelete($input, $output) && $this->safeDelete($name, $output)) {
			// Eliminar el archivo.
			$this->deleteFile("./src/controllers/{$name}.php") ? $output->writeln("El archivo {$name} ha sido eliminado.") : $output->writeln("No se ha encontrado el archivo './src/controllers/{$name}.php'");
		}

		return Command::SUCCESS;
	}

	private function safeDelete(string $name, OutputInterface $output): bool {
		$safe = ['AllController'];

		if (in_array(strtolower($name), $safe)) {
			$output->writeln("El controlador '{$name}' no puede ser eliminado, ya que forma parte del núcleo del framework.");
			return false;
		}

		return true;
	}

	private function confirmDelete(InputInterface $input, OutputInterface $output): bool {
		$questionHelper = $this->getHelper('question');

		$question = new ConfirmationQuestion('¿Deseas eliminar este controlador? (y/n) ', false);


		if ($questionHelper->ask($input, $output, $question)) {
			return true;
		} else {
			$output->writeln('No se ha eliminado el controlador.');
			return false;
		}
	}


	private function getControllerName(InputInterface $input) {
		$name = $input->getArgument('name');

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

		
}