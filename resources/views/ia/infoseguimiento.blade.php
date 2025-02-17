@csrf
<input type="hidden" id="ia_presupuesto_general_id" value="{{$infoPresupuesto->id}}" />
<table style="width: 100%">
<tr>
    <td style="text-align: left"><h1>Año: {{$infoPresupuesto->anio}}</td>
    <td style="text-align: right"><button class="btn btn-success" style="text-align: right" onclick="almacenaCambios();"><i class="fas fa-save"></i> Guardar Cambios</button></td>
</tr>
</table>    
</h1>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist" style="">
        <a class="nav-item nav-link active" id="nav-presupuesto-tab" data-toggle="tab" href="#nav-presupuesto"
            role="tab" aria-controls="nav-presupuesto" aria-selected="true">Presupuesto general por año<span
                id="objseleccionados"></span></a>
        <a class="nav-item nav-link" id="nav-pa-tab" data-toggle="tab" href="#nav-pa" role="tab"
            aria-controls="nav-pa" aria-selected="false">Población o área de enfoque</span></a>
        <a class="nav-item nav-link" id="nav-impacto-tab" data-toggle="tab" href="#nav-impacto" role="tab"
            aria-controls="nav-impacto" aria-selected="false">Impacto esperado</a>
        <a class="nav-item nav-link" id="nav-monitoreo-tab" data-toggle="tab" href="#nav-monitoreo" role="tab"
            aria-controls="nav-monitoreo" aria-selected="false">Monitoreo</a>
        <a class="nav-item nav-link" id="nav-medios-tab" data-toggle="tab" href="#nav-medios" role="tab"
            aria-controls="nav-medios" aria-selected="false">Medios de Verificación</a>
        <a class="nav-item nav-link" id="nav-obs-tab" data-toggle="tab" href="#nav-obs"
            role="tab" aria-controls="nav-obs" aria-selected="false">Observaciones</a>
    </div>    
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-presupuesto" role="tabpanel"aria-labelledby="nav-presupuesto-tab">
        <div class="col-lg-12" style="padding:20px;">
            <div class="card shadow">
                <div class="card-header py-3" style="background-color:rgb(157, 36, 73);color:white">
                    <h6 class="m-0 font-weight-bold text-light" onclick="toggle('chevgasoperativo','body-gasoperativo')"
                        style="cursor: pointer;color:white">Gasto perativo <i class="fas fa-chevron-down"
                            id="chevgasoperativo"></i>
                    </h6>
                </div>
                <div class="card-body" id="body-gasoperativo">
                    <div style="width: 100%;text-align:right;padding:5px;"><button class="btn btn-success" onclick="addPrograma('operativo')"><i
                                class="fas fa-plus"></i> Agregar Programa Prespuestario</button></div>
                    <div id="programasContent">
                        @if($poperativos->count()>0)
                            @foreach ($poperativos as $poperativo)
                                <div style="border: solid 1px green;padding:20px;border-radius:20px;margin:10px;" id="programa{{$poperativo->id}}">
                                    <input type="hidden" id="ia_presupuesto_tipog_id" value="{{$poperativo->id}}" class="ia_presupuesto_tipog_id"/>                                    
                                    <button class="close" type="button" aria-label="Close"
                                        style="color:red;position:realtive;bottom:30px;" onclick="removePrograma({{$poperativo->id}})">
                                        <span aria-hidden="true" style="font-size: .8em;"><i class="fas fa-trash"></i></span>
                                    </button>
                                    <table style="width: 100%">
                                        <tr>
                                            <td class="enc1" style="width: 10%">Programa Presupuestario:</td>
                                            <td>
                                                <select id="pp_id" class="form-control pp_id">
                                                    <option value="">Seleccione</option>
                                                    @foreach ($programas as $programa )
                                                        <option value="{{$programa->idPrograma}}" @if($programa->idPrograma == $poperativo->pp_id) selected @endif>{{$programa->clavePrograma." ".$programa->descripcionPrograma}}</option>   
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Debe seleccionar el programa presupuestario.
                                                </div>
                                            </td>
                                            <td class="enc1" style="width: 10%">Componente:</td>
                                            <td style="width: 40%">
                                                <input type="text" class="form-control componente"
                                                    placeholder="indicar el ID del componente" id="componente" value="{{$poperativo->componente}}"/>
                                                <div class="invalid-feedback">
                                                    Debe indicar el componente o componentes relacionados con el presupuesto.
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <table style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="enc1">No.</th>
                                                            <th class="enc1">Fuente de financiamiento</th>
                                                            <th class="enc1">Monto Federal</th>
                                                            <th class="enc1">Monto Estatal</th>
                                                            <th class="enc1">Monto Municipal</th>
                                                            <th class="enc1">Monto Total</th>
                                                            <th class="enc1">Opciones</th>
                                                            <th style="width: 5%;text-align:center"><button
                                                                    class="btn btn-success" onclick="fuenteFinanciamiento({{$poperativo->id}})"><i
                                                                        class="fas fa-plus"></i></button></th>
                                
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabla_presupuesto{{$poperativo->id}}">
                                                                                                         
                                                    </tbody>
                                                </table>
                                                <script>
                                                    getFuentes({{$poperativo->id}})
                                                </script>
                                            </td>
                                        </tr>
                                    </table>
                                </div>                                
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12" style="padding:20px;">
            <div class="card shadow">
                <div class="card-header py-3" style="background-color:rgb(157, 36, 73);color:white">
                    <h6 class="m-0 font-weight-bold text-light"
                        onclick="toggle('chevgasinversion','body-gasinversion')" style="cursor: pointer;color:white">
                        Gasto de inversión <i class="fas fa-chevron-down" id="chevgasinversion"></i>
                    </h6>
                </div>
                <div class="card-body" id="body-gasinversion">
                    <div style="width: 100%;text-align:right;padding:5px;"><button class="btn btn-success" onclick="addPrograma('inversion')"><i
                        class="fas fa-plus"></i> Agregar Programa Prespuestario</button></div>
                    <div id="programasInvContent">
                        @if($pinversion->count()>0)
                            @foreach ($pinversion as $pinv)
                                <div style="border: solid 1px green;padding:20px;border-radius:20px;margin:10px;" id="programa{{$pinv->id}}">
                                    <input type="hidden" id="ia_presupuesto_tipog_id" value="{{$pinv->id}}" class="ia_presupuesto_tipog_id"/>                                    
                                    <button class="close" type="button" aria-label="Close"
                                        style="color:red;position:realtive;bottom:30px;" onclick="removePrograma({{$pinv->id}})">
                                        <span aria-hidden="true" style="font-size: .8em;"><i class="fas fa-trash"></i></span>
                                    </button>
                                    <table style="width: 100%">
                                        <tr>
                                            <td class="enc1" style="width: 10%">Programa Presupuestario:</td>
                                            <td>
                                                <select id="pp_id" class="form-control pp_id">
                                                    <option value="">Seleccione</option>
                                                    @foreach ($programas as $programa )
                                                        <option value="{{$programa->idPrograma}}" @if($programa->idPrograma == $pinv->pp_id) selected @endif>{{$programa->clavePrograma." ".$programa->descripcionPrograma}}</option>   
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Debe seleccionar el programa presupuestario.
                                                </div>
                                            </td>
                                            <td class="enc1" style="width: 10%">Componente:</td>
                                            <td style="width: 40%">
                                                <input type="text" class="form-control componente"
                                                    placeholder="indicar el ID del componente" id="componente" value="{{$pinv->componente}}"/>
                                                <div class="invalid-feedback">
                                                    Debe indicar el componente o componentes relacionados con el presupuesto.
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <table style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="enc1">No.</th>
                                                            <th class="enc1">Fuente de financiamiento</th>
                                                            <th class="enc1">Monto Federal</th>
                                                            <th class="enc1">Monto Estatal</th>
                                                            <th class="enc1">Monto Municipal</th>
                                                            <th class="enc1">Monto Total</th>
                                                            <th class="enc1">Opciones</th>
                                                            <th style="width: 5%;text-align:center"><button
                                                                    class="btn btn-success" onclick="fuenteFinanciamiento({{$pinv->id}})"><i
                                                                        class="fas fa-plus"></i></button></th>
                                
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabla_presupuesto{{$pinv->id}}">
                                                                                                        
                                                    </tbody>
                                                </table>
                                                <script>
                                                    getFuentes({{$pinv->id}})
                                                </script>
                                            </td>
                                        </tr>
                                    </table>
                                </div>                                
                            @endforeach
                        @endif
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
                        <h4><i class="fas fa-users"></i> Población a atender</h4>                        
                            <table style="width:100%">
                                <tr>
                                    <td class="enc1" style="width:15%;border:1px solid gray">
                                        Tipo de población:
                                    </td>
                                    <td style="border:1px solid gray;font-size:1.3em">
                                       {{$poblacion->descripcion}} 
                                    </td>
                                    <td class="enc1" style="width:15%;border:1px solid gray">
                                        Descripción de la población a atender:
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
                                                        Debe indicar el total de la población.
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
                        <h4><i class="fas fa-check"></i> Área de enfoque a atender</h4>                        
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
                        <div class="col-md" style="padding-top:20px;border:solid 1px green;color:black;background-color:rgb(236, 236, 236);margin:10px;cursor:pointer" onmouseover="$(this).css('color','blue');$(this).css('background-color','white');" onmouseout="$(this).css('color','black');$(this).css('background-color','rgb(236, 236, 236)');" onclick="getInfoMonitoreo({{$bs->idBS}})">
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
                        Carga de medios de verificación <i class="fas fa-chevron-down" id="chevmedios"></i>
                    </h6>
                </div>
                <div class="card-body" id="body-medios">
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
                                <b>Medios de Verificación cargados</b>
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
