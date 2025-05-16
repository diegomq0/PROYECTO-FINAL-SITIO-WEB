<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];

    $servidor = "localhost";
    $usuario = "root";
    $clave = "";
    $baseDeDatos = "user";

    $enlace = mysqli_connect($servidor, $usuario, $clave, $baseDeDatos);

    if (!$enlace) {
        die("Error al conectar con la base de datos.");
    }

    $hash = password_hash($pass, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($enlace, "INSERT INTO administrador (correo, clave) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $email, $hash);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Administrador registrado con éxito.";
    } else {
        echo "Error al registrar administrador.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($enlace);
}
?>

<!-- Formulario HTML -->
<form action="registrar_admin.php" method="POST">
    <label for="correo">Correo:</label>
    <input type="correo" name="correo" required><br>

    <label for="clave">Contraseña:</label>
    <input type="clave" name="clave" required><br>

    <button type="submit">Registrar Admin</button>
</form>
