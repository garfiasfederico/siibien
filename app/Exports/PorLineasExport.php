<?php

namespace App\Exports;

use App\Models\LineaPED;
use App\Models\InformeAccion;
use App\Models\InformeParrafo;
use App\Models\AnexoEstadistico;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PorLineasExport implements FromArray, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function array(): array
    {
        //
        $lineasped = LineaPED::select("*")->join("estrategiaped", "estrategiaped.idEstrategiaPED", "=", "lineaaccionped.idEstrategiaPED")
            ->join("objetivoped", "objetivoped.idObjetivoPED", "=", "estrategiaped.idObjetivoPED")
            ->join("temaped", "temaped.idTemaPED", "=", "objetivoped.idTemaPED")
            ->join("ejeped", "ejeped.idEjePED", "=", "temaped.idEjePED")
            ->get();
        $lineas_a = array();
        for ($x = 1; $x <= 442; $x++)
            $lineas_a[$x] = array();

        $acciones = InformeAccion::where("informe_acciones.status", 1)
            ->join("dependencia", "dependencia.idDependencia", "=", "informe_acciones.idDependencia")
            ->get();

        foreach ($acciones as $accion) {
            $parrafos_redactados = InformeParrafo::where("informe_acciones_id", $accion->id)->get()->count();
            $lineas_ = explode('|', $accion->alineacion_la);
            if (count($lineas_) > 0) {
                array_pop($lineas_);
                $acciones_v = array();
                foreach ($lineas_ as $lin) {
                    $infoLinea = LineaPED::where('idLAPED', $lin)
                        ->join("estrategiaped", "estrategiaped.idEstrategiaPED", "=", "lineaaccionped.idEstrategiaPED")
                        ->join("objetivoped", "objetivoped.idObjetivoPED", "=", "estrategiaped.idObjetivoPED")
                        ->join("temaped", "temaped.idTemaPED", "=", "objetivoped.idTemaPED")
                        ->join("ejeped", "ejeped.idEjePED", "=", "temaped.idEjePED")
                        ->first();
                    if ($infoLinea != null) {
                        //Obtenemos los cuadros alineados a la accion si los hay
                        $cuadros = explode("|", $accion->ae_cuadros);
                        $cuadros_s = "";

                        if (count($cuadros) > 0) {
                            array_pop($cuadros);
                            foreach ($cuadros as $cuadro) {
                                $cuad = AnexoEstadistico::where("id", $cuadro)->first();
                                $cuadros_s .= $cuad->numero . ". ";
                            }
                        }
                        //array_push($lineas_a[$lin], $accion->id . " " . $accion->nombre . " " . $accion->temaPEDDescripcion . "|" . $parrafos_redactados . "|" . $accion->dependenciaSiglas . "|" . $cuadros_s);
                        array_push(
                            $lineas_a[$lin],
                            [
                                "ejePED" => $infoLinea->ejePEDClave . " " . $infoLinea->ejePEDDescripcion,
                                "temaPED" => $infoLinea->temaPEDClave . " " . $infoLinea->temaPEDDescripcion,
                                "objetivoPED" => $infoLinea->objetivoPEDClave . " " . $infoLinea->objetivoPEDDescripcion,
                                "estrategiaPED" => $infoLinea->estrategiaPEDClave . " " . $infoLinea->estrategiaPEDDescripcion,
                                "idLAPED" => $infoLinea->idLAPED,
                                "lineaPED" => $infoLinea->laPEDClave . " " . $infoLinea->laPEDDescripcion,
                                "idAccion" => $accion->id,
                                "Nombre" => $accion->nombre,
                                "parrafos" => $parrafos_redactados,
                                "Dependencia" => $accion->dependenciaSiglas,
                                "Anexo" => $cuadros_s
                            ]
                        );
                        //$lineas_a[$lin] .=$accion->id." ".$accion->nombre ." ".$accion->temaPEDDescripcion."|".$parrafos_redactados."\n";
                    }
                }
                //$lineas_a[$lin] = $acciones_v;
            }
        }

        //realizamos un ultimo recorrido del array para verificar las vacias
        foreach ($lineas_a as $key => $laped) {
            if (count($laped) == 0) {
                $infoLinea = LineaPED::where('idLAPED', $key)
                    ->join("estrategiaped", "estrategiaped.idEstrategiaPED", "=", "lineaaccionped.idEstrategiaPED")
                    ->join("objetivoped", "objetivoped.idObjetivoPED", "=", "estrategiaped.idObjetivoPED")
                    ->join("temaped", "temaped.idTemaPED", "=", "objetivoped.idTemaPED")
                    ->join("ejeped", "ejeped.idEjePED", "=", "temaped.idEjePED")
                    ->first();
                array_push(
                    $lineas_a[$key],
                    [
                        "ejePED" => $infoLinea->ejePEDClave . " " . $infoLinea->ejePEDDescripcion,
                        "temaPED" => $infoLinea->temaPEDClave . " " . $infoLinea->temaPEDDescripcion,
                        "objetivoPED" => $infoLinea->objetivoPEDClave . " " . $infoLinea->objetivoPEDDescripcion,
                        "estrategiaPED" => $infoLinea->estrategiaPEDClave . " " . $infoLinea->estrategiaPEDDescripcion,
                        "idLAPED" => $infoLinea->idLAPED,
                        "lineaPED" => $infoLinea->laPEDClave . " " . $infoLinea->laPEDDescripcion,
                        "idAccion" => "NINGUNA",
                        "Nombre" => "",
                        "parrafos" => "",
                        "Dependencia" => "",
                        "Anexo" => ""
                    ]
                );
            }
        }



        return $lineas_a;
    }

    public function headings(): array
    {
        //return array_keys($this->collection()->first()->toArray());
        return [
            "Eje",
            "Tema",
            "Objetivo",
            "Estrategia",
            "Id Línea",
            "Línea",
            "Id Acción",
            "Acción",
            "Párrafos Capturados",
            "Dependencia",
            "Cuadros Anexo"
        ];
    }
}
