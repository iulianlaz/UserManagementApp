<?php
namespace UserResource;
use Util\Logging;

/**
 * Class InputQueryValidator
 * @package UserResource
 */
class InputQueryValidator extends aQueryValidator  {

    /**
     * @var array
     */
    protected $_allowedAttributes = array('filterValue', 'sortBy', 'sortOrder');

    /**
     * @var array
     */
    protected $_allowedSortOrderOp = array('asc', 'desc');

    /**
     * Only some attributes must be allowed
     * @throws \Exception
     * @return bool
     */
    public function validateQuery() {
        parent::validateQuery();

        if (isset($this->_queryData['sortOrder']) &&
            !in_array($this->_queryData['sortOrder'], $this->_allowedSortOrderOp)) {
            throw new \Exception('Invalid sortOrder');
        }
        return true;
    }

}