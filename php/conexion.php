<?php 
	$servidor='localhost';
	$usuario='root';
	$clave='';
	$bd='fletear';

	$conexion=mysqli_connect($servidor,$usuario,$clave,$bd);
	if (!$conexion) {
		echo "ERROR EN LA CONEXIÓN CON EL SERVIDOR";
	}

try
    {
        $bd_conex = new PDO ('mysql:host=localhost;dbname='.$bd,$usuario,$clave,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }
    catch (Exception $e)
    {
        echo "Problema con la conexion: ".$e->getMessage();
	}

 ?>