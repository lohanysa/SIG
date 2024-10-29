<?php
require("DB_Puerto.php");

// Verifica la conexión
if (!$conn) {
    echo json_encode(["ERROR" => "No hay conexión con la base de datos"]);
    exit;
} else {
    // Sentencia para mostrar las ventas trimestral
    $query = "SELECT 
                    cliente.nombre, 
                    cliente.apellido, 
                    cliente.id_correo, 
                    COUNT(pedido.fk_amigurumis) AS cantidad_transacciones
                FROM 
                    cliente
                JOIN 
                    pedido ON pedido.fk_cliente = cliente.id_correo
                GROUP BY 
                    cliente.nombre, 
                    cliente.apellido, 
                    cliente.id_correo
                HAVING 
                    cantidad_transacciones >= 3;";


    
    $stmt = $conn->query($query);

    if ($stmt) {
        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lista);
    } else {
        echo json_encode(["ERROR" => "No hay datos"]);
    }
}
?>