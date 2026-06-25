<?php

require('fpdf/fpdf.php');

if (!isset($_POST['cp'])) {
    die('Sin datos');
}

$r = json_decode($_POST['cp'], true);

/*=========================================
NORMALIZAR (individual o array)
=========================================*/
if (isset($r['nm'])) {
    $r = [$r];
}

/*=========================================
HELPER UTF-8
=========================================*/
function t($txt){
    return iconv('UTF-8','ISO-8859-1//TRANSLIT',(string)$txt);
}

/*=========================================
PDF CLASS
=========================================*/
class PDF extends FPDF
{
    function Header()
    {
        if(file_exists('../img/fn2.png')){
            $this->Image('../img/fn2.png',0,0,210,297);
        }

        $this->SetFillColor(0,72,124);
        $this->Rect(0,0,210,25,'F');

        $this->SetTextColor(255);
        $this->SetFont('Arial','B',14);
        $this->SetY(7);

        $this->Cell(
            0,
            8,
            t('KLUANE DRILLING ECUADOR S.A.'),
            0,
            1,
            'C'
        );
    }

    function Footer()
    {
        $this->SetY(-12);

        $this->SetFont('Arial','I',8);
        $this->SetTextColor(120);

        $this->Cell(
            0,
            5,
            t('Documento generado electrónicamente'),
            0,
            0,
            'C'
        );
    }
}

/*=========================================
FUNCIÓN TEMPLATE (REUTILIZABLE)
=========================================*/
function generarCarta($pdf, $item)
{
    $nm     = $item['nm'] ?? '';
    $ci     = $item['ci_p'] ?? '';
    $cg     = $item['cg'] ?? '';
    $modulo = $item['cnd'] ?? '';
    $text   = $item['text'] ?? '';
    $fecha  = $item['fc_acp'] ?? '';
    $ip     = $item['ip'] ?? '';
    $email  = $item['email'] ?? '';
    $firma  = $item['fr'] ?? '';

    $pdf->AddPage();
    $pdf->SetAutoPageBreak(true,20);

    /*=========================================
    FECHA
    =========================================*/
    $pdf->SetTextColor(80);
    $pdf->SetFont('Arial','',9);

    $pdf->SetXY(140,35);
    $pdf->Cell(65,5,t('Fecha de aceptación: '.$fecha),0,1,'R');

    /*=========================================
    TITULO
    =========================================*/
    $pdf->Ln(2);

    $pdf->SetTextColor(0);
    $pdf->SetFont('Arial','B',12);

    $pdf->Cell(0,8,t('CARTA DE ACEPTACIÓN'),0,1,'C');

    $pdf->Ln(2);

    /*=========================================
    EMPRESA
    =========================================*/
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(0,6,t('Señores'),0,1);

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,6,t('KLUANE DRILLING ECUADOR S.A.'),0,1);

    $pdf->SetFont('Arial','',12);
    $pdf->Cell(0,6,t('Presente.-'),0,1);

    $pdf->Ln(1);

    /*=========================================
    CUERPO
    =========================================*/
    $pdf->SetFont('Arial','',10);

    $texto = "

$text

Yo, $nm, portador(a) de la cédula de ciudadanía No. $ci, quien actualmente desempeña el cargo de $cg, manifiesto de manera libre, voluntaria y expresa que he leído, comprendido y aceptado las condiciones establecidas por la empresa para el uso de la plataforma digital de $modulo.
Declaro que la información registrada corresponde a mi información laboral y acepto el uso de medios electrónicos como mecanismo oficial.

En constancia firmo electrónicamente esta aceptación.
";

    $pdf->MultiCell(0,8,t($texto),0,'J');

    /*=========================================
    FIRMA
    =========================================*/
    $pdf->Ln(5);

    $pdf->SetFont('Arial','',10);
    $pdf->Cell(0,6,t('Atentamente,'),0,1);

    $pdf->Ln(15);

    if (!empty($firma) && file_exists($firma)) {
        $pdf->Image($firma, 25, $pdf->GetY()-20, 45);
    }

    $pdf->Ln(2);

    $pdf->SetDrawColor(0,72,124);
    $pdf->Line(25, $pdf->GetY(), 90, $pdf->GetY());

    $pdf->Ln(3);

    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(0,6,t($nm),0,1);

    $pdf->SetFont('Arial','',8);
    $pdf->Cell(0,5,t('C.I. '.$ci),0,1);
    $pdf->Cell(0,5,t($cg),0,1);

    /*=========================================
    AUDITORIA
    =========================================*/
    $pdf->Ln(5);

    $pdf->SetFont('Arial','',8);
    $pdf->SetFillColor(245,245,245);

    $pdf->MultiCell(
        0,
        5,
        t(
            "VALIDACIÓN ELECTRÓNICA\n\n".
            "Correo: $email\n".
            "Dirección IP: $ip\n".
            "Fecha de aceptación: $fecha"
        ),
        1,
        'L',
        true
    );
}

/*=========================================
EJECUCIÓN
=========================================*/
$pdf = new PDF();

foreach ($r as $item) {
    generarCarta($pdf, $item);
}

/*=========================================
OUTPUT
=========================================*/
$pdf->Output('I','Carta_Aceptacion.pdf');