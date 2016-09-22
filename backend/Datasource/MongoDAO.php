<?php
namespace Datasource;

use Util\Logging;

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
     * @param null $query
     * @return array
     */
    public function find($query = array()) {
        return $this->_collection->find(
            $query
        );
    }

    /**
     * Delete docs based on ids (in out case username, because they are unique
     * @param $ids
     */
    public function delete($ids) {
        $result = $this->_collection->deleteMany(array("username" => array('$in' => $ids)));

        if ($result->isAcknowledged()) {
            return true;
        }

        return false;
    }


}