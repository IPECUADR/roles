<?php

require_once __DIR__ . '/fpdf/fpdf.php';

/* =====================================================
   1. VALIDACIÓN Y RECEPCIÓN
===================================================== */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido');
}

function recibir_json($campo) {

    $valor = json_decode($_POST[$campo] ?? 'null', true);

    return is_array($valor) ? $valor : [];
}

function obtener_registros($datos) {

    if (isset($datos['data']) && is_array($datos['data'])) {
        return $datos['data'];
    }

    return array_is_list($datos) ? $datos : [];
}

$hse = obtener_registros(recibir_json('hse'));
$competencias = obtener_registros(recibir_json('competencias'));
$kpi = obtener_registros(recibir_json('kpi'));

$resultados = recibir_json('resultados');

if (
    empty($hse) &&
    empty($competencias) &&
    empty($kpi) &&
    empty($resultados)
) {
    http_response_code(400);
    exit('No existen registros para generar el informe');
}

/* =====================================================
   2. FUNCIONES AUXILIARES
===================================================== */

function pdf_texto($texto) {

    $texto = (string)$texto;

    if (function_exists('iconv')) {

        $convertido = iconv(
            'UTF-8',
            'windows-1252//TRANSLIT//IGNORE',
            $texto
        );

        if ($convertido !== false) {
            return $convertido;
        }
    }

    return utf8_decode($texto);
}

function numero($valor) {

    return is_numeric($valor)
        ? (float)$valor
        : null;
}

function formato($valor) {

    return $valor === null
        ? 'N/D'
        : number_format($valor, 2);
}

function clasificar($valor) {

    if ($valor === null) {
        return 'SIN CLASIFICAR';
    }

    if ($valor >= 100 && $valor <= 125) {
        return 'SOBRESALIENTE';
    }

    if ($valor >= 80 && $valor < 100) {
        return 'CUMPLE CON LAS EXPECTATIVAS';
    }

    if ($valor >= 70 && $valor < 80) {
        return 'NECESITA MEJORAR';
    }

    if ($valor >= 0 && $valor < 70) {
        return 'NO CUMPLE';
    }

    return 'SIN CLASIFICAR';
}

function interpretar($valor) {

    if ($valor >= 100) {

        return 'El resultado refleja un desempeño sobresaliente. Se recomienda reconocer las contribuciones alcanzadas, mantener las buenas prácticas e identificar oportunidades para compartir conocimientos y experiencias con el equipo.';

    } elseif ($valor >= 80) {

        return 'El resultado refleja un desempeño favorable y un cumplimiento adecuado de las expectativas del puesto. Es importante consolidar las fortalezas identificadas y continuar desarrollando las capacidades profesionales.';

    } elseif ($valor >= 70) {

        return 'El resultado evidencia oportunidades de fortalecimiento. Se recomienda establecer compromisos de mejora, acompañamiento y seguimiento para consolidar el cumplimiento de las responsabilidades.';

    }

    return 'El resultado requiere especial atención y acompañamiento. Es recomendable revisar las condiciones de trabajo, las expectativas del puesto y establecer un plan de acción con objetivos claros y seguimiento periódico.';
}

function analizar_componente($nombre, $auto, $jefe) {

    if ($auto === null || $jefe === null) {
        return 'No se dispone de información suficiente para comparar las perspectivas de evaluación.';
    }

    $diferencia = abs($auto - $jefe);

    if ($diferencia <= 5) {

        return 'En ' . $nombre . ', existe una percepción relativamente alineada entre la autoevaluación y la jefatura. Esta coincidencia favorece la claridad sobre las responsabilidades y los resultados alcanzados.';

    } elseif ($auto > $jefe) {

        return 'En ' . $nombre . ', la autoevaluación presenta una valoración superior a la observada por la jefatura. Se recomienda dialogar sobre las evidencias, expectativas y oportunidades de alineación.';

    }

    return 'En ' . $nombre . ', la valoración de la jefatura es superior a la autoevaluación. Esta diferencia puede convertirse en una oportunidad para reconocer fortalezas que el propio colaborador podría no estar identificando.';
}

/* =====================================================
   3. CLASE PDF
===================================================== */

class InformeDesempeno extends FPDF {

    function Header() {

        $this->SetFillColor(23, 54, 93);
        $this->Rect(0, 0, 210, 27, 'F');

        $logo = __DIR__ . '/logo.png';

        if (file_exists($logo)) {
            $this->Image($logo, 15, 5, 18);
        }

        $this->SetTextColor(255, 255, 255);

        $this->SetFont('Arial', 'B', 14);
        $this->SetXY(38, 6);

        $this->Cell(
            115,
            7,
            pdf_texto('KLUANE DRILLING ECUADOR')
        );

        $this->SetFont('Arial', '', 7.5);
        $this->SetXY(38, 15);

        $this->Cell(
            125,
            5,
            pdf_texto('GESTIÓN DEL TALENTO | DESEMPEÑO 2026')
        );

        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(155, 10);

        $this->Cell(
            40,
            5,
            pdf_texto('INFORME INDIVIDUAL'),
            0,
            0,
            'R'
        );

        $this->SetY(34);
    }

    function Footer() {

        $this->SetY(-15);

        $this->SetDrawColor(220, 225, 230);

        $this->Line(
            15,
            $this->GetY(),
            195,
            $this->GetY()
        );

        $this->SetFont('Arial', '', 7);
        $this->SetTextColor(130, 140, 150);

        $this->SetXY(15, -12);

        $this->Cell(
            120,
            6,
            pdf_texto('Documento confidencial | Uso institucional')
        );

        $this->Cell(
            60,
            6,
            pdf_texto('Página ') . $this->PageNo(),
            0,
            0,
            'R'
        );
    }

    /* =================================================
       CONTROL DE ESPACIO
    ================================================= */

    function VerificarEspacio($alto) {

        if ($this->GetY() + $alto > 270) {
            $this->AddPage();
        }
    }

    /* =================================================
       TÍTULOS
    ================================================= */

    function Titulo($titulo, $subtitulo = '') {

        $this->Ln(2);

        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(23, 54, 93);

        $this->Cell(
            180,
            7,
            pdf_texto($titulo),
            0,
            1
        );

        if ($subtitulo !== '') {

            $this->SetFont('Arial', '', 8);
            $this->SetTextColor(110, 120, 130);

            $this->MultiCell(
                180,
                4,
                pdf_texto($subtitulo)
            );
        }

        $this->Ln(3);
    }

    function Texto($texto) {

        $this->SetFont('Arial', '', 8.5);
        $this->SetTextColor(65, 75, 85);

        $this->MultiCell(
            180,
            4.5,
            pdf_texto($texto),
            0,
            'J'
        );

        $this->Ln(2);
    }

    /* =================================================
       TARJETAS
    ================================================= */

    function Tarjeta($x, $y, $ancho, $titulo, $valor, $detalle) {

        $this->SetFillColor(246, 248, 250);
        $this->SetDrawColor(225, 230, 235);

        $this->Rect(
            $x,
            $y,
            $ancho,
            27,
            'DF'
        );

        $this->SetXY($x + 3, $y + 3);

        $this->SetFont('Arial', '', 7);
        $this->SetTextColor(100, 110, 120);

        $this->Cell(
            $ancho - 6,
            4,
            pdf_texto($titulo)
        );

        $this->SetXY($x + 3, $y + 9);

        $this->SetFont('Arial', 'B', 14);
        $this->SetTextColor(23, 54, 93);

        $this->Cell(
            $ancho - 6,
            7,
            pdf_texto($valor)
        );

        $this->SetXY($x + 3, $y + 19);

        $this->SetFont('Arial', '', 6.5);
        $this->SetTextColor(110, 120, 130);

        $this->Cell(
            $ancho - 6,
            4,
            pdf_texto($detalle)
        );
    }

    /* =================================================
       GRÁFICAS
    ================================================= */

    function GraficaComparativa($titulo, $auto, $jefe) {

        $this->Titulo($titulo);

        $datos = [
            'Autoevaluación' => $auto,
            'Jefatura' => $jefe
        ];

        $colores = [
            'Autoevaluación' => [45, 105, 170],
            'Jefatura' => [45, 135, 105]
        ];

        foreach ($datos as $nombre => $valor) {

            $y = $this->GetY();

            $this->SetFont('Arial', '', 8);
            $this->SetTextColor(65, 75, 85);

            $this->SetXY(15, $y);

            $this->Cell(
                35,
                7,
                pdf_texto($nombre)
            );

            $this->SetFillColor(235, 239, 243);

            $this->Rect(
                53,
                $y + 1,
                112,
                5,
                'F'
            );

            if ($valor !== null) {

                $valorGrafica = max(0, min(100, $valor));

                $ancho = ($valorGrafica / 100) * 112;

                $color = $colores[$nombre];

                $this->SetFillColor(
                    $color[0],
                    $color[1],
                    $color[2]
                );

                if ($ancho > 0) {

                    $this->Rect(
                        53,
                        $y + 1,
                        $ancho,
                        5,
                        'F'
                    );
                }
            }

            $this->SetXY(170, $y);

            $this->SetFont('Arial', 'B', 8);
            $this->SetTextColor(23, 54, 93);

            $this->Cell(
                25,
                7,
                formato($valor),
                0,
                1,
                'R'
            );
        }

        $this->Ln(3);
    }

    /* =================================================
       TABLAS DINÁMICAS
    ================================================= */

    function TituloTabla($mostrarPares = false) {

        $this->SetFillColor(23, 54, 93);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 7.5);

        if ($mostrarPares) {

            $this->Cell(112, 8, pdf_texto('PREGUNTA / INDICADOR'), 1, 0, 'L', true);
            $this->Cell(23, 8, pdf_texto('AUTOEVAL.'), 1, 0, 'C', true);
            $this->Cell(23, 8, pdf_texto('JEFATURA'), 1, 0, 'C', true);
            $this->Cell(22, 8, pdf_texto('PARES'), 1, 1, 'C', true);

        } else {

            $this->Cell(134, 8, pdf_texto('PREGUNTA / INDICADOR'), 1, 0, 'L', true);
            $this->Cell(23, 8, pdf_texto('AUTOEVAL.'), 1, 0, 'C', true);
            $this->Cell(23, 8, pdf_texto('JEFATURA'), 1, 1, 'C', true);
        }
    }

    function TablaPreguntas($titulo, $datos, $componente) {

        if (empty($datos)) {
            return;
        }

        $mostrarPares = false;

        foreach ($datos as $fila) {

            if (
                isset($fila['KPI_PARES']) &&
                is_numeric($fila['KPI_PARES'])
            ) {
                $mostrarPares = true;
                break;
            }
        }

        $anchoPregunta = $mostrarPares ? 112 : 134;

        $this->Titulo(
            $titulo,
            'Detalle de las valoraciones registradas por pregunta.'
        );

        $this->TituloTabla($mostrarPares);

        foreach ($datos as $fila) {

            $pregunta = $fila['p'] ?? 'Pregunta sin descripción';

            $auto = numero(
                $fila['KPI_AUTO_EVALUACION'] ?? null
            );

            $jefe = numero(
                $fila['KPI_JEFE'] ?? null
            );

            $pares = numero(
                $fila['KPI_PARES'] ?? null
            );

            $lineas = $this->NbLines(
                $anchoPregunta - 4,
                pdf_texto($pregunta)
            );

            $alto = max(12, ($lineas * 4) + 4);

            if ($this->GetY() + $alto > 270) {

                $this->AddPage();

                $this->SetFont('Arial', 'B', 9);
                $this->SetTextColor(23, 54, 93);

                $this->Cell(
                    180,
                    7,
                    pdf_texto($titulo . ' | Continuación'),
                    0,
                    1
                );

                $this->TituloTabla($mostrarPares);
            }

            $x = 15;
            $y = $this->GetY();

            $this->SetFillColor(248, 249, 251);
            $this->SetDrawColor(225, 230, 235);

            $this->Rect(
                $x,
                $y,
                $anchoPregunta,
                $alto,
                'DF'
            );

            $this->SetXY($x + 2, $y + 2);

            $this->SetFont('Arial', '', 7.5);
            $this->SetTextColor(60, 70, 80);

            $this->MultiCell(
                $anchoPregunta - 4,
                4,
                pdf_texto($pregunta)
            );

            $this->SetXY($x + $anchoPregunta, $y);

            $this->SetFont('Arial', 'B', 8);
            $this->SetTextColor(45, 105, 170);

            $this->Cell(
                23,
                $alto,
                formato($auto),
                1,
                0,
                'C'
            );

            $this->SetTextColor(45, 135, 105);

            $this->Cell(
                23,
                $alto,
                formato($jefe),
                1,
                0,
                'C'
            );

            if ($mostrarPares) {

                $this->SetTextColor(180, 125, 65);

                $this->Cell(
                    22,
                    $alto,
                    formato($pares),
                    1,
                    0,
                    'C'
                );
            }

            $this->Ln($alto);
        }

        $this->Ln(3);
    }

    /* =================================================
       CÁLCULO DE LÍNEAS
    ================================================= */

    function NbLines($w, $txt) {

        $cw = &$this->CurrentFont['cw'];

        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }

        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;

        $s = str_replace("\r", '', $txt);

        $nb = strlen($s);

        if ($nb > 0 && $s[$nb - 1] == "\n") {
            $nb--;
        }

        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;

        while ($i < $nb) {

            $c = $s[$i];

            if ($c == "\n") {

                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;

                continue;
            }

            if ($c == ' ') {
                $sep = $i;
            }

            $l += $cw[$c] ?? 0;

            if ($l > $wmax) {

                if ($sep == -1) {

                    if ($i == $j) {
                        $i++;
                    }

                } else {

                    $i = $sep + 1;
                }

                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;

            } else {

                $i++;
            }
        }

        return $nl;
    }

    /* =================================================
       FIRMAS PERSONALIZADAS
    ================================================= */

    function Firmas($colaborador, $evaluador, $resultado, $categoria, $existePares) {

        if ($this->GetY() + 100 > 270) {
            $this->AddPage();
        }

        $this->Titulo(
            'Validación del informe',
            'Constancia de revisión y socialización de los resultados de la valoración del desempeño.'
        );

        $this->SetFont('Arial', '', 8);
        $this->SetTextColor(65, 75, 85);

        $this->MultiCell(
            180,
            5,
            pdf_texto(
                'Mediante las firmas que constan a continuación, el colaborador y su evaluador dejan constancia de la socialización y revisión de los resultados presentados en este informe.'
            ),
            0,
            'J'
        );

        $this->Ln(5);

        // Resumen de validación
        $yTarjeta = $this->GetY();

        $this->SetFillColor(240, 244, 247);

        $this->Rect(
            15,
            $yTarjeta,
            180,
            24,
            'F'
        );

        $this->SetXY(19, $yTarjeta + 3);

        $this->SetFont('Arial', 'B', 8);
        $this->SetTextColor(23, 54, 93);

        $this->Cell(
            85,
            5,
            pdf_texto('RESULTADO FINAL')
        );

        $this->Cell(
            85,
            5,
            pdf_texto('CLASIFICACIÓN')
        );

        $this->SetXY(19, $yTarjeta + 9);

        $this->SetFont('Arial', 'B', 12);

        $this->Cell(
            85,
            7,
            formato($resultado) . ' / 125'
        );

        $this->SetFont('Arial', '', 8);

        $this->Cell(
            85,
            7,
            pdf_texto($categoria)
        );

        $this->SetXY(19, $yTarjeta + 17);

        $this->SetFont('Arial', '', 7);
        $this->SetTextColor(100, 110, 120);

        $this->Cell(
            170,
            4,
            pdf_texto(
                'Evaluación de pares: ' .
                ($existePares ? 'Participaron evaluadores pares' : 'No aplica')
            )
        );

        $this->SetY($yTarjeta + 34);

        $y = $this->GetY();

        // Firma del evaluador
        $this->SetDrawColor(100, 110, 120);

        $this->Line(20, $y, 92, $y);

        $this->SetXY(20, $y + 3);

        $this->SetFont('Arial', 'B', 8);
        $this->SetTextColor(23, 54, 93);

        $this->MultiCell(
            72,
            5,
            pdf_texto($evaluador !== '' ? $evaluador : 'Evaluador'),
            0,
            'C'
        );

        // Espacio para el cargo del evaluador
        $this->SetXY(20, $y + 11);

        $this->SetFont('Arial', '', 7.5);
        $this->SetTextColor(100, 110, 120);

        $this->Cell(
            72,
            5,
            pdf_texto('Cargo: _______________________'),
            0,
            1,
            'C'
        );

        $this->SetXY(20, $y + 18);

        $this->SetFont('Arial', 'B', 8);
        $this->SetTextColor(23, 54, 93);

        $this->Cell(
            72,
            5,
            pdf_texto('EVALUADOR / JEFE INMEDIATO'),
            0,
            1,
            'C'
        );

        // Firma del colaborador
        $this->Line(118, $y, 190, $y);

        $this->SetXY(118, $y + 3);

        $this->SetFont('Arial', 'B', 8);
        $this->SetTextColor(23, 54, 93);

        $this->MultiCell(
            72,
            5,
            pdf_texto($colaborador !== '' ? $colaborador : 'Colaborador'),
            0,
            'C'
        );

        // Espacio para el cargo del colaborador
        $this->SetXY(118, $y + 11);

        $this->SetFont('Arial', '', 7.5);
        $this->SetTextColor(100, 110, 120);

        $this->Cell(
            72,
            5,
            pdf_texto('Cargo: _______________________'),
            0,
            1,
            'C'
        );

        $this->SetXY(118, $y + 18);

        $this->SetFont('Arial', 'B', 8);
        $this->SetTextColor(23, 54, 93);

        $this->Cell(
            72,
            5,
            pdf_texto('COLABORADOR'),
            0,
            1,
            'C'
        );

        // Fecha
        $this->SetXY(15, $y + 29);

        $this->SetFont('Arial', '', 8);
        $this->SetTextColor(100, 110, 120);

        $this->Cell(
            180,
            6,
            pdf_texto('Fecha de socialización: __________________________________'),
            0,
            1
        );

        // Mensaje final
        $this->SetXY(15, $y + 43);

        $this->SetFillColor(240, 244, 247);

        $this->Rect(
            15,
            $y + 43,
            180,
            24,
            'F'
        );

        $this->SetXY(20, $y + 46);

        $this->SetFont('Arial', 'B', 8.5);
        $this->SetTextColor(23, 54, 93);

        $this->Cell(
            170,
            5,
            pdf_texto('El desarrollo profesional es un compromiso compartido')
        );

        $this->SetXY(20, $y + 52);

        $this->SetFont('Arial', '', 7.5);
        $this->SetTextColor(65, 75, 85);

        $this->MultiCell(
            170,
            4,
            pdf_texto(
                'Los resultados constituyen una oportunidad para reconocer fortalezas, establecer compromisos y continuar construyendo un entorno de mejora continua.'
            )
        );

        $this->SetY($y + 71);
    }
}

/* =====================================================
   4. RESULTADOS INDIVIDUALES
===================================================== */

$valorHSE = numero($resultados['TOTAL_HSE'] ?? null);

$valorCompetencias = numero(
    $resultados['TOTAL_COMPETENCIAS'] ?? null
);

$valorKPI = numero($resultados['TOTAL_KPI'] ?? null);

$valorFinal = numero(
    $resultados['TOTAL_EVALUACION'] ?? null
);

$autoHSE = numero($resultados['AUTO_HSE_100'] ?? null);
$jefeHSE = numero($resultados['JEFE_HSE_100'] ?? null);

$autoCompetencias = numero(
    $resultados['AUTO_COMPETENCIAS_100'] ?? null
);

$jefeCompetencias = numero(
    $resultados['JEFE_COMPETENCIAS_100'] ?? null
);

$autoKPI = numero($resultados['AUTO_KPI_100'] ?? null);
$jefeKPI = numero($resultados['JEFE_KPI_100'] ?? null);

// NUEVOS DATOS DE LA CONSULTA

$nombreColaborador = trim(
    ($resultados['nm'] ?? '') . ' ' .
    ($resultados['ap'] ?? '')
);

$nombreEvaluador = trim(
    ($resultados['nom_jefe'] ?? '') . ' ' .
    ($resultados['ap_jefe'] ?? '')
);

$existePares = (int)($resultados['EXISTE_PARES'] ?? 0);

$categoria = clasificar($valorFinal);

/* =====================================================
   5. ANÁLISIS INDIVIDUAL
===================================================== */

$componentes = [
    'HSE' => $hse,
    'COMPETENCIAS' => $competencias,
    'KPI' => $kpi
];

$fortalezas = [];
$oportunidades = [];

foreach ($componentes as $nombre => $datos) {

    foreach ($datos as $fila) {

        $jefe = numero(
            $fila['KPI_JEFE'] ?? null
        );

        if ($jefe !== null) {

            if ($jefe >= 95) {

                $fortalezas[] = [
                    'componente' => $nombre,
                    'pregunta' => $fila['p'] ?? '',
                    'nota' => $jefe
                ];

            } elseif ($jefe < 80) {

                $oportunidades[] = [
                    'componente' => $nombre,
                    'pregunta' => $fila['p'] ?? '',
                    'nota' => $jefe
                ];
            }
        }
    }
}

usort($fortalezas, function($a, $b) {
    return $b['nota'] <=> $a['nota'];
});

usort($oportunidades, function($a, $b) {
    return $a['nota'] <=> $b['nota'];
});

/* =====================================================
   6. GENERACIÓN DEL INFORME
===================================================== */

$pdf = new InformeDesempeno('P', 'mm', 'A4');

$pdf->SetMargins(15, 34, 15);
$pdf->SetAutoPageBreak(true, 20);

$pdf->AddPage();

/* =====================================================
   RESUMEN EJECUTIVO
===================================================== */

$pdf->Titulo(
    'Resumen ejecutivo',
    'Valoración individual del desempeño correspondiente al periodo 2026.'
);

$y = $pdf->GetY();

$pdf->Tarjeta(15, $y, 42, 'HSE', formato($valorHSE), 'Resultado del componente');
$pdf->Tarjeta(63, $y, 42, 'COMPETENCIAS', formato($valorCompetencias), 'Resultado del componente');
$pdf->Tarjeta(111, $y, 42, 'KPI', formato($valorKPI), 'Resultado del componente');
$pdf->Tarjeta(159, $y, 36, 'VALORACIÓN', formato($valorFinal), 'Resultado final');

$pdf->SetY($y + 33);

$pdf->SetFillColor(240, 244, 247);

$pdf->Rect(
    15,
    $pdf->GetY(),
    180,
    17,
    'F'
);

$pdf->SetXY(19, $pdf->GetY() + 2);

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(23, 54, 93);

$pdf->Cell(
    172,
    5,
    pdf_texto('CLASIFICACIÓN: ' . $categoria),
    0,
    1
);

$pdf->SetX(19);

$pdf->SetFont('Arial', '', 8);
$pdf->SetTextColor(65, 75, 85);

$pdf->Cell(
    172,
    5,
    pdf_texto('Escala institucional de valoración del desempeño'),
    0,
    1
);

$pdf->Ln(5);

$pdf->Titulo(
    'Distribución de la valoración',
    'Comparación de las perspectivas de autoevaluación y jefatura.'
);

$pdf->GraficaComparativa('HSE', $autoHSE, $jefeHSE);

$pdf->GraficaComparativa(
    'COMPETENCIAS',
    $autoCompetencias,
    $jefeCompetencias
);

$pdf->GraficaComparativa('KPI', $autoKPI, $jefeKPI);

$pdf->Titulo('Interpretación del resultado');

$pdf->Texto(
    $valorFinal !== null
        ? interpretar($valorFinal)
        : 'No se dispone de una valoración final para realizar la interpretación.'
);

$pdf->Texto(
    'La valoración integra tres dimensiones complementarias: HSE (30 %), Competencias (30 %) y KPI (40 %). Su lectura conjunta permite comprender el desempeño desde el cumplimiento de responsabilidades, las capacidades profesionales y los resultados esperados.'
);

/* =====================================================
   01. HSE
===================================================== */

$pdf->VerificarEspacio(75);

$pdf->Titulo(
    '01. Seguridad, salud y ambiente (HSE)',
    'Evaluación de comportamientos y responsabilidades relacionados con SSTyA.'
);

$pdf->GraficaComparativa(
    'Percepción HSE',
    $autoHSE,
    $jefeHSE
);

$pdf->Texto(
    analizar_componente(
        'HSE',
        $autoHSE,
        $jefeHSE
    )
);

$pdf->TablaPreguntas(
    'Detalle de evaluación HSE',
    $hse,
    'HSE'
);

/* =====================================================
   02. COMPETENCIAS
===================================================== */

$pdf->VerificarEspacio(75);

$pdf->Titulo(
    '02. Competencias laborales',
    'Evaluación de capacidades, comportamientos y contribuciones profesionales.'
);

$pdf->GraficaComparativa(
    'Percepción de competencias',
    $autoCompetencias,
    $jefeCompetencias
);

$pdf->Texto(
    analizar_componente(
        'Competencias',
        $autoCompetencias,
        $jefeCompetencias
    )
);

$pdf->TablaPreguntas(
    'Detalle de evaluación de competencias',
    $competencias,
    'COMPETENCIAS'
);

/* =====================================================
   03. KPI
===================================================== */

$pdf->VerificarEspacio(75);

$pdf->Titulo(
    '03. Indicadores de desempeño (KPI)',
    'Evaluación del cumplimiento de actividades, objetivos y responsabilidades asignadas.'
);

$pdf->GraficaComparativa(
    'Percepción KPI',
    $autoKPI,
    $jefeKPI
);

$pdf->Texto(
    analizar_componente(
        'KPI',
        $autoKPI,
        $jefeKPI
    )
);

$pdf->TablaPreguntas(
    'Detalle de evaluación KPI',
    $kpi,
    'KPI'
);

/* =====================================================
   04. ANÁLISIS Y RECOMENDACIONES
===================================================== */

$pdf->VerificarEspacio(35);

$pdf->Titulo(
    '04. Análisis individual',
    'Identificación de fortalezas y oportunidades de desarrollo a partir de las valoraciones registradas.'
);

/* FORTALEZAS */

$pdf->VerificarEspacio(18);

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(23, 54, 93);

$pdf->Cell(
    180,
    7,
    pdf_texto('Fortalezas identificadas'),
    0,
    1
);

if (!empty($fortalezas)) {

    foreach (array_slice($fortalezas, 0, 5) as $item) {

        $pdf->VerificarEspacio(15);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetTextColor(45, 135, 105);

        $pdf->Cell(8, 5, '-', 0, 0);

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(65, 75, 85);

        $pdf->MultiCell(
            172,
            4.5,
            pdf_texto(
                $item['componente'] . ': ' .
                $item['pregunta'] .
                ' (Valoración de jefatura: ' .
                formato($item['nota']) . ')'
            )
        );
    }

} else {

    $pdf->Texto(
        'No se identificaron preguntas con valoraciones de jefatura iguales o superiores a 95 puntos en los registros disponibles.'
    );
}

/* OPORTUNIDADES */

$pdf->Ln(3);

$pdf->VerificarEspacio(18);

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(23, 54, 93);

$pdf->Cell(
    180,
    7,
    pdf_texto('Oportunidades de desarrollo'),
    0,
    1
);

if (!empty($oportunidades)) {

    foreach (array_slice($oportunidades, 0, 5) as $item) {

        $pdf->VerificarEspacio(15);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetTextColor(190, 135, 65);

        $pdf->Cell(8, 5, '-', 0, 0);

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(65, 75, 85);

        $pdf->MultiCell(
            172,
            4.5,
            pdf_texto(
                $item['componente'] . ': ' .
                $item['pregunta'] .
                ' (Valoración de jefatura: ' .
                formato($item['nota']) . ')'
            )
        );
    }

} else {

    $pdf->Texto(
        'No se identificaron preguntas con valoraciones de jefatura inferiores a 80 puntos. Se recomienda mantener el seguimiento y consolidar las buenas prácticas.'
    );
}

/* RECOMENDACIONES */

$pdf->Ln(3);

$pdf->VerificarEspacio(25);

$pdf->Titulo(
    'Recomendaciones para el desarrollo profesional'
);

$recomendaciones = [
    'Mantener una comunicación periódica entre colaborador y jefatura para revisar avances y expectativas.',
    'Reconocer las fortalezas identificadas y promover su aplicación en las actividades del equipo.',
    'Establecer compromisos de desarrollo concretos y alineados con las responsabilidades del puesto.',
    'Dar seguimiento a los objetivos y revisar periódicamente los avances alcanzados.',
    'Promover el aprendizaje continuo y el intercambio de buenas prácticas.'
];

foreach ($recomendaciones as $i => $texto) {

    $pdf->VerificarEspacio(12);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetTextColor(45, 105, 170);

    $pdf->Cell(
        9,
        5,
        ($i + 1) . '.',
        0,
        0
    );

    $pdf->SetFont('Arial', '', 8);
    $pdf->SetTextColor(65, 75, 85);

    $pdf->MultiCell(
        171,
        4.5,
        pdf_texto($texto)
    );
}

/* =====================================================
   05. FIRMAS
===================================================== */

$pdf->Firmas(
    $nombreColaborador,
    $nombreEvaluador,
    $valorFinal,
    $categoria,
    $existePares
);

/* =====================================================
   7. SALIDA PDF
===================================================== */

if (ob_get_length()) {
    ob_end_clean();
}

header('Content-Type: application/pdf');

header(
    'Content-Disposition: inline; filename="Informe_Individual_Desempeno_2026.pdf"'
);

$pdf->Output(
    'I',
    'Informe_Individual_Desempeno_2026.pdf'
);

exit;

?>