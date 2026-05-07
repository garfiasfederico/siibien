@extends('layouts.administrador')

@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">Indicador / editar</h1>
@endsection

@section('content')
    <div class="row">

        <div class="col-xl-12 col-lg-7" id="indicadorContent">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                    style="background-color:#681b2e;">
                    <h6 class="m-0 font-weight-bold text-primary" style="color:white !important;">Actualizar información del
                        Indicador: <span style="color:rgb(209, 209, 209)">{{ $indicador->indicadorNombre }}</span></h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Acciones:</div>
                            <a class="dropdown-item" onclick="setValues()" style="cursor: pointer"><i class="fas fa-fill"
                                    style="color:green;"></i> Rellenar Auto</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <h4>Generales</h4>
                    <form id="formIndicador" action="{{ route('indicador.update') }}">
                        @csrf
                        <input type="hidden" id="idIndicador" name="idIndicador" value="{{ $indicador->idIndicador }}">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="indicadorNombre">Nombre del Indicador:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="indicadorNombre" name="indicadorNombre"
                                    value="{{ $indicador->indicadorNombre }}" placeholder="Porcentaje de ......"
                                    value="" required>
                                <div class="invalid-feedback">
                                    Debe Indicar el nombre del Indicador!
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="indicadorObjetivo">Definición:<span style="color: red">*</span></label>
                                <textarea class="form-control" id="indicadorObjetivo" name="indicadorObjetivo" placeholder="Finalidad del Indicador"
                                    required>{{ $indicador->indicadorObjetivo }}</textarea>
                                <div class="invalid-feedback">
                                    Debe Indicar el Objetivo del Indicador
                                </div>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <label for="indicadorTipo">Tipo:<span style="color: red">*</span></label>
                                <select class="form-control" id="indicadorTipo" name="indicadorTipo">
                                    <option value="0" selected>Seleccione...</option>
                                    <option value="gestion">Gestión</option>
                                    <option value="estrategico">Estratégico</option>
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione un tipo
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="indicadorDimension">Dimensión:<span style="color: red">*</span></label>
                                <select class="form-control" id="indicadorDimension" name="indicadorDimension">
                                    <option value="0">Seleccione...</option>
                                    <option value="calidad">Calidad</option>
                                    <option value="economia">Economía</option>
                                    <option value="eficacia">Eficacia</option>
                                    <option value="eficiencia">Eficiencia</option>
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione una Dimension
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="indicadorMetodo">Método de Cálculo:<span style="color: red">*</span></label>
                                <select class="form-control" id="indicadorMetodo" name="indicadorMetodo" required>
                                    <option value="0">Seleccione...</option>
                                    <option value="porcentaje">Porcentaje</option>
                                    <option value="indice">Índice</option>
                                    <option value="tasa">Tasa</option>
                                    <option value="tasa_v">Tasa de variación</option>
                                    <option value="razon">Razón o Promedio</option>
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione Método de cálculo
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="indicadorUM">Unidad de Medida:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="indicadorUM" name="indicadorUM"
                                    value="{{ $indicador->indicadorUM }}" placeholder="Unidad" required />
                                <div class="invalid-feedback">
                                    Debe indicar una unidad de Medida!
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <label for="indicadorFormula">Fórmula de Cálculo:<span style="color: red">*</span></label>
                                <textarea class="form-control" id="indicadorFormula" name="indicadorFormula" placeholder="Fórmula" required>{{ $indicador->indicadorFormula }}</textarea>
                                <div class="invalid-feedback">
                                    Debe indicar la Fórmula de Cálculo!
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="indicadorInterpretacion">Interpretación del Indicador:<span
                                        style="color: red">*</span></label>
                                <textarea class="form-control" id="indicadorInterpretacion" name="indicadorInterpretacion"
                                    placeholder="Interpretacion" required>{{ $indicador->indicadorInterpretacion }}</textarea>
                                <div class="invalid-feedback">
                                    Debe indicar una Interpretación!
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="indicadorFrecuencia">Frecuencia de Medición:<span style="color: red">*</span></label>
                                <select class="form-control" id="indicadorFrecuencia" name="indicadorFrecuencia"
                                    required>
                                    <option value="0">Seleccione...</option>
                                    <option value="anual">Anual</option>
                                    <option value="mensual">Mensual</option>
                                    <option value="bimestral">Bimestral</option>
                                    <option value="trimestral">Trimestral</option>
                                    <option value="semestral">Semestral</option>
                                    <option value="bienal">Bienal</option>
                                    <option value="quinquenal">Quinquenal</option>
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione una Frecuencia
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="indicadorSentido">Sentido:<span style="color: red">*</span></label>
                                <select class="form-control" id="indicadorSentido" name="indicadorSentido" required>
                                    <option value="0">Seleccione...</option>
                                    <option value="ascendente">Ascendente</option>
                                    <option value="descendente">Descendente</option>
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione Sentido
                                </div>
                            </div>
                          <!--  <div class="col-md-3 mb-3">
                                <label for="indicadorTipoPeriodo">Tipo de Periodo de Medición:<span
                                        style="color: red">*</span></label>
                                <select class="form-control" id="indicadorTipoPeriodo" name="indicadorTipoPeriodo"
                                    required>
                                    <option value="0">Seleccione...</option>
                                    <option value="escolar">Ciclo Escolar</option>
                                    <option value="normal">Ciclo Normal</option>
                                    <option value="agricola">Ciclo Agrícola</option>
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione Tipo de Medición
                                </div>
                            </div>-->
                        </div>
                        <div class="form-row">

                           <!-- <div class="col-md-3 mb-3">
                                <label for="indicadorDesagregacion">Desagregacion:<span
                                        style="color: red">*</span></label>
                                <select class="form-control" id="indicadorDesagregacion" name="indicadorDesagregacion"
                                    required>
                                    <option value="0">Seleccione...</option>
                                    <option value="estatal">Estatal</option>
                                    <option value="municipal">Municipal</option>
                                    <option value="regional">Regional</option>
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione Desagregación
                                </div>
                            </div>-->
                            <div class="col-md-3 mb-3">
                                <label for="indicadorLB">Año de Línea Base:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="indicadorLB" name="indicadorLB"
                                    value={{ $indicador->indicadorAnioLB }} placeholder="Anio Linea Base" required />
                                <div class="invalid-feedback">
                                    Indique un Año para la línea base
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="valorAnioLB">Valor de la Línea Base:<span style="color: red">*</span></label>
                                <input type="number" class="form-control" id="valorAnioLB" name="valorAnioLB"
                                    placeholder="Valor de la Línea Base" value="{{ $indicador->valorAnioLB }}" required />
                                <div class="invalid-feedback">
                                    Indique el Valor de la Línea Base
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="fuente_informacion">Fuente de Información:<span style="color: red">*</span></label>
                                <textarea type="text" class="form-control" id="fuente_informacion" name="fuente_informacion"
                                    placeholder="Fuente de información del indicador" required >{{$indicador->fuente_informacion}}</textarea>
                                <div class="invalid-feedback">
                                    Indique la Fuente de Información del indicador
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="proxima_actualizacion">Fecha de Proxima Actualización:<span
                                        style="color: red">*</span></label>
                                <input type="text" class="form-control" id="proxima_actualizacion"
                                    name="proxima_actualizacion" placeholder="Fecha de la próxima actualización" required
                                    value="{{ $indicador->proxima_actualizacion }}" />
                                <div class="invalid-feedback">
                                    Indique Fecha de Actualización
                                </div>
                            </div>
                        </div>



                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="indicadorObservaciones">Observaciones</label>
                                <textarea class="form-control" id="indicadorObservaciones" name="indicadorObservaciones" placeholder="Observaciones"
                                    required>{{ $indicador->observaciones }}</textarea>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                        </div>
                        <!--  <div class="form-group">
                                                                                      <div class="form-check text-align-right">
                                                                                        <input class="form-check-input is-invalid" type="checkbox" value="" id="invalidCheck3" required>
                                                                                        <label class="form-check-label" for="invalidCheck3">
                                                                                          Agree to terms and conditions
                                                                                        </label>
                                                                                        <div class="invalid-feedback">
                                                                                          You must agree before submitting.
                                                                                        </div>
                                                                                      </div>
                                                                                    </div>-->
                        <!--  <div class="float-right">
                                            <a href="{{ route('indicador.list') }}"><button class="btn btn-secondary" type="button"
                                                onclick="">Cancelar</button></a>
                                                &nbsp;
                                            <button class="btn btn-primary" type="button"
                                                onclick="almacenaIndicador()">Actualizar</button>
                                        </div>-->

                        <div class="float-right">
                            <a href="{{ route('admin.indicadores') }}"><button class="btn btn-secondary" type="button"
                                    onclick="">Cancelar</button></a>
                            &nbsp;
                            <button class="btn btn-primary" type="button" onclick="nextVariables()">Siguiente</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-7" id="variablesContent" style="display:none">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                    style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-light">Registro de Variables</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Acciones:</div>

                            <a class="dropdown-item" onclick="addVariable()" style="cursor: pointer"><i
                                    class="fas fa-plus" style="color:green;"></i> Agregar Variable</a>
                            <!--<a class="dropdown-item" onclick="" style="cursor: pointer" data-toggle="modal"
                                                        data-target=".modal-alineaciones"><i class="fas fa-link" style="color:green;"></i>
                                                        Indicar
                                                        Alineaciones</a>-->
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="instrucciones">
                        <p><b>Instrucciones: </b> Para agregar variables al indicador, ubique el botón: <span
                                style="background-color:#681b2e;width:40px">&nbsp;<i class="fas fa-ellipsis-v"
                                    style="color: white"></i> </span> &nbsp; localizado en la parte superior derecha de
                            esta ventana y a continuación seleccione la opción "<i class="fas fa-plus"
                                style="color: green"></i> Agregar Variable."</p>
                    </div>
                    <div id="variableContent">
                        <input type="hidden" id="variablesEliminadas">
                        <div id="variables" class="row">
                            @foreach ($variables as $variable)
                                <div class="col-xl-4 col-lg-7 variable" id="variable{{ $variable->idVariable }}">
                                    <div class="card shadow mb-4">
                                        <!-- Card Header - Dropdown -->
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                                            style="background-color:#681b2e">
                                            <h6 class="m-0 font-weight-bold text-primary" style="color:white !important;">
                                                Registro de Variable</h6>
                                            <div class="dropdown no-arrow">
                                                <a class="dropdown-toggle" href="#" role="button"
                                                    id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                    aria-labelledby="dropdownMenuLink">
                                                    <div class="dropdown-header">Acciones:</div>
                                                    <a class="dropdown-item" href="#"
                                                        onclick="removeVariable('{{ $variable->idVariable }}')"><i
                                                            class="fas fa-trash" style="color:red"></i> Eliminar
                                                        Variable</a>
                                                    <!--<a class="dropdown-item" href="#">Something else here</a>-->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Card Body -->
                                        <div class="card-body">
                                            <h4>Generales</h4>
                                            <form>
                                                <div class="form-row actualiza">
                                                    <div class="col-md-6 mb-3">
                                                        <input type="hidden" class="form-control" id="idVariable"
                                                            value="{{ $variable->idVariable }}" />
                                                        <label for="variableNombre">Nombre de la Variable:<span
                                                                style="color: red">*</span></label>
                                                        <textarea type="text" class="form-control variableNombre" id="variableNombre" name="variableNombre"
                                                            placeholder="Poblacion total..." value="" required>{{ $variable->variableNombre }}</textarea>
                                                        <div class="invalid-feedback">
                                                            Indique un Nombre para la Variable!
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="variableUM">Unidad de Medida:<span
                                                                style="color: red">*</span></label>
                                                        <input type="text" class="form-control variableUM"
                                                            id="variableUM" placeholder="Unidad de Medida"
                                                            value="{{ $variable->variableUM }}" required />
                                                        <div class="invalid-feedback">
                                                            Indique una Unidad de Medida para la Variable!
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="float-right">
                        <button class="btn btn-secondary" type="button" onclick="prevIndicador()">Atras</button>
                        &nbsp;
                        <!--<button class="btn btn-primary" type="button"
                                                            onclick="almacenaIndicador()">Siguiente</button>-->
                        <button class="btn btn-primary" type="button" onclick="nextAlineaciones()">Siguiente</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-7" id="alineacionContent" style="display:none">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                    style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-light">Alineación a los Instrumentos de Planeación</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="instrucciones">
                        <p><b>Instrucciones: </b> Posiciónese sobre el Objetivo ó Programa y de clic para seleccionarlo,
                            para quitarlo dé clic nuevamente sobre él. A continuación de clic en el botón "Actualizar
                            Indicador"
                    </div>

                    <div class="row" id="alineacionesContent" style="padding-left:15%;padding-right:15%;">
                        <div class="col-xl-12 col-lg-7">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab"
                                        href="#nav-home" role="tab" aria-controls="nav-home"
                                        aria-selected="true">Objetivos PED<span id="objseleccionados"></span></a>
                                    <a class="nav-item nav-link" id="nav-plan-tab" data-toggle="tab"
                                        href="#nav-plan" role="tab" aria-controls="nav-plan"
                                        aria-selected="false">Plan Sectorial / Especial</a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab"
                                        href="#nav-profile" role="tab" aria-controls="nav-profile"
                                        aria-selected="false">ODS Agenda 2030<span id="objodsseleccionados"></span></a>
                                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab"
                                        href="#nav-contact" role="tab" aria-controls="nav-contact"
                                        aria-selected="false">Programas
                                        Presupuestarios<span id="programasseleccionados"></span></a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">

                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                    aria-labelledby="nav-home-tab">
                                    <div class="row" style="padding:15px;">
                                        <div class="col-md-12 mb-3">
                                            <label for="ejeped">Seleccione Eje del PED:<span
                                                    style="color: red">*</span></label>
                                            <select class="form-control" id="ejeped" name="ejeped"
                                                onchange="getTemas()">
                                                <option value="0">Seleccione...</option>
                                                @foreach ($ejes as $eje)
                                                    <option value="{{ $eje->idEjePED }}">
                                                        {{ $eje->ejePEDClave . ' ' . $eje->ejePEDDescripcion }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Debe Seleccionar Eje del PED!
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3" id="temaContent" style="display: none">
                                            <label for="temaped">Seleccione un Tema:<span
                                                    style="color: red">*</span></label>
                                            <select class="form-control" id="temaped" name="temaped"
                                                onchange="getObjetivos()">
                                            </select>
                                            <div class="invalid-feedback">
                                                Debe Seleccionar Tema del PED!
                                            </div>
                                        </div>
                                    </div>
                                    <!--<div class="text-right" style="padding:10px">
                                                <button type="button" class="btn btn-warning" title="Quitar seleccionados"
                                                    onclick="quitaSeleccionados('objetivo')">
                                                    <i class="fas fa-eraser"></i>
                                                </button>
                                            </div>-->
                                    <hr />
                                    <table class="table table-bordered" id="objetivos">
                                        <thead>
                                            <th style="width:10%">Clave</th>
                                            <th style="width:90%">Descripcion</th>
                                        </thead>
                                        <tbody id="objetivosped">
                                        </tbody>
                                    </table>
                                </div>
                               <!--Se agrega nueva pestaña  -->
                                <div class="tab-pane fade" id="nav-plan" role="tabpanel" aria-labelledby="nav-plan-tab">
                                <div style="padding:15px;">
                                    <p>Seleccione el plan sectorial o especial al que se alinee el indicador:</p>

                                    {{-- Sector --}}
                                    <div class="form-group">
                                    <label for="idSector">Sector:<span style="color: red">*</span></label>
                                    <select class="form-control" id="idSector" name="idSector" required>
                                        <option value="">Seleccione el sector correspondiente...</option>
                                        @foreach ($sectores as $sector)
                                        <option value="{{ $sector->idSector }}"
                                            {{ optional($sectorAsignado)->idSector == $sector->idSector ? 'selected' : '' }}>
                                            {{ $sector->claveSector . ' - ' . $sector->sector }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Debe indicar el sector.</div>
                                    </div>

                                    {{-- Objetivo (cargado completo, filtrado en front) --}}
                                    <div class="form-group">
                                    <label for="idObjetivo">Objetivo:<span class="required">*</span></label>
                                    <select name="idObjetivo" id="idObjetivo" class="form-control" required>
                                        <option value="">Seleccione el objetivo del sector...</option>
                                        @foreach ($objetivosSector as $obj)
                                        <option value="{{ $obj->idObjetivo }}"
                                                data-sector="{{ $obj->idSector }}"
                                                {{ optional($sectorAsignado)->idObjetivo == $obj->idObjetivo ? 'selected' : '' }}>
                                            {{ $obj->claveObjetivo . ' ' . $obj->objetivo }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Debe indicar el objetivo del sector.</div>
                                    </div>

                                    {{-- Estrategia (cargada completa, filtrado en front) --}}
                                    <div class="form-group">
                                    <label for="idEstrategia">Estrategia:<span class="required">*</span></label>
                                    <select name="idEstrategia" id="idEstrategia" class="form-control" required>
                                        <option value="">Seleccione la estrategia del sector...</option>
                                        @foreach ($estrategiasSector as $est)
                                        <option value="{{ $est->idEstrategia }}"
                                                data-objetivo="{{ $est->idObjetivo }}"
                                                {{ optional($sectorAsignado)->idEstrategia == $est->idEstrategia ? 'selected' : '' }}>
                                            {{ $est->claveEstrategia . ' ' . $est->estrategia }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Debe indicar la estrategia del sector.</div>
                                    </div>
                                </div>
                                </div>


                                <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                    aria-labelledby="nav-profile-tab">
                                    <div class="text-right" style="padding:10px">
                                        <button type="button" class="btn btn-warning" title="Quitar seleccionados"
                                            onclick="quitaSeleccionados('objetivoods')">
                                            <i class="fas fa-eraser"></i>
                                        </button>
                                    </div>
                                    <table class="table table-bordered" id="objetivosods">
                                        <thead>
                                            <th style="width:10%">Clave</th>
                                            <th style="width:70%">Descripcion</th>
                                            <th style="width:20%"></th>

                                        </thead>
                                        @foreach ($objetivosods as $objetivoods)
                                            <tr onclick="toggleSelection($(this))" id="{{ $objetivoods->id }}"
                                                class="objetivoods" style="cursor: pointer">
                                                <td style="width:10%">{{ $objetivoods->clave }}</td>
                                                <td style="width:90%">{{ $objetivoods->descripcion }}</td>
                                                <td style="width:90%"><img style="width:100px;"
                                                        src="{{ asset('resources/images/ODS/' . $objetivoods->clave . '.png') }}" />
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                <div class="text-right" style="padding:10px">
                                    <button type="button" class="btn btn-warning" title="Quitar seleccionados"
                                        onclick="quitaSeleccionados('programapresupuestal')">
                                        <i class="fas fa-eraser"></i>
                                    </button>
                                </div>

                                {{-- Selector de año --}}
                                <div class="form-row" style="padding:10px">
                                    <div class="col-md-4 mb-2">
                                        <label for="anio_pp">Año del Programa Presupuestario</label>
                                        <select class="form-control" id="anio_pp">
                                            <option value="">Seleccione el año...</option>
                                            @isset($anios)
                                                @foreach($anios as $anio)
                                                    <option value="{{ $anio }}">{{ $anio }}</option>
                                                @endforeach
                                            @else
                                                @for($y = date('Y'); $y >= date('Y') - 6; $y--)
                                                    <option value="{{ $y }}">{{ $y }}</option>
                                                @endfor
                                            @endisset
                                        </select>

                                    </div>
                                    <div class="col-md-8 d-flex align-items-end">
                                        <small class="text-muted">Seleccione el año para mostrar los programas correspondientes.</small>
                                    </div>
                                </div>

                                <table class="table table-bordered" id="programaspresupuestales">
                                    <thead>
                                        <th style="width:10%">Clave</th>
                                        <th style="width:70%">Programa</th>
                                        <th style="width:20%">Nivel</th>
                                    </thead>
                                    <tbody id="programaspresupuestalesr"></tbody>
                                </table>
                            </div>

                            </div>
                            <div class="float-right">
                                <br />
                                <button class="btn btn-secondary" type="button" onclick="prevVariable()">Atras</button>
                                &nbsp;
                                <!--<button class="btn btn-primary" type="button"
                                                                onclick="almacenaIndicador()">Siguiente</button>-->
                                <button class="btn btn-primary" type="button" onclick="almacenaIndicador()">Actualizar
                                    Indicador</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="modal fade modal-alineaciones" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #919090; color:white">
                    <h5 class="modal-title">Alineaciones del Indicador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-right">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                    </div>
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                role="tab" aria-controls="nav-home" aria-selected="true">Objetivos PED<span
                                    id="objseleccionados"></span></a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                role="tab" aria-controls="nav-profile" aria-selected="false">ODS Agenda 2030<span
                                    id="objodsseleccionados"></span></a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                                role="tab" aria-controls="nav-contact" aria-selected="false">Programas
                                Presupuestarios<span id="programasseleccionados"></span></a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                            aria-labelledby="nav-home-tab">
                            <div class="text-right" style="padding:10px">
                                <button type="button" class="btn btn-warning" title="Quitar seleccionados"
                                    onclick="quitaSeleccionados('objetivo')">
                                    <i class="fas fa-eraser"></i>
                                </button>
                            </div>
                            <hr />
                            <table class="table table-bordered" id="objetivos">
                                <thead>
                                    <th style="width:10%">Clave</th>
                                    <th style="width:90%">Descripcion</th>
                                </thead>
                                @foreach ($objetivos as $objetivo)
                                    <tr onclick="toggleSelection($(this))" id="{{ $objetivo->idObjetivoPED }}"
                                        class="objetivo" style="cursor: pointer">
                                        <td style="width:10%">{{ $objetivo->objetivoPEDClave }}</td>
                                        <td style="width:90%">{{ $objetivo->objetivoPEDDescripcion }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="text-right" style="padding:10px">
                                <button type="button" class="btn btn-warning" title="Quitar seleccionados"
                                    onclick="quitaSeleccionados('objetivoods')">
                                    <i class="fas fa-eraser"></i>
                                </button>
                            </div>
                            <table class="table table-bordered" id="objetivosods">
                                <thead>
                                    <th style="width:10%">Clave</th>
                                    <th style="width:70%">Descripcion</th>
                                    <th style="width:20%"></th>

                                </thead>
                                @foreach ($objetivosods as $objetivoods)
                                    <tr onclick="toggleSelection($(this))" id="{{ $objetivoods->id }}"
                                        class="objetivoods" style="cursor: pointer">
                                        <td style="width:10%">{{ $objetivoods->clave }}</td>
                                        <td style="width:90%">{{ $objetivoods->descripcion }}</td>
                                        <td style="width:90%"><img style="width:100px;"
                                                src="{{ asset('resources/images/ODS/' . $objetivoods->clave . '.png') }}" />
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <div class="text-right" style="padding:10px">
                                <button type="button" class="btn btn-warning" title="Quitar seleccionados"
                                    onclick="quitaSeleccionados('programapresupuestal')">
                                    <i class="fas fa-eraser"></i>
                                </button>
                            </div>
                            <table class="table table-bordered" id="programaspresupuestales">
                                <thead>
                                    <th style="width:10%">Clave</th>
                                    <th style="width:70%">Programa</th>
                                    <th style="width:20%">Nivel</th>
                                </thead>
                                @foreach ($programaspresupuestales as $programapresupuestal)
                                    <tr onclick="toggleSelection($(this))" id="{{ $programapresupuestal->idPrograma }}"
                                        class="programapresupuestal" style="cursor: pointer">
                                        <td style="width:10%">{{ $programapresupuestal->clavePrograma }}</td>
                                        <td style="width:70%">{{ $programapresupuestal->descripcionPrograma }}</td>
                                        <td style="width:20%">
                                            <select class="form-control nivelmir" id="nivel">
                                                <option value="1">Fin</option>
                                                <option value="2">Propósito</option>
                                                <option value="3">Componente</option>
                                                <option value="4">Actividad</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        table tr:hover {
            background-color: rgb(242, 242, 242);
        }

        textarea,
        input,
        select {
            color: black !important;
        }
    </style>
@endsection

@section('scripts')
    <script>
        const seleccionPP = {};
        @foreach ($indicadorProgramas as $ip)
        seleccionPP["{{ $ip->idPrograma }}"] = "{{ $ip->nivel }}";
        @endforeach
        $(document).ready(function() {
            block(true);

            $("#objetivosods").DataTable({
                pageLength: 20,
                lengthMenu: [20],
            });
            $("#indicadorTipo").val('{{ $indicador->indicadorTipo }}');
            $("#indicadorDimension").val('{{ $indicador->indicadorDimension }}');
            $("#indicadorMetodo").val('{{ $indicador->indicadorMetodo }}');
            $("#indicadorFrecuencia").val('{{ $indicador->indicadorFrecuencia }}');
            $("#indicadorTipoPeriodo").val('{{ $indicador->indicadorTipoPeriodo }}');
            $("#indicadorSentido").val('{{ $indicador->indicadorSentido }}');
            $("#indicadorDesagregacion").val('{{ $indicador->indicadorDesagregacion }}');



            con = 0;

            @foreach ($indicadorObjetivos as $indicadorObjetivo_)
                con++;
                if (con == 1) {
                    $("#ejeped").val({{ $indicadorObjetivo_->idEjePED }});
                    getTemas();
                    setTimeout(function() {
                        $("#temaped").val({{ $indicadorObjetivo_->idTemaPED }});
                        getObjetivos();
                    }, 1000);
                }
            @endforeach



            @foreach ($indicadorObjetivosods as $indicadorObjetivoods)
                toggleSelection($("#objetivosods").find("#{{ $indicadorObjetivoods->idODS }}"));
            @endforeach
            loadProgramas();

            block(false);

//            $("#collapseTwo").addClass("show");
            $("#menuAdminIndicadores").addClass("active");

            setTimeout(function() {
                setObjetivos();
            }, 2000);
            setTimeout(function() {
                setProgramas();
            }, 3000);

        });


        function setObjetivos() {
            @foreach ($indicadorObjetivos as $indicadorObjetivo)
                toggleSelection($("#objetivosped").find("#{{ $indicadorObjetivo->idObjetivoPED }}"));
            @endforeach
        }

        function setProgramas() {
            @foreach ($indicadorProgramas as $indicadorPrograma)
                toggleSelection($("#programaspresupuestales").find("#{{ $indicadorPrograma->idPrograma }}"));
                $("#nivel{{ $indicadorPrograma->idPrograma }}").val("{{ $indicadorPrograma->nivel }}");
            @endforeach
        }

        function addVariable() {
            if ($(".variable").length == 3 && $("#idIndicador").val()!="67" && $("#idIndicador").val()!="22" ) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Límite de Variables alcanzado',
                    text: 'actualmente solo es posible asociar 3 variables al Indicador!',
                    confirmButtonColor: '#3085d6',
                })
            } else {
                variable = $.guid++;
                var htmlvariable = '<div class="col-xl-4 col-lg-7 variable" id="variable' + variable + '">' +
                    '<div class="card shadow mb-4">' +
                    '<!-- Card Header - Dropdown -->' +
                    '<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color:#681b2e">' +
                    '<h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Registro de Variable</h6>' +
                    '<div class="dropdown no-arrow">' +
                    '<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"' +
                    'data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                    '<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>' +
                    '</a>' +
                    '<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"' +
                    'aria-labelledby="dropdownMenuLink">' +
                    '<div class="dropdown-header">Acciones:</div>' +
                    '<a class="dropdown-item" href="#" onclick="removeVariable(' + variable +
                    ')"><i class="fas fa-trash" style="color:red"></i> Eliminar Variable</a>' +
                    '<!--<a class="dropdown-item" href="#">Something else here</a>-->' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<!-- Card Body -->' +
                    '<div class="card-body">' +
                    '<h4>Generales</h4>' +
                    '<form>' +
                    '<div class="form-row nueva">' +
                    '<div class="col-md-6 mb-3">' +
                    '<label for="variableNombre">Nombre de la Variable:<span style="color: red">*</span></label>' +
                    '<textarea type="text" class="form-control variableNombre" id="variableNombre" name="variableNombre"' +
                    'placeholder="Poblacion total..." value="" required>Poblacion' + variable + '</textarea>' +
                    '<div class="invalid-feedback">' +
                    'Indique un Nombre para la Variable!' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-6 mb-3">' +
                    '<label for="variableUM">Unidad de Medida:<span style="color: red">*</span></label>' +
                    '<input type="text" class="form-control variableUM" id="variableUM" placeholder="Unidad de Medida" value="unidad' +
                    variable + '" required/>' +
                    '<div class="invalid-feedback">' +
                    'Indique una Unidad de Medida para la Variable!' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</form>' +
                    '</div>' +
                    '</div>' +
                    '</div>'
                $("#variables").append(htmlvariable);
            }
        }

        function removeVariable(variable) {
            Swal.fire({
                title: '¿Está Seguro?',
                text: "No será posible recuperarla una vez eliminada!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarla!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#variable" + variable).hide('slow', function() {
                        $("#variable" + variable).remove()
                    });
                    if ($("#variable" + variable).find("#idVariable").length > 0) {
                        vareli = $("#variablesEliminadas").val() + $("#variable" + variable).find("#idVariable")
                            .val() + "|";
                        $("#variablesEliminadas").val(vareli);
                    }

                    /*Swal.fire({
                        icon: 'success',
                        title: 'Variable Eliminada!',
                        text: '',
                        confirmButtonColor: '#3085d6',
                    }).then((result)=>{
                        $("#variable" + variable).hide('slow',function(){$("#variable" + variable).remove()});
                    })*/

                }
            })
        }

        function toggleSelection(elemento) {
            if (elemento.hasClass("seleccionado")) {
                elemento.removeClass("seleccionado")
                elemento.css('background-color', '#fff');
                elemento.css('color', '#858796');
            } else {
                elemento.addClass("seleccionado");
                elemento.css('background-color', '#7e686d');
                elemento.css('color', 'white');
            }

            //if (elemento.hasClass("objetivo"))
              //  loadProgramas();
            updateContadores();
            // ---- BLOQUE NUEVO SÓLO PARA PROGRAMAS PRESUPUESTARIOS ----
            if (elemento.closest('#programaspresupuestales').length) {
            const id = elemento.attr('id');

            if (elemento.hasClass('seleccionado')) {
                const nivel = $("#nivel" + id).val() || "1";
                seleccionPP[id] = nivel;           // Guardamos por idPrograma
            } else {
                delete seleccionPP[id];            // Quitamos del estado global
            }
            }
  
        }

        function updateContadores() {
            seleccionados = $("#objetivos .seleccionado").length;
            if (seleccionados > 0)
                $("#objseleccionados").html(" (" + seleccionados + ")");
            else
                $("#objseleccionados").html("");

            seleccionadosods = $("#objetivosods .seleccionado").length;
            if (seleccionadosods > 0)
                $("#objodsseleccionados").html(" (" + seleccionadosods + ")");
            else
                $("#objodsseleccionados").html("");


            seleccionadosprogramas = $("#programaspresupuestales .seleccionado").length;
            if (seleccionadosprogramas > 0)
                $("#programasseleccionados").html(" (" + seleccionadosprogramas + ")");
            else
                $("#programasseleccionados").html("");
        }

        function quitaSeleccionados(tipo) {
            $('.' + tipo).removeClass("seleccionado");
            $('.' + tipo).css('background-color', '#fff');
            $('.' + tipo).css('color', '#858796');
            updateContadores();
        }

        function almacenaIndicador() {
            if (validaFormularios()) {

                var actualiza = "";
                //Construimos la cadena para las variables actualizadas
                $(".actualiza").each(function() {
                    idVariable = $(this).find("#idVariable").val();
                    variableNombre = $(this).find("#variableNombre").val();
                    variableUM = $(this).find("#variableUM").val();
                    actualiza += idVariable + "|" + variableNombre + "|" + variableUM + ";";
                })

                var borra = $("#variablesEliminadas").val();

                //Construimos las cadenas para las variables nuevas
                var nueva = "";
                $(".nueva").each(function() {
                    variableNombre = $(this).find("#variableNombre").val();
                    variableUM = $(this).find("#variableUM").val();
                    nueva += variableNombre + "|" + variableUM + ";";
                })

                var data = $("#formIndicador").serialize() + "&actualiza=" + actualiza +
                    "&borra=" + borra + "&nueva=" + nueva;
                data += "&idSector="     + encodeURIComponent($("#idSector").val() || '');
                data += "&idObjetivo="   + encodeURIComponent($("#idObjetivo").val() || '');
                data += "&idEstrategia=" + encodeURIComponent($("#idEstrategia").val() || '');


                //Obtenemos las alineaciones seleccionadas
                var objetivosped = "";
                var objetivosods = "";
                var programaspresupuestales = "";
                var niveles = "";

                // PED
                $("#objetivos .seleccionado").each(function() {
                objetivosped += $(this).attr("id") + "|";
                });

                // ODS
                $("#objetivosods .seleccionado").each(function() {
                objetivosods += $(this).attr("id") + "|";
                });

                // PROGRAMAS PP (desde el estado global, NO desde el DOM visible)
                for (const [id, nivel] of Object.entries(seleccionPP)) {
                programaspresupuestales += id + "|";
                niveles += (nivel || "1") + "|";
                }

                data += "&objetivos=" + objetivosped
                    +  "&objetivosods=" + objetivosods
                    +  "&programaspresupuestales=" + programaspresupuestales
                    +  "&niveles=" + niveles;



                saveIndicador(data);


            }
        }

        function nextVariables() {
            if (validaIndicador()) {
                $("#indicadorContent").hide('slow');
                $('#variablesContent').show('slow');
            }
        }

        function prevIndicador() {
            $('#variablesContent').hide('slow');
            $("#indicadorContent").show('slow');
        }

        function nextAlineaciones() {
            if (validaVariables()) {
                $("#variablesContent").hide('slow');
                $('#alineacionContent').show('slow');
            }
        }

        function prevVariable() {
            $('#alineacionContent').hide('slow');
            $("#variablesContent").show('slow');
        }

        function validaIndicador() {
            inputs = [
                "indicadorNombre",
                "indicadorObjetivo",
                "indicadorInterpretacion",
                "indicadorLB",
                "indicadorUM",
                "indicadorFormula",
                "valorAnioLB",
                "fuente_informacion",
                "proxima_actualizacion"
            ];
            selects = [
                "indicadorTipo",
                "indicadorDimension",
                "indicadorMetodo",
                "indicadorFrecuencia",
                "indicadorSentido",
                "indicadorTipoPeriodo",
                "indicadorDesagregacion"
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
                if ($("#" + selects[x]).val() == 0) {
                    $("#" + selects[x]).addClass("is-invalid");
                    valid = false;
                } else {
                    $("#" + selects[x]).removeClass("is-invalid");
                }
            }
            return valid;
        }

        function validaVariables() {
            valid = true;
            indicador = $("#idIndicador").val();
            if ($(".variable").length < 2 && indicador!=5 && indicador!=9 && indicador!=10 && indicador!=11 && indicador!=20 && indicador!=21 && indicador!=35 && indicador!=36 && indicador!=75 && indicador!=76 && indicador!=77 && indicador!=78 && indicador!=79 && indicador!=82 && indicador!=93 && indicador!=112 && indicador!=113 && indicador!=165) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Cantidad insufiente de variables registradas',
                    text: 'Es necesario indicar mínimo 2 variables!',
                    confirmButtonColor: '#3085d6',
                })
                valid = false;
            } else {
                varsvals = [
                    ".variableNombre",
                    ".variableUM"
                ];

                for (var z = 0; z < varsvals.length; z++) {
                    $(varsvals[z]).each(function() {
                        if ($(this).val().trim().length == 0) {
                            $(this).addClass('is-invalid');
                            valid = false;
                        } else {
                            $(this).removeClass('is-invalid');
                        }
                    });
                }
            }
            return valid;
        }

        function validaFormularios() {
            valid = validaIndicador();
            indicador = $("#idIndicador").val();
            if (valid) {
                if ($(".variable").length < 2  && indicador!=5 && indicador!=9 && indicador!=10 && indicador!=11 && indicador!=20 && indicador!=21 && indicador!=35 && indicador!=36 && indicador!=75 && indicador!=76 && indicador!=77 && indicador!=78 && indicador!=79 && indicador!=82 && indicador!=93 && indicador!=112 && indicador!=113) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Cantidad insufiente de variables registradas',
                        text: 'Es necesario indicar mínimo 2 variables!',
                        confirmButtonColor: '#3085d6',
                    })
                    valid = false;
                } else {
                    varsvals = [
                        ".variableNombre",
                        ".variableUM"
                    ];

                    for (var z = 0; z < varsvals.length; z++) {
                        $(varsvals[z]).each(function() {
                            if ($(this).val().trim().length == 0) {
                                $(this).addClass('is-invalid');
                                valid = false;
                            } else {
                                $(this).removeClass('is-invalid');
                            }
                        });
                    }
                    objetivos = $("#objetivos .seleccionado").length;
                    objetivosods = $("#objetivosods .seleccionado").length;
                   // programaspresupuestales = $("#programaspresupuestales .seleccionado").length;

                    if (objetivos == 0 || objetivosods == 0 ){//|| programaspresupuestales == 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Alineación Con los Instrumentos de planeación',
                            text: 'Por favor complete la alineación con los Instrumentos de Planeación!',
                            confirmButtonColor: '#3085d6',
                        })
                        valid = false;
                    }
                }
            }

            return valid;

        }

        function setValues() {
            $("#indicadorNombre").val(
                'Porcentaje de cobertura alcanzada de equipamiento a secundarias de los pueblos indígenas')
            $("#indicadorObjetivo").val("Medir la Cobertura de equipamiento en secundarias indigenas");
            $("#indicadorInterpretacion").val(
                "Refiere al porcentaje alcanzado de cobertura con respecto a las secundarias indigenas en el estado");
            $("#indicadorLB").val("2015");
            $("#indicadorUM").val("Porcentaje");
            $("#indicadorTipo").val("impacto");
            $("#indicadorDimension").val("eficacia");
            $("#indicadorMetodo").val("porcentaje");
            $("#indicadorFormula").val("Población atendida/Población Progrmada");
            $("#indicadorFrecuencia").val("anual");
            $("#indicadorSentido").val("ascendente");
            $("#indicadorTipoPeriodo").val("escolar");
            $("#indicadorDesagregacion").val("estatal");

        }

        function saveIndicador(data) {
            $.ajax({
                type: 'POST',
                url: $("#formIndicador").attr('action'),
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    block(true);
                }
            }).done(function(response) {
                block(false);
                if (response.success == "ok") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Indicador Actualizado Satisfactoriamente',
                        text: response.message + " Indicador: " + response.indicador,
                        confirmButtonColor: '#3085d6',
                    }).then((result) => {
                        window.location.replace("{{ route('admin.indicadores') }}");
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Ocurrió un error al intentar guardar el indicador',
                        text: '',
                        confirmButtonColor: '#3085d6',
                    })
                }
            }).fail(function(data) {
                block(false);
            })

        }

        function getTemas() {
            if ($("#ejeped").val() != 0) {
                $("#objetivosped").html("");
                $("#objetivos").hide("slow");
                quitaSeleccionados('objetivo');
                $.ajax({
                    type: 'GET',
                    url: "{{ route('gettemas') }}",
                    data: {
                        idEjePED: $("#ejeped").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        // block(true);
                    }
                }).done(function(response) {
                    //block(false);
                    options = "<option value='0'>Seleccione...</option>";
                    if (response.success = "ok") {
                        for (x = 0; x < response.temas.length; x++) {
                            options += "<option value='" + response.temas[x].idTemaPED + "'>" + response.temas[x]
                                .temaPEDClave + " " + response.temas[x].temaPEDDescripcion + "</option>";
                        }
                        $("#temaped").html(options);
                    }
                    $("#temaContent").show("slow");
                });
            } else {
                $("#temaContent").hide("slow");
            }

        }

        function getObjetivos() {
            if ($("#temaped").val() != 0) {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('getobjetivos') }}",
                    data: {
                        idTemaPED: $("#temaped").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        //block(true);
                    }
                }).done(function(response) {
                    // block(false);
                    if (response.success = "ok") {
                        rows = "";
                        for (x = 0; x < response.objetivos.length; x++) {
                            rows +=
                                '<tr onclick="toggleSelection($(this))" id="' + response.objetivos[x]
                                .idObjetivoPED + '"' +
                                'class="objetivo" style="cursor: pointer">' +
                                '<td style="width:10%">' + response.objetivos[x].objetivoPEDClave + '</td>' +
                                '<td style="width:90%">' + response.objetivos[x].objetivoPEDDescripcion + '</td>' +
                                '</tr>';
                        }
                        $("#objetivosped").html(rows);
                    }
                    $("#objetivos").show("slow");
                });
            } else {
                $("#objetivos").hide("slow");
            }

        }
        
        function loadProgramas() {
            const anio = $('#anio_pp').val();

            // Si no hay año seleccionado: ocultar tabla y limpiar cuerpo
            if (!anio) {
                $('#programaspresupuestales').hide();
                $('#programaspresupuestalesr').empty();
                return $.Deferred().resolve().promise(); 
            }

            // Si hay año: asegurar que la tabla se muestre
            $('#programaspresupuestales').show();

            // --- NO BORRAMOS LA SELECCIÓN GLOBAL ---
            return $.ajax({
                type: 'GET',
                url: "{{ route('getprogramas') }}",
                data: { anio: anio },
                dataType: 'json'
            })
            .done(function (response) {
                if (response.success === "ok") {
                let rows = "";
                for (let p of response.programas) {
                    rows +=
                    '<tr id="' + p.idPrograma + '" class="programapresupuestal" style="cursor:pointer" onclick="toggleSelection($(this))">' +
                        '<td style="width:10%">' + (p.clavePrograma ?? '') + '</td>' +
                        '<td style="width:70%">' + (p.descripcionPrograma ?? '') + '</td>' +
                        '<td style="width:20%">' +
                        '<select class="form-control nivelmir" id="nivel' + p.idPrograma + '">' +
                            '<option value="1">Fin</option>' +
                            '<option value="2">Propósito</option>' +
                            '<option value="3">Componente</option>' +
                            '<option value="4">Actividad</option>' +
                        '</select>' +
                        '</td>' +
                    '</tr>';
                }

                $("#programaspresupuestalesr").html(
                    rows || "<tr><td colspan='3'><h6>No hay programas para el año seleccionado.</h6></td></tr>"
                );

                for (const [id, nivel] of Object.entries(seleccionPP)) {
                    const $tr = $("#programaspresupuestales tr#" + id);
                    if ($tr.length) {
                    $tr.addClass('seleccionado').css({ 'background-color': '#7e686d', 'color': 'white' });
                    $("#nivel" + id).val(nivel);
                    }
                }

                // setProgramas();

                $("#programaspresupuestales .seleccionado").each(function () {
                    const rowId = $(this).attr('id');
                    const nivel = $("#nivel" + rowId).val() || "1";
                    if (!seleccionPP[rowId]) {
                    seleccionPP[rowId] = nivel;
                    }
                });

                updateContadores();
                } else {
                $("#programaspresupuestalesr").html("<tr><td colspan='3'><h6>No se pudo cargar la lista.</h6></td></tr>");
                }
            })
            .fail(function () {
                $("#programaspresupuestalesr").html("<tr><td colspan='3'><h6>Error al cargar los programas.</h6></td></tr>");
            });
        }



        $('#anio_pp').on('change', function () {
            Swal.fire({
                title: 'Cargando programas...',
                text: 'Por favor espera',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            loadProgramas().always(function () {
                if (Swal.isVisible()) Swal.close();
            });
        });

        $(document).ready(function () {
            loadProgramas();
        });

        $(document).on('change', '.nivelmir', function () {
            const tr = $(this).closest('tr');
            if (!tr.length || !tr.hasClass('programapresupuestal')) return;

            const id = tr.attr('id');
            if (tr.hasClass('seleccionado')) {
                seleccionPP[id] = $(this).val();
            }
        });


            function filtrarObjetivosPorSector() {
                const sectorId = $('#idSector').val();
                $('#idObjetivo option').each(function(){
                if ($(this).val() === '') return; // placeholder
                const s = String($(this).data('sector') || '');
                $(this).toggle( String(sectorId || '') === s );
                });
                // si el seleccionado no aplica, reset
                if (!$('#idObjetivo option:selected').is(':visible')) {
                $('#idObjetivo').val('');
                }
                filtrarEstrategiasPorObjetivo();
            }
            function filtrarEstrategiasPorObjetivo() {
                const objetivoId = $('#idObjetivo').val();
                $('#idEstrategia option').each(function(){
                if ($(this).val() === '') return; // placeholder
                const o = String($(this).data('objetivo') || '');
                $(this).toggle( String(objetivoId || '') === o );
                });
                if (!$('#idEstrategia option:selected').is(':visible')) {
                $('#idEstrategia').val('');
                }
            }
            //Eventos
            $('#idSector').on('change', filtrarObjetivosPorSector);
            $('#idObjetivo').on('change', filtrarEstrategiasPorObjetivo);

              $(document).ready(function(){
                filtrarObjetivosPorSector();
                filtrarEstrategiasPorObjetivo();
            });
                const SAVED_SECTOR     = "{{ optional($sectorAsignado)->idSector ?? '' }}";
                const SAVED_OBJETIVO   = "{{ optional($sectorAsignado)->idObjetivo ?? '' }}";
                const SAVED_ESTRATEGIA = "{{ optional($sectorAsignado)->idEstrategia ?? '' }}";

                $(function () {
                    if (SAVED_SECTOR) $('#idSector').val(SAVED_SECTOR);
                    filtrarObjetivosPorSector();

                    if (SAVED_OBJETIVO) $('#idObjetivo').val(SAVED_OBJETIVO);
                    filtrarEstrategiasPorObjetivo();

                    if (SAVED_ESTRATEGIA) $('#idEstrategia').val(SAVED_ESTRATEGIA);
                });
    </script>
@endsection
