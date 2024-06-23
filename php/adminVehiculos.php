<?php
include 'conexion.php';
session_start();
// PREGUNTA SI HAY UN USUARIO REGISTRADO
if (!isset($_SESSION['usuario'])) {
  header('Location: inicioSesion.php');
}

$idCliente = $_SESSION['idCliente'];
$eliminadoCliente=0;
$contadorWhile = 0;
//SELECT PARA VERIFICAR ROL POR LAS DUDAS NO ACTUALIZA EL DE LA VARIABLE SESSION
$sql2 = "SELECT * FROM usuario WHERE idCliente='$idCliente' ";
$res2 = mysqli_query($conexion, $sql2);
if ($row2 = $res2->fetch_assoc()) {
  $rol = $row2['rol'];
}
if ($rol !=2) {
  //mover al inicio de sesion y cerrar sesion
}else if($rol==2){
  //consultar datos
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
    <!-- CODIGO DE ALERTAS -->
    <?php
      if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'agregado')
      {
    ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Exito!</strong> Se agregó correctamente una nueva comisaria.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php
        }
    ?>
    <?php
      if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'error')
      {
    ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong> Error</strong> No se pudo agregar la nueva comisaria.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php
        }
    ?>
    <?php
      if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'eliminado')
      {
    ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Eliminado!</strong> Se eliminó correctamente la comisaria.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php
        }
    ?>

    <!--INPUT BUSCAR EN TABLAS-->
    <div class="search">
      <form method="post"><input type="text" name="campo" id="campo" placeholder="Buscar" class="rounded">
        <button type="button" class="btn btn-success float-end mb-2"data-bs-toggle="modal" data-bs-target="#staticBackdrop">
      <i class="bi bi-plus-circle-fill"></i>
      Agregar
      </button>
      </form>  
    </div><!--FIN INPUT BUSCAR EN TABLAS-->
    
    <!-- Modal AGREGAR COMISARIA -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Agregar Usuario</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="card">
              <div class="card-body">
                <!-- FORMULARIO PARA AGREGAR COMISARIA -->
                <form class="row g-3" method="post">
                  <div class="col-md-12">
                    <label for="inputName5" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombreComisaria" name="nombreComisaria">
                  </div>
                  <div class="col-md-12">
                    <label for="inputEmail5" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="direccionComisaria" name="direccionComisaria">
                  </div>
                  <div class="col-md-6">
                    <label for="inputtext5" class="form-label">Provincia</label>
                    <input type="text" class="form-control" id="provinciaComisaria" name="provinciaComisaria">
                  </div>
                  <div class="col-md-6">
                    <label for="inputtext5" class="form-label">Departamento</label>
                    <input type="text" class="form-control" id="departamentoComisaria" name="departamentoComisaria">
                  </div>
                  <div class="col-md-12">
                    <label for="inputtext5" class="form-label">Localidad</label>
                    <input type="text" class="form-control" id="localidadComisaria" name="localidadComisaria">
                  </div>
                  <div class="col-12">
                    <label for="inputAddress5" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefonoComisaria" name="telefonoComisaria">
                  </div>
                  <div class="col-md-6">
                    <label for="inputtext5" class="form-label">Latitud</label>
                    <input type="text" class="form-control" id="latitudComisaria" name="latitudComisaria">
                  </div>
                  <div class="col-md-6">
                    <label for="inputtext5" class="form-label">Longitud</label>
                    <input type="text" class="form-control" id="longitudComisaria" name="longitudComisaria">
                  </div>
                  <div class="col-md-6">
                    <label for="inputState" class="form-label">Habilitado</label>
                    <select id="habilitadoComisaria" name="habilitadoComisaria" class="form-select">
                      <option value="1" selected>Habilitado</option>
                      <option value="0">Deshabilitado</option>
                    </select>
                  </div>
                  
                  <div class="text-center">
                    <button type="submit" id="agregarComisaria" name="agregarComisaria" value="agregarComisaria" class="btn btn-primary">Agregar</button>
                  </div>
                </form><!-- End Multi Columns Form -->
  
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <!-- <button type="button" class="btn btn-primary">Understood</button> -->
          </div>
        </div>
      </div>
    </div><!--FIN MODAL AGREGEAR-->


    <!-- SEGUNDA OPCION -->
    <table class="table table-sm table-hover table-bordered text-center">
      <thead class="table-active">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">tipo</th>
            <th scope="col">color</th>
            <th scope="col">descripcion</th>
            <th scope="col">fecha reg</th>
            <th scope="col">solicitudes</th>
            <th scope="col">...</th>
          </tr>
           
          
      </thead>

    <tbody id="content">
        
      </tbody>
    </table>
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

<script>
  /* Llamando a la función getData() */
        getData()

        /* Escuchar un evento keyup en el campo de entrada y luego llamar a la función getData. */
        document.getElementById("campo").addEventListener("keyup", getData)

        /* Peticion AJAX */
        function getData() {
            let input = document.getElementById("campo").value
            let content = document.getElementById("content")
            let url = "adminSearchVeh.php"
            let formaData = new FormData()
            formaData.append('campo', input)

            fetch(url, {
                    method: "POST",
                    body: formaData
                }).then(response => response.json())
                .then(data => {
                    content.innerHTML = data
                }).catch(err => console.log(err))
        }
</script>

</html>
