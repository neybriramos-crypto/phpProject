-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 30-04-2026 a las 00:55:10
-- Versión del servidor: 9.1.0
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `nomina`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

DROP TABLE IF EXISTS `departamentos`;
CREATE TABLE IF NOT EXISTS `departamentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id`, `nombre`) VALUES
(1, 'Desarrollo'),
(2, 'Diseño'),
(3, 'QA'),
(4, 'Marketing'),
(5, 'Contabilidad y Ventas'),
(6, 'RRHH');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

DROP TABLE IF EXISTS `empleados`;
CREATE TABLE IF NOT EXISTS `empleados` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_departamento` int DEFAULT NULL,
  `salario_base` decimal(10,2) DEFAULT '0.00',
  `bonos` decimal(10,2) DEFAULT '0.00',
  `pago_festivos` decimal(10,2) DEFAULT '0.00',
  `pago_horas_extras` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `id_departamento` (`id_departamento`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre`, `apellido`, `fecha_ingreso`, `username`, `password`, `id_departamento`, `salario_base`, `bonos`, `pago_festivos`, `pago_horas_extras`) VALUES
(3, 'Juan', 'Perez', '2026-04-28', 'juan_dev', '$2y$10$QjSHS9.SInSGYM96ZzL8A.m5uX.iR5G5p7BfG.5J8Yh6X/B.D5W6S', 1, 1200.00, 150.00, 0.00, 0.00),
(4, 'Neymar', 'Brito', '2026-04-29', 'neybri', '$2y$10$rjFQlOO5zg8VKlNv4KKNEuN6HNqV.bTfp9fvMuD6zoTVOmGkPEtku', 6, 1500.00, 0.00, 0.00, 0.00);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
