<?php


class JobSeeker
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
        $sql = "SELECT * FROM jobseeker WHERE id = :id ";
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
        FROM jobseeker
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

    public static function login()
    {
        // deal with session fixation attacks
        session_regenerate_id(true);
        /* have a look we might not need this. */
    }
    /* this might just be turned into a sql query to change the user data. */
    public static function logout()
    {
        // empty session superglobal
        $_SESSION = [];

        // destroy cookies if session used cookies
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
    }
    /**
     * @param object user input 
     * @return boolean check if the new account has been created or not
     */
    public function register($data)
    {
        // sql query
        $sql = "INSERT INTO jobseeker
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
        // hash the password
        $hashedPassword = password_hash(htmlspecialchars(strip_tags($data->password)), PASSWORD_DEFAULT);
        // bind values
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
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
