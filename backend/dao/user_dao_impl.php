<?php
require 'user_dao.php';
require '../models/User.php';

class UserDaoImpl implements UserDao
{
    private $db;

    public function __construct()
    {
        require_once '../config/database.php';
        $this->db = Database::getInstance();
    }

    public function saveUser($userVO)
    {
        $connection = $this->db->getConnection();

        $user = new User();
        $user->setName($userVO->getName());
        $user->setEmail($userVO->getEmail());

        if (isset($connection)) {
            $insert = $connection->prepare('INSERT INTO users (name, email) VALUES(:name, :email)');
            $insert->bindValue('name', $user->getName());
            $insert->bindValue('email', $user->getEmail());
            $insert->execute();
            echo json_encode(array("msg" => "created"));
        }

        $connection->close();
    }

    public function getUsers()
    {
        $connection = $this->db->getConnection();

        if (isset($connection)) {
            $query = "SELECT * FROM users";
            $users = array();
            $i = 0;

            $results = $this->connection->query($query);
            //En caso de que la consulta falle
            if (!$results) {
                die("Error en la consulta");
            }
            //Los resultados de la consulta son guardados en un array asociativo
            while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
                $users[$i] = $row;
                $i++;
            };

            $results = null;
            $connection->close();
            return json_encode($users);
        }
    }
}
