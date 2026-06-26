<br />
<p style="text-align:right;">
    Tlalixtac de Cabrera, Oaxaca.
    <br />
    @php
        $days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $date = $days[date('w')];
        echo $date . ' ' . date('d') . ' de ' . $meses[intval(date('m') - 1)] . ' de ' . date('Y') . '.';
    @endphp
</p>
<p style="text-align: left"><b>{{ $enlace->titulo." ".$enlace->nombre." ".$enlace->apellidoP." ".$enlace->apellidoM }}</b>
    <br />
    <b>{{ $enlace==null?"":$enlace->cargo }}</b>
    <br />
    <b>P R E S E N T E .</b>
</p>
<p></p>
<p style="text-align: justify;line-height:20px;">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Con fundamento en los artículos 94 fracción IV, 96, 97 fracciones II y IV de la Ley Estatal de Planeación y 45 fracción LIX de la Ley Orgánica del
    Poder Ejecutivo del Estado de Oaxaca, se hace entrega de los datos de usuario para ingresar al Sistema de Seguimiento Integral de Indicadores del Bienestar (SIIBien),
    al cual puede acceder desde la dirección web: <a target="_blank" href="http://siibien.oaxaca.gob.mx/login">http://siibien.oaxaca.gob.mx/login</a>.
</p>
<p></p>

<table>
    <tr>
        <td style="width: 15%"></td>
        <td style="width: 70%">
            <table style="width: 100%;border:solid 1px gray;text-align:center">
                <tr>
                    <td style="background-color: #681b2e;color:white;textalign:center;height:20px;"><b>USUARIO</b></td>
                    <td style="text-align: center;height:20px; font-size:12pt.;border:solid 1px #681b2e">{{ $enlace==null?"":$enlace->cuenta }}</td>

                </tr>

                <tr>

                    <td style="background-color: #681b2e;color:white;textalign:center;height:20px;"><b>CONTRASEÑA</b>
                    </td>
                    <td style="text-align: center;font-size:12pt.;border:solid 1px #681b2e">{{ base64_decode($enlace==null?"":$enlace->enc) }}</td>
                </tr>
            </table>
        </td>
        <td style="width: 15%">
        </td>

    </tr>
</table>
<p></p>
<p style="text-align: justify;line-height:20px;">Se le recuerda que este usuario es confidencial e intransferible y se recomienda cambiar la contraseña después de ingresar por primera vez, considerando una contraseña de al menos 8 caracteres que incluya letras, números y signos.
</p>
<p style="text-align: justify;line-height:20px;">En caso de dudas o apoyo técnico para el uso del sistema, puede contactar al L.I. José Federico Sánchez Garfias jefe del Departamento de
    Desarrollo de Sistemas de Información al teléfono 501 15000 extensión 11410.
</p>
<div style="height: 200px;vertical-align:bottom">
    <p>
    </p>
    <table>
        <tr>
            <td style="text-align: center">
                <b>RECIBE</b>
                <br/>
                _________________________________
                <br />
                <b>{{ $enlace->titulo." ".$enlace->nombre." ".$enlace->apellidoP." ".$enlace->apellidoM }}</b>
                <br />
                {{ $enlace==null?"":$enlace->cargo }}
                <br />
                {{ $enlace==null?"":$enlace->dependenciaNombre }}
            </td>
            <td style="text-align: center">
                <b>ENTREGA</b>
                <br/>
                _________________________________
                <br />
                <b>Mtra. Laura Mendoza Aquino</b>
                <br />
                Jefa de la Unidad de Informes sobre el Estado de la Gestión Pública.
                <br>
                Secretaría de Finanzas
            </td>

        </tr>
    </table>
</div>
