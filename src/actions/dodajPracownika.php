<?php

// Załadowanie klasy pracownik i klasy bazaDanych
require_once __DIR__ . '/../classes/Pracownik.php';
require_once __DIR__ . '/../database/bazaDanych.php';

// Utwórz obiekt bazy danych
$db = new bazaDanych('localhost', 'SMZ', 'haslo123', 'smz_baza_danych');

// Przypisanie danych z formularza do zmiennych
$imie = $_POST['imie'];
$nazwisko = $_POST['nazwisko'];
$email = $_POST['email'];
$haslo = $_POST['haslo'];
$id_rola = $_POST['rola'];

// Utwórzenie obiektu pracownika i dodanie do bazy danych
$nowyPracownik = new Pracownik($imie, $nazwisko, $email, $haslo, $id_rola);
$nowyPracownik->dodajDoBazy($db);

// Przekierowanie użytkownika na odpowiednią stronę
header('Location: StronaGlowna.php');
exit();

?>
