<?php
include 'conexion.php';
session_start();
// PREGUNTA SI HAY UN USUARIO REGISTRADO
if (!isset($_SESSION['usuario'])) {
  header('Location: inicioSesion.php');
}
$rolString = "";

$idCliente = $_SESSION['idCliente'];
//SELECT PARA VERIFICAR ROL POR LAS DUDAS NOA ACTUALIZA EL DE LA VARIABLE SESSION
$sql2 = "SELECT * FROM usuario WHERE idCliente='$idCliente' ";
$res2 = mysqli_query($conexion, $sql2);
if ($row2 = $res2->fetch_assoc()) {
  $rol = $row2['rol'];
}
if ($rol == 0) {
  //ROL: CLIENTE
  //SQL1: EXTRAER INFORMACIÓN DE CLIENTE / FLETERO
  $sql1 = "SELECT * FROM cliente WHERE idCliente='$idCliente' ";
  $res1 = mysqli_query($conexion, $sql1);
  if ($row1 = $res1->fetch_assoc()) {
    //DATOS CLIENTE
    $nombreCliente = $row1['nombreCliente'];
    $apellidoCliente = $row1['apellidoCliente'];
    $correoCliente = $row1['correoCliente'];
    $dniCliente = $row1['dniCliente'];
    $domicilioCliente = $row1['domicilioCliente'];
    $telefonoCliente = $row1['telefonoCliente'];
    $fechaNacCliente = $row1['fechaNacCliente'];
    $sexoCliente = $row1['sexoCliente'];
    if ($sexoCliente == 0) {
      $sexoCliente = 'Hombre';
    } elseif ($sexoCliente == 1) {
      $sexoCliente = 'Mujer';
    } else {
      $sexoCliente = 'No Binario';
    }
    $fechaRegCliente = $row1['fechaRegCliente'];
    $eliminadoCliente = $row1['eliminadoCliente'];

    //VARIABLE ROL
    $rolString = 'Cliente';

    //SQL3: OBTENER DATOS DE USUARIO
    $sql3 = "SELECT * FROM usuario WHERE idCliente=$idCliente ";
    $res3 = mysqli_query($conexion, $sql3);
    if ($row3 = $res3->fetch_assoc()) {
      $usuario = $row3['usuario'];
      $contraseña = $row3['contraseña'];
    }
  }
} elseif ($rol == 1) {
  //ROL: FLETERO
  //SQL1: EXTRAER INFORMACIÓN DE CLIENTE / FLETERO
  $sql1 = "SELECT * FROM cliente c INNER JOIN fletero f WHERE c.idCliente=f.idCliente AND c.idCliente='$idCliente' ";
  $res1 = mysqli_query($conexion, $sql1);
  if ($row1 = $res1->fetch_assoc()) {
    //DATOS CLIENTE
    $nombreCliente = $row1['nombreCliente'];
    $apellidoCliente = $row1['apellidoCliente'];
    $correoCliente = $row1['correoCliente'];
    $dniCliente = $row1['dniCliente'];
    $domicilioCliente = $row1['domicilioCliente'];
    $telefonoCliente = $row1['telefonoCliente'];
    $fechaNacCliente = $row1['fechaNacCliente'];
    $sexoCliente = $row1['sexoCliente'];
    $eliminadoCliente = $row1['eliminadoCliente'];
    if ($sexoCliente == 0) {
      $sexoCliente = 'Hombre';
    } elseif ($sexoCliente == 1) {
      $sexoCliente = 'Mujer';
    } else {
      $sexoCliente = 'No Binario';
    }
    $fechaRegCliente = $row1['fechaRegCliente'];

    //DATOS FLETERO
    $idFletero = $row1['idFletero'];
    $descripcionFletero = $row1['descripcionFletero'];
    $carnetFletero = $row1['carnetFletero'];
    $cedulaFletero = $row1['cedulaFletero'];
    $fechaRegFletero = $row1['fechaRegFletero'];
    $eliminadoFletero = $row1['eliminadoFletero'];

    //OBTENGO IMAGEN FLETERO
    $imgFletero = $row1['imagenFletero'];
    //VARIABLE ROL
    $rolString = 'Fletero';

    //SQL3: OBTENER DATOS DE USUARIO
    $sql3 = "SELECT * FROM usuario WHERE idCliente=$idCliente ";
    $res3 = mysqli_query($conexion, $sql3);
    if ($row3 = $res3->fetch_assoc()) {
      $usuario = $row3['usuario'];
      $contraseña = $row3['contraseña'];
    }
  }
} elseif ($rol0 = 2) {
  //ROL: ADMINISTRADOR
  //SQL1: EXTRAER INFORMACIÓN DE CLIENTE / FLETERO
  $sql1 = "SELECT * FROM cliente c  WHERE c.idCliente='$idCliente' ";
  $res1 = mysqli_query($conexion, $sql1);
  if ($row1 = $res1->fetch_assoc()) {
    //DATOS CLIENTE
    $nombreCliente = $row1['nombreCliente'];
    $apellidoCliente = $row1['apellidoCliente'];
    $correoCliente = $row1['correoCliente'];
    $dniCliente = $row1['dniCliente'];
    $domicilioCliente = $row1['domicilioCliente'];
    $telefonoCliente = $row1['telefonoCliente'];
    $fechaNacCliente = $row1['fechaNacCliente'];
    $sexoCliente = $row1['sexoCliente'];
    $eliminadoCliente = $row1['eliminadoCliente'];
    if ($sexoCliente == 0) {
      $sexoCliente = 'Hombre';
    } elseif ($sexoCliente == 1) {
      $sexoCliente = 'Mujer';
    } else {
      $sexoCliente = 'No Binario';
    }
    $fechaRegCliente = $row1['fechaRegCliente'];


    //VARIABLE ROL
    $rolString = 'Admin';

    //SQL3: OBTENER DATOS DE USUARIO
    $sql3 = "SELECT * FROM usuario WHERE idCliente=$idCliente ";
    $res3 = mysqli_query($conexion, $sql3);
    if ($row3 = $res3->fetch_assoc()) {
      $usuario = $row3['usuario'];
      $contraseña = $row3['contraseña'];
    }
  }
}

//CAMBIAR USUARIO Y CONTRASEÑA
if (isset($_POST['submit'])) {
  $estado = 0;
  if ((isset($_POST['usuarioNuevo'])) && (isset($_POST['contraseñaNueva'])) && ($_POST['usuarioNuevo'] != $usuario) && ($_POST['contraseñaNueva'] != $contraseña)) {
    //VERIFICO QUE NO EXISTA OTRO USUARIO CON LOS MISMOS VALORES
    //SQL5: SELECT A TABLA USUARIO
    $sql5 = "SELECT * FROM usuario";
    $res5 = mysqli_query($conexion, $sql5);
    while ($row5 = $res5->fetch_assoc()) {
      if (($row5['usuario'] == $_POST['usuarioNuevo'] && $row5['contraseña'] == $_POST['contraseñaNueva']) || ($row5['usuario'] == $_POST['usuarioNuevo'])) {
?>
        <script>
          alert("Vuelva a intentar...");
        </script>
      <?php
        $estado = 1;
      }
    }
    if ($estado == 0) {
      $usuarioNuevo = $_POST['usuarioNuevo'];
      $contraseñaNueva = $_POST['contraseñaNueva'];

      //SQL4: UPDATE A BD PARA MODIFICAR CONTRASEÑA Y USUARIO
      $sql4 = "UPDATE usuario SET usuario='$usuarioNuevo', contraseña='$contraseñaNueva' WHERE idCliente=$idCliente ";
      $res4 = mysqli_query($conexion, $sql4);
    }
    if ($res4) {
      ?>
      <script>
        //pausar por 2 segundos
        setTimeout(function() {
          alert("Contraseña modificada con éxito.");
        }, 2000);
      </script>
    <?php
      //cerrar sesion
      header("Location: cerrar-sesion.php");
    }
  } else {
    ?>
    <script>
      alert("Vuelva a intentar...");
    </script>
<?php
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
  <br>
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


  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <?php include("./template/header.php") ?>

  <!-- ======= Sidebar ======= -->
  <?php if ($rol == 2) {
    include("./template/adminNav.php");
  } else if ($rol == 1) {
    include("./template/fleteroNav.php");
  } else {
    include("./template/clienteNav.php");
  }
  ?>

  <main id="main" class="main">



    <section class="section dashboard" style="padding-top: 0;">
      <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
          <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
              <img class="rounded-circle mt-5" width="150px" height="150px" src="<?php if ($rol == 1) {
                                                                                    echo $imgFletero;
                                                                                  } else {
                                                                                    echo 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg';
                                                                                  } ?>" alt="Imagen de perfil">
              <span class="font-weight-bold"><?php echo $apellidoCliente . " " . $nombreCliente ?></span>
              <span class="" style="color: #645CAA;">(<?php echo $rolString ?>)</span>
            </div>
          </div>
          <div class="col-md-5 border-right">
            <div class="p-3 py-5">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-right" style="color: black;">Información del Perfil</h4>
              </div>
              <div class="row mt-2">
                <div class="col-md-6"><label class="labels">Nombre</label><input disabled type="text" class="form-control" value="<?php echo $nombreCliente ?>" placeholder="nombre"></div>
                <div class="col-md-6"><label class="labels">Apellido</label><input disabled type="text" class="form-control" value="<?php echo $apellidoCliente ?>" placeholder="apellido"></div>
              </div>
              <div class="row mt-2">
                <div class="col-md-12"><label class="labels">Correo Electronico</label><input disabled type="email" class="form-control" value="<?php echo $correoCliente ?>" placeholder="correo"></div>
              </div>
              <div class="row mt-2">
                <div class="col-md-6"><label class="labels">DNI</label><input disabled type="number" class="form-control" value="<?php echo $dniCliente ?>" placeholder="dni"></div>
                <div class="col-md-6"><label class="labels">Telefono</label><input disabled type="number" class="form-control" value="<?php echo $telefonoCliente ?>" placeholder="telefono"></div>
              </div>
              <div class="row mt-2">
                <div class="col-md-12"><label class="labels">Domicilio</label><input disabled type="text" class="form-control" value="<?php echo $domicilioCliente ?>" placeholder="domicilio"></div>
              </div>
              <div class="row mt-2">
                <div class="col-md-6"><label class="labels">Fecha de Nacimiento</label><input disabled type="date" class="form-control" value="<?php echo $fechaNacCliente ?>" placeholder="fecha nacimiento"></div>
                <div class="col-md-6"><label class="labels">Sexo</label><input disabled type="text" class="form-control" value="<?php echo $sexoCliente ?>" placeholder="sexo"></div>
              </div>
              <div class="row mt-2">
                <?php
                if ($eliminadoCliente == 0) {
                  $eliminadoCliente = 'ACTIVO';
                } else {
                  $eliminadoCliente = 'ELIMINADO';
                }
                ?>
                <div class="col-md-6"><label class="labels">Fecha de Registro</label><input disabled type="date" class="form-control" value="<?php echo $fechaRegCliente ?>" placeholder="fecha registro"></div>
                <div class="col-md-6"><label class="labels">Estado</label><input disabled type="text" <?php if ($eliminadoCliente == 'ACTIVO') { ?> style="color: green" <?php echo '';
                                                                                                                                                                        } else { ?> style="color: red" <?php echo '';
                                                                                                                                                                                                      } ?> class="form-control" value="<?php echo $eliminadoCliente ?>" placeholder="estado"></div>

              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="p-3 py-5">
              <?php
              if ($rol == 0 || $rol == 1) {
              ?>
                <form method="POST" novalidate>
                <?php
              }
                ?>
                <div class="d-flex justify-content-between align-items-center experience"><span>Información de Usuario</span></div><br>
                <div class="col-md-12"><label class="labels">Nombre de Usuario</label><input type="text" id="usuarioNuevo" name="usuarioNuevo" class="form-control" placeholder="usuario" value="<?php echo $usuario ?>"></div> <br>
                <div class="col-md-12">
                  <label class="labels">Contraseña</label>
                  <div class="input-group">
                    <input type="password" id="contraseñaNueva" name="contraseñaNueva" class="form-control" placeholder="contraseña" value="<?php echo $contraseña ?>">
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                      <i class="bi bi-eye"></i>
                    </button>
                  </div>
                </div>
                <div class="col-md-12"><label class="labels" style="color: red;">Al guardar los cambios deberás iniciar sesión de nuevo.</label></div>
                <div class="mt-5 text-center"><button class="btn btn-primary profile-button" value="submit" name="submit" id="submit" type="submit">Editar</button></div>
                </form>
            </div>
          </div>
        </div>

      </div>




    </section>
  </main><!-- End #main -->
  <footer class="text-white" style="background-color: #645CAA; color: #ffffff; display: flex; justify-content: space-between; ">
    <div class="d-flex align-items-center">
      <!-- Section: Social media -->
      <section style="padding: 0px; display: flex; align-items: center;">
        <!-- Facebook -->
        <a class="btn btn-link btn-floating btn-lg text-dark m-1" href="#!" role="button" data-mdb-ripple-color="dark"><i style="color: #ffffff;" class="bi bi-facebook"></i></a>

        <!-- Twitter -->
        <a class="btn btn-link btn-floating btn-lg text-dark m-1" href="#!" role="button" data-mdb-ripple-color="dark"><i style="color: #ffffff;" class="bi bi-twitter"></i></a>

        <!-- Instagram -->
        <a class="btn btn-link btn-floating btn-lg text-dark m-1" href="#!" role="button" data-mdb-ripple-color="dark"><i style="color: #ffffff;" class="bi bi-instagram"></i></a>

        <!-- Linkedin -->
        <a class="btn btn-link btn-floating btn-lg text-dark m-1" href="#!" role="button" data-mdb-ripple-color="dark"><i style="color: #ffffff;" class="bi bi-linkedin"></i></a>
      </section>
      <!-- Section: Social media -->
    </div>

    <div class="text-end p-3">
      © 2023 Copyright:
      <a style="color: #ffffff;" class="text-white" href="#">Company, Inc. All rights reserved.</a>
    </div>
  </footer>

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
<script>
  var togglePassword = document.getElementById("togglePassword");
  var contraseñaNueva = document.getElementById("contraseñaNueva");

  togglePassword.addEventListener("click", function() {
    if (contraseñaNueva.type === "password") {
      contraseñaNueva.type = "text";
      togglePassword.innerHTML = '<i class="bi bi-eye-slash"></i>';
    } else {
      contraseñaNueva.type = "password";
      togglePassword.innerHTML = '<i class="bi bi-eye"></i>';
    }
  });
</script>