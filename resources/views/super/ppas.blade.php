@extends('layouts.administrador')

@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">PPAs / Listado General</h1>
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
                    <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Todos los PPAs Registrados</h6>
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
                    <div class="" style="text-align:right;position:relative;top:-10px;">
                        @if (count($ppas) > 0 && auth()->user()->cuenta!="SIIBIEN.IARTO")
                            <a href="{{ route('admin.ppas.downloadxlsx') }}" target="_blank">
                                <button class="btn btn-success"><i class="fas fa-download"></i> Concentrado General</button>
                            </a>
                        @endif
                    </div>
                    @if (count($ppas) > 0)
                        <table class="table table-bordered table-striped" id="dataTablePPAs" width="100%"
                            cellspacing="0" style="color: black!important">
                            <thead style="background-color: #919090;color:white;">
                                <tr>
                                    <th>Id</th>
                                    <th>Periodo</th>
                                    <th>Nombre del PPA</th>
                                    <th>Objetivo</th>
                                    <th>Cobertura</th>
                                    <th>Responsable</th>
                                    <th>Monto Inversion</th>
                                    <th>Monto Ejercido</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ppas as $ppa)
                                    @php
                                        switch ($ppa->periodo[0]) {
                                            case '1':
                                                $periodo = "Enero - Marzo ";
                                                break;
                                            case '2':
                                                $periodo = "Abril - Junio ";
                                                break;
                                            case '3':
                                                $periodo = "Julio - Septiembre ";
                                                break;
                                            case '4':
                                                $periodo = "Octubre - Diciembre ";
                                                break;
                                        }
                                        $periodo .= $ppa->periodo[1].$ppa->periodo[2].$ppa->periodo[3].$ppa->periodo[4]
                                    @endphp


                                    <tr>
                                        <td>{{ $ppa->id }}</td>
                                        <td>{{ $periodo }}</td>
                                        <td id="ppanombre{{$ppa->id}}">{{ $ppa->nombre }}</td>
                                        <td>{{ $ppa->objetivo }}</td>
                                        <td>{{ $ppa->cobertura }}</td>
                                        <td><button class="btn btn-primary">{{ $ppa->dependenciaSiglas }}</button></td>
                                        <td>{{ "$ ".number_format($ppa->monto_inversion,2) }}</td>
                                        <td>{{ "$ ".number_format($ppa->monto_ejercido,2) }}</td>
                                        <td class="text-center" style="width:150px">
                                                <a target="_blank"
                                                    href="{{ route('ppa.download', ['id' => $ppa->id]) }}"><button
                                                        class="btn btn-sm btn-dark"><i
                                                            class="fas fa-file-pdf"></i></button></a>
                                                   @if(auth()->user()->cuenta != "SIIBIEN.IARTO")
                                                    <a id="btneditar{{ $ppa->id }}"
                                                        href="{{ route('ppa.edit', ['id' => $ppa->id]) }}"><button
                                                            class="btn btn-sm btn-info"><i
                                                                class="fas fa-edit"></i></button></a>
                                                   @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <h3>
                                No existen PPAs Registrados!
                            </h3>
                            <a href="{{ route('ppa.index') }}">
                                <button class="btn btn-success">

                                    Agregar PPA

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

            $("#menuAdminPPA").addClass("active");
            //$("#ppalistado").css('background-color', "rgb(217, 217, 217)");

            $('#dataTablePPAs thead tr')
                .clone(true)
                .addClass('filters')
                .appendTo('#dataTablePPAs thead');

            dt = $('#dataTablePPAs').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 30, 50, 100],
                orderCellsTop: true,
                fixedHeader: true,
                initComplete: function() {
                    var api = this.api();

                    // For each column
                    api
                        .columns()
                        .eq(0)
                        .each(function(colIdx) {
                            // Set the header cell to contain the input element
                            var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                            );
                            var title = $(cell).text();
                            if (colIdx != 7) {
                                $(cell).html(
                                    '<input type="text" class="form-control" placeholder="' +
                                    title + '" />');
                            } else {
                                $(cell).html('')
                            }


                            // On every keypress in this input
                            $(
                                    'input',
                                    $('.filters th').eq($(api.column(colIdx).header()).index())
                                )
                                .off('keyup change')
                                .on('change', function(e) {
                                    // Get the search value
                                    $(this).attr('title', $(this).val());
                                    var regexr =
                                        '({search})'; //$(this).parents('th').find('select').val();

                                    var cursorPosition = this.selectionStart;
                                    // Search the column for that value
                                    api
                                        .column(colIdx)
                                        .search(
                                            this.value != '' ?
                                            regexr.replace('{search}', '(((' + this.value +
                                                ')))') :
                                            '',
                                            this.value != '',
                                            this.value == ''
                                        )
                                        .draw();
                                })
                                .on('keyup', function(e) {
                                    e.stopPropagation();

                                    $(this).trigger('change');
                                    $(this)
                                        .focus()[0]
                                        .setSelectionRange(cursorPosition, cursorPosition);
                                });
                        });
                },
            });

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
    </script>
@endsection
