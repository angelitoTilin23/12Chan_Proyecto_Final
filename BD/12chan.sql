-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 22-11-2026 a las 02:35:40
-- Versión del servidor: 10.11.19-MariaDB
-- Versión de PHP: 8.5.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `12chan`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE `publicaciones` (
  `Pub_ID` int(11) NOT NULL,
  `Tablero_ID` int(11) NOT NULL,
  `Tablero` varchar(50) NOT NULL,
  `Nom_User` varchar(50) NOT NULL,
  `Titulo` varchar(150) NOT NULL,
  `Mensaje` text NOT NULL,
  `Imagen` varchar(255) NOT NULL,
  `T_Pub` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`Pub_ID`, `Tablero_ID`, `Tablero`, `Nom_User`, `Titulo`, `Mensaje`, `Imagen`, `T_Pub`) VALUES
(17, 1, 'cultura_japonesa', 'Anónimo', '¿Qué comida o costumbre japonesa probarían sí o sí?', 'Dejando de lado el ramen y el sushi de siempre, ¿qué cosa rara o curiosa de Japón les da ganas de probar? Yo muero por entrar a un konbini a las 3 de la mañana.', 'uploads/1795144406_imagen_2026-11-19_210413176.png', '2026-11-20 03:13:26'),
(18, 2, 'anime_manga', 'Naruto_6767', '¿Qué están viendo o leyendo ahorita?', 'Pasen recomendaciones rápidas. Necesito algo bueno para maratonear este fin de semana, de preferencia que no tenga 500 capítulos de relleno.', 'uploads/1795144546_imagen_2026-11-19_211545505.png', '2026-11-20 03:15:46'),
(19, 2, 'anime_manga', 'Anónimo', '¿Algún hobby que empezaron por culpa de un anime?', 'Se vale todo: desde querer aprender a cocinar, tocar un instrumento o hasta meterse al gimnasio por ver Hajime no Ippo. ¿A quién más le pasó?', 'uploads/1795144658_imagen_2026-11-19_211735546.png', '2026-11-20 03:17:38'),
(20, 2, 'anime_manga', 'Anónimo', 'Recomienden animes', 'Díganme los mejores 67 animes que han visto', 'uploads/1795145039_imagen_2026-11-19_212305744.png', '2026-11-20 03:23:59'),
(21, 4, 'anime_flash', 'Anonimo', 'One Punch Man', 'Fondo de pantalla de garou vs saitama (resolucion 1440x900)', 'uploads/1795309551_wallpaperflare.com_wallpaper (15).jpg', '2026-11-22 01:05:51'),
(22, 19, 'basketball', 'Anonimo', '¿Quien es el mejor jugador de todos los tiempos?', 'Para mi el mejor jugador es y siempre sera Kobe Bean Bryant', 'uploads/1795311106_kobe bryant.png', '2026-11-22 01:31:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `Res_ID` int(11) NOT NULL,
  `Pub_ID` int(11) NOT NULL,
  `Nom_User` varchar(50) NOT NULL,
  `Mensaje` text NOT NULL,
  `Fecha_Res` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`Res_ID`, `Pub_ID`, `Nom_User`, `Mensaje`, `Fecha_Res`) VALUES
(7, 17, 'Anónimo', 'Yo no soy fan del sushi ni del ramen pero a veces se me antoja probar la comida exótica que venden en Japón', '2026-11-20 03:25:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tableros`
--

CREATE TABLE `tableros` (
  `Tablero_ID` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Slug` varchar(50) NOT NULL,
  `Fecha_Creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tableros`
--

INSERT INTO `tableros` (`Tablero_ID`, `Nombre`, `Slug`, `Fecha_Creacion`) VALUES
(1, 'Cultura japonesa', 'cultura_japonesa', '2026-11-20 02:15:14'),
(2, 'Anime y manga', 'anime_manga', '2026-11-20 02:15:14'),
(3, 'Anime y cultura', 'anime_cultura', '2026-11-20 02:15:14'),
(4, 'Anime y fondos de pantalla Flash', 'anime_flash', '2026-11-20 02:15:14'),
(5, 'Cosplay y EGL', 'cosplay_egl', '2026-11-20 02:15:14'),
(6, 'Cultura pop', 'cultura_pop', '2026-11-20 02:15:14'),
(7, 'YouTubers virtuales', 'youtubers_virtuales', '2026-11-20 02:15:14'),
(8, 'Videojuegos', 'videojuegos', '2026-11-20 02:15:14'),
(9, 'Videojuegos retro', 'videojuegos_retro', '2026-11-20 02:15:14'),
(10, 'Videojuegos generales', 'videojuegos_generales', '2026-11-20 02:15:14'),
(11, 'Videojuegos multijugador', 'videojuegos_multijugador', '2026-11-20 02:15:14'),
(12, 'Pokémon', 'pokemon', '2026-11-20 02:15:14'),
(13, 'Juegos de ritmo', 'juegos_ritmo', '2026-11-20 02:15:14'),
(14, 'Videojuegos de rol', 'videojuegos_rol', '2026-11-20 02:15:14'),
(15, 'Estrategia', 'estrategia', '2026-11-20 02:15:14'),
(16, 'Gimnasio', 'gimnasio', '2026-11-22 01:10:29'),
(17, 'Deportes', 'deportes', '2026-11-22 01:15:41'),
(19, 'Basketball', 'basketball', '2026-11-22 01:16:52'),
(20, 'Soccer', 'soccer', '2026-11-22 01:26:51');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`Pub_ID`),
  ADD KEY `idx_publicaciones_tablero` (`Tablero_ID`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`Res_ID`),
  ADD KEY `Pub_ID` (`Pub_ID`);

--
-- Indices de la tabla `tableros`
--
ALTER TABLE `tableros`
  ADD PRIMARY KEY (`Tablero_ID`),
  ADD UNIQUE KEY `uq_tableros_slug` (`Slug`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `Pub_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `Res_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tableros`
--
ALTER TABLE `tableros`
  MODIFY `Tablero_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `fk_respuestas_publicaciones` FOREIGN KEY (`Pub_ID`) REFERENCES `publicaciones` (`Pub_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
