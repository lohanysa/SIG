<?php 
require("DB_Puerto.php");

// Verifica la conexión
if (!$conn) {
    echo json_encode(["ERROR" => "No hay conexión con la base de datos"]);
    exit;
} else {
    if (isset($_POST['mes']) && isset($_POST['anio_mes'])) {
        $mes = $_POST['mes'];
        $anio_mes = $_POST['anio_mes'];

        $sql = "SELECT 
                    i.id_amigurumis,
                    i.direccion_url,
                    i.precio,
                    SUM(p.cantidad) AS cantidad_comprada,
                    SUM(p.cantidad * i.precio) AS venta_total,
                    SUM(CASE WHEN p.metodo_pago = 'yappy' THEN 1 ELSE 0 END) AS pagos_yappy,
                    SUM(CASE WHEN p.metodo_pago = 'efectivo' THEN 1 ELSE 0 END) AS pagos_efectivo
                FROM 
                    inventario_de_amigurumis i
                JOIN 
                    pedido p ON i.id_amigurumis = p.fk_amigurumis
                WHERE
                    MONTH(p.fecha) = :mes 
                    AND YEAR(p.fecha) = :anio_mes
                GROUP BY 
                    i.id_amigurumis, 
                    i.direccion_url, 
                    i.precio;";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
        $stmt->bindParam(':anio_mes', $anio_mes, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt) {
            $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($lista);
        } else {
            echo json_encode(["ERROR" => "No hay datos"]);
        }
    } else {
        echo json_encode(["ERROR" => "Mes o año no especificado"]);
    }
}


?>