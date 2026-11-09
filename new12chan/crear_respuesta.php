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
?>