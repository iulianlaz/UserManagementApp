<?php
namespace UserResource;

use Core\aHandler;
use Core\Request;
use Util\Logging;
use Util\Util;

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

        $this->_handleOperation($opName, $request->getPayload());

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
    private function _handleOperation($opName, $data) {
        $validator = new UserValidator($data);
        switch ($opName) {
            case 'add':
                // FIXME: username must be UNIQUE
                $validator->validateUser();
                $data['password'] = Util::encryptPassword($data['password']);
                $this->_dao->insert($data);
                break;

            case 'edit':
                // To do : validate editable attr + encrypt pass
                break;

            case 'delete':
                $this->_dao->delete($data);
                break;

            default:
                throw new \Exception('Invalid operation name');
        }
    }
}