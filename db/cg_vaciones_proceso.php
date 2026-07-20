<?php
session_start();

header('Content-Type: application/json');

// Solo permitir POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['err' => true, 'msg' => 'Método no permitido']);
    exit;
}

require_once '../sys/sys.conf.php';

$area = $_POST['area'] ?? 0;
$id = $_SESSION['pk_p'] ?? null;

try {

    $stmt = $pdo->prepare("
        SELECT

            vacaciones.FK_persona AS id,
            SUM(vacaciones.t_per_v) AS t_vc,
            SUM(vacaciones.dias_gozados) AS dg,
            SUM(vacaciones.dias_pendientes) AS dp,
            persona.nom_p,
            persona.ap_p AS ap,
            area.area AS a

        FROM vacaciones

        INNER JOIN persona
            ON persona.PK_persona = vacaciones.FK_persona

        INNER JOIN area
            ON area.PK_area = vacaciones.FK_area

        WHERE vacaciones.FK_area = :area
         and  FK_persona <> :id

        GROUP BY

            vacaciones.FK_persona,
            persona.nom_p,
            persona.ap_p,
            area.area

        ORDER BY persona.nom_p ASC
    ");

    $stmt->execute([
        ':area' => $area,
        ':id' => $id
    ]);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);

} catch (PDOException $e) {

    error_log($e->getMessage());

    echo json_encode([
        'err' => true,
        'msg' => $e->getMessage()
    ]);
}