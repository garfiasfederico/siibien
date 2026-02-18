@extends('layouts.administrador')

@section('encabezado')
    Asistencias / Administración de Eventos
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

        .th-op {
            width: 260px;
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
            width: 240px;
            margin: 0 auto;
        }

        /* Badges de estado */
        .badge-estado {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 14px;
            font-size: .78rem;
            font-weight: 600;
            color: #fff;
            min-width: 108px;
            text-align: center;
        }

        .badge-pendiente {
            background: #ffc107;
            color: #212529;
        }

        /* amarillo */
        .badge-activo {
            background: #28a745;
        }

        /* verde */
        .badge-finalizado {
            background: #6c757d;
        }

        /* gris */

        /* Modal */
        .modal-header-custom {
            background: #681b2e;
            color: #fff;
        }

        .modal-body-padding {
            padding: 22px;
        }

        input[type=text],
        input[type=datetime-local],
        select,
        textarea {
            color: #111;
        }

        textarea {
            height: 110px;
        }

        .select-readonly {
            background: #f0f0f8 !important;
            color: #444 !important;
            box-shadow: 0 0 0 2px #eee inset;
            pointer-events: none;
        }

        #evDepLinea {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: .5rem .5rem;

        }

        #evDepLinea .evdep-btn {
            font-weight: 500;
            line-height: 1.1;
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
                        Administración de Eventos
                    </h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <div style="text-align: right; padding:10px;">
                            {{-- Nuevo evento usa la función unificada --}}
                            <button type="button" class="btn btn-success" onclick="abrirEvento()">
                                <i class="fas fa-calendar-plus"></i> Nuevo evento
                            </button>
                        </div>

                        <table class="table table-bordered table-striped table-list" id="tablaEventos" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th class="th-id">ID</th>
                                    <th class="th-col">Nombre</th>
                                    <th class="th-col">Detalles</th>
                                    <th class="th-col">Descripción</th>
                                    <th class="th-col">Sede</th>
                                    <th class="th-col">Inicio</th>
                                    <th class="th-col">Fin</th>
                                    <th class="th-col">Estado</th>
                                    <th class="th-op">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($eventos as $ev)
                                    @php
                                        $badgeClass =
                                            $ev->estado_str === 'activo'
                                            ? 'badge-activo'
                                            : ($ev->estado_str === 'finalizado'
                                                ? 'badge-finalizado'
                                                : 'badge-pendiente');
                                    @endphp

                                    <tr data-id="{{ $ev->idEvento }}" data-estado="{{ $ev->estado_str }}"
                                        data-deps="{{ e($ev->idDependencia_invitadas ?? '') }}">
                                        <td class="text-center">{{ $ev->idEvento }}</td>
                                        <td>{{ e($ev->nombre) }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-info btn-actions" onclick="verDetallesEvento(this)">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        </td>
                                        <td>{{ e($ev->descripcion) }}</td>
                                        <td>{{ e($ev->sede) }}</td>
                                        <td>{{ $ev->fecha_inicio_fmt }}</td>
                                        <td>{{ $ev->fecha_fin_fmt }}</td>
                                        <td class="text-center">
                                            <span class="badge-estado {{ $badgeClass }}">{{ ucfirst($ev->estado_str) }}</span>
                                        </td>

                                        <td>
                                            <div class="botones-alineados">
                                                @if ($ev->estado_str === 'pendiente')
                                                    {{-- Editar solo en pendiente --}}
                                                    <button class="btn btn-sm btn-primary btn-actions" onclick="abrirEvento(this)">
                                                        <i class="fas fa-edit"></i> Editar
                                                    </button>
                                                    {{-- Iniciar desde pendiente --}}
                                                    <button class="btn btn-sm btn-success btn-actions"
                                                        onclick="iniciarEvento(this)">
                                                        <i class="fas fa-play"></i> Iniciar
                                                    </button>
                                                    <button class="btn btn-sm btn-danger btn-actions"
                                                        onclick="eliminarEvento(this)">
                                                        <i class="fas fa-trash"></i> Eliminar
                                                    </button>
                                                @elseif ($ev->estado_str === 'activo')
                                                    {{-- Finalizar cuando está activo --}}
                                                    <button class="btn btn-sm btn-warning btn-actions"
                                                        onclick="finalizarEvento(this)">
                                                        <i class="fas fa-hourglass-end"></i>
                                                        Finalizar
                                                    </button>
                                                @else
                                                    {{-- Finalizado: sin acciones --}}
                                                    <span class="text-muted" style="display:inline-block;padding:6px 0;">No
                                                        se puede
                                                        modificar un evento finalizado</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">Sin eventos.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Evento (Nuevo / Editar) --}}
    <div class="modal fade" id="modalEvento" tabindex="-1" aria-labelledby="modalEventoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title" id="modalEventoLabel">Nuevo evento</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-body-padding">
                    <form id="formEvento" novalidate>
                        <input type="hidden" id="evId">
                        <input type="hidden" id="evEstadoHidden" value="pendiente"><!-- control interno -->
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label><strong>Nombre del evento</strong></label>
                                <input type="text" class="form-control" id="evNombre" required>
                                <div class="invalid-feedback">El nombre es obligatorio.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label><strong>Estado </strong></label>
                                <select class="form-control select-readonly" id="evEstado" disabled>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="activo">Activo</option>
                                    <option value="finalizado">Finalizado</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label><strong>Descripción</strong></label>
                                <textarea class="form-control" id="evDescripcion"
                                    placeholder="Descripción breve del evento"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label><strong>Sede</strong></label>
                                <input type="text" class="form-control" id="evSede">

                            </div>
                            {{-- Dependencias participantes --}}
                            <div class="col-md-12 mb-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="mb-0"><strong>Dependencias participantes</strong></label>
                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                        onclick="mostrarPanelAgregarDependencia(true)">
                                        <i class="fas fa-plus"></i> Agregar dependencia
                                    </button>
                                </div>

                                {{-- Línea de chips separadas por comas --}}
                                <div id="evDepLinea" class="d-flex flex-wrap align-items-center"></div>
                                {{-- <small class="text-muted d-block mt-1">
                                </small> --}}
                                <div id="evDepAdd" class="d-none mt-2">
                                    <div class="input-group" style="max-width: 560px;">
                                        <select id="evDepSelect" class="form-control">
                                            <option value="">— Selecciona una dependencia —</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary"
                                                onclick="agregarDependenciaInvitada()">Agregar</button>

                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="mostrarPanelAgregarDependencia(false)">Cancelar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label><strong>Fecha y hora de inicio</strong></label>
                                <input type="datetime-local" class="form-control" id="evInicio">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label><strong>Fecha y hora de fin</strong></label>
                                <input type="datetime-local" class="form-control" id="evFin">
                            </div>
                        </div>
                        <input type="hidden" id="evDepsHidden">
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn brand-secondary" onclick="registrarEvento()">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal detalles de evento --}}
    <div class="modal fade" id="modalDetallesEvento" tabindex="-1" role="dialog" aria-labelledby="modalDetallesEventoLabel"
        aria-hidden="true" style="color: black !important;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="modalDetallesEventoLabel">Detalle de Asistencias</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" style="color:white">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <div id="detLoading" class="py-5 text-center">
                        <i class="fas fa-spinner fa-spin fa-2x"></i>
                        <div class="mt-2">Cargando desglose…</div>
                    </div>

                    <div id="detContent" class="d-none">
                        <div class="table-responsive">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 id="detTituloEvento" class="mb-0">Evento: —</h4>
                                <a id="btnDescargarExcelEvento" href="#" class="btn btn-success" target="_blank"
                                    rel="noopener">
                                    <i class="fas fa-download"></i> Descargar asistencias
                                </a>
                            </div>

                            <div class="card shadow-sm mb-3">
                                <div class="card-body d-flex justify-content-between flex-wrap">
                                    <div class="mb-2">
                                        <h6 class="text-muted mb-1">Dependencias esperadas</h6>
                                        <h4 id="totalDepsEsperadas" class="mb-0">0</h4>
                                    </div>
                                    <div class="mb-2">
                                        <h6 class="text-muted mb-1">Dependencias Presentes</h6>
                                        <h4 id="totalDeps" class="mb-0">0</h4>
                                    </div>
                                    <div class="mb-2">
                                        <h6 class="text-muted mb-1">Total asistentes</h6>
                                        <h4 id="totalAsist" class="mb-0">0</h4>
                                    </div>
                                </div>
                            </div>

                            <!-- Dependencias esperadas -->
                            <div class="card shadow-sm mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h6 class="text-muted mb-0">Dependencias esperadas</h6>
                                        <small class="text-muted">
                                            <span class="btn btn-sm btn-success disabled">Presente</span>
                                            <span class="btn btn-sm btn-secondary disabled">Faltante</span>
                                        </small>
                                    </div>
                                    <div id="btnsDepsEsperadas" class="d-flex flex-wrap" style="gap:.5rem;"></div>
                                </div>
                            </div>

                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr class="text-center align-middle">
                                        <th class="align-middle" style="width: 42%">Dependencia</th>
                                        <th class="align-middle" style="width: 12%">Presentes</th>
                                        <th class="align-middle" style="width: 46%">Asistentes</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyDepDesglose"><!-- Se llena por JS --></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', initApp);
        window.DEPENDENCIAS_OPTS = @json(
            $dependencias->map(function ($d) {
                return [
                    'id' => $d->idDependencia,
                    'nombre' => $d->nombre ?? ($d->dependenciaSiglas ?? $d->dependenciaNombre),
                ];
            })
        );

        function initApp() {
            initDataTable();
            bindUI();
            renderizaChipsDependencias();
        }

        function initDataTable() {
            if (!$.fn.DataTable) return;
            $('#tablaEventos').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 50],
                order: [
                    [0, 'desc']
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
                }
            });
        }

        function bindUI() {
            $('#modalEvento').on('hidden.bs.modal', function () {
                limpiarModalEvento();
                $('#formEvento').removeClass('was-validated');
            });

            $('#modalDetallesEvento').on('hidden.bs.modal', function () {
                $('#detLoading').removeClass('d-none');
                $('#detContent').addClass('d-none');
                $('#detTituloEvento').text('Evento: —');
                $('#totalDepsEsperadas').text('0');
                $('#totalDeps').text('0');
                $('#totalAsist').text('0');
                $('#totalDepsFaltantes').text('0');
                $('#btnsDepsEsperadas').empty();
                $('#tbodyDepDesglose').empty();
            });
        }
        function abrirEvento(btn) {
            limpiarModalEvento();
            setDependenciasDesdeString('');

            if (!btn) {
                // Nuevo
                $('#modalEventoLabel').text('Nuevo evento');
                $('#evEstadoHidden').val('pendiente');
                $('#evEstado').val('pendiente');
                $('#modalEvento').modal('show');
                return;
            }
            const $tr = $(btn).closest('tr');
            const estado = String($tr.attr('data-estado') || 'pendiente');
            if (estado !== 'pendiente') {
                toast('Este evento no puede editarse (no está en pendiente).');
                return;
            }

            $('#modalEventoLabel').text('Editar evento');

            const id = $tr.data('id') || '';
            $('#evId').val(id);
            $('#evNombre').val($tr.children().eq(1).text().trim()); // col 1: Nombre
            $('#evDescripcion').val($tr.children().eq(3).text().trim()); // col 3: Descripción
            $('#evSede').val($tr.children().eq(4).text().trim()); // col 4: Sede
            $('#evInicio').val(formateaParaInputDatetime($tr.children().eq(5).text().trim())); // col 5: Inicio
            $('#evFin').val(formateaParaInputDatetime($tr.children().eq(6).text().trim())); // col 6: Fin

            //Depednedncias invitadas
            const depsStr = $tr.attr('data-deps') || '';
            setDependenciasDesdeString(depsStr);
            // Estado informativo
            $('#evEstadoHidden').val(estado);
            $('#evEstado').val(estado);

            $('#modalEvento').modal('show');
        }
        function registrarEvento() {
            const form = document.getElementById('formEvento');
            if (!form.checkValidity()) {
                $('#formEvento').addClass('was-validated');
                return;
            }

            const idEvento = ($('#evId').val() || '').trim();
            const nombre = $('#evNombre').val().trim();
            const descripcion = $('#evDescripcion').val().trim();
            const sede = $('#evSede').val().trim();
            const fecha_inicio = $('#evInicio').val();
            const fecha_fin = $('#evFin').val();

            const idDependencia_invitadas = ($('#evDepsHidden').val() || '').trim(); // ⬅️ NUEVO

            const body = {
                idEvento: idEvento || null,
                nombre,
                descripcion,
                sede,
                fecha_inicio: fecha_inicio || null,
                fecha_fin: fecha_fin || null,
                idDependencia_invitadas,
            };

            const $btn = $('button[onclick="registrarEvento()"]').first();
            const backup = $btn.html();
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');

            fetch(`{{ url('/eventos/registrar') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify(body)
            })
                .then(r => r.json())
                .then(data => {
                    if (!data.success) throw new Error(data.message || 'Error');

                    const d = data.data;
                    const estadoStr = d.estado_str || 'pendiente';
                    const dt = $('#tablaEventos').DataTable();

                    let $tr = $(`tr[data-id="${d.idEvento}"]`);
                    if ($tr.length) {
                        $tr.children().eq(1).text(d.nombre || ''); // col 1: Nombre
                        $tr.children().eq(3).text(d.descripcion || ''); // 3: Descripción
                        $tr.children().eq(4).text(d.sede || ''); // 4: Sede
                        $tr.children().eq(5).text(d.fecha_inicio || ''); // 5: Inicio
                        $tr.children().eq(6).text(d.fecha_fin || ''); // 6: Fin
                        $tr.children().eq(7).html(renderBadgeEstado(estadoStr)); // 7: Estado
                        $tr.children().eq(8).html(renderAccionesPorEstado(estadoStr)); // 8: Opciones

                        $tr.attr('data-estado', estadoStr).data('estado', estadoStr);
                        $tr.attr('data-deps', d.idDependencia_invitadas || '');
                        dt.row($tr).invalidate().draw(false);
                    } else {
                        // === crear fila nueva (incluye col 2: Detalles) ===
                        const acciones = renderAccionesPorEstado(estadoStr);
                        const $row = $(`
                                                                                                <tr data-id="${d.idEvento}" data-estado="${estadoStr}" data-deps="${escapeHtml(d.idDependencia_invitadas || '')}">
                                                                                                    <td class="text-center">${d.idEvento}</td>                          <!-- 0 ID -->
                                                                                                    <td>${escapeHtml(d.nombre || '')}</td>                               <!-- 1 Nombre -->
                                                                                                    <td class="text-center">                                             <!-- 2 Detalles -->
                                                                                                    <button class="btn btn-sm btn-info btn-actions" onclick="verDetallesEvento(this)">
                                                                                                        <i class="fas fa-info-circle"></i>
                                                                                                    </button>
                                                                                                    </td>
                                                                                                    <td>${escapeHtml(d.descripcion || '')}</td>                          <!-- 3 Descripción -->
                                                                                                    <td>${escapeHtml(d.sede || '')}</td>                                 <!-- 4 Sede -->
                                                                                                    <td>${d.fecha_inicio || ''}</td>                                     <!-- 5 Inicio -->
                                                                                                    <td>${d.fecha_fin || ''}</td>                                        <!-- 6 Fin -->
                                                                                                    <td class="text-center">${renderBadgeEstado(estadoStr)}</td>         <!-- 7 Estado -->
                                                                                                    <td>${acciones}</td>                                                 <!-- 8 Opciones -->
                                                                                                </tr>
                                                                                                `);
                        dt.row.add($row[0]).draw(false);

                    }

                    Swal.fire('Éxito', data.message, 'success');
                    $('#modalEvento').modal('hide');
                    limpiarModalEvento();
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire('Error', err.message || 'No se pudo registrar el evento.', 'error');
                })
                .finally(() => {
                    $btn.prop('disabled', false).html(backup);
                });
        }
        function cambiarEstado($tr, nuevoEstado, $btn) {
            const id = $tr.data('id');
            if (!id) {
                toast('ID inválido');
                return;
            }

            const wasHtml = $btn ? $btn.html() : null;
            if ($btn) $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

            $.ajax({
                url: "{{ url('/eventos') }}/" + encodeURIComponent(id) + "/estado",
                type: 'PATCH',
                data: JSON.stringify({
                    estado: nuevoEstado
                }),
                contentType: 'application/json; charset=UTF-8',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    'Accept': 'application/json'
                }
            })
                .done(function (resp) {
                    if (!resp || !resp.success) {
                        const msg = (resp && resp.message) ? resp.message : 'No se pudo actualizar el estado.';
                        Swal.fire('Error', msg, 'error');
                        return;
                    }
                    actualizarFilaEstado($tr, resp.data.estado_str || nuevoEstado);
                    toast('Estado actualizado');
                })
                .fail(function (xhr) {
                    const status = xhr.status;
                    const msg = (xhr.responseJSON && xhr.responseJSON.message) ?
                        xhr.responseJSON.message :
                        'Error al cambiar estado.';

                    if (status === 422) {
                        Swal.fire({
                            title: 'No se puede iniciar',
                            text: msg,
                            icon: 'warning',
                            confirmButtonText: 'Entendido'
                        });
                    } else if (status === 409) {
                        Swal.fire({
                            title: 'Cambio no permitido',
                            text: msg,
                            icon: 'info',
                            confirmButtonText: 'Ok'
                        });
                    } else if (status === 404) {
                        Swal.fire('No encontrado', msg, 'info');
                    } else {
                        Swal.fire('Error', msg, 'error');
                    }
                })
                .always(function () {
                    if ($btn) $btn.prop('disabled', false).html(wasHtml);
                });
        }

        function iniciarEvento(btn) {
            const $tr = $(btn).closest('tr');
            const estado = String($tr.attr('data-estado') || $tr.data('estado') || 'pendiente');

            if (estado !== 'pendiente') {
                toast('Solo los eventos en pendiente pueden iniciarse.');
                return;
            }
            cambiarEstado($tr, 'activo', $(btn));
        }

        function finalizarEvento(btn) {
            const $tr = $(btn).closest('tr');
            const estado = String($tr.attr('data-estado') || 'pendiente');
            if (estado !== 'activo') {
                toast('Solo los eventos activos pueden finalizarse.');
                return;
            }
            cambiarEstado($tr, 'finalizado', $(btn));
        }

        function actualizarFilaEstado($tr, nuevoEstado) {
            $tr.attr('data-estado', nuevoEstado);
            $tr.data('estado', nuevoEstado);

            $tr.children().eq(7).html(renderBadgeEstado(nuevoEstado));

            $tr.children().eq(8).html(renderAccionesPorEstado(nuevoEstado));

            // Redibujar DataTables
            $('#tablaEventos').DataTable().row($tr).invalidate().draw(false);
        }

        function renderBadgeEstado(estado) {
            if (estado === 'activo')
                return '<span class="badge-estado badge-activo">Activo</span>';
            if (estado === 'finalizado')
                return '<span class="badge-estado badge-finalizado">Finalizado</span>';
            return '<span class="badge-estado badge-pendiente">Pendiente</span>';
        }

        function renderAccionesPorEstado(estado) {
            if (estado === 'pendiente') {
                return `
                                                                                        <div class="botones-alineados">
                                                                                            <button class="btn btn-sm btn-primary btn-actions" onclick="abrirEvento(this)">
                                                                                                <i class="fas fa-edit"></i> Editar
                                                                                            </button>
                                                                                            <button class="btn btn-sm btn-success btn-actions" onclick="iniciarEvento(this)">
                                                                                                <i class="fas fa-play"></i> Iniciar
                                                                                            </button>
                                                                                            <button class="btn btn-sm btn-danger btn-actions" onclick="eliminarEvento(this)">
                                                                                                <i class="fas fa-trash"></i> Eliminar
                                                                                            </button>
                                                                                        </div>
                                                                                    `;
            }
            if (estado === 'activo') {
                return `
                                                                                        <div class="botones-alineados">
                                                                                            <button class="btn btn-sm btn-warning btn-actions" onclick="finalizarEvento(this)">
                                                                                                <i class="fas fa-hourglass-end"></i> Finalizar
                                                                                            </button>
                                                                                        </div>
                                                                                    `;
            }
            return `
                                                                                    <div class="botones-alineados">
                                                                                        <span class="text-muted" style="display:inline-block;padding:6px 0;">
                                                                                            No se puede modificar un evento finalizado
                                                                                        </span>
                                                                                    </div>
                                                                                `;
        }

        function eliminarEvento(btn) {
            const $tr = $(btn).closest('tr');
            const id = $tr.data('id');
            const estado = String($tr.attr('data-estado') || $tr.data('estado') || 'pendiente');

            if (estado !== 'pendiente') {
                Swal.fire({
                    title: 'No se puede eliminar',
                    text: 'Solo los eventos en estado pendiente pueden eliminarse.',
                    icon: 'info',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            Swal.fire({
                title: '¿Eliminar evento?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (!result.isConfirmed) return;

                const $btn = $(btn);
                const wasHtml = $btn.html();
                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

                $.ajax({
                    url: "{{ url('/eventos') }}/" + encodeURIComponent(id),
                    type: 'DELETE',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                        'Accept': 'application/json'
                    }
                })
                    .done(function (resp) {
                        if (!resp || !resp.success) {
                            const msg = (resp && resp.message) ? resp.message :
                                'No se pudo eliminar el evento.';
                            Swal.fire('Error', msg, 'error');
                            return;
                        }

                        // Quitar la fila de la tabla (DataTables si existe)
                        if ($.fn.DataTable && $.fn.DataTable.isDataTable('#tablaEventos')) {
                            const dt = $('#tablaEventos').DataTable();
                            dt.row($tr).remove().draw(false);
                        } else {
                            $tr.remove();
                        }

                        Swal.fire('Eliminado', resp.message || 'Evento eliminado correctamente.', 'success');
                    })
                    .fail(function (xhr) {
                        const status = xhr.status;
                        const msg = (xhr.responseJSON && xhr.responseJSON.message) ?
                            xhr.responseJSON.message :
                            'Error al eliminar el evento.';

                        if (status === 409 || status === 422) {
                            Swal.fire({
                                title: 'No se puede eliminar',
                                text: msg,
                                icon: 'info',
                                confirmButtonText: 'Ok'
                            });
                        } else if (status === 404) {
                            Swal.fire('No encontrado', msg, 'info');
                        } else {
                            Swal.fire('Error', msg, 'error');
                        }
                    })
                    .always(function () {
                        $btn.prop('disabled', false).html(wasHtml);
                    });
            });
        }

        function limpiarModalEvento() {
            $('#formEvento').trigger('reset');
            $('#evId').val('');
            $('#evEstadoHidden').val('pendiente');
            $('#evEstado').val('pendiente');

            setDependenciasDesdeString('');
            mostrarPanelAgregarDependencia(false);
        }

        function formateaParaInputDatetime(texto) {
            if (!texto) return '';
            if (texto.includes('T')) return texto;
            return texto.replace(' ', 'T');
        }

        function escapeHtml(str) {
            if (str == null) return '';
            return String(str).replace(/[&<>"']/g, function (m) {
                return ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                }[m]);
            });
        }

        function toast(msg) {
            var t = $('<div/>', {
                text: msg,
                css: {
                    position: 'fixed',
                    bottom: '20px',
                    right: '20px',
                    background: '#681b2e',
                    color: '#fff',
                    padding: '10px 14px',
                    borderRadius: '6px',
                    zIndex: 9999,
                    boxShadow: '0 4px 12px rgba(0,0,0,.2)'
                }
            }).appendTo('body');
            setTimeout(function () {
                t.fadeOut(400, function () {
                    t.remove();
                });
            }, 1400);
        }

        function verDetallesEvento(btn) {
            const $tr = $(btn).closest('tr');
            const idEvento = $tr.data('id');
            $('#btnDescargarExcelEvento')
                .attr('href', `{{ route('eventos.asistencias.excel', ':id') }}`.replace(':id', idEvento));


            const nombreEvento = ($tr.children().eq(1).text() || '—').trim();

            if (!idEvento) {
                Swal.fire('Error', 'No se pudo determinar el ID del evento.', 'error');
                return;
            }

            $('#detTituloEvento').text('Evento: ' + nombreEvento);
            $('#totalDepsEsperadas').text('0');
            $('#totalDeps').text('0');
            $('#totalAsist').text('0');
            $('#tbodyDepDesglose').empty();
            $('#detLoading').removeClass('d-none');
            $('#detContent').addClass('d-none');

            const depsStrOriginal = String($tr.attr('data-deps') || '').trim();
            const depsEsperadasArr = depsStrOriginal ?
                depsStrOriginal.split(',')
                    .map(x => x.trim())
                    .filter(x => x !== '' && /^\d+$/.test(x))
                    .map(Number) : [];
            const depsEsperadasUnicas = Array.from(new Set(depsEsperadasArr));
            $('#totalDepsEsperadas').text(String(depsEsperadasUnicas.length));

            // Mostrar modal
            $('#modalDetallesEvento').modal('show');

            // Utilidades locales
            const esc = s => (s == null) ? '' : String(s).replace(/[&<>"']/g, m => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[m]));
            const slugId = base => (base || 'x')
                .toString()
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/(^-|-$)/g, '') + '-' + Math.random().toString(36).slice(2, 7);

            const renderTablaPersonas = (personas) => {
                const list = Array.isArray(personas) ? personas : [];
                if (!list.length) return `<em class="text-muted">Sin personas registradas.</em>`;
                list.sort((a, b) => String(a?.hora || '').localeCompare(String(b?.hora || '')));
                const rows = list.map(p => `
                                                                  <tr>
                                                                    <td>${esc((p?.nombre || '—').trim())}</td>
                                                                    <td>${esc((p?.cargo || '—').trim())}</td>
                                                                    <td class="text-center" style="width:160px">${esc((p?.hora || '—').trim())}</td>
                                                                  </tr>`).join('');
                return `
                                                                  <div class="table-responsive">
                                                                    <table class="table table-sm table-bordered mb-0">
                                                                      <thead>
                                                                        <tr class="text-center">
                                                                          <th>Nombre</th><th>Cargo</th><th style="width:160px">Hora check-in</th>
                                                                        </tr>
                                                                      </thead>
                                                                      <tbody>${rows}</tbody>
                                                                    </table>
                                                                  </div>`;
            };

            fetch(`{{ url('/eventos') }}/${encodeURIComponent(idEvento)}/desglose-dependencias`, {
                headers: {
                    'Accept': 'application/json'
                }
            })
                .then(async r => {
                    const ct = (r.headers.get('content-type') || '').toLowerCase();
                    const data = ct.includes('application/json') ? await r.json() : {
                        success: false,
                        message: `Respuesta no JSON (${r.status})`
                    };
                    if (!r.ok || data.success === false) throw new Error(data.message || `Error ${r.status}`);
                    return data;
                })
                .then(j => {
                    const depsRaw = j?.data?.dependencias || [];

                    const deps = depsRaw.filter(d => {
                        const personas = Array.isArray(d?.personas) ? d.personas : [];
                        const count = Number(d?.presentes ?? personas.length ?? 0) || 0;
                        return count > 0;
                    });

                    const $tb = $('#tbodyDepDesglose').empty();

                    if (!deps.length) {
                        $tb.append(
                            `<tr><td colspan="3" class="text-center align-middle text-muted">Sin asistencias registradas.</td></tr>`
                        );
                    } else {
                        deps.forEach(d => {
                            const id = slugId(d?.dep || 'dep');
                            const personas = Array.isArray(d?.personas) ? d.personas : [];
                            const count = Number(d?.presentes ?? personas.length ?? 0) || 0;

                            const asistentes = `
                                              <button class="btn btn-sm btn-outline-primary mb-2" type="button"
                                                      data-toggle="collapse" data-target="#${id}" aria-expanded="false" aria-controls="${id}">
                                                Ver asistentes (${count})
                                              </button>
                                              <div class="collapse mt-2 text-left" id="${id}">
                                                ${renderTablaPersonas(personas)}
                                              </div>`;

                            $tb.append(`
                                              <tr class="fila-dep">
                                                <td class="align-middle"><strong>${esc((d?.dep || '—').trim())}</strong></td>
                                                <td class="align-middle text-center">
                                                    <span class="badge badge-light text-dark px-3 py-2" style="font-size:1.1rem; font-weight:600;">
                                                        ${count}
                                                    </span>
                                                </td>

                                                <td class="align-middle">${asistentes}</td>
                                              </tr>`);
                        });
                    }

                    const totalDeps = deps.length;
                    const totalAsist = deps.reduce((acc, d) => acc + (Number(d.presentes ?? (Array.isArray(d
                        ?.personas) ? d.personas.length : 0)) || 0), 0);
                    $('#totalDeps').text(totalDeps);
                    $('#totalAsist').text(totalAsist);

                    const presentesPorNombre = new Set(
                        depsRaw
                            .filter(d => (Number(d?.presentes ?? (Array.isArray(d?.personas) ? d.personas.length : 0)) || 0) > 0)
                            .map(d => String(d?.dep || '').trim())
                    );

                    // Nombres de esperada
                    const catalogo = window.DEPENDENCIAS_OPTS || [];
                    const esperadoNombres = depsEsperadasUnicas
                        .map(id => {
                            const f = catalogo.find(x => Number(x.id) === Number(id));
                            return f ? String(f.nombre || '').trim() : null;
                        })
                        .filter(Boolean);

                    const esperadoLower = new Set(esperadoNombres.map(n => n.toLowerCase()));
                    const extrasPresentes = Array.from(presentesPorNombre)
                        .filter(n => !esperadoLower.has(n.toLowerCase()));

                    const todos = [...esperadoNombres, ...extrasPresentes];

                    const $btns = $('#btnsDepsEsperadas').empty();
                    if (!todos.length) {
                        $btns.append('<span class="text-muted">Sin dependencias esperadas.</span>');
                    } else {
                        todos.sort((a, b) => a.localeCompare(b, 'es', { sensitivity: 'base' }));
                        todos.forEach(nom => {
                            const present = presentesPorNombre.has(nom) || presentesPorNombre.has(nom.toLowerCase());
                            const cls = present ? 'btn-success' : 'btn-secondary';
                            $btns.append(
                                `<button type="button" class="btn btn-sm ${cls}" disabled>${nom}</button>`
                            );
                        });
                    }


                    $('#detLoading').addClass('d-none');
                    $('#detContent').removeClass('d-none');

                })
                .catch(err => {
                    console.error('desglose-dependencias error:', err);
                    $('#tbodyDepDesglose').html(`
                                                                  <tr>
                                                                    <td colspan="3" class="text-center text-danger">
                                                                      ${esc(err.message || 'Error al cargar el desglose.')}
                                                                    </td>
                                                                  </tr>
                                                                `);
                    $('#detLoading').addClass('d-none');
                    $('#detContent').removeClass('d-none');
                });
        }

        let EV_DEPS = [];

        function setDependenciasDesdeString(s) {
            if (!s) {
                EV_DEPS = [];
                sincronizaHiddenDependencias();
                renderizaChipsDependencias();
                return;
            }
            EV_DEPS = String(s)
                .split(',')
                .map(x => x.trim())
                .filter(x => x !== '' && /^\d+$/.test(x))
                .map(x => Number(x));
            EV_DEPS = Array.from(new Set(EV_DEPS));
            sincronizaHiddenDependencias();
            renderizaChipsDependencias();
        }

        function sincronizaHiddenDependencias() {
            $('#evDepsHidden').val(EV_DEPS.join(','));
        }

        function renderizaChipsDependencias() {
            const $line = $('#evDepLinea').empty();

            if (!EV_DEPS.length) {
                $line.append('<span class="text-muted">Sin dependencias agregadas.</span>');
                return;
            }

            EV_DEPS.forEach((id) => {
                const dep = (window.DEPENDENCIAS_OPTS || []).find(d => Number(d.id) === Number(id));
                const nombre = dep ? dep.nombre : ('ID ' + id);

                const $btn = $(`
                                                                          <button
                                                                            type="button"
                                                                            class="btn btn-sm btn-outline-primary rounded-pill evdep-btn mr-2 mb-2"
                                                                            onclick="quitarDependenciaInvitada(${id})"
                                                                            aria-label="Quitar ${escapeHtml(nombre)}"
                                                                            title="Quitar"
                                                                          >
                                                                            ${escapeHtml(nombre)} &times;
                                                                          </button>
                                                                        `);

                $line.append($btn);
            });
        }

        function quitarDependenciaInvitada(id) {
            const dep = (window.DEPENDENCIAS_OPTS || []).find(d => Number(d.id) === Number(id));
            const nombre = dep ? dep.nombre : ('ID ' + id);

            Swal.fire({
                title: '¿Quitar dependencia?',
                text: `Se quitará "${nombre}" de la lista. El cambio se aplicará al guardar el evento.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, quitar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (!result.isConfirmed) return;

                EV_DEPS = EV_DEPS.filter(x => Number(x) !== Number(id));
                sincronizaHiddenDependencias();
                renderizaChipsDependencias();
                setDirty(true);

                $('#evDepSelect').find(`option[value="${id}"]`).prop('disabled', false);

                toast('Dependencia quitada. Recuerda guardar para aplicar el cambio.');
            });
        }

        function mostrarPanelAgregarDependencia(mostrar) {
            const $p = $('#evDepAdd');
            if (mostrar) {
                const $sel = $('#evDepSelect');
                if ($sel.children().length <= 1) {
                    (window.DEPENDENCIAS_OPTS || []).forEach(d => {
                        $sel.append(`<option value="${d.id}">${escapeHtml(d.nombre)}</option>`);
                    });
                }
                $p.removeClass('d-none');
            } else {
                $p.addClass('d-none');
                $('#evDepSelect').val('');
            }
        }

        function clearSelectSafe($sel) {
            $sel.val('').prop('selectedIndex', 0);

            if ($sel.data('select2') || $sel.hasClass('select2-hidden-accessible')) {
                $sel.trigger('change.select2');
            } else {
                $sel.trigger('change');
            }
        }

        function agregarDependenciaInvitada() {
            const $sel = $('#evDepSelect');
            const val = $sel.val();
            if (!val) {
                toast('Selecciona una dependencia.');
                return;
            }

            const id = Number(val);
            const dep = (window.DEPENDENCIAS_OPTS || []).find(d => Number(d.id) === id);
            const nombre = dep ? dep.nombre : ('ID ' + id);

            if (EV_DEPS.includes(id)) {
                Swal.fire({
                    icon: 'info',
                    title: 'Ya está agregada',
                    text: `"${nombre}" ya se encuentra en la lista.`,
                    confirmButtonText: 'Entendido'
                });
                clearSelectSafe($sel);
                return;
            }

            // Agregar
            EV_DEPS.push(id);
            EV_DEPS = Array.from(new Set(EV_DEPS));
            sincronizaHiddenDependencias();
            renderizaChipsDependencias();

            clearSelectSafe($sel);

            if (typeof window.setDirty === 'function') {
                window.setDirty(true);
            }

            $sel.find(`option[value="${id}"]`).prop('disabled', true);

        }
    </script>
@endsection