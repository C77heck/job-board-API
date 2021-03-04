<?php

class Category
{

    private $conn; // connection credentials
    private $table = "category"; // table name we work from



    public $id; //@var integer
    public $name; //@var string


    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }


    /**
     * get all the job adverts
     *
     * @return array An associative array of all the article records
     *
     * job ads
     *  */
    public function getCategories()
    {
        // Get categories

        $sql = "SELECT * FROM {$this->table} ORDER BY name";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    
}
