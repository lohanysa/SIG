<?php
require("DB_Puerto.php");

// Verifica la conexión
if (!$conn) {
    echo json_encode(["ERROR" => "No hay conexión con la base de datos"]);
    exit;
} else {
    // Sentencia para mostrar las ventas de peluches
    $query = "SELECT 
    inventario_de_amigurumis.nombre, 
    inventario_de_amigurumis.id_amigurumis, 
    COUNT(pedido.fk_amigurumis) AS ventas
    FROM 
        inventario_de_amigurumis 
    JOIN 
        pedido 
    ON 
        inventario_de_amigurumis.id_amigurumis = pedido.fk_amigurumis 
    WHERE 
        MONTH(pedido.fecha) = MONTH(CURDATE())
    GROUP BY 
        inventario_de_amigurumis.nombre, 
        inventario_de_amigurumis.id_amigurumis";

    
    $stmt = $conn->query($query);

    if ($stmt) {
        $lista_comparacion = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lista_comparacion);
    } else {
        echo json_encode(["ERROR" => "No hay datos"]);
    }
}
