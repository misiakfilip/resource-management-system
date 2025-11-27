<?php
session_start();
require_once __DIR__ . '/../classes/Zadanie.php';
require_once __DIR__ . '/../database/bazaDanych.php';
require_once __DIR__ . '/../actions/wynik.php';

$db = new bazaDanych('localhost', 'SMZ', 'haslo123', 'smz_baza_danych');

$nazwaZadania = isset($_POST['nazwa']) ? $_POST['nazwa'] : null;
$opis = isset($_POST['opis']) ? $_POST['opis'] : null;
$status = isset($_POST['status']) ? $_POST['status'] : null;
$projekt_id = isset($_POST['id_projektu']) ? $_POST['id_projektu'] : null;
$pracownik_id= isset($_POST['id_pracownika']) ? $_POST['id_pracownika'] : null;

$noweZadanie = new Zadanie($nazwaZadania,$opis,$status,$projekt_id,$pracownik_id);
$wyniki = $noweZadanie->pobierzZBazy($db, $nazwaZadania);

$htmlTabela = generujTabele($wyniki, 'Zadanie');
$_SESSION['wyniki'] = $wyniki;
$_SESSION['klasa'] = "zadania";
header('Location: wynik.php?wyniki=true');

exit();
?>
