<?php
  require_once "conexion.php";
  $error = "";//variable para almacenar error
  if (isset($_POST['submit'])){
    if (!isset($_POST['usuario']) && !isset($_POST['contraseña']) && !isset($_POST['nombre']) && !isset($_POST['apellido']) && !isset($_POST['correo']) && !isset($_POST['dni']) && !isset($_POST['domicilio']) && !isset($_POST['telefono']) && !isset($_POST['fechaNac']) && !isset($_POST['sexo']))
    {
      $error = "Debe completar todos los campos del formulario.";
    }else{
      // CREAMOS USUARIO Y CONTRASEÑA
      $usuario = $_POST['usuario'];
      $contraseña = $_POST['contraseña'];
      $rol=0;//rol=0 -> cliente
      $eliminado=0;//eliminado=0 -> activo

      //CREAMOS DATOS DEL USUARIO
        $nombreCliente = $_POST['nombre'];
        $apellidoCliente = $_POST['apellido'];
        $correoCliente = $_POST['correo'];
        $dniCliente = $_POST['dni'];
        $domicilioCliente = $_POST['domicilio'];
        $telefonoCliente = $_POST['telefono'];
        $fechaNacCliente = $_POST['fechaNac'];
        $sexoCliente = $_POST['sexo'];
        $eliminadoCliente = 0;


        // VERIFICO QUE NO EXISTA PERSONA CON MISMO DNI
        $sql3 = "SELECT * FROM cliente WHERE dniCliente=$dniCliente";
        $res3 = mysqli_query($conexion, $sql3);
        if (mysqli_num_rows($res3)>0) {
            ?>
            <script>
              alertk("Ya existe un usuario registrado con este DNI");
            </script>
            <?php
            sleep(3);
            header('location: registrarse.php');
        }else{


          //SQL1: INSERTAR CLIENTE
        $sql1 = "INSERT INTO cliente(nombreCliente, apellidoCliente, correoCliente, dniCliente, domicilioCliente, telefonoCliente, fechaNacCliente, sexoCliente, fechaRegCliente, eliminadoCliente) VALUES('$nombreCliente', '$apellidoCliente', '$correoCliente', '$dniCliente', '$domicilioCliente', '$telefonoCliente', '$fechaNacCliente', '$sexoCliente', NOW(), '$eliminadoCliente' )";
        $res1 = mysqli_query($conexion, $sql1);

        //SQL2: OBTENEMOS 'idCliente' PARA TABLA USUARIO
        $sql2 = "SELECT idCliente FROM cliente WHERE dniCliente='$dniCliente'";
        $res2 = mysqli_query($conexion,$sql2);
        if($row2 = $res2->fetch_assoc()){
          $idCliente = $row2['idCliente'];
        }
        //SQL3: INSERTAR USUARIO
        $sql3 = "INSERT INTO usuario(usuario, contraseña, rol, eliminado, idCliente) VALUES('$usuario', '$contraseña', '$rol', '$eliminado', '$idCliente' )";
        $res3 = mysqli_query($conexion,$sql3);
        $var = "Registro Exitoso !!";
        echo "<script> alert('".$var."');</script>";
        sleep(3);
        header('location: inicioSesion.php');

        //ERRORES
        if(!$res3 || !$res2 || (!$res3 && !$res2)){
          ?>
          <script>
            alert('Error al registrarse, vuelva a inentar !!');
          </script>
          <?php
          sleep(3);
          header('location: registrarse.php'); //
        }
        }
    }
  }



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>FleteAr</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link rel="icon" type="image/jpeg" href="../images/logoFletear.png" />

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  
</head>

<body>

  <main>
    <!-- Header -->
    <header id="header2">
					<h1 style="color: white;" id="logo"><a style="color: white;" href="../html/index.html">FleteAr</a></h1>
					<nav id="nav">
						<ul>
							<li><a href="../html/index.html">Inicio</a></li>
							<li>
								<a href="#">Información</a>
								<ul>
									<li><a href="../html/serFletero.html">Ser fletero</a></li>
									<li><a href="../html/quienesSomos.html">¿Quienes somos?</a></li>
									<li><a href="#">Ultimas noticias</a></li>
								</ul>
							</li>
							<li><a href="../html/contacto.php">Contacto</a></li>
							<li><a style="padding: 0px;" href="inicioSesion.php" class="button primary">Ingresar</a></li>
						</ul>
					</nav>
				</header>
        <br>
    <div class="container">
<br>
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-9 col-md-9 d-flex flex-column align-items-center justify-content-center">
              <div class="card mb-3 pb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Registrarse</h5>
                    <p class="text-center small">Ingrese su información personal en el formulario</p>
                  </div>

                  <form class="row g-3 needs-validation" method="POST" novalidate>

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Nombre</label>
                      <div class="input-group has-validation">
                        <input type="text" name="nombre" class="form-control" id="nombre" required placeholder="example">
                        <div class="invalid-feedback">Ingrese su nombre</div>
                      </div>
                    </div>

                    <div class="col-6">
                      <label for="apellido" class="form-label">Apellido</label>
                      <input type="text" name="apellido" class="form-control" id="apellido" required placeholder="example">
                      <div class="invalid-feedback">Ingrese su apellido.</div>
                    </div>
                    <div class="col-6">
                      <label for="usuario" class="form-label">Usuario</label>
                      <input type="text" name="usuario" class="form-control" id="usuario" required placeholder="user">
                      <div class="invalid-feedback">Ingrese su usuario.</div>
                    </div>
                    <div class="col-6">
                      <label for="contraseña" class="form-label">Contraseña</label>
                      <input type="password" name="contraseña" class="form-control" id="contraseña" required placeholder="**********">
                      <div class="invalid-feedback">Ingrese su contraseña.</div>
                    </div>
                    <div class="col-6">
                      <label for="correo" class="form-label">Correo Electronico</label>
                      <input type="mail" name="correo" class="form-control" id="correo" required placeholder="example@example.com">
                      <div class="invalid-feedback">Ingrese su correo.</div>
                    </div>
                    <div class="col-6">
                      <label for="dni" class="form-label">DNI</label>
                      <input type="number" name="dni" class="form-control" id="dni" required placeholder="11111111">
                      <div class="invalid-feedback">Ingrese su dni.</div>
                    </div>
                    <div class="col-6">
                      <label for="domicilio" class="form-label">Domicilio</label>
                      <input type="text" name="domicilio" class="form-control" id="domicilio" required placeholder="">
                      <div class="invalid-feedback">Ingrese su domicilio.</div>
                    </div>
                    <div class="col-6">
                      <label for="telefono" class="form-label">Telefono</label>
                      <input type="number" name="telefono" class="form-control" id="telefono" required placeholder="+54 XXXX XXXXXX">
                      <div class="invalid-feedback">Ingrese su telefono.</div>
                    </div>
                    <div class="col-6">
                      <label for="fechaNac" class="form-label">Fecha de Nacimiento</label>
                      <input type="date" name="fechaNac" class="form-control" id="fechaNac" required>
                      <div class="invalid-feedback">Ingrese su fecha de nacimiento.</div>
                    </div>
                    <div class="col-6">
                      <label for="sexo" class="form-label">Sexo</label>
                      <select require name="sexo" id="sexo" class="form-select">
                      <option value="">Seleccionar</option>
                      <option value="0">Hombre</option>
                      <option value="1">Mujer</option>
                      <option value="2">No Binario</option>
                      </select>
                      <div class="invalid-feedback">Ingrese su sexo.</div>
                    </div>
                    

                    <div class="col-12 d-flex align-items-center justify-content-center">
                      <div style='color:red'>
                        <?php
                       
                          echo $error;
                        ?> 
                        </div>
                    </div>
                    <div class="col-12 d-flex align-items-center justify-content-center">
                      <button class="btn btn-primary w-50" type="submit" name="submit">Registrarse</button>
                    </div>
                    <div class="col-12 d-flex align-items-center justify-content-center mt-3">
                  <p class="text-center small">¿Ya tienes una cuenta? <a style="color: blue;" href="inicioSesion.php">Inicia sesión aquí</a></p>
                </div>
                  </form>

                </div>
              </div>
            </div>

          </div>
        </div>
    </div>

    </section>

    </div>
    <footer class="text-white" style="background-color: #645CAA; color: #ffffff; display: flex; justify-content: space-between; ">
  <div class="d-flex align-items-center">
    <!-- Section: Social media -->
    <section style="padding: 0px; display: flex; align-items: center;">
      <!-- Facebook -->
      <a
        class="btn btn-link btn-floating btn-lg text-dark m-1"
        href="#!"
        role="button"
        data-mdb-ripple-color="dark"
        ><i style="color: #ffffff;" class="bi bi-facebook"></i
      ></a>

      <!-- Twitter -->
      <a
        class="btn btn-link btn-floating btn-lg text-dark m-1"
        href="#!"
        role="button"
        data-mdb-ripple-color="dark"
        ><i style="color: #ffffff;" class="bi bi-twitter"></i
      ></a>

      <!-- Instagram -->
      <a
        class="btn btn-link btn-floating btn-lg text-dark m-1"
        href="#!"
        role="button"
        data-mdb-ripple-color="dark"
        ><i style="color: #ffffff;" class="bi bi-instagram"></i
      ></a>

      <!-- Linkedin -->
      <a
        class="btn btn-link btn-floating btn-lg text-dark m-1"
        href="#!"
        role="button"
        data-mdb-ripple-color="dark"
        ><i style="color: #ffffff;" class="bi bi-linkedin"></i
      ></a>
    </section>
    <!-- Section: Social media -->
  </div>

  <div class="text-end p-3">
    © 2023 Copyright:
    <a style="color: #ffffff;" class="text-white" href="#">Company, Inc. All rights reserved.</a>
  </div>
</footer>

  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>