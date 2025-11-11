{{-- resources/views/cliente/webinars/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Panel de Webinars')

@section('content')
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

<div class="page-wrapper d-flex flex-column min-vh-100">

  <div class="container py-5">

    <!-- ===== ENCABEZADO ===== -->
    <div class="text-center mb-5" data-aos="fade-down">
        <h1 class="fw-bold text-success display-5 mb-3">🎥 Webinars Institucionales</h1>
        <p class="text-muted fs-5 mb-0">Explora, inscríbete y participa en nuestros eventos virtuales.</p>
        <div class="mx-auto mt-3" style="width:100px;height:4px;background:linear-gradient(90deg,#198754,#20c997);border-radius:10px;"></div>
    </div>

    <!-- ===== BÚSQUEDA Y FILTROS ===== -->
    <form id="filtrosForm" method="GET" action="{{ route('cliente.webinars.index') }}"
          class="d-flex flex-wrap justify-content-center align-items-center gap-3 mb-5 p-3 rounded-4 shadow-sm bg-white border border-light-subtle"
          data-aos="fade-up">

        <div class="input-group shadow-sm" style="max-width: 520px;">
            <span class="input-group-text bg-success text-white border-0">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" name="q" value="{{ request('q') }}" class="form-control border-0" placeholder="Buscar webinar...">
        </div>

        <select name="estado" class="form-select border-0 shadow-sm w-auto rounded-pill bg-light">
            <option value="">Todos</option>
            <option value="proximo" {{ request('estado') == 'proximo' ? 'selected' : '' }}>Próximos</option>
            <option value="en_vivo" {{ request('estado') == 'en_vivo' ? 'selected' : '' }}>En vivo</option>
            <option value="finalizado" {{ request('estado') == 'finalizado' ? 'selected' : '' }}>Finalizados</option>
        </select>

        <button class="btn btn-success rounded-pill px-4 fw-semibold shadow-sm">
            <i class="bi bi-funnel"></i> Filtrar
        </button>
    </form>

    <!-- ===== LISTA DE WEBINARS ===== -->
    <div id="webinar-lista" data-aos="fade-up">
        @if ($webinars->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-camera-video-off display-1 text-muted"></i>
                <h4 class="mt-3 fw-semibold">No hay webinars disponibles</h4>
                <p class="text-muted">Pronto publicaremos nuevos eventos, ¡mantente atento!</p>
            </div>
        @else
            <div class="row g-4">
                @foreach ($webinars as $webinar)
                    @php
                        $estado = strtolower($webinar->estado ?? 'proximo');
                        $estadoColor = match($estado) {
                            'en_vivo' => 'bg-danger text-white',
                            'proximo' => 'bg-info text-dark',
                            'finalizado' => 'bg-secondary text-white',
                            default => 'bg-light text-dark'
                        };
                        $fecha = \Carbon\Carbon::parse($webinar->fecha);
                        $inscrito = auth()->check() 
                            ? \App\Models\Inscripcion::where('usuario_id', auth()->id())->where('webinar_id', $webinar->id)->exists()
                            : false;
                    @endphp

                    <div class="col-12 col-md-6 col-lg-4 d-flex">
                        <div class="card webinar-card shadow-sm border-0 h-100 w-100 overflow-hidden position-relative d-flex flex-column">
                            <div class="webinar-header position-relative">
                                <div class="overlay"></div>
                                <i class="bi bi-camera-video-fill icono"></i>
                                <span class="badge {{ $estadoColor }} estado-badge">{{ ucfirst($estado) }}</span>
                            </div>

                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="fw-bold text-dark mb-2 text-truncate">{{ $webinar->titulo }}</h5>
                                <p class="text-muted small mb-2">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    {{ $fecha->format('d/m/Y H:i') }}
                                </p>

                                @if($webinar->privado)
                                    <p class="text-danger small mb-2">
                                        <i class="bi bi-lock-fill"></i> Webinar privado (requiere clave)
                                    </p>
                                @else
                                    <p class="text-success small mb-2">
                                        <i class="bi bi-globe"></i> Webinar público
                                    </p>
                                @endif

                                <p class="text-secondary flex-grow-1">{{ Str::limit($webinar->descripcion, 140) }}</p>

                                <div class="mt-3 d-grid gap-2">
                                    @if (($estado === 'proximo' || $estado === 'en_vivo') && !$inscrito)
                                        <button
                                            class="btn btn-outline-success rounded-pill fw-semibold btn-open-registro"
                                            data-webinar-id="{{ $webinar->id }}"
                                            data-webinar-title="{{ $webinar->titulo }}"
                                            data-webinar-privado="{{ $webinar->privado ? '1' : '0' }}"
                                            type="button">
                                            <i class="bi bi-person-plus-fill me-1"></i> Inscribirme
                                        </button>
                                    @elseif ($inscrito && $estado === 'en_vivo')
                                        <a href="{{ route('cliente.webinars.acceder', $webinar->id) }}" 
                                           class="btn btn-danger rounded-pill fw-semibold">
                                            <i class="bi bi-broadcast me-1"></i> Ver en vivo
                                        </a>
                                    @elseif ($inscrito && $estado === 'finalizado')
                                        <a href="{{ $webinar->video_url }}" target="_blank" 
                                           class="btn btn-secondary rounded-pill fw-semibold">
                                            <i class="bi bi-play-circle me-1"></i> Ver Grabación
                                        </a>
                                    @else
                                        <div class="small text-muted">Abierto solo para inscritos</div>
                                    @endif
                                </div>
                            </div>

                            <div class="card-footer bg-light border-0 text-center py-3">
                                <small class="text-muted">
                                    <i class="bi bi-person-circle me-1"></i>
                                    {{ $webinar->creador->nombre ?? 'Administrador' }}
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
  </div>

  <!-- FOOTER (fijo abajo cuando contenido corto) -->

</div>

<!-- ===== MODAL DE CLAVE (Privado) ===== -->
<div class="modal fade" id="claveModal" tabindex="-1" aria-labelledby="claveModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title fw-bold" id="claveModalLabel">🔒 Webinar privado</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center p-4">
        <p class="text-muted mb-3">Este webinar es privado. Ingresa la clave de acceso para continuar:</p>
        <input type="password" id="clave_acceso" class="form-control text-center mb-2" placeholder="Clave de acceso">
        <input type="hidden" id="clave_webinar_id">
        <div id="clave_help" class="form-text text-muted">La clave la entrega el organizador.</div>
      </div>
      <div class="modal-footer border-0 d-flex justify-content-between p-3">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button id="btnValidarClave" class="btn btn-success fw-semibold">Validar clave</button>
      </div>
    </div>
  </div>
</div>

<!-- ===== MODAL DE REGISTRO (completo con todos los campos) ===== -->
<div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 border-0 shadow-lg">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title fw-bold" id="registroModalLabel">Acceder a Webinar</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

     <div class="modal-body p-4">
      <form id="registroForm" novalidate>
        @csrf
        <input type="hidden" id="registro_webinar_id" name="webinar_id">

        <div class="row g-3">
          <!-- NOMBRE -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
          </div>

          <!-- APELLIDO -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Apellido</label>
            <input type="text" name="apellido" class="form-control" required>
          </div>

          <!-- DOCUMENTO -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Documento de identidad</label>
            <input type="text" name="documento_identidad" class="form-control" required>
          </div>

          <!-- TELÉFONO -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Teléfono</label>
            <input type="text" name="telefono" class="form-control">
          </div>

          <!-- EDAD -->
          <div class="col-md-4">
            <label class="form-label fw-semibold">Edad</label>
            <input type="number" name="edad" class="form-control" min="1" max="120" required>
          </div>

          <!-- SEXO -->
          <div class="col-md-4">
            <label class="form-label fw-semibold">Sexo</label>
            <select name="sexo" class="form-select" required>
              <option value="">Seleccione</option>
              <option value="Hombre">Hombre</option>
              <option value="Mujer">Mujer</option>
              <option value="Indefinido">Indefinido</option>
            </select>
          </div>

          <!-- ETNIA -->
          <div class="col-md-4">
            <label class="form-label fw-semibold">Etnia</label>
            <select name="etnia" class="form-select">
              <option value="">Seleccione</option>
              <option value="Ninguna">Ninguna</option>
              <option value="Indígena">Indígena</option>
              <option value="Afrodescendiente">Afrodescendiente</option>
              <option value="Raizal">Raizal</option>
              <option value="Palenquero">Palenquero</option>
              <option value="ROM">ROM</option>
            </select>
          </div>

          <!-- GRUPO POBLACIONAL -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Grupo poblacional</label>
            <select name="grupo_poblacional" class="form-select" required>
              <option value="">Seleccione</option>
              <option value="Estudiante">Estudiante</option>
              <option value="Docente">Docente</option>
              <option value="Funcionario">Funcionario</option>
              <option value="Comunidad">Comunidad</option>
              <option value="Otro">Otro</option>
            </select>
          </div>

          <!-- BARRIO -->
          <div class="col-md-3">
            <label class="form-label fw-semibold">Barrio</label>
            <input type="text" name="barrio" class="form-control" required>
          </div>

          <!-- COMUNA -->
          <div class="col-md-3">
            <label class="form-label fw-semibold">Comuna</label>
            <input type="text" name="comuna" class="form-control" required>
          </div>
        </div>
      </form>
     </div>

      <div class="modal-footer border-0 d-flex justify-content-between">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button id="btnGuardarRegistro" type="button" class="btn btn-success">
          Guardar y agregar a Mis conferencias
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ===== ESTILOS ADICIONALES ===== -->
<style>
  body { background:#f8f9fa; }
  .webinar-card { border-radius: 1.2rem; min-height: 460px; display:flex; flex-direction:column; }
  .webinar-header { height:140px; background:linear-gradient(135deg,#198754,#20c997); position:relative; border-top-left-radius:1.2rem; border-top-right-radius:1.2rem; }
  .overlay{ position:absolute; inset:0; background:radial-gradient(circle at 30% 20%, rgba(255,255,255,0.12), transparent 70%); }
  .icono{ position:absolute; bottom:12px; right:12px; font-size:2.4rem; color:rgba(255,255,255,0.65); }
  .estado-badge{ position:absolute; top:12px; left:12px; padding:.4em .85em; border-radius:24px; font-weight:700; text-transform:capitalize; }
  .site-footer{ position:relative; bottom:0; width:100%; }
  @media (max-width:576px){
    .webinar-card{ min-height:520px; }
  }
</style>

<!-- ===== SCRIPTS ===== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  AOS.init({ duration: 700, once: true });

  const claveModalEl = document.getElementById('claveModal');
  const registroModalEl = document.getElementById('registroModal');
  const claveModal = new bootstrap.Modal(claveModalEl);
  const registroModal = new bootstrap.Modal(registroModalEl);

  // abrir flujo: si privado -> validar clave -> abrir modal registro
  document.querySelectorAll('.btn-open-registro').forEach(btn => {
      btn.addEventListener('click', () => {
          const privado = btn.dataset.webinarPrivado === '1';
          const id = btn.dataset.webinarId;
          const title = btn.dataset.webinarTitle;
          if (privado) {
              document.getElementById('clave_webinar_id').value = id;
              document.getElementById('clave_acceso').value = '';
              claveModal.show();
          } else {
              abrirModalRegistro(id, title);
          }
      });
  });

  // Validate key
  document.getElementById('btnValidarClave').addEventListener('click', async () => {
      const id = document.getElementById('clave_webinar_id').value;
      const clave = document.getElementById('clave_acceso').value.trim();
      if (!clave) return Swal.fire('Atención', 'Debes ingresar una clave.', 'warning');

      const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    || document.querySelector('input[name="_token"]')?.value;

      try {
          const res = await fetch(`/cliente/webinars/${encodeURIComponent(id)}/validar-clave`, {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': token
              },
              body: JSON.stringify({ clave })
          });

          const data = await res.json();

          if (res.ok && data.valida) {
              bootstrap.Modal.getInstance(claveModalEl).hide();
              abrirModalRegistro(id, data.titulo || document.querySelector(`[data-webinar-id="${id}"]`)?.dataset.webinarTitle || 'Registro');
          } else {
              Swal.fire('Clave incorrecta', data.message || 'La clave ingresada no es válida.', 'error');
          }
      } catch (err) {
          console.error(err);
          Swal.fire('Error', 'No se pudo validar la clave. Intenta de nuevo.', 'error');
      }
  });

  function abrirModalRegistro(id, titulo) {
      document.getElementById('registro_webinar_id').value = id;
      document.getElementById('registroModalLabel').textContent = `Accede a: ${titulo}`;
      document.getElementById('registroForm').reset();
      registroModal.show();
  }

  // Envío del registro con Fetch (mejor control de UX y mensajes)
  const btnGuardar = document.getElementById('btnGuardarRegistro');
  btnGuardar.addEventListener('click', async () => {
      const form = document.getElementById('registroForm');
      if (!form.reportValidity()) return;

      const webinarId = document.getElementById('registro_webinar_id').value;
      if (!webinarId) return Swal.fire('Error', 'Id del webinar no disponible', 'error');

      const fd = new FormData(form);
      const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    || document.querySelector('input[name="_token"]')?.value;

      // UI lock
      btnGuardar.disabled = true;
      const orig = btnGuardar.innerHTML;
      btnGuardar.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';

      try {
          const res = await fetch(`/cliente/webinars/${encodeURIComponent(webinarId)}/registrar-participante`, {
              method: 'POST',
              headers: { 'X-CSRF-TOKEN': token }, // no Content-Type -> FormData
              body: fd
          });

          const data = await res.json().catch(() => null);

          if (res.ok && data && (data.success === true || data.registered === true)) {
              await Swal.fire({ icon: 'success', title: 'Registro exitoso', text: data.message || 'Te has inscrito correctamente.' });
              registroModal.hide();
              // si backend devuelve en_vivo_url redirige
              if (data.en_vivo_url) {
                  window.location.href = data.en_vivo_url;
                  return;
              }
              // refrescar para actualizar botones/estado
              window.location.reload();
          } else {
              const msg = data?.message || 'No se pudo completar el registro.';
              Swal.fire('Error', msg, 'error');
          }
      } catch (err) {
          console.error(err);
          Swal.fire('Error', 'No se pudo conectar al servidor. Intenta de nuevo.', 'error');
      } finally {
          btnGuardar.disabled = false;
          btnGuardar.innerHTML = orig;
      }
  });

});
</script>
@endsection
