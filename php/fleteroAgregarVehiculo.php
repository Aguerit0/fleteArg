<?php
include('conexion.php');

session_start();
// PREGUNTA SI HAY UN USUARIO REGISTRADO
if (!isset($_SESSION['usuario'])) {
  header('Location: inicioSesion.php');
}

$error = "";


//AUTOMATIZAR SUBIDA DE IMAGENES
/* $vec=['conductor', 'carnet', 'cedula', 'seguro', 'vehiculo', 'titulo'];
  for ($i=0; $i < sizeof($vec); $i++) { 
    //CARGA DE IMAGENES
    $nombreArchivo=$_FILES[$vec[$i]]['name'];
    $archivo=$_FILES[$vec[$i]]['tmp_name'];
    $ruta="../imagenesFletero/".$vec[$i]."/".$nombreArchivo;
    move_uploaded_file($archivo, $ruta);  
  }
  

  $sql1 = "INSERT INTO fletero($) VALUES('$ruta') ";
  $res1 = mysqli_query($conexion, $sql1);
  if ($res1) {
  ?>
      <script type="text/javascript">
          alert('Imagen subida con exito !!');
      </script>
  <?php
  } */

//EXTRAIGO idCliente de Variables de sesion
$idCliente = $_SESSION['idCliente'];

if (isset($_POST['submit'])) {
  $contador = 0;
  if (
    !empty($_FILES['vehiculoVehiculo']['name']) &&
    !empty($_FILES['tituloVehiculo']['name']) &&
    !empty($_FILES['seguroVehiculo']['name']) &&
    !empty($_POST['tipoVehiculo']) &&
    !empty($_POST['colorVehiculo']) &&
    !empty($_POST['descripcionVehiculo'])
) {
      //IMAGEN VEHÍCULO
      $archivoVehiculo = $_FILES['vehiculoVehiculo']['name'];
      $archivoVehiculoTemp = $_FILES['vehiculoVehiculo']['tmp_name'];
      $rutaVehiculo = "../imagenesFletero/vehiculoVehiculo/" . $archivoVehiculo;
      move_uploaded_file($archivoVehiculoTemp, $rutaVehiculo);

      //IMAGEN SEGURO
      $archivoSeguro = $_FILES['seguroVehiculo']['name'];
      $archivoSeguroTemp = $_FILES['seguroVehiculo']['tmp_name'];
      $rutaSeguro = "../imagenesFletero/seguroVehiculo/" . $archivoSeguro;
      move_uploaded_file($archivoSeguroTemp, $rutaSeguro);

      //IMAGEN TITULO
      $archivoTitulo = $_FILES['tituloVehiculo']['name'];
      $archivoTituloTemp = $_FILES['tituloVehiculo']['tmp_name'];
      $rutaTitulo = "../imagenesFletero/tituloVehiculo/" . $archivoTitulo;
      move_uploaded_file($archivoTituloTemp, $rutaTitulo);

       //IMAGEN PATENTE
       $archivoPatente = $_FILES['patenteVehiculo']['name'];
       $archivoPatenteTemp = $_FILES['patenteVehiculo']['tmp_name'];
       $rutaPatente = "../imagenesFletero/patenteVehiculo/" . $archivoPatente;
       move_uploaded_file($archivoPatenteTemp, $rutaPatente);
 
       //PATENTE VEHICULO
       $patenteVehiculoText = $_POST['patenteVehiculoText'];

      //TIPO DE VEHÍCULO: SELECT
      $tipoVehiculo = $_POST['tipoVehiculo'];

      //COLOR VEHICULO
      $colorVehiculo = $_POST['colorVehiculo'];

      //DESCRIPCIÓN VEHICULO
      $descripcionVehiculo = $_POST['descripcionVehiculo'];
      
      //SQL1: SELECT TABLA FLETERO PARA OBTENER ID
      $sql1 = "SELECT idFletero FROM fletero WHERE idCliente='$idCliente' AND eliminadoFletero<1";
      $res1 = mysqli_query($conexion, $sql1);
      if ($row1 = $res1->fetch_assoc()) {
        $idFletero = $row1['idFletero'];
      }

      //SQL2: UPDATE CANTIDAD VEHICULOS TABLA FLETERO
      $sql2 = "UPDATE fletero SET cantidadVehiculosFletero=cantidadVehiculosFletero+1 WHERE idFletero='$idFletero' ";
      $res2 = mysqli_query($conexion,$sql2);

      //SI LA CARGA FUÉ EXITOSA, EL CLIENTE PASA A SER FLETERO
      if ($res2) {
        //SQL3: INSERT VEHICULO NUEVO
        $sql3 = "INSERT INTO vehiculo(vehiculoVehiculo, seguroVehiculo, tituloVehiculo, patenteVehiculo, patenteVehiculoText, tipoVehiculo, colorVehiculo, descripcionVehiculo, fechaRegVehiculo, eliminadoVehiculo, idFletero) VALUES('$rutaVehiculo', '$rutaSeguro', '$rutaTitulo', '$rutaPatente', '$patenteVehiculoText', '$tipoVehiculo', '$colorVehiculo', '$descripcionVehiculo', NOW(), 0, '$idFletero') ";
        $res3 = mysqli_query($conexion, $sql3);
        ?>
        <script>
          alert('Registro Exitoso !!');
        </script>
        <?php
        sleep(3);
        header('location: fleteroVerVehiculo.php'); //
      } else {
      ?>
        <script type="text/javascript">
          alert('ERROR AL CARGAR DATOS !!');
        </script>
      <?php
      }
    } else {
      ?>
      <script type="text/javascript">
        alert('Formulario Incompleto !!');
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
    <section class="section dashboard">
      <div class="container">
        <div class="card mb-3 pb-3">
          <div class="card-body">
            <form class="row g-3 needs-validation" method="POST" enctype="multipart/form-data">
              <!--DATOS DEL VEHICULO-->
              <div class="pt-4 pb-2">
                <h5 class="card-title text-center pb-0 fs-4">Registrá tu vehículo</h5>
                <p class="text-center small">Ingrese su información de su vehículo en el formulario</p>
              </div>
              <div class="col-4" style="height: 100px;">
                <label for="vehiculoVehiculo" class="form-label">Foto del Vehiculo</label>
                <div class="vehiculo-img">
                  <img src="../img/imgVehiculo.png" alt="vehiculoVehiculoPrev" id="vehiculoVehiculoPrev" />
                  <div class="file btn btn-lg btn-primary">
                    Subir Imagen
                    <input require type="file" name="vehiculoVehiculo" id="vehiculoVehiculo" accept="image/*" />
                  </div>
                </div>
              </div>
              <div class="col-4">
                <label for="seguroVehiculo" class="form-label">Seguro del Vehiculo</label>
                <div class="vehiculo-img">
                  <img src="../img/imgTitulo.png" alt="seguroVehiculoPrev" id="seguroVehiculoPrev" />
                  <div class="file btn btn-lg btn-primary">
                    Subir Imagen
                    <input require type="file" name="seguroVehiculo" id="seguroVehiculo" accept="image/*" />
                  </div>
                </div>
              </div>
              <div class="col-4">
                <label for="tituloVehiculo" class="form-label">Titulo del Vehiculo</label>
                <div class="vehiculo-img">
                  <img src="../img/imgTitulo.png" alt="tituloVehiculoPrev" id="tituloVehiculoPrev" />
                  <div class="file btn btn-lg btn-primary">
                    Subir Imagen
                    <input require type="file" name="tituloVehiculo" id="tituloVehiculo" accept="image/*" />
                  </div>
                </div>
              </div>
              <div class="col-4">
                <label for="patenteVehiculo" class="form-label">Patente del Vehiculo</label>
                <div class="vehiculo-img">
                  <img src="../img/imgTitulo.png" alt="patenteVehiculo" id="patenteVehiculoPrev" />
                  <div class="file btn btn-lg btn-primary">
                    Subir Imagen
                    <input require type="file" name="patenteVehiculo" id="patenteVehiculo" accept="image/*" />
                  </div>
                </div>
              </div>
              <div class="col-4">
                <label for="patenteVehiculoText" class="form-label">Escriba la patente del Vehiculo</label>
                <div class="input-group has-validation">
                  <input require type="text" class="form-control" name="patenteVehiculoText" id="patenteVehiculoText">
                  <div class="invalid-feedback">Escriba la patente del vehiculo</div>
                </div>
              </div>
              <div class="col-4">
                <label for="tipoVehiculo" class="form-label">Tipo de Vehículo</label>
                <select require name="tipoVehiculo" id="tipoVehiculo" class="form-select">
                  <option value="">Seleccionar</option>
                  <option value="0">Auto</option>
                  <option value="1">Camioneta</option>
                  <option value="2">Camion</option>
                  <option value="3">Traffic</option>
                  <option value="4">Moto</option>
                  <option value="5">Bicicleta</option>
                </select>
                <div class="invalid-feedback">Ingrese su sexo.</div>
              </div>
              <div class="col-4">
                <label for="colorVehiculo" class="form-label">Color del Vehículo</label>
                <div class="input-group has-validation">
                  <input require type="text" class="form-control" name="colorVehiculo" id="colorVehiculo">
                  <div class="invalid-feedback">Ingrese el color</div>
                </div>
              </div>
              <div class="col-4">
                <label for="descripcionVehiculo" class="form-label">Descripción del Vehículo</label>
                <div class="input-group has-validation">
                  <input require type="text" class="form-control" name="descripcionVehiculo" id="descripcionVehiculo">
                  <div class="invalid-feedback">Ingrese una descripcion</div>
                </div>
              </div>
              <div class="col-12 d-flex align-items-center justify-content-center">
                <div style='color:red'>
                  <?php
                  echo $error;
                  ?>
                </div>
              </div>
              <div class="col-12 d-flex align-items-center justify-content-center">
              </div>
              <div class="row text-center">
                <div class="col-md-4"></div>
                <div class="col-md-4">
              <button class="btn btn-primary w-20" type="submit" name="submit">Registrar</button>
                </div>
                <div class="col-md-4"></div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main><!-- End #main -->

  <script>
    // Obtener referencia al input y a la imagen
    const $seleccionArchivosVehiculo = document.querySelector("#vehiculoVehiculo"),
      $imagenPrevisualizacionVehiculo = document.querySelector("#vehiculoVehiculoPrev");
    // Escuchar cuando cambie
    $seleccionArchivosVehiculo.addEventListener("change", () => {
      // Los archivos seleccionados, pueden ser muchos o uno
      const archivos = $seleccionArchivosVehiculo.files;
      // Si no hay archivos salimos de la función y quitamos la imagen
      if (!archivos || !archivos.length) {
        $imagenPrevisualizacionVehiculo.src = "";
        return;
      }
      // Ahora tomamos el primer archivo, el cual vamos a previsualizar
      const primerArchivo = archivos[0];
      // Lo convertimos a un objeto de tipo objectURL
      const objectURL = URL.createObjectURL(primerArchivo);
      // Y a la fuente de la imagen le ponemos el objectURL
      $imagenPrevisualizacionVehiculo.src = objectURL;
    });

    // Obtener referencia al input y a la imagen
    const $seleccionArchivosSeguro = document.querySelector("#seguroVehiculo"),
      $imagenPrevisualizacionSeguro = document.querySelector("#seguroVehiculoPrev");
    // Escuchar cuando cambie
    $seleccionArchivosSeguro.addEventListener("change", () => {
      // Los archivos seleccionados, pueden ser muchos o uno
      const archivos = $seleccionArchivosSeguro.files;
      // Si no hay archivos salimos de la función y quitamos la imagen
      if (!archivos || !archivos.length) {
        $imagenPrevisualizacionSeguro.src = "";
        return;
      }
      // Ahora tomamos el primer archivo, el cual vamos a previsualizar
      const primerArchivo = archivos[0];
      // Lo convertimos a un objeto de tipo objectURL
      const objectURL = URL.createObjectURL(primerArchivo);
      // Y a la fuente de la imagen le ponemos el objectURL
      $imagenPrevisualizacionSeguro.src = objectURL;
    });

    // Obtener referencia al input y a la imagen
    const $seleccionArchivosTitulo = document.querySelector("#tituloVehiculo"),
      $imagenPrevisualizacionTitulo = document.querySelector("#tituloVehiculoPrev");
    // Escuchar cuando cambie
    $seleccionArchivosTitulo.addEventListener("change", () => {
      // Los archivos seleccionados, pueden ser muchos o uno
      const archivos = $seleccionArchivosTitulo.files;
      // Si no hay archivos salimos de la función y quitamos la imagen
      if (!archivos || !archivos.length) {
        $imagenPrevisualizacionTitulo.src = "";
        return;
      }
      // Ahora tomamos el primer archivo, el cual vamos a previsualizar
      const primerArchivo = archivos[0];
      // Lo convertimos a un objeto de tipo objectURL
      const objectURL = URL.createObjectURL(primerArchivo);
      // Y a la fuente de la imagen le ponemos el objectURL
      $imagenPrevisualizacionTitulo.src = objectURL;
    });
    // Obtener referencia al input y a la imagen
    const $seleccionArchivosPatente = document.querySelector("#patenteVehiculo"),
      $imagenPrevisualizacionPatente = document.querySelector("#patenteVehiculoPrev");

    // Escuchar cuando cambie
    $seleccionArchivosPatente.addEventListener("change", () => {
      // Los archivos seleccionados, pueden ser muchos o uno
      const archivos = $seleccionArchivosPatente.files;
      // Si no hay archivos salimos de la función y quitamos la imagen
      if (!archivos || !archivos.length) {
        $imagenPrevisualizacionPatente.src = "";
        return;
      }
      // Ahora tomamos el primer archivo, el cual vamos a previsualizar
      const primerArchivo = archivos[0];
      // Lo convertimos a un objeto de tipo objectURL
      const objectURL = URL.createObjectURL(primerArchivo);
      // Y a la fuente de la imagen le ponemos el objectURL
      $imagenPrevisualizacionPatente.src = objectURL;
    });
  </script>

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