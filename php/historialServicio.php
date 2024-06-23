<?php
include 'conexion.php';
session_start();
// PREGUNTA SI HAY UN USUARIO REGISTRADO
if (!isset($_SESSION['usuario'])) {
  header('Location: inicioSesion.php');
}

$idCliente = $_SESSION['idCliente'];
//SELECT PARA VERIFICAR ROL POR LAS DUDAS NO ACTUALIZA EL ID DE LA VARIABLE SESSION
$sql2 = "SELECT * FROM usuario WHERE idCliente='$idCliente' ";
$res2 = mysqli_query($conexion, $sql2);
if ($row2 = $res2->fetch_assoc()) {
  $rol = $row2['rol'];
}
if ($rol == 0) {
  //ROL: CLIENTE
  $sql2 = "SELECT * FROM servicio WHERE idCliente=$idCliente";

} elseif ($rol == 1) {
  //ROL: FLETERO
  //SQL1: CONSULTA PARA EXTRAER IDFLETERO
  $sql1 = "SELECT idFletero FROM fletero WHERE idCliente='$idCliente'";
  $res1 = mysqli_query($conexion, $sql1);
  if ($row1 = $res1->fetch_assoc()) {
    $idFletero = $row1['idFletero'];
    $sql2 = "SELECT * FROM servicio WHERE idCliente=$idCliente OR idFletero=$idFletero";
  }

} else {
  //ROL: ADMINISTRADOR
}

$res2 = mysqli_query($conexion, $sql2);


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>FleteAr</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

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

  <!-- Preview Imagen -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

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

  <main id="main" class="main">
    <!-- ======= Resume Section ======= -->
    <section id="resume" class="resume">
      <div style="padding-top: 50px;" class="container">

        <div class="section-title">
          <h2>Historial de Servicios </h2>
          <p>Información sobre historial de servicios</p>
        </div>


        <!--CARDS-->
        <div class="card-group mt-3">
          <?php
          $contador = 1;
          if($res2->num_rows==0){
            ?>
            <h2 class="tittle text-center" style="color: red;">
            No se encontraron registros.
            </h2>
            <?php
          }
          while ($row2 = $res2->fetch_assoc()) {
            //EXTRAIGO 'idVehiculo' PARA ENVIARLO EN EL BOTON
            $idServicio = $row2['idServicio'];
          ?>
            <div class="col md-3">
              <div class="card" style="width: 18rem;">
                <div class="card-body Vehiculo">
                  <h5 class="card-title text-center"><?php echo $contador ?></h5>
                  <p><b>Precio:</b> <?php echo $row2['precioServicio'] ?></p>
                  <p><b>Fecha de Salida:</b> <?php echo $row2['fechaSalidaServicio'] ?></p>
                  <p><b>Estado:</b> <?php echo $row2['estadoServicio'] ?></p>
                  <div class="col md-3 text-center">
                    <a href="historialServicioVerMas.php?idServicio=<?php echo $idServicio; ?>" class="btn btn-primary w-50" type="submit" name="editar">Ver Mas</a>
                  </div>
                </div>
              </div>
            </div>

          <?php
            $contador++;
          }
          ?>
        </div>


    </section><!-- End Resume Section -->
  </main><!-- End #main -->
  <footer class="text-white" style="background-color: #645CAA; color: #ffffff; display: flex; justify-content: space-between; position: absolute; bottom: 0; width: 100%;">
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

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>