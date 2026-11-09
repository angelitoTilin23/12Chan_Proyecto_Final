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
?>