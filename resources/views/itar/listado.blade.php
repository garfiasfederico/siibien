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
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body" id="indicadorContent">
                    <div class="" style="text-align: right;padding:10px;">
                        <button class="btn btn-success" onclick="fillSolicitud()"><i class="fas fa-plus"></i> Agregar PPA</button>
                    </div>
                    @if (count($ppas) > 0)
                        <table class="table table-bordered table-striped" id="dataTableItar" width="100%" cellspacing="0"
                            style="color: black!important">
                            <thead style="background-color: #919090;color:white;">
                                <tr style="text-align: center">
                                    <th>Prioritario</th>
                                    <th>Id</th>
                                    <th>Nombre del PPA</th>
                                    <th>Objetivo</th>
                                    <th>Descripcion</th>
                                    <th>Cobertura</th>
                                    <th>Responsable</th>
                                    <th>Año de inicio</th>
                                    <th>Estatus</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ppas as $ppa)
                                    <tr>
                                        <td style="text-align:center;color:rgb(192, 192, 192);vertical-align:middle">
                                            <i class="fas fa-star prioritario" style="@if($ppa->prioritario==0) color: gray @else color:gold @endif;font-size:1.3em;cursor:pointer" title="@if($ppa->prioritario==0) ordinario @else prioritario @endif"></i><br/>@if($ppa->prioritario==0) ordinario @else prioritario @endif
                                        </td>
                                        <td style="vertical-align: middle">{{ $ppa->id }}</td>
                                        <td style="vertical-align: middle">{{ $ppa->nombre }}</td>
                                        <td style="vertical-align: middle">{{ $ppa->objetivo }}</td>
                                        <td style="vertical-align: middle">{{ $ppa->descripcion }}</td>
                                        <td style="vertical-align: middle">{{ $ppa->cobertura }}</td>
                                        <td style="text-align: center;vertical-align: middle">{{ $ppa->dependenciaSiglas }}
                                        </td>
                                        <td style="vertical-align: middle">{{ $ppa->anio_inicio }}</td>
                                        <td style="vertical-align: middle;text-align:center">
                                            @if($ppa->estado!="revision")
                                                <button class="btn btn-warning" id="btnupt{{$ppa->id}}" style="" onclick="uptEstado({{$ppa->id}},'revision')"><i class="fas fa-paper-plane"></i> Enviar a revisión</button>
                                            @else
                                                <button class="btn btn-secondary"  style="" disabled><i class="fas fa-paper-plane"></i> PPA en revisión</button>
                                            @endif
                                        </td>
                                        <td class="" style="text-align: left;vertical-align: middle">
                                            @if($ppa->estado!="revision")
                                                <button style="margin:5px;width:150px;text-align:left"
                                                    class="btn btn-sm btn-primary" type="button" title="Datos Generales"
                                                    onclick="getDataPPA({{$ppa->id}})"><i class="fas fa-list"></i>
                                                    Datos Generales</button>
                                                <br />
                                                <form action="{{route("ia.seguimiento")}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="idPPA" value="{{$ppa->id}}">
                                                    <button style="margin:5px;width:150px;text-align:left"
                                                    class="btn btn-sm btn-success" type="submit" title="Seguimiento"><i
                                                        class="fas fa-tachometer-alt"></i> Seguimiento</button>
                                                </form>                                                   
                                            @endif
                                                <form action="{{route("ia.reportes")}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="idPPA" value="{{$ppa->id}}">                                                
                                                    <button style="margin:5px;width:150px;text-align:left"
                                                        class="btn btn-sm btn-info" type="submit" title="Reportes"><i
                                                            class="fas fa-chart-line"></i> Reportes</button>
                                                </form> 
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
                    <button class="btn btn-primary" type="button" onclick="Almacenar()" id="btnAlmacenarG">Almacenar</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalSolicitud" tabindex="-1" role="dialog" aria-labelledby="accionModalLabel" data-backdrop="static" data-keyboard="false"
        aria-hidden="true" style="color: black!important">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="accionModalLabel">Solicitud de alta de PPA</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <div style="width: 100%;" id="datosPPA">
                        <div style="text-align: right;padding:10px;"><button class="btn btn-info" onclick="getSolicitudes()"><i class="fas fa-list"></i> Ver solicitudes</button></div>
                        <b>Instrucciones:</b>Favor de rellenar los campos siguientes para solicitar a la ITE el registro del nuevo PPA, una vez registrada dicha solicitud, la ITE realizará el análisis correspondiente derivando en la aceptación o declinación de la solicitud. Para verficiar el estatus de dicha alta consulte el botón ubicado en la parte superior de esta ventana. 
                        <div class="col-lg-12" style="padding:20px;">
                            <div class="card shadow">
                                <div class="card-header py-3" style="background-color:rgb(157, 36, 73);color:white">
                                    <h6 class="m-0 font-weight-bold text-light" onclick="toggle('chevgenerales_s','body-generales_s')"
                                        style="cursor: pointer;color:white">Campos generales <i class="fas fa-chevron-down"
                                            id="chevgenerales_s"></i>
                                    </h6>
                                </div>
                                <div class="card-body" id="body-generales_s">
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
                                                            <input type="radio" name="tipo_s" id="programa_s" value="programa"
                                                                onclick="voidReglas_s()" style="transform:scale(1)" checked/> &nbsp; Programa
                                                        </td>
                                                        <td class="" colspan="" id="reglasDisplay_s"
                                                            style="text-align: center; border:solid 1px rgb(218, 218, 218);display:none">
                                                            <table style="width: 100%">
                                                                <tr>
                                                                    <td rowspan="2">Reglas de Operación</td>
                                                                    <td rowspan=""><input type="radio" name="reglas_s"
                                                                            value="si" id="reglassi_s" class="radio"
                                                                            style="transform:scale(1)"                                                                           
                                                                            onclick="linkro_s()" checked/>
                                                                        &nbsp; Si</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="radio" value="no" name="reglas_s"
                                                                            class="radio" id="reglasno_s" style="transform:scale(1)"
                                                                            onclick="linkro_s()"/>
                                                                        &nbsp; No</td>
                                                                </tr>
                                                            </table>
                                                            <input type="text"
                                                                style="width: 100%;"
                                                                placeholder="Link de reglas de operación" class="form-control"
                                                                id="link_r_o_s">
                                                            <div class="invalid-feedback">
                                                                Debe Indicar el link de la reglas de operación.
                                                            </div>
                                                        </td>
                                                        <td class="" colspan=""
                                                            style="text-align: center;border:solid 1px rgb(218, 218, 218);">
                                                            <input type="radio" name="tipo_s" value="proyecto" id="proyecto_s"
                                                                class="radio" onclick="voidReglas_s()" style="transform:scale(1)" />
                                                            &nbsp; Proyecto
                                                        </td>
                                                        <td class="" colspan="1"
                                                            style="text-align: center;border:solid 1px rgb(218, 218, 218);">
                                                            <input type="radio" name="tipo_s" value="accion" class="radio"
                                                                id="accion_s" onclick="voidReglas_s()" style="transform:scale(1)" />
                                                            &nbsp; Acción
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="enc1" style="width: 15%">Nombre: <span style="color: red">*</span> <i
                                                    class="fas fa-question-circle"></i></td>
                                            <td class="" colspan="3">
                                                <input class="form-control" name="nombre_s" id="nombre_s" placeholder="Indica el Nombre del PPA" style="color: black">
                                                <div class="invalid-feedback">
                                                    Debe Indicar el Nombre del PPA
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="enc1" style="width: 15%">Objetivo: <span style="color: red">*</span> <i
                                                    class="fas fa-question-circle"></i></td>
                                            <td class="" colspan="3">
                                                <textarea class="form-control" name="objetivo_s" id="objetivo_s" cols="30" rows="2"
                                                    placeholder="Indica el Objetivo del PPA" style="color: black"></textarea>
                                                <div class="invalid-feedback">
                                                    Debe Indicar el Objetivo del PPA
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="enc1" style="width: 15%">Descripción: <span style="color: red">*</span>
                                                <i class="fas fa-question-circle"></i></td>
                                            <td class="" colspan="3">
                                                <textarea class="form-control" name="descripcion_s" id="descripcion_s" cols="30" rows="2"
                                                    placeholder="Indica la Descripción del PPA" style="color: black"></textarea>
                                                <div class="invalid-feedback">
                                                    Debe Indicar la Descripción del PPA
                                                </div>
                                            </td>
                                        </tr>      
                                        <tr>
                                            <td class="enc1" style="width: 15%">Bienes o servicios: <span style="color: red">*</span>
                                                <i class="fas fa-question-circle"></i></td>
                                            <td class="" colspan="3">
                                                <textarea class="form-control" name="bss_s" id="bss_s" cols="30" rows="2"
                                                    placeholder="Indica los bienes o servicios que serían definidos para este PPA" style="color: black"></textarea>
                                                <div class="invalid-feedback">
                                                    Debe Indicar los bienes o servicios que quedarían para este PPA
                                                </div>
                                            </td>
                                        </tr>                                                          
                                    </table>
                                    <hr>
                                    <h4>Alineación</h4>
                                    <table style="width: 100%">
                                        <tr>
                                            <td class="enc1">Eje PED:<span style="color: red">*</span></td>
                                            <td>
                                                <select id="idEjePED_s" class="form-control" onchange="getTemas_s()">
                                                    <option value="">Seleccione...</option>
                                                    @foreach ($ejes as $eje )
                                                        <option value="{{$eje->idEjePED}}">{{$eje->ejePEDClave." ".$eje->ejePEDDescripcion}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Debe Indicar el Eje del PED al cual se alinea el PPA
                                                </div>
                                            </td>
                                        </tr>
                                        
                                        <tr>                                           
                                                <td class="enc1">Tema PED:<span style="color: red">*</span></td>
                                                <td>
                                                    <select name="idTemaPED_s" id="idTemaPED_s" class="form-control">
                                                        <option value="">Seleccione...</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Debe Indicar el Tema PED al cual se alinea el PPA
                                                    </div>
                                                </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>                    
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" onclick="almacenarSolicitud()" id="">Registrar solicitud</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalSolicitudes" tabindex="-1" role="dialog" aria-labelledby="accionModalLabel" data-backdrop="static" data-keyboard="false"
        aria-hidden="true" style="color: black!important">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="accionModalLabel">Registro de Solicitudes de altas de PPAs</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <div style="width: 100%;" id="solicitudesPPA">                        
                        <div class="col-lg-12" style="padding:20px;">
                            <div class="card shadow">
                                <div class="card-header py-3" style="background-color:rgb(157, 36, 73);color:white">
                                    <h6 class="m-0 font-weight-bold text-light" onclick="toggle('chevsolicitudes','body-solicitudes')"
                                        style="cursor: pointer;color:white">Solicitudes registradas <i class="fas fa-chevron-down"
                                            id="chevsolicitudes"></i>
                                    </h6>
                                </div>
                                <div class="card-body" id="body-solicitudes" style="max-height:500px;overflow:auto">
                                    
                                </div>
                            </div>
                        </div>                    
                    </div>
                </div>
                <div class="modal-footer">                    
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
                    [1, 'asc']
                ],
            });           
            voidReglas();
            linkro();
            $('#modalSolicitudes')
            .on('hidden.bs.modal', function (e) {
                $("#modalSolicitud").modal("show");
            });
            $('#modalSolicitudes')
            .on('show.bs.modal', function (e) {
                $("#modalSolicitud").modal("hide");
            });

            $("#collapse-itar").addClass("show");

        });



        function uptEstado(idPPA, estado) {

            Swal.fire({
                title: '¿Está Seguro?',
                text: "La información del ppa: [" + idPPA + "] " +
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
                            location.reload()
                        } else {                            
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

        function almacenarSolicitud(){
                        
            if(validaSolicitudPPA()){
                tipo = "";
                reglas = "";
                link_ro = "";

                if($("#programa_s").prop("checked")){
                    tipo='programa';                
                    reglas= $("#reglassi_s").prop("checked")?1:0;
                    link_ro = $("#link_r_o_s").val();
                }
                else{
                        if($("#proyecto_s").prop("checked"))
                            tipo='proyecto';
                        else
                            tipo='accion';
                }

                nombre = $("#nombre_s").val();
                objetivo = $("#objetivo_s").val();
                descripcion = $("#descripcion_s").val();
                idEjePED = $("#idEjePED_s").val();
                idTemaPED = $("#idTemaPED_s").val();
                idDependencia = {{auth()->user()->enlace->idDependencia}};  
                bss = $("#bss_s").val();    
                token = $("input[name='_token']").val();

                data =  {
                    tipo:tipo,
                    r_o:reglas,
                    link_r_o:link_ro,
                    nombre:nombre,
                    descripcion:descripcion,
                    objetivo:objetivo,
                    idEjePED:idEjePED,
                    idTemaPED:idTemaPED,
                    idDependencia:idDependencia,
                    bss:bss,
                    _token:token
                };

                $.ajax({
                    type: 'POST',
                    url: "{{ route('ia.almacenappatemporal') }}",
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        $("#body-generales_s").block({
                            message: '<h4>Procesando...</h4>',
                            css: { border: '3px solid gray', backgroundColor:'black','-webkit-border-radius': '10px','-moz-border-radius':'10px',width:"15%",color:"white" }
                        });
                        //block(true);
                    }
                }).done(function(response) {
                    //block(false);
                    $("#body-generales_s").unblock();
                    if (response.result == "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: 'ITAR, Registro de Solicitud de Alta de PPA',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {limpiaSolicitud();getSolicitudes()});                        
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'ITAR, Registro de Solicitud de Alta de PPA',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
                    }
                });
            }else{
                Swal.fire({
                            icon: 'warning',
                            title: 'Validación de Datos de solicitud de alta de PPA',
                            text: "Favor de atender las observaciones marcadas en rojo.",
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {});
            }
        }

        function fillSolicitud(){            
            $("#modalSolicitud").modal("show");
            voidReglas_s();
        }

        function voidReglas_s() {
            //alert($("input[name='tipo_s']:checked").val());

            if ($("input[name='tipo_s']:checked").val() != "programa") {
                $("input[name='reglas_s']:checked").prop("checked", false);
                $("#reglasDisplay_s").hide("slow");
            } else {
                $("#reglassi_s").prop("checked", true);
                $("#reglasDisplay_s").show("slow");
            }
        }

        function linkro_s(){
            if($("#reglassi_s").prop("checked"))
                $("#link_r_o_s").show();
            else{
                $("#link_r_o_s").hide();
                $("#link_r_o_s").removeClass("is-invalid");
            }                
        }

        function validaSolicitudPPA(){
            inputs = [
                "objetivo_s",
                "descripcion_s",
                "nombre_s",
                "bss_s"              
            ];
            selects = [
                "idEjePED_s",
                "idTemaPED_s"
               // "p_entrega",
            ];

            

            if($("#reglassi_s").prop("checked")){
                inputs.push("link_r_o_s");
                $("#link_r_o_s").show("slow");
            }                
            else{
                index = inputs.indexOf("link_r_o_s")
                if(index){
                    inputs.splice(index,0)
                    $("#link_r_o_s").removeClass("is-invalid");
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

        function getTemas_s() {
            if ($("#idEjePED_s").val() != "") {
                $("#idTemaPED_s").html("<option value=''>Seleccione</option>");                


                $.ajax({
                    type: 'GET',
                    url: "{{ route('gettemas') }}",
                    data: {
                        idEjePED: $("#idEjePED_s").val()
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
                        $("#idTemaPED_s").html(options);
                    }                    
                });
            } 
        }

        function limpiaSolicitud(){
            $("#link_r_o_s").val("");
            $("#nombre_s").val("");
            $("#descripcion_s").val("");
            $("#objetivo_s").val("");
            $("#idEjePED_s").val("");
            $("#idTemaPED_s").html("<option value=''>Seleccione...</option>");
        }

        function getSolicitudes(){

            $.ajax({
                    type: 'GET',
                    url: "{{ route('ia.getsolicitudes') }}",
                    data: {
                        idDependencia: {{auth()->user()->enlace->idDependencia}}
                    },
                    //dataType: 'json',
                    beforeSend: function() {
                        $("#body-solicitudes").block({
                            message: '<h4>Procesando...</h4>',
                            css: { border: '3px solid gray', backgroundColor:'black','-webkit-border-radius': '10px','-moz-border-radius':'10px',width:"15%",color:"white" }
                        });                        
                    }
                }).done(function(response) {
                    $("#body-solicitudes").unblock();
                    $("#body-solicitudes").html(response);                                        
                    $("#modalSolicitudes").modal("show");
                });
        }
    </script>
@endsection
