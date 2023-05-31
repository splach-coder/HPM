<?php
require '../../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable("C:/xampp/htdocs/HPM/");
$dotenv->load();

class db
{
    private $host;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    public function __construct()
    {
        $this->host = $_ENV['hostname'];
        $this->username = $_ENV['username'];
        $this->password = $_ENV['password'];
        $this->dbname = $_ENV['dbname'];
    }

    public function getConnection()
    {
        if (!$this->conn) {
            try {
                $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return $this->conn;
    }
}
