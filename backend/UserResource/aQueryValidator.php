<?php
namespace UserResource;
use Util\Logging;

/**
 * Class aQueryValidator
 * @package UserResource
 */
class aQueryValidator {
    /**
     * @var array
     */
    protected $_queryData = array();

    /**
     * Allowed attributes
     * @var array
     */
    protected $_allowedAttributes = array();

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
        return true;
    }
}