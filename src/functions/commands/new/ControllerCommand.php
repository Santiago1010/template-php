<?php

namespace Api\Functions\Commands\New;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{ InputInterface, InputArgument };
use Symfony\Component\Console\Output\OutputInterface;

use Api\Traits\Files;

class ControllerCommand extends Command {

	use Files;

	protected static $defaultName = 'new:controller';

	protected function configure() {
		$this->setDescription('Crear un nuevo archivo controlador')->setHelp('Este comando te permite crear un nuevo archivo controlador...')->addArgument('name', InputArgument::REQUIRED, 'Nombre del archivo controlador');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		// Obtener el nombre del archivo ingresado por el usuario
		$name = $this->getControllerName($input);

		// Crear el contenido del archivo controlador
		$content = "<?php

// Se define el namespace de los controladores.
namespace Api\Controllers;

// Se llama a la interfaz general.
use Api\Interfaces\iConstructor;

// Se llama `AllController` y sus traits y funciones.
use Api\Controllers\AllController;

/**
 * Se define una clase controladora final llamada `$name` que extiende de `AllController` (el cuál hereda de todas las funciones almacenadas en './src/functions/' y traits almacenados en './src/traits/') e implementa la interfaz `iConstructor`. La clase tiene un método constructor que llama al método constructor de la clase padre y luego llama al método `defineLogPath` que definirá la ruta en donde se almacenarán los logs creados (por defecto se almacenan en './src/logs/') con el resultado de la función `debug_backtrace()[0]` (que envía información como el nombre de la clase, el archivo, ubicación, etc.) como argumento.
 */
final class $name extends AllController implements iConstructor {

	public function __construct() {
		parent::__construct(); // Se ejecuta el constructor de `AllController`.
		\$this->defineLogPath(debug_backtrace()[0]); // Se define la ruta por defecto de los logs y se envía la información de la clase.
	}

}";

		// Guardar el archivo controlador en la ruta local especificada
		$this->saveFile('./src/controllers/', "$name.php", $content) ? $output->writeln("El archivo controlador '$name' ha sido creado exitosamente en la ruta: './src/controllers/" . $name . ".php'") : $output->writeln("El archivo controlador '$name' ya se encuentra creado en './src/controllers/{$name}.php'.");

		return Command::SUCCESS;
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