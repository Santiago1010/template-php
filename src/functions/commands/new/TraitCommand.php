<?php

namespace Api\Functions\Commands\New;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{ InputInterface, InputArgument };
use Symfony\Component\Console\Output\OutputInterface;

use Api\Traits\Files;

class TraitCommand extends Command {
	
	use Files;

	protected static $defaultName = 'new:trait';

	protected function configure() {
		$this->setDescription('Crear un nuevo archivo controlador')->setHelp('Este comando te permite crear un nuevo archivo controlador...')->addArgument('name', InputArgument::REQUIRED, 'Nombre del archivo controlador');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		// Obtener el nombre del archivo ingresado por el usuario
		$name = $this->getTraitName($input);

		// Definir la ruta local donde se guardará el archivo controlador
		$this->defineLocalRoute('./src/trait/');

		// Crear el contenido del archivo controlador
		$content = "<?php

namespace Api\Traits;

trait $name {

	// Haz tu trait aquí. Todas las funciones deben ser protegidas (protected).

}";

		// Guardar el archivo controlador en la ruta local especificada
		if ($this->saveFile('./src/traits/', "$name.php", $content)) {
			$this->setNewTrait($name);

			$output->writeln("El trait '$name' ha sido creado exitosamente en la ruta: './src/traits/{$name}.php'");
		} else {
			$output->writeln("El trait '$name' ya se encuentra creado en './src/traits/{$name}.php'.");
		}

		return Command::SUCCESS;
	}

	private function setNewTrait(string $name) {
		// Leer el contenido del archivo AllController
		$controller = file_get_contents('./src/controllers/AllController.php');

		// Utilizar una expresión regular para encontrar la línea donde se declaran los traits
		preg_match_all('/^use\sApi\\\\Traits\\\\.*;$/m', $controller, $invokers);
		$invokerLine = end($invokers[0]);

		// Insertar el nuevo trait debajo de la línea donde se declaran los traits
		$newInvokerLine = $invokerLine . "\nuse Api\Traits\\$name;";
		$controller = str_replace($invokerLine, $newInvokerLine, $controller);

		// Buscamos todas las líneas que cumplan con el patrón siguiente:
		// 1. Comiencen con 1 o más espacios en blanco (\s+)
		// 2. Sigan con la palabra reservada "use" (use)
		// 3. Sigan con 1 o más espacios en blanco (\s+)
		// 4. Continúen con una sola palabra (\w+)
		// 5. Finalicen con un punto y coma (;)
		// Las líneas deben terminar en un salto de línea o fin de línea (m)
		preg_match_all('/^\s+use\s+\w+;$/m', $controller, $uses);		
		$useLine = end($uses[0]); // Obtenemos la última línea que cumplió con el patrón
		
		$newUse = $useLine . "\n\tuse $name;"; // Creamos la nueva línea que queremos agregar
		$controller = str_replace($useLine, $newUse, $controller); // Reemplazamos la línea encontrada por la nueva línea

		// Sobrescribir el archivo AllController con el nuevo contenido
		file_put_contents('./src/controllers/AllController.php', $controller);
	}


	private function getTraitName(InputInterface $input) {
		$name = $input->getArgument('name');

		// Remover espacios y caracteres especiales
		$name = preg_replace('/\s+/', '', $name);
		$name = preg_replace('/[^A-Za-z0-9]/', '', $name);

		// Hacer un TitleCase al nombre
		$name = ucwords($name);

		return $name;
	}
}