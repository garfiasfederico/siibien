<?php

namespace App\Http\Controllers;

use App\Models\EstrategiaPED;
use App\Models\LineaPED;
use Illuminate\Http\Request;
use App\Models\TemaPED;
use App\Models\ObjetivoPED;
use App\Models\ProgramasPresupuestales;
use Illuminate\Support\Facades\DB;

class PEDController extends Controller
{
    //
    public function  gettemas(Request $req){
        $temas = TemaPED::where("idEjePED",$req->idEjePED)->get();
        return response()->json([
            'success' => 'ok',            
            'temas' => $temas
        ]);
    }

    public function  getobjetivos(Request $req){
        $objetivos = ObjetivoPED::where("idTemaPED",$req->idTemaPED)->get();
        return response()->json([
            'success' => 'ok',            
            'objetivos' => $objetivos
        ]);        
    }

    public function  getestrategias(Request $req){
        $estrategias = EstrategiaPED::where("idObjetivoPED",$req->idObjetivoPED)->get();
        return response()->json([
            'success' => 'ok',            
            'estrategias' => $estrategias
        ]);        
    }

    public function  getlineas(Request $req){
        $lineas = LineaPED::where("idEstrategiaPED",$req->idEstrategiaPED)->get();
        return response()->json([
            'success' => 'ok',            
            'lineas' => $lineas
        ]);        
    }
    
    public function getprogramas(Request $req){
        DB::enableQueryLog();
        $objetivos = explode("|",$req->objetivos);
        array_pop($objetivos);

        $programas = DB::table("programaspresupuestales");
        foreach($objetivos as $objetivo) 
        {
            $programas->orWhere("idObjetivoPED",$objetivo);
        }                
        $programas = $programas->get();
        //dd(DB::getQueryLog());
        //die(var_dump($programas->toSql()));
        
        return response()->json([
            'success' => 'ok',            
            'programas' => $programas
        ]);        
    }
}
