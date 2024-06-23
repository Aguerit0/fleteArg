<?php

include 'conexion.php';
session_start();
// PREGUNTA SI HAY UN USUARIO REGISTRADO
if (!isset($_SESSION['usuario'])) {
    header('Location: inicioSesion.php');
}

$error = "";
//EXTRAIGO idFletero que viene del boton
$idFletero = $_GET['idFletero'];
//EXTRAIGO idCliente de Variables de sesion
$idCliente = $_SESSION['idCliente'];
//SQL4: SELECT PARA VER INFORMACIÓN DEL VEHICULO
$sql4 = "SELECT * FROM vehiculo WHERE idFletero='$idFletero'";
$res4 = mysqli_query($conexion, $sql4);
if ($row4 = $res4->fetch_assoc()) {
    $vehiculoVehiculo = $row4['vehiculoVehiculo'];
    $tipoVehiculo = $row4['tipoVehiculo'];
    $colorVehiculo = $row4['colorVehiculo'];
    $descripcionVehiculo = $row4['descripcionVehiculo'];
    $eliminadoVehiculo = $row4['eliminadoVehiculo'];
    $idVehiculo = $row4['idVehiculo'];
}
//SQL1: SELECT PARA VER IMAGEN DEL FLETERO
$sql1 = "SELECT * FROM fletero WHERE idFletero='$idFletero'";
$res1 = mysqli_query($conexion, $sql1);
if ($row1 = $res1->fetch_assoc()) {
    $imagenFletero = $row1['imagenFletero'];
    //recupero id cliente
    $idClienteFletero = $row1['idCliente'];
    $acividadFletero = $row1['actividadFletero'];
}

//SQL2: SELECT PARA VER INFO DEL FLETERO
$sql2 = "SELECT * FROM cliente WHERE idCliente='$idCliente'";
$res2 = mysqli_query($conexion, $sql2);
if ($row2 = $res2->fetch_assoc()) {
    $nombreFletero = $row2['nombreCliente'];
    $apellidoFletero = $row2['apellidoCliente'];
    $fechaNacFletero = $row2['fechaNacCliente'];
    $sexoFletero = $row2['sexoCliente'];
    if ($sexoFletero == 0) {
        $sexoFletero = 'Hombre';
    } elseif ($sexoFletero == 1) {
        $sexoFletero = 'Mujer';
    } else {
        $sexoFletero = 'No Binario';
    }
    $edadFletero = edad($fechaNacFletero);
}

//función para saber edad
function edad($fecNac)
{
    // Calcular la edad en base a la fecha de nacimiento
    $fecha_actual = new DateTime();
    $fecha_nacimiento = new DateTime($fecNac);
    $edad = $fecha_actual->diff($fecha_nacimiento)->y;
    return $edad;
}



if (isset($_POST['reservar'])) {

    $tipoEncomienda = $_POST["tipo_encomienda"];
    $cantidadElementos = $_POST["cantidad_elementos"];
    $descripcion = $_POST["descripcion"];
    $desdeInput = $_POST["desdeInput"];
    $hastaInput = $_POST["hastaInput"];
    $distanciaInput = $_POST["distanciaInput"];
    $tiempoAproxInput = $_POST["tiempoAproxInput"];
    $tipoPago = $_POST["tipoPago"];
    $precioNeto = $_POST["precioNeto"];
    $tipoVehiculo = $_POST["tipoVehiculo"];
    $colorVehiculo = $_POST["colorVehiculo"];
    $descripcionVehiculo = $_POST["descripcionVehiculo"];
    $nombreFletero = $_POST["nombreFletero"];
    $apellidoFletero = $_POST["apellidoFletero"];
    $sexoFletero = $_POST["sexoFletero"];
    $edadFletero = $_POST["edadFletero"];

    //update cantidad de viajes y puntos fletero
    $sql2 = "INSERT INTO servicio(precioServicio, metodoPagoServicio, fechaSalidaServicio, fechaLlegadaServicio, estadoServicio, ubicacionSalidaServicio, ubicacionLlegadaServicio, distanciaServicio, tiempoServicio, descripcionServicio , idCliente, idFletero, idVehiculo) VALUES ('$precioNeto', '$tipoPago', NOW(), '--', 'pendiente', '$desdeInput', '$hastaInput','$distanciaInput','$tiempoAproxInput', '$descripcion', '$idCliente', '$idFletero','$idVehiculo')";
    $sql5 = "UPDATE fletero SET cantidadViajesFletero=cantidadViajesFletero+1, puntajeFletero=puntajeFletero+5 WHERE idFletero=$idFletero";
    $res5 = mysqli_query($conexion, $sql5);

    if (mysqli_query($conexion, $sql2)) {
?>
        <script>
            emailjs.init("M2BOaA7RdLIh3rGzY");

            const templateParams = {
                reply_to: "FleteAr - confirmar servicio",
                from_name: " -- ", 
                message: `
        Tipo de Encomienda: ${tipoEncomienda}
        Cantidad de Elementos: ${cantidadElementos}
        Descripción: ${descripcion}
        Desde: ${desdeInput}
        Hasta: ${hastaInput}
        Distancia: ${distanciaInput}
        Tiempo Aproximado: ${tiempoAproxInput}
        Tipo de Pago: ${tipoPago}
        Precio Neto: ${precioNeto}
        Tipo de Vehículo: ${tipoVehiculo}
        Color del Vehículo: ${colorVehiculo}
        Descripción del Vehículo: ${descripcionVehiculo}
        Nombre del Fletero: ${nombreFletero}
        Apellido del Fletero: ${apellidoFletero}
        Sexo del Fletero: ${sexoFletero}
        Edad del Fletero: ${edadFletero}
    `
};

            const serviceID = 'default_service';
            const templateID = 'template_9u4yd64';

            emailjs.send(serviceID, templateID, templateParams)
                .then(function(response) {
                    console.log("Mensaje enviado con éxito!", response);
                })
                .catch(function(error) {
                    console.log("Error al enviar el mensaje:", error);
                });
            alert("CARGADO");
        </script>
<?php
        sleep(3);
        header('location: inicio.php');
        exit();
    } else {
        echo "Error al insertar datos: " . mysqli_error($conexion);
        header('location: inicio.php');
        mysqli_close($conn);
    }
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

    <!-- Mapbox api-->
    <link href="https://api.mapbox.com/mapbox-gl-js/v1.11.0/mapbox-gl.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.css" type="text/css" />
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.2/mapbox-gl-directions.css" type="text/css" />
    <!-- Incluye la librería de Mapbox -->
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.5.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.5.1/mapbox-gl.css' rel='stylesheet' />

    <!-- Incluye el geocodificador de Mapbox -->
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.min.js'></script>
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.css' type='text/css' />

    <!-- Biblioteca de estilos de Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Biblioteca de JavaScript de Bootstrap (requiere jQuery) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://cdn.emailjs.com/dist/email.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
    <link href="assets/css/style.css" rel="stylesheet">

    <style>
        .fa-map-marker-alt,
        .fa-dot-circle {
            color: #5bc0de;
        }

        /*Jumbotron*/
        .jumbotron {
            background-color: transparent;
            margin: 0;
            padding: 10px;
            color: white;

        }

        .jumbotron h1 {
            color: white;
            letter-spacing: 2.5px;
            font-size: 3.5em;
        }

        .jumbotron h1,
        .jumbotron p {
            color: white;

            text-align: center;
        }


        /*output box*/
        #output {
            text-align: center;
            font-size: 2em;
            margin: 20px auto;
            color: white;

        }

        #mode {
            color: white;
        }

        .img-profile {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            object-position: center;
        }

        /*Mapbox css*/
        .mapbox-directions-profiles .mapbox-directions-profile-option:not([data-profile="driving"]) {
            display: none;
        }

        #map {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
        }

        #map-container {
            position: relative;
            width: 100%;
            height: 400px;
            margin-top: 60px;
        }

        #distanceInput,
        #durationInput {
            margin-top: 10px;
        }

        #info-container {
            text-align: start;
        }

        /*Modal tarifas*/
        .modal-header .btn-close {
            color: red;
        }

        .start {
            background: #2c2d2e;
        }

        .splashScreen {
            position: absolute;

        }

        .start .splashHeader {
            margin-top: 100px;
            color: #fff;
            text-align: center;
            font-family: Verdana, arial, helvetica, geneva, sans-serif !important;
        }

        .folding-map {
            margin: 20px auto;
            width: 150px;
            height: 150px;
            position: relative;
        }

        .folding-map-rotated {
            -webkit-transform: rotateZ(45deg);
            transform: rotateZ(45deg);
        }

        .folding-map .map-tile {
            float: left;
            width: 50%;
            height: 50%;
            position: relative;
            -webkit-transform: scale(1.1);
            -ms-transform: scale(1.1);
            transform: scale(1.1);
        }

        .folding-map .map-tile:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #c3c3c3;
            -webkit-animation: map-fold 2.4s infinite linear both;
            animation: map-fold 2.4s infinite linear both;
            -webkit-transform-origin: 100% 100%;
            -ms-transform-origin: 100% 100%;
            transform-origin: 100% 100%;
            background-size: 100%;
            border-top-left-radius: 5px;
        }

        .map-tile-1:before {
            background-image: url(http://server.arcgisonline.com/arcgis/rest/services/Canvas/World_Dark_Gray_Base/MapServer/tile/13/2685/4400);
        }

        .map-tile-2:before {
            background-image: url(http://server.arcgisonline.com/arcgis/rest/services/Canvas/World_Dark_Gray_Base/MapServer/tile/13/2685/4401);
        }

        .map-tile-3:before {
            background-image: url(http://services.arcgisonline.com/arcgis/rest/services/Canvas/World_Dark_Gray_Base/MapServer/tile/13/2686/4401);
        }

        .map-tile-4:before {
            background-image: url(http://services.arcgisonline.com/arcgis/rest/services/Canvas/World_Dark_Gray_Base/MapServer/tile/13/2686/4400);
        }

        .folding-map .map-tile-2 {
            -webkit-transform: scale(1.1) rotateZ(90deg);
            transform: scale(1.1) rotateZ(90deg);
        }

        .folding-map .map-tile-3 {
            -webkit-transform: scale(1.1) rotateZ(180deg);
            transform: scale(1.1) rotateZ(180deg);
        }

        .folding-map .map-tile-4 {
            -webkit-transform: scale(1.1) rotateZ(270deg);
            transform: scale(1.1) rotateZ(270deg);
        }

        .folding-map .map-tile-2:before {
            -webkit-animation-delay: 0.3s;
            animation-delay: 0.3s;
        }

        .folding-map .map-tile-3:before {
            -webkit-animation-delay: 0.6s;
            animation-delay: 0.6s;
        }

        .folding-map .map-tile-4:before {
            -webkit-animation-delay: 0.9s;
            animation-delay: 0.9s;
        }

        @-webkit-keyframes map-fold {

            0%,
            10% {
                -webkit-transform: perspective(140px) rotateX(-180deg);
                transform: perspective(140px) rotateX(-180deg);
                opacity: 0;
            }

            25%,
            75% {
                -webkit-transform: perspective(140px) rotateX(0deg);
                transform: perspective(140px) rotateX(0deg);
                opacity: 1;
            }

            90%,
            100% {
                -webkit-transform: perspective(140px) rotateY(180deg);
                transform: perspective(140px) rotateY(180deg);
                opacity: 0;
            }
        }

        @keyframes map-fold {

            0%,
            10% {
                -webkit-transform: perspective(140px) rotateX(-180deg);
                transform: perspective(140px) rotateX(-180deg);
                opacity: 0;
            }

            25%,
            75% {
                -webkit-transform: perspective(140px) rotateX(0deg);
                transform: perspective(140px) rotateX(0deg);
                opacity: 1;
            }

            90%,
            100% {
                -webkit-transform: perspective(140px) rotateY(180deg);
                transform: perspective(140px) rotateY(180deg);
                opacity: 0;
            }
        }

        .map-animation {
            position: relative;
            animation: map-pulse 4s infinite;
            width: 16px;
            border-radius: 50%;
        }

        .map-location {
            height: 16px;
            width: 16px;
            background: #2A88E6;
            border: 4px solid white;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
            position: relative;
        }

        @keyframes map-pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(25, 118, 210, .40);
            }

            50% {
                box-shadow: 0 0 0 40px rgba(25, 118, 210, 0);
            }

            100% {
                box-shadow: 0 0 0 40px transparent;
            }
        }

        .row {
            display: flex;
        }

        .container2 {
            position: relative;
            margin: auto;
            align-items: end;
            align-content: end;
            text-align: end;
        }

        .map2 {
            display: block;
            width: 4.7rem;
            height: 4.7rem;
            position: relative;
            margin: 0 auto;
            background: url(http://denis-creative.com/wp-content/uploads/2018/05/map2.png) center center no-repeat;
            background-size: cover;
            border-radius: 50%;
            box-sizing: border-box;
        }

        .map__pin2 {
            display: block;
            width: 2.6rem;
            height: auto;
            position: absolute;
            bottom: 0.5rem;
            left: 50%;
            transform: translateX(-50%);
            animation: map-pin 0.5s ease infinite;
        }

        .map__pin_shadow2 {
            display: block;
            width: 2.37rem;
            height: auto;
            position: absolute;
            bottom: 0.5rem;
            left: 50%;
            transform: translate(-50%, 50%);
            animation: map-pin-shadow 0.5s ease infinite;
        }

        @keyframes map-pin {
            50% {
                bottom: 0.9rem;
            }
        }

        @keyframes map-pin-shadow {
            50% {
                width: 1.6rem;
            }
        }

        .circle0 {
            display: block;
            width: calc(4.7rem - 0.12rem);
            height: calc(4.7rem - 0.12rem);
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 0.06rem solid #6bafde;
            border-radius: 50%;
            animation: outer 3s ease-out infinite;
        }

        .circle-2 {
            animation-delay: 1s;
        }

        .circle-3 {
            animation-delay: 2s;
        }

        @keyframes outer {
            100% {
                width: 5.7rem;
                height: 5.7rem;
                opacity: 0.1;
            }
        }

        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Ajustar el tamaño y el espaciado del contenido */
        }

        .title {
            font-size: 36px;
            color: #012970;
            font-weight: bold;
            margin-bottom: 20px;
            /* Ajustar tamaño y estilo del título */
        }

        .subtitle {
            font-size: 18px;
            color: black;
            margin-bottom: 10px;
            /* Ajustar tamaño y estilo del subtítulo */
        }

        .text-start {
            color: black;
            /* Ajustar el color del texto */
        }


        /* Estilos para los datos de salida */
        #info-container {
            text-align: left;
            color: black;
            /* Ajustar según sea necesario para la sección de información */
        }

        #tarifasLink {
            color: blue;
        }

        /* Ajustar según sea necesario para el botón "Continuar" */
        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
        }

        .mapbox-directions-control-instructions {
            display: none;
        }

        /* Estilo personalizado para el encabezado h1 en el resumen de la ruta */
        .mapbox-directions-route-summary h1 {
            font-size: 1.5em;
            /* Puedes ajustar el tamaño del texto según tus preferencias */
            margin: 0;
            /* Elimina cualquier margen que pueda afectar la apariencia */
            padding: 0;
            /* Elimina cualquier espacio de relleno que pueda afectar la apariencia */
        }

        /* Ocultar el div que contiene las opciones de perfil */
        .mapbox-directions-profile {
            display: none;
        }

        /* Ocultar la atribución en la esquina inferior derecha */
        .mapboxgl-ctrl-bottom-right {
            display: none;
        }
    </style>
</head>

<body>

    <!-- ======= Header ======= -->
    <?php include("./template/header.php") ?>

    <!-- ======= Sidebar ======= -->
    <?php if ($_SESSION['rol'] == 2) {
        include("./template/adminNav.php");
    } else if ($_SESSION['rol'] == 1) {
        include("./template/fleteroNav.php");
    } else if ($_SESSION['rol'] == 0) {
        include("./template/clienteNav.php");
    }
    ?>

    <main id="main" class="main">
        <section class="section dashboard card text-black">
            <div class="jumbotron">
                <h2 style="color: black;" class="title">Contratar Fletero</h2>
                <p style="color: black; align-items: start; align-content: start; text-align: start;" class="subtitle">Ingrese la ubicación de salida (A) y llegada (B) en el siguiente mapa.</p>
                <p style="color: #645CAA;" class="text-start">(recuerde que puede arrastrar los marcadores para mayor precisión).</p>
            </div>
            <div class="container-fluid">
                <div id="map-container">
                    <div id="map"></div>
                </div>
            </div>
            <section>
                <div class="container">
                    <form class="row g-3 needs-validation" id="miFormulario" method="POST" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="text-start mb-3">Datos de tus productos</h4>
                                <div class="form-group">
                                    <label for="tipo_encomienda">Tipo de encomienda:</label>
                                    <select class="form-control" id="tipo_encomienda" name="tipo_encomienda">
                                        <option value="mensajeria">Mensajería</option>
                                        <option value="mudanza">Mudanza</option>
                                        <option value="productos">Producto/s</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="cantidad_elementos">Cantidad de kilogramos (aprox):</label>
                                    <input type="range" class="form-control-range" id="cantidad_elementos" name="cantidad_elementos" min="1" max="9999" oninput="updateMensaje();">
                                    <div class="mt-2">
                                        <span style="color: black;" id="mensaje_elementos">0 kg</span>
                                    </div>
                                </div>
                                <!-- Resto de tu formulario y campos de entrada -->
                                <div class="form-group">
                                    <label for="descripcion">Descripción:</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" maxlength="200" rows="3" placeholder="Descripción de la mudanza (máximo 200 caracteres)"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4 class="text-start mb-3">Datos del Viaje</h4>
                                <div class="form-group">
                                    <label for="desde"><i class="bi bi-pin-map"></i> Desde</label>
                                    <input readonly type="text" class="form-control" id="desdeInput" name="desdeInput" value="" placeholder="ubicación de salida">
                                </div>
                                <div class="form-group">
                                    <label for="hasta"><i class="bi bi-pin-map-fill"></i> Hasta</label>
                                    <input readonly type="text" class="form-control" id="hastaInput" name="hastaInput" value="" placeholder="Ubicación de llegada">
                                </div>
                                <div class="form-group">
                                    <label for="distancia"><i class="bi bi-map"></i> Distancia (km)</label>
                                    <input readonly type="text" class="form-control" id="distanciaInput" name="distanciaInput" value="" placeholder="Distancia total a recorrer">
                                </div>
                                <div class="form-group">
                                    <label for="tiempoAprox"><i class="bi bi-clock"></i> Tiempo aprox (minutos)</label>
                                    <input readonly type="text" class="form-control" id="tiempoAproxInput" name="tiempoAproxInput" value="" placeholder="Tiempo aproximado" require>
                                    <input type="hidden" id="tipoVehiculo" name="tipoVehiculo" value="<?= $tipoVehiculo ?>">
                                    <input type="hidden" id="colorVehiculo" name="colorVehiculo" value="<?= $colorVehiculo ?>">
                                    <input type="hidden" id="descripcionVehiculo" name="descripcionVehiculo" value="<?= $descripcionVehiculo ?>">
                                    <input type="hidden" id="nombreFletero" name="nombreFletero" value="<?= $nombreFletero ?>">
                                    <input type="hidden" id="apellidoFletero" name="apellidoFletero" value="<?= $apellidoFletero ?>">
                                    <input type="hidden" id="sexoFletero" name="sexoFletero" value="<?= $sexoFletero ?>">
                                    <input type="hidden" id="edadFletero" name="edadFletero" value="<?= $edadFletero ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tipoPago">Tipo de Pago</label>
                                    <select class="form-control" id="tipoPago" name="tipoPago">
                                        <option value="debito">Debito (+10%)</option>
                                        <option value="transferencia">Transferencia </option>
                                        <option value="mercadopago">Mercado Pago (+5%)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <!-- Elemento para mostrar el precio estimado -->
                                <div class="form-group">
                                    <label for="precioNeto">Precio NETO (en pesos)</label>
                                    <input readonly type="text" class="form-control" id="precioNeto" name="precioNeto" value="" placeholder="Precio neto">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary" id="reservar" name="reservar">Reservar</button>
                            </div>
                        </div>
                    </form>

                </div>
            </section>
        </section>
    </main>
    <footer class="text-white" style="background-color: #645CAA; color: #ffffff; display: flex; justify-content: space-between; ">
        <div class="d-flex align-items-center">
            <!-- Section: Social media -->
            <section style="padding: 0px; display: flex; align-items: center;">
                <!-- Facebook -->
                <a class="btn btn-link btn-floating btn-lg text-dark m-1" href="#!" role="button" data-mdb-ripple-color="dark"><i style="color: #ffffff;" class="bi bi-facebook"></i></a>

                <!-- Twitter -->
                <a class="btn btn-link btn-floating btn-lg text-dark m-1" href="#!" role="button" data-mdb-ripple-color="dark"><i style="color: #ffffff;" class="bi bi-twitter"></i></a>

                <!-- Instagram -->
                <a class="btn btn-link btn-floating btn-lg text-dark m-1" href="#!" role="button" data-mdb-ripple-color="dark"><i style="color: #ffffff;" class="bi bi-instagram"></i></a>

                <!-- Linkedin -->
                <a class="btn btn-link btn-floating btn-lg text-dark m-1" href="#!" role="button" data-mdb-ripple-color="dark"><i style="color: #ffffff;" class="bi bi-linkedin"></i></a>
            </section>
            <!-- Section: Social media -->
        </div>

        <div class="text-end p-3">
            © 2023 Copyright:
            <a style="color: #ffffff;" class="text-white" href="#">Company, Inc. All rights reserved.</a>
        </div>
    </footer>



    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.min.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/css/style.css"></script>
    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/v1.11.0/mapbox-gl.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js"></script>

    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.2/mapbox-gl-directions.js"></script>

    <!-- Mercado Pago -->
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</body>

</html>

<script>
    var distance = 0;
    var duration = 0;
    // Mapbox API
    mapboxgl.accessToken = 'pk.eyJ1IjoiYWd1ZXJpdG8iLCJhIjoiY2xqeGtuYjgwMXRiYzNtbzg2eDYwcTJrbCJ9.HNAfAr5C0oHrNiXlYXN7mg';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/dark-v11',
        center: [-65.779, -28.469],
        zoom: 14
    });

    map.on('load', function() {
        var directionsControl = new MapboxDirections({
            accessToken: mapboxgl.accessToken,
            unit: 'metric',
            language: 'es',
            alternative: false,
            geocoder: new MapboxGeocoder({
                accessToken: mapboxgl.accessToken,
                countries: 'ar',
                mapboxgl: mapboxgl
            })
        }, 'top-right');

        map.addControl(directionsControl, 'top-right');

        directionsControl.on('route', function(e) {
            var route = e.route[0];
            var steps = route.legs[0].steps;

            distance = route.distance / 1000;
            duration = route.duration / 60;

            var tarifaBase = 200;
            var tarifaPorKm = 100;
            var tarifaPorMinuto = 20;

            var precioKilometros = distance * tarifaPorKm;
            var precioMinutos = duration * tarifaPorMinuto;
            var precioFinal = tarifaBase + precioKilometros + precioMinutos;

            var directionsContainer = document.querySelector('.mapbox-directions-instructions');
            directionsContainer.style.display = 'none';


            var pointALat = steps[0].intersections[0].location[1];
            var pointALng = steps[0].intersections[0].location[0];

            var lastStepIndex = steps.length - 1;
            var lastIntersectionIndex = steps[lastStepIndex].intersections.length - 1;
            var pointBLat = steps[lastStepIndex].intersections[lastIntersectionIndex].location[1];
            var pointBLng = steps[lastStepIndex].intersections[lastIntersectionIndex].location[0];
            document.getElementById('desdeInput').value = "lat: " + pointALat + " / long: " + pointALng;
            document.getElementById('hastaInput').value = "lat: " + pointBLat + " / long: " + pointBLng;
            document.getElementById('distanciaInput').value = distance.toFixed(2);
            document.getElementById('tiempoAproxInput').value = duration.toFixed(2);
            //document.getElementById('precioInput').value = precioFinal.toFixed(2);



            //getAddressFromCoordinates(pointALat, pointALng, 'pointAAddress', steps[0].intersections[0]);
            //getAddressFromCoordinates(pointBLat, pointBLng, 'pointBAddress', steps[lastStepIndex].intersections[lastIntersectionIndex]);

            // Actualizar los valores en los campos de entrada

            updatePrecio(distance, duration);

        });

        function getAddressFromCoordinates(lat, lng, outputElementId, intersection) {
            let geocoder = new MapboxGeocoder({
                accessToken: mapboxgl.accessToken,
                countries: 'ar',
                language: 'es',
            });
            geocoder.query({
                lng: lng,
                lat: lat
            }, function(result) {
                console.log(result);
                if (result && result.features && result.features.length > 0) {
                    let address = result.features[0].place_name;
                    let streetName = getAddressComponent(result.features[0], 'route');
                    let streetNumber = getAddressComponent(intersection, 'address');
                    let fullAddress = streetName + ' ' + streetNumber;

                    document.getElementById(outputElementId).textContent = fullAddress;
                } else {
                    document.getElementById(outputElementId).textContent = "Dirección no encontrada.";
                }
            });
        }

        function getAddressComponent(feature, type) {
            let component = feature.context.find(function(c) {
                return c.id.includes(type);
            });
            return component ? component.text : '';
        }
    });


    // 
    const slider = document.getElementById("cantidad_elementos");
    const mensajeElementos = document.getElementById("mensaje_elementos");
    const tipoPago = document.getElementById("tipoPago");


    function updateMensaje() {
        const valorKilogramos = parseFloat(slider.value);
        mensajeElementos.textContent = valorKilogramos + " kg";
        updatePrecio(distance, duration);
    }
    slider.addEventListener("input", updateMensaje);


    function updatePrecio(distance, duration) {
        const tipoEncomienda = document.getElementById("tipo_encomienda").value;
        const kilogramos = parseInt(document.getElementById("cantidad_elementos").value);
        const tipoPago = parseInt(document.getElementById("tipoPago").value);
        let precioNeto = 0;


        precioNeto = kilogramos * 5 + distance * 0.1 + duration * 2;

        if (tipoPago === 0) {
            precioNeto *= 1.1;
        } else if (tipoPago === 2) {
            precioNeto *= 1.05;
        }
        document.getElementById('precioNeto').value = precioNeto.toFixed(2);
    }

    updateMensaje();
</script>

</script>

<?php
// SDK de Mercado Pago
require 'mercadoPago/vendor/autoload.php';
// Agrega credenciales
MercadoPago\SDK::setAccessToken('TEST-533157210180086-071520-b470f367f441a8cf124c96e6edfa8f1d-526985919');


// Crea un objeto de preferencia
$preference = new MercadoPago\Preference();

// Crea un ítem en la preferencia
$item = new MercadoPago\Item();
$item->title = 'Mi producto';
$item->quantity = 1;
$item->unit_price = 75.56;
$item->currency_id = 'ARS';

$preference->items = array($item);
$preference->back_urls = array(
    "success" => "http://localhost/PROYECTOS/mp/captura.php",
    "failure" => "http://localhost/PROYECTOS/mp/fallo.php",
);
$preference->auto_return = "approved";
$preference->binary_mode = true;

$preference->save();
?>
<script>
    //TODO DE MERCADO PAGO
    const mp = new MercadoPago('TEST-7fc885ba-08d5-438d-9cb4-6e53fa53d0d9', {
        locale: 'es-AR'
    });
    mp.checkout({
        preference: {
            id: '<?php echo $preference->id; ?>'
        },
        render: {
            container: '.wallet_container',
            label: 'Pagar con MP'
        }
    })
</script>