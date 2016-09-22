<?php
namespace Datasource;

require("Datasource/vendor/autoload.php");

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
    }

    /**
     * @param $data
     */
    public function insert($data) {
        $this->_collection->insertOne($data);
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
     * @param null $query
     * @return \MongoDB\Driver\Cursor
     */
    public function find($query = null) {
        return $this->_collection->find(
            $query
        );
    }

    /**
     * @param $ids
     */
    public function delete($ids) {
        $this->_collection->deleteMany(array("_id" => array('$in' => $ids)));
    }


}