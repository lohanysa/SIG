<?php
require 'DB_Puerto.php';

$response = array();

if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['phoneNumber']) && isset($_POST['email'])) {
    $usuario = trim($_POST['email']); 
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $phoneNumber = trim($_POST['phoneNumber']);
    
    // Consulta para verificar si existe el cliente
    $sql = "SELECT * FROM Cliente WHERE id_correo = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $usuario);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // El correo ya existe
        $response['exists'] = true;
    } else {
        // Insertar el nuevo cliente
        $sqlInsert = "INSERT INTO Cliente (id_correo, nombre, apellido, telefono) VALUES (:email, :firstName, :lastName, :phoneNumber)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bindParam(':email', $usuario);
        $stmtInsert->bindParam(':firstName', $firstName);
        $stmtInsert->bindParam(':lastName', $lastName);
        $stmtInsert->bindParam(':phoneNumber', $phoneNumber);
        
        if ($stmtInsert->execute()) {
            // Inserción exitosa
            $response['success'] = true;
        } else {
            // Error en la inserción
            $response['success'] = false;
        }
    }
} else {
    $response['error'] = 'Datos incompletos';
}

header('Content-Type: application/json');
echo json_encode($response);
?>

