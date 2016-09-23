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
     * The page size
     */
    const PAGE_SIZE = 5;

    /**
     * @var array
     */
    private $_optionMapper = array(
        "page" => "skip"
    );

    /**
     * Mapper for operators
     * @var array
     */
    private $_opMapper = array(
        "asc" => 1,
        "desc" => -1
    );

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
        if (empty($data['currentUsername'])) {
            throw new \Exception('Current username is not set.');
        }

        $data = $this->_validateUserData($data);

        /* Only admin users can add new users */
        if ($this->_checkPermissions($data['currentUsername'])) {
            $currUsername = $data['currentUsername'];
            unset($data['currentUsername']);

            if (empty($data)) {
                return array("message" => "Nothing to update");
            }

            /* Update user */
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

                    /* If currently auth user is updated, then update username from session */
                    $userSession = UserSession::getInstance();
                    $userInfo = $userSession->checkSession();
                    if ($userInfo['username'] == $currUsername) {
                        $userSession->updateUsername($data['username']);
                    }
                }

                /* If currently auth user role is updated, then update role from session */
                if (isset($data['role'])) {
                    $userSession = UserSession::getInstance();
                    $userInfo = $userSession->checkSession();
                    if ($userInfo['username'] == $currUsername) {
                        $userSession->updateRole($data['role']);
                    }
                }

                return $response;
            }
        }

        return array("error" => "Update failed");
    }

    /**
     * Finds users based on query provided
     * If we receive something like: filterValue = "ian" then the following query will be
     * built:
     *  {
     *   "$or": [
     *       {
     *       "username": {
     *       "$regex": "ian"
     *       }
     *    },
     *       {
     *       "role": {
     *       "$regex": "ian"
     *       }
     *   },
     *   {
     *       "email": {
     *       "$regex": "ian"
     *   }}]}
     *
     * @param array $query
     * @return array
     */
    protected function _find($query = array(), $options = array()) {
        if (is_null($query)) {
            $query = array();
        }

        $optionPage = null;
        if (isset($options['page'])) {
            $optionPage = $options['page'];
        }

        /* Validates request query */
        $optionsValidator = new RequestQueryValidator($options);
        $optionsValidator->validateQuery();
        $options = $this->_mapOptions($options);

        /* Validates input query */
        $queryValidator = new InputQueryValidator($query);
        $queryValidator->validateQuery();

        $options['sort'] = $this->_buildSortQuery($query);
        $query = $this->_mapQuery($query);

        if ($this->_checkPermissions()) {
            $result = $this->_dao->find($query, $options);

            if (!empty($result)) {
                $resultArray = $result->toArray();
                $responseArray = $this->_getMandatoryInformation($resultArray);

                $response = array();
                $response['result'] = $responseArray;

                if (!is_null($optionPage)) {
                    $response['totalPages'] = $this->_getPages($query);
                }

                return $response;
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
     * Gets the number of pages
     * @return int
     */
    private function _getPages($query) {
        $noOfPages = 0;

        /* Sets the total number of pages */
        $total = $this->_dao->count($query);
        if (!is_null($total)) {
            $pages = (int)($total / self::PAGE_SIZE);

            $finalPages = null;
            if ($pages == 0) {
                $finalPages = 1;
            } else {
                $pagesReal = $total % self::PAGE_SIZE;
                if ($pagesReal == 0) {
                    $finalPages = $pages;
                } else {
                    $finalPages = $pages + 1;
                }
            }

            $noOfPages = $finalPages;

        }

        return $noOfPages;
    }

    /**
     * Creates response array with useful information
     * @param $resultArray
     * @return array
     */
    private function _getMandatoryInformation($resultArray) {
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

        return $responseArray;
    }

    /**
     * Validates user data
     * @param $data
     */
    private function _validateUserData($data) {
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

        return $data;
    }

    private function _buildSortQuery($query) {
        $sort = array();
        if (isset($query['sortBy']) && isset($query['sortOrder'])) {
            $sort = array(
                $query['sortBy'] => $this->_opMapper[$query['sortOrder']]
            );
        }

        return $sort;
    }

    /**
     * Add query in order to search in username, role and email fields
     * @param $query
     * @return mixed
     */
    private function _mapQuery($query) {
        $newQuery = array();
        if (!empty($query) && (isset($query['filterValue']))) {
            $newQuery = array(
               '$or' => array(
                   array(
                       'username' => array(
                           '$regex' => $query['filterValue'],
                       )
                   ),
                   array(
                       'email' => array(
                           '$regex' => $query['filterValue'],
                       )
                   ),
                   array(
                       'role' => array(
                           '$regex' => $query['filterValue'],
                       )
                   )
               )
            );

            return $newQuery;
        }

        return $newQuery;
    }

    /**
     * Map query according to query mapper
     * @param $query
     * @return array
     */
    private function _mapOptions($options) {
        if (!empty($options)) {

            $newQuery = array();
            foreach ($this->_optionMapper as $key => $value) {
                if (isset($options[$key])) {

                    if ($key == 'page') {
                        if (!empty($options[$key])) {
                            $newQuery[$value] = self::PAGE_SIZE * ($options[$key] - 1);
                        }
                        $newQuery['limit'] = self::PAGE_SIZE;
                    } else {
                        $newQuery[$value] = $options[$key];
                    }
                }
            }

            return $newQuery;
        }

        return $options;
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