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
let caracteristicaBluetooth = null;
let coordenadasActuales = null; // Variable global de coordenadas
let watchId = null;
let procesoActivo = false;
let gpsDisponible = false;

// Configuración
const UUID_SERVICIO = 0xFFE0;
const UUID_CARACTERISTICA = 0xFFE1;
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
                    <p>No hay dispositivos Bluetooth pareados</p>
                    <small>Conecta un dispositivo primero desde ajustes del sistema</small>
                </div>
            `);
        } else {
            dispositivos.forEach(dispositivo => {
                lista.append(`
                    <label class="list-group-item">
                        <input class="form-check-input me-2" type="radio" name="dispositivo" value="${dispositivo.id}">
                        <div>
                            <strong>${dispositivo.name || 'Dispositivo desconocido'}</strong>
                            <small class="text-muted d-block">${dispositivo.id}</small>
                            <small class="text-success" style="font-size:10px;">
                                ${dispositivo.gatt?.connected ? '✅ Conectado' : '🔴 Desconectado'}
                            </small>
                        </div>
                    </label>
                `);
            });
        }
    } catch (error) {
        mostrarToast('Error buscando dispositivos', 'error');
        agregarLog(`Error buscando dispositivos: ${error.message}`, 'error');
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
        
        mostrarToast(`✅ Conectado a ${dispositivo.name}`, 'success');
        actualizarEstadoBluetooth(true, dispositivo.name);
        cerrarModalBluetooth();
        
        agregarLog(`Conectado a dispositivo: ${dispositivo.name}`, 'success');
        
    } catch (error) {
        console.error('Error conectando:', error);
        mostrarToast(`❌ Error al conectar: ${error.message}`, 'error');
        agregarLog(`Error conexión Bluetooth: ${error.message}`, 'error');
    }
}

function manejarDatosBluetooth(evento) {
    try {
        const valor = evento.target.value;
        const datos = new TextDecoder().decode(valor).trim();
        
        if (datos && procesoActivo) {
            agregarLog(`📥 Dispositivo → "${datos}"`, 'bluetooth');
            
            // Solo procesar números (respuesta del dispositivo al "1")
            if (/^\d+$/.test(datos)) {
                enviarAlServidorConCoordenadas(datos);
            }
        }
    } catch (error) {
        console.error('Error Bluetooth:', error);
        agregarLog(`Error procesando datos Bluetooth: ${error.message}`, 'error');
    }
}

async function enviarPorBluetooth(datos) {
    // VERIFICACIÓN: Si hay dispositivo conectado, usar Bluetooth real
    if (caracteristicaBluetooth && dispositivoBluetooth && dispositivoBluetooth.gatt.connected) {
        try {
            const encoder = new TextEncoder();
            const buffer = encoder.encode(datos + '\n');
            await caracteristicaBluetooth.writeValue(buffer);
            
            agregarLog(`📤 Enviado a ${dispositivoBluetooth.name}: "${datos}"`, 'bluetooth');
            return true;
            
        } catch (error) {
            agregarLog(`❌ Error enviando por Bluetooth: ${error.message}`, 'error');
            
            // Si hay error de conexión, actualizar estado
            if (error.name === 'NetworkError' || error.message.includes('disconnected')) {
                actualizarEstadoBluetooth(false);
                dispositivoBluetooth = null;
                caracteristicaBluetooth = null;
            }
            
            return false;
        }
    } else {
        // SIMULACIÓN: Si no hay dispositivo, usar "12345"
        agregarLog('⚠️ Sin dispositivo Bluetooth, usando simulación: "12345"', 'warning');
        
        // Simular retardo de red
        setTimeout(() => {
            if (procesoActivo) {
                agregarLog('📥 Simulación: Dispositivo respondió "12345"', 'bluetooth');
                enviarAlServidorConCoordenadas('12345');
            }
        }, 1000);
        
        return true; // Devuelve true porque la simulación se inició
    }
}

// ==================== PROCESO CHAPA ====================
async function iniciarProcesoChapa() {
    if (procesoActivo) return;
    
    // VERIFICAR GPS
    if (!gpsDisponible || !coordenadasActuales) {
        mostrarToast('❌ Error: GPS no disponible', 'error');
        return;
    }
    
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
    
    agregarLog('🚀 Iniciando proceso de apertura de chapa', 'info');
    agregarLog(`📍 Coordenadas: ${coordenadasActuales.lat.toFixed(6)}, ${coordenadasActuales.lng.toFixed(6)}`, 'info');
    
    try {
        // PASO 1: Enviar "1" al dispositivo Bluetooth
        $('#mensaje-proceso').html('Enviando señal al dispositivo...');
        agregarLog('📤 Enviando "1" al dispositivo...', 'info');
        
        await enviarPorBluetooth('1');
        
        // El flujo continúa en manejarDatosBluetooth o en el setTimeout de simulación
        
    } catch (error) {
        finalizarProcesoConError('Error iniciando proceso: ' + error.message);
    }
}

async function enviarAlServidorConCoordenadas(codigoDispositivo) {
    try {
        // VERIFICAR QUE TENEMOS COORDENADAS MÁS RECIENTES
        if (!coordenadasActuales) {
            finalizarProcesoConError('No se pudieron obtener coordenadas');
            return;
        }
        
        $('#mensaje-proceso').html('Enviando al servidor...');
        agregarLog(`📤 Enviando código ${codigoDispositivo} al servidor con coordenadas`, 'info');
        
        // Enviar al servidor con las coordenadas más recientes
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
                lat: coordenadasActuales.lat,
                lng: coordenadasActuales.lng,
                precision: coordenadasActuales.precision,
                timestamp: coordenadasActuales.timestamp,
                ubicacion: `${coordenadasActuales.lat},${coordenadasActuales.lng}`
            }
        });
        
        if (respuesta.status == 1) {
            const codigoServidor = respuesta.codigo || respuesta.resultado;
            agregarLog(`✅ Servidor respondió: ${codigoServidor}`, 'success');
            
            // Mostrar código recibido
            mostrarCodigoRecibido(codigoServidor);
            
            // Enviar código al dispositivo Bluetooth
            setTimeout(() => {
                enviarCodigoAlDispositivo(codigoServidor);
            }, 1000);
            
        } else {
            throw new Error('Error en respuesta del servidor: ' + (respuesta.message || ''));
        }
        
    } catch (error) {
        finalizarProcesoConError('Error del servidor: ' + error.message);
    }
}

function mostrarCodigoRecibido(codigo) {
    $('#loader').hide();
    $('#codigo-generado').text(codigo);
    $('#resultado-container').show();
    $('#mensaje-proceso').html(`✅ Código recibido: ${codigo}`);
    
    mostrarToast('Código recibido del servidor', 'success');
    agregarLog(`📋 Mostrando código: ${codigo}`, 'info');
}

async function enviarCodigoAlDispositivo(codigo) {
    try {
        $('#mensaje-proceso').html('Enviando código al dispositivo...');
        agregarLog(`📤 Enviando código ${codigo} al dispositivo`, 'info');
        
        // Usar Bluetooth real si está disponible, de lo contrario simular
        if (caracteristicaBluetooth && dispositivoBluetooth && dispositivoBluetooth.gatt.connected) {
            const encoder = new TextEncoder();
            const buffer = encoder.encode(codigo + '\n');
            await caracteristicaBluetooth.writeValue(buffer);
            
            agregarLog(`✅ Código enviado al dispositivo: ${codigo}`, 'success');
            mostrarToast('Código enviado al dispositivo', 'success');
        } else {
            agregarLog('⚠️ Sin dispositivo, simulación completada', 'warning');
            mostrarToast('Simulación completada (sin dispositivo Bluetooth)', 'info');
        }
        
        // Finalizar proceso
        finalizarProcesoConExito();
        
    } catch (error) {
        agregarLog(`❌ Error enviando al dispositivo: ${error.message}`, 'error');
        mostrarToast('Error enviando al dispositivo', 'error');
        finalizarProcesoConExito(); // Finalizar de todos modos
    }
}

function finalizarProcesoConExito() {
    // Restaurar estado del botón
    $('#btn-text').show();
    $('#btn-loading').hide();
    $('#btn-abrir-chapa').prop('disabled', false);
    
    // Ocultar loader
    $('#loader').hide();
    procesoActivo = false;
    
    agregarLog('✅ Proceso completado exitosamente', 'success');
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
    
    agregarLog(`❌ Error: ${mensaje}`, 'error');
    mostrarToast(mensaje, 'error');
}

// ==================== FUNCIONES AUXILIARES ====================
function actualizarEstadoBluetooth(conectado, dispositivoNombre = null) {
    const dot = $('#bluetooth-dot');
    const text = $('#status-text');
    const alertDiv = $('#bluetooth-alert');
    const alertText = $('#bluetooth-status-text');
    
    if (conectado && dispositivoNombre) {
        // Estado conectado
        dot.removeClass('bluetooth-disconnected').addClass('bluetooth-connected');
        text.html('<span class="bluetooth-status bluetooth-connected"></span> ' + dispositivoNombre);
        
        alertDiv.removeClass('alert-info alert-danger').addClass('alert-success');
        alertText.html('<strong>✅ Conectado:</strong> ' + dispositivoNombre);
        
        agregarLog(`Bluetooth conectado: ${dispositivoNombre}`, 'success');
        
    } else {
        // Estado desconectado
        dot.removeClass('bluetooth-connected').addClass('bluetooth-disconnected');
        text.html('<span class="bluetooth-status bluetooth-disconnected"></span> Bluetooth desconectado');
        
        alertDiv.removeClass('alert-success').addClass('alert-info');
        alertText.html('<strong>🔵 Estado:</strong> Desconectado');
        
        if (dispositivoNombre === 'no-soportado') {
            alertDiv.removeClass('alert-info').addClass('alert-danger');
            alertText.html('<strong>⚠️ No soportado:</strong> Bluetooth no disponible');
            agregarLog('Bluetooth no es compatible con este navegador', 'warning');
        }
    }
}

async function verificarDispositivosConectados() {
    try {
        const dispositivos = await navigator.bluetooth.getDevices();
        
        if (dispositivos.length > 0) {
            agregarLog(`${dispositivos.length} dispositivo(s) Bluetooth pareados`, 'info');
            
            for (const dispositivo of dispositivos) {
                try {
                    if (dispositivo.gatt.connected) {
                        await reconectarDispositivo(dispositivo);
                        return;
                    }
                } catch (e) {
                    // Continuar con otros dispositivos
                }
            }
        }
        
        actualizarEstadoBluetooth(false);
        
    } catch (error) {
        console.error('Error verificando dispositivos:', error);
        actualizarEstadoBluetooth(false);
    }
}

async function reconectarDispositivo(dispositivo) {
    try {
        const server = await dispositivo.gatt.connect();
        const service = await server.getPrimaryService(UUID_SERVICIO);
        caracteristicaBluetooth = await service.getCharacteristic(UUID_CARACTERISTICA);
        
        await caracteristicaBluetooth.startNotifications();
        caracteristicaBluetooth.addEventListener('characteristicvaluechanged', manejarDatosBluetooth);
        
        dispositivoBluetooth = dispositivo;
        
        actualizarEstadoBluetooth(true, dispositivo.name);
        agregarLog(`Reconectado a dispositivo: ${dispositivo.name}`, 'success');
        
    } catch (error) {
        console.error('Error reconectando:', error);
        actualizarEstadoBluetooth(false);
    }
}

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
    
    const iconoTipo = mensaje.includes('📤') || mensaje.includes('📥') || tipo === 'bluetooth' ? 'bluetooth' : tipo;
    
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
        mostrarToast('Código copiado al portapapeles', 'success');
    });
}

function mostrarToast(mensaje, tipo = 'info') {
    toastr[tipo](mensaje);
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

/* Bottom menu (ya incluido en bottom_menu.blade.php) */
</style>

</body>
</html>