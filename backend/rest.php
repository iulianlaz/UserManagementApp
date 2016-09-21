<?php
require_once('Util/Autoloader.php');

use Core\Interceptor;
use UserResource\Handler;

$interceptor = new Interceptor();
try {
    $request = $interceptor->interceptRequest();
} catch (Exception $e) {
    echo json_encode(array("error" => $e->getMessage()));
}

$handler = new Handler();
try {
    $response = $handler->handle($request);
    echo json_encode(array('result' => $response));
} catch (Exception $e) {
    echo json_encode(array("error" => $e->getMessage()));
}


