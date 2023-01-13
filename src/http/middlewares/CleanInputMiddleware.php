<?php

namespace Api\Http\Middlewares;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class CleanInputMiddleware {

    public function __construct(Request $request) {
        // Obtener el contenido del request
        $content = $request->getContent();

        // Verificar si el contenido es un JSON válido
        if(json_decode($content) === null){
            // El contenido no es un JSON válido, no hacer nada
            return;
        }

        // Eliminar código PHP
        $content = preg_replace('/<\?(.*)\?>/', '', $content);

        // Eliminar la etiqueta <script>
        $content = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $content);

        // Eliminar sentencias SQL
        $content = preg_replace('/[\s(;)(\/\*)(--)(\s)]*(SELECT|INSERT|UPDATE|DELETE|DROP|TRUNCATE|ALTER|GRANT|REVOKE|COMMIT|ROLLBACK|CREATE|USE|SHOW|DESCRIBE|EXPLAIN)[\s\S]*[;]*/i', '', $content);

        // Asignar el contenido limpio al request
        $request->request->replace(json_decode($content, true));

        // Crear una sesión con los datos limpios
        $session = new Session();
        $session->start();
        $session->set('clean_request_data', json_decode($content, true));
    }

}