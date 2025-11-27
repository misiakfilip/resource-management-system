<?php

class Zadanie{
    private $id;
    private $nazwaZadania;
    private $opis;
    private $status;
    private $projektId;
    private $pracownikId;

    public function __construct($nazwaZadania, $opis, $status, $projektId, $pracownikId) {
        $this->nazwaZadania = $nazwaZadania;
        $this->opis = $opis;
        $this->status = $status;
        $this->projektId = $projektId;
        $this->pracownikId = $pracownikId;
    }

    public function dodajDoBazy(bazaDanych $db) {
        $nazwaZadania = $db->escape($this->nazwaZadania);
        $opis = $db->escape($this->opis);
        $status = $db->escape($this->status);
        $projektId = $db->escape($this->projektId);
        $pracownikId = $db->escape($this->pracownikId);
    
        $query = "INSERT INTO zadania (nazwa_zadania, opis, status, projekt_id, pracownik_id) 
                  VALUES ('$nazwaZadania', '$opis', '$status', '$projektId', '$pracownikId')";
    
        if ($db->execute($query)) {
            // Operacja dodawania do bazy danych zakończona sukcesem
            return true;
        } else {
            // Błąd podczas operacji na bazie danych
            return false;
        }
    }
    

    public function pobierzZBazy(bazaDanych $db, $nazwa = null) {
        if ($nazwa === null) {
            $query = "SELECT zadania.ID, nazwa_zadania as nazwa, opis, status, projekty.nazwa_projektu as 'Nazwa Projektu', CONCAT(pracownicy.imie, ' ', pracownicy.nazwisko) as Pracownik FROM zadania JOIN projekty ON projekty.ID = zadania.projekt_id JOIN pracownicy ON pracownicy.ID = zadania.pracownik_id";
        } else {
            $nazwa = $db->escape($nazwa);
            $query = "SELECT zadania.ID, nazwa_zadania as nazwa, opis, status, projekty.nazwa_projektu as 'Nazwa Projektu', CONCAT(pracownicy.imie, ' ', pracownicy.nazwisko) as Pracownik FROM zadania JOIN projekty ON projekty.ID = zadania.projekt_id JOIN pracownicy ON pracownicy.ID = zadania.pracownik_id WHERE nazwa_zadania = '$nazwa'"; 
        }

        $result = $db->execute($query);

        if (!$result) {
            // Błąd podczas operacji na bazie danych
            return false;
        }

        $wyniki = [];
        while ($row = $result->fetch_assoc()) {
            $wyniki[] = $row;
        }

        return $wyniki;
    }

    public static function pobierzDostepneStatusy(bazaDanych $db) {
        $query = "SELECT DISTINCT status FROM zadania";
        $result = $db->execute($query);

        $statusy = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $statusy[] = $row['status'];
            }
        }

        return $statusy;
    }
}
?>
