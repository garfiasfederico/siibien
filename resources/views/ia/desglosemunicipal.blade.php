<div class="col-lg-12" style="padding:20px;">
    <div class="card shadow">
        <div class="card-header py-3" style="background-color:rgb(157, 36, 73);color:white">
            <h6 class="m-0 font-weight-bold text-light" onclick="toggle('chevprimero','body-primero')"
                style="cursor: pointer;color:white">1er. trimestre <i class="fas fa-chevron-right"
                    id="chevprimero"></i>
            </h6>
        </div>
        <div class="card-body" id="body-primero" style="display: none">
            @if($trimestre1->count()>0)
            @php
                $totalhombres = 0;
                $totalmujeres = 0;                
                $totalarea = 0;
                $totalentregas = 0;
            @endphp
                <table style="text-align: center;width:100%;font-size:.8em">
                    <thead>
                        <tr>
                            <th class="enc1" style="text-align: center" rowspan="2">clave</th>
                            <th class="enc1" style="text-align: center" rowspan="2">Municipio</th>
                            <th class="enc1" style="text-align: center" rowspan="2">Región</th>
                            <th class="enc1" style="text-align: center" colspan="3">Población beneficiada</th>
                            <th class="enc1" style="text-align: center" >Área enfoque atendida</th>
                            <th class="enc1" style="text-align: center" >Bienes o servicios entregados</th>
                        </tr>
                        <tr>
                            <th class="enc1" style="text-align: center">Mujeres</th>
                            <th class="enc1" style="text-align: center">Hombres</th>
                            <th class="enc1" style="text-align: center">Total</th>
                            <th class="enc1" style="text-align: center">Total</th>
                            <th class="enc1" style="text-align: center">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trimestre1  as $trim1)
                            @php
                                $totalhombres += $trim1->hombres;
                                $totalmujeres += $trim1->mujeres;
                                $totalarea += $trim1->area;
                                $totalentregas += $trim1->entregas;
                            @endphp
                            <tr>
                                <td style="border:solid 1px rgb(201, 201, 201);">{{$trim1->clave}}</td>
                                <td style="text-align: left;border:solid 1px rgb(201, 201, 201);">{{$trim1->municipio}}</td>
                                <td style="text-align: left;border:solid 1px rgb(201, 201, 201);">{{$trim1->nombre}}</td>
                                <td style="text-align: right;border:solid 1px rgb(201, 201, 201);">{{$trim1->mujeres}}</td>
                                <td style="text-align: right;border:solid 1px rgb(201, 201, 201);">{{$trim1->hombres}}</td>
                                <td style="text-align: right;font-weight:bold;border:solid 1px rgb(201, 201, 201);">{{$trim1->hombres+$trim1->mujeres}}</td>
                                <td style="text-align: right;font-weight:bold;border:solid 1px rgb(201, 201, 201);">{{$trim1->area}}</td>
                                <td style="text-align: right;font-weight:bold;border:solid 1px rgb(201, 201, 201);">{{$trim1->entregas}}</td>
                            </tr>
                        @endforeach
                        <tfoot>
                            <tr>
                                <td colspan="3" class="enc1">Totales:</td>
                                <td style="font-weight:bold;text-align:right" class="enc1">{{$totalmujeres}}</td>
                                <td style="font-weight:bold;text-align:right" class="enc1">{{$totalhombres}}</td>
                                <td style="font-weight:bold;text-align:right" class="enc1">{{$totalmujeres + $totalhombres}}</td>
                                <td style="font-weight:bold;text-align:right" class="enc1">{{$totalarea}}</td>
                                <td style="font-weight:bold;text-align:right" class="enc1">{{$totalentregas}}</td>
                            </tr>
                        </tfoot>
                    </tbody>
                </table>
            @else

            @endif
        </div>
    </div>
</div>
<div class="col-lg-12" style="padding:20px;">
    <div class="card shadow">
        <div class="card-header py-3" style="background-color:rgb(157, 36, 73);color:white">
            <h6 class="m-0 font-weight-bold text-light" onclick="toggle('chevsegundo','body-segundo')"
                style="cursor: pointer;color:white">2do. trimestre <i class="fas fa-chevron-right"
                    id="chevsegundo"></i>
            </h6>
        </div>
        <div class="card-body" id="body-segundo" style="display: none">
        </div>
    </div>
</div>
<div class="col-lg-12" style="padding:20px;">
    <div class="card shadow">
        <div class="card-header py-3" style="background-color:rgb(157, 36, 73);color:white">
            <h6 class="m-0 font-weight-bold text-light" onclick="toggle('chevtercero','body-tercero')"
                style="cursor: pointer;color:white">3er. trimestre <i class="fas fa-chevron-right"
                    id="chevtercero"></i>
            </h6>
        </div>
        <div class="card-body" id="body-tercero" style="display: none">
        </div>
    </div>
</div>
<div class="col-lg-12" style="padding:20px;">
    <div class="card shadow">
        <div class="card-header py-3" style="background-color:rgb(157, 36, 73);color:white">
            <h6 class="m-0 font-weight-bold text-light" onclick="toggle('chevcuarto','body-cuarto')"
                style="cursor: pointer;color:white">4to. trimestre <i class="fas fa-chevron-right"
                    id="chevcuarto"></i>
            </h6>
        </div>
        <div class="card-body" id="body-cuarto" style="display: none">
        </div>
    </div>
</div>
