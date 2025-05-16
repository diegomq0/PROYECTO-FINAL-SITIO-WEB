<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $password = $_POST['pass'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $conn = mysqli_connect("localhost", "root", "", "veterinaria");

    if (!$conn) {
        die("Error en la conexión: " . mysqli_connect_error());
    }

    // Verificar si el correo ya está registrado
    $check = mysqli_prepare($conn, "SELECT IDCliente FROM RegistroCliente WHERE email = ?");
    mysqli_stmt_bind_param($check, "s", $email);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if (mysqli_stmt_num_rows($check) > 0) {
        header("Location: registroCliente.html?error=correo");
        exit;
    }

    // Insertar nuevo cliente
    $stmt = mysqli_prepare($conn, "INSERT INTO RegistroCliente (nombreCliente, apellido, telefono, email, pass) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssss", $nombre, $apellido, $telefono, $email, $hashed_password);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: loginCliente.html?registro=exito");
    } else {
        echo "Error al registrar: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
