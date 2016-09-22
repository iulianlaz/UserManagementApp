<?php
/**
 * Possible response attributes:
 * {
 *  "result": "",
 *  "auth": "",
 *  "error" : "",
 *  "message": ""
 * }
 */

session_start();

require_once('Util/Autoloader.php');

use Core\Interceptor;
use AuthResource\UserSession;

/* Builds the Request object. If an error occurs, exit */
$interceptor = new Interceptor();
try {
    $request = $interceptor->interceptRequest();
} catch (Exception $e) {
    echo json_encode(array("error" => $e->getMessage()));
    exit();
}

/* Get resource name in order to initialize the handler for that resource. */
$resourceName = $request->getResourceName();
if (empty($resourceName)) {
    echo json_encode(array("error" => 'Invalid resource name'));
    exit();
}

/* Check authentication: Check if user is logged in or not */
$userSession = UserSession::getInstance();
if (!$userSession->isLoggedIn()) {

    /* Only login method could be accessed if we are not authenticated */
    $allowedResource = 'auth';
    $opAllowedNoAuth = array('login', 'check');

    /* Should continue only for login operation for auth resource. Otherwise, exit */
    if (($resourceName !== $allowedResource) && !in_array($request->getOperationName(), $opAllowedNoAuth)) {
        echo json_encode(array(
                "error" => 'You are not authenticated',
                "auth" => false
            )
        );
        exit();
    }
}

/* Handles the request */
$resourceHandlerName = '\\' . ucfirst(strtolower($resourceName)) . 'Resource\\Handler';
try {
    $handler = new $resourceHandlerName();
    $response = $handler->handle($request);
    echo json_encode($response);
} catch (Exception $e) {
    echo json_encode(array("error" => $e->getMessage()));
}


