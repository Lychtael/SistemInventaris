<?php

class Auth_model {
    private $dbh;
    private $stmt;

    public function __construct() {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        try {
            $this->dbh = new PDO($dsn, DB_USER, DB_PASS);
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getUserByUsername($username) {
        $this->stmt = $this->dbh->prepare('SELECT * FROM users WHERE username = :username');
        $this->stmt->bindValue(':username', $username);
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
}