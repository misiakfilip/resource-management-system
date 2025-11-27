<?php

require_once __DIR__ . '/../classes/Projekt.php';
require_once __DIR__ . '/../database/bazaDanych.php';

$db = new bazaDanych('localhost', 'SMZ', 'haslo123', 'smz_baza_danych');

$nazwaProjektu= $_POST['nazwa'];
$dataRozpoczecia = $_POST['dataRoz'];
$dataZakonczenia = $_POST['dataZak'];
$kierownikId = $_POST['kierownik'];

$nowyProjekt = new Projekt($nazwaProjektu, $dataRozpoczecia, $dataZakonczenia, $kierownikId);
$nowyProjekt->dodajDoBazy($db);

header('Location: StronaGlowna.php');
exit();

?>
