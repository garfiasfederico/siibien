@extends('layouts.administrador')
@section('encabezado')

    ITAR / Seguimiento 
    @if (auth()->user()->hasRole("administrador") || auth()->user()->hasRole("administrador_itar") )
        <a href="{{ route('admin.nuevoitar') }}"><button class="btn btn-secondary"><i class="fas fa-arrow-left"></i> <i class="fas fa-home"></i> Tablero de PPAs</button></a>
    @else
        <a href="{{ route('itar.listado') }}"><button class="btn btn-secondary"><i class="fas fa-arrow-left"></i> <i class="fas fa-home"></i> Tablero de PPAs</button></a>
    @endif

        

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
            background-color: rgb(255, 195, 195);
            color: gray;
            border-radius: 5px;
            text-align: center;
            padding: 10px;
            border:solid 1px red;
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
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" onclick="almacenaDesglose()" id="btnAlmacenarD"><i class="fas fa-save"></i> Almacenar Desglose</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalCargaMunicipios" tabindex="-1" role="dialog" aria-labelledby="accionModalLabel" data-backdrop="static" data-keyboard="false"
        aria-hidden="true" style="color: black!important">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="accionModalLabel">Carga de desglose por municipios</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 30px;" id="body-municipios">      
                    <div> <span style="font-weight: bold">Instrucciones:</span> Para realizar la carga del concentrado de atención por municipio se deberá descargar la <b><a href="{{route("ia.descargaplantilladesglose")}}">PLANTILLA</a></b> de carga y a continuación se rellenará con la información correspondiente. Posteriormente, la carga del archivo con la información deberá ser cargado en la siguiente área.</div>
                    <hr/>
                    <table>
                        <tr>
                            <td class="">Año:</td>
                            <td id="anio_desglose" style="font-size: 1.3em;font-weight:bold"></td>
                        </tr>
                    </table>
                    <div>
                        <center style="max-height:500px; overflow:auto">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist" style="">
                                    <a class="nav-item nav-link active" id="nav-carga-tab" data-toggle="tab" href="#nav-carga"
                                        role="tab" aria-controls="nav-carga" aria-selected="true">Carga de plantilla<span
                                            id="carga-n"></span></a>
                                    <a class="nav-item nav-link" id="nav-desglose-tab" data-toggle="tab" href="#nav-desglose"
                                        role="tab" aria-controls="nav-desglose" aria-selected="true">Desglose municipal registrado<span
                                            id="desglose-n"></span></a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-carga" role="tabpanel"aria-labelledby="nav-carga-tab">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td style="width:40%;vertical-align:top">
                                                <table style="width: 100%">                                                    
                                                    <tr>
                                                        <td class="enc2">Trimestre:</td>
                                                        <td>
                                                            <select class="select form-control" id="trimestre_desglose" onclick="changeTrimestre()">
                                                                <option value="">Seleccione</option>
                                                                <option value="1">Primer</option>
                                                                <option value="2">Segundo</option>
                                                                <option value="3">Tercero</option>
                                                                <option value="4">Cuarto</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <form action="{{ route('ia.uploadconcentradomunicipio') }}" method="POST" enctype="multipart/form-data"
                                                class="dropzone" id="medios-municipios" style="color:rgb(0, 0, 0);display:none">
                                                    @csrf
                                                    <input type="hidden" id="trimestre_C" name="trimestre_C" />                                        
                                                    <input type="hidden" id="idBS_C" name="idBS_C" />                                        
                                                    <input type="hidden" id="anio_C" name="anio_C" />
                                                    <input type="hidden" id="idPPA_C" name="idPPA_C" />                                    
                                                </form>
                                            </td>
                                            <td style="vertical-align: top; width:60%;" id="procesamientodesglose">
                                                <table style="width:100%;font-size:.8em;">
                                                    <tr>
                                                        <td colspan="4" class="enc2" style="text-align: center">Municipios procesados</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="enc2" style="text-align: center">Clave</td>
                                                        <td class="enc2" style="text-align: center">Municipio</td>
                                                        <td class="enc2" style="text-align: center">Región</td>
                                                        <td class="enc2" style="text-align: center">Estatus de procesamiento</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>                                                                
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="nav-desglose" role="tabpanel"aria-labelledby="nav-desglose-tab">                                     
                                </div>                                                                                               
                            </div>
                        </center>
                    </div>
                </div>
                <div class="modal-footer">                    
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{{ asset('resources/js/dropzone-min.js') }}"></script>
    <script>
        $(document).ready(function(){
            inicializaDropZoneMunicipios();
            $("#collapse-itar").addClass("show");
        })

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

               /* $(".componente").each(function(){
                    if ($(this).val() == "") {
                        $(this).addClass("is-invalid");
                        valid = false;
                    } else {
                        $(this).removeClass("is-invalid");
                    }
                });*/

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
                                

                if($("#nav-presupuesto").find(".is-invalid").length>0)
                    $("#presupuesto-n").html(" <i class='fas fa-circle' style='color:red;font-size:.8em'></i>");
                else
                    $("#presupuesto-n").html("");
                
                if($("#nav-pa").find(".is-invalid").length>0)
                    $("#pa-n").html(" <i class='fas fa-circle' style='color:red;font-size:.8em'></i>");
                else
                    $("#pa-n").html("");

                if($("#nav-impacto").find(".is-invalid").length>0)
                    $("#impacto-n").html(" <i class='fas fa-circle' style='color:red;font-size:.8em'></i>");
                else
                    $("#impacto-n").html("");
                
                if($("#nav-monitoreo").find(".is-invalid").length>0)
                    $("#monitoreo-n").html(" <i class='fas fa-circle' style='color:red;font-size:.8em'></i>");
                else
                    $("#monitoreo-n").html("");

                if($("#nav-medios").find(".is-invalid").length>0)
                    $("#medios-n").html(" <i class='fas fa-circle' style='color:red;font-size:.8em'></i>");
                else
                    $("#medios-n").html("");

                if($("#nav-obs").find(".is-invalid").length>0)
                    $("#observaciones-n").html(" <i class='fas fa-circle' style='color:red;font-size:.8em'></i>");
                else
                    $("#observaciones-n").html("");
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
                         $('#toggleBS').bootstrapToggle();
                          setAplicaBS();
                    });
            
        }        

        function backListadoBS(){
            $("#row-bss").show("slow");            
            $("#monitoreo-bs").html("");
            $("#monitoreo-bs").hide("slow");
        }

        function showDesglose(idBS){
            ah1 = $("#ah1").val();
            ah2 = $("#ah2").val();
            ah3 = $("#ah3").val();
            ah4 = $("#ah4").val();

            am1 = $("#am1").val();
            am2 = $("#am2").val();
            am3 = $("#am3").val();
            am4 = $("#am4").val();

            ara1 = $("#ara1").val();
            ara2 = $("#ara2").val();
            ara3 = $("#ara3").val();
            ara4 = $("#ara4").val();

            if(ah1 == "" && ah2 == "" && ah3 == "" && ah4 == "" && am1 == "" && am2 == "" && am3 == "" && am4 == "" && ara1 == "" && ara2 == "" && ara3 == "" && ara4 == ""){
                Swal.fire({
                                icon: 'info',
                                title: 'Atención a población o área de enfoque',
                                text: "No existe información de atención de población o de área de enfoque",
                                confirmButtonColor: '#3085d6',
                            }).then((result) => {});
            }else{
                getDesglose();
                $("#modalDesglose").modal("show");
                setTimeout(function(){
                    validaDesglose();                    
                },800)
                
            }


            


           
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
            $("#taa").html(isNaN(taa)?"":taa.toFixed(2)+"%")


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

            thp = ph1 + ph2 + ph3 + ph4;
            tmp = pm1 + pm2 + pm3 + pm4;

            that = ah1 + ah2 + ah3 + ah4;
            tmat = am1 + am2 + am3 + am4;

            tha = (that / thp) * 100;
            tma = (tmat / tmp) * 100;

            ttp = thp + tmp;
            ttat = that + tmat;

            tta = (ttat / ttp) * 100;
            //alert(ttp+" / "+ttat +" = "+tta);

            $("#thp").html(thp);
            $("#tmp").html(tmp);

            $("#that").html(that);
            $("#tmat").html(tmat);

            $("#tha").html(isNaN(tha)?0:tha.toFixed(2)+"%");
            $("#tma").html(isNaN(tma)?0:tma.toFixed(2)+"%");

            $("#ttp").html(ttp);
            $("#ttat").html(ttat);
            $("#tta").html(isNaN(tta)?0:tta.toFixed(2)+"%");



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

            tapr = arp1 + arp2 + arp3 + arp4;
            taat = ara1 + ara2 + ara3 + ara4;
            taav = ( taat / tapr ) * 100;

            $("#tapr").html(tapr);
            $("#taat").html(taat);
            $("#taav").html(isNaN(taav)?0:taav.toFixed(2)+"%")


        }

        function almacenaMonitoreo(){
            if(validaMetas() && validaBSPresupuesto()){

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

                //procesamos prespuesto
                operativo = "";

                $(".operativo_bs").each(function(){
                    pom1 = $(this).find(".pom1").eq(0).val();
                    pom2 = $(this).find(".pom2").eq(0).val();
                    pom3 = $(this).find(".pom3").eq(0).val();
                    pom4 = $(this).find(".pom4").eq(0).val();

                    poe1 = $(this).find(".poe1").eq(0).val();
                    poe2 = $(this).find(".poe2").eq(0).val();
                    poe3 = $(this).find(".poe3").eq(0).val();
                    poe4 = $(this).find(".poe4").eq(0).val();

                    programa = $(this).attr("programa");
                    componente = $(this).find(".componente_bs").eq(0).val();

                    if(pom1!="" || pom2!="" || pom3!="" || pom4!="" || poe1!="" || poe2!="" || poe3!="" || poe4!=""){
                        operativo += programa + "|" + componente + "|" + pom1 + "|" + pom2 + "|" + pom3 + "|" + pom4 + "|" + poe1 + "|" + poe2 + "|" + poe3 + "|" + poe4 + "&"
                    }
                })
                


                inversion = "";
                $(".inversion_bs").each(function(){
                    pim1 = parseFloat($(this).find(".pim1").eq(0).val()==""?0:$(this).find(".pim1").eq(0).val());
                    pim2 = parseFloat($(this).find(".pim2").eq(0).val()==""?0:$(this).find(".pim2").eq(0).val());
                    pim3 = parseFloat($(this).find(".pim3").eq(0).val()==""?0:$(this).find(".pim3").eq(0).val());
                    pim4 = parseFloat($(this).find(".pim4").eq(0).val()==""?0:$(this).find(".pim4").eq(0).val());

                    pie1 =  parseFloat($(this).find(".pie1").eq(0).val()==""?0:$(this).find(".pie1").eq(0).val());
                    pie2 =  parseFloat($(this).find(".pie2").eq(0).val()==""?0:$(this).find(".pie2").eq(0).val());
                    pie3 =  parseFloat($(this).find(".pie3").eq(0).val()==""?0:$(this).find(".pie3").eq(0).val());
                    pie4 =  parseFloat($(this).find(".pie4").eq(0).val()==""?0:$(this).find(".pie4").eq(0).val());

                    programa = $(this).attr("programa");
                    componente = $(this).find(".componente_bs").eq(0).val();

                    if(pim1!="" || pim2!="" || pim3!="" || pim4!="" || pie1!="" || pie2!="" || pie3!="" || pie4!=""){
                        inversion += programa + "|" + componente + "|" + pim1 + "|" + pim2 + "|"  + pim3 + "|"  + pim4 + "|"  + pie1 + "|" + pie2 + "|" + pie3 + "|" + pie4 + "&"; 
                    }
                })
                

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
                            selectp:$("#select_poblacion").attr("seleccionado")==undefined?"false":$("#select_poblacion").attr("seleccionado"),
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
                            selecta:$("#select_area").attr("seleccionado")==undefined?"false":$("#select_area").attr("seleccionado"),
                            arp1:arp1,
                            ara1:ara1,
                            arp2:arp2,
                            ara2:ara2,
                            arp3:arp3,
                            ara3:ara3,
                            arp4:arp4,
                            ara4:ara4,
                            operativo:operativo,
                            inversion:inversion
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
            if($("#select_"+atencion).attr("seleccionado")=="true"){
                $("#select_"+atencion).attr("seleccionado",false)
                $("#select_"+atencion).css("background-color","gray");
                if(atencion=="poblacion"){
                    $("#select_"+atencion).html("Población beneficiada");
                    $(".p_").hide();
                } else{
                    $("#select_"+atencion).html("Área de enfoque atendida");
                    $(".a_").hide();
                }                               
            }else{                
                $("#select_"+atencion).attr("seleccionado",true)
                $("#select_"+atencion).css("background-color","green");
                if(atencion=="poblacion"){
                    $("#select_"+atencion).html("<i class='fas fa-check'></i> Población beneficiada");
                    $(".p_").show("slow");
                } else{
                    $("#select_"+atencion).html("<i class='fas fa-check'></i> Área de enfoque atendida");
                    $(".a_").show("slow");
                } 
            }
        }

        function refreshDesglose(){
            sumah1 = 0;
            sumah2 = 0;
            sumah3 = 0;
            sumah4 = 0;
            
            sumam1 = 0;
            sumam2 = 0;
            sumam3 = 0;
            sumam4 = 0;

            sumao1 = 0;
            sumao2 = 0;
            sumao3 = 0;
            sumao4 = 0;

            for(x=1;x<=8;x++){
                sumah1 += parseFloat($("#h1"+x).val()==""?0:$("#h1"+x).val());
                sumah2 += parseFloat($("#h2"+x).val()==""?0:$("#h2"+x).val());
                sumah3 += parseFloat($("#h3"+x).val()==""?0:$("#h3"+x).val());
                sumah4 += parseFloat($("#h4"+x).val()==""?0:$("#h4"+x).val());
                
                sumam1 += parseFloat($("#m1"+x).val()==""?0:$("#m1"+x).val());
                sumam2 += parseFloat($("#m2"+x).val()==""?0:$("#m2"+x).val());
                sumam3 += parseFloat($("#m3"+x).val()==""?0:$("#m3"+x).val());
                sumam4 += parseFloat($("#m4"+x).val()==""?0:$("#m4"+x).val());

                sumao1 += parseFloat($("#o1"+x).val()==""?0:$("#o1"+x).val());;
                sumao2 += parseFloat($("#o2"+x).val()==""?0:$("#o2"+x).val());;;
                sumao3 += parseFloat($("#o3"+x).val()==""?0:$("#o3"+x).val());;;
                sumao4 += parseFloat($("#o4"+x).val()==""?0:$("#o4"+x).val());;;
            }

            $("#trh1").html(isNaN(sumah1)?"":sumah1);
            $("#trh2").html(isNaN(sumah2)?"":sumah2);
            $("#trh3").html(isNaN(sumah3)?"":sumah3);
            $("#trh4").html(isNaN(sumah4)?"":sumah4);

            $("#trm1").html(isNaN(sumam1)?"":sumam1);
            $("#trm2").html(isNaN(sumam2)?"":sumam2);
            $("#trm3").html(isNaN(sumam3)?"":sumam3);
            $("#trm4").html(isNaN(sumam4)?"":sumam4);

            $("#tro1").html(isNaN(sumao1)?"":sumao1);
            $("#tro2").html(isNaN(sumao2)?"":sumao2);
            $("#tro3").html(isNaN(sumao3)?"":sumao3);
            $("#tro4").html(isNaN(sumao4)?"":sumao4);
        }

        function almacenaDesglose(){
            if(validaDesglose()){        
                data = {};
                datos = "";
                voids = "";
                idBS = $("#idBS").val();
                anio = $("#anio").val();
                _token = $("input[name='_token']").val();
                for(x=1;x<=8;x++){
                    vacia = true;
                    cadena = x+"_";
                    for(y=1;y<=4;y++){            
                        campo =   ("h"+y+""+x);      
                        valor = $("#h"+y+x).val();
                        data[campo] = valor;
                        cadena += valor+"|";
                        if(valor!="")
                            vacia=false;

                        campo =   ("m"+y+""+x);      
                        valor = $("#m"+y+x).val();
                        data[campo] = valor;
                        cadena += valor+"|";
                        if(valor!="")
                            vacia=false;

                        campo =   ("o"+y+""+x);      
                        valor = $("#o"+y+x).val();
                        data[campo] = valor;
                        cadena += valor+"|";
                        if(valor!="")
                            vacia=false;
                    }
                    if(!vacia){
                        datos += cadena+"&";
                    }else{
                        voids += x+"_";
                    }
                }

                data_ = {_token:_token,idBS:idBS,anio:anio,datos:datos,voids:voids};

                $.ajax({
                        type: 'POST',
                        url: "{{route('ia.almacenadesglose')}}",
                        data: data_,
                        dataType: 'json',
                        beforeSend: function() {
                            $("#body-desglose").block({
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
                            $("#body-desglose").unblock();
                            if(response.result == "ok"){
                                Swal.fire({
                                icon: 'success',
                                title: 'Desglose por Regiones',
                                text: response.message,
                                confirmButtonColor: '#3085d6',
                            }).then((result) => {  
                                    $("#modalDesglose").modal("hide");                         
                                });
                            }else{
                                Swal.fire({
                                icon: 'error',
                                title: 'Desglose por regiones',
                                text: response.message,
                                confirmButtonColor: '#3085d6',
                            }).then((result) => {});
                            }                        
                        });

                }                        
        }

        function getDesglose(){
            anio = $("#anio").val();
            idBS = $("#idBS").val();
            poblacion_ = $("#select_poblacion").attr("seleccionado");
            area_ = $("#select_area").attr("seleccionado");
            $.ajax({
                    type: 'GET',
                    url: "{{ route('ia.getdesglose') }}",
                    data: {anio:anio,idBS:idBS,poblacion:poblacion_,area:area_},
                    //dataType: 'json',
                    beforeSend: function() {
                        $("#body-desglose").block({
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
                        $("#body-desglose").unblock();
                        $("#body-desglose").html(response);
                    });
        }

        function validaDesglose(){
            valid = true;
            poblacion_ = $("#select_poblacion").attr("seleccionado");
            area_ = $("#select_area").attr("seleccionado");

            if(poblacion_=="true"){
                ah1 = parseFloat($("#ah1").val()==""?0:$("#ah1").val());
                am1 = parseFloat($("#am1").val()==""?0:$("#am1").val());

                ah2 = parseFloat($("#ah2").val()==""?0:$("#ah2").val());
                am2 = parseFloat($("#am2").val()==""?0:$("#am2").val());
                
                ah3 = parseFloat($("#ah3").val()==""?0:$("#ah3").val());
                am3 = parseFloat($("#am3").val()==""?0:$("#am3").val());
                
                ah4 = parseFloat($("#ah4").val()==""?0:$("#ah4").val());
                am4 = parseFloat($("#am4").val()==""?0:$("#am4").val());

                trh1 = parseFloat($("#trh1").html()==""?0:$("#trh1").html());
                trm1 = parseFloat($("#trm1").html()==""?0:$("#trm1").html());
                
                trh2 = parseFloat($("#trh2").html()==""?0:$("#trh2").html());
                trm2 = parseFloat($("#trm2").html()==""?0:$("#trm2").html());

                trh3 = parseFloat($("#trh3").html()==""?0:$("#trh3").html());
                trm3 = parseFloat($("#trm3").html()==""?0:$("#trm3").html());

                trh4 = parseFloat($("#trh4").html()==""?0:$("#trh4").html());
                trm4 = parseFloat($("#trm4").html()==""?0:$("#trm4").html());

                msg=true;

                if(trh1!=ah1){
                    msg=false;
                    $("#trh1").css("background-color","red");
                }else
                    $("#trh1").css("background-color","black");
                
                if(trh2!=ah2){
                    msg=false;
                    $("#trh2").css("background-color","red");
                }else
                    $("#trh2").css("background-color","black");

                if(trh2!=ah2){
                    msg=false;
                    $("#trh2").css("background-color","red");
                }else
                    $("#trh2").css("background-color","black");
                
                if(trh3!=ah3){
                    msg=false;
                    $("#trh3").css("background-color","red");
                }else
                    $("#trh3").css("background-color","black");

                if(trh4!=ah4){
                    msg=false;
                    $("#trh4").css("background-color","red");
                }else
                    $("#trh4").css("background-color","black");
                
                if(trm1!=am1){
                    msg=false;
                    $("#trm1").css("background-color","red");
                }else
                    $("#trm1").css("background-color","black");
                
                if(trm2!=am2){
                    msg=false;
                    $("#trm2").css("background-color","red");
                }else
                    $("#trm2").css("background-color","black");
                
                if(trm3!=am3){
                    msg=false;
                    $("#trm3").css("background-color","red");
                }else
                    $("#trm3").css("background-color","black");
                
                if(trm4!=am4){
                    msg=false;
                    $("#trm4").css("background-color","red");
                }else
                    $("#trm4").css("background-color","black");                                           
            }

            if(area_=="true"){                
                tro1 = parseFloat($("#tro1").html());
                tro2 = parseFloat($("#tro2").html());
                tro3 = parseFloat($("#tro3").html());
                tro4 = parseFloat($("#tro4").html());

                ara1 = parseFloat($("#ara1").val()==""?0:$("#ara1").val());
                ara2 = parseFloat($("#ara2").val()==""?0:$("#ara2").val());
                ara3 = parseFloat($("#ara3").val()==""?0:$("#ara3").val());
                ara4 = parseFloat($("#ara4").val()==""?0:$("#ara4").val());

                msg=true;

                if(tro1!=ara1){
                    msg = false;
                    $("#tro1").css("background-color","red");
                }else
                    $("#tro1").css("background-color","black");
                
                if(tro2!=ara2){
                    msg = false;
                    $("#tro2").css("background-color","red");
                }else
                    $("#tro2").css("background-color","black");
                
                if(tro3!=ara3){
                    msg = false;
                    $("#tro3").css("background-color","red");
                }else
                    $("#tro3").css("background-color","black");
            
                if(tro4!=ara4){
                    msg = false;
                    $("#tro4").css("background-color","red");
                }else
                    $("#tro4").css("background-color","black");
            }   

           /* if(!msg){
                    Swal.fire({
                                icon: 'warning',
                                title: 'Validación de Datos de Desglose por región',
                                text: "Los totales no son congruentes con las metas reportadas en el monitoreo de población beneficiada o área de enfoque atendida (El total del desglose debe ser igual a las metas alcanzadas en el trimestre)",
                                confirmButtonColor: '#3085d6',
                            }).then((result) => {});
                }*/
            
            return valid;
        }

        function validaBSPresupuesto(){
            return true;
        }

        function refreshPresupuesto(){

            $(".operativo_bs").each(function(){
                pom1 = parseFloat($(this).find(".pom1").eq(0).val()==""?0:$(this).find(".pom1").eq(0).val());
                pom2 = parseFloat($(this).find(".pom2").eq(0).val()==""?0:$(this).find(".pom2").eq(0).val());
                pom3 = parseFloat($(this).find(".pom3").eq(0).val()==""?0:$(this).find(".pom3").eq(0).val());
                pom4 = parseFloat($(this).find(".pom4").eq(0).val()==""?0:$(this).find(".pom4").eq(0).val());

                poe1 = parseFloat($(this).find(".poe1").eq(0).val()==""?0:$(this).find(".poe1").eq(0).val());
                poe2 = parseFloat($(this).find(".poe2").eq(0).val()==""?0:$(this).find(".poe2").eq(0).val());
                poe3 = parseFloat($(this).find(".poe3").eq(0).val()==""?0:$(this).find(".poe3").eq(0).val());
                poe4 = parseFloat($(this).find(".poe4").eq(0).val()==""?0:$(this).find(".poe4").eq(0).val());

                avo1 = (poe1/pom1)*100;
                avo2 = (poe2/pom2)*100;
                avo3 = (poe3/pom3)*100;
                avo4 = (poe4/pom4)*100;

                $(this).find(".avo1").eq(0).html(isNaN(avo1)?"":avo1.toFixed(2)+"%");
                $(this).find(".avo2").eq(0).html(isNaN(avo2)?"":avo2.toFixed(2)+"%");
                $(this).find(".avo3").eq(0).html(isNaN(avo3)?"":avo3.toFixed(2)+"%");
                $(this).find(".avo4").eq(0).html(isNaN(avo4)?"":avo4.toFixed(2)+"%");

                tamo = pom1 +  pom2 + pom3 + pom4;
                taeo = poe1 + poe2 + poe3 + poe4;

                tao = (taeo/tamo)*100;

                $(this).find(".tamo").eq(0).html(isNaN(tamo)?"":new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD',}).format(tamo,2));
                $(this).find(".taeo").eq(0).html(isNaN(taeo)?"":new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD',}).format(taeo,2));
                $(this).find(".tao").eq(0).html(isNaN(tao)?"":tao.toFixed(2)+"%");
            })

            $(".inversion_bs").each(function(){
                pim1 = parseFloat($(this).find(".pim1").eq(0).val()==""?0:$(this).find(".pim1").eq(0).val());
                pim2 = parseFloat($(this).find(".pim2").eq(0).val()==""?0:$(this).find(".pim2").eq(0).val());
                pim3 = parseFloat($(this).find(".pim3").eq(0).val()==""?0:$(this).find(".pim3").eq(0).val());
                pim4 = parseFloat($(this).find(".pim4").eq(0).val()==""?0:$(this).find(".pim4").eq(0).val());

                pie1 =  parseFloat($(this).find(".pie1").eq(0).val()==""?0:$(this).find(".pie1").eq(0).val());
                pie2 =  parseFloat($(this).find(".pie2").eq(0).val()==""?0:$(this).find(".pie2").eq(0).val());
                pie3 =  parseFloat($(this).find(".pie3").eq(0).val()==""?0:$(this).find(".pie3").eq(0).val());
                pie4 =  parseFloat($(this).find(".pie4").eq(0).val()==""?0:$(this).find(".pie4").eq(0).val());

                avi1 = (pie1/pim1)*100;
                avi2 = (pie2/pim2)*100;
                avi3 = (pie3/pim3)*100;
                avi4 = (pie4/pim4)*100;           

                $(this).find(".avi1").eq(0).html(isNaN(avi1)?"":avi1.toFixed(2)+"%");
                $(this).find(".avi2").eq(0).html(isNaN(avi2)?"":avi2.toFixed(2)+"%");
                $(this).find(".avi3").eq(0).html(isNaN(avi3)?"":avi3.toFixed(2)+"%");
                $(this).find(".avi4").eq(0).html(isNaN(avi4)?"":avi4.toFixed(2)+"%");

                
                tami = pim1 + pim2 + pim3 + pim4;
                taei = pie1 + pie2 + pie3 + pie4;

                
                tai = (taei/tami)*100;

                
                $(this).find(".tami").eq(0).html(isNaN(tami)?"":new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD',}).format(tami,2));
                $(this).find(".taei").eq(0).html(isNaN(taei)?"":new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD',}).format(taei,2));

                
                $(this).find(".tai").eq(0).html(isNaN(tai)?"":tai.toFixed(2)+"%");
            })

        }

        function showCargaMunicipios(idBS){
            miareadecargam.removeAllFiles(true);  
            $("#idBS_C").val(idBS);
            $("#anio_C").val($("#anio").val());
            $("#idPPA_C").val($("#idPPA").val());    
            $("#anio_desglose").html($("#anio").val());
            $("#procesamientodesglose").html("");                
            getDesglosesMunicipales(idBS,$("#anio").val());
            $("#modalCargaMunicipios").modal("show");

        }

        function inicializaDropZoneMunicipios() {
            miareadecargam = new Dropzone("#medios-municipios", {
                thumbnailWidth: 500,
                maxFilesize: 5,
                //disablePreviews:true,
                acceptedFiles: ".xlsx,.xls",
                buttonRemove: true
            });
            miareadecargam.on("addedfile", file => {
                //idIndicador = $("#idIndicador").val();
            });

            miareadecargam.on("success", function(file, response) {
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
                   // getMedios(response.idPPA,response.anio,response.trimestre);                   
                   getProcesamientoDesglose(response.ruta,response.archivo);
                }
            });
            $("#medios-municipios").find("button").eq(0).html("Arrastra aquí la plantilla o da clic en esta área para agregarla");
            $("#medios-municipios").css("width","100%");
            $("#medios-municipios").css("height","260px");
            $("#medios-municipios").css("vertical-align","top");
            $("#medios-municipios").css("overflow","auto");

        }   
        
        function getProcesamientoDesglose(ruta,archivo){            
            $.ajax({
                    type: 'POST',
                    url: "{{ route('ia.getprocesamientodesglose') }}",
                    data: {
                            _token : $("input[name='_token']").val(),
                            ruta:ruta,
                            archivo:archivo,
                            idBS:$("#idBS_C").val(),
                            trimestre:$("#trimestre_C").val(),
                            anio:$("#anio_C").val()
                        },
                    //dataType: 'json',
                    beforeSend: function() {
                        $("#procesamientodesglose").block({
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
                        $("#procesamientodesglose").unblock();
                        $("#procesamientodesglose").html(response);
                        getDesglosesMunicipales($("#idBS_C").val(),$("#anio_C").val());
                    });
        }

        function loadPP_a(){
            pps_operativo = {pps:[]};
            $("#programasContent").find(".pp_id").each(function(){
                pps_operativo.pps.push({"ppId" : $(this).val(),"ppDescripcion" : $(this).find(":selected").text()});                
            });

            pps_inversion = {pps:[]};
            $("#programasInvContent").find(".pp_id").each(function(){
                pps_inversion.pps.push({"ppId" : $(this).val(),"ppDescripcion" : $(this).find(":selected").text()});                
            });

            options_o = "";
            options_i = "";
            
            if(pps_operativo.pps.length>0){
                for(x=0;x<pps_operativo.pps.length;x++){
                   options_o += "<option value='" + pps_operativo.pps[x].ppId + "'>" + pps_operativo.pps[x].ppDescripcion + "</option>";
                   
                }
                $("#gasto_operativo_bs").show("slow");
            }

            if(pps_inversion.pps.length>0){
                for(x=0;x<pps_inversion.pps.length;x++){
                   options_i += "<option value='" + pps_inversion.pps[x].ppId + "'>" + pps_inversion.pps[x].ppDescripcion + "</option>";                   
                }
                $("#gasto_inversion_bs").show("slow");
            }

            $("#programa_bs_operativo").html(options_o);
            $("#programa_bs_inversion").html(options_i);
            
        }

        function addBSOperativo(){
            programa = $("#programa_bs_operativo").val();
            programa_text = $("#programa_bs_operativo option:selected").text();
            tipo="o";

            if($("#operativobs"+programa).length==0){
                row = '<div style="border: solid 1px blue;border-radius:5px;padding:10px;margin:10px;" id="operativobs'+programa+'"><table class="operativo_bs" programa="'+programa+'">'+
                        '<thead>'+
                            '<tr>'+
                                '<td colspan="6" style="text-align: right"><i class="fas fa-trash" style="color: red;cursor: pointer;margin:5px;" onclick="deleteBSPresupuesto('+programa+',\''+tipo+'\')"></i></td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td class="enc1" colspan="1">Programa Prespuestario:</td>'+
                                '<td colspan="2">'+programa_text+'</td>'+
                                '<td class="enc1" colspan="1">Componente:</td>'+
                                '<td class="" colspan="2"><input type="text" class="form-control componente_bs" placeholder="Indique el componente o componentes"/></td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td class="enc1">Concepto/Trimestre</td>'+
                                '<td class="enc1">Enero-Marzo</td>'+
                                '<td class="enc1">Abril-Junio</td>'+
                                '<td class="enc1">Julio-Septiembre</td>'+
                                '<td class="enc1">Octubre-Diciembre</td>'+
                                '<td class="enc1">Total Anual</td>'+
                            '</tr>'+
                        '</thead>'+
                        '<tbody>'+
                            '<tr class="po_">'+
                                '<td class="enc1">Modificado</td>'+
                                '<td><input type="number" class="form-control pom1" style="text-align:right;font-size:1.3em" onchange="refreshPresupuesto()"></td>'+
                                '<td><input type="number" class="form-control pom2" style="text-align:right;font-size:1.3em" onchange="refreshPresupuesto()"></td>'+
                                '<td><input type="number" class="form-control pom3" style="text-align:right;font-size:1.3em" onchange="refreshPresupuesto()"></td>'+
                                '<td><input type="number" class="form-control pom4" style="text-align:right;font-size:1.3em" onchange="refreshPresupuesto()"></td>'+
                                '<td class="enc4 tamo" style="text-align:right;font-size:1.5em"></td>'+
                            '</tr>'+
                            '<tr class="op_">'+
                                '<td class="enc1">Ejercido</td>'+
                                '<td><input type="number" class="form-control poe1" style="text-align:right;font-size:1.3em" onchange="refreshPresupuesto()"></td>'+
                                '<td><input type="number" class="form-control poe2" style="text-align:right;font-size:1.3em"  onchange="refreshPresupuesto()"></td>'+
                                '<td><input type="number" class="form-control poe3" style="text-align:right;font-size:1.3em"  onchange="refreshPresupuesto()"></td>'+
                                '<td><input type="number" class="form-control poe4" style="text-align:right;font-size:1.3em"  onchange="refreshPresupuesto()"></td>'+
                                '<td class="enc4 taeo" style="text-align:right;font-size:1.5em"></td>'+
                            '</tr>'+
                            '<tr class="op_">'+
                                '<td class="enc1">Avance</td>'+
                                '<td class="enc4 avo1" style="text-align:right;font-size:1.3em"></td>'+
                                '<td class="enc4 avo2" style="text-align:right;font-size:1.3em"></td>'+
                                '<td class="enc4 avo3" style="text-align:right;font-size:1.3em"></td>'+
                                '<td class="enc4 avo4" style="text-align:right;font-size:1.3em"></td>'+
                                '<td class="enc4 tao" style="text-align:right;font-size:1.5em"></td>'+
                            '</tr>'+
                        '</tbody>'+
                    '</table></div>';

                    $("#operativoBSContent").append(row);
            }            
        }

        function deleteBSPresupuesto(programa,tipo){
            Swal.fire({
                            icon: 'question',
                            title: 'Prespuesto por Bien o Servicio',
                            text: "¿Está seguro de querer eliminar esta información de presupuesto?, este registro será eliminado permanentemente.",                                                                      
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Sí, Eliminar!',
                            showCancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if(tipo=="o")
                                elemento = "operativobs";
                            else
                                elemento = "inversionbs";
                            idBS = $("#idBS").val();
                            anio = $("#anio").val();
                            $.ajax({
                                        type: 'POST',
                                        url: "{{ route('ia.remuevepresupuestobs') }}",
                                        data: {idBS:idBS,anio:anio,_token:$("input[name='_token']").val(),idPrograma:programa,tipo:tipo},
                                        dataType: 'json',
                                        beforeSend: function() {
                                            $("#"+elemento+programa).block({
                                                message: '<h4>Procesando...</h4>',
                                                css: { border: '3px solid gray', backgroundColor:'black','-webkit-border-radius': '10px','-moz-border-radius':'10px',width:"15%",color:"white" }
                                            });
                                            //block(true);
                                        }
                                    }).done(function(response) {
                                        if(response.result == "ok"){                                            
                                            $("#"+elemento+programa).hide("slow");
                                            setTimeout(function(){  
                                                $("#"+elemento+programa).remove();
                                            },300);        
                                        }else{
                                            $("#"+elemento+programa).unblock();
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Presupuesto Específico por Bien o Servicio',
                                                text: response.message,
                                                confirmButtonColor: '#3085d6',
                                            }).then((result) => {});
                                        }                                       
                                    });                            
                                });
        }

        function addBSInversion(){
            programa = $("#programa_bs_inversion").val();
            programa_text = $("#programa_bs_inversion option:selected").text();
            tipo="i";

            if($("#inversionbs"+programa).length==0){
                row = '<div style="border: solid 1px blue;border-radius:5px;padding:10px;margin:10px;" id="inversionbs'+programa+'"><table class="inversion_bs" programa="'+programa+'">'+
                        '<thead>'+
                            '<tr>'+
                                '<td colspan="6" style="text-align: right"><i class="fas fa-trash" style="color: red;cursor: pointer;margin:5px;" onclick="deleteBSPresupuesto('+programa+',\''+tipo+'\')"></i></td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td class="enc1" colspan="1">Programa Prespuestario:</td>'+
                                '<td colspan="2">'+programa_text+'</td>'+
                                '<td class="enc1" colspan="1">Componente:</td>'+
                                '<td class="" colspan="2"><input type="text" class="form-control componente_bs" placeholder="Indique el componente o componentes"/></td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td class="enc1">Concepto/Trimestre</td>'+
                                '<td class="enc1">Enero-Marzo</td>'+
                                '<td class="enc1">Abril-Junio</td>'+
                                '<td class="enc1">Julio-Septiembre</td>'+
                                '<td class="enc1">Octubre-Diciembre</td>'+
                                '<td class="enc1">Total Anual</td>'+
                            '</tr>'+
                        '</thead>'+
                        '<tbody>'+
                            '<tr class="pi_">'+
                                '<td class="enc1">Modificado</td>'+
                                '<td><input type="number" class="form-control pim1" style="text-align:right;font-size:1.3em" onchange="refreshPresupuesto()"></td>'+
                                '<td><input type="number" class="form-control pim2" style="text-align:right;font-size:1.3em" onchange="refreshPresupuesto()"></td>'+
                                '<td><input type="number" class="form-control pim3" style="text-align:right;font-size:1.3em" onchange="refreshPresupuesto()"></td>'+
                                '<td><input type="number" class="form-control pim4" style="text-align:right;font-size:1.3em" onchange="refreshPresupuesto()"></td>'+
                                '<td class="enc4 tami" style="text-align:right;font-size:1.5em"></td>'+
                            '</tr>'+
                            '<tr class="pi_">'+
                                '<td class="enc1">Ejercido</td>'+
                                '<td><input type="number" class="form-control pie1" style="text-align:right;font-size:1.3em" onchange="refreshPresupuesto()"></td>'+
                                '<td><input type="number" class="form-control pie2" style="text-align:right;font-size:1.3em"  onchange="refreshPresupuesto()"></td>'+
                                '<td><input type="number" class="form-control pie3" style="text-align:right;font-size:1.3em"  onchange="refreshPresupuesto()"></td>'+
                                '<td><input type="number" class="form-control pie4" style="text-align:right;font-size:1.3em"  onchange="refreshPresupuesto()"></td>'+
                                '<td class="enc4 taei" style="text-align:right;font-size:1.5em"></td>'+
                            '</tr>'+
                            '<tr class="pi_">'+
                                '<td class="enc1">Avance</td>'+
                                '<td class="enc4 avi1" style="text-align:right;font-size:1.3em"></td>'+
                                '<td class="enc4 avi2" style="text-align:right;font-size:1.3em"></td>'+
                                '<td class="enc4 avi3" style="text-align:right;font-size:1.3em"></td>'+
                                '<td class="enc4 avi4" style="text-align:right;font-size:1.3em"></td>'+
                                '<td class="enc4 tai" style="text-align:right;font-size:1.5em"></td>'+
                            '</tr>'+
                        '</tbody>'+
                    '</table></div>';

                    $("#inversionBSContent").append(row);
            }  
        }

        function changeTrimestre(){
            trimestre = $("#trimestre_desglose").val();
            if(trimestre==""){
                $("#medios-municipios").hide("slow");
                $("#trimestre_C").val("");
            }else{
                $("#medios-municipios").show("slow");
                $("#trimestre_C").val(trimestre);                    
            }
        }

        function getDesglosesMunicipales(idBS,anio,trimestre){
            $.ajax({
                    type: 'GET',
                    url: "{{ route('ia.getdesglosemunicipal') }}",
                    data: {                            
                            idBS:idBS,
                            trimestre:trimestre,
                            anio:anio
                        },
                    //dataType: 'json',
                    beforeSend: function() {
                        $("#nav-desglose").block({
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
                        $("#nav-desglose").unblock();
                        $("#nav-desglose").html(response);                        
                    });
        }

        function setAplica(idPPA,anio){          
            
            aplica = $("#toggleseguimiento").prop("checked");
            before =   !aplica;
            $.ajax({
                    type: 'POST',
                    url: "{{ route('ia.setaplica') }}",
                    data: {
                        idPPA: idPPA,                        
                        anio:anio,
                        aplica:aplica,
                        _token:$("input[name='_token']").val()
                    },
                    //dataType: 'json',
                    beforeSend: function() {
                             $("#toggleAplica").block(
                                {
                                    message: '<b style="font-size:.8em">Procesando.</b>',
                                    css: {
                                        border: '3px solid gray',
                                        backgroundColor: 'black',
                                        '-webkit-border-radius': '10px',
                                        '-moz-border-radius': '10px',
                                        width: "15%",
                                        color: "white"                                        
                                    }
                                }
                             );                   
                    }
                }).done(function(response) {        
                    $("#toggleAplica").unblock();                   
                    if(response.result=="ok"){
                        if(aplica){
                            $("#seguimientoAplica").show("");
                            $("#AlmacenarGeneral").html('<button class="btn btn-success" style="text-align: right" onclick="almacenaCambios();"><i class="fas fa-save"></i> Guardar Cambios</button>');
                        }else{
                            $("#seguimientoAplica").hide("");
                            $("#AlmacenarGeneral").html("")
                        }                        
                    }   else{                        
                        if(before){
                            $("#seguimientoAplica").show("");
                            $("#AlmacenarGeneral").html('<button class="btn btn-success" style="text-align: right" onclick="almacenaCambios();"><i class="fas fa-save"></i> Guardar Cambios</button>');
                        }else{
                            $("#seguimientoAplica").hide("");
                            $("#seguimientoAplica").html("")    
                        }
                    }         
                });

            
        }
        function setAplicaBS() {
            const aplica = $('#toggleBS').prop('checked') ? 1 : 0;

            if (aplica) {
                $('#contenidoMonitoreo').slideDown();
            } else {
                $('#contenidoMonitoreo').slideUp();
            }

            $.ajax({
                type: 'POST',
                url: '{{ route('monitoreo.guardarEstado') }}',
                data: {
                    idBS: $('#idBS').val(),
                    anio: $('#anio').val(),
                    aplica: aplica,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    console.log('Estado guardado con éxito');
                },
                error: function (xhr) {
                    console.error('Error al guardar el estado');
                }
            });
        }


    </script>

@endsection
