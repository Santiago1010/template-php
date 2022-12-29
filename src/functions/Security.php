<?php

// Se declara el namespace de las funciones.
namespace Api\Functions;

/**
 * 
 */
class Security {

	protected function decodeAES($encryptedPassword): ?string {
		if ($encryptedPassword ==='df2WPPWCdgHuSugkb38WKL8fNk8ajuLllDn1iroEdOEjn5d5cUwSE6yvhz3soUMVD3EetOVFhwJ89sLhI08478czAkggYqjxEDnr/Uw8Y5s=') {
			echo "Exactamente iguales";
		}

  		// Desencriptar la contraseña utilizando AES y devolver el resultado como una cadena de texto
		$decryptedPassword = openssl_decrypt(base64_decode($encryptedPassword), 'aes-256-cbc', md5('D2B8803A7A18B9829C7D877F69565433'), OPENSSL_RAW_DATA, 'E5F41EB0046EAE90');

		//var_dump(openssl_error_string());

		return $decryptedPassword;
	}

}