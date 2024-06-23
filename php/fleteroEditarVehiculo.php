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
//ID RECIBIDO POR BOTON PARA VER DATOS DE VEHICULO EN ESPECIFICO CON SELECT
$idVehiculo = $_GET['idVehiculo'];
//SQL4: SELECT PARA VER INFORMACIÓN DEL VEHICULO
$sql4 = "SELECT * FROM vehiculo WHERE idVehiculo='$idVehiculo'";
$res4 = mysqli_query($conexion, $sql4);
if ($row4 = $res4->fetch_assoc()) {
  $vehiculoVehiculo = $row4['vehiculoVehiculo'];
  $seguroVehiculo = $row4['seguroVehiculo'];
  $tituloVehiculo = $row4['tituloVehiculo'];
  $patenteVehiculo = $row4['patenteVehiculo'];
  $patenteVehiculoText = $row4['patenteVehiculoText'];
  $tipoVehiculo = $row4['tipoVehiculo'];
  $colorVehiculo = $row4['colorVehiculo'];
  $descripcionVehiculo = $row4['descripcionVehiculo'];
  $fechaRegVehiculo = $row4['fechaRegVehiculo'];
  $eliminadoVehiculo = $row4['eliminadoVehiculo'];
}

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

      //PATENTE DE VEHICULO
      $archivoPatente = $_FILES['patenteVehiculo']['name'];
      $archivoPatenteTemp = $_FILES['patenteVehiculo']['tmp_name'];
      $rutaPatente = "../imagenesFletero/patenteVehiculo/" . $archivoPatente;
      move_uploaded_file($archivoPatenteTemp, $rutaPatente);

      //PATENTE DE VEHICULO 'TEXT'
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

      if ($res1) {
        //SQL2: INSERT VEHICULO NUEVO
        $sql2 = "UPDATE vehiculo SET vehiculoVehiculo='$rutaVehiculo', seguroVehiculo='$rutaSeguro', tituloVehiculo='$rutaTitulo', patenteVehiculo='$rutaPatente', patenteVehiculoText='$patenteVehiculoText', tipoVehiculo='$tipoVehiculo', colorVehiculo='$colorVehiculo', descripcionVehiculo='$descripcionVehiculo' WHERE idVehiculo='$idVehiculo' ";
        $res2 = mysqli_query($conexion, $sql2);
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
          alert('Error al cargar datos !!');
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
            <form class="row g-3 needs-validation" method="POST" enctype="multipart/form-data" novalidate>
              <!--DATOS DEL VEHICULO-->
              <div class="pt-4 pb-2">
                <h5 class="card-title text-center pb-0 fs-4">Registrá tu vehículo</h5>
                <p class="text-center small">Ingrese la información de su vehículo en el siguiente formulario</p>
              </div>
              <div class="col-4">
                <label for="vehiculoVehiculo" class="form-label">Foto del Vehículo</label>
                <div class="vehiculo-img">
                  <?php if (!empty($vehiculoVehiculo)) { ?>
                    <img src="<?php echo $vehiculoVehiculo ?>" alt="vehiculoVehiculoPrev" id="vehiculoVehiculoPrev" class="img-fluid" />
                  <?php } else { ?>
                    <img src="<?php echo $vehiculoVehiculo ?>" alt="vehiculoVehiculoPrev" id="vehiculoVehiculoPrev" class="img-fluid" />
                  <?php } ?>
                  <div class="file btn btn-lg btn-primary">
                    Subir Imagen
                    <input type="file" name="vehiculoVehiculo" id="vehiculoVehiculo" accept="image/*" />
                  </div>
                </div>
              </div>

              <div class="col-4">
                <label for="seguroVehiculo" class="form-label text-center">Seguro del Vehículo</label>
                <div class="vehiculo-img">
                  <?php if (!empty($seguroVehiculo)) { ?>
                    <img src="<?php echo $seguroVehiculo ?>" alt="seguroVehiculoPrev" id="seguroVehiculoPrev" class="img-fluid" />
                  <?php } else { ?>
                    <img src="<?php echo $seguroVehiculo ?>" alt="seguroVehiculoPrev" id="seguroVehiculoPrev" class="img-fluid" />
                  <?php } ?>
                  <div class="file btn btn-lg btn-primary">
                    Subir Imagen
                    <input type="file" name="seguroVehiculo" id="seguroVehiculo" accept="image/*" />
                  </div>
                </div>
              </div>

              <div class="col-4">
                <label for="tituloVehiculo" class="form-label">Título del Vehículo</label>
                <div class="vehiculo-img">
                  <?php if (!empty($tituloVehiculo)) { ?>
                    <img src="<?php echo $tituloVehiculo ?>" alt="tituloVehiculoPrev" id="tituloVehiculoPrev" class="img-fluid" />
                  <?php } else { ?>
                    <img src="<?php echo $tituloVehiculo ?>" alt="tituloVehiculoPrev" id="tituloVehiculoPrev" class="img-fluid" />
                  <?php } ?>
                  <div class="file btn btn-lg btn-primary text-center d-flex justify-content-center align-items-center">
                    Subir Imagen
                    <input type="file" name="tituloVehiculo" id="tituloVehiculo" accept="image/*" />
                  </div>
                </div>
              </div>

              <div class="col-4">
                <label for="patenteVehiculo" class="form-label">Foto de Patente</label>
                <div class="vehiculo-img">
                  <?php if (!empty($patenteVehiculo)) { ?>
                    <img src="<?php echo $patenteVehiculo ?>" alt="patenteVehiculoPrev" id="patenteVehiculoPrev" class="img-fluid" />
                  <?php } else { ?>
                    <img src="<?php echo $patenteVehiculo ?>" alt="patenteVehiculoPrev" id="patenteVehiculoPrev" class="img-fluid" />
                  <?php } ?>
                  <div class="file btn btn-lg btn-primary text-center d-flex justify-content-center align-items-center">
                    Subir Imagen
                    <input type="file" name="patenteVehiculo" id="patenteVehiculo" accept="image/*" />
                  </div>
                </div>
              </div>

              <div class="col-4">
                <label for="patenteVehiculoText" class="form-label">Patente de Vehiculo</label>
                <div class="input-group has-validation">
                  <input require type="text" class="form-control" name="patenteVehiculoText" id="patenteVehiculoText" value="<?php echo $patenteVehiculoText ?>">
                  <div class="invalid-feedback">Ingrese una patente</div>
                </div>
              </div>

              <div class="col-4">
                <label for="tipoVehiculo" class="form-label">Tipo de Vehículo</label>
                <select require name="tipoVehiculo" id="tipoVehiculo" class="form-select">
                  <?php
                  if ($tipoVehiculo == 0) {
                    $tipoVehiculoStr = "Auto";
                  } elseif ($tipoVehiculo == 1) {
                    $tipoVehiculoStr = "Camioneta";
                  } elseif ($tipoVehiculo == 2) {
                    $tipoVehiculoStr = "Camion";
                  } elseif ($tipoVehiculo == 3) {
                    $tipoVehiculoStr = "Traffic";
                  } elseif ($tipoVehiculo == 4) {
                    $tipoVehiculoStr = "Moto";
                  } elseif ($tipoVehiculo == 5) {
                    $tipoVehiculoStr = "Bicicleta";
                  } else {
                    $tipoVehiculoStr = " ";
                  }
                  ?>
                  <option value="<?php echo $tipoVehiculo ?>"><?php echo $tipoVehiculoStr ?></option>
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
                  <input require type="text" class="form-control" name="colorVehiculo" id="colorVehiculo" value="<?php echo $colorVehiculo ?>">
                  <div class="invalid-feedback">Ingrese el color</div>
                </div>
              </div>
              <div class="col-4">
                <label for="descripcionVehiculo" class="form-label">Descripción del Vehículo</label>
                <div class="input-group has-validation">
                  <input require type="text" maxlength="25" class="form-control" name="descripcionVehiculo" id="descripcionVehiculo" value="<?php echo $descripcionVehiculo ?> ">
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
                <button onclick="return validarFormulario()" class="btn btn-primary w-50" type="submit" name="submit">Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main><!-- End #main -->

  <!--SCRIPT PARA CARGAR IMAGENES-->
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

  <!--SCRIPT PARA OBLIGAR A QUE LOS INPUTS TENGAN IMAGENES-->
  <script>
    // Obtener los elementos de imagen y campo de archivo por su ID
    var vehiculoVehiculoInput = document.getElementById("vehiculoVehiculo");
    var vehiculoVehiculoPrev = document.getElementById("vehiculoVehiculoPrev");

    var seguroVehiculoInput = document.getElementById("seguroVehiculo");
    var seguroVehiculoPrev = document.getElementById("seguroVehiculoPrev");

    var tituloVehiculoInput = document.getElementById("tituloVehiculo");
    var tituloVehiculoPrev = document.getElementById("tituloVehiculoPrev");

    var patenteVehiculoInput = document.getElementById("patenteVehiculo");
    var patenteVehiculoPrev = document.getElementById("patenteVehiculoPrev");

    // Verificar si existe una imagen en las variables PHP y asignarla a las vistas previas correspondientes
    if (!vehiculoVehiculoInput.value && "<?php echo $vehiculoVehiculo; ?>") {
      vehiculoVehiculoPrev.src = "<?php echo $vehiculoVehiculo; ?>";
    }
    if (!seguroVehiculoInput.value && "<?php echo $seguroVehiculo; ?>") {
      seguroVehiculoPrev.src = "<?php echo $seguroVehiculo; ?>";
    }
    if (!tituloVehiculoInput.value && "<?php echo $tituloVehiculo; ?>") {
      tituloVehiculoPrev.src = "<?php echo $tituloVehiculo; ?>";
    }
    if (!patenteVehiculoInput.value && "<?php echo $patenteVehiculo; ?>") {
      patenteVehiculoPrev.src = "<?php echo $patenteVehiculo; ?>";
    }

    // Asignar evento de cambio a cada campo de imagen
    vehiculoVehiculoInput.addEventListener("change", function() {
      handleImageChange(this, vehiculoVehiculoPrev);
    });

    seguroVehiculoInput.addEventListener("change", function() {
      handleImageChange(this, seguroVehiculoPrev);
    });

    tituloVehiculoInput.addEventListener("change", function() {
      handleImageChange(this, tituloVehiculoPrev);
    });
    patenteVehiculoInput.addEventListener("change", function() {
      handleImageChange(this, patenteVehiculoPrev);
    });

    // Función para manejar el cambio de imagen
    function handleImageChange(input, preview) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          preview.src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>




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