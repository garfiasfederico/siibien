@php
    use App\Models\MatrizCoordinacion;
@endphp
@extends('layouts.administrador')
@section('encabezado')
    Información cargada
@endsection
@section('content')
    <div class="col-xl-12 col-lg-7">
        <nav>
            <div class="nav nav-tabs nav-fill justify-content-center" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-temas-tab" data-toggle="tab" href="#nav-temas" role="tab"
                    aria-controls="nav-profile" aria-selected="false">Por Tema<span id="temasseleccionado"></span></a>
                <a class="nav-item nav-link" id="nav-objetivos-tab" data-toggle="tab" href="#nav-dependencias"
                    role="tab" aria-controls="nav-contact" aria-selected="false">Por Dependencia<span
                        id="objetivosseleccionado"></span></a>
            </div>
        </nav>
        <hr />
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-temas" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="" align="center">
                    <table class="table" style="width: 80%" border="0">
                        <thead>
                            <tr style="background-color: gray;color:white;">
                                <td>Eje</td>
                                <td>Tema</td>
                                <td>Dependencias</td>
                            </tr>
                        </thead>

                        <tr>
                            <td rowspan="{{ $temase1->count() + 1 }}"
                                style="text-align:center;vertical-align: middle;background-color:#00b0a4;color:white;font-size:1.5em;">
                                Eje 1</td>
                        </tr>
                        @foreach ($temase1 as $tema)
                            <tr>
                                <td style="background-color: #70c6c0;color:white;vertical-align:middle">
                                    {{ $tema->temaPEDClave . ' ' . $tema->temaPEDDescripcion }}
                                </td>
                                <td>
                                    @php
                                        $dependenciasP = MatrizCoordinacion::where('informe', '2')
                                            ->where('idTemaPED', $tema->idTemaPED)
                                            ->join(
                                                'dependencia',
                                                'dependencia.idDependencia',
                                                '=',
                                                'matriz_coordinacion.dependencias_id',
                                            )
                                            ->get();
                                    @endphp
                                    @if ($dependenciasP->count() > 0)
                                        <center>
                                            <table class="" style="width: 100%">
                                                @foreach ($dependenciasP as $dependencia)
                                                    <tr>
                                                        <th style="width: 30%">{{ $dependencia->dependenciaSiglas }}</th>
                                                        <th
                                                            style="text-align:center;width: 10%;@if ($dependencia->tipo == 'P') background-color:gray;color:white @else background-color:black;color:white @endif">
                                                            {{ $dependencia->tipo }}</th>
                                                        <th style="width: 50%"><button class="btn"
                                                                style="background-color:#70c6c0;color:white">Información
                                                                Capturada</button></th>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </center>
                                    @else
                                        <div class="alert alert-info" style="text-align: center">No existen Depedencias
                                            asociadas a este
                                            tema!</div>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td rowspan="{{ $temase2->count() + 1 }}"
                                style="text-align:center;vertical-align: middle;background-color:#a81042;color:white;font-size:1.5em;">
                                Eje 2</td>
                        </tr>
                        @foreach ($temase2 as $tema)
                            <tr>
                                <td style="background-color: #ba7481;color:white;vertical-align:middle">
                                    {{ $tema->temaPEDClave . ' ' . $tema->temaPEDDescripcion }}</td>
                                <td>
                                    @php
                                        $dependenciasP = MatrizCoordinacion::where('informe', '2')
                                            ->where('idTemaPED', $tema->idTemaPED)
                                            ->join(
                                                'dependencia',
                                                'dependencia.idDependencia',
                                                '=',
                                                'matriz_coordinacion.dependencias_id',
                                            )
                                            ->get();
                                    @endphp
                                    @if ($dependenciasP->count() > 0)
                                        <center>
                                            <table class="" style="width: 100%">
                                                @foreach ($dependenciasP as $dependencia)
                                                    <tr>
                                                        <th style="width: 30%">{{ $dependencia->dependenciaSiglas }}</th>
                                                        <th
                                                            style="text-align:center;width: 10%;@if ($dependencia->tipo == 'P') background-color:gray;color:white @else background-color:black;color:white @endif">
                                                            {{ $dependencia->tipo }}</th>
                                                        <th style="width: 50%"><button class="btn"
                                                                style="background-color:#ba7481;color:white">Información
                                                                Capturada</button></th>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </center>
                                    @else
                                        <div class="alert alert-info" style="text-align: center">No existen Depedencias
                                            asociadas a este
                                            tema!</div>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td rowspan="{{ $temase3->count() + 1 }}"
                                style="text-align:center;vertical-align: middle;background-color:#5b77b1;color:white;font-size:1.5em;">
                                Eje 3</td>
                        </tr>
                        @foreach ($temase3 as $tema)
                            <tr>
                                <td style="background-color: #809fd5;color:white;vertical-align:middle">
                                    {{ $tema->temaPEDClave . ' ' . $tema->temaPEDDescripcion }}</td>
                                <td>
                                    @php
                                        $dependenciasP = MatrizCoordinacion::where('informe', '2')
                                            ->where('idTemaPED', $tema->idTemaPED)
                                            ->join(
                                                'dependencia',
                                                'dependencia.idDependencia',
                                                '=',
                                                'matriz_coordinacion.dependencias_id',
                                            )
                                            ->get();
                                    @endphp
                                    @if ($dependenciasP->count() > 0)
                                        <center>
                                            <table class="" style="width: 100%">
                                                @foreach ($dependenciasP as $dependencia)
                                                    <tr>
                                                        <th style="width: 30%">{{ $dependencia->dependenciaSiglas }}</th>
                                                        <th
                                                            style="text-align:center;width: 10%;@if ($dependencia->tipo == 'P') background-color:gray;color:white @else background-color:black;color:white @endif">
                                                            {{ $dependencia->tipo }}</th>
                                                        <th style="width: 50%"><button class="btn"
                                                                style="background-color:#809fd5;color:white">Información
                                                                Capturada</button></th>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </center>
                                    @else
                                        <div class="alert alert-info" style="text-align: center">No existen Depedencias
                                            asociadas a este
                                            tema!</div>
                                    @endif

                                </td>

                            </tr>
                        @endforeach
                        <tr>
                            <td rowspan="{{ $temase4->count() + 1 }}"
                                style="text-align:center;vertical-align: middle;background-color:#5cb037;color:white;font-size:1.5em;">
                                Eje 4</td>
                        </tr>
                        @foreach ($temase4 as $tema)
                            <tr>
                                <td style="background-color: #a0dd80;color:white;vertical-align:middle">
                                    {{ $tema->temaPEDClave . ' ' . $tema->temaPEDDescripcion }}</td>
                                <td>
                                    @php
                                        $dependenciasP = MatrizCoordinacion::where('informe', '2')
                                            ->where('idTemaPED', $tema->idTemaPED)
                                            ->join(
                                                'dependencia',
                                                'dependencia.idDependencia',
                                                '=',
                                                'matriz_coordinacion.dependencias_id',
                                            )
                                            ->get();
                                    @endphp
                                    @if ($dependenciasP->count() > 0)
                                        <center>
                                            <table class="" style="width: 100%">
                                                @foreach ($dependenciasP as $dependencia)
                                                    <tr>
                                                        <th style="width: 30%">{{ $dependencia->dependenciaSiglas }}</th>
                                                        <th
                                                            style="text-align:center;width: 10%;@if ($dependencia->tipo == 'P') background-color:gray;color:white @else background-color:black;color:white @endif">
                                                            {{ $dependencia->tipo }}</th>
                                                        <th style="width: 50%"><button class="btn"
                                                                style="background-color:#a0dd80;color:white">Información
                                                                Capturada</button></th>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </center>
                                    @else
                                        <div class="alert alert-info" style="text-align: center">No existen Depedencias
                                            asociadas a este
                                            tema!</div>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td rowspan="{{ $temase5->count() + 1 }}"
                                style="text-align:center;vertical-align: middle;background-color:#f28325;color:white;font-size:1.5em;">
                                Eje 5</td>
                        </tr>
                        @foreach ($temase5 as $tema)
                            <tr>
                                <td style="background-color: #f7b584;color:white;vertical-align:middle">
                                    {{ $tema->temaPEDClave . ' ' . $tema->temaPEDDescripcion }}</td>
                                <td>
                                    @php
                                        $dependenciasP = MatrizCoordinacion::where('informe', '2')
                                            ->where('idTemaPED', $tema->idTemaPED)
                                            ->join(
                                                'dependencia',
                                                'dependencia.idDependencia',
                                                '=',
                                                'matriz_coordinacion.dependencias_id',
                                            )
                                            ->get();
                                    @endphp
                                    @if ($dependenciasP->count() > 0)
                                        <center>
                                            <table class="" style="width: 100%">
                                                @foreach ($dependenciasP as $dependencia)
                                                    <tr>
                                                        <th style="width: 30%">{{ $dependencia->dependenciaSiglas }}</th>
                                                        <th
                                                            style="text-align:center;width: 10%;@if ($dependencia->tipo == 'P') background-color:gray;color:white @else background-color:black;color:white @endif">
                                                            {{ $dependencia->tipo }}</th>
                                                        <th style="width: 50%"><button class="btn"
                                                                style="background-color:#f7b584;color:white">Información
                                                                Capturada</button></th>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </center>
                                    @else
                                        <div class="alert alert-info" style="text-align: center">No existen Depedencias
                                            asociadas a este
                                            tema!</div>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td rowspan="{{ $temase6->count() + 1 }}"
                                style="text-align:center;vertical-align: middle;background-color:black;color:white;font-size:1.5em;">
                                T1</td>
                        </tr>
                        @foreach ($temase6 as $tema)
                            <tr>
                                <td style="background-color: rgb(57, 57, 57);color:white;vertical-align:middle">
                                    {{ $tema->temaPEDClave . ' ' . $tema->temaPEDDescripcion }}</td>
                                <td>
                                    @php
                                        $dependenciasP = MatrizCoordinacion::where('informe', '2')
                                            ->where('idTemaPED', $tema->idTemaPED)
                                            ->join(
                                                'dependencia',
                                                'dependencia.idDependencia',
                                                '=',
                                                'matriz_coordinacion.dependencias_id',
                                            )
                                            ->get();
                                    @endphp
                                    @if ($dependenciasP->count() > 0)
                                        <center>
                                            <table class="" style="width: 100%">
                                                @foreach ($dependenciasP as $dependencia)
                                                    <tr>
                                                        <th style="width: 30%">{{ $dependencia->dependenciaSiglas }}</th>
                                                        <th
                                                            style="text-align:center;width: 10%;@if ($dependencia->tipo == 'P') background-color:gray;color:white @else background-color:black;color:white @endif">
                                                            {{ $dependencia->tipo }}</th>
                                                        <th style="width: 50%"><button class="btn"
                                                                style="background-color:rgb(57, 57, 57);color:white">Información
                                                                Capturada</button></th>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </center>
                                    @else
                                        <div class="alert alert-info" style="text-align: center;vertical-align:middle">No
                                            existen Depedencias asociadas a este
                                            tema!</div>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td rowspan="{{ $temase7->count() + 1 }}"
                                style="text-align:center;vertical-align: middle;background-color:black;color:white;font-size:1.5em;">
                                T2</td>
                        </tr>
                        @foreach ($temase7 as $tema)
                            <tr>
                                <td style="background-color: rgb(57, 57, 57);color:white;vertical-align:middle">
                                    {{ $tema->temaPEDClave . ' ' . $tema->temaPEDDescripcion }}</td>
                                <td>
                                    @php
                                        $dependenciasP = MatrizCoordinacion::where('informe', '2')
                                            ->where('idTemaPED', $tema->idTemaPED)
                                            ->join(
                                                'dependencia',
                                                'dependencia.idDependencia',
                                                '=',
                                                'matriz_coordinacion.dependencias_id',
                                            )
                                            ->get();
                                    @endphp
                                    @if ($dependenciasP->count() > 0)
                                        <center>
                                            <table class="" style="width: 100%">
                                                @foreach ($dependenciasP as $dependencia)
                                                    <tr>
                                                        <th style="width: 30%">{{ $dependencia->dependenciaSiglas }}</th>
                                                        <th
                                                            style="text-align:center;width: 10%;@if ($dependencia->tipo == 'P') background-color:gray;color:white @else background-color:black;color:white @endif">
                                                            {{ $dependencia->tipo }}</th>
                                                        <th style="width: 50%"><button class="btn"
                                                                style="background-color:rgb(57, 57, 57);color:white">Información
                                                                Capturada</button></th>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </center>
                                    @else
                                        <div class="alert alert-info" style="text-align: center">No existen Depedencias
                                            asociadas a este
                                            tema!</div>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td rowspan="{{ $temase8->count() + 1 }}"
                                style="text-align:center;vertical-align: middle;background-color:black;color:white;font-size:1.5em;">
                                T3</td>
                        </tr>
                        @foreach ($temase8 as $tema)
                            <tr>
                                <td style="background-color: rgb(57, 57, 57);color:white;vertical-align:middle">
                                    {{ $tema->temaPEDClave . ' ' . $tema->temaPEDDescripcion }}</td>
                                <td>
                                    @php
                                        $dependenciasP = MatrizCoordinacion::where('informe', '2')
                                            ->where('idTemaPED', $tema->idTemaPED)
                                            ->join(
                                                'dependencia',
                                                'dependencia.idDependencia',
                                                '=',
                                                'matriz_coordinacion.dependencias_id',
                                            )
                                            ->get();
                                    @endphp
                                    @if ($dependenciasP->count() > 0)
                                        <center>
                                            <table class="" style="width: 100%">
                                                @foreach ($dependenciasP as $dependencia)
                                                    <tr>
                                                        <th style="width: 30%">{{ $dependencia->dependenciaSiglas }}</th>
                                                        <th
                                                            style="text-align:center;width: 10%;@if ($dependencia->tipo == 'P') background-color:gray;color:white @else background-color:black;color:white @endif">
                                                            {{ $dependencia->tipo }}</th>
                                                        <th style="width: 50%"><button class="btn"
                                                                style="background-color:rgb(57, 57, 57);color:white">Información
                                                                Capturada</button></th>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </center>
                                    @else
                                        <div class="alert alert-info" style="text-align: center">No existen Depedencias
                                            asociadas a este
                                            tema!</div>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td rowspan="{{ $temase9->count() + 1 }}"
                                style="text-align:center;vertical-align: middle;background-color:black;color:white;font-size:1.5em;">
                                T4</td>
                        </tr>
                        @foreach ($temase9 as $tema)
                            <tr>
                                <td style="background-color: rgb(57, 57, 57);color:white;vertical-align:middle">
                                    {{ $tema->temaPEDClave . ' ' . $tema->temaPEDDescripcion }}</td>
                                <td>
                                    @php
                                        $dependenciasP = MatrizCoordinacion::where('informe', '2')
                                            ->where('idTemaPED', $tema->idTemaPED)
                                            ->join(
                                                'dependencia',
                                                'dependencia.idDependencia',
                                                '=',
                                                'matriz_coordinacion.dependencias_id',
                                            )
                                            ->get();
                                    @endphp
                                    @if ($dependenciasP->count() > 0)
                                        <center>
                                            <table class="" style="width: 100%">
                                                @foreach ($dependenciasP as $dependencia)
                                                    <tr>
                                                        <th style="width: 30%">{{ $dependencia->dependenciaSiglas }}</th>
                                                        <th
                                                            style="text-align:center;width: 10%;@if ($dependencia->tipo == 'P') background-color:gray;color:white @else background-color:black;color:white @endif">
                                                            {{ $dependencia->tipo }}</th>
                                                        <th style="width: 50%"><button class="btn"
                                                                style="background-color:rgb(57, 57, 57);color:white">Información
                                                                Capturada</button></th>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </center>
                                    @else
                                        <div class="alert alert-info" style="text-align: center">No existen Depedencias
                                            asociadas a este
                                            tema!</div>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </table>

                </div>
            </div>
            <div class="tab-pane fade" id="nav-dependencias" role="tabpanel" aria-labelledby="nav-contact-tab">
                <center>
                <table class="table" style="width:80%">
                    <thead>
                        <tr style="background-color: gray;color:white;vertical-align: middle">
                            <th style="display: none"">Dependencia</th>
                            <th>Dependencia</th>
                            <th>Temas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $ban=false;
                        @endphp
                        @foreach ($dependencias as $dependencia )
                            <tr style="background-color:{{$ban?"rgb(245,245,245)":"white"}}">
                                <td style="display: none">{{$dependencia->dependenciaNombre}}</td>
                                <td style="color:black;vertical-align:middle"><b>{{$dependencia->dependenciaSiglas}}</b></td>
                                @php
                                    //realizamos la consulta por dependencia y mostrarmos los temas en los cuales participa
                                    $temasd = MatrizCoordinacion::where("dependencias_id",$dependencia->idDependencia)->where("informe","2")
                                                                 ->join("temaped","temaped.idTemaPED","matriz_coordinacion.idTemaPED")
                                                                 ->get();
                                @endphp
                                <td>
                                    @if($temasd->count()>0)
                                    <table class="" style="width: 100%">
                                        <tbody>
                                            @foreach($temasd as $key => $tema)
                                            <tr>
                                                <td style="width: 47.50%">{{$tema->temaPEDClave." ".$tema->temaPEDDescripcion}}</td>
                                                <td style="text-align:center;width: 5%;background-color: @if($tema->tipo=="P") gray @else black @endif; color:white">{{$tema->tipo}}</td>
                                                <td style="width: 47.50%;text-align:center">
                                                    <button class="btn btn-primary">Información Capturada</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                    <div class="alert alert-info">No existen temas relacionados a esta dependencia!</div>
                                    @endif
                                </td>
                            </tr>
                            @php
                                $ban=!$ban;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
                </center>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $("#collapseInforme").addClass("show");
        $("#informecarga").css('background-color', "rgb(217, 217, 217)");
    });
</script>
@endsection
