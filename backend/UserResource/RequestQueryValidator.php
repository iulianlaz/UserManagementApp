<?php
namespace UserResource;
use Util\Logging;

/**
 * Class RequestQueryValidator
 * @package UserResource
 */
class RequestQueryValidator extends aQueryValidator  {

    protected $_allowedAttributes = array('page');
}