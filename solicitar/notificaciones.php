<?php
    include "../config.php";

    if (!isset($_GET['id_usuario']) || !is_numeric($_GET['id_usuario'])) {
        echo json_encode(['error' => 'Parámetro id_usuario inválido.']);
        exit;
    }

    $id_usuario = (int)$_GET['id_usuario'];

    $sql = "SELECT COUNT(*) AS notificaciones_count
              FROM mensajes
              WHERE id_destinatario = " . $id_usuario . " AND leido = 0";

    try {
        $result = $conexion->query($sql);
    } catch (mysqli_sql_exception $e) {
        http_response_code(500);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => 'Error de base de datos: ' . $e->getMessage()]);
        exit;
    }

    if (!$result) {
        http_response_code(500);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => 'Consulta inválida.']);
        exit;
    }

    $row = $result->fetch_assoc();
    $notificaciones = ['count' => (int)($row['notificaciones_count'] ?? 0)];

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($notificaciones);
?>