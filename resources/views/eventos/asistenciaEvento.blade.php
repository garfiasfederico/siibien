@extends('layouts.administrador')

@section('encabezado')
    Asistencias / Asistencias por Evento
@endsection

@section('styles')
    <style>
        .brand-primary {
            background: #681b2e;
            color: #fff;
        }

        .brand-secondary {
            background: #7c2f42;
            color: #fff;
        }

        .th-col,
        .th-id,
        .th-op {
            border: 1px solid #d1d1d1;
            text-align: center;
            padding: 8px;
            font-weight: 600;
        }

        .th-id {
            width: 80px;
        }

        table.table-list thead {
            background: #919090;
            color: #fff;
        }

        table.table-list td {
            padding: 8px;
            vertical-align: middle;
            border: 1px solid #e0e0e0;
            color: #333;
        }

        .kpi {
            border-radius: 10px;
            padding: 14px 16px;
            background: #f7f7f9;
            border: 1px solid #eee;
            display: flex;
            flex-direction: column;
            gap: 6px;
            height: 100%;
        }

        .kpi .label {
            font-size: .85rem;
            color: #555;
        }

        .kpi .value {
            font-size: 1.4rem;
            font-weight: 700;
            color: #222;
        }

        .modal-header-custom {
            background: #681b2e;
            color: #fff;
        }

        .modal-body-padding {
            padding: 22px;
        }

        .badge-estado {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 14px;
            font-size: .78rem;
            font-weight: 600;
            min-width: 108px;
            text-align: center;
            color: #fff;
        }

        .badge-presente {
            background: #28a745;
        }

        .row-flash {
            animation: flashRow 1.8s ease-out;
        }

        @keyframes flashRow {
            0% {
                background: #d4edda;
            }

            100% {
                background: transparent;
            }
        }

        /* Área de cámara */
        #qrCamContainer {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
        }

        #qrCamStatus {
            font-size: .85rem;
            color: #666;
        }
    </style>
@endsection

@section('content')
    @csrf
    @php
        /** @var \App\Models\Evento|null $eventoActivo */
        $idEvento = $idEvento ?? ($eventoActivo?->idEvento ?? null);
        $estadoEvento = $estadoEvento ?? ($eventoActivo ? 'activo' : null);
        $nombreEvento = $eventoActivo?->nombre ?? '—';
    @endphp

    @if(!$eventoActivo)
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-list" width="100%" cellspacing="0">
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="alert alert-info mb-2">
                                        Este evento no existe o no está activo.
                                    </div>
                                    <a href="{{ route('eventos.activos') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-chevron-left"></i> Volver a seleccionar evento
                                    </a>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="row" data-evento-id="{{ $idEvento }}" data-estado-evento="{{ $estadoEvento }}"
            data-evento-nombre="{{ e($nombreEvento) }}">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex align-items-center justify-content-between brand-primary">
                        <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">
                            Asistencias — {{ e($nombreEvento) }}
                        </h6>
                        <div class="d-flex align-items-center" style="gap:8px;">
                            <a href="{{ route('eventos.activos') }}" class="btn btn-sm"
                                style="background:#f7f7f9; border:1px solid #ccc; border-radius:50px; color:#681b2e; font-weight:600;">
                                Cambiar evento
                            </a>

                        </div>
                    </div>


                    <div class="card-body">

                        {{-- Botones de acciones --}}
                        <div class="d-flex justify-content-end mb-3" style="gap:.5rem;">
                            <button type="button" class="btn btn-info btn-sm" onclick="abrirModalParticipante()">
                                <i class="fas fa-user"></i> Registrar participante
                            </button>
                            <button type="button" class="btn btn-success btn-sm" onclick="abrirModalEscaneo()" id="btnEscanear">
                                <i class="fas fa-qrcode"></i> Escanear QR
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="abrirModalAgregar()">
                                <i class="fas fa-user-plus"></i> Registrar Asistencia
                            </button>
                        </div>

                        {{-- KPIs --}}
                        @php $presentesIniciales = isset($asistencias) ? $asistencias->count() : 0; @endphp
                        <div class="row mb-3">
                            <div class="col-md-3 mb-3">
                                <div class="kpi">
                                    <div class="label">Presentes</div>
                                    <div class="value" id="kpiPresentes">{{ $presentesIniciales }}</div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <button type="button" class="kpi" id="btnKpiDependencias"
                                    style="width:100%; text-align:left; border:none; cursor:pointer;">
                                    <div class="label">Dependencias (presentes)</div>
                                    <div class="value" id="kpiDependencias">0</div>
                                    <small class="text-muted">Haz clic para ver desglose</small>
                                </button>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="kpi">
                                    <div class="label">Último registro</div>
                                    <div class="value" id="kpiUltimo">{{ $kpiUltimo }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Tabla --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-list" id="tablaAsistencias" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr class="text-center">
                                        <th class="th-id">IdAsistencia</th>
                                        <th class="th-col">Nombre</th>
                                        <th class="th-col">Dependencia</th>
                                        <th class="th-col">QR</th>
                                        <th class="th-col">Hora check-in</th>
                                        <th class="th-col">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($asistencias as $a)
                                        <tr data-idr="{{ $a->idRegistro }}" data-qr="{{ e($a->qr_uuid) }}" data-estado="presente"
                                            class="row-flash">
                                            <td class="text-center">{{ $a->idAsistencia }}</td>
                                            <td>{{ e($a->nombre) }}</td>
                                            <td class="text-center">{{ e($a->dependencia) }}</td>
                                            <td>{{ e($a->qr_uuid) }}</td>
                                            <td class="text-center" data-hora>{{ $a->scanned_at }}</td>
                                            <td class="text-center estado-cell">
                                                <span class="badge-estado badge-presente">Presente</span>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        {{-- ===== Modal Escáner (solo cámara) ===== --}}
        <div class="modal fade" id="modalScan" tabindex="-1" aria-labelledby="modalScanLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header modal-header-custom">
                        <h5 class="modal-title" id="modalScanLabel">Escanear QR</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="text-white">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body modal-body-padding">
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-2" style="gap:8px;">
                            <div id="qrCamStatus">Cámara inactiva</div>
                            <div class="d-flex align-items-center" style="gap:6px;">
                                <select id="cameraSelect" class="form-control form-control-sm"
                                    style="min-width:210px; display:none;"></select>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="btnFlip"
                                    style="display:none;">Voltear</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="btnTorch"
                                    style="display:none;">Linterna</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="btnPause"
                                    style="display:none;">Pausar</button>
                                <button type="button" class="btn btn-sm btn-outline-success" id="btnCamToggle">Iniciar
                                    cámara</button>
                            </div>
                        </div>

                        <div id="qrCamContainer"></div>
                        <small class="text-muted d-block mt-2">
                            Permite acceso a la cámara. El check-in se registrará automáticamente al detectar un código válido.
                        </small>
                    </div>

                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- ===== Modal Dependencias (desglose) ===== --}}
        <div class="modal fade" id="modalDependencias" tabindex="-1" aria-labelledby="modalDependenciasLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header modal-header-custom">
                        <h5 class="modal-title" id="modalDependenciasLabel">Desglose por Dependencia</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="text-white">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body modal-body-padding">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="tablaDependencias" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr class="text-center">
                                        <th>Dependencia</th>
                                        <th>Presentes</th>
                                        <th>Primer check-in</th>
                                        <th>Último check-in</th>
                                    </tr>
                                </thead>
                                <tbody id="depsTbody">
                                    {{-- se llena vía JS --}}
                                </tbody>
                            </table>
                        </div>
                        {{-- <small class="text-muted">Se calcula en tiempo real con las filas marcadas como “Presente”.</small>
                        --}}
                    </div>

                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal Agregar Participante (manual) --}}
        <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header modal-header-custom">
                        <h5 class="modal-title" id="modalAgregarLabel">Agregar participante (check-in manual)</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="text-white">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body modal-body-padding">
                        <div class="d-flex flex-wrap align-items-end" style="gap:.6rem 1rem;">
                            <div style="min-width: 280px;">
                                <label class="mb-1"><strong>Dependencia</strong></label>
                                <select id="depFiltro" class="form-control">
                                    <option value="">— Todas —</option>
                                    @foreach($dependencias as $d)
                                        <option value="{{ $d->idDependencia }}">{{ $d->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div style="min-width: 280px;">
                                <label class="mb-1"><strong>Búsqueda</strong></label>
                                <input id="qFiltro" type="text" class="form-control" placeholder="Nombre, cargo o QR…">
                            </div>

                            <div class="ml-auto">
                                <button id="btnBuscarReg" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>

                        <hr>

                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0" id="tablaRegistros">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th style="width:80px;">ID</th>
                                        <th>Nombre</th>
                                        <th>Dependencia</th>
                                        <th>Cargo</th>
                                        <th style="width:200px;">QR</th>
                                        <th style="width:140px;">Acción</th>
                                    </tr>
                                </thead>
                                <tbody><!-- se llena por JS --></tbody>
                            </table>
                        </div>

                        {{-- <small class="text-muted d-block mt-2">
                            Tip: el check-in manual envía el <code>qr_uuid</code> del registro al endpoint de check-in del
                            evento seleccionado.
                        </small> --}}
                    </div>

                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>

                </div>
            </div>
        </div>
        {{-- Modal Registrar Participante --}}
        <div class="modal fade" id="modalParticipante" tabindex="-1" aria-labelledby="modalParticipanteLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header modal-header-custom">
                        <h5 class="modal-title" id="modalParticipanteLabel">Registrar participante</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="text-white">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body modal-body-padding">
                        {{-- Errores para AJAX --}}
                        <div id="regPartErrors" class="alert alert-danger d-none mb-3">
                            <ul class="mb-0" id="regPartErrorsList"></ul>
                        </div>

                        {{-- Vista previa del QR (si es alta) --}}
                        <div id="regPartQrWrap" class="mb-3 d-none" style="text-align:center;">
                            <div id="regPartQrSvg"></div>
                            <small class="text-muted d-block">Este es el código QR generado.</small>
                        </div>

                        <form id="formRegistroParticipante" novalidate method="POST"
                            action="{{ route('participantes.registrar') }}">
                            @csrf

                            <div class="row text-left" style="color: black">
                                <div class="col-lg-12 mb-12 p-2">
                                    <label for="tipo_enlace">Tipo de Enlace <span class="text-danger">*</span></label>
                                    <select name="tipo_enlace" id="tipo_enlace" class="form-control" required>
                                        <option value="">--Seleccione</option>
                                        <option value="Directivo">Directivo</option>
                                        <option value="Operativo">Operativo</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>

                                <div class="col-lg-12 mb-12 p-2">
                                    <label for="nombre">Nombre Completo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control py-3" id="nombre" name="nombre"
                                        placeholder="Nombre del Enlace" required>
                                </div>

                                <div class="col-lg-12 mb-12 p-2">
                                    <label for="dependencia">Institución <span class="text-danger">*</span></label>
                                    <select class="form-control" id="dependencia" name="dependencia" required>
                                        <option value="">Seleccione...</option>
                                        @foreach ($dependencias as $dep)
                                            <option value="{{ $dep->idDependencia }}">
                                                {{ $dep->nombre ?? $dep->dependenciaSiglas ?? $dep->dependenciaNombre ?? 'Sin nombre' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-12 mb-12 p-2">
                                    <label for="cargo">Cargo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control py-3" id="cargo" name="cargo"
                                        placeholder="Cargo que desempeña" required>
                                </div>

                                <div class="col-lg-12 mb-12 p-2">
                                    <label for="perfil">Perfil Académico <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control py-3" id="perfil" name="perfil"
                                        placeholder="Perfil académico" required>
                                </div>

                                <div class="col-lg-12 mb-12 p-2">
                                    <label for="email">Correo Electrónico <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control py-3" id="email" name="email"
                                        placeholder="ejemplo@ejemplo.com" required>
                                </div>

                                <div class="col-lg-12 mb-12 p-2">
                                    <label for="telefono">Teléfono de contacto <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control py-3" id="telefono" name="telefono"
                                        placeholder="Ej: 9991234567" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn" style="background-color: #681b2e; color:white">
                                    <i class="fas fa-save"></i> Registrar participante
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endif
@endsection
@section('scripts')
    {{-- Librería de lectura de QR desde cámara --}}
    <script src="https://unpkg.com/html5-qrcode" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', initUI);

        let dt;
        let html5Qr = null;
        let camRunning = false;
        let lastScanAt = 0;

        let cameraDevices = [];
        let currentDeviceIndex = -1;

        let depStats = [];

        function initUI() {
            initTable();
            wireModalAndInputs();
            actualizarEstadoBotonEscanear();
            if (dt) dt.on('draw', recalcKpisFromTable);
            recalcKpisFromTable();
            prepareFlipButton();
        }

        function initTable() {
            if (!$.fn.DataTable) return;
            dt = $('#tablaAsistencias').DataTable({
                pageLength: 10,
                lengthChange: false,
                searching: true,
                info: false,
                order: [[0, 'desc']],
                dom: 'lrtip',
                language: { url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json' },
            });
        }

        function recalcKpisFromTable() {
            if (!dt) return;

            const nodes = dt.rows({ search: 'applied' }).nodes().to$();

            let presentes = 0;
            const map = new Map();

            nodes.each(function () {
                const $row = $(this);
                if (String($row.attr('data-estado')) !== 'presente') return;

                presentes++;

                const dep = ($row.find('td').eq(2).text() || '—').trim();
                const hora = ($row.find('[data-hora]').text() || '').trim();

                if (!map.has(dep)) {
                    map.set(dep, { dep, count: 1, firstAt: hora || '', lastAt: hora || '' });
                } else {
                    const it = map.get(dep);
                    it.count += 1;
                    if (hora) {
                        if (!it.firstAt || hora < it.firstAt) it.firstAt = hora;
                        if (!it.lastAt || hora > it.lastAt) it.lastAt = hora;
                    }
                }
            });

            $('#kpiPresentes').text(presentes);

            depStats = Array.from(map.values()).sort((a, b) => b.count - a.count || a.dep.localeCompare(b.dep));
            $('#kpiDependencias').text(depStats.length);
        }


        function getEventoId() {
            const el = document.querySelector('[data-evento-id]');
            return el ? Number(el.getAttribute('data-evento-id')) : 0;
        }
        function obtenerEstadoEventoActual() {
            const el = document.querySelector('[data-estado-evento]');
            return el ? el.getAttribute('data-estado-evento') : 'pendiente';
        }
        function actualizarEstadoBotonEscanear() {
            const enabled = obtenerEstadoEventoActual() === 'activo';
            $('#btnEscanear').prop('disabled', !enabled).attr('title', enabled ? '' : 'El evento no está activo');
        }

        function abrirModalEscaneo() {
            if (obtenerEstadoEventoActual() !== 'activo') {
                mostrarToast('El evento no está activo. No se pueden registrar asistencias.');
                return;
            }
            $('#modalScan').modal('show');
        }

        function wireModalAndInputs() {
            $('#modalScan').on('shown.bs.modal', function () {
                $('#inputQR').val('').trigger('focus');
            });

            $('#modalScan').on('hidden.bs.modal', function () {
                stopCamera();
                $('#inputQR').val('');
            });

            // // ---- Sección “manual”  ----
            // $('#inputQR').on('keydown', function (e) {
            //     if (e.key === 'Enter') {
            //         e.preventDefault();
            //         const code = $(this).val().trim();
            //         if (code) registrarAsistenciaPorQR(code);
            //     }
            // });

            $('#btnGuardarManual').on('click', function () {
                const code = $('#inputQR').val().trim();
                if (!code) return mostrarToast('Ingresa un valor de QR');
                registrarAsistenciaPorQR(code);
            });

            // // ---- Tabs  ----
            // $('a[data-toggle="tab"]').on('shown.bs.tab', async function (e) {
            //     const target = $(e.target).attr('href');
            //     if (target === '#pane-camera') {
            //         await startCameraFlow();
            //     } else {
            //         stopCamera();
            //         setTimeout(() => $('#inputQR').trigger('focus'), 80);
            //     }
            // });

            $('#btnCamToggle').on('click', () => camRunning ? stopCamera() : startCameraFlow());

            $('#btnKpiDependencias').on('click', function () {
                renderDependenciasModal();
                $('#modalDependencias').modal('show');
            });
        }

        function isMobile() {
            return /Android|webOS|iPhone|iPad|iPod|Opera Mini|IEMobile/i.test(navigator.userAgent);
        }

        function prepareFlipButton() {
            const wrapper = document.querySelector('#pane-camera .d-flex.align-items-center.mb-2 > div:last-child');
            if (!wrapper) return;

            const btnFlip = document.createElement('button');
            btnFlip.id = 'btnFlip';
            btnFlip.type = 'button';
            btnFlip.className = 'btn btn-sm btn-outline-primary';
            btnFlip.textContent = 'Voltear cámara';
            btnFlip.style.marginRight = '8px';
            btnFlip.style.display = 'none';
            btnFlip.addEventListener('click', async () => {
                if (cameraDevices.length <= 1) return;
                const next = (currentDeviceIndex + 1) % cameraDevices.length;
                await restartCameraWithDeviceIndex(next);
            });

            const toggleBtn = document.getElementById('btnCamToggle');
            if (toggleBtn) wrapper.insertBefore(btnFlip, toggleBtn);
        }

        /*  Cámara   */
        function isDevSecureEnough() {
            const h = location.hostname;
            return window.isSecureContext || h === 'localhost' || h === '127.0.0.1' || h === '::1';
        }

        function waitForHtml5Qrcode(ms = 8000) {
            return new Promise((resolve, reject) => {
                const start = Date.now();
                (function check() {
                    if (window.Html5Qrcode && typeof Html5Qrcode.getCameras === 'function') return resolve();
                    if (Date.now() - start > ms) return reject(new Error('html5-qrcode no disponible'));
                    setTimeout(check, 50);
                })();
            });
        }

        async function startCameraFlow() {
            if (!isDevSecureEnough()) {
                $('#qrCamStatus').text('Se requiere HTTPS (o localhost) para usar la cámara');
                mostrarToast('Usa HTTPS o un túnel (ngrok/cloudflared) para probar en el celular.');
                return;
            }

            try {
                await waitForHtml5Qrcode();
            } catch {
                $('#qrCamStatus').text('Librería de cámara no cargada');
                mostrarToast('La librería de QR aún no está lista. Intenta otra vez.');
                return;
            }

            try {
                const tmp = await navigator.mediaDevices.getUserMedia({ video: true });
                tmp.getTracks().forEach(t => t.stop());
            } catch (e) {
                $('#qrCamStatus').text('Permiso de cámara denegado');
                mostrarToast('Permiso de cámara denegado. Revisa los permisos del navegador.');
                return;
            }

            try {
                cameraDevices = await Html5Qrcode.getCameras();
                if (!cameraDevices || !cameraDevices.length) {
                    $('#qrCamStatus').text('No hay cámaras disponibles');
                    mostrarToast('No se detectaron cámaras en el dispositivo.');
                    return;
                }
                const backIdx = pickBackCameraIndex(cameraDevices);
                await restartCameraWithDeviceIndex(backIdx);

                const btnFlip = document.getElementById('btnFlip');
                if (btnFlip) btnFlip.style.display = cameraDevices.length > 1 && isMobile() ? 'inline-block' : 'none';

            } catch (err) {
                console.error('startCameraFlow error:', err?.name, err?.message || err);
                $('#qrCamStatus').text('No se pudo iniciar la cámara');
                mostrarToast('No se pudo iniciar la cámara (verifica permisos/HTTPS).');
            }
        }

        function pickBackCameraIndex(devs) {
            let idx = devs.findIndex(d => /back|environment|rear|trasera/i.test(d.label));
            if (idx === -1) idx = 0;
            return idx;
        }

        function computeQrbox() {
            const cont = document.getElementById('qrCamContainer');
            const w = cont ? cont.clientWidth : 400;
            const boxW = Math.max(240, Math.min(400, Math.floor(w * 0.7)));
            return { width: boxW, height: boxW };
        }

        async function restartCameraWithDeviceIndex(idx) {
            await stopCamera();

            if (!window.Html5Qrcode) { mostrarToast('Librería de QR no cargó.'); return; }
            if (!html5Qr) html5Qr = new Html5Qrcode('qrCamContainer', false);

            currentDeviceIndex = idx;
            const cameraId = cameraDevices[idx].id || cameraDevices[idx].deviceId || cameraDevices[idx];

            const scanConfig = {
                fps: 15,
                qrbox: computeQrbox(),
                aspectRatio: 1.3333,
                experimentalFeatures: { useBarCodeDetectorIfSupported: true },
                formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE]
            };

            try {
                await html5Qr.start(
                    cameraId,
                    scanConfig,
                    onQrDecodedFromCamera,
                    onQrScanFailure
                );

                camRunning = true;
                $('#qrCamStatus').text('Cámara activa');
                $('#btnCamToggle').text('Detener cámara')
                    .removeClass('btn-outline-secondary').addClass('btn-outline-danger');

                window.addEventListener('resize', resizeReinit, { passive: true });

            } catch (err) {
                console.error('html5Qr.start error:', err?.name, err?.message || err);
                $('#qrCamStatus').text('No se pudo iniciar la cámara (reintentando configuración básica)');

                // Fallback mínimo
                try {
                    await html5Qr.start(
                        cameraId,
                        { qrbox: computeQrbox(), fps: 10 },
                        onQrDecodedFromCamera,
                        onQrScanFailure
                    );

                    camRunning = true;
                    $('#qrCamStatus').text('Cámara activa');
                    $('#btnCamToggle').text('Detener cámara')
                        .removeClass('btn-outline-secondary').addClass('btn-outline-danger');

                    window.addEventListener('resize', resizeReinit, { passive: true });

                } catch (e2) {
                    console.error('Fallback start error:', e2?.name, e2?.message || e2);
                    mostrarToast('No se pudo iniciar la cámara (¿otra app la está usando?).');
                }
            }
        }

        const resizeReinit = debounce(async () => {
            if (!camRunning) return;
            try { await restartCameraWithDeviceIndex(currentDeviceIndex); } catch (_) { }
        }, 500);

        async function stopCamera() {
            window.removeEventListener('resize', resizeReinit);
            if (html5Qr && camRunning) {
                try { await html5Qr.stop(); await html5Qr.clear(); } catch (_) { }
            }
            camRunning = false;
            $('#qrCamStatus').text('Cámara inactiva');
            $('#btnCamToggle').text('Iniciar cámara')
                .removeClass('btn-outline-danger').addClass('btn-outline-secondary');
        }

        function onQrDecodedFromCamera(decodedText/*, decodedResult*/) {
            const now = Date.now();
            if (now - lastScanAt < 300) return;
            lastScanAt = now;
            if (decodedText) registrarAsistenciaPorQR(String(decodedText).trim());
        }
        function onQrScanFailure(/*err*/) { /* silencioso */ }

        /* Registrar asistencia  */
        function obtenerFechaHoraActual() {
            const d = new Date(), pad = n => String(n).padStart(2, '0');
            return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())} ${pad(d.getHours())}:${pad(d.getMinutes())}`;
        }
        function generarIdTemporal() { return Math.floor(Date.now() / 1000); }
        function escaparHtml(str) {
            if (str == null) return '';
            return String(str).replace(/[&<>"']/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m]));
        }
        function mostrarToast(msg) {
            var t = $('<div/>', { text: msg, css: { position: 'fixed', bottom: '20px', right: '20px', background: '#681b2e', color: '#fff', padding: '10px 14px', borderRadius: '6px', zIndex: 9999, boxShadow: '0 4px 12px rgba(0,0,0,.2)' } }).appendTo('body');
            setTimeout(function () { t.fadeOut(400, function () { t.remove(); }); }, 1400);
        }

        async function registrarAsistenciaPorQR(qrCodeRaw) {
            if (obtenerEstadoEventoActual() !== 'activo') { mostrarToast('El evento no está activo.'); return; }
            const eventoId = getEventoId();
            if (!eventoId) { mostrarToast('No se pudo determinar el evento activo.'); return; }

            const qrCode = normalizarQr(qrCodeRaw);

            try {
                const r = await fetch(`{{ url('/eventos/checkin') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({ qr_uuid: qrCode, idEvento: eventoId })
                });

                const j = await r.json().catch(() => ({}));
                if (!r.ok || j.success === false) {
                    mostrarToast(j.message || 'No se pudo registrar la asistencia.');
                    // En error, NO tocar KPIs (no se agrega ni actualiza fila)
                    return;
                }

                if (j.data?.duplicado) {
                    const $row = buscarFilaPorQr(qrCode);
                    if ($row && $row.length) {
                        $row.addClass('row-flash');
                        setTimeout(() => $row.removeClass('row-flash'), 1800);
                    }
                    mostrarToast(j.message || 'Asistencia ya registrada.');
                    return;
                }

                const payload = {
                    idAsistencia: j.data?.idAsistencia,
                    idRegistro: j.data?.idRegistro,
                    nombre: j.data?.nombre || '—',
                    dependencia: j.data?.dependencia || '—',
                    checked_in_at: j.data?.checkin_at || obtenerFechaHoraActual(),
                    qr_code: qrCode,
                    duplicado: false
                };

                upsertAsistenciaEnTabla(qrCode, payload);
                $('#kpiUltimo').text(payload.checked_in_at);
                recalcKpisFromTable();
                swalCheckinOk(payload.nombre, payload.checked_in_at, payload.dependencia);

            } catch (err) {
                console.error(err);
                mostrarToast('Error de red al registrar la asistencia.');
            } finally {
                $('#inputQR').val('');
            }
        }

        function buscarFilaPorQr(qrNorm) {
            let $match = null;
            $('#tablaAsistencias tbody tr').each(function () {
                if (String($(this).attr('data-qr')) === qrNorm) { $match = $(this); return false; }
            });
            return $match;
        }

        function renderDependenciasModal() {
            const $tbody = $('#depsTbody').empty();

            if (!depStats.length) {
                $tbody.append(`<tr><td colspan="4" class="text-center text-muted">Sin presentes aún.</td></tr>`);
                return;
            }

            for (const it of depStats) {
                const dep = escaparHtml(it.dep || '—');
                const c = it.count || 0;
                const fi = escaparHtml(it.firstAt || '—');
                const la = escaparHtml(it.lastAt || '—');

                $tbody.append(`
                                                                                                                  <tr>
                                                                                                                    <td>${dep}</td>
                                                                                                                    <td class="text-center"><strong>${c}</strong></td>
                                                                                                                    <td class="text-center">${fi}</td>
                                                                                                                    <td class="text-center">${la}</td>
                                                                                                                  </tr>
                                                                                                                `);
            }
        }

        function upsertAsistenciaEnTabla(qrNorm, data) {
            const $match = buscarFilaPorQr(qrNorm);
            const ahora = obtenerFechaHoraActual();

            if ($match && $match.length) {
                if (String($match.attr('data-estado')) === 'presente') return;

                $match.attr('data-estado', 'presente');
                $match.find('[data-hora]').text(data.checked_in_at || ahora);
                $match.find('.estado-cell').html('<span class="badge-estado badge-presente">Presente</span>');
                dt.row($match).invalidate().draw(false);
                return;
            }

            const idShown = data.idAsistencia || data.idRegistro || generarIdTemporal();
            const nombre = escaparHtml(data.nombre || '—');
            const dep = escaparHtml(data.dependencia || '—');
            const hora = escaparHtml(data.checked_in_at || ahora);

            const $row = $(`
                                                                                                <tr data-idr="${data.idRegistro || ''}" data-qr="${qrNorm}" data-estado="presente" class="row-flash">
                                                                                                  <td class="text-center">${idShown}</td>
                                                                                                  <td>${nombre}</td>
                                                                                                  <td class="text-center">${dep}</td>
                                                                                                  <td>${escaparHtml(qrNorm)}</td>
                                                                                                  <td class="text-center" data-hora>${hora}</td>
                                                                                                  <td class="text-center estado-cell"><span class="badge-estado badge-presente">Presente</span></td>
                                                                                                </tr>
                                                                                              `);

            dt.row.add($row[0]).draw(false);
        }
        function normalizarQr(code) {
            if (code == null) return '';
            let s = String(code).trim();

            try {
                const u = new URL(s);
                const fromQuery = u.searchParams.get('qr') || u.searchParams.get('uuid') || u.searchParams.get('id') || '';
                if (fromQuery) s = fromQuery;
                else {
                    const parts = u.pathname.split('/').filter(Boolean);
                    if (parts.length) s = parts[parts.length - 1];
                }
            } catch (_) { /* no era URL, seguimos */ }

            return s.replace(/\s+/g, '').toLowerCase();
        }


        function debounce(fn, wait) {
            let t; return function (...args) { clearTimeout(t); t = setTimeout(() => fn.apply(this, args), wait); };
        }
        //Agregar Check-in de manera manual
        function abrirModalAgregar() {
            if (obtenerEstadoEventoActual() !== 'activo') {
                mostrarToast('El evento no está activo. No se pueden registrar asistencias.');
                return;
            }
            // limpia filtros
            $('#depFiltro').val('');
            $('#qFiltro').val('');
            // limpia tabla
            $('#tablaRegistros tbody').html(
                `<tr><td colspan="6" class="text-center text-muted">Usa los filtros y presiona <strong>Buscar</strong>.</td></tr>`
            );
            $('#modalAgregar').modal('show');
        }

        $('#btnBuscarReg').on('click', function () {
            buscarRegistrosAjax();
        });

        $('#qFiltro').on('keydown', function (e) {
            if (e.key === 'Enter') { e.preventDefault(); buscarRegistrosAjax(); }
        });

        function buscarRegistrosAjax() {
            const idDep = $('#depFiltro').val() || '';
            const q = ($('#qFiltro').val() || '').trim();
            const url = `{{ route('registros.buscar') }}`;
            const params = new URLSearchParams();
            if (idDep) params.set('idDependencia', idDep);
            if (q) params.set('q', q);
            params.set('limit', 100);

            $('#tablaRegistros tbody').html(
                `<tr><td colspan="6" class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando…</td></tr>`
            );

            fetch(url + '?' + params.toString(), { headers: { 'Accept': 'application/json' } })
                .then(r => r.json())
                .then(j => {
                    if (!j || j.success === false) throw new Error(j.message || 'Error');
                    renderTablaRegistros(j.data || []);
                })
                .catch(err => {
                    $('#tablaRegistros tbody').html(
                        `<tr><td colspan="6" class="text-center text-danger">${(err.message || 'Error al buscar registros')}</td></tr>`
                    );
                });
        }

        function renderTablaRegistros(items) {
            const $tb = $('#tablaRegistros tbody').empty();
            if (!items.length) {
                $tb.append(`<tr><td colspan="6" class="text-center text-muted">Sin resultados.</td></tr>`);
                return;
            }
            const esc = s => (s == null ? '' : String(s).replace(/[&<>"']/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m])));

            items.forEach(r => {
                const depRaw = r.dependencia || r.dependenciaSiglas || r.dependenciaNombre || '—';

                const tr = `
                                                <tr>
                                                    <td class="text-center">${esc(r.idRegistro)}</td>
                                                    <td>${esc(r.nombre || '—')}</td>
                                                    <td>${esc(depRaw)}</td>
                                                    <td>${esc(r.cargo || '—')}</td>
                                                    <td>${esc(r.qr_uuid || '')}</td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-success" onclick="checkinManual('${esc(r.qr_uuid || '')}')">
                                                            <i class="fas fa-check"></i> Check-in
                                                        </button>
                                                    </td>
                                                </tr>`;
                $tb.append(tr);
            });
        }
        async function checkinManual(qrUuid) {
            const eventoId = getEventoId();
            if (!eventoId) { mostrarToast('No se pudo determinar el evento.'); return; }
            if (!qrUuid) { mostrarToast('Registro sin QR.'); return; }

            try {
                const r = await fetch(`{{ url('/eventos/checkin') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({ qr_uuid: String(qrUuid).trim(), idEvento: eventoId })
                });
                const j = await r.json().catch(() => ({}));
                if (!r.ok || j.success === false) {
                    mostrarToast(j.message || 'No se pudo registrar la asistencia.');
                    return;
                }

                const qrNorm = normalizarQr(qrUuid);
                const payload = {
                    idAsistencia: j.data?.idAsistencia,
                    idRegistro: j.data?.idRegistro,
                    nombre: j.data?.nombre || '—',
                    dependencia: j.data?.dependencia || '—',
                    checked_in_at: j.data?.checkin_at || obtenerFechaHoraActual(),
                    qr_code: qrNorm,
                    duplicado: !!j.data?.duplicado
                };

                if (payload.duplicado) {
                    const $row = buscarFilaPorQr(qrNorm);
                    if ($row && $row.length) {
                        $row.addClass('row-flash');
                        setTimeout(() => $row.removeClass('row-flash'), 1800);
                    }
                    mostrarToast(j.message || 'Asistencia ya registrada.');
                } else {
                    upsertAsistenciaEnTabla(qrNorm, payload);
                    $('#kpiUltimo').text(payload.checked_in_at);
                    recalcKpisFromTable();
                    swalCheckinOk(payload.nombre, payload.checked_in_at, payload.dependencia);
                }

            } catch (e) {
                mostrarToast('Error de red al registrar la asistencia.');
            }
        }
        function swalCheckinOk(nombre, hora, dep) {
            Swal.fire({
                icon: 'success',
                title: 'Asistencia registrada',
                html: `
                                          <div style="font-size:14px;line-height:1.4;">
                                            <strong>${nombre || '—'}</strong><br>
                                            <span class="text-muted">Dependencia:</span> ${dep || '—'}<br>
                                            <span class="text-muted">Hora:</span> ${hora || '—'}
                                          </div>
                                        `,
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true
            });
        }
        function abrirModalParticipante() {
            const $modal = $('#modalParticipante');
            const $form = $('#formRegistroParticipante');

            if (!$modal.length || !$form.length) return;

            function swalValidationErrors(errors, meta, fallbackMessage) {
                let html = '<ul style="text-align:left; margin:0; padding-left:18px;">';
                let hasAny = false;

                if (errors && typeof errors === 'object') {
                    Object.keys(errors).forEach(k => {
                        (errors[k] || []).forEach(msg => {
                            hasAny = true;
                            html += `<li>${String(msg)}</li>`;
                        });
                    });
                }

                if (!hasAny) {
                    html += `<li>${fallbackMessage || 'Revisa los campos obligatorios.'}</li>`;
                }
                html += '</ul>';

                let title = 'Corrige los errores';
                const razon = meta && meta.razon ? String(meta.razon) : '';

                if (razon === 'email_duplicado') {
                    title = 'El correo ya existe';
                } else if (razon === 'nombre_duplicado_misma_dependencia') {
                    title = 'Nombre duplicado en la misma institución';
                } else if (razon === 'conflicto') {
                    title = 'No se pudo completar la operación';
                }

                Swal.fire({
                    icon: 'error',
                    title,
                    html,
                    confirmButtonText: 'Entendido'
                });
            }

            $form[0].reset();
            $modal.modal('show');
            setTimeout(() => $('#nombre').trigger('focus'), 150);

            $modal.one('hidden.bs.modal', function () {
                $form[0].reset();
                $form.off('submit._rp');
            });

            $form.off('submit._rp');

            $form.on('submit._rp', async function (e) {
                e.preventDefault();

                const action = $form.attr('action');
                const fd = new FormData(this);
                const $submit = $form.find('button[type="submit"]');
                const originalHtml = $submit.html();

                // loading
                $submit.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');

                try {
                    const r = await fetch(action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: fd
                    });

                    if (r.status === 422) {
                        const j = await r.json().catch(() => ({}));
                        swalValidationErrors(j.errors || null, j.meta || null, j.message || null);
                        return;
                    }

                    if (r.status === 409) {
                        const j = await r.json().catch(() => ({}));
                        swalValidationErrors(j.errors || null, j.meta || { razon: 'conflicto' }, j.message || 'Conflicto al registrar.');
                        return;
                    }

                    if (!r.ok) {
                        const j = await r.json().catch(() => ({}));
                        Swal.fire({
                            icon: 'error',
                            title: 'No se pudo registrar',
                            text: (j && j.message) ? j.message : 'Intenta nuevamente.'
                        });
                        return;
                    }
                    const j = await r.json().catch(() => ({}));
                    const esNuevo = !!(j.data && j.data.esNuevo);
                    const nombre = (j.data && j.data.nombre) || '—';

                    await Swal.fire({
                        icon: 'success',
                        title: esNuevo ? 'Participante registrado' : 'Participante actualizado',
                        html: `<div style="font-size:14px;"><strong>${nombre}</strong></div>`,
                        timer: 2000,
                        showConfirmButton: false,
                        timerProgressBar: true
                    });

                    // Limpieza post-éxito
                    $form[0].reset();
                    $modal.modal('hide');

                } catch (err) {
                    console.error(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de red',
                        text: 'No se pudo contactar al servidor.'
                    });
                } finally {
                    $submit.prop('disabled', false).html(originalHtml);
                }
            });
        }
    </script>
@endsection