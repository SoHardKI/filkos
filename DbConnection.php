<?php


class DbConnection
{
    private string $host = HOST;
    private string $dbname = DB;
    private string $username = DBUSER;
    private string $password = DBPASS;

    public $con = '';

    /**
     * DbConnection constructor.
     */
    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        try {
            $this->con = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4;", $this->username, $this->password);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'We\'re sorry but there was an error while trying to connect to the database';
        }
    }
}