<?php
require('fpdf/fpdf.php');

if (!isset($_POST['cp'])) die('Sin datos');

$r = json_decode($_POST['cp'], true);

/* ========= SI VIENE 1 SOLO REGISTRO ========= */
if(isset($r[0])){
    $datos = $r;
}else{
    $datos = [$r];
}

/* ========= UTF-8 ========= */
function t($txt){
    return iconv('UTF-8','ISO-8859-1//TRANSLIT',(string)$txt);
}

/* ========= PDF CLASS ========= */
class PDF extends FPDF {

    function Header(){

        $fondo = '../img/fn2.png';

        if (file_exists($fondo)) {
            $this->Image($fondo, 0, 0, 297, 210);
        }

        $this->SetFillColor(0,102,153);
        $this->Rect(0,0,297,20,'F');

        $this->SetTextColor(255);
        $this->SetFont('Arial','B',13);
        $this->SetY(6);
        $this->Cell(0,6,t('KLUANE DRILLING ECUADOR S.A.'),0,1,'C');

        $this->SetFont('Arial','',9);
        $this->Cell(0,5,t('ROL DE PAGOS'),0,1,'C');

        $this->Ln(6);
        $this->SetTextColor(0);
    }

    function titulo($x,$y,$w,$txt){

        $this->SetXY($x,$y);

        $this->SetFillColor(230,235,240);

        $this->SetFont('Arial','B',8.5);

        $this->Cell($w,6,t($txt),0,1,'L',true);
    }

    function fila($x,$txt,$val){

        $this->SetX($x);

        $this->SetFont('Arial','',7.8);

        $this->Cell(90,4.6,t($txt),'B',0,'L');

        $this->Cell(
            40,
            4.6,
            '$ '.number_format((float)$val,2),
            'B',
            1,
            'R'
        );
    }

    function total($x,$txt,$val){

        $this->SetX($x);

        $this->SetFont('Arial','B',9);

        $this->SetFillColor(220,230,240);

        $this->Cell(90,6,t($txt),0,0,'L',true);

        $this->Cell(
            40,
            6,
            '$ '.number_format((float)$val,2),
            0,
            1,
            'R',
            true
        );
    }
}

/* ========= INIT ========= */
$pdf = new PDF('L','mm','A4');

/* ========= RECORRER REGISTROS ========= */
foreach($datos as $item){

$pdf->AddPage();

/* ========= DATOS ========= */

$pdf->SetFont('Arial','',8.5);

/* Fila 1 */
$pdf->SetXY(14,23);

$pdf->Cell(20,5,t('Nombre:'),0,0);

$pdf->SetFont('Arial','B',8.5);

$pdf->Cell(
    85,
    5,
    t($item['nom_p'].' '.$item['ap_p']),
    0,
    0
);

$pdf->SetFont('Arial','',8.5);

$pdf->Cell(18,5,t('Cédula:'),0,0);

$pdf->SetFont('Arial','B',8.5);

$pdf->Cell(55,5,t($item['ci_p']),0,0);

$pdf->SetFont('Arial','',8.5);

$pdf->Cell(16,5,t('Cargo:'),0,0);

$pdf->SetFont('Arial','B',8.5);

$pdf->Cell(45,5,t($item['cargo_cg']),0,1);

/* Fila 2 */
$pdf->SetXY(14,30);

$pdf->SetFont('Arial','',8.5);

$pdf->Cell(20,5,t('MES:'),0,0);

$pdf->SetFont('Arial','B',8.5);

$pdf->Cell(85,5,t($item['mes']),0,0);

$pdf->SetFont('Arial','',8.5);

$pdf->Cell(18,5,t('Días:'),0,0);

$pdf->SetFont('Arial','B',8.5);

$pdf->Cell(55,5,t($item['dias']),0,0);

$pdf->SetFont('Arial','',8.5);

$pdf->Cell(22,5,t('Forma Pago:'),0,0);

$pdf->SetFont('Arial','B',8.5);

$pdf->Cell(45,5,t($item['forma_pago']),0,1);

/* ========= INGRESOS ========= */

$y = 40;

$pdf->titulo(10,$y,130,'INGRESOS');

$pdf->SetY($y+6);

$pdf->fila(10,'Sueldo Básico',$item['sueldo_basico']);
$pdf->fila(10,'Sueldo Mensual',$item['sueldo_mensual']);
$pdf->fila(10,'Horas Extras',$item['horas_extra']);
$pdf->fila(10,'Horas Adicionales',$item['horas_adicionales']);
$pdf->fila(10,'Jornada Nocturna',$item['jornada_nocturna']);
$pdf->fila(10,'Subsidio 50%',$item['sub_reposo_50']);
$pdf->fila(10,'Subsidio 25%',$item['sub_reposo_25']);
$pdf->fila(10,'Subsidio 75%',$item['sub_reposo_75']);
$pdf->fila(10,'Bonos Avance',$item['bn_avance_obra']);
$pdf->fila(10,'Bonos Cumplimiento',$item['bn_cumplimiento']);
$pdf->fila(10,'Bonos Producción',$item['bn_produccion']);
$pdf->fila(10,'Bonos Navidad',$item['bn_navidad']);
$pdf->fila(10,'Vacaciones',$item['vacaciones']);
$pdf->fila(10,'Otros Ajustes',$item['ot_ing_ajust_sl']);
$pdf->fila(10,'Otros Ingresos',$item['ot_ingresos']);

$pdf->total(
    10,
    'TOTAL INGRESOS',
    $item['total_remuneracion']
);

/* ========= DESCUENTOS ========= */

$pdf->titulo(150,$y,130,'DESCUENTOS');

$pdf->SetXY(150,$y+6);

$pdf->fila(150,'IESS',$item['aportes_iess']);
$pdf->fila(150,'Impuesto Renta',$item['imp_renta']);
$pdf->fila(150,'Préstamo Quirografario',$item['prestamo_quirografario']);
$pdf->fila(150,'Préstamo Hipotecario',$item['prestamo_hipotecario']);
$pdf->fila(150,'Préstamo Empresa',$item['prestamo_empresa']);
$pdf->fila(150,'Anticipos',$item['anticipo_sueldo']);
$pdf->fila(150,'Otros Descuentos',$item['otrs_des_contable']);
$pdf->fila(150,'Pensión Alimenticia',$item['pension_alimentos']);
$pdf->fila(150,'Salud Cónyuge',$item['ext_salud_conyuge']);
$pdf->fila(150,'Multas',$item['multas']);
$pdf->fila(150,'Ajustes',$item['des_ajuste_suledo']);
$pdf->fila(150,'Subsidio IESS 75%',$item['des_subcidio_iess_75']);

$pdf->total(
    150,
    'TOTAL DESCUENTOS',
    $item['total_descuentos']
);

/* ========= BENEFICIOS ========= */

$y2 = 123;

$pdf->titulo(10,$y2,130,'BENEFICIOS Y OTROS');

$pdf->SetY($y2+6);

$pdf->fila(10,'Transporte',$item['transporte']);
$pdf->fila(10,'Devoluciones',$item['devoluciones']);
$pdf->fila(10,'Bono',$item['bono']);
$pdf->fila(10,'Votaciones',$item['votaciones']);
$pdf->fila(10,'Fondo Reserva Pendiente',$item['fondo_reserva_p']);
$pdf->fila(10,'Fondo Reserva',$item['fon_reserva']);
$pdf->fila(10,'Décimo Tercero',$item['decimo_t']);
$pdf->fila(10,'Décimo Cuarto',$item['decim_c']);

$pdf->total(
    10,
    'TOTAL BENEFICIOS',
    $item['total_beneficios']
);

/* ========= LIQUIDO ========= */

$pdf->SetXY(150,130);

$pdf->SetFillColor(0,102,153);

$pdf->SetTextColor(255);

$pdf->SetFont('Arial','B',13);

$pdf->Cell(
    130,
    12,
    t('LÍQUIDO A PAGAR').'  $ '.number_format($item['liquido_pagar'],2),
    0,
    1,
    'C',
    true
);

$pdf->SetTextColor(0);

/* ========= FIRMAS ========= */

$pdf->Ln(20);

$xFirmas = 150;

$pdf->SetX($xFirmas);

$wFirma = 42;
$esp    = 2;
$wImg   = 30;
$hImg   = 10;

$yImg = $pdf->GetY();

$qrPath = '../qr_vt/qr6.png';

if (file_exists($qrPath)) {

    $pdf->Image(
        $qrPath,
        $xFirmas + $wFirma + $esp + (($wFirma - $wImg) / 2),
        $yImg,
        $wImg
    );

}

$pdf->Ln($hImg + 4);

$pdf->SetX($xFirmas);

$pdf->SetFont('Arial','B',7);

$pdf->Cell(
    $wFirma,
    6,
    t(date('d/m/Y H:i')),
    0,
    0,
    'C'
);

$pdf->Cell($esp,6,'',0,0);

}

/* ========= OUTPUT ========= */

$pdf->Output('I','ROL_PAGOS.pdf');
?>