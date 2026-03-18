<?php
$conn = include 'connection.php';

session_start();

// Verify if the user is logged in
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $id = $_SESSION['id'];
    $username = $_SESSION['username'];
} else {
    // redirect to login page
    header("Location: login.php");
    die();
}

// Check if the user compiled the form to insert a new auto
if (isset($_POST['s']) && isset($_POST["marca"]) && isset($_POST["modello"]) && isset($_POST["cilindrata"])) {
    // Insert a new auto with the fields
    // First take the values and sanitize them
    $marca = filter_var($_POST["marca"]);
    $modello = filter_var($_POST["modello"]);
    $cilindrata = filter_var($_POST["cilindrata"]);

    $stmt = $conn->prepare("INSERT INTO `auto` (marca, modello, cilindrata, username) VALUES (:marca, :modello, :cilindrata, :username)");
    $stmt->bindParam(":marca", $marca);
    $stmt->bindParam(":modello", $modello);
    $stmt->bindParam(":cilindrata", $cilindrata);
    $stmt->bindParam(":username", $_SESSION["username"]);
    $stmt->execute();
}

// get the user auto
$autos = $conn->query("SELECT `id`, `marca`, `modello`, `cilindrata`, `username` FROM `auto` WHERE username='$username'")->fetchAll();
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
<div class="container text-center">
    <h1>Welcome <?= $username ?></h1>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <form action="<?=$_SERVER["PHP_SELF"]?>" method="post">
                <input type="text" name="marca" placeholder="Marca" required>
                <input type="text" name="modello" placeholder="Modello" required>
                <input type="text" name="cilindrata" placeholder="Cilindrata" required>
                <input type="submit" name="s" value="Invia">
            </form>
        </div>
        <div class="col-2"></div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">marca</th>
                        <th scope="col">modello</th>
                        <th scope="col">cilindrata</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($autos as $auto) { ?>
                    <tr>
                        <td scope="row"><?= $auto['id'] ?></td>
                        <td><?= $auto['marca'] ?></td>
                        <td><?= $auto['modello'] ?></td>
                        <td><?= $auto['cilindrata'] ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="col-2"></div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>
</html>