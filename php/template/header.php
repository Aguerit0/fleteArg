<header id="header" class="header fixed-top d-flex align-items-center">
  <!-- ======= ALERTA DE INACTIVIDAD ======= -->
  <?php include("./alerta-sesion.php") ?>

  <div class="container-fluid d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
      <a href="inicio.php" class="logo d-flex align-items-center">
        <span class="d-none d-lg-block">FleteAr</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <ul class="d-flex list-unstyled mb-0">
      <li class="me-3"><a href="../html/index.php">Inicio</a></li>
      <li class="dropdown me-3" >
        <a href="#" class="dropdown-toggle"  data-bs-toggle="dropdown">Información</a>
        <ul class="dropdown-menu">
          <li><a style="color: #645CAA;" href="../html/serFletero.html">Ser fletero</a></li>
          <li><a style="color: #645CAA;" href="../html/quienesSomos.html">¿Quienes somos?</a></li>
          <li><a style="color: #645CAA;" href="../html/precios.html">Precios</a></li>
        </ul>
      </li>
      <li class="me-3"><a href="../html/contacto.php">Contacto</a></li>
    </ul>

    <ul class="d-flex list-unstyled mb-0">
      <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-person" style="color: #ffffff;"></i>
          <span class="d-none d-md-block dropdown-toggle ps-2" style="color: #ffffff"><?php echo $_SESSION['usuario']; ?></span>
        </a><!-- End Profile Iamge Icon -->
        
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile" style="color: #ffffff;">
          <li class="dropdown-header">
            <h6 style="color: #645CAA;"><?php echo $_SESSION['nombreCliente'] . " " . $_SESSION['apellidoCliente']; ?></h6>
            <span style="color: #645CAA;.dropdown-menu .dropdown-item:hover {background-color: #645CAA; color: #ffffff;}"><?php if ($_SESSION['rol'] == 2) {
              echo "(admin)";
            } else if ($_SESSION['rol'] == 1) {
              echo "(fletero)";
            } else if ($_SESSION['rol'] == 0) {
              echo "(cliente)";
            } ?></span>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="perfil.php">
              <i  class="bi bi-person"></i>
              <span>Mi Perfil</span>
            </a>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="cerrar-sesion.php">
              <i class="bi bi-box-arrow-right"></i>
              <span>Salir</span>
            </a>
          </li>
        </ul><!-- End Profile Dropdown Items -->
      </li><!-- End Profile Nav -->
    </ul>
  </div><!-- End Container -->
</header><!-- End Header -->
