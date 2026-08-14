<!DOCTYPE html>
<html lang="es">
<head>
  @include('header')
  <title>{{ getSiteTitle('Dashboard General') }}</title>
</head>
<body class="hold-transition sidebar-mini layout-fixed" style="background-color: var(--bg-main);">
@include('toast.toasts')  
<div class="wrapper">

  <!-- Navbar -->
  @include('administradores.navbar')

  <!-- Main Sidebar Container -->
  @include('administradores.sidebar')

  <!-- Content Wrapper -->
  <div class="content-wrapper" style="background-color: var(--bg-main);">
    
    <!-- Content Header -->
    <div class="content-header">
      <div class="container-fluid">
        <h1 class="m-0 text-white font-weight-bold" style="font-size: 1.5rem;">
          <i class="fas fa-tachometer-alt mr-2" style="color: var(--accent-cyan);"></i> Dashboard de Operaciones
        </h1>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <!-- Fila 1: Tarjetas de Resumen (KPIs) -->
        <div class="row">
          
          <!-- Card Total Equipos -->
          <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
            <div class="card card-oiion h-100" style="background-color: rgba(21, 28, 47, 0.6); border: 1px solid var(--border-color);">
              <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                  <span class="text-muted small font-weight-bold text-uppercase d-block">Total Equipos</span>
                  <h3 class="text-white font-weight-bold my-1">{{ $totalEquipos }}</h3>
                  <span class="badge badge-pill" style="background-color: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.4);">
                    <i class="fas fa-check-circle mr-1"></i> {{ $equiposActivos }} Activos
                  </span>
                </div>
                <div class="equipment-avatar-container m-0" style="border-color: var(--accent-cyan); box-shadow: 0 0 15px rgba(0, 242, 254, 0.25);">
                  <i class="fas fa-vault equipment-icon" style="color: var(--accent-cyan); filter: drop-shadow(0 0 8px rgba(0, 242, 254, 0.6));"></i>
                </div>
              </div>
            </div>
          </div>

          <!-- Card Operadores -->
          <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
            <div class="card card-oiion h-100" style="background-color: rgba(21, 28, 47, 0.6); border: 1px solid var(--border-color);">
              <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                  <span class="text-muted small font-weight-bold text-uppercase d-block">Operadores Activos</span>
                  <h3 class="text-white font-weight-bold my-1">{{ $totalOperadores }}</h3>
                  <small class="text-cyan"><i class="fas fa-users mr-1"></i> Habilitados</small>
                </div>
                <div class="equipment-avatar-container m-0" style="border-color: #10b981; box-shadow: 0 0 15px rgba(16, 185, 129, 0.25);">
                  <i class="fas fa-user-shield equipment-icon" style="color: #10b981; filter: drop-shadow(0 0 8px rgba(16, 185, 129, 0.6));"></i>
                </div>
              </div>
            </div>
          </div>

          <!-- Card Geocercas -->
          <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
            <div class="card card-oiion h-100" style="background-color: rgba(21, 28, 47, 0.6); border: 1px solid var(--border-color);">
              <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                  <span class="text-muted small font-weight-bold text-uppercase d-block">Geocercas</span>
                  <h3 class="text-white font-weight-bold my-1">{{ $totalGeocercas }}</h3>
                  <small class="text-info"><i class="fas fa-draw-polygon mr-1"></i> Operativas</small>
                </div>
                <div class="equipment-avatar-container m-0" style="border-color: #3b82f6; box-shadow: 0 0 15px rgba(59, 130, 246, 0.25);">
                  <i class="fas fa-map-marked-alt equipment-icon" style="color: #3b82f6; filter: drop-shadow(0 0 8px rgba(59, 130, 246, 0.6));"></i>
                </div>
              </div>
            </div>
          </div>

         <!-- Card Cajas Abiertas -->
        <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
            <div class="card card-oiion h-100" style="background-color: rgba(21, 28, 47, 0.6); border: 1px solid var(--border-color);">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small font-weight-bold text-uppercase d-block">Cajas Abiertas</span>
                        <h3 class="text-white font-weight-bold my-1" style="color: #ef4444;">{{ $totalCajasAbiertas }}</h3>
                        <span class="badge badge-pill status-badge abierto">
                            <i class="fas fa-lock-open mr-1"></i> 
                            <span class="badge-text">Abiertas</span>
                        </span>
                    </div>
                    <div class="equipment-avatar-container m-0" style="border-color: #ef4444; box-shadow: 0 0 15px rgba(239, 68, 68, 0.25);">
                        <i class="fas fa-exclamation-triangle equipment-icon" style="color: #ef4444; filter: drop-shadow(0 0 8px rgba(239, 68, 68, 0.6));"></i>
                    </div>
                </div>
            </div>
        </div>

        </div>

        <!-- Fila 2: Gráficas de Monitoreo -->
        <div class="row">
          
          <!-- Gráfica de Líneas -->
          <div class="col-lg-8 mb-4">
            <div class="card card-oiion h-100">
              <div class="card-header border-0 d-flex align-items-center justify-content-between">
                <h3 class="card-title text-white font-weight-bold" style="font-size: 1.1rem;">
                  <i class="fas fa-chart-line mr-2" style="color: var(--accent-cyan);"></i> Actividad de Códigos (Últimos 7 días)
                </h3>
              </div>
              <div class="card-body">
                <canvas id="chartRegistrosDia" style="max-height: 280px;"></canvas>
              </div>
            </div>
          </div>

          <!-- Gráfica de Rosca -->
          <div class="col-lg-4 mb-4">
            <div class="card card-oiion h-100">
              <div class="card-header border-0">
                <h3 class="card-title text-white font-weight-bold" style="font-size: 1.1rem;">
                  <i class="fas fa-chart-pie mr-2" style="color: var(--accent-cyan);"></i> Tipos de Acciones
                </h3>
              </div>
              <div class="card-body">
                <canvas id="chartOpciones" style="max-height: 280px;"></canvas>
              </div>
            </div>
          </div>

        </div>

        <!-- Fila 3: Tabla Neón de Últimos Eventos -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="card card-oiion">
              <div class="card-header border-0">
                <h3 class="card-title text-white font-weight-bold" style="font-size: 1.1rem;">
                  <i class="fas fa-list-alt mr-2" style="color: var(--accent-cyan);"></i> Registros de Comandos Recientes
                </h3>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-borderless table-striped text-white mb-0" style="background-color: transparent;">
                    <thead style="background-color: rgba(10, 15, 29, 0.8); border-bottom: 1px solid var(--border-color);">
                      <tr class="text-muted small text-uppercase">
                        <th class="py-3">Operador</th>
                        <th class="py-3">MAC</th>
                        <th class="py-3">Acción Ejecutada</th>
                        <th class="py-3 px-4 text-right">Fecha / Hora</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($ultimosRegistros as $registro)
                        <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.05);">
                          <td class="py-3 align-middle">
                            @php
                              $nombreOperador = $registro->operador_nombre ?? '';
                              if (empty($nombreOperador) || $nombreOperador == 'Kiosco / Desconocido') {
                                  $nombreOperador = 'Kiosco';
                              }
                            @endphp
                            {{ $nombreOperador }}
                          </td>
                          <td class="py-3 align-middle">
                            <span class="text-muted small">{{ $registro->mac ?: 'N/A' }}</span>
                          </td>
                          
                          <td class="py-3 align-middle">
                            @php
                              $opcionesAccion = [
                                  1 => 'Motor',
                                  2 => 'Estatus',
                                  3 => 'Configuración',
                                  4 => 'Abrir Chapa'
                              ];
                              $nombreAccion = $opcionesAccion[$registro->opcion] ?? 'Opción #'.$registro->opcion;
                            @endphp
                            <span class="badge badge-pill px-3 py-2" style="background-color: rgba(0, 242, 254, 0.1); color: var(--accent-cyan); border: 1px solid rgba(0, 242, 254, 0.3);">
                              {{ $nombreAccion }}
                            </span>
                          </td>
                          <td class="py-3 px-4 align-middle text-right text-muted small">
                            <i class="far fa-clock mr-1"></i>{{ \Carbon\Carbon::parse($registro->created_at)->format('d/m/Y H:i:s') }}
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="5" class="text-center text-muted py-4">No se han registrado eventos recientes.</td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>
  </div>

  <!-- Footer -->
 @include('footer')
</div>

@include('administradores.footer')

<!-- Librería de Gráficas Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  $(document).ready(function() {
    // Configuración estética Neón para Chart.js
    Chart.defaults.color = '#94a3b8';
    Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.08)';

    // 1. Gráfica de Registros por día
    const labelsDias = {!! json_encode($registrosPorDia->pluck('fecha')) !!};
    const dataDias = {!! json_encode($registrosPorDia->pluck('total')) !!};

    new Chart(document.getElementById('chartRegistrosDia'), {
        type: 'line',
        data: {
            labels: labelsDias,
            datasets: [{
                label: 'Comandos Generados',
                data: dataDias,
                borderColor: '#00f2fe',
                backgroundColor: 'rgba(0, 242, 254, 0.1)',
                pointBackgroundColor: '#00f2fe',
                pointBorderColor: '#00f2fe',
                pointRadius: 4,
                fill: true,
                tension: 0.35,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });

    // 2. Gráfica de Opciones Ejecutadas
    const labelsOpciones = {!! json_encode($registrosPorOpcion->pluck('opcion')->map(function($op) {
        $mapa = [
            1 => 'Motor',
            2 => 'Estatus',
            3 => 'Configuración',
            4 => 'Abrir Chapa'
        ];
        return $mapa[$op] ?? 'Opción '.$op;
    })) !!};
    const dataOpciones = {!! json_encode($registrosPorOpcion->pluck('total')) !!};

    new Chart(document.getElementById('chartOpciones'), {
        type: 'doughnut',
        data: {
            labels: labelsOpciones,
            datasets: [{
                data: dataOpciones,
                backgroundColor: ['#00f2fe', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
  });
</script>
</body>
</html>