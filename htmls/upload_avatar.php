<?php
session_start();
require_once 'DataBase.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['avatar']['tmp_name'];
        $fileName = $_FILES['avatar']['name'];
        $fileSize = $_FILES['avatar']['size'];
        $fileType = $_FILES['avatar']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Lista de extensiones permitidas
        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Verificar el tamaño (por ejemplo, máximo 2MB)
            if ($fileSize < 2 * 1024 * 1024) {
                // Generar un nombre único
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

                // Directorio donde se guardarán los avatares
                $uploadFileDir = 'uploads/avatars/';
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0755, true);
                }
                $dest_path = $uploadFileDir . $newFileName;

                // Mover el archivo al directorio de destino
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    // Opcional: Redimensionar la imagen si es necesario
                    list($width, $height) = getimagesize($dest_path);
                    $maxDim = 200;
                    if ($width > $maxDim || $height > $maxDim) {
                        $ratio = $width / $height;
                        if ($ratio > 1) {
                            $new_width = $maxDim;
                            $new_height = $maxDim / $ratio;
                        } else {
                            $new_width = $maxDim * $ratio;
                            $new_height = $maxDim;
                        }
                        $src = imagecreatefromstring(file_get_contents($dest_path));
                        $dst = imagecreatetruecolor($new_width, $new_height);
                        imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                        imagejpeg($dst, $dest_path);
                        imagedestroy($src);
                        imagedestroy($dst);
                    }

                    // Actualizar la ruta del avatar en la base de datos
                    $conn = DataBase::getInstance()->getConnection();
                    $userId = $_SESSION['user_id'];
                    $sql = "UPDATE usuario SET avatar = ? WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si", $dest_path, $userId);
                    if ($stmt->execute()) {
                        echo json_encode(['status' => 'success', 'avatar_path' => $dest_path]);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar la base de datos.']);
                    }
                    $stmt->close();
                    $conn->close();
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al mover el archivo al directorio de destino.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'El archivo es demasiado grande. Máximo 2MB.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Tipo de archivo no permitido.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se subió ningún archivo o hubo un error en la subida.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método de solicitud no válido.']);
}