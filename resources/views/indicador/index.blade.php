@extends('layouts.administrador')

@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">Indicador / registrar</h1>
@endsection

@section('content')
    <div class="row" style="">

        <div class="col-xl-12 col-lg-7" id="indicadorContent">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                    style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-light">Registro del Indicador</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Acciones:</div>
                            <a class="dropdown-item" href="{{ route('indicador.list') }}"><i class="fas fa-list"
                                    style="color:green"></i>
                                Listado de Indicadores</a>
                            <!--  <a class="dropdown-item" href="#">Another action</a>
                                                                                    <div class="dropdown-divider"></div>-->
                            <!--<a class="dropdown-item" onclick="setValues()" style="cursor: pointer"><i class="fas fa-fill"
                                    style="color:green;"></i> Rellenar Auto</a>-->
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <h4>Generales</h4>
                    <form id="formIndicador" action="{{ route('indicador.storage') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="indicadorNombre">Nombre del Indicador:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="indicadorNombre" name="indicadorNombre"
                                    placeholder="Porcentaje de ......" value="" required>
                                <div class="invalid-feedback">
                                    Debe Indicar el nombre del Indicador!
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="indicadorObjetivo">Definición:<span style="color: red">*</span></label>
                                <textarea class="form-control" id="indicadorObjetivo" name="indicadorObjetivo" placeholder="Finalidad del Indicador"
                                    required></textarea>
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
                                    <option value="gestion" >Gestión</option>
                                    <option value="estrategico">Estratégico</option>
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione un tipo
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="indicadorDimension">Dimension:<span style="color: red">*</span></label>
                                <select class="form-control" id="indicadorDimension" name="indicadorDimension">
                                    <option value="0">Seleccione...</option>
                                    <option value="calidad">Calidad</option>
                                    <option value="economia">Economía</option>
                                    <option value="eficacia">Eficacia</option>
                                    <option value="eficiencia">Eficiencia</option>
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione una Dimensión
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
                                    Seleccione Método
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="indicadorUM">Unidad de Medida:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="indicadorUM" name="indicadorUM"
                                    placeholder="Unidad" required />
                                <div class="invalid-feedback">
                                    Debe indicar una unidad de Medida!
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <label for="indicadorFormula">Fórmula de Cálculo:<span style="color: red">*</span></label>
                                <textarea class="form-control" id="indicadorFormula" name="indicadorFormula" placeholder="Fórmula" required></textarea>
                                <div class="invalid-feedback">
                                    Debe indicar la Fórmula de Cálculo!
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="indicadorInterpretacion">Interpretación del Indicador:<span
                                        style="color: red">*</span></label>
                                <textarea class="form-control" id="indicadorInterpretacion" name="indicadorInterpretacion"
                                    placeholder="Interpretacion" required></textarea>
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
                                    Seleccione Frecuencia
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
                           <!-- <div class="col-md-3 mb-3">
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
                                <label for="indicadorDesagregacion">Desagregación:<span
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
                                <input type="number" class="form-control" id="indicadorLB" name="indicadorLB"
                                    placeholder="Anio Linea Base" required />
                                <div class="invalid-feedback">
                                    Indique un Año para la línea base
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="valorAnioLB">Valor de la Línea Base:<span style="color: red">*</span></label>
                                <input type="number" class="form-control" id="valorAnioLB" name="valorAnioLB"
                                    placeholder="Valor de la Línea Base" required />
                                <div class="invalid-feedback">
                                    Indique el Valor de la Línea Base
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="fuente_informacion">Fuente de Información:<span style="color: red">*</span></label>
                                <textarea type="text" class="form-control" id="fuente_informacion" name="fuente_informacion"
                                    placeholder="Fuente de información del indicador" required ></textarea>
                                <div class="invalid-feedback">
                                    Indique la Fuente de Información del indicador
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="proxima_actualizacion">Fecha de Próxima Actualización:<span
                                        style="color: red">*</span></label>
                                <input type="text" class="form-control" id="proxima_actualizacion"
                                    name="proxima_actualizacion" placeholder="Fecha de la próxima actualización"
                                    required />
                                <div class="invalid-feedback">
                                    Indique la Fecha de Próxima actualización
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="indicadorObservaciones">Observaciones</label>
                                <textarea class="form-control" id="indicadorObservaciones" name="indicadorObservaciones" placeholder="Observaciones"
                                    required></textarea>
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
                        <div class="float-right">
                            <a href="{{ route('indicador.list') }}"><button class="btn btn-secondary" type="button"
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
                    <div class="row" id="variableContent">

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
                            para quitarlo dé clic nuevamente sobre él. A continuación de clic en el botón "Almacenar
                            Indicador"
                    </div>

                    <div class="row" id="alineacionesContent" style="padding-left:15%;padding-right:15%;">
                        <div class="col-xl-12 col-lg-7">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab"
                                        href="#nav-objetivosped" role="tab" aria-controls="nav-home"
                                        aria-selected="true">Objetivos PED<span id="objseleccionados"></span></a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab"
                                        href="#nav-objetivosods" role="tab" aria-controls="nav-profile"
                                        aria-selected="false">ODS Agenda 2030<span id="objodsseleccionados"></span></a>
                                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab"
                                        href="#nav-programas" role="tab" aria-controls="nav-contact"
                                        aria-selected="false">Programas
                                        Presupuestarios<span id="programasseleccionados"></span></a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">

                                <div class="tab-pane fade show active" id="nav-objetivosped" role="tabpanel"
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
                                                Debe Indicar el nombre del Indicador!
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3" id="temaContent" style="display: none">
                                            <label for="temaped">Seleccione un Tema:<span
                                                    style="color: red">*</span></label>
                                            <select class="form-control" id="temaped" name="temaped"
                                                onchange="getObjetivos()">
                                            </select>
                                            <div class="invalid-feedback">
                                                Debe Indicar el nombre del Indicador!
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="text-right" style="padding:10px">
                                            <button type="button" class="btn btn-warning" title="Quitar seleccionados"
                                                onclick="quitaSeleccionados('objetivo')">
                                                <i class="fas fa-eraser"></i>
                                            </button>
                                        </div>-->
                                    <hr />
                                    <table class="table table-bordered" id="objetivos" style="display:none">
                                        <thead>
                                            <tr>
                                                <td colspan="2">
                                                    <b>Instrucciones: </b> Dé clic sobre el Objetivo al cual se alinea el
                                                    indicador.
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width:10%">Clave</th>
                                                <th style="width:90%">Descripcion</th>
                                            </tr>
                                        </thead>
                                        <tbody id="objetivosped">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="nav-objetivosods" role="tabpanel"
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
                                <div class="tab-pane fade" id="nav-programas" role="tabpanel"
                                    aria-labelledby="nav-contact-tab">
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
                                        <tbody id="programaspresupuestalesr">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="float-right">
                                <br />
                                <button class="btn btn-secondary" type="button" onclick="prevVariable()">Atras</button>
                                &nbsp;
                                <!--<button class="btn btn-primary" type="button"
                                                        onclick="almacenaIndicador()">Siguiente</button>-->
                                <button class="btn btn-primary" type="button" onclick="almacenaIndicador()">Almacenar
                                    Indicador</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="variables" style="color: black;">
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
        $(document).ready(function() {
            $("#objetivosods").DataTable({
                pageLength: 30,
                lengthMenu: [],
            });

            $("#collapseTwo").addClass("show");
            $("#menuIndicadores").addClass("active");
            $("#optindicador").css('background-color', "rgb(217, 217, 217)");
            loadProgramas();
            //setValues();
        });

        var variable = 0;

        function addVariable() {
            if ($(".variable").length == 3) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Limite de Variables alcanzado',
                    text: 'actualmente solo es posible asociar 3 variables al Indicador!',
                    confirmButtonColor: '#3085d6',
                })
            } else {
                variable++;
                var htmlvariable = '<div class="col-xl-4 col-lg-7 variable" id="variable' + variable + '">' +
                    '<div class="card shadow mb-4">' +
                    '<!-- Card Header - Dropdown -->' +
                    '<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color:#681b2e">' +
                    '<h6 class="m-0 font-weight-bold text-primary" style="color:white !important;">Registro de Variable</h6>' +
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
                    '<div class="form-row">' +
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
                //$("#variables").append(htmlvariable);
                $("#variableContent").append(htmlvariable).animate("slow");

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
                    /* Swal.fire({
                         icon: 'success',
                         title: 'Variable Eliminada!',
                         text: '',
                         confirmButtonColor: '#3085d6',
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
            //if(elemento.hasClass("objetivo"))
              //  loadProgramas();
            updateContadores();
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

                //Obtenemos los datos de las variables asociadas.
                variablesNombres = "";
                variablesUnidades = "";

                $(".variableNombre").each(function() {
                    variablesNombres += $(this).val() + "|";
                })
                $(".variableUM").each(function() {
                    variablesUnidades += $(this).val() + "|";
                })

                var data = $("#formIndicador").serialize() + "&variablesNombres=" + variablesNombres +
                    "&variablesUnidades=" + variablesUnidades;

                //Obtenemos las alineaciones seleccionadas
                var objetivosped = "";
                var objetivosods = "";
                var programaspresupuestales = "";
                var niveles = "";

                $("#objetivos .seleccionado").each(function() {
                    objetivosped += $(this).attr("id") + "|";
                });
                $("#objetivosods .seleccionado").each(function() {
                    objetivosods += $(this).attr("id") + "|";
                });
                $("#programaspresupuestales .seleccionado").each(function() {
                    programaspresupuestales += $(this).attr("id") + "|";
                    niveles += $("#nivel"+$(this).attr("id")).val() + "|";
                });

                data += "&objetivos=" + objetivosped + "&objetivosods=" + objetivosods + "&programaspresupuestales=" +
                    programaspresupuestales+ "&niveles=" +niveles;


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

        function prevVariable() {
            $('#alineacionContent').hide('slow');
            $("#variablesContent").show('slow');
        }

        function nextAlineaciones() {
            if (validaVariables()) {
                $("#variablesContent").hide('slow');
                $('#alineacionContent').show('slow');
            }
        }


        function validaFormularios() {
            valid = validaIndicador();
            if (valid) {
                if ($(".variable").length < 2) {
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
                    //programaspresupuestales = $("#programaspresupuestales .seleccionado").length;

                    if (objetivos == 0 || objetivosods == 0 ){//|| programaspresupuestales == 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Alineación con los Instrumentos de planeación',
                            text: 'Por favor complete la alineación con los Instrumentos de Planeación!',
                            confirmButtonColor: '#3085d6',
                        })
                        valid = false;
                    }

                }
            }
            return valid;

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
                "proxima_actualizacion",
                "fuente_informacion"

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
            if ($(".variable").length < 2) {
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
            $("#valorAnioLB").val("12.3");

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
                        title: 'Indicador Almacenado Satisfactoriamente',
                        text: response.message + " Indicador: " + response.indicador,
                        confirmButtonColor: '#3085d6',
                    }).then((result) => {
                        window.location.replace("{{ route('indicador.list') }}");
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

        function block(val) {
            if (val) {
                $.blockUI({
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: .5,
                        color: '#fff'
                    },
                    message: "<h4>Procesando...</h4>"
                });
            } else {
                $.unblockUI();
            }

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
                        block(true);
                    }
                }).done(function(response) {
                    block(false);
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
                        block(true);
                    }
                }).done(function(response) {
                    block(false);
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
           /* if ($("#objetivos .seleccionado").length > 0) {
                objetivos = "";
                $("#objetivos .seleccionado").each(function(){
                    objetivos += $(this).attr("id")+"|";
                });*/
                $.ajax({
                    type: 'GET',
                    url: "{{ route('getprogramas') }}",
                    data: {
                        //objetivos: objetivos
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        block(true);
                    }
                }).done(function(response) {
                    block(false);
                    if (response.success = "ok") {
                        rows = "";
                        for (x = 0; x < response.programas.length; x++) {
                            rows +=
                            '<tr onclick="toggleSelection($(this))"'+
                                                'id="'+response.programas[x].idPrograma+'" class="programapresupuestal"'+
                                                'style="cursor: pointer">'+
                                                '<td style="width:10%">'+response.programas[x].clavePrograma+'</td>'+
                                                '<td style="width:70%">'+response.programas[x].descripcionPrograma+
                                                '</td>'+
                                                '<td style="width:20%">'+
                                                    '<select class="form-control nivelmir" id="nivel'+response.programas[x].idPrograma+'"> <option value="1">Fin</option><option value="2">Propósito</option><option value="3">Componente</option><option value="4">Actividad</option></select>'+
                                                '</td>'+
                            '</tr>';
                        }
                        if(rows!="")
                            $("#programaspresupuestalesr").html(rows);
                        else{
                            row = "<tr><td colspan='2'><h6>No existen programas presupuestarios asociados a los Objetivos del PED seleccionados!</h6></td></tr>";
                            $("#programaspresupuestalesr").html(row);
                        }

                    }
                });
         /*   }else{
                            row = "<tr><td colspan='2'><center><h3>No ha seleccionado Objetivos del PED!</h3></center></td></tr>";
                            $("#programaspresupuestalesr").html(row);
                        }*/
        }
    </script>
@endsection
