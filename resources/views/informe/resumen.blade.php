@php
    use App\Models\LineaPED;
    use App\Models\AnexoEstadistico;
    use App\Models\InformeParrafo;
@endphp
@extends('layouts.administrador')
@section('encabezado')
    Redacción por acciones del Segundo Informe de Gobierno
@endsection
@section('content')
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
            style="background-color: #681b2e;">
            <h6 class="m-0 font-weight-bold text-light">Acciones registradas
            </h6>

        </div>
        <!-- Card Body -->
        <div class="card-body" id="indicadorContent">
            <center>
                <h4>Reporte por Lineas de Acción del PED</h4>
                <div style="text-align: right;padding-right:15px;">
                </div>
                <hr />
                <table class="table table-bordered table-striped" style="padding: 15px; width:100%" id="tableLineas">
                    <thead>
                        <tr style="padding: 15px;background-color:gray;color:white;text-align:center">

                            <th style="width: 20%">Eje</th>
                            <th style="width: 20%">Tema</th>
                            <th style="width: 5%">Id Línea</th>
                            <th style="width: 20%">Línea de Acción</th>
                            <th style="width: 35%">Acciones reportadas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($lineas->count() > 0)
                            @foreach ($lineas as $linea)
                                <tr>
                                    @php
                                        switch($linea->idEjePED){
                                            case 1:
                                                $color = 'rgb(129,78,147)';
                                            break;
                                            case 2:
                                                $color = 'rgb(222,98,109)';
                                            break;
                                            case 3:
                                                $color = 'rgb(83,182,170)';
                                            break;
                                            case 4:
                                                $color = 'rgb(96,120,172)';
                                            break;
                                            case 5:
                                                $color = 'rgb(114,184,90)';
                                            break;
                                            default:
                                                $color = 'rgb(0,0,0)';
                                            break;
                                        }
                                    @endphp
                                    <td style="vertical-align: middle;text-align:center">{{ $linea->ejePEDClave." ".$linea->ejePEDDescripcion }}</td>
                                    <td style="vertical-align: middle;text-align:center">{{ $linea->temaPEDClave." ".$linea->temaPEDDescripcion }}</td>
                                    <td style="vertical-align: middle;text-align:center">{{ $linea->idLAPED }}</td>
                                    <td style="vertical-align: middle;text-align:center"><b>{{ $linea->laPEDClave." ".$linea->laPEDDescripcion }}</b></td>
                                    <td style="vertical-align: middle;text-align:left">
                                        @if(count($valores[$linea->idLAPED])>0)
                                        <table class="table striped" style="width: 100%">
                                            <thead style="background-color:{{$color}};color:white">
                                                <tr>
                                                    <th style="width: 50%">Acción</th>
                                                    <th style="width: 10%">Párrafos</th>
                                                    <th style="width: 20%">Dependencia</th>
                                                    <th style="width: 20%">Anexo</th>
                                                </tr>
                                            </thead>
                                        @endif
                                        @foreach($valores[$linea->idLAPED] as $valor)
                                        @if($valor!=null)
                                            @php
                                                echo "<tr>";
                                                $campos = explode("|",$valor);
                                                foreach ($campos as $campo) {
                                                    echo "<td>".$campo."</td>";
                                                }
                                                echo "</tr>";
                                            @endphp
                                        @endif
                                        @endforeach
                                        @if(count($valores[$linea->idLAPED])>0)
                                        </table>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </center>
        </div>
    </div>


@endsection



@section('scripts')
<script>
$(document).ready(function(){
    $("#tableLineas").DataTable({
                pageLength: 20,
                lengthMenu: [20, 50, 100, 200],
                order: [
                    [2, 'asc']
                ],
    });
});
</script>
@endsection
