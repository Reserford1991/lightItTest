<?php
include 'dbConfig.php';

class Model
{
    private $servername;
    private $username;
    private $password;
    private $dbname;

    public function __construct (){
        $this->servername =  $GLOBALS['servername'];
        $this->username =  $GLOBALS['username'];
        $this->password =  $GLOBALS['password'];
        $this->dbname =  $GLOBALS['dbname'];
        $this->message = $GLOBALS['message'];
    }

    public function createTable() {
        // Create connection
        $conn = new mysqli($this->servername, $this->username, $this->password);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Create database
        $sql = "CREATE DATABASE IF NOT EXISTS " . $this->dbname . ";";
        if (!$conn->query($sql) === TRUE) {
            $this->message .= "Error creating database: " . $conn->error;
        }

//        $conn->close();

        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "CREATE TABLE IF NOT EXISTS messages (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        f_user VARCHAR(30) NOT NULL,
        text TEXT NOT NULL,
        date TIMESTAMP,
        post_id VARCHAR(30),
        parent_id VARCHAR(30)
        )";

        if (!$conn->query($sql) === TRUE) {
            $this->message .= "Error creating table: " . $conn->error;
        }

        if ($conn->error) {
            echo "<script type='text/javascript'>alert('$this->message');</script>";
        }

        $conn->close();
    }

    public function saveData() {
        // Escape any html characters


        //getting facebook user_id
        if ($_COOKIE['fbsr_1417698314990838'] && $_POST['textMessage'] != "") {
            $signed_request = $_COOKIE['fbsr_1417698314990838'];
            list($encoded_sig, $payload) = explode('.', $signed_request, 2);
            $secret = '45db544825e706834f614a09d53dbc5c'; //secret of app

            // decode the data
            $sig = $this->base64_url_decode($encoded_sig);
            $data = json_decode($this->base64_url_decode($payload), true);

            // preparing data to save into database
            $text = htmlentities($_POST['textMessage']);
            $user_id = $data['user_id'];
            $date = date('Y-m-d H:i:s');
            $post_id = uniqid();
            if ($_POST['parent_id']) {
                $parent_id = $_POST['parent_id'];
            }

            // confirm the signature
            $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
            if ($sig !== $expected_sig) {
                error_log('Bad Signed JSON signature!');
                return null;
            }

            //connecting to database to save data
            $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "INSERT INTO messages (f_user, text, date, post_id, parent_id)
                VALUES ('$user_id', '$text', '$date' , '$post_id', '$parent_id')";

            if (!$conn->query($sql) === TRUE) {
                $this->message .= "Error saving data: " . $conn->error;
            }

            if ($conn->error) {
                echo "<script type='text/javascript'>alert('$this->message');</script>";
            }
            $conn->close();
//            return $data;
        }
    }

    public function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    public function getAllData() {
        // Create connection
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT id, f_user, text, date, post_id, parent_id FROM messages ORDER BY date DESC";
        $result = $conn->query($sql);
        $arr =  array();
        $arr = $result;
        //Put all data into variable
        $text = "";
        if ($result->num_rows > 0) {
            // return data of each row
            while($row = $result->fetch_assoc()) {
                $text .= "( " . $row["date"]. " ) " . $row["text"]. "<br><br>";
            }
        } else {
            echo "0 results";
        }
        return $text;
        $conn->close();
    }
}