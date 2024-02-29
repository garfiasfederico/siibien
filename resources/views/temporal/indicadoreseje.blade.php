@extends('layouts.temporal')
@section('styles')
    <link href="{{ asset('resources/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endsection
@section('content')
    <div class="row" style="padding: 15px;vertical-align:middle;display:table-cell;">
        <img src="{{ $eje->idEjePED <= 5 ? asset('images/main/EJE' . $eje->idEjePED . '.svg') : asset('images/main/EJE' . $eje->idEjePED . '.png') }}"/
            style="width: 150px">
        <span style="font-size: 2em;color:{{ $color }};">
            {{ 'Eje ' . ($eje->idEjePED <= 5 ? $eje->idEjePED : 'T. ') . ' ' . Str::upper($eje->ejePEDDescripcion) }}
            <h5 align="right"
                style="background-color: {{ $color }}; color:white; height:40px; vertical-align:middle;padding:10px;width:100%">
                Total de Indicadores del Eje registrados: {{ count($indicadores) }}</h5>
        </span>

    </div>
    <div class="row" id="listadoIndicadores">
        <div class="col-xl-12 col-lg-7 text-right" style="padding:15px;text-align:right ">
            <a href="{{ route('inicio') }}"><button class="btn btn-secondary">Volver al Inicio</button></a>
        </div>
        @csrf
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                    style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Indicadores del Estado</h6>
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
                                    <th>Tipo</th>
                                    <th>Dimension</th>
                                    <th>Sentido</th>
                                    <th>Responsable</th>
                                    <th>Opciones</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($indicadores as $indicador)
                                    <tr>
                                        <td>{{ $indicador->idIndicador }}</td>
                                        <td id="indicadornombre{{ $indicador->idIndicador }}" style="font-size: 1.3em;">
                                            {{ $indicador->indicadorNombre }}</td>
                                        <td>{{ $indicador->indicadorTipo }}</td>
                                        <td>{{ $indicador->indicadorDimension }}</td>
                                        <td style="text-align: center"><button class="btn btn-light" disabled><b>
                                                    @if ($indicador->indicadorSentido == 'ascendente')
                                                        <i class="material-icons"
                                                            style="font-size: 2em;color:green;font-weight:bold">trending_up</i>
                                                    @else
                                                        <i class="material-icons"
                                                            style="font-size: 2em;color:green;font-weight:bold">trending_down</i>
                                                    @endif
                                                </b></button></td>
                                        <td style="text-align: center"><b>{{ $indicador->dependenciaSiglas }}</b></td>
                                        <td class="text-center" style="width:150px">
                                            <button class="btn btn-sm btn-primary"
                                                onclick="detallesIndicador({{ $indicador->idIndicador }})"><i
                                                    class="fas fa-info" style="width: 20px;"></i></button>
                                            <button class="btn"
                                                onclick="getDatas({{ $indicador->idIndicador . ',"' . $indicador->indicadorNombre . '"' }})"
                                                style="background-color: {{ $color }};color:white;">
                                                <i class="fas fa-chart-pie"></i>
                                            </button>
                                        </td>
                                    </tr>
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

    <div style="display:none" id="comportamientohistorico">
        <h1 style="text-align: center"><span id="indicadorTitulo"></span></h1>
        <div class="row">
            <div class="col-xl-12 col-lg-7 text-right" style="padding:15px;text-align:right ">
                <button class="btn btn-secondary" id="regresar" onclick="regresar()">Regresar</button>
            </div>
            <div class="col-lg-6 mb-4">
                <!-- Pendientes IE -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3" style="background-color: #681b2e">
                        <h6 class="m-0 font-weight-bold text-primary" style="color: white!important">
                            Comportamiento
                            Histórico</h6>
                    </div>
                    <div class="card-body">
                        <center style="padding: 30px;" id="canvas">

                        </center>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <!-- Pendientes IE -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3" style="background-color: #681b2e">
                        <h6 class="m-0 font-weight-bold text-primary" style="color: white!important">
                            Comportamiento Actual
                        </h6>
                    </div>
                    <div class="card-body">
                        <center style="padding: 30px;" id="actuales">


                        </center>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 mb-4">
                <!-- Pendientes IE -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3" style="background-color: #681b2e">
                        <h6 class="m-0 font-weight-bold text-primary" style="color: white!important">Metas
                            Históricas
                        </h6>
                    </div>
                    <div class="card-body">
                        <center style="padding: 30px;" id="historicos_content">

                        </center>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 mb-4">
                <!-- Pendientes IE -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3" style="background-color: #681b2e">
                        <h6 class="m-0 font-weight-bold text-primary" style="color: white!important">Metas
                            Programadas
                        </h6>
                    </div>
                    <div class="card-body">
                        <center style="padding: 30px;" id="programados_content">

                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    <script src="{{ asset('resources/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('resources/js/demo/chart-indicador.js') }}"></script>
    <script src="{{ asset('resources/js/jquery.blockUI.js') }}"></script>
    <script>
        $(document).ready(function() {
            /*$("#dataTableIndicadores").DataTable({
                pageLength: 10,
                lengthMenu: [10, 30, 50],
                order: [
                    [0, 'asc']
                ],
            })*/

            $('#dataTableIndicadores thead tr')
                .clone(true)
                .addClass('filters')
                .appendTo('#dataTableIndicadores thead');

            dt = $('#dataTableIndicadores').DataTable({
                pageLength: 10,
                lengthMenu: [10, 30, 50],
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
                            if (colIdx != 6) {
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

        function getDatas(idIndicador, nombreIndicador) {
            $("#canvas").html('<canvas id="chart' + idIndicador + '"></canvas>');
            $("#actuales").html('<canvas id="actuales' + idIndicador + '"></canvas>');
            $("#listadoIndicadores").hide('slow');
            $("#indicadorTitulo").html("<b>Indicador: </b>" + nombreIndicador);
            $("#regresar").show('slow');
            setTimeout(function() {
                showHistoricos('chart' + idIndicador);
            }, 500)
            setTimeout(function() {
                showActuales('actuales' + idIndicador);
                $("#comportamientohistorico").show('slow');
            }, 500)
            //idIndicadorg = idIndicador;

            //$("#idDownload").val(idIndicadorg);
            //$("#formDownload").prop("action", "/indicador/admindownload/" + idIndicadorg);
        }
        function regresar(){
            $("#comportamientohistorico").hide('slow');
            $("#listadoIndicadores").show('slow');
        }

        function block(val) {
            if (val) {
                $.blockUI({
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: .5,
                        color: '#fff'
                    },
                    message: "<h4>Procesando...</h4>"
                });
            } else {
                $.unblockUI();
            }
        }
    </script>
@endsection
