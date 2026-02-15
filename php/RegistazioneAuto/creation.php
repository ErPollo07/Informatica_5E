<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $id = $_SESSION['id'];
    $username = $_SESSION['username'];
} else {
    // redirect to login page
    header("Location: login.php");
    die();
}

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

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $marca = $_POST["marca"];
    $modello = $_POST["modello"];
    $cilindrata = $_POST["cilindrata"];

    if ($marca && $modello && $cilindrata) {
        $query = $conn->prepare("INSERT INTO `auto` (`id`, `marca`, `modello`, `cilindrata`, `username`) VALUES (NULL, :marca, :modello, :cilindrata, :username);");
        $query->execute(["marca" => $marca, "modello" => $modello, "cilindrata" => $cilindrata, "username" => $_SESSION["username"]]);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Template</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<h1>Add a new entry</h1>

<form method="post">
    <input type="text" name="marca" placeholder="Marca">
    <input type="text" name="modello" placeholder="Modello">
    <input type="text" name="cilindrata" placeholder="Cilindrata">
    <button type="submit">Submit</button>
</form>

<a href="home.php">Back to home page</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>
</html>
