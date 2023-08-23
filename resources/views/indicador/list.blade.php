@extends('layouts.administrador')

@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">Indicador / listar</h1>
    <!--<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm disabled"><i
            class="fas fa-download fa-sm text-white-50"></i> Generar Listado de Indicadores</a>-->
@endsection

@section('content')
    <div class="row">
        @csrf
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Indicadores Registrados</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Acciones:</div>
                            <a class="dropdown-item" href="{{ route('indicador') }}" style="cursor: pointer"><i
                                    class="fas fa-plus" style="color:green;"></i> Nuevo Indicador</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body" id="indicadorContent">
                    @if (count($indicadores) > 0)
                        <table class="table table-bordered table-striped" id="dataTableIndicadores" width="100%"
                            cellspacing="0" style="color: black!important">
                            <thead style="background-color: #919090;color:white;">
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Objetivo</th>
                                    <th>Tipo</th>
                                    <th>Dimension</th>
                                    <th>Responsable</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>                            
                            <tbody>
                                @foreach ($indicadores as $indicador)
                                    <tr>
                                        <td>{{ $indicador->idIndicador }}</td>
                                        <td>{{ $indicador->indicadorNombre }}</td>
                                        <td>{{ $indicador->indicadorObjetivo }}</td>
                                        <td>{{ $indicador->indicadorTipo }}</td>
                                        <td>{{ $indicador->indicadorDimension }}</td>
                                        <td>{{ $indicador->dependenciaSiglas }}</td>
                                        <td class="text-center" style="width:150px">
                                            @if(Auth::user()->hasRole("consulta"))
                                            <button class="btn btn-sm btn-primary"
                                                onclick="detallesIndicador({{ $indicador->idIndicador }})"><i
                                                    class="fas fa-info"></i></button>
                                            @else        
                                            <button class="btn btn-sm btn-primary"
                                                onclick="detallesIndicador({{ $indicador->idIndicador }})"><i
                                                    class="fas fa-info"></i></button>
                                            <a target="_blank" href="{{ route('indicador.download', ['id' => $indicador->idIndicador]) }}"><button
                                                    class="btn btn-sm btn-success"><i
                                                        class="fas fa-download"></i></button></a>
                                            <a href="{{ route('indicador.edit', ['id' => $indicador->idIndicador]) }}"><button
                                                    class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button></a>
                                            <button class="btn btn-sm btn-danger"
                                                onclick="deleteIndicador({{ $indicador->idIndicador . ",'" . $indicador->indicadorNombre }}')"><i
                                                    class="fas fa-trash"></i></button>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
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
                </div>
            </div>
        </div>
    </div>
    <style>
        table tr:hover {
            background-color: rgb(242, 242, 242);
        }

        .odd {
            background-color: #f3f3f3 !important;
        }
    </style>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#dataTableIndicadores").DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 20],
                order: [
                    [0, 'desc']
                ],
            })
            $("#collapseTwo").addClass("show");
            $("#menuIndicadores").addClass("active");
            $("#optindicadorlistado").css('background-color',"rgb(217, 217, 217)"); 
        });

        function detallesIndicador(indicador) {
            $("#generalModal").modal("show");
            getInfoIndicador(indicador);

        }

        function getInfoIndicador(indicador) {
            $.ajax({
                type: 'GET',
                url: "{{ route('indicador.info') }}",
                data: {
                    indicador: indicador
                },
                beforeSend: function() {
                    $("#generalModal .modal-body").html(
                        '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando...</div>');
                }
            }).done(function(response) {
                $("#generalModal .modal-body").html(response).animate("slow");
            }).fail(function(data) {

            })
        }

        function deleteIndicador(idIndicador, nombreIndicador) {
            Swal.fire({
                title: '¿Está Seguro?',
                text: "La información del indicador: \"" + nombreIndicador + "\"  no estará disponible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, dar de baja!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('indicador.delete') }}",
                        data: {
                            idIndicador: idIndicador,
                            _token: $("input[name='_token']").val()
                        },
                        beforeSend: function() {
                            block(true)
                        },
                        success: function(response) {
                            if (response.success = "ok") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Indicador ',
                                    text: response.message + " Indicador: " + nombreIndicador,
                                    confirmButtonColor: '#3085d6',
                                }).then((result) => {
                                    window.location.replace("{{ route('indicador.list') }}");
                                });
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Ocurrió un error al intentar dar de baja el Indicador',
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
