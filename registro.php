<?php
if (isset($_POST['registrar'])) {
    $email = $_POST['email'];
    $password = $_POST['pass'];

    echo "Datos recibidos:<br>";
    echo "Email: $email<br>";
    echo "Password: $password<br>";

    // Conexión a la base de datos
    $servidor = "localhost";
    $usuario = "root";
    $clave = "";
    $baseDeDatos = "veterinaria";

    $enlace = mysqli_connect($servidor, $usuario, $clave, $baseDeDatos);

    if (!$enlace) {
        die("❌ Error en la conexión con el servidor: " . mysqli_connect_error());
    } else {
        echo "✅ Conexión exitosa<br>";
    }

    // Verificar si el usuario ya existe
    $verificar = mysqli_prepare($enlace, "SELECT id FROM administrador WHERE email = ?");
    mysqli_stmt_bind_param($verificar, "s", $email);
    mysqli_stmt_execute($verificar);
    mysqli_stmt_store_result($verificar);

    if (mysqli_stmt_num_rows($verificar) > 0) {
        echo "⚠️ El correo ya está registrado<br>";
        mysqli_stmt_close($verificar);
        mysqli_close($enlace);
        exit;
    }
    mysqli_stmt_close($verificar);
    echo "🟢 El correo no está registrado, procediendo al registro<br>";

    // Encriptar la contraseña
    $hash = password_hash($password, PASSWORD_DEFAULT);
    echo "Contraseña encriptada: $hash<br>";

    // Insertar nuevo usuario
    $insertar = mysqli_prepare($enlace, "INSERT INTO administrador (email, pass) VALUES (?, ?)");
    mysqli_stmt_bind_param($insertar, "ss", $email, $hash);

    if (mysqli_stmt_execute($insertar)) {
        echo "✅ Usuario registrado correctamente<br>";
        // header("Location: iniciarSesion.html");
    } else {
        echo "❌ Error al insertar: " . mysqli_error($enlace) . "<br>";
    }

    mysqli_stmt_close($insertar);
    mysqli_close($enlace);
} else {
    echo "⛔ No se recibió el formulario<br>";
}
?>
