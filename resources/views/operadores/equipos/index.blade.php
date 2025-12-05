@include('operadores.mobile_header')

<!-- Header fijo -->
<div class="container-fluid bg-primary text-white py-3 sticky-top">
    <div class="row align-items-center">
        <div class="col-8">
            <h5 class="mb-0">
                <i class="fas fa-truck"></i> Control de Chapas
            </h5>
            <small id="status-text">
                <span class="bluetooth-status bluetooth-disconnected" id="bluetooth-dot"></span>
                Bluetooth desconectado
            </small>
        </div>
        <div class="col-4 text-end">
            <button class="btn btn-light btn-sm" onclick="actualizarUbicacion()">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>
</div>

<!-- Contenido principal -->
<div class="container mt-3">
    
    <!-- Tarjeta de ubicación -->
    <div class="status-card">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0">
                <i class="fas fa-map-marker-alt text-danger"></i> Ubicación Actual
            </h6>
            <small id="fecha-hora" class="text-muted">{{ now()->format('H:i') }}</small>
        </div>
        <div id="map"></div>
        <div class="mt-2">
            <small id="direccion" class="text-muted">
                <i class="fas fa-info-circle"></i> Obteniendo ubicación...
            </small>
        </div>
    </div>
    
    <!-- Tarjeta de control -->
    <div class="status-card mt-3">
        <h6 class="mb-3">
            <i class="fas fa-car text-primary"></i> Control de Chapa
        </h6>
        
        <!-- Botón principal de acción con loading -->
        <button class="btn btn-primary w-100 mb-3" id="btn-abrir-chapa" onclick="iniciarProcesoChapa()">
            <span id="btn-text">
                <i class="fas fa-key"></i> ABRIR CHAPA
            </span>
            <span id="btn-loading" style="display: none;">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                PROCESANDO...
            </span>
        </button>
        
        <!-- Estado del proceso -->
        <div id="estado-proceso" class="text-center" style="display: none;">
            <div class="loader" id="loader"></div>
            <div id="mensaje-proceso" class="small"></div>
        </div>
        
        <!-- Resultado del código -->
        <div id="resultado-container" style="display: none;">
            <hr>
            <h6 class="text-center">Código Generado:</h6>
            <div class="codigo-resultado" id="codigo-generado">---</div>
            <button class="btn btn-outline-primary w-100" onclick="copiarCodigo()">
                <i class="fas fa-copy"></i> Copiar Código
            </button>
        </div>
    </div>
    
    <!-- Log de actividad -->
    <div class="status-card mt-3">
        <h6 class="mb-2">
            <i class="fas fa-history text-info"></i> Historial
        </h6>
        
        <!-- Status Bluetooth en el log -->
        <div class="bluetooth-status-log mb-2 p-2" style="background: #f8f9fa; border-radius: 8px;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-bluetooth-b text-primary me-2"></i>
                    <span id="bluetooth-status-text">Estado: Desconectado</span>
                </div>
                <div id="bluetooth-device-info" style="display: none;">
                    <small class="text-muted" id="connected-device-name"></small>
                </div>
            </div>
        </div>
        
        <div id="log-container" style="max-height: 150px; overflow-y: auto; font-size: 12px;">
            <!-- Los logs se agregarán aquí -->
        </div>
        <button class="btn btn-sm btn-link w-100 mt-2" onclick="limpiarLogs()">
            <i class="fas fa-trash"></i> Limpiar historial
        </button>
    </div>

</div>

@include('operadores.bottom_menu')
<!-- Modal de conexión Bluetooth -->
<div class="modal-mobile" id="modal-bluetooth">
    <div class="modal-content">
        <h5 class="text-center mb-3">
            <i class="fas fa-bluetooth-b text-primary"></i> Conectar Bluetooth
        </h5>
        
        <div class="mb-3">
            <p class="small text-muted">
                Conéctate al dispositivo de la chapa del vehículo.
            </p>
            
            <div class="list-group" id="lista-dispositivos">
                <!-- Dispositivos Bluetooth aparecerán aquí -->
            </div>
            
            <button class="btn btn-outline-primary w-100 mt-3" onclick="buscarDispositivos()">
                <i class="fas fa-search"></i> Buscar Dispositivos
            </button>
        </div>
        
        <div class="d-flex justify-content-between">
            <button class="btn btn-secondary" onclick="cerrarModalBluetooth()">Cancelar</button>
            <button class="btn btn-primary" onclick="conectarDispositivoSeleccionado()">Conectar</button>
        </div>
    </div>
</div>

@include('operadores.footer')

<!-- Scripts esenciales -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// Variables globales
let mapa = null;
let marcador = null;
let dispositivoBluetooth = null;
let caracteristicaBluetooth = null;
let ubicacionActual = null;
let watchId = null;
let procesoActivo = false;

// Configuración
const UUID_SERVICIO = 0xFFE0;
const UUID_CARACTERISTICA = 0xFFE1;
const SERVER_URL = '{{ url("api/GenerarCodigo") }}';

// ==================== INICIALIZACIÓN ====================
document.addEventListener('DOMContentLoaded', function() {
    inicializarMapa();
    iniciarSeguimientoUbicacion();
    actualizarHora();
    
    // Verificar compatibilidad Bluetooth
    if (!navigator.bluetooth) {
        mostrarToast('Bluetooth no está disponible en este navegador', 'error');
        actualizarEstadoBluetooth(false);
    }
    
    // Actualizar hora cada minuto
    setInterval(actualizarHora, 60000);
    
    // Inicialmente deshabilitar botón hasta tener ubicación
    $('#btn-abrir-chapa').prop('disabled', true);
    $('#mensaje-proceso').html('Esperando ubicación...');
    
    agregarLog('Sistema iniciado', 'info');
});

// ==================== MAPA Y UBICACIÓN ====================
function inicializarMapa() {
    mapa = L.map('map').setView([19.4326, -99.1332], 13); // Ciudad de México por defecto
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(mapa);
}

function iniciarSeguimientoUbicacion() {
    if (navigator.geolocation) {
        // Obtener ubicación actual
        navigator.geolocation.getCurrentPosition(actualizarUbicacionEnMapa, manejarErrorUbicacion);
        
        // Seguir cambios de ubicación
        watchId = navigator.geolocation.watchPosition(
            actualizarUbicacionEnMapa,
            manejarErrorUbicacion,
            { 
                enableHighAccuracy: true,
                maximumAge: 10000,
                timeout: 5000 
            }
        );
    } else {
        mostrarToast('Geolocalización no soportada', 'error');
    }
}

function actualizarUbicacionEnMapa(posicion) {
    const lat = posicion.coords.latitude;
    const lng = posicion.coords.longitude;
    ubicacionActual = { lat, lng };
    
    // Actualizar mapa
    if (!marcador) {
        marcador = L.marker([lat, lng]).addTo(mapa);
    } else {
        marcador.setLatLng([lat, lng]);
    }
    
    mapa.setView([lat, lng], 15);
    
    // Obtener dirección
    obtenerDireccion(lat, lng);
    
    // HABILITAR BOTÓN cuando tenemos ubicación
    $('#btn-abrir-chapa').prop('disabled', false);
    $('#mensaje-proceso').html('Listo para abrir chapa');
    
    agregarLog(`Ubicación obtenida: ${lat.toFixed(4)}, ${lng.toFixed(4)}`, 'success');
}

function manejarErrorUbicacion(error) {
    console.error('Error de ubicación:', error);
    mostrarToast('Error obteniendo ubicación', 'error');
    $('#btn-abrir-chapa').prop('disabled', true);
    $('#mensaje-proceso').html('<span class="text-danger">Error de ubicación. Verifica GPS.</span>');
}

function actualizarUbicacion() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(actualizarUbicacionEnMapa, manejarErrorUbicacion);
        mostrarToast('Ubicación actualizada', 'info');
    }
}

function manejarErrorUbicacion(error) {
    console.error('Error de ubicación:', error);
    mostrarToast('Error obteniendo ubicación', 'error');
}

async function obtenerDireccion(lat, lng) {
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
        const data = await response.json();
        
        if (data.display_name) {
            $('#direccion').html(`<i class="fas fa-map-pin"></i> ${data.display_name.split(',')[0]}`);
        }
    } catch (error) {
        console.error('Error obteniendo dirección:', error);
    }
}

// ==================== BLUETOOTH ====================
function mostrarModalBluetooth() {
    $('#modal-bluetooth').show();
    buscarDispositivos();
}

function cerrarModalBluetooth() {
    $('#modal-bluetooth').hide();
}

async function buscarDispositivos() {
    try {
        const dispositivos = await navigator.bluetooth.getDevices();
        const lista = $('#lista-dispositivos');
        lista.empty();
        
        if (dispositivos.length === 0) {
            lista.append(`
                <div class="text-center py-3 text-muted">
                    <i class="fas fa-search fa-2x mb-2"></i>
                    <p>No hay dispositivos pareados</p>
                </div>
            `);
        } else {
            dispositivos.forEach(dispositivo => {
                lista.append(`
                    <label class="list-group-item">
                        <input class="form-check-input me-2" type="radio" name="dispositivo" value="${dispositivo.id}">
                        ${dispositivo.name || 'Dispositivo desconocido'}
                        <small class="text-muted d-block">${dispositivo.id}</small>
                    </label>
                `);
            });
        }
    } catch (error) {
        mostrarToast('Error buscando dispositivos', 'error');
    }
}

async function conectarDispositivoSeleccionado() {
    const dispositivoId = $('input[name="dispositivo"]:checked').val();
    
    if (!dispositivoId) {
        mostrarToast('Selecciona un dispositivo', 'warning');
        return;
    }
    
    try {
        const dispositivos = await navigator.bluetooth.getDevices();
        const dispositivo = dispositivos.find(d => d.id === dispositivoId);
        
        if (!dispositivo) {
            throw new Error('Dispositivo no encontrado');
        }
        
        const server = await dispositivo.gatt.connect();
        const service = await server.getPrimaryService(UUID_SERVICIO);
        caracteristicaBluetooth = await service.getCharacteristic(UUID_CARACTERISTICA);
        
        // Configurar notificaciones
        await caracteristicaBluetooth.startNotifications();
        caracteristicaBluetooth.addEventListener('characteristicvaluechanged', manejarDatosBluetooth);
        
        dispositivoBluetooth = dispositivo;
        
        // Manejar desconexión
        dispositivo.addEventListener('gattserverdisconnected', () => {
            mostrarToast('Dispositivo desconectado', 'warning');
            actualizarEstadoBluetooth(false);
            dispositivoBluetooth = null;
            caracteristicaBluetooth = null;
        });
        
        mostrarToast(`Conectado a ${dispositivo.name}`, 'success');
        actualizarEstadoBluetooth(true);
        cerrarModalBluetooth();
        
        agregarLog(`Conectado Bluetooth: ${dispositivo.name}`, 'success');
        
    } catch (error) {
        console.error('Error conectando:', error);
        mostrarToast('Error al conectar', 'error');
    }
}

function manejarDatosBluetooth(evento) {
    try {
        const valor = evento.target.value;
        const datos = new TextDecoder().decode(valor).trim();
        
        if (datos && procesoActivo) {
            agregarLog(`Dispositivo → ${datos}`, 'success');
            
            // Solo procesar números (respuesta del dispositivo al "1")
            if (/^\d+$/.test(datos)) {
                // Enviar al servidor con coordenadas
                enviarAlServidorConCoordenadas(datos);
            }
        }
    } catch (error) {
        console.error('Error Bluetooth:', error);
    }
}

async function enviarPorBluetooth(datos) {
    if (!caracteristicaBluetooth) {
        // Simular respuesta para pruebas
        agregarLog('Bluetooth no disponible, simulando respuesta: 1234', 'warning');
        
        // Simular retardo de red
        setTimeout(() => {
            procesarConServidor('1234');
        }, 1000);
        
        return false;
    }
    
    try {
        const encoder = new TextEncoder();
        const buffer = encoder.encode(datos + '\n');
        await caracteristicaBluetooth.writeValue(buffer);
        
        agregarLog(`Bluetooth → ${datos}`, 'info');
        return true;
        
    } catch (error) {
        agregarLog(`Error Bluetooth: ${error.message}`, 'error');
        return false;
    }
}

// ==================== PROCESO CHAPA CON LOADING EN BOTÓN ====================
async function iniciarProcesoChapa() {
    if (procesoActivo) return;
    
    procesoActivo = true;
    
    // Activar loading en el botón
    $('#btn-text').hide();
    $('#btn-loading').show();
    $('#btn-abrir-chapa').prop('disabled', true);
    
    // Mostrar estado en tarjeta
    $('#estado-proceso').show();
    $('#loader').show();
    $('#mensaje-proceso').html('Iniciando proceso...');
    $('#resultado-container').hide();
    
    agregarLog('Iniciando proceso de apertura de chapa', 'info');
    
    try {
        // Paso 1: Enviar "1" al dispositivo Bluetooth
        $('#mensaje-proceso').html('Enviando señal al dispositivo...');
        
        const enviado = await enviarPorBluetooth('1');
        
        if (enviado) {
            $('#mensaje-proceso').html('Esperando respuesta del dispositivo...');
            agregarLog('Señal enviada, esperando respuesta...', 'info');
        } else {
            // En modo simulación, ya procesaremos '1234'
            $('#mensaje-proceso').html('Modo simulación: Procesando...');
        }
        
    } catch (error) {
        finalizarProcesoConError('Error en el proceso: ' + error.message);
    }
}

async function procesarConServidor(numeroRecibido) {
    try {
        $('#mensaje-proceso').html('Comunicando con servidor...');
        agregarLog(`Procesando número recibido: ${numeroRecibido}`, 'info');
        
        // Enviar al servidor (sin selección de vehículo)
        const respuesta = await $.ajax({
            url: SERVER_URL,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: 0, // Sin vehículo específico
                codent: numeroRecibido,
                opcion: '2', // Chapa (como en el modal original)
                numeconomico: 'Móvil',
                id_operador: '{{ Auth::guard("operadores")->user()->id }}',
                ubicacion: ubicacionActual ? `${ubicacionActual.lat},${ubicacionActual.lng}` : ''
            }
        });
        
        agregarLog('Respuesta del servidor recibida', 'success');
        
        if (respuesta.status == 1) {
            // Paso 3: Enviar respuesta al dispositivo Bluetooth
            $('#mensaje-proceso').html('Enviando respuesta al dispositivo...');
            
            await enviarPorBluetooth(respuesta.codigo || respuesta.resultado);
            
            // Mostrar resultado
            mostrarResultado(respuesta.codigo || respuesta.resultado);
            
            agregarLog('Proceso completado exitosamente', 'success');
            
        } else {
            throw new Error('Error en la respuesta del servidor');
        }
        
    } catch (error) {
        finalizarProcesoConError('Error del servidor: ' + error.message);
    }
}

function mostrarResultado(codigo) {
    // Restaurar estado del botón
    $('#btn-text').show();
    $('#btn-loading').hide();
    $('#btn-abrir-chapa').prop('disabled', false);
    
    // Ocultar loader y mostrar resultado
    $('#loader').hide();
    $('#estado-proceso').hide();
    $('#codigo-generado').text(codigo);
    $('#resultado-container').show();
    
    procesoActivo = false;
    
    mostrarToast('Código generado exitosamente', 'success');
}

function finalizarProcesoConError(mensaje) {
    // Restaurar estado del botón
    $('#btn-text').show();
    $('#btn-loading').hide();
    $('#btn-abrir-chapa').prop('disabled', false);
    
    // Mostrar error
    $('#loader').hide();
    $('#mensaje-proceso').html(`<span class="text-danger">${mensaje}</span>`);
    
    setTimeout(() => {
        $('#estado-proceso').hide();
    }, 3000);
    
    procesoActivo = false;
    
    agregarLog(mensaje, 'error');
    mostrarToast(mensaje, 'error');
}

// ==================== FUNCIONES AUXILIARES ====================
// ==================== FUNCIONES BLUETOOTH ACTUALIZADAS ====================
function actualizarEstadoBluetooth(conectado, dispositivoNombre = null) {
    const dot = $('#bluetooth-dot');
    const text = $('#status-text');
    const statusLog = $('#bluetooth-status-text');
    const deviceInfo = $('#bluetooth-device-info');
    const deviceName = $('#connected-device-name');
    
    if (conectado && dispositivoNombre) {
        // Estado conectado con nombre de dispositivo
        dot.removeClass('bluetooth-disconnected').addClass('bluetooth-connected');
        text.html('<span class="bluetooth-status bluetooth-connected"></span> ' + dispositivoNombre);
        statusLog.text('Conectado a: ' + dispositivoNombre);
        deviceName.text(dispositivoNombre);
        deviceInfo.show();
        
        agregarLog(`Bluetooth conectado: ${dispositivoNombre}`, 'success');
        
    } else if (conectado) {
        // Estado conectado sin nombre
        dot.removeClass('bluetooth-disconnected').addClass('bluetooth-connected');
        text.html('<span class="bluetooth-status bluetooth-connected"></span> Bluetooth conectado');
        statusLog.text('Estado: Conectado');
        deviceInfo.hide();
        
    } else {
        // Estado desconectado
        dot.removeClass('bluetooth-connected').addClass('bluetooth-disconnected');
        text.html('<span class="bluetooth-status bluetooth-disconnected"></span> Bluetooth desconectado');
        statusLog.text('Estado: Desconectado');
        deviceInfo.hide();
        
        if (dispositivoNombre === 'no-soportado') {
            statusLog.text('Estado: No soportado');
            agregarLog('Bluetooth no es compatible con este navegador', 'warning');
        }
    }
}

async function conectarDispositivoSeleccionado() {
    const dispositivoId = $('input[name="dispositivo"]:checked').val();
    
    if (!dispositivoId) {
        mostrarToast('Selecciona un dispositivo', 'warning');
        return;
    }
    
    try {
        const dispositivos = await navigator.bluetooth.getDevices();
        const dispositivo = dispositivos.find(d => d.id === dispositivoId);
        
        if (!dispositivo) {
            throw new Error('Dispositivo no encontrado');
        }
        
        const server = await dispositivo.gatt.connect();
        const service = await server.getPrimaryService(UUID_SERVICIO);
        caracteristicaBluetooth = await service.getCharacteristic(UUID_CARACTERISTICA);
        
        // Configurar notificaciones
        await caracteristicaBluetooth.startNotifications();
        caracteristicaBluetooth.addEventListener('characteristicvaluechanged', manejarDatosBluetooth);
        
        dispositivoBluetooth = dispositivo;
        
        // Manejar desconexión
        dispositivo.addEventListener('gattserverdisconnected', () => {
            mostrarToast('Dispositivo desconectado', 'warning');
            actualizarEstadoBluetooth(false);
            agregarLog(`Dispositivo desconectado: ${dispositivo.name}`, 'warning');
            dispositivoBluetooth = null;
            caracteristicaBluetooth = null;
        });
        
        mostrarToast(`Conectado a ${dispositivo.name}`, 'success');
        actualizarEstadoBluetooth(true, dispositivo.name);
        cerrarModalBluetooth();
        
        agregarLog(`Conectado a dispositivo: ${dispositivo.name}`, 'success');
        agregarLog(`ID dispositivo: ${dispositivo.id}`, 'info');
        
    } catch (error) {
        console.error('Error conectando:', error);
        mostrarToast('Error al conectar', 'error');
        agregarLog(`Error conexión Bluetooth: ${error.message}`, 'error');
    }
}

// ==================== INICIALIZACIÓN ACTUALIZADA ====================
document.addEventListener('DOMContentLoaded', function() {
    inicializarMapa();
    iniciarSeguimientoUbicacion();
    actualizarHora();
    
    // Verificar compatibilidad Bluetooth
    if (!navigator.bluetooth) {
        mostrarToast('Bluetooth no está disponible en este navegador', 'error');
        actualizarEstadoBluetooth(false, 'no-soportado');
        agregarLog('Bluetooth no compatible con este navegador', 'warning');
    } else {
        // Verificar dispositivos ya conectados
        verificarDispositivosConectados();
    }
    
    // Actualizar hora cada minuto
    setInterval(actualizarHora, 60000);
    
    // Inicialmente deshabilitar botón hasta tener ubicación
    $('#btn-abrir-chapa').prop('disabled', true);
    $('#mensaje-proceso').html('Esperando ubicación...');
    
    agregarLog('Sistema iniciado', 'info');
    agregarLog('Esperando conexión Bluetooth', 'info');
});

// Nueva función para verificar dispositivos ya conectados
async function verificarDispositivosConectados() {
    try {
        const dispositivos = await navigator.bluetooth.getDevices();
        
        if (dispositivos.length > 0) {
            agregarLog(`${dispositivos.length} dispositivo(s) Bluetooth pareados`, 'info');
            
            // Verificar si alguno está conectado
            for (const dispositivo of dispositivos) {
                try {
                    if (dispositivo.gatt.connected) {
                        actualizarEstadoBluetooth(true, dispositivo.name);
                        agregarLog(`Dispositivo ya conectado: ${dispositivo.name}`, 'success');
                        return;
                    }
                } catch (e) {
                    // Continuar con otros dispositivos
                }
            }
            
            actualizarEstadoBluetooth(false);
        } else {
            agregarLog('No hay dispositivos Bluetooth pareados', 'info');
            actualizarEstadoBluetooth(false);
        }
    } catch (error) {
        console.error('Error verificando dispositivos:', error);
        agregarLog('Error verificando dispositivos Bluetooth', 'error');
    }
}

// ==================== NUEVA FUNCIÓN PARA MOSTRAR INFO BLUETOOTH ====================
function mostrarInfoBluetooth() {
    if (!dispositivoBluetooth) {
        mostrarToast('No hay dispositivo conectado', 'info');
        return;
    }
    
    const info = `
        <strong>Dispositivo conectado:</strong> ${dispositivoBluetooth.name || 'Sin nombre'}<br>
        <strong>ID:</strong> ${dispositivoBluetooth.id}<br>
        <strong>Estado:</strong> ${dispositivoBluetooth.gatt?.connected ? 'Conectado' : 'Desconectado'}
    `;
    
    agregarLog(`Información Bluetooth: ${dispositivoBluetooth.name}`, 'info');
    
    // Mostrar en un modal o alerta
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Información Bluetooth',
            html: info,
            icon: 'info',
            confirmButtonText: 'OK'
        });
    } else {
        alert(info);
    }
}

// ==================== FUNCIÓN ACTUALIZADA PARA AGREGAR LOG ====================
function agregarLog(mensaje, tipo = 'info') {
    const logContainer = $('#log-container');
    const timestamp = new Date().toLocaleTimeString();
    const iconos = {
        info: 'fas fa-info-circle text-info',
        success: 'fas fa-check-circle text-success',
        error: 'fas fa-times-circle text-danger',
        warning: 'fas fa-exclamation-triangle text-warning',
        bluetooth: 'fas fa-bluetooth-b text-primary'
    };
    
    // Si es un mensaje relacionado con Bluetooth, usar icono específico
    const iconoTipo = mensaje.toLowerCase().includes('bluetooth') ? 'bluetooth' : tipo;
    
    const logItem = `
        <div class="border-bottom py-1">
            <i class="${iconos[iconoTipo] || iconos.info} me-2"></i>
            <small class="text-muted">${timestamp}</small>
            <small class="ms-2">${mensaje}</small>
        </div>
    `;
    
    logContainer.prepend(logItem);
    
    // Limitar a 15 logs
    if (logContainer.children().length > 15) {
        logContainer.children().last().remove();
    }
    
    // Auto-scroll al nuevo log
    logContainer.scrollTop(0);
}

// ==================== ACTUALIZAR FUNCIÓN enviarPorBluetooth ====================
async function enviarPorBluetooth(datos) {
    if (!caracteristicaBluetooth) {
        // Simular respuesta para pruebas
        agregarLog('Bluetooth no disponible, simulando respuesta: 1234', 'warning');
        
        // Agregar log de simulación
        agregarLog(`SIMULACIÓN: Enviando "${datos}" a dispositivo`, 'bluetooth');
        
        // Simular retardo de red
        setTimeout(() => {
            agregarLog('SIMULACIÓN: Dispositivo respondió "1234"', 'bluetooth');
            procesarConServidor('1234');
        }, 1000);
        
        return false;
    }
    
    try {
        const encoder = new TextEncoder();
        const buffer = encoder.encode(datos + '\n');
        await caracteristicaBluetooth.writeValue(buffer);
        
        agregarLog(`Enviado a ${dispositivoBluetooth?.name || 'dispositivo'}: "${datos}"`, 'bluetooth');
        return true;
        
    } catch (error) {
        agregarLog(`Error enviando a Bluetooth: ${error.message}`, 'error');
        return false;
    }
}

// ==================== AGREGAR BOTÓN PARA MOSTRAR INFO BLUETOOTH ====================
// Opcional: agregar este botón cerca del status Bluetooth

function actualizarHora() {
    const ahora = new Date();
    const hora = ahora.getHours().toString().padStart(2, '0');
    const minutos = ahora.getMinutes().toString().padStart(2, '0');
    $('#fecha-hora').text(`${hora}:${minutos}`);
}

function agregarLog(mensaje, tipo = 'info') {
    const logContainer = $('#log-container');
    const timestamp = new Date().toLocaleTimeString();
    const iconos = {
        info: 'fas fa-info-circle text-info',
        success: 'fas fa-check-circle text-success',
        error: 'fas fa-times-circle text-danger',
        warning: 'fas fa-exclamation-triangle text-warning'
    };
    
    const logItem = `
        <div class="border-bottom py-1">
            <i class="${iconos[tipo] || iconos.info} me-2"></i>
            <small>${timestamp}</small>
            <small class="ms-2">${mensaje}</small>
        </div>
    `;
    
    logContainer.prepend(logItem);
    
    // Limitar a 10 logs
    if (logContainer.children().length > 10) {
        logContainer.children().last().remove();
    }
}

function limpiarLogs() {
    $('#log-container').empty();
    agregarLog('Historial limpiado', 'info');
}

function copiarCodigo() {
    const codigo = $('#codigo-generado').text();
    navigator.clipboard.writeText(codigo).then(() => {
        mostrarToast('Código copiado al portapapeles', 'success');
    });
}

function mostrarToast(mensaje, tipo = 'info') {
    toastr[tipo](mensaje);
}

function mostrarVistaPrincipal() {
    // Aquí puedes cambiar vistas si es necesario
    $('.menu-item').removeClass('active');
    $('.menu-item:first').addClass('active');
}

function mostrarHistorial() {
    $('.menu-item').removeClass('active');
    $('.menu-item:nth-child(3)').addClass('active');
    // Aquí podrías cargar el historial desde el servidor
    mostrarToast('Cargando historial...', 'info');
}

// Función original adaptada
function GenerarCodigo(_this) {
    // Esta función se mantiene por compatibilidad
    iniciarProcesoChapa();
}

async function enviarAlServidorConCoordenadas(codigoDispositivo) {
    try {
        // Verificar que tenemos coordenadas
        if (!ubicacionActual) {
            finalizarProcesoConError('No se pudo obtener ubicación. Intenta de nuevo.');
            return;
        }
        
        $('#mensaje-proceso').html('Enviando al servidor...');
        agregarLog(`Enviando código ${codigoDispositivo} al servidor`, 'info');
        
        // Enviar al servidor
        const respuesta = await $.ajax({
            url: SERVER_URL,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: 0,
                codent: codigoDispositivo,
                opcion: '2',
                numeconomico: 'Móvil',
                id_operador: '{{ Auth::guard("operadores")->user()->id }}',
                lat: ubicacionActual.lat,
                lng: ubicacionActual.lng,
                ubicacion: `${ubicacionActual.lat},${ubicacionActual.lng}`
            }
        });
        
        if (respuesta.status == 1) {
            const codigoServidor = respuesta.codigo || respuesta.resultado;
            agregarLog(`Servidor respondió: ${codigoServidor}`, 'success');
            
            // PASO 1: Mostrar código recibido
            mostrarCodigoRecibido(codigoServidor);
            
            // PASO 2: Enviar código al dispositivo Bluetooth
            setTimeout(() => {
                enviarCodigoAlDispositivo(codigoServidor);
            }, 1000);
            
        } else {
            throw new Error('Error en respuesta del servidor');
        }
        
    } catch (error) {
        finalizarProcesoConError('Error del servidor: ' + error.message);
    }
}
</script>

<style>
/* Estilos para el loading del botón */
#btn-loading .spinner-border {
    vertical-align: middle;
    margin-right: 8px;
}

/* Estilos para el estado del proceso */
.loader {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    margin: 10px auto;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Estilos Bluetooth */
.bluetooth-status {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-right: 5px;
}

.bluetooth-connected {
    background: #4CAF50;
    box-shadow: 0 0 10px #4CAF50;
}

.bluetooth-disconnected {
    background: #f44336;
}

/* Bottom menu */
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
}

.menu-item.active {
    color: #667eea;
}

.menu-item i {
    font-size: 20px;
    margin-bottom: 3px;
}

/* Código resultado */
.codigo-resultado {
    font-size: 32px;
    font-weight: bold;
    color: #2196F3;
    text-align: center;
    margin: 20px 0;
    padding: 10px;
    background: #f0f8ff;
    border-radius: 10px;
    letter-spacing: 2px;
}
</style>

</body>
</html>