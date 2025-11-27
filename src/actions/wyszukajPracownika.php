<?php
session_start();
require_once __DIR__ . '/../classes/Pracownik.php';
require_once __DIR__ . '/../database/bazaDanych.php';
require_once __DIR__ . '/../actions/wynik.php';

$db = new bazaDanych('localhost', 'SMZ', 'haslo123', 'smz_baza_danych');

$imie = isset($_POST['imie']) ? $_POST['imie'] : null;
$nazwisko = isset($_POST['nazwisko']) ? $_POST['nazwisko'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$haslo = isset($_POST['haslo']) ? $_POST['haslo'] : null;
$rola = isset($_POST['rola']) ? $_POST['rola'] : null;

$nowyPracownik = new Pracownik($imie, $nazwisko, $email, $haslo, $rola);
$wyniki = $nowyPracownik->pobierzZBazy($db, $imie, $nazwisko);

//$htmlTabela = generujTabele($wyniki, 'Pracownik');
$_SESSION['wyniki'] = $wyniki;
$_SESSION['klasa'] = "pracownicy";
header('Location: wynik.php?wyniki=true');

exit();
?>
