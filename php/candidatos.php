<?php

$comunaId = $_POST['comuna_id'];

try {
    $pdo = new PDO('sqlite:../encuesta.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Consulta para obtener todas los candidatos de la región especificada
    $query = $pdo->prepare("SELECT * FROM Candidatos WHERE id_comuna = :comunaId");
    $query->bindParam(':comunaId', $comunaId, PDO::PARAM_INT);
    $query->execute();

    // Obtener resultados y enviar como respuesta JSON
    $candidatos = $query->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($candidatos);
} catch (PDOException $e) {
    // Manejar errores
    echo json_encode(['error' => $e->getMessage()]);
}
