<?php

namespace Api\Functions\Commands\New;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{ InputInterface, InputArgument };
use Symfony\Component\Console\Output\OutputInterface;

use Api\Traits\Files;

class ModelCommand extends Command {

	use Files;

	protected static $defaultName = 'new:model';

	protected function configure() {
		$this->setDescription('Crear un nuevo archivo de modelo')->setHelp('Este comando te permite crear un nuevo archivo de modelo...')->addArgument('name', InputArgument::REQUIRED, 'Nombre del archivo de modelo');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		// Obtener el nombre del archivo ingresado por el usuario
		$name = $this->getModelName($input);

		// Definir la ruta local donde se guardará el archivo controlador
		$this->defineLocalRoute('./src/models/');

		// Crear el contenido del archivo controlador
		$content = "<?php

// Se define el namespace del modelo.
namespace Api\Models;

// Se llama a la interfaz general.
use Api\Interface\iConstructor;

// Se llama la conexión a la base de datos.
use Api\Models\Connection\Connection;

/**
 * La clase `{$name}` es una clase de PHP que se encarga de establecer una conexión a una base de datos. Esta clase tiene un atributo privado llamado `connection` que es una instancia de la clase `Connection`, que se encarga de realizar la conexión a la base de datos. La clase `{$name}` tiene un constructor que se encarga de inicializar el atributo `connection` al invocar al método `getInstance()` de la clase `Connection`. Este método es un método estático que se encarga de crear una única instancia de la clase `Connection` para toda la aplicación y devolverla al invocarlo.
 */
final class {$name} implements iConstructor {

	// Se declara una atributo de tipo `Connection`.
	private Connection \$connection;

	public function __construct() {
		// Se crear una nueva instancia de la clase `Connection` y se almacena en el atributo `\$connection`.
		\$this->connection = Connection::getInstance();
	}

}";

		// Guardar el archivo controlador en la ruta local especificada
		$this->saveFile('./src/models/', "$name.php", $content) ? $output->writeln("El archivo controlador '$name' ha sido creado exitosamente en la ruta: './src/models/" . $name . ".php'") : $output->writeln("El archivo controlador '$name' ya se encuentra creado en './src/models/{$name}.php'.");

		return Command::SUCCESS;
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