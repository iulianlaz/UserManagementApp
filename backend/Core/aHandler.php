<?php
namespace Core;

use Datasource\MongoDAO;

/**
 * Class aHandler
 * @package Core
 */
abstract class aHandler {
    /**
     * Supported operation
     * @var array
     */
    protected $_supportedOps = array();

    /**
     * Data access object
     */
    protected $_dao = null;

    public function __construct() {
        $this->_dao = new MongoDAO();
    }

    /**
     * Method that handles the request
     * @param Request $request
     */
    public function handle(Request $request) {
        $opName = $request->getOperationName();

        return $this->_handleOperation($opName, $request->getPayload());
    }

    /**
     * Handles the operation
     * E.g. If a user must be added and "add" operation was called, then _addUser method will
     * be called
     * @throws \Exception
     * @param $opName
     */
    private function _handleOperation($opName, $data) {
        $methodName = '_' . strtolower($opName);

        if (!in_array($methodName, $this->_supportedOps)) {
            throw new \Exception('Operation not supported');
        }

        try {
            return $this->$methodName($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}