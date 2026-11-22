
<?php
$id_hilo = $_GET['id'] ?? null;
if (!$id_hilo) {
    header("Location: board.php");
    exit();
}

$host = "127.0.0.1";
$port = "3307";
$dbname = "12chan";
$user = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $password);
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
    <link rel="stylesheet" href="../css/board_style.css">
    <script src="../js/app.js" defer></script>
</head>

<body>

    <header>
        <div class="logo">
            <div class="logo-icono">
                <img src="../css/img/Isotipo_fverde.png" alt="12 CHAN Logo">
            </div>
            <span>12 CHAN</span>
        </div>

        <div>
            <a href="board.php?tablero=<?php echo urlencode($hilo['Tablero']); ?>" class="salir">
                Volver al Tablón
            </a>
        </div>
    </header>

    <main class="main-layout" style="display: block; width: 80%; margin: 30px auto;">

        <article class="post-card main-thread" style="width: 100%;">

            <?php if (!empty($hilo['Imagen'])): ?>
                <div class="post-img">
                    <a href="<?php echo htmlspecialchars($hilo['Imagen']); ?>" target="_blank">
                        <img src="<?php echo htmlspecialchars($hilo['Imagen']); ?>" alt="Imagen">
                    </a>
                </div>
            <?php endif; ?>

            <div class="post-content">
                <h2><?php echo htmlspecialchars($hilo['Titulo']); ?></h2>

                <p>
                    <strong><?php echo htmlspecialchars($hilo['Nom_User']); ?></strong>
                    -
                    <span><?php echo $hilo['T_Pub']; ?></span>
                    (Tablón: /<?php echo htmlspecialchars($hilo['Tablero']); ?>/)
                </p>

                <p><?php echo nl2br(htmlspecialchars($hilo['Mensaje'])); ?></p>
            </div>

        </article>

        <hr style="margin: 20px 0;">

        <h3>Respuestas (<?php echo count($respuestas); ?>)</h3>

        <section class="posts-list" style="margin-top: 15px;">

            <?php if (empty($respuestas)): ?>

                <p>No hay respuestas aún. ¡Sé el primero en comentar!</p>

            <?php else: ?>

                <?php foreach ($respuestas as $resp): ?>

                    <div class="post-card" style="margin-bottom: 15px;">
                        <div class="post-content">

                            <p>
                                <strong><?php echo htmlspecialchars($resp['Nom_User']); ?></strong>
                                -
                                <span><?php echo $resp['Fecha_Res']; ?></span>
                            </p>

                            <p><?php echo nl2br(htmlspecialchars($resp['Mensaje'])); ?></p>

                        </div>
                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

        </section>

        <section class="form-container" style="margin-top: 30px;">

            <h3>Responder a este hilo</h3>

            <form action="crear_respuesta.php" method="POST">

                <input type="hidden" name="pub_id" value="<?php echo $hilo['Pub_ID']; ?>">

                <div style="margin-bottom: 15px;">
                    <label>Nombre</label>
                    <input type="text" name="nom_user" placeholder="Anónimo">
                </div>

                <div style="margin-bottom: 15px;">
                    <label>Comentario</label>
                    <textarea name="mensaje" rows="3" required placeholder="Escribe tu respuesta..."></textarea>
                </div>

                <button type="submit">Enviar Respuesta</button>

            </form>

        </section>

    </main>

    <footer class="pie">
        <strong>12 CHAN</strong>
        <span>Imageboard Project v1.0</span>
    </footer>

</body>
</html>
