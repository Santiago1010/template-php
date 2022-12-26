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
		$this
		->setDescription('Crear un nuevo archivo controlador')
		->setHelp('Este comando te permite crear un nuevo archivo controlador...')
		->addArgument('name', InputArgument::REQUIRED, 'Nombre del archivo controlador');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		// Obtener el nombre del archivo ingresado por el usuario
		$name = $this->getControllerName($input);

		// Definir la ruta local donde se guardará el archivo controlador
		$this->defineLocalRoute('./src/Controller/');

		// Crear el contenido del archivo controlador
		$content = "<?php

namespace Api\Controllers;

use Api\Controllers\AllController;

class $name extends AllController {

	public function __construct() {
		parent::__construct();
		\$this->defineLogPath(debug_backtrace()[0]);
	}

}";

		// Guardar el archivo controlador en la ruta local especificada
		$this->saveFile('./src/controllers/', "$name.php", $content);

		// Mostrar mensaje de éxito
		$output->writeln("El archivo controlador $name ha sido creado exitosamente en la ruta: " . './src/controllers/');

		return Command::SUCCESS;
	}

	private function getControllerName(InputInterface $input) {
	    $name = $input->getArgument('name');

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