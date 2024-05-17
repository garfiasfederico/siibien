@extends('layouts.administrador')
@section('encabezado')
    ITAR / Listado de PPAs
@endsection
@section('content')
    <div class="row">
        @csrf
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex align-items-center justify-content-between"
                    style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">PPAs Registrados</h6>
                    <div class="dropdown no-arrow">
                        <!--<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                aria-labelledby="dropdownMenuLink">
                                                <div class="dropdown-header">Acciones:</div>
                                                <a class="dropdown-item" href="{{ route('indicador') }}" style="cursor: pointer"><i
                                                        class="fas fa-plus" style="color:green;"></i> Nuevo Indicador</a>
                                            </div>-->
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body" id="indicadorContent">
                    @if (count($ppas) > 0)
                       <!-- <div align="left" class="d-flex bg-gray-100 p-2 y-3 justify-content-between pl-4">
                            <form action="{{ route('ppa.oficializar') }}" method="GET" target="_blank" class="flex d-flex"
                                id="oficializacion">
                                Periodo a Oficializar:<select class="form-control" style="width:100%;" name="periodo"
                                    id="periodop">
                                    <option value="">---Seleccione</option>
                                    <option value="42023">Octubre-Diciembre 2023</option>
                                    <option value="12024">Enero-Marzo 2024</option>
                                </select>
                                &nbsp;&nbsp;
                                <button type="button" onclick="printOficializacion()" class="btn btn-success"><i
                                        class="fas fa-download"></i></button>
                            </form>
                        </div>-->
                        <table class="table table-bordered table-striped" id="dataTableItar" width="100%"
                            cellspacing="0" style="color: black!important">
                            <thead style="background-color: #919090;color:white;">
                                <tr style="text-align: center">
                                    <th>Folio</th>
                                    <th>Nombre del PPA</th>
                                    <th>Tipo</th>
                                    <th>Objetivo</th>
                                    <th>Cobertura</th>
                                    <th>Ejercicio</th>
                                    <th>Responsable</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ppas as $ppa)
                                    <tr >
                                        <td>{{$ppa->folio}}</td>
                                        <td>{{$ppa->nombre}}</td>
                                        <td>{{$ppa->tipo}}</td>
                                        <td>{{$ppa->objetivo}}</td>
                                        <td>{{$ppa->cobertura}}</td>
                                        <td>{{$ppa->ejercicio}}</td>
                                        <td>{{$ppa->idDependencia}}</td>
                                        <td class="" style="text-align: center">
                                            <form action="{{route('itar.edit')}}" style="float:left;margin:5px" method="POST">
                                                @csrf
                                                <input type="hidden" name="idITAR" value="{{$ppa->id}}"/>
                                                <button
                                                    class="btn btn-sm btn-info" type="submit"><i
                                                        class="fas fa-edit"></i></button>
                                            </form>
                                            <a target="_blank"
                                                    href="" style="float: left;margin:5px"><button
                                                        class="btn btn-sm btn-dark"><i
                                                            class="fas fa-file-pdf"></i></button></a>


                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <h3>
                                No existen PPAs Registrados!
                            </h3>
                            <a href="{{ route('itar.index') }}">
                                <button class="btn btn-success">

                                    Agregar PPA

                                </button>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $("#dataTableItar").DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 20],
                order: [
                    [0, 'asc']
                ],
            })
    });
</script>
@endsection
