<?php

namespace Api\Functions\Commands\New;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{ InputInterface, InputArgument };
use Symfony\Component\Console\Output\OutputInterface;

use Api\Functions\DataBase;

use Api\Traits\Files;

class EntityCommand extends Command {
	
	use Files;

	protected static $defaultName = 'new:entity';
	private array $attrs;

	protected function configure() {
		$this->setDescription('Crear una nueva entidad o cápsula')->setHelp('Este comando te permite crear nueva entidad o cápsula...')->addArgument('name', InputArgument::REQUIRED, 'Nombre de la tabla de la base de datos.');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$c = new DataBase();
		$this->attrs = $c->readColumns($input->getArgument('name'));

		// Obtener el nombre del archivo ingresado por el usuario
		$name = $this->getEntityName($input);

		// Definir la ruta local donde se guardará el archivo controlador
		$this->defineLocalRoute('./src/models/entities/');

		// Crear el contenido del archivo controlador
		$content = "<?php

// Se define el namespace de la entidad.
namespace Api\Entities;

// Usar la interfaz de las entidades.
use Api\Interfaces\iEntity;

/**
 * La clase `{$name}` es una clase de PHP que se encarga de realizar operaciones CRUD (crear, leer, actualizar y eliminar) en una tabla de usuarios en una base de datos. Esta clase implementa una interfaz llamada 'iEntity' que define los métodos necesarios para realizar estas operaciones. La clase `{$name}` proporciona una implementación para estos métodos y también tiene un constructor y varios métodos de acceso y modificación (`getters` y `setters`) para los atributos de la clase. Los métodos `create()`, `read()`, `update()` y `delete()` tienen un parámetro llamado `query` que indica la operación a realizar y devuelven una cadena con la consulta SQL correspondiente a la operación especificada.
 */

class Users implements iEntity {

	private string \$table = \$_ENV['NAME_DB'] . \".{$input->getArgument('name')}\";
" . $this->setAttributes() . "
	public function __construct(" . $this->setParams() . "): void {" . $this->setValues() . "
	}
" . $this->setGettersSetters() . "
	public function create(string \$query); string {
    	\$create = [
    		\"\" => \"\"
    	];

    	return \$create[\$query];
    }

    public function read(string \$query): string {
    	\$read = [
    		\"\" => \"\"
    	];

    	return \$read[\$query];
    }

    public function update(string \$query): string {
    	\$update = [
    		\"\" => \"\"
    	];

    	return \$update[\$query];
    }


    public function delete(string \$query): string {
    	\$delete = [
    		\"\" => \"\"
    	];

    	return \$delete[\$query];
    }

}";

		// Guardar el archivo controlador en la ruta local especificada
		if ($this->saveFile('./src/models/entities/', "$name.php", $content)) {

			$output->writeln("La entidad '$name' ha sido creado exitosamente en la ruta: './src/models/entities/{$name}.php'");
		} else {
			$output->writeln("La entidad '$name' ya se encuentra creado en './src/models/entities/{$name}.php'.");
		}

		return Command::SUCCESS;
	}

	private function setAttributes(): string {
		$content = "";

		foreach ($this->attrs as $key => $attr) {
			$content .= "\tprivate string \$" . $this->setNameAttr($attr['COLUMN_NAME']) . ";\n";
		}

		return $content;
	}

	private function setParams(): string {
		$content = "";

		foreach ($this->attrs as $key => $attr) {
			$content .= "string \$" . $this->setNameAttr($attr['COLUMN_NAME']) . ", ";
		}

		return rtrim($content, ', ');
	}

	private function setValues(): string {
		$content = "";

		foreach ($this->attrs as $key => $attr) {
			$content .= "\n\t\t\$this->" . $this->setNameAttr($attr['COLUMN_NAME']) . " = \$" . $this->setNameAttr($attr['COLUMN_NAME']) . ";";
		}

		return $content;
	}

	private function setGettersSetters(): string {
		$content = "";

		foreach ($this->attrs as $key => $attr) {
			$name = ucfirst($this->setNameAttr($attr['COLUMN_NAME']));
			$content .= "\n\tpublic function get{$name}(): string {
		return \$this->" . $this->setNameAttr($attr['COLUMN_NAME']) . ";
	}\n";

			$content .= "\n\tpublic function set{$name}(string \$" . $this->setNameAttr($attr['COLUMN_NAME']) . ") {
		\$this->" . $this->setNameAttr($attr['COLUMN_NAME']) . " = \$" . $this->setNameAttr($attr['COLUMN_NAME']) . ";
		return \$this;
	}\n";
		}

		return $content;
	}

	public function setNameAttr(string $name) {
		$name = str_replace("-", "_", $name);
		$name = str_replace(":", "_", $name);
		$name = str_replace(" ", "_", $name);

		$n = explode("_", $name);

		$name = strtolower($n[0]);

		for ($i = 1; $i < count($n); $i++) { 
			$name .= ucwords($n[$i]);
		}

		return $name;
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