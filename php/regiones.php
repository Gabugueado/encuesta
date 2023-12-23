<?php
try {
    // Conectando a la base de datos
    $pdo = new PDO('sqlite:../encuesta.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obteniendo todas las regiones
    $queryRegiones = $pdo->query("SELECT * FROM Regiones");

    // $regiones = [{id_region: Int, nombre_region: String}]
    $regiones = $queryRegiones->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los datos como JSON
    header('Content-Type: application/json');
    echo json_encode($regiones);
} catch (PDOException $e) {
    // Manejar errores
    echo json_encode(['error' => $e->getMessage()]);
}
