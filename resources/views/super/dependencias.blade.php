@extends('layouts.administrador')

@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">Dependencias / listado</h1>
@endsection

@section('content')
    <div class="row">

        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                    style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Dependencias Registradas</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Acciones:</div>
                            <a class="dropdown-item" onclick="showDependencia(null)" style="cursor: pointer"><i
                                    class="fas fa-plus" style="color:green;"></i> Nueva Dependencia</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body" id="dependenciaContent">
                    @if (count($dependencias) > 0)
                        <div class="" style="text-align:right;position:relative;top:-10px;">
                            <a href="{{ route('dependencia.download') }}" target="_blank">
                                <button class="btn btn-warning"><i class="fas fa-download"></i> PDF</button>
                            </a>
                            <a href="{{ route('dependencia.downloadxls') }}" target="_blank">
                                <button class="btn btn-success"><i class="fas fa-download"></i> Excel</button>
                            </a>
                            <a href="{{ route('dependencia.downloadcsv') }}" target="_blank">
                                <button class="btn btn-secondary"><i class="fas fa-download"></i> CSV</button>
                            </a>
                        </div>
                        <table class="table table-bordered table-striped" id="dataTableDependencias" width="100%"
                            cellspacing="0" style="color: black!important">
                            <thead style="background-color: #919090;color:white;">
                                <tr>
                                    <th style="display:none">Id</th>
                                    <th>UR</th>
                                    <th>Nombre</th>
                                    <th>Siglas</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dependencias as $dependencia)
                                    <tr id="dependencia{{ $dependencia->idDependencia }}">
                                        <td style="display:none">{{ $dependencia->idDependencia }}</td>
                                        <td>{{ $dependencia->numeroUR }}</td>
                                        <td>{{ $dependencia->dependenciaNombre }}</td>
                                        <td>{{ $dependencia->dependenciaSiglas }}</td>
                                        <td class="text-center" style="width:150px">
                                            <button class="btn btn-sm btn-info"
                                                onclick="showDependencia({{ $dependencia->idDependencia }})"><i
                                                    class="fas fa-edit"></i></button>
                                            <button class="btn btn-sm btn-danger"
                                                onclick="deleteDependencia('{{ $dependencia->idDependencia }}')"><i
                                                    class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <h3>
                                No existen Dependencias Registradas!
                            </h3>
                            <a href="{{ route('indicador') }}">
                                <button class="btn btn-success">

                                    Agregar Dependencia

                                </button>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="dependenciaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" style="color: black!important">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="exampleModalLabel">Datos de la Dependencia</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="formDependencia">
                        @csrf
                        <input type="hidden" id="idDependencia" name="idDependencia" />
                        <h3> Generales</h3>
                        <hr />
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="numeroUR">Número de Unidad Responsable:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="numeroUR" name="numeroUR" placeholder="00"
                                    value="" required>
                                <div class="invalid-feedback">
                                    Indique un número de Unidad Responsable!
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="dependenciaNombre">Nombre de la Dependencia:<span
                                        style="color: red">*</span></label>
                                <input type="text" class="form-control" id="dependenciaNombre"
                                    name="dependenciaNombre" placeholder="Secretaria de ...." value="" required>
                                <div class="invalid-feedback">
                                    Indique el nombre de la dependencia!
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="dependenciaSiglas">Siglas:</label>
                                <input type="text" class="form-control" id="dependenciaSiglas"
                                    name="dependenciaSiglas" placeholder="SIGL" value="">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="button" onclick="saveDependencia()">Almacenar</button>
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

        input {
            color: black !important
        }
    </style>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#dataTableDependencias").DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 20, 50],
                order: [
                    [0, 'asc']
                ],
            })
            $("#menuDependencias").addClass("active");
            //$("#optindicadorlistado").css('background-color',"rgb(217, 217, 217)"); 
        });

        function showDependencia(idDependencia) {
            if (idDependencia != null) {
                idDependencia = $("#dependencia" + idDependencia).find("td").eq(0).html();
                numeroUR = $("#dependencia" + idDependencia).find("td").eq(1).html();
                dependenciaNombre = $("#dependencia" + idDependencia).find("td").eq(2).html();
                dependenciaSigas = $("#dependencia" + idDependencia).find("td").eq(3).html();
                $("#idDependencia").val(idDependencia);
                $("#numeroUR").val(numeroUR);
                $("#dependenciaNombre").val(dependenciaNombre);
                $("#dependenciaSiglas").val(dependenciaSigas);
            } else {
                $("#idDependencia").val('');
                $("#numeroUR").val('');
                $("#dependenciaNombre").val('');
                $("#dependenciaSiglas").val('');
            }
            $("#dependenciaModal").modal("show");
        }

        function saveDependencia() {

            if (validaFormDependencia()) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('dependencia.save') }}",
                    data: $("#formDependencia").serialize(),
                    beforeSend: function() {
                        block(true)
                    }
                }).done(function(response) {
                    block(false);
                    if (response.success == "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Dependencia ',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                            window.location.replace("{{ route('dependencias') }}");
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Dependencia ',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
                    }

                }).fail(function(data) {

                });
            }

        }

        function validaFormDependencia() {
            inputs = [
                "numeroUR",
                "dependenciaNombre"
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
            return valid;
        }

        function deleteDependencia(idDependencia) {
            Swal.fire({
                title: '¿Está Seguro?',
                text: "La dependencia no será mostrada en el listado!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, dar de baja!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('dependencia.delete') }}",
                        data: {
                            idDependencia: idDependencia,
                            _token: $("input[name='_token']").val()
                        },
                        beforeSend: function() {
                            block(true)
                        },
                        success: function(response) {
                            if (response.success = "ok") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Dependencia ',
                                    text: response.message,
                                    confirmButtonColor: '#3085d6',
                                }).then((result) => {
                                    $("#dependencia" + idDependencia).hide('slow');
                                    //window.location.replace("{{ route('dependencias') }}");
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Ocurrió un error al intentar dar de baja a la dependencia',
                                    text: response.message,
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
