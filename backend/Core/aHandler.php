<?php
namespace Core;

use Datasource\MongoDAO;

/**
 * Class aHandler
 * @package Core
 */
abstract class aHandler {
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
     * @return mixed
     */
    abstract public function handle(Request $request);

}