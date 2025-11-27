<?php
    require_once __DIR__ . '/../../vendor/autoload.php';
    require_once __DIR__ . '/../database/bazaDanych.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    function generujTabele($wyniki) {
    if (empty($wyniki) || !is_array($wyniki)) {
        return "Brak wyników do wyświetlenia.";
    }
    $db = new bazaDanych('localhost', 'SMZ', 'haslo123', 'smz_baza_danych');
    $rolaUzytkownika = $_SESSION['user_role'];

    // Pobieranie nagłówków z pierwszego rekordu
    $naglowki = array_keys($wyniki[0]);
    // Rozpocznij budowanie tabeli
    $html = "<table border='1'>";
    
    // Dodanie nagłówków tabeli
    $html .= "<tr>";
    foreach ($naglowki as $naglowek) {
        $html .= "<th>$naglowek</th>";
    }
    if ($rolaUzytkownika === '1' || $rolaUzytkownika==='3'){$html .= "<th>Usuń</th> <th>Edytuj</th>";}
    $html .= "</tr>";

    // Dodanie danych do tabeli
    foreach ($wyniki as $rekord) {
        $html .= "<tr>";
        foreach ($rekord as $wartosc) {
            $html .= "<td>$wartosc</td>";
        }
        if ($rolaUzytkownika === '1' || $rolaUzytkownika==='3'){
            $idRekordu = $rekord['ID'];
            $html .= "<td>
            <form action='usun.php' method='post'>
                <input type='hidden' name='idRekordu' value='$idRekordu'>
                <button type='submit'>Usun rekord</button>
            </form>
            </td>
            <td>
            <form action='edytuj.php' method='post'>
                <input type='hidden' name='idRekordu' value='$idRekordu'>
                <button type='submit'>Edytuj Rekord</button>
            </form>
            </td>";
        }
        $html .= "</tr>";
    }

    // Zakończ tabelę
    $html .= "</table>";

    return $html;
    }

    $wyniki = isset($_SESSION['wyniki']) ? $_SESSION['wyniki'] : [];
    $klasa = isset($_SESSION['klasa']) ? $_SESSION['klasa'] : [];
    $htmlTabela = generujTabele($wyniki);

    if (isset($_POST['generujPDF'])) {
        $dompdf = new Dompdf\Dompdf();
        $dompdf->loadHtml($htmlTabela);

    // Renderuj PDF
        $dompdf->render();

    // Wygeneruj PDF w odpowiedzi HTTP
        $dompdf->stream();
    }
    if (isset($_POST['eksportJSON'])) {
        // Obsługa eksportu do pliku JSON
        $json_data = json_encode($wyniki, JSON_PRETTY_PRINT);
    
        // Zapis danych do pliku
        $file_path = 'wyniki.json';
        file_put_contents($file_path, $json_data);
    
        // Poinformuj użytkownika o zakończeniu eksportu
        echo "Dane zostały pomyślnie zapisane do pliku JSON: <a href='$file_path' target='_blank'>$file_path</a>";
    }
    //exit();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wyniki</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Wyniki wyszukiwania</h1>
    <?php 
        echo $htmlTabela;
    ?>
    <form action="" method="post">
        <button type="submit" name="generujPDF">Generuj PDF</button>
    </form>
    <form action="StronaGlowna.php" method="post">
        <button type="submit">Powrót do strony głównej</button> 
    </form>
    <form action="" method="post">
        <button type="submit" name="eksportJSON">Eksport do JSON</button>
    </form>
    <form action="logout.php" method="post">
        <button type="submit">Wyloguj się</button> 
    </form>        
</body>
</html>