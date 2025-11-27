<?php
session_start();
require_once __DIR__ . '/../database/bazaDanych.php';
require_once __DIR__ . '/../classes/wynik.php';

$db = new bazaDanych('localhost', 'SMZ', 'haslo123', 'smz_baza_danych');

$id = isset($_POST['idRekordu']) ? $_POST['idRekordu'] : null;
$klasa = isset($_SESSION['klasa']) ? $_SESSION['klasa'] : [];

$query = "DELETE FROM $klasa WHERE ID = $id";
$result = $db->execute($query);
if($klasa=='pracownicy'){
    header('Location: wyszukajPracownika.php');
}
elseif($klasa=='projekty'){
    header('Location: wyszukajProjekt.php'); 
}
elseif($klasa=='zadania'){
    header('Location: wyszukajZadanie.php'); 
}
exit();
?>
