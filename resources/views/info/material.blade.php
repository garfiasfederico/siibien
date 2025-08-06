@extends('layouts.administrador')

@section('encabezado')
    <h1 class="h3 mb-0 text-gray-800">Material de Apoyo</h1>
@endsection

@section('content')
    <div class="col-lg-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="background-color: #681b2e;">
                <h6 class="m-0 font-weight-bold text-light">Documentos descargables</h6>
            </div>
            <div class="card-body">
                <center>
                    <div style="width:50%;border-radius:15px">

                        <!-- Sección 1: Material General -->
                        <button class="btn btn-secondary btn-block mb-2" type="button" data-toggle="collapse"
                            data-target="#materialGeneral">
                            Material General
                        </button>
                        <div class="collapse" id="materialGeneral">
                            <table class="table striped text-center">
                                <thead style="background-color: gray; color: white;">
                                    <tr>
                                        <th>No.</th>
                                        <th>Documento</th>
                                        <th>Descarga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td style="text-align: left">Manual de Usuario SIIBIEN (módulo de Indicadores
                                            Estratégicos)</td>
                                        <td><a href="{{ route('manual') }}"><button class="btn btn-warning">PDF</button></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td style="text-align: left">Manual de Usuario SIIBIEN (módulo de Informe Trimestral
                                            de Avances y Resultados (ITAR))</td>
                                        <td><a href="{{ route('manualitar') }}"><button
                                                    class="btn btn-warning">PDF</button></a></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td style="text-align: left">Herramienta para la Proyección de metas</td>
                                        <td><a href="{{ route('hproyeccion') }}"><button
                                                    class="btn btn-success">Excel</button></a></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td style="text-align: left">Video Inducción del Módulo de Informe</td>
                                        <td><a href="{{ route('video') }}"><button
                                                    class="btn btn-dark">Visualizar</button></a></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td style="text-align: left">Presentación de indicadores 2025</td>
                                        <td><a href="{{ route('presentacioni') }}"><button
                                                    class="btn btn-success">Descargar</button></a></td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td style="text-align: left">Presentación ITAR 2025</td>
                                        <td><a href="{{ route('presentacionitar') }}"><button
                                                    class="btn btn-success">Descargar</button></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Sección 2: 3er Informe de Gobierno -->
                        <button class="btn btn-secondary btn-block mt-4 mb-2" type="button" data-toggle="collapse"
                            data-target="#materialInforme">
                            Material 3er Informe de Gobierno
                        </button>
                        <div class="collapse" id="materialInforme">
                            <table class="table striped text-center">
                                <thead style="background-color: gray; color: white;">
                                    <tr>
                                        <th>No.</th>
                                        <th>Documento</th>
                                        <th>Descarga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td style="text-align: left"> Lineamientos Generales para la Integración del Informe
                                            de Gobierno</td>
                                        <td><a href="{{ route('lineamientosGenerales') }}"><button
                                                    class="btn btn-warning">PDF</button></a></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td style="text-align: left"> Proceso de Integración del 3er Informe</td>
                                        <td><a href="{{ route('proceso-3er-informe') }}"><button
                                                    class="btn btn-warning">PDF</button></a></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td style="text-align: left"> Alineación con el Plan Estatal de Desarrollo 2022-2028
                                        </td>
                                        <td><a href="{{ route('alineación-PED-Informe') }}"><button
                                                    class="btn btn-warning">PDF</button></a></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td style="text-align: left"> ⁠Inversión Pública (Aspectos importantes a considerar)
                                        </td>
                                        <td><a href="{{ route('informe-inversion-publica') }}"><button
                                                    class="btn btn-warning">PDF</button></a></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td style="text-align: left"> Manual de usuario del módulo del informe
                                        </td>
                                        <td><a href="{{ route('manual-modulo-informe') }}"><button
                                                    class="btn btn-warning">PDF</button></a></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </center>
            </div>
        </div>
    </div>
@endsection
