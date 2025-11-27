<?php

class bazaDanych {
    private $host = 'localhost';
    private $username = 'SMZ';
    private $password = 'haslo123';
    private $database = 'smz_baza_danych';
    private $conn;

    public function __construct() {
        // Utworzenie połączenia z bazą danych
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        // Sprawdzenie połączenia
        if ($this->conn->connect_error) {
            die("Błąd połączenia z bazą danych: " . $this->conn->connect_error);
        }
    }
    
    public function escape($value) {
        return $this->conn->real_escape_string($value);
    }

    public function execute($query) {
        return $this->conn->query($query);
    }
}
?>
