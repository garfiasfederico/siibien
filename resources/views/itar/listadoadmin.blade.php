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
            background-color: rgb(255, 195, 195);
            color: gray;
            border-radius: 5px;
            text-align: center;
            padding: 10px;
            border:solid 1px red;
        }
        textarea{
            color:black;
        }
        .prioritario:hover{
            transform:scale(1.3);
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
                        <!-- <div align="left" class="d-flex bg-gray-100 p-2 y-3 justify-content-between pl-4">
                                <form action="{{ route('ppa.oficializar') }}" method="GET" target="_blank" class="flex d-flex"
                                    id="oficializacion">
                                    Periodo a Oficializar:<select class="form-control" style="width:100%;" name="periodo"
                                        id="periodop">
                                        <option value="">---Seleccione</option>
                                        <option value="42023">Octubre-Diciembre 2023</option>
                                        <option value="12024">Enero-Marzo 2024</option>
                                    </select>
                                    &nbsp;&nbsp;
                                    <button type="button" onclick="printOficializacion()" class="btn btn-success"><i
                                            class="fas fa-download"></i></button>
                                </form>
                            </div>-->
                            <div style="text-align: right; padding:10px;">
                                <a href="{{route("ia.listadodetalladoitar")}}"><button class="btn btn-info"><i class="fas fa-download"></i> Descargar avance por BS</button></a>
                                <a href="{{route("ia.exportitar")}}"><button class="btn btn-success"><i class="fas fa-download"></i> Descargar Listado</button></a>
                            </div>
                        <table class="table table-bordered table-striped" id="dataTableItar" width="100%" cellspacing="0"
                            style="color: black!important">
                            <thead style="background-color: #919090;color:white;">
                                <tr style="text-align: center">
                                    <th>Prioritario</th>
                                    <th>Id</th>
                                    <th>Año</th>
                                    <th>Vigente</th>
                                    <th>Nombre del PPA</th>
                                    <th>Descripcion</th>
                                    <th>Objetivo</th>
                                    <th>Responsable</th>                                   
                                    <th>Bienes o servicios registrados</th>
                                    <th>Estatus</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ppas as $ppa)
                                    <tr>
                                        <td style="text-align:center;color:rgb(192, 192, 192)" id="prioritario{{$ppa->id}}">
                                            <i onclick="setPrioritario({{$ppa->id}},{{$ppa->prioritario==0?1:0}})" class="fas fa-star prioritario" style="@if($ppa->prioritario==0) color: gray @else color:gold @endif;font-size:1.3em;cursor:pointer" title="Cambiar a @if($ppa->prioritario==0)Prioritario @else Ordinario @endif" ></i><br/>@if($ppa->prioritario==0) ordinario @else prioritario @endif
                                        </td>
                                        <td>{{ $ppa->id }}</td>
                                        <td>{{ $ppa->anio }}</td>
                                        <td style="text-align:center">
                                            <input
                                                type="checkbox"
                                                data-toggle="toggle"
                                                data-on="Vigente"
                                                data-off="No vigente"
                                                data-onstyle="success"
                                                data-offstyle="secondary"
                                                data-width="120"
                                                onchange="setVigente({{ $ppa->id }}, this.checked)"
                                                {{ $ppa->vigente == 1 ? 'checked' : '' }}>
                                        </td>

                                        <td>{{ $ppa->nombre }}</td>
                                        <td>{{ $ppa->descripcion }}</td>
                                        <td>{{ $ppa->objetivo }}</td>                                        
                                        <td style="text-align: center"><button class="btn btn-primary">{{ $ppa->dependenciaSiglas }}</button></td>
                                        <td style="text-align: center">{{ $ppa->bienes_servicios }}</td>   
                                        <td style="text-align: center">                                            
                                            @if($ppa->estadoPPA != "revision")
                                                <button class="btn btn-secondary" onclick="uptEstado({{$ppa->id}},'revision')" id="btnupt{{$ppa->id}}">Edición</button>
                                            @else
                                                <button class="btn btn-success" onclick="uptEstado({{$ppa->id}},'edicion')" id="btnupt{{$ppa->id}}">Revisión</button>
                                            @endif
                                            
                                        </td>   
                                        <td class="" style="text-align: center">                                            
                                            <form action="{{ route('itar.edit') }}" 
                                                style="float:left;margin:5px;display:none" method="POST">
                                                @csrf
                                                <input type="hidden" name="idITAR" value="{{ $ppa->id }}" />
                                                <button class="btn btn-sm btn-info" type="submit"><i
                                                        class="fas fa-edit"></i></button>
                                            </form>
                                                <button style="margin:5px;width:150px;text-align:left"
                                                    class="btn btn-sm btn-primary" type="button" title="Datos Generales"
                                                    onclick="getDataPPA({{$ppa->id}})"><i class="fas fa-list"></i>
                                                    Datos Generales</button>                                            <form action="{{route("ia.seguimiento")}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="idPPA" value="{{$ppa->id}}">
                                                <button style="margin:5px;width:150px;text-align:left"
                                                class="btn btn-sm btn-success" type="submit" title="Seguimiento"><i
                                                    class="fas fa-tachometer-alt"></i> Seguimiento</button>
                                            </form> 

                                            <form action="{{route("ia.reportes")}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="idPPA" value="{{$ppa->id}}">                                                
                                                <button style="margin:5px;width:150px;text-align:left"
                                                    class="btn btn-sm btn-info" type="submit" title="Reportes"><i
                                                        class="fas fa-chart-line"></i> Reportes</button>
                                            </form>

                                            <!--<a target="_blank" href="{{ route('itar.download', ['id' => $ppa->id]) }}"
                                                style="float: left;margin:5px"><button class="btn btn-sm btn-dark"><i
                                                        class="fas fa-file-pdf"></i></button></a>                                               -->
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
                            <!--<a href="{{ route('itar.index') }}">
                                <button class="btn btn-success">
                                    Agregar PPA
                                </button>
                            </a>-->
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div id="result-alert" style="position:absolute;right:10px; top:80px;color:white;padding:18px;display:none">
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
                    <button class="btn btn-primary" type="button" onclick="Almacenar()" id="btnAlmacenarG">Almacenar</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#dataTableItar").DataTable({
                pageLength: 10,
                lengthMenu: [10, 20, 50],
                order: [
                    [1, 'asc']
                ],
            })
        });

        function uptEstado(idPPA,estado){
            Swal.fire({
                title: 'Cambiar Estatus',
                text: "El estatus del PPA [" + idPPA + "] " +
                    " cambiará a "+estado,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, Continuar!',
                showCancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('admin.itar.uptestado') }}",
                        data: {
                            idPPA: idPPA,
                            estado: estado,
                            _token: $("input[name='_token']").val()
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            //block(true)
                            $("#btnupt" + idPPA).html('<i class="fas fa-spinner fa-spin"></i>');
                        }
                    }).done(function(response) {
                        if (response.result == "ok") {
                            //location.reload()
                            if(estado=="revision"){
                                $("#btnupt" + idPPA).removeClass("btn-secondary");
                                $("#btnupt" + idPPA).addClass("btn-success");
                                $("#btnupt" + idPPA).html("Revisión");
                                $("#btnupt" + idPPA).attr("onClick","uptEstado("+idPPA+",'edicion')");
                            }else{
                                $("#btnupt" + idPPA).addClass("btn-secondary");
                                $("#btnupt" + idPPA).removeClass("btn-success");
                                $("#btnupt" + idPPA).html("Edición");
                                $("#btnupt" + idPPA).attr("onClick","uptEstado("+idPPA+",'revision')");
                            }
                        } else { 
                            $("#btnupt" + idPPA).html('Error');                           
                            Swal.fire({
                            icon: 'error',
                            title: 'ITAR, Actualización de Estatus del PPA',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
                        }
                    }).fail(function(data) {
                        // block(false)
                    });
                }
            });
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

        function getInfoPPA(idPPA){            
            $.ajax({
                    type: 'GET',
                    url: "{{ route('ia.getinfoppa') }}",
                    data: {
                        idPPA: idPPA,                        
                    },
                    //dataType: 'json',
                    beforeSend: function() {
                        //block(true)
                        $("#infoPPA").block({
                            message: '<h4>Procesando...</h4>',
                            css: { border: '3px solid gray', backgroundColor:'black','-webkit-border-radius': '10px','-moz-border-radius':'10px',width:"15%",color:"white" }
                        });
                    }
                }).done(function(response) {                                  
                        $("#infoPPA").unblock();         
                        $("#infoPPA").html(response);                   
                        $("#modalInfo").modal("show");                        
                }).fail(function(data) {
                   // block(false)
                });

        }

        function setPrioritario(idPPA,prioritario){
            before = prioritario==0?1:0;


            /*Swal.fire({
                title: 'Cambiar Estus',
                text: "El estatus del PPA [" + idPPA + "] " +
                    " cambiará a "+estado,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, Continuar!',
                showCancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {                    
                }
            });*/
            $.ajax({
                type: 'POST',
                url: "{{ route('admin.itar.setprioritario') }}",
                data: {
                    idPPA: idPPA,
                    prioritario: prioritario,
                    _token: $("input[name='_token']").val()
                },
                dataType: 'json',
                beforeSend: function() {
                    //block(true)
                    $("#prioritario" + idPPA).html('<i class="fas fa-spinner fa-spin"></i>');
                }
            }).done(function(response) {
                if (response.result == "ok") {
                    //location.reload()
                    if(prioritario==0){
                        $("#prioritario" + idPPA).html('<i onclick="setPrioritario('+idPPA+',1)" class="fas fa-star prioritario" style="color: gray;font-size:1.3em;cursor:pointer" title="Cambiar a Prioritario" ></i><br/>ordinario')
                    }else{
                        $("#prioritario" + idPPA).html('<i onclick="setPrioritario('+idPPA+',0)" class="fas fa-star prioritario" style="color: gold;font-size:1.3em;cursor:pointer" title="Cambiar a Ordinario" ></i><br/>prioritario')    
                    }
                } else { 
                    if(before==0){
                        $("#prioritario" + idPPA).html('<i onclick="setPrioritario('+idPPA+','+prioritario+')" class="fas fa-star prioritario" style="color: gray;font-size:1.3em;cursor:pointer" title="Cambiar a Prioritario" ></i><br/>ordinario')
                    }else{
                        $("#prioritario" + idPPA).html('<i onclick="setPrioritario('+idPPA+','+prioritario+')" class="fas fa-star prioritario" style="color: gold;font-size:1.3em;cursor:pointer" title="Cambiar a Ordinario" ></i><br/>prioritario')    
                    }
                }
            }).fail(function(data) {
                if(before==0){
                        $("#prioritario" + idPPA).html('<i onclick="setPrioritario('+idPPA+','+prioritario+')" class="fas fa-star prioritario" style="color: gray;font-size:1.3em;cursor:pointer" title="Cambiar a Prioritario" ></i><br/>ordinario')
                    }else{
                        $("#prioritario" + idPPA).html('<i onclick="setPrioritario('+idPPA+','+prioritario+')" class="fas fa-star prioritario" style="color: gold;font-size:1.3em;cursor:pointer" title="Cambiar a Ordinario" ></i><br/>prioritario')    
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

                //Obtenemos la población o área de enfoque indicada
                tipo_p = $("#tipo_p").val();
                tipo_poblacion_id = $("#tipo_poblacion_id").val();
                nombre_enfoque = $("#nombre_enfoque").val();
                descripcion_poblacion = $("#descripcion_poblacion").val();
                tipo_poblacion_otro = $("#tipo_poblacion_otro").val();
                descripcion_area = $("#descripcion_area").val();
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
                        tipo_p:tipo_p,
                        tipo_poblacion_id:tipo_poblacion_id,
                        nombre_enfoque:nombre_enfoque,
                        descripcion_poblacion:descripcion_poblacion,
                        tipo_poblacion_otro:tipo_poblacion_otro,
                        descripcion_area : descripcion_area,
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
                "tipo_p"               
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

            if($("#tipo_p").val().includes("p_")){
                selects.push("tipo_poblacion_id");      
                inputs.push("descripcion_poblacion");    

                if($("#tipo_poblacion_id").val()=="16"){
                    inputs.push("tipo_poblacion_otro");
                }else{
                    index = inputs.indexOf("tipo_poblacion_otro")
                    if(index){
                        inputs.splice(index,0)
                        $("#tipo_poblacion_otro").removeClass("is-invalid");
                    }
                }
            }else{
                index = selects.indexOf("tipo_poblacion_id")
                if(index){
                    selects.splice(index,0)
                    $("#tipo_poblacion_id").removeClass("is-invalid");
                }   
                index = selects.indexOf("descripcion_poblacion")
                if(index){
                    selects.splice(index,0)
                    $("#descripcion_poblacion").removeClass("is-invalid");
                }   
            }            
            
            if($("#tipo_p").val().includes("a_")){
                inputs.push("nombre_enfoque");
                inputs.push("descripcion_area");                                                
            }else{
                index = inputs.indexOf("nombre_enfoque")
                if(index){
                    inputs.splice(index,0)
                    $("#nombre_enfoque").removeClass("is-invalid");
                }
                index = inputs.indexOf("descripcion_area")
                if(index){
                    inputs.splice(index,0)
                    $("#descripcion_area").removeClass("is-invalid");
                }
            }

            
            
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
            
            if($("#nav-home").find(".is-invalid").length>0)
                $("#datosgenerales-n").html(" <i class='fas fa-circle' style='color:red;font-size:.8em'></i>");
            else
                $("#datosgenerales-n").html("");
            
            if($("#nav-profile").find(".is-invalid").length>0)
                $("#alineacion-n").html(" <i class='fas fa-circle' style='color:red;font-size:.8em'></i>");
            else
                $("#alineacion-n").html("");
            
            if($("#nav-contact").find(".is-invalid").length>0)
                $("#bienes_servicios-n").html(" <i class='fas fa-circle' style='color:red;font-size:.8em'></i>");
            else
                $("#bienes_servicios-n").html("");
                        
            if($("#nav-poblacion").find(".is-invalid").length>0)
                $("#poblacion_area-n").html(" <i class='fas fa-circle' style='color:red;font-size:.8em'></i>");
            else
                $("#poblacion_area-n").html("");

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
                //"idProductoSector"

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
                    listadobs();
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

        function  agregabs(){
            $("#listado-bs").hide("slow");
            $("#registro-bs").show("slow");
            $("#btnAlmacenarG").hide("slow");
            limpiaBS();
        }

        function listadobs(){
            $("#registro-bs").hide("slow");
            $("#listado-bs").show("slow"); 
            $("#btnAlmacenarG").show("slow"); 
            getbss();          
        }

        function almacenabs(){
            if(validabs()){
                data = {
                    idBS : $("#idBS").val(),                
                    nombreBS : $("#nombrebs").val(),
                    descripcionBS : $("#descripcionbs").val(),
                    p_entrega : $("#p_entrega").val(),
                    p_otro : $("#p_otro").val(),
                    unidad_medidaBS : $("#unidad_medida").val(),
                    descripcionBS : $("#descripcionbs").val(),
                    ia_id : $("#idPPA").val(),
                    _token : $("input[name='_token']").val()
                }
                
                $.ajax({
                    type: 'POST',
                    url: "{{ route('ia.almacenabs') }}",
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        $("#body-bs").block({
                            message: '<h4>Procesando...</h4>',
                            css: { border: '3px solid gray', backgroundColor:'black','-webkit-border-radius': '10px','-moz-border-radius':'10px',width:"15%",color:"white" }
                        });
                        //block(true);
                    }
                }).done(function(response) {
                    //block(false);
                    $("#body-bs").unblock();
                    if (response.result == "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Bienes y Servicios',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {listadobs()});                        
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Bienes y Servicios',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
                    }
                });
   
            }
        }

        function validabs(){
            inputs = [
                    "nombrebs",
                    "p_entrega",                    
                    "unidad_medida",
                    "descripcionbs"
                ];
                selects = [
                    "p_entrega",

    
                ];

                if($("#p_entrega").val()=="otro")
                    inputs.push("p_otro");
                else{
                    index = inputs.indexOf("p_otro")
                    if(index){
                        inputs.splice(index,0)
                        $("#p_otro").removeClass("is-invalid");
                    }                   
                }
    
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

        function limpiaBS(){
            $("#idBS").val("");
            $("#nombrebs").val("");
            $("#p_entrega").val("");
            $("#p_otro").val("");
            $("#unidad_medida").val("");
            $("#descripcionbs").val("");
            $("#nombrebs").removeClass("is-invalid");
            $("#p_entrega").removeClass("is-invalid");
            $("#p_otro").removeClass("is-invalid");
            $("#unidad_medida").removeClass("is-invalid");
            $("#descripcionbs").removeClass("is-invalid");            
            $("#p_otro").hide("is-invalid");

        }

        function getbss(){
            $.ajax({
                    type: 'GET',
                    url: "{{ route('ia.getbss') }}",
                    data: {ia_id : $("#idPPA").val()},
                    //dataType: 'json',
                    beforeSend: function() {
                        $("#body-bs").block({
                            message: '<h4>Procesando...</h4>',
                            css: { border: '3px solid gray', backgroundColor:'black','-webkit-border-radius': '10px','-moz-border-radius':'10px',width:"15%",color:"white" }
                        });
                    }
                }).done(function(response) {
                    $("#body-bs").unblock();
                    $("#table-listado-bs").html(response);
                });
        }

        function editbs(idBS){
            $.ajax({
                    type: 'GET',
                    url: "{{ route('ia.getinfobs') }}",
                    data: {idBS : idBS},
                    dataType: 'json',
                    beforeSend: function() {
                        $("#body-bs").block({
                            message: '<h4>Procesando...</h4>',
                            css: { border: '3px solid gray', backgroundColor:'black','-webkit-border-radius': '10px','-moz-border-radius':'10px',width:"15%",color:"white" }
                        });
                    }
                }).done(function(response) {
                    $("#body-bs").unblock();
                    if(response.result=="ok"){
                        limpiaBS();
                        $("#idBS").val(response.bs.idBS);
                        $("#descripcionbs").val(response.bs.descripcionBS);
                        $("#unidad_medida").val(response.bs.unidad_medidaBS);
                        $("#p_otro").val(response.bs.p_otro);
                        $("#p_entrega").val(response.bs.p_entrega);
                        $("#nombrebs").val(response.bs.nombreBS);
                        if($("#p_entrega").val() == "otro")
                            potro();   
                            
                        $("#listado-bs").hide("slow");
                        $("#registro-bs").show("slow");
                        $("#btnAlmacenarG").hide("slow");                                         
                    }else{
                        limpiaBS();
                    }                    
                });    
        }

        function removebs(idBS){
            Swal.fire({
                            icon: 'question',
                            title: 'Bienes y Servicios',
                            text: "¿Está seguro de querer borrar este Bien o Servicio?, considere que toda la información relacionada con dicho registro será eliminada permanentemente del sistema",                                                                      
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Sí, Eliminar!',
                            showCancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                        type: 'POST',
                                        url: "{{ route('ia.removebs') }}",
                                        data: {idBS : idBS,_token:$("input[name='_token']").val()},
                                        dataType: 'json',
                                        beforeSend: function() {
                                            $("#body-bs").block({
                                                message: '<h4>Procesando...</h4>',
                                                css: { border: '3px solid gray', backgroundColor:'black','-webkit-border-radius': '10px','-moz-border-radius':'10px',width:"15%",color:"white" }
                                            });
                                            //block(true);
                                        }
                                    }).done(function(response) {
                                        //block(false);
                                        $("#body-bs").unblock();
                                        if (response.result == "ok") {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Bienes y Servicios',
                                                text: response.message,
                                                confirmButtonColor: '#3085d6',
                                            }).then((result) => {listadobs()});                        
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Bienes y Servicios',
                                                text: response.message,
                                                confirmButtonColor: '#3085d6',
                                            }).then((result) => {});
                                        }
                                    });
                            }                        
                        });
        }

        function changep(seleccion){            
            if(seleccion!=""){                
                if(seleccion=="p_a_" || seleccion == "a_p_"){
                $("#p_select").css("background-color","green");
                $("#p_select").css("color","white");
                $("#p_select").html('<i class="fas fa-check"></i> Población objetivo');
                $("#p_select").attr("seleccionado","true");

                $("#a_select").css("background-color","green");
                $("#a_select").css("color","white");
                $("#a_select").html('<i class="fas fa-check"></i> Área de enfoque');                            
                $("#a_select").attr("seleccionado","true");

                $(".a_").show();
                $(".p_").show();
                $("#tipo_p").val(seleccion);

                }else{
                    
                    seleccionado = $("#"+seleccion+"select").attr("seleccionado");                            
                    if(seleccionado == "false"){                  
                        $("#"+seleccion+"select").css("background-color","green");
                        $("#"+seleccion+"select").css("color","white");
                        $("#"+seleccion+"select").html('<i class="fas fa-check"></i> '+(seleccion=='p_'?'Población objetivo':'Área de enfoque'));            
                        $("#tipo_p").val($("#tipo_p").val() + seleccion);
                        $("#"+seleccion+"select").attr("seleccionado","true");    
                        $("."+seleccion).show("slow");
                        
                    }else{
                        $("#"+seleccion+"select").css("background-color","gray");
                        $("#"+seleccion+"select").css("color","white");
                        $("#"+seleccion+"select").html((seleccion=='p_'?'Población objetivo':'Área de enfoque'));
                        $("#tipo_p").val($("#tipo_p").val().replace(seleccion,""));
                        $("#"+seleccion+"select").attr("seleccionado","false");
                        $("."+seleccion).hide("slow");
                    }
                }  
            }            
                      

        }

        function poo(){
            if($("#tipo_poblacion_id").val()=="16"){
                $("#tipo_poblacion_otro").show("slow");
            }else{
                $("#tipo_poblacion_otro").hide("slow");
            }

        }
        function setVigente(idPPA,checked){
            $.ajax({
                type: 'POST',
                url: "{{ route('itar.setvigente') }}",
                data: {
                    idPPA,
                    vigente: checked ? 1 : 0,
                    _token: $("input[name='_token']").val()
                },
                dataType: 'json'
            }).done(function(response) {
                if (response.result == "ok") {
                    Swal.fire('Error', response.message, 'error')
                }
            }).fail(function(){
                Swal.fire('Error','NO se pudo actualizar la vigencia','error' )
            });
        }

    </script>
@endsection

