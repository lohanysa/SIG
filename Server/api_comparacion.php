<?php
require("DB_Puerto.php");

// Verifica la conexión
if (!$conn) {
    echo json_encode(["ERROR" => "No hay conexión con la base de datos"]);
    exit;
} else {
    // Sentencia para mostrar las ventas trimestral
    $query = "SELECT 
            COUNT(*) AS total_ventas, 
            QUARTER(fecha) AS trimestre, 
            MONTHNAME(fecha) AS mes 
          FROM 
            pedido 
          GROUP BY 
            trimestre, mes 
          ORDER BY 
            trimestre, MONTH(fecha)";


    
    $stmt = $conn->query($query);

    if ($stmt) {
        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lista);
    } else {
        echo json_encode(["ERROR" => "No hay datos"]);
    }
}
?>
