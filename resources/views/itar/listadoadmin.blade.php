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
                                    <th>Id</th>
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
                                        <td>{{ $ppa->id }}</td>
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
                                            <button class="btn btn-sm btn-primary" style="margin:5px;width:150px;text-align:left" onclick="getInfoPPA({{$ppa->id}})"><i class="fas fa-info"></i> Datos Generales</button>
                                            <form action="{{route("ia.seguimiento")}}" method="POST">
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
    <div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="accionModalLabel" data-backdrop="static" data-keyboard="false"
        aria-hidden="true" style="color: black!important">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="accionModalLabel">información del PPA</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <div style="width: 100%;" id="infoPPA">

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
    <script>
        $(document).ready(function() {
            $("#dataTableItar").DataTable({
                pageLength: 10,
                lengthMenu: [10, 20, 50],
                order: [
                    [0, 'asc']
                ],
            })
        });

        function uptEstado(idPPA,estado){
            Swal.fire({
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


    </script>
@endsection

