<?php
namespace Datasource;

use Util\Logging;

require_once("vendor/autoload.php");

/**
 * Database structure:
 *  - username
 *  - role
 *  - email
 *  - password
 *
 * Class MongoDAO
 * @package Datasource
 */
class MongoDAO {
    /**
     * @var \MongoDB\Client|null
     */
    private $_mongoDAO = null;

    /**
     * @var null
     */
    private $_collection = null;

    /**
     * @var \MongoDB\Database|null
     */
    private $_database = null;

    public function __construct() {
        $this->_mongoDAO = new \MongoDB\Client();
        $db = 'people';
        $coll = 'users';

        $this->_database = $this->_mongoDAO->$db;
        $this->_collection = $this->_database->$coll;

        /* Create text index in order to search strings when filter is called */
        $result = $this->_collection->createIndex(array(
            "username" => "text",
            "role" => "text",
            "email" => "text"
        ));
    }

    /**
     * @param $data
     */
    public function insert($data) {
        $result = $this->_collection->insertOne($data);
        if ($result->isAcknowledged()) {
            return true;
        }

        return false;
    }

    /**
     * @param $data
     */
    public function update($query, $data) {
        $result = $this->_collection->updateOne($query, $data);
        if ($result->isAcknowledged()) {
            return true;
        }

        return false;
    }

    /**
     * @param array $query
     * @param array $options
     * @return \MongoDB\Driver\Cursor
     */
    public function find($query = array(), $options = array()) {
        return $this->_collection->find(
            $query,
            $options
        );
    }

    /**
     * Delete docs based on ids (in our case username, because they are unique
     * @param $ids
     */
    public function delete($ids, $field = 'username') {
        $result = $this->_collection->deleteMany(array($field => array('$in' => $ids)));

        if ($result->isAcknowledged()) {
            return true;
        }

        return false;
    }

    /**
     * Counts the number of documents
     * @param array $query
     * @return int
     */
    public function count($query = array()) {
        return $this->_collection->count($query);
    }


}