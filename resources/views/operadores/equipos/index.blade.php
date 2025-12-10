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
        
        <!-- Estado GPS -->
        <div class="alert alert-warning mb-3" id="gps-alert" style="display: none;">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <span id="gps-message">Esperando señal GPS...</span>
        </div>
        
        <!-- Estado Bluetooth -->
        <div class="alert alert-info mb-3" id="bluetooth-alert">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-bluetooth-b me-2"></i>
                    <span id="bluetooth-status-text">Desconectado</span>
                </div>
                <button class="btn btn-sm btn-outline-primary" onclick="mostrarModalBluetooth()">
                    <i class="fas fa-plug"></i> Conectar
                </button>
            </div>
        </div>
        
        <!-- Botón principal de acción con loading -->
        <button class="btn btn-primary w-100 mb-3" id="btn-abrir-chapa" onclick="iniciarProcesoChapa()" disabled>
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
                <div class="text-center py-3 text-muted">
                    <i class="fas fa-search fa-2x mb-2"></i>
                    <p>Buscar dispositivos...</p>
                </div>
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
// ==================== VARIABLES GLOBALES ====================
let mapa = null;
let marcador = null;
let dispositivoBluetooth = null;
let servidorGATT = null;
let caracteristicaTX = null;
let caracteristicaRX = null;
let coordenadasActuales = null;
let watchId = null;
let procesoActivo = false;
let gpsDisponible = false;

// UUIDs para Bluetooth Serial del ESP32
const UUID_SERVICIO_BLUETOOTH = '0000ffe0-0000-1000-8000-00805f9b34fb';
const UUID_CARACTERISTICA_TX_RX = '0000ffe1-0000-1000-8000-00805f9b34fb';
const SERVER_URL = '{{ url("api/GenerarCodigo") }}';

// ==================== INICIALIZACIÓN ====================
document.addEventListener('DOMContentLoaded', function() {
    inicializarMapa();
    iniciarSeguimientoGPS();
    actualizarHora();
    
    // Verificar compatibilidad Bluetooth
    if (!navigator.bluetooth) {
        mostrarToast('Bluetooth no disponible en este navegador', 'error');
        actualizarEstadoBluetooth(false, 'no-soportado');
        agregarLog('Web Bluetooth no disponible', 'warning');
    } else {
        verificarDispositivosConectados();
    }
    
    // Actualizar hora cada minuto
    setInterval(actualizarHora, 60000);
    
    agregarLog('Sistema iniciado', 'info');
});

// ==================== GPS Y COORDENADAS ====================
function inicializarMapa() {
    mapa = L.map('map').setView([19.4326, -99.1332], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(mapa);
}

function iniciarSeguimientoGPS() {
    if (navigator.geolocation) {
        // Obtener ubicación actual
        navigator.geolocation.getCurrentPosition(
            actualizarCoordenadas,
            manejarErrorGPS,
            { enableHighAccuracy: true, timeout: 10000 }
        );
        
        // Seguir cambios de ubicación
        watchId = navigator.geolocation.watchPosition(
            actualizarCoordenadas,
            manejarErrorGPS,
            { enableHighAccuracy: true, maximumAge: 10000, timeout: 5000 }
        );
    } else {
        mostrarErrorGPS('Geolocalización no soportada por el navegador');
    }
}

function actualizarCoordenadas(posicion) {
    const lat = posicion.coords.latitude;
    const lng = posicion.coords.longitude;
    
    // ACTUALIZAR VARIABLE GLOBAL
    coordenadasActuales = { 
        lat: lat, 
        lng: lng,
        timestamp: new Date().toISOString(),
        precision: posicion.coords.accuracy
    };
    
    // Solo actualizar mapa si ya tenemos GPS disponible
    if (gpsDisponible) {
        actualizarMapa(lat, lng);
        obtenerDireccion(lat, lng);
        agregarLog(`GPS actualizado: ${lat.toFixed(6)}, ${lng.toFixed(6)}`, 'success');
    } else {
        // Primera vez que obtenemos coordenadas
        gpsDisponible = true;
        habilitarBotonChapa();
        actualizarMapa(lat, lng);
        obtenerDireccion(lat, lng);
        mostrarToast('✅ GPS disponible', 'success');
        agregarLog(`GPS conectado: ${lat.toFixed(6)}, ${lng.toFixed(6)}`, 'success');
    }
}

function actualizarMapa(lat, lng) {
    if (!marcador) {
        marcador = L.marker([lat, lng]).addTo(mapa);
    } else {
        marcador.setLatLng([lat, lng]);
    }
    mapa.setView([lat, lng], 15);
}

function manejarErrorGPS(error) {
    console.error('Error GPS:', error);
    
    let mensaje = '';
    switch(error.code) {
        case error.PERMISSION_DENIED:
            mensaje = 'Permiso de ubicación denegado. Activa GPS en ajustes.';
            break;
        case error.POSITION_UNAVAILABLE:
            mensaje = 'Ubicación no disponible. Verifica conexión GPS.';
            break;
        case error.TIMEOUT:
            mensaje = 'Tiempo de espera agotado. Intenta de nuevo.';
            break;
        default:
            mensaje = 'Error desconocido del GPS.';
    }
    
    mostrarErrorGPS(mensaje);
}

function mostrarErrorGPS(mensaje) {
    $('#gps-alert').show().removeClass('alert-success alert-warning').addClass('alert-danger');
    $('#gps-message').html(`<strong>❌ Error GPS:</strong> ${mensaje}`);
    $('#btn-abrir-chapa').prop('disabled', true);
    gpsDisponible = false;
    agregarLog(`Error GPS: ${mensaje}`, 'error');
}

function habilitarBotonChapa() {
    if (gpsDisponible) {
        $('#gps-alert').show().removeClass('alert-danger').addClass('alert-success');
        $('#gps-message').html('<strong>✅ GPS Conectado:</strong> Listo para usar');
        $('#btn-abrir-chapa').prop('disabled', false);
    }
}

function actualizarUbicacion() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(actualizarCoordenadas, manejarErrorGPS);
        mostrarToast('Actualizando ubicación...', 'info');
    }
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

// ==================== FUNCIONES BLUETOOTH ====================
function mostrarModalBluetooth() {
    $('#modal-bluetooth').show();
    buscarDispositivos();
}

function cerrarModalBluetooth() {
    $('#modal-bluetooth').hide();
}

function buscarDispositivos() {
    const lista = $('#lista-dispositivos');
    lista.empty();
    
    lista.append(`
        <div class="text-center py-4">
            <i class="fas fa-bluetooth-b fa-3x text-primary mb-3"></i>
            <h6>ESP32 Control de Chapas</h6>
            <p class="text-muted small">
                Conecta al dispositivo ESP32 del vehículo
            </p>
            <button class="btn btn-primary w-100 mt-2" onclick="conectarESP32()">
                <i class="fas fa-search me-2"></i>Buscar y Conectar ESP32
            </button>
        </div>
    `);
}

async function conectarESP32() {
    try {
        // 1. Solicitar dispositivo Bluetooth
        dispositivoBluetooth = await navigator.bluetooth.requestDevice({
            filters: [{ services: [UUID_SERVICIO_BLUETOOTH] }],
            optionalServices: [UUID_SERVICIO_BLUETOOTH]
        });
        
        // 2. Conectar al servidor GATT
        servidorGATT = await dispositivoBluetooth.gatt.connect();
        
        // 3. Obtener el servicio
        const servicio = await servidorGATT.getPrimaryService(UUID_SERVICIO_BLUETOOTH);
        
        // 4. Obtener la característica para TX/RX
        caracteristicaTX = await servicio.getCharacteristic(UUID_CARACTERISTICA_TX_RX);
        caracteristicaRX = caracteristicaTX;
        
        // 5. Configurar notificaciones
        await caracteristicaRX.startNotifications();
        caracteristicaRX.addEventListener('characteristicvaluechanged', manejarDatosESP32);
        
        // 6. Configurar desconexión
        dispositivoBluetooth.addEventListener('gattserverdisconnected', manejarDesconexion);
        
        // 7. Actualizar interfaz
        actualizarEstadoBluetooth(true, dispositivoBluetooth.name || 'ESP32');
        cerrarModalBluetooth();
        mostrarToast('✅ Conectado al ESP32', 'success');
        agregarLog('Conectado al dispositivo ESP32', 'success');
        
    } catch (error) {
        console.error('Error conectando:', error);
        
        if (error.name === 'NotFoundError') {
            mostrarToast('No se encontró ningún ESP32', 'warning');
        } else if (error.name === 'SecurityError') {
            mostrarToast('Permiso de Bluetooth denegado', 'error');
        } else {
            mostrarToast(`Error: ${error.message}`, 'error');
        }
        
        actualizarEstadoBluetooth(false);
        agregarLog(`Error conexión: ${error.message}`, 'error');
    }
}

function manejarDatosESP32(event) {
    try {
        const value = event.target.value;
        if (!value) return;
        
        const decoder = new TextDecoder('utf-8');
        const datos = decoder.decode(value).trim();
        
        if (!datos) return;
        
        agregarLog(`📥 ESP32 → "${datos}"`, 'bluetooth');
        
        if (procesoActivo && /^\d{3}$/.test(datos)) {
            enviarNumeroAlServidor(datos);
        }
        
    } catch (error) {
        console.error('Error procesando datos:', error);
        agregarLog(`Error: ${error.message}`, 'error');
    }
}

function manejarDesconexion() {
    mostrarToast('ESP32 desconectado', 'warning');
    actualizarEstadoBluetooth(false);
    
    dispositivoBluetooth = null;
    servidorGATT = null;
    caracteristicaTX = null;
    caracteristicaRX = null;
    
    agregarLog('ESP32 desconectado', 'warning');
}

async function enviarPorBluetooth(datos) {
    if (!dispositivoBluetooth || 
        !dispositivoBluetooth.gatt.connected || 
        !caracteristicaTX) {
        
        mostrarToast('❌ No conectado al ESP32', 'error');
        agregarLog('Error: No hay conexión Bluetooth', 'error');
        return false;
    }
    
    try {
        const encoder = new TextEncoder('utf-8');
        const buffer = encoder.encode(datos + '\n');
        
        await caracteristicaTX.writeValue(buffer);
        
        agregarLog(`📤 Web → ESP32: "${datos}"`, 'bluetooth');
        return true;
        
    } catch (error) {
        console.error('Error enviando:', error);
        agregarLog(`❌ Error: ${error.message}`, 'error');
        mostrarToast('Error enviando al ESP32', 'error');
        return false;
    }
}

function actualizarEstadoBluetooth(conectado, nombreDispositivo = null) {
    const statusText = $('#status-text');
    const bluetoothAlert = $('#bluetooth-alert');
    const bluetoothText = $('#bluetooth-status-text');
    const btnAbrirChapa = $('#btn-abrir-chapa');
    const bluetoothDot = $('#bluetooth-dot');
    
    if (conectado && nombreDispositivo) {
        bluetoothDot.removeClass('bluetooth-disconnected').addClass('bluetooth-connected');
        statusText.html(`<span class="bluetooth-status bluetooth-connected"></span> ${nombreDispositivo}`);
        
        bluetoothAlert.removeClass('alert-info').addClass('alert-success');
        bluetoothText.html(`<strong>✅ Conectado:</strong> ${nombreDispositivo}`);
        
        btnAbrirChapa.prop('disabled', false);
        
    } else {
        bluetoothDot.removeClass('bluetooth-connected').addClass('bluetooth-disconnected');
        statusText.html('<span class="bluetooth-status bluetooth-disconnected"></span> Bluetooth desconectado');
        
        bluetoothAlert.removeClass('alert-success').addClass('alert-info');
        bluetoothText.html('<strong>🔵 Estado:</strong> Desconectado');
        
        btnAbrirChapa.prop('disabled', true);
    }
}

async function verificarDispositivosConectados() {
    try {
        if (!navigator.bluetooth) {
            actualizarEstadoBluetooth(false, 'no-soportado');
            return;
        }
        
        const dispositivos = await navigator.bluetooth.getDevices();
        
        if (dispositivos.length > 0) {
            for (const dispositivo of dispositivos) {
                if (dispositivo.gatt && dispositivo.gatt.connected) {
                    await reconectarDispositivo(dispositivo);
                    break;
                }
            }
        }
        
    } catch (error) {
        console.error('Error verificando dispositivos:', error);
    }
}

async function reconectarDispositivo(dispositivo) {
    try {
        servidorGATT = await dispositivo.gatt.connect();
        const servicio = await servidorGATT.getPrimaryService(UUID_SERVICIO_BLUETOOTH);
        caracteristicaTX = await servicio.getCharacteristic(UUID_CARACTERISTICA_TX_RX);
        caracteristicaRX = caracteristicaTX;
        
        await caracteristicaRX.startNotifications();
        caracteristicaRX.addEventListener('characteristicvaluechanged', manejarDatosESP32);
        dispositivo.addEventListener('gattserverdisconnected', manejarDesconexion);
        
        actualizarEstadoBluetooth(true, dispositivo.name || 'ESP32');
        agregarLog('Reconectado al ESP32', 'success');
        
    } catch (error) {
        console.error('Error reconectando:', error);
        actualizarEstadoBluetooth(false);
    }
}

// ==================== PROCESO COMPLETO ====================
async function iniciarProcesoChapa() {
    if (!dispositivoBluetooth || !dispositivoBluetooth.gatt.connected) {
        mostrarToast('❌ Conecta primero al ESP32', 'error');
        mostrarModalBluetooth();
        return;
    }
    
    if (!gpsDisponible || !coordenadasActuales) {
        mostrarToast('❌ Error: GPS no disponible', 'error');
        return;
    }
    
    if (procesoActivo) return;
    
    procesoActivo = true;
    
    $('#btn-text').hide();
    $('#btn-loading').show();
    $('#btn-abrir-chapa').prop('disabled', true);
    $('#estado-proceso').show();
    $('#loader').show();
    $('#mensaje-proceso').html('Iniciando proceso...');
    $('#resultado-container').hide();
    
    agregarLog('🚀 Iniciando proceso de apertura de chapa', 'info');
    agregarLog(`📍 GPS: ${coordenadasActuales.lat.toFixed(6)}, ${coordenadasActuales.lng.toFixed(6)}`, 'info');
    
    try {
        $('#mensaje-proceso').html('Enviando señal al ESP32...');
        agregarLog('📤 Enviando "1" al ESP32...', 'info');
        
        const enviado = await enviarPorBluetooth('1');
        
        if (!enviado) {
            throw new Error('Fallo al enviar al ESP32');
        }
        
    } catch (error) {
        finalizarProcesoConError(`Error: ${error.message}`);
    }
}

async function enviarNumeroAlServidor(numeroESP32) {
    try {
        $('#mensaje-proceso').html('Consultando al servidor...');
        agregarLog(`📤 Enviando número ${numeroESP32} al servidor`, 'info');
        
        const datosServidor = {
            _token: '{{ csrf_token() }}',
            id: 0,
            codent: numeroESP32,
            opcion: '2',
            numeconomico: 'Móvil',
            id_operador: '{{ Auth::guard("operadores")->user()->id }}',
            lat: coordenadasActuales.lat,
            lng: coordenadasActuales.lng,
            precision: coordenadasActuales.precision,
            timestamp: coordenadasActuales.timestamp,
            ubicacion: `${coordenadasActuales.lat},${coordenadasActuales.lng}`
        };
        
        const respuesta = await $.ajax({
            url: SERVER_URL,
            method: 'POST',
            data: datosServidor,
            dataType: 'json'
        });
        
        if (respuesta.status == 1) {
            const codigoServidor = respuesta.codigo || respuesta.resultado;
            agregarLog(`✅ Servidor: ${codigoServidor}`, 'success');
            
            mostrarResultadoCodigo(codigoServidor);
            
            setTimeout(() => {
                enviarCodigoAlESP32(codigoServidor);
            }, 1000);
            
        } else {
            throw new Error(respuesta.message || 'Error del servidor');
        }
        
    } catch (error) {
        finalizarProcesoConError(`Error servidor: ${error.message}`);
    }
}

async function enviarCodigoAlESP32(codigo) {
    try {
        $('#mensaje-proceso').html('Completando proceso...');
        agregarLog(`📤 Enviando código ${codigo} al ESP32`, 'info');
        
        const enviado = await enviarPorBluetooth(codigo);
        
        if (enviado) {
            agregarLog('✅ Código enviado al ESP32', 'success');
            mostrarToast('Proceso completado', 'success');
        }
        
        finalizarProcesoConExito();
        
    } catch (error) {
        agregarLog(`Error: ${error.message}`, 'error');
        finalizarProcesoConExito();
    }
}

function mostrarResultadoCodigo(codigo) {
    $('#loader').hide();
    $('#codigo-generado').text(codigo);
    $('#resultado-container').show();
    $('#mensaje-proceso').html(`✅ Código: ${codigo}`);
    
    mostrarToast('Código recibido', 'success');
    agregarLog(`📋 Código: ${codigo}`, 'info');
}

function finalizarProcesoConExito() {
    $('#btn-text').show();
    $('#btn-loading').hide();
    $('#btn-abrir-chapa').prop('disabled', false);
    
    setTimeout(() => {
        $('#estado-proceso').hide();
    }, 2000);
    
    procesoActivo = false;
    agregarLog('✅ Proceso completado', 'success');
}

function finalizarProcesoConError(mensaje) {
    $('#btn-text').show();
    $('#btn-loading').hide();
    $('#btn-abrir-chapa').prop('disabled', false);
    
    $('#loader').hide();
    $('#mensaje-proceso').html(`<span class="text-danger">${mensaje}</span>`);
    
    setTimeout(() => {
        $('#estado-proceso').hide();
    }, 3000);
    
    procesoActivo = false;
    agregarLog(`❌ Error: ${mensaje}`, 'error');
    mostrarToast(mensaje, 'error');
}

// ==================== FUNCIONES AUXILIARES ====================
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
    
    const iconoTipo = mensaje.includes('📤') || mensaje.includes('📥') ? 'bluetooth' : tipo;
    
    const logItem = `
        <div class="border-bottom py-1">
            <i class="${iconos[iconoTipo] || iconos.info} me-2"></i>
            <small class="text-muted">${timestamp}</small>
            <small class="ms-2">${mensaje}</small>
        </div>
    `;
    
    logContainer.prepend(logItem);
    
    if (logContainer.children().length > 15) {
        logContainer.children().last().remove();
    }
    
    logContainer.scrollTop(0);
}

function mostrarToast(mensaje, tipo = 'info') {
    toastr[tipo](mensaje);
}

function actualizarHora() {
    const ahora = new Date();
    const hora = ahora.getHours().toString().padStart(2, '0');
    const minutos = ahora.getMinutes().toString().padStart(2, '0');
    $('#fecha-hora').text(`${hora}:${minutos}`);
}

function limpiarLogs() {
    $('#log-container').empty();
    agregarLog('Historial limpiado', 'info');
}

function copiarCodigo() {
    const codigo = $('#codigo-generado').text();
    navigator.clipboard.writeText(codigo).then(() => {
        mostrarToast('Código copiado', 'success');
    });
}

// NOTA: La función conectarDispositivoSeleccionado() no está implementada
// Si la necesitas, deberías agregarla o quitar el botón que la llama
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

/* Alerts */
.alert {
    border-radius: 10px;
    border: none;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border-left: 4px solid #28a745;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border-left: 4px solid #dc3545;
}

.alert-warning {
    background: #fff3cd;
    color: #856404;
    border-left: 4px solid #ffc107;
}

.alert-info {
    background: #d1ecf1;
    color: #0c5460;
    border-left: 4px solid #17a2b8;
}
</style>
</body>
</html>