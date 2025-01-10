@extends('layouts.administrador')
@section('encabezado')
    ITAR / Listado de PPAs
@endsection
@section('styles')
    <style>
        .enc1 {
            padding: 5px !important;
            background-color: #c5c5c5;
            color: white;
        }

        .enc2 {
            padding: 5px !important;
            background-color: #7c2f42;
            color: white;
        }

        .resp {
            font-weight: bold;
        }

        .enc3 {
            background-color: #ececec;
            font-weight: bold;
        }

        input[type=text],
        select {
            height: 35px;
            color:black;
        }

        table tr td {
            padding: 5px;
            border: solid 2px white;
        }

        .invalid-feedback {
            width: 100%;
            background-color: rgb(252, 241, 241);
            color: gray;
            border-radius: 5px;
            text-align: center;
            padding: 10px;
        }
        textarea{
            color:black;
        }
    </style>
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
                        <table class="table table-bordered table-striped" id="dataTableItar" width="100%" cellspacing="0"
                            style="color: black!important">
                            <thead style="background-color: #919090;color:white;">
                                <tr style="text-align: center">
                                    <th>Id</th>
                                    <th>Nombre del PPA</th>
                                    <th>Objetivo</th>
                                    <th>Descripcion</th>
                                    <th>Cobertura</th>
                                    <th>Responsable</th>
                                    <th>Año de inicio</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ppas as $ppa)
                                    <tr>
                                        <td style="vertical-align: middle">{{ $ppa->id }}</td>
                                        <td style="vertical-align: middle">{{ $ppa->nombre }}</td>
                                        <td style="vertical-align: middle">{{ $ppa->descripcion }}</td>
                                        <td style="vertical-align: middle">{{ $ppa->objetivo }}</td>
                                        <td style="vertical-align: middle">{{ $ppa->cobertura }}</td>
                                        <td style="text-align: center;vertical-align: middle">{{ $ppa->dependenciaSiglas }}
                                        </td>
                                        <td style="vertical-align: middle">{{ $ppa->anio_inicio }}</td>
                                        <td class="" style="text-align: left;vertical-align: middle">
                                            <button style="margin:5px;width:150px;text-align:left"
                                                class="btn btn-sm btn-primary" type="button" title="Datos Generales"
                                                onclick="$('#modalGenerales').modal('show');"><i class="fas fa-list"></i>
                                                Datos Generales</button>
                                            <br />
                                            <button style="margin:5px;width:150px;text-align:left"
                                                class="btn btn-sm btn-success" type="button" title="Seguimiento"><i
                                                    class="fas fa-tachometer-alt"></i> Seguimiento</button>
                                            <br />
                                            <button style="margin:5px;width:150px;text-align:left"
                                                class="btn btn-sm btn-warning" type="button" title="Reportes"><i
                                                    class="fas fa-chart-line"></i> Reportes</button>
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
                            @if (false)
                                <a href="{{ route('itar.index') }}">
                                    <button class="btn btn-success">

                                        Agregar PPA

                                    </button>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalGenerales" tabindex="-1" role="dialog" aria-labelledby="accionModalLabel"
        aria-hidden="true" style="color: black!important">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="accionModalLabel">Datos Generales y Alineación del PPA</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <div style="width: 100%;" id="infoPPA">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                    role="tab" aria-controls="nav-home" aria-selected="true">Datos Generales<span
                                        id="objseleccionados"></span></a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                    role="tab" aria-controls="nav-profile" aria-selected="false">Alineacion<span
                                        id="objodsseleccionados"></span></a>
                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                                    role="tab" aria-controls="nav-contact" aria-selected="false">Bienes o
                                    Servicios<span id="programasseleccionados"></span></a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home"
                                role="tabpanel"aria-labelledby="nav-home-tab">
                                <div style="padding:20px;">
                                    <table style="width: 100%">
                                        <tr>
                                            <td class="enc1" title="Tipo de PPA"> Tipo:
                                                <span style="color: red">*</span>
                                                <br />
                                            </td>
                                            <td colspan="4">
                                                <table style="width: 100%;">
                                                    <tr style="">
                                                        <td class="" colspan=""
                                                            style="text-align: center;border:solid 1px rgb(218, 218, 218);">
                                                            <input type="radio" name="tipo" value="programa"
                                                                id="programa" onclick="voidReglas()"
                                                                style="transform:scale(1)" checked/> &nbsp; Programa
                                                        </td>
                                                        <td class="" colspan="" id="reglasDisplay"
                                                            style="text-align: center; border:solid 1px rgb(218, 218, 218);display:none;">
                                                            <table style="width: 100%">
                                                                <tr>
                                                                    <td rowspan="2">Reglas de Operación</td>
                                                                    <td rowspan=""><input type="radio"
                                                                            name="reglas" value="si" id="reglassi"
                                                                            class="radio" style="transform:scale(1)"
                                                                             checked/>
                                                                        &nbsp; Si</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="radio" value="no"
                                                                            name="reglas" class="radio" id="reglasno"
                                                                            style="transform:scale(1)"
                                                                             />
                                                                        &nbsp; No</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="" colspan=""
                                                            style="text-align: center;border:solid 1px rgb(218, 218, 218);">
                                                            <input type="radio" name="tipo" value="proyecto"
                                                                id="proyecto" class="radio" onclick="voidReglas()"
                                                                style="transform:scale(1)"
                                                                 />
                                                            &nbsp; Proyecto
                                                        </td>
                                                        <td class="" colspan="1"
                                                            style="text-align: center;border:solid 1px rgb(218, 218, 218);">
                                                            <input type="radio" name="tipo" value="accion"
                                                                class="radio" id="accion" onclick="voidReglas()"
                                                                style="transform:scale(1)"
                                                                 />
                                                            &nbsp; Acción
                                                        </td>
                                                    </tr>                                                   
                                                </table>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="enc1" style="width: 15%">Objetivo: <i
                                                    class="fas fa-question-circle"></i></td>
                                            <td class="" colspan="3">
                                                <textarea class="form-control" name="objetivo" id="objetivo" cols="30" rows="2"
                                                    placeholder="Indica el Objetivo del PPA"></textarea>
                                                <div class="invalid-feedback">
                                                    Debe Indicar el Objetivo del PPA
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="enc1" style="width: 15%">Descripción: <i
                                                    class="fas fa-question-circle"></i></td>
                                            <td class="" colspan="3">
                                                <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="2"
                                                    placeholder="Indica la Descripción del PPA"></textarea>
                                                <div class="invalid-feedback">
                                                    Debe Indicar la Descripción del PPA
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="enc1" style="width: 15%">Cobertura: <i
                                                    class="fas fa-question-circle"></i></td>
                                            <td class="">
                                                <select name="cobertura" id="cobertura" class="form-control">
                                                    <option value="">Seleccione...</option>
                                                    <option value="estatal">Estatal</option>
                                                    <option value="regional">Regional</option>
                                                    <option value="municipal">Municipal</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Debe Indicar la cobertura del PPA
                                                </div>
                                            </td>
                                            <td class="enc1" style="width: 15%">Periodicidad de entrega del Bien o
                                                Servcio: <i class="fas fa-question-circle"></i></td>
                                            <td>
                                                <select name="p_entrega" id="p_entrega" class="form-control">
                                                    <option value="">Seleccione...</option>
                                                    <option value="estatal">Mensual</option>
                                                    <option value="estatal">Bimestral</option>
                                                    <option value="estatal">Trimestral</option>
                                                    <option value="estatal">Anual</option>
                                                    <option value="estatal">No Aplica</option>
                                                    <option value="estatal">Otro (especificar)</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Debe Indicar la periodicidad de entrega
                                                </div>
                                                <input type="text" name="p_otro" id="p_otro" class="form-control"
                                                    placeholder="Indique la Periodicidad" hidden />
                                                <div class="invalid-feedback">
                                                    Debe Indicar la periodicidad de entrega
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="enc1" style="width: 15%">Año de Inicio: <i
                                                    class="fas fa-question-circle"></i></td>
                                            <td>
                                                <input type="text" class="form-control" name="anio_inicio"
                                                    id="anio_inicio" />
                                                <div class="invalid-feedback">
                                                    Indique el año de inicio
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                aria-labelledby="nav-profile-tab">
                            </div>
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel"
                                aria-labelledby="nav-contact-tab">
                                <div class="col-lg-12" style="padding:20px;">
                                    <div class="card shadow">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">Alineación al PED
                                            </h6>
                                        </div>
                                        <div class="card-body">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" onclick="Almacenar()">Almacenar</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div id="result-alert" style="position:absolute;right:10px; top:80px;color:white;padding:18px;display:none">
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#dataTableItar").DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 20],
                order: [
                    [0, 'asc']
                ],
            })
            voidReglas();
        });

        function uptEstado(id, estado) {

            Swal.fire({
                title: '¿Está Seguro?',
                text: "La información del ppa: [" + id + "] " +
                    " no podrá ser modificada, en tanto la ITE realiza la revisión.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, Enviar a Revisión!',
                showCancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('admin.itar.uptestado') }}",
                        data: {
                            idITAR: id,
                            estado: estado,
                            _token: $("input[name='_token']").val()
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            //block(true)
                            $("#btnupt" + id).html('<i class="fas fa-spinner fa-spin"></i>');
                        }
                    }).done(function(response) {
                        if (response.result == "ok") {
                            $("#btnupt" + id).html('<i class="fas fa-paper-plane"></i>');
                            $("#btnupt" + id).addClass('btn-secondary');
                            $("#btnupt" + id).removeClass('btn-warning');
                            $("#btnupt" + id).prop('disabled', true);
                            $("#result-alert").css('background-color', "green");
                            $("#result-alert").html(
                                "El estado del PPA ha sido <b>enviado a revisión</b> correctamente!");
                            $("#result-alert").show("fast");
                            setTimeout(function() {
                                $("#result-alert").hide("slow");
                            }, 3000);

                        } else {
                            $("#btnupt" + id).html('<i class="fas fa-paper-plane"></i>');
                            $("#btnupt" + id).removeClass('btn-warning');
                            $("#btnupt" + id).removeClass('btn-secondary');
                            $("#btnupt" + id).addClass('btn-danger');
                            $("#result-alert").css('background-color', "red");
                            $("#result-alert").html(
                                "Ocurrió un error al tratar de cambiar el estado del PPA!");
                            $("#result-alert").show("fast");
                            setTimeout(function() {
                                $("#result-alert").hide("slow");
                            }, 3000);

                        }
                    }).fail(function(data) {
                        // block(false)
                    });
                }
            });



        }

        function Almacenar() {
            if (validaDatosGenerales()) {
                alert("Se procede con el almacenamiento");
            }
        }

        function validaDatosGenerales() {
            inputs = [
                "objetivo",
                "descripcion",
                "anio_inicio",
            ];
            selects = [
                "cobertura",
                "p_entrega",
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
                if ($("#" + selects[x]).val() == '') {
                    $("#" + selects[x]).addClass("is-invalid");
                    valid = false;
                } else {
                    $("#" + selects[x]).removeClass("is-invalid");
                }
            }

            return valid;
        }
        function voidReglas() {
            if ($("input[name='tipo']:checked").val() != "programa") {
                $("input[name='reglas']:checked").prop("checked", false);
                $("#reglasDisplay").hide("slow");
            } else {
                $("#reglassi").prop("checked", true);
                $("#reglasDisplay").show("slow");
            }

        }
    </script>
@endsection
