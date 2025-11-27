<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../database/bazaDanych.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$db = new bazaDanych('localhost', 'SMZ', 'haslo123', 'smz_baza_danych');

if (isset($_POST['idRekordu'])) {
    $idRekordu = $_POST['idRekordu'];

    // Pobieranie informacji o rekordzie na podstawie ID
    $klasa = $_SESSION['klasa']; // Klasa rekordu (pracownik, projekt, zadanie)
    $query = "SELECT * FROM $klasa WHERE ID = $idRekordu";
    $result = $db->execute($query);

    if ($result->num_rows > 0) {
        $rekord = $result->fetch_assoc();

        // Pobieranie informacji o kolumnach dla danej klasy
        $queryColumns = "SHOW COLUMNS FROM $klasa";
        $resultColumns = $db->execute($queryColumns);

        if ($resultColumns->num_rows > 0) {
            $columns = array();
            while ($row = $resultColumns->fetch_assoc()) {
                $columns[] = $row['Field'];
            }

            // Wyświetlanie formularza edycji w formie tabeli
            ?>
            <!DOCTYPE html>
            <html lang="pl">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Edytuj rekord</title>
                <link rel="stylesheet" type="text/css" href="style.css">
            </head>
            <body>
                <h1>Edytuj rekord</h1>
                <form action="zapisz_edycje.php" method="post">
                    <input type="hidden" name="klasa" value="<?php echo $klasa; ?>">
                    <input type="hidden" name="idRekordu" value="<?php echo $rekord['ID']; ?>">
                    <table border='1'>
                        <tr>
                            <th>Nazwa pola</th>
                            <th>Wartość</th>
                        </tr>
                        <?php
                        foreach ($columns as $column) {
                            echo "<tr>";
                            echo "<td>$column</td>";
                            echo "<td><input type='text' name='$column' value='" . $rekord[$column] . "'></td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                    <br>
                    <button type="submit">Zapisz zmiany</button>
                </form>
                <form action="StronaGlowna.php" method="post">
                    <button type="submit">Powrót do strony głównej</button> 
                </form>
                <form action="logout.php" method="post">
                    <button type="submit">Wyloguj się</button> 
                </form> 
            </body>
            </html>
            <?php
        } else {
            echo "Błąd podczas pobierania informacji o kolumnach.";
        }
    } else {
        echo "Nie znaleziono rekordu do edycji.";
    }
} else {
    echo "Brak danych do edycji.";
}

?>
