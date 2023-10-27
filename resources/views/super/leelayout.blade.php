@extends('layouts.administrador')

@section('content')
    <!-- Content Row -->
    <div class="row">
        <!-- Pending Requests Card Example -->
        <div class="col-xl-12 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <center>
                        <h3>Regitros del Layout!</h3>
                        @csrf
                        <table class="table" style="width:100%">
                            <thead>
                                <tr style="text-align: center">
                                    <th>Seleccionar<input type="checkbox" onchange="selectAll()" id="all" /></th>
                                    <th>Titulo</th>
                                    <th>Nombre</th>
                                    <th>Apellido Paterno</th>
                                    <th>Apellido Materno</th>
                                    <th>Cargo</th>
                                    <th>Tipo de Enlace</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Celular</th>
                                    <th>Tel Oficina</th>
                                    <th>Extensión</th>
                                    <th style="display: none">idDependencia</th>
                                    <th>Dependencia</th>
                                    <th>status</th>

                                </tr>
                            </thead>
                            <tbody>
                                @for ($x = 2; $x <= $sheet->getHighestRow(); $x++)
                                    @php
                                        $siglas = $Dependencia
                                            ::select('dependenciaSiglas')
                                            ->where('idDependencia', $sheet->getCellByColumnAndRow(12, $x))
                                            ->first();
                                    @endphp
                                    <tr id="row{{ $x }}">
                                        <td class="text-center"><input class="enlace" type="checkbox" name="enlace"
                                                id="enlace{{ $x }}" enlace="{{$x}}" /></td>
                                        <td><input class="form-control titulo" type="text"
                                                value="{{ $sheet->getCellByColumnAndRow(1, $x) }}" id="titulo{{$x}}" /></td>
                                        <td><input class="form-control nombre" type="text"
                                                value="{{ $sheet->getCellByColumnAndRow(2, $x) }}" id="nombre{{$x}}" /></td>
                                        <td><input class="form-control apellidop" type="text"
                                                value="{{ $sheet->getCellByColumnAndRow(3, $x) }}" id="apellidop{{$x}}" /></td>
                                        <td><input class="form-control apellidom" type="text"
                                                value="{{ $sheet->getCellByColumnAndRow(4, $x) }}" id="apellidom{{$x}}" /></td>
                                        <td><input class="form-control cargo" type="text"
                                                value="{{ $sheet->getCellByColumnAndRow(5, $x) }}" id="cargo{{$x}}" /></td>
                                        <td><input class="form-control tipo" type="text"
                                                value="{{ $sheet->getCellByColumnAndRow(6, $x) }}" id="tipo{{$x}}" /></td>
                                        <td><input class="form-control email" type="text"
                                                value="{{ $sheet->getCellByColumnAndRow(7, $x) }}" id="email{{$x}}" /></td>
                                        <td><input class="form-control telefono" type="text"
                                                value="{{ $sheet->getCellByColumnAndRow(8, $x) }}" id="telefono{{$x}}" /></td>
                                        <td><input class="form-control celular" type="text"
                                                value="{{ $sheet->getCellByColumnAndRow(9, $x) }}" id="celular{{$x}}" /></td>
                                        <td><input class="form-control teloficina" type="text"
                                                value="{{ $sheet->getCellByColumnAndRow(10, $x) }}" id="teloficina{{$x}}" /></td>
                                        <td><input class="form-control extension" type="text"
                                                value="{{ $sheet->getCellByColumnAndRow(11, $x) }}" id="extension{{$x}}" /></td>
                                        <td style="display: none"><input class="form-control iddependencia" type="text"
                                                value="{{ $sheet->getCellByColumnAndRow(12, $x) }}" id="iddependencia{{$x}}" /></td>
                                        <td><input class="form-control" type="text" name="dependencia[]" readonly
                                                value="{{ $siglas != null ? $siglas->dependenciaSiglas : '' }}" /></td>
                                        <td class="text-center status" id="status{{$x}}">

                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>

                    </center>
                </div>
                <div class="card-footer text-right">
                    <a href="{{route('enlaces')}}"><button type="button" class="btn btn-secondary">Cancelar</button></a>
                    <button type="button" class="btn btn-primary" onclick="loadEnlaces()" id="btnCargar">Cargar Enlaces al
                        Sistema</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function selectAll() {
            if ($("#all").prop("checked")) {
                $(".enlace").each(function(element) {
                    $(this).prop('checked', true);
                });
            } else {
                $(".enlace").each(function(element) {
                    $(this).prop('checked', false);
                });
            }
        }

        function loadEnlaces() {
            contador = 0;
            $("#btnCargar").prop('disabled', true);
            $(".enlace").each(function() {
                if (this.checked) {
                    enlace = $(this).attr("enlace");                    
                    titulo = $("#titulo"+enlace).val();
                    nombre = $("#nombre"+enlace).val();
                    apellidop = $("#apellidop"+enlace).val();
                    apellidom = $("#apellidom"+enlace).val();
                    cargo = $("#cargo"+enlace).val();
                    tipo = $("#tipo"+enlace).val();
                    email = $("#email"+enlace).val();
                    celular = $("#celular"+enlace).val();
                    teloficina = $("#teloficina"+enlace).val();
                    extension = $("#extension"+enlace).val();
                    iddependencia = $("#iddependencia"+enlace).val();
                    _token = $("input[name='_token']").val();
                    data = {
                        titulo: titulo,
                        nombre: nombre,
                        apellidop: apellidop,
                        apellidom: apellidom,
                        cargo: cargo,
                        tipo: tipo,
                        email: email,
                        celular: celular,
                        teloficina: teloficina,
                        extension: extension,
                        iddependencia: iddependencia,
                        _token: _token
                    }
                    sendBit(data, $(this).attr('enlace'));
                }
                contador++;
            })
            $("#btnCargar").prop('disabled', false);
        }

        function sendBit(data, id) {

            $.ajax({
                type: 'POST',
                url: "{{ route('enlace.upload') }}",
                data: data,
                //contentType: "application/json",
                dataType: "json",
                //processData: false,
                beforeSend: function() {
                    $("#status"+id).html('<i class="fas fa-spinner fa-spin" style="color: gray"></i>');
                }
            }).done(function(response) {
                if (response.success == "ok") {
                    $("#enlace" + id).prop("checked", false);
                    $("#enlace" + id).prop("disabled", true);
                    $("#enlace" + id).removeClass("enlace");
                    $("#status"+id).html('<i class="fas fa-check" style="color: green"></i>');
                    $("#row" + id).addClass("alert alert-success");
                    return true;
                }
            }).fail(function(data) {
                $("#status"+id).html('<i class="fas fa-check" style="color: red"></i>');
                $("#row" + id).addClass("alert alert-warning");
                return false;
            });
        }

        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }
    </script>
@endsection
