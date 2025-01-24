@php
    use App\Models\TemaPED;
    use App\Models\ObjetivoPED;
    use App\Models\LineaPED;
    use App\Models\ObjetivoSector;
    use App\Models\EstrategiaSector;
    use App\Models\ProductoSector;
    use App\Models\Indicador;


@endphp
<h2>PPA: {{ $ppa->id . ' - ' . $ppa->nombre }}</h2>
<input type="hidden" id="idPPA" name="idPPA" value="{{ $ppa->id }}" />
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist" style="">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
            aria-controls="nav-home" aria-selected="true">Datos Generales<span id="objseleccionados"></span></a>
        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab"
            aria-controls="nav-profile" aria-selected="false">Alineacion<span id="objodsseleccionados"></span></a>
        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab"
            aria-controls="nav-contact" aria-selected="false">Bienes o
            Servicios<span id="programasseleccionados"></span></a>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel"aria-labelledby="nav-home-tab">
        <div class="col-lg-12" style="padding:20px;">
            <div class="card shadow">
                <div class="card-header py-3" style="background-color:rgb(157, 36, 73);color:white">
                    <h6 class="m-0 font-weight-bold text-light" onclick="toggle('chevgenerales','body-generales')"
                        style="cursor: pointer;color:white">Datos Generales <i class="fas fa-chevron-down"
                            id="chevgenerales"></i>
                    </h6>
                </div>
                <div class="card-body" id="body-generales">
                    <div style="">
                        <table style="width: 100%">
                            <tr>
                                <td class="enc1" title="Tipo de PPA"> Tipo:
                                    <span style="color: red">*</span>
                                    <br />
                                </td>
                                <td colspan="4">
                                    <table style="width: 100%;">
                                        <tr style="">
                                            <td class="" colspan=""
                                                style="text-align: center;border:solid 1px rgb(218, 218, 218);">
                                                <input type="radio" name="tipo" value="programa" id="programa"
                                                    onclick="voidReglas()" style="transform:scale(1)"
                                                    @if ($ppa->tipo == 'programa' || $ppa->tipo == null) checked @endif /> &nbsp; Programa
                                            </td>
                                            <td class="" colspan="" id="reglasDisplay"
                                                style="text-align: center; border:solid 1px rgb(218, 218, 218); @if ($ppa->tipo != 'programa' && $ppa->tipo != null) display:none; @endif">
                                                <table style="width: 100%">
                                                    <tr>
                                                        <td rowspan="2">Reglas de Operación</td>
                                                        <td rowspan=""><input type="radio" name="reglas"
                                                                value="si" id="reglassi" class="radio"
                                                                style="transform:scale(1)"
                                                                @if (($ppa->tipo == 'programa' && $ppa->r_o == 1) || $ppa->tipo == null) checked @endif
                                                                onclick="linkro()" />
                                                            &nbsp; Si</td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="radio" value="no" name="reglas"
                                                                class="radio" id="reglasno" style="transform:scale(1)"
                                                                onclick="linkro()"
                                                                @if ($ppa->tipo == 'programa' && $ppa->r_o == 0) checked @endif />
                                                            &nbsp; No</td>
                                                    </tr>
                                                </table>
                                                <input type="text"
                                                    style="width: 100%;@if ($ppa->tipo != 'programa' && $ppa->tipo != null) display:none @endif"
                                                    placeholder="Link de reglas de operación" class="form-control"
                                                    id="link_r_o"
                                                    @if ($ppa->tipo == 'programa' && $ppa->r_o == 1) value="{{ $ppa->link_r_o }}" @endif>
                                                <div class="invalid-feedback">
                                                    Debe Indicar el link de la reglas de operación.
                                                </div>
                                            </td>
                                            <td class="" colspan=""
                                                style="text-align: center;border:solid 1px rgb(218, 218, 218);">
                                                <input type="radio" name="tipo" value="proyecto" id="proyecto"
                                                    class="radio" @if ($ppa->tipo == 'proyecto') checked @endif
                                                    onclick="voidReglas()" style="transform:scale(1)" />
                                                &nbsp; Proyecto
                                            </td>
                                            <td class="" colspan="1"
                                                style="text-align: center;border:solid 1px rgb(218, 218, 218);">
                                                <input type="radio" name="tipo" value="accion" class="radio"
                                                    id="accion" @if ($ppa->tipo == 'accion') checked @endif
                                                    onclick="voidReglas()" style="transform:scale(1)" />
                                                &nbsp; Acción
                                            </td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                            <tr>
                                <td class="enc1" style="width: 15%">Objetivo: <span style="color: red">*</span> <i
                                        class="fas fa-question-circle"></i></td>
                                <td class="" colspan="3">
                                    <textarea class="form-control" name="objetivo" id="objetivo" cols="30" rows="2"
                                        placeholder="Indica el Objetivo del PPA" style="color: black">{{ $ppa->objetivo }}</textarea>
                                    <div class="invalid-feedback">
                                        Debe Indicar el Objetivo del PPA
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="enc1" style="width: 15%">Descripción: <span style="color: red">*</span>
                                    <i class="fas fa-question-circle"></i></td>
                                <td class="" colspan="3">
                                    <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="2"
                                        placeholder="Indica la Descripción del PPA" style="color: black">{{ $ppa->descripcion }}</textarea>
                                    <div class="invalid-feedback">
                                        Debe Indicar la Descripción del PPA
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="enc1" style="width: 15%;">Cobertura: <span style="color: red">*</span> <i
                                        class="fas fa-question-circle"></i></td>
                                <td class="">
                                    <select name="cobertura" id="cobertura" class="form-control"
                                        style="color:black"">
                                        <option value="">Seleccione...</option>
                                        <option value="estatal" @if ($ppa->cobertura == 'estatal') selected @endif>
                                            Estatal</option>
                                        <option value="regional" @if ($ppa->cobertura == 'regional') selected @endif>
                                            Regional</option>
                                        <option value="municipal" @if ($ppa->cobertura == 'municipal') selected @endif>
                                            Municipal</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Debe Indicar la cobertura del PPA
                                    </div>
                                </td>                                
                                <td class="enc1" style="width: 15%">Año de Inicio: <span
                                    style="color: red">*</span><i class="fas fa-question-circle"></i></td>
                            <td>
                                <input type="number" class="form-control" name="anio_inicio" id="anio_inicio"
                                    value="{{ $ppa->anio_inicio }}" style="color:black" />
                                <div class="invalid-feedback">
                                    Indique el año de inicio
                                </div>
                            </td>
                            </tr>                       
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <div class="col-lg-12" style="padding:20px;">
            <div class="card shadow">
                <div class="card-header py-3" style="background-color:rgb(157, 36, 73);color:white">
                    <h6 class="m-0 font-weight-bold text-light" onclick="toggle('chevped','body-ped')"
                        style="cursor: pointer;color:white">Alineación al PED <i class="fas fa-chevron-down"
                            id="chevped"></i>
                    </h6>
                </div>
                <div class="card-body" id="body-ped">
                    <table style="width: 100%">
                        <tr>
                            <td class="enc1" style="width:15%">
                                Eje PED: <span style="color: red">*</span>
                            </td>
                            <td colspan="2">
                                <select id="idEjePED" name="idEjePED" class="form-control" onchange="getTemas()">
                                    <option value="">Seleccione</option>
                                    @foreach ($ejes as $eje)
                                        <option value="{{ $eje->idEjePED }}"
                                            @if ($alineaciones != null) @if ($alineaciones->idEjePED == $eje->idEjePED)
                                                     selected @endif
                                            @endif
                                            >{{ $eje->ejePEDClave . ' ' . $eje->ejePEDDescripcion }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Debe Indicar el Eje del PED al que se alinea el PPA
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="enc1" style="width:15%">
                                Tema PED: <span style="color: red">*</span>
                            </td>
                            <td colspan="2">
                                <select id="idTemaPED" name="idTemaPED" class="form-control"
                                    onchange="getObjetivos()">
                                    <option value="">Seleccione</option>
                                    @if ($alineaciones != null > 0)
                                        @php
                                            $temas = TemaPED::where('idEjePED', $alineaciones->idEjePED)->get();
                                        @endphp
                                        @foreach ($temas as $tema)
                                            <option value="{{ $tema->idTemaPED }}"
                                                @if ($tema->idTemaPED == $alineaciones->idTemaPED) selected @endif>
                                                {{ $tema->temaPEDClave . ' ' . $tema->temaPEDDescripcion }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback">
                                    Debe Indicar el Tema del PED al que se alinea el PPA
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="enc1" style="width:15%">
                                Objetivo PED: <span style="color: red">*</span>
                            </td>
                            <td colspan="2">
                                <select id="idObjetivoPED" name="idObjetivoPED" class="form-control"
                                    onchange="getLineas()">
                                    <option value="">Seleccione</option>
                                    @if ($alineaciones != null)
                                        @php
                                            $objetivos = ObjetivoPED::where(
                                                'idTemaPED',
                                                $alineaciones->idTemaPED,
                                            )->get();
                                        @endphp
                                        @foreach ($objetivos as $objetivo)
                                            <option value="{{ $objetivo->idObjetivoPED }}"
                                                @if ($objetivo->idObjetivoPED == $alineaciones->idObjetivoPED) selected @endif>
                                                {{ $objetivo->objetivoPEDClave . ' ' . $objetivo->objetivoPEDDescripcion }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback">
                                    Debe Indicar el Objetivo del PED al que se alinea el PPA
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="enc1" style="width:15%">
                                Lineas PED:
                            </td>
                            <td>
                                <select id="idLAPED" name="idLAPED" class="form-control">
                                    <option value="">Seleccione</option>
                                    @if ($alineaciones != null)
                                        @php
                                            $lineas = LineaPED::join(
                                                'estrategiaped',
                                                'estrategiaped.idEstrategiaPED',
                                                '=',
                                                'lineaaccionped.idEstrategiaPED',
                                            )
                                                ->join(
                                                    'objetivoped',
                                                    'objetivoped.idObjetivoPED',
                                                    '=',
                                                    'estrategiaped.idObjetivoPED',
                                                )
                                                ->where('objetivoped.idObjetivoPED', $alineaciones->idObjetivoPED)
                                                ->get();
                                        @endphp
                                        @foreach ($lineas as $linea)
                                            <option value="{{ $linea->idLAPED }}">
                                                {{ $linea->laPEDClave . ' - ' . $linea->laPEDDescripcion }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td style="width:15%;font-size:.3em;text-align:center">
                                <button class="btn btn-success" onclick="addLinea()"><i
                                        class="fas fa-arrow-down"></i> Agregarla</button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: center">
                                <center>
                                    <div style="background-color: rgb(243,203,215)">
                                        <b>Líneas que atiende el PPA</b>
                                    </div>
                                    <table style="width: 100%;max-height:300px;overflow:scroll;border:solid 1px gray"
                                        class="table striped">
                                        <thead>
                                            <tr style="text-align: center;">
                                                <th class="enc1" style="width: 5%;border:solid 1px gray">id</th>
                                                <th class="enc1" style="border:solid 1px gray">Clave</th>
                                                <th class="enc1" style="border:solid 1px gray">Descripción</th>
                                                <th class="enc1" style="width: 15%;border:solid 1px gray">Opciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="lineasatiende">
                                            @if ($alineaciones != null)
                                                @if ($alineaciones->lineas != null)
                                                    @php
                                                        $lineas_array = explode('|', $alineaciones->lineas);
                                                        array_pop($lineas_array);
                                                        foreach ($lineas_array as $linea_) {
                                                            $infoLinea = LineaPED::where('idLAPED', $linea_)->first();
                                                            if ($infoLinea != null) {
                                                                echo "<tr id='linea" .
                                                                    $infoLinea->idLAPED .
                                                                    "'>" .
                                                                    "<td class='lineaatiende' idLA='" .
                                                                    $infoLinea->idLAPED .
                                                                    "' style='border:solid 1px gray;vertical-align:middle'>" .
                                                                    $infoLinea->idLAPED .
                                                                    '</td>' .
                                                                    "<td style='border:solid 1px gray;vertical-align:middle'>" .
                                                                    $infoLinea->laPEDClave .
                                                                    '</td>' .
                                                                    "<td style='border:solid 1px gray;vertical-align:middle'>" .
                                                                    $infoLinea->laPEDDescripcion .
                                                                    '</td>' .
                                                                    "<td style='border:solid 1px gray;text-align:center;vertical-align:middle'><button class='btn btn-danger' style='font-size:.9em;' onclick='quitLinea(" .
                                                                    $infoLinea->idLAPED .
                                                                    ")'><i class='fas fa-trash'></i> Quitar</button></td>" .
                                                                    '</tr>';
                                                            }
                                                        }
                                                    @endphp
                                                @endif
                                            @endif
                                        </tbody>
                                    </table>
                                    <div class="invalid-feedback" id="error_lineas">
                                        Debe Indicar la linea o lineas que atiende el PPA!
                                    </div>
                                    <div style="background-color: rgb(243,203,215)">
                                        <b>Ejes transversales que atiende el PPA</b>
                                    </div>
                                    <table style="width: 100%">
                                        <tr>
                                            <td
                                                style="width: 25%;border:solid 1px gray;text-align:center;vertical-align: top;">
                                                <input type="checkbox" style="transform: scale(1.2)" id="igualdad"
                                                    @if ($alineaciones != null) @if (str_contains($alineaciones->ejes_trans, 'igualdad')) checked @endif
                                                    @endif/><br />Igual de género
                                            </td>
                                            <td
                                                style="width:25%;border:solid 1px gray;text-align:center;vertical-align: top;">
                                                <input type="checkbox" style="transform: scale(1.2)" id="desarrollo"
                                                    @if ($alineaciones != null) @if (str_contains($alineaciones->ejes_trans, 'desarrollo')) checked @endif
                                                    @endif/><br />Desarrollo sostenible y cambio
                                                climático
                                            </td>
                                            <td
                                                style="width: 25%;border:solid 1px gray;text-align:center;vertical-align:top">
                                                <input type="checkbox" style="transform: scale(1.2)"
                                                    id="interculturalidad"
                                                    @if ($alineaciones != null) @if (str_contains($alineaciones->ejes_trans, 'interculturalidad')) checked @endif
                                                    @endif/><br />Interculturalidad
                                            </td>
                                            <td
                                                style="width: 25%;border:solid 1px gray;text-align:center;vertical-align:top">
                                                <input type="checkbox" style="transform: scale(1.2)" id="ninas"
                                                    @if ($alineaciones != null) @if (str_contains($alineaciones->ejes_trans, 'ninas')) checked @endif
                                                    @endif/><br />Niñas, niños y adolescentes
                                            </td>
                                        </tr>
                                    </table>
                                </center>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-12" style="padding:20px;">
            <div class="card shadow">
                <div class="card-header py-3" style="background-color:rgb(157, 36, 73);color:white">
                    <h6 class="m-0 font-weight-bold text-light" onclick="toggle('chevsector','body-sector')"
                        style="cursor: pointer;color:white">Alineación a los planes Sectoriales <i
                            class="fas fa-chevron-down" id="chevsector"></i>
                    </h6>
                </div>
                <div class="card-body" id="body-sector">
                    <table style="width: 100%">
                        <tr>
                            <td class="enc1" style="width:15%">
                                Sector / Plan Especial: <span style="color: red">*</span>
                            </td>
                            <td colspan="2">
                                <select id="idSector" name="idSector" class="form-control"
                                    onchange="getObjetivosSector()">
                                    <option value="">Seleccione</option>
                                    @foreach ($sectores as $sector)
                                        <option value="{{ $sector->idSector }}"
                                            @if ($alineaciones != null) @if ($alineaciones->idSector == $sector->idSector)
                                                     selected @endif
                                            @endif
                                            >{{ $sector->claveSector . ' - ' . $sector->sector }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Debe Indicar el Sector al que se alinea el PPA
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="enc1" style="width:15%">
                                Objetivo: <span style="color: red">*</span>
                            </td>
                            <td colspan="2">
                                <select id="idObjetivoSector" name="idObjetivoSector" class="form-control"
                                    onchange="getEstrategiasSector()">
                                    <option value="">Seleccione</option>
                                    @if ($alineaciones != null > 0)
                                        @php
                                            $objetivosSector = ObjetivoSector::join(
                                                'subsectores',
                                                'subsectores.idSubsector',
                                                '=',
                                                'objetivosector.idSubsector',
                                            )
                                                ->join('sectores', 'sectores.idSector', '=', 'subsectores.idSector')
                                                ->where('sectores.idSector', $alineaciones->idSector)
                                                ->get();
                                        @endphp
                                        @foreach ($objetivosSector as $objetivo)
                                            <option value="{{ $objetivo->idObjetivo }}"
                                                @if ($objetivo->idObjetivo == $alineaciones->idObjetivoSector) selected @endif>
                                                {{ $objetivo->claveObjetivo . ' - ' . $objetivo->objetivo }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback">
                                    Debe Indicar el Objetivo al que se alinea el PPA
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="enc1" style="width:15%">
                                Estrategia: <span style="color: red">*</span>
                            </td>
                            <td colspan="2">
                                <select id="idEstrategiaSector" name="idEstrategiaSector" class="form-control"
                                    onchange="getProductosSector()">
                                    <option value="">Seleccione</option>
                                    @if ($alineaciones != null > 0)
                                        @php
                                            $estrategiasSector = EstrategiaSector::where(
                                                'idObjetivo',
                                                $alineaciones->idObjetivoSector,
                                            )->get();
                                        @endphp
                                        @foreach ($estrategiasSector as $estrategia)
                                            <option value="{{ $estrategia->idEstrategia }}"
                                                @if ($estrategia->idEstrategia == $alineaciones->idEstrategiaSector) selected @endif>
                                                {{ $estrategia->claveEstrategia . ' - ' . $estrategia->estrategia }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback">
                                    Debe Indicar el Objetivo al que se alinea el PPA
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="enc1" style="width:15%">
                                Producto: <span style="color: red">*</span>
                            </td>
                            <td colspan="2">
                                <select id="idProductoSector" name="idProductoSector" class="form-control">
                                    <option value="">Seleccione</option>
                                    @if ($alineaciones != null > 0)
                                        @php
                                            $productosSector = ProductoSector::where(
                                                'idEstrategia',
                                                $alineaciones->idEstrategiaSector,
                                            )->get();
                                        @endphp
                                        @foreach ($productosSector as $producto)
                                            <option value="{{ $producto->idProducto }}"
                                                @if ($producto->idProducto == $alineaciones->idProductoSector) selected @endif>
                                                {{ $producto->claveProducto . ' - ' . $producto->producto }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback">
                                    Debe Indicar el producto que atiende el PPA
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-12" style="padding:20px;">
            <div class="card shadow">
                <div class="card-header py-3" style="background-color:rgb(157, 36, 73);color:white">
                    <h6 class="m-0 font-weight-bold text-light" onclick="toggle('chevindicadores','body-indicadoressiibien')"
                        style="cursor: pointer;color:white">Alineación a los Indicadores Estratégicos SIIBIEN <i
                            class="fas fa-chevron-down" id="chevindicadores"></i>
                    </h6>
                </div>
                <div class="card-body" id="body-indicadoressiibien">
                    <table style="width: 100%">
                        <tr>
                            <td class="enc1" style="width:15%">
                                Indicador Estratégico: <span style="color: red">*</span>
                            </td>
                            <td colspan="2">
                                <select id="idIndicador" name="idIndicador" class="form-control">
                                    <option value="">Seleccione</option>
                                    @foreach ($indicadores as $indicador)
                                        <option value="{{ $indicador->idIndicador }}"                                            
                                            >{{ $indicador->idIndicador . ' - ' . $indicador->indicadorNombre }}</option>
                                    @endforeach
                                </select>                                
                            </td>
                            <td style="width:15%;text-align:center">
                                <button class="btn btn-success" onclick="agregarIndicador()"><i class="fas fa-arrow-down"></i> Agregarlo</button>
                            </td>
                        </tr>  
                        <tr>
                            <td colspan="4">
                                <table style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th class="enc1" style="border: solid 1px gray;width:10%;text-align:center">Id</th>
                                            <th class="enc1" style="border: solid 1px gray;text-align:center">Indicador</th>
                                            <th class="enc1" style="border: solid 1px gray;width:15%;text-align:center">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body-indicadores" style="color:gray">
                                        @php
                                            $empty = false;
                                        @endphp
                                        @if ($alineaciones != null)                                            
                                            @if ($alineaciones->i_estrategicos != null )                                            
                                                @php 
                                                    $empty=true;  
                                                    //obtenemos los indicadores registrados.
                                                    $indicadores_cadena = explode("|",$alineaciones->i_estrategicos);
                                                    array_pop($indicadores_cadena);                                                
                                                @endphp
                                                @foreach($indicadores_cadena as $in)
                                                    @php
                                                        $infoIndicador = Indicador::where("idIndicador",$in)->first();
                                                    @endphp
                                                    <tr id="rowindicador{{$infoIndicador->idIndicador}}" class="indicador" indicador="{{$infoIndicador->idIndicador}}">
                                                        <td style='text-align:center;border:solid 1px gray'>{{$infoIndicador->idIndicador}}</td>
                                                        <td style='border:solid 1px gray'>{{$infoIndicador->indicadorNombre}}</td>
                                                        <td style='text-align:center;border:solid 1px gray'><button class='btn btn-danger' onclick='removeIndicador({{$infoIndicador->idIndicador}})'><i class='fas fa-trash'></i> Quitar</button></td>
                                                    </tr>
                                                @endforeach
                                            @else                                            
                                                @php $empty=false; @endphp
                                            @endif
                                        @endif
                                        <tr id="emptyIndicadores" style="@if($empty) display:none @endif">
                                            <td colspan="3" style="text-align: center;border:solid 1px gray;">No existen Indicadores Alineados a este PPA</td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </td>                            
                        </tr>                     
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
        <div class="col-lg-12" style="padding:5px;">
            <div class="card shadow">
                <div class="card-header py-3" style="background-color:rgb(157, 36, 73);color:white">
                    <h6 class="m-0 font-weight-bold text-light" onclick="toggle('chevbs','body-bs')"
                        style="cursor: pointer;color:white">Bienes o Servicios Registrados <i
                            class="fas fa-chevron-down" id="chevindicadores"></i>
                    </h6>
                </div>
                <div class="card-body" id="body-bs">
                    <div id="listado-bs">
                        <div style="width:100%;padding:10px;text-align:right">
                            <button class="btn btn-success" onclick="agregabs()"><i class="fas fa-plus"></i> Agregar bien o servicio</button>
                        </div>
                        <div id="table-listado-bs">                            
                        </div>                        
                    </div>
                    <div id="registro-bs" style="display: none">
                        <div style="width:100%;text-align:right;padding:10px;">
                            <button class="btn btn-secondary" onclick="listadobs()"><i class="fas fa-arrow-left" ></i> Regresar al listado</button>
                        </div>                        
                            <h4 style="color:gray;padding-bottom:5px;">Datos generales del bien o servicio</h4>
                        <center>
                            <input id="idBS" type="hidden"/>
                            <table>
                                <tr>
                                    <td class="enc1" style="width:15%">Nombre:<span style="color: red">*</span></td>
                                    <td style="width: 30%">
                                        <textarea class="form-control" id="nombrebs" name="nombrebs" placeholder="Nombre del bien o servicio" style="color: black;"></textarea>
                                        <div class="invalid-feedback">
                                            Debe Indicar el nombre del bien o servicio
                                        </div>
                                    </td>
                                    <td class="enc1" style="width: 15%">Periodicidad de entrega: <span style="color: red">*</span>
                                    </td>
                                    <td style="width: 30%">
                                            <select name="p_entrega" id="p_entrega" class="form-control" onchange="potro()"
                                                style="color:black">
                                                <option value="">Seleccione...</option>
                                                <option value="mensual">
                                                    Mensual</option>
                                                <option value="bimestral">
                                                    Bimestral</option>
                                                <option value="trimestral">
                                                    Trimestral</option>
                                                <option value="anual">
                                                    Anual</option>
                                                <option value="no_aplica">
                                                    No Aplica</option>
                                                <option value="otro">Otro
                                                    (especificar)</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Debe Indicar la periodicidad de entrega
                                            </div>
                                            <input type="text" name="p_otro" id="p_otro" class="form-control"
                                                placeholder="Indique la Periodicidad"
                                                style="display: none; color:black"
                                                value="" />
                                            <div class="invalid-feedback">
                                                Debe Indicar cual es la periodicidad de entrega
                                            </div>
                                        </td>                                    
                                </tr>
                                <tr>
                                    <td class="enc1" style="width:15%">Descripción:<span style="color: red">*</span></td>
                                    <td style="width: 30%">
                                        <textarea class="form-control" id="descripcionbs" name="descripcionbs" placeholder="Descripción del bien o servicio" style="color: black;"></textarea>
                                        <div class="invalid-feedback">
                                            Debe indicar la descripción del bien o servicio
                                        </div>
                                    </td>                                                                                                    
                                    <td class="enc1" style="width:15%">Unidad de Medida:<span style="color: red">*</span></td>
                                    <td style="width: 30%">
                                        <input class="form-control" id="unidad_medida" name="unidad_medida" placeholder="Unidad de Medida" style="color: black;"/>
                                        <div class="invalid-feedback">
                                            Debe indicar la unidad de medida del bien o servicio
                                        </div>
                                    </td> 
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: right">
                                        <button class="btn btn-success" onclick="almacenabs()"><i class="fas fa-save"></i> Almacenar bien o servicio</button>
                                    </td>
                                </tr>
                            </table>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
