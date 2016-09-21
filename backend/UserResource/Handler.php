<?php
namespace UserResource;

use Core\aHandler;
use Core\Request;

/**
 * Class Handler
 * @package Core
 */
class Handler extends aHandler {
    const USR_RESOURCE = 'user';

    /**
     * Method that handles the request
     * @param Request $request
     */
    public function handle(Request $request) {
        $resName = $request->getResourceName();
        $this->_validateResource($resName);
        $opName = $request->getOperationName();

        $this->_handleOperation($opName);

        return true;

    }

    /**
     * @param $resourceName
     * @return bool
     * @throws \Exception
     */
    private function _validateResource($resourceName) {
        if ($resourceName == self::USR_RESOURCE) {
            return true;
        }

        throw new \Exception('Invalid resource');
    }

    /**
     * @param $opName
     */
    private function _handleOperation($opName) {

    }
}