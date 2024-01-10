@if (count($indicadores) > 0)
    <div class="row">
        @foreach ($indicadores as $indicador)
            @php
                switch ($indicador->idEjePED) {
                    case 1:
                        //$color = "#4EACA3";
                        $color = '#83d0c8';
                        break;
                    case 2:
                        //$color = "#9B2745";
                        $color = '#AF7782';
                        break;
                    case 3:
                        //$color = "#6177AC";
                        $color = '#87A0D2';
                        break;
                    case 4:
                        //$color = "#71AD4A";
                        $color = '#ADDB8A';
                        break;
                    case 5:
                        //$color = "#E18940";
                        $color = '#F3B88B';
                        break;
                    default:
                        $color = '#000000';
                        break;
                }
            @endphp
            <div class="col-lg-2 mb-4 indicador"
                style="border:solid 1px {{ $color }};padding:15px;border-radius:15pt;cursor:pointer;margin:20px;text-align:left;display:table-cell;vertical-align:middle;background-color:{{ $color }};color:white"
                onclick="getDatas({{ $indicador->idIndicador }},'{{ $indicador->indicadorNombre }}')">
                {{ '[' . $indicador->idIndicador . '] ' . $indicador->indicadorNombre }}
                <img src="{{ asset('/images/ejes_icons/eje' . $indicador->idEjePED . '.png') }}"
                    style="width: 40px;position:absolute;top:-15px;left:-15px;" />
            </div>
        @endforeach
    </div>
@else
    <div>
        <h2>No existen indicadores registrados!</h2>
    </div>
@endif
