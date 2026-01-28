<?php

namespace App\PDF;

use TCPDF;
class CustomPDFAcuse extends TCPDF
{
    public function Header()
    {
        $this->SetTopMargin(19);
        $this->SetY(30);

        $margenes = $this->getMargins();
        $anchoPagina = $this->getPageWidth();
        $alturaLogo = 13;

        $this->Image(
            public_path('images/Logo ITE.png'),
            $margenes['left'],
            5,
            0,
            $alturaLogo
        );

        $anchoLogoDerecho = 25;

        $this->Image(
            public_path('images/siibien_colores.png'),
            $anchoPagina - $margenes['right'] - $anchoLogoDerecho,
            5,
            0,
            $alturaLogo
        );

        // Mantienes esto para la primera página
        $this->Ln(18);
    }

    public function Footer()
    {
        $this->SetY(-15);

        $this->SetFont('helvetica', '', 8);

        $texto = '
        <span style="color:#9c2348; font-weight:bold;">
            DIRECCIÓN DE LA INSTANCIA TÉCNICA DE EVALUACIÓN
        </span><br>

        <span style="color:#ad8e65;">
            Ciudad Administrativa “Benemérito de las Américas”, 
            Edificio 3 “Andrés Henestrosa”, Nivel 1
        </span><br>

        <span style="color:#b09268;">
            Carretera Oaxaca-Istmo Km. 11.5 Tlalixtac de Cabrera, Oaxaca C.P. 68270
        </span>
    ';

        $this->writeHTMLCell(
            0,
            0,
            '',
            '',
            $texto,
            0,
            0,
            false,
            true,
            'C'
        );
    }

}