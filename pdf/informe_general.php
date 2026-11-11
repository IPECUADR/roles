<?php

require('fpdf/fpdf.php');

/* =====================================================
   VALIDAR INFORMACIÓN
===================================================== */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido');
}

$respuesta = json_decode($_POST['respuesta'] ?? '[]', true);

if (!is_array($respuesta) || empty($respuesta)) {
    http_response_code(400);
    exit('No existen datos para generar el informe');
}

$datos = array_values(array_filter($respuesta, 'is_array'));

if (empty($datos)) {
    http_response_code(400);
    exit('Información inválida');
}

/* =====================================================
   FUNCIONES
===================================================== */

function pdf_texto($texto) {
    $texto = (string)$texto;

    if (function_exists('iconv')) {
        $convertido = iconv('UTF-8', 'windows-1252//TRANSLIT//IGNORE', $texto);
        if ($convertido !== false) {
            return $convertido;
        }
    }

    return utf8_decode($texto);
}

function numero($valor) {
    return is_numeric($valor) ? (float)$valor : null;
}

function estadisticas($valores) {

    $valores = array_values(array_filter($valores, function ($v) {
        return $v !== null;
    }));

    if (!$valores) {
        return [
            'promedio' => 0,
            'minimo' => 0,
            'maximo' => 0,
            'desviacion' => 0,
            'cantidad' => 0
        ];
    }

    $cantidad = count($valores);
    $promedio = array_sum($valores) / $cantidad;
    $suma = 0;

    foreach ($valores as $valor) {
        $suma += pow($valor - $promedio, 2);
    }

    return [
        'promedio' => $promedio,
        'minimo' => min($valores),
        'maximo' => max($valores),
        'desviacion' => sqrt($suma / $cantidad),
        'cantidad' => $cantidad
    ];
}

function clasificar_resultado($valor) {

    if ($valor >= 100 && $valor <= 125) return 'SOBRESALIENTE';
    if ($valor >= 80 && $valor < 100) return 'CUMPLE CON LAS EXPECTATIVAS';
    if ($valor >= 70 && $valor < 80) return 'NECESITA MEJORAR';
    if ($valor >= 0 && $valor < 70) return 'NO CUMPLE';

    return 'FUERA DE ESCALA';
}

/* =====================================================
   CÁLCULOS GENERALES
===================================================== */

$totalColaboradores = count($datos);

$campos = [
    'HSE' => 'TOTAL_HSE',
    'COMPETENCIAS' => 'TOTAL_COMPETENCIAS',
    'KPI' => 'TOTAL_KPI',
    'EVALUACION' => 'TOTAL_EVALUACION'
];

$resultados = [];

foreach ($campos as $nombre => $campo) {

    $valores = [];

    foreach ($datos as $fila) {
        $valor = numero($fila[$campo] ?? null);

        if ($valor !== null) {
            $valores[] = $valor;
        }
    }

    $resultados[$nombre] = estadisticas($valores);
}

/* DISTRIBUCIÓN */

$distribucion = [
    'SOBRESALIENTE' => 0,
    'CUMPLE CON LAS EXPECTATIVAS' => 0,
    'NECESITA MEJORAR' => 0,
    'NO CUMPLE' => 0,
    'FUERA DE ESCALA' => 0
];

$totalResultados = 0;

foreach ($datos as $fila) {

    $valor = numero($fila['TOTAL_EVALUACION'] ?? null);

    if ($valor !== null) {
        $distribucion[clasificar_resultado($valor)]++;
        $totalResultados++;
    }
}

/* PERCEPCIÓN: SON APORTES PONDERADOS, NO NOTAS ORIGINALES */

$percepcion = [
    'AUTOEVALUACIÓN' => [],
    'JEFATURA' => [],
    'PARES' => []
];

foreach ($datos as $fila) {

    foreach (['HSE', 'COMPETENCIAS', 'KPI'] as $componente) {

        $auto = numero($fila['AUTO_' . $componente] ?? null);
        $jefe = numero($fila['JEFE_' . $componente] ?? null);

        if ($auto !== null) {
            $percepcion['AUTOEVALUACIÓN'][] = $auto;
        }

        if ($jefe !== null) {
            $percepcion['JEFATURA'][] = $jefe;
        }
    }

    if ((int)($fila['EXISTE_PARES'] ?? 0) > 0) {

        $pares = numero($fila['PARES_COMPETENCIAS'] ?? null);

        if ($pares !== null) {
            $percepcion['PARES'][] = $pares;
        }
    }
}

$promediosPercepcion = [];

foreach ($percepcion as $tipo => $valores) {
    $promediosPercepcion[$tipo] = estadisticas($valores);
}

/* INTERPRETACIÓN GENERAL */

$promedioGeneral = $resultados['EVALUACION']['promedio'];

if ($promedioGeneral >= 100) {
    $lecturaGeneral = 'Los resultados reflejan un desempeño colectivo destacado. Es importante reconocer las prácticas que contribuyen a este resultado y promover su continuidad.';
} elseif ($promedioGeneral >= 80) {
    $lecturaGeneral = 'Los resultados muestran un nivel general favorable. El siguiente paso consiste en consolidar las fortalezas existentes y trabajar sobre oportunidades puntuales de mejora.';
} elseif ($promedioGeneral >= 70) {
    $lecturaGeneral = 'Los resultados evidencian aspectos positivos que pueden fortalecerse mediante acompañamiento, retroalimentación y objetivos de desarrollo claros.';
} else {
    $lecturaGeneral = 'Los resultados sugieren la necesidad de reforzar el acompañamiento y revisar las condiciones, recursos y prácticas que facilitan el cumplimiento de los objetivos.';
}

$componentes = [
    'HSE' => $resultados['HSE']['promedio'],
    'COMPETENCIAS' => $resultados['COMPETENCIAS']['promedio'],
    'KPI' => $resultados['KPI']['promedio']
];

arsort($componentes);
$componenteMayor = array_key_first($componentes);
$componenteMenor = array_key_last($componentes);

/* =====================================================
   CLASE PDF
   Se desactiva el salto automático.
   Las páginas se crean de forma controlada.
===================================================== */

class InformeDesempeno extends FPDF {

    function Header() {

        $this->SetFillColor(20, 40, 61);
        $this->Rect(0, 0, 210, 28, 'F');

        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 15);
        $this->SetXY(15, 7);
        $this->Cell(125, 8, pdf_texto('KLUANE DRILLING ECUADOR'));

        $this->SetFont('Arial', '', 8);
        $this->SetXY(15, 17);
        $this->Cell(150, 5, pdf_texto('GESTIÓN DEL TALENTO | VALORACIÓN DEL DESEMPEÑO 2026'));

        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(160, 10);
        $this->Cell(35, 5, pdf_texto('INFORME GENERAL'), 0, 0, 'R');

        $this->SetY(36);
    }

    function Footer() {

        $this->SetY(-15);
        $this->SetDrawColor(220, 225, 230);
        $this->Line(15, $this->GetY(), 195, $this->GetY());

        $this->SetFont('Arial', '', 8);
        $this->SetTextColor(120, 130, 140);
        $this->SetXY(15, -13);
        $this->Cell(130, 8, pdf_texto('Documento institucional | Uso interno'));
        $this->Cell(50, 8, pdf_texto('Página ') . $this->PageNo(), 0, 0, 'R');
    }

    function TituloSeccion($titulo, $subtitulo = '') {

        $this->Ln(2);
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(20, 40, 61);
        $this->Cell(180, 7, pdf_texto($titulo), 0, 1);

        if ($subtitulo !== '') {
            $this->SetFont('Arial', '', 8);
            $this->SetTextColor(110, 120, 130);
            $this->MultiCell(180, 4, pdf_texto($subtitulo));
        }

        $this->Ln(2);
    }

    function Texto($texto, $ancho = 180, $alto = 4.5) {

        $this->SetFont('Arial', '', 8.5);
        $this->SetTextColor(65, 75, 85);
        $this->MultiCell($ancho, $alto, pdf_texto($texto), 0, 'J');
        $this->Ln(1.5);
    }

    function Tarjeta($x, $y, $ancho, $titulo, $valor, $detalle) {

        $this->SetFillColor(246, 248, 250);
        $this->SetDrawColor(225, 230, 235);
        $this->Rect($x, $y, $ancho, 27, 'DF');

        $this->SetXY($x + 3, $y + 3);
        $this->SetFont('Arial', '', 7);
        $this->SetTextColor(100, 110, 120);
        $this->Cell($ancho - 6, 4, pdf_texto($titulo));

        $this->SetXY($x + 3, $y + 9);
        $this->SetFont('Arial', 'B', 14);
        $this->SetTextColor(20, 40, 61);
        $this->Cell($ancho - 6, 7, pdf_texto($valor));

        $this->SetXY($x + 3, $y + 19);
        $this->SetFont('Arial', '', 6.5);
        $this->SetTextColor(110, 120, 130);
        $this->Cell($ancho - 6, 4, pdf_texto($detalle));
    }

    function GraficaBarras($titulo, $datos, $maximo = 125) {

        $this->TituloSeccion($titulo);

        $xInicio = 55;
        $anchoMaximo = 115;
        $y = $this->GetY();

        foreach ($datos as $nombre => $valor) {

            $valor = max(0, min($maximo, (float)$valor));

            $this->SetXY(15, $y + 1);
            $this->SetFont('Arial', 'B', 8);
            $this->SetTextColor(65, 75, 85);
            $this->Cell(37, 6, pdf_texto($nombre));

            $this->SetFillColor(235, 239, 243);
            $this->Rect($xInicio, $y, $anchoMaximo, 8, 'F');

            $ancho = ($valor / $maximo) * $anchoMaximo;
            $this->SetFillColor(35, 112, 132);
            $this->Rect($xInicio, $y, $ancho, 8, 'F');

            $this->SetXY(174, $y + 1);
            $this->SetFont('Arial', 'B', 8);
            $this->SetTextColor(20, 40, 61);
            $this->Cell(20, 6, number_format($valor, 2), 0, 0, 'R');

            $y += 14;
        }

        $this->SetY($y + 1);
    }

    function GraficaDistribucion($datos, $total) {

        $this->TituloSeccion(
            'Distribución de resultados',
            'Cantidad de colaboradores según los rangos institucionales de valoración.'
        );

        $colores = [
            'SOBRESALIENTE' => [35, 112, 132],
            'CUMPLE CON LAS EXPECTATIVAS' => [75, 130, 115],
            'NECESITA MEJORAR' => [205, 155, 65],
            'NO CUMPLE' => [175, 85, 85],
            'FUERA DE ESCALA' => [130, 135, 145]
        ];

        $y = $this->GetY();
        $anchoMaximo = 105;

        foreach ($datos as $nombre => $cantidad) {

            $this->SetXY(15, $y + 1);
            $this->SetFont('Arial', '', 7);
            $this->SetTextColor(65, 75, 85);
            $this->Cell(54, 6, pdf_texto($nombre));

            $this->SetFillColor(235, 239, 243);
            $this->Rect(72, $y, $anchoMaximo, 8, 'F');

            $porcentaje = $total > 0 ? $cantidad / $total : 0;
            $ancho = $porcentaje * $anchoMaximo;
            $color = $colores[$nombre];

            $this->SetFillColor($color[0], $color[1], $color[2]);

            if ($ancho > 0) {
                $this->Rect(72, $y, $ancho, 8, 'F');
            }

            $this->SetXY(179, $y + 1);
            $this->SetFont('Arial', 'B', 7);
            $this->SetTextColor(20, 40, 61);
            $this->Cell(16, 6, $cantidad . ' (' . round($porcentaje * 100, 1) . '%)', 0, 0, 'R');

            $y += 12;
        }

        $this->SetY($y + 1);
    }

    function TablaPercepcion($datos) {

        $this->TituloSeccion(
            'Percepción del desempeño',
            'Promedios de los aportes ponderados registrados por tipo de evaluación.'
        );

        $this->SetFillColor(20, 40, 61);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 8);

        $this->Cell(80, 8, pdf_texto('TIPO DE EVALUACIÓN'), 1, 0, 'L', true);
        $this->Cell(50, 8, pdf_texto('APORTE PROMEDIO'), 1, 0, 'C', true);
        $this->Cell(50, 8, pdf_texto('REGISTROS'), 1, 1, 'C', true);

        foreach ($datos as $nombre => $estadistica) {

            $this->SetFillColor(247, 249, 251);
            $this->SetTextColor(60, 70, 80);
            $this->SetFont('Arial', '', 8);

            $this->Cell(80, 8, pdf_texto($nombre), 1, 0, 'L', true);
            $this->Cell(50, 8, number_format($estadistica['promedio'], 2), 1, 0, 'C', true);
            $this->Cell(50, 8, $estadistica['cantidad'], 1, 1, 'C', true);
        }

        $this->Ln(2);
    }

    function Recomendacion($numero, $texto) {

        $this->SetFont('Arial', 'B', 8.5);
        $this->SetTextColor(35, 112, 132);
        $this->Cell(8, 5, $numero . '.', 0, 0);

        $this->SetFont('Arial', '', 8.2);
        $this->SetTextColor(65, 75, 85);
        $this->MultiCell(172, 4.5, pdf_texto($texto));
        $this->Ln(1);
    }
}

/* =====================================================
   GENERAR DOCUMENTO: 3 PÁGINAS CONTROLADAS
===================================================== */

$pdf = new InformeDesempeno('P', 'mm', 'A4');
$pdf->SetMargins(15, 36, 15);
$pdf->SetAutoPageBreak(false);

/* ==================== PÁGINA 1 ==================== */

$pdf->AddPage();

$pdf->TituloSeccion(
    'Resumen ejecutivo',
    'Lectura organizacional de los resultados de valoración del desempeño 2026.'
);

$y = $pdf->GetY();

$pdf->Tarjeta(15, $y, 42, 'COLABORADORES', $totalColaboradores, 'Registros recibidos');
$pdf->Tarjeta(63, $y, 42, 'VALORACIÓN GENERAL', number_format($promedioGeneral, 2), 'Promedio institucional');
$pdf->Tarjeta(111, $y, 42, 'FORTALEZA', $componenteMayor, 'Mayor promedio');
$pdf->Tarjeta(159, $y, 36, 'ATENCIÓN', $componenteMenor, 'Menor promedio');

$pdf->SetY($y + 32);

$pdf->Texto(
    'La valoración del desempeño es una herramienta para reconocer contribuciones, comprender necesidades y orientar el crecimiento profesional. Sus resultados deben interpretarse como una oportunidad de conversación y mejora continua, considerando tanto los objetivos alcanzados como las condiciones que acompañan el trabajo diario.'
);

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(20, 40, 61);
$pdf->Cell(180, 6, pdf_texto('Lectura general de los resultados'), 0, 1);

$pdf->Texto($lecturaGeneral);

$pdf->GraficaBarras(
    'Valoración promedio por componente',
    [
        'HSE' => $resultados['HSE']['promedio'],
        'COMPETENCIAS' => $resultados['COMPETENCIAS']['promedio'],
        'KPI' => $resultados['KPI']['promedio']
    ]
);

$pdf->Texto(
    'La lectura por componentes permite observar diferentes dimensiones del desempeño. HSE representa la dimensión de seguridad, salud y ambiente; Competencias recoge aspectos relacionados con comportamientos y capacidades laborales; mientras que KPI refleja el cumplimiento de indicadores y objetivos. Las diferencias entre estos resultados ayudan a orientar acciones específicas de reconocimiento, acompañamiento y desarrollo.'
);

/* ==================== PÁGINA 2 ==================== */

$pdf->AddPage();

$pdf->GraficaDistribucion($distribucion, $totalResultados);

$pdf->Texto(
    'La distribución muestra cómo se agrupan los resultados dentro de los rangos institucionales. Esta lectura complementa el promedio general, ya que dos grupos pueden alcanzar un promedio similar y presentar distribuciones muy diferentes. Por ello, es importante considerar tanto la tendencia general como la cantidad de personas en cada rango.'
);

$pdf->TablaPercepcion($promediosPercepcion);

$pdf->Texto(
    'La autoevaluación aporta la perspectiva que cada colaborador tiene sobre su propio desempeño. La valoración de jefatura incorpora la observación de resultados, responsabilidades y comportamientos en el contexto laboral. La evaluación de pares, cuando está disponible, añade una perspectiva de colaboración e interacción cotidiana.'
);

$pdf->Texto(
    'La comparación entre perspectivas no debe entenderse como una competencia entre evaluadores. Las diferencias pueden convertirse en una oportunidad para dialogar sobre expectativas, evidencias, fortalezas y aspectos que requieren mayor claridad o acompañamiento.'
);

/* ==================== PÁGINA 3 ==================== */

$pdf->AddPage();

$pdf->TituloSeccion(
    'Consistencia de los resultados',
    'Indicadores estadísticos para comprender la variabilidad del desempeño.'
);

foreach (['HSE', 'COMPETENCIAS', 'KPI', 'EVALUACION'] as $componente) {

    $e = $resultados[$componente];

    $pdf->SetFont('Arial', 'B', 8.5);
    $pdf->SetTextColor(20, 40, 61);
    $pdf->Cell(180, 5, pdf_texto($componente), 0, 1);

    $pdf->SetFont('Arial', '', 8);
    $pdf->SetTextColor(65, 75, 85);

    $pdf->MultiCell(
        180,
        4.5,
        pdf_texto(
            'Promedio: ' . number_format($e['promedio'], 2)
            . ' | Mínimo: ' . number_format($e['minimo'], 2)
            . ' | Máximo: ' . number_format($e['maximo'], 2)
            . ' | Desviación estándar: ' . number_format($e['desviacion'], 2)
            . ' | Registros: ' . $e['cantidad']
        )
    );

    $pdf->Ln(1);
}

$pdf->Texto(
    'La desviación estándar expresa qué tan dispersos se encuentran los resultados respecto de su promedio. Una dispersión mayor indica que los resultados son más diversos dentro del grupo; una dispersión menor refleja resultados más concentrados. Este indicador no explica por sí solo las causas de las diferencias, por lo que debe complementarse con conversaciones y contexto de cada área.'
);

$pdf->TituloSeccion(
    'Recomendaciones organizacionales',
    'Acciones que pueden transformar los resultados en oportunidades de crecimiento.'
);

$recomendaciones = [
    'Fortalecer la retroalimentación: promover conversaciones periódicas entre líderes y colaboradores, basadas en evidencias y expectativas claras.',
    'Reconocer las fortalezas: identificar prácticas y comportamientos positivos que puedan compartirse y replicarse dentro de los equipos.',
    'Orientar el desarrollo: establecer acciones concretas de capacitación, acompañamiento y mejora según las necesidades identificadas en cada componente.',
    'Alinear expectativas: asegurar que los objetivos, indicadores y responsabilidades sean comprendidos de manera consistente por líderes y colaboradores.',
    'Dar seguimiento: convertir los resultados de la evaluación en compromisos medibles, revisables y acompañados durante el siguiente periodo.'
];

foreach ($recomendaciones as $i => $recomendacion) {
    $pdf->Recomendacion($i + 1, $recomendacion);
}

/* CIERRE */

$y = $pdf->GetY() + 2;

$pdf->SetFillColor(240, 245, 247);
$pdf->SetDrawColor(220, 230, 235);
$pdf->Rect(15, $y, 180, 25, 'DF');

$pdf->SetXY(20, $y + 3);
$pdf->SetFont('Arial', 'B', 9.5);
$pdf->SetTextColor(20, 40, 61);
$pdf->Cell(170, 5, pdf_texto('El desempeño también se construye en equipo'));

$pdf->SetXY(20, $y + 9);
$pdf->SetFont('Arial', '', 8);
$pdf->SetTextColor(65, 75, 85);
$pdf->MultiCell(
    170,
    4.2,
    pdf_texto(
        'Cada resultado representa una oportunidad para reconocer el trabajo, fortalecer las relaciones profesionales y construir mejores condiciones para alcanzar los objetivos. La mejora continua comienza cuando la evaluación se convierte en una conversación que impulsa el crecimiento.'
    )
);

/* =====================================================
   SALIDA PDF
===================================================== */

if (ob_get_length()) {
    ob_end_clean();
}

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="Informe_Desempeno_2026.pdf"');

$pdf->Output('I', 'Informe_Desempeno_2026.pdf');
exit;
?>
