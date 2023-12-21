<?php

$regionId = $_POST['region_id'];

try {
    $pdo = new PDO('sqlite:../encuesta.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Consulta para obtener todas las comunas de la región especificada
    $query = $pdo->prepare("SELECT * FROM Comunas WHERE id_region = :regionId");
    $query->bindParam(':regionId', $regionId, PDO::PARAM_INT);
    $query->execute();

    // Obtener resultados y enviar como respuesta JSON
    $comunas = $query->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($comunas);
} catch (PDOException $e) {
    // Manejar errores
    echo json_encode(['error' => $e->getMessage()]);
}
