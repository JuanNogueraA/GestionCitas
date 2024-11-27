<?php
require_once 'DataBase.php'; // Adjust the path as necessary
session_start();
try {
    // Create connection using singleton pattern
    $conn = DataBase::getInstance()->getConnection();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['id']) && isset($_POST['newRole'])) {
            $id = $_POST['id'];
            $newRole = $_POST['newRole'];
            $sql = "UPDATE usuario SET rol = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $newRole, $id);
            if ($stmt->execute()) {
                
                if($newRole === 'administrador'){
                    $nivelpermisos = 1;
                    $sqlAdmin = "INSERT INTO administrador (id, id_usuario, nivel_permisos) VALUES (?, ?, ?)";
                    $stmtAdmin = $conn->prepare($sqlAdmin);
                    $stmtAdmin->bind_param("iis", $id, $id, $nivelpermisos);
                    if (!$stmtAdmin->execute()) {
                        echo json_encode(['status' => 'error', 'message' => 'Error al crear el registro de administrador']);
                        $stmtAdmin->close();
                        $stmt->close();
                        $conn->close();
                        exit();
                    }
                    $stmtAdmin->close();
                } else {
                    $sqlAdmin = "DELETE FROM administrador WHERE id_usuario = ?";
                    $stmtAdmin = $conn->prepare($sqlAdmin);
                    $stmtAdmin->bind_param("i", $id);
                    $stmtAdmin->execute();
                    $stmtAdmin->close();
                }
                if ($newRole === 'paciente') {
                    $estado = 'activo';
                    $sqlPaciente = "INSERT INTO paciente (id, id_usuario, estado) VALUES (?, ?, ?)";
                    $stmtPaciente = $conn->prepare($sqlPaciente);
                    $stmtPaciente->bind_param("iis", $id, $id, $estado);
                    if (!$stmtPaciente->execute()) {
                        echo json_encode(['status' => 'error', 'message' => 'Error al crear el registro de paciente']);
                        $stmtPaciente->close();
                        $stmt->close();
                        $conn->close();
                        exit();
                    }
                    $stmtPaciente->close();
                } else {
                    $sqlPaciente = "DELETE FROM paciente WHERE id_usuario = ?";
                    $stmtPaciente = $conn->prepare($sqlPaciente);
                    $stmtPaciente->bind_param("i", $id);
                    $stmtPaciente->execute();
                    $stmtPaciente->close();
                }
                if($newRole === 'medico'){
                    $specialty = isset($_POST['specialty']) ? $_POST['specialty'] : '';
                    $disponible = 1;
                    $sqlMedico = "INSERT INTO medico (id,id_usuario, especialidad, disponible) VALUES (?,?,?,?)";
                    $stmtMedico = $conn->prepare($sqlMedico);
                    $stmtMedico->bind_param("issi", $id, $id, $specialty, $disponible);
                    if (!$stmtMedico->execute()) {
                        echo json_encode(['status' => 'error', 'message' => 'Error al crear el registro de medico']);
                        $stmtMedico->close();
                        $stmt->close();
                        $conn->close();
                        exit();
                    }
                    $stmtMedico->close();
                } else {
                    $sqlMedico = "DELETE FROM medico WHERE id_usuario = ?";
                    $stmtMedico = $conn->prepare($sqlMedico);
                    $stmtMedico->bind_param("i", $id);
                    $stmtMedico->execute();
                    $stmtMedico->close();
                }
                echo json_encode(['status' => 'success']);
            } else {
                throw new Exception('Error al actualizar el rol');
            }
            $stmt->close();
        } else if (isset($_POST['id'])) {
            $id = $_POST['id'];
            if($_SESSION['user_rol']==='medico'){
                $sql = "SELECT * FROM usuario WHERE id = ? AND rol = 'paciente'";
            }else{
                $sql = "SELECT * FROM usuario WHERE id = ?";
            }
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                echo json_encode(['status' => 'success', 'user' => [
                    'name' => $user['nombres'], // Ensure 'nombres' is the correct column name for the user's name
                    'role' => $user['rol'], // Ensure 'rol' is the correct column name for the role
                    'lastname' => $user['apellidos'], // Ensure 'apellidos' is the correct column name for the user's last name
                    'address' => $user['direccion'], // Ensure 'direccion' is the correct column name for the address
                    'email' => $user['correo'], // Ensure 'correo' is the correct column name for the email
                    'phone' => $user['telefono'] // Ensure 'telefono' is the correct column name for the phone
                ]]);
            } else {
                if($_SESSION['user_rol']==='medico'){
                    throw new Exception('Paciente no encontrado');
                }else{
                    throw new Exception('Usuario no encontrado');
                }
            }
            $stmt->close();
        }
    }

    $conn->close();
} catch (Exception $e) {
    if ($e->getCode() === 1062) {
        $error = "Rol ya seleccionado. Por favor, use uno diferente.";
        echo json_encode(['status' => 'error', 'message' => $error]);
    }else{
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>