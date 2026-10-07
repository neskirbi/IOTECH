<!DOCTYPE html>
<html lang="es">
<head>
  @include('header')
  <title>{{ getSiteTitle('Historial Completo') }}</title>
</head>
<body class="hold-transition sidebar-mini layout-fixed" style="background-color: var(--bg-main);">
@include('toast.toasts')
<div class="wrapper">

  @include('administradores.navbar')
  @include('administradores.sidebar')

  <div class="content-wrapper" style="background-color: var(--bg-main);">

    <div class="content-header">
      <div class="container-fluid">
        <h1 class="m-0 text-white font-weight-bold" style="font-size: 1.5rem;">
          <i class="fas fa-history mr-2" style="color: var(--accent-cyan);"></i> Historial Completo de Eventos
        </h1>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">

        <!-- Filtros -->
        <div class="card card-oiion mb-4">
          <div class="card-header border-0">
            <h3 class="card-title text-white font-weight-bold" style="font-size: 1.1rem;">
              <i class="fas fa-filter mr-2" style="color: var(--accent-cyan);"></i> Filtros
            </h3>
          </div>
          <div class="card-body">
            <form method="GET" action="{{ route('historial.index') }}">
              <div class="row">
                <div class="col-md-3 mb-3">
                  <label class="text-muted small text-uppercase font-weight-bold">Número Económico</label>
                  <input type="text" name="numeconomico" class="form-control" value="{{ request('numeconomico') }}" placeholder="Ej. ECON005555">
                </div>
                <div class="col-md-3 mb-3">
                  <label class="text-muted small text-uppercase font-weight-bold">Equipo</label>
                  <input type="text" name="equipo" class="form-control" value="{{ request('equipo') }}" placeholder="Ej. Camion 2">
                </div>
                <div class="col-md-3 mb-3">
                  <label class="text-muted small text-uppercase font-weight-bold">Matrícula</label>
                  <input type="text" name="matricula" class="form-control" value="{{ request('matricula') }}" placeholder="Ej. 3232">
                </div>
                <div class="col-md-3 mb-3">
                  <label class="text-muted small text-uppercase font-weight-bold">Desde</label>
                  <input type="date" name="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
                </div>
                <div class="col-md-3 mb-3">
                  <label class="text-muted small text-uppercase font-weight-bold">Hasta</label>
                  <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
                </div>
                <div class="col-md-9 mb-3 d-flex align-items-end">
                  <button type="submit" class="btn btn-info mr-2">
                    <i class="fas fa-search mr-1"></i> Filtrar
                  </button>
                  <a href="{{ route('historial.index') }}" class="btn btn-secondary mr-2">
                    <i class="fas fa-times mr-1"></i> Limpiar
                  </a>
                  <a href="{{ route('historial.excel', request()->query()) }}" class="btn btn-success">
                    <i class="fas fa-file-excel mr-1"></i> Exportar Excel
                  </a>
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- Tabla -->
        <div class="card card-oiion">
          <div class="card-header border-0 d-flex justify-content-between align-items-center">
            <h3 class="card-title text-white font-weight-bold" style="font-size: 1.1rem;">
              <i class="fas fa-list-alt mr-2" style="color: var(--accent-cyan);"></i> Resultados ({{ $historial->total() }})
            </h3>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-borderless table-striped text-white mb-0" style="background-color: transparent;">
                <thead style="background-color: rgba(10, 15, 29, 0.8); border-bottom: 1px solid var(--border-color);">
                  <tr class="text-muted small text-uppercase">
                    <th class="py-3">Equipo</th>
                    <th class="py-3">N° Económico</th>
                    <th class="py-3">Matrícula</th>
                    <th class="py-3">MAC</th>
                    <th class="py-3">Evento</th>
                    <th class="py-3">Estado</th>
                    <th class="py-3 px-4 text-right">Fecha / Hora</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($historial as $registro)
                    @php
                      $evento = $registro->evento ?? 'desconocido';
                      $colorEvento = '#6c757d';
                      $iconoEvento = 'fa-question-circle';
                      $textoEvento = ucfirst($evento);

                      switch ($evento) {
                        case 'apertura':
                          $colorEvento = '#10b981';
                          $iconoEvento = 'fa-lock-open';
                          $textoEvento = 'Apertura';
                          break;
                        case 'cierre':
                          $colorEvento = '#ef4444';
                          $iconoEvento = 'fa-lock';
                          $textoEvento = 'Cierre';
                          break;
                        case 'ingreso':
                          $colorEvento = '#22c55e';
                          $iconoEvento = 'fa-dollar-sign';
                          $textoEvento = 'Ingreso de Dinero';
                          break;
                        case 'movimiento':
                          $colorEvento = '#f59e0b';
                          $iconoEvento = 'fa-arrows-alt';
                          $textoEvento = 'Movimiento';
                          break;
                      }
                    @endphp
                    <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.05);">
                      <td class="py-3 align-middle">
                        <i class="fas fa-vault mr-1" style="color: var(--accent-cyan);"></i>
                        {{ $registro->equipo ?: 'N/A' }}
                      </td>
                      <td class="py-3 align-middle">{{ $registro->numeconomico ?: 'N/A' }}</td>
                      <td class="py-3 align-middle">{{ $registro->matricula ?: 'N/A' }}</td>
                      <td class="py-3 align-middle">
                        <span class="text-muted small">{{ $registro->mac ?: 'N/A' }}</span>
                      </td>
                      <td class="py-3 align-middle">
                        <span class="badge badge-pill px-3 py-2" style="background-color: {{ $colorEvento }}22; color: {{ $colorEvento }}; border: 1px solid {{ $colorEvento }}55;">
                          <i class="fas {{ $iconoEvento }} mr-1"></i> {{ $textoEvento }}
                        </span>
                      </td>
                      <td class="py-3 align-middle text-muted small">
                        {{ ucfirst($registro->estado ?? '-') }}
                      </td>
                      <td class="py-3 px-4 align-middle text-right text-muted small">
                        <i class="far fa-clock mr-1"></i>{{ \Carbon\Carbon::parse($registro->datetime)->format('d/m/Y H:i:s') }}
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="7" class="text-center text-muted py-4">No se encontraron registros.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer border-0" style="background-color: rgba(10, 15, 29, 0.5);">
            {{ $historial->appends(request()->query())->links('pagination::bootstrap-4') }}
          </div>
        </div>

      </div>
    </section>
  </div>

  @include('footer')
</div>

@include('administradores.footer')
</body>
</html>