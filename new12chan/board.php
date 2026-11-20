
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
// IDENTIFICAR TABLERO DESDE LA BASE DE DATOS
// ==========================================

$tablero_actual = $_GET['tablero'] ?? 'cultura_japonesa';

$stmtTablero = $pdo->prepare(
    "SELECT Tablero_ID, Nombre, Slug
     FROM tableros
     WHERE Slug = ?
     LIMIT 1"
);

$stmtTablero->execute([$tablero_actual]);

$tablero = $stmtTablero->fetch();

if (!$tablero) {
    http_response_code(404);
    die("El tablón solicitado no existe.");
}

// Datos oficiales del tablero
$tablero_id = (int) $tablero['Tablero_ID'];
$tablero_actual = $tablero['Slug'];
$tablero_mostrar = $tablero['Nombre'];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>12 CHAN - Tablón: <?php echo htmlspecialchars($tablero_mostrar); ?></title>

    <link rel="stylesheet" href="../css/board_style.css">
</head>

<body>

    <!-- ==================================
         ENCABEZADO
    =================================== -->

    <header>

        <div class="logo">

            <div class="logo-icono">
                <img src="../css/img/Isotipo_fverde.png" alt="12 CHAN Logo">
            </div>

            <span>12 CHAN</span>

        </div>

        <div>
            <a href="index.php" class="salir">Cerrar Sesión</a>
        </div>

    </header>


    <!-- ==================================
         ESTRUCTURA PRINCIPAL
    =================================== -->

    <main class="main-layout">

        <!-- MENÚ LATERAL DE TABLEROS -->

        <aside class="boards-sidebar">

            <div class="boards-actions">

                <input
                    type="text"
                    id="buscadorTableros"
                    placeholder="Buscar tableros..."
                >

                <!-- Crear nuevas comunidades -->

                <div style="margin-top: 10px;">

                    <input
                        type="text"
                        id="nuevoTableroInput"
                        placeholder="Nombre nuevo tablero..."
                        style="margin-bottom: 5px;"
                    >

                    <button type="button">
                        Crear tablero
                    </button>

                </div>

            </div>


            <!-- COMUNIDADES CREADAS -->

            <div class="board-category" id="seccionComunidades">

                <h3>COMUNIDADES</h3>

                <ul id="listaComunidades" class="lista-enlaces">
                    <!-- Comunidades cargadas dinámicamente -->
                </ul>

            </div>


            <!-- CATEGORÍA CULTURA -->

            <div class="board-category">

                <h3>CULTURA</h3>

                <ul class="lista-enlaces">

                    <li><a href="board.php?tablero=cultura_japonesa">Cultura japonesa</a></li>

                    <li><a href="board.php?tablero=anime_manga">Anime y manga</a></li>

                    <li><a href="board.php?tablero=anime_cultura">Anime y cultura</a></li>

                    <li><a href="board.php?tablero=anime_flash">Anime y fondos de pantalla Flash</a></li>

                    <li><a href="board.php?tablero=cosplay_egl">Cosplay y EGL</a></li>

                    <li><a href="board.php?tablero=cultura_pop">Cultura pop</a></li>

                </ul>

            </div>


            <!-- CATEGORÍA ENTRETENIMIENTO -->

            <div class="board-category">

                <h3>ENTRETENIMIENTO</h3>

                <ul class="lista-enlaces">

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


        <!-- ==================================
             CONTENIDO PRINCIPAL
        =================================== -->

        <section class="content-section">

            <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">

                <h2 style="color: #007548;">
                    Tablón: <?php echo htmlspecialchars($tablero_mostrar); ?>
                </h2>

                <button
                    type="button"
                    id="btnToggleForm"
                    style="padding: 11px 20px; background-color: #007548; color: #fff; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;"
                >
                    + Crear publicación
                </button>

            </div>


            <!-- ==================================
                 FORMULARIO DE PUBLICACIONES
            =================================== -->

            <div
                class="form-container"
                id="formPublicarContainer"
                style="display: none; margin-bottom: 25px;"
            >

                <h3>
                    Compartir en el tablón: <?php echo htmlspecialchars($tablero_mostrar); ?>
                </h3>

                <form
                    action="crear_hilo.php"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    <!-- IMPORTANTE: conservar el identificador original -->

                    <input
                        type="hidden"
                        name="tablero_id"
                        value="<?php echo $tablero_id; ?>"
                    >

                    <input
                        type="hidden"
                        name="tablero"
                        value="<?php echo htmlspecialchars($tablero_actual, ENT_QUOTES, 'UTF-8'); ?>"
                    >


                    <div>

                        <label>Nombre</label>

                        <input
                            type="text"
                            name="nom_user"
                            placeholder="Anónimo"
                        >

                    </div>


                    <div>

                        <label>Asunto</label>

                        <input
                            type="text"
                            name="titulo"
                            required
                            placeholder="Escribe algo..."
                        >

                    </div>


                    <div>

                        <label>Comentario</label>

                        <textarea
                            name="mensaje"
                            rows="3"
                            required
                            placeholder="Escribe algo..."
                        ></textarea>

                    </div>


                    <div>

                        <label>Seleccionar archivo</label>

                        <label for="imagen" class="archivo-btn">

                            <img
                                src="../css/img/icono_archivos.png"
                                alt="Icono de archivo"
                            >

                        </label>

                        <input
                            type="file"
                            id="imagen"
                            name="imagen"
                            accept="image/*"
                            hidden
                        >

                    </div>


                    <button type="submit">
                        Compartir ahora en <?php echo htmlspecialchars($tablero_mostrar); ?>
                    </button>

                </form>

            </div>


            <hr>


            <!-- ==================================
                 LISTADO DE PUBLICACIONES
            =================================== -->

            <div class="posts-list">

                <?php

                try {

                    $stmt = $pdo->prepare(
                        "SELECT *
                         FROM publicaciones
                         WHERE Tablero_ID = ?
                         ORDER BY Pub_ID DESC"
                    );

                    $stmt->execute([$tablero_id]);

                    $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);


                    if (empty($publicaciones)) {

                        echo "<p>No hay publicaciones en este tablero todavía. ¡Sé el primero en compartir algo!</p>";

                    } else {

                        foreach ($publicaciones as $pub) {

                            echo "<article class='post-card'>";


                            // IMAGEN DE LA PUBLICACIÓN

                            if (!empty($pub['Imagen'])) {

                                $imagen = htmlspecialchars(
                                    $pub['Imagen'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                );

                                echo "<div class='post-img'>";

                                echo "<a href='$imagen' target='_blank' rel='noopener noreferrer'>";

                                echo "<img src='$imagen' alt='Imagen'>";

                                echo "</a>";

                                echo "</div>";

                            }


                            // CONTENIDO DE LA PUBLICACIÓN

                            echo "<div class='post-content'>";


                            echo "<h4>" .
                                htmlspecialchars($pub['Titulo']) .
                                "</h4>";


                            echo "<p><strong>" .
                                htmlspecialchars($pub['Nom_User']) .
                                "</strong> - <span>" .
                                htmlspecialchars($pub['T_Pub']) .
                                "</span> (No. " .
                                htmlspecialchars($pub['Pub_ID']) .
                                ")</p>";


                            echo "<p>" .
                                nl2br(htmlspecialchars($pub['Mensaje'])) .
                                "</p>";


                            // ENLACE AL HILO

                            echo "<p>";

                            echo "<a href='hilo.php?id=" .
                                urlencode($pub['Pub_ID']) .
                                "'>Ver respuestas y comentar</a>";

                            echo "</p>";


                            echo "</div>";

                            echo "</article>";

                        }

                    }

                } catch (PDOException $e) {

                    echo "<p style='color: red;'>Error al consultar la base de datos.</p>";

                }

                ?>

            </div>

        </section>

    </main>


    <!-- ==================================
         PIE DE PÁGINA
    =================================== -->

    <footer class="pie">

        <div class="logo-footer">

            <img
                src="../css/img/Isotipo_fblanco.png"
                alt="12 CHAN Logo Blanco"
            >

        </div>

        <strong>12 CHAN</strong>

        <span>Imageboard Project v1.0</span>

    </footer>

</body>

</html>
