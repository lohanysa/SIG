<?php
require 'DB_Puerto.php';

$URL = isset($_POST['image-url']) ? trim($_POST['image-url']) : null;
$Name = isset($_POST['Name']) ? trim($_POST['Name']) : null;
$Cost = isset($_POST['Priece']) ? trim($_POST['Priece']) : null;
$Detalle = isset($_POST['Descripcion']) ? trim($_POST['Descripcion']) : null;
$Stock = isset($_POST['Cantidad']) ? trim($_POST['Cantidad']) : null;
$idAmigurumis = isset($_POST['Id']) ? trim($_POST['Id']) : null;
$action = isset($_POST['action']) ? $_POST['action'] : null;

function generateProductId($prefix = 'MU', $length = 4) {
    $number = rand(0, 9999);
    $formattedNumber = str_pad($number, $length, '0', STR_PAD_LEFT);
    return $prefix . $formattedNumber;
}

$productId = $idAmigurumis ?: generateProductId();

try {
    if ($action == 'Delete') {
        
        // Eliminar un producto existente
        $sql = "DELETE FROM Inventario_de_amigurumis WHERE id_amigurumis = '$idAmigurumis'";

        // Ejecutar la consulta
        if ($conn->exec($sql)) {
            echo json_encode(array('success' => 'El producto fue eliminado con éxito.'));
        } else {
            echo json_encode(array('error' => 'Error al eliminar el producto.'.$idAmigurumis));
        }
    } else if ($idAmigurumis) {
        // Actualizar un producto existente
        $sql = "UPDATE Inventario_de_amigurumis SET 
                    cantidad_disponible = :cantidad_disponible,
                    precio = :precio,
                    descripcion = :descripcion,
                    nombre = :Nombre,
                    direccion_url = :link
                WHERE id_amigurumis = :id_amigurumis";

        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Vincular los parámetros
        $stmt->bindParam(':id_amigurumis', $idAmigurumis);
        $stmt->bindParam(':cantidad_disponible', $Stock);
        $stmt->bindParam(':precio', $Cost);
        $stmt->bindParam(':descripcion', $Detalle);
        $stmt->bindParam(':Nombre', $Name);
        $stmt->bindParam(':link', $URL);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo json_encode(array('success' => 'El producto fue actualizado con éxito.'));
        } else {
            echo json_encode(array('error' => 'Error al actualizar los datos.'));
        }
    } else {
        // Insertar un nuevo producto
        $sql = "INSERT INTO Inventario_de_amigurumis (`id_amigurumis`, `cantidad_disponible`, `precio`, `descripcion`, `nombre`, `direccion_url`) 
                VALUES (:id_amigurumis, :cantidad_disponible, :precio, :descripcion, :Nombre, :link)";

        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Vincular los parámetros
        $stmt->bindParam(':id_amigurumis', $productId);
        $stmt->bindParam(':cantidad_disponible', $Stock);
        $stmt->bindParam(':precio', $Cost);
        $stmt->bindParam(':descripcion', $Detalle);
        $stmt->bindParam(':Nombre', $Name);
        $stmt->bindParam(':link', $URL);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo json_encode(array('success' => 'La inserción fue grabada con éxito.'));
        } else {
            echo json_encode(array('error' => 'Error al insertar los datos.'));
        }
    }
} catch (PDOException $e) {
    echo json_encode(array('error' => 'Error al insertar los datos: ' . $e->getMessage()));
}
?>
