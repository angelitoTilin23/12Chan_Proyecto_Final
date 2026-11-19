<<<<<<< HEAD
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pub_id = $_POST['pub_id'] ?? null;
    $nom_user = trim($_POST['nom_user']);
    $mensaje = trim($_POST['mensaje']);

    if (empty($nom_user)) {
        $nom_user = "Anónimo";
    }

    if ($pub_id && !empty($mensaje)) {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=12chan;charset=utf8mb4", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("INSERT INTO respuestas (Pub_ID, Nom_User, Mensaje) VALUES (?, ?, ?)");
            $stmt->execute([$pub_id, $nom_user, $mensaje]);

            header("Location: hilo.php?id=" . $pub_id);
            exit();

        } catch (PDOException $e) {
            die("Error al guardar la respuesta: " . $e->getMessage());
        }
    }
}
header("Location: board.php");
exit();
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
    $pub_id = $_POST['pub_id'] ?? null;
    $nom_user = !empty($_POST['nom_user']) ? trim($_POST['nom_user']) : 'Anónimo';
    $mensaje = trim($_POST['mensaje'] ?? '');

    if ($pub_id && !empty($mensaje)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO respuestas (Pub_ID, Nom_User, Mensaje) VALUES (?, ?, ?)");
            $stmt->execute([$pub_id, $nom_user, $mensaje]);

            // Redirige de regreso al hilo correspondiente
            header("Location: hilo.php?id=" . $pub_id);
            exit();
        } catch (PDOException $e) {
            die("Error al guardar la respuesta: " . $e->getMessage());
        }
    } else {
        header("Location: board.php");
        exit();
    }
} else {
    header("Location: board.php");
    exit();
}
>>>>>>> 2c3e5a9 (Actualizacion Semana 2 del proyecto 12CHAN)
?>