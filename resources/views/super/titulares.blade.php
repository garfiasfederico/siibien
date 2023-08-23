@extends('layouts.administrador')

@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">Titulares / listado</h1>
@endsection

@section('content')
    <div class="row">

        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                    style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Titulares Registrados</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Acciones:</div>
                            <a class="dropdown-item" onclick="showTitular(null)" style="cursor: pointer"><i
                                    class="fas fa-plus" style="color:green;"></i> Nuevo Titular</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body" id="dependenciaContent">
                    @if (count($titulares) > 0)
                        <div class="" style="text-align:right;position:relative;top:-10px;">
                            <a href="{{ route('titular.download') }}" target="_blank">
                                <button class="btn btn-warning"><i class="fas fa-download"></i> PDF</button>
                            </a>
                            <a href="{{ route('titular.downloadxls') }}" target="_blank">
                                <button class="btn btn-success"><i class="fas fa-download"></i> Excel</button>
                            </a>
                            <a href="{{ route('titular.downloadcsv') }}" target="_blank">
                                <button class="btn btn-secondary"><i class="fas fa-download"></i> CSV</button>
                            </a>
                        </div>
                        <table class="table table-bordered table-striped" id="dataTableTitulares" width="100%"
                            cellspacing="0" style="color: black!important">
                            <thead style="background-color: #919090;color:white;">
                                <tr>
                                    <th style="display:none">Id</th>
                                    <th>Nombre</th>
                                    <th>Cargo</th>
                                    <th style="display:none">DependenciaID</th>
                                    <th>Dependencia</th>
                                    <th>Siglas</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($titulares as $titular)
                                    <tr id="titular{{ $titular->idTitular }}">
                                        <td style="display:none">{{ $titular->idTitular }}</td>
                                        <td>{{ $titular->nombre }}</td>
                                        <td>{{ $titular->cargo }}</td>
                                        <td style="display:none">{{ $titular->idDependencia }}</td>
                                        <td>{{ $titular->dependenciaNombre }}</td>
                                        <td>{{ $titular->dependenciaSiglas }}</td>
                                        <td class="text-center" style="width:150px">
                                            <button class="btn btn-sm btn-info"
                                                onclick="showTitular({{ $titular->idTitular }})"><i
                                                    class="fas fa-edit"></i></button>
                                            <button class="btn btn-sm btn-danger"
                                                onclick="deleteTitular('{{ $titular->idTitular }}')"><i
                                                    class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <h3>
                                No existen Titulares Registrados!
                            </h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="titularModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" style="color: black!important">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="exampleModalLabel">Datos del Titular</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="formTitular">
                        @csrf
                        <input type="hidden" id="idTitular" name="idTitular" />
                        <h3> Generales</h3>
                        <hr />
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="nombre">Nombre completo del Titular:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    placeholder="Ing. Germanio......" value="" required>
                                <div class="invalid-feedback">
                                    Indique el nombre del Titular!
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="cargo">Cargo:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="cargo" name="cargo"
                                    placeholder="Coordinador General...." value="" required>
                                <div class="invalid-feedback">
                                    Indique el cargo del Titular!
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="idDependencia">Dependencia:<span style="color: red">*</span></label>
                                <select class="form-control" id="idDependencia" name="idDependencia" required>
                                    <option value="0"> Seleccione...</option>
                                    @foreach ($dependencias as $dependencia)
                                        <option value="{{ $dependencia->idDependencia }}">
                                            {{ $dependencia->dependenciaNombre . ' - ' . $dependencia->dependenciaSiglas }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Indique la Dependencia!
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="button" onclick="saveTitular()">Almacenar</button>
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

        input,
        select {
            color: black !important
        }
    </style>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#dataTableTitulares").DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 20, 50],
                order: [
                    [0, 'des']
                ],
            })
            $("#menuTitulares").addClass("active");
            //$("#optindicadorlistado").css('background-color',"rgb(217, 217, 217)"); 
        });

        function showTitular(idTitular) {
            if (idTitular != null) {
                $("#idTitular").val(idTitular);
                nombre = $("#titular" + idTitular).find("td").eq(1).html();
                cargo = $("#titular" + idTitular).find("td").eq(2).html();
                idDependencia = $("#titular" + idTitular).find("td").eq(3).html();
                $("#nombre").val(nombre);
                $("#cargo").val(cargo);
                $("#idDependencia").val(idDependencia);
            } else {
                $("#nombre").val('');
                $("#cargo").val('');
                $("#idDependencia").val('0');
                $("#idTitular").val('');
            }
            $("#titularModal").modal("show");
        }

        function saveTitular() {

            if (validaFormTitular()) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('titular.save') }}",
                    data: $("#formTitular").serialize(),
                    beforeSend: function() {
                        block(true)
                    }
                }).done(function(response) {
                    block(false);
                    if (response.success == "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Titular ',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                            window.location.replace("{{ route('titulares') }}");
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Titular ',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
                    }

                }).fail(function(data) {

                });
            }

        }

        function validaFormTitular() {
            inputs = [
                "nombre",
                "cargo"
            ];

            selects = [
                "idDependencia",
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

        function deleteTitular(idTitular) {
            Swal.fire({
                title: '¿Está Seguro?',
                text: "El titular dejará de estar vigente!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, dar de baja!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('titular.delete') }}",
                        data: {
                            idTitular: idTitular,
                            _token: $("input[name='_token']").val()
                        },
                        beforeSend: function() {
                            block(true)
                        },
                        success: function(response) {
                            if (response.success = "ok") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Titular ',
                                    text: response.message,
                                    confirmButtonColor: '#3085d6',
                                }).then((result) => {
                                    $("#titular" + idTitular).hide('slow');
                                    //window.location.replace("{{ route('titulares') }}");
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Ocurrió un error al intentar dar de baja al titular',
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
