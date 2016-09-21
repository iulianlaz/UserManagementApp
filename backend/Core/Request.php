<?php
namespace Core;

/**
 * Class Request
 * Encapsulates relevant information from a request.
 * E.g. Request:
 *      - endpoint: rest.php/user/add
 *      - payload:
 *          {
 *              "name": "Iulian",
 *              "email": "test@rest.com"
 *          }
 * Resource name will be "user" and operation name will be "add" in this case
 * @package Util
 */
class Request {
    /**
     * @var null
     */
    private $_resourceName = null;

    /**
     * Operation to be executed
     *
     * @var null
     */
    private $_operationName = null;

    /**
     * @var array
     */
    private $_queryParams = array();

    /**
     * Payload of the request
     * @var null
     */
    private $_payload = null;

    /**
     * @return null
     */
    public function getResourceName() {
        return $this->_resourceName;
    }

    /**
     * @param $resourceName
     */
    public function setResourceName($resourceName) {
        $this->_resourceName = $resourceName;
    }

    /**
     * @return null
     */
    public function getOperationName() {
        return $this->_operationName;
    }

    /**
     * @param $operationName
     */
    public function setOperationName($operationName) {
        $this->_operationName = $operationName;
    }

    /**
     * @return null
     */
    public function getPayload() {
        return $this->_payload;
    }

    /**
     * @param $payload
     */
    public function setPayload($payload) {
        $this->_payload = $payload;
    }

    /**
     * @return array
     */
    public function getQueryParams() {
        return $this->_queryParams;
    }

    /**
     * @param $queryParams
     */
    public function setQueryParams($queryParams) {
        $this->_queryParams = $queryParams;
    }
}