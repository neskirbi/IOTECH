<nav class="main-header navbar navbar-expand navbar-dark border-bottom-0" style="background-color: var(--bg-card);">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <span class="nav-link font-weight-bold" style="color: var(--accent-cyan);">OIIon Security Platform</span>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
      <a class="nav-link text-white d-flex align-items-center gap-2" data-toggle="dropdown" href="#">
        <div class="avatar mr-2" style="width: 30px; height: 30px; font-size: 0.85rem;">A</div>
        <span>Administrador</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="background-color: var(--bg-card); border-color: var(--border-color);">
        <a href="#" class="dropdown-item text-light">
          <i class="fas fa-user mr-2"></i> Mi Perfil
        </a>
        <div class="dropdown-divider" style="border-color: var(--border-color);"></div>
        <a href="{{ url('logout') }}" class="dropdown-item text-danger">
          <i class="fas fa-power-off mr-2"></i> Cerrar Sesión
        </a>
        
      </div>
    </li>
  </ul>
</nav>