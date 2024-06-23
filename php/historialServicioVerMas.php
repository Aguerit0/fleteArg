<?php
include 'conexion.php';
session_start();
// PREGUNTA SI HAY UN USUARIO REGISTRADO
if (!isset($_SESSION['usuario'])) {
    header('Location: inicioSesion.php');
} else {
    if ($_SESSION['rol'] == 2) {
        header('Location: adminUsuarios.php');
    }
}

//id llega de boton
$idServicio = $_GET['idServicio'];
//consulta datos servicio
$sql1 = "SELECT * FROM servicio WHERE idServicio=$idServicio";
$res1 = mysqli_query($conexion, $sql1);
if ($row1 = $res1->fetch_assoc()) {
    //datos del servicio
    $idServicio = $row1['idServicio'];
    $precioServicio = $row1['precioServicio'];
    $metodoPagoServicio = $row1['metodoPagoServicio'];
    $fechaSalidaServicio = $row1['fechaSalidaServicio'];
    $fechaLlegadaServicio = $row1['fechaLlegadaServicio'];
    $estadoServicio = $row1['estadoServicio'];
    $ubicacionSalidaServicio = $row1['ubicacionSalidaServicio'];
    $ubicacionLlegadaServicio = $row1['ubicacionLlegadaServicio'];
    $distanciaServicio = $row1['distanciaServicio'];
    $tiempoServicio = $row1['tiempoServicio'];
    $descripcionServicio = $row1['descripcionServicio'];
    $idCliente = $row1['idCliente'];
    $idFletero = $row1['idFletero'];
    $idVehiculo = $row1['idVehiculo'];


    $ubicacionSalidaDatos = obtenerLatitudLongitud($ubicacionSalidaServicio);
    $ubicacionLlegadaDatos = obtenerLatitudLongitud($ubicacionLlegadaServicio);

    //consulta datos de fletero
    $sql2 = "SELECT * FROM fletero WHERE idFletero=$idFletero";
    $res2 = mysqli_query($conexion, $sql2);
    if ($row2 = $res2->fetch_assoc()) {
        //datos del fletero
        $descripcionFletero = $row2['descripcionFletero'];
        $cantidadVehiculosFletero = $row2['cantidadVehiculosFletero'];
        $cantidadViajesFletero = $row2['cantidadViajesFletero'];
        $puntajeFletero = $row2['puntajeFletero'];
        $actividadFletero = $row2['actividadFletero'];
        $fechaRegFletero = $row2['fechaRegFletero'];
        $eliminadoFletero = $row2['eliminadoFletero'];
    }
    //consulta datos del vehiculo
    $sql3 = "SELECT * FROM vehiculo WHERE idVehiculo=$idVehiculo";
    $res3 = mysqli_query($conexion, $sql3);
    if ($row3 = $res3->fetch_assoc()) {
        //datos del vehculo
        $patenteVehiculoText = $row3['patenteVehiculoText'];
        $tipoVehiculo = $row3['tipoVehiculo'];
        $colorVehiculo = $row3['colorVehiculo'];
        $descripcionVehiculo = $row3['descripcionVehiculo'];
        $eliminadoVehiculo = $row3['eliminadoVehiculo'];
    }
    $sql4 = "SELECT * FROM cliente WHERE idCliente = $idCliente";
    $res4 = mysqli_query($conexion, $sql4);
    if ($row4 = $res4->fetch_assoc()) {
        $nombreCliente = $row4['nombreCliente'];
        $apellidoCliente = $row4['apellidoCliente'];
        $correoCliente = $row4['correoCliente'];
        $dniCliente = $row4['dniCliente'];
        $domicilioCliente = $row4['domicilioCliente'];
        $telefonoCliente = $row4['telefonoCliente'];
        $fechaNacCliente = $row4['fechaNacCliente'];
        $sexoCliente = $row4['sexoCliente'];
        $fechaRegCliente = $row4['fechaRegCliente'];
        $eliminadoCliente = $row4['eliminadoCliente'];
    }
}



function obtenerLatitudLongitud($cadena)
{
    $parts = explode("/", $cadena);

    if (count($parts) >= 2) {
        $latPart = trim($parts[0]);
        $longPart = trim($parts[1]);

        if (strpos($latPart, "lat:") === 0 && strpos($longPart, "long:") === 0) {
            $lat = floatval(trim(str_replace("lat:", "", $latPart)));
            $long = floatval(trim(str_replace("long:", "", $longPart)));
            return array('latitud' => $lat, 'longitud' => $long);
        }
    }

    return null;
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


    <!-- Agrega esto antes del cierre de la etiqueta </body> -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Mapbox api-->
    <link href="https://api.mapbox.com/mapbox-gl-js/v1.11.0/mapbox-gl.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.css" type="text/css" />
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.2/mapbox-gl-directions.css" type="text/css" />
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>


    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #map {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
            border-radius: 20px;
        }

        main {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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



        <section class="section dashboard">
            <div class="card border-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title">
                            <a href="historialServicio.php" class="btn btn-primary">Volver</a>
                        </div>
                        <div class="card-title">
                            <span style="color: black;">Estado: </span>
                            <span style="color: <?php echo ($estadoServicio == 'pendiente') ? 'red' : 'green'; ?>"><?php echo $estadoServicio ?></span>
                        </div>
                    </div>

                    <br><br>
                    <form method="POST" class="row g-3 needs-validation" novalidate id="miFormulario">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2 class="text-start mb-3">Datos del Servicio</h2>
                                    <div id="form-group">
                                        <label for="precioServicio">Precio de Servicio</label>
                                        <input disabled class="form-control" type="text" id="precioServicio" name="precioServicio" value="<?php echo $precioServicio; ?>">
                                    </div>
                                    <div id="form-group">
                                        <label for="metodoPagoServicio">Método de Pago</label>
                                        <input disabled class="form-control" type="text" id="metodoPagoServicio" name="metodoPagoServicio" value="<?php echo $metodoPagoServicio; ?>">
                                    </div>


                                    <div id="form-group">
                                        <label for="fechaSalidaServicio">Fecha de Salida</label>
                                        <input disabled class="form-control" type="text" id="fechaSalidaServicio" name="fechaSalidaServicio" value="<?php echo $fechaSalidaServicio; ?>">
                                    </div>


                                    <div id="form-group">
                                        <label for="fechaLlegadaServicio">Fecha de Llegada</label>
                                        <input disabled class="form-control" type="text" id="fechaLlegadaServicio" name="fechaLlegadaServicio" value="<?php echo $fechaLlegadaServicio; ?>">
                                    </div>


                                    <div id="form-group"><label for="estadoServicio">Estado</label>
                                        <input disabled class="form-control" type="text" id="estadoServicio" name="estadoServicio" value="<?php echo $estadoServicio; ?>">
                                    </div>


                                    <div id="form-group"><label for="ubicacionSalidaServicio">Ubicación de Salida</label>
                                        <input disabled class="form-control" type="text" id="ubicacionSalidaServicio" name="ubicacionSalidaServicio" value="<?php if ($ubicacionSalidaDatos) {
                                                                                                                                                                echo 'lat: ' . $ubicacionSalidaDatos['latitud'] . '  long: ' . $ubicacionSalidaDatos['longitud'];
                                                                                                                                                            } else {
                                                                                                                                                                echo $ubicacionSalidaServicio;
                                                                                                                                                            } ?>">
                                    </div>


                                    <div id="form-group"><label for="ubicacionLlegadaServicio">Ubicación de Llegada</label>
                                        <input disabled class="form-control" type="text" id="ubicacionLlegadaServicio" name="ubicacionLlegadaServicio" value="<?php if ($ubicacionLlegadaDatos) {
                                                                                                                                                                    echo 'lat: ' . $ubicacionLlegadaDatos['latitud'] . '  long: ' . $ubicacionLlegadaDatos['longitud'];
                                                                                                                                                                } else {
                                                                                                                                                                    echo $ubicacionLlegadaServicio;
                                                                                                                                                                } ?>">

                                    </div>


                                    <div id="form-group">
                                        <label for="distanciaServicio">Distancia del Servicio</label>
                                        <input disabled class="form-control" type="text" id="distanciaServicio" name="distanciaServicio" value="<?php echo $distanciaServicio; ?>">
                                    </div>


                                    <div id="form-group"><label for="tiempoServicio">Tiempo del Servicio</label>
                                        <input disabled class="form-control" type="text" id="tiempoServicio" name="tiempoServicio" value="<?php echo $tiempoServicio; ?>">
                                    </div>


                                    <div id="form-group"><label for="descripcionServicio">Descripción del Servicio</label>
                                        <input disabled class="form-control" type="text" id="descripcionServicio" name="descripcionServicio" value="<?php echo $descripcionServicio; ?>">
                                    </div>


                                </div>
                                <div class="col-md-6">
                                    <!--MAPA MAPBOX CON LAT Y LONG-->
                                    <div id="map-container">
                                        <div id="map">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                            </div>
                            <div class="row" style="padding-top: 60px;">
                                <div class="col-md-6">
                                    <h2 class="text-start mb-3">Datos del Cliente</h2>
                                    <div class="form-group">
                                        <label for="nombreCliente">Nombre de Cliente</label>
                                        <input disabled class="form-control" type="text" id="nombreCliente" name="nombreCliente" value="<?php echo $nombreCliente; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="apellidoCliente">Apellido de Cliente</label>
                                        <input disabled class="form-control" type="text" id="apellidoCliente" name="apellidoCliente" value="<?php echo $apellidoCliente; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="domicilioCliente">Domicilio de Cliente</label>
                                        <input disabled class="form-control" type="text" id="domicilioCliente" name="domicilioCliente" value="<?php echo $domicilioCliente; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="telefonoCliente">Teléfono de Cliente</label>
                                        <input disabled class="form-control" type="text" id="telefonoCliente" name="telefonoCliente" value="<?php echo $telefonoCliente; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="sexoCliente">Sexo de Cliente</label>
                                        <input disabled class="form-control" type="text" id="sexoCliente" name="sexoCliente" value="<?php echo $sexoCliente; ?>">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <h2 class="text-start mb-3">Datos del Vehículo</h2>
                                    <div class="form-group">
                                        <label for="idVehiculo">ID de Vehículo</label>
                                        <input disabled class="form-control" type="text" id="idVehiculo" name="idVehiculo" value="<?php echo $idVehiculo; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="patenteVehiculo">Patente de Vehiculo</label>
                                        <input disabled class="form-control" type="text" id="patenteVehiculo" name="patenteVehiculo" value="<?php echo $patenteVehiculoText; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="tipoVehiculo">Tipo de Vehículo</label>
                                        <input disabled class="form-control" type="text" id="tipoVehiculo" name="tipoVehiculo" value="<?php echo $tipoVehiculo; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="colorVehiculo">Color de Vehículo</label>
                                        <input disabled class="form-control" type="text" id="colorVehiculo" name="colorVehiculo" value="<?php echo $colorVehiculo; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="descripcionVehiculo">Descripción de Vehículo</label>
                                        <input disabled class="form-control" type="text" id="descripcionVehiculo" name="descripcionVehiculo" value="<?php echo $descripcionVehiculo; ?>">
                                    </div>


                                </div>
                            </div>
                        </div>
                        <br>

                </div>

            </div>

            </form>
            </div>
            </div>


            <script>
                mapboxgl.accessToken = 'pk.eyJ1IjoiYWd1ZXJpdG8iLCJhIjoiY2xqeGtuYjgwMXRiYzNtbzg2eDYwcTJrbCJ9.HNAfAr5C0oHrNiXlYXN7mg';
                const map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/navigation-night-v1',
                    center: [-65.779, -28.469],
                    zoom: 12,
                });

                const latitud1 = parseFloat('<?php echo $ubicacionSalidaDatos['latitud']; ?>');
                const longitud1 = parseFloat('<?php echo $ubicacionSalidaDatos['longitud']; ?>');

                const latitud2 = parseFloat('<?php echo $ubicacionLlegadaDatos['latitud']; ?>');
                const longitud2 = parseFloat('<?php echo $ubicacionLlegadaDatos['longitud']; ?>');

                // Crear los marcadores
                const marker1 = new mapboxgl.Marker().setLngLat([longitud1, latitud1]).addTo(map);
                const marker2 = new mapboxgl.Marker({
                    rotation: 0
                }).setLngLat([longitud2, latitud2]).addTo(map);

                // Crear un popup para el primer marcador
                const popup1 = new mapboxgl.Popup()
                    .setHTML('<p>Ubicación de Salida</p><p>Aquí se encuentra el punto de salida.</p>');

                // Asociar el popup al primer marcador
                marker1.setPopup(popup1).togglePopup();

                // Crear un popup para el segundo marcador
                const popup2 = new mapboxgl.Popup()
                    .setHTML('<p>Ubicación de Llegada</p><p>Aquí se encuentra el punto de llegada.</p>');

                // Asociar el popup al segundo marcador
                marker2.setPopup(popup2).togglePopup();

                // Configurar Mapbox Directions
                const directions = new MapboxDirections({
                    accessToken: mapboxgl.accessToken,
                    unit: 'metric',
                    profile: 'mapbox/driving',
                    container: 'directions-container',
                });

                // Establecer los puntos de inicio y fin para la ruta
                directions.setOrigin([longitud1, latitud1]);
                directions.setDestination([longitud2, latitud2]);

                // Agregar el control de direcciones al mapa
                map.addControl(directions, 'top-left');
            </script>
        </section>


    </main><!-- End #main -->
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

</html>