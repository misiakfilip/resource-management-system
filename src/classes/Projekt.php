<?php

class Projekt {
    private $id;
    private $nazwaProjektu;
    private $dataRozpoczecia;
    private $dataZakonczenia;
    private $kierownikId;

    public function __construct($nazwaProjektu, $dataRozpoczecia, $dataZakonczenia, $kierownikId) {
        $this->nazwaProjektu = $nazwaProjektu;
        $this->dataRozpoczecia = $dataRozpoczecia;
        $this->dataZakonczenia = $dataZakonczenia;
        $this->kierownikId = $kierownikId;
    }

    public function dodajDoBazy(bazaDanych $db) {
        $nazwaProjektu = $db->escape($this->nazwaProjektu);
        $dataRozpoczecia = $db->escape($this->dataRozpoczecia);
        $dataZakonczenia = $db->escape($this->dataZakonczenia);
        $kierownikId = $db->escape($this->kierownikId);

        $query = "INSERT INTO projekty (nazwa_projektu, data_rozpoczecia, data_zakonczenia, kierownik_id) VALUES ('$nazwaProjektu', '$dataRozpoczecia', '$dataZakonczenia', '$kierownikId')";

        if ($db->execute($query)) {
            // Operacja dodawania do bazy danych zakończona sukcesem
            return true;
        } else {
            // Błąd podczas operacji na bazie danych
            return false;
        }
    }

    public function pobierzZBazy(bazaDanych $db, $nazwaProjektu = null) {
        if ($nazwaProjektu === null) {
            $query = "SELECT projekty.ID, nazwa_projektu as nazwa, data_rozpoczecia as 'Data Rozpoczęcia', data_zakonczenia as 'Data Zakończenia', CONCAT(pracownicy.imie, ' ', pracownicy.nazwisko) as kierownik FROM projekty JOIN pracownicy ON projekty.kierownik_id = pracownicy.ID;";
        } else {
            $nazwaProjektu = $db->escape($nazwaProjektu);
            $query = "SELECT projekty.ID, nazwa_projektu as nazwa, data_rozpoczecia as 'Data Rozpoczęcia', data_zakonczenia as 'Data Zakończenia', CONCAT(pracownicy.imie, ' ', pracownicy.nazwisko) as kierownik FROM projekty JOIN pracownicy ON projekty.kierownik_id = pracownicy.ID WHERE nazwa_projektu = '$nazwaProjektu'";
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

    public static function pobierzProjektyZBazy(bazaDanych $db) {
        $query = "SELECT projekty.ID, nazwa_projektu FROM projekty";
        $result = $db->execute($query);
    
        $projekty = [];
    
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $projekty[] = $row;
            }
        }
    
        return $projekty;
    }
    
}
?>
