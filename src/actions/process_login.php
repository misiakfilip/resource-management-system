<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $haslo = $_POST['haslo'];

    $dbHost = 'localhost';
    $dbUser = 'SMZ';
    $dbPassword = 'haslo123';
    $dbName = 'smz_baza_danych';

    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn->connect_error);
    }

    $email = $conn->real_escape_string($email);

    $sql = "SELECT ID, email, haslo, id_rola FROM pracownicy WHERE email = '$email'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $haslo_hash = $row['haslo'];
        if (password_verify($haslo, $haslo_hash)) {

            $_SESSION['user_id'] = $row['ID'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_role'] = $row['id_rola'];

            header('Location: StronaGlowna.php');
            exit();
        } else {
            $_SESSION['error'] = 'Nieprawidłowy email lub hasło';
            header('Location: index.html');
            exit();
        }
    } else {
        $_SESSION['error'] = 'Nieprawidłowy email lub hasło';
        header('Location: index.html');
        exit();
    }
    $conn->close();
} else {
    header('Location: index.html');
    exit();
}
?>
