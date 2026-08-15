

@php
    $theme = getTheme();
    $isKeySecure = isKeySecure();
@endphp<!-- Main Sidebar Container OIIon -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: var(--bg-card) !important; border-right: 1px solid var(--border-color);">
    <!-- Brand Logo -->
    <a href="#" class="brand-link border-bottom-0 d-flex align-items-center" style="gap: 10px; padding: 16px 20px;">
        @if($isKeySecure)
            <!-- Logo KeySecure -->
            <img src="{{ asset('images/keysecure-logo.png') }}" alt="KeySecure" class="brand-image elevation-3" style="opacity: .9; border-radius: 6px; height: 33px; width: auto;">
            
        @else
            <!-- Logo OIION -->
            <img src="{{ asset('images/oiin-logo.png') }}" alt="OIIon" class="brand-image elevation-3" style="opacity: .9; border-radius: 6px;">
            <span class="brand-text font-weight-bold" style="color: var(--accent-cyan); letter-spacing: 1px;">OIIon</span>
        @endif
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      
      <!-- User Panel -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center" style="border-bottom: 1px solid var(--border-color);">
        <div class="image">
          <div class="avatar" style="width: 34px; height: 34px; font-size: 0.85rem;">
            {{ substr(Auth::guard('administradores')->user()->nombres ?? 'A', 0, 1) }}
          </div>
        </div>
        <div class="info pl-2">
          <a href="#" class="d-block text-light font-weight-bold" style="font-size: 0.9rem;">
            {{Auth::guard('superusuarios')->user()->nombres.' '.Auth::guard('superusuarios')->user()->apellidos}}
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-header text-muted font-weight-bold" style="letter-spacing: 1px; font-size: 0.75rem; padding: 0.5rem 1rem;">ASOCIACIÓN</li>

          <li class="nav-item">
            <a href="{{url('empresas')}}" class="nav-link {{ request()->is('empresas*') ? 'active-oiion' : '' }}">
              <i class="nav-icon fa fa-building" style="color: var(--accent-cyan);" aria-hidden="true"></i>
              <p class="text-light">Empresas</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('administradores')}}" class="nav-link {{ request()->is('administradores*') ? 'active-oiion' : '' }}">
              <i class="nav-icon fa fa-group" style="color: var(--accent-cyan);" aria-hidden="true"></i>
              <p class="text-light">Administradores</p>
            </a>
          </li>

          

        </ul>
      </nav>
    </div>
</aside>