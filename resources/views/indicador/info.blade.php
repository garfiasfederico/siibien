<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
            aria-controls="nav-home" aria-selected="true">Metadatos<span id="objseleccionados"></span></a>
        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab"
            aria-controls="nav-profile" aria-selected="false">Variables<span
                id="objodsseleccionados"></span></a>
        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab"
            aria-controls="nav-contact" aria-selected="false">Alineación a los Instrumentos de Planeación<span
                id="programasseleccionados"></span></a>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel"aria-labelledby="nav-home-tab">
        <div style="padding:20px;">
            <table>
                <tr>
                    <td class="label">Nombre:</td>
                    <td class="valor">{{ $indicador->indicadorNombre }}</td>
                </tr>
                <tr>
                    <td class="label">Definición:</td>
                    <td class="valor">{{ $indicador->indicadorObjetivo }}</td>
                </tr>
                <tr>
                    <td class="label">Tipo:</td>
                    <td class="valor">{{ $indicador->indicadorTipo }}</td>
                </tr>
                <tr>
                    <td class="label">Dimensión:</td>
                    <td class="valor">{{ $indicador->indicadorDimension }}</td>
                </tr>
                <tr>
                    <td class="label">Método de cálculo:</td>
                    <td class="valor">{{ $indicador->indicadorMetodo }}</td>
                </tr>
                <tr>
                    <td class="label">Formula:</td>
                    <td class="valor">{{ $indicador->indicadorFormula }}</td>
                </tr>
                <tr>
                    <td class="label">Unidad de Medida:</td>
                    <td class="valor">{{ $indicador->indicadorUM }}</td>
                </tr>
                <tr>
                    <td class="label">Interpretación:</td>
                    <td class="valor">{{ $indicador->indicadorInterpretacion }}</td>
                </tr>
                <tr>
                    <td class="label">Frecuencia:</td>
                    <td class="valor">{{ $indicador->indicadorFrecuencia }}</td>
                </tr>               
                <tr>
                    <td class="label">Sentido:</td>
                    <td class="valor">{{ $indicador->indicadorSentido }}</td>
                </tr>
                <tr>
                    <td class="label">Desagregación:</td>
                    <td class="valor">{{ $indicador->indicadorDesagregacion }}</td>
                </tr>
                <tr>
                    <td class="label">Año de Línea Base:</td>
                    <td class="valor">{{ $indicador->indicadorAnioLB }}</td>
                </tr>
                <tr>
                    <td class="label">Valor de Línea Base:</td>
                    <td class="valor">{{ $indicador->valorAnioLB }}</td>
                </tr>
                <tr>
                    <td class="label">Fecha de Próxima Actualización:</td>
                    <td class="valor">{{ $indicador->proxima_actualizacion }}</td>
                </tr>
                <tr>
                    <td class="label">Responsable:</td>
                    <td class="valor">{{ $indicador->dependenciaNombre }}</td>
                </tr>
                <tr>
                    <td class="label">Observaciones:</td>
                    <td class="valor">{{ $indicador->observaciones }}</td>
                </tr>
                <tr>
                    <td class="label">Estatus:</td>
                    <td class="valor">{{ $indicador->status == 1 ? 'Activo' : 'Dado de Baja' }}</td>
                </tr>
            </table>
        </div>

    </div>
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

        <div class="row">

            @foreach ($variables as $variable)
                <div class="col-lg-6 mb-4" style="padding:20px;">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Variable: {{ $variable->variableNombre }}
                            </h6>
                        </div>
                        <div class="card-body">
                            Unidad de Medida: {{ $variable->variableUM }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
        <div class="col-lg-12" style="padding:20px;">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Alineación al PED
                    </h6>
                </div>
                <div class="card-body">
                    @if (count($objetivos) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        Clave
                                    </th>
                                    <th>
                                        Descripción
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($objetivos as $objetivo)
                                    <tr>
                                        <td>
                                            Eje {{ $objetivo->ejePEDClave }}
                                        </td>
                                        <td>
                                            {{ $objetivo->ejePEDDescripcion }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Tema {{ $objetivo->temaPEDClave }}
                                        </td>
                                        <td>
                                            {{ $objetivo->temaPEDDescripcion }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Objetivo {{ $objetivo->objetivoPEDClave }}
                                        </td>
                                        <td>
                                            {{ $objetivo->objetivoPEDDescripcion }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>                        
                    @else
                    <div class="text-center" style="color:rgb(113, 113, 113)">
                        No existen Objetivos Asociados al Indicador!
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-12" style="padding:20px;">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Alineación con los Objetivos ODS
                    </h6>
                </div>
                <div class="card-body">
                    @if (count($objetivosods) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        Clave
                                    </th>
                                    <th>
                                        Descripción
                                    </th>
                                    <th>
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($objetivosods as $objetivo)
                                    <tr>
                                        <td>
                                            {{ $objetivo->clave }}
                                        </td>
                                        <td>
                                            {{ $objetivo->descripcion }}
                                        </td>
                                        <td>
                                            <img style="width:100px;" src="{{asset('/resources/images/ODS/'.$objetivo->clave.'.png')}}"/>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                    <div class="text-center" style="color:rgb(113, 113, 113)">
                        No existen ODS Asociados al Indicador!
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-12" style="padding:20px;">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Alineación con los Programas Presupuestales
                    </h6>
                </div>
                <div class="card-body">
                    @if (count($programas) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        Clave
                                    </th>
                                    <th>
                                        Descripción
                                    </th>                                    
                                    <th>
                                        Nivel
                                    </th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($programas as $programa)
                                    <tr>
                                        <td>
                                            {{ $programa->clavePrograma }}
                                        </td>
                                        <td>
                                            {{ $programa->descripcionPrograma }}
                                        </td>      
                                        <td>
                                            {{ ($programa->nivel==1?"Fin":($programa->nivel==2?"Propósito":($programa->nivel==3?"Componente":"Actividad")) )}}
                                        </td>                                  
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                    <div class="text-center" style="color:rgb(113, 113, 113)">
                        No existen Programas Presupuestales Asociados al Indicador!
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
<style>
    .label {
        color: black;
        font-weight: bold;
        padding: 5px;
    }

    .valor {
        border-bottom: dashed 1px rgb(218, 218, 218);
        font-size: 1.1em;

    }
</style>
