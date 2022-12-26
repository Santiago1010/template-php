<?php

namespace Api\Functions\Commands\Delete;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{ InputInterface, InputArgument };
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Helper\QuestionHelper;

use Api\Traits\Files;

class TraitCommand extends Command {
	
	use Files;

	protected static $defaultName = 'delete:trait';

	protected function configure() {
		$this->setDescription('Eliminar un trait')->setHelp('Este comando te permite eliminar un trait...')->addArgument('name', InputArgument::REQUIRED, 'Nombre del trait');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		// Obtener el nombre del archivo ingresado por el usuario
		$name = $this->getFunctionName($input);

		// Definir la ruta local donde se guardará el archivo de la función
		$this->defineLocalRoute('./src/traits/');

		if ($this->confirmDelete($input, $output) && $this->safeDelete($name, $output)) {
			// Eliminar el archivo.
			if ($this->deleteFile("./src/traits/{$name}.php")) {
				// Eliminar las referencias a la función de `AllController`
				$this->deleteTrait($name);

				$output->writeln("El archivo {$name} ha sido eliminado y sus referencias dentro de `AllController`.");
			} else {
				$output->writeln("No se ha encontrado el archivo './src/traits/{$name}.php'");
			}
		}

		return Command::SUCCESS;
	}

	private function safeDelete(string $name, OutputInterface $output): bool {
		$safe = ['email', 'files', 'logger', 'response'];

		if (in_array(strtolower($name), $safe)) {
			$output->writeln("El trait '{$name}' no puede ser eliminado, ya que forma parte del núcleo del framework.");
			return false;
		}

		return true;
	}

	private function confirmDelete(InputInterface $input, OutputInterface $output): bool {
		$questionHelper = $this->getHelper('question');

		$question = new ConfirmationQuestion('¿Deseas eliminar este trait? (y/n) ', false);


		if ($questionHelper->ask($input, $output, $question)) {
			return true;
		} else {
			$output->writeln('No se ha eliminado el trait.');
			return false;
		}
	}

	private function deleteTrait(string $name) {
		// Leer el contenido del archivo AllController
		$controller = file_get_contents('./src/controllers/AllController.php');

		$controller = str_replace("\nuse Api\Traits\\$name;", "", $controller);
		$controller = str_replace("\n\tuse $name;", "", $controller);

		// Sobrescribir el archivo AllController con el nuevo contenido
		file_put_contents('./src/controllers/AllController.php', $controller);
	}


	private function getFunctionName(InputInterface $input) {
		$name = $input->getArgument('name');

		// Remover espacios y caracteres especiales
		$name = preg_replace('/\s+/', '', $name);
		$name = preg_replace('/[^A-Za-z0-9]/', '', $name);

		// Hacer un TitleCase al nombre
		$name = ucwords($name);

		return $name;
	}
}