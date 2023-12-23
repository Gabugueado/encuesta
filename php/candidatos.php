<?php

// Obteniendo el id de la comuna del formulario
$comunaId = $_POST['comuna_id'];

try {
    // Conectando a la base de datos
    $pdo = new PDO('sqlite:../encuesta.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Consulta para obtener todos los candidatos de la comuna especificada
    $query = $pdo->prepare("SELECT * FROM Candidatos WHERE id_comuna = :comunaId");
    
    // https://www.php.net/manual/es/pdo.constants.php
    // Representa el tipo de dato INTEGER de SQL
    $query->bindParam(':comunaId', $comunaId, PDO::PARAM_INT);
    $query->execute();

    // Obteniendo el resultado
    $candidatos = $query->fetchAll(PDO::FETCH_ASSOC);
    
    // Devolver los datos como JSON
    header('Content-Type: application/json');
    echo json_encode($candidatos);
} catch (PDOException $e) {
    // Manejar errores
    echo json_encode(['error' => $e->getMessage()]);
}
