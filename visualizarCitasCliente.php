<?php
session_start();

// Verificar que el cliente haya iniciado sesión
if (!isset($_SESSION['IDCliente'])) {
    echo "<p>No has iniciado sesión.</p>";
    exit;
}

$idCliente = $_SESSION['IDCliente'];

// Conexión a la base de datos
$servidor = "localhost";      
$usuario = "root";
$clave = "";
$baseDeDatos = "veterinaria";

$enlace = mysqli_connect($servidor, $usuario, $clave, $baseDeDatos);
if (!$enlace) {
    echo "Error en la conexión con el servidor";
    exit;
}

// Consulta para obtener las citas del cliente logueado
$consulta = "SELECT citas.IDCita, citas.mascota, citas.razonCita, citas.fecha, citas.hora,
    cliente.IDCliente, cliente.nombreCliente, cliente.apellido, cliente.telefono 
    FROM citas
    INNER JOIN cliente ON cliente.IDCliente = citas.IDCliente 
    WHERE cliente.IDCliente = $idCliente 
    ORDER BY citas.fecha DESC";

$ejecutarConsulta = mysqli_query($enlace, $consulta);

if (!$ejecutarConsulta) {
    echo "<p>Error al mostrar las citas.</p>";
    exit;
}

// Mostrar citas
if (mysqli_num_rows($ejecutarConsulta) > 0) {
    $num = 0;
    while ($recuperar = mysqli_fetch_array($ejecutarConsulta)) {
        $num++;
        echo '<div class="appointment" style="border: 1px solid #ddd;text-align: center;">
            <h3 style="text-align: center;">Cita #' . $num . '</h3>
            <div style="width: 50%;float: left;text-align: left;">
                <p><strong>Nombre:</strong> ' . $recuperar['nombreCliente'] . '</p>
                <p><strong>Tipo de Mascota:</strong> ' . $recuperar['mascota'] . '</p>
                <p><strong>Fecha:</strong> ' . $recuperar['fecha'] . '</p><br>
            </div>
            <div style="width: 50%;float: left;text-align: left;padding-left: 10%;">
                <p><strong>Apellido:</strong> ' . $recuperar['apellido'] . '</p>
                <p><strong>Razón de la cita:</strong> ' . $recuperar['razonCita'] . '</p>
                <p><strong>Hora:</strong> ' . $recuperar['hora'] . ' AM</p><br>
            </div>
            <button style="border: 2px solid #d99595; color: #d99595; background-color: #f9f9f9;" 
                onclick="borrar(' . $recuperar['IDCita'] . ')">Borrar</button><br>
        </div>';
    }
} else {
    echo "<p>No hay citas registradas para este cliente.</p>";
}
?>
