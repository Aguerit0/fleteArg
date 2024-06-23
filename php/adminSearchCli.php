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
$sql2 = "SELECT *
FROM cliente 
WHERE 
    idCliente LIKE '%" . $campo . "%' OR 
    nombreCliente LIKE '%" . $campo . "%' OR 
    apellidoCliente LIKE '%" . $campo . "%' OR 
    correoCliente LIKE '%" . $campo . "%' OR 
    dniCliente LIKE '%" . $campo . "%' OR 
    domicilioCliente LIKE '%" . $campo . "%' OR 
    telefonoCliente LIKE '%" . $campo . "%' OR 
    fechaNacCliente LIKE '%" . $campo . "%' OR 
    sexoCliente LIKE '%" . $campo . "%' OR 
    fechaRegCliente LIKE '%" . $campo . "%' OR 
    eliminadoCliente LIKE '%" . $campo . "%'
ORDER BY idCliente ASC";
$sql = "SELECT " . implode(", ", $columns) . "
FROM $table
$where ";
$resultado = $conexion->query($sql2);
$num_rows = $resultado->num_rows;


/* Mostrado resultados */
$html = '';

if ($num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {        
        $html .= '<tr >';
        
        $html .= '<th scope="row">' . $row['idCliente'] . '</td>';
        $html .= '<td scope="row">' . $row['nombreCliente'] . '</td>';
        $html .= '<td scope="row">' . $row['apellidoCliente'] . '</td>';
        $html .= '<td scope="row">' . $row['correoCliente'] . '</td>';
        $html .= '<td scope="row">' . $row['dniCliente'] . '</td>';
        $html .= '<td scope="row">' . $row['domicilioCliente'] . '</td>';
        $idCliente = $row['idCliente'];
        $html .= '<td scope="row"><a class="btn btn-primary" href="admCliVerMas.php?id=' . $row['idCliente'] .'">Ver más</a></td>';
        $html .= '</tr>';

    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="7">Sin resultados</td>';
    $html .= '</tr>';
}

echo json_encode($html, JSON_UNESCAPED_UNICODE);
