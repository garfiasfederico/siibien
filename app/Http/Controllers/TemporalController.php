<?php

namespace App\Http\Controllers;

use Excel;
use Exception;
use App\Models\Indicador;
use App\Models\Asistencias;
use Illuminate\Http\Request;
use App\Models\EncuestaSiibien;
use App\Exports\EncuestasExport;
use App\Exports\AsistenciasExport;
use App\Models\Dependencia;
use App\Models\EjePED;
use Illuminate\Support\Facades\DB;

class TemporalController extends Controller
{
    public function registraasistencia(Request $request){

        $this->validate($request,[
            "nombre" => 'required',
            "cargo" => 'required',
            "dependencia" => 'required',
            "email" => 'required|email',
            "telefono" => 'required'
        ]);

        try{
            Asistencias::create([
                "nombre" => $request->nombre,
                "cargo" => $request->cargo,
                "dependenciasId" => $request->dependencia,
                "email" => $request->email,
                "telefono" => $request->telefono
            ]);
            $resultado = true;
            $nombre = $request->nombre;
        }catch(Exception $ex){
            $resultado = false;
            $nombre = "";
        }
        return view('temporal.resultadoregistro')->with("resultado",$resultado)->with("nombre",$nombre);
    }
    public function downloadasistencias(){
        try{
            return Excel::download(new AsistenciasExport, 'asistencias'.date('YmdHis').'.xlsx');
        }catch(Exception $ex){
           dd($ex);
        }

    }

    public function registraencuesta(Request $request){
        $this->validate($request,[
            "p1" => 'required',
            "p2" => 'required',
            "p3" => 'required',
            "p4" => 'required',
            "p5" => 'required',
            "p6" => 'required',
        ]);


        try{
            DB::beginTransaction();
            EncuestaSiibien::create([
                'p1' => $request->p1,
                'p2' => $request->p2,
                'p3' => $request->p3,
                'p4' => $request->p4,
                'p5' => $request->p5,
                'p6' => $request->p6,
                'p7' => $request->p7
            ]);
            $resultado=true;
            DB::commit();
        }catch(Exception $ex){
            dd($ex);
            $resultado=false;
            DB::rollback();
        }
        return view('temporal.resulencuesta')->with("resultado",$resultado);
    }
    public function downloadresultadosencuesta(){
        try{
            return Excel::download(new EncuestasExport, 'resultencuesta'.date('YmdHis').'.xlsx');
        }catch(Exception $ex){
           dd($ex);
        }

    }

    public function indicadoreseje($eje_id){
        $eje = EjePED::where("idEjePED",$eje_id)->first();
        switch($eje_id){
            case 1:
                $color = "rgb(78,172,162)";
                break;
            case 2:
                $color = "rgb(155,39,69)";
                break;
            case 3:
                $color = "rgb(97,119,172)";
                break;
            case 4:
                $color = "rgb(113,173,74)";
                break;
            case 5:
                $color = "rgb(225,136,64)";
                break;
            default:
                $color = "rgb(0,0,0)";
                break;
        }
        $dependencias = Dependencia::all();

        $Indicadores = Indicador::select("indicador.*", "dependencia.dependenciaSiglas","ejeped.idEjePED")
                ->join("dependencia", "dependencia.idDependencia", "=", "indicador.idDependencia")
                ->join("indicadorobjetivos", "indicadorobjetivos.idIndicador", "=", "indicador.idIndicador")
                ->join("objetivoped", "objetivoped.idObjetivoPED", "=", "indicadorobjetivos.idObjetivoPED")
                ->join("temaped", "objetivoped.idTemaPED", "=", "temaped.idTemaPED")
                ->join("ejeped", "ejeped.idEjePED", "=", "temaped.idEjePED")
                ->where("indicador.status", 1)
                ->where("ejeped.idEjePED",$eje_id)->get()->sortBy("idIndicador");
        return view("temporal.indicadoreseje")->with("indicadores",$Indicadores)->with("eje",$eje)->with('color',$color)->with("dependencias",$dependencias);
    }
}
