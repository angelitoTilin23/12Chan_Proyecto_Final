
<?php

// ==========================================
// CONEXIÓN A LA BASE DE DATOS
// ==========================================

$host = "127.0.0.1";
$port = "3307";
$dbname = "12chan";
$user = "root";
$password = "";

try {

    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $user,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {

    die("Error de conexión: " . $e->getMessage());

}


// ==========================================
// PROCESAR PUBLICACIÓN
// ==========================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Datos recibidos del formulario
    $tablero_id = filter_input(INPUT_POST, 'tablero_id', FILTER_VALIDATE_INT);
    $nom_user = trim($_POST['nom_user'] ?? '');
    $titulo = trim($_POST['titulo'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    // Validar campos obligatorios
    if (!$tablero_id || empty($titulo) || empty($mensaje)) {
        die("Error: faltan datos obligatorios para publicar.");
    }

    // ==========================================
    // VERIFICAR QUE EL TABLERO EXISTA
    // ==========================================

    $stmtTablero = $pdo->prepare(
        "SELECT Tablero_ID, Slug
         FROM tableros
         WHERE Tablero_ID = ?
         LIMIT 1"
    );

    $stmtTablero->execute([$tablero_id]);

    $tablero = $stmtTablero->fetch();

    if (!$tablero) {
        die("Error: el tablero seleccionado no existe.");
    }

    // Obtener el identificador oficial del tablero
    $tablero_id = (int) $tablero['Tablero_ID'];
    $slug_tablero = $tablero['Slug'];

    // Nombre predeterminado
    if (empty($nom_user)) {
        $nom_user = "Anónimo";
    }


    // ==========================================
    // CARGA DE IMAGEN
    // ==========================================

    $imagen_ruta = "";

    if (
        isset($_FILES['imagen']) &&
        $_FILES['imagen']['error'] === UPLOAD_ERR_OK
    ) {

        $nombre_tmp = $_FILES['imagen']['tmp_name'];

        $nombre_archivo = time() . '_' .
            basename($_FILES['imagen']['name']);

        $directorio_destino = __DIR__ . '/uploads/';

        if (!is_dir($directorio_destino)) {
            mkdir($directorio_destino, 0775, true);
        }

        $ruta_destino = $directorio_destino . $nombre_archivo;

        if (move_uploaded_file($nombre_tmp, $ruta_destino)) {

            // Ruta que se guarda en la base de datos
            $imagen_ruta = 'uploads/' . $nombre_archivo;

        }

    }


    // ==========================================
    // GUARDAR PUBLICACIÓN
    // ==========================================

    try {

        $stmt = $pdo->prepare(
            "INSERT INTO publicaciones
            (
                Tablero_ID,
                Tablero,
                Nom_User,
                Titulo,
                Mensaje,
                Imagen
            )
            VALUES (?, ?, ?, ?, ?, ?)"
        );

        $stmt->execute([
            $tablero_id,
            $slug_tablero,
            $nom_user,
            $titulo,
            $mensaje,
            $imagen_ruta
        ]);


        // ==========================================
        // REGRESAR AL TABLERO
        // ==========================================

        header(
            "Location: board.php?tablero=" .
            urlencode($slug_tablero)
        );

        exit();

    } catch (PDOException $e) {

        die("Error al guardar la publicación: " . $e->getMessage());

    }

} else {

    header("Location: board.php");
    exit();

}

?>
