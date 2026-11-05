<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['err' => true, 'msg' => 'Método no permitido']);
    exit;
}

require_once '../sys/sys.conf.php';

$id = $_SESSION['pk_p'] ?? null;

if (!$id) {
    echo json_encode(['err' => true, 'msg' => 'Sesión no válida']);
    exit;
}

try {

    $stmt = $pdo->prepare("


SELECT
    p.PK_pregunta,
    p.pregunta AS p,

    /* ==========================
       CALIFICACIONES SOBRE 100
    ========================== */

    AVG(CASE
        WHEN ev.FK_t_evaluacion = 1
        THEN ev.rp_ev_v_ds
    END) AS KPI_AUTO_EVALUACION,

    AVG(CASE
        WHEN ev.FK_t_evaluacion = 2
        THEN ev.rp_ev_v_ds
    END) AS KPI_JEFE,

    AVG(CASE
        WHEN ev.FK_t_evaluacion = 3
        THEN ev.rp_ev_v_ds
    END) AS KPI_PARES,


    /* ==========================
       EXISTENCIA DE EVALUACIÓN
    ========================== */

    COUNT(CASE
        WHEN ev.FK_t_evaluacion = 3
        THEN 1
    END) AS EXISTE_PARES,


    /* ==========================
       APORTES PONDERADOS
    ========================== */

    COALESCE(SUM(CASE
        WHEN ev.FK_t_evaluacion = 1
        THEN ((ev.rp_ev_v_ds * ev.pnd_clf_ev) / 100) * 0.25
        ELSE 0
    END), 0) AS aporte_auto,

    COALESCE(SUM(CASE
        WHEN ev.FK_t_evaluacion = 2
        THEN ((ev.rp_ev_v_ds * ev.pnd_clf_ev) / 100) * 0.75
        ELSE 0
    END), 0) AS aporte_jefe,

    COALESCE(AVG(CASE
        WHEN ev.FK_t_evaluacion = 3
        THEN (ev.rp_ev_v_ds * ev.pnd_clf_ev) / 100
    END), 0) * 0.05 AS aporte_pares,


    /* ==========================
       RESULTADO POR PREGUNTA
    ========================== */

    (
        COALESCE(SUM(CASE
            WHEN ev.FK_t_evaluacion = 1
            THEN ((ev.rp_ev_v_ds * ev.pnd_clf_ev) / 100) * 0.25
            ELSE 0
        END), 0)

        +

        COALESCE(SUM(CASE
            WHEN ev.FK_t_evaluacion = 2
            THEN ((ev.rp_ev_v_ds * ev.pnd_clf_ev) / 100) * 0.75
            ELSE 0
        END), 0)

        +

        COALESCE(AVG(CASE
            WHEN ev.FK_t_evaluacion = 3
            THEN (ev.rp_ev_v_ds * ev.pnd_clf_ev) / 100
        END), 0) * 0.05

    ) AS total_general,


    /* ==========================
       RESULTADOS GENERALES
    ========================== */

    COALESCE(SUM(CASE
        WHEN ev.FK_t_evaluacion = 1
        THEN ((ev.rp_ev_v_ds * ev.pnd_clf_ev) / 100) * 0.25
        ELSE 0
    END), 0) AS AUTOEVALUACION,

    COALESCE(SUM(CASE
        WHEN ev.FK_t_evaluacion = 2
        THEN ((ev.rp_ev_v_ds * ev.pnd_clf_ev) / 100) * 0.75
        ELSE 0
    END), 0) AS JEFE,

    COALESCE(AVG(CASE
        WHEN ev.FK_t_evaluacion = 3
        THEN (ev.rp_ev_v_ds * ev.pnd_clf_ev) / 100
    END), 0) * 0.05 AS PARES


FROM ev_v_des ev

INNER JOIN preguntas p
    ON p.PK_pregunta = ev.FK_pregunta

WHERE
    ev.ci_colaborador = :id
    AND ev.FK_base_clf BETWEEN 1 AND 12
    AND ev.FK_t_evaluacion IN (1, 2, 3)

GROUP BY
    p.PK_pregunta,
    p.pregunta

ORDER BY p.PK_pregunta



    ");

    $stmt->execute([':id' => $id]);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'err' => false,
        'data' => $data
    ]);

} catch (PDOException $e) {

    error_log($e->getMessage());

    echo json_encode([
        'err' => true,
        'msg' => 'Error al consultar los resultados'
    ]);
}
