<?php

class Pracownik {
    private $id;
    private $imie;
    private $nazwisko;
    private $email;
    private $haslo;
    private $id_rola;

    public function __construct($imie, $nazwisko, $email, $haslo, $id_rola) {
        $this->imie = $imie;
        $this->nazwisko = $nazwisko;
        $this->email = $email;
        $this->haslo = password_hash($haslo, PASSWORD_DEFAULT); 
        $this->id_rola = $id_rola;
    }

    public function dodajDoBazy(bazaDanych $db) {
        $imie = $db->escape($this->imie);
        $nazwisko = $db->escape($this->nazwisko);
        $email = $db->escape($this->email);
        $haslo = $db->escape($this->haslo);
        $id_rola = $db->escape($this->id_rola);

        $query = "INSERT INTO pracownicy (imie, nazwisko, email, haslo, id_rola) VALUES ('$imie', '$nazwisko', '$email', '$haslo', '$id_rola')";

        if ($db->execute($query)) {
            // Operacja dodawania do bazy danych zakończona sukcesem
            return true;
        } else {
            // Błąd podczas operacji na bazie danych
            return false;
        }
    }

    public function pobierzZBazy(bazaDanych $db, $imie = null, $nazwisko = null) {  
        if ($imie === null && $nazwisko === null) {
            $query = "SELECT pracownicy.ID, imie, nazwisko, role.nazwa AS rola FROM pracownicy JOIN role ON pracownicy.id_rola = role.id;";
        } else {
            $imie = $db->escape($imie);
            $nazwisko = $db->escape($nazwisko);
            $query = "SELECT pracownicy.ID, imie, nazwisko, role.nazwa AS rola FROM pracownicy JOIN role ON pracownicy.id_rola = role.id WHERE imie = '$imie' AND nazwisko = '$nazwisko'";
        }
    
        $result = $db->execute($query);
    
        if (!$result) {
            //Błąd podczas operacji na bazie danych
            return false;
        }
    
        $wyniki = [];
        while ($row = $result->fetch_assoc()) {
            $wyniki[] = $row;
        }
    
        return $wyniki;
    }
    public static function pobierzRoleZBazy(bazaDanych $db) {
        $query = "SELECT id, nazwa FROM role";
        $result = $db->execute($query);

        $role = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $role[$row['id']] = $row['nazwa'];
            }
        }
        return $role; 
    }
    public static function pobierzKierownikowZBazy(bazaDanych $db) {
        $query = "SELECT ID, imie, nazwisko FROM pracownicy WHERE id_rola = 3";
        $result = $db->execute($query);
    
        $kierownicy = [];
    
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $kierownicy[] = $row;
            }
        }
    
        return $kierownicy;
    }
    public static function pobierzPracownikowZBazy(bazaDanych $db) {
        $query = "SELECT ID, imie, nazwisko FROM pracownicy";
        $result = $db->execute($query);
    
        $pracownicy = [];
    
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $pracownicy[] = $row;
            }
        }
    
        return $pracownicy;
    }    
}
?>
