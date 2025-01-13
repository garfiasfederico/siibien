<h2>PPA: {{$ppa->id." - ".$ppa->nombre}}</h2>
<input type="hidden" id="idPPA" name="idPPA" value="{{$ppa->id}}"/>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
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
        <div style="padding:20px;">
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
                                        onclick="voidReglas()" style="transform:scale(1)" @if($ppa->tipo=="programa" || $ppa->tipo==null) checked @endif /> &nbsp; Programa
                                </td>
                                <td class="" colspan="" id="reglasDisplay"
                                    style="text-align: center; border:solid 1px rgb(218, 218, 218); @if($ppa->tipo!="programa" && $ppa->tipo!=null) display:none; @endif">
                                    <table style="width: 100%">
                                        <tr>
                                            <td rowspan="2">Reglas de Operación</td>
                                            <td rowspan=""><input type="radio" name="reglas" value="si"
                                                    id="reglassi" class="radio" style="transform:scale(1)" @if(($ppa->tipo=="programa" && $ppa->r_o == 1)|| $ppa->tipo==null) checked @endif
                                                    onclick="linkro()" />
                                                &nbsp; Si</td>
                                        </tr>
                                        <tr>
                                            <td><input type="radio" value="no" name="reglas" class="radio"
                                                    id="reglasno" style="transform:scale(1)" onclick="linkro()" @if($ppa->tipo=="programa" && $ppa->r_o == 0) checked @endif/>
                                                &nbsp; No</td>
                                        </tr>
                                    </table>
                                    <input type="text" style="width: 100%;@if($ppa->tipo!="programa" && $ppa->tipo!=null) display:none @endif"
                                        placeholder="Link de reglas de operación" class="form-control" id="link_r_o" @if($ppa->tipo=="programa" && $ppa->r_o == 1) value="{{$ppa->link_r_o}}" @endif>
                                    <div class="invalid-feedback">
                                        Debe Indicar el link de la reglas de operación.
                                    </div>
                                </td>
                                <td class="" colspan=""
                                    style="text-align: center;border:solid 1px rgb(218, 218, 218);">
                                    <input type="radio" name="tipo" value="proyecto" id="proyecto" class="radio" @if($ppa->tipo=="proyecto") checked @endif
                                        onclick="voidReglas()" style="transform:scale(1)" />
                                    &nbsp; Proyecto
                                </td>
                                <td class="" colspan="1"
                                    style="text-align: center;border:solid 1px rgb(218, 218, 218);">
                                    <input type="radio" name="tipo" value="accion" class="radio" id="accion" @if($ppa->tipo=="accion") checked @endif
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
                            placeholder="Indica el Objetivo del PPA">{{$ppa->objetivo}}</textarea>
                        <div class="invalid-feedback">
                            Debe Indicar el Objetivo del PPA
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="enc1" style="width: 15%">Descripción: <span style="color: red">*</span> <i
                            class="fas fa-question-circle"></i></td>
                    <td class="" colspan="3">
                        <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="2"
                            placeholder="Indica la Descripción del PPA">{{$ppa->descripcion}}</textarea>
                        <div class="invalid-feedback">
                            Debe Indicar la Descripción del PPA
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="enc1" style="width: 15%">Cobertura: <span style="color: red">*</span> <i
                            class="fas fa-question-circle"></i></td>
                    <td class="">
                        <select name="cobertura" id="cobertura" class="form-control">
                            <option value="">Seleccione...</option>
                            <option value="estatal" @if($ppa->cobertura=="estatal") selected @endif>Estatal</option>
                            <option value="regional" @if($ppa->cobertura=="regional") selected @endif>Regional</option>
                            <option value="municipal" @if($ppa->cobertura=="municipal") selected @endif>Municipal</option>
                        </select>
                        <div class="invalid-feedback">
                            Debe Indicar la cobertura del PPA
                        </div>
                    </td>
                    <td class="enc1" style="width: 15%">Periodicidad de entrega del Bien o
                        Servcio: <span style="color: red">*</span> <i class="fas fa-question-circle"></i></td>
                    <td>
                        <select name="p_entrega" id="p_entrega" class="form-control" onchange="potro()">
                            <option value="">Seleccione...</option>
                            <option value="mensual" @if($ppa->p_entrega=="mensual") selected @endif>Mensual</option>
                            <option value="bimestral" @if($ppa->p_entrega=="bimestral") selected @endif>Bimestral</option>
                            <option value="trimestral" @if($ppa->p_entrega=="trimestral") selected @endif>Trimestral</option>
                            <option value="anual" @if($ppa->p_entrega=="anual") selected @endif>Anual</option>
                            <option value="no_aplica" @if($ppa->p_entrega=="no_aplica") selected @endif>No Aplica</option>
                            <option value="otro" @if($ppa->p_entrega=="otro") selected @endif>Otro (especificar)</option>
                        </select>
                        <div class="invalid-feedback">
                            Debe Indicar la periodicidad de entrega
                        </div>
                        <input type="text" name="p_otro" id="p_otro" class="form-control"
                            placeholder="Indique la Periodicidad" style="@if($ppa->p_entrega!="otro") display: none" @endif value="{{$ppa->p_otro}}"/>
                        <div class="invalid-feedback">
                            Debe Indicar cual es la periodicidad de entrega
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="enc1" style="width: 15%">Año de Inicio: <span style="color: red">*</span><i
                            class="fas fa-question-circle"></i></td>
                    <td>
                        <input type="number" class="form-control" name="anio_inicio" id="anio_inicio" value="{{$ppa->anio_inicio}}" />
                        <div class="invalid-feedback">
                            Indique el año de inicio
                        </div>
                    </td>
                </tr>
            </table>
        </div>

    </div>
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
    </div>
    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
        <div class="col-lg-12" style="padding:20px;">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Alineación al PED
                    </h6>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
</div>
