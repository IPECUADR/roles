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

    /* CALIFICACIONES */
    SUM(CASE 
        WHEN ev.FK_t_evaluacion = 1
        THEN ev.rp_ev_v_ds
        ELSE 0 
    END) AS KPI_AUTO_EVALUACION,

    SUM(CASE 
        WHEN ev.FK_t_evaluacion = 2
        THEN ev.rp_ev_v_ds
        ELSE 0 
    END) AS KPI_JEFE,

    /* APORTES PONDERADOS */
    SUM(CASE 
        WHEN ev.FK_t_evaluacion = 1
        THEN ((ev.rp_ev_v_ds * ev.pnd_clf_ev) / 100) * 0.25
        ELSE 0 
    END) AS aporte_auto,

    SUM(CASE 
        WHEN ev.FK_t_evaluacion = 2
        THEN ((ev.rp_ev_v_ds * ev.pnd_clf_ev) / 100) * 0.75
        ELSE 0 
    END) AS aporte_jefe,

    /* RESULTADO POR PREGUNTA */
    SUM(
        ((ev.rp_ev_v_ds * ev.pnd_clf_ev) / 100) *
        CASE 
            WHEN ev.FK_t_evaluacion = 1 THEN 0.25
            WHEN ev.FK_t_evaluacion = 2 THEN 0.75
            ELSE 0
        END
    ) AS total_general,

    /* PROMEDIOS GENERALES */
    AVG(CASE 
        WHEN ev.FK_t_evaluacion = 1
        THEN ev.rp_ev_v_ds
    END) * 0.25 AS AUTOEVALUACION,

    AVG(CASE 
        WHEN ev.FK_t_evaluacion = 2
        THEN ev.rp_ev_v_ds
    END) * 0.75 AS JEFE

FROM ev_v_des ev

INNER JOIN preguntas p
    ON p.PK_pregunta = ev.FK_pregunta

WHERE 
    ev.ci_colaborador = :id
    AND ev.FK_base_clf = 13
    AND ev.FK_t_evaluacion IN (1, 2)

GROUP BY 
    p.PK_pregunta,
    p.pregunta

ORDER BY p.PK_pregunta;

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