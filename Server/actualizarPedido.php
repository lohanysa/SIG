<?php
require 'DB_Puerto.php';
$response = [];
$estado = $_POST['estado'];
$id = $_POST['id'];
if ($estado != '') {
    try {
        $sql = "UPDATE Pedido SET estado = :estado WHERE id_pedido = :id";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        $response['msg'] = 'Se actualizo con exito';
        echo json_encode($response);

    } catch (PDOException $e) {
        $response['msg'] = "Error al registrar el pedido: " . $e->getMessage();
        echo json_encode($response);
    }
} else {
    $response['msg'] = 'No se enviaron parametros.';
    echo json_encode($response);
}