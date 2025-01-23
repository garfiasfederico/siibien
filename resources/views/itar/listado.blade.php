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
                                                onclick="getDataPPA({{$ppa->id}})"><i class="fas fa-list"></i>
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
    <div class="modal fade" id="modalGenerales" tabindex="-1" role="dialog" aria-labelledby="accionModalLabel" data-backdrop="static" data-keyboard="false"
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
            linkro();
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
            if (validaDatosGenerales() && validaAlineacion()) {
                tipo = "";
                reglas = "";
                link_ro = "";

                if($("#programa").prop("checked")){
                    tipo='programa';                
                    reglas= $("#reglassi").prop("checked")?1:0;
                    link_ro = $("#link_r_o").val();
                }
                else{
                        if($("#proyecto").prop("checked"))
                            tipo='proyecto';
                        else
                            tipo='accion';
                }
                objetivo = $("#objetivo").val();
                descripcion = $("#descripcion").val();
                cobertura = $("#cobertura").val();
                //p_entrega = $("#p_entrega").val();
                //p_otro = $("#p_otro").val();
                anio_inicio = $("#anio_inicio").val();
                idPPA = $("#idPPA").val();
                token = $("input[name='_token']").val();

                //Realizamos el vaciado de la información de alineación
                idEjePED = $("#idEjePED").val();
                idTemaPED = $("#idTemaPED").val();
                idObjetivoPED = $("#idObjetivoPED").val();
                lineas = "";

                $(".lineaatiende").each(function(){
                    lineas += $(this).attr("idLA")+"|";
                });

                transversales = "";
                transversales += $("#igualdad").prop("checked")?"igualdad ":"";
                transversales += $("#desarrollo").prop("checked")?"desarollo ":"";
                transversales += $("#interculturalidad").prop("checked")?"interculturalidad ":"";
                transversales += $("#ninas").prop("checked")?"ninas ":"";


                //Alineacion a sectoriales y especiales
                idSector = $("#idSector").val();
                idObjetivoSector = $("#idObjetivoSector").val();
                idEstrategiaSector = $("#idEstrategiaSector").val();
                idProductoSector = $("#idProductoSector").val();

                indicadores = "";
                //Obtenemos los indicadores asociados
                $(".indicador").each(function(){
                    indicadores += $(this).attr("indicador")+"|";
                });


                


                data = {idPPA:idPPA,
                        tipo:tipo,
                        reglas:reglas,
                        link_ro:link_ro,
                        objetivo:objetivo,
                        descripcion:descripcion,
                        cobertura:cobertura,
                        //p_entrega:p_entrega,
                        //p_otro:p_otro,
                        anio_inicio:anio_inicio,
                        idEjePED:idEjePED,
                        idTemaPED:idTemaPED,
                        idObjetivoPED:idObjetivoPED,
                        lineas:lineas,
                        transversales:transversales,
                        idSector:idSector,
                        idObjetivoSector:idObjetivoSector,
                        idProductoSector:idProductoSector,
                        idEstrategiaSector:idEstrategiaSector,
                        indicadores:indicadores,
                        _token:token};                
                almacenaGenerales(data)              
            }else{
                Swal.fire({
                            icon: 'warning',
                            title: 'Validación de Datos Generales',
                            text: "Favor de atender las observaciones marcadas en rojo.",
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
            }
        }

        function almacenaGenerales(data){
            $.ajax({
                    type: 'POST',
                    url: "{{ route('ia.actualizagenerales') }}",
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        $("#modalGenerales").block({
                            message: '<h4>Procesando...</h4>',
                            css: { border: '3px solid gray', backgroundColor:'black','-webkit-border-radius': '10px','-moz-border-radius':'10px',width:"15%",color:"white" }
                        });
                        //block(true);
                    }
                }).done(function(response) {
                    //block(false);
                    $("#modalGenerales").unblock();
                    if (response.result == "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: 'ITAR, Actualización de Generales',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {$("#modalGenerales").modal("hide"); location.reload()});                        
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'ITAR, Actualización de Generales',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
                    }
                });
        }

        function validaDatosGenerales() {
            inputs = [
                "objetivo",
                "descripcion",
                "anio_inicio",
            ];
            selects = [
                "cobertura",
               // "p_entrega",
            ];

            if($("#reglassi").prop("checked")){
                inputs.push("link_r_o");
                $("#link_r_o").show("slow");
            }                
            else{
                index = inputs.indexOf("link_r_o")
                if(index){
                    inputs.splice(index,0)
                    $("#link_r_o").removeClass("is-invalid");
                }                   
            }

            /*if($("#p_entrega").val()=="otro")
                inputs.push("p_otro");
            else{
                index = inputs.indexOf("p_otro")
                if(index){
                    inputs.splice(index,0)
                    $("#p_otro").removeClass("is-invalid");
                }                   
            }*/
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
            if(!valid){
                $("#nav-home-tab").click();
            }
            return valid;
        }

        function validaAlineacion(){
            inputs = [
                
            ];
            selects = [
                "idEjePED",
                "idTemaPED",
                "idObjetivoPED",
                "idSector",
                "idObjetivoSector",
                "idEstrategiaSector",
                "idProductoSector"

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

            if($(".lineaatiende").length==0){
                $("#error_lineas").show();
                valid=false;
            }else{
                $("#error_lineas").hide();
            }

            if(!valid){
                $("#nav-profile-tab").click();
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

        function linkro(){
            if($("#reglassi").prop("checked"))
                $("#link_r_o").show();
            else{
                $("#link_r_o").hide();
                $("#link_r_o").removeClass("is-invalid");
            }                
        }

        function potro(){
            if($("#p_entrega").val()=="otro"){
                $("#p_otro").show("slow");
            }else{
                $("#p_otro").hide("slow");
                $("#p_otro").val("");
            }
        }
        function getDataPPA(idPPA){
            //$("#idPPA").val(idPPA);
            $.ajax({
                    type: 'GET',
                    url: "{{ route('ia.getdatosgenerales') }}",
                    data:{idPPA:idPPA},
                    //dataType: 'json',
                    beforeSend: function() {
                        $("#infoPPA").html("<center>Cargando</center>");
                        $("#modalGenerales").block({
                            message: '<h4>Obteniendo datos...</h4>',
                            css: { border: '3px solid gray', backgroundColor:'black','-webkit-border-radius': '10px','-moz-border-radius':'10px',width:"15%",color:"white" }
                        });
                        //block(true);
                    }
                }).done(function(response) {
                    //block(false);
                    $("#modalGenerales").unblock();
                    $("#infoPPA").html(response)
                });
            $('#modalGenerales').modal('show');
        }
        function getTemas() {
            if ($("#idEjePED").val() != "") {
                $("#idTemaPED").html("<option value=''>Seleccione</option>");
                $("#idObjetivoPED").html("<option value=''>Seleccione</option>");
                $("#idLAPED").html("<option value=''>Seleccione</option>");


                $.ajax({
                    type: 'GET',
                    url: "{{ route('gettemas') }}",
                    data: {
                        idEjePED: $("#idEjePED").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        // block(true);
                    }
                }).done(function(response) {
                    //block(false);
                    options = "<option value=''>Seleccione</option>";
                    if (response.success = "ok") {
                        for (x = 0; x < response.temas.length; x++) {
                            options += "<option value='" + response.temas[x].idTemaPED + "'>" + response.temas[x]
                                .temaPEDClave + " " + response.temas[x].temaPEDDescripcion + "</option>";
                        }
                        $("#idTemaPED").html(options);
                    }                    
                });
            } 
        }

        function getObjetivos() {
            if ($("#idTemaPED").val() != "") {
                $("#idObjetivoPED").html("<option value=''>Seleccione</option>");
                $("#idLAPED").html("<option value=''>Seleccione</option>");
                $.ajax({
                    type: 'GET',
                    url: "{{ route('getobjetivos') }}",
                    data: {
                        idTemaPED: $("#idTemaPED").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        //block(true);
                    }
                }).done(function(response) {
                    // block(false);
                    options = "<option value=''>Seleccione</option>";
                    if (response.success = "ok") {                       
                        for (x = 0; x < response.objetivos.length; x++) {
                            options += "<option value='" + response.objetivos[x].idObjetivoPED + "'>" + response.objetivos[x]
                                .objetivoPEDClave + " " + response.objetivos[x].objetivoPEDDescripcion + "</option>";
                        }
                        $("#idObjetivoPED").html(options);
                    }                    
                });
            } 
        }

        function getLineas(){
            if ($("#idObjetivoPED").val() != "") {
                $("#idLAPED").html("<option value=''>Seleccione</option>");
                $.ajax({
                    type: 'GET',
                    url: "{{ route('getlineasbyobjetivo') }}",
                    data: {
                        idObjetivoPED: $("#idObjetivoPED").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        //block(true);
                    }
                }).done(function(response) {
                    // block(false);
                    options = "<option value=''>Seleccione</option>";
                    if (response.success = "ok") {                       
                        for (x = 0; x < response.lineas.length; x++) {
                            options += "<option value='" + response.lineas[x].idLAPED + "'>" + response.lineas[x]
                                .laPEDClave + " - " + response.lineas[x].laPEDDescripcion + "</option>";
                        }
                        $("#idLAPED").html(options);
                    }                    
                });
            } 
        }

        function addLinea(){
            idLAPED = $("#idLAPED").val();                        
            if(idLAPED != ""){
                if($("#linea"+idLAPED).length == 0){
                    linea = $("#idLAPED option:selected").text();
                    dt = linea.split(" - ");
                    row = "<tr id='linea"+idLAPED+"'>"+
                        "<td class='lineaatiende' idLA='"+idLAPED+"' style='border:solid 1px gray;vertical-align:middle'>"+idLAPED+"</td>"+
                        "<td style='border:solid 1px gray;vertical-align:middle'>"+dt[0]+"</td>"+
                        "<td style='border:solid 1px gray;vertical-align:middle'>"+dt[1]+"</td>"+
                        "<td style='border:solid 1px gray;text-align:center;vertical-align:middle'><button class='btn btn-danger' style='font-size:.9em;' onclick='quitLinea("+idLAPED+")'><i class='fas fa-trash'></i> Quitar</button></td>"+
                        "</tr>";
                    $("#lineasatiende").append(row);
                }
            }
            
        }

        function quitLinea(id){
            $("#linea"+id).hide("slow")
            setTimeout(function(){$("#linea"+id).remove();},500)            
        }    
        
        function toggle(icon,element){
            if($("#"+element).css("display")=="none"){
                $("#"+element).show("fast");
                $("#"+icon).removeClass("fa-chevron-right");
                $("#"+icon).addClass("fa-chevron-down");
            }else{
                $("#"+element).hide("fast");                
                $("#"+icon).removeClass("fa-chevron-down");
                $("#"+icon).addClass("fa-chevron-right");
            }
            
        }

        function getObjetivosSector(){
            if ($("#idSector").val() != "") {
                $("#idObjetivoSector").html("<option value=''>Seleccione</option>");  
                $("#idEstrategiaSector").html("<option value=''>Seleccione</option>");  

               $.ajax({
                    type: 'GET',
                    url: "{{ route('getobjetivossector') }}",
                    data: {
                        idSector: $("#idSector").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        //block(true);
                    }
                }).done(function(response) {
                    // block(false);
                    options = "<option value=''>Seleccione</option>";
                    if (response.success = "ok") {                       
                        for (x = 0; x < response.objetivos.length; x++) {
                            options += "<option value='" + response.objetivos[x].idObjetivo + "'>" + response.objetivos[x]
                                .claveObjetivo + " - " + response.objetivos[x].objetivo + "</option>";
                        }
                        $("#idObjetivoSector").html(options);
                    }                    
                });
            }
        }

        function getEstrategiasSector(){
            if ($("#idObjetivoSector").val() != "") {
                $("#idEstrategiaSector").html("<option value=''>Seleccione</option>");                
               $.ajax({
                    type: 'GET',
                    url: "{{ route('getestrategiassector') }}",
                    data: {
                        idObjetivoSector: $("#idObjetivoSector").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        //block(true);
                    }
                }).done(function(response) {
                    // block(false);
                    options = "<option value=''>Seleccione</option>";
                    if (response.success = "ok") {                       
                        for (x = 0; x < response.estrategias.length; x++) {
                            options += "<option value='" + response.estrategias[x].idEstrategia + "'>" + response.estrategias[x].claveEstrategia + " - " + response.estrategias[x].estrategia + "</option>";
                        }
                        $("#idEstrategiaSector").html(options);
                    }                    
                });
            }
        }

        function getProductosSector(){
            if ($("#idEstrategiaSector").val() != "") {
                $("#idProductoSector").html("<option value=''>Seleccione</option>");                
               $.ajax({
                    type: 'GET',
                    url: "{{ route('getproductossector') }}",
                    data: {
                        idEstrategiaSector: $("#idEstrategiaSector").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        //block(true);
                    }
                }).done(function(response) {
                    // block(false);
                    options = "<option value=''>Seleccione</option>";
                    if (response.success = "ok") {                       
                        for (x = 0; x < response.productos.length; x++) {
                            options += "<option value='" + response.productos[x].idProducto + "'>" + response.productos[x].claveProducto + " - " + response.productos[x].producto + "</option>";
                        }
                        $("#idProductoSector").html(options);
                    }                    
                });
            }
        }

        function agregarIndicador(){
            indicador = $("#idIndicador").val();
            if(indicador != ""){
                descripcion = $("#idIndicador option:selected").text();
                dat = descripcion.split(" - ");
                if($("#rowindicador"+indicador).length==0){
                    row = "<tr id='rowindicador"+indicador+"' class='indicador' indicador='"+indicador+"'>"+
                        "<td style='text-align:center;border:solid 1px gray'>"+dat[0]+"</td>"+
                        "<td style='border:solid 1px gray'>"+dat[1]+"</td>"+
                        "<td style='text-align:center;border:solid 1px gray'><button class='btn btn-danger' onclick='removeIndicador("+indicador+")'><i class='fas fa-trash'></i> Quitar</button></td>"+
                    "</tr>";
                $("#emptyIndicadores").hide();
                $("#body-indicadores").append(row);       
                }
                
            }
        }

        function removeIndicador(idIndicador){
            $("#rowindicador"+idIndicador).hide("slow");
            setTimeout(function(){
                    $("#rowindicador"+idIndicador).remove()
                    if($(".indicador").length==0){
                    $("#emptyIndicadores").show("slow");
                }   
                ;},500);
            

            
        }

    </script>
@endsection
