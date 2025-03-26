@extends('layouts.administrador')
@section('encabezado')
    ITAR / Listado de PPAs
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
                                        <td class="" style="text-align: center">                                            
                                            <form action="{{ route('itar.edit') }}" 
                                                style="float:left;margin:5px;display:none" method="POST">
                                                @csrf
                                                <input type="hidden" name="idITAR" value="{{ $ppa->id }}" />
                                                <button class="btn btn-sm btn-info" type="submit"><i
                                                        class="fas fa-edit"></i></button>
                                            </form>
                                            <button class="btn btn-primary"><i class="fas fa-info"></i></button>
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

        function uptEstado(id,estado){
            $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.itar.uptestado') }}",
                    data: {
                        idITAR: id,
                        estado:estado,
                        _token: $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        //block(true)
                        $("#btnupt"+id).html('<i class="fas fa-spinner fa-spin"></i>');
                    }
                }).done(function(response) {
                    if (response.result == "ok") {
                        if(estado=="edicion"){
                            $("#btnupt"+id).html('<i class="fas fa-ban"></i>');
                            $("#btnupt"+id).removeClass('btn-success');
                            $("#btnupt"+id).addClass('btn-secondary');
                            $("#btnupt"+id).attr('onclick','uptEstado('+id+',"revision")');
                            estado_ = "Liberada";

                        }else{
                            $("#btnupt"+id).html('<i class="fas fa-ban"></i>');
                            $("#btnupt"+id).addClass('btn-success');
                            $("#btnupt"+id).removeClass('btn-secondary');
                            $("#btnupt"+id).attr('onclick','uptEstado('+id+',"edicion")');
                            estado_ = "Bloqueada";

                        }
                        $("#result-alert").css('background-color',"green");
                        $("#result-alert").html("La edición del PPA ha sido <b>"+estado_+"</b> correctamente!");
                        $("#result-alert").show("fast");
                        setTimeout(function(){$("#result-alert").hide("slow");},3000);


                    } else {
                        $("#result-alert").css('background-color',"red");
                        $("#result-alert").html("Ocurrió un error al tratar de cambiar el estado del PPA!");
                        $("#result-alert").show("fast");
                        setTimeout(function(){$("#result-alert").hide("slow");},3000);
                        $("#btnupt"+id).html('<i class="fas fa-ban"></i>');
                        $("#btnupt"+id).removeClass('btn-success');
                        $("#btnupt"+id).removeClass('btn-secondary');
                        $("#btnupt"+id).addClass('btn-danger');


                    }
                }).fail(function(data) {
                   // block(false)
                });
        }
    </script>
@endsection
