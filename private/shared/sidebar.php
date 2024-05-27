
<link href="<?php echo url_for('/dist/css/sidebar.css'); ?>" rel="stylesheet">
<div class="page-wrapper  chiller-theme toggled">
  <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
    <i class="fas fa-bars"></i>
  </a>
  <nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <a href="#"><img src="<?php echo url_for('/dist/img/logo.png'); ?>" width="180"></a>
        <div id="close-sidebar">
          <i class="fas fa-times"></i>
        </div>
      </div>
      <div class="sidebar-header">
        <div class="user-pic">
        </div>
        <div class="user-info">
          <span class="user-name"><?php echo $_SESSION['ApuestaTotal_nombre'] ?? '';?></span>
          <span class="user-role"><?php echo $_SESSION['ApuestaTotal_cargo'] ?? '';?></span>
          <span class="user-status">
            <i class="fa fa-circle"></i>
            <span>Online</span>
          </span>
        </div>
      </div>
      <!-- sidebar-header  -->
      <div class="sidebar-menu">
        <ul>
          <li class="header-menu">
            <span>General</span>
          </li>
          <li>
            <a href="<?php echo url_for('main.php'); ?>">
              <i class="fa fa-cash-register"></i>
              <span>Depósitos</span>
            </a>
          </li>
        </ul>
      </div>
      <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->
    <div class="sidebar-footer">
      <a href="cerrarSesion.php">
        <i class="fa fa-power-off"></i> Cerrar Sesión
      </a>
    </div>
  </nav>