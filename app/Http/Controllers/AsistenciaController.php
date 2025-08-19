<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Evento;
use App\Models\Registro;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\Request;



class AsistenciaController extends Controller
{

    //Seccion del listado de registros de asistenci
    public function listadoRegistros()
    {
        $usuario = Auth::user();

        if (!$usuario->hasRole('administrador') && !$usuario->hasRole('administrador_evento')) {
            return view('nopermitido');
        }
        $registros = DB::table('registros as r')
            ->leftJoin('dependencia as d', 'd.idDependencia', '=', 'r.idDependencia')
            ->select([
                'r.idRegistro',
                'r.idDependencia',
                'r.nombre',
                'r.cargo',
                'r.email',
                'r.telefono',
                'r.perfil',
                'r.tipo_enlace',
                'r.qr_uuid',
                DB::raw("COALESCE(d.dependenciaSiglas, d.dependenciaNombre) AS dependencia"),
            ])
            ->orderByDesc('r.idRegistro')
            ->get();
        $dependencias = DB::table('dependencia')
            ->select('idDependencia', 'dependenciaNombre', 'dependenciaSiglas')
            ->orderBy('dependenciaNombre')
            ->get();

        // Agregar data URL SVG a cada registro (evita Imagick)
        foreach ($registros as $r) {
            if (!empty($r->qr_uuid)) {
                // QR "amigable" para lectores de navegador
                $svg = QrCode::format('svg')
                    ->size(380)
                    ->margin(4)// 16 
                    ->errorCorrection('M')
                    ->color(0, 0, 0)
                    ->backgroundColor(255, 255, 255)
                    ->generate((string) $r->qr_uuid);

                // Data URL para usar en <img src="...">
                $r->qr_svg_data = 'data:image/svg+xml;base64,' . base64_encode($svg);
            } else {
                $r->qr_svg_data = null;
            }
        }


        return view('eventos.listadoRegistros', compact('registros', 'dependencias'));
    }
    public function actualizarRegistro(Request $request, int $id)
    {
        // Validación (equivalente a $this->validate)
        $request->validate([
            'cargo' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'perfil' => 'nullable|string|max:255',
            'tipo_enlace' => 'required|in:Directivo,Operativo,Otro',
        ]);

        try {
            $registro = Registro::find($id);
            if (!$registro) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registro no encontrado.',
                ], 404);
            }

            $registro->cargo = $request->cargo;
            $registro->telefono = $request->filled('telefono') ? $request->telefono : null;
            $registro->perfil = $request->filled('perfil') ? $request->perfil : null;
            $registro->tipo_enlace = $request->tipo_enlace;

            $registro->saveOrFail();

            return response()->json([
                'success' => true,
                'message' => 'Registro actualizado correctamente.',
                'data' => [
                    'idRegistro' => $registro->idRegistro,
                    'cargo' => $registro->cargo,
                    'telefono' => $registro->telefono,
                    'perfil' => $registro->perfil,
                    'tipo_enlace' => $registro->tipo_enlace,
                ],
            ], 200);

        } catch (\Throwable $ex) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al guardar.',
            ], 500);
        }
    }
    //Seccion para los eventos
    public function listadoEventos()
    {        //Falta crear la bandera de autorizacion , la que tiene es una que ya existe 

        $usuario = auth()->user();
        $esAdmin = $usuario->hasAnyRole(['administrador', 'administrador_evento']);
        $tieneIE = (bool) ($usuario->ie ?? false);

        // Autorización
        if (!($tieneIE || $esAdmin)) {
            return view('nopermitido');
        }

        $eventos = Evento::orderByDesc('idEvento')->get()->map(function ($e) {
            $estadoStr = [0 => 'pendiente', 1 => 'activo', 2 => 'finalizado'][$e->estado] ?? 'pendiente';

            $fi = $e->fecha_inicio ? Carbon::parse($e->fecha_inicio)->format('Y-m-d H:i:s') : '';
            $ff = $e->fecha_fin ? Carbon::parse($e->fecha_fin)->format('Y-m-d H:i:s') : '';

            // Conteo de asistencias del evento
            $asistCount = DB::table('asistencia_eventos')
                ->where('idEvento', $e->idEvento)
                ->count();

            $e->estado_str = $estadoStr;
            $e->fecha_inicio_fmt = $fi;
            $e->fecha_fin_fmt = $ff;
            $e->asistencias_cnt = $asistCount;
            // Solo se puede eliminar si es pendiente y no tiene asistencias
            $e->can_delete = ($estadoStr === 'pendiente' && $asistCount === 0);

            return $e;
        });

        return view('eventos.listadoEventos', compact('eventos'));
    }




    public function registrarEvento(Request $request)
    {
        $request->validate([
            'idEvento' => 'nullable|integer',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        try {
            $inicio = $request->filled('fecha_inicio')
                ? Carbon::parse(str_replace('T', ' ', $request->fecha_inicio))
                : null;
            $fin = $request->filled('fecha_fin')
                ? Carbon::parse(str_replace('T', ' ', $request->fecha_fin))
                : null;

            // === EDITAR POR ID (nunca crear aquí) ===
            if ($request->filled('idEvento')) {
                $evento = Evento::find($request->idEvento);
                if (!$evento) {
                    return response()->json(['success' => false, 'message' => 'Evento no encontrado.'], 404);
                }
                if ((int) $evento->estado !== 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Este evento no puede editarse (no está en pendiente).'
                    ], 409);
                }

                $evento->nombre = $request->nombre;
                $evento->descripcion = $request->descripcion ?: null;
                $evento->fecha_inicio = $inicio;
                $evento->fecha_fin = $fin;
                // No tocar estado
                $evento->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Evento actualizado.',
                    'data' => [
                        'idEvento' => $evento->idEvento,
                        'nombre' => $evento->nombre,
                        'descripcion' => $evento->descripcion,
                        'fecha_inicio' => $evento->fecha_inicio ? $evento->fecha_inicio->format('Y-m-d H:i:s') : '',
                        'fecha_fin' => $evento->fecha_fin ? $evento->fecha_fin->format('Y-m-d H:i:s') : '',
                        'estado' => (int) $evento->estado,
                        'estado_str' => [0 => 'pendiente', 1 => 'activo', 2 => 'finalizado'][$evento->estado] ?? 'pendiente',
                    ],
                ]);
            }

            $evento = Evento::updateOrCreate(
                ['nombre' => $request->nombre, 'fecha_inicio' => $inicio],
                [
                    'descripcion' => $request->descripcion ?: null,
                    'fecha_fin' => $fin,
                    'estado' => 0, // siempre pendiente al crear
                ]
            );

            return response()->json([
                'success' => true,
                'message' => $evento->wasRecentlyCreated ? 'Evento creado.' : 'Evento actualizado.',
                'data' => [
                    'idEvento' => $evento->idEvento,
                    'nombre' => $evento->nombre,
                    'descripcion' => $evento->descripcion,
                    'fecha_inicio' => $evento->fecha_inicio ? $evento->fecha_inicio->format('Y-m-d H:i:s') : '',
                    'fecha_fin' => $evento->fecha_fin ? $evento->fecha_fin->format('Y-m-d H:i:s') : '',
                    'estado' => (int) $evento->estado,
                    'estado_str' => [0 => 'pendiente', 1 => 'activo', 2 => 'finalizado'][$evento->estado] ?? 'pendiente',
                ],
            ]);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'No se pudo registrar el evento.'], 500);
        }
    }
    public function cambiarEstado(Request $request, int $id)
    {
        $request->validate([
            'estado' => 'required|string|in:pendiente,activo,finalizado',
        ]);

        $map = ['pendiente' => 0, 'activo' => 1, 'finalizado' => 2];

        return DB::transaction(function () use ($id, $request, $map) {
            $evento = Evento::lockForUpdate()->find($id);
            if (!$evento) {
                return response()->json(['success' => false, 'message' => 'Evento no encontrado'], 404);
            }

            $actual = (int) $evento->estado;
            $nuevo = $map[$request->estado];

            // Transiciones permitidas: pendiente->activo, activo->finalizado
            $valida = ($actual === 0 && $nuevo === 1) || ($actual === 1 && $nuevo === 2);
            if (!$valida) {
                return response()->json(['success' => false, 'message' => 'Cambio de estado no permitido'], 409);
            }

            // Activar: verificar que no haya otro activo
            if ($nuevo === 1) {
                $yaHayActivo = Evento::where('estado', 1)
                    ->where('idEvento', '<>', $evento->idEvento)
                    ->lockForUpdate()
                    ->exists();

                if ($yaHayActivo) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ya existe un evento activo. Primero finaliza el evento activo actual.'
                    ], 422);
                }
            }

            $evento->estado = $nuevo;
            $evento->save();

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado correctamente',
                'data' => [
                    'idEvento' => $evento->idEvento,
                    'estado' => $evento->estado,
                    'estado_str' => ['pendiente', 'activo', 'finalizado'][$evento->estado] ?? 'pendiente',
                ]
            ]);
        });
    }

    public function eliminarEvento(int $id)
    {
        try {
            return DB::transaction(function () use ($id) {
                $evento = Evento::lockForUpdate()->find($id);
                if (!$evento) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Evento no encontrado.'
                    ], 404);
                }

                // Única regla en backend: solo si está PENDIENTE (estado = 0)
                if ((int) $evento->estado !== 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Solo se pueden eliminar eventos en pendiente.'
                    ], 422);
                }

                $evento->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Evento eliminado correctamente.'
                ]);
            });
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el evento.'
            ], 500);
        }
    }



    //Seccion para la asitencia de eventos
    public function asistenciaEventos()
    {
        //Falta crear la bandera de autorizacion , la que tiene es una que ya existe 
        $usuario = auth()->user();
        $esAdmin = $usuario->hasAnyRole(['administrador', 'administrador_evento']);
        $tieneIE = (bool) ($usuario->ie ?? false);

        // Autorización
        if (!($tieneIE || $esAdmin)) {
            return view('nopermitido');
        }

        $eventoActivo = Evento::where('estado', 1)
            ->orderByDesc('idEvento')
            ->first();

        $asistencias = collect();

        if ($eventoActivo) {
            $asistencias = DB::table('asistencia_eventos as a')
                ->join('registros as r', 'r.idRegistro', '=', 'a.idRegistro')
                ->leftJoin('dependencia as d', 'd.idDependencia', '=', 'r.idDependencia')
                ->where('a.idEvento', $eventoActivo->idEvento)
                ->orderByDesc('a.scanned_at')
                ->get([
                    'a.idAsistencia',
                    'a.idEvento',
                    'r.idRegistro',
                    'r.nombre',
                    'r.qr_uuid',
                    DB::raw("COALESCE(d.dependenciaSiglas, d.dependenciaNombre) AS dependencia"),
                    DB::raw("DATE_FORMAT(a.scanned_at, '%Y-%m-%d %H:%i') as scanned_at"),
                ]);
        }

        // KPI: último registro
        $kpiUltimo = $asistencias->first()->scanned_at ?? '—';

        return view('eventos.asistenciaEvento', [
            'eventoActivo' => $eventoActivo,
            'idEvento' => $eventoActivo?->idEvento,
            'estadoEvento' => $eventoActivo ? 'activo' : null,
            'asistencias' => $asistencias,
            'kpiUltimo' => $kpiUltimo,
        ]);
    }


    public function checkIn(Request $request)
    {
        $request->validate([
            'qr_uuid' => 'required|string',
            'idEvento' => 'required|integer|exists:eventos,idEvento',
        ]);

        $evento = Evento::find($request->idEvento);

        if (!$evento || (int) $evento->estado !== 1) {
            return response()->json([
                'success' => false,
                'message' => 'El evento no está activo.'
            ], 409);
        }

        $registro = Registro::where('qr_uuid', $request->qr_uuid)->first();
        if (!$registro) {
            return response()->json([
                'success' => false,
                'message' => 'QR no encontrado en registros.'
            ], 404);
        }

        // Verificar si ya existe asistencia para este evento/registro
        $asistencia = DB::table('asistencia_eventos')
            ->where('idEvento', $evento->idEvento)
            ->where('idRegistro', $registro->idRegistro)
            ->first();

        if ($asistencia) {
            return response()->json([
                'success' => true,
                'message' => 'Asistencia ya registrada.',
                'data' => [
                    'idAsistencia' => $asistencia->idAsistencia,
                    'idEvento' => $evento->idEvento,
                    'idRegistro' => $registro->idRegistro,
                    'nombre' => $registro->nombre,
                    'dependencia' => DB::table('dependencia')
                        ->where('idDependencia', $registro->idDependencia)
                        ->value(DB::raw("COALESCE(dependenciaSiglas, dependenciaNombre)")),
                    'checkin_at' => $asistencia->scanned_at,
                    'duplicado' => true
                ]
            ], 200);
        }

        // Insertar nueva asistencia
        $idAsistencia = DB::table('asistencia_eventos')->insertGetId([
            'idEvento' => $evento->idEvento,
            'idRegistro' => $registro->idRegistro,
            'scanned_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-in registrado.',
            'data' => [
                'idAsistencia' => $idAsistencia,
                'idEvento' => $evento->idEvento,
                'idRegistro' => $registro->idRegistro,
                'nombre' => $registro->nombre,
                'dependencia' => DB::table('dependencia')
                    ->where('idDependencia', $registro->idDependencia)
                    ->value(DB::raw("COALESCE(dependenciaSiglas, dependenciaNombre)")),
                'checkin_at' => now()->format('Y-m-d H:i:s'),
                'duplicado' => false
            ]
        ], 201);
    }
    public function desgloseDependencias(int $id)
{
    $usuario = auth()->user();
    $esAdmin = $usuario->hasAnyRole(['administrador', 'administrador_evento']);
    $tieneIE = (bool) ($usuario->ie ?? false);

    if (!($tieneIE || $esAdmin)) {
        return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
    }

    $evento = Evento::find($id);
    if (!$evento) {
        return response()->json(['success' => false, 'message' => 'Evento no encontrado'], 404);
    }

    // Base: asistencias del evento join registros y dependencias
    $rows = DB::table('asistencia_eventos as a')
        ->join('registros as r', 'r.idRegistro', '=', 'a.idRegistro')
        ->leftJoin('dependencia as d', 'd.idDependencia', '=', 'r.idDependencia')
        ->where('a.idEvento', $evento->idEvento)
        ->get([
            'r.nombre',
            'r.cargo',
            DB::raw("COALESCE(d.dependenciaSiglas, d.dependenciaNombre) AS dep"),
            DB::raw("DATE_FORMAT(a.scanned_at, '%Y-%m-%d %H:%i') as hora"),
        ]);

    // Agrupar por dependencia
    $map = [];
    foreach ($rows as $row) {
        $dep = $row->dep ?: '—';
        if (!isset($map[$dep])) {
            $map[$dep] = [
                'dep'       => $dep,
                'presentes' => 0,
                'firstAt'   => null,
                'lastAt'    => null,
                'personas'  => [],
            ];
        }
        $map[$dep]['presentes']++;
        $map[$dep]['personas'][] = [
            'nombre' => $row->nombre ?? '—',
            'cargo' => $row->cargo ?? '_',
            'hora'   => $row->hora ?? '',
        ];

        if ($row->hora) {
            if ($map[$dep]['firstAt'] === null || $row->hora < $map[$dep]['firstAt']) {
                $map[$dep]['firstAt'] = $row->hora;
            }
            if ($map[$dep]['lastAt'] === null || $row->hora > $map[$dep]['lastAt']) {
                $map[$dep]['lastAt'] = $row->hora;
            }
        }
    }

    // A arreglo y ordenar por presentes desc, luego nombre asc
    $dependencias = array_values($map);
    usort($dependencias, function ($a, $b) {
        if ($a['presentes'] !== $b['presentes']) return $b['presentes'] <=> $a['presentes'];
        return strcmp($a['dep'], $b['dep']);
    });

    return response()->json([
        'success' => true,
        'data' => [
            'idEvento'     => $evento->idEvento,
            'nombre'       => $evento->nombre,
            'dependencias' => $dependencias,
        ]
    ]);
}


}
