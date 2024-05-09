@php
use App\Models\MatrizCoordinacion;
@endphp
@extends('layouts.administrador')
@section('encabezado')
    Matriz de Coordinación
@endsection

@section('content')
    @csrf
    <div class="row"
        style="background-color: rgb(249, 249, 249);padding:15px;border-radius:10px; border:solid 1px rgb(204, 204, 204);display:none">
        <div class="col-md-12 mb-4">
            <h4>Captura de Coordinadores de Tema y Participantes</h4>
        </div>
        <div class="col-md-3 mb-4">
            <label for="poreje">Dependencia<span style="color: red"></span></label>
            <select class="form-control selectpicker" id="poreje" name="poreje" onchange="getIndicadoresByFiltro()">
                <option value="0">Todos...</option>
            </select>
        </div>
        <div class="col-md-3 mb-4">
            <label for="pordependencia">Tema del PED<span style="color: red"></span></label>
            <select class="form-control" id="pordependencia" name="pordependencia" onchange="getIndicadoresByFiltro()">
                <option value="0">Todas...</option>
            </select>

        </div>
        <div class="col-md-3 mb-4">
            <label for="porsector">Rol<span style="color: red"></span></label>
            <select class="form-control" id="porsector" name="porsector" onchange="getIndicadoresByFiltro()">
                <option value="P">Participante (P)</option>
                <option value="CT">Coordinadora de Tema (CT)</option>
            </select>

        </div>
        <div class="col-md-3 mb-4" style="text-align:center;">
            <label for="porsector" style="color:rgb(249, 249, 249)">Almacena<span></span></label>
            <br />
            <button class="btn btn-primary">Guardar Relación</button>
        </div>
    </div>
    <div class="row" style="overflow: scroll">
        @php
            $temas = [
                '1' => '1.1',
                '2' => '1.2',
                '3' => '1.3',
                '4' => '1.4',
                '5' => '1.5',
                '6' => '1.6',
                '7' => '1.7',
                '8' => '1.8',
                '9' => '1.9',
                '10' => '2.1',
                '11' => '2.2',
                '12' => '2.3',
                '13' => '2.4',
                '14' => '2.5',
                '15' => '2.6',
                '16' => '3.1',
                '17' => '3.2',
                '18' => '3.3',
                '19' => '3.4',
                '20' => '4.1',
                '21' => '4.2',
                '22' => '4.3',
                '23' => '4.4',
                '24' => '4.5',
                '25' => '4.6',
                '26' => '5.1',
                '27' => '5.2',
                '28' => '5.3',
                '29' => '5.4',
                '30' => '5.5',
                '31' => '5.6',
                '32' => '5.7',
                '33' => '6.1',
                '34' => '6.2',
                '35' => '6.3',
                '36' => '6.4',
            ];
            $col1 = '#861e1e';
            $col2 = '#b18d5c';
        @endphp
        <table class="table table-bordered" id="dataTableIndicadores" cellspacing="0" style="color: black;width:100%"
            data-filter-control="true" data-show-search-clear-button="true">
            <thead style="background-color: #861e1e;color:white;;">
                <tr style="text-align: center">
                    <th rowspan="2" style="vertical-align:middle">Dependencia</th>
                    <th colspan="9" style="background-color: {{ $col1 }}">Eje 1</th>
                    <th colspan="6" style="background-color: {{ $col2 }}">Eje 2</th>
                    <th colspan="4" style="background-color: {{ $col1 }}">Eje 3</th>
                    <th colspan="6" style="background-color: {{ $col2 }}">Eje 4</th>
                    <th colspan="7" style="background-color: {{ $col1 }}">Eje 5</th>
                    <th colspan="4" style="background-color: {{ $col2 }}">Transversales</th>
                </tr>
                <tr>
                    @foreach ($temas as $key => $tema)
                        @php
                            if ($tema >= 1.1 && $tema <= 1.9) {
                                $col = $col1;
                            }
                            if ($tema >= 2.1 && $tema <= 2.9) {
                                $col = $col2;
                            }
                            if ($tema >= 3.1 && $tema <= 3.9) {
                                $col = $col1;
                            }
                            if ($tema >= 4.1 && $tema <= 4.9) {
                                $col = $col2;
                            }
                            if ($tema >= 5.1 && $tema <= 5.9) {
                                $col = $col1;
                            }
                            if ($tema >= 6.1 && $tema <= 6.9) {
                                $col = $col2;
                            }

                        @endphp
                        <td style="background-color:{{ $col }}">{{ $tema }}</td>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($dependencias as $dependencia)
                    <tr class="dependencia">
                        <td title="{{ $dependencia->dependenciaNombre }}">
                            <b>{{ $dependencia->dependenciaSiglas }}</b>
                        </td>
                        @foreach ($temas as $key => $tema)
                        @php
                           $relacion = MatrizCoordinacion::where("dependencias_id", $dependencia->idDependencia)->where("idTemaPED", $key)->where("informe","2")->first();
                           $style = "";
                           if($relacion!=null){
                                if($relacion->tipo=="P"){
                                    $style="background-color:gray";
                                }else{
                                    $style="background-color:black;color:white";
                                }
                           }
                        @endphp
                            <td style="text-align:center; {{$style}}" id="c{{ $dependencia->idDependencia . '-' . $key }}">
                                <select name="" id="{{ $dependencia->idDependencia }}-{{ $key }}"
                                    onchange="setRolTema({{ $dependencia->idDependencia }},{{ $key }})"
                                    title="Dependencia: {{ $dependencia->dependenciaSiglas }} Tema: {{ $tema }}"
                                    data-title="Dependencia: {{ $dependencia->dependenciaSiglas }} Tema: {{ $tema }}"
                                    style="appearance: none;padding:2px;text-align:center;border:none;color:black;background-color:rgb(249, 249, 249); {{$style}}">
                                    <option value=""></option>
                                    <option value="P" @if($relacion!=null) {{$relacion->tipo=="P"?"selected":""}}  @endif>P</option>
                                    <option value="CT" @if($relacion!=null) {{$relacion->tipo=="CT"?"selected":""}} @endif>CT</option>
                                </select>
                            </td>
                        @endforeach
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
@section('styles')
    <style>
        .dependencia:hover {
            background-color: rgb(235, 235, 235);
        }
    </style>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            dependencia = {{ session('idDependencia') }};
            if (!dependencia == 0) {
                $('#dependencia').val(dependencia);
                $('#dependencia').prop('disabled', true);
            }
            $("#collapseInforme").addClass("show");
            //$("#pparegistro").addClass("active");
            $("#informematriz").css('background-color', "rgb(217, 217, 217)");
            // fillEjemplo();
        });

        function setRolTema(dependencia, tema) {
            rol = $("#" + dependencia + "-" + tema).val();
            text = "black";
            $.ajax({
                type: 'POST',
                url: "{{ route('matriz.uptroltema') }}",
                data: {
                    dependencia: dependencia,
                    tema: tema,
                    rol: rol,
                    _token: $("input[name='_token']").val()
                },
                beforeSend: function() {
                    block(true)
                },
                success: function(response) {
                    block(false);
                    if (response.result == "ok") {
                        if (rol == "") {
                            background = "white";
                        } else {
                            if (rol == "P") {
                                background = "gray";
                            } else {
                                background = "black";
                                text = "white";
                            }
                        }
                        $("#c" + dependencia + "-" + tema).css("background", background);
                        $("#" + dependencia + "-" + tema).css("background", background);
                        $("#" + dependencia + "-" + tema).css("color", text);
                    } else {
                        Swal.fire({
                                    icon: 'error',
                                    title: 'Asignación de rol de tema ',
                                    text: response.message,
                                    confirmButtonColor: '#3085d6',
                                }).then((result) => {
                                });
                        $("#c" + dependencia + "-" + tema).css("background", "red");
                        $("#" + dependencia + "-" + tema).css("background", "red");
                    }
                }
            }).done(function(response) {
                block(false);
            }).fail(function(data) {
                block(false);
            })



        }
    </script>
@endsection
