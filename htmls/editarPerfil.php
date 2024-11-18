<?php
session_start();
require_once 'DataBase.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombres = $_POST['nombres'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    // Use the singleton database connection
    $conn = DataBase::getInstance()->getConnection();

    $user_id = $_SESSION['user_id'];
    $sql = "UPDATE usuario SET nombres='$nombres', correo='$correo', telefono='$telefono' WHERE id='$user_id'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['user_nombres'] = $nombres;
        $_SESSION['user_correo'] = $correo;
        $_SESSION['user_telefono'] = $telefono;
        $_SESSION['success_message'] = "Los cambios se han guardado con éxito.";
        header('Location: verPerfil.php');
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Editar Perfil</title>
</head>
<body>
    <div class="container">
        <h1>Editar Perfil</h1>
        <form method="POST" action="editarPerfil.php">
            <div class="mb-3">
                <label for="nombres" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo $_SESSION['user_nombres']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $_SESSION['user_correo']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $_SESSION['user_telefono']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>