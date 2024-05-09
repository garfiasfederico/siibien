<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\TemaPED;
use App\Models\LineaPED;
use App\Models\Dependencia;
use App\Models\InformeAccion;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use App\Models\MatrizCoordinacion;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\Style\Language;
use PhpOffice\PhpWord\Writer\Word2007;
use PhpOffice\PhpWord\SimpleType\DocProtect;

class InformeController extends Controller
{
    //
    public function index()
    {
        $temase1 = TemaPED::select("ejeped.ejePEDClave", "temaped.*")->join("ejeped", "ejeped.idEjePED", "=", "temaped.idEjePED")->where("temaped.idEjePED", 1)->get();
        $temase2 = TemaPED::select("ejeped.ejePEDClave", "temaped.*")->join("ejeped", "ejeped.idEjePED", "=", "temaped.idEjePED")->where("temaped.idEjePED", 2)->get();
        $temase3 = TemaPED::select("ejeped.ejePEDClave", "temaped.*")->join("ejeped", "ejeped.idEjePED", "=", "temaped.idEjePED")->where("temaped.idEjePED", 3)->get();
        $temase4 = TemaPED::select("ejeped.ejePEDClave", "temaped.*")->join("ejeped", "ejeped.idEjePED", "=", "temaped.idEjePED")->where("temaped.idEjePED", 4)->get();
        $temase5 = TemaPED::select("ejeped.ejePEDClave", "temaped.*")->join("ejeped", "ejeped.idEjePED", "=", "temaped.idEjePED")->where("temaped.idEjePED", 5)->get();
        $temase6 = TemaPED::select("ejeped.ejePEDClave", "temaped.*")->join("ejeped", "ejeped.idEjePED", "=", "temaped.idEjePED")->where("temaped.idEjePED", 6)->get();
        $temase7 = TemaPED::select("ejeped.ejePEDClave", "temaped.*")->join("ejeped", "ejeped.idEjePED", "=", "temaped.idEjePED")->where("temaped.idEjePED", 7)->get();
        $temase8 = TemaPED::select("ejeped.ejePEDClave", "temaped.*")->join("ejeped", "ejeped.idEjePED", "=", "temaped.idEjePED")->where("temaped.idEjePED", 8)->get();
        $temase9 = TemaPED::select("ejeped.ejePEDClave", "temaped.*")->join("ejeped", "ejeped.idEjePED", "=", "temaped.idEjePED")->where("temaped.idEjePED", 9)->get();
        $dependencias = Dependencia::all();
        return view("informe.cargas")->with("temase1", $temase1)
            ->with("temase2", $temase2)
            ->with("temase3", $temase3)
            ->with("temase4", $temase4)
            ->with("temase5", $temase5)
            ->with("temase6", $temase6)
            ->with("temase7", $temase7)
            ->with("temase8", $temase8)
            ->with("temase9", $temase9)
            ->with("dependencias", $dependencias);
    }

    public function redactar()
    {
        $idDependencia = auth()->user()->enlace->idDependencia;
        $temas = MatrizCoordinacion::where("dependencias_id", $idDependencia)->where("informe", "2")
            ->join("temaped", "temaped.idTemaPED", "matriz_coordinacion.idTemaPED")
            ->join("ejeped", "ejeped.idEjePED", "temaped.idEjePED")
            ->orderBy("temaped.idTemaPED", "ASC")
            ->get();

        return view("informe.redactar")->with("temas", $temas);
    }

    public function acciones(Request $request)
    {
        DB::enableQueryLog();
        $tema = TemaPED::where("idTemaPED", $request->tema)->first();
        $dependencia = Dependencia::where("idDependencia",$request->dependencia)->first();
        $lineas = LineaPED::select("idLAPED","laPEDClave","laPEDDescripcion")
                                    ->join("estrategiaped","estrategiaped.idEstrategiaPED","=","lineaaccionped.idEstrategiaPED")
                                    ->join("objetivoped","objetivoped.idObjetivoPED","=","estrategiaped.idObjetivoPED")
                                    ->join("temaped","temaped.idTemaPED","=","objetivoped.idTemaPED")
                                    ->where("temaped.idTemaPED",$request->tema)->get();

        return view("informe.acciones")->with("tema", $tema)->with("dependencia",$dependencia)->with("lineas",$lineas);

    }

    public function downloadword(Request $request)
    {

        //obtenemos informacion de la dependencia y del tema enviado por POST
        $dependencia = Dependencia::where("idDependencia",$request->dependencia)->first();
        $tema = TemaPED::where("idTemaPED",$request->tema)->first();



        $documento = new PhpWord();
        $propiedades = $documento->getDocInfo();
        $propiedades->setCreator("Instancia Técnica de Evaluación");
        $propiedades->setTitle("Texto");
        $documento->getSettings()->setTrackRevisions(true);
        $documento->getSettings()->setDoNotTrackMoves(true);
        $documento->getSettings()->setDoNotTrackFormatting(true);
        //$documentProtection = $documento->getSettings()->getDocumentProtection();
        //$documentProtection->setEditing(DocProtect::READ_ONLY);
        //$documentProtection->setPassword('myPassword');

        # Agregar texto...
        /*
Todos los textos deben estar dentro de una sección
 */

        $seccion = $documento->addSection();
        // Add first page header
        $header = $seccion->addHeader();
        $header->firstPage();
        $table = $header->addTable();
        $table->addRow();
        $cell = $table->addCell(10000);
        $textrun = $cell->addTextRun();
        $fuenteTitulo = [
            "name" => "Arial",
            "size" => 10,
            "color" => "000000",
        ];
        $textrun->addText(htmlspecialchars('2do. Informe de Gobierno'),$fuenteTitulo);
        $table->addRow();
        $cell = $table->addCell(10000);
        $textrun = $cell->addTextRun();
        $fuenteTitulo = [
            "name" => "Arial",
            "size" => 10,
            "color" => "000000",
        ];
        $textrun->addText(htmlspecialchars('Dependencia: '.$dependencia->dependenciaNombre." (".$dependencia->dependenciaNombre.")"),$fuenteTitulo);
        $table->addRow();
        $cell = $table->addCell(10000);
        $textrun = $cell->addTextRun();
        $textrun->addText(htmlspecialchars('Tema: '.$tema->temaPEDClave." ".$tema->temaPEDDescripcion),$fuenteTitulo);


        //$table->addCell(4500)->addImage('resources/images/logo_ped.png',array('width' => 80, 'height' => 80, 'align' => 'right'));

        # Simple texto
        /*  $seccion->addText("Hola, esto es algo de texto");
        # Con fuentes personalizadas
        $fuente = [
            "name" => "Arial",
            "size" => 12,
            "color" => "8bc34a",
            "italic" => true,
            "bold" => true,
        ];
        $seccion->addText("Hola, esto es algo de texto", $fuente);
        # Hipervínculo
        $fuenteHipervinculo = [
            "name" => "Arial",
            "size" => 12,
            "color" => "ff0000",
            "italic" => true,
        ];
        $seccion->addLink("https://parzibyte.me/blog", "Mi blog", $fuenteHipervinculo);
*/
        # Títulos. Solo modificando depth (el número)
        $fuenteTitulo = [
            "name" => "Arial",
            "size" => 10,
            "color" => "000000",
        ];
        $documento->addTitleStyle(1, $fuenteTitulo);
        //$seccion->addTitle(auth()->user()->enlace->dependencia->dependenciaNombre, 1);

        # Texto bajo el título
        $seccion->addText("",);
        $seccion->addText("Hola",);
        # Ahora un subtítulo con profundidad de 2
        //   $fuenteSubtitulo = [
        //      "name" => "Verdana",
        //     "size" => 18,
        //    "color" => "000000",
        //];
        //$documento->addTitleStyle(2, $fuenteSubtitulo);
        //$seccion->addTitle("Soy un subtítulo", 2);


        # Para que no diga que se abre en modo de compatibilidad
        $documento->getCompatibility()->setOoxmlVersion(15);
        # Idioma español de México
        $documento->getSettings()->setThemeFontLang(new Language("ES-MX"));

        # Guardarlo
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($documento, "Word2007");

        $filename= $dependencia->dependenciaSiglas."-".$tema->temaPEDClave.".docx";
        $objWriter->save("informe.docx");

        $headers = [
            "Content-type: application/octet-stream",
        ];

        return response()->download("informe.docx", $filename, $headers)->deleteFileAfterSend(true);
    }

    public function saveaccion( Request $request){
        try{
            DB::beginTransaction();
            InformeAccion::create([
                "nombre"=>$request->nombre,
                "idDependencia"=>$request->dependencia,
                "idTemaPED"=>$request->tema,
                "alineacion_la"=>$request->lineas,
                "ae_cuadros"=>$request->cuadros,
            ]);
            DB::commit();
            return response()->json([
                "result"=>"ok",
                "message"=>"La acción ha sido almacenada Satisfactoriamente!"
            ],200);
        }catch(Excepction $ex){
            DB::rollBack();
            return response()->json([
                "result"=>"error",
                "message"=>"Ocurrió un error al tratar de almacenar la Acción!"
            ],500);
        }

    }
}
