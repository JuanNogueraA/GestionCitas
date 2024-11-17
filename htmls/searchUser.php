<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestiondecitas";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id']) && isset($_POST['newRole'])) {
        $id = $_POST['id'];
        $newRole = $_POST['newRole'];

        $sql = "UPDATE usuario SET rol = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $newRole, $id);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Rol actualizado']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el rol']);
        }
        $stmt->close();
    }else if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $sql = "SELECT * FROM usuario WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            echo json_encode(['status' => 'success', 'user' => [
                'name' => $user['nombres'], // Ensure 'nombre' is the correct column name for the user's name
                'role' => $user['rol'] // Ensure 'rol' is the correct column name for the role
            ]]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Usuario no encontrado']);
        }
        $stmt->close();
    }
}

$conn->close();
?>