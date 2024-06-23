<?php
include 'conexion.php';
session_start();
// PREGUNTA SI HAY UN USUARIO REGISTRADO
if (!isset($_SESSION['usuario'])) {
  header('Location: inicioSesion.php');
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
if ($rol == 0) {
  //ROL: CLIENTE
  //SQL1: CONSULTA PARA EXTRAER IMAGENES E INFO DE TABLA FLETERO PARA MOSTRAR TOP 3
  $sql1 = "SELECT * FROM cliente c INNER JOIN fletero f WHERE (c.eliminadoCliente<1) AND (f.eliminadoFletero<1) AND (c.idCliente=f.idCliente) ORDER BY f.puntajeFletero DESC LIMIT 3";
  $res1 = mysqli_query($conexion, $sql1);
} elseif ($rol == 1) {
  //ROL: FLETERO
  //SQL1: CONSULTA PARA EXTRAER IMAGENES E INFO DE TABLA FLETERO PARA MOSTRAR TOP 3
  $sql1 = "SELECT * FROM cliente c INNER JOIN fletero f WHERE (c.eliminadoCliente<1) AND (f.eliminadoFletero<1) AND (c.iCliente=f.idCliente) ORDER BY f.puntajeFletero DESC LIMIT 3";
  $res1 = mysqli_query($conexion, $sql1);
} else {
  //ROL: ADMINISTRADOR
}


//CONSULTA
//$sql2 = "SELECT SQL_CALC_FOUND_ROWS * FROM cliente c INNER JOIN fletero f WHERE (c.eliminadoCliente<1) AND (f.eliminadoFletero<1) AND (c.idCliente=f.idCliente) AND (nombreCliente LIKE '%$campo%' OR apellidoCliente LIKE '%$campo%') ORDER BY f.puntajeFletero DESC";
//

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



  <link href="assets/css/style.css" rel="stylesheet">

  <!-- Style Search -->
  <style>
    #searchFleteros {
      width: auto;
      height: 40px;
      border-color: black;
      font-size: 20px;
      align-items: center;
      align-content: center;
    }
  </style>

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
      <div class="container">

        <div class="row">
          <div class="col-md-8">
            <h2 style="color: black;">Buscar Fleteros</h2>
          </div>
          <div class="col-md-4">
            <div class="align-end text-end">
              <input style="margin-bottom: 20px; border-radius: 8px;" type="text" id="searchFleteros" placeholder="Buscar un Vehículo" />
            </div>
          </div>
        </div>
        <div class="container">
          <div class="row">

            <div id="resultado" class="row">
              <!-- AQUÍ SE DESPLIEGA EL RESULTADO DE LA BUSQUEDA -->

            </div>
          </div>
        </div>


    </section><!-- End Resume Section -->

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

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>

<!--Con esta petición se verán los resultados de la lista -->
<script>
  $(obtener_registros());

  function obtener_registros(fletero) {
    $.ajax({
        url: 'clienteBuscarFleteroBack2.php',
        type: 'POST',
        dataType: 'html',
        data: {
          fletero: fletero
        },
      })

      .done(function(resultado) {
        $("#resultado").html(resultado);
      })
  }

  $(document).on('keyup', '#busqueda', function() {
    var valorBusqueda = $(this).val();
    if (valorBusqueda != "") {
      obtener_registros(valorBusqueda);
    } else {
      obtener_registros();
    }
  });
</script>