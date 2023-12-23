<?php

// Obteniendo datos del formulario
$nombre_apellido = $_POST['nombre_apellido'];
$alias = $_POST['alias'];
$rut = $_POST['rut'];
$email = $_POST['email'];
$id_region = $_POST['regiones'];
$id_comuna = $_POST['comunas'];
$id_candidato = $_POST['candidatos'];

// aplicando funcion ternaria para simplificar codigo
// si el resultado es true se guarda como 1 en caso contrario 0
$web = $_POST['web'] == 'true' ? 1 : 0;
$tv = $_POST['tv'] == 'true'  ? 1 : 0;
$rrss = $_POST['rrss'] == 'true'  ? 1 : 0;
$amigo = $_POST['amigo'] == 'true'  ? 1 : 0;

try {
    // Validar campos obligatorios
    if ($nombre_apellido == '') throw new Exception('Debe completar el campo Nombre y Apellido');

    // alias no debe ser vacio y debe ser mayor o igual a 5
    if ( $alias == '' /* && (strlen($alias) <= 5) && (!preg_match('/[a-zA-Z]/', $alias) || !preg_match('/[0-9]/', $alias)) */) {
        throw new Exception('Debe completar el campo Alias');
    } elseif ( strlen($alias) <= 5) {
        // largo de alias debe ser mayor a 5
        throw new Exception('El campo Alias debe ser mayor a 5');
    } elseif (!preg_match('/[a-zA-Z]/', $alias) || !preg_match('/[0-9]/', $alias)) {
        // Verificar que el alias contenga letras y números
        throw new Exception('El campo Alias debe contener letras y números.');
    }
    
    // JavaScript se encarga de que el RUT debe ser válido.
    if ($rut == '') throw new Exception('Debe completar el campo RUT');
    
    // el formulario se encarga de validar  el correo según estándar
    if ($email == '') throw new Exception('Debe completar el campo email');
    if ($id_region == '') throw new Exception('Debe completar el campo Región');
    if ($id_comuna == '') throw new Exception('Debe completar el campo Comuna');
    if ($id_candidato == '') throw new Exception('Debe completar el campo Candidato');

    // Conectar a la base de datos
    $pdo = new PDO('sqlite:../encuesta.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Validar duplicación de votos por RUT
    $stmtDuplicacion = $pdo->prepare("SELECT COUNT(*) as total FROM Encuesta WHERE rut = ?");
    $stmtDuplicacion->execute([$rut]);
    // https://www.php.net/manual/en/pdostatement.fetch.php
    // retorna una arreglo con el indice y el valor
    $duplicacion = $stmtDuplicacion->fetch(PDO::FETCH_ASSOC);

    // $duplicacion = [ 'total' => cantidad ]
    if ($duplicacion['total'] > 0) {
        // Manejar la duplicación de votos
        throw new Exception('Ya existe un voto registrado con el RUT proporcionado.');
    }

    // Preparar y ejecutar la consulta de inserción
    $stmt = $pdo->prepare('INSERT INTO Encuesta (nombre_apellido, alias, rut, email, id_region, id_comuna, id_candidato, web, tv, rrss, amigo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$nombre_apellido, $alias, $rut, $email, $id_region, $id_comuna, $id_candidato, $web, $tv, $rrss, $amigo]);

    // Mensaje de exito amigable para el usuario
    echo json_encode(['status' => 'success', 'message' => 'Datos insertados con éxito']);
} catch (PDOException $e) {
    // Log de errores
    error_log('Error de PDO: ' . $e->getMessage());
    // Mensaje de error amigable para el usuario
    echo json_encode(['status' => 'error', 'message' => 'Error al conectar a la base de datos. Por favor, inténtelo de nuevo más tarde.', $e->getMessage()]);
} catch (Exception $e) {
    // Mensaje de error amigable para el usuario
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
} finally {
    // Cerrar la conexión a la base de datos
    $pdo = null;
}
