<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My website</title>
    <link rel="stylesheet" href="HojasEstilo/inicioSesion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
</head>
<body>
    <header>
        <nav class="navegacionhome navbar">
            <ul>
                <li><button onclick="redirectToHome()" class="button">Home</button></li>
                <li><button onclick="redirectToIniciarSesion()" class="button">Iniciar sesion</button></li>
            </ul>
            <div class="user-menu">
                <i class="fas fa-user"></i>
            </div>
        </nav>
        <div class="login-container">
            <div class="login-box">
                <div class="avatar">
                    <img src="https://static.vecteezy.com/system/resources/previews/005/005/840/non_2x/user-icon-in-trendy-flat-style-isolated-on-grey-background-user-symbol-for-your-web-site-design-logo-app-ui-illustration-eps10-free-vector.jpg" alt="User Avatar">
                </div>
                <form method="post" action="iniciarsesionbd.php">
                    
                    <label for="id">Id</label>
                    <input type="text" id="id" placeholder="Ingrese id" name="id">
                    
                    <label for="contrasena">Contraseña</label>
                    <input type="password" id="contrasena" placeholder="Ingrese contraseña" name="contrasena">
                    
                    <div class="options">
                        <a href="registro1.php"><br/>Registrar usuario</a>
                    </div>
                    <?php
                    session_start();
                    if (isset($_SESSION['error'])) {
                        echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
                        unset($_SESSION['error']);
                    }
                    ?>
                    <button type="submit">LOGIN</button>
                </form>
            </div>
        </div>
    </header>
    <script>
        function redirectToHome() {
            window.location.href = 'index.php';
        }

        function redirectToIniciarSesion() {
            window.location.href = 'iniciarsesion.php';
        }
    </script>
</body>
</html>