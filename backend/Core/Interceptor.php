<?php
namespace Core;

class Interceptor {
    private $_request = null;

    public function __construct() {
        $this->_request = new Request();
    }

    /**
     * Builds the request based on input
     * @return Request|null
     */
    public function interceptRequest() {
        $this->_validateRequest();
        $this->_initRequest();
        return $this->_request;
    }

    /**
     * If a restriction must be set, set it here
     * e.g. Content-type: application/json
     * @throws \Exception
     * @return bool
     */
    private function _validateRequest() {
        if (isset($_SERVER['CONTENT_TYPE']) &&
            isset($_SERVER['REQUEST_METHOD']) &&
            ($_SERVER['REQUEST_METHOD'] != 'GET')
        ) {
            if ($_SERVER['CONTENT_TYPE'] != 'application/json') {
                throw new \Exception('Invalid content type');
            }
        }
    }

    /**
     * Initialises the request based on input data
     */
    private function _initRequest() {
        if (isset($_SERVER['PATH_INFO'])) {
            $parts = explode('/', trim($_SERVER['PATH_INFO'], '/'));

            /* Sets the resource name (e.g. rest/user/add -> user will be the resource )*/
            if (isset($parts[0])) {
                $this->_request->setResourceName($parts[0]);
            }

            /* Set the op name (e.g. rest/user/add -> add will be the operation */
            if (isset($parts[1])) {
                $this->_request->setOperationName($parts[1]);
            }
        }

        if (isset($_SERVER['QUERY_STRING'])) {
            parse_str($_SERVER['QUERY_STRING'], $queryArray);
            $this->_request->setQueryParams($queryArray);
        }

        $input = file_get_contents('php://input');
        if (!empty($input)) {
            $payload = json_decode($input, true);
            if (!empty($payload)) {
                $this->_request->setPayload($payload);
            }
        }

    }
}