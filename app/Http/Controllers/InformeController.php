<?php

namespace App\Http\Controllers;

use App\Models\AnexoEstadistico;
use Carbon\Carbon;
use App\Models\TemaPED;
use App\Models\LineaPED;
use App\Models\Dependencia;
use App\Models\InformeAccion;
use App\Models\InformeParrafo;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use App\Models\MatrizCoordinacion;
use App\Models\ParrafoBase;
use Exception;
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
        $dependencia = Dependencia::where("idDependencia", $request->dependencia)->first();
        $lineas = LineaPED::select("idLAPED", "laPEDClave", "laPEDDescripcion")
            ->join("estrategiaped", "estrategiaped.idEstrategiaPED", "=", "lineaaccionped.idEstrategiaPED")
            ->join("objetivoped", "objetivoped.idObjetivoPED", "=", "estrategiaped.idObjetivoPED")
            ->join("temaped", "temaped.idTemaPED", "=", "objetivoped.idTemaPED")
            ->where("temaped.idTemaPED", $request->tema)->get();
        $acciones = InformeAccion::where("informe_acciones.idDependencia", auth()->user()->enlace->idDependencia)
            ->where("idTemaPED", $request->tema)
            ->join("dependencia", "dependencia.idDependencia", "=", "informe_acciones.idDependencia")
            ->get();

        $cuadrosE = AnexoEstadistico::where("idTemaPED", $request->tema)->get();
        //dd($acciones);

        return view("informe.acciones")->with("tema", $tema)->with("dependencia", $dependencia)->with("lineas", $lineas)->with("acciones", $acciones)->with("cuadros", $cuadrosE);
    }

    public function downloadword(Request $request)
    {

        //obtenemos informacion de la dependencia y del tema enviado por POST
        $dependencia = Dependencia::where("idDependencia", $request->dependencia)->first();
        $tema = TemaPED::where("idTemaPED", $request->tema)->first();



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
        $textrun->addText(htmlspecialchars('2do. Informe de Gobierno'), $fuenteTitulo);
        $table->addRow();
        $cell = $table->addCell(10000);
        $textrun = $cell->addTextRun();
        $fuenteTitulo = [
            "name" => "Arial",
            "size" => 10,
            "color" => "000000",
        ];
        $textrun->addText(htmlspecialchars('Dependencia: ' . $dependencia->dependenciaNombre . " (" . $dependencia->dependenciaNombre . ")"), $fuenteTitulo);
        $table->addRow();
        $cell = $table->addCell(10000);
        $textrun = $cell->addTextRun();
        $textrun->addText(htmlspecialchars('Tema: ' . $tema->temaPEDClave . " " . $tema->temaPEDDescripcion), $fuenteTitulo);


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

        //obtenemos todos los parragos de la dependencia por tema
        $parrafos = InformeParrafo::join("informe_acciones","informe_acciones.id","=","informe_parrafos.informe_acciones_id")
                                    ->join("dependencia","dependencia.idDependencia","=","informe_acciones.idDependencia")
                                    ->where("informe_acciones.idDependencia",$request->dependencia)
                                    ->where("idTemaPED",$request->tema)
                                    ->where("informe_parrafos.status",1)
                                    ->orderBy("informe_parrafos.orden", "ASC")

                                    ->get();
        //dd($parrafos);
        $fuente = [
            "name" => "Montserrat",
            "size" => 11,
            "color" => "000000",
            "italic" => false,
            "bold" => false,
        ];

        $pJustify=[
            'align' => 'mediumKashida', 'spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 0
        ];


        if($parrafos->count()>0){
            foreach($parrafos as $parrafo){
                //$seccion->addText($parrafo->resultado.'<w:rPr><w:b w:val="true"/></w:rPr> ('.$parrafo->dependenciaSiglas.')'."<w:br/>",$fuente,$pJustify);
                $seccion->addText($parrafo->resultado."<w:br/>",$fuente,$pJustify);
            }
        }

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

        $filename = $dependencia->dependenciaSiglas . "-" . $tema->temaPEDClave . ".docx";
        $objWriter->save("informe.docx");

        $headers = [
            "Content-type: application/octet-stream",
        ];

        return response()->download("informe.docx", $filename, $headers)->deleteFileAfterSend(true);
    }

    public function saveaccion(Request $request)
    {
        try {
            DB::beginTransaction();

            if($request->id==""){
                InformeAccion::create([
                    "nombre" => $request->nombre,
                    "idDependencia" => $request->dependencia,
                    "idTemaPED" => $request->tema,
                    "alineacion_la" => $request->lineas,
                    "ae_cuadros" => $request->cuadros,
                ]);
            }else{
                InformeAccion::where("id",$request->id)->update([
                    "nombre" => $request->nombre,
                    "alineacion_la" => $request->lineas,
                    "ae_cuadros" => $request->cuadros,
                ]);
            }

            DB::commit();
            return response()->json([
                "result" => "ok",
                "message" => "La acción ha sido almacenada Satisfactoriamente!"
            ], 200);
        } catch (Excepction $ex) {
            DB::rollBack();
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al tratar de almacenar la Acción!"
            ], 500);
        }
    }

    public function getinfoaccion(Request $request)
    {
        $accion_id = $request->id;
        $infoAccion = InformeAccion::where("id", $accion_id)->first();

        if ($infoAccion != null) {

            //obtenemos lineas de accion asociadas
            $lineas_ = explode("|", $infoAccion->alineacion_la);
            if (count($lineas_) > 0) {
                array_pop($lineas_);
                $lineas = "";
                foreach ($lineas_ as  $lin) {
                    $infoLinea = LineaPED::where("idLAPED", $lin)->first();
                    if ($infoLinea != null) {
                        $lineas .= '<tr id="linea' . $infoLinea->idLAPED . '" >' .
                            '<td class="linea_asociada" id="asociada" style="display:none;">' . $infoLinea->idLAPED . '</td>' .
                            '<td style="padding:10px;">' . $infoLinea->laPEDClave . " " . $infoLinea->laPEDDescripcion . '</td>' .
                            '<td style="text-align:center"><button type="button" class="btn btn-danger" onclick="quitLinea(' .
                            $infoLinea->idLAPED . ')"><i class="fas fa-trash"></i></button></td>' .
                            '</tr>';
                    }
                }
            }

            //obtenemos cuadros estadisticos asociados

            $cuadros_ = explode("|", $infoAccion->ae_cuadros);
            if (count($cuadros_) > 0) {
                array_pop($cuadros_);
                $cuadros = "";
                foreach ($cuadros_ as  $cuad) {
                    $infoCuad = AnexoEstadistico::where("id", $cuad)->first();
                    if ($infoCuad != null) {
                        $cuadros.='<tr id="cuadro' . $infoCuad->id . '" >' .
                        '<td class="cuadro_asociado" id="asociada_c" style="display:none;">' . $infoCuad->id . '</td>' .
                        '<td style="padding:10px;">' . $infoCuad->numero." ". $infoCuad->cuadro . '</td>' .
                        '<td style="text-align:center"><button type="button" class="btn btn-danger" onclick="quitCuadro(' .
                        $infoCuad->id . ')"><i class="fas fa-trash"></i></button></td>' .
                        '</tr>';
                    }
                }
            }

            return response()->json([
                "result" => "ok",
                "info" => $infoAccion,
                "lineas" => $lineas,
                "cuadros" => $cuadros
            ]);
        } else {
            return response()->json([
                "result" => "error",
                "message" => "No se localizó la acción indicada!",

            ]);
        }
    }

    public function redactaparrafos($accion_id){
        $infoAccion = InformeAccion::where("id",$accion_id)
                                    ->join("dependencia","dependencia.idDependencia","=","informe_acciones.idDependencia")
                                    ->join("temaped","temaped.idTemaPED","=","informe_acciones.idTemaPED")
                                    ->first();
        $parrafos = InformeParrafo::where("informe_acciones_id",$accion_id)->get();
        return view("informe.redactarparrafos")->with("accion",$infoAccion)->with("parrafos",$parrafos);
    }

    public function almacenap(Request $request){
        $user_id = auth()->user()->id;
        $campos="";
        $texto = "";
        $accion_id = $request->accion_id;
        $parrafoscapturados = InformeParrafo::where("informe_acciones_id",$accion_id)->get();
        $orden = $parrafoscapturados->count()+1;
        if($request->plantilla!=4){
            $modelo = ParrafoBase::where("id",$request->plantilla)->first();
            $modelo = $modelo->cuerpo;
            $campos = $request->campos;
            $texto = $modelo;
            $campos_ = explode("|",$campos);
            $texto = str_replace("&campo1",$campos_[0],$texto);
            $texto = str_replace("&campo2",$campos_[1],$texto);
            $texto = str_replace("&campo3",$campos_[2],$texto);
            $texto = str_replace("&campo4",$campos_[3],$texto);
            $texto = str_replace("&campo5",$campos_[4],$texto);
            $texto = str_replace("&campo6",$campos_[5],$texto);
            $texto = str_replace("&campo7",$campos_[6],$texto);
            $texto = str_replace("&campo8",$campos_[7],$texto);
        }else{
            $modelo = "";
            $texto = $request->texto;
        }

        try{
            DB::beginTransaction();
            if($request->parrafo_id==""){
                InformeParrafo::create([
                    "users_id"=>$user_id,
                    "campos" => $campos,
                    "resultado" => $texto,
                    "texto"=>$modelo,
                    "informe_acciones_id"=>$accion_id,
                    "tipo" => $request->plantilla,
                    "orden" => $orden
                ]);
            }else{
                InformeParrafo::where("id",$request->parrafo_id)->update([
                    "campos" => $campos,
                    "resultado" => $texto,
                    "texto"=>$modelo,
                    "tipo" => $request->plantilla,
                ]);
            }
            DB::commit();
            return response()->json([
                "result"=>"ok",
                "message"=>"Párrafo almacenado satisfactoriamente!"
            ]);
        }catch(Exception $ex){
            DB::rollBack();
            return response()->json([
                "result"=>"error",
                "message"=>"Ocurrió un error al intentar almacenar el Pârrafo favor de intentar más tarde!"
            ]);
        }
    }

    public function updateordenparrafo(Request $request){
        try{
            InformeParrafo::where("id",$request->parrafo)->update([
                "orden"=>$request->orden
            ]);
            return response()->json([
                "result"=>"ok",
                "message"=>"Orden Actualizado correctamente!"
            ]);
        }catch(Exception $ex){
            return response()->json([
                "result"=>"error",
                "message"=>"Error al actualizar el orden!"
            ]);
        }
    }

    public function updatestatusparrafo(Request $request){
        try{

            InformeParrafo::where("id",$request->parrafo)->update([
                "status"=>$request->status=="false"?false:true
            ]);
            return response()->json([
                "result"=>"ok",
                "message"=>"Status Actualizado correctamente!"
            ]);
        }catch(Exception $ex){
            return response()->json([
                "result"=>"error",
                "message"=>"Error al actualizar el status!"
            ]);
        }
    }

    public function getinfoparrafo(Request $request){
        $infoParrafo = InformeParrafo::where("id",$request->parrafo)->first();
        return response()->json([
            "result" => "ok",
            "message" => "Párrafo localizado",
            "parrafo" => $infoParrafo
        ]);
    }
}

