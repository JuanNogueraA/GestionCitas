<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

    $sql = "SELECT DISTINCT especialidad FROM medico WHERE especialidad IS NOT NULL AND especialidad != ''";
    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("Error en la consulta: " . $conn->error);
    }

    $especialidades = [];
    while($row = $result->fetch_assoc()) {
        $especialidades[] = ['especialidad' => $row['especialidad']];
    }

    echo json_encode($especialidades);

} catch (Exception $e) {
    error_log('Error en getEspecialidades.php: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}