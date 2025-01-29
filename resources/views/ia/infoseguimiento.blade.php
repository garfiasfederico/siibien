@csrf
<input type="hidden" id="ia_presupuesto_general_id" value="{{$infoPresupuesto->id}}" />
<h1>Año: {{$infoPresupuesto->anio}}
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
        <a class="nav-item nav-link" id="nav-observaciones-tab" data-toggle="tab" href="#nav-observaciones"
            role="tab" aria-controls="nav-observaciones" aria-selected="false">Observaciones</a>

    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-presupuesto" role="tabpanel"aria-labelledby="nav-presupuesto-tab">
        <div class="col-lg-12" style="padding:20px;">
            <div class="card shadow">
                <div class="card-header py-3" style="background-color:rgb(157, 36, 73);color:white">
                    <h6 class="m-0 font-weight-bold text-light" onclick="toggle('chevgasoperativo','body-gasoperativo')"
                        style="cursor: pointer;color:white">Gasto Operativo <i class="fas fa-chevron-down"
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
                                    <input type="hidden" id="ia_presupuesto_tipog_id" value="{{$poperativo->id}}">                                    
                                    <button class="close" type="button" aria-label="Close"
                                        style="color:red;position:realtive;bottom:30px;" onclick="removePrograma({{$poperativo->id}})">
                                        <span aria-hidden="true" style="font-size: .8em;"><i class="fas fa-trash"></i></span>
                                    </button>
                                    <table style="width: 100%">
                                        <tr>
                                            <td class="enc1" style="width: 10%">Programa Presupuestario:</td>
                                            <td>
                                                <select id="pp_id" class="form-control"></select>
                                            </td>
                                            <td class="enc1" style="width: 10%">Componente:</td>
                                            <td style="width: 40%">
                                                <input type="text" class="form-control"
                                                    placeholder="indicar el ID del componente" id="componente" />
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
                                                                    class="btn btn-success" onclick="fuenteFinanciamiento()"><i
                                                                        class="fas fa-plus"></i></button></th>
                                
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="8"
                                                                style="text-align: center;border:solid 1px gray;">No existen
                                                                fuentes de financiamiento registradas para este Programa</td>
                                                        </tr>                                                  
                                                    </tbody>
                                                </table>
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
                        Gasto de Inversión <i class="fas fa-chevron-down" id="chevgasinversion"></i>
                    </h6>
                </div>
                <div class="card-body" id="body-gasinversion">
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-pa" role="tabpanel"aria-labelledby="nav-pa-tab">
    </div>
    <div class="tab-pane fade" id="nav-impacto" role="tabpanel"aria-labelledby="nav-impacto-tab">
    </div>
    <div class="tab-pane fade" id="nav-monitoreo" role="tabpanel"aria-labelledby="nav-monitoreo-tab">
    </div>
    <div class="tab-pane fade" id="nav-medios" role="tabpanel"aria-labelledby="nav-medios-tab">
    </div>
    <div class="tab-pane fade" id="nav-observaciones" role="tabpanel"aria-labelledby="nav-observaciones-tab">
    </div>
</div>
