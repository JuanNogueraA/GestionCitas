
<?php
class DataBase {
    private static $instance = null;
    private $connection;

    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "gestiondecitas";

    private function __construct() {
        $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->connection->connect_error) {
            throw new Exception("Connection failed: " . $this->connection->connect_error);
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DataBase();
        }

        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>