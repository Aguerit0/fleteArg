<?php
include 'conexion.php';
session_start();
// PREGUNTA SI HAY UN USUARIO REGISTRADO
if (!isset($_SESSION['usuario'])) {
  header('Location: inicioSesion.php');
}
//traigo id servicio de la pantalla anterior
$idServicio = $_GET['id'];
//consulta para traer datos del servicio
$sqlServ = "SELECT * FROM servicio WHERE idServicio=$idServicio";
$resServ = mysqli_query($conexion, $sqlServ);
if ($rowSer = $resServ->fetch_assoc()) {
  $precioServicio = $rowSer['precioServicio'];
  $metodoPagoServicio = $rowSer['metodoPagoServicio'];
  $fechaSalidaServicio = $rowSer['fechaSalidaServicio'];
  $fechaLlegadaServicio = $rowSer['fechaLlegadaServicio'];
  $estadoServicio = $rowSer['estadoServicio'];
  $ubicacionSalidaServicio = $rowSer['ubicacionSalidaServicio'];
  $ubicacionLlegadaServicio = $rowSer['ubicacionLlegadaServicio'];
  $distanciaServicio = $rowSer['distanciaServicio'];
  $tiempoServicio = $rowSer['tiempoServicio'];
  $idClienteServicio = $rowSer['idCliente'];
  $descripcionServicio = $rowSer['descripcionServicio'];
  $idFleteroServicio = $rowSer['idFletero'];
  $idVehiculoServicio = $rowSer['idVehiculo'];
}

$idCliente = $_SESSION['idCliente'];
$eliminadoCliente = 0;
$contadorWhile = 0;
//SELECT PARA VERIFICAR ROL POR LAS DUDAS NO ACTUALIZA EL DE LA VARIABLE SESSION
$sql2 = "SELECT * FROM usuario WHERE idCliente='$idCliente' ";
$res2 = mysqli_query($conexion, $sql2);
if ($row2 = $res2->fetch_assoc()) {
  $rol = $row2['rol'];
}
if ($rol != 2) {
  //mover al inicio de sesion y cerrar sesion
} else if ($rol == 2) {
  //consultar datos
  //EXTRAER ID 
  $idUsuario = $_GET['id'];
  //consulta para extraer todos los datos de ese usuario de nuevo
  $sqlUsu = "SELECT * FROM usuario WHERE idUsuario=$idUsuario";
  $resUsu = mysqli_query($conexion, $sqlUsu);
  if ($rowUsu = $resUsu->fetch_assoc()) {
    $idUsuario = $rowUsu['idUsuario'];
    $usuario = $rowUsu['usuario'];
    $contraseña = $rowUsu['contraseña'];
    $rol = $rowUsu['rol'];
    $eliminado = $rowUsu['eliminado'];
    $idCliente = $rowUsu['idCliente'];
  }
}
if (isset($_POST['guardar'])) {
  $usuario = $_POST['inputUsuario'];
  $contraseña = $_POST['inputContraseña'];
  $rol = $_POST['inputRol'];
  $eliminado = $_POST['inputEliminado'];
  $idCliente = $_POST['inputIdCliente'];
  $idUsuario = $_POST['inputIdUsuario'];

  $sqlUpdate = "UPDATE usuario SET usuario='$usuario', contraseña='$contraseña', rol='$rol', eliminado='$eliminado', idCliente='$idCliente' WHERE idUsuario='$idUsuario'";
  mysqli_query($conexion, $sqlUpdate);
?>
  <script>
    if (confirm("Usuario modificado con éxito!! ¿Desea ir a otra página?")) {
      window.location.href = "otraPagina.php";
    } else {
      window.location.href = "adminUsuarios.php";
    }
  </script>
<?php
  exit;
  sleep(3);
  header('Location: adminUsuarios.php');
}


//CONSULTA
//$sql2 = "SELECT SQL_CALC_FOUND_ROWS * FROM cliente c INNER JOIN fletero f WHERE (c.eliminadoCliente<1) AND (f.eliminadoFletero<1) AND (c.idCliente=f.idCliente) AND (nombreCliente LIKE '%$campo%' OR apellidoCliente LIKE '%$campo%') ORDER BY f.puntajeFletero DESC";
//


//consulta boton confirmar -> update datos servicio
if (isset($_POST['confirmar'])) {
  // Recupera los datos del formulario
  $precioServicio = $_POST['precioServicio'];
  $metodoPagoServicio = $_POST['metodoPagoServicio'];
  $fechaSalidaServicio = $_POST['fechaSalidaServicio'];
  $fechaLlegadaServicio = $_POST['fechaLlegadaServicio'];
  $ubicacionSalidaServicio = $_POST['ubicacionSalidaServicio'];
  $ubicacionLlegadaServicio = $_POST['ubicacionLlegadaServicio'];
  $distanciaServicio = $_POST['distanciaServicio'];
  $tiempoServicio = $_POST['tiempoServicio'];
  $estadoServicio = $_POST['estadoServicio'];
  $descripcionServicio = $_POST['descripcionServicio'];
  $idServicio = $_POST['idServicio'];
  $idClienteServicio = $_POST['idCliente'];
  $idFleteroServicio = $_POST['idFletero'];
  $idVehiculoServicio = $_POST['idVehiculo'];

  // Consulta SQL para actualizar los datos en la tabla
  $consulta = "UPDATE servicio SET 
      precioServicio = '$precioServicio',
      metodoPagoServicio = '$metodoPagoServicio',
      fechaSalidaServicio = '$fechaSalidaServicio',
      fechaLlegadaServicio = '$fechaLlegadaServicio',
      ubicacionSalidaServicio = '$ubicacionSalidaServicio',
      ubicacionLlegadaServicio = '$ubicacionLlegadaServicio',
      distanciaServicio = '$distanciaServicio',
      tiempoServicio = '$tiempoServicio',
      estadoServicio = '$estadoServicio',
      descripcionServicio = '$descripcionServicio'
  WHERE idServicio = $idServicio";

  if ($conexion->query($consulta) === TRUE) {
    echo "Datos actualizados con éxito.";
    header('Location: adminServicios.php');
  } else {
    echo "Error al actualizar los datos: " . $conexion->error;
  }
  $conexion->close();
}

//consulta boton eliminar
if (isset($_POST['confirmarModal'])) {
  $sqlEliminar = "DELETE FROM servicio WHERE idServicio=$idServicio";
  if ($conexion->query($sqlEliminar) == true) {
    echo "Registro eliminado con éxito.";
    header('Location: adminServicios.php');
  } else {
    echo "Error al eliminar el registro.";
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

  <!-- Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Preview Image -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

  <!-- SCRIPTS JS-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


  <link href="assets/css/style.css" rel="stylesheet">


</head>

<body>

  <!-- ======= Header ======= -->
  <?php include("template/header.php") ?>

  <!-- ======= Sidebar ======= -->
  <?php if ($_SESSION['rol'] == 2) {
    include("./template/adminNav.php");
  } else if ($_SESSION['rol'] == 1) {
    include("./template/fleteroNav.php");
  } else {
    include("./template/clienteNav.php");
  }
  ?>



  <main style="padding-top: 50px;" id="main" class="main">
    <div class="container">
      <div class="card">
        <div class="card-body">
          <h2 class="card-tittle">Editar Servicio</h2>
          <br>
          <form method="POST" novalidate>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="precioServicio">Precio</label>
                  <input type="text" class="form-control" id="precioServicio" name="precioServicio" value="<?php echo $precioServicio ?>">
                </div>

              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="metodoPagoServicio">Método de Pago</label>
                  <input type="text" class="form-control" id="metodoPagoServicio" name="metodoPagoServicio" value="<?php echo $metodoPagoServicio ?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="fechaSalidaServicio">Fecha de Salida</label>
                  <input type="text" class="form-control" id="fechaSalidaServicio" name="fechaSalidaServicio" value="<?php echo $fechaSalidaServicio ?>">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="fechaLlegadaServicio">Fecha de Llegada</label>
                  <input type="text" class="form-control" id="fechaLlegadaServicio" name="fechaLlegadaServicio" value="<?php echo $fechaLlegadaServicio ?>">
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="ubicacionSalidaServicio">Ubicación de Salida</label>
                  <input type="text" class="form-control" id="ubicacionSalidaServicio" name="ubicacionSalidaServicio" value="<?php echo $ubicacionSalidaServicio ?>">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="ubicacionLlegadaServicio">Ubicación de Llegada</label>
                  <input type="text" class="form-control" id="ubicacionLlegadaServicio" name="ubicacionLlegadaServicio" value="<?php echo $ubicacionLlegadaServicio ?>">
                </div>
              </div>

            </div>

            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="distanciaServicio">Distancia</label>
                  <input type="text" class="form-control" id="distanciaServicio" name="distanciaServicio" value="<?php echo $distanciaServicio ?>">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="tiempoServicio">Tiempo</label>
                  <input type="text" class="form-control" id="tiempoServicio" name="tiempoServicio" value="<?php echo $tiempoServicio ?>">
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="estadoServicio">Estado</label>
                  <input type="text" class="form-control" id="estadoServicio" name="estadoServicio" value="<?php echo $estadoServicio ?>">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="descripcionServicio">Descripción</label>
                  <input type="text" class="form-control" id="descripcionServicio" name="descripcionServicio" value="<?php echo $descripcionServicio ?>">
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="idServicio">ID Servicio</label>
                  <input type="text" class="form-control" id="idServicio" name="idServicio" value="<?php echo $idServicio ?>">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="idCliente">ID Cliente</label>
                  <input type="text" class="form-control" id="idCliente" name="idCliente" value="<?php echo $idClienteServicio ?>">
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="idFletero">ID Fletero</label>
                  <input type="text" class="form-control" id="idFletero" name="idFletero" value="<?php echo $idFleteroServicio ?>">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="idVehiculo">ID idVehiculo</label>
                  <input type="text" class="form-control" id="idVehiculo" name="idVehiculo" value="<?php echo $idVehiculoServicio ?>">
                </div>
              </div>

            </div>
            <br>
            <div class="row">
              <div class="col-6 text-start">
              </div>
              <div class="col-6 text-end">
                <button type="button" id="eliminar" name="eliminar" class="btn btn-danger" data-toggle="modal" data-target="#confirmacionModal">Eliminar</button>


                <button type="submit" id="confirmar" name="confirmar" class="btn btn-success">Confirmar</button>
              </div>
              <div class="modal fade" id="confirmacionModal" tabindex="-1" role="dialog" aria-labelledby="confirmacionModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="confirmacionModalLabel">Confirmación</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      ¿Estás seguro de que deseas eliminar este elemento?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                      <button type="submit" id="confirmarModal" name="confirmarModal" class="btn btn-danger">Confirmar</button>
                    </div>
                  </div>
                </div>
              </div>

            </div>

          </form>
        </div>
      </div>
    </div>
  </main>




  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>