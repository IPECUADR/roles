<?php

// restriccion de acceso desde navegador
// Bloqueo acceso directo



// Validar método (opcional)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido');
}

