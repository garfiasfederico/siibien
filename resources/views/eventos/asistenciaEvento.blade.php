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
                                    <div class="alert alert-info mb-0">
                                        No hay eventos activos, favor de informar al Administrador.
                                    </div>
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
                            <button type="button" class="btn btn-success btn-sm" onclick="abrirModalEscaneo()" id="btnEscanear">
                                Escanear QR
                            </button>
                        </div>
                    </div>

                    <div class="card-body">

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
                                        {{-- si no hay asistencias aún, deja vacío; al escanear se irán agregando --}}
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


    @endif
@endsection
@section('scripts')
    {{-- Librería de lectura de QR desde cámara --}}
    <script src="https://unpkg.com/html5-qrcode" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', initUI);

        let dt;                 // DataTable
        let html5Qr = null;     // Html5Qrcode instance
        let camRunning = false;
        let lastScanAt = 0;

        // manejo de cámaras por índice (para “Voltear cámara”)
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

        /* ==================== KPI helpers ==================== */
        function recalcKpisFromTable() {
            if (!dt) return;

            const nodes = dt.rows({ search: 'applied' }).nodes().to$();

            // Conteo de presentes y armado de desglose por dependencia
            let presentes = 0;
            const map = new Map(); // dep => { dep, count, firstAt, lastAt }

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
                        // actualizar min/max usando comparación lexicográfica YYYY-MM-DD HH:MM
                        if (!it.firstAt || hora < it.firstAt) it.firstAt = hora;
                        if (!it.lastAt || hora > it.lastAt) it.lastAt = hora;
                    }
                }
            });

            // Actualiza KPI "Presentes"
            $('#kpiPresentes').text(presentes);

            // Actualiza KPI "Dependencias"
            depStats = Array.from(map.values()).sort((a, b) => b.count - a.count || a.dep.localeCompare(b.dep));
            $('#kpiDependencias').text(depStats.length);
        }


        /* ================= Estado evento / IDs ================= */
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

        /* ================= Modal /   ================= */
        function abrirModalEscaneo() {
            if (obtenerEstadoEventoActual() !== 'activo') {
                mostrarToast('El evento no está activo. No se pueden registrar asistencias.');
                return;
            }
            $('#modalScan').modal('show');
        }

        function wireModalAndInputs() {
            // Foco al abrir modal (si existe input manual)
            $('#modalScan').on('shown.bs.modal', function () {
                $('#inputQR').val('').trigger('focus');
            });

            // Limpiar/detener al cerrar
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

            // Toggle cámara
            $('#btnCamToggle').on('click', () => camRunning ? stopCamera() : startCameraFlow());

            $('#btnKpiDependencias').on('click', function () {
                renderDependenciasModal();
                $('#modalDependencias').modal('show');
            });
        }


        /*  Botón “Voltear cámara”  */
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
            btnFlip.style.display = 'none'; // se mostrará sólo si hay >1 cámara
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
            // HTTPS o localhost
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

            // listar cámaras y arrancar
            try {
                cameraDevices = await Html5Qrcode.getCameras();
                if (!cameraDevices || !cameraDevices.length) {
                    $('#qrCamStatus').text('No hay cámaras disponibles');
                    mostrarToast('No se detectaron cámaras en el dispositivo.');
                    return;
                }
                const backIdx = pickBackCameraIndex(cameraDevices);
                await restartCameraWithDeviceIndex(backIdx);

                // mostrar botón “Voltear” si hay más de una
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
                    //  resaltar la fila existente (si la encontramos por QR normalizado)
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
                mostrarToast(j.message || 'Check-in registrado.');

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

        //  Tabla: insertar/actualizar fila
        function upsertAsistenciaEnTabla(qrNorm, data) {
            const $match = buscarFilaPorQr(qrNorm);
            const ahora = obtenerFechaHoraActual();

            if ($match && $match.length) {
                // Si ya está presente, no cambiamos conteos
                if (String($match.attr('data-estado')) === 'presente') return;

                $match.attr('data-estado', 'presente');
                $match.find('[data-hora]').text(data.checked_in_at || ahora);
                $match.find('.estado-cell').html('<span class="badge-estado badge-presente">Presente</span>');
                dt.row($match).invalidate().draw(false);
                return;
            }

            // Crear fila nueva – siempre guardamos el QR normalizado en data-qr
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

            // Si viene como URL, toma el último segmento 
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
    </script>
@endsection