<?php
require("../../server/DB_Puerto.php");

// Verifica la conexión
if (!$conn) {
    echo json_encode(["ERROR" => "No hay conexión con la base de datos"]);
    exit;
} else {
    // Sentencia para mostrar los pedidos
    $query = "SELECT * FROM pedido";
    $stmt = $conn->query($query);

    if ($stmt) {
        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lista);
    } else {
        echo json_encode(["ERROR" => "No hay datos"]);
    }
}
