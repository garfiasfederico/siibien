@php
    use Illuminate\Support\Facades\DB;

    $acciones2024 = DB::table('informe_acciones_2024')
        ->where('idDependencia', auth()->user()->enlace->idDependencia)
        ->where('idTemaPED', $tema->idTemaPED)
        ->get();
    
    $acciones2025 = DB::table('informe_acciones')
        ->where('idDependencia', auth()->user()->enlace->idDependencia)
        ->where('idTemaPED', $tema->idTemaPED)
        ->get();

    $parrafosPorAccion = DB::table('informe_parrafos_2024')
        ->whereIn('informe_acciones_id', $acciones2024->pluck('id'))
        ->get()
        ->groupBy('informe_acciones_id');
    
    $parrafosPorAccion2025 = DB::table('informe_parrafos_2025')
        ->whereIn('informe_acciones_id', $acciones2025->pluck('id'))
        ->get()
        ->groupBy('informe_acciones_id');
@endphp

<div class="modal fade" id="modalInformeHistorico" tabindex="-1" role="dialog" aria-labelledby="modalInformeLabel"
    aria-hidden="true" style="color: black !important;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #681b2e; color:white">
                <h5 class="modal-title" id="modalInformeLabel">Información reportada en Informes Anteriores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" style="color:white">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                    <h4>Tema: {{ $tema->temaPEDClave . ' ' . $tema->temaPEDDescripcion }}</h4>

                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist" style="">
                            <a class="nav-item nav-link active" id="nav-2025-tab" data-toggle="tab" href="#nav-2025" role="tab"
                                aria-controls="nav-2025" aria-selected="true">3er. Informe<span id="2025-historico"></span></a>
                            <a class="nav-item nav-link" id="nav-2024-tab" data-toggle="tab" href="#nav-2024" role="tab"
                                aria-controls="nav-2024" aria-selected="false">2do. Informe<span id="2024-historico"></span></a>                            
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-2025" role="tabpanel"aria-labelledby="nav-2025-tab">   
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr class="text-center align-middle">
                                        <th class="align-middle" style="width: 10%">ID PPA 2025</th>
                                        <th class="align-middle" style="width: 25%">Nombre del PPA 2025</th>
                                        <th class="align-middle" style="width: 65%">Párrafos Redactados 2025</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($acciones2025 as $accion)
                                        @php
                                            $parrafos = $parrafosPorAccion2025[$accion->id] ?? collect();
                                        @endphp
                                        <tr>
                                            <td class="text-center align-middle">{{ $accion->id }}</td>
                                            <td class="align-middle">{{ $accion->nombre }}</td>
                                            <td class="align-middle">
                                                @if ($parrafos->isEmpty())
                                                    <em class="text-muted">Sin párrafos registrados</em>
                                                @else
                                                    <button class="btn btn-sm btn-outline-primary mb-2 toggle-parrafos" type="button"
                                                        data-toggle="collapse" data-target="#collapseParrafos2025{{ $accion->id }}"
                                                        aria-expanded="false" aria-controls="collapseParrafos2025{{ $accion->id }}">
                                                        <span class="parrafo-label">Ver</span> párrafos
                                                        ({{ $parrafos->count() }})
                                                    </button>
                                                    <div class="collapse mt-2" id="collapseParrafos2025{{ $accion->id }}">
                                                        <ul class="mb-0 pl-3 text-left">
                                                            @foreach ($parrafos as $p)
                                                                <li>{{ $p->resultado }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center align-middle">
                                                No hay PPA registradas del 2025 en esta dependencia.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>                    
                        </div>   
                        <div class="tab-pane fade" id="nav-2024" role="tabpanel"aria-labelledby="nav-2024-tab">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr class="text-center align-middle">
                                        <th class="align-middle" style="width: 10%">ID PPA 2024</th>
                                        <th class="align-middle" style="width: 25%">Nombre del PPA 2024</th>
                                        <th class="align-middle" style="width: 65%">Párrafos Redactados 2024</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($acciones2024 as $accion)
                                        @php
                                            $parrafos = $parrafosPorAccion[$accion->id] ?? collect();
                                        @endphp
                                        <tr>
                                            <td class="text-center align-middle">{{ $accion->id }}</td>
                                            <td class="align-middle">{{ $accion->nombre }}</td>
                                            <td class="align-middle">
                                                @if ($parrafos->isEmpty())
                                                    <em class="text-muted">Sin párrafos registrados</em>
                                                @else
                                                    <button class="btn btn-sm btn-outline-primary mb-2 toggle-parrafos" type="button"
                                                        data-toggle="collapse" data-target="#collapseParrafos{{ $accion->id }}"
                                                        aria-expanded="false" aria-controls="collapseParrafos{{ $accion->id }}">
                                                        <span class="parrafo-label">Ver</span> párrafos
                                                        ({{ $parrafos->count() }})
                                                    </button>
                                                    <div class="collapse mt-2" id="collapseParrafos{{ $accion->id }}">
                                                        <ul class="mb-0 pl-3 text-left">
                                                            @foreach ($parrafos as $p)
                                                                <li>{{ $p->resultado }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center align-middle">
                                                No hay PPA registradas del 2024 en esta dependencia.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>                      
                    </div>
                    
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>