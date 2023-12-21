<?php
// Conexión a la base de datos (ajusta las credenciales según tu configuración)

$pdo = new PDO('sqlite:encuesta.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Ruta al archivo SQL
    $sqlFilePath = "./db/script.sql";

    // Lee el contenido del archivo SQL
    $sqlContent = file_get_contents($sqlFilePath);

    // Ejecuta el contenido del archivo SQL
    $pdo->exec($sqlContent);

    echo "Script SQL ejecutado exitosamente.";
} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error general: " . $e->getMessage();
}
