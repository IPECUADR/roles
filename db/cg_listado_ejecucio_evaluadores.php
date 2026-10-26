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

            persona.PK_persona as id, 
            persona.nom_p as nm, 
            persona.ap_p as ap, 
            t_evaluacion.t_evaluacion as tipo, 
            estado_rp_ev.estado_rp_ev as estado, 
            estado_rp_ev.PK_est_rp_ev as is_status,
            COUNT(ev_v_des.PK_aut_ev_v_des) as total_p


        FROM 

            ev_v_des, persona, 
            t_evaluacion,
            estado_rp_ev 

        WHERE 

            persona.ci_p = ev_v_des.ci_evaluador 
            and t_evaluacion.PK_t_evaluacion = ev_v_des.FK_t_evaluacion 
            and  estado_rp_ev.PK_est_rp_ev = ev_v_des.FK_est_ev 

            AND FK_t_evaluacion = :tipo


        GROUP BY
            id,
            nm, 
            ap

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