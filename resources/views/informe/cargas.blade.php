@php
    use App\Models\MatrizCoordinacion;
    use App\Models\InformeParrafo;
    use App\Models\InformeMedio;

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
                    <table class="table" style="width: 80%" border="0" id="tableTemas">
                        <thead>
                            <tr style="background-color: gray;color:white;">
                                <th>Eje</th>
                                <th>Tema</th>
                                <th style="width: 20%">Estatus</th>
                                <th>Dependencias</th>
                                <th>Complementos</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                <td id="temaestatus{{$tema->idTemaPED}}">                                    
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
                                                        @php
                                                            if (false){//$dependencia->tipo == 'CT') {
                                                                //obtenemos todos los parrafos redactados del tema
                                                                $parrafos = InformeParrafo::join(
                                                                    'informe_acciones',
                                                                    'informe_acciones.id',
                                                                    '=',
                                                                    'informe_parrafos.informe_acciones_id',
                                                                )
                                                                    ->where(
                                                                        'informe_acciones.idTemaPED',
                                                                        $tema->idTemaPED,
                                                                    )
                                                                    ->where("informe_acciones.status","=",1)
                                                                    ->where("informe_acciones.reporta4to","=",1)
                                                                    ->get();
                                                            } else {
                                                                //obtenemos todos los parrafos redactados del tema y por dependencia
                                                                $parrafos = InformeParrafo::join(
                                                                    'informe_acciones',
                                                                    'informe_acciones.id',
                                                                    '=',
                                                                    'informe_parrafos.informe_acciones_id',
                                                                )
                                                                    ->where(
                                                                        'informe_acciones.idTemaPED',
                                                                        $tema->idTemaPED,
                                                                    )
                                                                    ->where(
                                                                        'informe_acciones.idDependencia',
                                                                        $dependencia->idDependencia,
                                                                    )
                                                                    ->where("informe_acciones.status","=",1)
                                                                    ->where("informe_acciones.reporta4to","=",1)
                                                                    ->get();
                                                            }
                                                        @endphp
                                                    <tr>
                                                        <td style="width: 30%" data-title="{{ $dependencia->dependenciaNombre }}"
                                                            data-toggle="tooltip"
                                                            data-placement="top">{{ $dependencia->dependenciaSiglas }}</td>
                                                            <td
                                                                style="text-align:center;width: 10%;@if ($dependencia->tipo == 'P') background-color:gray;color:white @else background-color:black;color:white @endif">
                                                                {{ $dependencia->tipo }}
                                                        </td>
                                                        <td>
                                                            @if ($parrafos->count() > 0 && $dependencia->bloqueado==1)
                                                                <i class="fas fa-circle" style="color:green" data-title="Info cargada y mandada a revisión por el enlace" data-toggle="tooltip" data-placement="top"></i>
                                                            @else
                                                                <i class="fas fa-circle" style="color:red" data-title="La Info no ha sido cargada y mandada a revisión por el enlace" data-toggle="tooltip" data-placement="top"></i>
                                                            @endif
                                                        </td>
                                                        <td style="width: 50%;text-align: center">                                                            
                                                            @if ($parrafos->count() > 0)
                                                            <form action="{{route('informe.downloadword')}}" method="POST" class="padding:10px;">
                                                                @csrf

                                                                    <input type="hidden" value="{{$dependencia->idDependencia}}" name="dependencia"/>
                                                                    <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>                                                                    
                                                                    <input type="hidden" value="true" name="sinrol"/>                                                                    
                                                                    @if($parrafos->count()>0)
                                                                        <button type="submit" class="btn btn-primary" style="font-size:.8em;"><i class="fas fa-download"></i> Individual</button>
                                                                    @endif
                                                                </form>
                                                            @endif
                                                            <div
                                                                style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align: ">
                                                                ({{ $parrafos->count() }})
                                                                párrafos
                                                            </div>
                                                        </td>
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
                                @php
                                    $complementos = InformeMedio::join("informe_parrafos","informe_parrafos.id","=","informe_medios.idParrafo")
                                                                    ->join("informe_acciones","informe_acciones.id","=","informe_parrafos.informe_acciones_id")
                                                                    ->where("informe_acciones.idTemaPED","=",$tema->idTemaPED)
                                                                    ->where("informe_acciones.status","=",1)
                                                                    ->where("informe_acciones.reporta4to","=",1)
                                                                    ->get();
                                    //obtenemos todos los parrafos redactados del tema
                                    $parrafos_totales = InformeParrafo::join(
                                                                    'informe_acciones',
                                                                    'informe_acciones.id',
                                                                    '=',
                                                                    'informe_parrafos.informe_acciones_id',
                                                                )
                                                                    ->where(
                                                                        'informe_acciones.idTemaPED',
                                                                        $tema->idTemaPED,
                                                                    )
                                                                    ->where("informe_acciones.status","=",1)
                                                                    ->where("informe_acciones.reporta4to","=",1)
                                                                    ->get();
                                    //obtenemos si existe un ordenamiento de párrafos por parte de la Coordinadora 
                                    $parrafos_ordenados = 0;
                                    $parrafos_sin_ordenar = 0;
                                    foreach($parrafos_totales as $pa){
                                        if($pa->orden_ct === null)
                                            $parrafos_sin_ordenar += 1;
                                        else
                                            $parrafos_ordenados += 1;                                        
                                    }
                                @endphp
                                <td style="vertical-align:middle;">
                                    @if ($parrafos_totales->count() > 0)
                                        <form action="{{route('informe.downloadword')}}" method="POST" class="padding:10px;">
                                            @csrf

                                                <input type="hidden" value="0" name="dependencia"/>
                                                <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>
                                                <input type="hidden" value="true" name="integrado"/>
                                                @if($parrafos_totales->count()>0)
                                                    <button type="submit" class="btn btn-success" style="font-size:.8em;"><i class="fas fa-download"></i> Integrado</button>
                                                @endif
                                        </form>
                                    @endif
                                    <div
                                        style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align: ">
                                        ({{ $parrafos_totales->count() }}) p. totales
                                        <br/>
                                        <span style="color:green">({{ $parrafos_ordenados }})</span>
                                        <span style="color:red">({{ $parrafos_sin_ordenar }})</span>

                                    </div>                                
                                    @if($complementos->count()>0)
                                        <form action="{{route('informe.tema.getcomplementoszip')}}" target="_blank" method="POST">
                                            @csrf
                                            <input type="hidden" name="idTemaPED" value="{{$tema->idTemaPED}}">
                                            <button type="submit" class="btn btn-warning" ><i class="fas fa-download"></i> Complementos</button>
                                        </form>
                                    @endif
                                    <div style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align:">({{$complementos->count()}})Complementos</div>
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
                                <td id="temaestatus{{$tema->idTemaPED}}">                                    
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
                                                    @php
                                                        if (false){//$dependencia->tipo == 'CT') {
                                                            //obtenemos todos los parrafos redactados del tema
                                                            $parrafos = InformeParrafo::join(
                                                                'informe_acciones',
                                                                'informe_acciones.id',
                                                                '=',
                                                                'informe_parrafos.informe_acciones_id',
                                                            )
                                                                ->where(
                                                                    'informe_acciones.idTemaPED',
                                                                    $tema->idTemaPED,
                                                                )
                                                                ->where("informe_acciones.status","=",1)
                                                                ->where("informe_acciones.reporta4to","=",1)
                                                                ->get();
                                                        } else {
                                                            //obtenemos todos los parrafos redactados del tema y por dependencia
                                                            $parrafos = InformeParrafo::join(
                                                                'informe_acciones',
                                                                'informe_acciones.id',
                                                                '=',
                                                                'informe_parrafos.informe_acciones_id',
                                                            )
                                                                ->where(
                                                                    'informe_acciones.idTemaPED',
                                                                    $tema->idTemaPED,
                                                                )
                                                                ->where(
                                                                    'informe_acciones.idDependencia',
                                                                    $dependencia->idDependencia,
                                                                )->where("informe_acciones.status","=",1)
                                                                ->where("informe_acciones.reporta4to","=",1)
                                                                ->get();
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td style="width: 30%" data-title="{{ $dependencia->dependenciaNombre }}"
                                                            data-toggle="tooltip"
                                                            data-placement="top">{{ $dependencia->dependenciaSiglas }}</td>
                                                        <td
                                                            style="text-align:center;width: 10%;@if ($dependencia->tipo == 'P') background-color:gray;color:white @else background-color:black;color:white @endif">
                                                            {{ $dependencia->tipo }}</td>
                                                        <td>
                                                            @if ($parrafos->count() > 0 && $dependencia->bloqueado==1)
                                                                <i class="fas fa-circle" style="color:green" data-title="Info cargada y mandada a revisión por el enlace" data-toggle="tooltip" data-placement="top"></i>
                                                            @else
                                                                <i class="fas fa-circle" style="color:red" data-title="La Info no ha sido cargada y mandada a revisión por el enlace" data-toggle="tooltip" data-placement="top"></i>
                                                            @endif
                                                        </td>
                                                        <td style="width: 50%;text-align:center">                                                        
                                                            @if ($parrafos->count() > 0)
                                                            <form action="{{route('informe.downloadword')}}" method="POST" class="padding:10px;">
                                                                @csrf

                                                                    <input type="hidden" value="{{$dependencia->idDependencia}}" name="dependencia"/>
                                                                    <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>
                                                                    <input type="hidden" value="true" name="sinrol"/>                                                                    
                                                                    @if($parrafos->count()>0)
                                                                        <button type="submit" class="btn btn-primary" style="font-size:.8em;"><i class="fas fa-download"></i> Individual</button>
                                                                    @endif
                                                                </form>
                                                            @endif
                                                            <div
                                                                style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align: ">
                                                                ({{ $parrafos->count() }})
                                                                párrafos
                                                            </div>
                                                        </td>
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
                                @php
                                $complementos = InformeMedio::join("informe_parrafos","informe_parrafos.id","=","informe_medios.idParrafo")
                                                                ->join("informe_acciones","informe_acciones.id","=","informe_parrafos.informe_acciones_id")
                                                                ->where("informe_acciones.idTemaPED","=",$tema->idTemaPED)
                                                                ->where("informe_acciones.status","=",1)
                                                                ->where("informe_acciones.reporta4to","=",1)
                                                                ->get();
                                //obtenemos todos los parrafos redactados del tema
                                $parrafos_totales = InformeParrafo::join(
                                                                    'informe_acciones',
                                                                    'informe_acciones.id',
                                                                    '=',
                                                                    'informe_parrafos.informe_acciones_id',
                                                                )
                                                                    ->where(
                                                                        'informe_acciones.idTemaPED',
                                                                        $tema->idTemaPED,
                                                                    )
                                                                    ->where("informe_acciones.status","=",1)
                                                                    ->where("informe_acciones.reporta4to","=",1)
                                                                    ->get();
                                 //obtenemos si existe un ordenamiento de párrafos por parte de la Coordinadora 
                                 $parrafos_ordenados = 0;
                                    $parrafos_sin_ordenar = 0;
                                    foreach($parrafos_totales as $pa){
                                        if($pa->orden_ct === null)
                                            $parrafos_sin_ordenar += 1;
                                        else
                                            $parrafos_ordenados += 1;                                        
                                    }
                            @endphp
                            <td style="vertical-align:middle">
                                @if ($parrafos_totales->count() > 0)
                                                <form action="{{route('informe.downloadword')}}" method="POST" class="padding:10px;">
                                                    @csrf

                                                        <input type="hidden" value="0" name="dependencia"/>
                                                        <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>
                                                        <input type="hidden" value="true" name="integrado"/>
                                                        @if($parrafos_totales->count()>0)
                                                            <button type="submit" class="btn btn-success" style="font-size:.8em;"><i class="fas fa-download"></i> Integrado</button>
                                                        @endif
                                                    </form>
                                @endif
                                <div
                                    style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align: ">
                                    ({{ $parrafos_totales->count() }}) p. totales
                                    <br/>
                                    <span style="color:green">({{ $parrafos_ordenados }})</span>
                                    <span style="color:red">({{ $parrafos_sin_ordenar }})</span>
                                </div>  
                                @if($complementos->count()>0)
                                    <form action="{{route('informe.tema.getcomplementoszip')}}" target="_blank" method="POST">
                                        @csrf
                                        <input type="hidden" name="idTemaPED" value="{{$tema->idTemaPED}}">
                                        <button type="submit" class="btn btn-warning" ><i class="fas fa-download"></i>Complementos</button>
                                    </form>
                                @endif
                                <div style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align:">({{$complementos->count()}})Complementos</div>
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
                                <td id="temaestatus{{$tema->idTemaPED}}">                                    
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
                                                    @php
                                                        if (false){//$dependencia->tipo == 'CT') {
                                                            //obtenemos todos los parrafos redactados del tema
                                                            $parrafos = InformeParrafo::join(
                                                                'informe_acciones',
                                                                'informe_acciones.id',
                                                                '=',
                                                                'informe_parrafos.informe_acciones_id',
                                                            )
                                                                ->where(
                                                                    'informe_acciones.idTemaPED',
                                                                    $tema->idTemaPED,
                                                                )
                                                                ->where("informe_acciones.status","=",1)
                                                                ->where("informe_acciones.reporta4to","=",1)
                                                                ->get();
                                                        } else {
                                                            //obtenemos todos los parrafos redactados del tema y por dependencia
                                                            $parrafos = InformeParrafo::join(
                                                                'informe_acciones',
                                                                'informe_acciones.id',
                                                                '=',
                                                                'informe_parrafos.informe_acciones_id',
                                                            )
                                                                ->where(
                                                                    'informe_acciones.idTemaPED',
                                                                    $tema->idTemaPED,
                                                                )
                                                                ->where(
                                                                    'informe_acciones.idDependencia',
                                                                    $dependencia->idDependencia,
                                                                )
                                                                ->where("informe_acciones.status","=",1)
                                                                ->where("informe_acciones.reporta4to","=",1)
                                                                ->get();
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td style="width: 30%" data-title="{{ $dependencia->dependenciaNombre }}"
                                                            data-toggle="tooltip"
                                                            data-placement="top">{{ $dependencia->dependenciaSiglas }}</td>
                                                        <td
                                                            style="text-align:center;width: 10%;@if ($dependencia->tipo == 'P') background-color:gray;color:white @else background-color:black;color:white @endif">
                                                            {{ $dependencia->tipo }}</td>
                                                    <td>
                                                        @if ($parrafos->count() > 0 && $dependencia->bloqueado==1)
                                                            <i class="fas fa-circle" style="color:green" data-title="Info cargada y mandada a revisión por el enlace" data-toggle="tooltip" data-placement="top"></i>
                                                        @else
                                                            <i class="fas fa-circle" style="color:red" data-title="La Info no ha sido cargada y mandada a revisión por el enlace" data-toggle="tooltip" data-placement="top"></i>
                                                        @endif
                                                    </td>
                                                        <td style="width: 50%;text-align:center">                                                            
                                                            @if ($parrafos->count() > 0)
                                                            <form action="{{route('informe.downloadword')}}" method="POST" class="padding:10px;">
                                                                @csrf

                                                                    <input type="hidden" value="{{$dependencia->idDependencia}}" name="dependencia"/>
                                                                    <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>
                                                                    <input type="hidden" value="true" name="sinrol"/>                                                                    
                                                                    @if($parrafos->count()>0)
                                                                        <button type="submit" class="btn btn-primary" style="font-size:.8em;"><i class="fas fa-download"></i> Individual</button>
                                                                    @endif
                                                                </form>
                                                            @endif
                                                            <div
                                                                style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align: ">
                                                                ({{ $parrafos->count() }})
                                                                párrafos
                                                            </div>
                                                        </td>
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
                                @php
                                $complementos = InformeMedio::join("informe_parrafos","informe_parrafos.id","=","informe_medios.idParrafo")
                                                                ->join("informe_acciones","informe_acciones.id","=","informe_parrafos.informe_acciones_id")
                                                                ->where("informe_acciones.idTemaPED","=",$tema->idTemaPED)
                                                                ->where("informe_acciones.status","=",1)
                                                                ->where("informe_acciones.reporta4to","=",1)
                                                                ->get();
                                 //obtenemos todos los parrafos redactados del tema
                                 $parrafos_totales = InformeParrafo::join(
                                                                    'informe_acciones',
                                                                    'informe_acciones.id',
                                                                    '=',
                                                                    'informe_parrafos.informe_acciones_id',
                                                                )
                                                                    ->where(
                                                                        'informe_acciones.idTemaPED',
                                                                        $tema->idTemaPED,
                                                                    )
                                                                    ->where("informe_acciones.status","=",1)
                                                                    ->where("informe_acciones.reporta4to","=",1)
                                                                    ->get();
                                //obtenemos si existe un ordenamiento de párrafos por parte de la Coordinadora 
                                $parrafos_ordenados = 0;
                                $parrafos_sin_ordenar = 0;
                                    foreach($parrafos_totales as $pa){
                                        if($pa->orden_ct === null)
                                            $parrafos_sin_ordenar += 1;
                                        else
                                            $parrafos_ordenados += 1;                                        
                                    }
                                @endphp
                                <td style="vertical-align:middle">
                                    @if ($parrafos_totales->count() > 0)
                                    <form action="{{route('informe.downloadword')}}" method="POST" class="padding:10px;">
                                        @csrf

                                            <input type="hidden" value="0" name="dependencia"/>
                                            <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>
                                            <input type="hidden" value="true" name="integrado"/>
                                            @if($parrafos_totales->count()>0)
                                                <button type="submit" class="btn btn-success" style="font-size:.8em;"><i class="fas fa-download"></i> Integrado</button>
                                            @endif
                                        </form>
                                    @endif
                                    <div
                                        style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align: ">
                                        ({{ $parrafos_totales->count() }}) p. totales
                                        <br/>
                                        <span style="color:green">({{ $parrafos_ordenados }})</span>
                                        <span style="color:red">({{ $parrafos_sin_ordenar }})</span>
                                    </div>  
                                    @if($complementos->count()>0)
                                        <form action="{{route('informe.tema.getcomplementoszip')}}" target="_blank" method="POST">
                                            @csrf
                                            <input type="hidden" name="idTemaPED" value="{{$tema->idTemaPED}}">
                                            <button type="submit" class="btn btn-warning" ><i class="fas fa-download"></i> Complementos</button>
                                        </form>
                                    @endif
                                    <div style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align:">({{$complementos->count()}})Complementos</div>
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
                                <td id="temaestatus{{$tema->idTemaPED}}">                                    
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
                                                    @php
                                                        if (false){//$dependencia->tipo == 'CT') {
                                                            //obtenemos todos los parrafos redactados del tema
                                                            $parrafos = InformeParrafo::join(
                                                                'informe_acciones',
                                                                'informe_acciones.id',
                                                                '=',
                                                                'informe_parrafos.informe_acciones_id',
                                                            )
                                                                ->where(
                                                                    'informe_acciones.idTemaPED',
                                                                    $tema->idTemaPED,
                                                                )
                                                                ->where("informe_acciones.status","=",1)
                                                                ->where("informe_acciones.reporta4to","=",1)
                                                                ->get();
                                                        } else {
                                                            //obtenemos todos los parrafos redactados del tema y por dependencia
                                                            $parrafos = InformeParrafo::join(
                                                                'informe_acciones',
                                                                'informe_acciones.id',
                                                                '=',
                                                                'informe_parrafos.informe_acciones_id',
                                                            )
                                                                ->where(
                                                                    'informe_acciones.idTemaPED',
                                                                    $tema->idTemaPED,
                                                                )
                                                                ->where(
                                                                    'informe_acciones.idDependencia',
                                                                    $dependencia->idDependencia,
                                                                )
                                                                ->where("informe_acciones.status","=",1)
                                                                ->where("informe_acciones.reporta4to","=",1)
                                                                ->get();
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td style="width: 30%" data-title="{{ $dependencia->dependenciaNombre }}"
                                                            data-toggle="tooltip"
                                                            data-placement="top">{{ $dependencia->dependenciaSiglas }}</td>
                                                        <td
                                                            style="text-align:center;width: 10%;@if ($dependencia->tipo == 'P') background-color:gray;color:white @else background-color:black;color:white @endif">
                                                            {{ $dependencia->tipo }}</td>
                                                        <td>
                                                            @if ($parrafos->count() > 0 && $dependencia->bloqueado==1)
                                                                <i class="fas fa-circle" style="color:green" data-title="Info cargada y mandada a revisión por el enlace" data-toggle="tooltip" data-placement="top"></i>
                                                            @else
                                                                <i class="fas fa-circle" style="color:red" data-title="La Info no ha sido cargada y mandada a revisión por el enlace" data-toggle="tooltip" data-placement="top"></i>
                                                            @endif
                                                        </td>
                                                        <td style="width: 50%;text-align:center">                                                            
                                                            @if ($parrafos->count() > 0)
                                                            <form action="{{route('informe.downloadword')}}" method="POST" class="padding:10px;">
                                                                @csrf

                                                                    <input type="hidden" value="{{$dependencia->idDependencia}}" name="dependencia"/>
                                                                    <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>
                                                                    <input type="hidden" value="true" name="sinrol"/>                                                                    
                                                                    @if($parrafos->count()>0)
                                                                        <button type="submit" class="btn btn-primary" style="font-size:.8em;"><i class="fas fa-download"></i> Individual</button>
                                                                    @endif
                                                                </form>
                                                            @endif
                                                            <div
                                                                style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align: ">
                                                                ({{ $parrafos->count() }})
                                                                párrafos
                                                            </div>
                                                        </td>
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
                                @php
                                //obtenemos todos los parrafos redactados del tema
                                $parrafos_totales = InformeParrafo::join(
                                                                    'informe_acciones',
                                                                    'informe_acciones.id',
                                                                    '=',
                                                                    'informe_parrafos.informe_acciones_id',
                                                                )
                                                                    ->where(
                                                                        'informe_acciones.idTemaPED',
                                                                        $tema->idTemaPED,
                                                                    )
                                                                    ->where("informe_acciones.status","=",1)
                                                                    ->where("informe_acciones.reporta4to","=",1)
                                                                    ->get();
                                $complementos = InformeMedio::join("informe_parrafos","informe_parrafos.id","=","informe_medios.idParrafo")
                                                                ->join("informe_acciones","informe_acciones.id","=","informe_parrafos.informe_acciones_id")
                                                                ->where("informe_acciones.idTemaPED","=",$tema->idTemaPED)
                                                                ->where("informe_acciones.status","=",1)
                                                                ->where("informe_acciones.reporta4to","=",1)
                                                                ->get();                                                          
                                $parrafos_ordenados = 0;
                                $parrafos_sin_ordenar = 0;
                                foreach($parrafos_totales as $pa){
                                    if($pa->orden_ct === null)
                                        $parrafos_sin_ordenar += 1;
                                    else
                                        $parrafos_ordenados += 1;                                        
                                }
                            @endphp
                            <td style="vertical-align:middle">
                                @if ($parrafos_totales->count() > 0)
                                    <form action="{{route('informe.downloadword')}}" method="POST" class="padding:10px;">
                                        @csrf

                                            <input type="hidden" value="0" name="dependencia"/>
                                            <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>
                                            <input type="hidden" value="true" name="integrado"/>
                                            @if($parrafos_totales->count()>0)
                                                <button type="submit" class="btn btn-success" style="font-size:.8em;"><i class="fas fa-download"></i> Integrado</button>
                                            @endif
                                        </form>
                                @endif
                                <div
                                    style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align: ">
                                    ({{ $parrafos_totales->count() }}) p. totales
                                    <br/>
                                    <span style="color:green">({{ $parrafos_ordenados }})</span>
                                    <span style="color:red">({{ $parrafos_sin_ordenar }})</span>
                                </div>
                                @if($complementos->count()>0)
                                    <form action="{{route('informe.tema.getcomplementoszip')}}" target="_blank" method="POST">
                                        @csrf
                                        <input type="hidden" name="idTemaPED" value="{{$tema->idTemaPED}}">
                                        <button type="submit" class="btn btn-warning" ><i class="fas fa-download"></i> Complementos</button>
                                    </form>
                                @endif
                                <div style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align:">({{$complementos->count()}})Complementos</div>
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
                                <td id="temaestatus{{$tema->idTemaPED}}">                                    
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
                                                    @php
                                                        if (false){//$dependencia->tipo == 'CT') {
                                                            //obtenemos todos los parrafos redactados del tema
                                                            $parrafos = InformeParrafo::join(
                                                                'informe_acciones',
                                                                'informe_acciones.id',
                                                                '=',
                                                                'informe_parrafos.informe_acciones_id',
                                                            )
                                                                ->where(
                                                                    'informe_acciones.idTemaPED',
                                                                    $tema->idTemaPED,
                                                                )
                                                                ->where("informe_acciones.status","=",1)
                                                                ->where("informe_acciones.reporta4to","=",1)
                                                                ->get();
                                                        } else {
                                                            //obtenemos todos los parrafos redactados del tema y por dependencia
                                                            $parrafos = InformeParrafo::join(
                                                                'informe_acciones',
                                                                'informe_acciones.id',
                                                                '=',
                                                                'informe_parrafos.informe_acciones_id',
                                                            )
                                                                ->where(
                                                                    'informe_acciones.idTemaPED',
                                                                    $tema->idTemaPED,
                                                                )
                                                                ->where(
                                                                    'informe_acciones.idDependencia',
                                                                    $dependencia->idDependencia,
                                                                )
                                                                ->where("informe_acciones.status","=",1)
                                                                ->where("informe_acciones.reporta4to","=",1)
                                                                ->get();
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td style="width: 30%" data-title="{{ $dependencia->dependenciaNombre }}"
                                                            data-toggle="tooltip"
                                                            data-placement="top">{{ $dependencia->dependenciaSiglas }}</td>
                                                        <td
                                                            style="text-align:center;width: 10%;@if ($dependencia->tipo == 'P') background-color:gray;color:white @else background-color:black;color:white @endif">
                                                            {{ $dependencia->tipo }}</td>
                                                        <td>
                                                            @if ($parrafos->count() > 0 && $dependencia->bloqueado==1)
                                                                <i class="fas fa-circle" style="color:green" data-title="Info cargada y mandada a revisión por el enlace" data-toggle="tooltip" data-placement="top"></i>
                                                            @else
                                                                <i class="fas fa-circle" style="color:red" data-title="La Info no ha sido cargada y mandada a revisión por el enlace" data-toggle="tooltip" data-placement="top"></i>
                                                            @endif
                                                        </td>
                                                        <td style="width: 50%;text-align:center">                                                            
                                                            @if ($parrafos->count() > 0)
                                                            <form action="{{route('informe.downloadword')}}" method="POST" class="padding:10px;">
                                                                @csrf

                                                                    <input type="hidden" value="{{$dependencia->idDependencia}}" name="dependencia"/>
                                                                    <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>
                                                                    <input type="hidden" value="true" name="sinrol"/>                                                                    
                                                                    @if($parrafos->count()>0)
                                                                        <button type="submit" class="btn btn-primary" style="font-size:.8em;"><i class="fas fa-download"></i> Individual</button>
                                                                    @endif
                                                                </form>
                                                            @endif
                                                            <div
                                                                style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align: ">
                                                                ({{ $parrafos->count() }})
                                                                párrafos
                                                            </div>
                                                        </td>
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
                                @php
                                $complementos = InformeMedio::join("informe_parrafos","informe_parrafos.id","=","informe_medios.idParrafo")
                                                                ->join("informe_acciones","informe_acciones.id","=","informe_parrafos.informe_acciones_id")
                                                                ->where("informe_acciones.idTemaPED","=",$tema->idTemaPED)
                                                                ->where("informe_acciones.status","=",1)
                                                                ->where("informe_acciones.reporta4to","=",1)
                                                                ->get();
                                //obtenemos todos los parrafos redactados del tema
                                $parrafos_totales = InformeParrafo::join(
                                                                    'informe_acciones',
                                                                    'informe_acciones.id',
                                                                    '=',
                                                                    'informe_parrafos.informe_acciones_id',
                                                                )
                                                                    ->where(
                                                                        'informe_acciones.idTemaPED',
                                                                        $tema->idTemaPED,
                                                                    )
                                                                    ->where("informe_acciones.status","=",1)
                                                                    ->where("informe_acciones.reporta4to","=",1)
                                                                    ->get();
                                $parrafos_ordenados = 0;
                                $parrafos_sin_ordenar = 0;
                                foreach($parrafos_totales as $pa){
                                    if($pa->orden_ct === null)
                                        $parrafos_sin_ordenar += 1;
                                    else
                                        $parrafos_ordenados += 1;                                        
                                }
                            @endphp
                            <td style="vertical-align:middle">
                                @if ($parrafos_totales->count() > 0)
                                    <form action="{{route('informe.downloadword')}}" method="POST" class="padding:10px;">
                                        @csrf

                                            <input type="hidden" value="0" name="dependencia"/>
                                            <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>
                                            <input type="hidden" value="true" name="integrado"/>
                                            @if($parrafos_totales->count()>0)
                                                <button type="submit" class="btn btn-success" style="font-size:.8em;"><i class="fas fa-download"></i> Integrado</button>
                                            @endif
                                        </form>
                                @endif
                                <div
                                    style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align: ">
                                    ({{ $parrafos_totales->count() }}) p. totales
                                    <br/>
                                    <span style="color:green">({{ $parrafos_ordenados }})</span>
                                    <span style="color:red">({{ $parrafos_sin_ordenar }})</span>
                                </div>
                                @if($complementos->count()>0)
                                    <form action="{{route('informe.tema.getcomplementoszip')}}" target="_blank" method="POST">
                                        @csrf
                                        <input type="hidden" name="idTemaPED" value="{{$tema->idTemaPED}}">
                                        <button type="submit" class="btn btn-warning" ><i class="fas fa-download"></i> Complementos</button>
                                    </form>
                                @endif
                                <div style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align:">({{$complementos->count()}})Complementos</div>
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
                                <td id="temaestatus{{$tema->idTemaPED}}">                                    
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
                                                    @php
                                                        if (false){//$dependencia->tipo == 'CT') {
                                                            //obtenemos todos los parrafos redactados del tema
                                                            $parrafos = InformeParrafo::join(
                                                                'informe_acciones',
                                                                'informe_acciones.id',
                                                                '=',
                                                                'informe_parrafos.informe_acciones_id',
                                                            )
                                                                ->where(
                                                                    'informe_acciones.idTemaPED',
                                                                    $tema->idTemaPED,
                                                                )
                                                                ->where("informe_acciones.status","=",1)
                                                                ->where("informe_acciones.reporta4to","=",1)
                                                                ->get();
                                                        } else {
                                                            //obtenemos todos los parrafos redactados del tema y por dependencia
                                                            $parrafos = InformeParrafo::join(
                                                                'informe_acciones',
                                                                'informe_acciones.id',
                                                                '=',
                                                                'informe_parrafos.informe_acciones_id',
                                                            )
                                                                ->where(
                                                                    'informe_acciones.idTemaPED',
                                                                    $tema->idTemaPED,
                                                                )
                                                                ->where(
                                                                    'informe_acciones.idDependencia',
                                                                    $dependencia->idDependencia,
                                                                )
                                                                ->where("informe_acciones.status","=",1)
                                                                ->where("informe_acciones.reporta4to","=",1)
                                                                ->get();
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td style="width: 30%" data-title="{{ $dependencia->dependenciaNombre }}"
                                                            data-toggle="tooltip"
                                                            data-placement="top">{{ $dependencia->dependenciaSiglas }}</td>
                                                        <td
                                                            style="text-align:center;width: 10%;@if ($dependencia->tipo == 'P') background-color:gray;color:white @else background-color:black;color:white @endif">
                                                            {{ $dependencia->tipo }}</td>
                                                        <td>
                                                            @if ($parrafos->count() > 0 && $dependencia->bloqueado==1)
                                                                <i class="fas fa-circle" style="color:green" data-title="Info cargada y mandada a revisión por el enlace" data-toggle="tooltip" data-placement="top"></i>
                                                            @else
                                                                <i class="fas fa-circle" style="color:red" data-title="La Info no ha sido cargada y mandada a revisión por el enlace" data-toggle="tooltip" data-placement="top"></i>
                                                            @endif
                                                        </td>
                                                        <td style="width: 50%;text-align:center">                                                            
                                                            @if ($parrafos->count() > 0)
                                                            <form action="{{route('informe.downloadword')}}" method="POST" class="padding:10px;">
                                                                @csrf

                                                                    <input type="hidden" value="{{$dependencia->idDependencia}}" name="dependencia"/>
                                                                    <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>
                                                                    <input type="hidden" value="true" name="sinrol"/>                                                                    
                                                                    @if($parrafos->count()>0)
                                                                        <button type="submit" class="btn btn-primary" style="font-size:.8em;"><i class="fas fa-download"></i> Individual</button>
                                                                    @endif
                                                                </form>
                                                            @endif
                                                            <div
                                                                style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align: ">
                                                                ({{ $parrafos->count() }})
                                                                párrafos
                                                            </div>
                                                        </td>
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
                                @php
                                $complementos = InformeMedio::join("informe_parrafos","informe_parrafos.id","=","informe_medios.idParrafo")
                                                                ->join("informe_acciones","informe_acciones.id","=","informe_parrafos.informe_acciones_id")
                                                                ->where("informe_acciones.idTemaPED","=",$tema->idTemaPED)
                                                                ->where("informe_acciones.status","=",1)
                                                                ->where("informe_acciones.reporta4to","=",1)
                                                                ->get();
                                //obtenemos todos los parrafos redactados del tema
                                $parrafos_totales = InformeParrafo::join(
                                                                    'informe_acciones',
                                                                    'informe_acciones.id',
                                                                    '=',
                                                                    'informe_parrafos.informe_acciones_id',
                                                                )
                                                                    ->where(
                                                                        'informe_acciones.idTemaPED',
                                                                        $tema->idTemaPED,
                                                                    )
                                                                    ->where("informe_acciones.status","=",1)
                                                                    ->where("informe_acciones.reporta4to","=",1)
                                                                    ->get();
                                $parrafos_ordenados = 0;
                                $parrafos_sin_ordenar = 0;
                                foreach($parrafos_totales as $pa){
                                    if($pa->orden_ct === null)
                                        $parrafos_sin_ordenar += 1;
                                    else
                                        $parrafos_ordenados += 1;                                        
                                }
                            @endphp
                            <td style="vertical-align:middle">
                                @if ($parrafos_totales->count() > 0)
                                    <form action="{{route('informe.downloadword')}}" method="POST" class="padding:10px;">
                                        @csrf

                                            <input type="hidden" value="0" name="dependencia"/>
                                            <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>
                                            <input type="hidden" value="true" name="integrado"/>
                                            @if($parrafos_totales->count()>0)
                                                <button type="submit" class="btn btn-success" style="font-size:.8em;"><i class="fas fa-download"></i> Integrado</button>
                                            @endif
                                        </form>
                                @endif
                                <div
                                    style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align: ">
                                    ({{ $parrafos_totales->count() }}) p. totales
                                    <br/>
                                    <span style="color:green">({{ $parrafos_ordenados }})</span>
                                    <span style="color:red">({{ $parrafos_sin_ordenar }})</span>
                                </div>
                                @if($complementos->count()>0)
                                    <form action="{{route('informe.tema.getcomplementoszip')}}" target="_blank" method="POST">
                                        @csrf
                                        <input type="hidden" name="idTemaPED" value="{{$tema->idTemaPED}}">
                                        <button type="submit" class="btn btn-warning" ><i class="fas fa-download"></i> Complementos</button>
                                    </form>
                                @endif
                                <div style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align:">({{$complementos->count()}})Complementos</div>
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
                                <td id="temaestatus{{$tema->idTemaPED}}">                                    
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
                                                @php
                                                    if (false){//$dependencia->tipo == 'CT') {
                                                        //obtenemos todos los parrafos redactados del tema
                                                        $parrafos = InformeParrafo::join(
                                                            'informe_acciones',
                                                            'informe_acciones.id',
                                                            '=',
                                                            'informe_parrafos.informe_acciones_id',
                                                        )
                                                            ->where(
                                                                'informe_acciones.idTemaPED',
                                                                $tema->idTemaPED,
                                                            )
                                                            ->where("informe_acciones.status","=",1)
                                                            ->where("informe_acciones.reporta4to","=",1)
                                                            ->get();
                                                    } else {
                                                        //obtenemos todos los parrafos redactados del tema y por dependencia
                                                        $parrafos = InformeParrafo::join(
                                                            'informe_acciones',
                                                            'informe_acciones.id',
                                                            '=',
                                                            'informe_parrafos.informe_acciones_id',
                                                        )
                                                            ->where(
                                                                'informe_acciones.idTemaPED',
                                                                $tema->idTemaPED,
                                                            )
                                                            ->where(
                                                                'informe_acciones.idDependencia',
                                                                $dependencia->idDependencia,
                                                            )
                                                            ->where("informe_acciones.status","=",1)
                                                            ->where("informe_acciones.reporta4to","=",1)
                                                            ->get();
                                                    }
                                                @endphp
                                                    <tr>
                                                        <td style="width: 30%" data-title="{{ $dependencia->dependenciaNombre }}"
                                                            data-toggle="tooltip"
                                                            data-placement="top">{{ $dependencia->dependenciaSiglas }}</td>
                                                        <td
                                                            style="text-align:center;width: 10%;@if ($dependencia->tipo == 'P') background-color:gray;color:white @else background-color:black;color:white @endif">
                                                            {{ $dependencia->tipo }}</td>
                                                        <td>
                                                            @if ($parrafos->count() > 0 && $dependencia->bloqueado==1)
                                                                <i class="fas fa-circle" style="color:green" data-title="Info cargada y mandada a revisión por el enlace" data-toggle="tooltip" data-placement="top"></i>
                                                            @else
                                                                <i class="fas fa-circle" style="color:red" data-title="La Info no ha sido cargada y mandada a revisión por el enlace" data-toggle="tooltip" data-placement="top"></i>
                                                            @endif
                                                        </td>
                                                        <td style="width: 50%;text-align:center">                                                            
                                                            @if ($parrafos->count() > 0)
                                                            <form action="{{route('informe.downloadword')}}" method="POST" class="padding:10px;">
                                                                @csrf

                                                                    <input type="hidden" value="{{$dependencia->idDependencia}}" name="dependencia"/>
                                                                    <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>
                                                                    <input type="hidden" value="true" name="sinrol"/>                                                                    
                                                                    @if($parrafos->count()>0)
                                                                        <button type="submit" class="btn btn-primary" style="font-size:.8em;"><i class="fas fa-download"></i> Individual</button>
                                                                    @endif
                                                                </form>
                                                            @endif
                                                            <div
                                                                style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align: ">
                                                                ({{ $parrafos->count() }})
                                                                párrafos
                                                            </div>
                                                        </td>
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
                                @php
                                $complementos = InformeMedio::join("informe_parrafos","informe_parrafos.id","=","informe_medios.idParrafo")
                                                                ->join("informe_acciones","informe_acciones.id","=","informe_parrafos.informe_acciones_id")
                                                                ->where("informe_acciones.idTemaPED","=",$tema->idTemaPED)
                                                                ->where("informe_acciones.status","=",1)
                                                                ->where("informe_acciones.reporta4to","=",1)
                                                                ->get();
                                //obtenemos todos los parrafos redactados del tema
                                $parrafos_totales = InformeParrafo::join(
                                                                    'informe_acciones',
                                                                    'informe_acciones.id',
                                                                    '=',
                                                                    'informe_parrafos.informe_acciones_id',
                                                                )
                                                                    ->where(
                                                                        'informe_acciones.idTemaPED',
                                                                        $tema->idTemaPED,
                                                                    )
                                                                    ->where("informe_acciones.status","=",1)
                                                                    ->where("informe_acciones.reporta4to","=",1)
                                                                    ->get();
                                $parrafos_ordenados = 0;
                                $parrafos_sin_ordenar = 0;
                                foreach($parrafos_totales as $pa){
                                    if($pa->orden_ct === null)
                                        $parrafos_sin_ordenar += 1;
                                    else
                                        $parrafos_ordenados += 1;                                        
                                }
                            @endphp
                            <td style="vertical-align:middle">
                                @if ($parrafos_totales->count() > 0)
                                    <form action="{{route('informe.downloadword')}}" method="POST" class="padding:10px;">
                                        @csrf

                                            <input type="hidden" value="0" name="dependencia"/>
                                            <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>
                                            <input type="hidden" value="true" name="integrado"/>
                                            @if($parrafos_totales->count()>0)
                                                <button type="submit" class="btn btn-success" style="font-size:.8em;"><i class="fas fa-download"></i> Integrado</button>
                                            @endif
                                        </form>
                                @endif
                                <div
                                    style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align: ">
                                    ({{ $parrafos_totales->count() }}) p. totales
                                    <br/>
                                    <span style="color:green">({{ $parrafos_ordenados }})</span>
                                    <span style="color:red">({{ $parrafos_sin_ordenar }})</span>
                                </div>
                                @if($complementos->count()>0)
                                    <form action="{{route('informe.tema.getcomplementoszip')}}" target="_blank" method="POST">
                                        @csrf
                                        <input type="hidden" name="idTemaPED" value="{{$tema->idTemaPED}}">
                                        <button type="submit" class="btn btn-warning" ><i class="fas fa-download"></i> Complementos</button>
                                    </form>
                                @endif
                                <div style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align:">({{$complementos->count()}})Complementos</div>
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
                                <td id="temaestatus{{$tema->idTemaPED}}">                                    
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
                                                    @php
                                                        if (false){//$dependencia->tipo == 'CT') {
                                                            //obtenemos todos los parrafos redactados del tema
                                                            $parrafos = InformeParrafo::join(
                                                                'informe_acciones',
                                                                'informe_acciones.id',
                                                                '=',
                                                                'informe_parrafos.informe_acciones_id',
                                                            )
                                                                ->where(
                                                                    'informe_acciones.idTemaPED',
                                                                    $tema->idTemaPED,
                                                                )
                                                                ->where("informe_acciones.status","=",1)
                                                                ->where("informe_acciones.reporta4to","=",1)
                                                                ->get();
                                                        } else {
                                                            //obtenemos todos los parrafos redactados del tema y por dependencia
                                                            $parrafos = InformeParrafo::join(
                                                                'informe_acciones',
                                                                'informe_acciones.id',
                                                                '=',
                                                                'informe_parrafos.informe_acciones_id',
                                                            )
                                                                ->where(
                                                                    'informe_acciones.idTemaPED',
                                                                    $tema->idTemaPED,
                                                                )
                                                                ->where(
                                                                    'informe_acciones.idDependencia',
                                                                    $dependencia->idDependencia,
                                                                )
                                                                ->where("informe_acciones.status","=",1)
                                                                ->where("informe_acciones.reporta4to","=",1)
                                                                ->get();
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td style="width: 30%" data-title="{{ $dependencia->dependenciaNombre }}"
                                                            data-toggle="tooltip"
                                                            data-placement="top">{{ $dependencia->dependenciaSiglas }}</td>
                                                        <td
                                                            style="text-align:center;width: 10%;@if ($dependencia->tipo == 'P') background-color:gray;color:white @else background-color:black;color:white @endif">
                                                            {{ $dependencia->tipo }}</td>
                                                        <td>
                                                            @if ($parrafos->count() > 0 && $dependencia->bloqueado==1)
                                                                <i class="fas fa-circle" style="color:green" data-title="Info cargada y mandada a revisión por el enlace" data-toggle="tooltip" data-placement="top"></i>
                                                            @else
                                                                <i class="fas fa-circle" style="color:red" data-title="La Info no ha sido cargada y mandada a revisión por el enlace" data-toggle="tooltip" data-placement="top"></i>
                                                            @endif
                                                        </td>
                                                        <td style="width: 50%;text-align:center">                                                            
                                                            @if ($parrafos->count() > 0)
                                                            <form action="{{route('informe.downloadword')}}" method="POST" class="padding:10px;">
                                                                @csrf

                                                                    <input type="hidden" value="{{$dependencia->idDependencia}}" name="dependencia"/>
                                                                    <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>
                                                                    <input type="hidden" value="true" name="sinrol"/>                                                                    
                                                                    @if($parrafos->count()>0)
                                                                        <button type="submit" class="btn btn-primary" style="font-size:.8em;"><i class="fas fa-download"></i> Individual</button>
                                                                    @endif
                                                                </form>
                                                            @endif
                                                            <div
                                                                style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align: ">
                                                                ({{ $parrafos->count() }})
                                                                párrafos
                                                            </div>
                                                        </td>
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
                                @php
                                $complementos = InformeMedio::join("informe_parrafos","informe_parrafos.id","=","informe_medios.idParrafo")
                                                                ->join("informe_acciones","informe_acciones.id","=","informe_parrafos.informe_acciones_id")
                                                                ->where("informe_acciones.idTemaPED","=",$tema->idTemaPED)
                                                                ->where("informe_acciones.status","=",1)
                                                                ->where("informe_acciones.reporta4to","=",1)
                                                                ->get();
                                //obtenemos todos los parrafos redactados del tema
                                $parrafos_totales = InformeParrafo::join(
                                                                    'informe_acciones',
                                                                    'informe_acciones.id',
                                                                    '=',
                                                                    'informe_parrafos.informe_acciones_id',
                                                                )
                                                                    ->where(
                                                                        'informe_acciones.idTemaPED',
                                                                        $tema->idTemaPED,
                                                                    )
                                                                    ->where("informe_acciones.status","=",1)
                                                                    ->where("informe_acciones.reporta4to","=",1)
                                                                    ->get();
                                $parrafos_ordenados = 0;
                                $parrafos_sin_ordenar = 0;
                                foreach($parrafos_totales as $pa){
                                    if($pa->orden_ct === null)
                                        $parrafos_sin_ordenar += 1;
                                    else
                                        $parrafos_ordenados += 1;                                        
                                }
                            @endphp
                            <td style="vertical-align:middle">
                                @if ($parrafos_totales->count() > 0)
                                    <form action="{{route('informe.downloadword')}}" method="POST" class="padding:10px;">
                                        @csrf

                                            <input type="hidden" value="0" name="dependencia"/>
                                            <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>
                                            <input type="hidden" value="true" name="integrado"/>
                                            @if($parrafos_totales->count()>0)
                                                <button type="submit" class="btn btn-success" style="font-size:.8em;"><i class="fas fa-download"></i> Integrado</button>
                                            @endif
                                        </form>
                                @endif
                                <div
                                    style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align: ">
                                    ({{ $parrafos_totales->count() }}) p. totales
                                    <br/>
                                    <span style="color:green">({{ $parrafos_ordenados }})</span>
                                    <span style="color:red">({{ $parrafos_sin_ordenar }})</span>
                                </div>
                                @if($complementos->count()>0)
                                    <form action="{{route('informe.tema.getcomplementoszip')}}" target="_blank" method="POST">
                                        @csrf
                                        <input type="hidden" name="idTemaPED" value="{{$tema->idTemaPED}}">
                                        <button type="submit" class="btn btn-warning" ><i class="fas fa-download"></i> Complementos</button>
                                    </form>
                                @endif
                                <div style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align:">({{$complementos->count()}})Complementos</div>
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
                                <td id="temaestatus{{$tema->idTemaPED}}">                                    
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
                                                    @php
                                                        if (false){//$dependencia->tipo == 'CT') {
                                                            //obtenemos todos los parrafos redactados del tema
                                                            $parrafos = InformeParrafo::join(
                                                                'informe_acciones',
                                                                'informe_acciones.id',
                                                                '=',
                                                                'informe_parrafos.informe_acciones_id',
                                                            )
                                                                ->where(
                                                                    'informe_acciones.idTemaPED',
                                                                    $tema->idTemaPED,
                                                                )
                                                                ->where("informe_acciones.status","=",1)
                                                                ->where("informe_acciones.reporta4to","=",1)
                                                                ->get();
                                                        } else {
                                                            //obtenemos todos los parrafos redactados del tema y por dependencia
                                                            $parrafos = InformeParrafo::join(
                                                                'informe_acciones',
                                                                'informe_acciones.id',
                                                                '=',
                                                                'informe_parrafos.informe_acciones_id',
                                                            )
                                                                ->where(
                                                                    'informe_acciones.idTemaPED',
                                                                    $tema->idTemaPED,
                                                                )
                                                                ->where(
                                                                    'informe_acciones.idDependencia',
                                                                    $dependencia->idDependencia,
                                                                )
                                                                ->where("informe_acciones.status","=",1)
                                                                ->where("informe_acciones.reporta4to","=",1)
                                                                ->get();
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td style="width: 30%" data-title="{{ $dependencia->dependenciaNombre }}"
                                                            data-toggle="tooltip"
                                                            data-placement="top">{{ $dependencia->dependenciaSiglas }}</td>
                                                        <td
                                                            style="text-align:center;width: 10%;@if ($dependencia->tipo == 'P') background-color:gray;color:white @else background-color:black;color:white @endif">
                                                            {{ $dependencia->tipo }}</td>
                                                        <td>
                                                            @if ($parrafos->count() > 0 && $dependencia->bloqueado==1)
                                                                <i class="fas fa-circle" style="color:green" data-title="Info cargada y mandada a revisión por el enlace" data-toggle="tooltip" data-placement="top"></i>
                                                            @else
                                                                <i class="fas fa-circle" style="color:red" data-title="La Info no ha sido cargada y mandada a revisión por el enlace" data-toggle="tooltip" data-placement="top"></i>
                                                            @endif
                                                        </td>
                                                        <td style="width: 50%;text-align:center">                                                            
                                                            @if ($parrafos->count() > 0)
                                                            <form action="{{route('informe.downloadword')}}" method="POST" class="padding:10px;">
                                                                @csrf

                                                                    <input type="hidden" value="{{$dependencia->idDependencia}}" name="dependencia"/>
                                                                    <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>
                                                                    <input type="hidden" value="true" name="sinrol"/>                                                                    
                                                                    @if($parrafos->count()>0)
                                                                        <button type="submit" class="btn btn-primary" style="font-size:.8em;"><i class="fas fa-download"></i> Individual</button>
                                                                    @endif
                                                                </form>
                                                            @endif
                                                            <div
                                                                style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align: ">
                                                                ({{ $parrafos->count() }})
                                                                párrafos
                                                            </div>
                                                        </td>
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
                                @php
                                $complementos = InformeMedio::join("informe_parrafos","informe_parrafos.id","=","informe_medios.idParrafo")
                                                                ->join("informe_acciones","informe_acciones.id","=","informe_parrafos.informe_acciones_id")
                                                                ->where("informe_acciones.idTemaPED","=",$tema->idTemaPED)
                                                                ->where("informe_acciones.status","=",1)
                                                                ->where("informe_acciones.reporta4to","=",1)
                                                                ->get();
                                //obtenemos todos los parrafos redactados del tema
                                $parrafos_totales = InformeParrafo::join(
                                                                    'informe_acciones',
                                                                    'informe_acciones.id',
                                                                    '=',
                                                                    'informe_parrafos.informe_acciones_id',
                                                                )
                                                                    ->where(
                                                                        'informe_acciones.idTemaPED',
                                                                        $tema->idTemaPED,
                                                                    )
                                                                    ->where("informe_acciones.status","=",1)
                                                                    ->where("informe_acciones.reporta4to","=",1)
                                                                    ->get();
                                $parrafos_ordenados = 0;
                                $parrafos_sin_ordenar = 0;
                                foreach($parrafos_totales as $pa){
                                    if($pa->orden_ct === null)
                                        $parrafos_sin_ordenar += 1;
                                    else
                                        $parrafos_ordenados += 1;                                        
                                }
                            @endphp
                            <td style="vertical-align:middle">
                                @if ($parrafos_totales->count() > 0)
                                    <form action="{{route('informe.downloadword')}}" method="POST" class="padding:10px;">
                                        @csrf

                                            <input type="hidden" value="0" name="dependencia"/>
                                            <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>
                                            <input type="hidden" value="true" name="integrado"/>
                                            @if($parrafos_totales->count()>0)
                                                <button type="submit" class="btn btn-success" style="font-size:.8em;"><i class="fas fa-download"></i> Integrado</button>
                                            @endif
                                        </form>
                                @endif
                                <div
                                    style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align: ">
                                    ({{ $parrafos_totales->count() }}) p. totales
                                    <br/>
                                    <span style="color:green">({{ $parrafos_ordenados }})</span>
                                    <span style="color:red">({{ $parrafos_sin_ordenar }})</span>
                                </div>
                                @if($complementos->count()>0)
                                    <form action="{{route('informe.tema.getcomplementoszip')}}" target="_blank" method="POST">
                                        @csrf
                                        <input type="hidden" name="idTemaPED" value="{{$tema->idTemaPED}}">
                                        <button type="submit" class="btn btn-warning" ><i class="fas fa-download"></i> Complementos</button>
                                    </form>
                                @endif
                                <div style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align:">({{$complementos->count()}})Complementos</div>
                            </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-dependencias" role="tabpanel" aria-labelledby="nav-contact-tab">
                <center>
                    <div style="width: 100%;text-align:right;padding-right:80px;" class="d-flex justify-content-around">                        
                            <h4 style="color: green">Habilitados:<span id="habilitados">{{$hayalgunlibre->count()}}</span></h4>    
                            <h4 style="color: red">Deshabilitados:<span id="deshabilitados">{{$hayalgunbloqueo->count()}}</span></h4>    

                          
                            <button class="btn btn-success" onclick="bloqueodesbloqueo(0)">
                                <i class="fas fa-unlock" ></i>
                                Habilitar Todos
                            </button>
                          
                            <button class="btn btn-danger" onclick="bloqueodesbloqueo(1)">
                                <i class="fas fa-lock"></i>
                                Deshabilitar Todos
                            </button>
                          
                       
                        <a href="{{route('informe.cumplimiento')}}" target="_blank">                            
                            <button class="btn btn-success"><i class="fas fa-download"></i> Cumplimiento</button>
                        </a>
                    </div>
                    
                    <table class="table" style="width:90%" id="tableDependencias">
                        <thead>
                            <tr style="background-color: gray;color:white;vertical-align: middle">
                                <th style="display: none"">Dependencia</th>
                                <th>Dependencia</th>
                                <th>Temas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $ban = false;
                            @endphp
                            @foreach ($dependencias as $dependencia)
                                <tr style="background-color:{{ $ban ? 'rgb(245,245,245)' : 'white' }}">
                                    <td style="display: none">{{ $dependencia->dependenciaNombre }}</td>
                                    <td style="color:black;vertical-align:middle" data-title="{{ $dependencia->dependenciaNombre }}"
                                        data-toggle="tooltip"
                                        data-placement="top">
                                        <b>{{ $dependencia->dependenciaSiglas }}</b></td>
                                    @php
                                        //realizamos la consulta por dependencia y mostrarmos los temas en los cuales participa
                                        $temasd = MatrizCoordinacion::where(
                                            'dependencias_id',
                                            $dependencia->idDependencia,
                                        )
                                            ->where('informe', '2')
                                            ->join('temaped', 'temaped.idTemaPED', 'matriz_coordinacion.idTemaPED')
                                            ->get();
                                    @endphp
                                    <td>
                                        @if ($temasd->count() > 0)
                                            <table class="" style="width: 100%">
                                                <tbody>
                                                    @foreach ($temasd as $key => $tema)
                                                        @php
                                                            /*  if ($tema->tipo == 'CT') {
                                                                //obtenemos todos los parrafos redactados del tema
                                                                $parrafos = InformeParrafo::join(
                                                                    'informe_acciones',
                                                                    'informe_acciones.id',
                                                                    '=',
                                                                    'informe_parrafos.informe_acciones_id',
                                                                )
                                                                    ->where(
                                                                        'informe_acciones.idTemaPED',
                                                                        $tema->idTemaPED,
                                                                    )
                                                                    ->get();
                                                            } else {*/
                                                                //obtenemos todos los parrafos redactados del tema y por dependencia
                                                                $parrafos = InformeParrafo::join(
                                                                    'informe_acciones',
                                                                    'informe_acciones.id',
                                                                    '=',
                                                                    'informe_parrafos.informe_acciones_id',
                                                                )
                                                                    ->where(
                                                                        'informe_acciones.idTemaPED',
                                                                        $tema->idTemaPED,
                                                                    )
                                                                    ->where(
                                                                        'informe_acciones.idDependencia',
                                                                        $tema->dependencias_id,
                                                                    )
                                                                    ->where("informe_acciones.status","=",1)
                                                                    ->where("informe_acciones.reporta4to","=",1)
                                                                    ->get();

                                                                $lastUpdated    =    InformeParrafo::select("informe_parrafos.updated_at as actualizacion")
                                                                ->join(
                                                                    'informe_acciones',
                                                                    'informe_acciones.id',
                                                                    '=',
                                                                    'informe_parrafos.informe_acciones_id',
                                                                )
                                                                    ->where(
                                                                        'informe_acciones.idTemaPED',
                                                                        $tema->idTemaPED,
                                                                    )
                                                                    ->where(
                                                                        'informe_acciones.idDependencia',
                                                                        $tema->dependencias_id,
                                                                    )
                                                                    ->where("informe_acciones.status","=",1)
                                                                    ->where("informe_acciones.reporta4to","=",1)
                                                                    ->latest("informe_parrafos.updated_at")->first();

                                                            //}
                                                        @endphp
                                                        <tr>
                                                            <td id="bloqueo{{$tema->dependencias_id.$tema->idTemaPED.$tema->informe}}">
                                                                @if($tema->bloqueado)
                                                                    <i class="fas fa-lock" style="color: red;cursor:pointer" onclick="bloqueoTema({{$tema->dependencias_id.','.$tema->idTemaPED.','.$tema->informe}},0)"></i>
                                                                @else
                                                                    <i class="fas fa-unlock" style="color: green;cursor:pointer" onclick="bloqueoTema({{$tema->dependencias_id.','.$tema->idTemaPED.','.$tema->informe}},1)"></i>
                                                                @endif
                                                            </td>
                                                            <td style="width: 50%">
                                                                {{ $tema->temaPEDClave . ' ' . $tema->temaPEDDescripcion }}
                                                            </td>
                                                            <td
                                                                style="text-align:center;width: 5%;background-color: @if ($tema->tipo == 'P') gray @else black @endif; color:white">
                                                                {{ $tema->tipo }}</td>
                                                            <td>
                                                                @if ($parrafos->count() > 0 && $tema->bloqueado==1)
                                                                    <i class="fas fa-circle" style="color:green" data-title="Info cargada y mandada a revisión por el enlace" data-toggle="tooltip" data-placement="top"></i>
                                                                @else
                                                                    <i class="fas fa-circle" style="color:red" data-title="La Info no ha sido cargada y mandada a revisión por el enlace" data-toggle="tooltip" data-placement="top"></i>
                                                                @endif
                                                            </td>
                                                            <td style="width: 25%;text-align:center">                                                                
                                                                @if ($parrafos->count() > 0)
                                                                <form action="{{route('informe.downloadword')}}" method="POST" class="padding:10px;">
                                                                    @csrf
                                                                        <input type="hidden" value="{{$tema->dependencias_id}}" name="dependencia"/>
                                                                        <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>
                                                                        <input type="hidden" value="true" name="sinrol"/>
                                                                        @if($parrafos->count()>0)
                                                                            <button type="submit" class="btn btn-primary" style="font-size:.8em;"><i class="fas fa-download"></i> Individual</button>
                                                                        @endif
                                                                    </form>
                                                                @endif
                                                                <div
                                                                    style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic;text-align: ">
                                                                    ({{ $parrafos->count() }})
                                                                    párrafos
                                                                </div>
                                                            </td>
                                                            <td style="vertical-align: middle;text-align:center;width:25%">
                                                                <span style="font-size: .7em;font-style:italic">
                                                                    Fecha actualización: <br/> {{$lastUpdated != null?$lastUpdated->actualizacion:""}}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <div class="alert alert-info">No existen temas relacionados a esta dependencia!
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $ban = !$ban;
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
        $(document).ready(function() {
            $("#collapseInforme").addClass("show");
            $("#informecarga").css('background-color', "rgb(217, 217, 217)");

            $('#tableDependencias thead tr')
                .clone(true)
                .addClass('filters')
                .appendTo('#tableDependencias thead');

            dt = $('#tableDependencias').DataTable({
                pageLength: 100,
                lengthMenu: [100],
                paging:false,
                searching:true,
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
                            if (colIdx != 4) {
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
            $("#tableDependencias_filter").hide();
            getTablesEstatus();
        });
        function bloqueoTema(idDependencia,idTemaPED,informe,valor){
            inicial = $("#bloqueo"+idDependencia+''+idTemaPED+''+informe).html();
            $.ajax({
                type: 'POST',
                url: "{{ route('informe.bloqueotema') }}",
                data: {
                    idDependencia: idDependencia,
                    idTemaPED:idTemaPED,
                    informe:informe,
                    valor:valor,
                    _token: $("input[name='_token']").val()
                },
                dataType: 'json',
                beforeSend: function() {
                    $("#bloqueo"+idDependencia+''+idTemaPED+''+informe).html('<i class="fas fa-spinner fa-spin"></i>');
                    block(true)
                },
                success: function(response) {
                        if(response.result=="ok"){
                            if(valor==1){
                                $("#bloqueo"+idDependencia+''+idTemaPED+''+informe).html('<i class="fas fa-lock" style="color: red;cursor:pointer" onclick="bloqueoTema('+idDependencia+','+idTemaPED+','+informe+',0)"></i>')
                            }else{
                                $("#bloqueo"+idDependencia+''+idTemaPED+''+informe).html('<i class="fas fa-unlock" style="color: green;cursor:pointer" onclick="bloqueoTema('+idDependencia+','+idTemaPED+','+informe+',1)"></i>')
                            }
                            loadResumenBloDes();
                            getTablesEstatus();
                        }else{
                            $("#bloqueo"+idDependencia+''+idTemaPED+''+informe).html(inicial);
                        }
                }
            }).done(function(response) {
                block(false);
            }).fail(function(data) {
                block(false);
                $("#bloqueo"+idDependencia+''+idTemaPED+''+informe).html(inicial);
            })
        }

        function bloqueodesbloqueo(bloqueo){
            Swal.fire({
            title: 'Cambiar Estatus de captura',
            text: bloqueo==1? '¿Desea bloquear la captura para todos los temas de todas las dependencias?': '¿Desea desbloquear la captura para todos los temas de todas las dependencias?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F59C49',
            confirmButtonText: 'Sí '+(bloqueo==1?"bloquear":"desbloquear"),
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                    $.ajax({
                    type: 'POST',
                    url: "{{ route('informe.bloqueodesbloqueo') }}",
                    data: {
                        valor:bloqueo,
                        _token: $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        //$("#bloqueo"+idDependencia+''+idTemaPED+''+informe).html('<i class="fas fa-spinner fa-spin"></i>');
                        //block(true)
                    },
                    success: function(response) {
                            if(response.result=="ok"){                                    
                                setTimeout(() => {
                                 loadResumenBloDes();    
                                }, 300);
                            }
                    }
                }).done(function(response) {
                    //block(false);
                }).fail(function(data) {
                    //block(false);
                    //$("#bloqueo"+idDependencia+''+idTemaPED+''+informe).html(inicial);
                })
            }
        });
    }
    function loadResumenBloDes(){
        $.ajax({
                    type: 'GET',
                    url: "{{ route('informe.getresumenblodes') }}",                    
                    dataType: 'json',
                    beforeSend: function() {
                        //$("#bloqueo"+idDependencia+''+idTemaPED+''+informe).html('<i class="fas fa-spinner fa-spin"></i>');
                        $("#habilitados").html('');
                        $("#deshabilitados").html('');
                        block(true)
                    },
                    success: function(response) {
                            if(response.result=="ok"){                                
                               $("#habilitados").html(response.habilitados);
                               $("#deshabilitados").html(response.deshabilitados);
                               response.todos.forEach(function(e){
                                dependencias_id = e.dependencias_id;
                                tema = e.idTemaPED;
                                informe = e.informe;
                                bloqueado = e.bloqueado;
                                if(bloqueado==1)
                                    $("#bloqueo"+dependencias_id+tema+informe).html('<i class="fas fa-lock" style="color: red;cursor:pointer" onclick="bloqueoTema('+dependencias_id+','+tema+','+informe+',0)"></i>')
                                else
                                    $("#bloqueo"+dependencias_id+tema+informe).html('<i class="fas fa-lock" style="color: green;cursor:pointer" onclick="bloqueoTema('+dependencias_id+','+tema+','+informe+',1)"></i>')
                               })
                            }
                    }
                }).done(function(response) {
                    block(false);
                }).fail(function(data) {
                    block(false);
                    //$("#bloqueo"+idDependencia+''+idTemaPED+''+informe).html(inicial);
                })
    }
    function getTablesEstatus(){
        $.ajax({
                    type: 'GET',
                    url: "{{ route('informe.gettablesestatus') }}",                           
                    dataType: 'json',
                    beforeSend: function() {
                        //$("#bloqueo"+idDependencia+''+idTemaPED+''+informe).html('<i class="fas fa-spinner fa-spin"></i>');                        
                        //block(true)
                    },
                    success: function(response) {
                            if(response.result=="ok"){                                
                               response.tables.forEach(function(re){

                                button = '<button class="btn btn-light" style="font-size:.8em" onclick="bloDesTema('+re.idTemaPED+',1)"><i class="fas fa-unlock" style="color: green;font-size:2em"></i> Bloquear todas</button>';                                
                                if(re.desbloqueado==0)
                                    button = '<button class="btn btn-light" style="font-size:.8em" onclick="bloDesTema('+re.idTemaPED+',0)"><i class="fas fa-lock" style="color: red;font-size:2em"></i> Desbloquear todas</button>';
                                
                                if(re.bloqueado==0)
                                    button = '<button class="btn btn-light" style="font-size:.8em" onclick="bloDesTema('+re.idTemaPED+',1)"><i class="fas fa-unlock" style="color: green;font-size:2em"></i> Bloquear todas</button>';
                                


                                table = '<table class="table table-striped" style="font-size: .8em">'+
                                        '<thead>'+
                                            '<tr>'+
                                                '<td colspan="2" style="text-align: center">'+button+'</td>'+
                                            '</tr>'+
                                        '</thead>'+
                                        '<tbody>'+
                                            '<tr style="text-align: center">'+
                                                '<td>Bloqueadas</td>'+
                                                '<td>Desbloqueadas</td>'+
                                            '</tr>'+
                                            '<tr style="text-align: center">'+
                                                '<td style="color:red">'+re.bloqueado+'</td>'+
                                                '<td style="color:green">'+re.desbloqueado+'</td>'+ 
                                            '</tr>'+                                 
                                        '</tbody>'+
                                    '</table>'
                                $("#temaestatus"+re.idTemaPED).html(table);                                
                               })
                            }
                    }
                }).done(function(response) {
                    //block(false);
                }).fail(function(data) {
                    //block(false);
                    //$("#bloqueo"+idDependencia+''+idTemaPED+''+informe).html(inicial);
                })
    }

    function bloDesTema(tema,bloqueo){
        bloq=bloqueo==1?"bloquear":"desbloquear";
        Swal.fire({
            title: bloqueo==1?'Bloqueo de tema, bloqueo de dependencias participantes':'Desbloqueo de tema, desbloqueo de dependencias participantes',
            text: '¿Desea '+bloq+' la captura para este tema?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F59C49',
            confirmButtonText: 'Sí '+(bloqueo==1?"bloquear":"desbloquear"),
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            $.ajax({
                    type: 'POST',
                    url: "{{ route('informe.bloqueodesbloqueotema') }}",
                    data: {
                        bloqueo:bloqueo,
                        tema:tema,
                        _token: $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        //$("#bloqueo"+idDependencia+''+idTemaPED+''+informe).html('<i class="fas fa-spinner fa-spin"></i>');
                        //block(true)
                    },
                    success: function(response) {
                            if(response.result=="ok"){                                    
                                setTimeout(() => {
                                 getTablesEstatus();    
                                }, 300);
                                setTimeout(()=>{
                                    window.location.reload();
                                },300)
                            }
                    }
                }).done(function(response) {
                    //block(false);
                }).fail(function(data) {
                    //block(false);
                    //$("#bloqueo"+idDependencia+''+idTemaPED+''+informe).html(inicial);
                })

        })       
    }
    </script>
@endsection
