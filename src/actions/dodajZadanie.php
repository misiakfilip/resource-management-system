<?php

require_once __DIR__ . '/../classes/Zadanie.php';
require_once __DIR__ . '/../database/bazaDanych.php';

$db = new bazaDanych('localhost', 'SMZ', 'haslo123', 'smz_baza_danych');

$nazwa = $_POST['nazwa'];
$opis = $_POST['opis'];
$status = $_POST['status'];
$id_projektu = $_POST['id_projektu'];
$id_pracownika = $_POST['id_pracownika'];

$noweZadanie = new Zadanie($nazwa, $opis, $status, $id_projektu, $id_pracownika);
$noweZadanie->dodajDoBazy($db);

header('Location: StronaGlowna.php');
exit();

?>