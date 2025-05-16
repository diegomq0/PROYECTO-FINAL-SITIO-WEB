<?php
session_start();

if (isset($_POST['entrar'])) {
    $email = $_POST['email'];
    $password = $_POST['pass'];

    $enlace = mysqli_connect("localhost", "root", "", "veterinaria");
    if (!$enlace) {
        die("Error en la conexión.");
    }

    // Asegúrate de que la tabla se llame RegistroCliente y tenga email y pass
    $stmt = mysqli_prepare($enlace, "SELECT IDCliente, pass FROM RegistroCliente WHERE email = ?");
    if (!$stmt) {
        die("Error en la consulta: " . mysqli_error($enlace));
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $idCliente, $hash);

    if (mysqli_stmt_fetch($stmt)) {
        if (password_verify($password, $hash)) {
            $_SESSION['IDCliente'] = $idCliente;
            header("Location: citas.php");
            exit;
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($enlace);

    header("Location: loginCliente.html?error=1");
    exit;
}
?>
