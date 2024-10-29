<?php
require("DB_Puerto.php");

// Verifica la conexión
if (!$conn) {
    echo json_encode(["ERROR" => "No hay conexión con la base de datos"]);
    exit;
} else {
    // peluches menos comprados
    $query = "SELECT 
                    inventario_de_amigurumis.nombre, 
                    inventario_de_amigurumis.precio,
                     inventario_de_amigurumis.direccion_url,
                    COUNT(pedido.fk_amigurumis) AS cantidad_transacciones
                FROM 
                    inventario_de_amigurumis
                JOIN 
                    pedido ON pedido.fk_amigurumis= inventario_de_amigurumis.id_amigurumis
                GROUP BY 
                     inventario_de_amigurumis.nombre, 
                    inventario_de_amigurumis.precio,
                     inventario_de_amigurumis.direccion_url
                HAVING 
                    cantidad_transacciones <5";

    
    $stmt = $conn->query($query);

    if ($stmt) {
        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lista);
    } else {
        echo json_encode(["ERROR" => "No hay datos"]);
    }
}
?>