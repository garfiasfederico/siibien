@extends('layouts.administrador')

@section('encabezado')
    Asistencias / Seleccionar evento activo
@endsection

@section('styles')
    <style>
        :root {
            --brand: #681b2e;
            /* primario */
            --brand-2: #7c2f42;
            /* secundario */
            --bg-soft: #f7f7f9;
            --text-1: #1d1d1f;
            --text-2: #666;
            --border: #e6e6e6;
            --ok: #28a745;
            --chip: #edf2f7;
        }

        .brand-primary {
            background: var(--brand);
            color: #fff;
        }

        /* Header */
        .page-tools {
            gap: .5rem;
        }

        .page-tools .form-control {
            min-width: 220px;
        }

        /* Contenedor de tarjetas */
        .ev-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 18px;
        }

        @media (max-width: 1199px) {
            .ev-grid {
                grid-template-columns: repeat(12, 1fr);
            }
        }

        @media (max-width: 992px) {
            .ev-grid {
                grid-template-columns: repeat(12, 1fr);
            }
        }

        @media (max-width: 768px) {
            .ev-grid {
                grid-template-columns: repeat(6, 1fr);
            }
        }

        @media (max-width: 576px) {
            .ev-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .ev-card {
            grid-column: span 4;
            /* 3 cards por fila en XL/LG; 2 en MD; 1 en XS */
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .04);
            display: flex;
            flex-direction: column;
            padding: 16px;
            position: relative;
            overflow: hidden;
            transition: box-shadow .2s ease, transform .12s ease;
        }

        @media (max-width: 992px) {
            .ev-card {
                grid-column: span 6;
            }
        }

        @media (max-width: 576px) {
            .ev-card {
                grid-column: span 4;
            }
        }

        .ev-card:hover {
            box-shadow: 0 10px 28px rgba(0, 0, 0, .08);
            transform: translateY(-1px);
        }

        .ev-ribbon {
            position: absolute;
            top: 14px;
            right: -38px;
            transform: rotate(35deg);
            background: linear-gradient(90deg, var(--brand), var(--brand-2));
            color: #fff;
            font-weight: 700;
            font-size: .72rem;
            letter-spacing: .06em;
            padding: 6px 42px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, .12);
        }

        .ev-title {
            font-weight: 700;
            color: var(--text-1);
            font-size: 1.05rem;
            margin-bottom: .25rem;
        }

        .ev-desc {
            color: var(--text-2);
            min-height: 44px;
            margin-bottom: .35rem;
        }

        .ev-meta {
            display: flex;
            flex-wrap: wrap;
            gap: .35rem .6rem;
            margin-bottom: .6rem;
            color: var(--text-2);
            font-size: .92rem;
        }

        .ev-meta .chip {
            background: var(--chip);
            border-radius: 999px;
            padding: .25rem .6rem;
            font-size: .83rem;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
        }

        .ev-metrics {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: auto;
            gap: .75rem;
        }

        .metric {
            background: var(--bg-soft);
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 10px 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 120px;
        }

        .metric .label {
            font-size: .82rem;
            color: #777;
        }

        .metric .value {
            font-weight: 700;
            color: #222;
        }

        .btn-ghost {
            background: #fff;
            border: 1px solid var(--brand-2);
            color: var(--brand-2);
        }

        .btn-ghost:hover {
            background: var(--brand-2);
            color: #fff;
        }

        .empty {
            border: 1px dashed var(--border);
            background: #fafafa;
            color: #555;
            border-radius: 12px;
            padding: 28px 18px;
            text-align: center;
        }

        /* Buscador / filtros */
        .filters .form-control,
        .filters .custom-select {
            border-radius: 10px;
        }
    </style>
@endsection

@section('content')
    @csrf

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between brand-primary">
                    <h6 class="m-0 font-weight-bold" style="color:white !important">
                        Eventos activos
                    </h6>
                    <div class="page-tools d-flex">
                        <a href="{{ route('eventos.activos') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    <div class="filters d-flex flex-wrap align-items-center justify-content-end mb-3"
                        style="gap:.6rem 1rem;">
                        <div class="input-group d-none" style="max-width:300px;">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input id="searchInput" type="text" class="form-control"
                                placeholder="Buscar por nombre, sede o descripción…">
                        </div>
                        <div>
                            <select id="sedeSelect" class="custom-select">
                                <option value="">Todas las sedes</option>
                                @php
                                    $sedes = $eventosActivos->pluck('sede')->filter()->unique()->values();
                                @endphp
                                @foreach($sedes as $s)
                                    <option value="{{ strtolower($s) }}">{{ e($s) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- Contenido --}}
                    @if($eventosActivos->isEmpty())
                        <div class="empty">
                            <i class="far fa-calendar-times fa-lg"></i>
                            <div class="mt-2">No hay eventos activos en este momento.</div>
                        </div>
                    @else
                        <div id="grid" class="ev-grid">
                            @foreach($eventosActivos as $ev)
                                @php
                                    $inicio = $ev->inicio ?? '';
                                    $fin = $ev->fin ?? '';
                                    $desc = trim($ev->descripcion ?? '');
                                    $sede = trim($ev->sede ?? '');
                                @endphp
                                <div class="ev-card" data-name="{{ strtolower($ev->nombre) }}" data-sede="{{ strtolower($sede) }}"
                                    data-desc="{{ strtolower($desc) }}">

                                    <div class="ev-ribbon">EN CURSO</div>

                                    <div class="ev-title">{{ e($ev->nombre) }}</div>

                                    @if($desc)
                                        <div class="ev-desc">{{ e(Str::limit($desc, 140)) }}</div>
                                    @else
                                        <div class="ev-desc text-muted"><em>Sin descripción</em></div>
                                    @endif

                                    <div class="ev-meta">
                                        @if($sede)
                                            <span class="chip"><i class="fas fa-map-marker-alt"></i>{{ e($sede) }}</span>
                                        @endif
                                        @if($inicio)
                                            <span class="chip" title="Inicio">
                                                <i class="far fa-clock"></i>{{ $inicio }}
                                            </span>
                                        @endif
                                        @if($fin)
                                            <span class="chip" title="Fin">
                                                <i class="far fa-hourglass"></i>{{ $fin }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="ev-metrics">
                                        <div class="metric">
                                            <div class="label">Asistencias</div>
                                            <div class="value"><i class="fas fa-user-check text-success"></i> {{ $ev->asistencias }}
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center" style="gap:.5rem;">
                                            <a class="btn btn-ghost"
                                                href="{{ route('eventos.asistencias', ['id' => $ev->idEvento]) }}">
                                                <i class="fas fa-qrcode"></i> Abrir asistencias
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function () {
            const $search = document.getElementById('searchInput');   // puede NO existir
            const $sede = document.getElementById('sedeSelect');    // debe existir
            const $grid = document.getElementById('grid');          // debe existir
            const $count = document.getElementById('countShown');    // puede NO existir

            if (!$grid || !$sede) return;

            function normalize(s) { return (s || '').toString().trim().toLowerCase(); }

            function applyFilters() {
                const term = $search ? normalize($search.value) : '';   
                const sede = normalize($sede.value);

                let shown = 0;

                Array.from($grid.children).forEach(card => {
                    const name = card.getAttribute('data-name') || '';
                    const s = card.getAttribute('data-sede') || '';
                    const desc = card.getAttribute('data-desc') || '';

                    const matchText = !term || name.includes(term) || s.includes(term) || desc.includes(term);
                    const matchSede = !sede || s === sede;

                    const visible = matchText && matchSede;
                    card.style.display = visible ? '' : 'none';
                    if (visible) shown++;
                });

                if ($count) $count.textContent = shown; 
            }

            // Listeners (protegidos)
            if ($search) $search.addEventListener('input', debounce(applyFilters, 80));
            $sede.addEventListener('change', applyFilters);

            applyFilters();

            function debounce(fn, wait) {
                let t; return function () { clearTimeout(t); t = setTimeout(fn, wait); };
            }
        })();
    </script>

@endsection