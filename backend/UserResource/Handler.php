<?php
namespace UserResource;

use Core\aHandler;
use Util\Logging;
use Util\Util;

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
        '_add',
        '_edit',
        '_delete'
    );

    /**
     * @param $data
     */
    protected function _add($data) {
        $validator = new UserValidator($data);
        $validator->validateUser();

        /* Username must be unique */
        $this->_checkUsername($data['username']);

        $data['password'] = Util::encryptPassword($data['password']);
        return $this->_dao->insert($data);
    }

    /**
     * Username must be unique, we must check if it exists in database
     * @throws \Exception
     * @param $username
     */
    private function _checkUsername($username) {
        $result = $this->_dao->find(array("username" => $username));
        $resultArray = $result->toArray();

        if (!empty($resultArray)) {
            throw new \Exception(('Username already exists'));
        }

        return true;
    }

    /**
     * @param $data
     */
    protected function _edit($data) {

    }

    /**
     * @param $ids
     */
    protected function _delete($ids) {

    }
}