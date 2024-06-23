<?php
require 'conexion.php';

/* Un arreglo de las columnas a mostrar en la tabla */
$columns = ['idFletero', 'imagenFletero', 'descripcionFletero', 'carnetFletero', 'cedulaFletero', 'cantidadVehiculosFletero', 'cantidadViajesFletero', 'puntajeFletero', 'actividadFletero', 'eliminadoFletero', 'idCliente'];

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
        
        $html .= '<th scope="row">' . $row['idFletero'] . '</th>';
        $html .= '<td scope="row">' . $row['descripcionFletero'] . '</td>';
        $html .= '<td scope="row">' . $row['cantidadVehiculosFletero'] . '</td>';
        $html .= '<td scope="row">' . $row['cantidadViajesFletero'] . '</td>';
        $html .= '<td scope="row">' . $row['puntajeFletero'] . '</td>';
        $html .= '<td scope="row">' . $row['eliminadoFletero'] . '</td>';
        $idFletero = $row['idFletero'];
        $html .= '<td scope="row"><a class="btn btn-primary" href="admFleVerMas.php?id=' . $row['idFletero'] .'">Ver más</a></td>';
        $html .= '</tr>';

    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="7">Sin resultados</td>';
    $html .= '</tr>';
}

echo json_encode($html, JSON_UNESCAPED_UNICODE);
?>