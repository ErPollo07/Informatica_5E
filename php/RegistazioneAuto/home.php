<?php
$conn = include 'connection.php';

session_start();

// get the username and password

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $id = $_SESSION['id'];
    $username = $_SESSION['username'];
} else {
    // redirect to login page
    header("Location: login.php");
    die();
}

// get the user auto
$autos = $conn->query("SELECT * FROM auto WHERE username='$username'")->fetchAll();
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
    <br>
    <button>
        <a href="creation.php">Add a new entry</a>
    </button>
    <br><br>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
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
        <div class="col-3"></div>


    </div>


</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>
</html>