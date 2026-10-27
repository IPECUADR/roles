<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([]);
    exit;
}

require_once '../sys/sys.conf.php';

$id = $_SESSION['pk_p'] ?? null;
$id_Evaludaor = $_POST ['id'] ?? null;

$tipo = $_POST ['t_ev'] ?? null;

if (!$id) {
    echo json_encode([]);
    exit;
}

try {

    $stmt = $pdo->prepare("

  SELECT
    ev.ci_colaborador AS ci_evaluado,
    CONCAT_WS(' ', p.nom_p, p.ap_p) AS evaluado,

    ev.ci_evaluador AS ci_evaluador,
    CONCAT_WS(' ', e.nom_p, e.ap_p) AS evaluador,

    ev.FK_t_evaluacion AS t_ev,
    te.t_evaluacion AS EVALUACION,

    COUNT(*) AS total_preguntas,

    SUM(CASE
        WHEN ev.FK_est_ev = 1 THEN 1
        ELSE 0
    END) AS ejecutadas,

    SUM(CASE
        WHEN ev.FK_est_ev = 2 THEN 1
        ELSE 0
    END) AS pendientes

FROM ev_v_des AS ev

INNER JOIN persona AS p
    ON p.PK_persona = ev.ci_colaborador

INNER JOIN persona AS e
    ON e.PK_persona = ev.ci_evaluador

INNER JOIN t_evaluacion AS te
    ON te.PK_t_evaluacion = ev.FK_t_evaluacion

WHERE ev.FK_t_evaluacion = :tipo

GROUP BY
    ev.ci_colaborador,
    p.nom_p,
    p.ap_p,
    ev.ci_evaluador,
    e.nom_p,
    e.ap_p,
    ev.FK_t_evaluacion,
    te.PK_t_evaluacion
    
    ");

    $stmt->execute([

       ':tipo' => $tipo

    ]);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);


} catch (PDOException $e) {

    error_log($e->getMessage());

    echo json_encode([]);
}