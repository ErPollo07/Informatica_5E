<?php
$conn = include 'connection.php';

session_start();

// Verify if the user is logged in
if (isset($_SESSION['id']) && isset($_SESSION['username']) && isset($_SESSION["role"])) {
    // TODO create a user obj to store all his variables
    $id = $_SESSION['id'];
    $username = $_SESSION['username'];
    $role = $_SESSION["role"];
} else {
    // redirect to login page
    header("Location: login.php");
    die();
}

// Check if there are some action to do else load the page normally
if (isset($_POST['action'])) {
    $action = $_POST["action"];

    echo "action = " . $action;

    if ($action == "creation" && isset($_POST["marca"]) && isset($_POST["modello"]) && isset($_POST["cilindrata"])) {
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

        header("Location: " . $_SERVER["PHP_SELF"]);
        die();
    }
    else if ($action == "save_modify" && isset($_POST["auto_id"]) && isset($_POST["marca"]) && isset($_POST["modello"]) && isset($_POST["cilindrata"])) {
        $auto_id = filter_var($_POST["auto_id"]);
        $marca = filter_var($_POST["marca"]);
        $modello = filter_var($_POST["modello"]);
        $cilindrata = filter_var($_POST["cilindrata"]);

        echo "marca: " . $marca . "\n";
        echo "modello: " . $modello . "\n";
        echo "cilindrata: " . $cilindrata . "\n";
        echo "id: " . $auto_id . "\n";
        echo "username: " . $username;

        $stmt = $conn->prepare("UPDATE `auto` SET `marca`=:marca, `modello`=:modello, `cilindrata`=:cilindrata WHERE `id`=:auto_id AND `username`=:username");
        $stmt->bindParam(":marca", $marca);
        $stmt->bindParam(":modello", $modello);
        $stmt->bindParam(":cilindrata", $cilindrata);
        $stmt->bindParam(":auto_id", $auto_id);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        // Reload the page
        header("Refresh: 5; url=home.php");
        die();
    }
    else if ($action == "delete" && isset($_POST["auto_id"])) {
        $auto_id = filter_var($_POST["auto_id"]);

        $stmt = $conn->prepare("DELETE FROM `auto` WHERE id = :auto_id AND username = :username");
        $stmt->bindParam(":auto_id", $auto_id);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        header("Location: home.php");
        die();
    }
}

// get the user auto
$stmt = $conn->prepare("SELECT `id`, `marca`, `modello`, `cilindrata`, `username` FROM `auto` WHERE username=:username");
$stmt->bindParam(":username", $username);
$stmt->execute();
$autos = $stmt->fetchAll();
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
<style>
    .icon-btn {
        border: none;
    }
</style>
<div class="container text-center">
    <h1>Welcome <?= $username ?></h1>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                <input type="hidden" name="action" value="creation">
                <input type="text" name="marca" placeholder="Marca" required>
                <input type="text" name="modello" placeholder="Modello" required>
                <input type="text" name="cilindrata" placeholder="Cilindrata" required>
                <button type="submit">Submit</button>
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
                        <?php if ($role == "admin") { ?>
                            <td>
                                <form action="modify.php" method="post">
                                    <input type="hidden" name="action" value="modify"><!-- use for redirection on the same page-->
                                    <input type="hidden" name="auto_id" value="<?= $auto['id'] ?>">
                                    <button type="submit" class="icon-btn">
                                        <img src="./assets/edit_icon.svg" alt="Edit">
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="auto_id" value="<?= $auto['id'] ?>">
                                    <button type="submit" class="icon-btn">
                                        <img src="./assets/delete_icon.svg" alt="Delete">
                                    </button>
                                </form>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <button>
                <a href="logout.php">Logout</a>
            </button>
        </div>
        <div class="col-2"></div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>
</html>