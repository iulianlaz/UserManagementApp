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

    private $_database = null;

    public function __construct() {
        $this->_mongoDAO = new \MongoDB\Client();
        $db = 'people';
        $coll = 'users';

        $this->_database = $this->_mongoDAO->$db;
        $this->_collection = $this->_database->$coll;
    }

    public function insert($data) {
        $this->_collection->insertOne($data);
    }

    public function update($data) {
        $this->_collection->updateOne($data);
    }

    public function delete($ids) {
        $this->_collection->deleteMany();
    }


}