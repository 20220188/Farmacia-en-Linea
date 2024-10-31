<?php
// Se incluye la clase del modelo.
require_once('../../models/data/bodega_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    session_start();
    $bodega = new BodegaData;
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null);

    // Se verifica si existe una sesión iniciada como administrador.
    if (isset($_SESSION['idAdministrador'])) {
        switch ($_GET['action']) {
           

            case 'readAll':
                if ($result['dataset'] = $bodega->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Se encontraron ' . count($result['dataset']) . ' bodegas';
                } else {
                    $result['error'] = 'No hay bodegas registradas';
                }
                break;

           
            default:
                $result['error'] = 'Acción no disponible dentro de la sesión';
        }

        // Se obtiene la excepción del servidor de base de datos.
        $result['exception'] = Database::getException();
        header('Content-type: application/json; charset=utf-8');
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}