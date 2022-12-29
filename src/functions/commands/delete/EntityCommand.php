<?php

namespace Api\Functions\Commands\Delete;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{ InputInterface, InputArgument };
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Helper\QuestionHelper;

use Api\Traits\Files;

class EntityCommand extends Command {
	
	use Files;

	protected static $defaultName = 'delete:entity';

	protected function configure() {
		$this->setDescription('Eliminar una entidad')->setHelp('Este comando te permite eliminar una entidad...')->addArgument('name', InputArgument::REQUIRED, 'Nombre de la entidad');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		// Obtener el nombre del archivo ingresado por el usuario
		$name = $this->getEntityName($input);

		if ($this->confirmDelete($input, $output) && $this->safeDelete($name, $output)) {
			// Eliminar el archivo.
			$this->deleteFile("./src/models/entities/{$name}.php") ? $output->writeln("El archivo {$name} ha sido eliminado.") : $output->writeln("No se ha encontrado el archivo './src/models/entities/{$name}.php'");
		}

		return Command::SUCCESS;
	}

	private function safeDelete(string $name, OutputInterface $output): bool {
		$safe = [''];

		if (in_array(strtolower($name), $safe)) {
			$output->writeln("La entidad '{$name}' no puede ser eliminado, ya que forma parte del núcleo del framework.");
			return false;
		}

		return true;
	}

	private function confirmDelete(InputInterface $input, OutputInterface $output): bool {
		$questionHelper = $this->getHelper('question');

		$question = new ConfirmationQuestion('¿Deseas eliminar esta entidad? (y/n) ', false);


		if ($questionHelper->ask($input, $output, $question)) {
			return true;
		} else {
			$output->writeln('No se ha eliminado la entidad.');
			return false;
		}
	}

	private function getEntityName(InputInterface $input): string {
		$name = $input->getArgument('name');

		// Hacer un TitleCase al nombre
		$name = ucwords($name);

		// Retirar caracteres especiales.
		$name = str_replace([' ', '_', '-', ':'], '', $name);

		return $name;
	}

		
}