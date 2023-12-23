<?php

// Obteniendo el id de la region del formulario
$regionId = $_POST['region_id'];

try {
    // Conectando a la base de datos
    $pdo = new PDO('sqlite:../encuesta.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Consulta para obtener todas las comunas de la región especificada
    $query = $pdo->prepare("SELECT * FROM Comunas WHERE id_region = :regionId");
    
    // https://www.php.net/manual/es/pdo.constants.php
    // Representa el tipo de dato INTEGER de SQL
    $query->bindParam(':regionId', $regionId, PDO::PARAM_INT);
    $query->execute();

    // Obteniendo el resultado
    $comunas = $query->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los datos como JSON
    header('Content-Type: application/json');
    echo json_encode($comunas);
} catch (PDOException $e) {
    // Manejar errores
    echo json_encode(['error' => $e->getMessage()]);
}
