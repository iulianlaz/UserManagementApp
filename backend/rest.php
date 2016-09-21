<?php
require_once('Util/Autoloader.php');

use Core\Interceptor;

$interceptor = new Interceptor();
error_log('____________________________');
try {
    $request = $interceptor->interceptRequest();
    error_log('____________________________');
} catch (Exception $e) {
    echo $e->getMessage();
}
error_log('____________________________');
//$handler = new Handler();
//$handler->handle($request);


