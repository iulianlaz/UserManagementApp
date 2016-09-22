<?php
namespace Util;

class Util {
    /**
     * @param $password
     * @return bool|string
     */
    public static function encryptPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}