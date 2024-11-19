
<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

$opcion = $data['opcion'];
$valorOpcion = $data['valorOpcion'];
$fecha = $data['fecha'];
$hora = $data['hora'];

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestioncitas');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$sql = "SELECT id, name, specialty FROM doctors WHERE available_date = ? AND available_time = ? AND $opcion = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $fecha, $hora, $valorOpcion);
$stmt->execute();
$result = $stmt->get_result();

$doctors = [];
while ($row = $result->fetch_assoc()) {
    $doctors[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($doctors);
?>