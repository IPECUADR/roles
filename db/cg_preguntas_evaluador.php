<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([]);
    exit;
}

require_once '../sys/sys.conf.php';


$p = $_POST['p'] ?? null;
$b = $_POST['id'] ?? null;
$t =  $_POST['tp'] ?? null;

if (!$p || !$b) {
    echo json_encode([]);
    exit;
}

try {

    $stmt = $pdo->prepare("
        SELECT 
            ev.PK_aut_ev_v_des AS id,
            p.pregunta AS p
        FROM ev_v_des AS ev
        INNER JOIN preguntas AS p
            ON p.PK_pregunta = ev.FK_pregunta
        WHERE ev.ci_colaborador = :p
          AND ev.FK_base_clf = :id
          AND ev.FK_est_ev = 2
          AND ev.FK_t_evaluacion = :
    ");

    $stmt->execute([
        ':p'  => $p,
        ':id' => $b, 
        ':t'  => $t
    ]);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);

} catch (PDOException $e) {

    error_log($e->getMessage());

    echo json_encode([]);
}
