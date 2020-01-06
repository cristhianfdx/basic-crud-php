<?php

require 'user_controller.php';

$controller = null;
$action = null;
$method = null;
$request = null;

if (!isset($_GET['action']) && !isset($_GET['method'])) {
    // Se obtiene JSON del request de la petición
    $request = json_decode(file_get_contents('php://input'), true);

    // Datos del JSON para llamar al controller y método solicitado
    $action = $request['action'];
    $method = $request['method'];
} else {
    $action = $_GET['action'];
    $method = $_GET['method'];
}


if (isset($action) && $action == 'users') {
    $controller = new UserController();
    $user = $request['user'];

    switch ($method) {
        case 'create-user':
            $controller->user_post($user);
            break;
        case 'get-users':
            $controller->user_get();
            break;

        default:
            # code...
            break;
    }
}
