<!DOCTYPE HTML>
<html>

<head>
	<title>FleteAr</title>
	<meta charset="utf-8" />
	<link rel="icon" type="image/jpeg" href="../images/logoFletear.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="../assets/css/main.css" />
	<noscript>
		<link rel="stylesheet" href="../assets/css/noscript.css" />
	</noscript>
	<script src="https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js"></script>
	<link href="https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css" rel="stylesheet" />

	<script src="ruta/a/awesomplete.js"></script>

</head>

<body class="is-preload landing">
	<div id="page-wrapper">

		<!-- Header -->
		<header id="header">
			<h1 id="logo"><a style="color: white; font: Roboto;" href="index.html">FleteAr</a></h1>
			<nav id="nav">
				<ul>
					<li><a href="index.php">Inicio</a></li>
					<li>
						<a href="#">Información</a>
						<ul>
							<li><a href="serFletero.html">Ser fletero</a></li>
							<li><a href="quienesSomos.html">¿Quienes somos?</a></li>
							<li><a href="precios.html">Precios</a></li>
						</ul>
					</li>
					<li><a href="contacto.php">Contacto</a></li>
					<li><a href="../php/inicioSesion.php" class="button primary">Ingresar</a></li>
				</ul>
			</nav>
		</header>

		<!-- Banner -->
		<section id="banner">
			<div class="content">
				<header>
					<h2>FleteAr</h2>
					<p>Tu satisfacción es nuestro compromiso.</p>
				</header>
				<div class="image-container">
					<img src="../images/imgFletearLogo.png" alt="" />
				</div>
			</div>
			<a href="#cero" class="goto-next scrolly">Siguiente</a>
		</section>













		<!-- One -->
		<section id="one" class="spotlight style1 bottom">
			<span class="image fit main"><img src="../assets/img/img1.jpg" alt="" /></span>
			<div class="content">
				<div class="container">
					<div class="row">
						<div class="col-4 col-12-medium">
							<header>
								<h2>Siempre pensamos en la seguridad de tus envios. </h2>
							</header>
						</div>
						<div class="col-4 col-12-medium">
							<p>Con los recursos y estándares de seguridad que incorporamos en nuestra organizacion, nos
								comprometemos a crear un entorno seguro para nuestros usuarios y su paqueteria.</p>
						</div>
						<div class="col-4 col-12-medium">
							<p>Queremos que te muevas con libertad, aproveches tu tiempo al máximo.
								Es por eso que estamos comprometidos con la seguridad: desde la creación de nuevos
								estándares hasta el desarrollo de tecnología con el objetivo de reducir los incidentes.
							</p>
						</div>
					</div>
				</div>
			</div>
			<a href="#two" class="goto-next scrolly">Siguiente</a>
		</section>

		<!-- Two -->
		<section id="two" class="spotlight style2 right">
			<span class="image fit main"><img src="../assets/img/img2.jpg" alt="" /></span>
			<div class="content">
				<header>
					<h2>¿Quiénes somos?</h2>
					<p>"Somos una empresa de transporte y logística dedicada a ofrecer soluciones de movilidad
						eficientes y confiables a nuestros clientes. Nos aseguramos de que sus envíos lleguen a su
						destino en tiempo y forma."</p>
				</header>
				<p></p>
				<ul class="actions">
					<li><a href="quienesSomos.html" class="button" style="background-color: #A084CA; color: white;">Leer mas</a></li>
				</ul>
			</div>
			<a href="#three" class="goto-next scrolly">Siguiente</a>
		</section>

		<!-- Three -->
		<section id="three" class="spotlight style3 left">
			<span class="image fit main bottom"><img src="../assets/img/img4.jpg" alt="" /></span>
			<div class="content">
				<header>
					<h2>Unete a nuestro equipo de trabajo</h2>
					<p>Visita mediante el boton nuestro apartado para estar al tanto de los requisitos necesarios para
						poder ser parte de nuestra flota de vehiculos y sumate a FleteAr</p>
				</header>
				<p>Es muy simple y estas a tan solo un click.</p>
				<ul class="actions">
					<li><a style="background-color: #A084CA;color: white;" href="../php/inicioSesion.php" class="button">Unete</a></li>
				</ul>
			</div>
			<a href="#four" class="goto-next scrolly">Siguiente</a>
		</section>


		<section id="four" class="spotlight style1 bottom">
			<div class="content">
				<div class="container">
					<div class="row">
						<div class="col-6 col-12-medium">
							<header>
								<h2>Programar Flete para mas tarde</h2>
							</header>
							<form onsubmit="event.preventDefault()">
								<div class="row gtr-uniform">
									<div class="col-12">
										<ul style="list-style-type: disc;">
											<li>
												<p style="color: black;"><strong style="color: black; font-weight: bold;">Paso 1:</strong>  Agregar Ubicación de Salida</p>
											</li>
											<li>
												<p style="color: black;"><strong style="color: black; font-weight: bold;">Paso 2:</strong>: Agregar Ubicación de Llegada</p>
											</li>
											<li>
												<p style="color: black;"><strong style="color: black; font-weight: bold;">Paso 3:</strong> Agregar Datos del Paquete</p>
											</li>
											<li>
												<p style="color: black;"><strong style="color: black; font-weight: bold;">Paso 4:</strong> Elegir Método de Pago y Reservar</p>
											</li>
										</ul>
									</div>

									<div class="col-12" style="text-align: center;">
												<a type="submit" value="Programar para más tarde" class="button" style="background-color: white; color: black; border: 1px solid black;" href="../php/inicioSesion.php">Programar para más tarde</a>
									</div>
									<div class="col-12">
										<p>Los precios de muestra son estimaciones y no reflejan las variaciones que
											pueden producir los descuentos, las zonas geográficas, el tráfico u otros
											factores. Es posible que se apliquen precios fijos e importes mínimos. Los
											precios reales de los trayectos pueden variar.</p>
									</div>
								</div>
							</form>
						</div>
						<div class="col-6 col-12-medium" style="display: flex; justify-content: center; align-items: center;">
							<div id="map" style="height: 400px; border-radius: 10px; width: 100%;"></div>
						</div>
					</div>
				</div>
			</div>
			<a href="#five" class="goto-next scrolly">Siguiente</a>
		</section>




		<!-- five -->
		<section id="five" class="wrapper style1 special fade-up">
			<div class="container">
				<header class="major">
					<h2 style="color: black;">Nuestros principales compromisos</h2>
				</header>
				<div class="box alt">
					<div class="row gtr-uniform">


						<section class="col-4 col-6-medium col-12-xsmall">
							<span class="icon solid alt major fa-paper-plane" style="background-color: #A084CA;"></span>
							<h3 style="color: black;">Destinos</h3>
							<p style="color: black;">Brindamos un servicio de logistica donde tu mismo eliges el
								destino.</p>
						</section>
						<section class="col-4 col-6-medium col-12-xsmall">
							<span class="icon solid alt major fa-file" style="background-color: #A084CA; color: white;"></span>
							<h3 style="color: black;">Informacion</h3>
							<p style="color: black;">Brindamos informacion personal, de todos nuestros empleados para
								generar transparencia y seguridad.</p>
						</section>
						<section class="col-4 col-6-medium col-12-xsmall">
							<span class="icon solid alt major fa-lock" style="background-color: #A084CA;"></span>
							<h3 style="color: black;">Seguridad</h3>
							<p style="color: black;">Brindamos Seguridad y garantia para que tu paqueteria llegue
								siempre segura.</p>
						</section>
					</div>
				</div>

			</div>
		</section>

		<!-- Footer -->
		<footer class="text-white" style="background-color: #645CAA; color: #ffffff; display: flex; justify-content: space-between; padding: 10px 20px;">
			<div class="d-flex align-items-center">
				<!-- Section: Social media -->
				<section style="display: flex; align-items: center;">
					<!-- Facebook -->
					<a style="margin: 4px; padding: 8px 16px;" class="btn btn-link btn-floating btn-lg text-white me-2" href="#" role="button" data-mdb-ripple-color="white">
						<i class="icon brands alt fa-facebook" style="color: white;"></i>
					</a>

					<!-- Twitter -->
					<a style="margin: 4px; padding: 8px 16px;" class="btn btn-link btn-floating btn-lg text-white me-2" href="#" role="button" data-mdb-ripple-color="dark">
						<i class="icon brands alt fa-twitter" style="color: white;"></i>
					</a>

					<!-- Instagram -->
					<a style="margin: 4px; padding: 8px 16px;" class="btn btn-link btn-floating btn-lg text-white me-2" href="#" role="button" data-mdb-ripple-color="dark">
						<i class="icon brands alt fa-instagram" style="color: white; height: 20px; width: 20px;"></i>
					</a>

					<!-- Linkedin -->
					<a style="margin: 4px; padding: 8px 16px;" class="btn btn-link btn-floating btn-lg text-white" href="#" role="button" data-mdb-ripple-color="dark">
						<i class="icon brands alt fa-linkedin" style="color: white;"></i>
					</a>
				</section>
				<!-- Section: Social media -->
			</div>

			<div class="text-end p-3">
				© 2023 Copyright:
				<a style="color: #ffffff;" class="text-white" href="#">Company, Inc. All rights reserved.</a>
			</div>
		</footer>



	</div>

	<script>
		mapboxgl.accessToken = 'pk.eyJ1IjoiYWd1ZXJpdG8iLCJhIjoiY2xqeGtuYjgwMXRiYzNtbzg2eDYwcTJrbCJ9.HNAfAr5C0oHrNiXlYXN7mg';
		var map = new mapboxgl.Map({
			container: 'map',
			style: 'mapbox://styles/mapbox/streets-v11',
			center: [-65.7852, -28.4696], // Coordenadas de Catamarca, Argentina
			zoom: 12
		});
	</script>

	<!-- Scripts -->
	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/jquery.scrolly.min.js"></script>
	<script src="../assets/js/jquery.dropotron.min.js"></script>
	<script src="../assets/js/jquery.scrollex.min.js"></script>
	<script src="../assets/js/browser.min.js"></script>
	<script src="../assets/js/breakpoints.min.js"></script>
	<script src="../assets/js/util.js"></script>
	<script src="../assets/js/main.js"></script>

</body>

</html>