<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Metadatos y enlaces a hojas de estilo -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="HojasEstilo/Administrador.css">
  <link rel="stylesheet" href="HojasEstilo/navigator.css">
  <title>Citas</title>
  <style> /* Estilos para el avatar */
    .avatar {
      display: flex;
      justify-content: center;
    }

    /* Estilos para la imagen dentro de .avatar */
    .avatar img {
      width: 30px;
      height: 30px;
      border-radius: 50%;
    }
  </style>
</head>

<body> <!-- Barra de navegación -->
<?php if($_SESSION['user_rol'] === 'administrador'){ ?>
  <a id="regresar" href="GestionCitas.html" class="btn btn-primary" style="margin: 30px 0 0 30px;">← Volver</a>
  <?php } ?>
  <?php if($_SESSION['user_rol'] === 'paciente'){ ?>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
    <a class="navbar-brand" href="">
            <i class="fas fa-user-injured me-2"></i>Portal Paciente
          </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
        <?php if ($_SESSION['user_rol'] === 'paciente') { 
            echo '<li class="nav-item"><a class="nav-link" aria-current="page" href="PacienteInicio.html"><i class="fas fa-home"></i>Home</a></li>';
            echo '<li class="nav-item"><a class="nav-link active" href="Citas.php"><i class="fas fa-calendar-alt"></i>Citas</a></li>';
            echo '<li class="nav-item"><a class="nav-link" href="GestionCitasUsuario.php"><i class="fas fa-tasks"></i>Gestionar Citas</a></li>';
            echo '<li class="nav-item"><a class="nav-link" href="Calendario.html"><i class="fas fa-calendar"></i>Calendario</a></li>';
        }?>
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              <div class="avatar">
                <img
                  src="https://static.vecteezy.com/system/resources/previews/005/005/840/non_2x/user-icon-in-trendy-flat-style-isolated-on-grey-background-user-symbol-for-your-web-site-design-logo-app-ui-illustration-eps10-free-vector.jpg"
                  alt="User Avatar">
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li><a class="dropdown-item" href="verPerfil.php">Ver Perfil</a></li>
              <li><a class="dropdown-item" href="#" id="logout-link">Cerrar Sesión</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
      <?php }
  ?>
  <br>
  <!-- Contenido de la página -->
  <div class="container">
    <!-- Formulario para asignar citas -->
    <?php if ($_SESSION['user_rol'] === 'paciente') { 
      ?>
    <h2>Asignar Cita</h2>
   <?php }else{ ?>
    <h2 style="margin-top: 60px;">Asignar Citas</h2>
    <?php

   } ?>
    <form id="appointmentForm">
      <div class="mb-3">
        <label for="optionSelect" class="form-label">Seleccionar Método de búsqueda</label>
        <select class="form-select" id="optionSelect" required>
          <!-- Opciones para seleccionar el método de búsqueda -->
          <option value="">Seleccionar...</option>
          <option value="medico">Por médico</option>
          <option value="especialidad">Por especialidad</option>
        </select>
        <!-- Campo para seleccionar el médico o especialidad -->
        <div id="optionfield" class="form-label" style="display: none; margin-top: 30px;">
          <select class="form-control" id="optionvalue" name="optionvalue">
            <option value="">Seleccionar...</option>
          </select>
        </div>
      </div>
      <!-- Campos para seleccionar la fecha y hora -->
      <div class="mb-3">
        <label for="dateSelect" class="form-label">Seleccionar Fecha</label>
        <input type="date" class="form-control" id="dateSelect" required>
      </div>
      <!-- Campo para seleccionar la hora -->
      <div class="mb-3">
        <label for="timeSelect" class="form-label">Seleccionar Hora</label>
        <input type="time" class="form-control" id="timeSelect" step="3600" required min="07:00" max="18:00">
      </div>
      <button type="submit" class="btn btn-primary">Buscar Citas Disponibles</button>
    </form>
    <div id="availableDoctors" class="row mt-4"></div>
  </div>
  <footer class="footer text-center text-lg-start">
    <div class="container p-4">
      <div class="row">
        <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
          <h5 class="text-uppercase">Citas</h5>
          <p>
            Aquí puedes gestionar todas tus citas de manera fácil y rápida.
          </p>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">Enlaces</h5>  
          <ul class="list-unstyled mb-0">
            <li>
              <a href="PacienteInicio.html" class="text-dark">
                <i class="fas fa-home"></i>Home
              </a>
            </li>
            <li>
              <a href="Citas.html" class="text-dark">
                <i class="fas fa-calendar-alt"></i>Citas
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="GestionCitasUsuario.php">
                <i class="fas fa-tasks"></i>Gestionar Citas
              </a>
            </li>
            <li>
              <a href="Calendario.html" class="text-dark">
                <i class="fas fa-calendar"></i>Calendario
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2024 Citas. Todos los derechos reservados.
    </div>
  </footer>
    <!-- Scripts de Bootstrap y SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Manejar el evento de carga del documento
    document.addEventListener('DOMContentLoaded', function (event) {
      document.getElementById('timeSelect').addEventListener('change', function (e) {
        let time = e.target.value;
        if (time) {
          // Extrae solo la hora y establece los minutos a 00
          let hour = time.split(':')[0];
          e.target.value = hour + ':00';
        }
      });
      // Manejar el evento de cierre de sesión
      document.getElementById('logout-link').addEventListener('click', function (event) {
        event.preventDefault();
        if (confirm('¿Desea salir de la sesión?')) {
          fetch('logout.php', {
            method: 'POST'
          }).then(() => {
            window.location.href = 'iniciarsesion.php';
          });
        }
      });

      //Cargar médicos y especialidades
      document.getElementById('optionSelect').addEventListener('change', function () {
        const optionSelect = document.getElementById('optionSelect').value;
        const optionField = document.getElementById('optionfield');
        const optionValue = document.getElementById('optionvalue');
        optionValue.innerHTML = ''; // Limpiar opciones
        if (optionSelect) {
          if (optionSelect === 'medico') {
            optionField.style.display = 'block';
            fetch('getMedicos.php')  
              .then(response => {
                if (!response.ok) {
                  return response.json().then(err => {
                    throw new Error(err.error || 'Error del servidor');
                  });
                }
                return response.json();  // Parsear respuesta a JSON
              })
              .then(data => {
                if (!Array.isArray(data)) { // Verificar si la respuesta es un array
                  throw new Error('Formato de datos inválido');
                }
                const optionValue = document.getElementById('optionvalue'); // Obtener el campo de selección
                optionValue.innerHTML = '<option value="">Seleccionar...</option>';
                data.forEach(medico => { // Iterar sobre los médicos
                  const option = document.createElement('option');
                  option.value = medico.id;
                  option.textContent = medico.nombre;
                  optionValue.appendChild(option); // Agregar opción al campo de selección
                });
              }) // Capturar errores
              .catch(error => {
                console.error('Error detallado:', error);
                alert('Error al cargar los médicos: ' + error.message);
              });
          } else if (optionSelect === 'especialidad') {
            optionField.style.display = 'block';
            fetch('getEspecialidades.php')  // Updated path
              .then(response => {
                if (!response.ok) {
                  return response.json().then(err => {
                    throw new Error(err.error || 'Error del servidor');
                  });
                }
                return response.json();
              })
              .then(data => {
                if (!Array.isArray(data)) {
                  throw new Error('Formato de datos inválido');
                } // Actualizar el campo de selección con las especialidades
                const optionValue = document.getElementById('optionvalue');
                optionValue.innerHTML = '<option value="">Seleccionar...</option>';
                data.forEach(especialidad => { // Iterar sobre las especialidades
                  const option = document.createElement('option');
                  option.value = especialidad.especialidad;
                  option.textContent = especialidad.especialidad;
                  optionValue.appendChild(option);
                });
              })
              .catch(error => {
                console.error('Error detallado:', error);
                alert('Error al cargar las especialidades: ' + error.message);
              });
          }
        } else { // Ocultar el campo de selección si no se ha seleccionado una opción
          optionField.style.display = 'none';
        }
      });
      // Manejar el envío del formulario
      document.getElementById('appointmentForm').addEventListener('submit', function (event) {
        event.preventDefault();
        const opcion = document.getElementById('optionSelect').value;
        const valorOpcion = document.getElementById('optionvalue').value;
        const date = document.getElementById('dateSelect').value;
        const time = document.getElementById('timeSelect').value;
        let body = JSON.stringify({
          opcion: opcion,
          valorOpcion: valorOpcion,
          fecha: date,
          hora: time
        }); // Enviar solicitud para obtener los médicos disponibles
        fetch('getAvailableDoctors.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: body
        }).then(response => response.json())
          .then(data => {
            // Mostrar los médicos disponibles
            const availableDoctors = document.getElementById('availableDoctors');
            availableDoctors.innerHTML = '';
            if (data.length > 0) {
              data.forEach(doctor => {
                const card = document.createElement('div');
                card.className = 'col-md-4';
                card.innerHTML = `
                              <div class="card mb-4">
                                  <div class="card-body">
                                      <h5 class="card-title">${doctor.nombres}</h5>
                                      <p class="card-text">Especialidad: ${doctor.especialidad}</p>
                                      <p class="card-text">Fecha: ${doctor.fecha}</p>
                                      <p class="card-text">Hora: ${time}</p>
                                      <button class="btn btn-primary assign-btn" data-doctor-id="${doctor.id}">Asignar Cita</button>
                                  </div>
                              </div>
                          `;
                availableDoctors.appendChild(card);
              });
              // Asignar eventos de clic a los botones de asignación
              document.querySelectorAll('.assign-btn').forEach(button => {
                button.addEventListener('click', function (event) {
                  const doctorId = this.getAttribute('data-doctor-id');
                  let patientId;
                  <?php if ($_SESSION['user_rol'] === 'administrador') { ?>
                    patientId = <?php echo $_GET['id']; ?>;
                  <?php } else { ?>
                    patientId = <?php echo $_SESSION['user_id']; ?>;
                  <?php } ?>
                  const correo = "<?php echo $_SESSION['user_correo']; ?>";
                  let body = JSON.stringify({
                    opcion: opcion,
                    valorOpcion: valorOpcion,
                    patientId: patientId,
                    doctorId: doctorId,
                    fecha: date,
                    hora: time
                  }); // Enviar solicitud para asignar la cita
                  fetch('assignAppointment.php', {
                    method: 'POST',
                    headers: {
                      'Content-Type': 'application/json'
                    },
                    body: body
                  }).then(response => response.json())
                    .then(data => {
                      if (data.status === 'success') {
                        // Mostrar mensaje de éxito y recargar la página
                        Swal.fire({
                          icon: 'success',
                          title: 'Cita Asignada',
                          text: `Email de recordatorio enviado a: ${correo}`,
                          confirmButtonText: 'Aceptar'
                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                location.reload(); // Recargar la página
                                            }
                                        });  
                      } else {
                        alert(data.message);
                      } // Capturar errores
                    });
                });
              });
            } else {
              availableDoctors.innerHTML = '<p>No hay médicos disponibles para la fecha y hora seleccionadas.</p>';
            }
          })
          .catch(error => console.error('Error:', error));
      });
    });
  </script>
</body>

</html>