<?php

namespace App\Http\Controllers;

use Excel;
use Exception;
use App\Models\Asistencias;
use Illuminate\Http\Request;
use App\Exports\AsistenciasExport;
use App\Models\EncuestaSiibien;
use Illuminate\Support\Facades\DB;
use App\Exports\EncuestasExport;

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
}
