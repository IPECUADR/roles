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
            ev.ci_colaborador AS ci,
            CONCAT_WS(' ', p.nom_p, p.ap_p) AS names,
            ev.FK_t_evaluacion AS t_ev,
            COUNT(*) AS total
            

        FROM evaluar_2026.ev_v_des AS ev

        INNER JOIN roles_pagos.persona AS p
            ON p.PK_persona = ev.ci_colaborador

        WHERE
            ev.ci_evaluador = :id
            AND ev.FK_t_evaluacion = :t
            AND ev.FK_est_ev  = 2

        GROUP BY
            ev.ci_colaborador,
            p.nom_p,
            p.ap_p,
            ev.FK_t_evaluacion

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