<?php

namespace App\Http\Controllers;

use App\Exports\AsistenciasExport;
use App\Models\Asistencias;
use Exception;
use Illuminate\Http\Request;
use Excel;

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
}
