<?php
namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductosSectorialesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnWidths, WithStyles
{
    public function collection()
    {
        $productos = DB::table('productosector as p')
            ->leftJoin('dependencia as d', 'p.idDependencia', '=', 'd.idDependencia')
            ->leftJoin('alineacion_general_producto as a', 'p.idProducto', '=', 'a.idProducto')
            ->leftJoin('ejeped as eje', 'a.idEjePED', '=', 'eje.idEjePED')
            ->leftJoin('temaped as tema', 'a.idTemaPED', '=', 'tema.idTemaPED')
            ->leftJoin('objetivoped as objped', 'a.idObjetivoPED', '=', 'objped.idObjetivoPED')
            ->leftJoin('estrategiaped as estped', 'a.idEstrategiaPED', '=', 'estped.idEstrategiaPED')
            ->leftJoin('sectores as s', 'a.idSector', '=', 's.idSector')
            ->leftJoin('objetivosector as objsec', 'a.idObjetivo', '=', 'objsec.idObjetivo')
            ->leftJoin('estrategiasector as estsec', 'a.idEstrategia', '=', 'estsec.idEstrategia')
            ->leftJoin('indicadores_producto as ind', 'p.idProducto', '=', 'ind.idProducto')
            ->select([
                'p.idProducto',
                'p.producto',
                'p.estado_producto',
                DB::raw("COALESCE(d.dependenciaSiglas, ' ') as dependencia_siglas"),
                DB::raw("CONCAT(eje.ejePEDClave, ' ', eje.ejePEDDescripcion) as eje"),
                DB::raw("CONCAT(tema.temaPEDClave, ' ', tema.temaPEDDescripcion) as tema"),
                DB::raw("CONCAT(objped.objetivoPEDClave, ' ', objped.objetivoPEDDescripcion) as objetivo"),
                DB::raw("CONCAT(estped.estrategiaPEDClave, ' ', estped.estrategiaPEDDescripcion) as estrategia"),
                DB::raw("CONCAT(s.claveSector,' ',s.sector)as sector_nombre"),
                DB::raw("CONCAT(objsec.claveObjetivo, ' ', objsec.objetivo) as objetivo_sector"),
                DB::raw("CONCAT(estsec.claveEstrategia, ' ', estsec.estrategia) as estrategia_sector"),
                'a.idBS',
                'a.id as idPPAS',
                'a.idLAPED',
                'ind.nombreIndicador',
                'ind.tipo',
                'ind.metodo_calculo',
                'ind.frecuencia_medicion',
                'ind.sentido_esperado',
                'ind.unidad_medida_producto',
                'ind.unidad_medida_indicador',
                'ind.medio_verificacion_indicador'
            ])
            ->get();

        return $productos->map(function ($producto) {
            // Obtener PPAs
            $ppas = !empty($producto->idPPAS)
                ? DB::table('informe_acciones')
                    ->whereIn('id', explode(',', $producto->idPPAS))
                    ->get()
                    ->map(fn($ppa) => "{$ppa->id} - {$ppa->nombre}")
                    ->implode(', ')
                : ' ';

            // Obtener Bienes y Servicios
            $bs = !empty($producto->idBS)
                ? DB::table('ia_bs')
                    ->whereIn('idBS', explode(',', $producto->idBS))
                    ->pluck('nombreBS')
                    ->implode(', ')
                : ' ';

            // Obtener líneas de acción y jerarquía
            $laIds = !empty($producto->idLAPED) ? explode(',', $producto->idLAPED) : [];
            $lineasAccion = collect();
            $ejes = $temas = $objetivosPed = $estrategiasPed = [];

            if ($laIds) {
                $lineasAccion = DB::table('lineaaccionped as la')
                    ->leftJoin('estrategiaped as est', 'la.idEstrategiaPED', '=', 'est.idEstrategiaPED')
                    ->leftJoin('objetivoped as obj', 'est.idObjetivoPED', '=', 'obj.idObjetivoPED')
                    ->leftJoin('temaped as tema', 'obj.idTemaPED', '=', 'tema.idTemaPED')
                    ->leftJoin('ejeped as eje', 'tema.idEjePED', '=', 'eje.idEjePED')
                    ->whereIn('la.idLAPED', $laIds)
                    ->select([
                        'la.laPEDClave',
                        'la.laPEDDescripcion',
                        DB::raw("CONCAT(eje.ejePEDClave, ' ', eje.ejePEDDescripcion) as eje_nombre"),
                        DB::raw("CONCAT(tema.temaPEDClave, ' ', tema.temaPEDDescripcion) as tema_nombre"),
                        DB::raw("CONCAT(obj.objetivoPEDClave, ' ', obj.objetivoPEDDescripcion) as objetivo_ped"),
                        DB::raw("CONCAT(est.estrategiaPEDClave, ' ', est.estrategiaPEDDescripcion) as estrategia_ped")
                    ])
                    ->get();

                $ejes = $lineasAccion->pluck('eje_nombre')->unique()->filter()->values()->toArray();
                $temas = $lineasAccion->pluck('tema_nombre')->unique()->filter()->values()->toArray();
                $objetivosPed = $lineasAccion->pluck('objetivo_ped')->unique()->filter()->values()->toArray();
                $estrategiasPed = $lineasAccion->pluck('estrategia_ped')->unique()->filter()->values()->toArray();
            }

            $lineasTexto = $lineasAccion->map(fn($la) => "{$la->laPEDClave} - {$la->laPEDDescripcion}")->implode("\n");

            $seguimientoMetas = DB::table('seguimiento_metas')
                ->where('idProducto', $producto->idProducto)
                ->whereIn('año', [2023, 2024, 2025, 2026, 2027, 2028])
                ->get()
                ->keyBy('año');

            $seguimiento = [];
            foreach ([2023, 2024, 2025, 2026, 2027, 2028] as $anio) {
                $seguimiento[$anio] = [
                    'programado' => $seguimientoMetas[$anio]->programado ?? '',
                    'realizado' => $seguimientoMetas[$anio]->realizado ?? '',
                ];
            }

            return [
                'ID' => $producto->idProducto,
                'Producto' => $producto->producto,
                'Estado' => $producto->estado_producto,
                'Dependencia' => $producto->dependencia_siglas,
                'Eje PED' => implode("\n", $ejes),
                'Tema PED' => implode("\n", $temas),
                'Objetivo PED' => implode("\n", $objetivosPed),
                'Estrategia PED' => implode("\n", $estrategiasPed),
                'Linea Accion' => $lineasTexto ?: ' ',
                'Sector' => $producto->sector_nombre ?? ' ',
                'Objetivo Sector' => $producto->objetivo_sector ?? ' ',
                'Estrategia Sector' => $producto->estrategia_sector ?? ' ',
                'PPA' => $ppas,
                'Bienes o Servicios' => $bs,
                'Nombre del Indicador' => $producto->nombreIndicador ?? ' ',
                'Tipo' => $producto->tipo ?? ' ',
                'Metodo de Calculo' => $producto->metodo_calculo ?? ' ',
                'Frecuencia de Medicion' => $producto->frecuencia_medicion ?? ' ',
                'Sentido Esperado' => $producto->sentido_esperado ?? ' ',
                'Unidad de Medida Producto' => $producto->unidad_medida_producto ?? ' ',
                'Unidad de Medida Indicador' => $producto->unidad_medida_indicador ?? ' ',
                'Medio de Verificacion' => $producto->medio_verificacion_indicador ?? ' ',
                'Programado 2023' => $seguimiento[2023]['programado'],
                'Realizado 2023' => $seguimiento[2023]['realizado'],
                'Programado 2024' => $seguimiento[2024]['programado'],
                'Realizado 2024' => $seguimiento[2024]['realizado'],
                'Programado 2025' => $seguimiento[2025]['programado'],
                'Realizado 2025' => $seguimiento[2025]['realizado'],
                'Programado 2026' => $seguimiento[2026]['programado'],
                'Realizado 2026' => $seguimiento[2026]['realizado'],
                'Programado 2027' => $seguimiento[2027]['programado'],
                'Realizado 2027' => $seguimiento[2027]['realizado'],
                'Programado 2028' => $seguimiento[2028]['programado'],
                'Realizado 2028' => $seguimiento[2028]['realizado'],
            ];
        });
    }


    public function headings(): array
    {
        return [
            'ID',
            'Producto',
            'Estado',
            'Dependencia',
            'Eje PED',
            'Tema PED',
            'Objetivo PED',
            'Estrategia PED',
            'Linea Accion',
            'Sector',
            'Objetivo Sector',
            'Estrategia Sector',
            'PPA',
            'Bienes o Servicios',
            'Nombre del indicador',
            'Tipo',
            'Metodo de Calculo',
            'Frecuencia de Medicion',
            'Sentido Esperado',
            'Unidad de Medida Producto',
            'Unidad de Medida Indicador',
            'Medio de Verificacion',
            'Programado 2023',
            'Realizado 2023',
            'Programado 2024',
            'Realizado 2024',
            'Programado 2025',
            'Realizado 2025',
            'Programado 2026',
            'Realizado 2026',
            'Programado 2027',
            'Realizado 2027',
            'Programado 2028',
            'Realizado 2028',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'B' => 50,
            'E' => 50,
            'F' => 50,
            'G' => 50,
            'H' => 50,
            'I' => 50,
            'J' => 50,
            'K' => 50,
            'L' => 50,
            'M' => 50,
            'N' => 50,
            'O' => 50,
            'T' => 50,
            'U' => 50,
            'V' => 50,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        foreach (['B'] as $col) {
            $sheet->getStyle($col)->getAlignment()->setWrapText(true);
        }
    }

}
