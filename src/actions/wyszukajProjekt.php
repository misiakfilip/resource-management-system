<?php
session_start();
require_once __DIR__ . '/../classes/Projekt.php';
require_once __DIR__ . '/../database/bazaDanych.php';
require_once __DIR__ . '/../actions/wynik.php';

$db = new bazaDanych('localhost', 'SMZ', 'haslo123', 'smz_baza_danych');

$nazwaProjektu = isset($_POST['nazwa']) ? $_POST['nazwa'] : null;
$dataRozpoczecia = isset($_POST['dataRoz']) ? $_POST['dataRoz'] : null;
$dataZakonczenia = isset($_POST['dataZak']) ? $_POST['dataZak'] : null;
$kierownikId = isset($_POST['kierownik']) ? $_POST['kierownik'] : null;

$nowyProjekt = new Projekt($nazwaProjektu, $dataRozpoczecia, $dataZakonczenia, $kierownikId);
$wyniki = $nowyProjekt->pobierzZBazy($db);

$htmlTabela = generujTabele($wyniki, 'Projekt');
$_SESSION['wyniki'] = $wyniki;
$_SESSION['klasa'] = "projekty";
header('Location: wynik.php?wyniki=true');

exit();
?>
