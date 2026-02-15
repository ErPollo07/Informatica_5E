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

    echo "Connessione riuscita\n";
} catch (PDOException $e) {
    die("Errore: " . $e->getMessage());
}

//$conn->query("INSERT INTO `auto` (`id`, `marca`, `modello`, `cilindrata`) VALUES (NULL, 'marca', 'modello', '4000');");

$ret = $conn->query("SELECT * FROM auto");

$arr = $ret->fetchAll();

for ($i = 0; $i < count($arr); $i++) {
    echo "Row $i\n";
    echo "\tID:         " . $arr[$i]["id"] . "\n";
    echo "\tMARCA:      " . $arr[$i]["marca"] . "\n";
    echo "\tMODELLO:    " . $arr[$i]["modello"] . "\n";
    echo "\tCILINDRATA: " . $arr[$i]["cilindrata"] . "\n";
}

$conn = null;