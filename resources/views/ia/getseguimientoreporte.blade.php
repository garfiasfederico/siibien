@php
    use App\Models\IAFuente;
@endphp
@if($presupuestoGeneral->aplica == 1)
<div style="text-align: right;margin:15px;">
<a target="_blank" href="{{route('ia.itaranualreporte',['anio' => $anio,"idPPA" => $idPPA])}}"><button class="btn" style="background-color: rgb(75,90,137);color:white"><i class="fas fa-download"></i> Ficha {{$anio}}</button></a>
<a target="_blank" href="{{route('ia.itartrimestral',['anio' => $anio,"idPPA" => $idPPA,"trim" => 1])}}"><button class="btn" style="background-color: rgb(167,176,207);color:white"><i class="fas fa-download"></i> Ficha 1er trimestre</button></a>
<a target="_blank" href="{{route('ia.itartrimestral',['anio' => $anio,"idPPA" => $idPPA,"trim" => 2])}}"><button class="btn" style="background-color: rgb(167,176,207);color:white"><i class="fas fa-download"></i> Ficha 2do trimestre</button></a>
<a target="_blank" href="{{route('ia.itartrimestral',['anio' => $anio,"idPPA" => $idPPA,"trim" => 3])}}"><button class="btn" style="background-color: rgb(167,176,207);color:white"><i class="fas fa-download"></i> Ficha 3er trimestre</button></a>
<a target="_blank" href="{{route('ia.itartrimestral',['anio' => $anio,"idPPA" => $idPPA,"trim" => 4])}}"><button class="btn" style="background-color: rgb(167,176,207);color:white"><i class="fas fa-download"></i> Ficha 4to trimestre</button></a>
</div>
<div class="row">
{{-- <div class="col-xl-6 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background-color: rgb(75,90,137);">
            <h6 class="m-0 font-weight-bold text-primary" style="color:white !important;cursor: pointer;" onclick="toggle('chevpresupuesto','body-presupuesto')">Presupuesto general por año <i class="fas fa-chevron-down"
                id="chevpresupuesto"></i></h6>
            <div class="dropdown no-arrow">
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body" id="body-presupuesto">
            @if($presupuesto->count()>0)
                @php
                    $gasto_operativo_ids = array();
                    $gasto_inversion_ids = array();
                    $gasto_operativo_nombres = array();
                    $gasto_inversion_nombres = array();
                    foreach($presupuesto  as $pre){
                        if($pre->tipo_gasto=="operativo" && $pre->pp_id!=null){
                            array_push($gasto_operativo_ids,$pre->id);
                            array_push($gasto_operativo_nombres,$pre->clavePrograma." ".$pre->descripcionPrograma);
                        }

                        if($pre->tipo_gasto=="inversion" && $pre->pp_id!=null){
                            array_push($gasto_inversion_ids,$pre->id);
                            array_push($gasto_inversion_nombres,$pre->clavePrograma." ".$pre->descripcionPrograma);
                        }
                    }
                @endphp
                @if(count($gasto_operativo_ids)>0)
                    <h4>Gasto operativo</h4>
                    <table style="width: 100%">
                    @foreach ($gasto_operativo_nombres as $key => $gastoop )
                            <tr>
                                <td class="enc5">Programa Presupuestario</td>
                                <td class="enc6">{{$gastoop}}</td>
                            </tr>                        
                            <tr>
                                <td colspan="2" class="enc5" style="text-align: center">Fuentes de Financiamiento</td>
                            </tr>

                            @php
                                //obtenemos las fuentes de financiamiento
                                $fuentes = IAFuente::where("ia_presupuesto_tipog_id",$gasto_operativo_ids[$key])
                                            ->join("fuente_financiamiento","fuente_financiamiento.idFuente","=","ia_fuente.fuente_id")
                                            ->get();
                            @endphp
                            @if($fuentes->count()>0)
                                <tr>
                                    <td colspan="2" style="">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th class="enc5" style="text-align: center">Fuente</th>
                                                    <th class="enc5" style="text-align: center">Monto Federal</th>
                                                    <th class="enc5" style="text-align: center">Monto Estatal</th>
                                                    <th class="enc5" style="text-align: center">Monto Municipal</th>
                                                    <th class="enc5" style="text-align: center">Monto Total</th>
                                                </tr>
                                                @foreach ($fuentes as $fuente )
                                                <tr>
                                                    <td class="enc6">{{$fuente->fuente}}</td>
                                                    <td class="enc6" style="text-align: right">$ {{number_format($fuente->monto_federal,2)}}</td>
                                                    <td class="enc6" style="text-align: right">$ {{number_format($fuente->monto_estatal,2)}}</td>
                                                    <td class="enc6" style="text-align: right">$ {{number_format($fuente->monto_municipa,2)}}</td>
                                                    <td class="enc6" style="text-align: right">$ {{number_format($fuente->monto_total,2)}}</td>
                                                </tr>    
                                                @endforeach
                                            </thead>
                                        </table>
                                    </td>
                                </tr>
                            @else
                            <tr>
                                <td colspan="2" style="">
                                    <div class="alert alert-info" style="text-align: center">No existen fuentes de financiamiento registradas para este programa!</div>
                                </td>
                            </tr>
                                
                            @endif

                    @endforeach
                    </table>
                @endif
                @if(count($gasto_inversion_ids)>0)
                    <h4>Gasto de inversión</h4>
                    <table style="width: 100%">
                    @foreach ($gasto_inversion_nombres as $key => $gastoin )
                            <tr>
                                <td class="enc5">Programa Presupuestario</td>
                                <td class="enc6">{{$gastoin}}</td>
                            </tr>                        
                            <tr>
                                <td colspan="2" class="enc5" style="text-align: center">Fuentes de Financiamiento</td>
                            </tr>

                            @php
                                //obtenemos las fuentes de financiamiento
                                $fuentes = IAFuente::where("ia_presupuesto_tipog_id",$gasto_inversion_ids[$key])
                                            ->join("fuente_financiamiento","fuente_financiamiento.idFuente","=","ia_fuente.fuente_id")
                                            ->get();
                            @endphp
                            @if($fuentes->count()>0)
                                <tr>
                                    <td colspan="2" style="">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th class="enc5" style="text-align: center">Fuente</th>
                                                    <th class="enc5" style="text-align: center">Monto Federal</th>
                                                    <th class="enc5" style="text-align: center">Monto Estatal</th>
                                                    <th class="enc5" style="text-align: center">Monto Municipal</th>
                                                    <th class="enc5" style="text-align: center">Monto Total</th>
                                                </tr>
                                                @foreach ($fuentes as $fuente )
                                                <tr>
                                                    <td class="enc6">{{$fuente->fuente}}</td>
                                                    <td class="enc6" style="text-align: right">$ {{number_format($fuente->monto_federal,2)}}</td>
                                                    <td class="enc6" style="text-align: right">$ {{number_format($fuente->monto_estatal,2)}}</td>
                                                    <td class="enc6" style="text-align: right">$ {{number_format($fuente->monto_municipa,2)}}</td>
                                                    <td class="enc6" style="text-align: right">$ {{number_format($fuente->monto_total,2)}}</td>
                                                </tr>    
                                                @endforeach
                                            </thead>
                                        </table>
                                    </td>
                                </tr>
                            @else
                            <tr>
                                <td colspan="2" style="">
                                    <div class="alert alert-info" style="text-align: center">No existen fuentes de financiamiento registradas para este programa!</div>
                                </td>
                            </tr>                                
                            @endif
                    @endforeach
                    </table>
                @endif
            @endif
        </div>
    </div>
</div> --}}
<div class="col-xl-6 col-lg-7">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background-color: rgb(75,90,137);">
            <h6 class="m-0 font-weight-bold text-primary" style="color:white !important;cursor: pointer;"
                onclick="toggle('chevpresupuesto','body-presupuesto')">
                Presupuesto general por año
                <i class="fas fa-chevron-down" id="chevpresupuesto"></i>
            </h6>
            <div class="dropdown no-arrow"></div>
        </div>

        <div class="card-body" id="body-presupuesto">
            @if($presupuesto->count() > 0)

                @foreach($presupuesto->groupBy('pp_id') as $pp_id => $registros)
                    @if(!$pp_id) @continue @endif

                    @php
                        $operativo = $registros->where('tipo_gasto','operativo')->first();
                        $inversion = $registros->where('tipo_gasto','inversion')->first();
                    @endphp

                    <table style="width: 100%; margin-bottom:20px;">
                        <tr>
                            <td class="enc5">Programa Presupuestario</td>
                            <td class="enc6">
                                {{ $operativo->clavePrograma ?? $inversion->clavePrograma }}
                                {{ $operativo->descripcionPrograma ?? $inversion->descripcionPrograma }}
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2" class="enc5" style="text-align:center">Detalle de gasto</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th class="enc5" style="width:30%">Tipo de gasto</th>
                                            <th class="enc5" style="width:35%">Estado</th>
                                            <th class="enc5" style="width:35%; text-align:right">Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($operativo && $operativo->aplica)
                                        <tr>
                                            <td class="enc6">Operativo</td>
                                            <td class="enc6">
                                                @if($operativo->estatus == 0) No aplica
                                                @elseif($operativo->estatus == 1) No disponible
                                                @elseif($operativo->estatus == 2) Aplica
                                                @endif
                                            </td>
                                            <td class="enc6" style="text-align:right">
                                                @if($operativo->estatus == 2)
                                                    $ {{ number_format($operativo->monto,2) }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                        </tr>
                                        @endif

                                        @if($inversion && $inversion->aplica)
                                        <tr>
                                            <td class="enc6">Inversión</td>
                                            <td class="enc6">
                                                @if($inversion->estatus == 0) No aplica
                                                @elseif($inversion->estatus == 1) No disponible
                                                @elseif($inversion->estatus == 2) Aplica
                                                @endif
                                            </td>
                                            <td class="enc6" style="text-align:right">
                                                @if($inversion->estatus == 2)
                                                    $ {{ number_format($inversion->monto,2) }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>

                @endforeach

            @else
                <div class="alert alert-info" style="text-align:center">
                    No existe información de presupuesto para este año.
                </div>
            @endif
        </div>
    </div>
</div>
<div class="col-xl-6 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background-color: rgb(75,90,137);">
            <h6 class="m-0 font-weight-bold text-primary" style="color:white !important;cursor: pointer;" onclick="toggle('chevpob','body-pob')">Población o área de enfoque <i class="fas fa-chevron-down"
                id="chevpob"></i></h6>
            <div class="dropdown no-arrow">
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body" id="body-pob">
            @if($poblacion!=null)                       
                        @if(str_contains($poblacion->tipo,"p_"))    
                        <h4><i class="fas fa-users"></i> Población Objetivo (meta anual)</h4>                        
                            <table style="width:100%">
                                <tr>
                                    <td class="enc5" style="width:15%;border:1px solid gray">
                                        Tipo de población:
                                    </td>
                                    <td class="enc6" style="border:1px solid gray;font-size:1.3em">
                                       {{$poblacion->descripcion}} 
                                    </td>
                                    <td class="enc5" style="width:15%;border:1px solid gray">
                                        Descripción de la población objetivo:
                                    </td>
                                    <td class="enc6" style="border:1px solid gray;font-size:1.3em">
                                       {{$poblacion->descripcion_poblacion}} 
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td colspan="4" style="border:1px solid gray">
                                        <table style="width: 100%">
                                            <tr>
                                                <td class="enc5" style="width: 15%" >Mujeres:</td>
                                                <td class="enc6" style="font-size: 1.5em;color:black;text-align:center">                                                    
                                                    @if($infoP != null ){{number_format($infoP->mujeres,0)}}@endif
                                                    
                                                </td>
                                                <td class="enc5" style="width: 15%;" >Hombres:</td>
                                                <td class="enc6" style="font-size: 1.5em;color:black;text-align:center">                                                    
                                                    @if($infoP != null ){{number_format($infoP->hombres,0)}}@endif                                                   
                                                </td>
                                                <td class="enc5" style="width: 15%;" >Total:</td>
                                                <td class="enc6" style="font-size: 1.5em;color:black;text-align:center">                                                    
                                                    @if($infoP != null ){{number_format($infoP->total,0)}}@endif
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                            </table>
                        @endif
                        @if(str_contains($poblacion->tipo,"a_"))  
                        <br/>
                        <h4><i class="fas fa-check"></i> Área de enfoque objetivo</h4>                        
                        <table style="width:100%">
                            <tr>
                                <td class="enc5" style="width:15%;border:1px solid gray">
                                    Nombre del área de enfoque:
                                </td>
                                <td class="enc6" style="border:1px solid gray;font-size:1.3em">
                                   {{$poblacion->nombre_enfoque}} 
                                </td>
                                <td class="enc5" style="width:15%;border:1px solid gray">
                                    Descripción del área de enfoque:
                                </td>
                                <td class="enc6" style="border:1px solid gray;font-size:1.3em">
                                   {{$poblacion->descripcion_area}} 
                                </td>                                    
                            </tr>
                            <tr>
                                <td colspan="4" style="border:1px solid gray">
                                    <table style="width: 100%">
                                        <tr>
                                            <td class="enc5" style="width: 15%" >Meta anual:</td>
                                            <td class="enc6" style="font-size: 1.5em;color:black;text-align:center">                                                
                                                @if($infoP != null ){{number_format($infoP->total_area,0)}}@endif                                               
                                            </td>
                                            <td style="width: 70%"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        @endif
                    @else
                        <div class="alert alert-info">No existe población o área de enfoque asociada a este PPA!</div>
                    @endif
        </div>
    </div>
</div>
<div class="col-xl-6 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background-color: rgb(75,90,137);">
            <h6 class="m-0 font-weight-bold text-primary" style="color:white !important;cursor: pointer;" onclick="toggle('chevimpacto','body-impacto')">Impacto esperado <i class="fas fa-chevron-down"
                id="chevimpacto"></i></h6>
            <div class="dropdown no-arrow">
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body" id="body-impacto">
            <table style="width:100%">
                <tr>
                    <td class="enc5" style="width: 15%;border:solid 1px gray;">Tipo de Impacto</td>
                    <td class="enc6" style="border:solid 1px gray;">
                        <table style="width: 100%">
                            <tr>
                                <td style="text-align: center;font-size:1.3em"><i class="fas fa-users"></i> <input type="checkbox"  readonly disabled style="transform: scale(1.3);color:aquamarine" @if($infoP!=null) @if(str_contains($infoP->impacto_esperado, 'social')) checked @endif @endif> Social</td>
                                <td style="text-align: center;font-size:1.3em"><i class="fas fa-dollar-sign"> </i> <input type="checkbox" readonly disabled  style="transform: scale(1.3)" @if($infoP!=null) @if(str_contains($infoP->impacto_esperado, 'economico')) checked @endif @endif> Económico</td>
                                <td style="text-align: center;font-size:1.3em"><i class="fas fa-tree"></i> <input type="checkbox" readonly  disabled style="transform: scale(1.3)" @if($infoP!=null) @if(str_contains($infoP->impacto_esperado, 'ambiental')) checked @endif @endif> Ambiental</td>
                            </tr>                            
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="enc5" style="width: 15%;border:solid 1px gray;">Descripción del impacto</td>
                    <td class="enc6" style="border:solid 1px gray;">
                        @if($infoP!=null){{$infoP->descripcion_impacto}}@endif                      
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="col-xl-6 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background-color: rgb(75,90,137);">
            <h6 class="m-0 font-weight-bold text-primary" style="color:white !important;cursor: pointer;" onclick="toggle('chevmonitoreo','body-monitoreo')">Monitoreo por bien o servicio <i class="fas fa-chevron-down"
                id="chevmonitoreo"></i></h6>
            <div class="dropdown no-arrow">
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body" id="body-monitoreo">
            <center>
                <div class="row" id="row-bss">
            @if($bss->count()>0)                
                    @foreach($bss as $bs)
                        <div class="col-md" style="padding-top:20px;
                                                                border:solid 1px green;
                                                                color:{{ $bs->aplica_estado === 0 ? 'gray' : 'black' }};
                                                                background-color:{{ $bs->aplica_estado === 0 ? '#f0f0f0' : 'rgb(236, 236, 236)' }};
                                                                margin:10px;
                                                                cursor:{{ $bs->aplica_estado === 0 ? 'not-allowed' : 'pointer' }};"
                            @if($bs->aplica_estado !== 0) @if($bs->status) onclick="getInfoMonitoreo({{ $bs->idBS }})"
                                onmouseover="$(this).css('color','blue');$(this).css('background-color','white');"
                            onmouseout="$(this).css('color','black');$(this).css('background-color','rgb(236, 236, 236)');" @endif @endif>
                            @if(!$bs->status)
                                <div class="alert alert-warning" style="text-align: center;width:100%;position:absolute;top:0px;left:0px">
                                    Baja
                                </div>
                            @endif
                            <h4>{{ $bs->nombreBS }}</h4>
                            <p style="font-size:.8em; text-align:justify">{{ $bs->descripcionBS }}</p>
                            <div style="text-align: right;font-size:.7em">({{ $bs->unidad_medidaBS }})</div>

                            @if($bs->aplica_estado === 0)
                                <div class="text-danger" style="font-size: 0.8em;"><i class="fas fa-ban"></i> No aplica en {{ $anio }}</div>

                            @endif
                        </div>
                    @endforeach

                </div>
                <div id="monitoreo-bs" style="display: none; text-align:left;width:100%">
                    
                </div>
            </center>
            @else 
                <div class="alert alert-info" style="text-align: center">No existen bienes o servicios definidos para este PPA</div>
            @endif
        </div>
    </div>
</div>
<div class="col-xl-6 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background-color: rgb(75,90,137);">
            <h6 class="m-0 font-weight-bold text-primary" style="color:white !important;cursor: pointer;" onclick="toggle('chevmedios','body-medios')">Ejemplos para difusión cargados <i class="fas fa-chevron-down"
                id="chevmedios"></i></h6>
            <div class="dropdown no-arrow">
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body" id="body-medios">
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="">
                <a class="nav-item nav-link active" id="nav-1er-tab" data-toggle="tab" href="#nav-primer"
                    role="tab" aria-controls="nav-primer" aria-selected="true">1er. Trimestre</a>
                <a class="nav-item nav-link " id="nav-2do-tab" data-toggle="tab" href="#nav-segundo"
                    role="tab" aria-controls="nav-segundo" aria-selected="true">2do. Trimestre</a>
                <a class="nav-item nav-link " id="nav-3er-tab" data-toggle="tab" href="#nav-tercero"
                    role="tab" aria-controls="nav-tercero" aria-selected="true">3er. Trimestre</a>
                <a class="nav-item nav-link " id="nav-4to-tab" data-toggle="tab" href="#nav-cuarto"
                    role="tab" aria-controls="nav-cuarto" aria-selected="true">4to. Trimestre</a>
            </div>
            <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-primer" role="tabpanel" aria-labelledby="nav-1er-tab" style="margin: 15px;">   
                @if($medios1->count()>0)
                <table style="width: 100%">
                    <thead>
                        <tr>
                            <th class="enc5" style="display: none">Id</th>
                            <th class="enc5" style="text-align:center">Archivo cargado</th>
                            <th class="enc5" style="text-align:center">Descripcion</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($medios1 as $medio )
                        <tr id="rowmedio{{$medio->idMedio}}" idMedio="{{$medio->idMedio}}" class="medioia">
                            <td class="enc6">
                                <a target="blank_" href="{{ asset('medios') }}/itar/{{$medio->ia_id}}/{{$medio->anio}}/{{$medio->trimestre}}/{{$medio->archivo}}">{{$medio->nombre}}</a>                
                            <td class="enc6">{{$medio->descripcion}}</td>                            
                        </tr>    
                        @endforeach
                    </tbody>   
                </table>
                @else                        
                    <div class="alert alert-info" style="text-align: center;margin:10px;">No existen medios de verificación cargados en este trimestre</div>                        
                @endif                     
                </div>
                <div class="tab-pane fade show" id="nav-segundo" role="tabpanel" aria-labelledby="nav-2do-tab">  
                    @if($medios2->count()>0)
                    <table style="width: 100%">
                        <thead>
                            <tr>
                                <th class="enc5" style="display: none">Id</th>
                                <th class="enc5" style="text-align:center">Archivo cargado</th>
                                <th class="enc5" style="text-align:center">Descripcion</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($medios2 as $medio )
                            <tr id="rowmedio{{$medio->idMedio}}" idMedio="{{$medio->idMedio}}" class="medioia">
                                <td class="enc6">
                                    <a target="blank_" href="{{ asset('medios') }}/itar/{{$medio->ia_id}}/{{$medio->anio}}/{{$medio->trimestre}}/{{$medio->archivo}}">{{$medio->nombre}}</a>                
                                <td class="enc6">{{$medio->descripcion}}</td>                                
                            </tr>    
                            @endforeach
                        </tbody>   
                    </table>
                    @else                        
                        <div class="alert alert-info" style="text-align: center;margin:10px;">No existen medios de verificación cargados en este trimestre</div>                        
                    @endif                   
                   
                </div>
                <div class="tab-pane fade show" id="nav-tercero" role="tabpanel" aria-labelledby="nav-3er-tab">                    
                    @if($medios3->count()>0)
                    <table style="width: 100%">
                        <thead>
                            <tr>
                                <th class="enc5" style="display: none">Id</th>
                                <th class="enc5" style="text-align:center">Archivo cargado</th>
                                <th class="enc5" style="text-align:center">Descripcion</th>                            
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($medios3 as $medio )
                            <tr id="rowmedio{{$medio->idMedio}}" idMedio="{{$medio->idMedio}}" class="medioia">
                                <td class="enc6">
                                    <a target="blank_" href="{{ asset('medios') }}/itar/{{$medio->ia_id}}/{{$medio->anio}}/{{$medio->trimestre}}/{{$medio->archivo}}">{{$medio->nombre}}</a>                
                                <td class="enc6">{{$medio->descripcion}}</td>                            
                            </tr>    
                            @endforeach
                        </tbody>   
                    </table>
                    @else                        
                        <div class="alert alert-info" style="text-align: center;margin:10px;">No existen medios de verificación cargados en este trimestre</div>                        
                    @endif                     
                </div>
                <div class="tab-pane fade show" id="nav-cuarto" role="tabpanel" aria-labelledby="nav-2do-tab" style="margin: 15px;">  
                        @if($medios4->count()>0)
                        <table style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="enc5" style="display: none">Id</th>
                                    <th class="enc5" style="text-align:center">Archivo cargado</th>  
                                    <th class="enc5" style="text-align:center">Descripcion</th>                                                              
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($medios4 as $medio )
                                <tr id="rowmedio{{$medio->idMedio}}" idMedio="{{$medio->idMedio}}" class="medioia">
                                    <td class="enc6">
                                        <a target="blank_" href="{{ asset('medios') }}/itar/{{$medio->ia_id}}/{{$medio->anio}}/{{$medio->trimestre}}/{{$medio->archivo}}">{{$medio->nombre}}</a>                
                                    <td class="enc6">{{$medio->descripcion}}</td>                                
                                </tr>    
                                @endforeach
                            </tbody>   
                        </table>
                        @else                        
                            <div class="alert alert-info" style="text-align: center;margin:10px;">No existen medios de verificación cargados en este trimestre</div>                        
                        @endif
                </div>                
            </div>
        </div>       
    </div>
</div>
<div class="col-xl-6 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background-color: rgb(75,90,137);">
            <h6 class="m-0 font-weight-bold text-primary" style="color:white !important;cursor: pointer;" onclick="toggle('chevobs','body-obs')">Observaciones <i class="fas fa-chevron-down"
                id="chevobs"></i></h6>
            <div class="dropdown no-arrow">
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body" id="body-obs">
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="">
                <a class="nav-item nav-link active" id="nav-1er-tabobs" data-toggle="tab" href="#nav-primerobs"
                    role="tab" aria-controls="nav-primerobs" aria-selected="true">1er. Trimestre</a>
                <a class="nav-item nav-link " id="nav-2do-tabobs" data-toggle="tab" href="#nav-segundoobs"
                    role="tab" aria-controls="nav-segundoobs" aria-selected="true">2do. Trimestre</a>
                <a class="nav-item nav-link " id="nav-3er-tabobs" data-toggle="tab" href="#nav-terceroobs"
                    role="tab" aria-controls="nav-terceroobs" aria-selected="true">3er. Trimestre</a>
                <a class="nav-item nav-link " id="nav-4to-tabobs" data-toggle="tab" href="#nav-cuartoobs"
                    role="tab" aria-controls="nav-cuartoobs" aria-selected="true">4to. Trimestre</a>
            </div>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-primerobs" role="tabpanel" aria-labelledby="nav-1er-tabobs" style="padding:10px;">   
                    @if($obs1->count()>0)
                    <div style="padding: 10px;">
                        @foreach ($obs1 as  $obs)
                            {{$obs->observaciones}}
                        @endforeach
                    </div>
                    @else
                        <div class="alert alert-info" style="text-align: center">Sin observaciones para este trimestre</div>
                    @endif             
                </div>
                <div class="tab-pane fade show" id="nav-segundoobs" role="tabpanel" aria-labelledby="nav-2do-tabobs" style="padding:10px;">  
                    @if($obs2->count()>0)
                    <div style="padding: 10px;">
                        @foreach ($obs2 as  $obs)
                            {{$obs->observaciones}}
                        @endforeach
                    </div>
                    @else
                        <div class="alert alert-info" style="text-align: center">Sin observaciones para este trimestre</div>
                    @endif                  
                    
                </div>
                <div class="tab-pane fade show" id="nav-terceroobs" role="tabpanel" aria-labelledby="nav-3er-tabobs" style="padding:10px;">                    
                    @if($obs3->count()>0)
                    <div style="padding: 10px;">
                        @foreach ($obs3 as  $obs)
                            {{$obs->observaciones}}
                        @endforeach
                    </div>
                    @else
                        <div class="alert alert-info" style="text-align: center">Sin observaciones para este trimestre</div>
                    @endif
                </div>
                <div class="tab-pane fade show" id="nav-cuartoobs" role="tabpanel" aria-labelledby="nav-4to-tabobs" style="padding:10px;">                    
                    @if($obs4->count()>0)
                    <div style="padding: 10px;">
                        @foreach ($obs4 as  $obs)
                            {{$obs->observaciones}}
                        @endforeach
                    </div>
                    @else
                        <div class="alert alert-info" style="text-align: center">Sin observaciones para este trimestre</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-info col-xl-12 col-lg-5" style="text-align: center; margin: 20px auto;">
    Este PPA no aplica para el año seleccionado.
</div>

@endif
