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
            if(validaPresupuesto()){
                //obtenemos los datos del prespuesto
                contador = 0;
                presupuestos = "";
                $(".ia_presupuesto_tipog_id").each(function(){
                    pp_id = $(".pp_id").eq(contador).val();
                    componente = $(".componente").eq(contador).val();
                    presupuestos += $(this).val()+"|"+pp_id+"|"+componente+"&";    
                    contador++;                
                });
                data = {presupuestos:presupuestos,_token:$("input[name='_token']").val(),idPoblacion:$("#idPoblacion").val(),total:$("#total").val(),tipoP:$("#tipoP").val(),anio:$("#anio").val()};
                if($("#tipoP").val()=="poblacion"){
                    data.mujeres = $("#mujeres").val();
                    data.hombres = $("#hombres").val();                                        
                }

                //agregamos la información del impacto
                impacto = $("#social").prop("checked")?"social ":"";
                impacto += $("#economico").prop("checked")?"economico ":"";
                impacto += $("#ambiental").prop("checked")?"ambiental ":"";
                descripcion_impacto = $("#descripcion_impacto").val();

                data.impacto = impacto;
                data.descripcion_impacto = descripcion_impacto;


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
                    "total",
                    "descripcion_impacto"
                ];
                selects = [
                    ,               
                ];

                if($("#tipoP").val() == "poblacion"){
                    inputs.push("mujeres");
                    inputs.push("hombres");

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
    </script>
@endsection
