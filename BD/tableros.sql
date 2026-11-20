-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 20-11-2026 a las 05:11:01
-- Versión del servidor: 10.11.16-MariaDB
-- Versión de PHP: 8.3.36

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
(15, 'Estrategia', 'estrategia', '2026-11-20 02:15:14');

--
-- Índices para tablas volcadas
--

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
-- AUTO_INCREMENT de la tabla `tableros`
--
ALTER TABLE `tableros`
  MODIFY `Tablero_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
