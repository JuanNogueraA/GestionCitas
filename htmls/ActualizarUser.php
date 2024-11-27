<?php
require_once 'DataBase.php'; // Ajusta la ruta según sea necesario

try {
    // Crear conexión usando el patrón singleton
    $conn = DataBase::getInstance()->getConnection();

    //Se comprueba si el método de la petición es POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //Se comprueba si los datos requeridos existen
        if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['address']) && isset($_POST['phone']) && isset($_POST['correo'])) {
            //Se obtienen los datos enviados
            $id = $_POST['id'];
            $name = $_POST['name'];
            $lastname = $_POST['lastname'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];
            $correo = $_POST['correo'];
            //Se actualizan los datos del usuario
            $sql = "UPDATE usuario SET nombres = ?, apellidos = ?, direccion = ?, telefono = ?, correo = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssi", $name, $lastname, $address, $phone, $correo, $id);
            //Se verifica si la consulta se ejecutó correctamente
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Datos actualizados correctamente']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al actualizar los datos']);
            }
            //Se cierra la conexión
            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
        }
    }

    $conn->close();
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>