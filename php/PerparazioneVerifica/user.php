<?php
// Pagina utente per vedere le prenotazioni o eliminarle
session_start();
include "Acquisto.php";
$conn = include "connection.php";

if (isset($_SESSION["userId"]) && isset($_SESSION["username"]) && isset($_SESSION["role"])) {
    if ($_SESSION["role"] != "user") {
        header("Location: " . ($_SESSION["role"] == "admin" ? "admin.php" : "login.php"));
    }

    $userId = $_SESSION["userId"];
    $username = $_SESSION["username"];

    $stmt = $conn->prepare("SELECT id, personaId, quantitaTeli, dataInizio, dataFine, prezzo FROM acquisto WHERE personaId=:personaId");
    $stmt->bindParam(":personaId", $userId);
    $stmt->execute();
    $acquisti_stmt = $stmt->fetchAll();

    $acquisti = array();

    foreach ($acquisti_stmt as $key => $value) {
        $a = new Acquisto($value["id"], $value["personaId"], $value["dataInizio"], $value["dataFine"], $value["quantitaTeli"], $value["prezzo"], array(), array());

        $stmt = $conn->prepare("SELECT id, lettinoId, acquistoId FROM acquisto_lettino WHERE acquistoId=:acquistoId");
        $stmt->bindParam(":acquistoId", $a->getId());
        $stmt->execute();
        $acquisto_lettini_stmt = $stmt->fetchAll();

        print_r($acquisto_lettini_stmt);

        $stmt = $conn->prepare("SELECT id, ombrelloneId, acquistoId FROM acquisto_ombrellone WHERE acquistoId=:acquistoId");
        $stmt->bindParam(":acquistoId", $a->getId());
        $stmt->execute();
        $acquisto_ombrelloni_stmt = $stmt->fetchAll();

        print_r($acquisto_ombrelloni_stmt);

        $acquisti[$key] = $a;
    }



//    $stmt = $conn->prepare("SELECT id, personaId, quantitaTeli, dataInizio, dataFine, prezzo FROM acquisto WHERE personaId=:personaId");
//    $stmt->bindParam(":personaId", $userId);
//    $stmt->execute();
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<h1>Hello, user</h1>

<div class="container">
    <div class="row"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>