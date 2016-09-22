<?php
/**
 * This script will add an admin user in mongo database (people database, users collection)
 * If an admin user already exists, it will not be touched
 * If you run this with forcedel argument, then existent admin username will be deleted
 * You can run this script as follows:
 *  php initDatabase.php <forcedel>
 */
require_once ("MongoDAO.php");
require_once("../Util/Util.php");

use Datasource\MongoDAO;
use Util\Util;

$mongoDAO = new MongoDAO();

/* Deletes existent admin users */
if (isset($argv[1]) && ($argv[1] === 'forcedel')) {
    $mongoDAO->delete(array(
        "admin"
    ));
}

/* Check if we already have an admin user */
$result = $mongoDAO->find(array(
    "username" => "admin"
));

if (!empty($result)) {
    $resultArray = $result->toArray();
    if (count($resultArray) > 0) {
        echo "It already exists an admin user" . PHP_EOL;
        echo "Result:" . json_encode($resultArray, JSON_PRETTY_PRINT) . PHP_EOL;
        exit();
    }
}

/* Insert admin user */
$result = $mongoDAO->insert(array(
    "username" => "admin",
    "password" => Util::encryptPassword('admin123#'),
    "role" => "admin",
    "email" => "admin@mongo.com"
    )
);

if ($result) {
    echo 'Admin was successfully created' . PHP_EOL;
} else {
    echo 'Admin user was not created' . PHP_EOL;
}