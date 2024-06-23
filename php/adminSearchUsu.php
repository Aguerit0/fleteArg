<?php
require 'conexion.php';

/* Un arreglo de las columnas a mostrar en la tabla */
$columns = ['idUsuario', 'usuario', 'contraseña', 'rol', 'eliminado', 'idCliente'];

/* Nombre de la tabla */
$table = "usuario";

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
FROM usuario
WHERE 
    idUsuario LIKE '%" . $campo . "%' OR 
    usuario LIKE '%" . $campo . "%' OR 
    contraseña LIKE '%" . $campo . "%' OR 
    rol LIKE '%" . $campo . "%' OR 
    eliminado LIKE '%" . $campo . "%' OR 
    idCliente LIKE '%" . $campo . "%'
ORDER BY idUsuario ASC";

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

        $html .= '<th scope="row">' . $row['idUsuario'] . '</td>';
        $html .= '<td scope="row">' . $row['usuario'] . '</td>';
        $html .= '<td scope="row">' . $row['contraseña'] . '</td>';
        $html .= '<td scope="row">' . $row['rol'] . '</td>';
        $html .= '<td scope="row">' . $row['eliminado'] . '</td>';
        $html .= '<td scope="row">' . $row['idCliente'] . '</td>';
        $idCliente = $row['idCliente'];
        $html .= '<td scope="row"><a class="btn btn-primary" href="admUsuVerMas.php?id=' . $row['idCliente'] . '">Ver más</a></td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="7">Sin resultados</td>';
    $html .= '</tr>';
}

echo json_encode($html, JSON_UNESCAPED_UNICODE);
?>