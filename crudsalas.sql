-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-05-2022 a las 03:21:39
-- Versión del servidor: 10.4.10-MariaDB
-- Versión de PHP: 7.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `crudsalas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pc`
--

CREATE TABLE `pc` (
  `CODIGO` varchar(10) NOT NULL,
  `SEDE` varchar(10) NOT NULL,
  `SALA` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pc`
--

INSERT INTO `pc` (`CODIGO`, `SEDE`, `SALA`) VALUES
('PC02', 'SE01', 'Sin asigna'),
('PC03', 'Sin asigna', 'SALA01'),
('PC04', 'SE02', 'SALA02'),
('PC05', 'SE01', 'SALA01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sala`
--

CREATE TABLE `sala` (
  `CODIGO` varchar(10) NOT NULL,
  `SEDE` varchar(10) NOT NULL,
  `CANTIDADPC` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sala`
--

INSERT INTO `sala` (`CODIGO`, `SEDE`, `CANTIDADPC`) VALUES
('SALA01', 'SE01', 11),
('SALA02', 'SE01', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sede`
--

CREATE TABLE `sede` (
  `NOMBRESEDE` varchar(30) NOT NULL,
  `CODIGO` varchar(10) NOT NULL,
  `DIRECCION` varchar(50) NOT NULL,
  `TELEFONO` int(11) NOT NULL,
  `CANTIDADSALAS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sede`
--

INSERT INTO `sede` (`NOMBRESEDE`, `CODIGO`, `DIRECCION`, `TELEFONO`, `CANTIDADSALAS`) VALUES
('COSMO', 'SE01', 'K 72 41C 64', 3851027, 2),
('20 de Julio', 'SE02', 'C 43 69E 05', 3851027, 3),
('ROMERIO', 'SE03', 'C 46 74  73', 3851027, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `NOMBRE` varchar(50) NOT NULL,
  `USERNAME` varchar(20) NOT NULL,
  `PASSWORD` varchar(40) NOT NULL,
  `CORREO` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`NOMBRE`, `USERNAME`, `PASSWORD`, `CORREO`) VALUES
('admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@admin.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pc`
--
ALTER TABLE `pc`
  ADD PRIMARY KEY (`CODIGO`);

--
-- Indices de la tabla `sala`
--
ALTER TABLE `sala`
  ADD PRIMARY KEY (`CODIGO`),
  ADD KEY `SEDE` (`SEDE`);

--
-- Indices de la tabla `sede`
--
ALTER TABLE `sede`
  ADD PRIMARY KEY (`CODIGO`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`USERNAME`);
ALTER TABLE `usuarios` ADD FULLTEXT KEY `NOMBRE` (`NOMBRE`,`USERNAME`,`PASSWORD`,`CORREO`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `sala`
--
ALTER TABLE `sala`
  ADD CONSTRAINT `sala_ibfk_1` FOREIGN KEY (`SEDE`) REFERENCES `sede` (`CODIGO`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
