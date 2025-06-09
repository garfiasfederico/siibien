<?php

namespace App\Http\Controllers;

use App\Models\EjePED;
use App\Models\TemaPED;
use App\Models\ObjetivoPED;
use App\Models\EstrategiaPED;
use App\Models\LineaPED;
use App\Models\ObjetivoSector;
use App\Models\EstrategiaSector;
use App\Models\InformeAccion;
use App\Models\IABS;
use App\Models\Dependencia;
use App\Models\ProductoPE;
use App\Models\AlineacionGeneralProducto;
use App\Models\IndicadorProducto;
use App\Models\ProgramaPresupuestario;
use App\Models\ProgramaPresupuestarioProducto;
use App\Models\SeguimientoMeta;
use App\Models\MedioVerificacion;
use App\Models\Titular;
use App\Models\PsObservacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use TCPDF;
use Illuminate\Support\Facades\Storage;

class ProductoSectorialController extends Controller
{


    public function listarProductosSectoriales()
    {
        $usuario = auth()->user();
        $dependenciaUsuario = $usuario->enlace ? $usuario->enlace->dependencia : null;
        $enlace = $usuario->enlace ?? null;
        $productosQuery = ProductoPE::leftJoin('alineacion_general_producto', 'productos_pes.idProducto', '=', 'alineacion_general_producto.idProducto')
            ->join('dependencia', 'productos_pes.idDependencia', '=', 'dependencia.idDependencia')
            ->select(
                'productos_pes.*',
                'alineacion_general_producto.idObjetivoPED',
                'dependencia.dependenciaNombre',
                'dependencia.dependenciaSiglas'
            );

        if ($dependenciaUsuario) {
            $productosQuery->where('productos_pes.idDependencia', $dependenciaUsuario->idDependencia);
        }

        $productos = $productosQuery->get();

        if (auth()->user()->ipes)
            return view('productosSectoriales.productossectoriales', [
                'productos' => $productos,
                'ejes' => EjePED::all(),
                'temas' => TemaPED::all(),
                'objetivos' => ObjetivoPED::all(),
                'estrategias' => EstrategiaPED::all(),
                'lineasaccionped' => LineaPED::all(),
                'objetivosSector' => ObjetivoSector::all(),
                'estrategiasSector' => EstrategiaSector::all(),
                'ppas' => InformeAccion::all(),
                'nombresbs' => IABS::all(),
            ]);
        else
            return view("nopermitido");

    }


    public function mostrarFormularioCaptura()
    {
        // Obtener el usuario autenticado
        $usuario = Auth::user();
        $dependenciaUsuario = $usuario->enlace ? $usuario->enlace->dependencia : null;
        $dependencias = Dependencia::all();

        // Pasar las dependencias y la dependencia del usuario a la vista
        return view('productosSectoriales.productossectoriales', [
            'dependencias' => $dependencias,    // Pasar todas las dependencias
            'dependenciaUsuario' => $dependenciaUsuario,  // Pasar la dependencia asociada al usuario
            'ejes' => EjePED::all(),
            'temas' => TemaPED::all(),
            'objetivos' => ObjetivoPED::all(),
            'estrategias' => EstrategiaPED::all(),
            'lineasaccionped' => LineaPED::all(),
            'objetivosSector' => ObjetivoSector::all(),
            'estrategiasSector' => EstrategiaSector::all(),
            $ppas = InformeAccion::where('idDependencia', $dependenciaUsuario->idDependencia)->get(),

            'nombresbs' => IABS::all(),
        ]);
    }

    // Guardar el producto sectorial
    public function guardarProductoSectorial(Request $request)
    {
        DB::beginTransaction();

        try {
            $usuario = Auth::user();

            if (!$usuario->enlace || !$usuario->enlace->dependencia) {
                return response()->json([
                    "result" => "error",
                    "message" => "No tienes una dependencia asignada."
                ], 200);
            }

            // Crear o actualizar producto
            if ($request->idProducto) {
                $producto = ProductoPE::find($request->idProducto);

                if (!$producto) {
                    return response()->json([
                        "result" => "error",
                        "message" => "Producto no encontrado para actualizar."
                    ], 404);
                }

                $producto->update([
                    'nombre_producto' => $request->nombreProducto,
                    'idDependencia' => $usuario->enlace->dependencia->idDependencia,
                ]);

                $mensaje = "Producto actualizado correctamente.";
            } else {
                $producto = ProductoPE::create([
                    'nombre_producto' => $request->nombreProducto,
                    'idDependencia' => $usuario->enlace->dependencia->idDependencia,
                ]);

                $mensaje = "Producto creado correctamente.";
            }

            // Validación básica
            if (empty($request->bienesServicios)) {
                return response()->json([
                    "result" => "error",
                    "message" => "No se seleccionaron bienes o servicios."
                ], 400);
            }

            if (empty($request->nombrePPA)) {
                return response()->json([
                    "result" => "error",
                    "message" => "Debe seleccionar al menos un PPA."
                ], 400);
            }

            // Crear o actualizar alineación
            AlineacionGeneralProducto::updateOrCreate(
                ['idProducto' => $producto->idProducto],
                [
                    'idEjePED' => $request->idEjePED,
                    'idTemaPED' => $request->idTemaPED,
                    'idObjetivoPED' => $request->idObjetivoPED,
                    'idEstrategiaPED' => $request->idEstrategiaPED,
                    'idLAPED' => $request->idLAPED,
                    'idObjetivo' => $request->idObjetivo,
                    'idEstrategia' => $request->idEstrategia,
                    'id' => $request->nombrePPA, // <- PPA múltiple
                    'idBS' => $request->bienesServicios, // <- Bienes múltiples
                ]
            );

            // Indicadores
            IndicadorProducto::updateOrCreate(
                ['idProducto' => $producto->idProducto],
                [
                    'tipo' => $request->tipoIndicador,
                    'metodo_calculo' => $request->calculoIndicador,
                    'frecuencia_medicion' => $request->frecuenciaMedicion,
                    'sentido_esperado' => $request->sentidoEsperado,
                    'unidad_medida_producto' => $request->unidadIndicador,
                    'unidad_medida_indicador' => $request->unidadMedidaIndicador,
                    'medio_verificacion_indicador' => $request->medioIndicador,
                ]
            );

            DB::commit();

            return response()->json([
                "result" => "ok",
                "message" => $mensaje
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al guardar los datos: ', ['error' => $e->getMessage()]);
            return response()->json([
                "result" => "error",
                "message" => "Error al guardar los datos: " . $e->getMessage()
            ], 500);
        }
    }


    public function obtenerDatosGenerales($id)
    {
        try {
            \Log::info("Buscando producto con ID: $id");

            $producto = ProductoPE::from('productos_pes')
                ->leftJoin('alineacion_general_producto as agp', 'productos_pes.idProducto', '=', 'agp.idProducto')
                ->leftJoin('indicadores_producto as ip', 'productos_pes.idProducto', '=', 'ip.idProducto')
                ->where('productos_pes.idProducto', $id)
                ->select([
                    'productos_pes.idProducto as idProducto',
                    'productos_pes.nombre_producto as nombreProducto',
                    'productos_pes.idDependencia as idDependencia',
                    'agp.idEjePED',
                    'agp.idTemaPED',
                    'agp.idObjetivoPED',
                    'agp.idEstrategiaPED',
                    'agp.idLAPED',
                    'agp.idObjetivo',
                    'agp.idEstrategia',
                    'agp.id as idPPA',
                    'agp.idBS',
                    'ip.tipo as tipoIndicador',
                    'ip.metodo_calculo as calculoIndicador',
                    'ip.frecuencia_medicion',
                    'ip.sentido_esperado',
                    'ip.unidad_medida_producto as unidadIndicador',
                    'ip.unidad_medida_indicador',
                    'ip.medio_verificacion_indicador as medioIndicador'
                ])
                ->first();

            if (!$producto) {
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }

            return response()->json($producto);

        } catch (\Exception $e) {
            \Log::error("Error al obtener datos del producto: " . $e->getMessage());
            return response()->json(['error' => 'Error interno'], 500);
        }
    }
    //Eliminar Bien o Servicio:
    public function eliminarBien($productoId, $bienId)
    {
        // Obtener la alineación del producto
        $alineacion = AlineacionGeneralProducto::where('idProducto', $productoId)->first();

        if (!$alineacion) {
            return response()->json([
                'success' => false,
                'message' => 'Alineación no encontrada.'
            ], 404);
        }

        // Separar los ID de bienes/servicios
        $bienes = explode(',', $alineacion->idBS);

        // Filtrar el ID a eliminar
        $bienesFiltrados = array_filter($bienes, function ($id) use ($bienId) {
            return trim($id) != trim($bienId);
        });

        // Actualizar el campo si hubo cambios
        $alineacion->idBS = implode(',', $bienesFiltrados);
        $alineacion->save();

        return response()->json([
            'success' => true,
            'message' => 'Bien o servicio eliminado correctamente.'
        ]);
    }
    //Elimnar PPA
    public function eliminarPPA($productoId, $ppaId)
    {
        try {
            $alineacion = AlineacionGeneralProducto::where('idProducto', $productoId)->first();

            if (!$alineacion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Alineación no encontrada.'
                ], 404);
            }

            // Limpiar PPAs
            $ppas = explode(',', $alineacion->id ?? '');
            $ppasFiltrados = array_filter($ppas, fn($id) => trim($id) !== trim($ppaId));
            $alineacion->id = implode(',', $ppasFiltrados);

            // Eliminar bienes asociados al PPA
            $bienesActuales = explode(',', $alineacion->idBS ?? '');
            $bienesFiltrados = [];
            $bienesEliminados = [];

            foreach ($bienesActuales as $bienId) {
                $bienId = trim($bienId);
                if (!is_numeric($bienId) && !ctype_digit($bienId))
                    continue;

                $bien = IABS::where('idBS', $bienId)->first(); // ← Aquí es el cambio clave
                if (!$bien || is_null($bien->ia_id))
                    continue;

                if ((string) $bien->ia_id === (string) $ppaId) {
                    $bienesEliminados[] = $bienId;
                } else {
                    $bienesFiltrados[] = $bienId;
                }
            }


            $alineacion->idBS = implode(',', $bienesFiltrados);
            $alineacion->save();

            return response()->json([
                'success' => true,
                'message' => 'PPA y bienes relacionados eliminados correctamente.',
                'bienesEliminados' => $bienesEliminados
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al eliminar PPA: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error en el servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    //Seguimiento de producto:

    public function seguimiento($idProducto)
    {
        $producto = ProductoPE::findOrFail($idProducto);

        // Obtener los seguimientos del producto por año
        $seguimientos = ProgramaPresupuestarioProducto::where('idProducto', $idProducto)
            ->orderBy('anio') // Ordenar por año
            ->get();
        return view('productosSectoriales.seguimientoProductos', compact('producto', 'seguimientos'));
    }

    public function mostrarFormularioSeguimiento($idProducto)
    {
        // Obtener el producto por su ID
        $producto = ProductoPE::findOrFail($idProducto);

        // Obtener todos los programas presupuestarios
        $programapresupuestarios = ProgramaPresupuestario::all();  // Obtención de todos los programas

        // Obtener los años disponibles para este producto desde la tabla programa_presupuestario_producto
        $anosDisponibles = ProgramaPresupuestarioProducto::where('idProducto', $idProducto)
            ->select('anio')
            ->distinct()  // Obtener años únicos
            ->get();

        // Obtener los seguimientos por año para ese producto
        $seguimientos = ProgramaPresupuestarioProducto::where('idProducto', $idProducto)
            ->orderBy('anio') // Ordenar por año
            ->get();

        // Pasar tanto el producto como los programas, los años disponibles y los seguimientos a la vista
        return view('productosSectoriales.seguimientoProductos', [
            'producto' => $producto,
            'programapresupuestarios' => $programapresupuestarios,  // Pasar los programas obtenidos
            'anosDisponibles' => $anosDisponibles, // Pasar los años disponibles
            'seguimientos' => $seguimientos, // Pasar los seguimientos por año
        ]);
    }

    public function guardarSeguimientoProductosSectoriales(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validaciones generales
            $request->validate([
                'idProducto' => 'required|exists:productos_pes,idProducto',
                'anio' => 'required|integer|min:2023|max:2028',
                'programas' => 'required|array|min:1',
                'programas.*.idPrograma' => 'required|exists:programa_presupuestario,idPrograma',
                'programas.*.componente' => 'required|string|max:255',
                'programas.*.actividad' => 'required|string|max:255',
                'observaciones' => 'nullable|string',
                // Validar arrays de medios existentes
                'medios.idMedio' => 'array',
                'medios.idMedio.*' => 'exists:medios_verificacion,idMedio',
                'medios.descripcion' => 'array',
                'medios.descripcion.*' => 'nullable|string|max:1000',
                // Validar arrays de medios nuevos
                'nuevosMedios.descripcion' => 'array',
                'nuevosMedios.descripcion.*' => 'nullable|string|max:1000',
                'nuevosMedios.nombreArchivo' => 'array',
                'nuevosMedios.nombreArchivo.*' => 'string',
                'nuevosMedios.rutaArchivo' => 'array',
                'nuevosMedios.rutaArchivo.*' => 'string',
            ]);

            $anio = $request->input('anio');

            $programado = $request->input("programado_$anio");
            $realizado = $request->input("realizado_$anio");
            $valor_indicador = $request->input("valor_indicado_decimal_$anio");

            $programado = is_null($programado) ? null : (int) $programado;
            $realizado = is_null($realizado) ? null : (int) $realizado;
            $valor_indicador = is_null($valor_indicador) ? null : (float) $valor_indicador;

            // Guardar seguimiento meta
            $this->guardarSeguimientoMeta($request->idProducto, $anio, $programado, $realizado, $valor_indicador);

            // Guardar programas presupuestarios (varios)
            $programas = $request->input('programas', []);
            $this->guardarProgramaPresupuestarioProducto(
                $request->idProducto,
                $anio,
                $programas
            );

            // Guardar observaciones
            $this->guardarObservacion(
                $request->idProducto,
                $anio,
                $request->input('observaciones')
            );

            // ACTUALIZAR descripciones de medios existentes
            if (!empty($request->input('medios.idMedio'))) {
                foreach ($request->input('medios.idMedio') as $index => $idMedio) {
                    $descripcion = $request->input('medios.descripcion')[$index] ?? null;
                    MedioVerificacion::where('idMedio', $idMedio)->update(['descripcion' => $descripcion]);
                }
            }

            // GUARDAR medios nuevos (archivos subidos)
            if (!empty($request->input('nuevosMedios.nombreArchivo'))) {
                foreach ($request->input('nuevosMedios.nombreArchivo') as $index => $nombreArchivo) {
                    $descripcion = $request->input('nuevosMedios.descripcion')[$index] ?? null;
                    $rutaArchivo = $request->input('nuevosMedios.rutaArchivo')[$index] ?? null;

                    if ($rutaArchivo && $nombreArchivo) {
                        $carpetaFinal = "medios/ps/{$request->idProducto}/{$anio}";
                        if (!file_exists(public_path($carpetaFinal))) {
                            mkdir(public_path($carpetaFinal), 0755, true);
                        }
                        $nuevoPath = $carpetaFinal . '/' . $nombreArchivo;
                        rename(public_path($rutaArchivo), public_path($nuevoPath));

                        MedioVerificacion::create([
                            'idProducto' => $request->idProducto,
                            'anio' => $anio,
                            'nombreArchivo' => $nombreArchivo,
                            'rutaArchivo' => $nuevoPath,
                            'descripcion' => $descripcion
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                "result" => "ok",
                "message" => "Datos actualizados correctamente."
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al guardar el seguimiento: ', ['error' => $e->getMessage()]);
            return response()->json([
                "result" => "error",
                "message" => 'Error al guardar el seguimiento: ' . $e->getMessage()
            ], 500);
        }
    }

    protected function guardarSeguimientoMeta($idProducto, $anio, $programado, $realizado, $valor_indicador)
    {
        SeguimientoMeta::updateOrCreate(
            ['idProducto' => $idProducto, 'año' => $anio],
            [
                'programado' => $programado,
                'realizado' => $realizado,
                'valor_indicador' => $valor_indicador,
            ]
        );
    }

    protected function guardarProgramaPresupuestarioProducto($idProducto, $anio, array $programas)
    {
        // Eliminar registros anteriores para evitar duplicados
        ProgramaPresupuestarioProducto::where('idProducto', $idProducto)
            ->where('anio', $anio)
            ->delete();

        // Insertar o crear cada programa presupuestario del arreglo
        foreach ($programas as $programa) {
            if (empty($programa['idPrograma']) || empty($programa['componente']) || empty($programa['actividad'])) {
                continue; // Ignorar registros incompletos
            }

            ProgramaPresupuestarioProducto::create([
                'idProducto' => $idProducto,
                'anio' => $anio,
                'idPrograma' => $programa['idPrograma'],
                'componente' => $programa['componente'],
                'actividad' => $programa['actividad'],
            ]);
        }
    }

    /**
     * Guarda o actualiza las descripciones de medios de verificación para un producto y año.
     *
     * @param int $idProducto
     * @param int $anio
     * @param array $medios Array con ['idMedio' => int, 'descripcion' => string]
     * @return void
     */
    protected function guardarMediosVerificacion(int $idProducto, int $anio, array $medios): void
    {
        foreach ($medios as $medio) {
            if (!empty($medio['idMedio'])) {
                MedioVerificacion::updateOrCreate(
                    [
                        'idProducto' => $idProducto,
                        'anio' => $anio,
                        'idMedio' => $medio['idMedio'],
                    ],
                    [
                        'descripcion' => $medio['descripcion'] ?? null,
                    ]
                );
            }
        }
    }

    protected function guardarObservacion($idProducto, $anio, $observacionTexto)
    {
        if ($observacionTexto === null) {
            // Si no viene observación, no hace nada
            return;
        }

        PsObservacion::updateOrCreate(
            [
                'idProducto' => $idProducto,
                'anio' => $anio,
            ],
            [
                'observacion' => $observacionTexto,
            ]
        );
    }

    /**
     * Obtener observaciones para un producto y año (para llenar formulario)
     */
    public function obtenerObservacion(Request $request, $idProducto)
    {
        $anio = $request->input('anio');
        if (!$anio) {
            return response()->json(['result' => 'error', 'message' => 'Año no proporcionado'], 400);
        }

        $observacion = PsObservacion::where('idProducto', $idProducto)
            ->where('anio', $anio)
            ->first();

        return response()->json([
            'result' => 'ok',
            'data' => $observacion ? $observacion->observacion : '',
        ]);
    }



    protected function obtenerSeguimientoMeta($idProducto, $anio)
    {
        return SeguimientoMeta::where('idProducto', $idProducto)
            ->where('año', $anio)
            ->first();
    }

    protected function obtenerProgramaPresupuestarioProducto($idProducto, $anio)
    {
        return ProgramaPresupuestarioProducto::where('idProducto', $idProducto)
            ->where('anio', $anio)
            ->get();
    }

    protected function obtenerAniosSeleccionados($idProducto)
    {
        return SeguimientoMeta::where('idProducto', $idProducto)
            ->pluck('año')
            ->toArray();
    }
    public function subirMedioVerificacion(Request $request)
    {
        try {
            $request->validate([
                'archivo' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:2048',
            ]);

            $archivo = $request->file('archivo');
            if (!$archivo) {
                return response()->json(['result' => 'error', 'message' => 'No se recibió ningún archivo.'], 400);
            }

            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $carpetaTemporal = "medios/temp";

            if (!file_exists(public_path($carpetaTemporal))) {
                if (!mkdir(public_path($carpetaTemporal), 0755, true)) {
                    return response()->json(['result' => 'error', 'message' => 'No se pudo crear la carpeta de destino.'], 500);
                }
            }

            $archivo->move(public_path($carpetaTemporal), $nombreArchivo);

            $rutaArchivo = "$carpetaTemporal/$nombreArchivo";

            return response()->json([
                'result' => 'ok',
                'message' => 'Archivo subido correctamente',
                'archivo' => [
                    'nombre' => $nombreArchivo,
                    'ruta' => $rutaArchivo
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al subir archivo: ' . $e->getMessage());
            return response()->json([
                'result' => 'error',
                'message' => 'Error al subir el archivo: ' . $e->getMessage()
            ], 500);
        }
    }

    public function actualizarDescripcionMedio(Request $request, $idMedio)
    {
        $request->validate([
            'descripcion' => 'nullable|string|max:1000',
        ]);

        $medio = MedioVerificacion::find($idMedio);

        if (!$medio) {
            return response()->json(['result' => 'error', 'message' => 'Medio no encontrado'], 404);
        }

        $medio->descripcion = $request->descripcion;
        $medio->save();

        return response()->json(['result' => 'ok', 'message' => 'Descripción actualizada']);
    }
    public function getMediosVerificacion($idProducto, $anio)
    {
        $medios = MedioVerificacion::where('idProducto', $idProducto)
            ->where('anio', $anio)
            ->get();

        return response()->json([
            'result' => 'ok',
            'medios' => $medios
        ]);
    }
    public function eliminarMedio($idMedio)
    {
        $medio = MedioVerificacion::find($idMedio);

        if (!$medio) {
            return response()->json(['result' => 'error', 'message' => 'Archivo no encontrado'], 404);
        }

        // Eliminar archivo físico si existe
        if (file_exists(public_path($medio->rutaArchivo))) {
            unlink(public_path($medio->rutaArchivo));
        }

        $medio->delete();

        return response()->json(['result' => 'ok']);
    }

    public function obtenerDatosSeguimientoTodos($idProducto)
    {
        $anios = [2023, 2024, 2025, 2026, 2027, 2028];
        $datos = [];
        $primeraVez = true;

        // Carga todo en 2 consultas (una por tabla)
        $seguimientos = SeguimientoMeta::where('idProducto', $idProducto)
            ->whereIn('año', $anios)
            ->get()
            ->keyBy('año');

        $programas = ProgramaPresupuestarioProducto::where('idProducto', $idProducto)
            ->whereIn('anio', $anios)
            ->get()
            ->groupBy('anio');

        foreach ($anios as $anio) {
            $seguimiento = $seguimientos->get($anio);
            $programasAnio = $programas->get($anio, collect());

            $programasArray = $programasAnio->map(fn($p) => [
                'idPrograma' => $p->idPrograma,
                'componente' => $p->componente,
                'actividad' => $p->actividad,
            ])->toArray();

            $programado = $seguimiento->programado ?? null;
            if ($programado !== null && floatval($programado) > 0) {
                $primeraVez = false;
            }

            $datos[$anio] = [
                'programado' => $programado ?? '',
                'realizado' => $seguimiento->realizado ?? '',
                'valor_indicado' => $seguimiento->valor_indicador ?? '',
                'programas' => $programasArray,
            ];
        }

        return response()->json([
            'result' => 'ok',
            'data' => $datos,
            'primera_vez' => $primeraVez,
        ]);
    }



    public function eliminarProgramaProducto(Request $request, $idProducto, $idPrograma, $anio)
    {
        try {
            $registro = ProgramaPresupuestarioProducto::where('idProducto', $idProducto)
                ->where('idPrograma', $idPrograma)
                ->where('anio', $anio)
                ->first();

            if (!$registro) {
                return response()->json([
                    'result' => 'error',
                    'message' => 'No se encontró el programa presupuestario para este producto y año.'
                ], 404);
            }

            $registro->delete();

            return response()->json([
                'result' => 'ok',
                'message' => 'Programa presupuestario eliminado correctamente.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error al eliminar programa presupuestario: ', ['error' => $e->getMessage()]);
            return response()->json([
                'result' => 'error',
                'message' => 'Error al eliminar el programa: ' . $e->getMessage()
            ], 500);
        }
    }

    //Reporte :
    public function detalleReporteProducto($id)
    {
        $producto = ProductoPE::from('productos_pes as p')
            ->leftJoin('alineacion_general_producto as a', 'p.idProducto', '=', 'a.idProducto')
            ->leftJoin('ejeped as eje', 'a.idEjePED', '=', 'eje.idEjePED')
            ->leftJoin('temaped as tema', 'a.idTemaPED', '=', 'tema.idTemaPED')
            ->leftJoin('objetivoped as objped', 'a.idObjetivoPED', '=', 'objped.idObjetivoPED')
            ->leftJoin('estrategiaped as estped', 'a.idEstrategiaPED', '=', 'estped.idEstrategiaPED')
            ->leftJoin('lineaaccionped as lap', 'a.idLAPED', '=', 'lap.idLAPED')
            ->leftJoin('objetivosector as objsec', 'a.idObjetivo', '=', 'objsec.idObjetivo')
            ->leftJoin('estrategiasector as estsec', 'a.idEstrategia', '=', 'estsec.idEstrategia')
            ->select([
                'p.idProducto',
                'p.nombre_producto',
                DB::raw("CONCAT(eje.ejePEDClave, ' ', eje.ejePEDDescripcion) as eje_nombre"),
                DB::raw("CONCAT(tema.temaPEDClave, ' ', tema.temaPEDDescripcion) as tema_nombre"),
                DB::raw("CONCAT(objped.objetivoPEDClave, ' ', objped.objetivoPEDDescripcion) as objetivo_ped"),
                DB::raw("CONCAT(estped.estrategiaPEDClave, ' ', estped.estrategiaPEDDescripcion) as estrategia_ped"),
                DB::raw("CONCAT(lap.laPEDClave, ' ', lap.laPEDDescripcion) as linea_accion"),
                DB::raw("CONCAT(objsec.claveObjetivo, ' ', objsec.objetivo) as objetivo_sector"),
                DB::raw("CONCAT(estsec.claveEstrategia, ' ', estsec.estrategia) as estrategia_sector"),
                'a.idBS',
                'a.id as idPPAS' // Aquí sigue usándose la columna 'id' para guardar múltiples PPAs
            ])
            ->where('p.idProducto', $id)
            ->first();

        // Obtener bienes o servicios
        $bienesServicios = [];
        if ($producto && !empty($producto->idBS)) {
            $ids = explode(',', $producto->idBS);
            $bienesServicios = IABS::whereIn('idBS', $ids)->get();
        }

        // Obtener múltiples PPAs
        $ppasSeleccionados = [];
        if ($producto && !empty($producto->idPPAS)) {
            $ppaIds = explode(',', $producto->idPPAS);
            $ppasSeleccionados = DB::table('informe_acciones')
                ->whereIn('id', $ppaIds)
                ->get();
        }
        $indicador = IndicadorProducto::where('idProducto', $id)->first();

        $programas = ProgramaPresupuestarioProducto::from('programa_presupuestario_producto as ppp')
            ->leftJoin('programa_presupuestario as pp', 'ppp.idPrograma', '=', 'pp.idPrograma')
            ->where('ppp.idProducto', $id)
            ->orderBy('ppp.anio')
            ->select([
                'ppp.anio',
                'ppp.componente',
                'ppp.actividad',
                'pp.clavePrograma',
                'pp.descripcionPrograma'
            ])
            ->get();

        $seguimientos = SeguimientoMeta::where('idProducto', $id)
            ->orderBy('año')
            ->get();

        $mediosVerificacion = MedioVerificacion::where('idProducto', $producto->idProducto)->get();

        return view('productosSectoriales.detalleReporteProducto', compact(
            'producto',
            'bienesServicios',
            'ppasSeleccionados',
            'indicador',
            'programas',
            'seguimientos',
            'mediosVerificacion'
        ));
    }
    //Generar Reporte
    public function verReportePS($id)
    {
        $usuario = auth()->user();
        $dependenciaUsuario = $usuario->enlace ? $usuario->enlace->dependencia : null;
        $enlace = $usuario->enlace ?? null;

        $producto = ProductoPE::from('productos_pes as p')
            ->leftJoin('alineacion_general_producto as a', 'p.idProducto', '=', 'a.idProducto')
            ->leftJoin('ejeped as eje', 'a.idEjePED', '=', 'eje.idEjePED')
            ->leftJoin('temaped as tema', 'a.idTemaPED', '=', 'tema.idTemaPED')
            ->leftJoin('objetivoped as objped', 'a.idObjetivoPED', '=', 'objped.idObjetivoPED')
            ->leftJoin('estrategiaped as estped', 'a.idEstrategiaPED', '=', 'estped.idEstrategiaPED')
            ->leftJoin('lineaaccionped as lap', 'a.idLAPED', '=', 'lap.idLAPED')
            ->leftJoin('objetivosector as objsec', 'a.idObjetivo', '=', 'objsec.idObjetivo')
            ->leftJoin('estrategiasector as estsec', 'a.idEstrategia', '=', 'estsec.idEstrategia')
            ->select([
                'p.idProducto',
                'p.nombre_producto',
                'p.idDependencia',
                DB::raw("CONCAT(eje.ejePEDClave, ' ', eje.ejePEDDescripcion) as eje_nombre"),
                DB::raw("CONCAT(tema.temaPEDClave, ' ', tema.temaPEDDescripcion) as tema_nombre"),
                DB::raw("CONCAT(objped.objetivoPEDClave, ' ', objped.objetivoPEDDescripcion) as objetivo_ped"),
                DB::raw("CONCAT(estped.estrategiaPEDClave, ' ', estped.estrategiaPEDDescripcion) as estrategia_ped"),
                DB::raw("CONCAT(lap.laPEDClave, ' ', lap.laPEDDescripcion) as linea_accion"),
                DB::raw("CONCAT(objsec.claveObjetivo, ' ', objsec.objetivo) as objetivo_sector"),
                DB::raw("CONCAT(estsec.claveEstrategia, ' ', estsec.estrategia) as estrategia_sector"),
                'a.idBS',
                'a.id as idPPAS'
            ])
            ->where('p.idProducto', $id)
            ->first();

        // Bienes y servicios
        $bienesServicios = [];
        if ($producto && !empty($producto->idBS)) {
            $ids = explode(',', $producto->idBS);
            $bienesServicios = IABS::whereIn('idBS', $ids)->get();
        }

        // PPAs seleccionados
        $ppasSeleccionados = [];
        if ($producto && !empty($producto->idPPAS)) {
            $ppaIds = explode(',', $producto->idPPAS);
            $ppasSeleccionados = DB::table('informe_acciones')
                ->whereIn('id', $ppaIds)
                ->get();
        }

        // Indicadores
        $indicador = IndicadorProducto::where('idProducto', $id)->first();

        // Programas
        $programas = ProgramaPresupuestarioProducto::from('programa_presupuestario_producto as ppp')
            ->leftJoin('programa_presupuestario as pp', 'ppp.idPrograma', '=', 'pp.idPrograma')
            ->where('ppp.idProducto', $id)
            ->orderBy('ppp.anio')
            ->select([
                'ppp.anio',
                'ppp.componente',
                'ppp.actividad',
                'pp.clavePrograma',
                'pp.descripcionPrograma'
            ])
            ->get();

        // Seguimiento
        $seguimientos = SeguimientoMeta::where('idProducto', $id)->orderBy('año')->get();
        $anios = ['2023', '2024', '2025', '2026', '2027', '2028'];
        $seguimientoValores = [];

        foreach ($seguimientos as $s) {
            $seguimientoValores[$s->tipo][$s->año] = $s->valor;
        }

        $mediosVerificacion = MedioVerificacion::where('idProducto', $producto->idProducto)->get();
        // Titular de dependencia
        $titular = null;
        if ($dependenciaUsuario) {
            $titular = Titular::where('idDependencia', $dependenciaUsuario->idDependencia)->first();
        }
        // Crear PDF
        //personalizar el PDF 310,210
        //Carta 216 279
        $pdf = new CustomPDF('P', 'mm', array(310, 210), true, 'UTF-8', false);
        $pdf->SetMargins(15, 10, 15);
        $pdf->SetAutoPageBreak(true, 15);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 8);

        $fechaActualizacion = now()->format('Y-m-d H:i:s');

        $html = view('productosSectoriales.reportePS', compact(
            'producto',
            'bienesServicios',
            'ppasSeleccionados', // ¡IMPORTANTE!
            'indicador',
            'programas',
            'seguimientos',
            'seguimientoValores',
            'mediosVerificacion',
            'dependenciaUsuario',
            'anios',
            'titular',
            'enlace',
            'fechaActualizacion'
        ))->render();

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('Ficha Tecnica Del Indicador.pdf', 'I');
    }

    public function guardarSeguimientoPrimeraVez(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'idProducto' => 'required|exists:productos_pes,idProducto',
            ]);

            $idProducto = $request->input('idProducto');
            $allAnios = [2023, 2024, 2025, 2026, 2027, 2028];

            foreach ($allAnios as $anio) {
                $programado = $request->input("programado_$anio");
                $realizado = $request->input("realizado_$anio");
                $valor_indicador = $request->input("valor_indicado_decimal_$anio");

                if (!is_null($programado) && $programado !== '') {
                    $this->guardarSeguimientoMeta(
                        $idProducto,
                        $anio,
                        (int) $programado,
                        is_null($realizado) || $realizado === '' ? null : (int) $realizado,
                        is_null($valor_indicador) || $valor_indicador === '' ? null : (float) $valor_indicador
                    );
                }
            }

            DB::commit();

            return response()->json([
                'result' => 'ok',
                'message' => 'Seguimiento inicial guardado correctamente.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error en seguimiento inicial: ' . $e->getMessage());
            return response()->json([
                'result' => 'error',
                'message' => 'Error al guardar los datos iniciales: ' . $e->getMessage(),
            ], 500);
        }
    }

    //Revision Pendiente 
    public function enviarRevision(Request $request)
    {
        try {
            ProductoPE::where('idProducto', $request->idProducto)->first()
                ->update([
                    'estado_producto' => $request->estado ?? 'revision' // 
                ]);

            return response()->json([
                'result' => 'ok',
                'message' => 'El producto fue enviado a revisión correctamente.'
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'result' => 'error',
                'message' => 'Ocurrió un error al enviar el producto a revisión.'
            ]);
        }
    }


}
class CustomPDF extends TCPDF
{
    private $paginaPrimera = true;

    public function Header()
    {
        $anchoPagina = $this->getPageWidth();

        // Imagen en la parte superior
        $this->Image(public_path('images/encabezado-pdf.png'), 15, 5, $anchoPagina - 30);

        // Ajuste condicional del margen
        if (!$this->paginaPrimera) {
            $this->SetMargins(15, 25, 15);
        }

        $this->Ln(40);
        $this->paginaPrimera = false;
    }
}

