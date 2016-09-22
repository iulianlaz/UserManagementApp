<?php
namespace Util;

class Util {
    /**
     * Encrypts the password
     * @param $password
     * @return bool|string
     */
    public static function encryptPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Checks password
     * @param $password
     * @param $hash
     * @return bool
     */
    public static function checkPassword($password, $hash) {
        return password_verify($password, $hash);
    }
}