<?php
namespace AuthResource;

use Core\aHandler;
use UserResource\UserValidator;

/**
 * Class Handler
 * @package Core
 */
class Handler extends aHandler {
    /**
     * Supported operation
     * @var array
     */
    protected $_supportedOps = array(
        '_login',
        '_logout'
    );

    /**
     * @param $data
     */
    protected function _login($data) {
        $userValidator = new UserValidator($data);
        $userValidator->validateUser();
        $userValidator->validatePassword();

        $userSession =  UserSession::getInstance();
        if ($userSession->login($data['username'], $data['password'])) {
            return array(
                "message" => "Successfully authenticated user.",
                "auth" => true
            );
        } else {
            return array(
                "error" => "Authentication failed.",
                "auth" => false
            );
        }
    }

    /**
     * @param $data
     */
    protected function _logout($data) {
        $userSession =  UserSession::getInstance();
        if ($userSession->logout()) {
            return array(
                "message" => "User has been logged out.",
                "auth" => false
            );
        } else {
            return array(
                "error" => "Logout fails."
            );
        }
    }
}