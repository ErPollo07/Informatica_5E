<?php
// modify.php page
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username']) && isset($_SESSION["role"])) {
    $user_id = $_SESSION['id'];
    $username = $_SESSION['username'];
    $role = $_SESSION["role"];
} else {
    // redirect to login page
    header("Location: login.php");
    die();
}

$id = $_POST["auto_id"];
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
<h1>Modify</h1>

<form action="home.php" method="post">
    <input type="hidden" name="action" value="save_modify">
    <input type="hidden" name="auto_id" value="<?=$id?>">
    <input type="text" name="marca" required>
    <input type="text" name="modello" required>
    <input type="text" name="cilindrata" required>
    <button type="submit">Salva</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>
