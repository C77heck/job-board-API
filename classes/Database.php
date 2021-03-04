<?php

class Database
{
    // Get DB params
    public function __construct($host, $name, $user, $password)
    {
        $this->db_host = $host;
        $this->db_name = $name;
        $this->db_user = $user;
        $this->db_pass = $password;
    }

    //DB connect
    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->db_host . ';dbname=' . $this->db_name,
                $this->db_user,
                $this->db_pass
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $err) {
            echo 'Connection Error: ' . $err->getMessage();
        }

        return $this->conn;
    }
};
