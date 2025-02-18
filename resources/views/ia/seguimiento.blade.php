@extends('layouts.administrador')
@section('encabezado')
    ITAR / Seguimiento
@endsection
@section('styles')
<link href="{{ asset('resources/css/dropzone.css') }}" rel="stylesheet" type="text/css">
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
            color: black;
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

        textarea {
            color: black;
        }

        .dropzone{
            background-color: rgb(250, 255, 243);
            border: solid 2px green;
        }

        bss:hover{
            background-color: black;
            color: white;
        }

        .bss div:hover{
            background-color: black;
            color: white;
        }
        .enc4{
            background-color: black;
            color: white;
        }
    </style>
@endsection
@section('content')
    <div class="col-xl-12 col-lg-7">
        @csrf
        <input type="hidden" id="idPPA" value="{{ $infoPPA->id }}">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex align-items-center justify-content-between"
                style="background-color: #681b2e;">
                <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Seguimiento: PPA
                    {{ $infoPPA->id . ' ' . $infoPPA->nombre }}</h6>
                <div class="dropdown no-arrow">
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="indicadorContent">
                <div class="" style="width: 100%;text-align:right">
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 75%;text-align:right"></td>
                            <td style="width:15%;text-align:right">
                                <select class="form-control" style="font-size:1.2em;" onchange="getSeguimiento()"
                                    id="anio">
                                    <option value="">Seleccione Ejercicio</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                </select>
                            </td>
                            <td style="width:10%">
                                <button class="btn btn-primary" onclick="getSeguimiento()"><i class="fas fa-sync"></i> Actualizar</button>
                            </td>
                        </tr>
                    </table>
                </div>
                <hr/>
                <div id="seguimientoContent">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalFuente" tabindex="-1" role="dialog" aria-labelledby="accionModalLabel" data-backdrop="static" data-keyboard="false"
        aria-hidden="true" style="color: black!important">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="accionModalLabel">Fuentes de financiamiento</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 30px;" id="body-fuente">
                    <div style="width: 100%;" id="fuenteFinanciamiento">
                        <input type="hidden" id="ia_presupuesto_tipog_id_temp">
                        <input id="ia_fuente_id" value="" type="hidden">
                        <table>
                            <tr>
                                <td class="enc1">Fuente de financiamiento:<span style="color: red">*</span></td>
                                <td colspan="7">
                                    <select class="form-control" id="fuente_financiamiento" onchange="fotra()">
                                        <option value="">Seleccione</option>
                                        @foreach ($fuentes as $fuente )
                                        <option value="{{$fuente->idFuente}}">{{$fuente->fuente}}</option>                                            
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Debe indicar la fuente de financiamiento.
                                    </div>
                                    <input type="text" id="fotra" class="form-control" placeholder="Indique fuente de financiamiento" style="display:none"/>
                                    <div class="invalid-feedback">
                                        Debe indicar la otra fuente de financiamiento.
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="enc1" style="text-align: center">Monto Federal</td>                               
                                <td class="enc1" style="text-align: center">Monto Estatal</td>
                                <td class="enc1" style="text-align: center">Monto Municipal</td>
                                <td class="enc1" style="text-align: center">Monto Total</td>
                            </tr>
                            <tr>
                                <td><input type="number" class="form-control" style="text-align: right" id="monto_federal" onkeyup="refreshMonto()"/></td>
                                <td><input type="number" class="form-control" style="text-align: right" id="monto_estatal" onkeyup="refreshMonto()"/></td>
                                <td><input type="number" class="form-control" style="text-align: right" id="monto_municipal" onkeyup="refreshMonto()"/></td>
                                <td><input type="number" class="form-control" readonly style="text-align: right" id="monto_total"/></td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <input type="hidden" id="valida_monto">
                                    <div class="invalid-feedback">
                                       Indique algún monto.
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" onclick="almacenarFuente()" id="btnAlmacenarF">Registar Fuente</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalDesglose" tabindex="-1" role="dialog" aria-labelledby="accionModalLabel" data-backdrop="static" data-keyboard="false"
        aria-hidden="true" style="color: black!important">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="accionModalLabel">Desglose de población y/o área de enfoque por región</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 30px;" id="body-desglose">
                    <table style="width: 100%">
                        <tr>
                            <tr><td colspan="13" style="text-align: center;background-color:rgb(243,203,215);color:gray;">Desglose por región <br/> [Seleccione trimestre a mostrar]</td></tr>
                        </tr>
                        <tr>
                            <td colspan="13">
                                <table style="width: 100%">
                                    <tr>
                                        <td style="text-align: center;transform:scale(1.2)"><input type="checkbox" onclick="toggleTrimestre($(this),1)" checked> 1er. Trimestre</td>
                                        <td style="text-align: center;transform:scale(1.2)"><input type="checkbox" onclick="toggleTrimestre($(this),2)" checked> 2do. Trimestre</td>
                                        <td style="text-align: center;transform:scale(1.2)"><input type="checkbox" onclick="toggleTrimestre($(this),3)" checked> 3er. Trimestre</td>
                                        <td style="text-align: center;transform:scale(1.2)"><input type="checkbox" onclick="toggleTrimestre($(this),4)" checked> 4to. Trimestre</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="2" class="enc1" style="width: 15%">Periodo</td>
                            <td colspan="3" class="enc1 trim1" style="text-align: center;">Enero-Marzo</td>
                            <td colspan="3" class="enc1 trim2" style="text-align: center;">Abril-Junio</td>
                            <td colspan="3" class="enc1 trim3" style="text-align: center;">Julio-Septiembre</td>
                            <td colspan="3" class="enc1 trim4" style="text-align: center;">Octubre-Diciembre</td>
                        </tr>
                        <tr style="font-size:.8em;">
                            <td  class="enc1 trim1" style="text-align: center;">hombres</td>
                            <td  class="enc1 trim1" style="text-align: center;">mujeres</td>
                            <td  class="enc1 trim1" style="text-align: center;">otro (area de enfoque)</td>
                            <td  class="enc1 trim2" style="text-align: center;">hombres</td>
                            <td  class="enc1 trim2" style="text-align: center;">mujeres</td>
                            <td  class="enc1 trim2" style="text-align: center;">otro (area de enfoque)</td>
                            <td  class="enc1 trim3" style="text-align: center;">hombres</td>
                            <td  class="enc1 trim3" style="text-align: center;">mujeres</td>
                            <td  class="enc1 trim3" style="text-align: center;">otro (area de enfoque)</td>
                            <td  class="enc1 trim4" style="text-align: center;">hombres</td>
                            <td  class="enc1 trim4" style="text-align: center;">mujeres</td>
                            <td  class="enc1 trim4" style="text-align: center;">otro (area de enfoque)</td>                            
                        </tr>

                        <tr style="">
                            <td   class="enc1" style="text-align: left;">Sierra de Flores Magón</td>
                            <td  class="trim1" style="text-align: center;"><input type="number" class="form-control"/></td>
                            <td  class="trim1" style="text-align: center;"><input type="number" class="form-control"/></td>
                            <td  class="trim1" style="text-align: center;"><input type="number" class="form-control"/></td>
                            <td  class="trim2" style="text-align: center;"><input type="number" class="form-control"/></td>
                            <td  class="trim2" style="text-align: center;"><input type="number" class="form-control"/></td>
                            <td  class="trim2" style="text-align: center;"><input type="number" class="form-control"/></td>
                            <td  class="trim3" style="text-align: center;"><input type="number" class="form-control"/></td>
                            <td  class="trim3" style="text-align: center;"><input type="number" class="form-control"/></td>
                            <td  class="trim3" style="text-align: center;"><input type="number" class="form-control"/></td>
                            <td  class="trim4" style="text-align: center;"><input type="number" class="form-control"/></td>
                            <td  class="trim4" style="text-align: center;"><input type="number" class="form-control"/></td>
                            <td  class="trim4" style="text-align: center;"><input type="number" class="form-control"/></td>                            
                        </tr>

                        <tr style="">
                            <td  class="enc1" style="text-align: left;">Costa</td>
                            <td  class="trim1" style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td  class="trim1" style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td  class="trim1" style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td  class="trim2" style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td  class="trim2" style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td  class="trim2" style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td  class="trim3" style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td  class="trim3" style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td  class="trim3" style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td  class="trim4" style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td  class="trim4" style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td  class="trim4" style="text-align: center;"><input type="number" class="form-control "/></td>                            
                        </tr>

                        <tr style="">
                            <td   class="enc1" style="text-align: left;">Cuenca del Papaloapan</td>
                            <td class="trim1"  style="text-align: center"><input type="number" class="form-control "/></td>
                            <td class="trim1"  style="text-align: center"><input type="number" class="form-control "/></td>
                            <td class="trim1"  style="text-align: center"><input type="number" class="form-control "/></td>
                            <td class="trim2"  style="text-align: center"><input type="number" class="form-control "/></td>
                            <td class="trim2"  style="text-align: center"><input type="number" class="form-control "/></td>
                            <td class="trim2"  style="text-align: center"><input type="number" class="form-control "/></td>
                            <td class="trim3"  style="text-align: center"><input type="number" class="form-control "/></td>
                            <td class="trim3"  style="text-align: center"><input type="number" class="form-control "/></td>
                            <td class="trim3"  style="text-align: center"><input type="number" class="form-control "/></td>
                            <td class="trim4"  style="text-align: center"><input type="number" class="form-control "/></td>
                            <td class="trim4"  style="text-align: center"><input type="number" class="form-control "/></td>
                            <td class="trim4"  style="text-align: center"><input type="number" class="form-control "/></td>                            
                        </tr>
                        <tr style="">
                            <td class="enc1" style="text-align: left;">Istmo</td>
                            <td class="trim1"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim1"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim1"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim2"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim2"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim2"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim3"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim3"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim3"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim4"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim4"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim4"  style="text-align: center;"><input type="number" class="form-control "/></td>                            
                        </tr>
                        <tr style="">
                            <td class="enc1" style="text-align: left;">Mixteca</td>
                            <td class="trim1"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim1"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim1"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim2"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim2"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim2"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim3"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim3"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim3"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim4"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim4"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim4"  style="text-align: center;"><input type="number" class="form-control "/></td>                            
                        </tr>
                        <tr style="">
                            <td class="enc1" style="text-align: left;">Sierra Sur</td>
                            <td class="trim1"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim1"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim1"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim2"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim2"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim2"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim3"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim3"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim3"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim4"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim4"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim4"  style="text-align: center;"><input type="number" class="form-control "/></td>                            
                        </tr>

                        <tr style="">
                            <td class="enc1" style="text-align: left;">Valles Centrales</td>
                            <td class="trim1"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim1"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim1"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim2"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim2"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim2"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim3"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim3"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim3"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim4"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim4"  style="text-align: center;"><input type="number" class="form-control "/></td>
                            <td class="trim4"  style="text-align: center;"><input type="number" class="form-control "/></td>                            
                        </tr>
                        <tr style="">
                            <td class="enc1" style="text-align: left;">Total</td>
                            <td class="enc1 trim1"  style="text-align: righ;"></td>
                            <td class="enc1 trim1"  style="text-align: righ;"></td>
                            <td class="enc1 trim1"  style="text-align: righ;"></td>
                            <td class="enc1 trim2"  style="text-align: righ;"></td>
                            <td class="enc1 trim2"  style="text-align: righ;"></td>
                            <td class="enc1 trim2"  style="text-align: righ;"></td>
                            <td class="enc1 trim3"  style="text-align: right;"></td>
                            <td class="enc1 trim3"  style="text-align: righ;"></td>
                            <td class="enc1 trim3"  style="text-align: righ;"></td>
                            <td class="enc1 trim4"  style="text-align: righ;"></td>
                            <td class="enc1 trim4"  style="text-align: righ;"></td>
                            <td class="enc1 trim4"  style="text-align: righ;"></td>                            
                        </tr>
                    </table>                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" onclick="almacenadesglose()" id="btnAlmacenarF"><i class="fas fa-save"></i> Almacenar Desglose</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{{ asset('resources/js/dropzone-min.js') }}"></script>
    <script>
        function getSeguimiento() {
            if($("#anio").val()!=""){
                anio = $("#anio").val();
                idPPA = $("#idPPA").val();
                $.ajax({
                    type: 'GET',
                    url: "{{ route('ia.getseguimiento') }}",
                    data: {
                        idPPA: $("#idPPA").val(),
                        anio:anio
                    },
                    //dataType: 'json',
                    beforeSend: function() {
                        $("#seguimientoContent").block({
                            message: '<h4>Procesando...</h4>',
                            css: {
                                border: '3px solid gray',
                                backgroundColor: 'black',
                                '-webkit-border-radius': '10px',
                                '-moz-border-radius': '10px',
                                width: "15%",
                                color: "white"
                            }
                        });
                    }
                }).done(function(response) {
                    $("#seguimientoContent").unblock();
                    $("#seguimientoContent").html(response);
                    inicializaDropZone();
                });
            }else{
                $("#seguimientoContent").html("");
            }
            
        }

        function toggle(icon, element) {
            if(element=="body-bsgenerales"){
                if ($("." + element).css("display") == "none") {
                    $("." + element).show("fast");
                    $("#" + icon).removeClass("fa-chevron-right");
                    $("#" + icon).addClass("fa-chevron-down");
                } else {
                    $("." + element).hide("fast");
                    $("#" + icon).removeClass("fa-chevron-down");
                    $("#" + icon).addClass("fa-chevron-right");
                }

            }else{
                if ($("#" + element).css("display") == "none") {
                    $("#" + element).show("fast");
                    $("#" + icon).removeClass("fa-chevron-right");
                    $("#" + icon).addClass("fa-chevron-down");
                } else {
                    $("#" + element).hide("fast");
                    $("#" + icon).removeClass("fa-chevron-down");
                    $("#" + icon).addClass("fa-chevron-right");
                }
            }

            

        }

        function addPrograma(tipo){
            $.ajax({
                    type: 'POST',
                    url: "{{ route('ia.addprograma') }}",
                    data: {
                        ia_presupuesto_general_id: $("#ia_presupuesto_general_id").val(),
                        tipo:tipo,
                        anio:$("#anio").val(),
                        _token:$("input[name='_token']").val()
                    },
                    //dataType: 'json',
                    beforeSend: function() {
                        if(tipo=="operativo"){
                            $("#programasContent").block({
                                message: '<h4>Procesando...</h4>',
                                css: {
                                    border: '3px solid gray',
                                    backgroundColor: 'black',
                                    '-webkit-border-radius': '10px',
                                    '-moz-border-radius': '10px',
                                    width: "15%",
                                    color: "white"
                                }
                            });
                        }else{
                            $("#programasInvContent").block({
                                message: '<h4>Procesando...</h4>',
                                css: {
                                    border: '3px solid gray',
                                    backgroundColor: 'black',
                                    '-webkit-border-radius': '10px',
                                    '-moz-border-radius': '10px',
                                    width: "15%",
                                    color: "white"
                                }
                            }); 
                        }
                    }
                }).done(function(response) {        
                    if(tipo=="operativo"){
                        $("#programasContent").unblock();
                        $("#programasContent").append(response);
                    }   else{
                        $("#programasInvContent").unblock();
                        $("#programasInvContent").append(response);
                    }         
                    
                   
                });
        }

        function removePrograma(ia_presupuesto_tipog_id){
            Swal.fire({
                            icon: 'question',
                            title: 'Presupuesto General por año',
                            text: "¿Está seguro de querer eliminar este registro de Programa presupuestario?, tome en cuenta que toda la información reportada con respecto a este programa será eliminada permanentemente.",                                                                      
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Sí, Eliminar!',
                            showCancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                        type: 'POST',
                                        url: "{{ route('ia.removeprograma') }}",
                                        data: {ia_presupuesto_tipog_id : ia_presupuesto_tipog_id,_token:$("input[name='_token']").val()},
                                        dataType: 'json',
                                        beforeSend: function() {
                                            $("#programasContent").block({
                                                message: '<h4>Procesando...</h4>',
                                                css: { border: '3px solid gray', backgroundColor:'black','-webkit-border-radius': '10px','-moz-border-radius':'10px',width:"15%",color:"white" }
                                            });
                                            //block(true);
                                        }
                                    }).done(function(response) {
                                        //block(false);
                                        $("#programasContent").unblock();
                                        if (response.result == "ok") {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Presupuesto General por año',
                                                text: response.message,
                                                confirmButtonColor: '#3085d6',
                                            }).then((result) => {$("#programa"+ia_presupuesto_tipog_id).hide("slow"); setTimeout(() => {
                                                $("#programa"+ia_presupuesto_tipog_id).remove();
                                            }, 500);});                        
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Presupuesto General por año',
                                                text: response.message,
                                                confirmButtonColor: '#3085d6',
                                            }).then((result) => {});
                                        }
                                    });
                            }                        
                        });
        }

        function fuenteFinanciamiento(ia_presupuesto_tipog_id){
            limpiaFormFuente();
            $("#ia_presupuesto_tipog_id_temp").val(ia_presupuesto_tipog_id);
            $("#modalFuente").modal("show");
        }

        function fotra(){
            if($("#fuente_financiamiento option:selected").text()=="Otro"){
                $("#fotra").show("slow");
            }else{
                $("#fotra").hide("slow");
            }
        }
        
        function almacenarFuente(){
            if(validaFuente()){
                ia_presupuesto_tipog_id_temp = $("#ia_presupuesto_tipog_id_temp").val();
                if(ia_presupuesto_general_id != ""){
                    //procedemos al almacenamiento de la fuente
                    data = {
                    ia_presupuesto_tipog_id:ia_presupuesto_tipog_id_temp,
                    ia_fuente_id : $("#ia_fuente_id").val(),
                    fuente_id : $("#fuente_financiamiento").val(),
                    f_otra : $("#fotra").val(),
                    monto_total : $("#monto_total").val(),
                    monto_estatal : $("#monto_estatal").val(),
                    monto_municipal : $("#monto_municipal").val(),
                    monto_federal : $("#monto_federal").val(),
                    _token : $("input[name='_token']").val()
                    }
                    $.ajax({
                    type: 'POST',
                    url: "{{ route('ia.addfuente') }}",
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        $("#fuenteFinanciamiento").block({
                            message: '<h4>Procesando...</h4>',
                            css: {
                                border: '3px solid gray',
                                backgroundColor: 'black',
                                '-webkit-border-radius': '10px',
                                '-moz-border-radius': '10px',
                                width: "15%",
                                color: "white"
                            }
                        });
                    }
                    }).done(function(response) {
                        $("#fuenteFinanciamiento").unblock();
                        if(response.result == "ok"){
                            Swal.fire({
                            icon: 'success',
                            title: 'Registro de fuentes de financiamiento',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                                $("#modalFuente").modal("hide");
                                limpiaFormFuente();
                                getFuentes(ia_presupuesto_tipog_id_temp);
                            });
                        }else{
                            Swal.fire({
                            icon: 'error',
                            title: 'Registro de fuentes de financiamiento',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
                        }
                        //$("#seguimientoContent").html(response);
                    });   
                }
            }else{
                Swal.fire({
                            icon: 'warning',
                            title: 'Validación de Datos de Fuente de Financiamiento',
                            text: "Favor de atender las observaciones marcadas en rojo.",
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
            }
        }

        function validaFuente() {
            inputs = [
                
            ];
            selects = [
                "fuente_financiamiento",               
            ];

            
            if($("#fuente_financiamiento option:selected").text()=="Otro"){                
                inputs.push("fotra");                
            }else{            
                index = inputs.indexOf("fotra")
                if(index){
                    inputs.splice(index,0)
                    $("#fotra").removeClass("is-invalid");
                }                
            }
            
            valid = true;        

            $monto_total = $("#monto_total").val();
            if($monto_total.length == 0){
                valid=false;
                $("#valida_monto").addClass("is-invalid");
            }else{
                valid=true;
                $("#valida_monto").removeClass("is-invalid");
            }

            for (var x = 0; x < inputs.length; x++) {
                if ($("#" + inputs[x]).val().trim().length == 0) {
                    $("#" + inputs[x]).addClass("is-invalid");
                    valid = false;
                } else {
                    $("#" + inputs[x]).removeClass("is-invalid");
                }
            }
            
            for (var x = 0; x < selects.length; x++) {
                if ($("#" + selects[x]).val() == "") {
                    $("#" + selects[x]).addClass("is-invalid");
                    valid = false;
                } else {
                    $("#" + selects[x]).removeClass("is-invalid");
                }
            }   
            return valid;
        }

        function refreshMonto(){
            monto_federal = parseFloat($("#monto_federal").val()==""?0:$("#monto_federal").val());
            monto_estatal = parseFloat($("#monto_estatal").val()==""?0:$("#monto_estatal").val());
            monto_municipal = parseFloat( $("#monto_municipal").val()==""?0:$("#monto_municipal").val());
            total = monto_federal + monto_estatal + monto_municipal;
            $("#monto_total").val(total);            
        }

        function getFuentes(ia_presupuesto_tipog_id){
            $.ajax({
                    type: 'GET',
                    url: "{{ route('ia.getfuentes') }}",
                    data: {ia_presupuesto_tipog_id:ia_presupuesto_tipog_id},
                    //dataType: 'json',
                    beforeSend: function() {
                        $("#tabla_presupuesto"+ia_presupuesto_tipog_id).block({
                            message: '<h4>Procesando...</h4>',
                            css: {
                                border: '3px solid gray',
                                backgroundColor: 'black',
                                '-webkit-border-radius': '10px',
                                '-moz-border-radius': '10px',
                                width: "15%",
                                color: "white"
                            }
                        });
                    }
                    }).done(function(response) {
                        $("#tabla_presupuesto"+ia_presupuesto_tipog_id).unblock();
                        $("#tabla_presupuesto"+ia_presupuesto_tipog_id).html(response);                        
                    }); 
        }

        function limpiaFormFuente(){
            $("#fuente_financiamiento").val("");
            $("#fotra").val("");
            $("#monto_federal").val("");
            $("#monto_estatal").val("");
            $("#monto_municipal").val("");
            $("#ia_presupuesto_tipog_id_temp").val("");
            $("#ia_fuente_id").val("");
            $("#monto_total").val("");
            $("#fuente_financiamiento").removeClass("is-invalid");
            $("#fotra").removeClass("is-invalid");
            $("#valida_monto").removeClass("is-invalid");

        }

        function getInfoFuente(ia_fuente_id){
            $.ajax({
                    type: 'GET',
                    url: "{{ route('ia.getinfofuente') }}",
                    data: {ia_fuente_id:ia_fuente_id},
                    //dataType: 'json',
                    beforeSend: function() {
                        $("#body-fuente").block({
                            message: '<h4>Procesando...</h4>',
                            css: {
                                border: '3px solid gray',
                                backgroundColor: 'black',
                                '-webkit-border-radius': '10px',
                                '-moz-border-radius': '10px',
                                width: "15%",
                                color: "white"
                            }
                        });
                    }
                    }).done(function(response) {
                        $("#modalFuente").modal("show");
                        $("#body-fuente").unblock();
                        $("#body-fuente").html(response);                        
                    });
        }

        function removeFuente(ia_fuente_id){
            Swal.fire({
                            icon: 'question',
                            title: 'Presupuesto General por año, fuentes',
                            text: "¿Está seguro de querer eliminar este registro de Fuente de financiamiento?, este registro será eliminado permanentemente.",                                                                      
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Sí, Eliminar!',
                            showCancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                        type: 'POST',
                                        url: "{{ route('ia.removefuente') }}",
                                        data: {ia_fuente_id : ia_fuente_id,_token:$("input[name='_token']").val()},
                                        dataType: 'json',
                                        beforeSend: function() {
                                            $("#fuente"+ia_fuente_id).block({
                                                message: '<h4>Procesando...</h4>',
                                                css: { border: '3px solid gray', backgroundColor:'black','-webkit-border-radius': '10px','-moz-border-radius':'10px',width:"15%",color:"white" }
                                            });
                                            //block(true);
                                        }
                                    }).done(function(response) {
                                        //block(false);
                                        $("#fuente"+ia_fuente_id).unblock();
                                        if (response.result == "ok") {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Presupuesto General por año, fuente de financiamiento',
                                                text: response.message,
                                                confirmButtonColor: '#3085d6',
                                            }).then((result) => {$("#fuente"+ia_fuente_id).hide("slow"); setTimeout(() => {
                                                $("#fuente"+ia_fuente_id).remove();
                                            }, 500);});                        
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Presupuesto General por año, fuente de financiamiento',
                                                text: response.message,
                                                confirmButtonColor: '#3085d6',
                                            }).then((result) => {});
                                        }
                                    });
                            }                        
                        });
        }

        function almacenaCambios(){
            if(validaPresupuesto()){ //&& validaMetas()){
                //obtenemos los datos del prespuesto
                contador = 0;
                presupuestos = "";
                $(".ia_presupuesto_tipog_id").each(function(){
                    pp_id = $(".pp_id").eq(contador).val();
                    componente = $(".componente").eq(contador).val();
                    presupuestos += $(this).val()+"|"+pp_id+"|"+componente+"&";    
                    contador++;                
                });
                data = {presupuestos:presupuestos,_token:$("input[name='_token']").val(),idPoblacion:$("#idPoblacion").val(),tipoP:$("#tipoP").val(),anio:$("#anio").val(),idPPA:$("#idPPA").val()};
                if($("#tipoP").val().includes("p_")){
                    data.mujeres = $("#mujeres").val();
                    data.hombres = $("#hombres").val();                                        
                    data.total = $("#total").val();
                }

                if($("#tipoP").val().includes("a_")){
                    data.total_area = $("#total_area").val();
                }


                //agregamos la información del impacto
                impacto = $("#social").prop("checked")?"social ":"";
                impacto += $("#economico").prop("checked")?"economico ":"";
                impacto += $("#ambiental").prop("checked")?"ambiental ":"";
                descripcion_impacto = $("#descripcion_impacto").val();

                data.impacto = impacto;
                data.descripcion_impacto = descripcion_impacto;

                //agregamos las descripciones de los medios de verificacion
                medios = "";
                contador = 0;
                $(".medioia").each(function(){
                    medios += $(this).attr("idMedio")+"|"+$(".descripcionmedioia").eq(contador).val()+"&";
                    contador++;
                });

                data.medios = medios;

                //agregamos datos de las observaciones
                if($("#trimestre_obs").val()!=""){
                    data.observaciones = $("#idObservacion").val()+"|"+$("#observaciones").val();
                    data.trimestre_obs = $("#trimestre_obs").val();
                }else{
                    data.observaciones = "";
                    data.trimestre_obs = "";
                    
                }                
                
                $.ajax({
                    type: 'POST',
                    url: "{{ route('ia.updateseguimiento') }}",
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        $("#seguimientoContent").block({
                            message: '<h4>Procesando...</h4>',
                            css: {
                                border: '3px solid gray',
                                backgroundColor: 'black',
                                '-webkit-border-radius': '10px',
                                '-moz-border-radius': '10px',
                                width: "15%",
                                color: "white"
                            }
                        });
                    }
                    }).done(function(response) {
                        $("#seguimientoContent").unblock();
                        if(response.result == "ok"){
                            Swal.fire({
                            icon: 'success',
                            title: 'Actualización de datos de seguimiento',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                                getSeguimiento();
                            });
                        }else{
                            Swal.fire({
                            icon: 'error',
                            title: 'Actualización de datos de seguimiento',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
                        }
                        //$("#seguimientoContent").html(response);
                    });    
            }else{
                Swal.fire({
                            icon: 'warning',
                            title: 'Validación de Datos de seguimiento',
                            text: "Favor de atender las observaciones marcadas en rojo.",
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
            }
        }

        function validaPresupuesto(){
                valid=true;

                $(".pp_id").each(function(){
                    if ($(this).val() == "") {
                        $(this).addClass("is-invalid");
                        valid = false;
                    } else {
                        $(this).removeClass("is-invalid");
                    }
                });

                $(".componente").each(function(){
                    if ($(this).val() == "") {
                        $(this).addClass("is-invalid");
                        valid = false;
                    } else {
                        $(this).removeClass("is-invalid");
                    }
                });

                inputs = [                    
                    "descripcion_impacto"
                ];
                selects = [
                    ,               
                ];

                if($("#tipoP").val().includes("p_")){
                    inputs.push("mujeres");
                    inputs.push("hombres");
                    inputs.push("total");
                }

                if($("#tipoP").val().includes("a_")){
                    inputs.push("total_area");
                }

                for (var x = 0; x < inputs.length; x++) {
                    if ($("#" + inputs[x]).val().trim().length == 0) {
                        $("#" + inputs[x]).addClass("is-invalid");
                        valid = false;
                    } else {
                        $("#" + inputs[x]).removeClass("is-invalid");
                    }
                }
                
                for (var x = 0; x < selects.length; x++) {
                    if ($("#" + selects[x]).val() == "") {
                        $("#" + selects[x]).addClass("is-invalid");
                        valid = false;
                    } else {
                        $("#" + selects[x]).removeClass("is-invalid");
                    }
                }

                //validamos el apartado de Impacto
                if(!$("#social").prop("checked") && !$("#economico").prop("checked") && !$("#ambiental").prop("checked")){
                    $("#impacto_seleccion").addClass("is-invalid");
                    valid=false;
                }else{
                    $("#impacto_seleccion").removeClass("is-invalid");
                }
                
                
                return valid;
        }

        function refreshPoblacion(){
            mujeres = parseInt($("#mujeres").val()==""?0:$("#mujeres").val());
            hombres = parseInt($("#hombres").val()==""?0:$("#hombres").val());
            total = mujeres + hombres;
            $("#total").val(total);
        }

        function inicializaDropZone() {
            miareadecarga = new Dropzone("#medios-ppa", {
                thumbnailWidth: 500,
                maxFilesize: 5,
                //disablePreviews:true,
                acceptedFiles: ".jpg,.jpeg,.png,.tiff,.raw,.pdf,.zip,.docx,.xlsx,.doc,.xls,application/x-zip-compressed,application/zip",
                buttonRemove: true
            });
            miareadecarga.on("addedfile", file => {
                //idIndicador = $("#idIndicador").val();
            });

            miareadecarga.on("success", function(file, response) {
                if (response.success == "ok") {
                    nombre = file.name;
                    filename = response.filename;
                   /* rowmedio = '<tr id="rowmedio' + response.random + '">' +
                        '<td class="medioppa" medio="' + filename +
                        '" ><a target="blank_" href="{{ asset('medios') }}' + '/itar/'+response.idPPA+"/"+response.anio+"/"+response.trimestre+"/" + filename + '">' + nombre +
                        '</a><input type="hidden" value="' + filename +
                        '" name="mediooriginal[]"/><input type="hidden" value="' + nombre +
                        '" name="medioreal[]"/></td>' +
                        '<td><textarea placeholder="Agrega Descripción" class="medioppa form-control" name="descripcionmedio[]"></textarea></td>' +
                        '<td><button type="button" class="btn btn-danger" onclick="deleteMedio(' + response.random +
                        ',\'' + response.extension + '\')"><i class="fas fa-trash"></i></button></td>' +
                        '</tr>';*/
                    //$("#medios_cargados").append(rowmedio).show("slow");
                    getMedios(response.idPPA,response.anio,response.trimestre);
                }
            });
        }

        function showMedios(){
            trim = $("#trim").val();
            if(trim == ""){
                $("#areaDropzone").hide("slow");
                $("#trim_M").val("");
                $("#medios_cargados").html("");
            }else{
                $("#areaDropzone").show("slow");
                $("#trim_M").val(trim);
                getMedios($("#idPPA").val(),$("#anio").val(),$("#trim").val());                
            }        
        }

        function getMedios(idPPA,anio,trimestre){
            $.ajax({
                    type: 'GET',
                    url: "{{ route('ia.getmedios') }}",
                    data: {idPPA:idPPA,anio:anio,trimestre:trimestre},
                    //dataType: 'json',
                    beforeSend: function() {
                        $("#medios_cargados").block({
                            message: '<h7>Procesando...</h7>',
                            css: {
                                border: '3px solid gray',
                                backgroundColor: 'black',
                                '-webkit-border-radius': '10px',
                                '-moz-border-radius': '10px',
                                width: "15%",
                                color: "white",                                
                            }
                        });
                    }
                    }).done(function(response) {                        
                        $("#medios_cargados").unblock();
                        $("#medios_cargados").html(response);
                    });
        }

        function deleteMedio(idMedio){
            Swal.fire({
                            icon: 'question',
                            title: 'Medios de verificación',
                            text: "¿Está seguro de querer eliminar este medio de verificación?, este registro será eliminado permanentemente.",                                                                      
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Sí, Eliminar!',
                            showCancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                        type: 'POST',
                                        url: "{{ route('ia.removemedio') }}",
                                        data: {idMedio : idMedio,_token:$("input[name='_token']").val()},
                                        dataType: 'json',
                                        beforeSend: function() {
                                            $("#medios_cargados").block({
                                                message: '<h4>Procesando...</h4>',
                                                css: { border: '3px solid gray', backgroundColor:'black','-webkit-border-radius': '10px','-moz-border-radius':'10px',width:"15%",color:"white" }
                                            });
                                            //block(true);
                                        }
                                    }).done(function(response) {
                                        //block(false);
                                        $("#medios_cargados").unblock();
                                        if (response.result == "ok") {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Medios de verificación',
                                                text: response.message,
                                                confirmButtonColor: '#3085d6',
                                            }).then((result) => {getMedios($("#idPPA").val(),$("#anio").val(),$("#trim").val())});                        
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Medios de verificación',
                                                text: response.message,
                                                confirmButtonColor: '#3085d6',
                                            }).then((result) => {});
                                        }
                                    });
                            }                        
                        });
        }

        function showObservaciones(){
            $trimestre = $("#trimestre_obs").val();
            if($trimestre!=""){
                $("#rowObservaciones").show("slow");
                $.ajax({
                    type: 'GET',
                    url: "{{ route('ia.getobservaciones') }}",
                    data: {idPPA:$("#idPPA").val(),anio:$("#anio").val(),trimestre:$("#trimestre_obs").val()},
                    //dataType: 'json',
                    beforeSend: function() {
                        $("#rowObservaciones").block({
                            message: '<h7>Procesando...</h7>',
                            css: {
                                border: '3px solid gray',
                                backgroundColor: 'black',
                                '-webkit-border-radius': '10px',
                                '-moz-border-radius': '10px',
                                width: "15%",
                                color: "white",                                
                            }
                        });
                    }
                    }).done(function(response) {                        
                        $("#rowObservaciones").unblock();
                        $("#rowObservaciones").html(response);
                    });                
            }else{
                $("#observaciones").val("");
                $("#idObservacion").val("");
                $("#rowObservaciones").hide("slow");
            }
        }

        function getInfoMonitoreo(idBS){

            $.ajax({
                    type: 'GET',
                    url: "{{ route('ia.getmonitoreo') }}",
                    data: {idBS:idBS,idPPA:$("#idPPA").val(),anio:$("#anio").val()},
                    //dataType: 'json',
                    beforeSend: function() {
                        $("#monitoreo-bs").block({
                            message: '<h7>Procesando...</h7>',
                            css: {
                                border: '3px solid gray',
                                backgroundColor: 'black',
                                '-webkit-border-radius': '10px',
                                '-moz-border-radius': '10px',
                                width: "15%",
                                color: "white",                                
                            }
                        });
                    }
                    }).done(function(response) {                        
                        $("#monitoreo-bs").unblock();
                        $("#monitoreo-bs").html(response);
                        $("#row-bss").hide("slow");
                        $("#monitoreo-bs").show("slow");
                    });
            
        }        

        function backListadoBS(){
            $("#row-bss").show("slow");            
            $("#monitoreo-bs").html("");
            $("#monitoreo-bs").hide("slow");
        }

        function showDesglose(){
            $("#modalDesglose").modal("show");
        }

        function toggleTrimestre(elemento,trimestre){
            if(elemento.prop("checked")){
                $(".trim"+trimestre).show("slow");
            }else{
                $(".trim"+trimestre).hide("slow");
            }
        }

        function refreshMetas(){
            //Obtenemos información de los datos por trimestre
            
            p1 = parseFloat($("#1p").val()==""?"0":$("#1p").val());
            p2 = parseFloat($("#2p").val()==""?"0":$("#2p").val());
            p3 = parseFloat($("#3p").val()==""?0:$("#3p").val());
            p4 = parseFloat($("#4p").val()==""?0:$("#4p").val());

            r1 = parseFloat($("#1r").val()==""?0:$("#1r").val());
            r2 = parseFloat($("#2r").val()==""?0:$("#2r").val());
            r3 = parseFloat($("#3r").val()==""?0:$("#3r").val());
            r4 = parseFloat($("#4r").val()==""?0:$("#4r").val());

            a1 = (r1/p1)*100;
            a2 = (r2/p2)*100;
            a3 = (r3/p3)*100;
            a4 = (r4/p4)*100;

            $("#1a").html(isNaN(a1)?"":a1.toFixed(2)+"%");
            $("#2a").html(isNaN(a2)?"":a2.toFixed(2)+"%");
            $("#3a").html(isNaN(a3)?"":a3.toFixed(2)+"%");
            $("#4a").html(isNaN(a4)?"":a4.toFixed(2)+"%");

            tap = p1 + p2 + p3 + p4;
            tar = r1 + r2 + r3 + r4;
            taa = (tar/tap)*100

            $("#tap").html(tap)
            $("#tar").html(tar)
            $("#taa").html(taa.toFixed(2)+"%")


        }

        function validaMetas(){
            valid=true;
            if($("#1p").length>0){
                inputs = [
                        "1p",
                        "2p",
                        "3p",
                        "4p",
                    ];
                    selects = [
                        ,               
                    ];            

                    for (var x = 0; x < inputs.length; x++) {
                        if ($("#" + inputs[x]).val().trim().length == 0) {
                            $("#" + inputs[x]).addClass("is-invalid");
                            valid = false;
                        } else {
                            $("#" + inputs[x]).removeClass("is-invalid");
                        }
                    }
                    
                    for (var x = 0; x < selects.length; x++) {
                        if ($("#" + selects[x]).val() == "") {
                            $("#" + selects[x]).addClass("is-invalid");
                            valid = false;
                        } else {
                            $("#" + selects[x]).removeClass("is-invalid");
                        }
                    }               
                }                                 
                    return valid;
        }

        function refreshPoblacionAtendida(){
            ph1 = parseFloat($("#ph1").val()==""?0:$("#ph1").val());
            ah1 = parseFloat($("#ah1").val()==""?0:$("#ah1").val());
            avh1 = (ah1/ph1)*100;
            $("#avh1").html(isNaN(avh1)?"":avh1.toFixed(2)+"%");

            ph2 = parseFloat($("#ph2").val()==""?0:$("#ph2").val());
            ah2 = parseFloat($("#ah2").val()==""?0:$("#ah2").val());
            avh2 = (ah2/ph2)*100;
            $("#avh2").html(isNaN(avh2)?"":avh2.toFixed(2)+"%");

            ph3 = parseFloat($("#ph3").val()==""?0:$("#ph3").val());
            ah3 = parseFloat($("#ah3").val()==""?0:$("#ah3").val());
            avh3 = (ah3/ph3)*100;
            $("#avh3").html(isNaN(avh3)?"":avh3.toFixed(2)+"%");

            ph4 = parseFloat($("#ph4").val()==""?0:$("#ph4").val());
            ah4 = parseFloat($("#ah4").val()==""?0:$("#ah4").val());
            avh4 = (ah4/ph4)*100;
            $("#avh4").html(isNaN(avh4)?"":avh4.toFixed(2)+"%");

            pm1 = parseFloat($("#pm1").val()==""?0:$("#pm1").val());
            am1 = parseFloat($("#am1").val()==""?0:$("#am1").val());
            avm1 = (am1/pm1)*100;
            $("#avm1").html(isNaN(avm1)?"":avm1.toFixed(2)+"%");

            pm2 = parseFloat($("#pm2").val()==""?0:$("#pm2").val());
            am2 = parseFloat($("#am2").val()==""?0:$("#am2").val());
            avm2 = (am2/pm2)*100;
            $("#avm2").html(isNaN(avm2)?"":avm2.toFixed(2)+"%");

            pm3 = parseFloat($("#pm3").val()==""?0:$("#pm3").val());
            am3 = parseFloat($("#am3").val()==""?0:$("#am3").val());
            avm3 = (am3/pm3)*100;
            $("#avm3").html(isNaN(avm3)?"":avm3.toFixed(2)+"%");

            pm4 = parseFloat($("#pm4").val()==""?0:$("#pm4").val());
            am4 = parseFloat($("#am4").val()==""?0:$("#am4").val());
            avm4 = (am4/pm4)*100;
            $("#avm4").html(isNaN(avm4)?"":avm4.toFixed(2)+"%");

            tp1 = ph1+pm1;
            ta1 = ah1+am1;

            tp2 = ph2+pm2;
            ta2 = ah2+am2;

            tp3 = ph3+pm3;
            ta3 = ah3+am3;

            tp4 = ph4+pm4;
            ta4 = ah4+am4;


            $("#tp1").html((tp1));
            $("#ta1").html((ta1));

            $("#tp2").html((tp2));
            $("#ta2").html((ta2));

            $("#tp3").html((tp3));
            $("#ta3").html((ta3));

            $("#tp4").html((tp4));
            $("#ta4").html((ta4));

            tap1 = (ta1/tp1)*100;
            tap2 = (ta2/tp2)*100;
            tap3 = (ta3/tp3)*100;
            tap4 = (ta4/tp4)*100;

            $("#tap1").html(isNaN(tap1)?"":tap1.toFixed(2)+"%");
            $("#tap2").html(isNaN(tap2)?"":tap2.toFixed(2)+"%");
            $("#tap3").html(isNaN(tap3)?"":tap3.toFixed(2)+"%");
            $("#tap4").html(isNaN(tap4)?"":tap4.toFixed(2)+"%");
        }

        function refreshAreaEnfoque(){            
            arp1 = parseFloat($("#arp1").val()==""?0:$("#arp1").val());
            ara1 = parseFloat($("#ara1").val()==""?0:$("#ara1").val());

            arp2 = parseFloat($("#arp2").val()==""?0:$("#arp2").val());
            ara2 = parseFloat($("#ara2").val()==""?0:$("#ara2").val());

            arp3 = parseFloat($("#arp3").val()==""?0:$("#arp3").val());
            ara3 = parseFloat($("#ara3").val()==""?0:$("#ara3").val());

            arp4 = parseFloat($("#arp4").val()==""?0:$("#arp4").val());
            ara4 = parseFloat($("#ara4").val()==""?0:$("#ara4").val());

            ava1 = (ara1/arp1)*100;
            ava2 = (ara2/arp2)*100;
            ava3 = (ara3/arp3)*100;
            ava4 = (ara4/arp4)*100;

            $("#ava1").html(isNaN(ava1)?"":ava1.toFixed(2)+"%");
            $("#ava2").html(isNaN(ava2)?"":ava2.toFixed(2)+"%");
            $("#ava3").html(isNaN(ava3)?"":ava3.toFixed(2)+"%");
            $("#ava4").html(isNaN(ava4)?"":ava4.toFixed(2)+"%");

        }

        function almacenaMonitoreo(){
            if(validaMetas()){

                //Entregas
                p1 = $("#1p").val();
                p2 = $("#2p").val();
                p3 = $("#3p").val();
                p4 = $("#4p").val();

                r1 = $("#1r").val();
                r2 = $("#2r").val();
                r3 = $("#3r").val();
                r4 = $("#4r").val();

                //Poblacion atendida trimestralmente
                ph1 = $("#ph1").val();
                ah1 = $("#ah1").val();
                ph2 = $("#ph2").val();
                ah2 = $("#ah2").val();
                ph3 = $("#ph3").val();
                ah3 = $("#ah3").val();
                ph4 = $("#ph4").val();
                ah4 = $("#ah4").val();

                pm1 = $("#pm1").val();
                am1 = $("#am1").val();
                pm2 = $("#pm2").val();
                am2 = $("#am2").val();
                pm3 = $("#pm3").val();
                am3 = $("#am3").val();
                pm4 = $("#pm4").val();
                am4 = $("#am4").val();

                //Area de enfoque si fuera el caso
                arp1 = $("#arp1").val();
                ara1 = $("#ara1").val();
                arp2 = $("#arp2").val();
                ara2 = $("#ara2").val();
                arp3 = $("#arp3").val();
                ara3 = $("#ara3").val();
                arp4 = $("#arp4").val();
                ara4 = $("#ara4").val();





                data = {_token:$("input[name='_token']").val(),anio:$("#anio").val(),
                            p1:p1,
                            p2:p2,
                            p3:p3,
                            p4:p4,
                            r1:r1,
                            r2:r2,
                            r3:r3,
                            r4:r4,
                            idBS:$("#idBS").val(),
                            ph1:ph1,
                            ah1:ah1,
                            ph2:ph2,
                            ah2:ah2,
                            ph3:ph3,
                            ah3:ah3,
                            ph4:ph4,
                            ah4:ah4,
                            pm1:pm1,
                            am1:am1,
                            pm2:pm2,
                            am2:am2,
                            pm3:pm3,
                            am3:am3,
                            pm4:pm4,
                            am4:am4,
                            arp1:arp1,
                            ara1:ara1,
                            arp2:arp2,
                            ara2:ara2,
                            arp3:arp3,
                            ara3:ara3,
                            arp4:arp4,
                            ara4:ara4,
                        };

                $.ajax({
                    type: 'POST',
                    url: "{{ route('ia.almacenamonitoreo') }}",
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        $("#monitoreo-bs").block({
                            message: '<h4>Procesando...</h4>',
                            css: {
                                border: '3px solid gray',
                                backgroundColor: 'black',
                                '-webkit-border-radius': '10px',
                                '-moz-border-radius': '10px',
                                width: "15%",
                                color: "white"
                            }
                        });
                    }
                    }).done(function(response) {
                        $("#monitoreo-bs").unblock();
                        if(response.result == "ok"){
                            Swal.fire({
                            icon: 'success',
                            title: 'Monitoreo de Metas por Bien o Servicio',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                                getInfoMonitoreo($("#idBS").val());
                            });
                        }else{
                            Swal.fire({
                            icon: 'error',
                            title: 'Monitoreo de Metas por Bien o Servicio',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
                        }                        
                    });





            }
        }

        function selectAtencion(atencion){
            alert($("#select_"+atencion).attr("seleccionado"));
            if($("#select_"+atencion).prop("seleccionado")){
                $("#select_"+atencion).prop("seleccionado",false)
                $("#select_"+atencion).css("backgorund-color","gray");
            }else{
                $("#select_"+atencion).prop("seleccionado",true)
                $("#select_"+atencion).css("backgorund-color","green");
            }
        }
    </script>
@endsection
