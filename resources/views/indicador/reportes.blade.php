@extends('layouts.administrador')

@section('content')
    <!-- Content Row -->
    <div style="text-align:right;display:none;top:-30px;position:relative" id="regresar">
        <center>
            <span id="indicadorTitulo" style="text-align: left;font-size:18pt;width:100%;color:black">

            </span>
            <hr />
            <button class="btn btn-primary" onclick="returnIndicadores()"><i class="fas fa-arrow-left"> </i> Regresar</button>
        </center>
    </div>
    <div class="row" id="indicadores">
        <div class="col-lg-12 mb-4">
            <!-- Pendientes IE -->
            <div class="card shadow mb-4">
                <div class="card-header py-3" style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-primary" style="color:white!important">Indicadores</h6>
                </div>
                <div class="card-body">
                    @if (auth()->user()->hasRole('administrador'))
                        <h2>Filtros</h2>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="poreje">Por Eje:<span style="color: red"></span></label>
                                <select class="form-control selectpicker" id="poreje" name="poreje"
                                    onchange="getIndicadoresByFiltro()">
                                    <option value="0">Todos...</option>
                                    <option value="1">1. Estado de bienestar para todas las oaxaqueñas y oaxaqueños
                                    </option>
                                    <option value="2">2. Gobierno honesto, cercano y transparente al servicio de los
                                        pueblos y comunidades</option>
                                    <option value="3">3. Seguridad y justicia para vivir en paz</option>
                                    <option value="4">4. Crecimiento y Desarrollo Económico para las ocho regiones
                                    </option>
                                    <option value="5">5. Infraestructura y Sevicios públicos para el desarrollo
                                    </option>
                                    <option value="6">6. Igualdad de Genero</option>
                                    <option value="7">7. Desarrollo sostenible</option>
                                    <option value="8">8. Interculturalidad</option>
                                    <option value="9">9. Niñas, Niños y Adolescentes</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="pordependencia">Por Dependencia:<span style="color: red"></span></label>
                                <select class="form-control" id="pordependencia" name="pordependencia"
                                    onchange="getIndicadoresByFiltro()">
                                    <option value="0">Todas...</option>
                                    @foreach ($dependencias as $dependencia)
                                        <option value="{{ $dependencia->idDependencia }}">
                                            {{ $dependencia->dependenciaNombre . ' (' . $dependencia->dependenciaSiglas . ')' }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="porsector">Por Sector:<span style="color: red"></span></label>
                                <select class="form-control" id="porsector" name="porsector"
                                    onchange="getIndicadoresByFiltro()">
                                    <option value="0">Todos...</option>
                                </select>

                            </div>
                        </div>
                        <hr />
                    @endif
                    <center style="padding: 30px;" id="indicadoresContent">
                        @if (count($indicadores) > 0)
                            <div class="row">
                                @foreach ($indicadores as $indicador)
                                    @php
                                        switch ($indicador->idEjePED) {
                                            case 1:
                                                //$color = "#4EACA3";
                                                $color = '#83d0c8';
                                                break;
                                            case 2:
                                                //$color = "#9B2745";
                                                $color = '#AF7782';
                                                break;
                                            case 3:
                                                //$color = "#6177AC";
                                                $color = '#87A0D2';
                                                break;
                                            case 4:
                                                //$color = "#71AD4A";
                                                $color = '#ADDB8A';
                                                break;
                                            case 5:
                                                //$color = "#E18940";
                                                $color = '#F3B88B';
                                                break;
                                            default:
                                                $color = '#000000';
                                                break;
                                        }
                                    @endphp
                                    <div class="col-lg-2 mb-4 indicador"
                                        style="border:solid 1px {{ $color }};padding:15px;border-radius:15pt;cursor:pointer;margin:20px;text-align:left;display:table-cell;vertical-align:middle;background-color:{{ $color }};color:white"
                                        onclick="getDatas({{ $indicador->idIndicador }},'{{ $indicador->indicadorNombre }}')">
                                        {{ '[' . $indicador->idIndicador . '] ' . $indicador->indicadorNombre }}
                                        <img src="{{ asset('/images/ejes_icons/eje' . $indicador->idEjePED . '.png') }}"
                                            style="width: 40px;position:absolute;top:-15px;left:-15px;" />
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div>
                                <h2>No existen indicadores registrados!</h2>
                            </div>
                        @endif
                    </center>
                </div>
            </div>
        </div>
    </div>
    <div style="display: none" id="comportamientohistorico">
        <div class="row">
            <div class="col-lg-12 mb-4 text-right d-flex flex-row-reverse" style="gap:5px;">
                <button class="btn btn-sm btn-success" onclick="detallesIndicador(idIndicadorg)"><i class="fas fa-info"></i>
                    Ficha Técnica</button>
                @auth
                    @if (auth()->user()->hasRole('administrador'))
                        <form target="_blank" action="" method="GET" id="formDownload" style="">
                            &nbsp;
                            <button class="btn btn-sm btn-dark" type="submit"><i class="fas fa-file-pdf"></i> Decargar
                                PDF</button>
                        </form>
                    @endif
                @endauth

            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mb-4">
                <!-- Pendientes IE -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3" style="background-color: #681b2e">
                        <h6 class="m-0 font-weight-bold text-primary" style="color: white!important">Comportamiento
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
                        <h6 class="m-0 font-weight-bold text-primary" style="color: white!important">Comportamiento Actual
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
                        <h6 class="m-0 font-weight-bold text-primary" style="color: white!important">Metas Históricas
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
                        <h6 class="m-0 font-weight-bold text-primary" style="color: white!important">Metas Programadas
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
    <style>
        .indicador:hover {
            color: black;
            background-color: ;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{ asset('resources/js/demo/chart-indicador.js') }}"></script>
    <script>
        var idIndicadorg = 0;
        $(document).ready(function() {

            $("#collapseTwo").addClass("show");
            $("#menuIndicadores").addClass("active");
            $("#optindicadorreportes").css('background-color', "rgb(217, 217, 217)");
            //getIndicadoresByFiltro();
        });

        function getDatas(idIndicador, nombreIndicador) {
            $("#canvas").html('<canvas id="chart' + idIndicador + '"></canvas>');
            $("#actuales").html('<canvas id="actuales' + idIndicador + '"></canvas>');
            $("#comportamientohistorico").show('slow');
            $("#indicadores").hide('slow');
            $("#indicadorTitulo").html("<b>Indicador: </b>" + nombreIndicador);
            $("#regresar").show('slow');
            setTimeout(function() {
                showHistoricos('chart' + idIndicador);
            }, 500)
            setTimeout(function() {
                showActuales('actuales' + idIndicador);
            }, 500)
            idIndicadorg = idIndicador;
            $("#idDownload").val(idIndicadorg);
            $("#formDownload").prop("action", "/indicador/admindownload/" + idIndicadorg);
        }

        function returnIndicadores() {
            $("#indicadorTitulo").html("");
            $("#comportamientohistorico").hide('slow');
            $("#indicadores").show('slow');
            $("#regresar").hide('slow');

        }

        function getIndicadoresByFiltro() {
            eje = $("#poreje").val();
            dependencia = $("#pordependencia").val();
            sector = $("#porsector").val();

            $.ajax({
                type: 'GET',
                url: '{{ route('admin.indicadores.filtros') }}',
                data: {
                    eje: eje,
                    dependencia: dependencia,
                    sector: sector
                },
                //dataType: 'json',
                beforeSend: function() {
                    block(true);
                }
            }).done(function(response) {
                block(false);
                $("#indicadoresContent").html(response);
            }).fail(function(data) {
                block(false);
            })
        }

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
    </script>
@endsection
