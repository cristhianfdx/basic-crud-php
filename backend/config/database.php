<?php

// Se usa el patrón Singleton para obtener la conexión a la base de datos

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        require_once 'config.php';
        $this->initConnection();
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    private function initConnection()
    {
        try {
            $this->connection = new PDO("mysql:host=" . DB_HOST . "; dbname=" .
                DB_NAME, DB_USERNAME, DB_PASSWORD);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->exec("SET CHARACTER SET utf8");
        } catch (PDOException $ex) {
            echo "Error en la conexión :" . $ex->getMessage() . "<br>";
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
