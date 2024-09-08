<?php
require 'DB_Puerto.php';
$response = [];

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $idPedido = $_POST['id'];

    try {
        // Prepare and execute the first query
        $sql = "SELECT * FROM Pedido WHERE id_pedido = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $idPedido, PDO::PARAM_INT);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);

        // Prepare and execute the second query
        $sqlurl = "
            SELECT 
                pe.id_pedido,
                cl.id_correo,
                inv.direccion_url
            FROM 
                Pedido pe
            JOIN 
                Cliente cl ON pe.fk_cliente = cl.id_correo
            JOIN 
                Inventario_de_amigurumis inv ON cl.fk_amigurumis = inv.id_amigurumis
            WHERE 
                pe.id_pedido = :id";
        $stmtUrl = $conn->prepare($sqlurl);
        $stmtUrl->bindParam(':id', $idPedido, PDO::PARAM_INT);
        $stmtUrl->execute();
        $registro2 = $stmtUrl->fetch(PDO::FETCH_ASSOC);

        if ($registro && $registro2) {
            $response['id'] = $registro['id_pedido'];
            $response['estado'] = $registro['estado'];
            $response['fecha'] = $registro['fecha'];
            $response['metodo_pago'] = $registro['metodo_pago'];
            $response['cantidad'] = $registro['cantidad'];
            $response['fk_empleado'] = $registro['fk_empleado'];
            $response['fk_cliente'] = $registro['fk_cliente'];
            $response['direccion_url'] = $registro2['direccion_url'];
        } else {
            $response['error'] = 'No se encontró el pedido o los datos relacionados.';
        }
    } catch (PDOException $e) {
        $response['error'] = 'Error de base de datos: ' . $e->getMessage();
    }
} else {
    $response['error'] = 'ID de pedido no proporcionado o vacío.';
}

echo json_encode($response);
?>
