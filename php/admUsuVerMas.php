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
  //EXTRAER ID 
  $idUsuario = $_GET['id'];
  //consulta para extraer todos los datos de ese usuario de nuevo
  $sqlUsu = "SELECT * FROM usuario WHERE idUsuario=$idUsuario";
  $resUsu = mysqli_query($conexion, $sqlUsu);
  if($rowUsu = $resUsu->fetch_assoc()){
    $idUsuario = $rowUsu['idUsuario'];
    $usuario = $rowUsu['usuario'];
    $contraseña = $rowUsu['contraseña'];
    $rol = $rowUsu['rol'];
    $eliminado = $rowUsu['eliminado'];
    $idCliente = $rowUsu['idCliente'];
  }
}
if(isset($_POST['guardar'])){
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
        if(confirm("Usuario modificado con éxito!! ¿Desea ir a otra página?")) {
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
  <div class="container">
    <h1>Editar Usuario</h1>
    <form method="POST">
      <div class="row">
        <div class="col-md-6">
          <label for="inputUsuario">Usuario</label>
          <input type="text" class="form-control" id="inputUsuario" name="inputUsuario" value="<?php echo $usuario; ?>">
        </div>
        <div class="col-md-6">
          <label for="inputContraseña">Contraseña</label>
          <input type="text" class="form-control" id="inputContraseña" name="inputContraseña" value="<?php echo $contraseña; ?>">
        </div>
        <div class="form-group col-md-6">
          <label for="inputRol">Rol</label>
          <input type="text" class="form-control" id="inputRol" name="inputRol" value="<?php echo $rol; ?>">
        </div>
        <div class="form-group col-md-6">
          <label for="inputEliminado">Eliminado</label>
          <input type="text" class="form-control" id="inputEliminado" name="inputEliminado" value="<?php echo $eliminado; ?>">
        </div>
        <div class="form-group col-md-6">
          <label for="inputIdCliente">ID Cliente</label>
          <input type="text" class="form-control" id="inputIdCliente" name="inputIdCliente" value="<?php echo $idCliente; ?>">
        </div>
        <div class="form-group col-md-6">
          <label for="inputId">ID Usuario</label>
          <input type="text" class="form-control" id="inputIdUsuario" name="inputIdUsuario" value="<?php echo $idUsuario; ?>">
        </div>
      </div>
      <div class="row text-center">
        <div class="form-group col-md-12 justify-content-center">
            <br>
          <button type="submit" class="btn btn-primary btn-block" name="guardar">Guardar</button>
        </div>
      </div>
    </form>
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
