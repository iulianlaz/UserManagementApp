<?php
namespace UserResource;

use AuthResource\UserSession;
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
        '_find',
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

        /* Only admin users can add new users */
        if ($this->_checkPermissions()) {
            $data['password'] = Util::encryptPassword($data['password']);
            $result = $this->_dao->insert($data);

            if ($result) {
                return array("message" => "User successfully updated");
            }
        }

        return array("error" => "User cannot be created");
    }

    /**
     * Edit user
     * Users are edited based on their username (they are unique)
     * @param $data
     */
    protected function _edit($data) {
        if (!isset($data['currentUsername'])) {
            throw new \Exception('Current username is not set.');
        }

        $validator = new UserValidator($data);

        /* Username must be unique */
        if (isset($data['username'])) {
            $validator->validateUsername();
            $this->_checkUsername($data['username']);
        }

        /* Validate password. Also, encrypts it */
        if (isset($data['password'])) {
            $validator->validatePassword();
            $data['password'] = Util::encryptPassword($data['password']);
        }

        /* Validate role */
        if (isset($data['role'])) {
            $validator->validateRole();
        }

        /* Validate email */
        if (isset($data['email'])) {
            $validator->validateEmail();
        }

        /* Only admin users can add new users */
        if ($this->_checkPermissions($data['currentUsername'])) {
            $currUsername = $data['currentUsername'];
            unset($data['currentUsername']);

            if (empty($data)) {
                return array("message" => "Nothing to update");
            }

            $result = $this->_dao->update(
                array("username" => $currUsername),
                array('$set' => $data)
            );

            if ($result) {
                $response = array(
                    "message" => "User successfully updated",
                );

                if (isset($data['username'])) {
                    $response['result']['username'] = $data['username'];
                }

                /* If currently auth user is updated, then update username from session */
                $userSession = UserSession::getInstance();
                $userInfo = $userSession->checkSession();
                if ($userInfo['username'] == $currUsername) {
                    $userSession->updateUsername($data['username']);
                }

                return $response;
            }
        }

        return array("error" => "Update failed");
    }

    protected function _find($query = array()) {
        if (empty($query)) {
            $query = array();
        }

        if ($this->_checkPermissions()) {
            $result = $this->_dao->find($query);
            if (!empty($result)) {
                $resultArray = $result->toArray();

                /* Do not return all fields, only the one that we need */
                $responseArray = array();
                foreach($resultArray as $key => $value) {
                    $mandatoryFields = array();
                    if (isset($value['username'])) {
                        $mandatoryFields['username'] = $value['username'];
                    }

                    if (isset($value['email'])) {
                        $mandatoryFields['email'] = $value['email'];
                    }

                    if (isset($value['role'])) {
                        $mandatoryFields['role'] = $value['role'];
                    }

                    if (!empty($mandatoryFields)) {
                        $responseArray[] = $mandatoryFields;
                    }
                }


                return array("result" => $responseArray);
            }
        }

        return array("error" => "Find method failed");
    }

    /**
     * Delete users based on their usernames
     * @param $ids
     */
    protected function _delete($ids) {
        /* Only admin users can add new users */
        if ($this->_checkPermissions()) {
            $result = $this->_dao->delete($ids);
            if (!empty($result)) {
                return array("message" => "Users have been deleted.");
            }
        }

        return array("error" => "Delete method failed");
    }

    /**
     * Check permission
     * @return bool
     * @throws \Exception
     */
    private function _checkPermissions($username = null) {
        $userSession = UserSession::getInstance();

        /* If current auth user is the user that edits his details, go further */
        if (!empty($username)) {
            $userInfo = $userSession->checkSession();
            if ($userInfo['username'] == $username) {
                return true;
            }
        }

        if ($userSession->isAdmin()) {
            return true;
        }

        throw new \Exception('User does not have permission to call this method');
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
}