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
    ev.PK_aut_ev_v_des AS id,
    te.t_evaluacion AS tipo,
    ev.FK_est_ev AS st,
    est.estado_rp_ev AS stado,
    FK_t_evaluacion as t_ev, 
    text_ev as text

FROM ev_v_des AS ev

INNER JOIN t_evaluacion AS te
    ON te.PK_t_evaluacion = ev.FK_t_evaluacion

INNER JOIN estado_rp_ev AS est
    ON est.PK_est_rp_ev = ev.FK_est_ev

WHERE
    (ev.ci_colaborador = :id1 AND ev.FK_t_evaluacion = 1)
    OR
    (ev.ci_evaluador = :id2 AND ev.FK_t_evaluacion IN (2, 3))
    
    
    GROUP BY 
    
    tipo, 
    stado, 
    text, 
    t_ev


    ");

    $stmt->execute([
        ':id1' => $id,
        ':id2' => $id
  
    ]);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);


} catch (PDOException $e) {

    error_log($e->getMessage());

    echo json_encode([]);
}