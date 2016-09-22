<?php
namespace UserResource;
use Util\Logging;

/**
 * Class UserValidator
 * @package UserResource
 */
class UserValidator {
    /**
     * @var array
     */
    private $_userData = array();

    private $_allowedRoles = array('regular', 'admin');

    /**
     * UserValidator constructor.
     * @param $data
     */
    public function __construct($data) {
        $this->_userData = $data;
    }

    public function validateUser() {
        $this->validateRole();
        $this->validateUsername();
        $this->validateEmail();
        $this->validatePassword();
    }

    /**
     * Validates role property
     * @throws \Exception
     */
    public function validateRole() {
        if (empty($this->_userData['role'])) {
            throw new \Exception(' Invalid role');
        }

        if (!in_array($this->_userData['role'], $this->_allowedRoles)) {
            throw new \Exception(' Invalid role');
        }
    }

    /**
     * Validates name propery
     * @throws \Exception
     */
    public function validateUsername() {
        if (empty($this->_userData['username'])) {
            throw new \Exception(' Invalid username');
        }

        if (!is_string($this->_userData['username'])) {
            throw new \Exception(' Invalid username');
        }

        if (strlen($this->_userData['username']) > 257) {
            throw new \Exception(' Invalid username');
        }
    }

    /**
     * Validates email property
     * @throws \Exception
     */
    public function validateEmail() {
        if (empty($this->_userData['email'])) {
            throw new \Exception(' Invalid email');
        }

        if (!is_string($this->_userData['email'])) {
            throw new \Exception(' Invalid email');
        }

    }

    /**
     * Validates password
     * @throws \Exception
     */
    public function validatePassword() {
        if (empty($this->_userData['password'])) {
            throw new \Exception(' Invalid password');
        }

        if (!is_string($this->_userData['password'])) {
            throw new \Exception(' Invalid password');
        }

        /* Password must contain alphanumeric */
        if (!preg_match('/[A-Za-z0-9]+/', $this->_userData['password'])) {
            throw new \Exception(' Invalid password');
        }

        /* Password must contain special chars */
        if (!preg_match('/[^A-Za-z0-9]+/', $this->_userData['password'])) {
            throw new \Exception(' Invalid password');
        }

        if (strlen($this->_userData['password']) < 8) {
            throw new \Exception(' Invalid password');
        }

    }
}