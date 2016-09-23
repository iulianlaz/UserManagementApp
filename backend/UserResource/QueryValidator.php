<?php
namespace UserResource;
use Util\Logging;

/**
 * Class UserValidator
 * @package UserResource
 */
class QueryValidator {
    /**
     * @var array
     */
    private $_queryData = array();

    private $_allowedAttributes = array('page');

    /**
     * UserValidator constructor.
     * @param $data
     */
    public function __construct($data) {
        $this->_queryData = $data;
    }

    /**
     * Only some attributes must be allowed
     * @throws \Exception
     * @return bool
     */
    public function validateQuery() {
        $inputKeys = array_keys($this->_queryData);

        if (array_diff($inputKeys, $this->_allowedAttributes)) {
            throw new \Exception(' Invalid query params');
        }

        if (empty($this->_queryData['page'])) {
            throw new \Exception(' Invalid page param');
        }

        return true;
    }
}