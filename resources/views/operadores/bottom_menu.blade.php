<!-- Bottom Menu -->
<div class="bottom-menu">
    <a href="{{ url('equiposop') }}" class="menu-item @if(Request::is('equiposop') || Request::is('/')) active @endif">
        <i class="fas fa-truck"></i>
        <span>Equipos</span>
    </a>
    <a href="{{ url('equiposop') }}" class="menu-item @if(Request::is('operador/mobile')) active @endif" id="menu-chapa">
        <i class="fas fa-key"></i>
        <span>Chapa</span>
    </a>
    <a href="#" class="menu-item" onclick="mostrarHistorial()">
        <i class="fas fa-history"></i>
        <span>Historial</span>
    </a>
    <a href="{{ url('logout') }}" class="menu-item">
        <i class="fas fa-sign-out-alt text-danger"></i>
        <span>Salir</span>
    </a>
</div>

<style>
.bottom-menu {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: white;
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding: 10px 0;
    box-shadow: 0 -2px 20px rgba(0,0,0,0.1);
    z-index: 1000;
    height: 60px;
}

.menu-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 5px 15px;
    color: #666;
    text-decoration: none;
    font-size: 12px;
    transition: all 0.3s;
    border-radius: 8px;
}

.menu-item:hover {
    color: #667eea;
    background: rgba(102, 126, 234, 0.1);
}

.menu-item.active {
    color: #667eea;
    background: rgba(102, 126, 234, 0.1);
}

.menu-item i {
    font-size: 20px;
    margin-bottom: 3px;
}

/* Para vista móvil */
@media (max-width: 768px) {
    .bottom-menu {
        padding: 8px 0;
        height: 55px;
    }
    
    .menu-item {
        padding: 5px 10px;
        font-size: 11px;
    }
    
    .menu-item i {
        font-size: 18px;
    }
}
</style>

<script>
// Función para mostrar historial (si es necesario)
function mostrarHistorial() {
    // Aquí puedes cargar el historial desde el servidor o mostrar un modal
    if (typeof toastr !== 'undefined') {
        toastr.info('Cargando historial...');
    } else {
        alert('Función de historial');
    }
    
    // Ejemplo: podrías cargar un modal con el historial
    // $('#modal-historial').modal('show');
}

// Cambiar clase activa al hacer clic
$(document).ready(function() {
    $('.bottom-menu .menu-item').on('click', function(e) {
        if (!$(this).attr('href') || $(this).attr('href') === '#') {
            e.preventDefault();
            $('.menu-item').removeClass('active');
            $(this).addClass('active');
        }
    });
});
</script>