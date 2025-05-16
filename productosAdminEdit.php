<?php
$servidor = "localhost";
$usuario = "root";
$clave = "";
$baseDeDatos = "veterinaria";

$enlace = mysqli_connect($servidor, $usuario, $clave, $baseDeDatos);
if(!$enlace){
    die("Error en la conexión con el servidor");
}

if (!isset($_GET['IDProducto'])) {
    die("ID de producto no proporcionado.");
}

$idProducto = $_GET['IDProducto'] ?? null;

if (!$idProducto) {
    echo "ID de producto no proporcionado.";
    exit;
}

$idProducto = intval($_GET['IDProducto']);

$consulta = "SELECT * FROM productos WHERE IDProducto = $idProducto";
$resultado = mysqli_query($enlace, $consulta);

if (!$resultado || mysqli_num_rows($resultado) === 0) {
    die("Producto no encontrado.");
}

$producto = mysqli_fetch_assoc($resultado);

// Aquí puedes mostrar los datos para editar en un formulario
// Ejemplo:
?>
<form method="POST" action="actualizarProducto.php" enctype="multipart/form-data">
    <input type="hidden" name="IDProducto" value="<?= $producto['IDProducto'] ?>">
    <label>Nombre:</label>
    <input type="text" name="nombreProducto" value="<?= htmlspecialchars($producto['nombreProducto']) ?>"><br>
    <label>Detalles:</label>
    <textarea name="detalles"><?= htmlspecialchars($producto['detalles']) ?></textarea><br>
    <label>Categoría:</label>
    <input type="text" name="categoria" value="<?= htmlspecialchars($producto['categoria']) ?>"><br>
    <label>Imagen actual:</label>
    <img src="<?= $producto['imagen'] ?>" alt="Imagen del producto" style="width:100px;"><br>
    <label>Nueva imagen (opcional):</label>
    <input type="file" name="imagen"><br>
    <button type="submit">Actualizar</button>
</form>
<?php
mysqli_close($enlace);
?>
