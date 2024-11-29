<?php
require_once 'DataBase.php'; // Ajusta la ruta según sea necesario
session_start();

try {
    // Crear conexión usando el patrón singleton
    $conn = DataBase::getInstance()->getConnection();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Verificar si id y newRole están establecidos en la solicitud POST
        if (isset($_POST['id']) && isset($_POST['newRole'])) {
            $id = $_POST['id'];
            $newRole = $_POST['newRole'];
            $sql = "UPDATE usuario SET rol = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $newRole, $id);
            $stmtcomprobacion = $conn->prepare("SELECT rol FROM usuario WHERE id = ?");
            $stmtcomprobacion->bind_param("i", $id);
            $stmtcomprobacion->execute();
            $result = $stmtcomprobacion->get_result();
            $rol = $result->fetch_assoc();
            if ($rol['rol'] === $newRole) {
                echo json_encode(['status' => 'error', 'message' => 'El usuario ya tiene el rol seleccionado']);
                $stmtcomprobacion->close();
                $stmt->close();
                $conn->close();
                exit();
            }

            if ($stmt->execute()) {
                // Manejar la lógica específica del rol
                if ($newRole === 'administrador') {
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
                    // Eliminar el registro de administrador si el nuevo rol no es administrador
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
                    // Eliminar el registro de paciente si el nuevo rol no es paciente
                    $sqlPaciente = "DELETE FROM paciente WHERE id_usuario = ?";
                    $stmtPaciente = $conn->prepare($sqlPaciente);
                    $stmtPaciente->bind_param("i", $id);
                    $stmtPaciente->execute();
                    $stmtPaciente->close();
                }

                if ($newRole === 'medico') {
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
                    // Eliminar el registro de medico si el nuevo rol no es medico
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
            // Si el usuario actual es un medico, solo puede buscar pacientes
            if ($_SESSION['user_rol'] === 'medico') {
                $sql = "SELECT * FROM usuario WHERE id = ? AND rol = 'paciente'";
            } else {
                $sql = "SELECT * FROM usuario WHERE id = ?";
            }
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                echo json_encode(['status' => 'success', 'user' => [
                    'name' => $user['nombres'], // Asegúrate de que 'nombres' es el nombre correcto de la columna para el nombre del usuario
                    'role' => $user['rol'], // Asegúrate de que 'rol' es el nombre correcto de la columna para el rol
                    'lastname' => $user['apellidos'], // Asegúrate de que 'apellidos' es el nombre correcto de la columna para el apellido del usuario
                    'address' => $user['direccion'], // Asegúrate de que 'direccion' es el nombre correcto de la columna para la dirección
                    'email' => $user['correo'], // Asegúrate de que 'correo' es el nombre correcto de la columna para el correo electrónico
                    'phone' => $user['telefono'] // Asegúrate de que 'telefono' es el nombre correcto de la columna para el teléfono
                ]]);
            } else {
                if ($_SESSION['user_rol'] === 'medico') {
                    throw new Exception('Paciente no encontrado');
                } else {
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
    } else {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>