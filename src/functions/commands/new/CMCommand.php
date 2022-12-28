<?php

namespace Api\Functions\Commands\New;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\{ InputInterface, InputArgument };
use Symfony\Component\Console\Output\OutputInterface;

use Api\Functions\DataBase;

use Api\Traits\Files;

class CMCommand extends Command {
	
	use Files;

	protected static $defaultName = 'new:cm';
	private array $columns;
	private string $name;
	private string $entity;

	protected function configure() {
		$this->setDescription('Crear un nuevo controlador, modelo y entidad')->setHelp('Este comando te permite crear un nuevo controlador, modelo y entidad...')->addArgument('name', InputArgument::REQUIRED, 'Nombre de la tabla de la base de datos.');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$c = new DataBase();
		$this->columns = $c->readColumns($input->getArgument('name'));

		// Obtener el nombre del archivo ingresado por el usuario
		$this->name = $input->getArgument('name');
		$this->entity = $this->getEntityName($input);

		// Crear la entidad.
		$entity = $this->newEntity($output);

		// Crear el modelo.
		$model = $this->newModel($output);

		// Crear el controlador.
		$controller = $this->newController($output);

		if ($entity === true && $model === true && $controller === true) {
			$index = file_get_contents('index.php');

			preg_match('/\/\/\sImportar\scontroladores\./', $index, $result);
			
			$resultLine = $result[0];

			$newUse = $resultLine . "\nuse Api\\Controllers\\" . $this->getControllerName($this->name) . ";";
			$index = str_replace($resultLine, $newUse, $index);

			file_put_contents('index.php', $index);
		}

		return Command::SUCCESS;
	}

	private function newEntity(OutputInterface $output): bool {
		// Crear el contenido de la entidad
		$content = "<?php

// Se define el namespace de la entidad.
namespace Api\Models\Entities;

// Usar la interfaz de las entidades.
use Api\Interfaces\iEntity;

/**
 * La entidad `{$this->entity}` es una clase de PHP que se encarga de realizar operaciones CRUD (crear, leer, actualizar y eliminar) en una tabla de usuarios en una base de datos. Esta clase implementa una interfaz llamada 'iEntity' que define los métodos necesarios para realizar estas operaciones. La clase `{$this->entity}` proporciona una implementación para estos métodos y también tiene un constructor y varios métodos de acceso y modificación (`getters` y `setters`) para los atributos de la clase. Los métodos `create()`, `read()`, `update()` y `delete()` tienen un parámetro llamado `query` que indica la operación a realizar y devuelven una cadena con la consulta SQL correspondiente a la operación especificada.
 */

class {$this->entity} implements iEntity {

	private string \$table;
" . $this->setAttributes() . "
	public function __construct(" . $this->setParams() . ") {\n\t\t\$this->table = \"{$_ENV['NAME_DB']}.{$this->name}\";\n" . $this->setValues() . "
	}
" . $this->setGettersSetters() . "
	public function create(string \$query): string {
    	\$create = [
    		\"create" . rtrim($this->entity, 's') . "\" => \"" . $this->setCreate() . "\"
    	];

    	return \$create[\$query];
    }

    public function read(string \$query): string {
    	\$read = [
    		\"read{$this->entity}\" => \"" . $this->setSelect(false) . "\",
    		\"read" . rtrim($this->entity, 's') . "\" => \"" . $this->setSelect(true) . "\",
    	];

    	return \$read[\$query];
    }

    public function update(string \$query): string {
    	\$update = [
    		\"update" . rtrim($this->entity, 's') . "\" => \"" . $this->setUpdate() . "\"
    	];

    	return \$update[\$query];
    }


    public function delete(string \$query): string {
    	\$delete = [
    		\"delete" . rtrim($this->entity, 's') . "\" => \"DELETE FROM {\$this->table} WHERE {$this->columns['info'][0]['COLUMN_NAME']} = :" . $this->setNameAttr($this->columns['info'][0]['COLUMN_NAME']) . "\"
    	];

    	return \$delete[\$query];
    }

}";

		// Definir la ruta local donde se guardará la entidad
		$this->defineLocalRoute('./src/models/entities/');

		// Guardar la entidad en la ruta local especificada
		if ($this->saveFile('./src/models/entities/', "{$this->entity}.php", $content)) {
			$output->writeln("La entidad '{$this->entity}' ha sido creada exitosamente en la ruta: './src/models/entities/{{$this->entity}}.php'");
			return true;
		} else {
			$output->writeln("La entidad '{$this->entity}' ya se encuentra creada en './src/models/entities/{$this->entity}.php'.");
			return false;
		}
	}

	private function newModel(OutputInterface $output): bool {
		$name = $this->getModelName($this->name);

		$object = rtrim($this->name, 's');

		// Crear el contenido del modelo
		$content = "<?php

// Se define el namespace del modelo.
namespace Api\Models;

// Se llama a la interfaz general.
use Api\Interfaces\iConstructor;

// Se llama la conexión a la base de datos.
use Api\Models\Connection\Connection;

// Se llama la entidad.
use Api\Models\Entities\\{$this->entity};

/**
 * El modelo `{$name}` es una clase de PHP que se encarga de establecer una conexión a una base de datos. Esta clase tiene un atributo privado llamado `connection` que es una instancia de la clase `Connection`, que se encarga de realizar la conexión a la base de datos. La clase `{$name}` tiene un constructor que se encarga de inicializar el atributo `connection` al invocar al método `getInstance()` de la clase `Connection`. Este método es un método estático que se encarga de crear una única instancia de la clase `Connection` para toda la aplicación y devolverla al invocarlo.
 */
final class {$name} implements iConstructor {

	// Se declara una atributo de tipo `Connection`.
	private Connection \$connection;

	public function __construct() {
		// Se crear una nueva instancia de la clase `Connection` y se almacena en el atributo `\$connection`.
		\$this->connection = Connection::getInstance();
	}

	// Crear un nuevo {registro}.
	public function create" . ucfirst($object) . "DB({$this->entity} \${$object}): bool {
		\$ps = \$this->connection->getPrepareStatement(\${$object}->create(\"create" . rtrim($this->entity, 's') . "\"));
		\$ps = \$this->connection->getBindParam(\$ps, \${$object}, [" . $this->ignoreId() . "]);
		
		return \$ps->execute() ? ['status' => true, 'info' => 'Se ha creado el {registro} correctamente.'] : ['status' => false, 'info' => 'No se ha podido crear el {registro}. Ya hemos enviado el reporte.', 'error' => \$ps->errorInfo()];
	}

	// Lee la lista completa de los {registro}s.
	public function read{$this->entity}DB({$this->entity} \${$object}): array {
		\$ps = \$this->connection->getPrepareStatement(\${$object}->read(\"read{$this->entity}\"));

		\$response = \$this->connection->getFetch(\$ps);

		return \$response['status'] ? \$response : ['status' => false, 'info' => 'Ha ocurrido un error al leer los {registro}s. Ya hemos reportado el problema.', 'error' => \$response['info']];
	}

	// Lee la información de 1 sólo {registro}.
	public function read" . ucfirst($object) . "DB({$this->entity} \${$object}): array {
		\$ps = \$this->connection->getPrepareStatement(\${$object}->read(\"read" . rtrim($this->entity, 's') . "\"));

		\$response = \$this->connection->getFetch(\$ps);

		return \$response['status'] ? \$response : ['status' => false, 'info' => 'Ha ocurrido un error al leer el {registro}. Ya hemos reportado el problema.', 'error' => \$response['info']];
	}

	// Actualizar un {registro}.
	public function update" . ucfirst($object) . "DB({$this->entity} \${$object}): bool {
		\$ps = \$this->connection->getPrepareStatement(\${$object}->update(\"update" . rtrim($this->entity, 's') . "\"));
		\$ps = \$this->connection->getBindParam(\$ps, \${$object}, [" . $this->setUpdateOrder() . "]);
		
		return \$ps->execute() ? ['status' => true, 'info' => 'Se ha actualizado el {registro} correctamente.'] : ['status' => false, 'info' => 'No se ha podido actualizar el {registro}. Ya hemos enviado el reporte.', 'error' => \$ps->errorInfo()];
	}

	// Eliminar un {registro}.
	public function delete" . ucfirst($object) . "DB({$this->entity} \${$object}): bool {
		\$ps = \$this->connection->getPrepareStatement(\${$object}->delete(\"delete" . rtrim($this->entity, 's') . "\"));
		\$ps = \$this->connection->getBindParam(\$ps, \${$object}, ['get" . ucfirst($this->setNameAttr($this->columns['info'][0]['COLUMN_NAME'])) . "']);
		
		return \$ps->execute() ? ['status' => true, 'info' => 'Se ha eliminado el {registro} correctamente.'] : ['status' => false, 'info' => 'No se ha podido eliminar el {registro}. Ya hemos enviado el reporte.', 'error' => \$ps->errorInfo()];
	}

}";

		// Guardar el modelo en la ruta local especificada
		if ($this->saveFile('./src/models/', "{$name}.php", $content)) {
		 	$output->writeln("El modelo '{$name}' ha sido creado exitosamente en la ruta: './src/models/{$name}.php'");
		 	return true;
		 } else {
		 	$output->writeln("El modelo '{$name}' ya se encuentra creado en './src/models/{$name}.php'.");
		 	return false;
		 }
	}

	private function newController(OutputInterface $output): bool {
		$name = $this->getControllerName($this->name);

		$object = rtrim($this->name, 's');

		$content = "<?php

// Se define el namespace de los controladores.
namespace Api\Controllers;

// Se llama a la interfaz general.
use Api\Interfaces\iConstructor;

// Se llama `AllController` y sus traits y funciones.
use Api\Controllers\AllController;

// Se llama el modelo.
use Api\Models\\" . $this->getModelName($this->name) . ";

// Se llama la entidad.
use Api\Models\Entities\\{$this->entity};

/**
 * Se define una clase controladora final llamada `$name` que extiende de `AllController` (el cuál hereda de todas las funciones almacenadas en './src/functions/' y traits almacenados en './src/traits/') e implementa la interfaz `iConstructor`. La clase tiene un método constructor que llama al método constructor de la clase padre y luego llama al método `defineLogPath` que definirá la ruta en donde se almacenarán los logs creados (por defecto se almacenan en './src/logs/') con el resultado de la función `debug_backtrace()[0]` (que envía información como el nombre de la clase, el archivo, ubicación, etc.) como argumento.
 */
final class {$name} extends AllController implements iConstructor {

	private " . $this->getModelName($this->name) . " \$model;

	public function __construct() {
		parent::__construct(); // Se ejecuta el constructor de `AllController`.
		\$this->defineLogPath(debug_backtrace()[0]); // Se define la ruta por defecto de los logs y se envía la información de la clase.
		\$this->model = new " . $this->getModelName($this->name) . "();
	}

	public function create" . ucfirst($object) . "(): string {
		\${$object} = " . $this->setNewObject() . "
		\$response = \$this->model->create" . ucfirst($object) . "DB(\${$object});

		if (\$response['status']) {
			\$this->info(\"Se creó un nuevo registro con ID {\${$object}->get" . ucfirst($this->columns['info'][0]['COLUMN_NAME']) . "()}\", debug_backtrace()[0]['function']);
			return \$this->messsageCreated(\$response['info']);
		} else {
			\$this->error(\"No se ha podido crear el registro ({\$response['error']})\", debug_backtrace()[0]['function']);
			return \$this->messageInternalServerError(\$response['info']);
		}
	}

	public function read{$this->entity}(): string {
		\${$object} = " . $this->setNewObject() . "
		\$response = \$this->model->read" . ucfirst($object) . "sDB(\${$object});

		if (\$response['status']) {
			return \$this->messageOk('Esta es la lista completa de los registros.', \$response['info']);
		} else {
			\$this->error(\"No se ha podido actualizar el registro ({\$response['error']})\", debug_backtrace()[0]['function']);
			return \$this->messageInternalServerError(\$response['info'], \$response['info']);
		}
	}

	public function read" . ucfirst($object) . "(): string {
		\${$object} = " . $this->setNewObject() . "
		\$response = \$this->model->read" . ucfirst($object) . "DB(\${$object});

		if (\$response['status']) {
			return \$this->messageOk('Esta es la información el registro solicitado.', \$response['info']);
		} else {
			\$this->error(\"No se ha podido leer el registro ({\$response['error']})\", debug_backtrace()[0]['function']);
			return \$this->messageInternalServerError(\$response['info'], \$response['error']);
		}
	}

	public function update" . ucfirst($object) . "(): string {
		\${$object} = " . $this->setNewObject() . "
		\$response = \$this->model->update" . ucfirst($object) . "DB(\${$object});

		if (\$response['status']) {
			return \$this->messsageCreated(\$response['info']);
		} else {
			\$this->error(\"No se ha podido actualizar el registro ({\$response['error']})\", debug_backtrace()[0]['function']);
			return \$this->messageInternalServerError(\$response['info']);
		}
	}

	public function delete" . ucfirst($object) . "(): string {
		\${$object} = " . $this->setNewObject() . "
		\$response = \$this->model->delete" . ucfirst($object) . "DB(\${$object});

		if (\$response['status']) {
			\$this->info(\"Se ha eliminado el registro con ID '{\${$object}->get" . ucfirst($this->columns['info'][0]['COLUMN_NAME']) . "()}'\", debug_backtrace()[0]['function']);
			return \$this->messsageCreated(\$response['info']);
		} else {
			\$this->error(\"No se ha podido eliminar el registro ({\$response['error']})\", debug_backtrace()[0]['function']);
			return \$this->messageInternalServerError(\$response['info']);
		}
	}

}";

		// Guardar el controlador en la ruta local especificada
		if ($this->saveFile('./src/controllers/', "$name.php", $content)) {
			$output->writeln("El controlador '$name' ha sido creado exitosamente en la ruta: './src/controllers/" . $name . ".php'");
		 	return true;
		} else {
			$output->writeln("El controlador '$name' ya se encuentra creado en './src/controllers/{$name}.php'.");
			return false;
		}
	}

	private function setNewObject(): string {
		$content = "new " . $this->entity . "(";

		foreach ($this->columns['info'] as $key => $column) {
			$content .= "\$this->request->" . $this->setNameAttr($column['COLUMN_NAME']) . ", ";
		}

		$content = rtrim($content, ", ");
		return $content . ");";
	}

	private function setAttributes(): string {
		$content = "";

		foreach ($this->columns['info'] as $key => $attr) {
			$content .= "\tprivate ?string \$" . $this->setNameAttr($attr['COLUMN_NAME']) . " = null;\n";
		}

		return $content;
	}

	private function setParams(): string {
		$content = "";

		foreach ($this->columns['info'] as $key => $attr) {
			$content .= "?string \$" . $this->setNameAttr($attr['COLUMN_NAME']) . " = null, ";
		}

		return rtrim($content, ', ');
	}

	private function setValues(): string {
		$content = "";

		foreach ($this->columns['info'] as $key => $attr) {
			$content .= "\n\t\t\$this->" . $this->setNameAttr($attr['COLUMN_NAME']) . " = \$" . $this->setNameAttr($attr['COLUMN_NAME']) . ";";
		}

		return $content;
	}

	private function setGettersSetters(): string {
		$content = "";

		foreach ($this->columns['info'] as $key => $attr) {
			$name = ucfirst($this->setNameAttr($attr['COLUMN_NAME']));
			$content .= "\n\tpublic function get{$name}(): ?string {
		return \$this->" . $this->setNameAttr($attr['COLUMN_NAME']) . ";
	}\n";

			$content .= "\n\tpublic function set{$name}(?string \$" . $this->setNameAttr($attr['COLUMN_NAME']) . " = null): self {
		\$this->" . $this->setNameAttr($attr['COLUMN_NAME']) . " = \$" . $this->setNameAttr($attr['COLUMN_NAME']) . ";
		return \$this;
	}\n";
		}

		return $content;
	}

	private function setCreate(): string {
		$sql = "INSERT INTO {\$this->table} (";

		foreach ($this->columns['info'] as $key => $attr) {
			$sql .= $attr['COLUMN_NAME'] . ", ";
		}

		$sql = rtrim($sql, ", ");

		$sql .= ") VALUES (";

		foreach ($this->columns['info'] as $key => $attr) {
			$sql .= ":" . $this->setNameAttr($attr['COLUMN_NAME']) . ", ";
		}

		$sql = rtrim($sql, ", ");

		$sql .= ")";

		return $sql;
	}

	private function setSelect(bool $indiviudal = false): string {
		$sql = "SELECT * FROM " . "\$this->table";

		$sql .= $indiviudal ? " WHERE {$this->columns['info'][0]['COLUMN_NAME']} = :" . $this->setNameAttr($this->columns['info'][0]['COLUMN_NAME']) : "";

		return $sql;
	}

	private function setUpdate(): string {
		$sql = "UPDATE {\$this->table} SET ";

		for ($i = 1; $i < count($this->columns); $i++) { 
			$sql .= "{$this->columns['info'][$i]['COLUMN_NAME']} = :" . $this->setNameAttr($this->columns['info'][$i]['COLUMN_NAME']) . ", ";
		}

		$sql = rtrim($sql, ", ");

		$sql .= " WHERE {$this->columns['info'][0]['COLUMN_NAME']} = :" . $this->setNameAttr($this->columns['info'][0]['COLUMN_NAME']);

		return $sql;
	}

	private function ignoreId() {
		$order = "";

		for ($i = 1; $i < count($this->columns); $i++) { 
			$order .= "'get" . ucfirst($this->setNameAttr($this->columns['info'][$i]['COLUMN_NAME'])) . "', ";
		}

		$order = rtrim($order, ", ");

		return $order;
	}

	private function setUpdateOrder() {
		$order = $this->ignoreId();

		$order .= ", 'get" . ucfirst($this->setNameAttr($this->columns['info'][0]['COLUMN_NAME'])) . "'";

		return $order;
	}

	public function setNameAttr($name) {
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

	private function getControllerName(string $input) {
		$name = $input;

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

	private function getModelName(string $input) {
		$name = $input;

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