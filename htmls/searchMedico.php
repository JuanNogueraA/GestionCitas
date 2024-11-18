<?php
// ...existing code...

require_once 'DataBase.php'; // Asegúrate de ajustar la ruta según sea necesario

// Obtener la instancia de la base de datos
$db = DataBase::getInstance();
$connection = $db->getConnection();

// ...existing code...

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $userId = $_POST['id'];
    // Consulta para buscar el médico utilizando INNER JOIN
    $query = "SELECT *
    FROM medico
    INNER JOIN usuario ON medico.id_usuario = usuario.id
    WHERE usuario.id = ?
    ";
    $stmt = $connection->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Procesar los resultados
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'user' => [
            'name' => $user['nombres'], // Ensure 'nombres' is the correct column name for the user's name
            'especialidad' => $user['especialidad'] // Ensure 'especialidad' is the correct column name for the specialty
        ]]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Usuario no encontrado']);
    }

    $stmt->close();
}
$connection->close();
// ...existing code...

?>
