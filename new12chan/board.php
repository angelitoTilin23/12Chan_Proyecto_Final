<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>12 CHAN - Tablón</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <h1>12 CHAN</h1>
        <nav>
            <a href="index.php">&larr; Volver al inicio</a>
        </nav>
    </header>

    <main class="main-layout">
        <!-- Menú lateral con los tablones oficiales del proyecto -->
        <aside class="boards-sidebar">
            <div class="boards-actions">
                <input type="text" placeholder="Buscar tableros...">
                <button type="button">Crear tablero</button>
            </div>

            <div class="board-category">
                <h3>CULTURA</h3>
                <ul>
                    <li><a href="board.php?tablero=cultura_japonesa">Cultura japonesa</a></li>
                    <li><a href="board.php?tablero=anime_manga">Anime y manga</a></li>
                    <li><a href="board.php?tablero=anime_cultura">Anime y cultura</a></li>
                    <li><a href="board.php?tablero=anime_flash">Anime y fondos de pantalla Flash</a></li>
                    <li><a href="board.php?tablero=cosplay_egl">Cosplay y EGL</a></li>
                    <li><a href="board.php?tablero=cultura_pop">Cultura pop</a></li>
                </ul>
            </div>

            <div class="board-category">
                <h3>ENTRETENIMIENTO</h3>
                <ul>
                    <li><a href="board.php?tablero=youtubers_virtuales">YouTubers virtuales</a></li>
                    <li><a href="board.php?tablero=videojuegos">Videojuegos</a></li>
                    <li><a href="board.php?tablero=videojuegos_retro">Videojuegos retro</a></li>
                    <li><a href="board.php?tablero=videojuegos_generales">Videojuegos generales</a></li>
                    <li><a href="board.php?tablero=videojuegos_multijugador">Videojuegos multijugador</a></li>
                    <li><a href="board.php?tablero=pokemon">Pokémon</a></li>
                    <li><a href="board.php?tablero=juegos_ritmo">Juegos de ritmo</a></li>
                    <li><a href="board.php?tablero=videojuegos_rol">Videojuegos de rol</a></li>
                    <li><a href="board.php?tablero=estrategia">Estrategia</a></li>
                </ul>
            </div>
        </aside>

        <!-- Contenido principal del tablón -->
        <section class="content-section">
            <div class="form-container">
                <h3>Compartir en el tablón</h3>
                <form action="crear_hilo.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="tablero" value="general">
                    
                    <div>
                        <label>Nombre</label>
                        <input type="text" name="nom_user" placeholder="Anónimo">
                    </div>

                    <div>
                        <label>Asunto</label>
                        <input type="text" name="titulo" required>
                    </div>

                    <div>
                        <label>Comentario</label>
                        <textarea name="mensaje" rows="3" required placeholder="Escribe algo..."></textarea>
                    </div>

                    <div>
                        <label>Seleccionar archivo</label>
                        <input type="file" name="imagen" accept="image/*">
                    </div>

                    <button type="submit">Compartir ahora</button>
                </form>
            </div>

            <hr>

            <div class="posts-list">
                <?php
                try {
                    $pdo = new PDO("mysql:host=localhost;dbname=12chan;charset=utf8mb4", "root", "");
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $stmt = $pdo->query("SELECT * FROM publicaciones ORDER BY Pub_ID DESC");
                    
                    while ($pub = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<article class='post-card'>";
                        
                        if (!empty($pub['Imagen'])) {
                            echo "<div class='post-img'><a href='{$pub['Imagen']}' target='_blank'><img src='{$pub['Imagen']}' alt='Imagen'></a></div>";
                        }
                        
                        echo "<div class='post-content'>";
                        echo "<h4>" . htmlspecialchars($pub['Titulo']) . "</h4>";
                        echo "<p><strong>" . htmlspecialchars($pub['Nom_User']) . "</strong> - <span>" . $pub['T_Pub'] . "</span> (No. {$pub['Pub_ID']})</p>";
                        echo "<p>" . nl2br(htmlspecialchars($pub['Mensaje'])) . "</p>";
                        echo "<p><a href='hilo.php?id={$pub['Pub_ID']}'>Ver respuestas y comentar</a></p>";
                        echo "</div>";
                        
                        echo "</article>";
                    }
                } catch (PDOException $e) {
                    echo "<p style='color: red;'>Error al conectar con la base de datos.</p>";
                }
                ?>
            </div>
        </section>
    </main>

    <footer>
        <p>12 CHAN Imageboard Project v1.0</p>
    </footer>

</body>
</html>