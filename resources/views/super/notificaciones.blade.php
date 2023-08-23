@extends('layouts.administrador')

@section('styles')
@endsection

@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">Notificaciones</h1>
@endsection

@section('content')
    <div class="row">

        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                    style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Notificaciones Registradas
                    </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Acciones:</div>
                            <a class="dropdown-item" onclick="showNotificacion(null)" style="cursor: pointer"><i
                                    class="fas fa-plus" style="color:green;"></i> Nueva notificación</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body" id="notificacionesContent">
                    @if (count($notificaciones) > 0)
                        <div class="" style="text-align:right;position:relative;top:-10px;display:none">
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
                                    <th>Id</th>
                                    <th>Tipo de Notificación</th>
                                    <th>Descripcion</th>
                                    <th>Fecha de Creación</th>
                                    <th>Usuarios notificados</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notificaciones as $notificacion)
                                    <tr id="notificacion{{ $notificacion->idNotificacion }}">
                                        <td>{{ $notificacion->idNotificacion }}</td>
                                        <td>{{ $notificacion->tipo }}</td>
                                        <td>{{ $notificacion->descripcion }}</td>
                                        <td>{{ $notificacion->created_at }}</td>
                                        <td align="center"><button class="btn btn-info" onclick="showUsuariosNotificados({{$notificacion->idNotificacion}})"><i class="fas fa-users"></i></button></td>
                                        <td class="text-center" style="width:150px">                                            
                                            <button class="btn btn-sm btn-danger"
                                                onclick="deleteNotificacion({{$notificacion->idNotificacion}})"><i
                                                    class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <h3>
                                No existen Notificaciones registradas!
                            </h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="notificacionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" style="color: black!important">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="exampleModalLabel">Registar Notificación</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="formNotificacion">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="tipo">Tipo de Notificación:<span style="color: red">*</span></label>
                                <select name="tipo" id="tipo" class="form-control select">
                                    <option value="0">Seleccione...</option>
                                    <option value="recordatorio">Recordatorio <i class="fas fa-clock"></i></option>
                                    <option value="general">General <i class="fas fa-bell"></i></option>
                                    <option value="amonestacion">Amonestación <i class="fas fa-warning"></i></option>
                                </select>
                                <div class="invalid-feedback">
                                    Indique un tipo de Notificación!
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="descripcion ">Descripción de la Notificación:<span
                                        style="color: red">*</span></label>
                                <textarea class="form-control" id="descripcion" name="descripcion" placeholder="" value="" required></textarea>
                                <div class="invalid-feedback">
                                    Integre la descripción de la notifiación!
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="descripcion ">Selecciona los usuarios que serán notificados:<span
                                        style="color: red">*</span></label>
                                <div style="max-height: 200px;overflow:scroll">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" onclick="selectAll($(this).prop('checked'))">
                                                    Selecciona</th>
                                                <th>Usuario</th>
                                                <th>Dependencia</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($usuarios as $user)
                                                <tr>
                                                    <td><input type="checkbox" value="{{$user->id}}" name="user[]"
                                                            class="user" /></td>
                                                    <td>{{ $user->cuenta }}</td>
                                                    <td>{{ $user->dependenciaSiglas }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div>
                                    <span id="errorSelectUsers" class="invalid-feedback"
                                        style="color: red;display:none;">Seleccione al menos un usuario para ser
                                        notificado</span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="button" onclick="saveNotificacion()">Almacenar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="usuariosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="exampleModalLabel">Usuarios Notificacos</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"
                        style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="usuariosNotificados"></div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-dismiss="modal">Cerrar</button>
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
            $("#menuNotificaciones").addClass("active");
            //$("#optindicadorlistado").css('background-color',"rgb(217, 217, 217)");      
        });

        function selectAll(checked) {
            if (checked) {
                $(".user").each(function() {
                    $(this).prop('checked', true);
                });
            } else {
                $(".user").each(function() {
                    $(this).prop('checked', false);
                });
            }
        }

        function showNotificacion() {
            $("#notificacionModal").modal("show");
        }

        function saveNotificacion() {

            if (validaFormNotificacion()) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('notificacion.save') }}",
                    data: $("#formNotificacion").serialize(),
                    beforeSend: function() {
                        block(true)
                    }
                }).done(function(response) {
                    block(false);
                    if (response.success == "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Notificacion ',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                            window.location.replace("{{ route('notificaciones') }}");
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Notificacion ',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
                    }

                }).fail(function(data) {

                });
            }

        }

        function validaFormNotificacion() {
            inputs = [
                "descripcion",
            ];

            selects = [
                "tipo"
            ]
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

            if (valid) {
                valid=false;
                $(".user").each(function() {
                    if ($(this).prop('checked')) {
                        valid = true;
                    }

                });
                if (!valid)
                    $("#errorSelectUsers").show("");
                else
                    $("#errorSelectUsers").hide("");
            }
            return valid;
        }

        function deleteNotificacion(idNotificacion) {
            Swal.fire({
                title: '¿Está Seguro?',
                text: "La notificación ya no será visible para los usuarios notificados!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, dar de baja!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('notificacion.delete') }}",
                        data: {
                            idNotificacion: idNotificacion,
                            _token: $("input[name='_token']").val()
                        },
                        beforeSend: function() {
                            block(true)
                        },
                        success: function(response) {
                            if (response.success = "ok") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Notificación ',
                                    text: response.message,
                                    confirmButtonColor: '#3085d6',
                                }).then((result) => {
                                    $("#notificacion" + idNotificacion).hide('slow');
                                    //window.location.replace("{{ route('dependencias') }}");
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Ocurrió un error al intentar dar de baja la notificación',
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

        function showUsuariosNotificados(idNotificacion){
            $.ajax({
                    type: 'GET',
                    url: "{{ route('notificacion.getusers') }}",
                    data: {idNotificacion:idNotificacion},
                    beforeSend: function() {
                        block(true)
                    }
                }).done(function(response) {
                    block(false);
                    usuarios="<table class='table'><thead><th>Nombre</th><th>Usuario</th><th>Depedendencia</th><thead><tbody>";
                    if (response.success == "ok") {
                        for(x=0;x<response.users.length;x++){
                            usuarios += '<tr>'+
                                '<td>'+response.users[x].name+'</td>'+
                                '<td>'+response.users[x].cuenta+'</td>'+
                                '<td>'+response.users[x].dependenciaSiglas+'</td>'+
                                '</tr>';
                        }   
                        usuarios += "</tbody></table>";                 
                        $("#usuariosNotificados").html(usuarios);
                        $("#usuariosModal").modal("show");
                    } 
                }).fail(function(data) {

                });
        }
    </script>
@endsection
