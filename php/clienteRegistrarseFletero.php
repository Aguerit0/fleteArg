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
  if (!empty($_FILES)) {
    if (isset($_FILES['imagenFletero']) or isset($_FILES['carnetFletero']) or isset($_FILES['cedulaFletero']) or isset($_POST['descripcionFletero']) or isset($_FILES['vehiculoVehiculo']) or isset($_FILES['tituloVehiculo']) or isset($_FILES['seguroVehiculo']) or isset($_POST['tipoVehiculo']) or isset($_POST['colorVehiculo']) or isset($_POST['descripcionVehiculo']) or isset($_FILES['patenteVehiculo'])  or isset($_POST['patenteVehiculoText'])) {
      //IMAGEN CONDUCTOR
      $archivoConductor = $_FILES['imagenFletero']['name'];
      $archivoConductorTemp = $_FILES['imagenFletero']['tmp_name'];
      $rutaConductor = "../imagenesFletero/imagenFletero/" . $archivoConductor;
      move_uploaded_file($archivoConductorTemp, $rutaConductor);

      //IMAGEN CARNET
      $archivoCarnet = $_FILES['carnetFletero']['name'];
      $archivoCarnetTemp = $_FILES['carnetFletero']['tmp_name'];
      $rutaCarnet = "../imagenesFletero/carnetFletero/" . $archivoCarnet;
      move_uploaded_file($archivoCarnetTemp, $rutaCarnet);

      //IMAGEN CEDULA
      $archivoCedula = $_FILES['cedulaFletero']['name'];
      $archivoCedulaTemp = $_FILES['cedulaFletero']['tmp_name'];
      $rutaCedula = "../imagenesFletero/cedulaFletero/" . $archivoCedula;
      move_uploaded_file($archivoCedulaTemp, $rutaCedula);

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

      //DESCRIPCIONES
      $descripcionFletero = $_POST['descripcionFletero'];

      //DESCRIPCIÓN VEHICULO
      $descripcionVehiculo = $_POST['descripcionVehiculo'];

      //SQL1: INSERT DATOS PARA TABLA FLETERO
      $sql1 = "INSERT INTO fletero(imagenFletero, descripcionFletero, carnetFletero, cedulaFletero, cantidadVehiculosFletero, fechaRegFletero, eliminadoFletero, idCliente) VALUES('$rutaConductor', '$descripcionFletero', '$rutaCarnet', '$rutaCedula', 1, NOW(), 0, '$idCliente' ) ";
      $res1 = mysqli_query($conexion, $sql1);

      //SI LA CARGA FUÉ EXITOSA, EL CLIENTE PASA A SER FLETERO
      if ($res1) {
        //POR LO TANTO UPDATE A LA TABLA USUARIO CAMBIANDOLE EL ROL
        //SQL2: UPDATE CAMBIO DE ROL TABLA CLIENTES
        $sql2 = "UPDATE usuario SET rol='1' WHERE idCliente='$idCliente' ";
        $res2 = mysqli_query($conexion, $sql2);
        //SQL4: SELECT PARA EXTRAER ID DE FLETERO ACTUAL
        $sql4 = "SELECT idFletero FROM fletero WHERE (idCliente='$idCliente') AND (eliminadoFletero<1)";
        $res4 = mysqli_query($conexion, $sql4);
        if ($row4 = $res4->fetch_assoc()) {
          $idFletero = $row4['idFletero'];
        }
        //SQL3: INSERT DATOS PARA TABLA VEHICULO
        $sql3 = "INSERT INTO vehiculo(vehiculoVehiculo, seguroVehiculo, tituloVehiculo, patenteVehiculo, patenteVehiculoText, tipoVehiculo, colorVehiculo, descripcionVehiculo, fechaRegVehiculo, eliminadoVehiculo, idFletero) VALUES('$rutaVehiculo', '$rutaSeguro', '$rutaTitulo', '$rutaPatente','$patenteVehiculoText', '$tipoVehiculo', '$colorVehiculo', '$descripcionVehiculo', NOW(), 0, '$idFletero') ";
        $res3 = mysqli_query($conexion, $sql3);

?>
        <script>
          alert('Registro Exitoso !!');
        </script>
      <?php
        sleep(4);
        session_unset();
        session_destroy();
        header('location: inicioSesion.php'); //
      } else {
      ?>
        <script type="text/javascript">
          alert('NO SE REALIZÓ LA CONSULTA SQL !!');
        </script>
      <?php
      }
    } else {
      ?>
      <script type="text/javascript">
        alert('FORMULARIO INCOMPLETO !!');
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
} else {
  ?>
  <script type="text/javascript">
    //alert('No se transfirio correctamente la imagen ');
  </script>
<?php
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
            <div class="section-title">
              <h2 class="fw-bold"><span>Registrarse como Fletero</span></h2>
            </div>
            <form class="row g-3 needs-validation" method="POST" enctype="multipart/form-data" novalidate>

              <!-- DATOS DEL CONDUCTOR -->
              <div class="col-6">
                <label for="imagenFletero" class="form-label">
                  Foto del Conductor <span class="exclamation" data-bs-toggle="tooltip" data-bs-placement="right" title="Arrastre y suelte una imagen aquí o haga clic para seleccionar"><i style="color: red;" class="bi bi-exclamation-lg"></i></span>
                </label>
                <div class="input-group">
                  <input type="file" id="imagenFletero" name="imagenFletero" class="form-control" accept="image/*" style="display: none;">
                  <div id="drag-and-drop-area1" class="drag-and-drop-area">
                    <p>Arrastre y suelte una imagen aquí o haga clic para seleccionar</p>
                    <i id="checkmark" class="fas fa-check" style="display: none;"></i>
                    <p id="status" style="display: none;">Imagen cargada <i style="color: green;" class="bi bi-check-lg"></i></p>
                  </div>
                </div>
              </div>

              <script>
                // Función para manejar el evento de soltar
                function handleDrop(event) {
                  event.preventDefault();
                  event.stopPropagation();

                  const files = event.dataTransfer.files;
                  if (files.length > 0) {
                    // Obtener el archivo
                    document.getElementById('drag-and-drop-area1').classList.add('uploaded');
                    document.getElementById('checkmark').style.display = 'inline';
                    document.getElementById('status').style.display = 'inline';
                  }
                }

                // Agregar el evento de arrastre y soltar al área de arrastre
                const dragAndDropArea = document.getElementById('drag-and-drop-area1');
                dragAndDropArea.addEventListener('dragover', (event) => {
                  event.preventDefault();
                  event.stopPropagation();
                  dragAndDropArea.classList.add('dragover');
                });

                dragAndDropArea.addEventListener('dragleave', (event) => {
                  event.preventDefault();
                  event.stopPropagation();
                  dragAndDropArea.classList.remove('dragover');
                });

                dragAndDropArea.addEventListener('drop', handleDrop);

                // Agregar el evento de clic para abrir el cuadro de diálogo de selección de archivo
                const fileInput = document.getElementById('imagenFletero');
                dragAndDropArea.addEventListener('click', () => {
                  fileInput.click();
                });

                // Agregar un manejador de cambio para el input de archivo
                fileInput.addEventListener('change', (event) => {
                  // Obtener el archivo
                  document.getElementById('drag-and-drop-area1').classList.add('uploaded');
                  document.getElementById('checkmark').style.display = 'inline';
                  document.getElementById('status').style.display = 'inline';
                });
              </script>

              <style>
                .drag-and-drop-area {
                  border: 2px dashed #ccc;
                  border-radius: 5px;
                  padding: 20px;
                  text-align: center;
                  cursor: pointer;
                  transition: border-color 0.3s ease-in-out;
                }

                .drag-and-drop-area.dragover {
                  border-color: #007bff;
                }

                .drag-and-drop-area.uploaded {
                  border-color: #28a745;
                  background-color: #e9f7ef;
                }

                #checkmark {
                  color: #28a745;
                  font-size: 24px;
                }

                #status {
                  color: #28a745;
                  font-weight: bold;
                }
              </style>


              <!--CARNET-->
              <div class="col-6">
                <label for="carnetFletero" class="form-label">
                  Carnet del Fletero <span class="exclamation" data-bs-toggle="tooltip" data-bs-placement="right" title="Suba una imagen del carnét de conducir"><i style="color: red;" class="bi bi-exclamation-lg"></i></span>
                </label>
                <div class="input-group">
                  <input type="file" id="carnetFletero" name="carnetFletero" class="form-control" accept="image/*" style="display: none;">
                  <div id="drag-and-drop-area2" class="drag-and-drop-area">
                    <p>Arrastre y suelte una imagen aquí o haga clic para seleccionar</p>
                    <i id="checkmark2" class="fas fa-check" style="display: none;"></i>
                    <p id="status2" style="display: none; color: green;">Imagen cargada <i style="color: green;" class="bi bi-check-lg"></i></p>
                  </div>
                </div>
              </div>
              <!--DESCRIPCIÓN-->
              <div class="col-4">
                <label for="descripcionFletero" class="form-label">
                  Descripción del Conductor <span class="exclamation" data-bs-toggle="tooltip" data-bs-placement="right" title="Ingrese una descripción"></span>
                </label>
                <div class="input-group has-validation">
                  <input require type="text" class="form-control" name="descripcionFletero" id="descripcionFletero">
                  <div class="invalid-feedback">Ingrese una descripción</div>
                </div>
              </div>

              <div class="col-2"></div>
              <!--CEDULA-->
              <div class="col-6">
                <label for="cedulaFletero" class="form-label">
                  Cedula del Conductor <span class="exclamation" data-bs-toggle="tooltip" data-bs-placement="right" title="Suba una imagen de la cédula de conductor"><i style="color: red;" class="bi bi-exclamation-lg"></i></span>
                </label>
                <div class="input-group">
                  <input type="file" id="cedulaFletero" name="cedulaFletero" class="form-control" accept="image/*" style="display: none;">
                  <div id="drag-and-drop-area3" class="drag-and-drop-area">
                    <p>Arrastre y suelte una imagen aquí o haga clic para seleccionar</p>
                    <i id="checkmark3" class="fas fa-check" style="display: none;"></i>
                    <p id="status3" style="display: none;">Imagen cargada <i style="color: green;" class="bi bi-check-lg"></i></p>
                  </div>
                </div>
              </div>

              <!-- DATOS DEL VEHÍCULO -->
              <div class="pt-4 pb-2">
                <h5 class="card-title text-center pb-0 fs-4">Registrá tu vehículo</h5>
                <p class="text-center small">Ingrese su información de su vehículo en el formulario</p>
              </div>

              <!--FOTO DE VEHICULO-->

              <div class="col-4">
                <label for="vehiculoVehiculo" class="form-label">
                  Foto del Vehículo <span class="exclamation" data-bs-toggle="tooltip" data-bs-placement="right" title="Suba una imagen del vehículo"><i style="color: red;" class="bi bi-exclamation-lg"></i></span>
                </label>
                <div class="input-group">
                  <input type="file" id="vehiculoVehiculo" name="vehiculoVehiculo" class="form-control" accept="image/*" style="display: none;">
                  <div id="drag-and-drop-area4" class="drag-and-drop-area">
                    <p>Arrastre y suelte una imagen aquí o haga clic para seleccionar</p>
                    <i id="checkmark4" class="fas fa-check" style="display: none;"></i>
                    <p id="status4" style="display: none;">Imagen cargada <i style="color: green;" class="bi bi-check-lg"></i></p>
                  </div>
                </div>
              </div>

              <!--SEGURO-->

              <div class="col-4">
                <label for="seguroVehiculo" class="form-label">
                  Seguro del Vehículo <span class="exclamation" data-bs-toggle="tooltip" data-bs-placement="right" title="Suba una imagen del seguro del vehículo"><i style="color: red;" class="bi bi-exclamation-lg"></i></span>
                </label>
                <div class="input-group">
                  <input type="file" id="seguroVehiculo" name="seguroVehiculo" class="form-control" accept="image/*" style="display: none;">
                  <div id="drag-and-drop-area5" class="drag-and-drop-area">
                    <p>Arrastre y suelte una imagen aquí o haga clic para seleccionar</p>
                    <i id="checkmark5" class="fas fa-check" style="display: none;"></i>
                    <p id="status5" style="display: none;">Imagen cargada <i style="color: green;" class="bi bi-check-lg"></i></p>
                  </div>
                </div>
              </div>
              <!--TITULO-->
              <div class="col-4">
                <label for="tituloVehiculo" class="form-label">
                  Titulo del Vehículo <span class="exclamation" data-bs-toggle="tooltip" data-bs-placement="right" title="Suba una imagen del título del vehículo"><i style="color: red;" class="bi bi-exclamation-lg"></i></span>
                </label>
                <div class="input-group">
                  <input type="file" id="tituloVehiculo" name="tituloVehiculo" class="form-control" accept="image/*" style="display: none;">
                  <div id="drag-and-drop-area6" class="drag-and-drop-area">
                    <p>Arrastre y suelte una imagen aquí o haga clic para seleccionar</p>
                    <i id="checkmark6" class="fas fa-check" style="display: none;"></i>
                    <p id="status6" style="display: none;">Imagen cargada <i style="color: green;" class="bi bi-check-lg"></i></p>
                  </div>
                </div>
              </div>
              <!--PATENTE-->
              <div class="col-4">
                <label for="patenteVehiculo" class="form-label">
                  Patente del Vehículo <span class="exclamation" data-bs-toggle="tooltip" data-bs-placement="right" title="Suba una imagen de la patente del vehículo"><i style="color: red;" class="bi bi-exclamation-lg"></i></span>
                </label>
                <div class="input-group">
                  <input type="file" id="patenteVehiculo" name="patenteVehiculo" class="form-control" accept="image/*" style="display: none;">
                  <div id="drag-and-drop-area7" class="drag-and-drop-area">
                    <p>Arrastre y suelte una imagen aquí o haga clic para seleccionar</p>
                    <i id="checkmark7" class="fas fa-check" style="display: none;"></i>
                    <p id="status7" style="display: none;">Imagen cargada <i style="color: green;" class="bi bi-check-lg"></i></p>
                  </div>
                </div>
              </div>

              <div class="col-4">
                <label for="patenteVehiculoText" class="form-label">
                  Escriba la patente del Vehiculo <span class="exclamation" data-bs-toggle="tooltip" data-bs-placement="right" title="Ingrese la patente del vehículo"></span>
                </label>
                <div class="input-group has-validation">
                  <input require type="text" class="form-control" name="patenteVehiculoText" id="patenteVehiculoText">
                  <div class="invalid-feedback">Escriba la patente del vehículo</div>
                </div>
              </div>

              <div class="col-4">
                <label for="tipoVehiculo" class="form-label">
                  Tipo de Vehículo <span class="exclamation" data-bs-toggle="tooltip" data-bs-placement="right" title="Seleccione el tipo de vehículo"></span>
                </label>
                <select require name="tipoVehiculo" id="tipoVehiculo" class="form-select">
                  <option value="">Seleccionar</option>
                  <option value="0">Auto</option>
                  <option value="1">Camioneta</option>
                  <option value="2">Camión</option>
                  <option value="3">Traffic</option>
                  <option value="4">Moto</option>
                  <option value="5">Bicicleta</option>
                </select>
                <div class="invalid-feedback">Ingrese el tipo de vehículo.</div>
              </div>

              <div class="col-4">
                <label for="colorVehiculo" class="form-label">
                  Color del Vehículo <span class="exclamation" data-bs-toggle="tooltip" data-bs-placement="right" title="Ingrese el color del vehículo"></span>
                </label>
                <div class="input-group has-validation">
                  <input require type="text" class="form-control" name="colorVehiculo" id="colorVehiculo">
                  <div class="invalid-feedback">Ingrese el color del vehículo</div>
                </div>
              </div>

              <div class="col-4">
                <label for="descripcionVehiculo" class="form-label">
                  Descripción del Vehículo <span class="exclamation" data-bs-toggle="tooltip" data-bs-placement="right" title="Ingrese una descripción"></span>
                </label>
                <div class="input-group has-validation">
                  <input require type="text" class="form-control" name="descripcionVehiculo" id="descripcionVehiculo">
                  <div class="invalid-feedback">Ingrese una descripción</div>
                </div>
              </div>

              <div class="col-12 d-flex align-items-center justify-content-center">
                <div style='color:red'>
                  <?php
                  echo $error;
                  ?>
                </div>
              </div>

              <div class="pt-4 pb-2">
                <p class="text-start bold"><a style="color: red;">ATENCIÓN:</a> Una vez registrado tendrás que volver a iniciar sesión.</p>
              </div>

              <div class="col-12 d-flex align-items-center justify-content-center">
                <button class="btn btn-primary w-50" type="submit" name="submit">Registrar Información</button>
              </div>
            </form>

            <script>
              // Inicializar tooltips de Bootstrap
              var tooltips = [].slice.call(document.querySelectorAll('.exclamation'))
              var tooltipList = tooltips.map(function(tooltip) {
                return new bootstrap.Tooltip(tooltip)
              })
            </script>



          </div>
        </div>
      </div>
    </section>
  </main><!-- End #main -->

  <script>
    // Obtener referencia al input y a la imagen
    const $seleccionArchivos = document.querySelector("#imagenFletero"),
      $imagenPrevisualizacion = document.querySelector("#imagenFleteroPrev");

    // Escuchar cuando cambie
    $seleccionArchivos.addEventListener("change", () => {
      // Los archivos seleccionados, pueden ser muchos o uno
      const archivos = $seleccionArchivos.files;
      // Si no hay archivos salimos de la función y quitamos la imagen
      if (!archivos || !archivos.length) {
        $imagenPrevisualizacion.src = "";
        return;
      }
      // Ahora tomamos el primer archivo, el cual vamos a previsualizar
      const primerArchivo = archivos[0];
      // Lo convertimos a un objeto de tipo objectURL
      const objectURL = URL.createObjectURL(primerArchivo);
      // Y a la fuente de la imagen le ponemos el objectURL
      $imagenPrevisualizacion.src = objectURL;
    });


    // Obtener referencia al input y a la imagen
    const $seleccionArchivosCarnet = document.querySelector("#carnetFletero"),
      $imagenPrevisualizacionCarnet = document.querySelector("#carnetFleteroPrev");

    // Escuchar cuando cambie
    $seleccionArchivosCarnet.addEventListener("change", () => {
      // Los archivos seleccionados, pueden ser muchos o uno
      const archivos = $seleccionArchivosCarnet.files;
      // Si no hay archivos salimos de la función y quitamos la imagen
      if (!archivos || !archivos.length) {
        $imagenPrevisualizacionCarnet.src = "";
        return;
      }
      // Ahora tomamos el primer archivo, el cual vamos a previsualizar
      const primerArchivo = archivos[0];
      // Lo convertimos a un objeto de tipo objectURL
      const objectURL = URL.createObjectURL(primerArchivo);
      // Y a la fuente de la imagen le ponemos el objectURL
      $imagenPrevisualizacionCarnet.src = objectURL;
    });

    // Obtener referencia al input y a la imagen
    const $seleccionArchivosCedula = document.querySelector("#cedulaFletero"),
      $imagenPrevisualizacionCedula = document.querySelector("#cedulaFleteroPrev");

    // Escuchar cuando cambie
    $seleccionArchivosCedula.addEventListener("change", () => {
      // Los archivos seleccionados, pueden ser muchos o uno
      const archivos = $seleccionArchivosCedula.files;
      // Si no hay archivos salimos de la función y quitamos la imagen
      if (!archivos || !archivos.length) {
        $imagenPrevisualizacionCedula.src = "";
        return;
      }
      // Ahora tomamos el primer archivo, el cual vamos a previsualizar
      const primerArchivo = archivos[0];
      // Lo convertimos a un objeto de tipo objectURL
      const objectURL = URL.createObjectURL(primerArchivo);
      // Y a la fuente de la imagen le ponemos el objectURL
      $imagenPrevisualizacionCedula.src = objectURL;
    });

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
  // Función para manejar el evento de soltar
  function handleDrop(event) {
    event.preventDefault();
    event.stopPropagation();

    const files = event.dataTransfer.files;
    if (files.length > 0) {
      // Obtener el archivo
      document.getElementById('drag-and-drop-area2').classList.add('uploaded');
      document.getElementById('checkmark2').style.display = 'inline';
      document.getElementById('status2').style.display = 'inline';
    }
  }

  // Agregar el evento de arrastre y soltar al área de arrastre
  const dragAndDropArea2 = document.getElementById('drag-and-drop-area2');
  dragAndDropArea2.addEventListener('dragover', (event) => {
    event.preventDefault();
    event.stopPropagation();
    dragAndDropArea2.classList.add('dragover');
  });

  dragAndDropArea2.addEventListener('dragleave', (event) => {
    event.preventDefault();
    event.stopPropagation();
    dragAndDropArea2.classList.remove('dragover');
  });

  dragAndDropArea2.addEventListener('drop', handleDrop);

  // Agregar el evento de clic para abrir el cuadro de diálogo de selección de archivo
  const fileInput2 = document.getElementById('carnetFletero');
  dragAndDropArea2.addEventListener('click', () => {
    fileInput2.click();
  });

  // Agregar un manejador de cambio para el input de archivo
  fileInput2.addEventListener('change', (event) => {
    // Obtener el archivo
    document.getElementById('drag-and-drop-area2').classList.add('uploaded');
    document.getElementById('checkmark2').style.display = 'inline';
    document.getElementById('status2').style.display = 'inline';
  });
</script>

<script>
  // Función para manejar el evento de soltar
  function handleDrop(event) {
    event.preventDefault();
    event.stopPropagation();

    const files = event.dataTransfer.files;
    if (files.length > 0) {
      // Obtener el archivo
      document.getElementById('drag-and-drop-area3').classList.add('uploaded');
      document.getElementById('checkmark').style.display = 'inline';
      document.getElementById('status').style.display = 'inline';
    }
  }

  // Agregar el evento de arrastre y soltar al área de arrastre
  const dragAndDropArea3 = document.getElementById('drag-and-drop-area3');
  dragAndDropArea3.addEventListener('dragover', (event) => {
    event.preventDefault();
    event.stopPropagation();
    dragAndDropArea3.classList.add('dragover');
  });

  dragAndDropArea3.addEventListener('dragleave', (event) => {
    event.preventDefault();
    event.stopPropagation();
    dragAndDropArea3.classList.remove('dragover');
  });

  dragAndDropArea3.addEventListener('drop', handleDrop);

  // Agregar el evento de clic para abrir el cuadro de diálogo de selección de archivo
  const fileInput3 = document.getElementById('cedulaFletero');
  dragAndDropArea3.addEventListener('click', () => {
    fileInput3.click();
  });

  // Agregar un manejador de cambio para el input de archivo
  fileInput3.addEventListener('change', (event) => {
    // Obtener el archivo
    document.getElementById('drag-and-drop-area3').classList.add('uploaded');
    document.getElementById('checkmark3').style.display = 'inline';
    document.getElementById('status3').style.display = 'inline';
  });
</script>
<script>
  // Función para manejar el evento de soltar
  function handleDrop(event) {
    event.preventDefault();
    event.stopPropagation();

    const files = event.dataTransfer.files;
    if (files.length > 0) {
      // Obtener el archivo
      document.getElementById('drag-and-drop-area4').classList.add('uploaded');
      document.getElementById('checkmark').style.display = 'inline';
      document.getElementById('status').style.display = 'inline';
    }
  }

  // Agregar el evento de arrastre y soltar al área de arrastre
  const dragAndDropArea4 = document.getElementById('drag-and-drop-area4');
  dragAndDropArea4.addEventListener('dragover', (event) => {
    event.preventDefault();
    event.stopPropagation();
    dragAndDropArea4.classList.add('dragover');
  });

  dragAndDropArea4.addEventListener('dragleave', (event) => {
    event.preventDefault();
    event.stopPropagation();
    dragAndDropArea4.classList.remove('dragover');
  });

  dragAndDropArea4.addEventListener('drop', handleDrop);

  // Agregar el evento de clic para abrir el cuadro de diálogo de selección de archivo
  const fileInput4 = document.getElementById('vehiculoVehiculo');
  dragAndDropArea4.addEventListener('click', () => {
    fileInput4.click();
  });

  // Agregar un manejador de cambio para el input de archivo
  fileInput4.addEventListener('change', (event) => {
    // Obtener el archivo
    document.getElementById('drag-and-drop-area4').classList.add('uploaded');
    document.getElementById('checkmark4').style.display = 'inline';
    document.getElementById('status4').style.display = 'inline';
  });
</script>
<script>
  // Función para manejar el evento de soltar
  function handleDrop(event) {
    event.preventDefault();
    event.stopPropagation();

    const files = event.dataTransfer.files;
    if (files.length > 0) {
      // Obtener el archivo
      document.getElementById('drag-and-drop-area5').classList.add('uploaded');
      document.getElementById('checkmark').style.display = 'inline';
      document.getElementById('status').style.display = 'inline';
    }
  }

  // Agregar el evento de arrastre y soltar al área de arrastre
  const dragAndDropArea5 = document.getElementById('drag-and-drop-area5');
  dragAndDropArea5.addEventListener('dragover', (event) => {
    event.preventDefault();
    event.stopPropagation();
    dragAndDropArea5.classList.add('dragover');
  });

  dragAndDropArea5.addEventListener('dragleave', (event) => {
    event.preventDefault();
    event.stopPropagation();
    dragAndDropArea5.classList.remove('dragover');
  });

  dragAndDropArea5.addEventListener('drop', handleDrop);

  // Agregar el evento de clic para abrir el cuadro de diálogo de selección de archivo
  const fileInput5 = document.getElementById('seguroVehiculo');
  dragAndDropArea5.addEventListener('click', () => {
    fileInput5.click();
  });

  // Agregar un manejador de cambio para el input de archivo
  fileInput5.addEventListener('change', (event) => {
    // Obtener el archivo
    document.getElementById('drag-and-drop-area5').classList.add('uploaded');
    document.getElementById('checkmark5').style.display = 'inline';
    document.getElementById('status5').style.display = 'inline';
  });
</script>
<script>
  // Función para manejar el evento de soltar
  function handleDrop(event) {
    event.preventDefault();
    event.stopPropagation();

    const files = event.dataTransfer.files;
    if (files.length > 0) {
      // Obtener el archivo
      document.getElementById('drag-and-drop-area6').classList.add('uploaded');
      document.getElementById('checkmark').style.display = 'inline';
      document.getElementById('status').style.display = 'inline';
    }
  }

  // Agregar el evento de arrastre y soltar al área de arrastre
  const dragAndDropArea6 = document.getElementById('drag-and-drop-area6');
  dragAndDropArea6.addEventListener('dragover', (event) => {
    event.preventDefault();
    event.stopPropagation();
    dragAndDropArea6.classList.add('dragover');
  });

  dragAndDropArea6.addEventListener('dragleave', (event) => {
    event.preventDefault();
    event.stopPropagation();
    dragAndDropArea6.classList.remove('dragover');
  });

  dragAndDropArea6.addEventListener('drop', handleDrop);

  // Agregar el evento de clic para abrir el cuadro de diálogo de selección de archivo
  const fileInput6 = document.getElementById('tituloVehiculo');
  dragAndDropArea6.addEventListener('click', () => {
    fileInput6.click();
  });

  // Agregar un manejador de cambio para el input de archivo
  fileInput6.addEventListener('change', (event) => {
    // Obtener el archivo
    document.getElementById('drag-and-drop-area6').classList.add('uploaded');
    document.getElementById('checkmark6').style.display = 'inline';
    document.getElementById('status6').style.display = 'inline';
  });
</script>

<script>
  // Función para manejar el evento de soltar
  function handleDrop(event) {
    event.preventDefault();
    event.stopPropagation();

    const files = event.dataTransfer.files;
    if (files.length > 0) {
      // Obtener el archivo
      document.getElementById('drag-and-drop-area7').classList.add('uploaded');
      document.getElementById('checkmark').style.display = 'inline';
      document.getElementById('status').style.display = 'inline';
    }
  }

  // Agregar el evento de arrastre y soltar al área de arrastre
  const dragAndDropArea7 = document.getElementById('drag-and-drop-area7');
  dragAndDropArea7.addEventListener('dragover', (event) => {
    event.preventDefault();
    event.stopPropagation();
    dragAndDropArea7.classList.add('dragover');
  });

  dragAndDropArea7.addEventListener('dragleave', (event) => {
    event.preventDefault();
    event.stopPropagation();
    dragAndDropArea7.classList.remove('dragover');
  });

  dragAndDropArea7.addEventListener('drop', handleDrop);

  // Agregar el evento de clic para abrir el cuadro de diálogo de selección de archivo
  const fileInput7 = document.getElementById('patenteVehiculo');
  dragAndDropArea7.addEventListener('click', () => {
    fileInput7.click();
  });

  // Agregar un manejador de cambio para el input de archivo
  fileInput7.addEventListener('change', (event) => {
    // Obtener el archivo
    document.getElementById('drag-and-drop-area7').classList.add('uploaded');
    document.getElementById('checkmark7').style.display = 'inline';
    document.getElementById('status7').style.display = 'inline';
  });
</script>