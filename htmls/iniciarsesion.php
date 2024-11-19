<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My website</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <link rel="stylesheet" href="HojasEstilo/inicioSesion.css"> 
   
</head>
<body>
    <header>
        <nav class="navegacionhome">
            <ul>
                <li><button onclick="redirectToHome()" class="button">
                    <i class="fas fa-home"></i> Home
                </button></li>
            </ul>
            <div class="user-menu">
                <i class="fas fa-user-circle"></i>
            </div>
        </nav>
    </header>

    <main>
        <section class="login-section">
            <div class="login-container">
                <div class="login-box">
                    <div class="avatar">
                        <i class="fas fa-user-circle fa-5x"></i>
                    </div>
                    <form method="post" action="iniciarsesionbd.php">
                        <label for="id">
                            <i class="fas fa-user"></i> Usuario ID
                        </label>
                        <input type="text" id="id" placeholder="Ingrese su ID" name="id" required>
                        
                        <label for="contrasena">
                            <i class="fas fa-lock"></i> Contraseña
                        </label>
                        <input type="password" id="contrasena" placeholder="Ingrese su contraseña" name="contrasena" required>
                        
                        <div class="options">
                            <a href="registro1.php">
                                <i class="fas fa-user-plus"></i> Registrar usuario
                            </a>
                            <a href="forgotpassword.php">
                                <i class="fas fa-key"></i> ¿Olvidó su contraseña?
                            </a>
                        </div>

                        <?php
                        if (isset($_SESSION['error'])) {
                            echo '<p class="error-message"><i class="fas fa-exclamation-circle"></i> ' . $_SESSION['error'] . '</p>';
                            unset($_SESSION['error']);
                        }
                        ?>

                        <button type="submit">
                            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </main>

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