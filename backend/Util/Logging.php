<?php
namespace Util;

class Logging {

    /**
     * Useful method in order to log things
     * @param $message
     * @param null $data
     */
    public static function log($message, $data = null) {
        error_log($message);
        if (!empty($data)) {
            error_log(print_r($data, true));
        }
}
}