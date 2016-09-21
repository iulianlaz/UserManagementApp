<?php
namespace Auth;

use Datasource\MongoDAO;
use Util\Util;

/**
 * Class UserSession
 * @package Auth
 */
class UserSession {
    private $_dao = null;

    public function __construct() {
        $this->_dao = new MongoDAO();
    }

    public function login($username, $password) {
        try
        {
            $cursor = $this->_dao->find(array(
                "username" => $username,
                "password" => Util::encryptPassword($password))
            );

            // FIXME here with cursor :)
            if (!empty($cursor)) {
                $_SESSION['userIdSession'] = $cursor['_id'];
                return true;
            } else {
                return false;
            }
        }
        catch(\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function isLoggedIn() {
        if (isset($_SESSION['userIdSession'])) {
            return true;
        }

        return false;
    }

    public function logout() {
        session_destroy();
        unset($_SESSION['userIdSession']);
        return true;
    }
}