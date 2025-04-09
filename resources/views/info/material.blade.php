@extends('layouts.administrador')

@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">Material de Apoyo</h1>
@endsection

@section('content')
    <div class="col-lg-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="background-color: #681b2e;">
                <h6 class="m-0 font-weight-bold text-light">Documentos descargables</h6>
            </div>
            <div class="card-body">
                <center >
                    <div style="width:50%;border-radius:15px">
                        <table style="width: 100%;text-align:center" class="table striped">
                            <thead style="background-color: gray;color:white">
                                <tr>
                                    <th>No.</th>
                                    <th>Documento</th>
                                    <th>Descarga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td style="text-align: left">Manual de Usuario SIIBIEN V1.0</td>
                                    <td><a href="{{route('manual')}}"><button class="btn btn-warning">PDF</button></a></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td style="text-align: left">Herramienta para la Proyección de metas</td>
                                    <td><a href="{{route('hproyeccion')}}"><button class="btn btn-success">Excel</button></a></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td style="text-align: left">Video Inducción del Módulo de Informe</td>
                                    <td><a href="{{route('video')}}"><button class="btn btn-dark">Visualizar</button></a></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td style="text-align: left">Presentación de indicadores 2025</td>
                                    <td><a href="{{route('presentacioni')}}"><button class="btn btn-success">Descargar</button></a></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td style="text-align: left">Presentación de Informe Trimestral de Avances y Resultados (ITAR) 2025</td>
                                    <td><a href="{{route('presentacionitar')}}"><button class="btn btn-success">Descargar</button></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </center>
            </div>
        </div>
    </div>
@endsection
