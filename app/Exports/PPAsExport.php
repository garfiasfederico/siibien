<?php

namespace App\Exports;

use App\Models\EjePED;
use App\Models\EstrategiaPED;
use App\Models\LineaPED;
use App\Models\ObjetivoPED;
use App\Models\PPA;
use App\Models\ProgramasPresupuestales;
use App\Models\TemaPED;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PPAsExport implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
         $ppas = PPA::select("id",
                            "periodo",
                            "nombre",
                            "ppa.objetivo",
                            "descripcion",
                            "cobertura",
                            "fuente_financiamiento",
                            "monto_inversion",
                            "monto_ejercido",
                            "descripcion_bs",
                            "entregas_bs",
                            "um_bs",
                            "tipo_beneficiario",
                            "descripcion_beneficiario",
                            "regiones",
                            "municipios",
                            "impacto_social",
                            "impacto_economico",
                            "impacto_ambiental",
                            "fecha_evento",
                            "dependenciaSiglas",
                            "observaciones",
                            "alineacion_ped",
                            "alineacion_pp",
                            "poblacion_objetivo",
                            "poblacion_atendida",
                            "poblacion_atender",
        DB::raw('CASE WHEN periodo="42023" THEN "Octubre-Diciembre 2023" ELSE "Enero-Marzo 2024" END AS periodo'))
            ->join("dependencia","dependencia.idDependencia","=","ppa.dependencia_id")
        ->get();

        $array = [];

        foreach($ppas as $ppa){
            $reg = [
                "caniada" => "Sierra de Flores Magón",
                "costa" => "Costa",
                "sierra_norte" => "Sierra de Juárez",
                "sierra_sur" => "Sierra Sur",
                "valles_centrales" => "Valles Centrales",
                "istmo" => "Istmo de Tehuantepec",
                "papaloapam" => "Cuenta del Papaloapan",
                "mixteca" => "Mixteca"
            ];
            $regiones_a = explode("|",$ppa->regiones);
            $regiones_s = "";
            array_pop($regiones_a);
            if(count($regiones_a)>0){
                foreach($regiones_a as $region){
                    $regiones_s .= $reg[(string)$region]."\n";
                }
            }
            $ppa->regiones = $regiones_s;


            //Agregamos la alineacion PED
            $alineacion = explode ("|",$ppa->alineacion_ped);
            $ppa->eje_ped = "";
            if($alineacion[0]!=''){
                $eje = EjePED::where("idEjePED",$alineacion[0])->first();
                $ppa->eje_ped =$eje->ejePEDClave." ".$eje->ejePEDDescripcion;
            }

            $ppa->tema_ped = "";
            if($alineacion[1]!=''){
                $tema = TemaPED::where("idTemaPED",$alineacion[1])->first();
                $ppa->tema_ped =$tema->temaPEDClave." ".$tema->temaPEDDescripcion;
            }

            $ppa->objetivo_ped = "";
            if($alineacion[2]!=''){
                $objetivo = ObjetivoPED::where("idObjetivoPED",$alineacion[2])->first();
                $ppa->objetivo_ped =$objetivo->objetivoPEDClave." ".$objetivo->objetivoPEDDescripcion;
            }

            $ppa->estrategia_ped = "";
            if($alineacion[2]!=''){
                $estrategia = EstrategiaPED::where("idEstrategiaPED",$alineacion[2])->first();
                $ppa->estrategia_ped =$estrategia->estrategiaPEDClave." ".$estrategia->estrategiaPEDDescripcion;
            }

            $ppa->linea_ped = "";
            if($alineacion[3]!=''){
                $linea = LineaPED::where("idLAPED",$alineacion[3])->first();
                $ppa->linea_ped =$linea->laPEDClave." ".$linea->laPEDDescripcion;
            }

            $programas = $ppa->alineacion_pp;
            $programasp = explode("|",$programas);
            $ps="";
            if(count($programasp)>0){
                array_pop($programasp);
                foreach($programasp as $programa){
                    $p = ProgramasPresupuestales::where("idPrograma",$programa)->first();
                    $ps .= $p->clavePrograma." ".$p->descripcionPrograma."\n";
                }
            }
            $ppa->alineacion_pp = $ps;

            $poblacion_objetivo =  explode("|",$ppa->poblacion_objetivo);
            $ppa->p_o = $poblacion_objetivo[0];
            $ppa->p_o_m = $poblacion_objetivo[1];
            $ppa->p_o_h = $poblacion_objetivo[2];

            $poblacion_atendida =  explode("|",$ppa->poblacion_atendida);
            $ppa->p_a = $poblacion_atendida[0];
            $ppa->p_a_m = $poblacion_atendida[1];
            $ppa->p_a_h = $poblacion_atendida[2];

            $poblacion_atender =  explode("|",$ppa->poblacion_atender);
            $ppa->p_pa = $poblacion_atender[0];
            $ppa->p_pa_m = $poblacion_atender[1];
            $ppa->p_pa_h = $poblacion_atender[2];

            $ppa->offsetUnset('alineacion_ped');
            $ppa->offsetUnset('poblacion_objetivo');
            $ppa->offsetUnset('poblacion_atendida');
            $ppa->offsetUnset('poblacion_atender');


            array_push($array,$ppa);
        }


        $collection = new Collection($array);

        return $collection;

    }

    public function headings():array{
        return array_keys($this->collection()->first()->toArray());
    }
}
