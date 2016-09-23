<?php
namespace UserResource;
use Util\Logging;

/**
 * Class InputQueryValidator
 * @package UserResource
 */
class InputQueryValidator extends aQueryValidator  {

    protected $_allowedAttributes = array('filterValue');

}