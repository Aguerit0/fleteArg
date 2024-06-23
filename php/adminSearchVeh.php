<?php
require 'conexion.php';

/* Un arreglo de las columnas a mostrar en la tabla */
$columns = ['idVehiculo', 'vehiculoVehiculo', 'seguroVehiculo', 'tituloVehiculo', 'tipoVehiculo', 'colorVehiculo', 'descripcionVehiculo', 'fechaRegVehiculo', 'solicitudVehiculo', 'eliminadoVehiculo', 'idFletero'];

/* Nombre de la tabla */
$table = "vehiculo";

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
}else{
    $where = "WHERE (";

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {
        $where .= $columns[$i] . " LIKE '%" . $campo . "%' OR ";
    }
    $where = substr_replace($where, "", -4);
    $where .= ")";
}


/* Consulta */
$sql = "SELECT " . implode(", ", $columns) . "
FROM $table
$where ";
$resultado = $conexion->query($sql);
$num_rows = $resultado->num_rows;


/* Mostrado resultados */
$html = '';

if ($num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {        
        $html .= '<tr>';
        
        $html .= '<th scope="row">' . $row['idVehiculo'] . '</td>';
        $html .= '<td scope="row">' . $row['tipoVehiculo'] . '</td>';
        $html .= '<td scope="row">' . $row['colorVehiculo'] . '</td>';
        $html .= '<td scope="row">' . $row['descripcionVehiculo'] . '</td>';
        $html .= '<td scope="row">' . $row['fechaRegVehiculo'] . '</td>';
        $html .= '<td scope="row">' . $row['solicitudVehiculo'] . '</td>';
        $idVehiculo = $row['idVehiculo'];
        $html .= '<td scope="row"><a class="btn btn-primary" href="admVehVerMas.php?id=' . $row['idVehiculo'] .'">Ver más</a></td>';
        $html .= '</tr>';

    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="7">Sin resultados</td>';
    $html .= '</tr>';
}

echo json_encode($html, JSON_UNESCAPED_UNICODE);
?>