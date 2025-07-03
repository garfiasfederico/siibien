@php
    use Illuminate\Support\Facades\DB;

    $acciones2024 = DB::table('informe_acciones_2024')
        ->where('idDependencia', auth()->user()->enlace->idDependencia)
        ->where('idTemaPED', $tema->idTemaPED)
        ->get();

    $parrafosPorAccion = DB::table('informe_parrafos_2024')
        ->whereIn('informe_acciones_id', $acciones2024->pluck('id'))
        ->get()
        ->groupBy('informe_acciones_id');
@endphp

<div class="modal fade" id="modalInforme2024" tabindex="-1" role="dialog" aria-labelledby="modalInformeLabel"
    aria-hidden="true" style="color: black !important;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #681b2e; color:white">
                <h5 class="modal-title" id="modalInformeLabel">Información reportada del Segundo Informe 2024</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" style="color:white">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                    <h4>Tema: {{ $tema->temaPEDClave . ' ' . $tema->temaPEDDescripcion }}</h4>

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

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>