@php
    use App\Models\IAFuente;
@endphp
<div style="text-align: right;margin:15px;">
<button class="btn" style="background-color: rgb(75,90,137);color:white"><i class="fas fa-download"></i> Ficha {{$anio}}</button>
<button class="btn" style="background-color: rgb(167,176,207);color:white"><i class="fas fa-download"></i> Ficha 1er trimestre</button>
<button class="btn" style="background-color: rgb(167,176,207);color:white"><i class="fas fa-download"></i> Ficha 2do trimestre</button>
<button class="btn" style="background-color: rgb(167,176,207);color:white"><i class="fas fa-download"></i> Ficha 3er trimestre</button>
<button class="btn" style="background-color: rgb(167,176,207);color:white"><i class="fas fa-download"></i> Ficha 4to trimestre</button>
</div>
<div class="row">
<div class="col-xl-6 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background-color: rgb(75,90,137);">
            <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Presupuesto general por año</h6>
            <div class="dropdown no-arrow">
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
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
            @endif
        </div>
    </div>
</div>
<div class="col-xl-6 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background-color: rgb(75,90,137);">
            <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Población o área de enfoque</h6>
            <div class="dropdown no-arrow">
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
        </div>
    </div>
</div>
<div class="col-xl-6 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background-color: rgb(75,90,137);">
            <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Impacto esperado</h6>
            <div class="dropdown no-arrow">
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
        </div>
    </div>
</div>
<div class="col-xl-6 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background-color: rgb(75,90,137);">
            <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Monitoreo por bien o servicio</h6>
            <div class="dropdown no-arrow">
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
        </div>
    </div>
</div>
<div class="col-xl-6 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background-color: rgb(75,90,137);">
            <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Medios de verificación cargados</h6>
            <div class="dropdown no-arrow">
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
        </div>
    </div>
</div>
<div class="col-xl-6 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background-color: rgb(75,90,137);">
            <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Observaciones</h6>
            <div class="dropdown no-arrow">
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
        </div>
    </div>
</div>