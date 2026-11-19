<<<<<<< HEAD
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tablero = $_POST['tablero'] ?? 'cultura_japonesa';
    $nom_user = trim($_POST['nom_user']);
    $titulo = trim($_POST['titulo']);
    $mensaje = trim($_POST['mensaje']);

    if (empty($nom_user)) {
        $nom_user = "Anónimo";
    }

    $ruta_imagen = "";

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $archivo_tmp = $_FILES['imagen']['tmp_name'];
        $nombre_original = basename($_FILES['imagen']['name']);
        $nombre_unico = uniqid() . "_" . $nombre_original;
        $ruta_destino = "uploads/" . $nombre_unico;

        if (move_uploaded_file($archivo_tmp, $ruta_destino)) {
            $ruta_imagen = $ruta_destino;
        }
    }

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=12chan;charset=utf8mb4", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO publicaciones (Tablero, Nom_User, Titulo, Mensaje, Imagen) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$tablero, $nom_user, $titulo, $mensaje, $ruta_imagen]);

        header("Location: board.php?tablero=" . urlencode($tablero));
        exit();

    } catch (PDOException $e) {
        die("Error al guardar en la base de datos: " . $e->getMessage());
    }
} else {
    header("Location: board.php");
    exit();
}
=======
<?php
$host = "127.0.0.1";
$port = "3307"; 
$dbname = "12chan";
$user = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tablero = $_POST['tablero'] ?? 'general';
    $nom_user = !empty($_POST['nom_user']) ? trim($_POST['nom_user']) : 'Anónimo';
    $titulo = trim($_POST['titulo'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');
    $imagen_ruta = '';

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombre_tmp = $_FILES['imagen']['tmp_name'];
        $nombre_archivo = time() . '_' . basename($_FILES['imagen']['name']);
        $directorio_destino = 'uploads/';

        if (!file_exists($directorio_destino)) {
            mkdir($directorio_destino, 0777, true);
        }

        $imagen_ruta = $directorio_destino . $nombre_archivo;
        move_uploaded_file($nombre_tmp, $imagen_ruta);
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO publicaciones (Tablero, Nom_User, Titulo, Mensaje, Imagen) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$tablero, $nom_user, $titulo, $mensaje, $imagen_ruta]);

        // Redirige de regreso al tablero exacto donde estabas
        header("Location: board.php?tablero=" . urlencode($tablero));
        exit();

    } catch (PDOException $e) {
        die("Error al guardar la publicación: " . $e->getMessage());
    }
} else {
    header("Location: board.php");
    exit();
}
>>>>>>> 2c3e5a9 (Actualizacion Semana 2 del proyecto 12CHAN)
?>