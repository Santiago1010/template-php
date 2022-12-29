<?php

namespace Api\Functions\Commands\New;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{ InputInterface, InputArgument };
use Symfony\Component\Console\Output\OutputInterface;

use Api\Traits\Files;

class FunctionCommand extends Command {
	
	use Files;

	protected static $defaultName = 'new:function';

	protected function configure() {
		$this->setDescription('Crear un nuevo archivo con una función')->setHelp('Este comando te permite crear un nuevo archivo controlador...')->addArgument('name', InputArgument::REQUIRED, 'Nombre del archivo controlador');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		// Obtener el nombre del archivo ingresado por el usuario
		$name = $this->getFunctionName($input);

		// Crear el contenido del archivo de la función
		$content = "<?php

// Se define el namespace de las funciones.
namespace Api\Controllers;

// Se llama a la interfaz general.
use Api\Interface\iConstructor;

/**
 * 
 */
class $name implements iConstructor {

	public function __construct() {
		//
	}

}";

		// Guardar el archivo de la función en la ruta local especificada
		if ($this->saveFile('./src/functions/', "$name.php", $content)) {
			$this->setNewFunction($name);

			$output->writeln("El archivo de función '$name' ha sido creado exitosamente en la ruta: './src/functions/{$name}.php'");
		} else {
			$output->writeln("El archivo de función '$name' ya se encuentra creado en './src/functions/{$name}.php'.");
		}

		return Command::SUCCESS;
	}

	private function setNewFunction(string $name) {
		// Leer el contenido del archivo AllController
		$controller = file_get_contents('./src/controllers/AllController.php');

		// Utilizar una expresión regular para encontrar la línea donde se declaran los traits
		preg_match_all('/^use\sApi\\\\Functions\\\\.*;$/m', $controller, $invokers);
		$invokerLine = end($invokers[0]);

		// Insertar el nuevo trait debajo de la línea donde se declaran los traits
		$newInvokerLine = $invokerLine . "\nuse Api\Functions\\$name;";
		$controller = str_replace($invokerLine, $newInvokerLine, $controller);

		preg_match('/protected object \$request;/', $controller, $attrs);
		$attr = $attrs[0];

		$newAttr = $attr . "\n\tprotected " . $name . " $" . strtolower($name) . ";";
		$controller = str_replace($attr, $newAttr, $controller);

		preg_match('/\$this->request = \$this->getRequest\(\);/', $controller, $line);
		$request = $line[0];
		
		$newClass = $request . "\n\t\t\$this->" . strtolower($name) . " = new $name();";
		$controller = str_replace($request, $newClass, $controller);

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