-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 20-11-2026 a las 05:15:15
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
(20, 2, 'anime_manga', 'Anónimo', 'Recomienden animes', 'Díganme los mejores 67 animes que han visto', 'uploads/1795145039_imagen_2026-11-19_212305744.png', '2026-11-20 03:23:59');

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
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `Pub_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD CONSTRAINT `fk_publicaciones_tableros` FOREIGN KEY (`Tablero_ID`) REFERENCES `tableros` (`Tablero_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
