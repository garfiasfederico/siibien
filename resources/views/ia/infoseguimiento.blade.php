@csrf
<input type="hidden" id="ia_presupuesto_general_id" value="{{$infoPresupuesto->id}}" />
<table style="width: 100%">
<tr>
    <td style="text-align: left;width:15%"><h1>Año: {{$infoPresupuesto->anio}}</h1></td>
    <td style="text-align: left;width:42.5%" id="toggleAplica">
        <input style="" id="toggleseguimiento" type="checkbox" @if($infoPresupuesto->aplica) checked @endif data-toggle="toggle" data-on="Aplica" data-off="No aplica" data-onstyle="success" data-offstyle="secondary" onchange="setAplica({{$infoPresupuesto->ia_id}},{{$infoPresupuesto->anio}})">
    </td>   
    <td style="text-align: right;width:42.5%"" id="AlmacenarGeneral">
        @if($infoPresupuesto->aplica)
            <button class="btn btn-success" style="text-align: right" onclick="almacenaCambios();"><i class="fas fa-save"></i> Guardar Cambios</button>
        @endif
    </td>
</tr>
</table>    
</h1>

<div id="seguimientoAplica" style="@if(!$infoPresupuesto->aplica) display:none @endif">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist" style="">
            <a class="nav-item nav-link active" id="nav-presupuesto-tab" data-toggle="tab" href="#nav-presupuesto"
                role="tab" aria-controls="nav-presupuesto" aria-selected="true">Presupuesto general por año<span
                    id="presupuesto-n"></span></a>
            <a class="nav-item nav-link" id="nav-pa-tab" data-toggle="tab" href="#nav-pa" role="tab"
                aria-controls="nav-pa" aria-selected="false">Población o área de enfoque<span
                id="pa-n"></span></a>
            <a class="nav-item nav-link" id="nav-impacto-tab" data-toggle="tab" href="#nav-impacto" role="tab"
                aria-controls="nav-impacto" aria-selected="false">Impacto esperado<span
                id="impacto-n"></span></a>
            <a class="nav-item nav-link" id="nav-monitoreo-tab" data-toggle="tab" href="#nav-monitoreo" role="tab"
                aria-controls="nav-monitoreo" aria-selected="false">Monitoreo<span
                id="monitoreo-n"></span></a>
            <a class="nav-item nav-link" id="nav-medios-tab" data-toggle="tab" href="#nav-medios" role="tab"
                aria-controls="nav-medios" aria-selected="false">Ejemplos para Difusión<span
                id="medios-n"></span></a>
            <a class="nav-item nav-link" id="nav-obs-tab" data-toggle="tab" href="#nav-obs"
                role="tab" aria-controls="nav-obs" aria-selected="false">Observaciones<span
                id="observaciones-n"></span></a>
        </div>    
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-presupuesto" role="tabpanel"
            aria-labelledby="nav-presupuesto-tab">
            <div class="col-lg-12" style="padding:20px;">
                <div class="card shadow">
                    <div class="card-header py-3" style="background-color:rgb(157, 36, 73);color:white">
                        <h6 class="m-0 font-weight-bold text-light">Programas presupuestarios</h6>
                    </div>

                    <div class="card-body">
                        <div style="width:100%;text-align:right;padding-bottom:10px;">
                            <button class="btn btn-success" onclick="addPrograma()">
                                <i class="fas fa-plus"></i> Agregar Programa Presupuestario
                            </button>
                        </div>

                        <div id="programasContent">
                            @foreach ($programasAgrupados as $pp_id => $registros)
                                @if(!$pp_id)
                                    @continue
                                @endif
                                @php
                                    $operativo = null;
                                    $inversion = null;

                                    foreach ($registros as $r) {
                                        if ($r->tipo_gasto === 'operativo') {
                                            $operativo = $r;
                                        }
                                        if ($r->tipo_gasto === 'inversion') {
                                            $inversion = $r;
                                        }
                                    }

                                    $idOperativo = $operativo->id ?? null;
                                    $idInversion = $inversion->id ?? null;
                                @endphp

                                <div class="programa-item"
                                    style="border:1px solid green;padding:15px;border-radius:20px;margin:10px;">

                                    <input type="hidden" class="tipog_operativo_id" value="{{ $idOperativo }}">
                                    <input type="hidden" class="tipog_inversion_id" value="{{ $idInversion }}">

                                    <button class="close" style="color:red"
                                        onclick="removePrograma({{ $idOperativo }}, {{ $idInversion }})">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <table style="width:100%">
                                        <tr>
                                            <td class="enc1" style="width:25%">Programa presupuestario:</td>
                                            <td style="width:75%">
                                                <select class="form-control pp_id">
                                                    <option value="">Seleccione</option>
                                                    @foreach ($programas as $p)
                                                        <option value="{{ $p->idPrograma }}"
                                                            @if ($p->idPrograma == $pp_id) selected @endif>
                                                            {{ $p->clavePrograma }} {{ $p->descripcionPrograma }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="enc1">Tipo de gasto:</td>
                                            <td>
                                                <div style="display:flex; gap:40px; align-items:center;">

                                                    <div style="display:flex; align-items:center; gap:10px;">
                                                        <span class="enc1">Operativo</span>
                                                        <input type="checkbox" class="toggle-gasto toggle-operativo"
                                                            data-id="{{ $idOperativo }}" data-toggle="toggle"
                                                            data-on="Aplica" data-off="No aplica"
                                                            data-onstyle="success" data-offstyle="secondary"
                                                            {{ isset($operativo->aplica) && $operativo->aplica ? 'checked' : '' }}>

                                                    </div>

                                                    <div style="display:flex; align-items:center; gap:10px;">
                                                        <span class="enc1">Inversión</span>
                                                        <input type="checkbox" class="toggle-gasto toggle-inversion"
                                                            data-id="{{ $idInversion }}" data-toggle="toggle"
                                                            data-on="Aplica" data-off="No aplica"
                                                            data-onstyle="primary" data-offstyle="secondary"
                                                            {{ isset($inversion->aplica) && $inversion->aplica ? 'checked' : '' }}>

                                                    </div>

                                                </div>
                                            </td>
                                        </tr>

                                    </table>

                                    <hr>

                                    <div class="bloque-operativo">

                                        <table style="width:100%">
                                            <tr>
                                                <td class="enc1" style="width:25%">Monto operativo:</td>
                                                <td style="width:40%">
                                                    <select class="form-control form-control-sm selector-gasto"
                                                        data-id="{{ $idOperativo }}" style="width:220px;">
                                                        <option value="">Seleccione una opción</option>
                                                        <option value="0"
                                                            {{ isset($operativo->estatus) && $operativo->estatus == 0 ? 'selected' : '' }}>
                                                            No aplica</option>
                                                        <option value="1"
                                                            {{ isset($operativo->estatus) && $operativo->estatus == 1 ? 'selected' : '' }}>
                                                            No disponible</option>
                                                        <option value="2"
                                                            {{ isset($operativo->estatus) && $operativo->estatus == 2 ? 'selected' : '' }}>
                                                            Aplica</option>
                                                    </select>
                                                </td>
                                                <td style="width:35%">
                                                    <input type="number"
                                                        class="form-control form-control-sm monto-gasto"
                                                        data-id="{{ $idOperativo }}" placeholder="$ 0.00"
                                                        value="{{ $operativo->monto ?? '' }}">

                                                </td>

                                            </tr>
                                        </table>

                                        {{-- <div class="mt-3">
                                            <a class="enc1 d-block" data-toggle="collapse"
                                                href="#fuentes_operativo_{{ $idOperativo ?? 'tmp_op_' . $pp_id }}">
                                                Fuentes <i class="fas fa-chevron-down ml-1"></i>
                                            </a>

                                            <div class="collapse mt-2"
                                                id="fuentes_operativo_{{ $idOperativo ?? 'tmp_op_' . $pp_id }}">
                                                <table style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="enc1">No.</th>
                                                            <th class="enc1">Fuente</th>
                                                            <th class="enc1">Federal</th>
                                                            <th class="enc1">Estatal</th>
                                                            <th class="enc1">Municipal</th>
                                                            <th class="enc1">Total</th>
                                                            <th class="enc1">Opciones</th>
                                                            <th>
                                                                <button class="btn btn-success btn-sm"
                                                                    onclick="fuenteFinanciamiento({{ $idOperativo }})"
                                                                    {{ !$idOperativo ? 'disabled' : '' }}>
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabla_presupuesto{{ $idOperativo }}">
                                                        <tr>
                                                            <td colspan="8" class="text-center text-muted">
                                                                No hay fuentes registradas
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                @if ($idOperativo)
                                                    <script>
                                                        getFuentes({{ $idOperativo }});
                                                    </script>
                                                @endif
                                            </div>
                                        </div> --}}

                                    </div>

                                    <hr>

                                    <div class="bloque-inversion">

                                        <table style="width:100%">
                                            <tr>
                                                <td class="enc1" style="width:25%">Monto inversión:</td>
                                                <td style="width:40%">
                                                    <select class="form-control form-control-sm selector-gasto"
                                                        data-id="{{ $idInversion }}" style="width:220px;">
                                                        <option value="">Seleccione una opción</option>
                                                        <option value="0"
                                                            {{ isset($inversion->estatus) && $inversion->estatus == 0 ? 'selected' : '' }}>
                                                            No aplica</option>
                                                        <option value="1"
                                                            {{ isset($inversion->estatus) && $inversion->estatus == 1 ? 'selected' : '' }}>
                                                            No disponible</option>
                                                        <option value="2"
                                                            {{ isset($inversion->estatus) && $inversion->estatus == 2 ? 'selected' : '' }}>
                                                            Aplica</option>
                                                    </select>
                                                </td>
                                                <td style="width:35%">
                                                    <input type="number"
                                                        class="form-control form-control-sm monto-gasto"
                                                        data-id="{{ $idInversion }}" placeholder="$ 0.00"
                                                        value="{{ $inversion->monto ?? '' }}">

                                                </td>

                                            </tr>
                                        </table>


                                        {{-- <div class="mt-3">
                                            <a class="enc1 d-block" data-toggle="collapse"
                                                href="#fuentes_inversion_{{ $idInversion ?? 'tmp_inv_' . $pp_id }}">
                                                Fuentes <i class="fas fa-chevron-down ml-1"></i>
                                            </a>

                                            <div class="collapse mt-2"
                                                id="fuentes_inversion_{{ $idInversion ?? 'tmp_inv_' . $pp_id }}">
                                                <table style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="enc1">No.</th>
                                                            <th class="enc1">Fuente</th>
                                                            <th class="enc1">Federal</th>
                                                            <th class="enc1">Estatal</th>
                                                            <th class="enc1">Municipal</th>
                                                            <th class="enc1">Total</th>
                                                            <th class="enc1">Opciones</th>
                                                            <th>
                                                                <button class="btn btn-success btn-sm"
                                                                    onclick="fuenteFinanciamiento({{ $idInversion }})"
                                                                    {{ !$idInversion ? 'disabled' : '' }}>
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabla_presupuesto{{ $idInversion }}">
                                                        <tr>
                                                            <td colspan="8" class="text-center text-muted">
                                                                No hay fuentes registradas
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                @if ($idInversion)
                                                    <script>
                                                        getFuentes({{ $idInversion }});
                                                    </script>
                                                @endif
                                            </div>
                                        </div> --}}

                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="nav-pa" role="tabpanel"aria-labelledby="nav-pa-tab">
            <div class="col-lg-12" style="padding:20px;">
                <div class="card shadow">
                    <div class="card-header py-3" style="background-color:rgb(157, 36, 73);color:white">
                        <h6 class="m-0 font-weight-bold text-light"
                            onclick="toggle('chevpa','body-pa')" style="cursor: pointer;color:white">
                            Datos de la población o área de enfoque a atender <i class="fas fa-chevron-down" id="chevpa"></i>
                        </h6>
                    </div>
                    <div class="card-body" id="body-pa">
                        @if($poblacion!=null)
                            <input type="hidden" id="idPoblacion" value="{{$poblacion->idPoblacion}}">
                            <input type="hidden" id="tipoP" value="{{$poblacion->tipo}}">

                            @if(str_contains($poblacion->tipo,"p_"))    
                            <h4><i class="fas fa-users"></i> Población Objetivo (meta anual)</h4>                        
                                <table style="width:100%">
                                    <tr>
                                        <td class="enc1" style="width:15%;border:1px solid gray">
                                            Tipo de población:
                                        </td>
                                        <td style="border:1px solid gray;font-size:1.3em">
                                        {{$poblacion->descripcion}} 
                                        </td>
                                        <td class="enc1" style="width:15%;border:1px solid gray">
                                            Descripción de la objetivo:
                                        </td>
                                        <td style="border:1px solid gray;font-size:1.3em">
                                        {{$poblacion->descripcion_poblacion}} 
                                        </td>                                    
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="border:1px solid gray">
                                            <table style="width: 100%">
                                                <tr>
                                                    <td class="enc1" style="width: 15%" >Mujeres:</td>
                                                    <td>
                                                        <input type="number" class="form-control" style="font-size: 1.5em;color:black;text-align:right" min="0" id="mujeres" onkeyup="refreshPoblacion()"
                                                        @if($infoP != null )value="{{$infoP->mujeres}}"@endif>
                                                        <div class="invalid-feedback">
                                                            Debe indicar número de mujeres.
                                                        </div>
                                                    </td>
                                                    <td class="enc1" style="width: 15%" >Hombres:</td>
                                                    <td>
                                                        <input type="number" class="form-control" style="font-size: 1.5em;color:black;text-align:right" min="0" id="hombres" onkeyup="refreshPoblacion()"
                                                        @if($infoP != null )value="{{$infoP->hombres}}"@endif/>
                                                        <div class="invalid-feedback">
                                                            Debe indicar número de hombres.
                                                        </div>
                                                    </td>
                                                    <td class="enc1" style="width: 15%" >Total:</td>
                                                    <td>
                                                        <input type="number" class="form-control" style="font-size: 1.5em;color:black;text-align:right" min="0" id="total" readonly
                                                        @if($infoP != null )value="{{$infoP->total}}"@endif/>
                                                        <div class="invalid-feedback">
                                                            Debe indicar el total de la población objetivo.
                                                        </div>
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
                                    <td class="enc1" style="width:15%;border:1px solid gray">
                                        Nombre del área de enfoque:
                                    </td>
                                    <td style="border:1px solid gray;font-size:1.3em">
                                    {{$poblacion->nombre_enfoque}} 
                                    </td>
                                    <td class="enc1" style="width:15%;border:1px solid gray">
                                        Descripción del área de enfoque:
                                    </td>
                                    <td style="border:1px solid gray;font-size:1.3em">
                                    {{$poblacion->descripcion_area}} 
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td colspan="4" style="border:1px solid gray">
                                        <table style="width: 100%">
                                            <tr>
                                                <td class="enc1" style="width: 15%" >Meta anual:</td>
                                                <td>
                                                    <input type="number" class="form-control" style="font-size: 1.5em;color:black;text-align:right" min="0" id="total_area"
                                                    @if($infoP != null )value="{{$infoP->total_area}}"@endif/>
                                                    <div class="invalid-feedback">
                                                        Debe indicar la meta anual de atención.
                                                    </div>
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
        </div>
        <div class="tab-pane fade" id="nav-impacto" role="tabpanel"aria-labelledby="nav-impacto-tab">
            <div class="col-lg-12" style="padding:20px;">
                <div class="card shadow">
                    <div class="card-header py-3" style="background-color:rgb(157, 36, 73);color:white">
                        <h6 class="m-0 font-weight-bold text-light"
                            onclick="toggle('chevimpacto','body-impacto')" style="cursor: pointer;color:white">
                            Impacto Esperado <i class="fas fa-chevron-down" id="chevimpacto"></i>
                        </h6>
                    </div>
                    <div class="card-body" id="body-impacto">
                        <table style="width:100%">
                            <tr>
                                <td class="enc1" style="width: 15%;border:solid 1px gray;">Tipo de Impacto</td>
                                <td style="border:solid 1px gray;">
                                    <table style="width: 100%">
                                        <tr>
                                            <td style="text-align: center;font-size:1.3em"><i class="fas fa-users"></i> <input type="checkbox" id="social" style="transform: scale(1.3)" @if($infoP!=null) @if(str_contains($infoP->impacto_esperado, 'social')) checked @endif @endif> Social</td>
                                            <td style="text-align: center;font-size:1.3em"><i class="fas fa-dollar-sign"> </i> <input type="checkbox" id="economico" style="transform: scale(1.3)" @if($infoP!=null) @if(str_contains($infoP->impacto_esperado, 'economico')) checked @endif @endif> Económico</td>
                                            <td style="text-align: center;font-size:1.3em"><i class="fas fa-tree"></i> <input type="checkbox" id="ambiental" style="transform: scale(1.3)" @if($infoP!=null) @if(str_contains($infoP->impacto_esperado, 'ambiental')) checked @endif @endif> Ambiental</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <input type="hidden" id="impacto_seleccion"/>
                                                <div class="invalid-feedback">
                                                    Debe seleccionar al menos un tipo de impacto que genera el PPA.
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="enc1" style="width: 15%;border:solid 1px gray;">Descripción del impacto</td>
                                <td style="border:solid 1px gray;">
                                    <textarea class="form-control" id="descripcion_impacto" placeholder="Describir brevemente el impacto generado tras la implementación del PPA.">@if($infoP!=null){{$infoP->descripcion_impacto}}@endif</textarea>
                                    <div class="invalid-feedback">
                                        Debe Indicar una descripción del impacto a generar.
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>        
        </div>
        <div class="tab-pane fade" id="nav-monitoreo" role="tabpanel"aria-labelledby="nav-monitoreo-tab">
            <div class="col-lg-12" style="padding:20px;">
                <div class="card shadow">
                    <div class="card-header py-3" style="background-color:rgb(157, 36, 73);color:white">
                        <h6 class="m-0 font-weight-bold text-light"
                            onclick="toggle('chevmonitoreo','body-monitoreo')" style="cursor: pointer;color:white;">
                            Monitoreo por bien o servicio <i class="fas fa-chevron-down" id="chevmonitoreo"></i>
                        </h6>
                    </div>
                    <div class="card-body" id="body-monitoreo">
                        <center>
                        <div class="row" id="row-bss">
                    @if($bss->count()>0)                
                        @foreach($bss as $bs)
                            <div class="col-md" style="padding-top:20px;border:solid 1px green;color:black;@if($bs->status)'background-color:rgb(236, 236, 236)' @else 'background-color:orange' @endif;margin:10px;cursor:pointer" @if($bs->status) onmouseover="$(this).css('color','blue');$(this).css('background-color','white');" onmouseout="$(this).css('color','black');$(this).css('background-color','rgb(236, 236, 236)');" onclick="getInfoMonitoreo({{$bs->idBS}})" @endif>
                                @if(!$bs->status)
                                <div class="alert alert-warning" style="text-align: center;width:40%;position:absolute;top:0px;left:0px;">
                                    Baja
                                </div>
                                @endif
                                <h4>{{$bs->nombreBS}}</h4>
                                <p style="font-size:.8em">{{$bs->descripcionBS}}</p>                            
                                <div style="text-align: right;font-size:.7em">({{$bs->unidad_medidaBS}})</div>                            
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
        </div>
        <div class="tab-pane fade" id="nav-medios" role="tabpanel"aria-labelledby="nav-medios-tab">
            <div class="col-lg-12" style="padding:20px;">
                <div class="card shadow">
                    <div class="card-header py-3" style="background-color:rgb(157, 36, 73);color:white">
                        <h6 class="m-0 font-weight-bold text-light"
                            onclick="toggle('chevmedios','body-medios')" style="cursor: pointer;color:white">
                            Carga de Ejemplos para Difusión <i class="fas fa-chevron-down" id="chevmedios"></i>
                        </h6>
                    </div>
                    <div class="card-body" id="body-medios">
                        <h5><b>Instrucciones:</b> Descargue la <a href="{{route("ia.descargaplantilladifusion")}}">PLANTILLA</a> para concentrar la información de difusión y posteriormente realizar la carga en el siguiente apartado.</h5>
                        <table style="width:100%">
                            <tr>
                                <td style="width: 50%;border:solid 1px rgb(201, 201, 201);vertical-align:top;">
                                    <table style="width: 100%">
                                        <tr>
                                            <td class="enc1" style="20%">Seleccione trimestre</td>
                                            <td style="width:80%">
                                                <select class="form-control" id="trim" onchange="showMedios()">
                                                    <option value="">Seleccione</option>
                                                    <option value="1">1er. trimestre</option>
                                                    <option value="2">2do. trimestre</option>
                                                    <option value="3">3er. trimestre</option>
                                                    <option value="4">4to. trimestre</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="col-xl-12" style="height:200px;padding:10px;display:none" id="areaDropzone">
                                        <form action="{{ route('ia.uploadmedio') }}" method="POST" enctype="multipart/form-data"
                                            class="dropzone" id="medios-ppa" style="color:rgb(0, 0, 0)">
                                            @csrf
                                            <input type="hidden" id="idPPA_M" name="idPPA_M" value="{{$infoPresupuesto->ia_id}}"/>                                        
                                            <input type="hidden" id="anio_M" name="anio_M" value="{{$infoPresupuesto->anio}}"/>
                                            <input type="hidden" id="trim_M" name="trim_M"/>
                                        </form>
                                    </div>
                                </td>
                                <td style="width: 50%;text-align:center;vertical-align:top;border:solid 1px rgb(201, 201, 201)" class="">
                                    <b>Ejemplos para Difusión cargados</b>
                                    <div id="mediosCargados" style="width: 100%;text-align:center">
                                        <table style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th class="enc2" style="display: none">Id</th>
                                                    <th class="enc2">Archivo cargado</th>
                                                    <th class="enc2">Descripcion</th>
                                                    <th class="enc2">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody id="medios_cargados">                                            
                                            </tbody>  
                                        </table>                                  
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-obs" role="tabpanel" aria-labelledby="nav-obs-tab">
            <div class="col-lg-12" style="padding:20px;">
                <div class="card shadow">
                    <div class="card-header py-3" style="background-color:rgb(157, 36, 73);color:white">
                        <h6 class="m-0 font-weight-bold text-light"
                            onclick="toggle('chevobservaciones','body-observaciones')" style="cursor: pointer;color:white">
                            Observaciones por trimestre <i class="fas fa-chevron-down" id="chevobservaciones"></i>
                        </h6>
                    </div>
                    <div class="card-body" id="body-observaciones">
                        <table style="width: 100%">
                            <thead>
                                <tr>
                                    <td class="enc1" style="width: 15%">Seleccione Trimestre:</td>
                                    <td>
                                        <select class="form-control" id="trimestre_obs" onchange="showObservaciones()">
                                            <option value="">Seleccione</option>
                                            <option value="1">1er. trimestre</option>
                                            <option value="2">2do. trimestre</option>
                                            <option value="3">3er. trimestre</option>
                                            <option value="4">4to. trimestre</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr id="rowObservaciones" style="display: none">                                
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>

<script>
    function initToggles(container = document) {
        $(container).find('input[data-toggle="toggle"]').each(function() {
            if (!$(this).data('bs.toggle')) {
                $(this).bootstrapToggle();
            }
        });
    }

    function initBloques() {
        $('.programa-item').each(function() {
            const cont = $(this);

            cont.find('.bloque-operativo')
                .toggle(cont.find('.toggle-operativo').prop('checked'));

            cont.find('.bloque-inversion')
                .toggle(cont.find('.toggle-inversion').prop('checked'));
        });
    }

    function initMontos() {
        $('.selector-gasto').each(function() {
            const select = $(this);
            const estatus = parseInt(select.val());
            const cont = select.closest('.programa-item');
            const monto = cont.find('.monto-gasto[data-id="' + select.data('id') + '"]');

            monto.prop('readonly', estatus !== 2);
            if (estatus !== 2) monto.val('');
        });
    }

    function guardarPrograma(select) {
        const pp_id = select.val();
        const cont = select.closest('.programa-item');

        if (!pp_id) return;

        const operativo_id = cont.find('.tipog_operativo_id').val();
        const inversion_id = cont.find('.tipog_inversion_id').val();

        $.post("{{ route('ia.savePrograma') }}", {
                _token: $("input[name='_token']").val(),
                pp_id,
                operativo_id,
                inversion_id
            })
            .fail(function(xhr) {

                if (xhr.status === 422 && xhr.responseJSON?.type === 'duplicado') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Programa duplicado',
                        text: 'Este programa ya está asignado a otro registro'
                    });
                    select.val('');
                    return;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No fue posible guardar el programa'
                });
            });
    }

    function actualizarToggle(toggle) {
        const id = toggle.data('id');
        if (!id) return;

        const aplica = toggle.prop('checked') ? 1 : 0;
        const cont = toggle.closest('.programa-item');

        cont.find(
            toggle.hasClass('toggle-operativo') ?
            '.bloque-operativo' :
            '.bloque-inversion'
        ).toggle(aplica === 1);

        $.post("{{ route('ia.updateTipoGastoBasico') }}", {
            _token: $("input[name='_token']").val(),
            id: id,
            aplica: aplica
        });
    }

    function actualizarSelector(select) {
        const id = select.data('id');
        if (!id) return;

        const estatus = parseInt(select.val());
        const cont = select.closest('.programa-item');
        const monto = cont.find('.monto-gasto[data-id="' + id + '"]');

        let montoValor = null;

        if (estatus === 2) {
            monto.prop('readonly', false);
            montoValor = monto.val();
        } else {
            monto.val('');               
            monto.prop('readonly', true);
            montoValor = null;
        }
        $.post("{{ route('ia.updateTipoGastoBasico') }}", {
            _token: $("input[name='_token']").val(),
            id: id,
            estatus: estatus,
            monto: montoValor
        });
    }



    $(document).ready(function() {
        initToggles();
        initBloques();
        initMontos();
    });

    $(document).on('change', '.toggle-gasto', function() {
        actualizarToggle($(this));
    });

    $(document).on('change', '.selector-gasto', function() {
        actualizarSelector($(this));
    });

    $(document).on('change', '.pp_id', function() {
        guardarPrograma($(this));
    });
</script>
