<?php
try {
    $pdo = new PDO('sqlite:../encuesta.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Obtener todas las regiones
    $queryRegiones = $pdo->query("SELECT * FROM Regiones");
    $regiones = $queryRegiones->fetchAll(PDO::FETCH_ASSOC);

    // Obtener todas las comunas
    $queryComunas = $pdo->query("SELECT * FROM Comunas");
    $comunas = $queryComunas->fetchAll(PDO::FETCH_ASSOC);

    // Crear un array para devolver los datos como JSON
    $result = [
        'regiones' => $regiones,
        'comunas' => $comunas
    ];

    // Devolver los datos como JSON
    header('Content-Type: application/json');
    echo json_encode($result);
} catch (PDOException $e) {
    // Manejar errores
    echo json_encode(['error' => $e->getMessage()]);
}
