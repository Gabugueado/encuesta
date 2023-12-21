<?php
$nombre_apellido = $_POST['name'];
$alias = $_POST['alias'];
$rut = $_POST['rut'];
$email = $_POST['email'];
$id_region = $_POST['regiones'];
$id_comuna = $_POST['comunas'];
$id_candidato = $_POST['candidatos'];
// aplicando funcion ternaria para simplificar codigo, si el resultado es true se guarda como 1 en caso contrario 0
$web = $_POST['web'] == 'true' ? 1 : 0;
$tv = $_POST['tv'] == 'true'  ? 1 : 0;
$rrss = $_POST['rrss'] == 'true'  ? 1 : 0;
$amigo = $_POST['amigo'] == 'true'  ? 1 : 0;

try {
    if ($nombre_apellido == '') throw new Exception("debe completar el campo nombre");
    if ($alias == '') throw new Exception("debe completar el campo alias");
    if ($rut == '') throw new Exception("debe completar el campo rut");
    if ($email == '') throw new Exception("debe completar el campo email");
    if ($id_region == '') throw new Exception("debe completar el campo region");
    if ($id_comuna == '') throw new Exception("debe completar el campo comuna");
    if ($id_candidato == '') throw new Exception("debe completar el campo candidato");
    // Conectar a la base de datos SQLite
    $pdo = new PDO('sqlite:../encuesta.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Validar duplicación de votos por RUT
    $stmtDuplicacion = $pdo->prepare("SELECT COUNT(*) as total FROM Encuesta WHERE rut = ?");
    $stmtDuplicacion->execute([$rut]);
    $duplicacion = $stmtDuplicacion->fetch(PDO::FETCH_ASSOC);
    // [ 'total' => cantidad ]
    if ($duplicacion['total'] > 0) {
        // Manejar la duplicación de votos
        throw new Exception("Ya existe un voto registrado con el RUT proporcionado.");
    }
    // Preparar y ejecutar la consulta de inserción
    $stmt = $pdo->prepare("INSERT INTO Encuesta (nombre_apellido, alias, rut, email, id_region, id_comuna, id_candidato, web, tv, rrss, amigo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nombre_apellido, $alias, $rut, $email, $id_region, $id_comuna, $id_candidato, $web, $tv, $rrss, $amigo]);
    // Mensaje de exito amigable para el usuario
    echo json_encode(['status' => 'success', 'message' => 'Datos insertados con éxito']);
} catch (PDOException $e) {
    // Log de errores
    error_log("Error de PDO: " . $e->getMessage());
    // Mensaje de error amigable para el usuario
    echo json_encode(['status' => 'error', 'message' => 'Error al conectar a la base de datos. Por favor, inténtelo de nuevo más tarde.', $e->getMessage()]);
} catch (Exception $e) {
    // Mensaje de error amigable para el usuario
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
} finally {
    // Cerrar la conexión a la base de datos
    $pdo = null;
}

?>