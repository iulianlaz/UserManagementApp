<?php
namespace AuthResource;

use Datasource\MongoDAO;
use Util\Logging;
use Util\Util;

/**
 * Class UserSession
 * @package Auth
 */
class UserSession {
    private $_dao = null;

    private static $_instance = null;

    private function __construct() {
        $this->_dao = new MongoDAO();
    }

    public static function getInstance() {
        if (empty(self::$_instance)) {
            return new self();
        }
    }

    /**
     * Login the user
     * @param $username
     * @param $password
     * @return mixed
     * @throws \Exception
     */
    public function login($username, $password) {
        try
        {
            $cursor = $this->_dao->find(array(
                "username" => $username
            ));
            $result = $cursor->toArray();

            /* Set session for current user */
            if (!empty($result)) {
                if (isset($result[0])) {

                    if (is_string($result[0]['_id'])) {
                        $id = $result[0]['_id'];
                    } else {
                        $id = $result[0]['_id']->__toString();
                    }

                    if (Util::checkPassword($password, $result[0]['password'])) {
                        $_SESSION['userIdSession'] = $id;
                        $_SESSION['userInfo'] = array(
                          "username" => $result[0]['username'],
                          "role" => $result[0]['role']
                        );
                        return $_SESSION['userInfo'];
                    } else {
                        throw new \Exception('Invalid login password');
                    }
                }
            }

            throw new \Exception('Invalid login username');

        }
        catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Checks if user is authenticated
     * @return bool
     */
    public function isLoggedIn() {
        if (isset($_SESSION['userIdSession']) && isset($_SESSION['userInfo'])) {
            return true;
        }

        return false;
    }

    public function checkSession() {
        if ($this->isLoggedIn()) {
            return $_SESSION['userInfo'];
        }

        return false;
    }

    public function isAdmin() {
        if ($this->isLoggedIn()) {
            return ($_SESSION['userInfo']['role'] == 'admin');
        }

        return false;
    }

    /**
     * Logout user
     * @return bool
     */
    public function logout() {
        session_destroy();
        unset($_SESSION['userIdSession']);
        unset($_SESSION['userInfo']);
        return true;
    }
}