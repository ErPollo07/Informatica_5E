<?php
session_start();
$conn = include "connection.php";

$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_var($_POST["username"], FILTER_DEFAULT);
    $password = filter_var($_POST["password"], FILTER_DEFAULT);

    $stmt = $conn->prepare("SELECT id, nome, cognome, username, password, role FROM persona WHERE username=:username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["userId"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["role"] = $user["role"];

        if ($user['role'] == "admin") header("Location: admin.php");
        elseif ($user['role'] == "user") header("Location: user.php");

        die();
    } else {
        $error = "Username or password incorrect";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<style>
    .error-message {
        color: red;
    }
</style>
<div class="container">
    <h1>Login</h1>
    <div class="col">
        <form method="post">
            <input type="text" name="username" required>
            <input type="text" name="password" required>
            <button type="submit">Login</button>
        </form>
        <?php if ($error != null) : ?>
            <p class="error-message"><?= $error ?></p>
        <?php endif; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>
</html>