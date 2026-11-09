<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([]);
    exit;
}

require_once '../sys/sys.conf.php';


$id = $_SESSION['pk_p'] ?? null;

if (!$id) {
    echo json_encode([]);
    exit;
}

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

        /* TOTAL HSE - 100% JEFATURA */
        calculos.JEFE_HSE AS TOTAL_HSE,

        /* TOTAL COMPETENCIAS - 100% JEFATURA */
        calculos.JEFE_COMPETENCIAS AS TOTAL_COMPETENCIAS,

        /* TOTAL KPI - 100% JEFATURA */
        calculos.JEFE_KPI AS TOTAL_KPI

    FROM (

        SELECT

            /* ==========================
               HSE - FK_BASE_CLF = 13
            ========================== */

            COALESCE(AVG(CASE
                WHEN ev.FK_base_clf = 13
                THEN ev.rp_ev_v_ds
            END), 0) AS JEFE_HSE,

            COALESCE(AVG(CASE
                WHEN ev.FK_base_clf = 13
                THEN ev.rp_ev_v_ds
            END), 0) AS JEFE_HSE_100,


            /* ==========================
               COMPETENCIAS - 1 AL 12
            ========================== */

            COALESCE(AVG(CASE
                WHEN ev.FK_base_clf BETWEEN 1 AND 12
                THEN ev.rp_ev_v_ds
            END), 0) AS JEFE_COMPETENCIAS,

            COALESCE(AVG(CASE
                WHEN ev.FK_base_clf BETWEEN 1 AND 12
                THEN ev.rp_ev_v_ds
            END), 0) AS JEFE_COMPETENCIAS_100,


            /* ==========================
               KPI - FK_BASE_CLF = 14
            ========================== */

            COALESCE(SUM(CASE
                WHEN ev.FK_base_clf = 14
                THEN (ev.rp_ev_v_ds * ev.pnd_clf_ev) / 100
                ELSE 0
            END), 0) AS JEFE_KPI,

            COALESCE(SUM(CASE
                WHEN ev.FK_base_clf = 14
                THEN (ev.rp_ev_v_ds * ev.pnd_clf_ev) / 100
                ELSE 0
            END), 0) AS JEFE_KPI_100

        FROM ev_v_des ev

        WHERE ev.ci_colaborador = :id
          AND ev.FK_base_clf BETWEEN 1 AND 14
          AND ev.FK_t_evaluacion = 2

          /* EXCLUSIVAMENTE EVALUACIÓN DE JEFATURA */
          AND NOT EXISTS (
              SELECT 1
              FROM ev_v_des otras
              WHERE otras.ci_colaborador = ev.ci_colaborador
                AND otras.FK_t_evaluacion IN (1, 3)
          )

    ) AS calculos

) AS indicadores

    ");

    $stmt->execute([
        ':id' => $id
  
    ]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($data ?: []);

} catch (PDOException $e) {

    error_log($e->getMessage());

    echo json_encode([]);
}