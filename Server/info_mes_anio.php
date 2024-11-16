<?php
//esto es para hacer la consulta de los trimestre años y meses(es una manera de evitar una consulta erronea)
require("DB_Puerto.php");


if (!$conn) {
    die("Conexion fallida: " . $conn);
}


$sql_info = "SELECT  YEAR(fecha) AS anio,
    MONTH(fecha) AS mes,
    MONTHNAME(fecha) AS nombre_mes,
    CEIL(MONTH(fecha) / 3) AS trimestre
FROM 
    pedido
   GROUP BY 
    anio, nombre_mes, trimestre
ORDER BY 
    anio, nombre_mes;";


$stmt = $conn->prepare($sql_info);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($result) {
    echo json_encode($result);
} else {
    echo json_encode(array("Error" => "No hay resultados"));
}



?>