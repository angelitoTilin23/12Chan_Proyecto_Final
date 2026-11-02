<?php
$id_hilo = $_GET['id'] ?? null;
if (!$id_hilo) {
    header("Location: board.php");
    exit();
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=12chan;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->prepare("SELECT * FROM publicaciones WHERE Pub_ID = ?");
    $stmt->execute([$id_hilo]);
    $hilo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$hilo) {
        die("El hilo no existe.");
    }

    $stmt_resp = $pdo->prepare("SELECT * FROM respuestas WHERE Pub_ID = ? ORDER BY Res_ID ASC");
    $stmt_resp->execute([$id_hilo]);
    $respuestas = $stmt_resp->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error de base de datos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>12 CHAN - Hilo #<?php echo $hilo['Pub_ID']; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <h1>12 CHAN</h1>
        <nav>
            <a href="board.php">&larr; Volver al tablón</a>
        </nav>
    </header>

    <main>
        <article class="post-card main-thread">
            <?php if (!empty($hilo['Imagen'])): ?>
                <div class="post-img">
                    <a href="<?php echo $hilo['Imagen']; ?>" target='_blank'><img src="<?php echo $hilo['Imagen']; ?>" alt="Imagen"></a>
                </div>
            <?php endif; ?>
            <div class="post-content">
                <h2><?php echo htmlspecialchars($hilo['Titulo']); ?></h2>
                <p><strong><?php echo htmlspecialchars($hilo['Nom_User']); ?></strong> - <span><?php echo $hilo['T_Pub']; ?></span></p>
                <p><?php echo nl2br(htmlspecialchars($hilo['Mensaje'])); ?></p>
            </div>
        </article>

        <hr>
        <h3>Respuestas (<?php echo count($respuestas); ?>)</h3>

        <section class="replies-section">
            <?php if (empty($respuestas)): ?>
                <p>No hay respuestas aún. ¡Sé el primero en comentar!</p>
            <?php else: ?>
                <?php foreach ($respuestas as $resp): ?>
                    <div class="reply-card">
                        <p><strong><?php echo htmlspecialchars($resp['Nom_User']); ?></strong> - <span><?php echo $resp['Fecha_Res']; ?></span></p>
                        <p><?php echo nl2br(htmlspecialchars($resp['Mensaje'])); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

        <section class="form-container" style="margin-top: 20px;">
            <h3>Responder a este hilo</h3>
            <form action="crear_respuesta.php" method="POST">
                <input type="hidden" name="pub_id" value="<?php echo $hilo['Pub_ID']; ?>">
                
                <div>
                    <label>Nombre</label>
                    <input type="text" name="nom_user" placeholder="Anónimo">
                </div>

                <div>
                    <label>Comentario</label>
                    <textarea name="mensaje" rows="2" required placeholder="Escribe tu respuesta..."></textarea>
                </div>

                <button type="submit">Enviar Respuesta</button>
            </form>
        </section>
    </main>

    <footer>
        <p>12 CHAN Imageboard Project v1.0</p>
    </footer>

</body>
</html>