<?php
session_start();

header('Content-Type: application/json');

date_default_timezone_set('America/Guayaquil');

// Bloquear acceso directo
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'err' => true,
        'msg' => 'Método no permitido'
    ]);
    exit;
}

$us = $_SESSION['user'] ?? null;

require_once '../sys/sys.conf.php';

try {

    $tipo        = $_POST['tipo'] ?? 'general';
    $mes         = $_POST['mes'] ?? '';
    $colaborador = $_POST['colaborador'] ?? '';

    $filtro = '';
    $params = [];

    // REPORTE POR MES
    if ($tipo == 'mes' && !empty($mes)) {

        $filtro .= " AND rol_p.FK_mes = :mes ";
        $params[':mes'] = $mes;
    }

    // REPORTE POR COLABORADOR
    if ($tipo == 'colaborador' && !empty($mes) && !empty($colaborador)) {

        $filtro .= "
            AND rol_p.FK_mes = :mes
            AND rol_p.FK_persona = :persona
        ";

        $params[':mes'] = $mes;
        $params[':persona'] = $colaborador;
    }

    $sql = "

        SELECT 
            *,
            CONCAT(persona.nom_p, ' ', persona.ap_p) AS nm

        FROM 
        
            persona,
            rol_p,
            proyecto,
            mes,
            cargo,
            firma_rol

        WHERE 
            
            persona.PK_persona = rol_p.FK_persona
            AND cargo.PK_cg = persona.FK_cg
            AND mes.PK_mes = rol_p.FK_mes
            AND firma_rol.PK_firma = rol_p.FK_firma
            AND proyecto.PK_pro = persona.FK_pro

            $filtro

        ORDER BY persona.ap_p ASC

    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute($params);

    $data = $stmt->fetchAll();

            if (empty($data)) {
                echo json_encode([
                    'error' => true,
                    'icon' => 'error',
                    'msg' => 'No hay datos'
                ]);
                exit;
            }

    echo json_encode($data);



} catch (Exception $e) {

    error_log($e->getMessage());

    echo json_encode([
        'err' => true,
        'msg' => $e->getMessage()
    ]);
}