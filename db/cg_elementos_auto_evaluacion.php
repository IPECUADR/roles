<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([]);
    exit;
}

require_once '../sys/sys.valoracion.php';

$id = $_SESSION['pk_p'] ?? null;
$t = $_POST ['t_evaluacion'] ?? null;

if (!$id) {
    echo json_encode([]);
    exit;
}

try {

    $stmt = $pdo->prepare("

    SELECT 

        bc.base AS b,
        bc.PK_base_clf as id, 
        COUNT(ev.FK_pregunta) AS ct

    FROM ev_v_des AS ev

        INNER JOIN base_clasific AS bc 
            ON bc.PK_base_clf = ev.FK_base_clf
        WHERE ev.ci_colaborador = :id
        AND ev.FK_t_evaluacion  = :t
        AND ev.FK_est_ev  = 2
        GROUP BY

        bc.base, 
        id

    ");

    $stmt->execute([
        ':id' => $id,
        ':t' => $t
  
    ]);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);


} catch (PDOException $e) {

    error_log($e->getMessage());

    echo json_encode([]);
}