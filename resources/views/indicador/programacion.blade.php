@extends('layouts.administrador')

@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">Indicador / Programación de Metas</h1>    
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
            <div class="row">                
                <div class="col-xl-12 col-lg-7">
                    <nav >
                        <div class="nav nav-tabs nav-fill justify-content-center" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab"
                                href="#nav-historicos" role="tab" aria-controls="nav-home"
                                aria-selected="true">Valores Históricos<span id="objseleccionados"></span></a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab"
                                href="#nav-programacion" role="tab" aria-controls="nav-profile"
                                aria-selected="false">Programación de Metas<span id="objodsseleccionados"></span></a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab"
                                href="#nav-variables" role="tab" aria-controls="nav-contact"
                                aria-selected="false">Históricos y Programación de Variables<span id="programasseleccionados"></span></a>
                        </div>
                    </nav>
                    <hr/>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-historicos" role="tabpanel"
                            aria-labelledby="nav-home-tab"> 
                            <div class="row" id="historicosContent" style="display:none;z-index:1000">
                                <div class="instrucciones" style="color:black;padding:30px;">
                                    <b>Instrucciones: </b> Para agregar valores de metas históricas, identifique en la ventana siguiente el ícono: <span style="height:80px;background-color:#681b2e;"><i
                                            class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i></span> dé clic y elija la opción <b>"<i
                                            class="fas fa-plus" style="color: green"></i> Agregar Valor"</b>
                                </div>
                                <div class="col-xl-12 col-lg-7">
                                    <div class="card shadow mb-4">
                                        <!-- Card Header - Dropdown -->
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                                            style="background-color: #681b2e;">
                                            <h6 class="m-0 font-weight-bold text-light">Valores Históricos del Indicador: </h6>
                                            <div class="dropdown no-arrow">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                    aria-labelledby="dropdownMenuLink">
                                                    <div class="dropdown-header">Acciones:</div>
                                                    <!--  <a class="dropdown-item" href="#">Another action</a>
                                                                                                                                                                                    <div class="dropdown-divider"></div>-->
                                                    <a class="dropdown-item" onclick="showModal()" style="cursor: pointer"><i
                                                            class="fas fa-plus" style="color:green;"></i> Agregar Valor</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Card Body -->
                                        <div class="card-body">
                                            <div id="emptyhistoricos" style="display:none">
                                                <center>
                                                    <h4>No existen valores históricos registrados!</h4>
                                                </center>
                                            </div>
                                            <table class="table table-striped table-bordered" id="tableHistoricos" style="display:none">
                                                <thead>
                                                    <tr style="background-color:#919090;color:white;">
                                                        <th style="width: 15%">Periodo de Medicion</th>
                                                        <th style="width: 15%">Fin del Periodo(ciclo)</th>
                                                        <th style="width: 15%">Valor Histórico</th>
                                                        <th style="width: 15%">Estatus del valor</th>
                                                        <th style="width: 30%">Observaciones</th>
                                                        <th style="width: 10%"></th>
                    
                    
                                                    </tr>
                                                </thead>
                                                <tbody id="rowshistorico">
                                                    <!--<tr class="rowhistorico">
                                                                                                                            <td>
                                                                                                                                <select class="form-control" class="periodoMedicion">
                                                                                                                                    <option value="0">Seleccione...</option>
                                                                                                                                    <option value="2020">2020</option>
                                                                                                                                    <option value="2021">2021</option>
                                                                                                                                    <option value="2022">2022</option>
                                                                                                                                </select>
                                                                                                                            </td>
                                                                                                                            <td>
                                                                                                                                <input type="text" class="form-control valorHistorico" id="valorHistorico"
                                                                                                                                    placeholder="0.000" value="" style="text-align:right;width:150px;"required />
                                                                                                                            </td>
                                                                                                                            <td>
                                                                                                                                <select class="form-control" class="estatusDato">
                                                                                                                                    <option value="0">Seleccione...</option>
                                                                                                                                    <option value="no_disponible">No disponible</option>
                                                                                                                                    <option value="preliminar">Preliminar</option>
                                                                                                                                    <option value="proyectado">Proyectado</option>
                                                                                                                                    <option value="definitivo">Definitivo</option>
                                                                                                                                </select>
                                                                                                                            </td>
                                                                                                                            <td>
                                                                                                                                <textarea type="text" class="form-control observaciones" id="obseraciones" name="observaciones" placeholder=""
                                                                                                                                    value="" required></textarea>
                                                                                                                            </td>
                                                                                                                        </tr>-->
                                                </tbody>
                                            </table>
                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-programacion" role="tabpanel"
                            aria-labelledby="nav-profile-tab">  
                            <div class="instrucciones" style="color:black;padding:30px;">
                                <b>Instrucciones: </b> Para agregar valores de metas programadas, identifique en la ventana siguiente el ícono: <span style="height:80px;background-color:#681b2e;"><i
                                        class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i></span> dé clic y elija la opción <b>"<i
                                        class="fas fa-plus" style="color: green"></i> Agregar Valor"</b>
                            </div>
                            <div class="row" id="programacionContent" style="display:none;z-index:1001">                                
                                <div class="col-xl-12 col-lg-7">
                                    <div class="card shadow mb-4">
                                        <!-- Card Header - Dropdown -->
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                                            style="background-color: #681b2e;">
                                            <h6 class="m-0 font-weight-bold text-light">Programación de Metas: </h6>
                                            <div class="dropdown no-arrow">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                    aria-labelledby="dropdownMenuLink">
                                                    <div class="dropdown-header">Acciones:</div>
                                                    <!--  <a class="dropdown-item" href="#">Another action</a>
                                                                                            <div class="dropdown-divider"></div>-->
                                                    <a class="dropdown-item" onclick="showModalProgramado()" style="cursor: pointer"><i
                                                            class="fas fa-plus" style="color:green;"></i> Agregar Meta</a>
                                                </div>
                                            </div>
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
                                                        <th style="width: 15%">Periodo de Medicion</th>
                                                        <th style="width: 15%">Fin del Periodo(ciclo)</th>
                                                        <th style="width: 15%">Valor Programado</th>
                                                        <th style="width: 15%">Estatus del valor</th>
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
                            <div class="row" id="variablesContent" style="display:none;z-index:1002">
                                <div class="instrucciones" style="color:black;padding:30px;">
                                    <b>Instrucciones: </b> Para agregar valores tanto de metas históricas y metas programadas de las variables
                                    dé clic en el botón: <button class="btn btn-primary"><i class="fas fa-calendar"></i> Programacion de
                                        Metas</button> de cada espacio de la variable correspondiente
                                </div>
                                <div class="col-xl-12 col-lg-7">
                                    <div class="card shadow mb-4">
                                        <!-- Card Header - Dropdown -->
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                                            style="background-color: #681b2e;">
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
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                        style="background-color: #681b2e;">
                        <h6 class="m-0 font-weight-bold text-light">Seleccione Indicador </h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="col-md-12 mb-3">
                            <label for="indicadorTipo">Indicador:<span style="color: red">*</span></label>
                            <select class="form-control" id="indicador" name="indicador" onchange="setDataIndicador()">
                                <option value="0">Seleccione...</option>
                                @foreach ($indicadores as $indicador)
                                    <option value="{{ $indicador->idIndicador }}">{{ $indicador->indicadorNombre }}</option>
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
        </style>
        <div class="modal fade modal-valorhistorico" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #681b2e; color:white">
                        <h5 class="modal-title">Agregar Valores Históricos al Indicador</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="color:white">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding:25px;">
                        <form id="valoresIndicador" action="{{ route('indicador.valores.addhistoricos') }}">
                            <div class="row">
                                <input type="hidden" name="idValoresIndicador" id="idValoresIndicador" />
                                @csrf
                                <table style="width:100%">
                                    <tr>
                                        <td style="width:30%">
                                            <label for="valoresAnioMedicion">Ciclo de Medicion:<span
                                                    style="color: red">*</span></label>
                                        </td>
                                        <td style="width:35%">
                                            <select class="form-control" id="valoresAnioMedicion"
                                                name="valoresAnioMedicion">
                                                <option value="0">Seleccione...</option>
                                                @for ($x = 2016; $x <= 2022; $x++)
                                                    <option value="{{ $x }}">{{ $x }}</option>
                                                @endfor
                                            </select>
                                            <div class="invalid-feedback">
                                                Seleccione ciclo de Medición!
                                            </div>
                                        </td>
                                        <td style="width:35%">
                                            <select class="form-control" id="valoresCicloMedicion"
                                                name="valoresCicloMedicion">
                                                <option value="0">Seleccione...</option>
                                                @for ($x = 2016; $x <= 2022; $x++)
                                                    <option value="{{ $x }}">{{ $x }}</option>
                                                @endfor
                                            </select>
                                            <div class="invalid-feedback">
                                                Seleccione ciclo de Medición!
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%">
                                            <label for="valoresValor">Valor Histórico:<span
                                                    style="color: red">*</span></label>
                                        </td>
                                        <td colspan="2">
                                            <input type="text" class="form-control" id="valoresValor"
                                                placeholder="0.000" value="" style="text-align:right;"required
                                                name="valoresValor" />
                                            <div class="invalid-feedback">
                                                Indique un Valor Válido!
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%">
                                            <label for="valoresEstatus">Estatus del Dato:<span
                                                    style="color: red">*</span></label>
                                        </td>
                                        <td colspan="2">
                                            <select class="form-control" id="valoresEstatus" name="valoresEstatus">
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
                                            <label for="valoresObservaciones">Obsevaciones:</label>
                                        </td>
                                        <td colspan="2">
                                            <textarea type="text" class="form-control" id="valoresObservaciones" name="valoresObservaciones" placeholder=""
                                                value="" required></textarea>
                                            <div class="invalid-feedback">
                                                Elija un Estatus!
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="rellenaValor()">Rellenar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="addValor()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal-valorprogramado" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #681b2e; color:white">
                        <h5 class="modal-title">Agregar Programación de Meta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="color:white">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding:25px;">
                        <form id="formValorProgramado" action="{{ route('indicador.valores.addprogramado') }}">
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
                                                name="valoresAnioMedicionProgramado">
                                                <option value="0">Seleccione...</option>
                                                @for ($x = 2022; $x <= 2028; $x++)
                                                    <option value="{{ $x }}">{{ $x }}</option>
                                                @endfor
                                            </select>
                                            <div class="invalid-feedback">
                                                Seleccione ciclo de Medición!
                                            </div>
                                        </td>
                                        <td style="width:35%">
                                            <select class="form-control" id="valoresCicloMedicionProgramado"
                                                name="valoresCicloMedicionProgramado">
                                                <option value="0">Seleccione...</option>
                                                @for ($x = 2022; $x <= 2028; $x++)
                                                    <option value="{{ $x }}">{{ $x }}</option>
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
                                            <input type="text" class="form-control" id="valoresValorProgramado"
                                                placeholder="0.000" value="" style="text-align:right;"required
                                                name="valoresValorProgramado" />
                                            <div class="invalid-feedback">
                                                Indique un Valor Válido!
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%">
                                            <label for="valoresEstatusProgramado">Estatus del Dato:<span
                                                    style="color: red">*</span></label>
                                        </td>
                                        <td colspan="2">
                                            <select class="form-control" id="valoresEstatusProgramado"
                                                name="valoresEstatusProgramado">
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success"
                            onclick="rellenaValorProgramado()">Rellenar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="addValorProgramado()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal-variables" id="modal-variables" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true" style="z-index:1400">
            <div class="modal-dialog modal-xl">

                <div class="modal-content">
                    <div class="modal-header" style="background-color: #919090; color:white">
                        <h5 class="modal-title">Valores Históricos y Programación de Metas para la Variable: <span
                                id="modalVariableNombre"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="color:white">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="instrucciones" style="color:black;padding:20px;">
                        <b>Instrucciones: </b> Para agregar valores tanto de metas históricas y metas programadas,
                        identifique en el título de los apartados el ícono: <span
                            style="height:80px;background-color:#681b2e;"><i
                                class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i></span> que mostrará la opción
                        <b>"<i class="fas fa-plus" style="color: green"></i> Agregar Valor"</b>
                    </div>
                    <div class="modal-body" style="padding:25px;">
                        <input type="hidden" id="idVariable" />
                        <div class="row" id="variablehistoricosContent">
                            <div class="col-xl-12 col-lg-7">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                                        style="background-color: #681b2e;">
                                        <h6 class="m-0 font-weight-bold text-light">Valores Históricos de la Variable
                                        </h6>
                                        <div class="dropdown no-arrow">
                                            <a class="dropdown-toggle" href="#" role="button"
                                                id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                aria-labelledby="dropdownMenuLink">
                                                <div class="dropdown-header">Acciones:</div>
                                                <!--  <a class="dropdown-item" href="#">Another action</a>
                                                                                                                                                                                <div class="dropdown-divider"></div>-->
                                                <a class="dropdown-item" onclick="showModalVariableHistorico()"
                                                    style="cursor: pointer"><i class="fas fa-plus"
                                                        style="color:green;"></i>
                                                    Agregar Valor</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div id="emptyhistoricosvariable" style="display:none">
                                            <center>
                                                <h4>No existen valores históricos registrados!</h4>
                                            </center>
                                        </div>
                                        <table class="table table-striped table-bordered" id="tableVariableHistoricos"
                                            style="display:none">
                                            <thead>
                                                <tr style="background-color:#919090;color:white;">
                                                    <th style="width: 15%">Periodo de Medicion</th>
                                                    <th style="width: 15%">Fin del Periodo(ciclo)</th>
                                                    <th style="width: 15%">Valor Histórico</th>
                                                    <th style="width: 15%">Estatus del valor</th>
                                                    <th style="width: 30%">Observaciones</th>
                                                    <th style="width: 10%"></th>


                                                </tr>
                                            </thead>
                                            <tbody id="rowsvariablehistorico">
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="variableprogramadosContent">
                            <div class="col-xl-12 col-lg-7">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                                        style="background-color: #681b2e;">
                                        <h6 class="m-0 font-weight-bold text-light">Valores Programados de la Variable
                                        </h6>
                                        <div class="dropdown no-arrow">
                                            <a class="dropdown-toggle" href="#" role="button"
                                                id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                aria-labelledby="dropdownMenuLink">
                                                <div class="dropdown-header">Acciones:</div>
                                                <!--  <a class="dropdown-item" href="#">Another action</a>
                                                                                                                                                                                <div class="dropdown-divider"></div>-->
                                                <a class="dropdown-item" onclick="showModalVariableProgramado()"
                                                    style="cursor: pointer"><i class="fas fa-plus"
                                                        style="color:green;"></i>
                                                    Agregar Valor</a>
                                            </div>
                                        </div>
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
                                                    <th style="width: 15%">Periodo de Medicion</th>
                                                    <th style="width: 15%">Fin del Periodo(ciclo)</th>
                                                    <th style="width: 15%">Valor Programado</th>
                                                    <th style="width: 15%">Estatus del valor</th>
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
        <div class="modal fade modal-valorvariablehistorico" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true" style="z-index:1401" data-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #681b2e; color:white">
                        <h5 class="modal-title">Agregar Valores Históricos a la Variable</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="color:white">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding:25px;">
                        <form id="formValoresVariableHistorico" action="{{ route('variable.valores.addhistorico') }}">
                            <div class="row">
                                <input type="hidden" name="idValoresVariableHistorico"
                                    id="idValoresVariableHistorico" />
                                @csrf
                                <table style="width:100%">
                                    <tr>
                                        <td style="width:30%">
                                            <label for="valoresVariableAnioMedicionHistorico">Ciclo de Medicion:<span
                                                    style="color: red">*</span></label>
                                        </td>
                                        <td style="width:35%">
                                            <select class="form-control" id="valoresVariableAnioMedicionHistorico"
                                                name="valoresVariableAnioMedicionHistorico">
                                                <option value="0">Seleccione...</option>
                                                @for ($x = 2016; $x <= 2022; $x++)
                                                    <option value="{{ $x }}">{{ $x }}</option>
                                                @endfor
                                            </select>
                                            <div class="invalid-feedback">
                                                Seleccione ciclo de Medición!
                                            </div>
                                        </td>
                                        <td style="width:35%">
                                            <select class="form-control" id="valoresVariableCicloMedicionHistorico"
                                                name="valoresVariableCicloMedicionHistorico">
                                                <option value="0">Seleccione...</option>
                                                @for ($x = 2016; $x <= 2022; $x++)
                                                    <option value="{{ $x }}">{{ $x }}</option>
                                                @endfor
                                            </select>
                                            <div class="invalid-feedback">
                                                Seleccione ciclo de Medición!
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%">
                                            <label for="valoresValor">Valor Histórico:<span
                                                    style="color: red">*</span></label>
                                        </td>
                                        <td colspan="2">
                                            <input type="text" class="form-control" id="valoresVariableValorHistorico"
                                                placeholder="0.000" value="" style="text-align:right;"required
                                                name="valoresVariableValorHistorico" />
                                            <div class="invalid-feedback">
                                                Indique un Valor Válido!
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%">
                                            <label for="valoresVariableEstatusHistorico">Estatus del Dato:<span
                                                    style="color: red">*</span></label>
                                        </td>
                                        <td colspan="2">
                                            <select class="form-control" id="valoresVariableEstatusHistorico"
                                                name="valoresVariableEstatusHistorico">
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
                                            <label for="valoresVariableObservacionesHistorico">Obsevaciones:</label>
                                        </td>
                                        <td colspan="2">
                                            <textarea type="text" class="form-control" id="valoresVariableObservacionesHistorico"
                                                name="valoresVariableObservacionesHistorico" placeholder="" value="" required></textarea>
                                            <div class="invalid-feedback">
                                                Elija un Estatus!
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success"
                            onclick="rellenaValorVariableHistorico()">Rellenar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            onclick="$('.modal-variables').off('hide.bs.modal');">Cancelar</button>
                        <button type="button" class="btn btn-primary"
                            onclick="addValorVariableHistorico()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal-valorvariableprogramado" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true" style="z-index:1600">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #681b2e; color:white">
                        <h5 class="modal-title">Programar Metas de la Variable</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="color:white">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding:25px;">
                        <form id="formValoresVariableProgramado" action="{{ route('variable.valores.addprogramado') }}">
                            <div class="row">
                                <input type="hidden" name="idValoresVariableProgramado"
                                    id="idValoresVariableProgramado" />
                                @csrf
                                <table style="width:100%">
                                    <tr>
                                        <td style="width:30%">
                                            <label for="valoresVariableAnioMedicionProgramado">Ciclo de Medicion:<span
                                                    style="color: red">*</span></label>
                                        </td>
                                        <td style="width:35%">
                                            <select class="form-control" id="valoresVariableAnioMedicionProgramado"
                                                name="valoresVariableAnioMedicionProgramado">
                                                <option value="0">Seleccione...</option>
                                                @for ($x = 2022; $x <= 2028; $x++)
                                                    <option value="{{ $x }}">{{ $x }}</option>
                                                @endfor
                                            </select>
                                            <div class="invalid-feedback">
                                                Seleccione ciclo de Medición!
                                            </div>
                                        </td>
                                        <td style="width:35%">
                                            <select class="form-control" id="valoresVariableCicloMedicionProgramado"
                                                name="valoresVariableCicloMedicionProgramado">
                                                <option value="0">Seleccione...</option>
                                                @for ($x = 2022; $x <= 2028; $x++)
                                                    <option value="{{ $x }}">{{ $x }}</option>
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
                                            <input type="text" class="form-control" id="valoresVariableProgramado"
                                                placeholder="0.000" value="" style="text-align:right;"required
                                                name="valoresVariableProgramado" />
                                            <div class="invalid-feedback">
                                                Indique un Valor Válido!
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%">
                                            <label for="valoresVariableEstatusProgramado">Estatus del Dato:<span
                                                    style="color: red">*</span></label>
                                        </td>
                                        <td colspan="2">
                                            <select class="form-control" id="valoresVariableEstatusProgramado"
                                                name="valoresVariableEstatusProgramado">
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
                                            <label for="valoresVariableObservacionesProgramado">Obsevaciones:</label>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success"
                            onclick="rellenaValorVariableProgramado()">Rellenar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary"
                            onclick="addValorVariableProgramado()">Guardar</button>
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


            $('.modal-valorvariablehistorico')
                .on('hidden.bs.modal', function(e) {
                    $(".modal-variables").modal("show");
                });

            $('.modal-valorvariablehistorico')
                .on('show.bs.modal', function(e) {
                    $(".modal-variables").modal("hide");
                });
            $('.modal-valorvariableprogramado')
                .on('hidden.bs.modal', function(e) {
                    $(".modal-variables").modal("show");
                });
            $('.modal-valorvariableprogramado')
                .on('show.bs.modal', function(e) {
                    $(".modal-variables").modal("hide");
                });
            $("#collapseTwo").addClass("show");
            $("#menuIndicadores").addClass("active");
            $("#optindicadorprogramacion").css('background-color',"rgb(217, 217, 217)"); 

        });


        function setDataIndicador() {
            seleccionado = $("#indicador option:selected").val();
            textseleccionado = $("#indicador option:selected").text();
            if (seleccionado > 0) {
                $("#indicadorSeleccion").hide("slow");
                $("#indicadorTitle").show("slow");
                $("#indicadorSelected").html(textseleccionado);
                $("#historicosContent").show("slow");
                $("#programacionContent").show("slow");
                $("#variablesContent").show("slow");
                $("#idIndicador").val(seleccionado);
                getValoresHistoricos(seleccionado);
                getValoresProgramados(seleccionado);
                getVariables(seleccionado);
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

        function showModal() {
            $("#idValoresIndicador").val("");
            $("#valoresAnioMedicion").val(0);
            $("#valoresCicloMedicion").val(0);
            $("#valoresValor").val("");
            $("#valoresEstatus").val(0);
            $("#valoresObservaciones").val("");
            $(".modal-valorhistorico").modal("show");

        }

        function addValor() {
            if (validaValorHistorico()) {
                idIndicador = $("#idIndicador").val();                                               
                $(".modal-valorhistorico").modal("hide");
                valoresAnioMedicion = $("#valoresAnioMedicion").val();
                valoresCicloMedicion = $("#valoresCicloMedicion").val();
                valoresValor = $("#valoresValor").val();
                valoresEstatus = $("#valoresEstatus").val();
                valoresObservaciones = $("#valoresObservaciones").val();
                var data = $("#valoresIndicador").serialize();
                data += "&idIndicador=" + idIndicador;

                $.ajax({
                    type: 'POST',
                    url: $("#valoresIndicador").attr('action'),
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
                            title: 'Valor Histórico del Indicador Guardado Satifactoriamente!',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                            //window.location.replace("{{ route('indicador.list') }}");
                        });
                        if ($("#idValoresIndicador").val().length > 0) {
                            getValoresHistoricos(idIndicador);
                        } else {
                            row = '<tr class="rowhistorico" id="rowhistorico' + response.id + '">' +
                                '<td class="text-center valoresAnioMedicion">' + valoresAnioMedicion + '</td>' +
                                '<td class="text-center valoresCicloMedicion">' + valoresCicloMedicion + '</td>' +
                                '<td class="text-right valoresValor">' + valoresValor + '</td>' +
                                '<td class="text-center valoresEstatus">' + valoresEstatus + '</td>' +
                                '<td class="valoresObservaciones">' + valoresObservaciones + '</td>' +
                                '<td class="text-center">' +
                                '<button class="btn btn-sm btn-info" title="Editar Valor" onclick="setDataValor(' +
                                response.id + ')"><i class="fas fa-edit"></i></button> &nbsp;' +
                                '<button class="btn btn-sm btn-danger" onclick="deleteValor(' + response.id +
                                ')" title="Eliminar Registro"><i class="fas fa-trash"></i></button>' +
                                '</td>' +
                                '</tr>';
                            $("#rowshistorico").append(row);
                            $("#tableHistoricos").show("slow");
                            $("#emptyhistoricos").hide("");
                        }                        
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Ocurrió un error al intentar guardar el valor, intente más tarde',
                            text: '',
                            confirmButtonColor: '#3085d6',
                        })
                    }
                }).fail(function(data) {
                    block(false);
                })
            }
        }

        function validaValorHistorico() {
            inputs = [
                "valoresValor"
            ];
            selects = [
                "valoresAnioMedicion",
                "valoresCicloMedicion",
                "valoresEstatus"
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

        function rellenaValor() {
            $("#valoresAnioMedicion").val("2020");
            $("#valoresCicloMedicion").val("2021");
            $("#valoresValor").val("1.1234");
            $("#valoresEstatus").val("no_disponible");
            $("#valoresObservaciones").val("Osservaciones Puntuales");
        }

        function getValoresHistoricos(idIndicador) {
            $(".rowhistorico").remove();
            $.ajax({
                type: 'GET',
                url: "{{ route('indicador.valores.gethistoricos') }}",
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
                    if (response.historicos.length > 0) {
                        for (x = 0; x < response.historicos.length; x++) {
                            row = '<tr class="rowhistorico" id="rowhistorico' + response.historicos[x]
                                .idValoresIndicador + '">' +
                                '<td class="text-center valoresAnioMedicion">' + response.historicos[x]
                                .valoresAnioMedicion + '</td>' +
                                '<td class="text-center valoresCicloMedicion">' + response.historicos[x]
                                .valoresCicloMedicion + '</td>' +
                                '<td class="text-right valoresValor">' + response.historicos[x].valoresValor +
                                '</td>' +
                                '<td class="text-center valoresEstatus">' + response.historicos[x].valoresEstatus +
                                '</td>' +
                                '<td class="valoresObservaciones">' + response.historicos[x].valoresObservaciones +
                                '</td>' +
                                '<td class="text-center">' +
                                '<button class="btn btn-sm btn-info" title="Editar Valor" onclick="setDataValor(' +
                                response.historicos[x].idValoresIndicador +
                                ')"><i class="fas fa-edit"></i></button> &nbsp;' +
                                '<button class="btn btn-sm btn-danger" onclick="deleteValor(' + response.historicos[
                                    x].idValoresIndicador +
                                ')" title="Eliminar Registro"><i class="fas fa-trash"></i></button>' +
                                '</td>' +
                                '</tr>';
                            $("#rowshistorico").append(row);
                        }
                        $("#emptyhistoricos").hide("slow");
                        $("#tableHistoricos").show("slow");
                    } else {
                        $("#tableHistoricos").hide("slow");
                        $("#emptyhistoricos").show("");
                    }
                } else {

                }
            }).fail(function(data) {
                block(false);
            })
        }

        function setDataValor(idValoresId) {

            valoresAnioMedicion = $("#rowhistorico" + idValoresId).find(".valoresAnioMedicion").html();
            valoresCicloMedicion = $("#rowhistorico" + idValoresId).find(".valoresCicloMedicion").html();
            valoresValor = $("#rowhistorico" + idValoresId).find(".valoresValor").html();
            valoresEstatus = $("#rowhistorico" + idValoresId).find(".valoresEstatus").html();
            valoresObservaciones = $("#rowhistorico" + idValoresId).find(".valoresObservaciones").html();
            $("#idValoresIndicador").val(idValoresId);
            $("#valoresAnioMedicion").val(valoresAnioMedicion);
            $("#valoresCicloMedicion").val(valoresCicloMedicion);
            $("#valoresValor").val(valoresValor);
            $("#valoresEstatus").val("" + valoresEstatus + "");
            $("#valoresObservaciones").val(valoresObservaciones);
            $(".modal-valorhistorico").modal("show");
        }

        function deleteValor(idValoresIndicador) {
            Swal.fire({
                title: '¿Está Seguro?',
                text: "La información del valor histórico no estará disponible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('indicador.valoreshistoricos.delete') }}",
                        data: {
                            idValoresIndicador: idValoresIndicador,
                            _token: $("input[name='_token']").val()
                        },
                        beforeSend: function() {
                            block(true)
                        },
                        success: function(response) {
                            if (response.success = "ok") {
                                getValoresHistoricos($("#idIndicador").val());
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Valor histórico ',
                                    text: response.message,
                                    confirmButtonColor: '#3085d6',
                                }).then((result) => {});
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Ocurrió un error al intentar dar de baja el valor Histótrico',
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

        function rellenaValorProgramado() {
            $("#valoresAnioMedicionProgramado").val("2022");
            $("#valoresCicloMedicionProgramado").val("2023");
            $("#valoresValorProgramado").val("1.1234");
            $("#valoresEstatusProgramado").val("no_disponible");
            $("#valoresObservacionesProgramado").val("Observaciones Puntuales");
        }

        function addValorProgramado() {
            if (validaValorProgramado()) {
                idIndicador = $("#idIndicador").val();
                
                $(".modal-valorprogramado").modal("hide");
                valoresAnioMedicionProgramado = $("#valoresAnioMedicionProgramado").val();
                valoresCicloMedicionProgramado = $("#valoresCicloMedicionProgramado").val();
                valoresValorProgramado = $("#valoresValorProgramado").val();
                valoresEstatusProgramado = $("#valoresEstatusProgramado").val();
                valoresObservacionesProgramado = $("#valoresObservacionesProgramado").val();
                var data = $("#formValorProgramado").serialize();
                data += "&idIndicador=" + idIndicador;

                $.ajax({
                    type: 'POST',
                    url: $("#formValorProgramado").attr('action'),
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
                            title: 'Valor Programado del Indicador se ha Guardado Satifactoriamente!',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                            //window.location.replace("{{ route('indicador.list') }}");
                        });
                        if ($("#idValoresIndicadorProgramado").val().length > 0) {
                            getValoresProgramados(idIndicador);
                        } else {
                            row = '<tr class="rowprogramado" id="rowprogramado' + response.id + '">' +
                                '<td class="text-center valoresAnioMedicionProgramado">' +
                                valoresAnioMedicionProgramado + '</td>' +
                                '<td class="text-center valoresCicloMedicionProgramado">' +
                                valoresCicloMedicionProgramado + '</td>' +
                                '<td class="text-right valoresValorProgramado">' + valoresValorProgramado +
                                '</td>' +
                                '<td class="text-center valoresEstatusProgramado">' + valoresEstatusProgramado +
                                '</td>' +
                                '<td class="valoresObservacionesProgramado">' + valoresObservacionesProgramado +
                                '</td>' +
                                '<td class="text-center">' +
                                '<button class="btn btn-sm btn-info" title="Editar Valor" onclick="setDataValorProgramado(' +
                                response.id + ')"><i class="fas fa-edit"></i></button> &nbsp;' +
                                '<button class="btn btn-sm btn-danger" onclick="deleteValorProgramado(' + response
                                .id +
                                ')" title="Eliminar Registro"><i class="fas fa-trash"></i></button>' +
                                '</td>' +
                                '</tr>';
                            $("#rowsprogramados").append(row);
                            $("#tableProgramados").show("slow");
                            $("#emptyprogramados").hide();
                        }
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Ocurrió un error al intentar guardar el valor programado, intente más tarde',
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
                "valoresValorProgramado"
            ];
            selects = [
                "valoresAnioMedicionProgramado",
                "valoresCicloMedicionProgramado",
                "valoresEstatusProgramado"
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
                                '<td class="valoresObservacionesProgramado">' + response.programados[x]
                                .valoresObservaciones +
                                '</td>' +
                                '<td class="text-center">' +
                                '<button class="btn btn-sm btn-info" title="Editar Valor" onclick="setDataValorProgramado(' +
                                response.programados[x].idValoresIndicador +
                                ')"><i class="fas fa-edit"></i></button> &nbsp;' +
                                '<button class="btn btn-sm btn-danger" onclick="deleteValorProgramado(' + response
                                .programados[
                                    x].idValoresIndicador +
                                ')" title="Eliminar Registro"><i class="fas fa-trash"></i></button>' +
                                '</td>' +
                                '</tr>';
                            $("#rowsprogramados").append(row);
                        }
                        $("#emptyprogramados").hide("");
                        $("#tableProgramados").show("slow");
                    }else{
                        $("#tableProgramados").hide("slow");
                        $("#emptyprogramados").show("");
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
            valoresObservacionesProgramado = $("#rowprogramado" + idValoresId).find(".valoresObservacionesProgramado")
                .html();
            $("#idValoresIndicadorProgramado").val(idValoresId);
            $("#valoresAnioMedicionProgramado").val(valoresAnioMedicionProgramado);
            $("#valoresCicloMedicionProgramado").val(valoresCicloMedicionProgramado);
            $("#valoresValorProgramado").val(valoresValorProgramado);
            $("#valoresEstatusProgramado").val("" + valoresEstatusProgramado + "");
            $("#valoresObservacionesProgramado").val(valoresObservacionesProgramado);
            $(".modal-valorprogramado").modal("show");
        }

        function deleteValorProgramado(idValoresIndicador) {
            Swal.fire({
                title: '¿Está Seguro?',
                text: "La información del valor programado no estará disponible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('indicador.valoresprogramados.delete') }}",
                        data: {
                            idValoresIndicador: idValoresIndicador,
                            _token: $("input[name='_token']").val()
                        },
                        beforeSend: function() {
                            block(true)
                        },
                        success: function(response) {
                            if (response.success = "ok") {
                                getValoresProgramados($("#idIndicador").val());
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Valor Programado ',
                                    text: response.message,
                                    confirmButtonColor: '#3085d6',
                                }).then((result) => {});
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Ocurrió un error al intentar dar de baja el valor Programado',
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
                                '<button class="btn btn-primary" onclick="showModalVariables(\'' + response
                                .variables[x].variableNombre + '\',' + response.variables[x].idVariable +
                                ')"><i class="fas fa-calendar"></i> Programación de Metas</button> ' +
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
            getValoresVariableHistoricos(idVariable);
            getValoresVariableProgramados(idVariable);

        }

        function showModalVariableHistorico() {
            $("#idValoresVariableHistorico").val("");
            $("#valoresVariableAnioMedicionHistorico").val(0);
            $("#valoresVariableCicloMedicionHistorico").val(0);
            $("#valoresVariableValorHistorico").val("");
            $("#valoresVariableEstatusHistorico").val(0);
            $("#valoresVariableObservacionesHistorico").val("");
            $(".modal-valorvariablehistorico").modal("show");
        }

        function rellenaValorVariableHistorico() {
            $("#valoresVariableAnioMedicionHistorico").val("2020");
            $("#valoresVariableCicloMedicionHistorico").val("2021");
            $("#valoresVariableValorHistorico").val("1.1234");
            $("#valoresVariableEstatusHistorico").val("no_disponible");
            $("#valoresVariableObservacionesHistorico").val("Observaciones Puntuales");
        }

        function addValorVariableHistorico() {
            if (validaVariableValorHistorico()) {
                idVariable = $("#idVariable").val();
                
                $(".modal-valorvariablehistorico").modal("hide");
                valoresAnioMedicion = $("#valoresVariableAnioMedicionHistorico").val();
                valoresCicloMedicion = $("#valoresVariableCicloMedicionHistorico").val();
                valoresValor = $("#valoresVariableValorHistorico").val();
                valoresEstatus = $("#valoresVariableEstatusHistorico").val();
                valoresObservaciones = $("#valoresVariableObservacionesHistorico").val();
                var data = $("#formValoresVariableHistorico").serialize();
                data += "&idVariable=" + idVariable;

                $.ajax({
                    type: 'POST',
                    url: $("#formValoresVariableHistorico").attr('action'),
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
                            title: 'Valor Histórico de la Variable se ha Guardado Satifactoriamente!',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                            //window.location.replace("{{ route('indicador.list') }}");
                        });
                        if ($("#idValoresVariableHistorico").val().length > 0) {
                            getValoresVariableHistoricos(idVariable);
                        } else {
                            row = '<tr class="rowvariablehistorico" id="rowvariablehistorico' + response.id + '">' +
                                '<td class="text-center valoresVariableAnioMedicionHistorico">' +
                                valoresAnioMedicion + '</td>' +
                                '<td class="text-center valoresVariableCicloMedicionHistorico">' +
                                valoresCicloMedicion + '</td>' +
                                '<td class="text-right valoresVariableValorHistorico">' + valoresValor + '</td>' +
                                '<td class="text-center valoresVariableEstatusHistorico">' + valoresEstatus +
                                '</td>' +
                                '<td class="valoresVariableObservacionesHistorico">' + valoresObservaciones +
                                '</td>' +
                                '<td class="text-center">' +
                                '<button class="btn btn-sm btn-info" title="Editar Valor" onclick="setDataValorVariableHistorico(' +
                                response.id + ')"><i class="fas fa-edit"></i></button> &nbsp;' +
                                '<button class="btn btn-sm btn-danger" onclick="deleteValorVariableHistorico(' +
                                response.id +
                                ')" title="Eliminar Registro"><i class="fas fa-trash"></i></button>' +
                                '</td>' +
                                '</tr>';
                            $("#rowsvariablehistorico").append(row);
                            $("#tableVariableHistoricos").show("slow");
                            $("#emptyhistoricosvariable").hide("");
                        }
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Ocurrió un error al intentar guardar el valor, intente más tarde',
                            text: '',
                            confirmButtonColor: '#3085d6',
                        })
                    }
                }).fail(function(data) {
                    block(false);
                })
            }
        }

        function validaVariableValorHistorico() {
            inputs = [
                "valoresVariableValorHistorico"
            ];
            selects = [
                "valoresVariableAnioMedicionHistorico",
                "valoresVariableCicloMedicionHistorico",
                "valoresVariableEstatusHistorico"
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

        function getValoresVariableHistoricos(idVariable) {
            $(".rowvariablehistorico").remove();
            $.ajax({
                type: 'GET',
                url: "{{ route('variable.valores.historicos') }}",
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
                    if (response.historicos.length > 0) {
                        for (x = 0; x < response.historicos.length; x++) {
                            row = '<tr class="rowvariablehistorico" id="rowvariablehistorico' + response.historicos[
                                    x]
                                .idValores + '">' +
                                '<td class="text-center valoresVariableAnioMedicionHistorico">' + response
                                .historicos[x]
                                .valoresAnioMedicion + '</td>' +
                                '<td class="text-center valoresVariableCicloMedicionHistorico">' + response
                                .historicos[x]
                                .valoresCicloMedicion + '</td>' +
                                '<td class="text-right valoresVariableValorHistorico">' + response.historicos[x]
                                .valoresHistorico +
                                '</td>' +
                                '<td class="text-center valoresVariableEstatusHistorico">' + response.historicos[x]
                                .valoresEstatus +
                                '</td>' +
                                '<td class="valoresVariableObservacionesHistorico">' + response.historicos[x]
                                .valoresObservaciones +
                                '</td>' +
                                '<td class="text-center">' +
                                '<button class="btn btn-sm btn-info" title="Editar Valor" onclick="setDataValorVariableHistorico(' +
                                response.historicos[x].idValores +
                                ')"><i class="fas fa-edit"></i></button> &nbsp;' +
                                '<button class="btn btn-sm btn-danger" onclick="deleteValorVariableHistorico(' +
                                response
                                .historicos[
                                    x].idValores +
                                ')" title="Eliminar Registro"><i class="fas fa-trash"></i></button>' +
                                '</td>' +
                                '</tr>';
                            $("#rowsvariablehistorico").append(row);
                        }
                        $("#emptyhistoricosvariable").hide();
                        $("#tableVariableHistoricos").show("slow");
                    }else{
                        $("#tableVariableHistoricos").hide("slow");
                        $("#emptyhistoricosvariable").show();
                    }
                } else {}
            }).fail(function(data) {
                block(false);
            })
        }

        function setDataValorVariableHistorico(idValoresId) {

            valoresVariableAnioMedicionHistorico = $("#rowvariablehistorico" + idValoresId).find(
                ".valoresVariableAnioMedicionHistorico").html();
            valoresVariableCicloMedicionHistorico = $("#rowvariablehistorico" + idValoresId).find(
                    ".valoresVariableCicloMedicionHistorico")
                .html();
            valoresVariableValorHistorico = $("#rowvariablehistorico" + idValoresId).find(".valoresVariableValorHistorico")
                .html();
            valoresVariableEstatusHistorico = $("#rowvariablehistorico" + idValoresId).find(
                ".valoresVariableEstatusHistorico").html();
            valoresVariableObservacionesHistorico = $("#rowvariablehistorico" + idValoresId).find(
                    ".valoresVariableObservacionesHistorico")
                .html();
            $("#idValoresVariableHistorico").val(idValoresId);
            $("#valoresVariableAnioMedicionHistorico").val(valoresVariableAnioMedicionHistorico);
            $("#valoresVariableCicloMedicionHistorico").val(valoresVariableCicloMedicionHistorico);
            $("#valoresVariableValorHistorico").val(valoresVariableValorHistorico);
            $("#valoresVariableEstatusHistorico").val("" + valoresVariableEstatusHistorico + "");
            $("#valoresVariableObservacionesHistorico").val(valoresVariableObservacionesHistorico);
            $(".modal-valorvariablehistorico").modal("show");
        }

        function deleteValorVariableHistorico(idValoresVariableHistorico) {
            Swal.fire({
                title: '¿Está Seguro?',
                text: "La información del valor histórico no estará disponible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('variable.valoreshistoricos.delete') }}",
                        data: {
                            idValoresVariableHistorico: idValoresVariableHistorico,
                            _token: $("input[name='_token']").val()
                        },
                        beforeSend: function() {
                            block(true)
                        },
                        success: function(response) {
                            if (response.success = "ok") {
                                getValoresVariableHistoricos($("#idVariable").val());
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Valor Historico ',
                                    text: response.message,
                                    confirmButtonColor: '#3085d6',
                                }).then((result) => {});
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Ocurrió un error al intentar dar de baja el valor Histórico',
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
    <!--Scripts para Variables Programados-->
    <script>
        function showModalVariableProgramado() {
            $("#idValoresVariableProgramado").val("");
            $("#valoresVariableAnioMedicionProgramado").val(0);
            $("#valoresVariableCicloMedicionProgramado").val(0);
            $("#valoresVariableProgramado").val("");
            $("#valoresVariableEstatusProgramado").val(0);
            $("#valoresVariableObservacionesProgramado").val("");
            $(".modal-valorvariableprogramado").modal("show");
        }

        function rellenaValorVariableProgramado() {
            $("#valoresVariableAnioMedicionProgramado").val("2022");
            $("#valoresVariableCicloMedicionProgramado").val("2023");
            $("#valoresVariableProgramado").val("1.1234");
            $("#valoresVariableEstatusProgramado").val("no_disponible");
            $("#valoresVariableObservacionesProgramado").val("Observaciones Puntuales");
        }

        function addValorVariableProgramado() {
            if (validaVariableValorProgramado()) {
                idVariable = $("#idVariable").val();
                
                $(".modal-valorvariableprogramado").modal("hide");
                valoresAnioMedicion = $("#valoresVariableAnioMedicionProgramado").val();
                valoresCicloMedicion = $("#valoresVariableCicloMedicionProgramado").val();
                valoresValor = $("#valoresVariableProgramado").val();
                valoresEstatus = $("#valoresVariableEstatusProgramado").val();
                valoresObservaciones = $("#valoresVariableObservacionesProgramado").val();
                var data = $("#formValoresVariableProgramado").serialize();
                data += "&idVariable=" + idVariable;

                $.ajax({
                    type: 'POST',
                    url: $("#formValoresVariableProgramado").attr('action'),
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
                            $("#tableVariableProgramados").show("slow");
                            $("#emptyprogramadosvariable").hide();
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
                "valoresVariableProgramado"
            ];
            selects = [
                "valoresVariableAnioMedicionProgramado",
                "valoresVariableCicloMedicionProgramado",
                "valoresVariableEstatusProgramado"
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
                                '<td class="valoresVariableObservacionesProgramado">' + response.programados[x]
                                .valoresObservaciones +
                                '</td>' +
                                '<td class="text-center">' +
                                '<button class="btn btn-sm btn-info" title="Editar Valor" onclick="setDataValorVariableProgramado(' +
                                response.programados[x].idValores +
                                ')"><i class="fas fa-edit"></i></button> &nbsp;' +
                                '<button class="btn btn-sm btn-danger" onclick="deleteValorVariableProgramado(' +
                                response
                                .programados[
                                    x].idValores +
                                ')" title="Eliminar Registro"><i class="fas fa-trash"></i></button>' +
                                '</td>' +
                                '</tr>';
                            $("#rowsvariableprogramado").append(row);
                        }
                        $("#tableVariableProgramados").show("slow");
                        $("#emptyprogramadosvariable").hide();
                    }else{
                        $("#emptyprogramadosvariable").show();
                        $("#tableVariableProgramados").hide("slow");
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
                    ".valoresVariableCicloMedicionProgramado")
                .html();
            valoresVariableProgramado = $("#rowvariableprogramado" + idValoresId).find(".valoresVariableProgramado")
                .html();
            valoresVariableEstatusProgramado = $("#rowvariableprogramado" + idValoresId).find(
                ".valoresVariableEstatusProgramado").html();
            valoresVariableObservacionesProgramado = $("#rowvariableprogramado" + idValoresId).find(
                    ".valoresVariableObservacionesProgramado")
                .html();
            $("#idValoresVariableProgramado").val(idValoresId);
            $("#valoresVariableAnioMedicionProgramado").val(valoresVariableAnioMedicionProgramado);
            $("#valoresVariableCicloMedicionProgramado").val(valoresVariableCicloMedicionProgramado);
            $("#valoresVariableProgramado").val(valoresVariableProgramado);
            $("#valoresVariableEstatusProgramado").val("" + valoresVariableEstatusProgramado + "");
            $("#valoresVariableObservacionesProgramado").val(valoresVariableObservacionesProgramado);
            $(".modal-valorvariableprogramado").modal("show");
        }

        function deleteValorVariableProgramado(idValoresVariableProgramado) {
            Swal.fire({
                title: '¿Está Seguro?',
                text: "La información de la meta no estará disponible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('variable.valoresprogramados.delete') }}",
                        data: {
                            idValoresVariableProgramado: idValoresVariableProgramado,
                            _token: $("input[name='_token']").val()
                        },
                        beforeSend: function() {
                            block(true)
                        },
                        success: function(response) {
                            if (response.success = "ok") {
                                getValoresVariableProgramados($("#idVariable").val());
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Meta Programada ',
                                    text: response.message,
                                    confirmButtonColor: '#3085d6',
                                }).then((result) => {});
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Ocurrió un error al intentar dar de baja la meta',
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
@endsection
