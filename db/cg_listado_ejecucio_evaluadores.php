<?php
session_start();

//header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([]);
    exit;
}

require_once '../sys/sys.conf.php';


$id = $_SESSION['pk_p'] ?? null;
$tipo = $_POST['t_evaluacion'];

if (!$id) {
    echo json_encode([]);
    exit;
}

try {

    $stmt = $pdo->prepare("

      SELECT
            ev.ci_evaluador AS id,
            CONCAT_WS(' ', e.nom_p, e.ap_p) AS nm,
            COUNT(*) AS total_p,
            ev.FK_t_evaluacion AS is_status,
            est.estado_rp_ev AS est,
            t_ev.t_evaluacion AS tipo_ev

        FROM ev_v_des AS ev

        INNER JOIN persona AS e
            ON e.PK_persona = ev.ci_evaluador

        INNER JOIN estado_rp_ev AS est
            ON est.PK_est_rp_ev = ev.FK_est_ev

        INNER JOIN t_evaluacion AS t_ev
            ON t_ev.PK_t_evaluacion = ev.FK_t_evaluacion

        WHERE ev.FK_t_evaluacion = :tipo
        AND ev.FK_est_ev = 2

        GROUP BY
            ev.ci_evaluador,
            e.nom_p,
            e.ap_p,
            ev.FK_t_evaluacion,
            est.estado_rp_ev,
            t_ev.t_evaluacion;

    ");

    $stmt->execute([

      ':tipo'=> $tipo

    ]);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);


} catch (PDOException $e) {

    error_log($e->getMessage());

    echo json_encode([]);
}