<?php
require 'conexion.php';
//consulta para update
if (isset($_POST['confirmar'])) {
    $idServicioConfirmar = $_POST['idServicio'];
    $sqlUpdate = "UPDATE servicio SET estadoServicio='confirmado'";
    if ($conexion->query($sqlUpdate) == true) {
        echo "Campo actualizado con éxito.";
        header("Location: adminServicios.php");
    } else {
        echo "Error al actualizar el campo.";
    }
}

/* Un arreglo de las columnas a mostrar en la tabla */
$columns = ['idFletero', 'imagenFletero', 'descripcionFletero', 'carnetFletero', 'cedulaFletero', 'cantidadVehiculosFletero', 'cantidadViajesFletero', 'puntajeFletero', 'actividadFletero', 'eliminadoFletero'];

/* Nombre de la tabla */
$table = "fletero";

$campo = isset($_POST['campo']) ? $conexion->real_escape_string($_POST['campo']) : null;


/* Filtrado */
$where = '';

if ($campo != null) {
    $where = "WHERE (";

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {
        $where .= $columns[$i] . " LIKE '%" . $campo . "%' OR ";
    }
    $where = substr_replace($where, "", -4);
    $where .= ")";
} else {
    $where = "WHERE (";

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {
        $where .= $columns[$i] . " LIKE '%" . $campo . "%' OR ";
    }
    $where = substr_replace($where, "", -4);
    $where .= ")";
}


/* Consulta */
$sql2 = "SELECT *
FROM servicio 
WHERE 
idServicio LIKE '%" . $campo . "%' OR 
    precioServicio LIKE '%" . $campo . "%' OR 
    metodoPagoServicio LIKE '%" . $campo . "%' OR 
    fechaSalidaServicio LIKE '%" . $campo . "%' OR 
    fechaLlegadaServicio LIKE '%" . $campo . "%' OR 
    estadoServicio LIKE '%" . $campo . "%' OR 
    ubicacionSalidaServicio LIKE '%" . $campo . "%' OR 
    ubicacionLlegadaServicio LIKE '%" . $campo . "%' OR 
    distanciaServicio LIKE '%" . $campo . "%' OR 
    tiempoServicio LIKE '%" . $campo . "%' OR 
    descripcionServicio LIKE '%" . $campo . "%'
ORDER BY idServicio ASC";
$sql = "SELECT " . implode(", ", $columns) . "
FROM $table
$where ";
$resultado = $conexion->query($sql2);
$num_rows = $resultado->num_rows;


/* Mostrado resultados */
$html = '';

if ($num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $html .= '<tr>';

        $html .= '<th scope="row">' . $row['idServicio'] . '</th>';
        $html .= '<td scope="row">' . $row['precioServicio'] . '</td>';
        $html .= '<td scope="row">' . $row['metodoPagoServicio'] . '</td>';
        $html .= '<td scope="row">' . $row['estadoServicio'] . '</td>';
        $html .= '<td scope="row">' . $row['distanciaServicio'] . '</td>';
        $html .= '<td scope="row">' . $row['descripcionServicio'] . '</td>';
        $idServicio = $row['idServicio'];
        $html .= '<td scope="row">
            <a class="btn btn-primary" href="admServVerMas.php?id=' . $row['idServicio'] . '">Ver más</a>
            <div class="btn-group">
                <form method="post" action="adminSearchServ.php">
                    <input type="hidden" name="idServicio" value="' . $row['idServicio'] . '">
                    <button type="submit" class="btn btn-success" name="confirmar">Confirmar</button>
                </form>
            </div>
          </td>';


        $html .= '</tr>';
    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="7">Sin resultados</td>';
    $html .= '</tr>';
}

echo json_encode($html, JSON_UNESCAPED_UNICODE);
