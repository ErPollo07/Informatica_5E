<?php
$conn = include "connection.php";
include "util.php";

session_start();

$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $username = filter_var($_POST['username']);
    $password = filter_var($_POST['password']);

    echo "username: ". $username . "\n";
    echo "Password: ".  $password . "\n";

    // Prepare the sql string
    $stmt = $conn->prepare("SELECT id, username, password, role FROM utenti WHERE username = :username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    // Get only one row from the result
    $user = $stmt->fetch();

    // Check if the password is correct (use password_verify() if the password is hashed)
    if ($user && $password == $user['password']) {
        // Put in the session variable the id and username of the user
        $_SESSION["id"] = $user['id'];
        $_SESSION["username"] = $user['username'];
        $_SESSION["role"] = $user["role"];

        header("Location: home.php");
        exit;
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
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<h1>Login</h1>
<form method="post">
    <input type="text" name="username" placeholder="Username">
    <input type="text" name="password" placeholder="Password">
    <button type="submit">Submit</button>
    <?php if ($error) { ?>
        <p><?=$error?></p>
    <?php } ?>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>
</html>