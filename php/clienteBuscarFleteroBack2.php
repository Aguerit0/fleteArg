<?php
session_start();
$idCliente = $_SESSION['idCliente'];

include('conexion.php');
//////////////// VALORES INICIALES ///////////////////////
$sql = "SELECT * FROM fletero WHERE idCliente=$idCliente";
$ressql = mysqli_query($conexion, $sql);
if ($rowres = $ressql->fetch_assoc()) {
  $idFleteroo = $rowres['idFletero'];
  $tabla = "";
  $query = "SELECT * FROM cliente c INNER JOIN fletero f WHERE (c.idCliente=f.idCliente) AND (c.eliminadoCliente<1) AND (f.eliminadoFletero<1) ORDER BY f.puntajeFletero DESC";
  $query2 = "SELECT * FROM vehiculo v INNER JOIN fletero f 
           WHERE (v.idFletero=f.idFletero) 
           AND (v.eliminadoVehiculo < 1) 
           AND (f.eliminadoFletero < 1) 
           AND (f.idFletero != $idFleteroo) 
           ORDER BY f.puntajeFletero DESC";


  ///////// LO QUE OCURRE AL TECLEAR SOBRE EL INPUT DE BUSQUEDA ////////////
  if (isset($_POST['fletero'])) {
    $q = $conexion->real_escape_string($_POST['fletero']);
    $query = "SELECT * FROM cliente c INNER JOIN fletero f WHERE c.nombreCliente LIKE '%" . $q . "%' OR c.apellidoCliente LIKE '%" . $q . "%' ORDER BY f.puntajeFletero DESC";
    $query2 = "SELECT * FROM vehiculo v 
           INNER JOIN fletero f ON v.idFletero = f.idFletero 
           WHERE (v.tipoVehiculo LIKE '%" . $q . "%' 
                  OR v.colorVehiculo LIKE '%" . $q . "%' 
                  OR v.descripcionVehiculo LIKE '%" . $q . "%') 
           AND f.eliminadoFletero < 1 
           AND f.idFletero != $idFletero 
           ORDER BY f.puntajeFletero DESC";
  }
}else{
  $tabla = "";
  $query = "SELECT * FROM cliente c INNER JOIN fletero f WHERE (c.idCliente=f.idCliente) AND (c.eliminadoCliente<1) AND (f.eliminadoFletero<1) ORDER BY f.puntajeFletero DESC";
  $query2 = "SELECT * FROM vehiculo v INNER JOIN fletero f 
             WHERE (v.idFletero=f.idFletero) 
             AND (v.eliminadoVehiculo < 1) 
             AND (f.eliminadoFletero < 1) 
             ORDER BY f.puntajeFletero DESC";
  
  
  ///////// LO QUE OCURRE AL TECLEAR SOBRE EL INPUT DE BUSQUEDA ////////////
  if (isset($_POST['fletero'])) {
    $q = $conexion->real_escape_string($_POST['fletero']);
    $query = "SELECT * FROM cliente c INNER JOIN fletero f WHERE c.nombreCliente LIKE '%" . $q . "%' OR c.apellidoCliente LIKE '%" . $q . "%' ORDER BY f.puntajeFletero DESC";
    $query2 = "SELECT * FROM vehiculo v INNER JOIN fletero f WHERE v.tipoVehiculo LIKE '%" . $q . "%' OR v.colorVehiculo LIKE '%" . $q . "%' OR v.descripcionVehiculo LIKE '%" . $q . "%' ORDER BY f.puntajeFletero DESC ";
  }
}




$buscarFletero = $conexion->query($query2);
if ($buscarFletero->num_rows > 0) {
  //AQUÍ VAN LOS VALORES DESPUES DE HABER BUSCADO

  while ($row1 = $buscarFletero->fetch_assoc()) {
    $idFletero = $row1['idFletero'];
    $queryIdCliente = "SELECT * FROM cliente c INNER JOIN fletero f WHERE c.idCliente=f.idFletero";
    $resIdCliente = $conexion->query($queryIdCliente);
    if ($row2 = $resIdCliente->fetch_assoc()) {
      $nombreCliente = $row2['nombreCliente'];
      $apellidoCliente = $row2['apellidoCliente'];
    }
?>
    <!--EJEMPLO-->
    <div class="col-md-4" style="padding-bottom: 50px; padding-left: 15px;">
      <div class="card h-100">
        <img src="<?php echo $row1['vehiculoVehiculo'] ?>" class="card-img-top" alt="Skyscrapers" />
        <div class="card-body">
          <h5 class="card-title text-center">MARCA/MODELO</h5>
          <div class="card-text">
            <p><strong>Localidad: </strong> SFVC-Catamarca</p>
            <p><strong>Tipo: </strong> <?php echo $row1['tipoVehiculo'] ?></p>
            <p><strong>Color: </strong>: <?php echo $row1['colorVehiculo'] ?></p>
            <p><strong>Descripción: </strong>: <?php echo $row1['descripcionVehiculo']; ?></p>
          </div>
        </div>
        <div class="card-footer text-center">
          <a href="clienteAddServicio3.php?idFletero=<?php echo $idFletero ?>" class="btn btn-primary">Reservar</a>
        </div>
      </div>
    </div>
    <br><br>

    <!-- Modal de comentarios -->
    <div class="modal fade" id="comentariosModal" tabindex="-1" aria-labelledby="comentariosModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="comentariosModalLabel">Comentarios</h5><br>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p class="modal-body"><?php echo $row1['descripcionVehiculo']; ?></p>
          </div>
        </div>
      </div>
    </div>



<?php
  }
} else {
  $tabla = "No se encontraron coincidencias con sus criterios de búsqueda.";
  ?>
  <div style="width: 100%; height: 100%;" class="row text-center">
  <div class="col-md-12 text-center">
    <h2 style="color: red;">No se encontraron fleteros disponibles.</h2>
  </div>
</div>

  <?php
}


echo $tabla;
?>