@extends('layouts.administrador')

@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">Indicador / listar</h1>
    <!--<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm disabled"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Generar Listado de Indicadores</a>-->
@endsection

@section('content')
    <div class="row">
        @csrf
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                    style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Indicadores Registrados</h6>
                    <div class="dropdown no-arrow">
                        <!--<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                aria-labelledby="dropdownMenuLink">
                                                <div class="dropdown-header">Acciones:</div>
                                                <a class="dropdown-item" href="{{ route('indicador') }}" style="cursor: pointer"><i
                                                        class="fas fa-plus" style="color:green;"></i> Nuevo Indicador</a>
                                            </div>-->
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body" id="indicadorContent">
                    @if (count($indicadores) > 0)
                        <table class="table table-bordered table-striped" id="dataTableIndicadores" width="100%"
                            cellspacing="0" style="color: black!important">
                            <thead style="background-color: #919090;color:white;">
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Definición</th>
                                    <th>Tipo</th>
                                    <th>Dimension</th>
                                    <th>Responsable</th>
                                    <th>Validación CREMA</th>
                                    <th>Opciones</th>
                                    <th>Envío</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($indicadores as $indicador)
                                @if($indicador->en_revision!=2)
                                    <tr>
                                        <td>{{ $indicador->idIndicador }}</td>
                                        <td id="indicadornombre{{$indicador->idIndicador}}">{{ $indicador->indicadorNombre }}</td>
                                        <td>{{ $indicador->indicadorObjetivo }}</td>
                                        <td>{{ $indicador->indicadorTipo }}</td>
                                        <td>{{ $indicador->indicadorDimension }}</td>
                                        <td>{{ $indicador->dependenciaSiglas }}</td>
                                        <td>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                                title="Validar criterios CREMA"
                                                onclick="abrirModalCrema({{ $indicador->idIndicador }}, '{{ addslashes($indicador->indicadorNombre) }}')">
                                            <i class="fas fa-award"></i> Validar CREMA
                                        </button>
                                        </td>
                                        <td class="text-center" style="width:150px">
                                            @if (Auth::user()->hasRole('consulta'))
                                                <button class="btn btn-sm btn-primary"
                                                    onclick="detallesIndicador({{ $indicador->idIndicador }})"><i
                                                        class="fas fa-info"></i></button>
                                            @else
                                                <button class="btn btn-sm btn-primary"
                                                    onclick="detallesIndicador({{ $indicador->idIndicador }})"><i
                                                        class="fas fa-info"></i></button>
                                                <a target="_blank"
                                                    href="{{ route('indicador.download', ['id' => $indicador->idIndicador]) }}"><button
                                                        class="btn btn-sm btn-dark"><i
                                                            class="fas fa-file-pdf"></i></button></a>
                                                @if (!$indicador->en_revision && $indicador->meta)
                                                    <a id="btneditar{{ $indicador->idIndicador }}"
                                                        href="{{ route('indicador.edit', ['id' => $indicador->idIndicador]) }}"><button
                                                            class="btn btn-sm btn-info"><i
                                                                class="fas fa-edit"></i></button></a>
                                                @endif

                                                <!--<button class="btn btn-sm btn-danger"
                                                                        onclick="deleteIndicador({{ $indicador->idIndicador . ",'" . $indicador->indicadorNombre }}')"><i
                                                                            class="fas fa-trash"></i></button>-->
                                            @endif
                                        </td>
                                        <td style="text-align: center" id="revision{{ $indicador->idIndicador }}">
                                            @if (!$indicador->en_revision)
                                                <button id="btnrevision{{ $indicador->idIndicador }}"
                                                    onclick="updateEditar({{ $indicador->idIndicador }})"
                                                    class="btn btn-sm btn-warning"><i class="fas fa-check"></i> Enviar a
                                                    Revisión</button>
                                            @else
                                                <a><button disabled class="btn btn-sm btn-secondary"><i
                                                            class="fas fa-paper-plane"></i> Indicador en
                                                        Revisión</button></a>
                                            @endif
                                        </td>
                                    </tr>
                                @else
                                <tr style="color: gray">
                                    <td>{{ $indicador->idIndicador }}</td>
                                    <td id="indicadornombre{{$indicador->idIndicador}}">{{ $indicador->indicadorNombre }}</td>
                                    <td>{{ $indicador->indicadorObjetivo }}</td>
                                    <td>{{ $indicador->indicadorTipo }}</td>
                                    <td>{{ $indicador->indicadorDimension }}</td>
                                    <td>{{ $indicador->dependenciaSiglas }}</td>
                                    <td>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                                title="Validar criterios CREMA"
                                                onclick="abrirModalCrema({{ $indicador->idIndicador }}, '{{ addslashes($indicador->indicadorNombre) }}')">
                                            <i class="fas fa-award"></i> Validar CREMAA
                                        </button>
                                    </td>
                                    <td class="text-center" style="width:150px">
                                        @if (Auth::user()->hasRole('consulta'))
                                            <button class="btn btn-sm btn-primary"
                                                onclick="detallesIndicador({{ $indicador->idIndicador }})"><i
                                                    class="fas fa-info"></i></button>
                                        @else
                                            <button class="btn btn-sm btn-primary"
                                                onclick="detallesIndicador({{ $indicador->idIndicador }})"><i
                                                    class="fas fa-info"></i></button>
                                            <a target="_blank"
                                                href="{{ route('indicador.download', ['id' => $indicador->idIndicador]) }}"><button
                                                    class="btn btn-sm btn-dark"><i
                                                        class="fas fa-file-pdf"></i></button></a>
                                            <!--<button class="btn btn-sm btn-danger"
                                                                    onclick="deleteIndicador({{ $indicador->idIndicador . ",'" . $indicador->indicadorNombre }}')"><i
                                                                        class="fas fa-trash"></i></button>-->
                                        @endif
                                    </td>
                                    <td style="text-align: center" id="revision{{ $indicador->idIndicador }}">
                                        <div>
                                            <span>Indicador dado de baja</span>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <h3>
                                No existen Indicadores Registrados!
                            </h3>
                            <a href="{{ route('indicador') }}">
                                <button class="btn btn-success">

                                    Agregar Indicador

                                </button>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <style>
        table tr:hover {
            background-color: rgb(242, 242, 242);
        }

        .odd {
            background-color: #f3f3f3 !important;
        }
    </style>
    @include('indicador.validarCrema')
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#dataTableIndicadores").DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 20],
                order: [
                    [0, 'asc']
                ],
            })
            $("#collapseTwo").addClass("show");
            $("#menuIndicadores").addClass("active");
            $("#optindicadorlistado").css('background-color', "rgb(217, 217, 217)");
        });

        function detallesIndicador(indicador) {
            $("#generalModal").modal("show");
            getInfoIndicador(indicador);

        }

        function getInfoIndicador(indicador) {
            $.ajax({
                type: 'GET',
                url: "{{ route('indicador.info') }}",
                data: {
                    indicador: indicador
                },
                beforeSend: function() {
                    $("#generalModal .modal-body").html(
                        '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando...</div>');
                }
            }).done(function(response) {
                $("#generalModal .modal-body").html(response).animate("slow");
            }).fail(function(data) {

            })
        }

        function deleteIndicador(idIndicador, nombreIndicador) {
            Swal.fire({
                title: '¿Está Seguro?',
                text: "La información del indicador: \"" + nombreIndicador + "\"  no estará disponible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, dar de baja!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('indicador.delete') }}",
                        data: {
                            idIndicador: idIndicador,
                            _token: $("input[name='_token']").val()
                        },
                        beforeSend: function() {
                            block(true)
                        },
                        success: function(response) {
                            if (response.success = "ok") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Indicador ',
                                    text: response.message + " Indicador: " + nombreIndicador,
                                    confirmButtonColor: '#3085d6',
                                }).then((result) => {
                                    window.location.replace("{{ route('indicador.list') }}");
                                });
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Ocurrió un error al intentar dar de baja el Indicador',
                                    text: '',
                                    confirmButtonColor: '#3085d6',
                                })
                            }
                        }
                    }).done(function(response) {
                        block(false);
                    }).fail(function(data) {
                        block(false);
                    })
                }
            })
        }

        function updateEditar(indicador) {
            editar = 1;
            indicadornombre = $("#indicadornombre"+indicador).html()
            Swal.fire({
                title: '¿Está Seguro?',
                text: "La información del indicador: [" + indicador+ "] " +indicadornombre+" no podrá ser modificada!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, Enviar a Revisión!',
                showCancelButtonText:'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('admin.indicador.updateeditar') }}",
                        data: {
                            indicador: indicador,
                            editar: editar,
                            _token: $("input[name='_token']").val()
                        },
                        beforeSend: function() {
                            $("#btnrevision" + indicador).html(
                                '<i class="fas fa-spinner fa-spin"></i> Procesando...');
                        }
                    }).done(function(response) {
                        if (response.success == "ok") {
                            $("#revision" + indicador).html(
                                '<a><button disabled class="btn btn-sm btn-secondary"><i class="fas fa-paper-plane"></i> Indicador en Revisión</button></a>'
                            );
                            $("#btneditar" + indicador).remove();
                        } else {
                            $("#revision" + indicador).html('<button id="btnrevision' + indicador +
                                '" onclick="updateEditar(' + indicador +
                                ')" class="btn btn-sm btn-warning"><i class="fas fa-check"></i> Enviar a Revisión</button>'
                            );
                        }

                    }).fail(function(data) {
                        $("#revision" + indicador).html('<button id="btnrevision' + indicador +
                            '" onclick="updateEditar(' +
                            indicador +
                            ')" class="btn btn-sm btn-warning"><i class="fas fa-check"></i> Enviar a Revisión</button>'
                            );
                    })
                }
            });
        }

        function abrirModalCrema(idIndicador, nombreIndicador) {
            if (!$('#modalCrema').data('cremaHandlersBound')) {
                $('#modalCrema')
                    .on('change', 'input[type="checkbox"][data-toggle="toggle"]', function() {
                        const $card = $(this).closest('.crema-card');
                        $(this).prop('checked') ? $card.addClass('is-checked') : $card.removeClass('is-checked');
                    })
                    .data('cremaHandlersBound', true);
            }
            $('#formCrema input[type="checkbox"][data-toggle="toggle"]').each(function() {
                if (!$(this).data('bs.toggle') && typeof $(this).bootstrapToggle === 'function') {
                    $(this).bootstrapToggle(); // inicializa el plugin
                }
            });

            $('#cremaIndicadorId').val(idIndicador);
            $('#modalCremaLabel').text(
                nombreIndicador 
                    ? 'Validación CREMA — [' + idIndicador + '] ' + nombreIndicador 
                    : 'Validación CREMA'
            );

            const $checks = $('#formCrema input[type="checkbox"][data-toggle="toggle"]');
            $checks.each(function() {
                if ($(this).data('bs.toggle')) {
                    $(this).bootstrapToggle('off'); // dispara change y despinta
                } else {
                    $(this).prop('checked', false).trigger('change');
                }
            });

            $('#modalCrema').modal('show');

            const $btn = $('#btnGuardarCrema');
            const originalBtn = $btn.html();
            $btn.prop('disabled', true);
            const $loader = $(`
        <div id="cremaLoading" class="alert alert-light d-flex align-items-center" role="alert" style="border:1px solid #eee;">
            <i class="fas fa-spinner fa-spin mr-2"></i>
            <span>Cargando...</span>
        </div>
    `);
            $('.crema-body').prepend($loader);

            const url = "{{ url('/indicadores') }}/" + idIndicador + "/crema";
            $.ajax({
                    url,
                    method: 'GET',
                    dataType: 'json'
                })
                .done(function(resp) {
                    if (resp && resp.data) {
                        ['claro', 'relevante', 'economico', 'monitoreable', 'adecuado', 'aporteMarginal'].forEach(function(k) {
                            const v = Number(resp.data[k]) === 1;
                            const $chk = $(`#formCrema input[type="checkbox"][name="crema[${k}]"]`);

                            if ($chk.data('bs.toggle')) {
                                $chk.bootstrapToggle(v ? 'on' : 'off'); // dispara change y pinta/despinta
                            } else {
                                $chk.prop('checked', v).trigger('change');
                            }
                        });
                    }
                })
                .fail(function(xhr) {
                    console.error('Error al cargar datos', xhr);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudieron cargar los datos de Validación'
                    });
                })
                .always(function() {
                    $('#cremaLoading').remove();
                    $btn.prop('disabled', false).html(originalBtn);
                });
        }

        function guardarCrema() {
            const $form = $('#formCrema');
            const $btn = $('#btnGuardarCrema');
            const originalHtml = $btn.html();

            const idIndicador = $('#cremaIndicadorId').val();
            if (!idIndicador) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Falta el ID del indicador.'
                });
                return;
            }

            const url = "{{ url('/indicadores') }}/" + idIndicador + "/crema";

            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...');

            $.ajax({
                    url,
                    method: 'POST',
                    data: $form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $form.find('input[name="_token"]').val(),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    dataType: 'json'
                })
                .done(function(resp) {
                    if (resp.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Guardado',
                            text: resp.message || 'Validación guardada correctamente.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#modalCrema').modal('hide');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: resp.message || 'Ocurrió un problema inesperado.'
                        });
                    }
                })
                .fail(function(xhr) {
                    const msg = xhr.responseJSON?.message || 'Ocurrió un error al guardar la validación.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: msg
                    });
                })
                .always(function() {
                    $btn.prop('disabled', false).html(originalHtml);
                });
        }

    </script>
@endsection
