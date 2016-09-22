<?php
namespace AuthResource;

use Datasource\MongoDAO;
use Util\Logging;

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
     * @return bool
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

                    Logging::log('-----> Pass data: ', $result);
                    if (password_verify($password, $result[0]['password'])) {
                        Logging::log('-----> OK !!!!');
                        $_SESSION['userIdSession'] = $id;
                        return true;
                    }
                }
            }

            throw new \Exception('Login failed');

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
        if (isset($_SESSION['userIdSession'])) {
            return true;
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
        return true;
    }
}