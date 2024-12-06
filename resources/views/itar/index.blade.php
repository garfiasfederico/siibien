@extends('layouts.administrador')
@section('encabezado')
    ITAR/Registro de PPA
@endsection
@section('content')
    @if (isset($itar))
        @if ($itar->estado == 'revision')
            <center>
                <div
                    style="text-align: center;width:300px;background-color:rgb(139, 139, 139);border-radius:10px;color:white;padding:15px">
                    <i class="fas fa-info-circle" style="font-size: 20pt"></i>
                    <p>Este PPA se encuentra en revisión por la ITE, favor de intentar más tarde!</p>
                </div>
            </center>
            @php
                goto end;
            @endphp
        @endif
    @endif

    <div class="row">

        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                    style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-light">Informe Trimestral de Avance y Resultados (ITAR)
                    </h6>
                </div>
                <!-- Card Body -->
                <div class="card-body" id="itarContent">
                    <table style="width: 100%">
                        <thead style="text-align: center">
                            <tr>
                                <th style="width:20%;padding:10px;border:dashed 1px rgb(226, 226, 226);" class="activo"
                                    id="indicador1">1. Datos Generales y Alineación al PED</th>
                                <th style="width:20%;padding:10px;border:dashed 1px rgb(226, 226, 226);" id="indicador2">2.
                                    Presupuesto</th>
                                <th style="width:20%;padding:10px;border:dashed 1px rgb(226, 226, 226);" id="indicador3">3.
                                    Bienes o Servicios, población beneficiada y distribución territorial</th>
                                <th style="width:20%;padding:10px;border:dashed 1px rgb(226, 226, 226);" id="indicador4">4.
                                    Impacto y Difusión</th>
                                <th style="width:20%;padding:10px;border:dashed 1px rgb(226, 226, 226);" id="indicador5">5.
                                    Medios de verificación</th>
                            </tr>
                        </thead>
                    </table>
                    <div style="width:100%; border:solid 1px green;padding:20px" id="itar1">
                        <input type="hidden" id="idITAR" value="{{ isset($itar) ? $itar->id : '' }}">
                        @csrf
                        <table style="width:100%">
                            <tr>
                                <td colspan="6" class="enc2" style="text-align: center">Datos Generales</td>
                            </tr>
                            <tr>
                                <td colspan="" class="enc1" style="text-align: center;width:15%">Folio:</td>
                                <td colspan="" class="resp" style="text-align: center;width:11.6%" id="folio">
                                    {{ isset($itar) ? $itar->folio : '' }}
                                </td>
                                <td colspan="" class="enc1" style="text-align: center;width:16.6%">Periodo que se
                                    reporta:</td>
                                <td colspan="" class="resp" style="text-align: center;width:29.8%">
                                    <table>
                                        <tr>
                                            <td>Mes-Inicio:</td>
                                            <td>
                                                <select name="mesinicio" id="mesinicio">
                                                    <option value="enero">Enero</option>
                                                    <option value="febrero">Febrero</option>
                                                    <option value="marzo">Marzo</option>
                                                    <option value="abril">Abril</option>
                                                    <option value="mayo">Mayo</option>
                                                    <option value="junio">Junio</option>
                                                    <option value="julio">Julio</option>
                                                    <option value="agosto">Agosto</option>
                                                    <option value="septiembre">Septiembre</option>
                                                    <option value="octubre">Octubre</option>
                                                    <option value="noviembre">Noviembre</option>
                                                    <option value="diciembre">Diciembre</option>
                                                </select>
                                            </td>
                                            <td>Mes-Final:</td>
                                            <td>
                                                <select name="mesfinal" id="mesfinal">
                                                    <option value="enero">Enero</option>
                                                    <option value="febrero">Febrero</option>
                                                    <option value="marzo">Marzo</option>
                                                    <option value="abril">Abril</option>
                                                    <option value="mayo">Mayo</option>
                                                    <option value="junio">Junio</option>
                                                    <option value="julio">Julio</option>
                                                    <option value="agosto">Agosto</option>
                                                    <option value="septiembre">Septiembre</option>
                                                    <option value="octubre">Octubre</option>
                                                    <option value="noviembre">Noviembre</option>
                                                    <option value="diciembre">Diciembre</option>
                                                </select>
                                            </td>
                                            <td>Año:</td>
                                            <td>
                                                <select name="anio" id="anio">
                                                    <option value="2023">2023</option>
                                                    <option value="2024" selected>2024</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td colspan="" class="enc1" style="text-align: center;width:16.6%">Fecha de Envío:
                                </td>
                                <td colspan="" class="resp" style="text-align: center;width:10%">
                                    {{ isset($itar) ? $itar->fecha_envio : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="enc1" title="Dependencia ó entidad que reporta"> Dependencia/Entidad:
                                    <span style="color: red">*</span>
                                    <br />
                                </td>
                                <td class="resp" colspan="6">
                                    <select class="form-control" name="dependencia" id="dependencia" disabled>
                                        @foreach ($dependencias as $dependencia)
                                            <option value="{{ $dependencia->idDependencia }}"
                                                @if ($dependencia->idDependencia == auth()->user()->enlace->idDependencia) selected @endif>
                                                {{ $dependencia->dependenciaNombre . ' (' . $dependencia->dependenciaSiglas . ')' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"
                                        style="width: 100%;background-color:rgb(255, 102, 102);color:white;border-radius:5px;text-align:center;padding:10px;">
                                        Debe seleccionar un periodo a reportar
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="enc1" title="Tipo de PPA"> Tipo:
                                    <span style="color: red">*</span>
                                    <br />
                                </td>
                                <td class="resp" colspan=""
                                    style="text-align: center;border-bottom:solid 1px rgb(218, 218, 218);">
                                    <input type="radio" name="tipo" value="programa" id="programa"
                                        onclick="voidReglas()" style="transform:scale(2)" checked /> &nbsp; Programa
                                </td>
                                <td class="resp" colspan=""
                                    style="text-align: center; border:solid 1px rgb(218, 218, 218);">
                                    <table>
                                        <tr>
                                            <td rowspan="2">Reglas de Operación</td>
                                            <td rowspan=""><input type="radio" name="reglas" value="si"
                                                    id="reglassi" class="radio" style="transform:scale(2)"
                                                    @if (isset($itar)) {{ $itar->reglas == 'si' ? 'checked' : '' }} @else checked @endif />
                                                &nbsp; Si</td>
                                        </tr>
                                        <tr>
                                            <td><input type="radio" value="no" name="reglas" class="radio"
                                                    id="reglasno" style="transform:scale(2)"
                                                    @if (isset($itar)) {{ $itar->reglas == 'no' ? 'checked' : '' }} @endif />
                                                &nbsp; No</td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="resp" colspan=""
                                    style="text-align: center;border:solid 1px rgb(218, 218, 218);">
                                    <input type="radio" name="tipo" value="proyecto" id="proyecto" class="radio"
                                        onclick="voidReglas()" style="transform:scale(2)"
                                        @if (isset($itar)) {{ $itar->tipo == 'proyecto' ? 'checked' : '' }} @endif />
                                    &nbsp; Proyecto
                                </td>
                                <td class="resp" colspan="2"
                                    style="text-align: center;border:solid 1px rgb(218, 218, 218);">
                                    <input type="radio" name="tipo" value="accion" class="radio" id="accion"
                                        onclick="voidReglas()" style="transform:scale(2)"
                                        @if (isset($itar)) {{ $itar->tipo == 'accion' ? 'checked' : '' }} @endif />
                                    &nbsp; Acción
                                </td>
                            </tr>
                            <tr>
                                <td class="enc1">Tipología del gasto:<span style="color: red">*</span></td>
                                <td colspan="5">
                                    <select name="tipologia" id="tipologia" class="form-control" onchange="showSObra()">
                                        <option value="">--Seleccione</option>
                                        <option value="inversion">Gasto de Inversión</option>
                                        <option value="operativo">Gasto Operativo</option>
                                    </select>
                                    <div class="invalid-feedback" style="">
                                        Debe Indicar la tipología del gasto
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="enc1">Nombre del Programa, Proyecto ó Acción (PPA):<span
                                        style="color: red">*</span></td>
                                <td colspan="5">
                                    <textarea class="form-control" style="width: 100%" name="nombre" id="nombre">{{ isset($itar) ? $itar->nombre : '' }}</textarea>
                                    <div class="invalid-feedback" style="">
                                        Debe Indicar un Nombre de PPA
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="enc1">Objetivo del PPA:<span style="color: red">*</span></td>
                                <td colspan="5">
                                    <textarea class="form-control" style="width: 100%" name="objetivo" id="objetivo">{{ isset($itar) ? $itar->objetivo : '' }}</textarea>
                                    <div class="invalid-feedback" style="">
                                        Debe Indicar el Objetivo del PPA
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="enc1">Descripción del PPA:<span style="color: red">*</span></td>
                                <td colspan="5">
                                    <textarea class="form-control" style="width: 100%" name="descripcion" id="descripcion">{{ isset($itar) ? $itar->descripcion : '' }}</textarea>
                                    <div class="invalid-feedback" style="">
                                        Debe Indicar la Descripción del PPA
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="enc1">Cobertura:<span style="color: red">*</span></td>
                                <td colspan="5">
                                    <select class="form-control" style="width: 100%" name="cobertura" id="cobertura">
                                        <option value="">--Seleccione</option>
                                        <option value="estatal">Estatal</option>
                                        <option value="municipal">Municipal</option>
                                        <option value="regional">Regional</option>
                                    </select>
                                    <div class="invalid-feedback" style="">
                                        Debe Indicar la Cobertura del PPA
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="enc1">Periodicidad del bien o servicio que se entrega:<span
                                        style="color: red">*</span></td>
                                <td colspan="5">
                                    <select class="form-control" style="width: 100%" name="periodicidad"
                                        id="periodicidad">
                                        <option value="">--Seleccione</option>
                                        <option value="mensual">Mensual</option>
                                        <option value="bimestral">Bimestral</option>
                                        <option value="trimestral">Trimestral</option>
                                        <option value="na">NA</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                    <div class="invalid-feedback" style="">
                                        Debe Indicar la Periodicidad de entrega
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="enc1">Año de inicio del PPA:<span style="color: red">*</span></td>
                                <td colspan="5">
                                    <select class="form-control" style="width: 100%" name="anio_inicio"
                                        id="anio_inicio">
                                        <option value="">--Seleccione</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                    </select>
                                    <div class="invalid-feedback" style="">
                                        Debe Indicar el año en el que inicia el PPA
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <table style="width:100%">
                            <tr>
                                <td colspan="6" class="enc2" style="text-align: center">Alineación al PED</td>
                            </tr>
                            <tr>
                                <td class="enc1" style="width: 15%">Eje:<span style="color: red">*</span></td>
                                <td colspan="4">
                                    <select name="idEjePED" id="idEjePED" class="form-control" onchange="getTemas()">
                                        <option value="">--Seleccione</option>
                                        @foreach ($ejes as $eje)
                                            <option value="{{ $eje->idEjePED }}">
                                                {{ $eje->idEjePED . '. ' . $eje->ejePEDDescripcion }}</option>
                                        @endforeach

                                    </select>
                                    <div class="invalid-feedback" style="">
                                        Seleccione un eje del PED
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="enc1" style="width: 15%">Tema:<span style="color: red">*</span></td>
                                <td colspan="4">
                                    <select name="idTemaPED" id="idTemaPED" class="form-control"
                                        onchange="getObjetivos()">
                                        <option value="">--Seleccione</option>
                                    </select>
                                    <div class="invalid-feedback" style="">
                                        Seleccione un tema del PED
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="enc1" style="width: 15%">Objetivo:<span style="color: red">*</span></td>
                                <td colspan="4">
                                    <select name="idObjetivoPED" id="idObjetivoPED" class="form-control"
                                        onchange="getEstrategias()">
                                        <option value="">--Seleccione</option>
                                    </select>
                                    <div class="invalid-feedback" style="">
                                        Seleccione un objetivo del PED
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="enc1" style="width: 15%">Estrategia:</td>
                                <td colspan="4">
                                    <select name="idEstrategiaPED" id="idEstrategiaPED" class="form-control"
                                        onchange="getLineas()">
                                        <option value="">--Seleccione</option>
                                    </select>
                                    <div class="invalid-feedback" style="">
                                        Seleccione una Estrategia del PED
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="enc1" style="width: 15%">Linea de Acción:</td>
                                <td colspan="4">
                                    <select name="idLAPED" id="idLAPED" class="form-control">
                                        <option value="">--Seleccione</option>
                                    </select>
                                    <div class="invalid-feedback" style="">
                                        Seleccione una línea de acción del PED
                                    </div>
                                </td>
                            </tr>
                            <tr rowspan="2">
                                <td class="enc1" style="width: 15%;">Eje(s) Transversal(es) en incide:</td>
                                <td style="text-align: center;border: solid 1px rgb(218, 218, 218);padding:20px;">
                                    <input type="checkbox" class="" name="igualdad" id="igualdad"
                                        style="transform:scale(2)" /> &nbsp; Igualdad de Género
                                </td>
                                <td style="text-align: center;border: solid 1px rgb(218, 218, 218);;">
                                    <input type="checkbox" class="" name="desarrollo" id="desarrollo"
                                        style="transform:scale(2)" /> &nbsp; Desarrollo Sostenible y Cambio Climático
                                </td>
                                <td style="text-align: center;border: solid 1px rgb(218, 218, 218);;">
                                    <input type="checkbox" class="" name="interculturalidad"
                                        id="interculturalidad" style="transform:scale(2)" /> &nbsp; Interculturalidad
                                </td>
                                <td style="text-align: center;border: solid 1px rgb(218, 218, 218);;">
                                    <input type="checkbox" class="" name="ninas" style="transform:scale(2)"
                                        id="ninas" /> &nbsp; Niñas, Niños y Adolescentes
                                </td>
                            </tr>
                            <tr style="display: none">
                                <td class="enc1" style="border-top:solid 1px #ff0000"></td>
                                <td colspan="4">
                                    <input id="transversales" type="hidden" />
                                    <div class="invalid-feedback" style="">
                                        Incide en algún eje transversal
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="enc1" style="width: 15%">Indicador Estratégico con el que se relaciona:
                                </td>
                                <td colspan="4">
                                    <select name="idIndicador" id="idIndicador" class="form-control">
                                        <option value="">--Seleccione</option>
                                        @foreach ($indicadores as $indicador)
                                            <option value="{{ $indicador->idIndicador }}">
                                                {{ '[' . $indicador->idIndicador . '] ' . $indicador->indicadorNombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" style="">
                                        Seleccione un Indicador al que se relaciona este PPA
                                    </div>
                                </td>
                            </tr>
                        </table>


                        <table style="width: 100%">
                            <tr>
                                <td style="width:50%;text-align:right;padding:15px"><button class="btn btn-primary"
                                        onclick="almacena1()">Almacenar y Siguiente</button></td>
                            </tr>
                        </table>
                    </div>
                    <div style="width:100%; border:solid 1px green;display:none;padding:20px" id="itar2">

                        <div id="presupuestos">

                            @if (isset($itar))
                                @if ($itarPresupuestos->count() > 0)
                                    @foreach ($itarPresupuestos as $presupuesto)
                                        <table style="width:100%" class="presupuesto">

                                            <tr>
                                                <td colspan="6" class="enc2" style="text-align: center">
                                                    Presupuesto<input type="hidden" class="idPresupuesto"
                                                        value="{{ $presupuesto->id }}"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="" style="text-align: right"><button
                                                        class="btn btn-danger" onclick="eliminaPresupuesto($(this))"><i
                                                            class="fas fa-trash"></i> Eliminar registro</button></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 15%" class="enc1">
                                                    Ejercicio: <span style="color: red">*</span>
                                                </td>
                                                <td colspan="5">
                                                    <select class="ejercicio form-control">
                                                        <option value="">--Seleccione</option>
                                                        <option value="2024"
                                                            {{ $presupuesto->ejercicio == '2024' ? 'selected' : '' }}>
                                                            2024
                                                        </option>
                                                    </select>
                                                    <div class="invalid-feedback" style="">
                                                        Seleccione un ejercicio
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 15%" class="enc1">
                                                    Programa Presupuestario: <span style="color: red">*</span>
                                                </td>
                                                <td colspan="5">
                                                    <select class="programa form-control">
                                                        <option value="">--Seleccione</option>
                                                        @foreach ($programas as $programa)
                                                            <option value="{{ $programa->idPrograma }}"
                                                                {{ $programa->idPrograma == $presupuesto->idPrograma ? 'selected' : '' }}>
                                                                {{ $programa->clavePrograma . ' ' . $programa->descripcionPrograma }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback" style="">
                                                        Seleccione el programa presupuestario
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 15%" class="enc1">
                                                    Fecha de Corte: <span style="color: red">*</span>
                                                </td>
                                                <td colspan="5">
                                                    <input type="date" class="fecha_corte form-control"
                                                        value="{{ $presupuesto->fecha_corte }}" />
                                                    <div class="invalid-feedback" style="">
                                                        Indique una fecha de corte
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="enc1" style="text-align: center">Federal
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="enc1" style="text-align: center">Presupuesto</td>
                                                <td class="enc1" style="text-align: center">enero-marzo</td>
                                                <td class="enc1" style="text-align: center">abril-junio</td>
                                                <td class="enc1" style="text-align: center">julio-septiembre</td>
                                                <td class="enc1" style="text-align: center">octubre-diciembre</td>
                                            </tr>
                                            <tr>
                                                <td class="enc1">Modificado</td>
                                                <td><input type="number" class="f1m form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()"
                                                        value="{{ $presupuesto->f1m }}" />
                                                    <div
                                                        style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                        $ <span class="f1m-f" style="width: 100%"> </span></div>
                                                </td>
                                                <td><input type="number" class="f2m form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()"
                                                        value="{{ $presupuesto->f2m }}" />
                                                    <div
                                                        style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                        $ <span class="f2m-f" style="width: 100%"> </span></div>
                                                </td>
                                                <td><input type="number" class="f3m form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()" readonly
                                                        value="{{ $presupuesto->f3m }}" />
                                                    <!--<div style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:black;color:white">$ <span class="f3m-f" style="width: 100%"> </span></div>-->
                                                </td>
                                                <td><input type="number" class="f4m form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()" readonly
                                                        value="{{ $presupuesto->f4m }}" />
                                                    <!--<div style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:black;color:white">$ <span class="f4m-f" style="width: 100%"> </span></div>-->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="enc1">Ejercido</td>
                                                <td><input type="number" class="f1e form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()"
                                                        value="{{ $presupuesto->f1e }}" />
                                                    <div
                                                        style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                        $ <span class="f1e-f" style="width: 100%"> </span></div>
                                                </td>
                                                <td><input type="number" class="f2e form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()"
                                                        value="{{ $presupuesto->f2e }}" />
                                                    <div
                                                        style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                        $ <span class="f2e-f" style="width: 100%"> </span></div>
                                                </td>
                                                <td><input type="number" class="f3e form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()" readonly
                                                        value="{{ $presupuesto->f3e }}" />
                                                    <!--<div style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:black;color:white">$ <span class="f3e-f" style="width: 100%"> </span></div>-->
                                                </td>
                                                <td><input type="number" class="f4e form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()" readonly
                                                        value="{{ $presupuesto->f4e }}" />
                                                    <!--<div style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:black;color:white">$ <span class="f4e-f" style="width: 100%"> </span></div>-->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="enc1">Porcentaje</td>
                                                <td class="pf1"></td>
                                                <td class="pf2"></td>
                                                <td class="pf3"></td>
                                                <td class="pf4"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="enc1" style="text-align: center">Estatal
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="enc1" style="text-align: center">Presupuesto</td>
                                                <td class="enc1" style="text-align: center">enero-marzo</td>
                                                <td class="enc1" style="text-align: center">abril-junio</td>
                                                <td class="enc1" style="text-align: center">julio-septiembre</td>
                                                <td class="enc1" style="text-align: center">octubre-diciembre</td>
                                            </tr>
                                            <tr>
                                                <td class="enc1">Modificado</td>
                                                <td><input type="number" class="e1m form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()"
                                                        value="{{ $presupuesto->e1m }}" />
                                                    <div
                                                        style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                        $ <span class="e1m-f" style="width: 100%"> </span></div>
                                                </td>
                                                <td><input type="number" class="e2m form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()"
                                                        value="{{ $presupuesto->e2m }}" />
                                                    <div
                                                        style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                        $ <span class="e2m-f" style="width: 100%"> </span></div>
                                                </td>
                                                <td><input type="number" class="e3m form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()" readonly
                                                        value="{{ $presupuesto->e3m }}" /></td>
                                                <td><input type="number" class="e4m form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()" readonly
                                                        value="{{ $presupuesto->e4m }}" /></td>
                                            </tr>
                                            <tr>
                                                <td class="enc1">Ejercido</td>
                                                <td><input type="number" class="e1e form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()"
                                                        value="{{ $presupuesto->e1e }}" />
                                                    <div
                                                        style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                        $ <span class="e1e-f" style="width: 100%"> </span></div>
                                                </td>
                                                <td><input type="number" class="e2e form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()"
                                                        value="{{ $presupuesto->e2e }}" />
                                                    <div
                                                        style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                        $ <span class="e2e-f" style="width: 100%"> </span></div>
                                                </td>
                                                <td><input type="number" class="e3e form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()" readonly
                                                        value="{{ $presupuesto->e3e }}" /></td>
                                                <td><input type="number" class="e4e form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()" readonly
                                                        value="{{ $presupuesto->e4e }}" /></td>
                                            </tr>
                                            <tr>
                                                <td class="enc1">Porcentaje</td>
                                                <td class="pe1"></td>
                                                <td class="pe2"></td>
                                                <td class="pe3"></td>
                                                <td class="pe4"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="enc1" style="text-align: center">
                                                    Municipal</td>
                                            </tr>
                                            <tr>
                                                <td class="enc1" style="text-align: center">Presupuesto</td>
                                                <td class="enc1" style="text-align: center">enero-marzo</td>
                                                <td class="enc1" style="text-align: center">abril-junio</td>
                                                <td class="enc1" style="text-align: center">julio-septiembre</td>
                                                <td class="enc1" style="text-align: center">octubre-diciembre</td>
                                            </tr>
                                            <tr>
                                                <td class="enc1">Modificado</td>
                                                <td><input type="number" class="m1m form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()"
                                                        value="{{ $presupuesto->m1m }}" />
                                                    <div
                                                        style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                        $ <span class="m1m-f" style="width: 100%"> </span></div>
                                                </td>
                                                <td><input type="number" class="m2m form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()"
                                                        value="{{ $presupuesto->m2m }}" />
                                                    <div
                                                        style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                        $ <span class="m2m-f" style="width: 100%"> </span></div>
                                                </td>
                                                <td><input type="number" class="m3m form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()" readonly
                                                        value="{{ $presupuesto->m3m }}" /></td>
                                                <td><input type="number" class="m4m form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()" readonly
                                                        value="{{ $presupuesto->m4m }}" /></td>
                                            </tr>
                                            <tr>
                                                <td class="enc1">Ejercido</td>
                                                <td><input type="number" class="m1e form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()"
                                                        value="{{ $presupuesto->m1e }}" />
                                                    <div
                                                        style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                        $ <span class="m1e-f" style="width: 100%"> </span></div>
                                                </td>
                                                <td><input type="number" class="m2e form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()"
                                                        value="{{ $presupuesto->m2e }}" />
                                                    <div
                                                        style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                        $ <span class="m2e-f" style="width: 100%"> </span></div>
                                                </td>
                                                <td><input type="number" class="m3e form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()" readonly
                                                        value="{{ $presupuesto->m3e }}" /></td>
                                                <td><input type="number" class="m4e form-control"
                                                        style="text-align: right" onchange="refreshPorcentajes()" readonly
                                                        value="{{ $presupuesto->m4e }}" /></td>
                                            </tr>
                                            <tr>
                                                <td class="enc1">Porcentaje</td>
                                                <td class="pm1"></td>
                                                <td class="pm2"></td>
                                                <td class="pm3"></td>
                                                <td class="pm4"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="enc1" style="text-align: center">Total
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="enc1" style="text-align: center">Presupuesto</td>
                                                <td class="enc1" style="text-align: center">enero-marzo</td>
                                                <td class="enc1" style="text-align: center">abril-junio</td>
                                                <td class="enc1" style="text-align: center">julio-septiembre</td>
                                                <td class="enc1" style="text-align: center">octubre-diciembre</td>
                                            </tr>
                                            <tr>
                                                <td class="enc1">Modificado</td>
                                                <td class="t1m"></td>
                                                <td class="t2m"></td>
                                                <td class="t3m"></td>
                                                <td class="t4m"></td>
                                            </tr>
                                            <tr>
                                                <td class="enc1">Ejercido</td>
                                                <td class="t1e"></td>
                                                <td class="t2e"></td>
                                                <td class="t3e"></td>
                                                <td class="t4e"></td>
                                            </tr>
                                            <tr>
                                                <td class="enc1">Porcentaje</td>
                                                <td class="pt1"></td>
                                                <td class="pt2"></td>
                                                <td class="pt3"></td>
                                                <td class="pt4"></td>
                                            </tr>
                                        </table>
                                    @endforeach
                                @endif
                            @else
                                <table style="width:100%" class="presupuesto">

                                    <tr>
                                        <td colspan="6" class="enc2" style="text-align: center">
                                            Presupuesto<input type="hidden" class="idPresupuesto" value="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="" style="text-align: right"><button
                                                class="btn btn-danger" onclick="eliminaPresupuesto($(this))"><i
                                                    class="fas fa-trash"></i> Eliminar registro</button></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%" class="enc1">
                                            Ejercicio: <span style="color: red">*</span>
                                        </td>
                                        <td colspan="5">
                                            <select class="ejercicio form-control">
                                                <option value="">--Seleccione</option>
                                                <option value="2024" selected>2024</option>
                                            </select>
                                            <div class="invalid-feedback" style="">
                                                Seleccione un ejercicio
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%" class="enc1">
                                            Programa Presupuestario: <span style="color: red">*</span>
                                        </td>
                                        <td colspan="5">
                                            <select class="programa form-control">
                                                <option value="">--Seleccione</option>
                                                @foreach ($programas as $programa)
                                                    <option value="{{ $programa->idPrograma }}">
                                                        {{ $programa->clavePrograma . ' ' . $programa->descripcionPrograma }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback" style="">
                                                Seleccione el programa presupuestario
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%" class="enc1">
                                            Fecha de Corte: <span style="color: red">*</span>
                                        </td>
                                        <td colspan="5">
                                            <input type="date" class="fecha_corte form-control"
                                                value="{{ date('Y-m-d') }}" />
                                            <div class="invalid-feedback" style="">
                                                Indique una fecha de corte
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="enc1" style="text-align: center">Federal</td>
                                    </tr>
                                    <tr>
                                        <td class="enc1" style="text-align: center">Presupuesto</td>
                                        <td class="enc1" style="text-align: center">enero-marzo</td>
                                        <td class="enc1" style="text-align: center">abril-junio</td>
                                        <td class="enc1" style="text-align: center">julio-septiembre</td>
                                        <td class="enc1" style="text-align: center">octubre-diciembre</td>
                                    </tr>
                                    <tr>
                                        <td class="enc1">Modificado</td>
                                        <td><input type="number" class="f1m form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" />
                                            <div
                                                style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                $ <span class="f1m-f" style="width: 100%"> </span></div>
                                        </td>
                                        <td><input type="number" class="f2m form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" />
                                            <div
                                                style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                $ <span class="f2m-f" style="width: 100%"> </span></div>
                                        </td>
                                        <td><input type="number" class="f3m form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" readonly /></td>
                                        <td><input type="number" class="f4m form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" readonly /></td>
                                    </tr>
                                    <tr>
                                        <td class="enc1">Ejercido</td>
                                        <td><input type="number" class="f1e form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" />
                                            <div
                                                style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                $ <span class="f1e-f" style="width: 100%"> </span></div>
                                        </td>
                                        <td><input type="number" class="f2e form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" />
                                            <div
                                                style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                $ <span class="f2e-f" style="width: 100%"> </span></div>
                                        </td>
                                        <td><input type="number" class="f3e form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" readonly /></td>
                                        <td><input type="number" class="f4e form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" readonly /></td>
                                    </tr>
                                    <tr>
                                        <td class="enc1">Porcentaje</td>
                                        <td class="pf1"></td>
                                        <td class="pf2"></td>
                                        <td class="pf3"></td>
                                        <td class="pf4"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="enc1" style="text-align: center">Estatal</td>
                                    </tr>
                                    <tr>
                                        <td class="enc1" style="text-align: center">Presupuesto</td>
                                        <td class="enc1" style="text-align: center">enero-marzo</td>
                                        <td class="enc1" style="text-align: center">abril-junio</td>
                                        <td class="enc1" style="text-align: center">julio-septiembre</td>
                                        <td class="enc1" style="text-align: center">octubre-diciembre</td>
                                    </tr>
                                    <tr>
                                        <td class="enc1">Modificado</td>
                                        <td><input type="number" class="e1m form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" />
                                            <div
                                                style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                $ <span class="e1m-f" style="width: 100%"> </span></div>
                                        </td>
                                        <td><input type="number" class="e2m form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" />
                                            <div
                                                style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                $ <span class="e2m-f" style="width: 100%"> </span></div>
                                        </td>
                                        <td><input type="number" class="e3m form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" readonly /></td>
                                        <td><input type="number" class="e4m form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" readonly /></td>
                                    </tr>
                                    <tr>
                                        <td class="enc1">Ejercido</td>
                                        <td><input type="number" class="e1e form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" />
                                            <div
                                                style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                $ <span class="e1e-f" style="width: 100%"> </span></div>
                                        </td>
                                        <td><input type="number" class="e2e form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" />
                                            <div
                                                style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                $ <span class="e2e-f" style="width: 100%"> </span></div>
                                        </td>
                                        <td><input type="number" class="e3e form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" readonly /></td>
                                        <td><input type="number" class="e4e form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" readonly /></td>
                                    </tr>
                                    <tr>
                                        <td class="enc1">Porcentaje</td>
                                        <td class="pe1"></td>
                                        <td class="pe2"></td>
                                        <td class="pe3"></td>
                                        <td class="pe4"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="enc1" style="text-align: center">Municipal</td>
                                    </tr>
                                    <tr>
                                        <td class="enc1" style="text-align: center">Presupuesto</td>
                                        <td class="enc1" style="text-align: center">enero-marzo</td>
                                        <td class="enc1" style="text-align: center">abril-junio</td>
                                        <td class="enc1" style="text-align: center">julio-septiembre</td>
                                        <td class="enc1" style="text-align: center">octubre-diciembre</td>
                                    </tr>
                                    <tr>
                                        <td class="enc1">Modificado</td>
                                        <td><input type="number" class="m1m form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" />
                                            <div
                                                style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                $ <span class="m1m-f" style="width: 100%"> </span></div>
                                        </td>
                                        <td><input type="number" class="m2m form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" />
                                            <div
                                                style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                $ <span class="m2m-f" style="width: 100%"> </span></div>
                                        </td>
                                        <td><input type="number" class="m3m form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" readonly /></td>
                                        <td><input type="number" class="m4m form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" readonly /></td>
                                    </tr>
                                    <tr>
                                        <td class="enc1">Ejercido</td>
                                        <td><input type="number" class="m1e form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" />
                                            <div
                                                style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                $ <span class="m1e-f" style="width: 100%"> </span></div>
                                        </td>
                                        <td><input type="number" class="m2e form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" />
                                            <div
                                                style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">
                                                $ <span class="m2e-f" style="width: 100%"> </span></div>
                                        </td>
                                        <td><input type="number" class="m3e form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" readonly /></td>
                                        <td><input type="number" class="m4e form-control" style="text-align: right"
                                                onchange="refreshPorcentajes()" readonly /></td>
                                    </tr>
                                    <tr>
                                        <td class="enc1">Porcentaje</td>
                                        <td class="pm1"></td>
                                        <td class="pm2"></td>
                                        <td class="pm3"></td>
                                        <td class="pm4"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="enc1" style="text-align: center">Total</td>
                                    </tr>
                                    <tr>
                                        <td class="enc1" style="text-align: center">Presupuesto</td>
                                        <td class="enc1" style="text-align: center">enero-marzo</td>
                                        <td class="enc1" style="text-align: center">abril-junio</td>
                                        <td class="enc1" style="text-align: center">julio-septiembre</td>
                                        <td class="enc1" style="text-align: center">octubre-diciembre</td>
                                    </tr>
                                    <tr>
                                        <td class="enc1">Modificado</td>
                                        <td class="t1m"></td>
                                        <td class="t2m"></td>
                                        <td class="t3m"></td>
                                        <td class="t4m"></td>
                                    </tr>
                                    <tr>
                                        <td class="enc1">Ejercido</td>
                                        <td class="t1e"></td>
                                        <td class="t2e"></td>
                                        <td class="t3e"></td>
                                        <td class="t4e"></td>
                                    </tr>
                                    <tr>
                                        <td class="enc1">Porcentaje</td>
                                        <td class="pt1"></td>
                                        <td class="pt2"></td>
                                        <td class="pt3"></td>
                                        <td class="pt4"></td>
                                    </tr>
                                </table>
                            @endif
                        </div>
                        <div style="padding: 10px;text-align:right">
                            <button type="button" class="btn btn-success" onclick="addPresupuesto()"><i
                                    class="fas fa-plus"></i> Agregar otro programa presupuestario</button>
                        </div>
                        <table style="width: 100%">
                            <tr>
                                <td style="width:50%;text-align:right;padding:15px"><button class="btn btn-secondary"
                                        onclick="before(1)">Atrás</button> <button class="btn btn-primary"
                                        onclick="almacena2()">Almacenar y Siguiente</button></td>

                            </tr>
                        </table>
                    </div>
                    <div style="width:100%; border:solid 1px green;display:none;padding:20px" id="itar3">
                        <div id="body_bs">
                            @if (isset($itarBS))
                                @if ($itarBS->count() > 0)
                                    @foreach ($itarBS as $bs)
                                        <table style="width:100%" class="BS">
                                            <tr>
                                                <td colspan="6" class="enc2" style="text-align: center">Bienes o
                                                    servicios que se entregan<input type="hidden" class="idBS"
                                                        value="{{ $bs->id }}" /></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="" style="text-align: right"><button
                                                        class="btn btn-danger" onclick="removeBS($(this))"><i
                                                            class="fas fa-trash"></i> Eliminar bien o servicio</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="enc1" style="width:15%">Descripcion del bien o servicio:
                                                    <span style="color: red">*</span></td>
                                                <td colspan="2">
                                                    <textarea name="descripcion_bs" class="form-control descripcion_bs">{{ $bs->descripcion_bs }}</textarea>
                                                    <div class="invalid-feedback" style="">
                                                        Indique una descripción del Bien o servicio
                                                    </div>
                                                </td>
                                                <td class="enc1">Unidad de medida: <span style="color: red">*</span>
                                                </td>
                                                <td><input type="text" class="form-control unidad_bs" name="unidad_bs"
                                                        value="{{ $bs->unidad_bs }}" />
                                                    <div class="invalid-feedback" style="">
                                                        Indique la Unidad de medida
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="enc1">Cantidad</td>
                                                <td class="enc1" style="width: 21.25%">enero-marzo</td>
                                                <td class="enc1" style="width: 21.25%">abril-junio</td>
                                                <td class="enc1" style="width: 21.25%">julio-septiembre</td>
                                                <td class="enc1" style="width: 21.25%">octubre-diciembre</td>
                                            </tr>
                                            <tr>
                                                <td class="enc1">Programada</td>
                                                <td>
                                                    <input type="number" class="form-control bs1p" name="bs1p"
                                                        onchange="refreshBienes()" value="{{ $bs->bs1p }}">
                                                    <div class="invalid-feedback" style="">
                                                        Indique la cantidad programa para el 1er trimestre
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control bs2p" name="bs2p"
                                                        onchange="refreshBienes()" value="{{ $bs->bs2p }}">
                                                    <div class="invalid-feedback" style="">
                                                        Indique la cantidad programa para el 2do trimestre
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control bs3p" name="bs3p"
                                                        onchange="refreshBienes()" value="{{ $bs->bs3p }}">
                                                    <div class="invalid-feedback" style="">
                                                        Indique la cantidad programa para el 3er trimestre
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control bs4p" name="bs4p"
                                                        onchange="refreshBienes()" value="{{ $bs->bs4p }}">
                                                    <div class="invalid-feedback" style="">
                                                        Indique la cantidad programa para el 4to trimestre
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="enc1">Entregada</td>
                                                <td>
                                                    <input type="number" class="form-control bs1r" name="bs1r"
                                                        onchange="refreshBienes()" value="{{ $bs->bs1r }}">
                                                    <div class="invalid-feedback" style="">
                                                        Indique la cantidad entregada para el 1er trimestre
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control bs2r" name="bs2r"
                                                        onchange="refreshBienes()" value="{{ $bs->bs2r }}">
                                                    <div class="invalid-feedback" style="">
                                                        Indique la cantidad entregada para el 2do trimestre
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control bs3r" name="bs3r"
                                                         onchange="refreshBienes()" value="{{ $bs->bs3r }}">
                                                    <div class="invalid-feedback" style="">
                                                        Indique la cantidad entregada para el 3er trimestre
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control bs4r" name="bs4r"
                                                         onchange="refreshBienes()" value="{{ $bs->bs4r }}">
                                                    <div class="invalid-feedback" style="">
                                                        Indique la cantidad entregada para el 4to trimestre
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="enc1">Porcentaje de avance</td>
                                                <td class="pa1" style="text-align:right"></td>
                                                <td class="pa2" style="text-align:right"></td>
                                                <td class="pa3" style="text-align:right"></td>
                                                <td class="pa4" style="text-align:right"></td>
                                            </tr>
                                        </table>
                                    @endforeach
                                @endif
                            @endif
                        </div>
                        <div style="width: 100%;text-align:right;padding:10px">
                            <button class="btn btn-success" onclick="addBS()"><i class="fas fa-plus"></i> Agregar Bien
                                o Servicio entregado</button>
                        </div>

                                <div style="width: 100%;@if(isset($itar))@if($itar->tipologia_gasto!="inversion")display:none;@endif @endif" id="seguimiento_obras"
                                >
                                    <table style="width:100%"
                                        <tr>
                                            <td colspan="6" style="text-align: center" class="enc2">Seguimiento de Obras</td>
                                        </tr>
                                        <tr>
                                            <td class="enc1" style="width: 20%">
                                                Total de Obras autorizadas:
                                            </td>
                                            <td style="width:14%">
                                                <input type="number" class="form-control" id="o_a" onchange="freshObras()" value="@if(isset($itar)){{$itar->o_a}}@endif"/>
                                                <div class="invalid-feedback" style="">
                                                    Indique las obras totales autorizadas
                                                </div>
                                            </td>
                                            <td class="enc1" style="width: 20%">
                                                Total de Obras ejecutadas:
                                            </td>
                                            <td style="width:13%">
                                                <input type="number" class="form-control" id="o_e" onchange="freshObras()" value="@if(isset($itar)){{$itar->o_e}}@endif"/>
                                                <div class="invalid-feedback" style="">
                                                    Indique los obras totales ejecutadas
                                                </div>
                                            </td>
                                            <td class="enc1" style="width: 20%">Porcentaje de Avance</td>
                                            <td style="width:14%;text-align:center">
                                                <b id="pobra"></b>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                        <table style="width:100%">
                            <tr>
                                <td colspan="9" class="enc2" style="text-align: center">Población beneficiada
                                </td>
                            </tr>
                            <tr>
                                <td class="enc1" style="width:15%">Tipo de población: <span
                                        style="color: red">*</span>
                                </td>
                                <td colspan="4">
                                    <select name="idPoblacion" id="idPoblacion" class="form-control">
                                        <option value="">--Seleccione</option>
                                        @foreach ($poblacion as $pobla)
                                            <option value="{{ $pobla->id }}">{{ $pobla->descripcion }}</option>
                                        @endforeach

                                    </select>
                                    <div class="invalid-feedback" style="">
                                        Indique un tipo de población beneficiaria
                                    </div>
                                </td>
                                <td class="enc1">Descripción de la población beneficiaria: <span
                                        style="color: red">*</span></td>
                                <td colspan="3"><input type="text" class="form-control" name="descripcion_pb"
                                        id="descripcion_pb" value="{{ isset($itar) ? $itar->descripcion_pb : '' }}" />
                                    <div class="invalid-feedback" style="">
                                        Indique una descripción de la población beneficiaria
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="enc1" style="width:15%">Población objetivo: <span
                                        style="color: red">*</span></td>
                                <td colspan="4">
                                    <input type="number" id="po" class="form-control" readonly>
                                    <div class="invalid-feedback" style="">
                                        Indique el total de la población objetivo
                                    </div>
                                </td>
                                <td class="enc1">Mujeres: <span style="color: red">*</span></td>
                                <td><input type="number" class="form-control" name="po_m" id="po_m"
                                        onchange="refreshPoblaciono()" value="{{ isset($itar) ? $itar->po_m : '' }}" />
                                    <div class="invalid-feedback" style="">
                                        Indique la cantidad de mujeres beneficiadas
                                    </div>
                                </td>
                                <td class="enc1">Hombres: <span style="color: red">*</span></td>
                                <td><input type="number" class="form-control" name="po_h" id="po_h"
                                        onchange="refreshPoblaciono()" value="{{ isset($itar) ? $itar->po_h : '' }}" />
                                    <div class="invalid-feedback" style="">
                                        Indique la cantidad de hombres beneficiados
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="enc1" rowspan="4" style="text-align: left">Población beneficiada por
                                    trimestre <span style="color: red">*</span></td>
                                <td class="enc1" colspan="2" style="text-align: center;width:21.25%">enero-marzo
                                </td>
                                <td class="enc1" colspan="2" style="text-align: center;width:21.25%">abril-junio
                                </td>
                                <td class="enc1" colspan="2" style="text-align: center;width:21.25%">
                                    julio-septiembre</td>
                                <td class="enc1" colspan="2" style="text-align: center;width:21.25%">
                                    octubre-dicimebre</td>
                            </tr>
                            <tr>
                                <td class="" colspan="2"><input type="number" id="pb1_t" readonly
                                        class="form-control"value="{{ isset($itar) ? $itar->pb1_t : '' }}" />
                                    <div class="invalid-feedback" style="">
                                        Indique la cantidad total de personas beneficiadas
                                    </div>
                                </td>
                                <td class="" colspan="2"><input type="number" id="pb2_t" readonly
                                        class="form-control" value="{{ isset($itar) ? $itar->pb2_t : '' }}" />
                                    <div class="invalid-feedback" style="">
                                        Indique la cantidad total de personas beneficiadas
                                    </div>
                                </td>
                                <td class="" colspan="2"><input type="number" id="pb3_t"
                                        class="form-control" readonly value="{{ isset($itar) ? $itar->pb3_t : '' }}" />
                                </td>
                                <td class="" colspan="2"><input type="number" id="pb4_t"
                                        class="form-control" readonly value="{{ isset($itar) ? $itar->pb4_t : '' }}" />
                                </td>
                            </tr>
                            <tr>
                                <td class="enc1" style="text-align: center">Mujeres</td>
                                <td class="enc1" style="text-align: center">Hombres</td>
                                <td class="enc1" style="text-align: center">Mujeres</td>
                                <td class="enc1" style="text-align: center">Hombres</td>
                                <td class="enc1" style="text-align: center">Mujeres</td>
                                <td class="enc1" style="text-align: center">Hombres</td>
                                <td class="enc1" style="text-align: center">Mujeres</td>
                                <td class="enc1" style="text-align: center">Hombres</td>
                            </tr>
                            <tr>
                                <td style="text-align: center"><input type="number" id="pb1_m"
                                        onchange="refreshPoblacionb()" class="form-control"
                                        value="{{ isset($itar) ? $itar->pb1_m : '' }}" />
                                    <div class="invalid-feedback" style="">
                                        Indique la cantidad de mujeres beneficiadas
                                    </div>
                                </td>
                                <td style="text-align: center"><input type="number" id="pb1_h"
                                        onchange="refreshPoblacionb()" class="form-control"
                                        value="{{ isset($itar) ? $itar->pb1_h : '' }}" />
                                    <div class="invalid-feedback" style="">
                                        Indique la cantidad de hombres beneficiados
                                    </div>
                                </td>
                                <td style="text-align: center"><input type="number" id="pb2_m"
                                        onchange="refreshPoblacionb()" class="form-control"
                                        value="{{ isset($itar) ? $itar->pb2_m : '' }}" />
                                    <div class="invalid-feedback" style="">
                                        Indique la cantidad de mujeres beneficiadas
                                    </div>
                                </td>
                                <td style="text-align: center"><input type="number" id="pb2_h"
                                        onchange="refreshPoblacionb()" class="form-control"
                                        value="{{ isset($itar) ? $itar->pb2_h : '' }}" />
                                    <div class="invalid-feedback" style="">
                                        Indique la cantidad de hombres beneficiados
                                    </div>
                                </td>
                                <td style="text-align: center"><input type="number" id="pb3_m"
                                        class="form-control" onchange="refreshPoblacionb()" readonly
                                        value="{{ isset($itar) ? $itar->pb3_m : '' }}" /></td>
                                <td style="text-align: center"><input type="number" id="pb3_h"
                                        class="form-control" onchange="refreshPoblacionb()" readonly
                                        value="{{ isset($itar) ? $itar->pb3_h : '' }}" /></td>
                                <td style="text-align: center"><input type="number" id="pb4_m"
                                        class="form-control" onchange="refreshPoblacionb()" readonly
                                        value="{{ isset($itar) ? $itar->pb4_m : '' }}" /></td>
                                <td style="text-align: center"><input type="number" id="pb4_h"
                                        class="form-control" onchange="refreshPoblacionb()" readonly
                                        value="{{ isset($itar) ? $itar->pb4_h : '' }}" /></td>
                            </tr>

                        </table>
                        <div id="regiones">


                            @if (isset($itar))
                                @if ($itarRegiones->count() > 0)
                                    @foreach ($itarRegiones as $reg)
                                        <table style="width:100%" class="region">
                                            <tr>
                                                <td colspan="9" class="enc2" style="text-align: center">
                                                    Distribucion
                                                    territorial/área geográfica atendida</td>
                                            </tr>
                                            <tr>
                                                <td colspan="9" style="text-align: right"><button
                                                        class="btn btn-danger" onclick="eliminaRegion($(this))"><i
                                                            class="fas fa-trash"></i> Eliminar
                                                        registro</button></td>
                                            </tr>
                                            <tr>
                                                <td class="enc1" rowspan="2" style="width:15%">Regiones
                                                    atendidas en el periodo
                                                    que se reporta <input type="hidden" class="idITARRegion"
                                                        value="{{ $reg->id }}">
                                                </td>
                                                <td colspan="8">
                                                    <select class="idRegion form-control">
                                                        <option value="">--Seleccione</option>
                                                        @foreach ($regiones as $region)
                                                            <option value="{{ $region->id }}"
                                                                {{ $reg->idRegion == $region->id ? 'selected' : '' }}>
                                                                {{ $region->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Seleccione una región
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="enc1">Total de mujeres atendidas</td>
                                                <td><input type="number" class="form-control tpm"
                                                        onchange="refreshPoblacionr($(this))"
                                                        value="{{ $reg->tpm }}" />
                                                    <div class="invalid-feedback" style="">
                                                        Indique el total de mujeres atendidas
                                                    </div>
                                                </td>
                                                <td class="enc1">Total de hombres atendidos</td>
                                                <td>
                                                    <input type="number" class="form-control tph"
                                                        onchange="refreshPoblacionr($(this))"
                                                        value="{{ $reg->tph }}" />
                                                    <div class="invalid-feedback" style="">
                                                        Indique el total de homobres atendidos
                                                    </div>

                                                </td>
                                                <td class="enc1">Total de personas atendidas</td>
                                                <td>
                                                    <input type="number" class="form-control tp" readonly
                                                        value="{{ $reg->tp }}" />
                                                    <div class="invalid-feedback" style="">
                                                        Indique el total de personas atendidas
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="enc1">Número de municipios atendidos</td>
                                                <td>
                                                    <input type="number" class="form-control num_mun"
                                                        value="{{ $reg->num_mun }}" />
                                                    <div class="invalid-feedback" style="">
                                                        Indique el total de municipios atendidos
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    @endforeach
                                @endif
                            @else
                                <table style="width:100%" class="region">
                                    <tr>
                                        <td colspan="9" class="enc2" style="text-align: center">Distribucion
                                            territorial/área geográfica atendida</td>
                                    </tr>
                                    <tr>
                                        <td colspan="9" style="text-align: right"><button class="btn btn-danger"
                                                onclick="eliminaRegion($(this))"><i class="fas fa-trash"></i> Eliminar
                                                registro</button></td>
                                    </tr>
                                    <tr>
                                        <td class="enc1" rowspan="2" style="width:15%">Regiones atendidas en
                                            el periodo
                                            que se reporta <input type="hidden" class="idITARRegion" value="">
                                        </td>
                                        <td colspan="8">
                                            <select class="idRegion form-control">
                                                <option value="">--Seleccione</option>
                                                @foreach ($regiones as $region)
                                                    <option value="{{ $region->id }}">{{ $region->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Seleccione una región
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="enc1">Total de mujeres atendidas</td>
                                        <td><input type="number" class="form-control tpm"
                                                onchange="refreshPoblacionr($(this))" />
                                            <div class="invalid-feedback" style="">
                                                Indique el total de mujeres atendidas
                                            </div>
                                        </td>
                                        <td class="enc1">Total de hombres atendidos</td>
                                        <td>
                                            <input type="number" class="form-control tph"
                                                onchange="refreshPoblacionr($(this))" />
                                            <div class="invalid-feedback" style="">
                                                Indique el total de homobres atendidos
                                            </div>

                                        </td>
                                        <td class="enc1">Total de personas atendidas</td>
                                        <td>
                                            <input type="number" class="form-control tp" readonly />
                                            <div class="invalid-feedback" style="">
                                                Indique el total de personas atendidas
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="enc1">Número de municipios atendidos</td>
                                        <td>
                                            <input type="number" class="form-control num_mun" />
                                            <div class="invalid-feedback" style="">
                                                Indique el total de municipios atendidos
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            @endif
                        </div>
                        <div style="width: 100%;text-align:right">
                            <button class="btn btn-success" onclick="addRegion()"><i class="fas fa-plus"></i> Agregar
                                Región de atención</button>
                        </div>

                        <table style="width: 100%">
                            <tr>
                                <td style="width:50%;text-align:right;padding:15px"><button class="btn btn-secondary"
                                        onclick="before(2)">Atrás</button> <button class="btn btn-primary"
                                        onclick="almacena3()">Almacenar y Siguiente</button>
                                </td>

                            </tr>
                        </table>
                    </div>
                    <div style="width:100%; border:solid 1px green;display:none;padding:20px" id="itar4">
                        <table style="width:100%" class="impacto">
                            <tr>
                                <td colspan="6" class="enc2" style="text-align: center">Impacto</td>
                            </tr>
                            <tr>
                                <td class="enc1">Ámbito social:</td>
                                <td>
                                    <textarea name="im_s" id="im_s" class="form-control">{{ isset($itar) ? $itar->im_s : '' }}</textarea>
                                </td>
                                <td class="enc1">Ámbito económico:</td>
                                <td>
                                    <textarea name="im_e" id="im_e" class="form-control">{{ isset($itar) ? $itar->im_e : '' }}</textarea>
                                </td>
                                <td class="enc1">Ámbito ambiental:</td>
                                <td>
                                    <textarea name="im_a" id="im_a" class="form-control">{{ isset($itar) ? $itar->im_a : '' }}</textarea>
                                </td>
                            </tr>
                        </table>
                        <table style="width:100%" class="difusion">
                            <tr>
                                <td colspan="9" class="enc2" style="text-align: center">Difusión e
                                    interacción con
                                    la ciudadanía</td>
                            </tr>
                            <tr style="text-align: center">
                                <td style="width: 33.33%" colspan="3" class="enc1">Página oficial</td>
                                <td style="width: 33.33%" colspan="3" class="enc1">Redes sociales</td>
                                <td style="width: 33.33%" colspan="3" class="enc1">Buzón digital</td>
                            </tr>
                            <tr>
                                <td><input type="text" class="form-control" id="link_po"
                                        placeholder="link de la pagina oficial"></td>
                                <td><input type="number" class="form-control" id="alcance_po"
                                        placeholder="Alcance (número de visitas)"></td>
                                <td><button class="btn btn-primary" style="font-size: .8em;"
                                        onclick="addPagina()">Agregar Link</button></td>

                                <td>
                                    <select class="form-control" id="red_social">
                                        <option value="">--Seleccione</option>
                                        <option value="Facebook">Facebook</option>
                                        <option value="Instagram">Instagram</option>
                                        <option value="X">X</option>
                                        <option value="TikTok">TikTok</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" id="alcance_rs"
                                        placeholder="Alcance (Número de interacciones)"></td>
                                <td><button class="btn btn-primary" style="font-size: .8em;" onclick="addRS()">Agregar
                                        Red</button></td>

                                <td><input type="text" class="form-control" id="buzon_direccion"
                                        placeholder="cuenta de correo electrónico"></td>
                                <td><input type="number" class="form-control" id="alcance_buzon"
                                        placeholder="Alcance (Número de correos recibidos)"></td>
                                <td><button class="btn btn-primary" style="font-size: .8em;"
                                        onclick="addBuzon()">Agregar
                                        correo</button></td>
                            </tr>
                            <tr style="text-align: center">
                                <td style="width: 33.33%; vertical-align:top" colspan="3">
                                    <table style="width: 100%;" id="table_po">
                                        <thead>
                                            <tr style="text-align: center">
                                                <th class="enc1-s">Link</th>
                                                <th class="enc1-s">Alcance</th>
                                                <th class="enc1-s">Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody id="body_pagina">
                                            @if (isset($itar))
                                                @php
                                                    $cadena_paginas = $itar->p_o;
                                                    if (Str::length($cadena_paginas) > 0) {
                                                        $array_p = explode(';', $cadena_paginas);
                                                        array_pop($array_p);
                                                        if (count($array_p) > 0) {
                                                            foreach ($array_p as $vals) {
                                                                $array_vals = explode('|', $vals);
                                                                $row =
                                                                    '<tr>' .
                                                                    '<td style="text-align: left" class="link_po">' .
                                                                    $array_vals[0] .
                                                                    '</td>' .
                                                                    '<td style="text-align: center" class="alcance_po">' .
                                                                    $array_vals[1] .
                                                                    '</td>' .
                                                                    '<td><button class="btn btn-danger" onclick="deleteRow($(this))"><i styele="font-size:.3em;" class="fas fa-trash"></i></button></td>' .
                                                                    '</tr>';
                                                                echo $row;
                                                            }
                                                        }
                                                    }
                                                @endphp
                                            @endif
                                        </tbody>
                                    </table>
                                </td>
                                <td style="width: 33.33%; vertical-align:top" colspan="3">
                                    <table style="width: 100%; " id="table_rs">
                                        <thead>
                                            <tr style="text-align: center">
                                                <th class="enc1-s">Red s.</th>
                                                <th class="enc1-s">Alcance</th>
                                                <th class="enc1-s">Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody id="body_rs">
                                            @if (isset($itar))
                                                @php
                                                    $cadena_redes = $itar->r_s;
                                                    if (Str::length($cadena_redes) > 0) {
                                                        $array_r = explode(';', $cadena_redes);
                                                        array_pop($array_r);
                                                        if (count($array_r) > 0) {
                                                            foreach ($array_r as $vals) {
                                                                $array_vals = explode('|', $vals);
                                                                $row =
                                                                    '<tr>' .
                                                                    '<td style="text-align: left" class="red_social">' .
                                                                    $array_vals[0] .
                                                                    '</td>' .
                                                                    '<td style="text-align: center" class="alcance_rs">' .
                                                                    $array_vals[1] .
                                                                    '</td>' .
                                                                    '<td><button class="btn btn-danger" onclick="deleteRow($(this))"><i styele="font-size:.3em;" class="fas fa-trash"></i></button></td>' .
                                                                    '</tr>';
                                                                echo $row;
                                                            }
                                                        }
                                                    }
                                                @endphp
                                            @endif
                                        </tbody>
                                    </table>
                                </td>
                                <td style="width: 33.33%; vertical-align:top" colspan="3">
                                    <table style="width: 100%;" id="table_buzon">
                                        <thead>
                                            <tr style="text-align: center">
                                                <th class="enc1-s">Correo</th>
                                                <th class="enc1-s">Alcance</th>
                                                <th class="enc1-s">Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody id="body_buzon">
                                            @if (isset($itar))
                                                @php
                                                    $cadena_buzon = $itar->b_d;
                                                    if (Str::length($cadena_buzon) > 0) {
                                                        $array_b = explode(';', $cadena_buzon);
                                                        array_pop($array_b);
                                                        if (count($array_b) > 0) {
                                                            foreach ($array_b as $vals) {
                                                                $array_vals = explode('|', $vals);
                                                                $row =
                                                                    '<tr>' .
                                                                    '<td style="text-align: left" class="buzon_direccion">' .
                                                                    $array_vals[0] .
                                                                    '</td>' .
                                                                    '<td style="text-align: center" class="alcance_buzon">' .
                                                                    $array_vals[1] .
                                                                    '</td>' .
                                                                    '<td><button class="btn btn-danger" onclick="deleteRow($(this))"><i styele="font-size:.3em;" class="fas fa-trash"></i></button></td>' .
                                                                    '</tr>';
                                                                echo $row;
                                                            }
                                                        }
                                                    }
                                                @endphp
                                            @endif
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr style="text-align: center">
                                <td style="width: 33.33%" colspan="3" class="enc1">Atención telefónica</td>
                                <td style="width: 33.33%" colspan="3" class="enc1">Atención personal</td>
                                <td style="width: 33.33%" colspan="3" class="enc1">Otro</td>
                            </tr>
                            <tr>
                                <td><input type="text" class="form-control" id="telefono_atencion"
                                        placeholder="Teléfono desde el que se brinda la atención"></td>
                                <td><input type="number" class="form-control" id="alcance_telefono"
                                        placeholder="Alcance (Llamadas atendidas)"></td>
                                <td><button class="btn btn-primary" style="font-size: .8em;"
                                        onclick="addTelefono()">Agregar teléfono</button></td>

                                <td><input type="text" class="form-control" id="oficina_atencion"
                                        placeholder="Oficina de atención"></td>
                                <td><input type="number" class="form-control" id="alcance_oficina"
                                        placeholder="Alcance (personas atendidas)"></td>
                                <td><button class="btn btn-primary" style="font-size: .8em;"
                                        onclick="addPersonal()">Agregar Oficina</button></td>

                                <td><input type="text" class="form-control" id="otro_atencion"
                                        placeholder="Otro medio de difusión"></td>
                                <td><input type="number" class="form-control" id="alcance_otro"
                                        placeholder="Alcance (numero de personas)"></td>
                                <td><button class="btn btn-primary" style="font-size: .8em;"
                                        onclick="addOtro()">Agregar
                                        Otro</button></td>
                            </tr>
                            <tr style="text-align: center">
                                <td style="width: 33.33%; vertical-align:top" colspan="3">
                                    <table style="width: 100%;" id="table_telefono">
                                        <thead>
                                            <tr style="text-align: center">
                                                <th class="enc1-s">Teléfono</th>
                                                <th class="enc1-s">Alcance</th>
                                                <th class="enc1-s">Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody id="body_telefono">
                                            @if (isset($itar))
                                                @php
                                                    $cadena_at = $itar->a_t;
                                                    if (Str::length($cadena_at) > 0) {
                                                        $array_at = explode(';', $cadena_at);
                                                        array_pop($array_at);
                                                        if (count($array_at) > 0) {
                                                            foreach ($array_at as $vals) {
                                                                $array_vals = explode('|', $vals);
                                                                $row =
                                                                    '<tr>' .
                                                                    '<td style="text-align: left" class="telefono_atencion">' .
                                                                    $array_vals[0] .
                                                                    '</td>' .
                                                                    '<td style="text-align: center" class="alcance_telefono">' .
                                                                    $array_vals[1] .
                                                                    '</td>' .
                                                                    '<td><button class="btn btn-danger" onclick="deleteRow($(this))"><i styele="font-size:.3em;" class="fas fa-trash"></i></button></td>' .
                                                                    '</tr>';
                                                                echo $row;
                                                            }
                                                        }
                                                    }
                                                @endphp
                                            @endif
                                        </tbody>
                                    </table>
                                </td>
                                <td style="width: 33.33%; vertical-align:top" colspan="3">
                                    <table style="width: 100%;" id="table_oficina">
                                        <thead>
                                            <tr style="text-align: center">
                                                <th class="enc1-s">Oficina</th>
                                                <th class="enc1-s">Alcance</th>
                                                <th class="enc1-s">Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody id="body_oficina">
                                            @if (isset($itar))
                                                @php
                                                    $cadena_ap = $itar->a_p;
                                                    if (Str::length($cadena_ap) > 0) {
                                                        $array_ap = explode(';', $cadena_ap);
                                                        array_pop($array_ap);
                                                        if (count($array_ap) > 0) {
                                                            foreach ($array_ap as $vals) {
                                                                $array_vals = explode('|', $vals);
                                                                $row =
                                                                    '<tr>' .
                                                                    '<td style="text-align: left" class="oficina_atencion">' .
                                                                    $array_vals[0] .
                                                                    '</td>' .
                                                                    '<td style="text-align: center" class="alcance_oficina">' .
                                                                    $array_vals[1] .
                                                                    '</td>' .
                                                                    '<td><button class="btn btn-danger" onclick="deleteRow($(this))"><i styele="font-size:.3em;" class="fas fa-trash"></i></button></td>' .
                                                                    '</tr>';
                                                                echo $row;
                                                            }
                                                        }
                                                    }
                                                @endphp
                                            @endif
                                        </tbody>
                                    </table>
                                </td>
                                <td style="width: 33.33%; vertical-align:top" colspan="3">
                                    <table style="width: 100%;" id="table_otro">
                                        <thead>
                                            <tr style="text-align: center">
                                                <th class="enc1-s">Otro</th>
                                                <th class="enc1-s">Alcance</th>
                                                <th class="enc1-s">Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody id="body_otro">
                                            @if (isset($itar))
                                                @php
                                                    $cadena_otro = $itar->otro;
                                                    if (Str::length($cadena_otro) > 0) {
                                                        $array_otro = explode(';', $cadena_otro);
                                                        array_pop($array_otro);
                                                        if (count($array_otro) > 0) {
                                                            foreach ($array_otro as $vals) {
                                                                $array_vals = explode('|', $vals);
                                                                $row =
                                                                    '<tr>' .
                                                                    '<td style="text-align: left" class="otro_atencion">' .
                                                                    $array_vals[0] .
                                                                    '</td>' .
                                                                    '<td style="text-align: center" class="alcance_otro">' .
                                                                    $array_vals[1] .
                                                                    '</td>' .
                                                                    '<td><button class="btn btn-danger" onclick="deleteRow($(this))"><i styele="font-size:.3em;" class="fas fa-trash"></i></button></td>' .
                                                                    '</tr>';
                                                                echo $row;
                                                            }
                                                        }
                                                    }
                                                @endphp
                                            @endif

                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                        </table>
                        <table style="width: 100%">
                            <tr>
                                <td style="width:50%;text-align:right;padding:15px"><button class="btn btn-secondary"
                                        onclick="before(3)">Atrás</button> <button class="btn btn-primary"
                                        onclick="almacena4()">Almacenar y Siguiente</button>
                                </td>

                            </tr>
                        </table>
                    </div>
                    <div style="width:100%; border:solid 1px green;display:none;padding:20px" id="itar5">
                        <table style="width:100%" class="">
                            <tr>
                                <td colspan="2" class="enc2" style="text-align: center">Selección fotográfica y
                                    documentos probatorios
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="enc1" style="text-align: center">Carga de Archivos
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" class="enc1" style="text-align: center;width:50%">Area de
                                    Carga</td>
                                <td colspan="1" class="enc1" style="text-align: center">Archivos Cargados
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="vertical-align:top">
                                    <div class="">
                                        <form action="{{ route('itar.medioupload') }}" method="POST"
                                            enctype="multipart/form-data" class="dropzone" id="medios-itar"
                                            style="color:blue">
                                            @csrf
                                            <input type="hidden" name="idITARm" id="idITARm" value="1">
                                        </form>
                                    </div>
                                    <div style="font-size: .9em">
                                        <b>Nota: </b>Las fotografías incluidas deberán ser representativas de los bienes o
                                        servicios entregados y de la población beneficiada.
                                    </div>
                                </td>
                                <td style="vertical-align: top;text-align:center;width:50%" colspan="1">
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
                                            @if (isset($itar))
                                                @if ($itarMedios->count() > 0)
                                                    @foreach ($itarMedios as $medio)
                                                        <tr id="rowmedio{{ $medio->id }}">
                                                            <td style="display:none">{{ $medio->id }}</td>
                                                            <td class="medioitar" medio=""
                                                                style="text-align:left"><input type="hidden"
                                                                    class="medio" name=""
                                                                    value="{{ $medio->id }}"><a target="blank_"
                                                                    href="{{ asset('medios') }}/itar/{{ $medio->idITAR . '/' . $medio->ubicacion }}">{{ $medio->nombre }}</a>
                                                            </td>
                                                            <td>
                                                                <textarea placeholder="Agrega Descripción" class="descripcionmedio form-control" name="descripcionmedio[]">{{ $medio->descripcion }}</textarea>
                                                                <div class="invalid-feedback" style="">Indique
                                                                    una descripcion para el medio cargado</div>
                                                            </td>
                                                            <td><button type="button" class="btn btn-danger"
                                                                    onclick="deleteMedioRelacionado({{ $medio->id }})"><i
                                                                        class="fas fa-trash"></i></button></td>
                                                        </tr>;
                                                    @endforeach
                                                @endif
                                            @endif
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <table style="width: 100%">
                            <tr>
                                <td colspan="5" class="enc1" style="text-align: center">Links Directos</td>
                            </tr>
                            <tr>
                                <td class="enc1" style="width: 10%">Link</td>
                                <td class="" style="width: 35%"><input type="text" class="form-control"
                                        id="link" /></td>
                                <td class="enc1" style="width: 10%">Descripción</td>
                                <td style="width: 35%"><input class="form-control" type="text"
                                        id="descripcion_link" /></td>
                                <td style="width:10%"><button class="btn btn-success" onclick="addLink()"><i
                                            class="fas fa-plus"></i> Agregar Link</button></td>
                            </tr>
                        </table>
                        <table style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="enc2" style="text-align: center">Link</th>
                                    <th class="enc2" style="text-align: center">Descripción</th>
                                    <th class="enc2" style="text-align: center">Acción</th>
                                </tr>
                            </thead>
                            <tbody id="links_probatorios">
                                @if (isset($itar))
                                    @if ($itarLinks->count() > 0)
                                        @foreach ($itarLinks as $link)
                                            <tr id="rowlink{{ $link->id }}">
                                                <td style="text-align: center">{{ $link->nombre }}</td>
                                                <td style="text-align: center">{{ $link->descripcion }}</td>
                                                <td style="text-align: center"><button class="btn btn-danger"
                                                        onclick="deleteLink({{ $link->id }})"><i
                                                            class="fas fa-trash"></i></button></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                            </tbody>
                        </table>
                        <table style="width: 100%">
                            <tr>
                                <td style="width:50%;text-align:right;padding:15px"><button class="btn btn-secondary"
                                        onclick="before(4)">Atrás</button> <button class="btn btn-primary"
                                        onclick="almacena5()">Almacenar y Finalizar</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        end:
    @endphp

@endsection
@section('styles')
    <link href="{{ asset('resources/css/dropzone.css') }}" rel="stylesheet" type="text/css">
    <style>
        .activo {
            background-color: rgb(50, 50, 50);
            color: white
        }

        .enc1 {
            padding: 5px !important;
            background-color: #919090;
            color: white;
        }

        .enc1-s {
            padding: 5px !important;
            background-color: #bababa;
            color: white;
        }

        .enc2 {
            padding: 5px !important;
            background-color: #7c2f42;
            color: white;
        }

        .resp {
            font-weight: bold;
        }

        .enc3 {
            background-color: #ececec;
            font-weight: bold;
        }

        input[type=text],
        select {
            height: 35px;
        }

        table tr td {
            padding: 5px;
            border: solid 2px white;
        }

        .invalid-feedback {
            width: 100%;
            background-color: rgb(255, 220, 220);
            color: black;
            border-radius: 5px;
            text-align: center;
            padding: 10px;
        }

        .pf1,
        .pf2,
        .pf3,
        .pf4,
        .pe1,
        .pe2,
        .pe3,
        .pe4,
        .pm1,
        .pm2,
        .pm3,
        .pm4,
        .pt1,
        .pt2,
        .pt3,
        .pt4,
        .t1m,
        .t2m,
        .t3m,
        .t4m,
        .t1e,
        .t2e,
        .pt1,
        .pt2,
        #pa1,
        #pa2,
        #pa3,
        #pa4 {
            text-align: right;
            padding: 15px;
            font-size: 1.3em;
            border: solid 1px gray;
            font-weight: bold;

        }

        input[type=number] {
            text-align: right;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{ asset('resources/js/dropzone-min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#collapse-itar").addClass("show");
            $("#itarregistro").css('background-color', "rgb(217, 217, 217)");
            if ($("#medios-itar").length > 0) {
                inicializaDropZone();
            }

            @if (isset($itar))
                periodo_reporte = "{{ $itar->periodo_reporte }}".split("-");
                $("#mesinicio").val(periodo_reporte[0]);
                $("#mesfinal").val(periodo_reporte[1]);
                $("#anio").val(periodo_reporte[2]);
                $("#dependencia").val({{ $itar->idDependencia }});
                $("#cobertura").val('{{ $itar->cobertura }}');
                $("#periodicidad").val('{{ $itar->periodicidad }}');
                $("#anio_inicio").val('{{ $itar->anio_inicio }}');
                $("#idEjePED").val('{{ $itar->idEjePED }}');
                $("#tipologia").val('{{ $itar->tipologia_gasto }}');
                getTemas();
                setTimeout(function() {
                    $("#idTemaPED").val({{ $itar->idTemaPED }});
                    getObjetivos()
                }, 500);
                setTimeout(function() {
                    $("#idObjetivoPED").val({{ $itar->idObjetivoPED }});
                    getEstrategias()
                }, 800);
                setTimeout(function() {
                    $("#idEstrategiaPED").val({{ $itar->idEstrategiaPED }});
                    getLineas()
                }, 1100);
                setTimeout(function() {
                    $("#idLAPED").val({{ $itar->idLAPED }});
                }, 1400);

                transversales = "{{ $itar->transversales }}".split("|");

                if (transversales.length > 0) {
                    transversales.pop();
                    transversales.forEach((transversal) => {
                        $("#" + transversal).prop("checked", true);
                    });
                }
                $("#idIndicador").val('{{ $itar->idIndicador }}');
                $("#idPoblacion").val('{{ $itar->idPoblacion }}');
                refreshBienes();
                refreshPoblaciono();
            @endif
            refreshPorcentajes();
            freshObras();
        });

        function almacena1() {
            if (valida1()) {
                transversales = "";
                mesinicio = $("#mesinicio").val();
                mesfinal = $("#mesfinal").val();
                anio = $("#anio").val()
                tipo = $("input[name='tipo']:checked").val();
                reglas = $("input[name='reglas']:checked").val();
                nombre = $("#nombre").val();
                objetivo = $("#objetivo").val();
                descripcion = $("#descripcion").val();
                cobertura = $("#cobertura").val();
                periodicidad = $("#periodicidad").val();
                anio_inicio = $("#anio_inicio").val();
                idEjePED = $("#idEjePED").val();
                idTemaPED = $("#idTemaPED").val();
                idObjetivoPED = $("#idObjetivoPED").val();
                idEstrategiaPED = $("#idEstrategiaPED").val();
                idLAPED = $("#idLAPED").val();
                transversales += $("#igualdad").prop('checked') ? "igualdad|" : "";
                transversales += $("#desarrollo").prop('checked') ? "desarrollo|" : "";
                transversales += $("#interculturalidad").prop('checked') ? "interculturalidad|" : "";
                transversales += $("#ninas").prop('checked') ? "ninas|" : "";
                idIndicador = $("#idIndicador").val();
                dependencia = $("#dependencia").val();
                idITAR = $("#idITAR").val();
                tipologia = $("#tipologia").val();


                $.ajax({
                    type: 'POST',
                    url: "{{ route('itar.almacena1') }}",
                    data: {
                        mesinicio: mesinicio,
                        mesfinal: mesfinal,
                        anio: anio,
                        tipo: tipo,
                        reglas: reglas,
                        nombre: nombre,
                        objetivo: objetivo,
                        descripcion: descripcion,
                        cobertura: cobertura,
                        periodicidad: periodicidad,
                        anio_inicio: anio_inicio,
                        idEjePED: idEjePED,
                        idTemaPED: idTemaPED,
                        idObjetivoPED: idObjetivoPED,
                        idEstrategiaPED: idEstrategiaPED,
                        idLAPED: idLAPED,
                        transversales: transversales,
                        idIndicador: idIndicador,
                        idITAR: idITAR,
                        idDependencia: dependencia,
                        tipologia: tipologia,
                        _token: $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        block(true)
                    }
                }).done(function(response) {
                    if (response.result == "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Datos Generales y Alineación del PPA!',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                            $("#indicador1").removeClass("activo");
                            $("#indicador2").addClass("activo");
                            $("#itar1").hide();
                            $("#itar2").show();
                            $("#folio").html(response.itar.folio);
                            $("#idITAR").val(response.itar.id);
                            $("#idITARm").val(response.itar.id);
                        });


                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Almacenamiento de PPA',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
                    }
                    block(false)
                }).fail(function(data) {
                    block(false)
                });

            }
            /*
                        $("#indicador1").removeClass("activo");
                        $("#indicador2").addClass("activo");
                        $("#itar1").hide();
                        $("#itar2").show();*/



        }

        function almacena2() {
            if (valida2()) {
                //construimos las cadenas para enviar para su almacenamiento
                idITAR = $("#idITAR").val();
                presupuesto = "";
                $(".presupuesto").each(function() {
                    idPresupuesto = $(this).find(".idPresupuesto").eq(0).val();
                    ejercicio = $(this).find(".ejercicio").eq(0).val();
                    programa = $(this).find(".programa").eq(0).val();
                    f1m = $(this).find(".f1m").eq(0).val();
                    f2m = $(this).find(".f2m").eq(0).val();
                    f3m = $(this).find(".f3m").eq(0).val();
                    f4m = $(this).find(".f4m").eq(0).val();

                    f1e = $(this).find(".f1e").eq(0).val();
                    f2e = $(this).find(".f2e").eq(0).val();
                    f3e = $(this).find(".f3e").eq(0).val();
                    f4e = $(this).find(".f4e").eq(0).val();

                    e1m = $(this).find(".e1m").eq(0).val();
                    e2m = $(this).find(".e2m").eq(0).val();
                    e3m = $(this).find(".e3m").eq(0).val();
                    e4m = $(this).find(".e4m").eq(0).val();

                    e1e = $(this).find(".e1e").eq(0).val();
                    e2e = $(this).find(".e2e").eq(0).val();
                    e3e = $(this).find(".e3e").eq(0).val();
                    e4e = $(this).find(".e4e").eq(0).val();

                    m1m = $(this).find(".m1m").eq(0).val();
                    m2m = $(this).find(".m2m").eq(0).val();
                    m3m = $(this).find(".m3m").eq(0).val();
                    m4m = $(this).find(".m4m").eq(0).val();

                    m1e = $(this).find(".m1e").eq(0).val();
                    m2e = $(this).find(".m2e").eq(0).val();
                    m3e = $(this).find(".m3e").eq(0).val();
                    m4e = $(this).find(".m4e").eq(0).val();

                    fecha_corte = $(this).find(".fecha_corte").eq(0).val();


                    presupuesto += idPresupuesto + "|";
                    presupuesto += ejercicio + "|";
                    presupuesto += programa + "|";
                    presupuesto += f1m + "|";
                    presupuesto += f2m + "|";
                    presupuesto += f3m + "|";
                    presupuesto += f4m + "|";
                    presupuesto += e1m + "|";
                    presupuesto += e2m + "|";
                    presupuesto += e3m + "|";
                    presupuesto += e4m + "|";
                    presupuesto += m1m + "|";
                    presupuesto += m2m + "|";
                    presupuesto += m3m + "|";
                    presupuesto += m4m + "|";
                    presupuesto += f1e + "|";
                    presupuesto += f2e + "|";
                    presupuesto += f3e + "|";
                    presupuesto += f4e + "|";
                    presupuesto += e1e + "|";
                    presupuesto += e2e + "|";
                    presupuesto += e3e + "|";
                    presupuesto += e4e + "|";
                    presupuesto += m1e + "|";
                    presupuesto += m2e + "|";
                    presupuesto += m3e + "|";
                    presupuesto += m4e + "|";
                    presupuesto += fecha_corte + "|";
                    presupuesto += "&";
                })

                $.ajax({
                    type: 'POST',
                    url: "{{ route('itar.almacena2') }}",
                    data: {
                        idITAR: idITAR,
                        presupuestos: presupuesto,
                        _token: $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        block(true)
                    }
                }).done(function(response) {
                    if (response.result == "ok") {

                        if (response.nuevos.length > 0) {
                            cuenta = 0;
                            $(".idPresupuesto").each(function() {
                                if ($(this).val() == "") {
                                    $(this).val(response.nuevos[cuenta]);
                                    cuenta++
                                }
                            })
                        }
                        Swal.fire({
                            icon: 'success',
                            title: 'Presupuesto del PPA!',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                            $("#indicador2").removeClass("activo");
                            $("#indicador3").addClass("activo");
                            $("#itar2").hide();
                            $("#itar3").show();
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Almacenamiento de información del presupuesto',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
                    }
                    block(false)
                }).fail(function(data) {
                    block(false)
                });
            }
            /*
                        $("#indicador2").removeClass("activo");
                        $("#indicador3").addClass("activo");
                        $("#itar2").hide();
                        $("#itar3").show();*/

        }

        function almacena3() {
            if (valida3()) {
                //construimos las cadenas para enviar para su almacenamiento
                idITAR = $("#idITAR").val();
                regiones = "";
                bss = "";
                $(".region").each(function() {
                    idITARRegion = $(this).find(".idITARRegion").eq(0).val();
                    idRegion = $(this).find(".idRegion").eq(0).val();
                    tpm = $(this).find(".tpm").eq(0).val();
                    tph = $(this).find(".tph").eq(0).val();
                    tp = $(this).find(".tp").eq(0).val();
                    num_mun = $(this).find(".num_mun").eq(0).val();

                    regiones += idITARRegion + "|";
                    regiones += idRegion + "|";
                    regiones += tpm + "|";
                    regiones += tph + "|";
                    regiones += tp + "|";
                    regiones += num_mun + "|";
                    regiones += "&";
                });

                cont = 0;
                $(".idBS").each(function() {
                    descripcion_bs = $(".descripcion_bs").eq(cont).val();
                    unidad_bs = $(".unidad_bs").eq(cont).val();
                    bs1p = $(".bs1p").eq(cont).val();
                    bs2p = $(".bs2p").eq(cont).val();
                    bs3p = $(".bs3p").eq(cont).val();
                    bs4p = $(".bs4p").eq(cont).val();
                    bs1r = $(".bs1r").eq(cont).val();
                    bs2r = $(".bs2r").eq(cont).val();
                    bs3r = $(".bs3r").eq(cont).val();
                    bs4r = $(".bs4r").eq(cont).val();
                    idBS = $(".idBS").eq(cont).val();

                    bss += idBS + "|" + descripcion_bs + "|" + unidad_bs + "|" + bs1p + "|" + bs2p + "|" + bs3p +
                        "|" + bs4p + "|" + bs1r + "|" + bs2r + "|" + bs3r + "|" + bs4r + "&";
                    cont++;

                })

                idPoblacion = $("#idPoblacion").val();
                descripcion_pb = $("#descripcion_pb").val();
                po = $("#po").val();
                po_m = $("#po_m").val();
                po_h = $("#po_h").val();
                pb1_t = $("#pb1_t").val();
                pb2_t = $("#pb2_t").val();
                pb3_t = $("#pb3_t").val();
                pb4_t = $("#pb4_t").val();
                pb1_m = $("#pb1_m").val();
                pb1_h = $("#pb1_h").val();
                pb2_m = $("#pb2_m").val();
                pb2_h = $("#pb2_h").val();
                pb3_m = $("#pb3_m").val();
                pb3_h = $("#pb3_h").val();
                pb4_m = $("#pb4_m").val();
                pb4_h = $("#pb4_h").val();
                o_a = $("#o_a").val();
                o_e = $("#o_e").val();


                $.ajax({
                    type: 'POST',
                    url: "{{ route('itar.almacena3') }}",
                    data: {
                        idITAR: idITAR,
                        regiones: regiones,
                        bss: bss,
                        idPoblacion: idPoblacion,
                        descripcion_pb: descripcion_pb,
                        po: po,
                        po_m: po_m,
                        po_h: po_h,
                        pb1_t: pb1_t,
                        pb2_t: pb2_t,
                        pb3_t: pb3_t,
                        pb4_t: pb4_t,
                        pb1_m: pb1_m,
                        pb1_h: pb1_h,
                        pb2_m: pb2_m,
                        pb2_h: pb2_h,
                        pb3_m: pb3_m,
                        pb3_h: pb3_h,
                        pb4_m: pb4_m,
                        pb4_h: pb4_h,
                        o_a:o_a,
                        o_e:o_e,
                        _token: $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        block(true)
                    }
                }).done(function(response) {
                    if (response.result == "ok") {

                        if (response.nuevos.length > 0) {
                            cuenta = 0;
                            $(".idITARRegion").each(function() {
                                if ($(this).val() == "") {
                                    $(this).val(response.nuevos[cuenta]);
                                    cuenta++
                                }
                            })
                        }
                        if (response.nuevos_bienes.length > 0) {
                            cuenta = 0;
                            $(".idBS").each(function() {
                                if ($(this).val() == "") {
                                    $(this).val(response.nuevos_bienes[cuenta]);
                                    cuenta++
                                }
                            })
                        }
                        Swal.fire({
                            icon: 'success',
                            title: 'Bienes o servicios, población beneficiada y Distribución geográfica.',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                            $("#indicador3").removeClass("activo");
                            $("#indicador4").addClass("activo");
                            $("#itar3").hide();
                            $("#itar4").show();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Almacenamiento de información de distribución territorial y área geográfica atendida',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
                    }
                    block(false)
                }).fail(function(data) {
                    block(false)
                });
            }
            /*
                        $("#indicador3").removeClass("activo");
                        $("#indicador4").addClass("activo");
                        $("#itar3").hide();
                        $("#itar4").show();*/
        }

        function almacena4() {
            if (true) {


                //obtenemos los datos que mandaremos a la base
                im_s = $("#im_s").val();
                im_e = $("#im_e").val();
                im_a = $("#im_a").val();
                idITAR = $("#idITAR").val();

                difusion_pagina = "";
                difusion_redes = "";
                difusion_buzon = "";
                difusion_telefonica = "";
                difusion_personal = "";
                difusion_otro = "";

                if ($("#body_pagina").find("tr").length > 0) {
                    $("#body_pagina").find("tr").each(function() {
                        link_po = $(this).find(".link_po").eq(0).html();
                        alcance_po = $(this).find(".alcance_po").eq(0).html();
                        difusion_pagina += link_po + "|" + alcance_po + ";";
                    });
                }

                if ($("#body_rs").find("tr").length > 0) {
                    $("#body_rs").find("tr").each(function() {
                        red_social = $(this).find(".red_social").eq(0).html();
                        alcance_rs = $(this).find(".alcance_rs").eq(0).html();
                        difusion_redes += red_social + "|" + alcance_rs + ";";
                    });
                }

                if ($("#body_buzon").find("tr").length > 0) {
                    $("#body_buzon").find("tr").each(function() {
                        buzon_direccion = $(this).find(".buzon_direccion").eq(0).html();
                        alcance_buzon = $(this).find(".alcance_buzon").eq(0).html();
                        difusion_buzon += buzon_direccion + "|" + alcance_buzon + ";";
                    });
                }

                if ($("#body_telefono").find("tr").length > 0) {
                    $("#body_telefono").find("tr").each(function() {
                        telefono_atencion = $(this).find(".telefono_atencion").eq(0).html();
                        alcance_telefono = $(this).find(".alcance_telefono").eq(0).html();
                        difusion_telefonica += telefono_atencion + "|" + alcance_telefono + ";";
                    });
                }

                if ($("#body_oficina").find("tr").length > 0) {
                    $("#body_oficina").find("tr").each(function() {
                        oficina_atencion = $(this).find(".oficina_atencion").eq(0).html();
                        alcance_oficina = $(this).find(".alcance_oficina").eq(0).html();
                        difusion_personal += oficina_atencion + "|" + alcance_oficina + ";";
                    });
                }

                if ($("#body_otro").find("tr").length > 0) {
                    $("#body_otro").find("tr").each(function() {
                        otro_atencion = $(this).find(".otro_atencion").eq(0).html();
                        alcance_otro = $(this).find(".alcance_otro").eq(0).html();
                        difusion_otro += otro_atencion + "|" + alcance_otro + ";";
                    });
                }

                //alert(difusion_pagina+"\n"+difusion_redes+"\n"+difusion_buzon+"\n"+difusion_telefonica+"\n"+difusion_personal+"\n"+difusion_otro);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('itar.almacena4') }}",
                    data: {
                        idITAR: idITAR,
                        im_s: im_s,
                        im_e: im_e,
                        im_a: im_a,
                        p_o: difusion_pagina,
                        r_s: difusion_redes,
                        b_d: difusion_buzon,
                        a_t: difusion_telefonica,
                        a_p: difusion_personal,
                        otro: difusion_otro,
                        _token: $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        block(true)
                    }
                }).done(function(response) {
                    if (response.result == "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Difusión e impacto!',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                            $("#indicador4").removeClass("activo");
                            $("#indicador5").addClass("activo");
                            $("#itar4").hide();
                            $("#itar5").show();
                        });


                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Almacenamiento de información de difusión e impacto',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
                    }
                    block(false)
                }).fail(function(data) {
                    block(false)
                });

            }
            /*
                        $("#indicador4").removeClass("activo");
                        $("#indicador5").addClass("activo");
                        $("#itar4").hide();
                        $("#itar5").show();*/

        }

        function almacena5() {
            if (valida5()) {
                //
                medios = "";
                descripciones = "";

                $(".medio").each(function() {
                    medios += $(this).val() + "|";
                });
                $(".descripcionmedio").each(function() {
                    descripciones += $(this).val() + "|";
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ route('itar.almacenamedios') }}",
                    data: {
                        idITAR: $("#idITARm").val(),
                        medios: medios,
                        descripciones: descripciones,
                        _token: $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        block(true)
                    }
                }).done(function(response) {
                    if (response.result == "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Medios de Verificación.',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                            window.location.replace("{{ route('itar.listado') }}")
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Almacenamiento de medios de verificación',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
                    }
                    block(false)
                }).fail(function(data) {
                    block(false)
                });




                /*

                                $("#indicador5").removeClass("activo");
                                $("#indicador1").addClass("activo");
                                $("#itar5").hide();
                                $("#itar1").show();*/
            }

        }

        function before(indice) {
            $("#indicador" + (indice + 1)).removeClass("activo");
            $("#indicador" + indice).addClass("activo");
            $("#itar" + (indice + 1)).hide()
            $("#itar" + (indice)).show()
        }

        function valida1() {
            inputs = [
                "nombre",
                "objetivo",
                "descripcion",
            ];
            selects = [
                "periodicidad",
                "cobertura",
                "anio_inicio",
                "idEjePED",
                "idTemaPED",
                "idObjetivoPED",
                "idEstrategiaPED",
                "idLAPED",
                "idIndicador",
                "tipologia"

            ];
            valid = true;

            for (var x = 0; x < inputs.length; x++) {
                if ($("#" + inputs[x]).val().trim().length == 0) {
                    $("#" + inputs[x]).addClass("is-invalid");
                    valid = false;
                } else {
                    $("#" + inputs[x]).removeClass("is-invalid");
                }
            }

            for (var x = 0; x < selects.length; x++) {
                if ($("#" + selects[x]).val() == '') {
                    $("#" + selects[x]).addClass("is-invalid");
                    valid = false;
                } else {
                    $("#" + selects[x]).removeClass("is-invalid");
                }
            }

            return valid;
        }

        function valida2() {
            valid = true;
            $(".programa").each(function() {
                if ($(this).val() == "") {
                    valid = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            });

            $(".ejercicio").each(function() {
                if ($(this).val() == "") {
                    valid = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            });

            $(".fecha_corte").each(function() {
                if ($(this).val() == "") {
                    valid = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            });
            return valid;
        }

        function valida3() {
            inputs = [
                "descripcion_pb",
                "po",
                "po_m",
                "po_h",
                "pb1_t",
                "pb2_t",
                "pb1_m",
                "pb1_h",
                "pb2_m",
                "pb2_h",
            ];
            selects = [
                "idPoblacion"
            ];
            valid = true;

            if($("#tipologia").val()=="inversion"){
                inputs.push("o_a");
                inputs.push("o_e");
            }

            for (var x = 0; x < inputs.length; x++) {
                if ($("#" + inputs[x]).val().trim().length == 0) {
                    $("#" + inputs[x]).addClass("is-invalid");
                    valid = false;
                } else {
                    $("#" + inputs[x]).removeClass("is-invalid");
                }
            }

            for (var x = 0; x < selects.length; x++) {
                if ($("#" + selects[x]).val() == '') {
                    $("#" + selects[x]).addClass("is-invalid");
                    valid = false;
                } else {
                    $("#" + selects[x]).removeClass("is-invalid");
                }
            }

            $(".idRegion").each(function() {
                if ($(this).val() == "") {
                    valid = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            });

            $(".tpm").each(function() {
                if ($(this).val() == "") {
                    valid = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            });

            $(".tph").each(function() {
                if ($(this).val() == "") {
                    valid = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            });

            $(".tp").each(function() {
                if ($(this).val() == "") {
                    valid = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            });

            $(".num_mun").each(function() {
                if ($(this).val() == "") {
                    valid = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            });

            $(".descripcion_bs").each(function() {
                if ($(this).val() == "") {
                    valid = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            });
            $(".unidad_bs").each(function() {
                if ($(this).val() == "") {
                    valid = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            });
            $(".bs1p").each(function() {
                if ($(this).val() == "") {
                    valid = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            });
            $(".bs2p").each(function() {
                if ($(this).val() == "") {
                    valid = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            });
            $(".bs3p").each(function() {
                if ($(this).val() == "") {
                    valid = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            });
            $(".bs4p").each(function() {
                if ($(this).val() == "") {
                    valid = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            });
            $(".bs1r").each(function() {
                if ($(this).val() == "") {
                    valid = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            });
            $(".bs2r").each(function() {
                if ($(this).val() == "") {
                    valid = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            });
            $(".bs3r").each(function() {
                if ($(this).val() == "") {
                    valid = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            });
            $(".bs4r").each(function() {
                if ($(this).val() == "") {
                    valid = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            });






            return valid;
        }

        function valida5() {
            valid = true;

            $(".descripcionmedio").each(function() {
                if ($(this).val() == "") {
                    valid = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            });

            return valid;
        }

        //Alineacion

        function getTemas() {
            if ($("#idEjePED").val() != 0) {
                $("#idObjetivoPED").html("");
                $.ajax({
                    type: 'GET',
                    url: "{{ route('gettemas') }}",
                    data: {
                        idEjePED: $("#idEjePED").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        //block(true);
                    }
                }).done(function(response) {
                    //block(false);
                    options = "<option value=''>--Seleccione</option>";
                    if (response.success = "ok") {
                        for (x = 0; x < response.temas.length; x++) {
                            options += "<option value='" + response.temas[x].idTemaPED + "'>" +
                                response.temas[x].temaPEDClave + " " + response.temas[x].temaPEDDescripcion +
                                "</option>";
                        }
                        $("#idTemaPED").html(options);
                        $("#idObjetivoPED").html("<option value=''>--Seleccione</option>");
                        $("#idEstrategiaPED").html("<option value=''>--Seleccione</option>");
                        $("#idLAPED").html("<option value=''>--Seleccione</option>");
                    }
                });
            } else {}
        }

        function getObjetivos() {
            if ($("#idTemaPED").val() != 0) {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('getobjetivos') }}",
                    data: {
                        idTemaPED: $("#idTemaPED").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        //block(true);
                    }
                }).done(function(response) {
                    //block(false);
                    if (response.success = "ok") {
                        options = "<option value=''>--Seleccione</option>";
                        for (x = 0; x < response.objetivos.length; x++) {
                            for (x = 0; x < response.objetivos.length; x++) {
                                options += "<option value='" + response.objetivos[x].idObjetivoPED + "'>" +
                                    response.objetivos[x].objetivoPEDClave + " " + response.objetivos[x]
                                    .objetivoPEDDescripcion +
                                    "</option>";
                            }
                        }
                        $("#idObjetivoPED").html(options);
                        $("#idEstrategiaPED").html("<option value=''>--Seleccione</option>");
                        $("#idLAPED").html("<option value=''>--Seleccione</option>");
                    }
                });
            } else {}

        }

        function getEstrategias() {
            if ($("#idObjetivoPED").val() != 0) {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('getestrategias') }}",
                    data: {
                        idObjetivoPED: $("#idObjetivoPED").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        //block(true);
                    }
                }).done(function(response) {
                    //block(false);
                    if (response.success = "ok") {
                        options = "<option value=''>--Seleccione</option>";
                        for (x = 0; x < response.estrategias.length; x++) {
                            for (x = 0; x < response.estrategias.length; x++) {
                                options += "<option value='" + response.estrategias[x].idEstrategiaPED + "'>" +
                                    response.estrategias[x].estrategiaPEDClave + " " + response.estrategias[x]
                                    .estrategiaPEDDescripcion +
                                    "</option>";
                            }
                        }
                        $("#idEstrategiaPED").html(options);
                    }
                });
            } else {}

        }

        function getLineas() {
            if ($("#idEstrategiaPED").val() != 0) {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('getlineas') }}",
                    data: {
                        idEstrategiaPED: $("#idEstrategiaPED").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        // block(true);
                    }
                }).done(function(response) {
                    //block(false);
                    if (response.success = "ok") {
                        options = "<option value=''>--Seleccione</option>";
                        for (x = 0; x < response.lineas.length; x++) {
                            for (x = 0; x < response.lineas.length; x++) {
                                options += "<option value='" + response.lineas[x].idLAPED + "'>" +
                                    response.lineas[x].laPEDClave + " " + response.lineas[x].laPEDDescripcion +
                                    "</option>";
                            }
                        }
                        $("#idLAPED").html(options);
                    }
                });
            } else {}

        }

        function voidReglas() {
            if ($("input[name='tipo']:checked").val() != "programa") {
                $("input[name='reglas']:checked").prop("checked", false);
            } else {
                $("#reglassi").prop("checked", true);
            }

        }

        //Funciones para la segunda parte

        function addPresupuesto() {
            row = '<table style="width:100%" class="presupuesto">' +
                '<tr>' +
                '<td colspan="6" class="enc2" style="text-align: center">Presupuesto <input type="hidden" class="idPresupuesto" value=""></td>' +
                '</tr>' +
                '<tr>' +
                '<td colspan="6" class="" style="text-align: right"><button class="btn btn-danger" onclick="eliminaPresupuesto($(this))"><i class="fas fa-trash"></i> Eliminar registro</button></td>' +
                '</tr>' +
                '<tr>' +
                '<td style="width: 15%" class="enc1">' +
                'Ejercicio: <span style="color: red">*</span>' +
                '</td>' +
                '<td colspan="5">' +
                '<select class="ejercicio form-control" >' +
                '<option value="">--Seleccione</option>' +
                '<option value="2024" selected>2024</option>' +
                '</select>' +
                '<div class="invalid-feedback" style="">' +
                'Seleccione un ejercicio' +
                '</div>' +
                '</td>' +
                '</tr>' +
                '<tr>' +
                '<td style="width: 15%" class="enc1">' +
                'Programa Presupuestario: <span style="color: red">*</span>' +
                '</td>' +
                '<td colspan="5">' +
                '<select class="programa form-control" >' +
                '<option value="">--Seleccione</option>' +
                @foreach ($programas as $programa)
                    '<option value="{{ $programa->idPrograma }}">{{ $programa->clavePrograma . ' ' . $programa->descripcionPrograma }}</option>' +
                @endforeach
            '</select>' +
            '<div class="invalid-feedback" style="">' +
            'Seleccione el programa presupuestario' +
            '</div>' +
            '</td>' +
            '</tr>' +
            '<tr>' +
            '<td style="width: 15%" class="enc1">' +
            'Fecha de Corte: <span style="color: red">*</span>' +
            '</td>' +
            '<td colspan="5">' +
            '<input type="date" class="fecha_corte form-control"' +
            'value="{{ date('Y-m-d') }}" />' +
            '<div class="invalid-feedback" style="">' +
            'Indique una fecha de corte' +
            '</div>' +
            '</td>' +
            '</tr>' +
            '<tr>' +
            '<td colspan="6" class="enc1" style="text-align: center">Federal</td>' +
            '</tr>' +
            '<tr>' +
            '<td class="enc1" style="text-align: center">Presupuesto</td>' +
            '<td class="enc1" style="text-align: center">enero-marzo</td>' +
            '<td class="enc1" style="text-align: center">abril-junio</td>' +
            '<td class="enc1" style="text-align: center">julio-septiembre</td>' +
            '<td class="enc1" style="text-align: center">octubre-diciembre</td>' +
            '</tr>' +
            '<tr>' +
            '<td class="enc1">Modificado</td>' +
            '<td><input type="number" class="f1m form-control" style="text-align: right" onchange="refreshPorcentajes()"/><div style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">$ <span class="f1m-f" style="width: 100%"> </span></div></td>' +
            '<td><input type="number" class="f2m form-control" style="text-align: right" onchange="refreshPorcentajes()"/><div style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">$ <span class="f2m-f" style="width: 100%"> </span></div></td>' +
            '<td><input type="number" class="f3m form-control" style="text-align: right" readonly onchange="refreshPorcentajes()"/></td>' +
            '<td><input type="number" class="f4m form-control" style="text-align: right" readonly onchange="refreshPorcentajes()"/></td>' +
            '</tr>' +
            '<tr>' +
            '<td class="enc1">Ejercido</td>' +
            '<td><input type="number" class="f1e form-control" style="text-align: right" onchange="refreshPorcentajes()"/><div style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">$ <span class="f1e-f" style="width: 100%"> </span></div></td>' +
            '<td><input type="number" class="f2e form-control" style="text-align: right" onchange="refreshPorcentajes()"/><div style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">$ <span class="f2e-f" style="width: 100%"> </span></div></td>' +
            '<td><input type="number" class="f3e form-control" style="text-align: right" readonly onchange="refreshPorcentajes()"/></td>' +
            '<td><input type="number" class="f4e form-control" style="text-align: right" readonly onchange="refreshPorcentajes()"/></td>' +
            '</tr>' +
            '<tr>' +
            '<td class="enc1">Porcentaje</td>' +
            '<td class="pf1"></td>' +
            '<td class="pf2"></td>' +
            '<td class="pf3"></td>' +
            '<td class="pf4"></td>' +
            '</tr>' +
            '<tr>' +
            '<td colspan="6" class="enc1" style="text-align: center">Estatal</td>' +
            '</tr>' +
            '<tr>' +
            '<td class="enc1" style="text-align: center">Presupuesto</td>' +
            '<td class="enc1" style="text-align: center">enero-marzo</td>' +
            '<td class="enc1" style="text-align: center">abril-junio</td>' +
            '<td class="enc1" style="text-align: center">julio-septiembre</td>' +
            '<td class="enc1" style="text-align: center">octubre-diciembre</td>' +
            '</tr>' +
            '<tr>' +
            '<td class="enc1">Modificado</td>' +
            '<td><input type="number" class="e1m form-control" style="text-align: right" onchange="refreshPorcentajes()"/><div style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">$ <span class="e1m-f" style="width: 100%"> </span></div></td>' +
            '<td><input type="number" class="e2m form-control" style="text-align: right" onchange="refreshPorcentajes()"/><div style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">$ <span class="e2m-f" style="width: 100%"> </span></div></td>' +
            '<td><input type="number" class="e3m form-control" style="text-align: right" readonly onchange="refreshPorcentajes()"/></td>' +
            '<td><input type="number" class="e4m form-control" style="text-align: right" readonly onchange="refreshPorcentajes()"/></td>' +
            '</tr>' +
            '<tr>' +
            '<td class="enc1">Ejercido</td>' +
            '<td><input type="number" class="e1e form-control" style="text-align: right" onchange="refreshPorcentajes()"/><div style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">$ <span class="e1e-f" style="width: 100%"> </span></div></td>' +
            '<td><input type="number" class="e2e form-control" style="text-align: right" onchange="refreshPorcentajes()"/><div style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">$ <span class="e2e-f" style="width: 100%"> </span></div></td>' +
            '<td><input type="number" class="e3e form-control" style="text-align: right" readonly onchange="refreshPorcentajes()"/></td>' +
            '<td><input type="number" class="e4e form-control" style="text-align: right" readonly onchange="refreshPorcentajes()"/></td>' +
            '</tr>' +
            '<tr>' +
            '<td class="enc1">Porcentaje</td>' +
            '<td class="pe1"></td>' +
            '<td class="pe2"></td>' +
            '<td class="pe3"></td>' +
            '<td class="pe4"></td>' +
            '</tr>' +
            '<tr>' +
            '<td colspan="6" class="enc1" style="text-align: center">Municipal</td>' +
            '</tr>' +
            '<tr>' +
            '<td class="enc1" style="text-align: center">Presupuesto</td>' +
            '<td class="enc1" style="text-align: center">enero-marzo</td>' +
            '<td class="enc1" style="text-align: center">abril-junio</td>' +
            '<td class="enc1" style="text-align: center">julio-septiembre</td>' +
            '<td class="enc1" style="text-align: center">octubre-diciembre</td>' +
            '</tr>' +
            '<tr>' +
            '<td class="enc1">Modificado</td>' +
            '<td><input type="number" class="m1m form-control" style="text-align: right" onchange="refreshPorcentajes()"/><div style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">$ <span class="m1m-f" style="width: 100%"> </span></div></td>' +
            '<td><input type="number" class="m2m form-control" style="text-align: right" onchange="refreshPorcentajes()"/><div style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">$ <span class="m2m-f" style="width: 100%"> </span></div></td>' +
            '<td><input type="number" class="m3m form-control" style="text-align: right" readonly onchange="refreshPorcentajes()"/></td>' +
            '<td><input type="number" class="m4m form-control" style="text-align: right" readonly onchange="refreshPorcentajes()"/></td>' +
            '</tr>' +
            '<tr>' +
            '<td class="enc1">Ejercido</td>' +
            '<td><input type="number" class="m1e form-control" style="text-align: right" onchange="refreshPorcentajes()"/><div style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">$ <span class="m1e-f" style="width: 100%"> </span></div></td>' +
            '<td><input type="number" class="m2e form-control" style="text-align: right" onchange="refreshPorcentajes()"/><div style="width: 100%;text-align:right;padding-right:20px;font-size:1.3em;background-color:#afafb4;color:white">$ <span class="m2e-f" style="width: 100%"> </span></div></td>' +
            '<td><input type="number" class="m3e form-control" style="text-align: right" readonly onchange="refreshPorcentajes()"/></td>' +
            '<td><input type="number" class="m4e form-control" style="text-align: right" readonly onchange="refreshPorcentajes()"/></td>' +
            '</tr>' +
            '<tr>' +
            '<td class="enc1">Porcentaje</td>' +
            '<td class="pm1"></td>' +
            '<td class="pm2"></td>' +
            '<td class="pm3"></td>' +
            '<td class="pm4"></td>' +
            '</tr>' +
            '<tr>' +
            '<td colspan="6" class="enc1" style="text-align: center">Total</td>' +
            '</tr>' +
            '<tr>' +
            '<td class="enc1" style="text-align: center">Presupuesto</td>' +
            '<td class="enc1" style="text-align: center">enero-marzo</td>' +
            '<td class="enc1" style="text-align: center">abril-junio</td>' +
            '<td class="enc1" style="text-align: center">julio-septiembre</td>' +
            '<td class="enc1" style="text-align: center">octubre-diciembre</td>' +
            '</tr>' +
            '<tr>' +
            '<td class="enc1">Modificado</td>' +
            '<td class="t1m"></td>' +
            '<td class="t2m"></td>' +
            '<td class="t3m"></td>' +
            '<td class="t4m"></td>' +
            '</tr>' +
            '<tr>' +
            '<td class="enc1">Ejercido</td>' +
            '<td class="t1e"></td>' +
            '<td class="t2e"></td>' +
            '<td class="t3e"></td>' +
            '<td class="t4e"></td>' +
            '</tr>' +
            '<tr>' +
            '<td class="enc1">Porcentaje</td>' +
            '<td class="pt1"></td>' +
            '<td class="pt2"></td>' +
            '<td class="pt3"></td>' +
            '<td class="pt4"></td>' +
            '</tr>' +
            '</table>';
            $("#presupuestos").append(row);
        }

        function refreshPorcentajes() {
            contador = 0;
            total_m = 0;
            total_e = 0;
            $(".f1m").each(function() {


                f1m = $(this).val();
                $(".f1m-f").eq(contador).html(new Intl.NumberFormat('es-MX').format(f1m));
                f1e = $(".f1e").eq(contador).val();
                $(".f1e-f").eq(contador).html(new Intl.NumberFormat('es-MX').format(f1e));
                pf1 = (f1e / f1m) * 100;
                if (!isNaN(pf1)) {
                    $(".pf1").eq(contador).html(pf1.toFixed(2) + "%");
                }

                f2m = $(".f2m").eq(contador).val();
                $(".f2m-f").eq(contador).html(new Intl.NumberFormat('es-MX').format(f2m));
                f2e = $(".f2e").eq(contador).val();
                $(".f2e-f").eq(contador).html(new Intl.NumberFormat('es-MX').format(f2e));
                pf2 = (f2e / f2m) * 100;
                if (!isNaN(pf2)) {
                    $(".pf2").eq(contador).html(pf2.toFixed(2) + "%");
                }

                //3er y 4to Trimestre Federal
                /*
                f3m = $(".f3m").eq(contador).val();
                f3e = $(".f3e").eq(contador).val();
                pf3 = (f3e/f3m)*100;
                if(!isNaN(pf3)){
                    $(".pf3").eq(contador).html(pf3.toFixed(2)+"%");
                }

                f4m = $(".f4m").eq(contador).val();
                f4e = $(".f4e").eq(contador).val();
                pf4 = (f4e/f4m)*100;
                if(!isNaN(pf4)){
                    $(".pf4").eq(contador).html(pf4.toFixed(2)+"%");
                }
                */


                e1m = $(".e1m").eq(contador).val();
                $(".e1m-f").eq(contador).html(new Intl.NumberFormat('es-MX').format(e1m));
                e1e = $(".e1e").eq(contador).val();
                $(".e1e-f").eq(contador).html(new Intl.NumberFormat('es-MX').format(e1e));
                pe1 = (e1e / e1m) * 100;
                if (!isNaN(pe1)) {
                    $(".pe1").eq(contador).html(pe1.toFixed(2) + "%");
                }

                e2m = $(".e2m").eq(contador).val();
                $(".e2m-f").eq(contador).html(new Intl.NumberFormat('es-MX').format(e2m));
                e2e = $(".e2e").eq(contador).val();
                $(".e2e-f").eq(contador).html(new Intl.NumberFormat('es-MX').format(e2e));
                pe2 = (e2e / e2m) * 100;
                if (!isNaN(pe2)) {
                    $(".pe2").eq(contador).html(pe2.toFixed(2) + "%");
                }

                m1m = $(".m1m").eq(contador).val();
                $(".m1m-f").eq(contador).html(new Intl.NumberFormat('es-MX').format(m1m));
                m1e = $(".m1e").eq(contador).val();
                $(".m1e-f").eq(contador).html(new Intl.NumberFormat('es-MX').format(m1e));
                pm1 = (m1e / m1m) * 100;
                if (!isNaN(pm1)) {
                    $(".pm1").eq(contador).html(pm1.toFixed(2) + "%");
                }

                m2m = $(".m2m").eq(contador).val();
                $(".m2m-f").eq(contador).html(new Intl.NumberFormat('es-MX').format(m2m));
                m2e = $(".m2e").eq(contador).val();
                $(".m2e-f").eq(contador).html(new Intl.NumberFormat('es-MX').format(m2e));
                pm2 = (m2e / m2m) * 100;
                if (!isNaN(pm2)) {
                    $(".pm2").eq(contador).html(pm2.toFixed(2) + "%");
                }

                //seteamos los totales por presupuesto


                $(".presupuesto").each(function() {

                    //Modificado

                    f1m = 0;
                    e1m = 0;
                    m1m = 0;

                    f2m = 0;
                    e2m = 0;
                    m2m = 0;

                    f1m = parseFloat($(this).find(".f1m").eq(0).val() == "" ? 0 : $(this).find(".f1m").eq(0)
                        .val());
                    e1m = parseFloat($(this).find(".e1m").eq(0).val() == "" ? 0 : $(this).find(".e1m").eq(0)
                        .val());
                    m1m = parseFloat($(this).find(".m1m").eq(0).val() == "" ? 0 : $(this).find(".m1m").eq(0)
                        .val());

                    f2m = parseFloat($(this).find(".f2m").eq(0).val() == "" ? 0 : $(this).find(".f2m").eq(0)
                        .val());
                    e2m = parseFloat($(this).find(".e2m").eq(0).val() == "" ? 0 : $(this).find(".e2m").eq(0)
                        .val());
                    m2m = parseFloat($(this).find(".m2m").eq(0).val() == "" ? 0 : $(this).find(".m2m").eq(0)
                        .val());

                    total_modificado1 = f1m + e1m + m1m;
                    total_modificado2 = f2m + e2m + m2m;

                    $(this).find(".t1m").eq(0).html(new Intl.NumberFormat('es-MX').format(
                        total_modificado1));
                    $(this).find(".t2m").eq(0).html(new Intl.NumberFormat('es-MX').format(
                        total_modificado2));

                    //Ejercido
                    f1e = 0;
                    e1e = 0;
                    m1e = 0;

                    f2e = 0;
                    e2e = 0;
                    m2e = 0;

                    f1e = parseFloat($(this).find(".f1e").eq(0).val() == "" ? 0 : $(this).find(".f1e").eq(0)
                        .val());
                    e1e = parseFloat($(this).find(".e1e").eq(0).val() == "" ? 0 : $(this).find(".e1e").eq(0)
                        .val());
                    m1e = parseFloat($(this).find(".m1e").eq(0).val() == "" ? 0 : $(this).find(".m1e").eq(0)
                        .val());

                    f2e = parseFloat($(this).find(".f2e").eq(0).val() == "" ? 0 : $(this).find(".f2e").eq(0)
                        .val());
                    e2e = parseFloat($(this).find(".e2e").eq(0).val() == "" ? 0 : $(this).find(".e2e").eq(0)
                        .val());
                    m2e = parseFloat($(this).find(".m2e").eq(0).val() == "" ? 0 : $(this).find(".m2e").eq(0)
                        .val());

                    total_ejercido1 = f1e + e1e + m1e;
                    total_ejercido2 = f2e + e2e + m2e;

                    pt1 = (total_ejercido1 / total_modificado1) * 100;
                    pt2 = (total_ejercido2 / total_modificado2) * 100;


                    $(this).find(".t1e").eq(0).html(new Intl.NumberFormat('es-MX').format(total_ejercido1
                        .toFixed(2)));
                    $(this).find(".t2e").eq(0).html(new Intl.NumberFormat('es-MX').format(total_ejercido2
                        .toFixed(2)));

                    $(this).find(".pt1").eq(0).html(isNaN(pt1) ? "0" : pt1.toFixed(2) + "%");
                    $(this).find(".pt2").eq(0).html(isNaN(pt2) ? "0" : pt2.toFixed(2) + "%");

                })
                contador++;
            })
        }

        function eliminaPresupuesto(elemento) {
            Swal.fire({
                title: '¿Está Seguro?',
                text: "No será posible recuperar el registro de presupuesto una vez eliminado!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    elemento.parent("td").parent("tr").parent("tbody").parent("table").hide("slow");
                    id = elemento.parent("td").parent("tr").parent("tbody").parent("table").find(".idPresupuesto")
                        .eq(0).val();
                    if (id == "") {
                        setTimeout(function() {
                            elemento.parent("td").parent("tr").parent("tbody").parent("table").remove();
                        }, 500)
                    } else {
                        //Mandámos la petición para que sea eliminado de la base de datos
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('itar.eliminap') }}",
                            data: {
                                idPresupuesto: id,
                                _token: $("input[name='_token']").val()
                            },
                            dataType: 'json',
                            beforeSend: function() {
                                block(true);
                            }
                        }).done(function(response) {
                            block(false);
                            if (response.result == "ok") {
                                setTimeout(function() {
                                    elemento.parent("td").parent("tr").parent("tbody").parent(
                                        "table").remove();
                                }, 500)
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Registro de presupuesto',
                                    text: response.message,
                                    confirmButtonColor: '#3085d6',
                                }).then((result) => {});
                            }
                        });
                    }

                }
            })
        }

        //Funciones para la 3ra parte
        function addRegion() {
            row = '<table style="width:100%" class="region">' +
                '<tr>' +
                '<td colspan="9" class="enc2" style="text-align: center">Distribucion' +
                'territorial/área geográfica atendida</td>' +
                '</tr>' +
                '<tr>' +
                '<td colspan="9" style="text-align: right"><button class="btn btn-danger" onclick="eliminaRegion($(this))"><i class="fas fa-trash" ></i> Eliminar registro</button></td>' +
                '</tr>' +
                '<tr>' +
                '<td class="enc1"  rowspan="2" style="width:15%">Regiones atendidas en el periodo que se reporta <input type="hidden" class="idITARRegion" value="">' +
                '</td>' +
                '<td colspan="8">' +
                '<select class="idRegion form-control" >' +
                '<option value="">--Seleccione</option>' +
                @foreach ($regiones as $region)
                    '<option value="{{ $region->id }}">{{ $region->nombre }}</option>' +
                @endforeach
            '</select>' +
            '<div class="invalid-feedback">' +
            'Seleccione una región' +
            '</div>' +
            '</td>' +
            '</tr>' +
            '<tr>' +
            '<td class="enc1">Total de mujeres atendidas</td>' +
            '<td><input type="number" class="form-control tpm" onchange="refreshPoblacionr($(this))"/>' +
            '<div class="invalid-feedback" style="">' +
            'Indique el total de mujeres atendidas' +
            '</div>' +
            '</td>' +
            '<td class="enc1">Total de hombres atendidos</td>' +
            '<td>' +
            '<input type="number" class="form-control tph" onchange="refreshPoblacionr($(this))"/>' +
            '<div class="invalid-feedback" style="">' +
            'Indique el total de homobres atendidos' +
            '</div>' +
            '</td>' +
            '<td class="enc1">Total de personas atendidas</td>' +
            '<td>' +
            '<input type="number" class="form-control tp" readonly/>' +
            '<div class="invalid-feedback" style="">' +
            'Indique el total de personas atendidas' +
            '</div>' +
            '</td>' +
            '</tr>' +
            '<tr>' +
            '<td class="enc1">Número de municipios atendidos</td>' +
            '<td>' +
            '<input type="number" class="form-control num_mun"/>' +
            '<div class="invalid-feedback" style="">' +
            'Indique el total de municipios atendidos' +
            '</div>' +
            '</td>' +
            '</tr>' +
            '</table>';
            $("#regiones").append(row);
        }

        function eliminaRegion(elemento) {

            //elemento.parent("td").parent("tr").parent("tbody").parent("table").css("background-color","red");
            Swal.fire({
                title: '¿Está Seguro?',
                text: "No será posible recuperar el registro de region atendida una vez eliminada!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarla!'
            }).then((result) => {
                if (result.isConfirmed) {
                    elemento.parent("td").parent("tr").parent("tbody").parent("table").hide("slow");
                    id = elemento.parent("td").parent("tr").parent("tbody").parent("table").find(".idITARRegion")
                        .eq(0).val();
                    if (id == "") {
                        setTimeout(function() {
                            elemento.parent("td").parent("tr").parent("tbody").parent("table").remove();
                        }, 500)
                    } else {
                        //Mandámos la petición para que sea eliminado de la base de datos
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('itar.eliminaregion') }}",
                            data: {
                                idITARRegion: id,
                                _token: $("input[name='_token']").val()
                            },
                            dataType: 'json',
                            beforeSend: function() {
                                block(true);
                            }
                        }).done(function(response) {
                            block(false);
                            if (response.result == "ok") {
                                setTimeout(function() {
                                    elemento.parent("td").parent("tr").parent("tbody").parent(
                                        "table").remove();
                                }, 500)
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Registro de región atendida',
                                    text: response.message,
                                    confirmButtonColor: '#3085d6',
                                }).then((result) => {});
                            }
                        });
                    }

                }
            })
        }

        function refreshBienes() {
            $(".BS").each(function(){
                bs1p = ($(this).find(".bs1p").eq(0).val() == "") ? 0 : $(this).find(".bs1p").eq(0).val();
                bs2p = ($(this).find(".bs2p").eq(0).val() == "") ? 0 : $(this).find(".bs2p").eq(0).val();
                bs3p = ($(this).find(".bs3p").eq(0).val() == "") ? 0 : $(this).find(".bs3p").eq(0).val();
                bs4p = ($(this).find(".bs4p").eq(0).val() == "") ? 0 : $(this).find(".bs4p").eq(0).val();

                bs1r = ($(this).find(".bs1r").eq(0).val() == "") ? 0 : $(this).find(".bs1r").eq(0).val();
                bs2r = ($(this).find(".bs2r").eq(0).val() == "") ? 0 : $(this).find(".bs2r").eq(0).val();
                bs3r = ($(this).find(".bs3r").eq(0).val() == "") ? 0 : $(this).find(".bs3r").eq(0).val();
                bs4r = ($(this).find(".bs4r").eq(0).val() == "") ? 0 : $(this).find(".bs4r").eq(0).val();

                pa1 = parseFloat(bs1r / bs1p) * 100;
                pa2 = parseFloat(bs2r / bs2p) * 100;
                pa3 = parseFloat(bs3r / bs3p) * 100;
                pa4 = parseFloat(bs4r / bs4p) * 100;

                $(this).find(".pa1").eq(0).html(isNaN(pa1) ? "" : pa1.toFixed(2));
                $(this).find(".pa2").eq(0).html(isNaN(pa2) ? "" : pa2.toFixed(2));
                $(this).find(".pa3").eq(0).html(isNaN(pa3) ? "" : pa3.toFixed(2));
                $(this).find(".pa4").eq(0).html(isNaN(pa4) ? "" : pa4.toFixed(2));
                });

        }

        function refreshPoblaciono() {
            po_m = parseFloat(($("#po_m").val() == "") ? 0 : $("#po_m").val());
            po_h = parseFloat(($("#po_h").val() == "") ? 0 : $("#po_h").val());
            po = (po_m + po_h);
            $("#po").val(isNaN(po) ? "" : po);
        }

        function refreshPoblacionb() {
            pb1_m = parseFloat(($("#pb1_m").val() == "") ? 0 : $("#pb1_m").val());
            pb2_m = parseFloat(($("#pb2_m").val() == "") ? 0 : $("#pb2_m").val());

            pb1_h = parseFloat(($("#pb1_h").val() == "") ? 0 : $("#pb1_h").val());
            pb2_h = parseFloat(($("#pb2_h").val() == "") ? 0 : $("#pb2_h").val());

            pb1_t = pb1_m + pb1_h;
            pb2_t = pb2_m + pb2_h;

            $("#pb1_t").val(pb1_t);
            $("#pb2_t").val(pb2_t);
        }

        function refreshPoblacionr(elemento) {
            tpm = parseFloat(elemento.parent("td").parent("tr").find(".tpm").eq(0).val() == "" ? 0 : elemento.parent("td")
                .parent("tr").find(".tpm").eq(0).val());
            tph = parseFloat(elemento.parent("td").parent("tr").find(".tph").eq(0).val() == "" ? 0 : elemento.parent("td")
                .parent("tr").find(".tph").eq(0).val());
            tp = tpm + tph;
            elemento.parent("td").parent("tr").find(".tp").eq(0).val(tp);
        }

        //funciones para la 4ta parte
        function addPagina() {
            link_po = $("#link_po").val();
            alcance_po = $("#alcance_po").val();
            if (link_po != "" && alcance_po != "") {
                row = '<tr>' +
                    '<td style="text-align: left" class="link_po">' + link_po + '</td>' +
                    '<td style="text-align: center" class="alcance_po">' + alcance_po + '</td>' +
                    '<td><button class="btn btn-danger" onclick="deleteRow($(this))"><i styele="font-size:.3em;" class="fas fa-trash"></i></button></td>' +
                    '</tr>';
                $("#body_pagina").append(row)
            }

            $("#link_po").val('');
            $("#alcance_po").val('');
        }

        function addRS() {
            red_social = $("#red_social").val();
            alcance_rs = $("#alcance_rs").val();
            if (red_social != "" && alcance_rs != "") {
                row = '<tr>' +
                    '<td style="text-align: left" class="red_social">' + red_social + '</td>' +
                    '<td style="text-align: center" class="alcance_rs">' + alcance_rs + '</td>' +
                    '<td><button class="btn btn-danger" onclick="deleteRow($(this))"><i styele="font-size:.3em;" class="fas fa-trash"></i></button></td>' +
                    '</tr>';
                $("#body_rs").append(row)
            }

            $("#red_social").val('');
            $("#alcance_rs").val('');
        }

        function addBuzon() {
            buzon_direccion = $("#buzon_direccion").val();
            alcance_buzon = $("#alcance_buzon").val();
            if (buzon_direccion != "" && alcance_buzon != "") {
                row = '<tr>' +
                    '<td style="text-align: left" class="buzon_direccion">' + buzon_direccion + '</td>' +
                    '<td style="text-align: center" class="alcance_buzon">' + alcance_buzon + '</td>' +
                    '<td><button class="btn btn-danger" onclick="deleteRow($(this))"><i styele="font-size:.3em;" class="fas fa-trash"></i></button></td>' +
                    '</tr>';
                $("#body_buzon").append(row)
            }

            $("#buzon_direccion").val('');
            $("#alcance_buzon").val('');
        }

        function addTelefono() {
            telefono_atencion = $("#telefono_atencion").val();
            alcance_telefono = $("#alcance_telefono").val();
            if (telefono_atencion != "" && alcance_telefono != "") {
                row = '<tr>' +
                    '<td style="text-align: left" class="telefono_atencion">' + telefono_atencion + '</td>' +
                    '<td style="text-align: center" class="alcance_telefono">' + alcance_telefono + '</td>' +
                    '<td><button class="btn btn-danger" onclick="deleteRow($(this))"><i styele="font-size:.3em;" class="fas fa-trash"></i></button></td>' +
                    '</tr>';
                $("#body_telefono").append(row)
            }

            $("#telefono_atencion").val('');
            $("#alcance_telefono").val('');
        }

        function addPersonal() {
            oficina_atencion = $("#oficina_atencion").val();
            alcance_oficina = $("#alcance_oficina").val();
            if (oficina_atencion != "" && alcance_oficina != "") {
                row = '<tr>' +
                    '<td style="text-align: left" class="oficina_atencion">' + oficina_atencion + '</td>' +
                    '<td style="text-align: center" class="alcance_oficina">' + alcance_oficina + '</td>' +
                    '<td><button class="btn btn-danger" onclick="deleteRow($(this))"><i styele="font-size:.3em;" class="fas fa-trash"></i></button></td>' +
                    '</tr>';
                $("#body_oficina").append(row)
            }

            $("#oficina_atencion").val('');
            $("#alcance_oficina").val('');
        }

        function addOtro() {
            otro_atencion = $("#otro_atencion").val();
            alcance_otro = $("#alcance_otro").val();
            if (otro_atencion != "" && alcance_otro != "") {
                row = '<tr>' +
                    '<td style="text-align: left" class="otro_atencion">' + otro_atencion + '</td>' +
                    '<td style="text-align: center" class="alcance_otro">' + alcance_otro + '</td>' +
                    '<td><button class="btn btn-danger" onclick="deleteRow($(this))"><i styele="font-size:.3em;" class="fas fa-trash"></i></button></td>' +
                    '</tr>';
                $("#body_otro").append(row)
            }

            $("#otro_atencion").val('');
            $("#alcance_otro").val('');
        }

        function deleteRow(elemento) {
            elemento.parent("td").parent("tr").remove();
        }

        function inicializaDropZone() {
            miareadecarga = new Dropzone("#medios-itar", {
                thumbnailWidth: 500,
                maxFilesize: 5,
                //disablePreviews:true,
                acceptedFiles: ".jpg,.jpeg,.png,.tiff,.raw,.pdf,.zip,.docx,.xlsx,.doc,.xls,application/x-zip-compressed,application/zip",
                buttonRemove: true
            });
            miareadecarga.on("addedfile", file => {
                //idIndicador = $("#idIndicador").val();
            });

            miareadecarga.on("success", function(file, response) {
                if (response.result == "ok") {
                    nombre = file.name;
                    filename = response.filename;
                    rowmedio = '<tr id="rowmedio' + response.medio_id + '">' +
                        '<td style="display:none">' + response.medio_id + '</td>' +
                        '<td class="medioitar" medio="" style="text-align:left"><input type="hidden" class="medio" name="" value="' +
                        response
                        .medio_id + '"><a target="blank_" href="{{ asset('medios') }}' + '/itar/' + $("#idITARm")
                        .val() +
                        "/" + filename + '">' + nombre + '</a></td>' +
                        '<td><textarea placeholder="Agrega Descripción" class="descripcionmedio form-control" name="descripcionmedio[]"></textarea><div class="invalid-feedback" style="">Indique una descripcion para el medio cargado</div></td>' +
                        '<td><button type="button" class="btn btn-danger" onclick="deleteMedioRelacionado(' +
                        response.medio_id + ')"><i class="fas fa-trash"></i></button></td>' +
                        '</tr>';
                    $("#medios_cargados").append(rowmedio);
                }
            });
        }

        function deleteMedioRelacionado(medio_id) {
            Swal.fire({
                title: '¿Está Seguro?',
                text: "No será posible recuperar el medio cargado una vez eliminado!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('itar.mediodelete') }}",
                        data: {
                            medio_id: medio_id,
                            idITARm: $("#idITARm").val(),
                            _token: $("input[name='_token']").val()
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            block(true)
                        }
                    }).done(function(response) {
                        if (response.result == "ok") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Medios eliminados',
                                text: response.message,
                                confirmButtonColor: '#3085d6',
                            }).then((result) => {
                                $("#rowmedio" + medio_id).hide('slow');
                                setTimeout(function() {
                                    $("#rowmedio" + medio_id).remove()
                                }, 200);
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Medios cargados',
                                text: response.message,
                                confirmButtonColor: '#3085d6',
                            }).then((result) => {});
                        }
                        block(false)
                    }).fail(function(data) {
                        block(false)
                    });
                }
            });
        }

        function addLink() {
            link = $("#link").val();
            descripcion_link = $("#descripcion_link").val();
            if (link != "" && descripcion_link != "") {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('itar.medioaddlink') }}",
                    data: {
                        idITAR: $("#idITARm").val(),
                        link: link,
                        descripcion_link: descripcion_link,
                        _token: $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        block(true)
                    }
                }).done(function(response) {
                    if (response.result == "ok") {
                        row = '<tr id="rowlink' + response.medio_id + '">' +
                            '<td style="text-align: center">' + link + '</td>' +
                            '<td style="text-align: center">' + descripcion_link + '</td>' +
                            '<td style="text-align: center"><button class="btn btn-danger" onclick="deleteLink(' +
                            response.medio_id + ')"><i class="fas fa-trash"></i></button></td>' +
                            '</tr>';
                        $("#links_probatorios").append(row);
                        $("#link").val("");
                        $("#descripcion_link").val("");

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Almacenamiento de información de links como medios de verificación',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
                    }
                    block(false)
                }).fail(function(data) {
                    block(false)
                });
            }
        }

        function deleteLink(id) {
            Swal.fire({
                title: '¿Está Seguro?',
                text: "No será posible recuperar el link agregado!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('itar.deletelink') }}",
                        data: {
                            medio_id: id,
                            idITARm: $("#idITARm").val(),
                            _token: $("input[name='_token']").val()
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            block(true)
                        }
                    }).done(function(response) {
                        if (response.result == "ok") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Link eliminados',
                                text: response.message,
                                confirmButtonColor: '#3085d6',
                            }).then((result) => {
                                $("#rowlink" + id).hide('slow');
                                setTimeout(function() {
                                    $("#rowlink" + id).remove()
                                }, 200);
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Links',
                                text: response.message,
                                confirmButtonColor: '#3085d6',
                            }).then((result) => {});
                        }
                        block(false)
                    }).fail(function(data) {
                        block(false)
                    });
                }
            });
        }

        function addBS() {
            row = '<table style="width:100%" class="BS">' +
                '<tr>' +
                '<td colspan="6" class="enc2" style="text-align: center">Bienes o servicios que se entregan<input type="hidden" class="idBS"/></td>' +
                '</tr>' +
                '<tr>' +
                '<td colspan="6" class="" style="text-align: right"><button class="btn btn-danger" onclick="removeBS($(this))"><i class="fas fa-trash"></i> Eliminar bien o servicio</button></td>' +
                '</tr>' +
                '<tr>' +
                '<td class="enc1" style="width:15%">Descripcion del bien o servicio: <span' +
                '       style="color: red">*</span></td>' +
                '<td colspan="2">' +
                '<textarea name="descripcion_bs" class="form-control descripcion_bs"></textarea>' +
                '<div class="invalid-feedback" style="">' +
                'Indique una descripción del Bien o servicio' +
                '</div>' +
                '</td>' +
                '<td class="enc1">Unidad de medida: <span style="color: red">*</span></td>' +
                '<td><input type="text" class="form-control unidad_bs" name="unidad_bs" ' +
                '/>' +
                '<div class="invalid-feedback" style="">' +
                '   Indique la Unidad de medida' +
                '</div>' +
                '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="enc1">Cantidad</td>' +
                '<td class="enc1" style="width: 21.25%">enero-marzo</td>' +
                '<td class="enc1" style="width: 21.25%">abril-junio</td>' +
                '<td class="enc1" style="width: 21.25%">julio-septiembre</td>' +
                '<td class="enc1" style="width: 21.25%">octubre-diciembre</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="enc1">Programada</td>' +
                '<td>' +
                '<input type="number" class="form-control bs1p" name="bs1p"' +
                'onchange="refreshBienes()" >' +
                '<div class="invalid-feedback" style="">' +
                'Indique la cantidad programa para el 1er trimestre' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<input type="number" class="form-control bs2p" name="bs2p"' +
                'onchange="refreshBienes()" >' +
                '<div class="invalid-feedback" style="">' +
                'Indique la cantidad programa para el 2do trimestre' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<input type="number" class="form-control bs3p" name="bs3p"' +
                'onchange="refreshBienes()" >' +
                '<div class="invalid-feedback" style="">' +
                'Indique la cantidad programa para el 3er trimestre' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<input type="number" class="form-control bs4p"  name="bs4p"' +
                'onchange="refreshBienes()" >' +
                '<div class="invalid-feedback" style="">' +
                'Indique la cantidad programa para el 4to trimestre' +
                '</div>' +
                '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="enc1">Entregada</td>' +
                '<td>' +
                '<input type="number" class="form-control bs1r" name="bs1r"' +
                'onchange="refreshBienes()" >' +
                '<div class="invalid-feedback" style="">' +
                'Indique la cantidad entregada para el 1er trimestre' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<input type="number" class="form-control bs2r" name="bs2r"' +
                'onchange="refreshBienes()" >' +
                '<div class="invalid-feedback" style="">' +
                'Indique la cantidad entregada para el 2do trimestre' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<input type="number" class="form-control bs3r"  name="bs3r"  ' +
                'onchange="refreshBienes()" >' +
                '<div class="invalid-feedback" style="">' +
                'Indique la cantidad entregada para el 3er trimestre' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<input type="number" class="form-control bs4r" name="bs4r"  ' +
                'onchange="refreshBienes()" >' +
                '<div class="invalid-feedback" style="">' +
                'Indique la cantidad entregada para el 4to trimestre' +
                '</div>' +
                '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="enc1">Porcentaje de avance</td>' +
                '<td class="pa1" style="text-align:right"></td>' +
                '<td class="pa2" style="text-align:right"></td>' +
                '<td class="pa3" style="text-align:right"></td>' +
                '<td class="pa4" style="text-align:right"></td>' +
                '</tr></table>';
            $("#body_bs").append(row);
        }

        function removeBS(elemento) {
            Swal.fire({
                title: '¿Está Seguro?',
                text: "No será posible recuperar el registro del bien o servicio una vez eliminado!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo!'
            }).then((result) => {
                if (result.isConfirmed) {

                    id = elemento.parent("td").parent("tr").parent("tbody").parent("table").find(".idBS")
                        .eq(0).val();
                    if (id == "") {
                        setTimeout(function() {
                            elemento.parent("td").parent("tr").parent("tbody").parent("table").hide("slow");
                            elemento.parent("td").parent("tr").parent("tbody").parent("table").remove();
                        }, 500)
                    } else{
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('itar.eliminabs') }}",
                            data: {
                                idBS: id,
                                _token: $("input[name='_token']").val()
                            },
                            dataType: 'json',
                            beforeSend: function() {
                                block(true);
                            }
                        }).done(function(response) {
                            block(false);
                            if (response.result == "ok") {
                                setTimeout(function() {
                                    elemento.parent("td").parent("tr").parent("tbody").parent("table").hide("slow");
                                    elemento.parent("td").parent("tr").parent("tbody").parent("table").remove();
                                }, 500)
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Registro de Bien o Servicio entregado',
                                    text: response.message,
                                    confirmButtonColor: '#3085d6',
                                }).then((result) => {});
                            }
                        });

                    }

                }

            })
        }
        function showSObra(){
            tipologia = $("#tipologia").val();
            if(tipologia == "inversion"){
                $("#seguimiento_obras").show("slow");
            }else{
                $("#seguimiento_obras").hide("slow");
            }
        }
        function freshObras(){
            obras_autorizadas = $("#o_a").val();
            obras_ejecutadas = $("#o_e").val();
            cumplimiento = (obras_ejecutadas/obras_autorizadas)*100
            $("#pobra").html(cumplimiento.toFixed(2)+"%");
        }
    </script>
@endsection
