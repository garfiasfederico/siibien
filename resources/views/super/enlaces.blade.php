@extends('layouts.administrador')

@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">Enlaces / listado</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                    style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Enlaces Registrados</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Acciones:</div>
                            <a class="dropdown-item" onclick="showEnlace(null)" style="cursor: pointer"><i
                                    class="fas fa-plus" style="color:green;"></i> Nuevo Enlace</a>
                            <a class="dropdown-item" onclick="showMasiva()" style="cursor: pointer"><i class="fas fa-list"
                                    style="color:green;"></i> Carga Masiva</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body" id="enlaceContent">
                    @if (count($enlaces) > 0)
                        <div class="" style="text-align:right;position:relative;top:-10px;">
                            <a href="{{ route('enlace.download') }}" target="_blank">
                                <button class="btn btn-warning"><i class="fas fa-download"></i> PDF</button>
                            </a>
                            <a href="{{ route('enlace.downloadxls') }}" target="_blank">
                                <button class="btn btn-success"><i class="fas fa-download"></i> Excel</button>
                            </a>
                            <a href="{{ route('enlace.downloadcsv') }}" target="_blank">
                                <button class="btn btn-secondary"><i class="fas fa-download"></i> CSV</button>
                            </a>
                        </div>
                        <table class="table table-bordered table-striped" id="dataTableEnlaces" width="100%"
                            cellspacing="0" style="color: black!important">
                            <thead style="background-color: #919090;color:white;">
                                <tr>
                                    <th style="display:none">Id</th>
                                    <th>Título</th>
                                    <th>Nombre</th>
                                    <th>Apellido Paterno</th>
                                    <th>Apellido Materno</th>
                                    <th>Cargo</th>
                                    <th>Tipo de Enlace</th>
                                    <th style="display:none">DependenciaID</th>
                                    <th>Dependencia</th>
                                    <th style="display:none">Email</th>
                                    <th style="display:none">Telefono</th>
                                    <th style="display:none">Celular</th>
                                    <th style="display:none">Teléfono de Oficina</th>
                                    <th style="display:none">Extensión</th>
                                    <th style="display:none">Oficio de Solicitud</th>
                                    <th style="display:none">Fecha de Acuse</th>
                                    <th style="display:none">Oficio de Designación</th>
                                    <th style="display:none">Fecha de Recepción</th>
                                    <th style="display:none">Observaciones</th>
                                    <th>Usuario Activo</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($enlaces as $enlace)
                                    <tr id="enlace{{ $enlace->idEnlaceDependencia }}">
                                        <td style="display:none">{{ $enlace->idEnlaceDependencia }}</td>
                                        <td>{{ $enlace->titulo }}</td>
                                        <td>{{ $enlace->nombre }}</td>
                                        <td>{{ $enlace->apellidoP }}</td>
                                        <td>{{ $enlace->apellidoM }}</td>
                                        <td>{{ $enlace->cargo }}</td>
                                        <td>{{ $enlace->tipoEnlace }}</td>
                                        <td style="display:none">{{ $enlace->idDependencia }}</td>
                                        <td>{{ $enlace->dependenciaSiglas }}</td>
                                        <td style="display:none">{{ $enlace->email }}</td>
                                        <td style="display:none">{{ $enlace->telefono }}</td>
                                        <td style="display:none">{{ $enlace->celular }}</td>
                                        <td style="display:none">{{ $enlace->teloficina }}</td>
                                        <td style="display:none">{{ $enlace->extension }}</td>
                                        <td style="display:none">{{ $enlace->oficioSolicitud }}</td>
                                        <td style="display:none">{{ $enlace->fechaAcuse }}</td>
                                        <td style="display:none">{{ $enlace->oficioDesignacion }}</td>
                                        <td style="display:none">{{ $enlace->fechaRecepcion }}</td>
                                        <td style="display:none">{{ $enlace->observaciones }}</td>
                                        <td style="text-align: center"><input type="checkbox"
                                                {{ $enlace->statusUser ? 'checked' : '' }} id="check{{ $enlace->id }}"
                                                onchange="setStatus({{ $enlace->id }})" /><i
                                                class="fas fa-spinner fa-spin" id="spin{{ $enlace->id }}"
                                                style="display: none"></i></td>
                                        <td class="text-center" style="width:150px">
                                            <button class="btn btn-sm btn-info"
                                                onclick="showEnlace({{ $enlace->idEnlaceDependencia }})"><i
                                                    class="fas fa-edit"></i></button>
                                            <button class="btn btn-sm btn-success"
                                                onclick="showUser({{ $enlace->id }})"><i class="fas fa-key"></i></button>
                                            <form method="POST" action="{{ route('perfil.responsivap') }}" style="display:initial" target="_blank">
                                                @csrf
                                                <input type="hidden" value="{{$enlace->idEnlaceDependencia}}" name="idEnlaceDependencia"/>
                                                <button class="btn btn-sm btn-info"><i class="fas fa-file-pdf"></i></button>
                                            </form>
                                            <button class="btn btn-sm btn-danger"
                                                onclick="deleteEnlace('{{ $enlace->idEnlaceDependencia }}')"><i
                                                    class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <h3>
                                No existen Enlaces Registrados!
                            </h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="enlaceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" style="">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="exampleModalLabel">Datos del Enlace</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="margin-left:15px!important;margin-right:15px">
                    <form method="POST" id="formEnlace">
                        @csrf
                        <input type="hidden" id="idEnlaceDependencia" name="idEnlaceDependencia" />
                        <h3> Generales</h3>
                        <hr />
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="nombre">Titulo:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="titulo" name="titulo"
                                    placeholder="Ing" value="" required>
                                <div class="invalid-feedback">
                                    Indique un título!
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="nombre">Nombre:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    placeholder="Gerardo ..." value="" required>
                                <div class="invalid-feedback">
                                    Indique un nombre!
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="nombre">Apellido Paterno:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="apellidoP" name="apellidoP"
                                    placeholder="" value="" required>
                                <div class="invalid-feedback">
                                    Indique el apellido paterno!
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="nombre">Apellido Materno:</label>
                                <input type="text" class="form-control" id="apellidoM" name="apellidoM"
                                    placeholder="" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="cargo">Cargo:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="cargo" name="cargo"
                                    placeholder="Coordinador General...." value="" required>
                                <div class="invalid-feedback">
                                    Indique el cargo del Titular!
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="tipoEnlace">Tipo Enlace:<span style="color: red">*</span></label>
                                <select name="tipoEnlace" id="tipoEnlace" class="form-control">
                                    <option value="0">Seleccione...</option>
                                    <option value="operativo">Operativo</option>
                                    <option value="directivo">Directivo</option>
                                </select>
                                <div class="invalid-feedback">
                                    Indique el tipo de enlace!
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="email">Email:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="ejemplo@ejempli.com" value="" required>
                                <div class="invalid-feedback">
                                    Indique un email válido!
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" class="form-control" id="telefono" name="telefono"
                                    placeholder="" value="">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="celular">Celular:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="celular" name="celular" placeholder=""
                                    value="" required>
                                <div class="invalid-feedback">
                                    Indique celular válido!
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="teloficina">Teléfono de oficina:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="teloficina" name="teloficina"
                                    placeholder="" value="" required>
                                <div class="invalid-feedback">
                                    Indique teléfono válido!
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="extension">Extensión:</label>
                                <input type="text" class="form-control" id="extension" name="extension"
                                    placeholder="" value="">
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
                        <h3>Designación</h3>
                        <hr />
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="oficioSolicitud">Oficio de Solicitud:</label>
                                <input type="text" class="form-control" id="oficioSolicitud" name="oficioSolicitud"
                                    placeholder="" value="">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="fechaAcuse">Fecha del Acuse:</label>
                                <input type="date" class="form-control" id="fechaAcuse" name="fechaAcuse"
                                    placeholder="" value="">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="oficioDesignacion">Oficio de Designación:</label>
                                <input type="text" class="form-control" id="oficioDesignacion"
                                    name="oficioDesignacion" placeholder="" value="">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="fechaRecepcion">Fecha de la Recepción:</label>
                                <input type="date" class="form-control" id="fechaRecepcion" name="fechaRecepcion"
                                    placeholder="" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="observaciones">Observaciones:</label>
                                <textarea type="date" class="form-control" id="observaciones" name="observaciones" placeholder=""
                                    value=""></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="button" onclick="saveEnlace()">Almacenar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" style="">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="exampleModalLabel">Información de la Cuenta de Acceso</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="margin-left:15px!important;margin-right:15px">
                    <form method="POST" id="formUser">
                        @csrf
                        <input type="hidden" id="idUser" name="idUser" />
                        <h3> Generales</h3>
                        <hr />
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name">Nombre:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" placeholder=""
                                    value="" required>
                                <div class="invalid-feedback">
                                    Indique el Nombre de la cuenta!
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="nombre">Cuenta:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="cuenta" name="cuenta" placeholder=""
                                    value="" required>
                                <div class="invalid-feedback">
                                    Indique la cuenta de acceso!
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="rol">Rol:<span style="color: red">*</span></label>
                                <select id="rol" name="rol" class="form-control">
                                    <option value="1">Enlace</option>
                                    <option value="2">Consulta</option>
                                </select>
                                <div class="invalid-feedback">
                                    Indique un Rol
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="password">Contraseña Actual:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="password" name="password"
                                    placeholder="" value="" required>
                                <div class="invalid-feedback">
                                    Indicar Contraseña!
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="nombre">Cambiar Contraseña:</label>
                                <input type="text" class="form-control" id="cambia" name="cambia" placeholder=""
                                    value="">
                                <div class="invalid-feedback">
                                    Contraseña Insegura: almenos 10 caracteres!
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="nombre">Activo:<span style="color: red">*</span></label>
                                <input type="checkbox" class="form-control" style="width: 15px;" id="status"
                                    name="status" placeholder="" required>
                                <div class="invalid-feedback">
                                    Confirma Estatus!
                                </div>
                            </div>
                        </div>
                    </form>
                    <h3>Permisos</h3>
                    <hr />
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <input type="checkbox" id="informe_p" onchange="updateestatuspermiso('informe')"> Informe de Gobierno
                            </td>
                        <tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="itar_p" onchange="updateestatuspermiso('itar')"> ITAR
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="ie_p" onchange="updateestatuspermiso('ie')"> Indicadores Estratégicos
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="ipes_p" onchange="updateestatuspermiso('ipes')" > Indicadores PES/PE
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="eventos_p" onchange="updateestatuspermiso('eventos')"> Eventos
                            </td>
                        </tr>
                    </table>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="button" onclick="saveUser()">Almacenar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="masivaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" style="">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="exampleModalLabel">Carga Masiva de Enlaces</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="margin-left:15px!important;margin-right:15px">
                    <div class="text-right"><a target="_blank" href="{{ asset('docs/ejemplo.xlsx') }}">Descarga Ejemplo
                            de plantilla</a></div>
                    <form method="POST" id="formMasiva" enctype="multipart/form-data">
                        @csrf
                        <h3> Carga Plantilla</h3>
                        <hr />
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="custom-file-label">Selecciona Archivo:<span
                                        style="color: red">*</span></label>
                                <input type="file" class="custom-file-input" id="layout" name="layout" required
                                    onchange="setFile()"
                                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel">
                                <div style="width:100%" id="filename" class="alert"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="button" onclick="sendLayout()" id="btnCarga">Cargar</button>

                </div>
            </div>
        </div>
    </div>
    <style>
        .odd {
            background-color: #f3f3f3 !important;
        }

        input,
        select {
            color: black !important
        }

        .custom-file-text {
            en: "Browse",
                es:"Elegir"
        }
    </style>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#dataTableEnlaces").DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 20, 50],
                order: [
                    [0, 'des']
                ],
            })
            $("#menuEnlaces").addClass("active");
            //$("#optindicadorlistado").css('background-color',"rgb(217, 217, 217)");
        });

        function showEnlace(idEnlaceDependencia) {
            if (idEnlaceDependencia != null) {
                $("#idEnlaceDependencia").val(idEnlaceDependencia);
                titulo = $("#enlace" + idEnlaceDependencia).find("td").eq(1).html();
                nombre = $("#enlace" + idEnlaceDependencia).find("td").eq(2).html();
                apellidoP = $("#enlace" + idEnlaceDependencia).find("td").eq(3).html();
                apellidoM = $("#enlace" + idEnlaceDependencia).find("td").eq(4).html();
                cargo = $("#enlace" + idEnlaceDependencia).find("td").eq(5).html();
                tipoEnlace = $("#enlace" + idEnlaceDependencia).find("td").eq(6).html();
                email = $("#enlace" + idEnlaceDependencia).find("td").eq(9).html();
                telefono = $("#enlace" + idEnlaceDependencia).find("td").eq(10).html();
                celular = $("#enlace" + idEnlaceDependencia).find("td").eq(11).html();
                teloficina = $("#enlace" + idEnlaceDependencia).find("td").eq(12).html();
                extension = $("#enlace" + idEnlaceDependencia).find("td").eq(13).html();
                oficioSolicitud = $("#enlace" + idEnlaceDependencia).find("td").eq(14).html();
                fechaAcuse = $("#enlace" + idEnlaceDependencia).find("td").eq(15).html();
                oficioDesignacion = $("#enlace" + idEnlaceDependencia).find("td").eq(16).html();
                fechaRecepcion = $("#enlace" + idEnlaceDependencia).find("td").eq(17).html();
                observaciones = $("#enlace" + idEnlaceDependencia).find("td").eq(18).html();
                idDependencia = $("#enlace" + idEnlaceDependencia).find("td").eq(7).html();

                $("#titulo").val(titulo);
                $("#nombre").val(nombre);
                $("#apellidoP").val(apellidoP);
                $("#apellidoM").val(apellidoM);
                $("#cargo").val(cargo);
                $("#tipoEnlace").val(tipoEnlace);
                $("#email").val(email);
                $("#telefono").val(telefono);
                $("#celular").val(celular);
                $("#teloficina").val(teloficina);
                $("#extension").val(extension);
                $("#oficioSolicitud").val(oficioSolicitud);
                $("#fechaAcuse").val(fechaAcuse);
                $("#oficioDesignacion").val(oficioDesignacion);
                $("#fechaRecepcion").val(fechaRecepcion);
                $("#observaciones").val(observaciones);
                $("#idDependencia").val(idDependencia);
            } else {
                $("#titulo").val('');
                $("#nombre").val('');
                $("#apellidoP").val('');
                $("#apellidoM").val('');
                $("#cargo").val('');
                $("#tipoEnlace").val('0');
                $("#email").val('');
                $("#telefono").val('');
                $("#celular").val('');
                $("#teloficina").val('');
                $("#extension").val('');
                $("#oficioSolicitud").val('');
                $("#fechaAcuse").val('');
                $("#oficioDesignacion").val('');
                $("#fechaRecepcion").val('');
                $("#observaciones").val('');
                $("#idDependencia").val('0');
                $("#idEnlaceDependencia").val('');
            }
            $("#enlaceModal").modal("show");
        }

        function saveEnlace() {

            if (validaFormEnlace()) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('enlace.save') }}",
                    data: $("#formEnlace").serialize(),
                    beforeSend: function() {
                        block(true)
                    }
                }).done(function(response) {
                    block(false);
                    if (response.success == "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Enlace ',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                            window.location.replace("{{ route('enlaces') }}");
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Enlace ',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
                    }

                }).fail(function(data) {

                });
            }

        }

        function validaFormEnlace() {
            inputs = [
                "titulo",
                "nombre",
                "apellidoP",
                "cargo",
                "email",
                "celular",
                "teloficina",
            ];

            selects = [
                "idDependencia",
                "tipoEnlace"
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

        function deleteEnlace(idEnlaceDependencia) {
            Swal.fire({
                title: '¿Está Seguro?',
                text: "El enlace dejará de estar vigente!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, dar de baja!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('enlace.delete') }}",
                        data: {
                            idEnlaceDependencia: idEnlaceDependencia,
                            _token: $("input[name='_token']").val()
                        },
                        beforeSend: function() {
                            block(true)
                        },
                        success: function(response) {
                            if (response.success = "ok") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Enlace ',
                                    text: response.message,
                                    confirmButtonColor: '#3085d6',
                                }).then((result) => {
                                    $("#enlace" + idEnlaceDependencia).hide('slow');
                                    //window.location.replace("{{ route('titulares') }}");
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Ocurrió un error al intentar dar de baja al enlace',
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

        //Usuarios

        function showUser(idUser) {
            if (idUser != null) {

                $.ajax({
                    type: 'GET',
                    url: "{{ route('user') }}",
                    data: {
                        idUser: idUser
                    },
                    beforeSend: function() {
                        block(true)
                    }
                }).done(function(response) {
                    if (response.success == "ok") {
                        //Rellenamos con los datos del usuario
                        $("#idUser").val('' + response.usuario.id + '');
                        $("#name").val('' + response.usuario.name + '');
                        $("#cuenta").val('' + response.usuario.cuenta + '');
                        $("#password").val('' + atob(response.usuario.enc) + '');
                        $("#cambia").val('');
                        $("#status").prop('checked', response.usuario.status);
                        $("#rol").val(response.rol);
                        if(response.usuario.informe==1){
                            $("#informe_p").prop("checked",true)
                        }else{
                            $("#informe_p").prop("checked",false)
                        }

                        if(response.usuario.itar==1){
                            $("#itar_p").prop("checked",true)
                        }else{
                            $("#itar_p").prop("checked",false)
                        }

                        if(response.usuario.ie==1){
                            $("#ie_p").prop("checked",true)
                        }else{
                            $("#ie_p").prop("checked",false)
                        }
                        if(response.usuario.ipes==1){
                            $("#ipes_p").prop("checked",true)
                        }else{
                            $("#ipes_p").prop("checked",false)
                        }
                        if(response.usuario.eventos==1){
                            $('#eventos_p').prop("checked",true)
                        }else{
                            $('#eventos_p').prop("checked",false)
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Usuario ',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
                    }
                    block(false);

                }).fail(function(data) {

                });


            }
            $("#userModal").modal("show");
        }

        function saveUser() {

            if (validaFormUser()) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('user.save') }}",
                    data: $("#formUser").serialize(),
                    beforeSend: function() {
                        block(true)
                    }
                }).done(function(response) {
                    block(false);
                    if (response.success == "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Usuario ',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                            $("#userModal").modal("hide");
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Usuario ',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
                    }

                }).fail(function(data) {

                });
            }

        }

        function validaFormUser() {
            inputs = [
                "name",
                "cuenta",
                "password",
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

            if (valid) {
                if (($("#cambia").val().length != 0) && ($("#cambia").val().length < 10)) {
                    $("#cambia").addClass("is-invalid");
                    valid = false;
                } else {
                    $("#cambia").removeClass("is-invalid");
                    valid = true;
                }
            }
            return valid;
        }

        function setStatus(idUser) {
            status = $("#check" + idUser).prop('checked');
            _token = $("input[name='_token']").val();

            $.ajax({
                type: 'POST',
                url: "{{ route('user.updatestatus') }}",
                data: {
                    idUser: idUser,
                    status: status == 'false' ? 0 : 1,
                    _token: _token
                },
                beforeSend: function() {
                    $("#spin" + idUser).show('');
                    $("#check" + idUser).hide('');
                }
            }).done(function(response) {
                $("#check" + idUser).css('accent-color', 'blue');
                if (response.success != "ok") {
                    if (status == 'false') {
                        $("#check" + idUser).prop('checked', true);
                        $("#check" + idUser).css('accent-color', 'red');
                    } else {
                        $("#check" + idUser).prop('checked', false);
                        $("#check" + idUser).css('accent-color', 'red');
                    }
                }
                $("#spin" + idUser).hide('');
                $("#check" + idUser).show('');
            }).fail(function(data) {
                $("#check" + idUser).prop('checked', !status == 'false' ? false : true);
                $("#spin" + idUser).hide('');
                $("#check" + idUser).show('');
            });
        }

        function showMasiva() {
            $('#filename').html('');
            $('#filename').removeClass("alert-warning");
            $('#filename').removeClass("alert-success");
            $('#layout').val('');
            $("#masivaModal").modal("show");
        }

        function setFile() {
            filename = $("#layout").val();

            if (filename != "") {
                $('#filename').html(filename);
                $('#filename').removeClass("alert-warning");
                $('#filename').addClass("alert-success");
                $("#btnCarga").attr("disabled", false)
            } else {
                $('#filename').html('');
                $('#filename').removeClass("alert-success");
                $('#filename').addClass("alert-warning");
                $("#btnCarga").attr("disabled", true)
            }
        }

        function sendLayout() {
            _token = $("input[name='_token']").val();
            formData = new FormData($("#formMasiva").get(0));
            //formData.append("_token",_token);
            $.ajax({
                type: 'POST',
                url: "{{ route('enlace.validalayout') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    block(true)
                }
            }).done(function(response) {

                if (response.success != "ok") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Plantilla de Enlaces ',
                        text: response.message,
                        confirmButtonColor: '#3085d6',
                    }).then((result) => {
                        $("#masivaModal").modal("hide");
                    });
                } else {
                    window.location.replace("/enlace/leelayout/" + response.path);
                }
                block(false)
            }).fail(function(data) {
                block(false)
            });
        }

        function updateestatuspermiso(campo){
            status = $("#"+campo+"_p").prop("checked");
            idUser = $("#idUser").val();
            $.ajax({
                    type: 'POST',
                    url: "{{ route('user.updateestatuspermiso') }}",
                    data: {
                        idUser:idUser,
                        campo:campo,
                        status:status,
                        _token: $("input[name='_token']").val()
                    },
                    beforeSend: function() {
                        block(true)
                    }
                }).done(function(response) {
                    block(false);
                    if (response.success != "ok") {
                      $("#"+campo+"_p").prop("checked",!status)
                    }

                }).fail(function(data) {

                });
        }
    </script>
@endsection
