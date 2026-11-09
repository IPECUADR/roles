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

    /* CALIFICACIÓN DEL JEFE */
    SUM(
        CASE 
            WHEN ev.FK_t_evaluacion = 2
            THEN ev.rp_ev_v_ds
            ELSE 0 
        END
    ) AS KPI_JEFE,

    /* APORTE PONDERADO AL 100% */
    SUM(
        CASE 
            WHEN ev.FK_t_evaluacion = 2
            THEN (ev.rp_ev_v_ds * ev.pnd_clf_ev) / 100
            ELSE 0 
        END
    ) AS aporte_jefe,

    /* RESULTADO POR PREGUNTA */
    SUM(
        CASE 
            WHEN ev.FK_t_evaluacion = 2
            THEN (ev.rp_ev_v_ds * ev.pnd_clf_ev) / 100
            ELSE 0
        END
    ) AS total_general,

    /* PROMEDIO DEL JEFE */
    AVG(
        CASE 
            WHEN ev.FK_t_evaluacion = 2
            THEN ev.rp_ev_v_ds
        END
    ) AS JEFE

FROM ev_v_des ev

INNER JOIN preguntas p
    ON p.PK_pregunta = ev.FK_pregunta

WHERE 
    ev.ci_colaborador = :id
    AND ev.FK_base_clf = 13
    AND ev.FK_t_evaluacion = 2

    /* EXCLUSIVAMENTE JEFATURA */
    AND NOT EXISTS (
        SELECT 1
        FROM ev_v_des otras
        WHERE otras.ci_colaborador = ev.ci_colaborador
          AND otras.FK_t_evaluacion IN (1, 3)
    )

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