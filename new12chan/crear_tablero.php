<?php
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Método no permitido']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$nombre = trim($input['nombre'] ?? '');

if ($nombre === '') {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'El nombre del tablero es obligatorio']);
    exit;
}

$nombre = mb_substr($nombre, 0, 100, 'UTF-8');

// Generar slug compatible con varchar(50)
$slug = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $nombre);
$slug = strtolower($slug ?: '');
$slug = preg_replace('/[^a-z0-9]+/', '_', $slug);
$slug = trim($slug, '_');
$slug = substr($slug !== '' ? $slug : 'tablero', 0, 50);

$host = "127.0.0.1";
$port = "3307";
$dbname = "12chan";
$user = "root";
$password = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    // Si el slug ya existe, devolverlo para evitar duplicados
    $stmtBuscar = $pdo->prepare("SELECT Tablero_ID, Nombre, Slug FROM tableros WHERE Slug = ? LIMIT 1");
    $stmtBuscar->execute([$slug]);
    $existente = $stmtBuscar->fetch();

    if ($existente) {
        echo json_encode(['ok' => true, 'tablero' => $existente, 'existente' => true]);
        exit;
    }

    $stmtInsert = $pdo->prepare("INSERT INTO tableros (Nombre, Slug) VALUES (?, ?)");
    $stmtInsert->execute([$nombre, $slug]);

    echo json_encode([
        'ok' => true,
        'existente' => false,
        'tablero' => [
            'Tablero_ID' => (int) $pdo->lastInsertId(),
            'Nombre' => $nombre,
            'Slug' => $slug
        ]
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Error al guardar en la base de datos']);
}