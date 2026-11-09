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
    te.t_evaluacion AS tipo
FROM ev_v_des AS ev

INNER JOIN t_evaluacion AS te
    ON te.PK_t_evaluacion = ev.FK_t_evaluacion

WHERE
    ev.ci_colaborador = :id
    AND ev.FK_t_evaluacion = 2

    AND NOT EXISTS (
        SELECT 1
        FROM ev_v_des AS aut
        WHERE aut.ci_colaborador = ev.ci_colaborador
          AND aut.FK_t_evaluacion = 1
    )

LIMIT 1;
    ");

    $stmt->execute([
        ':id' => $id
 
    ]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($data ?: [], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {

    error_log($e->getMessage());

    echo json_encode([]);
}