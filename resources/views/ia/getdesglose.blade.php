@php
    use App\Models\IABSRegion;
@endphp
<table style="width: 100%">
    <tr>
    <tr>
        <td colspan="13" style="text-align: center;background-color:rgb(243,203,215);color:gray;">Desglose por región <br /> [Seleccione trimestre a mostrar]</td>
    </tr>
    </tr>
    <tr>
        <td colspan="13">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: center;transform:scale(1.2)"><input type="checkbox" onclick="toggleTrimestre($(this),1)" checked> 1er. Trimestre</td>
                    <td style="text-align: center;transform:scale(1.2)"><input type="checkbox" onclick="toggleTrimestre($(this),2)" checked> 2do. Trimestre</td>
                    <td style="text-align: center;transform:scale(1.2)"><input type="checkbox" onclick="toggleTrimestre($(this),3)" checked> 3er. Trimestre</td>
                    <td style="text-align: center;transform:scale(1.2)"><input type="checkbox" onclick="toggleTrimestre($(this),4)" checked> 4to. Trimestre</td>
                </tr>
            </table>
        </td>
    </tr>

    @php
        $colspan = 0;

        if($poblacion=="true")
            $colspan += 2;

        if($area=="true")
            $colspan += 1;
        

        
    @endphp
    <tr>
        <td rowspan="2" class="enc1" style="width: 15%">Periodo</td>
        <td colspan="{{$colspan}}" class="enc1 trim1" style="text-align: center;">Enero-Marzo</td>
        <td colspan="{{$colspan}}" class="enc1 trim2" style="text-align: center;">Abril-Junio</td>
        <td colspan="{{$colspan}}" class="enc1 trim3" style="text-align: center;">Julio-Septiembre</td>
        <td colspan="{{$colspan}}" class="enc1 trim4" style="text-align: center;">Octubre-Diciembre</td>
    </tr>
    <tr style="font-size:.8em;">
        @if($poblacion=="true")
            <td class="enc1 trim1" style="text-align: center;">hombres</td>
            <td class="enc1 trim1" style="text-align: center;">mujeres</td>
        @endif

        @if($area=="true")
            <td class="enc1 trim1" style="text-align: center;">otro (area de enfoque)</td>
        @endif
        
        @if($poblacion=="true")
            <td class="enc1 trim2" style="text-align: center;">hombres</td>
            <td class="enc1 trim2" style="text-align: center;">mujeres</td>
        @endif

        @if($area=="true")
            <td class="enc1 trim2" style="text-align: center;">otro (area de enfoque)</td>
        @endif
        
        @if($poblacion=="true")
            <td class="enc1 trim3" style="text-align: center;">hombres</td>
            <td class="enc1 trim3" style="text-align: center;">mujeres</td>
        @endif
        
        @if($area=="true")
            <td class="enc1 trim3" style="text-align: center;">otro (area de enfoque)</td>
        @endif
        
        @if($poblacion=="true")
            <td class="enc1 trim4" style="text-align: center;">hombres</td>
            <td class="enc1 trim4" style="text-align: center;">mujeres</td>
        @endif
        
        @if($area=="true")
            <td class="enc1 trim4" style="text-align: center;">otro (area de enfoque)</td>
        @endif
    </tr>
    @foreach ($regiones as $region )
    @php
        //Obtenemos los datos guardados del desglose
        $datos = IABSRegion::where("idBS",$idBS)->where("anio",$anio)->where("idRegion",$region->id)->first()
    @endphp
    <tr style="">
        <td class="enc1" style="text-align: left;">{{$region->nombre}}</td>
        @if($poblacion=="true")
            <td class="trim1" style="text-align: right;"><input type="number" class="form-control" id="h1{{$region->id}}" onchange="refreshDesglose()" style="text-align: right" @if($datos!=null) value="{{$datos->h1}}" @endif></td>
            <td class="trim1" style="text-align: right;"><input type="number" class="form-control" id="m1{{$region->id}}" onchange="refreshDesglose()" style="text-align: right" @if($datos!=null) value="{{$datos->m1}}" @endif/></td>
        @endif
        
        @if($area=="true")
            <td class="trim1" style="text-align: right;"><input type="number" class="form-control" id="o1{{$region->id}}" onchange="refreshDesglose()" style="text-align: right" @if($datos!=null) value="{{$datos->a1}}" @endif/></td>
        @endif
        
        @if($poblacion=="true")
            <td class="trim2" style="text-align: right;"><input type="number" class="form-control" id="h2{{$region->id}}" onchange="refreshDesglose()" style="text-align: right" @if($datos!=null) value="{{$datos->h2}}" @endif/></td>
            <td class="trim2" style="text-align: right;"><input type="number" class="form-control" id="m2{{$region->id}}" onchange="refreshDesglose()" style="text-align: right" @if($datos!=null) value="{{$datos->m2}}" @endif/></td>
        @endif
        
        @if($area=="true")
            <td class="trim2" style="text-align: right;"><input type="number" class="form-control" id="o2{{$region->id}}" onchange="refreshDesglose()" style="text-align: right" @if($datos!=null) value="{{$datos->a2}}" @endif/></td>
        @endif
        
        @if($poblacion=="true")
            <td class="trim3" style="text-align: right;"><input type="number" class="form-control" id="h3{{$region->id}}" onchange="refreshDesglose()" style="text-align: right" @if($datos!=null) value="{{$datos->h3}}" @endif/></td>
            <td class="trim3" style="text-align: right;"><input type="number" class="form-control" id="m3{{$region->id}}" onchange="refreshDesglose()" style="text-align: right" @if($datos!=null) value="{{$datos->m3}}" @endif/></td>
        @endif

        @if($area=="true")        
            <td class="trim3" style="text-align: right;"><input type="number" class="form-control" id="o3{{$region->id}}" onchange="refreshDesglose()" style="text-align: right" @if($datos!=null) value="{{$datos->a3}}" @endif/></td>
        @endif
        
        @if($poblacion=="true")
            <td class="trim4" style="text-align: right;"><input type="number" class="form-control" id="h4{{$region->id}}" onchange="refreshDesglose()" style="text-align: right" @if($datos!=null) value="{{$datos->h4}}" @endif/></td>
            <td class="trim4" style="text-align: right;"><input type="number" class="form-control" id="m4{{$region->id}}" onchange="refreshDesglose()" style="text-align: right" @if($datos!=null) value="{{$datos->m4}}" @endif/></td>
        @endif
        
        @if($area=="true")
            <td class="trim4" style="text-align: right;"><input type="number" class="form-control" id="o4{{$region->id}}" onchange="refreshDesglose()" style="text-align: right" @if($datos!=null) value="{{$datos->a4}}" @endif/></td>
        @endif
    </tr>
    @endforeach


    <tr style="">
        <td class="enc1" style="text-align: left;">Total</td>
        @if($poblacion=="true")
            <td class="enc4 trim1" style="text-align: right;font-size:1.3em;font-weight:bold;" id="trh1"></td>
            <td class="enc4 trim1" style="text-align: right;font-size:1.3em;font-weight:bold;" id="trm1"></td>
        @endif

        @if($area=="true")
            <td class="enc4 trim1" style="text-align: right;font-size:1.3em;font-weight:bold;" id="tro1"></td>
        @endif
        
        
        @if($poblacion=="true")
            <td class="enc4 trim2" style="text-align: right;font-size:1.3em;font-weight:bold;" id="trh2"></td>
            <td class="enc4 trim2" style="text-align: right;font-size:1.3em;font-weight:bold;" id="trm2"></td>
        @endif
        
        @if($area=="true")
            <td class="enc4 trim2" style="text-align: right;font-size:1.3em;font-weight:bold;" id="tro2"></td>
        @endif
        
        @if($poblacion=="true")
            <td class="enc4 trim3" style="text-align: right;font-size:1.3em;font-weight:bold;" id="trh3"></td>
            <td class="enc4 trim3" style="text-align: right;font-size:1.3em;font-weight:bold;" id="trm3"></td>
        @endif
        
        @if($area=="true")
            <td class="enc4 trim3" style="text-align: right;font-size:1.3em;font-weight:bold;" id="tro3"></td>
        @endif
        
        @if($poblacion=="true")
            <td class="enc4 trim4" style="text-align: right;font-size:1.3em;font-weight:bold;" id="trh4"></td>
            <td class="enc4 trim4" style="text-align: right;font-size:1.3em;font-weight:bold;" id="trm4"></td>
        @endif
        
        @if($area=="true")
            <td class="enc4 trim4" style="text-align: right;font-size:1.3em;font-weight:bold;" id="tro4"></td>
        @endif
    </tr>
</table>
<script>
    refreshDesglose();
</script>