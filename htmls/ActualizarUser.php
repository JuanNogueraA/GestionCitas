<?php
require_once 'DataBase.php'; // Ajusta la ruta según sea necesario
session_start();

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
            $descripcion = "Actualización de datos del usuario";
            date_default_timezone_set('America/Bogota'); // Ajusta la zona horaria a Bogotá, Colombia
            $fechaActual = date('Y-m-d H:i:s');
            $stmtauditoria = $conn->prepare("INSERT INTO auditoria_usuario (id_usuario, id_admin, fecha, descripcion_accion) VALUES (?, ?, ?, ?)");
            $stmtauditoria->bind_param("iiss", $id, $_SESSION['user_id'], $fechaActual, $descripcion);
            
            if ($stmt->execute()) {
                $stmtauditoria->execute();
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