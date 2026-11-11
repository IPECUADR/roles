<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'err' => true,
        'msg' => 'Método no permitido',
        'data' => []
    ]);
    exit;
}

require_once '../sys/sys.conf.php';

try {

    $stmt = $pdo->prepare("

  SELECT
    indicadores.*,

    /* VALORACIÓN FINAL 2026 */
    (
        (indicadores.TOTAL_HSE * 0.30) +
        (indicadores.TOTAL_COMPETENCIAS * 0.30) +
        (indicadores.TOTAL_KPI * 0.40)
    ) AS TOTAL_EVALUACION

FROM (

    SELECT
        calculos.*,

        /* TOTAL HSE: JEFE 100% */
        calculos.JEFE_HSE AS TOTAL_HSE,

        /* TOTAL COMPETENCIAS: JEFE 100% */
        calculos.JEFE_COMPETENCIAS AS TOTAL_COMPETENCIAS,

        /* TOTAL KPI: JEFE 100% */
        calculos.JEFE_KPI AS TOTAL_KPI

    FROM (

        SELECT
            persona.PK_persona,
            persona.nom_p,
            persona.ap_p,
            cargo.cargo_cg AS cargo,

            /* HSE: EVALUACIÓN JEFE 100% */
            COALESCE(AVG(CASE
                WHEN ev_v_des.FK_base_clf = 13
                     AND ev_v_des.FK_t_evaluacion = 2
                THEN ev_v_des.rp_ev_v_ds
            END), 0) AS JEFE_HSE,

            /* COMPETENCIAS: EVALUACIÓN JEFE 100% */
            COALESCE(AVG(CASE
                WHEN ev_v_des.FK_base_clf BETWEEN 1 AND 12
                     AND ev_v_des.FK_t_evaluacion = 2
                THEN ev_v_des.rp_ev_v_ds
            END), 0) AS JEFE_COMPETENCIAS,

            /* KPI: EVALUACIÓN JEFE 100% */
            COALESCE(SUM(CASE
                WHEN ev_v_des.FK_base_clf = 14
                     AND ev_v_des.FK_t_evaluacion = 2
                THEN (
                    (ev_v_des.rp_ev_v_ds * ev_v_des.pnd_clf_ev) / 100
                )
                ELSE 0
            END), 0) AS JEFE_KPI

        FROM ev_v_des

        INNER JOIN persona
            ON persona.PK_persona = ev_v_des.ci_colaborador

        INNER JOIN cargo
            ON cargo.PK_cg = ev_v_des.FK_cg

        WHERE
            ev_v_des.FK_base_clf BETWEEN 1 AND 14
            AND ev_v_des.FK_t_evaluacion = 2

            /* EXCLUIR QUIENES TENGAN AUTOEVALUACIÓN O PARES */
            AND NOT EXISTS (

                SELECT 1
                FROM ev_v_des AS otras

                WHERE otras.ci_colaborador = ev_v_des.ci_colaborador
                  AND otras.FK_t_evaluacion IN (1, 3)

            )

        GROUP BY
            persona.PK_persona,
            persona.nom_p,
            persona.ap_p,
            cargo.cargo_cg

    ) AS calculos

) AS indicadores

ORDER BY indicadores.ap_p;

    ");

   $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);

} catch (PDOException $e) {

    error_log($e->getMessage());

    echo json_encode([
        'err' => true,
        'msg' => 'Error al consultar los resultados',
        'data' => []
    ], JSON_UNESCAPED_UNICODE);
}
