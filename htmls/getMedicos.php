<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    $dbPath = __DIR__ . DIRECTORY_SEPARATOR . 'DataBase.php';
    if (!file_exists($dbPath)) {
        throw new Exception('DataBase.php no encontrado en: ' . $dbPath);
    }

    require_once $dbPath;
    
    $conn = DataBase::getInstance()->getConnection();
    
    if (!$conn) {
        throw new Exception("Error de conexión a la base de datos");
    }

    $rol = 'medico';
    $sql = "SELECT id, nombres FROM usuario WHERE rol = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $rol);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        throw new Exception("Error en la consulta: " . $conn->error);
    }

    $medicos = [];
    while($row = $result->fetch_assoc()) {
        $medicos[] = ['id' => $row['id'], 'nombre' => $row['nombres']];
    }
    
    echo json_encode($medicos);
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>