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
            ->leftJoin('lineaaccionped as lap', 'a.idLAPED', '=', 'lap.idLAPED')
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
                DB::raw("CONCAT(lap.laPEDClave, ' ', lap.laPEDDescripcion) as linea_accion"),
                DB::raw("CONCAT(objsec.claveObjetivo, ' ', objsec.objetivo) as objetivo_sector"),
                DB::raw("CONCAT(estsec.claveEstrategia, ' ', estsec.estrategia) as estrategia_sector"),
                'a.idBS',
                'a.id as idPPAS',
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
            $ppas = !empty($producto->idPPAS)
                ? DB::table('informe_acciones')
                    ->whereIn('id', explode(',', $producto->idPPAS))
                    ->get()
                    ->map(fn($ppa) => "{$ppa->id} - {$ppa->nombre}")
                    ->implode(', ')
                : ' ';


            $bs = !empty($producto->idBS)
                ? DB::table('ia_bs')->whereIn('idBS', explode(',', $producto->idBS))->pluck('nombreBS')->implode(', ')
                : ' ';

            return [
                'ID' => $producto->idProducto,
                'Producto' => $producto->producto,
                'Estado' => $producto->estado_producto,
                'Dependencia' => $producto->dependencia_siglas,
                'Eje PED' => $producto->eje ?? ' ',
                'Tema PED' => $producto->tema ?? ' ',
                'Objetivo PED' => $producto->objetivo ?? ' ',
                'Estrategia PED' => $producto->estrategia ?? ' ',
                'Linea Accion' => $producto->linea_accion ?? ' ',
                'Objetivo Sector' => $producto->objetivo_sector ?? ' ',
                'Estrategia Sector' => $producto->estrategia_sector ?? ' ',
                'PPA' => $ppas,
                'Bienes o Servicios' => $bs,
                'Tipo' => $producto->tipo ?? ' ',
                'Metodo de Calculo' => $producto->metodo_calculo ?? ' ',
                'Frecuencia de Medicion' => $producto->frecuencia_medicion ?? ' ',
                'Sentido Esperado' => $producto->sentido_esperado ?? ' ',
                'Unidad de Medida Producto' => $producto->unidad_medida_producto ?? ' ',
                'Unidad de Medida Indicador' => $producto->unidad_medida_indicador ?? ' ',
                'Medio de Verificacion' => $producto->medio_verificacion_indicador ?? ' ',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre del Producto',
            'Estado',
            'Dependencia',
            'Eje PED',
            'Tema PED',
            'Objetivo PED',
            'Estrategia PED',
            'Linea Accion',
            'Objetivo Sector',
            'Estrategia Sector',
            'PPA',
            'Bienes o Servicios',
            'Tipo',
            'Metodo de Calculo',
            'Frecuencia de Medicion',
            'Sentido Esperado',
            'Unidad de Medida Producto',
            'Unidad de Medida Indicador',
            'Medio de Verificacion'
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
            'T' => 50,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        foreach (['B'] as $col) {
            $sheet->getStyle($col)->getAlignment()->setWrapText(true);
        }
    }

}
