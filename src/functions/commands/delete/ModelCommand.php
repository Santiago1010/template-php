<?php

namespace Api\Functions\Commands\Delete;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{ InputInterface, InputArgument };
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Helper\QuestionHelper;

use Api\Traits\Files;

class ModelCommand extends Command {
	
	use Files;

	protected static $defaultName = 'delete:model';

	protected function configure() {
		$this->setDescription('Eliminar un modelo')->setHelp('Este comando te permite eliminar un modelo...')->addArgument('name', InputArgument::REQUIRED, 'Nombre del modelo');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		// Obtener el nombre del archivo ingresado por el usuario
		$name = $this->getModelName($input);

		if ($this->confirmDelete($input, $output) && $this->safeDelete($name, $output)) {
			// Eliminar el archivo.
			$this->deleteFile("./src/models/{$name}.php") ? $output->writeln("El archivo {$name} ha sido eliminado.") : $output->writeln("No se ha encontrado el archivo './src/models/{$name}.php'");
		}

		return Command::SUCCESS;
	}

	private function safeDelete(string $name, OutputInterface $output): bool {
		$safe = [''];

		if (in_array(strtolower($name), $safe)) {
			$output->writeln("El modelo '{$name}' no puede ser eliminado, ya que forma parte del núcleo del framework.");
			return false;
		}

		return true;
	}

	private function confirmDelete(InputInterface $input, OutputInterface $output): bool {
		$questionHelper = $this->getHelper('question');

		$question = new ConfirmationQuestion('¿Deseas eliminar este modelo? (y/n) ', false);


		if ($questionHelper->ask($input, $output, $question)) {
			return true;
		} else {
			$output->writeln('No se ha eliminado el modelo.');
			return false;
		}
	}


	private function getModelName(InputInterface $input) {
		$name = $input->getArgument('name');

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