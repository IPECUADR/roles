
<?php
// Generar token numérico seguro (6 dígitos)
$token = random_int(100000, 999999);

// Definir tiempo de validez (minutos)
$minutosValidez = 10;

// Calcular fecha y hora de expiración
$token_expira = date(
    'Y-m-d H:i:s',
    time() + ($minutosValidez * 60)
);

// Mostrar resultados
echo "Token generado: " . $token . "<br>";
echo "Fecha de expiración: " . $token_expira;
?>
