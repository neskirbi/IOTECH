<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="#" class="logo">
            {!!GetIcon()!!}
            <span class="logo-text">{{Empresa()}}</span>
        </a>
    </div>
    
    <div class="sidebar-menu">
        
        <!--<a href="{{url('equipos')}}" class="menu-item">
            <i class="fas fa-tablet menu-icon"></i>
            <span class="menu-text">Equipos</span>
        </a>-->

        <a href="{{url('operadores')}}" class="menu-item">
            <i class="fas fa-users menu-icon"></i>
            <span class="menu-text">Operadores</span>
        </a>

        <a href="{{url('geocercas')}}" class="menu-item">
            <i class="fas fa-map menu-icon"></i>
            <span class="menu-text">Geocercas</span>
        </a>

        <!--<a href="{{url('soporte')}}" class="menu-item">
            <i class="fas fa-phone menu-icon"></i>
            <span class="menu-text">Soporte</span>
        </a>-->

      

        

        <!-- Comentado el resto del menú 
        
        <a href="#" class="menu-item">
            <i class="fas fa-tasks menu-icon"></i>
            <span class="menu-text">Proyectos</span>
            <span class="menu-badge">5</span>
        </a>-->
        <!-- Grupo expandible de Reportes 
        <div class="expandable-menu-container">
            <a href="#" class="menu-item expandable-toggle" onclick="toggleReportesMenu(this)">
                <i class="fas fa-chart-line menu-icon"></i>
                <span class="menu-text">Reportes</span>
                <i class="fas fa-chevron-down expandable-arrow"></i>
            </a>

            <div class="expandable-submenu">
                 <a href="{{url('reportes/contratos')}}" class="submenu-item">
                    <i class="fas fa-file-alt submenu-icon"></i>
                    <span class="submenu-text">Reporte Contratos</span>
                </a>

                <a href="{{url('reportes/ingresos')}}" class="submenu-item">
                    <i class="fas fa-file-alt submenu-icon"></i>
                    <span class="submenu-text">Reporte Ingresos</span>
                </a>

                <a href="{{url('reportes/compra')}}" class="submenu-item">
                    <i class="fas fa-file-alt submenu-icon"></i>
                    <span class="submenu-text">Reporte Compras</span>
                </a>

                <a href="{{url('reportes/destajo')}}" class="submenu-item">
                    <i class="fas fa-file-alt submenu-icon"></i>
                    <span class="submenu-text">Reporte Destajo</span>
                </a>

                
             
                
            </div>
        </div>-->
    </div>
    
    <div style="padding: 20px; border-top: 1px solid var(--color-secundario); margin-top: auto;">
        <!--<div class="menu-item">
            <i class="fas fa-headset menu-icon"></i>
            <span class="menu-text">Soporte</span>
        </div>-->
    </div>
</aside>