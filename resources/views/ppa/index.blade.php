@extends('layouts.administrador')

@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">PPA / registrar</h1>    
@endsection

@section('styles')
<style>
    .enc1{
        padding:5px !important;
        background-color: #919090;
        color:white;        
    }

    .enc2{
        padding:5px !important;
        background-color: #7c2f42;
        color:white;
    }

    .resp{
        font-weight: bold;
    }

    .enc3{
        background-color: #ececec;
        font-weight: bold;
    }
    input[type=text], select{
        height: 35px;
    }

    table tr td{
        padding: 5px;
        border: solid 2px white;
    }
</style>
@endsection

@section('content')
    <div class="row">

        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-light">Registro del Programa Proyecto o Acción para el Seguimiento</h6>
 
                </div>
                <!-- Card Body -->
                <div class="card-body" id="indicadorContent">
                    <form method="POST" action="" id="formularioppa">
                        <div style="width:100%;border:dotted 1px gray;">                            
                            <table style="width:100%">
                                <tr>
                                    <td class="enc1" title="Fecha de Captura del Reporte (Automática)"> Fecha de reporte <br/></td>
                                    <td class="resp"><?php echo date("d-m-Y H:i:s") ?><br/></td>                
                                </tr>                        
                                <tr>
                                    <td class="enc1">
                                        Dependencia o Entidad:
                                    </td>
                                    <td>
                                        <select style="width:100%" name="dependencia" title="Elegir de la lista desplegable la institución de la que realiza el reporte">                                            
                                        </select>
                                    </td>
                                    <td class="enc1">
                                        Sector
                                    </td>
                                    <td>
                                        <select name="sector" title="Elegir de la lista desplegable el sector al cual pertenece su institución.">
                                            
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <table style="width: 100%">
                                <tr>
                                    <td colspan="2" class="enc1" style="text-align: center">1. Datos Generales</td>
                                </tr>
                                <tr>
                                    <td class="enc3" style="width: 30%">Nombre del Programa, Proyecto o Acción (PPA):</td>
                                    <td><textarea name="nombre_ppa" style="width: 100%;" required title='Capturar el nombre oficial del “Programa”, “Proyecto” o “Acción” de manera completa. En caso de contar con siglas estas deberán escribirse en mayúsculas y entre paréntesis.'></textarea></td>
                                </tr>
                                <tr>
                                    <td class="enc3" style="width: 30%">Cobertura:</td>
                                    <td>
                                        <select style="width:100%;" name="cobertura" title="Seleccionar del menú desplegable según corresponda; estatal, regional o municipal.">
                                            <option value="Municipal">Municipal</option>
                                            <option value="Distrital">Distrital</option>
                                            <option value="Regional">Regional</option>
                                            <option value="Estatal">Estatal</option>                        
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td  class="enc3" style="width: 30%">Objetivo General del PPA:</td>
                                    <td><textarea style="width: 100%;" name="objetivo_ppa" required title='Especificar el propósito del "Programa", "Proyecto" o "Acción".'></textarea></td>
                                </tr>
                                <tr>
                                    <td  class="enc3" style="width: 30%" >Descripción del PPA:</td>
                                    <td><textarea style="width: 100%;" name="descripcion_ppa" required title="Describa en un lenguaje claro, simple e incluyente; en qué consiste el PPA."></textarea></td>
                                </tr>
                                <tr>
                                    <td class="enc3" style="width: 30%">Eje del PED:</td>
                                    <td>
                                        <select style="width:100%;" name="ejeped" title="Seleccionar el eje de gobierno en el cual se enmarca el PPA.">
                                            <option value="1">1. Oaxaca Incluyente con Desarrollo Social</option>
                                            <option value="2">2. Oaxaca Moderno y Transparente</option>
                                            <option value="3">3. Oaxaca Seguro</option>
                                            <option value="4">4. Oaxaca Productivo e Innovador</option>                        
                                            <option value="5">5. Oaxaca Sustentable</option>                        
                                            <option value="6">6. Políticas Transversales</option>                        
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="enc3" style="width: 30%">Compromiso Atendido:</td>
                                    <td><textarea style="width: 100%;" name="compromiso" required></textarea></td>
                                </tr>
                                <tr>
                                    <td class="enc3" style="width: 30%">Tipo PPA:</td>
                                    <td>
                                        <select style="width:100%;" name="tipo_ppa" title="Seleccionar de las opciones dadas, si el PPA se creó con propósito de la contingencia o si se trata de un PPA ya existente que fue modificado exprofeso.">
                                            <option value="1">Creado Exprofeso</option>
                                            <option value="2">Innovado o modificado Exprofeso</option>                        
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <table style="width: 100%">
                                <tr>
                                    <td colspan="4" class="enc1" style="text-align: center">2. Productos Entregados (Bienes o Servicios Públicos) e Inversión</td>
                                </tr>
                                <tr>
                                    <td class="enc3" style="width: 15%">Producto Entregado:</td>
                                    <td><textarea style="width: 100%;" name="producto" required title="Describa claramente cual es el producto a entregar como parte de este PPA. Por ejemplo: despensas, créditos, asistencia telefónica, etc."></textarea></td>
                                    <td class="enc3" style="width: 15%">Número de Entregas:</td>
                                    <td><textarea style="width: 100%;" name="entregas" required title="Reportar el número de bienes o servicios públicos programados a entregar durante el periodo que se tiene prevista la intervención del PPA."></textarea></td>
                                </tr>
                                <tr>
                                    <td class="enc3" style="width: 15%">Unidad de Medida:</td>
                                    <td><textarea style="width: 100%;" name="um" required title="Especificar el parámetro utilizado como estándar de medida para determinar la magnitud física de los bienes o servicios públicos entregados, por ejemplo: vacunas, vales, becas, apoyos económicos."></textarea></td>
                                    <td class="enc3" style="width: 15%">Monto de Inversión:</td>
                                    <td><textarea style="width: 100%;" name="monto_inversion" required title='Señalar el monto de inversión total que se tiene previsto para la ejecución del "Programa", "Proyecto" o "Acción".'></textarea></td>
                                </tr>
                                <tr>
                                    <td class="enc3" style="width: 15%">Fuente de Financiamiento:</td>
                                    <td colspan="4"><textarea style="width: 100%;" name="fuente_financiamiento" required title='Señalar si se refiere a “Programa Normal Estatal”, “En coordinación con la Federación (pari-passu)” o “Programa Ejercido por el Gobierno Federal”, o en su caso si se trata de un programa emergente derivado de la emergencia. Escribir el nombre del programa presupuestario o fuente de financimiento del cual proviene el recurso a ejercer.'></textarea></td>                
                                </tr>
                            </table>
                            <table style="width: 100%">
                                <tr>
                                    <td colspan="6" class="enc1" style="text-align: center">3. Población Objetivo</td>
                                </tr>
                                <tr>            
                                    <td class="enc3" style="width: 15%">Descripción del Beneficiario:</td>
                                    <td colspan="5"><textarea style="width: 100%;" name="descripcion_beneficiario" required title="Describir las características del beneficiario, como género, rango de edad, ubicación, zona, actividad económica del o de los sujetos. Por ejemplo: Mujeres jefas de familia, Artesanos, MiPymes, etc."></textarea></td>                
                                </tr>
                                <tr>            
                                    <td class="enc3" style="width: 15%">Población Objetivo:</td>
                                    <td colspan=""><textarea style="width: 100%;" name="poblacion_objetivo" required title="Reportar el número de personas que el programa o proyecto tiene planeado o programado atender. "></textarea></td>                
                                    <td class="enc3" style="width: 15%">Mujeres:</td>
                                    <td colspan=""><textarea style="width: 100%;" name="mujeres" required></textarea></td>                
                                    <td class="enc3" style="width: 15%">Hombres:</td>
                                    <td colspan=""><textarea style="width: 100%;" name="hombres" required></textarea></td>                
                                </tr>
                                <tr>            
                                    <td  class="enc3" style="width: 15%" title="Señalar la o las regiones en las cuales se tiene programada la intervención.">Region:</td>
                                    <td colspan="2">
                                        <table style="width:100%;">
                                            <tr>
                                                <td><input type="checkbox" value="cañada" name="region[]"/>Cañada</td>
                                                <td><input type="checkbox" value="costa" name="region[]"/>Costa</td>
                                                <td><input type="checkbox" value="istmo" name="region[]"/>Istmo</td>
                                            </tr>
                                            <tr>                            
                                                <td><input type="checkbox" value="mixteca" name="region[]"/>Mixteca</td>
                                                <td><input type="checkbox" value="papaloapam" name="region[]"/>Papaloapam</td>
                                                <td><input type="checkbox" value="sierra_norte" name="region[]"/>Sierra Norte</td>
                                            </tr>                        
                                            <tr>
                                                <td><input type="checkbox" value="sierra_sur" name="region[]"/>Sierra Sur</td>
                                                <td><input type="checkbox" value="valles_centrales" name="region[]"/>Valles Centrales</td>
                                            </tr>
                                        </table>
                
                
                
                
                
                
                
                
                                    </td>                
                                    <td class="enc3" style="width: 15%">Municipio:</td>
                                    <td colspan="2">
                                        <textarea style="width: 100%;" name="municipio" required title='Especificar los municipios atendidos con el "Programa", "Proyecto" o "Acción". En caso de tratarse de mas de cinco, reportar el total de municipios atendidos.'></textarea>
                                    </td>                                
                                </tr>
                            </table>
                            <table style="width: 100%">
                                <tr>
                                    <td colspan="11" class="enc1" style="text-align: center">4. Programación de Metas y Seguimiento</td>
                                </tr>
                                <tr>
                                    <td colspan="11" class="enc2" style="text-align: center" title="Capturar las metas programadas para la entrega de los bienes y servicios, del periodo de marzo a diciembre, así como las entregas realizadas al mes de reporte.">a. Metas mensuales (Bienes y Servicios)</td>
                                </tr>
                                <tr>
                                    <td colspan="1" class="enc3" style="text-align: center;width:9.09%"></td>
                                    <td colspan="1" class="enc3" style="text-align: center;width:9.09%">Marzo</td>
                                    <td colspan="1" class="enc3" style="text-align: center;width:9.09%">Abril</td>
                                    <td colspan="1" class="enc3" style="text-align: center;width:9.09%">Mayo</td>
                                    <td colspan="1" class="enc3" style="text-align: center;width:9.09%">Junio</td>
                                    <td colspan="1" class="enc3" style="text-align: center;width:9.09%">Julio</td>                
                                    <td colspan="1" class="enc3" style="text-align: center;width:9.09%">Agosto</td>                
                                    <td colspan="1" class="enc3" style="text-align: center;width:9.09%">Septiembre</td>                
                                    <td colspan="1" class="enc3" style="text-align: center;width:9.09%">Octubre</td>                
                                    <td colspan="1" class="enc3" style="text-align: center;width:9.09%">Noviembre</td>                
                                    <td colspan="1" class="enc3" style="text-align: center;width:9.09%">Diciembre</td>                
                                </tr>
                                <tr>
                                    <td colspan="1" class="enc3" style="text-align: ;width:9.09%">Programado</td>
                                    <td colspan="1" class="" style="text-align: center;"><input style="width:90px;" type="text" name="pmar" /></td>
                                    <td colspan="1" class="" style="text-align: center;"><input style="width:90px;" type="text" name="pabr" /></td>
                                    <td colspan="1" class="" style="text-align: center;"><input  style="width:90px;" type="text" name="pmay" /></td>
                                    <td colspan="1" class="" style="text-align: center;"><input style="width:90px;" type="text" name="pjun" /></td>
                                    <td colspan="1" class="" style="text-align: center;"><input style="width:90px;" type="text" name="pjul" /></td>                
                                    <td colspan="1" class="" style="text-align: center;"><input style="width:90px;" type="text" name="pago" /></td>                
                                    <td colspan="1" class="" style="text-align: center;"><input style="width:90px;" type="text" name="psep" /></td>                
                                    <td colspan="1" class="" style="text-align: center;"><input style="width:90px;" type="text" name="poct" /></td>                
                                    <td colspan="1" class="" style="text-align: center;"><input style="width:90px;" type="text" name="pnov" /></td>                
                                    <td colspan="1" class="" style="text-align: center;"><input style="width:90px;" type="text" name="pdic" /></td>                
                                </tr>
                                <tr>
                                    <td colspan="1" class="enc3" style="text-align: ;width:9.09%">Realizado</td>
                                    <td colspan="1" class="" style="text-align: center;"><input  style="width:90px;" type="text" name="rmar" /></td>
                                    <td colspan="1" class="" style="text-align: center;"><input style="width:90px;" type="text" name="rabr" /></td>
                                    <td colspan="1" class="" style="text-align: center;"><input style="width:90px;" type="text" name="rmay" /></td>
                                    <td colspan="1" class="" style="text-align: center;"><input style="width:90px;" type="text" name="rjun" /></td>
                                    <td colspan="1" class="" style="text-align: center;"><input style="width:90px;" type="text" name="rjul" /></td>                
                                    <td colspan="1" class="" style="text-align: center;"><input style="width:90px;" type="text" name="rago" /></td>                
                                    <td colspan="1" class="" style="text-align: center;"><input style="width:90px;" type="text" name="rsep" /></td>                
                                    <td colspan="1" class="" style="text-align: center;"><input style="width:90px;" type="text" name="roct" /></td>                
                                    <td colspan="1" class="" style="text-align: center;"><input style="width:90px;" type="text" name="rnov" /></td>                
                                    <td colspan="1" class="" style="text-align: center;"><input style="width:90px;" type="text" name="rdic" /></td>                
                                </tr>
                                <tr>
                                    <td colspan="1" class="enc3" style="text-align: ;width:10%" title='Incluir los medios de verificación que permitan corroborar la entrega de los bienes y servicios reportados. Puede considerarse: Fotografías, redes sociales, actas de entrega, enlaces a documentos de consulta. '>Medios de Verificación</td>
                                    <td colspan="10" class="" style="text-align: center;"><textarea style="width:100%" name="mv_metas"></textarea></td>
                                </tr>
                            </table>
                            <table style="width: 100%">            
                                <tr>
                                    <td colspan="6" class="enc2" style="text-align: center" title="Reportar la información referente al indicador que medirá a nivel gestión la eficacia del PPA. Por ejemplo: Porcentaje de población atendida, Porcentaje de becas entregadas, etc.">b. Indicadores de Gestión</td>
                                </tr>
                                <tr>
                                    <td colspan="6" id="indicadores_gestion">
                                        <input type='hidden' value='1' id='indicadores_gestion_agregados'>
                                        <table style="width:100%" class="indicador_gestion" id="indicador_gestion1">
                                            <tr>
                                                <td colspan="6" class="enc2" style="text-align:center;">Indicador de Gestión</td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="enc3" style="text-align: ;width:16.6%">Nombre</td>
                                                <td colspan="5" class="" style="text-align: center;"><input type="text" style="width:100%" name="nombre_gestion[]"/></td>                
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="enc3" style="text-align: ;width:16.6%">Objetivo</td>
                                                <td colspan="5" class="" style="text-align: center;"><input type="text" style="width:100%" name="objetivo_gestion[]"/></td>                
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="enc3" style="text-align: ;width:16.6%">Tipo</td>
                                                <td colspan="1" class="" style="text-align: center;">
                                                    
                                                    <select style="width: 100%" name="tipo_gestion[]" >
                                                        <option value="impacto">Impacto</option>
                                                        <option value="gestion">Gestion</option>
                                                    </select>
                                                
                                                </td>                
                                                <td colspan="1" class="enc3" style="text-align: ;width:16.6%">Dimensión</td>
                                                <td colspan="1" class="" style="text-align: center;">
                                                    <select style="width:100%" name="dimension_gestion[]">
                                                        <option value="eficacia">Eficacia</option>
                                                        <option value="eficiencia">Eficiencia</option>
                                                        <option value="economia">Economía</option>
                                                        <option value="calidad">Calidad</option>
                                                    </select>
                                                </td>                
                                                <td colspan="1" class="enc3" style="text-align: ;width:16.6%">Método de Cálculo</td>
                                                <td colspan="1" class="" style="text-align: center;">
                                                    <select style="width:100%" name="metodo_gestion[]">
                                                        <option value="porcentaje">Porcentaje</option>
                                                        <option value="razon_promedio">Razon Promedio</option>
                                                        <option value="tasa_variacion">Tasa Variación</option>
                                                        <option value="tasa">Tasa</option>
                                                        <option value="indice">Índice</option>
                                                    </select>
                                                </td>                
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="enc3" style="text-align: ;width:16.6%">Fórmula</td>
                                                <td colspan="5" class="" style="text-align: center;"><input type="text" style="width:100%" name="formula_gestion[]"/></td>                
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="enc3" style="text-align: ;width:16.6%">Frecuencia de Medición</td>
                                                <td colspan="1" class="" style="text-align: center;">                                    
                                                    <select style="width:100%" name="frecuencia_gestion[]">
                                                        <option value="mensual">Mensual</option>
                                                        <option value="bimestral">Bimestral</option>
                                                        <option value="trimestral">Trimestral</option>
                                                        <option value="semestral">Semestral</option>
                                                        <option value="anual">Anual</option>
                                                        <option value="bienal">Bienal</option>
                                                        <option value="quinquenal">Quinquenal</option>
                                                    </select>
                                                </td>                
                                                <td colspan="1" class="enc3" style="text-align: ;width:16.6%">Sentido Esperado</td>
                                                <td colspan="1" class="" style="text-align: center;">
                                                    <select style="width:100%" name="sentido_gestion[]">
                                                        <option value="ascendente">Ascendente</option>
                                                        <option value="descendente">Descendente</option>
                                                    </select>
                                                </td>                
                                                <td colspan="1" class="enc3" style="text-align: ;width:16.6%">Línea Base</td>
                                                <td colspan="1" class="" style="text-align: center;"><input type="text" style="width:100%" name="base_gestion[]" maxlength="4"/></td>                
                                            </tr>
                                            <tr>
                                                <td colspan=6" class="enc3" style="text-align: center">Meta Programada</td>
                                            <tr>
                                            <tr>
                                                <td colspan="1" class="enc3" style="text-align:;width:16.6%">Periodo</td>
                                                <td colspan="2" class="" style="text-align: center;"><input type="text" style="width:100%" name="periodo_gestion[]"/></td>                
                                                <td colspan="1" class="enc3" style="text-align:;width:16.6%">Valor</td>
                                                <td colspan="2" class="" style="text-align: center;"><input type="text" style="width:100%" name="valor_gestion[]"/></td>                
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="enc3" style="text-align:;width:16.6%">Medios de Verificación</td>
                                                <td colspan="5" class="" style="text-align: center;"><textarea style="width:100%" name="mv_gestion[]"></textarea></td>                
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="enc3" style="text-align:right;"><i class="fas fa-plus-circle" style="width:80px;cursor:pointer;" onclick="addIGestion()"></i></td>                                
                                            </tr>
                                        </table>
                                    </td>
                                </tr>            
                            </table>
                            <table style="width: 100%">            
                                <tr>
                                    <td colspan="6" class="enc2" style="text-align: center" title='Capturar la información referente al indicador con el que se medirá a nivel estratégicos el impacto esperado por la implementación del PPA. Por ejemplo: Tasa de desocupación, Incidencia delictiva, etc. Deberá considerarse que la frecuencia de medición del indicadoreseleccionado permita determinar los resultados o impacto generado por la intervención.'>c. Indicadores de Resultados</td>
                                </tr>
                                <tr>
                                    <td colspan="6" id="indicadores_resultados">
                                        <input type='hidden' value='1' id='indicadores_resultados_agregados'>
                                        <table style="width: 100%;" class="indicadores" id="indicador_resultados1">
                                            <tr>
                                                <td colspan="1" class="enc3" style="text-align: ;width:16.6%">Nombre</td>
                                                <td colspan="5" class="" style="text-align: center;"><input type="text" style="width:100%" name="nombre_resul[]"/></td>                
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="enc3" style="text-align: ;width:16.6%">Objetivo</td>
                                                <td colspan="5" class="" style="text-align: center;"><input type="text" style="width:100%" name="objetivo_resul[]"/></td>                
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="enc3" style="text-align: ;width:16.6%">Tipo</td>
                                                <td colspan="1" class="" style="text-align: center;">
                                                    <select style="width: 100%" name="tipo_resul[]" >
                                                        <option value="impacto">Impacto</option>
                                                        <option value="gestion">Gestion</option>
                                                    </select>
                                                </td>                
                                                <td colspan="1" class="enc3" style="text-align: ;width:16.6%">Dimensión</td>
                                                <td colspan="1" class="" style="text-align: center;">
                                                     <select style="width:100%" name="dimension_resul[]">
                                                        <option value="eficacia">Eficacia</option>
                                                        <option value="eficiencia">Eficiencia</option>
                                                        <option value="economia">Economía</option>
                                                        <option value="calidad">Calidad</option>
                                                    </select>
                                                </td>                
                                                <td colspan="1" class="enc3" style="text-align: ;width:16.6%">Método de Cálculo</td>
                                                <td colspan="1" class="" style="text-align: center;">
                                                    <select style="width:100%" name="metodo_resul[]">
                                                        <option value="porcentaje">Porcentaje</option>
                                                        <option value="razon_promedio">Razon Promedio</option>
                                                        <option value="tasa_variacion">Tasa Variación</option>
                                                        <option value="tasa">Tasa</option>
                                                        <option value="indice">Índice</option>
                                                    </select>
                                                </td>                
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="enc3" style="text-align: ;width:16.6%">Fórmula</td>
                                                <td colspan="5" class="" style="text-align: center;"><input type="text" style="width:100%" name="formula_resul[]"/></td>                
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="enc3" style="text-align: ;width:16.6%">Frecuencia de Medición</td>
                                                <td colspan="1" class="" style="text-align: center;">                                    
                                                    <select style="width:100%" name="frecuencia_resul[]">
                                                        <option value="mensual">Mensual</option>
                                                        <option value="bimestral">Bimestral</option>
                                                        <option value="trimestral">Trimestral</option>
                                                        <option value="semestral">Semestral</option>
                                                        <option value="anual">Anual</option>
                                                        <option value="bienal">Bienal</option>
                                                        <option value="quinquenal">Quinquenal</option>
                                                    </select>
                                                    
                                                </td>                
                                                <td colspan="1" class="enc3" style="text-align: ;width:16.6%">Sentido Esperado</td>
                                                <td colspan="1" class="" style="text-align: center;">
                                                    <select style="width:100%" name="sentido_resul[]">
                                                        <option value="ascendente">Ascendente</option>
                                                        <option value="descendente">Descendente</option>
                                                    </select>
                                                </td>                
                                                <td colspan="1" class="enc3" style="text-align: ;width:16.6%">Línea Base</td>
                                                <td colspan="1" class="" style="text-align: center;"><input type="text" style="width:100%" name="base_resul[]" maxlength="4"/></td>                
                                            </tr>
                                            <tr>
                                                <td colspan=6" class="enc3" style="text-align: center">Meta Programada</td>
                                            <tr>
                                            <tr>
                                                <td colspan="1" class="enc3" style="width:16.6%">Periodo</td>
                                                <td colspan="2" class="" style="text-align: center;"><input type="text" style="width:100%" name="periodo_resul[]"/></td>                
                                                <td colspan="1" class="enc3" style="width:16.6%">Valor</td>
                                                <td colspan="2" class="" style="text-align: center;"><input type="text" style="width:100%" name="valor_resul[]"/></td>                
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="enc3" style="width:16.6%">Medios de Verificación</td>
                                                <td colspan="5" class="" style="text-align: center;"><textarea style="width:100%" name="mv_resul[]"></textarea></td>                
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="enc3" style="text-align:right;"><i class="fas fa-plus-circle" style="width:80px;cursor:pointer;"  onclick="addIResultados()"></i></td>                                
                                            </tr>
                
                                        </table>
                                    </td>
                                </tr>
                
                            </table>
                            <table style="width: 100%">
                                <tr>
                                    <td colspan="6" class="enc1" style="text-align: center" title="Seleccionar los medios por los cuales se ha establecido el contacto con la población para dar o conocer o hacver llegar los bienes y servicios otorgados como parte del PPA.">5. Interacción con la Ciudadanía</td>
                                </tr>
                                <tr>
                                    <td colspan="1"><input type="checkbox" value="pag_oficial" name="pag_oficial"/><label>Página Oficial</label></td>
                                    <td colspan="1"><input type="text" name="pag_oficial_val"></td>
                                    <td colspan="1"><input type="checkbox" value="red_sociales" name="red_sociales"/>Redes Sociales</td>
                                    <td colspan="1"><input type="text" name="red_sociales_val"></td>
                                    <td colspan="1"><input type="checkbox" value="plat_dig" name="plat_dig"/>Plataforma Digital</td>
                                    <td colspan="1"><input type="text" name="plat_dig_val"></td>
                                </tr>
                                <tr>
                                    <td colspan="1"><input type="checkbox" value="buzon_digital" name="buzon_digital"/>Buzón Digital</td>
                                    <td colspan="1"><input type="text" name="buzon_digital_val"></td>
                                    <td colspan="1"><input type="checkbox" value="atencion_personal" name="atencion_personal"/>Atención personal (con medidas sanitarias)</td>
                                    <td colspan="1"><input type="text" name="atencion_personal_val"></td>
                                    <td colspan="1"><input type="checkbox" value="video_conferencia" name="video_conferencia"/>Videoconferencias</td>              
                                    <td colspan="1"><input type="text" name="video_conferencia_val"></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="otro">Otro</td>
                                    <td colspan="1"><input type="text" style="" name="otro_val"></td>                
                                </tr>
                                <tr>
                                    <td colspan="1">Total de Atendidos</td>
                                    <td colspan="1"><input type="text" name="total_atendidos" required title="Especificar, en caso de contar con la información, el total de personas con las cuales se interactuó a través del medio seleccionado."></td>
                                </tr>
                            </table>
                            <table style="width: 100%">
                                <tr>
                                    <td colspan="6" class="enc1" style="text-align: center" title="Capturar comentarios adicionales que sea importante reportar.">6. Observaciones Generales</td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="enc1" style="text-align: center"><textarea style="width: 100%" name="observaciones_generales" title="Capturar comentarios adicionales que sea importante reportar."></textarea></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="enc1" style="text-align: center"><textarea style="width: 100%" name="elaboro"></textarea></td>
                                    <td colspan="3" class="enc1" style="text-align: center"><textarea style="width: 100%" name="aprobo"></textarea></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="enc1" style="text-align: center">Elaboró<br/>(Nombre y cargo)</td>
                                    <td colspan="3" class="enc1" style="text-align: center">Aprobó <br/> (Nombre y cargo)</td>
                                </tr>
                                <tr>                      
                                    <td colspan="6"  style="text-align:right;padding: 30px;"><div class="g-recaptcha" data-sitekey="6LfGZPsUAAAAAJ_w_n-Hzz5e1Gb1nlE71iIb463P" required></div><input type='submit'  style="width:150px; height:40px;background-color:#73af76;color: white;cursor:pointer;" value="Enviar Reporte"></td>                
                                </tr>
                            </table>
                
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection