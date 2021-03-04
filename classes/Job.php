<?php

/**
 * Job
 * 
 *job adverts
 */
class Job
{
    // DB stuff
    private $conn; // connection credentials
    private $table = 'adverts'; // table name we work from
  

    public $id; //@var integer
    public $job_title; //@var string
    public $content; //@var string
    public $salary; //@var integer
    public $company_name; //@var string
    public $submitted_at; //@var date-time

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
    public function getAds()
    {
        //Get jobs ads

        $sql  = "SELECT *
        FROM {$this->table}
        ORDER BY submitted_at DESC";
        /*  figure the query we need to write to get the right data*/

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt;
    }


    public function getAdById()
    {

        //query
        $sql = "SELECT *
        FROM {$this->table}
        WHERE id = :id
        LIMIT 0,1";

        //statement
        $stmt = $this->conn->prepare($sql);
        // bind the value to the placeholder
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        // execute
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->job_title = $row['job_title'];
        $this->content = $row['content'];
        $this->salary = $row['salary'];
        $this->company_name = $row['company_name'];
        $this->submitted_at = $row['submitted_at'];
        /* we need to bind the class values to the returned values in order to be
        able to use them. */
    }
    //Create job ad
    public function create()
    {

        $sql = "INSERT INTO {$this->table}
        SET 
            job_title = :job_title,
            content= :content,
            salary = :salary,
            company_name = :company_name,
            submitted_at = :submitted_at";

        // Prepare statement

        $stmt = $this->conn->prepare($sql);

        // Sanitize data
        $this->job_title = htmlspecialchars(strip_tags($this->job_title));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->salary = htmlspecialchars(strip_tags($this->salary));
        $this->company_name = htmlspecialchars(strip_tags($this->company_name));
        $this->submitted_at = htmlspecialchars(strip_tags($this->submitted_at));

        // Bind data
        $stmt->bindValue(':job_title', $this->job_title, PDO::PARAM_STR);
        $stmt->bindValue(':content', $this->content, PDO::PARAM_STR);
        $stmt->bindValue(':salary', $this->salary, PDO::PARAM_STR);
        $stmt->bindValue(':company_name', $this->company_name, PDO::PARAM_STR);
        $stmt->bindValue(':submitted_at', $this->submitted_at, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        }

        // Error handling
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function update()
    {

        $sql = "UPDATE {$this->table}
        SET 
            job_title = :job_title,
            content= :content,
            salary = :salary,
            company_name = :company_name,
            submitted_at = :submitted_at
            WHERE id = :id";

        // Prepare statement

        $stmt = $this->conn->prepare($sql);

        // Sanitize data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->job_title = htmlspecialchars(strip_tags($this->job_title));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->salary = htmlspecialchars(strip_tags($this->salary));
        $this->company_name = htmlspecialchars(strip_tags($this->company_name));
        $this->submitted_at = htmlspecialchars(strip_tags($this->submitted_at));

        // Bind data
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':job_title', $this->job_title, PDO::PARAM_STR);
        $stmt->bindValue(':content', $this->content, PDO::PARAM_STR);
        $stmt->bindValue(':salary', $this->salary, PDO::PARAM_INT);
        $stmt->bindValue(':company_name', $this->company_name, PDO::PARAM_STR);
        $stmt->bindValue(':submitted_at', $this->submitted_at, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        }

        // Error handling
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    /**
     * delete ad. 
     * @return boolean to condition the if statement in the file being used
     */
    public function delete()
    {
        $sql = "DELETE FROM {$this->table}
        WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }
}
