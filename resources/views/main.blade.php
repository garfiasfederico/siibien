@extends('layouts.administrador')

@section('encabezado')
    <!--Heading-->
    <h5 class="h3 mb-0 text-gray-800">Bienvenido {{ session('enlace') }} </h5>

    <!--<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                                        class="fas fa-download fa-sm text-white-50"></i> Generar Listado</a>                    -->
@endsection

@section('content')
    <!-- Content Row -->
    <div class="text-center">
        <img  style="width:300px;opacity:.20" src="{{asset('images/col_gabinete.svg')}}" alt="">
        <h1>Sistema para el Seguimiento Integral de Indicadores del Bienestar</h1>
        <h1>SIIBien</h1>
    </div>
    <div class="row">


       <!-- <div class="col-lg-12 mb-4">

            <div class="card shadow mb-4">
                <div class="card-header py-3" style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-light">Indicadores Estratégicos Registrados
                        {{ count($indicadores) }}
                    </h6>
                </div>
                <div class="card-body">
                    <center style="padding: 30px;">
                        @if (!count($indicadores) > 0)
                            <h2>No existen Indicadores Registrados !</h2>
                            <a href="{{ route('indicador') }}"><button class="btn btn-primary">Registrar Nuevo
                                    Indicador</button></a>
                        @else
                            <table class="table striped">
                                <thead>
                                    <tr>
                                        <th style="background-color: #919090;color:white">Nombre</th>
                                        <th style="background-color: #919090;color:white">Tipo</th>
                                        <th style="background-color: #919090;color:white">Responsable</th>
                                        <th style="background-color: #919090;color:white">Sentido</th>
                                        <th style="background-color: #919090;color:white">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($indicadores as $indicador)
                                        <tr>
                                            <td>{{ $indicador->indicadorNombre }}</td>
                                            <td>{{ $indicador->indicadorTipo }}</td>
                                            <td>{{ $indicador->dependenciaSiglas }}</td>
                                            <td>{{ $indicador->indicadorSentido }}</td>
                                            <td>
                                                @if ($indicador->editar)
                                                    <a
                                                        href="{{ route('indicador.edit', ['id' => $indicador->idIndicador]) }}"><button
                                                            class="btn btn-sm btn-info"><i
                                                                class="fas fa-edit"></i></button></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </center>
                </div>-->

                <!--<div class="card-body">
                                                        <canvas id="myPieChart">
                                                        </canvas>
                                                    </div>-->
            </div>
        </div>
        <!--<div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Indicadores de Gestión Registrados</h6>
                    </div>
                    <div class="card-body">
                        <center style="padding: 30px;height:200px;overflow:auto;">
                            <h2>No existen Productos Registrados!</h2>
                            <a href="#"><button class="btn btn-primary">Registrar Nuevo
                                    Producto</button></a>
                        </center>
                    </div>
                </div>
            </div>-->
    </div>
    <!-- <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Proyectos Estratégicos</h6>
                    </div>
                    <div class="card-body">
                        <center style="padding: 30px;height:200px;overflow:auto;">
                            <h2>No existen Proyectos Registrados!</h2>
                            <a href="#"><button class="btn btn-primary">Registrar Nuevo
                                    Proyecto</button></a>
                        </center>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Cumplimiento</h6>
                    </div>
                    <div class="card-body">
                        <center style="padding: 30px;height:200px;overflow:auto;">
                            <canvas id="myPieChart"></canvas>
                        </center>
                    </div>
                </div>
            </div>
        </div>-->
@endsection
@section('scripts')
    <!--<script src="{{ asset('resources/js/demo/chart-pie-demo.js') }}"></script>-->
@endsection
