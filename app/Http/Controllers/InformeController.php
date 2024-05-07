<?php

namespace App\Http\Controllers;

use App\Models\Dependencia;
use App\Models\TemaPED;
use Illuminate\Http\Request;

class InformeController extends Controller
{
    //
    public function index(){
        $temase1 = TemaPED::select("ejeped.ejePEDClave","temaped.*")->join("ejeped","ejeped.idEjePED","=","temaped.idEjePED")->where("temaped.idEjePED",1)->get();
        $temase2 = TemaPED::select("ejeped.ejePEDClave","temaped.*")->join("ejeped","ejeped.idEjePED","=","temaped.idEjePED")->where("temaped.idEjePED",2)->get();
        $temase3 = TemaPED::select("ejeped.ejePEDClave","temaped.*")->join("ejeped","ejeped.idEjePED","=","temaped.idEjePED")->where("temaped.idEjePED",3)->get();
        $temase4 = TemaPED::select("ejeped.ejePEDClave","temaped.*")->join("ejeped","ejeped.idEjePED","=","temaped.idEjePED")->where("temaped.idEjePED",4)->get();
        $temase5 = TemaPED::select("ejeped.ejePEDClave","temaped.*")->join("ejeped","ejeped.idEjePED","=","temaped.idEjePED")->where("temaped.idEjePED",5)->get();
        $temase6 = TemaPED::select("ejeped.ejePEDClave","temaped.*")->join("ejeped","ejeped.idEjePED","=","temaped.idEjePED")->where("temaped.idEjePED",6)->get();
        $temase7 = TemaPED::select("ejeped.ejePEDClave","temaped.*")->join("ejeped","ejeped.idEjePED","=","temaped.idEjePED")->where("temaped.idEjePED",7)->get();
        $temase8 = TemaPED::select("ejeped.ejePEDClave","temaped.*")->join("ejeped","ejeped.idEjePED","=","temaped.idEjePED")->where("temaped.idEjePED",8)->get();
        $temase9 = TemaPED::select("ejeped.ejePEDClave","temaped.*")->join("ejeped","ejeped.idEjePED","=","temaped.idEjePED")->where("temaped.idEjePED",9)->get();
        $dependencias = Dependencia::all();
        return view("informe.cargas")->with("temase1",$temase1)
                                     ->with("temase2",$temase2)
                                     ->with("temase3",$temase3)
                                     ->with("temase4",$temase4)
                                     ->with("temase5",$temase5)
                                     ->with("temase6",$temase6)
                                     ->with("temase7",$temase7)
                                     ->with("temase8",$temase8)
                                     ->with("temase9",$temase9)
                                     ->with("dependencias",$dependencias);
    }
}
