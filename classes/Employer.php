<?php

class Employer
{

    private $conn;

    public $id;
    public $username;
    public $password;
    public $email;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getUserData()
    {
        // query
        $sql = "SELECT * FROM employer WHERE id = :id ";
        // statement
        $stmt = $this->conn->prepare($sql);
        // bind the value to the placeholder
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        // execute
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->username = $row['username'];
        $this->password = $row['password'];
        $this->email = $row['email'];
    }

    /**
     * @param string username
     * @param string password
     *    
     * @return boolean true if credentials are checking out or null if they aren't.
     */
    public static function authenticate($conn, $username, $password)
    {
        $sql = "SELECT * 
        FROM employer
        WHERE username = :username";
        // prepare statement
        $stmt = $conn->prepare($sql);
        // bind value
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        // convert into object(from array)
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        // execute
        $stmt->execute();
        // compare passwords
        if ($user = $stmt->fetch()) {
           return password_verify($password, $user->password);
        }
    }

    /**
     * @param object user input 
     * @return boolean check if the new account has been created or not
     */
    public function register($data)
    {
        // sql query
        $sql = "INSERT INTO employer
        (username, password, email)
        VALUES (:username, :password, :email)";
        // prepare statement
        $stmt = $this->conn->prepare($sql);
        // Sanitize data
        $this->username = htmlspecialchars(strip_tags($data->username));
        $this->email = htmlspecialchars(strip_tags($data->email));
        // hash password
        $hashedPassword = password_hash(htmlspecialchars(strip_tags($data->password)), PASSWORD_DEFAULT);
        // bind values
        $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindValue(':password', $this->password, PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
        if ($stmt->execute()) {
            // get the id of the newly created row
            $this->id = $this->conn->lastInsertId();
            return true;
        } else {
            return false;
        }
    }

    /**
     * update user data
     * @param object user data
     * @return boolean to see if the update process was succesful or not
     */
    public function update($data)
    {
        // sql query
        $sql = "UPDATE jobseeker SET 
                username = :username,
                password = :password,
                email = :email
                WHERE id = :id";
        // prepare statement
        $stmt = $this->conn->prepare($sql);
        // bind values

        // Sanitize data
        $this->username = htmlspecialchars(strip_tags($data->username));
        $this->email = htmlspecialchars(strip_tags($data->email));
        // hash password
        $hashedPassword = password_hash(htmlspecialchars(strip_tags($data->password)), PASSWORD_DEFAULT);
        // bind values
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // get the id of the newly created row
            $this->id = $this->conn->lastInsertId();
            return true;
        } else {
            return false;
        }
    }
}
