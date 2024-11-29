<?php
session_start();
require_once 'conexion.php'; // Tu archivo de conexión a la base de datos

// Verificar que el médico esté logueado
if (!isset($_SESSION['medico_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

$medico_id = $_SESSION['medico_id'];

try {
    // Obtener disponibilidad del médico
    $stmt_disponibilidad = $conexion->prepare("
        SELECT dia, hora_inicio, hora_fin, disponible 
        FROM disponibilidad_medico 
        WHERE medico_id = ?
    ");
    $stmt_disponibilidad->bind_param("i", $medico_id);
    $stmt_disponibilidad->execute();
    $result_disponibilidad = $stmt_disponibilidad->get_result();
    $disponibilidad = $result_disponibilidad->fetch_all(MYSQLI_ASSOC);

    // Obtener citas pendientes
    $stmt_citas = $conexion->prepare("
        SELECT 
            c.id, 
            p.nombre AS paciente, 
            c.fecha, 
            c.hora 
        FROM citas c
        JOIN pacientes p ON c.paciente_id = p.id
        WHERE c.medico_id = ? AND c.estado = 'pendiente'
        ORDER BY c.fecha, c.hora
        LIMIT 5
    ");
    $stmt_citas->bind_param("i", $medico_id);
    $stmt_citas->execute();
    $result_citas = $stmt_citas->get_result();
    $citasPendientes = $result_citas->fetch_all(MYSQLI_ASSOC);

    echo json_encode([
        'disponibilidad' => $disponibilidad,
        'citasPendientes' => $citasPendientes
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} 