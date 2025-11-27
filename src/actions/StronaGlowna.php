<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Nawigacyjny</title>
    <link rel="stylesheet" type="text/css" href="../../public/style.css">
    <?php
        session_start();
        require_once __DIR__ .'/../database/bazaDanych.php';
        $db = new bazaDanych('localhost', 'SMZ', 'haslo123', 'smz_baza_danych');
        $rolaUzytkownika = $_SESSION['user_role'];
    ?>
</head>
<body>
    <h1>SZZ</h1>
    <ul>
        <li>Pracownicy</li>
        <?php if ($rolaUzytkownika === '1' || $rolaUzytkownika==='3'): ?>
            <label>Dodawanie nowego pracownika</label><br>
            <form action="dodajPracownika.php" method="post">
                <label for="imie">Imię:</label>
                <input type="text" name="imie" required><br>
                <label for="nazwisko">Nazwisko:</label>
                <input type="text" name="nazwisko" required><br>
                <label for="email">Email:</label>
                <input type="email" name="email" required><br>
                <label for="haslo">Hasło:</label>
                <input type="password" name="haslo" required><br>
                <label for="rola">Rola:</label>
                <select name="rola" required>
                <?php
                    require_once __DIR__ . '/../classes/Pracownik.php';
                    $dostepneRole = Pracownik::pobierzRoleZBazy($db);
                    if ($dostepneRole) {
                        foreach ($dostepneRole as $id => $nazwaRoli) {
                            echo "<option value=\"$id\">$nazwaRoli</option>";
                        }
                    }
                ?>
                </select><br><br>
                <button type="submit">Dodaj pracownika</button>
            </form><br>
            <?php endif; ?>
            <label>Wyświetlanie wszystkich pracowników</label>
            <form action="wyszukajPracownika.php" method="post"><br>
                <button type="submit">Wyświetl wszystkich pracowników</button>
            </form><br>
            <label>Wyszukaj pracownika</label>
            <form action="wyszukajPracownika.php" method="post">
                <label for="imie">Imię:</label>
                <input type="text" name="imie" required><br>
                <label for="nazwisko">Nazwisko:</label>
                <input type="text" name="nazwisko" required><br><br>
                <button type="submit">Szukaj Pracownika</button>
            </form><br>
        <li>Projekty</li>
        <?php if ($rolaUzytkownika === '1' || $rolaUzytkownika==='3'): ?>
            <label>Dodawanie nowego projektu</label><br>
            <form action="dodajProjekt.php" method="post">
                <label for="nazwa">Nazwa Projektu:</label>
                <input type="text" name="nazwa" required><br>
                <label for="dataRoz">Data rozpoczęcia:</label>
                <input type="date" name="dataRoz" required><br>
                <label for="dataZak">Data zakończenia:</label>
                <input type="date" name="dataZak" required><br>
                <label for="kierownik">Kierownik:</label>
                <select name="kierownik" required>
                <?php
                require_once __DIR__ . '/../classes/Pracownik.php';
                $dostepniKierownicy = Pracownik::pobierzKierownikowZBazy($db);
                if ($dostepniKierownicy) {
                    foreach ($dostepniKierownicy as $kierownik) {
                        echo "<option value=\"{$kierownik['pracownik_id']}\">{$kierownik['imie']} {$kierownik['nazwisko']}</option>";
                    }
                }
                ?>
                </select><br><br>
                <button type="submit">Dodaj Projekt</button>
            </form><br>
            <?php endif; ?>
            <label>Wyświetlanie wszystkich projektów</label>
            <form action="wyszukajProjekt.php" method="post">
                <button type="submit">Wyświetl wszystkie projekty</button>
            </form><br>
            <label>Wyszukaj projekt</label>
            <form action="wyszukajProjekt.php" method="post">
                <label for="nazwa">Nazwa projektu:</label>
                <input type="text" name="nazwa" required><br><br>
                <button type="submit">Szukaj projektu</button>
            </form><br>
        <li>Zadania</li>
        <?php if ($rolaUzytkownika === '1' || $rolaUzytkownika==='3'): ?>
        <label>Dodawanie nowego zadania</label><br>
            <form action="dodajZadanie.php" method="post">
                <label for="nazwa">Nazwa Zadania:</label>
                <input type="text" name="nazwa" required><br>
                <label for="opis">Opis:</label>
                <input type="text" name="opis" required><br>
                <label for="status">Status:</label>
                <select name="status" required>
                <?php
                require_once __DIR__ . '/../classes/Zadanie.php';
                $dostepneStatusy = Zadanie::pobierzDostepneStatusy($db);
                if ($dostepneStatusy) {
                    foreach ($dostepneStatusy as $status) {
                        echo "<option value=\"$status\">$status</option>";
                    }
                }
                ?>
                </select><br>
                <label for="id_projektu">Projekt:</label>
                <select name="id_projektu" required>
                <?php
                require_once __DIR__ . '/../classes/Projekt.php';
                $dostepneProjekty = Projekt::pobierzProjektyZBazy($db);
                if ($dostepneProjekty) {
                    foreach ($dostepneProjekty as $projekt) {
                        echo "<option value=\"{$projekt['projekt_id']}\">{$projekt['nazwa_projektu']}</option>";
                    }
                }
                ?>
                </select><br>
                <label for="id_pracownika">Pracownik:</label>
                <select name="id_pracownika" required>
                <?php
                require_once __DIR__ . '/../classes/Pracownik.php';
                $dostepniPracownicy = Pracownik::pobierzPracownikowZBazy($db);
                if ($dostepniPracownicy) {
                    foreach ($dostepniPracownicy as $pracownik) {
                        echo "<option value=\"{$pracownik['pracownik_id']}\">{$pracownik['imie']} {$pracownik['nazwisko']}</option>";
                    }
                }
                ?>
                </select><br><br>
                <button type="submit">Dodaj Zadanie</button>
            </form><br>
            <?php endif; ?>
                <label>Wyświetlanie wszystkich zadań</label>
                <form action="wyszukajZadanie.php" method="post">
                <button type="submit">Wyświetl wszystkie zadania</button>
            </form><br>
            <label>Wyszukaj zadanie</label>
            <form action="wyszukajZadanie.php" method="post">
                <label for="nazwa">Nazwa zadania:</label>
                <input type="text" name="nazwa" required><br><br>
                <button type="submit">Szukaj zadanie</button>
            </form>
    </ul>
    <form action="logout.php" method="post">
        <button type="submit">Wyloguj się</button>
    </form>
</body>
</html>
