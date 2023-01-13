<?php

// Namespace destinado a los traits
namespace Api\Traits;

//`use NumberFormatter` permite usar la clase NumberFormatter de PHP
use NumberFormatter;

/**
 * Este código es un trait (característica) de PHP, llamado "Number", que se encuentra en el namespace Api\Traits, el cual permite convertir un número a su representación en una cadena de texto, utilizando la clase "NumberFormatter" de PHP. Contiene una variable privada "$formatter", que es una instancia de la clase NumberFormatter, y un método público "numberToString" que recibe una variable que puede ser un entero, un float o un string, y devuelve una cadena de texto con la representación del número en español.
 */
trait Number {

	//`private NumberFormatter $formatter;` es una variable privada que almacena una instancia de la clase NumberFormatter.
	private NumberFormatter $formatter;

	/**
	* Método que convierte un número a su representación en string
	* 
	* @param string|int|float $number Número a convertir
	* @param bool $may Si se quiere que se vuelva en mayúsuculas, o no.
	* @return string representación en string del número
	*/
	public function numberToString(string|int|float $number, bool $may): string {
		// Inicializar variable vacía
		$n = "";

		// Reemplaza cualquier comas o guion medio por un punto
		$number = str_replace(',', '.', str_replace('-', '.', $number));
		
		// Crea un array con las partes del número dividido por puntos
		$number = explode('.', (string) $number);

		// Obtener el decimal si existe, si no lo hay o tiene más de dos dígitos se asigna null
		$decimal = count($number) > 1 && strlen(end($number)) <= 2 ? end($number) : null;
		
		// Concatena todos los elementos del array, exceptuando el último (decimal)
		for ($i = 0; $i < count($number) - 1; $i++) { 
			$n .= $number[$i];
		}

		// Asigna la variable $n al número
		$number = $n;

		// Crea un formateador de números
		$f = new NumberFormatter("es", NumberFormatter::SPELLOUT);
		
		// Formatea el número a su representación en string
		$string = $f->format((int) $number);

		// Si hay decimal, lo agrega al string
		if ($decimal !== null) {
			$string .= ' coma ' . $f->format($decimal);
		}

		// reemplaza las vocales acentuadas por las mismas pero mayúsculas
		$string = str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ'], ["Á", "É", "Í", "Ó", "Ú", "Ñ"], $string);

		// retorna el string completo
		return $string;
	}

}