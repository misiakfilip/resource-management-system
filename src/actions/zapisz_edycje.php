<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../database/bazaDanych.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$db = new bazaDanych('localhost', 'SMZ', 'haslo123', 'smz_baza_danych');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['klasa']) && isset($_POST['idRekordu'])) {
        $klasa = $_POST['klasa'];
        $idRekordu = $_POST['idRekordu'];

        // Pobierz informacje o kolumnach
        $queryColumns = "SHOW COLUMNS FROM $klasa";
        $resultColumns = $db->execute($queryColumns);

        if ($resultColumns->num_rows > 0) {
            $columns = array();
            while ($row = $resultColumns->fetch_assoc()) {
                $columns[] = $row['Field'];
            }

            // Aktualizuj rekord w bazie danych
            $updateValues = array();
            foreach ($columns as $column) {
                if (isset($_POST[$column])) {
                    $value = $db->escape($_POST[$column]);
                    $updateValues[] = "$column = '$value'";
                }
            }

            $updateQuery = "UPDATE $klasa SET " . implode(', ', $updateValues) . " WHERE ID = $idRekordu";
            $resultUpdate = $db->execute($updateQuery);

            if ($resultUpdate) {
                echo "Zmiany zostały zapisane.";
            } else {
                echo "Błąd podczas zapisywania zmian.";
            }
        } else {
            echo "Błąd podczas pobierania informacji o kolumnach.";
        }
    } else {
        echo "Brak wymaganych danych.";
    }
} else {
    echo "Nieprawidłowe żądanie.";
}
header('Location: StronaGlowna.php'); 
?>
