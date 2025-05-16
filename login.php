<?php
session_start();

if (isset($_POST['entrar'])) {
    $email = $_POST['email'];
    $password = $_POST['pass'];

    $servidor = "localhost";
    $usuario = "root";
    $clave = "";
    $baseDeDatos = "veterinaria";

    $enlace = mysqli_connect($servidor, $usuario, $clave, $baseDeDatos);

    if (!$enlace) {
        die("Error en la conexión con el servidor");
    }

    // Preparamos la consulta de manera segura para evitar inyección SQL
    $stmt = mysqli_prepare($enlace, "SELECT pass FROM administrador WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $passwordexistente);

    if (mysqli_stmt_fetch($stmt)) {
        // Usuario encontrado, ahora verificamos la contraseña
        if (password_verify($password, $passwordexistente)) {
            // Contraseña válida
            $_SESSION['correo'] = $email; // Guardar usuario en sesión
            header("Location: AdminIndex.html");
            exit;
        } else {
            // Contraseña incorrecta
            $error_message = "Usuario o contraseña incorrectos.";
        }
    } else {
        // Usuario no encontrado
        $error_message = "Usuario o contraseña incorrectos.";
    }

    // Cierre de la conexión
    mysqli_stmt_close($stmt);
    mysqli_close($enlace);

    // Redirigir con error
    header("Location: iniciarSesion.html?error=" . urlencode($error_message));
    exit;
}
?>
