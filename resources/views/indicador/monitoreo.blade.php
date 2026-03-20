@extends('layouts.administrador')

@section('styles')
    <link href="{{ asset('resources/css/dropzone.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">Indicador / Monitoreo</h1>
@endsection

@section('content')
    @if (count($indicadores) > 0)
        <hr />
        <div id="indicadorTitle" style="display:none">
            <input type="hidden" id="idIndicador" />
            <h2 class="text-center"><span id="indicadorSelected" style="color:#919090""></span> </h2>
            <center>
                <button class="btn btn-secondary" onclick="backToSelector()"><i class="fas fa-arrow-left"></i> Regresar</button>
            </center>
            <hr />
            <div id="bloqueado" style="display:none">
                <center>
                    <div style="background-color: #dddddd;width:30%;border-radius:13px; padding:20px;">
                        <h4> <i class="fas fa-info-circle"></i> El monitoreo de metas para este Indicador está bloqueada!</h4>
                    </div>
                </center>
            </div>
            <div id="enrevision" style="display:none">
                <center>
                    <div style="background-color: #dddddd;width:30%;border-radius:13px; padding:20px;">
                        <h4> <i class="fas fa-info-circle"></i> Este indicador se encuentra en Estatus de Revisión!</h4>
                    </div>
                </center>
            </div>
            <div class="row" id="rowtags" style="display: none" >
                <div class="col-xl-12 col-lg-7">
                    <nav >
                        <div class="nav nav-tabs nav-fill justify-content-center" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab"
                                href="#nav-programacion" role="tab" aria-controls="nav-profile"
                                aria-selected="false">Monitoreo de Metas<span id="objodsseleccionados"></span></a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab"
                                href="#nav-variables" role="tab" aria-controls="nav-contact"
                                aria-selected="false">Monitoreo de Metas para las Variables<span id="programasseleccionados"></span></a>
                        </div>
                    </nav>
                    <hr/>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-programacion" role="tabpanel"
                            aria-labelledby="nav-profile-tab">
                            <div class="row" id="programacionContent" style="display:none">
                                <div class="instrucciones" style="color:black;padding:30px;">
                                    <b>Instrucciones: </b> Para agregar valores de las metas alcanzadas, dé clic sobre el boton   <button class="btn btn-sm btn-success" title="Editar Valor"><i class="fas fa-arrow-up"></i></button> del periodo correspondiente.
                                </div>
                                <div class="col-xl-12 col-lg-7">
                                    <div class="card shadow mb-4">
                                        <!-- Card Header - Dropdown -->
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #681b2e;">
                                            <h6 class="m-0 font-weight-bold text-light">Monitoreo de Metas: </h6>

                                        </div>
                                        <!-- Card Body -->
                                        <div class="card-body">
                                            <div id="emptyprogramados" style="display:none">
                                                <center>
                                                    <h4>No existen valores programados registrados!</h4>
                                                </center>
                                            </div>
                                            <table class="table table-striped table-bordered" id="tableProgramados" style="display:none">
                                                <thead>
                                                    <tr style="background-color:#919090;color:white;">
                                                        <th style="width: 10%">Periodo de Medicion</th>
                                                        <th style="width: 10%">Fin del Periodo(ciclo)</th>
                                                        <th style="width: 10%">Valor Programado</th>
                                                        <th style="width: 10%">Estatus del valor Programado</th>
                                                        <th style="width: 10%">Valor Real</th>
                                                        <th style="width: 10%">Estatus del valor Real</th>
                                                        <th style="width: 30%">Observaciones</th>
                                                        <th style="width: 10%"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="rowsprogramados">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-variables" role="tabpanel"
                            aria-labelledby="nav-contact-tab">
                            <div class="row" id="variablesContent" style="display:none">
                                <div class="instrucciones" style="color:black;padding:20px;">
                                    <b>Instrucciones: </b> Para agregar valores de las metas alcanzadas por variable, dé clic en el botón:  <button class="btn btn-success"><i class="fas fa-chart-line"></i> Monitoreo de Metas</button> de la variable correspondiente.
                                </div>
                                <div class="col-xl-12 col-lg-7">
                                    <div class="card shadow mb-4">
                                        <!-- Card Header - Dropdown -->
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #681b2e;">
                                            <h6 class="m-0 font-weight-bold text-light">Variables </h6>
                                        </div>
                                        <!-- Card Body -->
                                        <div class="card-body">
                                            <div class="row" id="variables">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="indicadorSeleccion">
            <div class="col-xl-12 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #681b2e;">
                        <h6 class="m-0 font-weight-bold text-light">Seleccione Indicador </h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="col-md-12 mb-3">
                            <label for="indicadorTipo">Indicador:<span style="color: red">*</span></label>
                            <select class="form-control" id="indicador" name="indicador" onchange="setDataIndicador()">
                                <option value="0">Seleccione...</option>
                                @foreach ($indicadores as $indicador)
                                @if($indicador->en_revision!=2)
                                    <option value="{{ $indicador->idIndicador }}">{{ "[".$indicador->idIndicador."] ".$indicador->indicadorNombre }}</option>
                                @endif
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Seleccione un indicador
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            table tr:hover {
                background-color: rgb(242, 242, 242);
            }

            table tr td {
                padding: 5px;
            }

            .swal2-container {
                z-index: 1800;
            }

            .modal{
                overflow: scroll;
            }
        </style>
        <div class="modal fade modal-valorprogramado" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #681b2e; color:white">
                        <h5 class="modal-title">Resultados del Indicador</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding:25px;">

                        <div class="row">
                            <div class="col-xl-6" style="background-color:rgb(240, 240, 240)">
                                <h4>Datos de la Meta</h4>
                                <form id="formValorMeta" action="{{ route('indicador.metas.setvalor') }}">
                                    <div class="row">
                                        <input type="hidden" name="idValoresIndicadorProgramado"
                                            id="idValoresIndicadorProgramado" />
                                        @csrf
                                        <table style="width:100%">
                                            <tr>
                                                <td style="width:30%">
                                                    <label for="valoresAnioMedicionProgramado">Ciclo de Medicion:<span
                                                            style="color: red">*</span></label>
                                                </td>
                                                <td style="width:35%">
                                                    <select class="form-control" id="valoresAnioMedicionProgramado"
                                                        name="valoresAnioMedicionProgramado" disabled>
                                                        <option value="0">Seleccione...</option>
                                                        @for ($x = 2022; $x <= 2028; $x++)
                                                            <option value="{{ $x }}">{{ $x }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Seleccione ciclo de Medición!
                                                    </div>
                                                </td>
                                                <td style="width:35%">
                                                    <select class="form-control" id="valoresCicloMedicionProgramado"
                                                        name="valoresCicloMedicionProgramado" disabled>
                                                        <option value="0">Seleccione...</option>
                                                        @for ($x = 2022; $x <= 2028; $x++)
                                                            <option value="{{ $x }}">{{ $x }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Seleccione ciclo de Medición!
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:30%">
                                                    <label for="valoresValorProgramado">Meta Programada:<span
                                                            style="color: red">*</span></label>
                                                </td>
                                                <td colspan="2">
                                                    <input type="text" class="form-control"
                                                        id="valoresValorProgramado" placeholder="0.000" value=""
                                                        style="text-align:right;"required name="valoresValorProgramado"
                                                        disabled />
                                                    <div class="invalid-feedback">
                                                        Indique un Valor Válido!
                                                    </div>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:30%">
                                                    <label for="valoresEstatusProgramado">Estatus de la Meta
                                                        Programada:<span style="color: red">*</span></label>
                                                </td>
                                                <td colspan="2">
                                                    <select class="form-control" id="valoresEstatusProgramado"
                                                        name="valoresEstatusProgramado" disabled>
                                                        <option value="0">Seleccione...</option>
                                                        <option value="no_disponible">No disponible</option>
                                                        <option value="preliminar">Preliminar</option>
                                                        <option value="proyectado">Proyectado</option>
                                                        <option value="definitivo">Definitivo</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Elija un Estatus!
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:30%">
                                                    <label for="valoresValorMeta">Meta Resultado:<span
                                                            style="color: red">*</span></label>
                                                </td>
                                                <td colspan="2">
                                                    <input type="text" class="form-control" id="valoresValorMeta"
                                                        placeholder="0.000" value=""
                                                        style="text-align:right;"required name="valoresValorMeta" />
                                                    <div class="invalid-feedback">
                                                        Indique un Valor Válido!
                                                    </div>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:30%">
                                                    <label for="valoresEstatusMeta">Estatus del Resultado:<span
                                                            style="color: red">*</span></label>
                                                </td>
                                                <td colspan="2">
                                                    <select class="form-control" id="valoresEstatusMeta"
                                                        name="valoresEstatusMeta">
                                                        <option value="0">Seleccione...</option>
                                                        <option value="no_disponible">No disponible</option>
                                                        <option value="preliminar">Preliminar</option>
                                                        <option value="proyectado">Proyectado</option>
                                                        <option value="definitivo">Definitivo</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Elija un Estatus!
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:30%">
                                                    <label for="valoresObservacionesProgramado">Obsevaciones:</label>
                                                </td>
                                                <td colspan="2">
                                                    <textarea type="text" class="form-control" id="valoresObservacionesProgramado"
                                                        name="valoresObservacionesProgramado" placeholder="" value="" required></textarea>
                                                    <div class="invalid-feedback">
                                                        Elija un Estatus!
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </form>
                            </div>
                            <div class="col-xl-6" style="border:dashed 1px gray; overflow:scroll; height:400px">
                                <h4>Medios Cargados</h4>
                                <table class="table">
                                    <thead class="thead-dark" style="background-color: #919090; color:white">
                                        <tr>
                                            <td>Archivo</td>
                                            <td>Descripcion</td>
                                            <td>Acciones</td>
                                        </tr>
                                    </thead>
                                    <tbody id="mediosindicador" style="font-size:.8em">
                                    </tbody>
                                </table>
                                <!--<div class="alert text-center"><h4>No existen Medios de Verificación Cargados!</h4></div>-->
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <h4>Area de Carga</h4>
                            <div class="col-xl-12" style="height:200px;overflow:scroll;">
                                <form action="{{ route('indicador.valor.medioverificacion') }}" method="POST"
                                    enctype="multipart/form-data" class="dropzone" id="medio-upload" style="color:blue">
                                    @csrf
                                    <input type="hidden" name="idIndicadorF" id="idIndicadorF">
                                    <input type="hidden" name="idValoresIndicadorF" id="idValoresIndicadorF">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="updateValorMeta()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal-variables" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true" style="z-index:1400">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #681b2e; color:white">
                        <h5 class="modal-title">Monitoreo de Metas para la Variable: <span
                                id="modalVariableNombre"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="color:white">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="instrucciones" style="color:black;padding:30px;">
                        <b>Instrucciones: </b> Para agregar valores de las metas alcanzadas, dé clic sobre el boton   <button class="btn btn-sm btn-success" title="Editar Valor"><i class="fas fa-arrow-up"></i></button> del periodo correspondiente.
                    </div>
                    <div class="modal-body" style="padding:25px;">
                        <input type="hidden" id="idVariable" />
                        <div class="row" id="variableprogramadosContent">
                            <div class="col-xl-12 col-lg-7">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #681b2e;">
                                        <h6 class="m-0 font-weight-bold text-light">Metas Programadas de la Variable
                                        </h6>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div id="emptyprogramadosvariable" style="display:none">
                                            <center>
                                                <h4>No existen valores programados registrados!</h4>
                                            </center>
                                        </div>
                                        <table class="table table-striped table-bordered" id="tableVariableProgramados"
                                            style="display:none">
                                            <thead>
                                                <tr style="background-color:#919090;color:white;">
                                                    <th style="width: 10%">Periodo de Medicion</th>
                                                    <th style="width: 10%">Fin del Periodo(ciclo)</th>
                                                    <th style="width: 10%">Valor Programado</th>
                                                    <th style="width: 10%">Estatus del valor</th>
                                                    <th style="width: 10%">Valor Real</th>
                                                    <th style="width: 10%">Estatus del valor Real</th>
                                                    <th style="width: 30%">Observaciones</th>
                                                    <th style="width: 10%"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="rowsvariableprogramado">
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal-valorvariableprogramado" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true" style="z-index:1600">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #681b2e; color:white">
                        <h5 class="modal-title">Metas Cumplidas de la Variable</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="color:white">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding:25px;">
                        <div class="row">
                            <div class="col-xl-6" style="background-color:rgb(240, 240, 240)">
                                <h4>Datos de la Meta</h4>
                                <form id="formValoresVariableMeta" action="{{ route('variable.valores.setmeta') }}">
                                    <div class="row">
                                        <input type="hidden" name="idValoresVariableProgramado"
                                            id="idValoresVariableProgramado" />
                                        @csrf
                                        <table style="width:100%">
                                            <tr>
                                                <td style="width:30%">
                                                    <label for="valoresVariableAnioMedicionProgramado">Ciclo de
                                                        Medicion:<span style="color: red">*</span></label>
                                                </td>
                                                <td style="width:35%">
                                                    <select class="form-control"
                                                        id="valoresVariableAnioMedicionProgramado"
                                                        name="valoresVariableAnioMedicionProgramado" disabled>
                                                        <option value="0">Seleccione...</option>
                                                        @for ($x = 2022; $x <= 2028; $x++)
                                                            <option value="{{ $x }}">{{ $x }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Seleccione ciclo de Medición!
                                                    </div>
                                                </td>
                                                <td style="width:35%">
                                                    <select class="form-control"
                                                        id="valoresVariableCicloMedicionProgramado"
                                                        name="valoresVariableCicloMedicionProgramado" disabled>
                                                        <option value="0">Seleccione...</option>
                                                        @for ($x = 2022; $x <= 2028; $x++)
                                                            <option value="{{ $x }}">{{ $x }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Seleccione ciclo de Medición!
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:30%">
                                                    <label for="valoresVariableProgramado">Valor Programado:<span
                                                            style="color: red">*</span></label>
                                                </td>
                                                <td colspan="2">
                                                    <input type="text" class="form-control"
                                                        id="valoresVariableProgramado" placeholder="0.000" value=""
                                                        style="text-align:right;"required name="valoresVariableProgramado"
                                                        disabled />
                                                    <div class="invalid-feedback">
                                                        Indique un Valor Válido!
                                                    </div>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:30%">
                                                    <label for="valoresVariableEstatusProgramado">Estatus del Dato
                                                        Programado:<span style="color: red">*</span></label>
                                                </td>
                                                <td colspan="2">
                                                    <select class="form-control" id="valoresVariableEstatusProgramado"
                                                        name="valoresVariableEstatusProgramado" disabled>
                                                        <option value="0">Seleccione...</option>
                                                        <option value="no_disponible">No disponible</option>
                                                        <option value="preliminar">Preliminar</option>
                                                        <option value="proyectado">Proyectado</option>
                                                        <option value="definitivo">Definitivo</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Elija un Estatus!
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:30%">
                                                    <label for="valoresVariableMeta">Resultado de la Meta:<span
                                                            style="color: red">*</span></label>
                                                </td>
                                                <td colspan="2">
                                                    <input type="text" class="form-control" id="valoresVariableMeta"
                                                        placeholder="0.000" value=""
                                                        style="text-align:right;"required name="valoresVariableMeta" />
                                                    <div class="invalid-feedback">
                                                        Indique un Valor Válido!
                                                    </div>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:30%">
                                                    <label for="valoresVariableEstatusMeta">Estatus de la Meta:<span
                                                            style="color: red">*</span></label>
                                                </td>
                                                <td colspan="2">
                                                    <select class="form-control" id="valoresVariableEstatusMeta"
                                                        name="valoresVariableEstatusMeta">
                                                        <option value="0">Seleccione...</option>
                                                        <option value="no_disponible">No disponible</option>
                                                        <option value="preliminar">Preliminar</option>
                                                        <option value="proyectado">Proyectado</option>
                                                        <option value="definitivo">Definitivo</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Elija un Estatus!
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:30%">
                                                    <label
                                                        for="valoresVariableObservacionesProgramado">Obsevaciones:</label>
                                                </td>
                                                <td colspan="2">
                                                    <textarea type="text" class="form-control" id="valoresVariableObservacionesProgramado"
                                                        name="valoresVariableObservacionesProgramado" placeholder="" value="" required></textarea>
                                                    <div class="invalid-feedback">
                                                        Elija un Estatus!
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </form>
                            </div>
                            <div class="col-xl-6" style="border:dashed 1px gray; overflow:scroll; height:400px">
                                <h4>Medios Cargados</h4>
                                <table class="table">
                                    <thead class="thead-dark" style="background-color: #919090; color:white">
                                        <tr>
                                            <td>Archivo</td>
                                            <td>Descripcion</td>
                                            <td>Acciones</td>
                                        </tr>
                                    </thead>
                                    <tbody id="mediosvariable" style="font-size:.8em">
                                    </tbody>
                                </table>
                                <!--<div class="alert text-center"><h4>No existen Medios de Verificación Cargados!</h4></div>-->
                            </div>
                        </div>
                        <div class="row">
                            <h4>Area de Carga</h4>
                            <div class="col-xl-12" style="height:200px;overflow:scroll;">
                                <form action="{{ route('variable.valor.medioverificacion') }}" method="POST"
                                    enctype="multipart/form-data" class="dropzone" id="mediovariable-upload" style="color:blue">
                                    @csrf
                                    <input type="hidden" name="idIndicadorFV" id="idIndicadorFV">
                                    <input type="hidden" name="idVariableF" id="idVariableF">
                                    <input type="hidden" name="idValoresVariableF" id="idValoresVariableF">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary"
                            onclick="updateValorVariableMeta()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center">
            <hr />
            <h3>
                No existen Indicadores Registrados!
            </h3>
            <a href="{{ route('indicador') }}">
                <button class="btn btn-success">

                    Agregar Indicador

                </button>
            </a>
        </div>
    @endif
@endsection

@section('scripts')
    <script src="{{ asset('resources/js/dropzone-min.js') }}"></script>

    <script>
        //Scripts para la funcionalidad de los valores históricos
        $(document).ready(function() {
            //block(true);
            //block(false);
            historicos = $(".rowhistorico").length;
            if (historicos > 0) {
                $("#tableHistoricos").show("slow");
            }

            programados = $(".rowprogramado").length;
            if (programados > 0) {
                $("#tableProgramados").show("slow");
            }

            $('.modal-valorvariableprogramado')
            .on('hidden.bs.modal', function (e) {
                $(".modal-variables").modal("show");
            });
            $('.modal-valorvariableprogramado')
            .on('show.bs.modal', function (e) {
                $(".modal-variables").modal("hide");
            });

            $("#collapseTwo").addClass("show");
            $("#menuIndicadores").addClass("active");
            $("#optindicadormonitoreo").css('background-color',"rgb(217, 217, 217)");

        });

        let miareadecarga = null;
        //miareadecarga.on("complete", function(file) {
        //    miareadecarga.removeFile(file);
        //});
        inicializaDropZone();
        inicializaDropZoneVariable();


        function setDataIndicador() {
            seleccionado = $("#indicador option:selected").val();
            textseleccionado = $("#indicador option:selected").text();


            if (seleccionado > 0) {
                $.ajax({
                        type: 'GET',
                        url: "{{ route('indicador.getstatus') }}",
                        data: {
                            indicador:seleccionado
                        },
                        async: false,
                        cache: false,
                        beforeSend: function() {
                            block(true)
                        },
                    }).done(function(response) {
                        block(false);
                        if(response.status==0){
                            if(response.monitoreo){
                                $("#indicadorSeleccion").hide("slow");
                                $("#enrevision").hide("");
                                $("#indicadorTitle").show("slow");
                                $("#rowtags").show("");
                                $("#indicadorSelected").html(textseleccionado);
                                $("#programacionContent").show("slow");
                                $("#variablesContent").show("slow");
                                $("#idIndicador").val(seleccionado);
                                $("#bloqueado").hide("");
                                getValoresProgramados(seleccionado);
                                getVariables(seleccionado);
                            }else{
                                $("#rowtags").hide("");
                                $("#bloqueado").show("");
                                $("#indicadorSeleccion").hide("slow");
                                $("#indicadorTitle").show("slow");
                                $("#indicadorSelected").html(textseleccionado);
                            }

                        }else{
                            $("#rowtags").hide("");
                            $("#enrevision").show("");
                            $("#bloqueado").hide("");
                            $("#indicadorSeleccion").hide("slow");
                            $("#indicadorTitle").show("slow");
                            $("#indicadorSelected").html(textseleccionado);
                        }
                    }).fail(function(data) {
                        block(false);
                    })
            }
        }

        function backToSelector() {
            $("#indicadorSeleccion").show("slow");
            $("#indicadorTitle").hide("slow");
            $("#indicadorSelected").html("");
            $("#indicador").val(0);
            $("#historicosContent").hide("slow");
            $("#programacionContent").hide("slow");
            $("#variablesContent").hide("slow");

        }

        function inicializaDropZone() {
            miareadecarga = new Dropzone("#medio-upload", {
                thumbnailWidth: 500,
                maxFilesize: 5,
                //disablePreviews:true,
                acceptedFiles: ".pdf,.zip,.docx,.xlsx,.doc,.xls,application/x-zip-compressed,application/zip",
            });
            miareadecarga.on("addedfile", file => {
                idIndicador = $("#idIndicador").val();
                idValoresIndicador = $("#idValoresIndicadorProgramado").val();
                $("#idIndicadorF").val(idIndicador);
                $("#idValoresIndicadorF").val(idValoresIndicador);
            });

            miareadecarga.on("success", function(file, response) {
                if (response.success == "ok") {
                    idIndicador = $("#idIndicador").val();
                    idValoresIndicador = $("#idValoresIndicadorProgramado").val();
                    nombre = file.name;
                    idMedioIndicador = response.idMedio;
                    filename = response.filename;
                    rowmedio = '<tr class="rowmedio' + idMedioIndicador + '">' +
                        '<td class="medioindicador" medio="' + idMedioIndicador +
                        '"><a target="blank_" href="{{asset("medios")}}'+ '/' + idIndicador + '/' + idValoresIndicador + '/' +
                        filename + '">' + nombre + '</a></td>' +
                        '<td><textarea placeholder="Agrega Descripcion" class="medioindicadorobservacion"></textarea></td>' +
                        '<td><button class="btn btn-danger" onclick="deleteMedio(' + idMedioIndicador +
                        ')"><i class="fas fa-trash"></i></button></td>' +
                        '</tr>';
                    $("#mediosindicador").append(rowmedio).show("slow");
                }
            });
        }

        function inicializaDropZoneVariable() {
            miareadecargavariable = new Dropzone("#mediovariable-upload", {
                thumbnailWidth: 500,
                maxFilesize: 5,
                //disablePreviews:true,
                acceptedFiles: ".pdf,.zip,.docx,.xlsx,.doc,.xls,application/x-zip-compressed,application/zip",
            });
            miareadecargavariable.on("addedfile", file => {
                idIndicador = $("#idIndicador").val();
                idVariable = $("#idVariable").val();
                idValoresVariable = $("#idValoresVariableProgramado").val();
                $("#idIndicadorFV").val(idIndicador);
                $("#idVariableF").val(idVariable);
                $("#idValoresVariableF").val(idValoresVariable);
            });

            miareadecargavariable.on("success", function(file, response) {
                if (response.success == "ok") {
                    idIndicador = $("#idIndicador").val();
                    idVariable = $("#idVariable").val();
                    idValoresVariable = $("#idValoresVariableProgramado").val();
                    nombre = file.name;
                    idMedioVariable = response.idMedio;
                    filename = response.filename;
                    rowmedio = '<tr class="rowmediovariable' + idMedioVariable + '">' +
                        '<td class="mediovariable" medio="' + idMedioVariable +
                        '"><a target="blank_" href="{{asset("medios")}}'+'/'+idIndicador+'/variables/' + idVariable + '/' + idValoresVariable + '/' +
                        filename + '">' + nombre + '</a></td>' +
                        '<td><textarea placeholder="Agrega Descripcion" class="mediovariableobservacion"></textarea></td>' +
                        '<td><button class="btn btn-danger" onclick="deleteMedioVariable(' + idMedioVariable +
                        ')"><i class="fas fa-trash"></i></button></td>' +
                        '</tr>';
                    $("#mediosvariable").append(rowmedio).show("slow");
                }
            });
        }

        function getMediosIndicador() {
            $("#mediosindicador").html('');
            idIndicador = $("#idIndicador").val();
            idValoresIndicador = $("#idValoresIndicadorProgramado").val();
            $.ajax({
                type: 'GET',
                url: "{{ route('indicador.valor.medios') }}",
                data: {
                    idValoresIndicador: idValoresIndicador
                },
                dataType: 'json',
                beforeSend: function() {
                    block(true);
                }
            }).done(function(response) {
                block(false);
                if (response.success == "ok") {
                    if (response.medios.length > 0) {
                        for (x = 0; x < response.medios.length; x++) {
                            row = '<tr class="rowmedio' + response.medios[x].idMedio + '">' +
                                '<td class="medioindicador" medio="' + response.medios[x].idMedio +
                                '"><a target="blank_" href="{{asset("medios")}}'+'/' + idIndicador + '/' + idValoresIndicador +
                                '/' + response.medios[x].filename + '">' + response.medios[x].archivo +
                                '</a></td>' +
                                '<td><textarea class="medioindicadorobservacion" placeholder="Agrega Descripcion">' +
                                response.medios[x].descripcion + '</textarea></td>' +
                                '<td><button class="btn btn-danger" onclick="deleteMedio(' + response.medios[x]
                                .idMedio + ')"><i class="fas fa-trash"></i></button></td>' +
                                '</tr>';
                            $("#mediosindicador").append(row);
                        }
                    }
                } else {

                }
            }).fail(function(data) {
                block(false);
            })
        }

        function getMediosVariable() {
            $("#mediosvariable").html('');
            idIndicador = $("#idIndicador").val();
            idVariable = $("#idVariable").val();
            idValoresVariable = $("#idValoresVariableProgramado").val();
            $.ajax({
                type: 'GET',
                url: "{{ route('variable.valor.medios') }}",
                data: {
                    idValoresVariable: idValoresVariable
                },
                dataType: 'json',
                beforeSend: function() {
                    block(true);
                }
            }).done(function(response) {
                block(false);
                if (response.success == "ok") {
                    if (response.medios.length > 0) {
                        for (x = 0; x < response.medios.length; x++) {
                            row = '<tr class="rowmedio' + response.medios[x].idMedio + '">' +
                                '<td class="mediovariable" medio="' + response.medios[x].idMedio +
                                '"><a target="blank_" href="{{asset("medios")}}/' + idIndicador + '/variables/' + idVariable + '/' + idValoresVariable +
                                '/' + response.medios[x].filename + '">' + response.medios[x].archivo +
                                '</a></td>' +
                                '<td><textarea class="mediovariableobservacion" placeholder="Agrega Descripcion">' +
                                response.medios[x].descripcion + '</textarea></td>' +
                                '<td><button class="btn btn-danger" onclick="deleteMedioVariable(' + response.medios[x]
                                .idMedio + ')"><i class="fas fa-trash"></i></button></td>' +
                                '</tr>';
                            $("#mediosvariable").append(row);
                        }
                    }
                } else {

                }
            }).fail(function(data) {
                block(false);
            })
        }

        function deleteMedio(idMedioIndicador) {
            idIndicador = $("#idIndicador").val();
            idValoresIndicador = $("#idValoresIndicadorProgramado").val();
            Swal.fire({
                title: '¿Está Seguro?',
                text: "Este medio será eliminado de los registros!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('indicador.valor.deletemedio') }}",
                        data: {
                            idMedioIndicador: idMedioIndicador,
                            idIndicador: idIndicador,
                            idValoresIndicador: idValoresIndicador,
                            _token: $("input[name='_token']").val()
                        },
                        beforeSend: function() {
                            block(true)
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.success == "ok") {
                                getMediosIndicador();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Medio Eliminado',
                                    text: response.message,
                                    confirmButtonColor: '#3085d6',
                                }).then((result) => {});
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Ocurrió un error al intentar eliminar el medio',
                                    text: '',
                                    confirmButtonColor: '#3085d6',
                                })
                            }
                        }
                    }).done(function(response) {
                        block(false);
                    }).fail(function(data) {
                        block(false);
                    })
                }
            })

        }

        function deleteMedioVariable(idMedioVariable) {
            idIndicador = $("#idIndicador").val();
            idVariable = $("#idVariable").val();
            idValoresVariable = $("#idValoresVariableProgramado").val();
            Swal.fire({
                title: '¿Está Seguro?',
                text: "Este medio será eliminado de los registros!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('variable.valor.deletemedio') }}",
                        data: {
                            idVariable:idVariable,
                            idMedioVariable: idMedioVariable,
                            idIndicador: idIndicador,
                            idValoresVariable: idValoresVariable,
                            _token: $("input[name='_token']").val()
                        },
                        beforeSend: function() {
                            block(true)
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.success == "ok") {
                                getMediosVariable();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Medio Eliminado',
                                    text: response.message,
                                    confirmButtonColor: '#3085d6',
                                }).then((result) => {});
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Ocurrió un error al intentar eliminar el medio',
                                    text: '',
                                    confirmButtonColor: '#3085d6',
                                })
                            }
                        }
                    }).done(function(response) {
                        block(false);
                    }).fail(function(data) {
                        block(false);
                    })
                }
            })

        }
    </script>
    <!-- Scripts para valores programados -->
    <script>
        function showModalProgramado() {
            $("#idValoresIndicadorProgramado").val("");
            $("#valoresAnioMedicionProgramado").val(0);
            $("#valoresCicloMedicionProgramado").val(0);
            $("#valoresValorProgramado").val("");
            $("#valoresEstatusProgramado").val(0);
            $("#valoresObservacionesProgramado").val("");
            $(".modal-valorprogramado").modal("show");
        }

        function updateValorMeta() {
            if (validaValorProgramado()) {
                idIndicador = $("#idIndicador").val();
                $("#tableProgramados").show("slow");
                $(".modal-valorprogramado").modal("hide");
                valoresAnioMedicionProgramado = $("#valoresAnioMedicionProgramado").val();
                valoresCicloMedicionProgramado = $("#valoresCicloMedicionProgramado").val();
                valoresValorProgramado = $("#valoresValorProgramado").val();
                valoresEstatusProgramado = $("#valoresEstatusProgramado").val();
                valoresValorMeta = $("#valoresValorMeta").val();
                valoresEstatusMeta = $("#valoresEstatusMeta").val();

                medios = "";
                observaciones = "";

                $(".medioindicador").each(function() {
                    medios += $(this).attr("medio") + "|";
                });

                $(".medioindicadorobservacion").each(function() {
                    observaciones += $(this).val() + "|";
                });



                valoresObservacionesProgramado = $("#valoresObservacionesProgramado").val();
                var data = $("#formValorMeta").serialize();
                data += "&idIndicador=" + idIndicador;
                data += "&medios=" + medios;
                data += "&descripciones=" + observaciones;

                $.ajax({
                    type: 'POST',
                    url: $("#formValorMeta").attr('action'),
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
                            title: 'La meta del Indicador se ha Actualizado Satifactoriamente!',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                            //window.location.replace("{{ route('indicador.list') }}");
                        });
                        if ($("#idValoresIndicadorProgramado").val().length > 0) {
                            getValoresProgramados(idIndicador);
                        }
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Ocurrió un error al intentar guardar la meta, intente más tarde',
                            text: '',
                            confirmButtonColor: '#3085d6',
                        })
                    }
                }).fail(function(data) {
                    block(false);
                })
            }
        }

        function validaValorProgramado() {
            inputs = [
                "valoresValorProgramado",
                "valoresValorMeta"
            ];
            selects = [
                "valoresAnioMedicionProgramado",
                "valoresCicloMedicionProgramado",
                "valoresEstatusProgramado",
                "valoresEstatusMeta"

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

        function getValoresProgramados(idIndicador) {
            $(".rowprogramado").remove();
            $.ajax({
                type: 'GET',
                url: "{{ route('indicador.valores.programados') }}",
                data: {
                    idIndicador: idIndicador
                },
                dataType: 'json',
                beforeSend: function() {
                    block(true);
                }
            }).done(function(response) {
                block(false);
                if (response.success == "ok") {
                    if (response.programados.length > 0) {
                        for (x = 0; x < response.programados.length; x++) {
                            let anio = response.programados[x].valoresAnioMedicion;
                            let botonEditar = '';
                            //el botón de editar solo se muestra para los años 2025 y 2026
                            if (anio == 2025 || anio == 2026 ) {
                                botonEditar =
                                    '<button class="btn btn-sm btn-success" title="Editar Valor" ' +
                                    'onclick="setDataValorProgramado(' + response.programados[x].idValoresIndicador + ')">' +
                                    '<i class="fas fa-arrow-up"></i></button>';
                            }

                            if (anio == 2024 && (response.programados[x].idIndicador == 2 ||  response.programados[x].idIndicador == 30 )) {
                                botonEditar =
                                    '<button class="btn btn-sm btn-success" title="Editar Valor" ' +
                                    'onclick="setDataValorProgramado(' + response.programados[x].idValoresIndicador + ')">' +
                                    '<i class="fas fa-arrow-up"></i></button>';
                            }

                            row = '<tr class="rowprogramado" id="rowprogramado' + response.programados[x]
                                .idValoresIndicador + '">' +
                                '<td class="text-center valoresAnioMedicionProgramado">' + response.programados[x]
                                .valoresAnioMedicion + '</td>' +
                                '<td class="text-center valoresCicloMedicionProgramado">' + response.programados[x]
                                .valoresCicloMedicion + '</td>' +
                                '<td class="text-right valoresValorProgramado">' + response.programados[x]
                                .valoresProgramado +
                                '</td>' +
                                '<td class="text-center valoresEstatusProgramado">' + response.programados[x]
                                .valoresEstatusP +
                                '</td>' +
                                '<td class="text-right valoresValorMeta" style="color:black; font-weight:bold;">' +
                                response.programados[x]
                                .valoresReal +
                                '</td>' +
                                '<td class="text-center valoresEstatusMeta" style="color:black; font-weight:bold;">' +
                                response.programados[x]
                                .valoresEstatus +
                                '</td>' +
                                '<td class="valoresObservacionesProgramado">' + response.programados[x]
                                .valoresObservaciones +
                                '</td>' +
                                '<td class="text-center">' + botonEditar + '</td>' +
                                '</tr>';
                            $("#rowsprogramados").append(row);
                        }
                        $("#tableProgramados").show("slow");
                        $("#emptyprogramados").hide("slow");
                    }else{
                        $("#tableProgramados").hide("slow");
                        $("#emptyprogramados").show("slow");
                    }
                } else {}
            }).fail(function(data) {
                block(false);
            })
        }

        function setDataValorProgramado(idValoresId) {

            valoresAnioMedicionProgramado = $("#rowprogramado" + idValoresId).find(".valoresAnioMedicionProgramado").html();
            valoresCicloMedicionProgramado = $("#rowprogramado" + idValoresId).find(".valoresCicloMedicionProgramado")
                .html();
            valoresValorProgramado = $("#rowprogramado" + idValoresId).find(".valoresValorProgramado").html();
            valoresEstatusProgramado = $("#rowprogramado" + idValoresId).find(".valoresEstatusProgramado").html();
            valoresValorMeta = $("#rowprogramado" + idValoresId).find(".valoresValorMeta").html();
            valoresEstatusMeta = $("#rowprogramado" + idValoresId).find(".valoresEstatusMeta").html();
            if (valoresEstatusMeta == "Sin definir")
                valoresEstatusMeta = 0;
            valoresObservacionesProgramado = $("#rowprogramado" + idValoresId).find(".valoresObservacionesProgramado")
                .html();
            $("#idValoresIndicadorProgramado").val(idValoresId);
            $("#valoresAnioMedicionProgramado").val(valoresAnioMedicionProgramado);
            $("#valoresCicloMedicionProgramado").val(valoresCicloMedicionProgramado);
            $("#valoresValorProgramado").val(valoresValorProgramado);
            $("#valoresEstatusProgramado").val("" + valoresEstatusProgramado + "");
            $("#valoresValorMeta").val(valoresValorMeta);
            $("#valoresEstatusMeta").val("" + valoresEstatusMeta + "");
            $("#valoresObservacionesProgramado").val(valoresObservacionesProgramado);
            $(".dz-complete").remove();
            $(".modal-valorprogramado").modal("show");
            getMediosIndicador();
        }
    </script>
    <!--Scripts para Variables HIstoricos-->
    <script>
        function getVariables(idIndicador) {
            $.ajax({
                type: 'GET',
                url: "{{ route('indicador.variables') }}",
                data: {
                    idIndicador: idIndicador
                },
                dataType: 'json',
                beforeSend: function() {
                    block(true);
                }
            }).done(function(response) {
                block(false);
                if (response.success == "ok") {
                    if (response.variables.length > 0) {
                        variables = "";
                        for (x = 0; x < response.variables.length; x++) {
                            variables += '<div class="col-lg-4 mb-4" style="padding:20px;">' +
                                '<div class="card shadow mb-4">' +
                                '<div class="card-header py-3" style="background-color: #919090;">' +
                                '<h6 class="m-0 font-weight-bold" style="color:white">Variable: ' + response
                                .variables[x].variableNombre +
                                '</h6>' +
                                '<h6 class="m-0 font-weight-bold" style="color:white">Unidad de Medida: ' + response
                                .variables[x].variableUM +
                                '</h6>' +
                                '</div>' +
                                '<div class="card-body">' +
                                '<button class="btn btn-success" onclick="showModalVariables(\'' + response
                                .variables[x].variableNombre + '\',' + response.variables[x].idVariable +
                                ')"><i class="fas fa-chart-line"></i> Monitoreo de Metas</button> ' +
                                '</div>' +
                                '</div>' +
                                '</div>';

                        }
                        $("#variables").html(variables);
                    }
                } else {}
            }).fail(function(data) {
                block(false);
            })
        }

        function showModalVariables(variable, idVariable) {
            $(".modal-variables").modal("show");
            $("#modalVariableNombre").html(variable);
            $("#idVariable").val(idVariable);
            getValoresVariableProgramados(idVariable);

        }
    </script>
    <!--Scripts para Variables Programados-->
    <script>
        function updateValorVariableMeta() {
            if (validaVariableValorProgramado()) {
                idVariable = $("#idVariable").val();
                $("#tableVariableProgramados").show("slow");
                $(".modal-valorvariableprogramado").modal("hide");
                valoresAnioMedicion = $("#valoresVariableAnioMedicionProgramado").val();
                valoresCicloMedicion = $("#valoresVariableCicloMedicionProgramado").val();
                valoresValor = $("#valoresVariableProgramado").val();
                valoresEstatus = $("#valoresVariableEstatusProgramado").val();
                valoresObservaciones = $("#valoresVariableObservacionesProgramado").val();

                medios = "";
                descripciones = "";

                $(".mediovariable").each(function() {
                    medios += $(this).attr("medio") + "|";
                });

                $(".mediovariableobservacion").each(function() {
                    descripciones += $(this).val() + "|";
                });

                var data = $("#formValoresVariableMeta").serialize();
                data += "&idVariable=" + idVariable;
                data += "&medios=" + medios;
                data += "&descripciones=" + descripciones;

                $.ajax({
                    type: 'POST',
                    url: $("#formValoresVariableMeta").attr('action'),
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
                            title: 'Meta guardada Satifactoriamente!',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                            //window.location.replace("{{ route('indicador.list') }}");
                        });
                        if ($("#idValoresVariableProgramado").val().length > 0) {
                            getValoresVariableProgramados(idVariable);
                        } else {
                            row = '<tr class="rowvariableprogramado" id="rowvariableprogramado' + response.id +
                                '">' +
                                '<td class="text-center valoresVariableAnioMedicionProgramado">' +
                                valoresAnioMedicion + '</td>' +
                                '<td class="text-center valoresVariableCicloMedicionProgramado">' +
                                valoresCicloMedicion + '</td>' +
                                '<td class="text-right valoresVariableProgramado">' + valoresValor + '</td>' +
                                '<td class="text-center valoresVariableEstatusProgramado">' + valoresEstatus +
                                '</td>' +
                                '<td class="valoresVariableObservacionesProgramado">' + valoresObservaciones +
                                '</td>' +
                                '<td class="text-center">' +
                                '<button class="btn btn-sm btn-info" title="Editar Valor" onclick="setDataValorVariableProgramado(' +
                                response.id + ')"><i class="fas fa-edit"></i></button> &nbsp;' +
                                '<button class="btn btn-sm btn-danger" onclick="deleteValorVariableProgramado(' +
                                response.id +
                                ')" title="Eliminar Registro"><i class="fas fa-trash"></i></button>' +
                                '</td>' +
                                '</tr>';
                            $("#rowsvariableprogramado").append(row);
                        }
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Ocurrió un error al intentar guardar la meta, intente más tarde',
                            text: '',
                            confirmButtonColor: '#3085d6',
                        })
                    }
                }).fail(function(data) {
                    block(false);
                })
            }
        }

        function validaVariableValorProgramado() {
            inputs = [
                "valoresVariableProgramado",
                "valoresVariableMeta"
            ];
            selects = [
                "valoresVariableAnioMedicionProgramado",
                "valoresVariableCicloMedicionProgramado",
                "valoresVariableEstatusProgramado",
                "valoresVariableEstatusMeta",

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

        function getValoresVariableProgramados(idVariable) {
            $(".rowvariableprogramado").remove();
            $.ajax({
                type: 'GET',
                url: "{{ route('variable.valores.programados') }}",
                data: {
                    idVariable: idVariable
                },
                dataType: 'json',
                beforeSend: function() {
                    block(true);
                }
            }).done(function(response) {
                block(false);
                if (response.success == "ok") {
                    if (response.programados.length > 0) {
                        for (x = 0; x < response.programados.length; x++) {
                            row = '<tr class="rowvariableprogramado" id="rowvariableprogramado' + response
                                .programados[
                                    x]
                                .idValores + '">' +
                                '<td class="text-center valoresVariableAnioMedicionProgramado">' + response
                                .programados[x]
                                .valoresAnioMedicion + '</td>' +
                                '<td class="text-center valoresVariableCicloMedicionProgramado">' + response
                                .programados[x]
                                .valoresCicloMedicion + '</td>' +
                                '<td class="text-right valoresVariableProgramado">' + response.programados[x]
                                .valoresProgramado +
                                '</td>' +
                                '<td class="text-center valoresVariableEstatusProgramado">' + response.programados[
                                    x]
                                .valoresEstatusP +
                                '</td>' +
                                '<td class="text-right valoresVariableMeta" style="color:black; font-weight:bold;">' +
                                response.programados[x]
                                .valoresReal +
                                '</td>' +
                                '<td class="text-center valoresVariableEstatusMeta" style="color:black; font-weight:bold;">' +
                                response.programados[
                                    x]
                                .valoresEstatus +
                                '</td>' +
                                '<td class="valoresVariableObservacionesProgramado">' + response.programados[x]
                                .valoresObservaciones +
                                '</td>' +
                                '<td class="text-center">' +
                                '<button class="btn btn-sm btn-success" title="Editar Valor" onclick="setDataValorVariableProgramado(' +
                                response.programados[x].idValores +
                                ')"><i class="fas fa-arrow-up"></i></button> &nbsp;' +
                                '</td>' +
                                '</tr>';
                            $("#rowsvariableprogramado").append(row);
                        }
                        $("#tableVariableProgramados").show("slow");
                        $("#emptyprogramadosvariable").hide();
                    }else{
                        $("#tableVariableProgramados").hide("slow");
                        $("#emptyprogramadosvariable").show();
                    }
                } else {}
            }).fail(function(data) {
                block(false);
            })
        }

        function setDataValorVariableProgramado(idValoresId) {

            valoresVariableAnioMedicionProgramado = $("#rowvariableprogramado" + idValoresId).find(
                ".valoresVariableAnioMedicionProgramado").html();
            valoresVariableCicloMedicionProgramado = $("#rowvariableprogramado" + idValoresId).find(
                ".valoresVariableCicloMedicionProgramado").html();
            valoresVariableProgramado = $("#rowvariableprogramado" + idValoresId).find(".valoresVariableProgramado").html();
            valoresVariableEstatusProgramado = $("#rowvariableprogramado" + idValoresId).find(
                ".valoresVariableEstatusProgramado").html();
            valoresVariableMeta = $("#rowvariableprogramado" + idValoresId).find(".valoresVariableMeta").html();

            valoresVariableEstatusMeta = $("#rowvariableprogramado" + idValoresId).find(".valoresVariableEstatusMeta")
                .html();
            valoresVariableObservacionesProgramado = $("#rowvariableprogramado" + idValoresId).find(
                ".valoresVariableObservacionesProgramado").html();

            if (valoresVariableEstatusMeta == "Sin definir")
                valoresVariableEstatusMeta = 0;
            $("#idValoresVariableProgramado").val(idValoresId);
            $("#valoresVariableAnioMedicionProgramado").val(valoresVariableAnioMedicionProgramado);
            $("#valoresVariableCicloMedicionProgramado").val(valoresVariableCicloMedicionProgramado);
            $("#valoresVariableProgramado").val(valoresVariableProgramado);
            $("#valoresVariableEstatusProgramado").val("" + valoresVariableEstatusProgramado + "");
            $("#valoresVariableMeta").val(valoresVariableMeta);
            $("#valoresVariableEstatusMeta").val("" + valoresVariableEstatusMeta + "");
            $("#valoresVariableObservacionesProgramado").val(valoresVariableObservacionesProgramado);
            $(".dz-complete").remove();
            getMediosVariable();
            $(".modal-valorvariableprogramado").modal("show");
        }
    </script>
@endsection
