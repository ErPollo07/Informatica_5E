<?php
$host = "localhost";
$dbname = "user_auto";
$username = "user";
$password = "user";



try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Errore: " . $e->getMessage());
}

return $conn;
?>