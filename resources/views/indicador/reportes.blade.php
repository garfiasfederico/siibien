@extends('layouts.administrador')

@section('content')
    <!-- Content Row -->
    <div style="text-align:right;display:none;top:-30px;position:relative" id="regresar">
        <center>
            <span id="indicadorTitulo" style="text-align: left;font-size:18pt;width:100%;color:black">

            </span>
            <hr/>
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
                    <center style="padding: 30px;">
                        @if (count($indicadores) > 0)
                            <div class="row">
                                @foreach ($indicadores as $indicador)
                                    <div class="col-lg-2 mb-4 indicador"
                                        style="border:solid 1px gray;padding:15px;border-radius:15pt;cursor:pointer;margin:20px;background-image:url('{{ asset('images/ejes_content/ceje1.png') }}');background-position:bottom right;background-size:40px;background-repeat:no-repeat;text-align:left"
                                        onclick="getDatas({{ $indicador->idIndicador }},'{{ $indicador->indicadorNombre }}')">
                                        {{ $indicador->indicadorNombre }}
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
        $(document).ready(function() {
            $("#collapseTwo").addClass("show");
            $("#menuIndicadores").addClass("active");
            $("#optindicadorreportes").css('background-color', "rgb(217, 217, 217)");
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

        }

        function returnIndicadores() {
            $("#indicadorTitulo").html("");
            $("#comportamientohistorico").hide('slow');
            $("#indicadores").show('slow');
            $("#regresar").hide('slow');

        }
    </script>
@endsection
