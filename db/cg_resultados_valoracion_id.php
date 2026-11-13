
<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([]);
    exit;
}

require_once '../sys/sys.conf.php';

$id = $_POST['id'] ?? null;

if (!$id) {
    echo json_encode([]);
    exit;
}

try {

    $stmt = $pdo->prepare("

        SELECT
            indicadores.*,

            /* DATOS DEL COLABORADOR */

            (
                SELECT p.nom_p
                FROM persona p
                WHERE p.ci_p = :id_nombre
                LIMIT 1
            ) AS nm,

            (
                SELECT p.ap_p
                FROM persona p
                WHERE p.ci_p = :id_apellido
                LIMIT 1
            ) AS ap,

            /* DATOS DEL JEFE */

            (
                SELECT p.nom_p
                FROM persona p
                WHERE p.ci_p = (
                    SELECT e.ci_evaluador
                    FROM ev_v_des e
                    WHERE e.ci_colaborador = :id_jefe_nombre
                      AND e.FK_t_evaluacion = 2
                    LIMIT 1
                )
                LIMIT 1
            ) AS nom_jefe,

            (
                SELECT p.ap_p
                FROM persona p
                WHERE p.ci_p = (
                    SELECT e.ci_evaluador
                    FROM ev_v_des e
                    WHERE e.ci_colaborador = :id_jefe_apellido
                      AND e.FK_t_evaluacion = 2
                    LIMIT 1
                )
                LIMIT 1
            ) AS ap_jefe,

            /* VALORACIÓN FINAL 2026 */

            (
                (indicadores.TOTAL_HSE * 0.30) +
                (indicadores.TOTAL_COMPETENCIAS * 0.30) +
                (indicadores.TOTAL_KPI * 0.40)
            ) AS TOTAL_EVALUACION

        FROM (

            SELECT
                calculos.*,

                /* TOTAL HSE */
                (
                    calculos.AUTO_HSE +
                    calculos.JEFE_HSE
                ) AS TOTAL_HSE,

                /* TOTAL COMPETENCIAS + PARES */
                (
                    calculos.AUTO_COMPETENCIAS +
                    calculos.JEFE_COMPETENCIAS +
                    calculos.PARES_COMPETENCIAS
                ) AS TOTAL_COMPETENCIAS,

                /* TOTAL KPI */
                (
                    calculos.AUTO_KPI +
                    calculos.JEFE_KPI
                ) AS TOTAL_KPI

            FROM (

                SELECT

                    /* HSE - FK_BASE_CLF = 13 */

                    COALESCE(AVG(CASE
                        WHEN FK_base_clf = 13 AND FK_t_evaluacion = 1
                        THEN rp_ev_v_ds
                    END), 0) * 0.25 AS AUTO_HSE,

                    COALESCE(AVG(CASE
                        WHEN FK_base_clf = 13 AND FK_t_evaluacion = 1
                        THEN rp_ev_v_ds
                    END), 0) AS AUTO_HSE_100,

                    COALESCE(AVG(CASE
                        WHEN FK_base_clf = 13 AND FK_t_evaluacion = 2
                        THEN rp_ev_v_ds
                    END), 0) * 0.75 AS JEFE_HSE,

                    COALESCE(AVG(CASE
                        WHEN FK_base_clf = 13 AND FK_t_evaluacion = 2
                        THEN rp_ev_v_ds
                    END), 0) AS JEFE_HSE_100,


                    /* COMPETENCIAS - 1 AL 12 */

                    COALESCE(AVG(CASE
                        WHEN FK_base_clf BETWEEN 1 AND 12
                         AND FK_t_evaluacion = 1
                        THEN rp_ev_v_ds
                    END), 0) * 0.25 AS AUTO_COMPETENCIAS,

                    COALESCE(AVG(CASE
                        WHEN FK_base_clf BETWEEN 1 AND 12
                         AND FK_t_evaluacion = 1
                        THEN rp_ev_v_ds
                    END), 0) AS AUTO_COMPETENCIAS_100,

                    COALESCE(AVG(CASE
                        WHEN FK_base_clf BETWEEN 1 AND 12
                         AND FK_t_evaluacion = 2
                        THEN rp_ev_v_ds
                    END), 0) * 0.75 AS JEFE_COMPETENCIAS,

                    COALESCE(AVG(CASE
                        WHEN FK_base_clf BETWEEN 1 AND 12
                         AND FK_t_evaluacion = 2
                        THEN rp_ev_v_ds
                    END), 0) AS JEFE_COMPETENCIAS_100,


                    /* EVALUACIÓN DE PARES - 5% */

                    COALESCE(AVG(CASE
                        WHEN FK_base_clf BETWEEN 1 AND 12
                         AND FK_t_evaluacion = 3
                        THEN rp_ev_v_ds
                    END), 0) * 0.05 AS PARES_COMPETENCIAS,

                    COALESCE(AVG(CASE
                        WHEN FK_base_clf BETWEEN 1 AND 12
                         AND FK_t_evaluacion = 3
                        THEN rp_ev_v_ds
                    END), 0) AS PARES_COMPETENCIAS_100,

                    COUNT(CASE
                        WHEN FK_base_clf BETWEEN 1 AND 12
                         AND FK_t_evaluacion = 3
                        THEN 1
                    END) AS EXISTE_PARES,


                    /* KPI - FK_BASE_CLF = 14 */

                    COALESCE(SUM(CASE
                        WHEN FK_base_clf = 14 AND FK_t_evaluacion = 1
                        THEN ((rp_ev_v_ds * pnd_clf_ev) / 100) * 0.20
                        ELSE 0
                    END), 0) AS AUTO_KPI,

                    COALESCE(SUM(CASE
                        WHEN FK_base_clf = 14 AND FK_t_evaluacion = 1
                        THEN (rp_ev_v_ds * pnd_clf_ev) / 100
                        ELSE 0
                    END), 0) AS AUTO_KPI_100,

                    COALESCE(SUM(CASE
                        WHEN FK_base_clf = 14 AND FK_t_evaluacion = 2
                        THEN ((rp_ev_v_ds * pnd_clf_ev) / 100) * 0.80
                        ELSE 0
                    END), 0) AS JEFE_KPI,

                    COALESCE(SUM(CASE
                        WHEN FK_base_clf = 14 AND FK_t_evaluacion = 2
                        THEN (rp_ev_v_ds * pnd_clf_ev) / 100
                        ELSE 0
                    END), 0) AS JEFE_KPI_100

                FROM ev_v_des

                WHERE ci_colaborador = :id_calculo
                  AND FK_base_clf BETWEEN 1 AND 14
                  AND FK_t_evaluacion IN (1, 2, 3)

            ) AS calculos

        ) AS indicadores

    ");

    $stmt->execute([
        ':id_nombre'       => $id,
        ':id_apellido'     => $id,
        ':id_jefe_nombre'  => $id,
        ':id_jefe_apellido'=> $id,
        ':id_calculo'      => $id
    ]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($data ?: [], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {

    error_log('Error consulta desempeño: ' . $e->getMessage());

    echo json_encode([
        'err' => true,
        'msg' => 'Error al consultar los resultados.',
        'detalle' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
