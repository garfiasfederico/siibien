@extends('layouts.administrador')

@section('encabezado')
    Asistencias / Listado de Registros
@endsection

@section('styles')
    <style>
        .header-dark {
            background-color: rgb(157, 36, 73);
            color: #fff;
        }

        .brand-primary {
            background-color: #681b2e;
            color: #fff;
        }

        .brand-secondary {
            background-color: #7c2f42;
            color: #fff;
        }

        .gray-1 {
            background-color: #c5c5c5;
            color: #fff;
        }

        .gray-2 {
            background-color: #ececec;
            color: #111;
        }

        .th-reg,
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

        .th-op {
            width: 220px;
        }

        table.table-list thead {
            background-color: #919090;
            color: #fff;
        }

        table.table-list td {
            padding: 8px;
            vertical-align: middle;
            border: 1px solid #e0e0e0;
            color: #333;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .btn-actions {
            margin: 3px 0;
            width: 100%;
        }

        .botones-alineados {
            display: flex;
            flex-direction: column;
            gap: 8px;
            width: 210px;
            margin: 0 auto;
        }

        .chip {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 14px;
            font-size: .8rem;
            background: #f0f0f8;
            color: #444;
            border: 1px solid #e5e5ee;
        }

        .modal-header-custom {
            background-color: #681b2e;
            color: #fff;
        }

        .modal-body-padding {
            padding: 22px;
        }

        input[type=text],
        input[type=email],
        input[type=tel],
        select,
        textarea {
            height: 38px;
            color: #111;
        }

        textarea {
            height: 100px;
        }

        #qrPreview img {
            image-rendering: pixelated;
        }
    </style>
@endsection

@section('content')
    @csrf
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between brand-primary">
                    <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">
                        Listado-Registros
                    </h6>
                </div>

                <div class="card-body" id="indicadorContent">


                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-list" id="tablaRegistros" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th class="th-id">ID</th>
                                    <th class="th-reg">Nombre</th>
                                    <th class="th-reg">Cargo</th>
                                    <th class="th-reg">Dependencia</th>
                                    <th class="th-reg">Email</th>
                                    <th class="th-reg">Teléfono</th>
                                    <th class="th-reg">Perfil</th>
                                    <th class="th-reg">Tipo enlace</th>
                                    <th class="th-op">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($registros as $r)
                                    <tr data-id="{{ $r->idRegistro }}">
                                        <td class="text-center">{{ $r->idRegistro }}</td>
                                        <td>{{ e($r->nombre) }}</td>
                                        <td>{{ e($r->cargo) }}</td>
                                        <td class="text-center"><span class="chip">{{ e($r->dependencia ?? '—') }}</span></td>
                                        <td>{{ e($r->email) }}</td>
                                        <td>{{ e($r->telefono) }}</td>
                                        <td>{{ e($r->perfil) }}</td>
                                        <td>{{ e($r->tipo_enlace) }}</td>
                                        <td>
                                            <div class="botones-alineados">
                                                <button class="btn btn-sm btn-primary btn-actions" onclick="onVerClick(this)"
                                                    data-id="{{ $r->idRegistro }}" data-nombre="{{ e($r->nombre) }}"
                                                    data-cargo="{{ e($r->cargo) }}"
                                                    data-dependencia="{{ e($r->dependencia ?? '') }}"
                                                    data-dependencia-id="{{ $r->idDependencia }}" {{-- ← nuevo --}}
                                                    data-email="{{ e($r->email) }}" data-telefono="{{ e($r->telefono) }}"
                                                    data-perfil="{{ e($r->perfil) }}" data-tipo="{{ e($r->tipo_enlace) }}" {{--
                                                    ya existía --}} data-qr="{{ e($r->qr_uuid) }}">
                                                    <i class="fas fa-eye"></i> Ver
                                                </button>

                                                <button class="btn btn-sm btn-info btn-actions" onclick="onQRClick(this)"
                                                    data-qr="{{ e($r->qr_uuid) }}" data-qrimg="{{ $r->qr_svg_data }}">
                                                    <i class="fas fa-qrcode"></i> QR
                                                </button>


                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">No hay registros.</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Modal Ver/Editar ===== --}}
    <div class="modal fade" id="modalRegistro" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title" id="modalRegistroLabel">Detalle del registro</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-body-padding">
                    <form id="formRegistro" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label><strong>Nombre</strong></label>
                                <input type="text" class="form-control" id="regNombre" readonly>
                                <div class="invalid-feedback">Nombre es obligatorio.</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Cargo</strong></label>
                                <input type="text" class="form-control" id="regCargo" required>
                                <div class="invalid-feedback">Cargo es obligatorio.</div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label><strong>Dependencia</strong></label>
                                <select class="form-control" id="regDependencia" disabled>
                                    @if(!empty($dependenciasSeleccionada))
                                        <option value="{{ $dependenciasSeleccionada->idDependencia }}">
                                            {{ $dependenciasSeleccionada->dependenciaSiglas }}
                                        </option>
                                    @else
                                        <option value="">—</option>
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label><strong>Email</strong></label>
                                <input type="email" class="form-control" id="regEmail" readonly>
                                <div class="invalid-feedback">Email inválido.</div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label><strong>Teléfono</strong></label>
                                <input type="tel" class="form-control" id="regTelefono">
                                <div class="invalid-feedback">Teléfono inválido.</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Perfil Académico</strong></label>
                                <input type="text" class="form-control" id="regPerfil">
                                <div class="invalid-feedback">Perfil inválido.</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Tipo de enlace</strong></label>
                                <select class="form-control" id="regTipo" required>
                                    <option value="">--Seleccione--</option>
                                    <option value="Directivo">Directivo</option>
                                    <option value="Operativo">Operativo</option>
                                    <option value="Otro">Otro</option>
                                </select>
                                <div class="invalid-feedback">Seleccione el tipo de enlace.</div>
                            </div>

                            <div class="col-md-12 mb-2">
                                <label><strong>QR permanente</strong></label>
                                <div class="d-flex align-items-center">
                                    <input type="text" class="form-control mr-2" id="regQR" readonly>
                                    <button type="button" class="btn btn-outline-secondary" id="btnCopiarQR"
                                        onclick="copiarQR()">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Este QR es único por persona.</small>
                            </div>
                        </div>
                        <input type="hidden" id="regId">
                    </form>
                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn brand-secondary" id="btnGuardarCambios" onclick="guardarCambios()">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>


    {{-- ===== Modal QR ===== --}}

    <div class="modal fade" id="modalQR" tabindex="-1" aria-labelledby="modalQRLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title" id="modalQRLabel">QR del registro</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>

                <div class="modal-body modal-body-padding text-center">
                    <div class="mb-3">
                        <img id="qrImg" alt="Código QR" style="width:220px;height:220px;image-rendering:pixelated;">
                    </div>

                    <input type="text" class="form-control text-center" id="qrTexto" readonly>
                    <small class="text-muted">Valor del QR permanente</small>
                </div>

                <div class="modal-footer">
                    <a id="btnDescargarQR" class="btn brand-secondary" download="qr_registro.svg">
                        <i class="fas fa-download"></i> Descargar QR
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', initApp);

        function initApp() {
            initDataTable();
            bindUI();
        }

        function initDataTable() {
            if (!$.fn.DataTable) return;

            $('#tablaRegistros').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 50],
                order: [[0, 'asc']],
                language: { url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json' }
            });
        }

        function bindUI() {
            $('#modalRegistro').on('hidden.bs.modal', function () {
                $('#formRegistro').removeClass('was-validated');
            });
        }

        function onVerClick(btn) {
            limpiarModalRegistro();
            const d = btn.dataset;

            $('#modalRegistroLabel').text('Detalle del registro #' + (d.id || ''));
            $('#regId').val(d.id || '');

            $('#regNombre').val(d.nombre || '');              // readonly
            $('#regCargo').val(d.cargo || '');
            $('#regEmail').val(d.email || '');                // readonly
            $('#regTelefono').val(d.telefono || '');
            $('#regPerfil').val(d.perfil || '');
            $('#regQR').val(d.qr || '');

            // Selects:
            $('#regTipo').val(d.tipo || '');
            $('#regDependencia').empty().append(
                $('<option>', {
                    value: d.dependenciaId || '',
                    text: d.dependencia || '—'
                })
            );
            $('#modalRegistro').modal('show');
        }

        function onQRClick(btn) {
            const uuid = btn.dataset.qr || '';
            const img64 = btn.dataset.qrimg || '';
            const id = btn.closest('tr')?.dataset.id || '';

            document.getElementById('modalQRLabel').textContent =
                'QR del registro' + (id ? ` #${id}` : '');
            document.getElementById('qrTexto').value = uuid;

            if (!img64) {
                toastCopy('No hay imagen de QR generada para este registro.');
                return;
            }

            document.getElementById('qrImg').src = img64;

            prepararDescargaDataUrlSVGcomoPNG(img64, '#btnDescargarQR', `qr_registro${id ? '_' + id : ''}.png`);

            $('#modalQR').modal('show');
        }

        function prepararDescargaDataUrlSVGcomoPNG(svgDataUrl, linkSelector, nombreArchivo = "qr.png") {
            const downloadLink = document.querySelector(linkSelector);
            if (!svgDataUrl || !downloadLink) return;

            const image = new Image();
            image.onload = function () {
                const escala = 3;
                const canvas = document.createElement("canvas");
                canvas.width = image.width * escala;
                canvas.height = image.height * escala;
                const ctx = canvas.getContext("2d");
                ctx.scale(escala, escala);
                ctx.drawImage(image, 0, 0);

                canvas.toBlob(function (blob) {
                    const pngUrl = URL.createObjectURL(blob);
                    downloadLink.href = pngUrl;
                    downloadLink.download = nombreArchivo;
                }, "image/png");
            };
            image.src = svgDataUrl;
        }

        // function descargarQR() {
        //     const a = document.getElementById('btnDescargarQR');
        //     if (!a || !a.href) return;
        //     a.click();
        // }

        function copiarQR() {
            var el = document.getElementById('regQR');
            el.select(); el.setSelectionRange(0, 99999);
            document.execCommand('copy');
            toastCopy('QR copiado al portapapeles');
        }

        function limpiarModalRegistro() {
            $('#formRegistro').trigger('reset');
            $('#regQR').val('');
            $('#regTipo').val('');
            $('#regDependencia').val('');
            $('#formRegistro').removeClass('was-validated');
        }

        function toastCopy(msg) {
            var t = $('<div/>', {
                text: msg,
                css: {
                    position: 'fixed', bottom: '20px', right: '20px',
                    background: '#681b2e', color: '#fff', padding: '10px 14px',
                    borderRadius: '6px', zIndex: 9999, boxShadow: '0 4px 12px rgba(0,0,0,.2)'
                }
            }).appendTo('body');
            setTimeout(function () { t.fadeOut(400, function () { t.remove(); }); }, 1400);
        }
        function guardarCambios() {
            const id = document.getElementById('regId').value;

            if (!id) {
                Swal.fire('Error', 'ID de registro inválido.', 'error');
                return;
            }

            //  campos editables
            const payload = {
                cargo: (document.getElementById('regCargo').value || '').trim(),
                telefono: (document.getElementById('regTelefono').value || '').trim(),
                perfil: (document.getElementById('regPerfil').value || '').trim(),
                tipo_enlace: document.getElementById('regTipo').value || ''
            };

            const $btn = $('#btnGuardarCambios');
            const originalHtml = $btn.html();
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');

            fetch(`{{ url('/registros') }}/${encodeURIComponent(id)}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify(payload)
            })
                .then(async (response) => {
                    const data = await response.json().catch(() => ({}));

                    if (response.ok && data && data.success) {
                        Swal.fire('Éxito', data.message || 'Registro actualizado correctamente.', 'success')
                            .then(() => {
                                $('#modalRegistro').modal('hide');

                                location.reload();
                            });
                    } else {
                        const msg = (data && (data.message || (data.errors && 'Errores de validación.'))) || 'No se pudo actualizar el registro.';
                        Swal.fire('Error', msg, 'error');
                    }
                })
                .catch((err) => {
                    console.error('Error al guardar:', err);
                    Swal.fire('Error de red', 'No se pudo conectar al servidor.', 'error');
                })
                .finally(() => {
                    $btn.prop('disabled', false).html(originalHtml);
                });
        }


    </script>
@endsection