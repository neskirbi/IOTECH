-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 02-02-2026 a las 18:39:06
-- Versión del servidor: 10.6.24-MariaDB-cll-lve
-- Versión de PHP: 8.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `citas_csmx`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adinspecciones`
--

CREATE TABLE `adinspecciones` (
  `id` varchar(32) NOT NULL,
  `id_inspeccion` varchar(32) NOT NULL,
  `archivo` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `adinspecciones`
--

INSERT INTO `adinspecciones` (`id`, `id_inspeccion`, `archivo`, `created_at`, `updated_at`) VALUES
('a1b2c3d4e5f678901234567890123456', 'b2c3d4e5f6789012345678901234567', 'inspeccion_001.pdf', '2024-01-15 10:00:00', '2024-01-15 10:00:00'),
('b2c3d4e5f6789012345678901234567', 'c3d4e5f67890123456789012345678', 'inspeccion_002.pdf', '2024-01-16 11:00:00', '2024-01-16 11:00:00'),
('c3d4e5f67890123456789012345678', 'd4e5f678901234567890123456789', 'inspeccion_003.pdf', '2024-01-17 12:00:00', '2024-01-17 12:00:00'),
('d4e5f678901234567890123456789', 'e5f6789012345678901234567890', 'inspeccion_004.pdf', '2024-01-18 13:00:00', '2024-01-18 13:00:00'),
('e5f6789012345678901234567890', 'f67890123456789012345678901', 'inspeccion_005.pdf', '2024-01-19 14:00:00', '2024-01-19 14:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL DEFAULT '',
  `administrador` varchar(150) NOT NULL,
  `cargo` varchar(150) NOT NULL DEFAULT '',
  `firma` longtext NOT NULL DEFAULT '',
  `mail` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `principal` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `passtemp` varchar(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id`, `id_planta`, `administrador`, `cargo`, `firma`, `mail`, `pass`, `remember_token`, `principal`, `created_at`, `updated_at`, `passtemp`) VALUES
('f67890123456789012345678901234', '12345678901234567890123456789012', 'Juan Pérez', 'Administrador General', '', 'juan@empresa.com', '$2y$10$abcdefghijklmnopqrstuv', NULL, 1, '2024-01-01 08:00:00', '2024-01-01 08:00:00', ''),
('789012345678901234567890123456', '23456789012345678901234567890123', 'María García', 'Administradora de Planta', '', 'maria@empresa.com', '$2y$10$abcdefghijklmnopqrstuv', NULL, 0, '2024-01-02 09:00:00', '2024-01-02 09:00:00', ''),
('890123456789012345678901234567', '34567890123456789012345678901234', 'Carlos López', 'Supervisor', '', 'carlos@empresa.com', '$2y$10$abcdefghijklmnopqrstuv', NULL, 0, '2024-01-03 10:00:00', '2024-01-03 10:00:00', ''),
('901234567890123456789012345678', '45678901234567890123456789012345', 'Ana Rodríguez', 'Coordinadora', '', 'ana@empresa.com', '$2y$10$abcdefghijklmnopqrstuv', NULL, 0, '2024-01-04 11:00:00', '2024-01-04 11:00:00', ''),
('012345678901234567890123456789', '56789012345678901234567890123456', 'Pedro Martínez', 'Administrador Jr', '', 'pedro@empresa.com', '$2y$10$abcdefghijklmnopqrstuv', NULL, 0, '2024-01-05 12:00:00', '2024-01-05 12:00:00', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agregados`
--

CREATE TABLE `agregados` (
  `id` varchar(32) NOT NULL,
  `categoria` varchar(150) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `agregados`
--

INSERT INTO `agregados` (`id`, `categoria`, `nombre`, `descripcion`, `created_at`, `updated_at`) VALUES
('12345678901234567890123456789012', 'Grava', 'Grava 3/4', 'Grava de 3/4 pulgada', '2024-01-10 08:00:00', '2024-01-10 08:00:00'),
('23456789012345678901234567890123', 'Arena', 'Arena Lavada', 'Arena fina lavada', '2024-01-11 09:00:00', '2024-01-11 09:00:00'),
('34567890123456789012345678901234', 'Piedra', 'Piedra Bola', 'Piedra bola para decoración', '2024-01-12 10:00:00', '2024-01-12 10:00:00'),
('45678901234567890123456789012345', 'Base', 'Base Hidráulica', 'Base para pavimentos', '2024-01-13 11:00:00', '2024-01-13 11:00:00'),
('56789012345678901234567890123456', 'Tepetate', 'Tepetate Compactado', 'Material para terracerías', '2024-01-14 12:00:00', '2024-01-14 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `appkeys`
--

CREATE TABLE `appkeys` (
  `id` varchar(32) NOT NULL,
  `app` varchar(32) NOT NULL,
  `token` varchar(32) NOT NULL,
  `municipio` varchar(150) NOT NULL DEFAULT '',
  `bloqueado` int(11) NOT NULL DEFAULT 0,
  `consumo` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `appkeys`
--

INSERT INTO `appkeys` (`id`, `app`, `token`, `municipio`, `bloqueado`, `consumo`, `created_at`, `updated_at`) VALUES
('67890123456789012345678901234567', 'citas_movil', 'abc123def456ghi789jkl012mno345', 'Tlalnepantla', 0, 150, '2024-01-20 10:00:00', '2024-01-20 10:00:00'),
('78901234567890123456789012345678', 'citas_web', 'pqr678stu901vwx234yz567abc890', 'Naucalpan', 0, 89, '2024-01-21 11:00:00', '2024-01-21 11:00:00'),
('89012345678901234567890123456789', 'admin_app', 'def456ghi789jkl012mno345pqr678', 'Ecatepec', 0, 45, '2024-01-22 12:00:00', '2024-01-22 12:00:00'),
('90123456789012345678901234567890', 'chofer_app', 'ghi789jkl012mno345pqr678stu901', 'Toluca', 0, 230, '2024-01-23 13:00:00', '2024-01-23 13:00:00'),
('01234567890123456789012345678901', 'ventas_app', 'jkl012mno345pqr678stu901vwx234', 'Cuautitlán', 0, 67, '2024-01-24 14:00:00', '2024-01-24 14:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones`
--

CREATE TABLE `asignaciones` (
  `id` varchar(32) NOT NULL,
  `id_venta` varchar(32) NOT NULL,
  `id_obra` varchar(32) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `asignaciones`
--

INSERT INTO `asignaciones` (`id`, `id_venta`, `id_obra`, `created_at`, `updated_at`) VALUES
('11223344556677889900112233445566', '223344556677889900112233445566', '334455667788990011223344556677', '2024-02-01 09:00:00', '2024-02-01 09:00:00'),
('22334455667788990011223344556677', '334455667788990011223344556677', '445566778899001122334455667788', '2024-02-02 10:00:00', '2024-02-02 10:00:00'),
('33445566778899001122334455667788', '445566778899001122334455667788', '556677889900112233445566778899', '2024-02-03 11:00:00', '2024-02-03 11:00:00'),
('44556677889900112233445566778899', '556677889900112233445566778899', '667788990011223344556677889900', '2024-02-04 12:00:00', '2024-02-04 12:00:00'),
('55667788990011223344556677889900', '667788990011223344556677889900', '778899001122334455667788990011', '2024-02-05 13:00:00', '2024-02-05 13:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asociados`
--

CREATE TABLE `asociados` (
  `id` varchar(32) NOT NULL,
  `asociado` varchar(150) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `passtemp` varchar(20) NOT NULL DEFAULT '',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `asociados`
--

INSERT INTO `asociados` (`id`, `asociado`, `mail`, `pass`, `passtemp`, `remember_token`, `created_at`, `updated_at`) VALUES
('66778899001122334455667788990011', 'Constructora ABC', 'info@constructoraabc.com', 'pass123', '', NULL, '2024-02-10 08:00:00', '2024-02-10 08:00:00'),
('77889900112233445566778899001122', 'Ingeniería XYZ', 'contacto@ingenieriaxyz.com', 'pass456', '', NULL, '2024-02-11 09:00:00', '2024-02-11 09:00:00'),
('88990011223344556677889900112233', 'Desarrollos Pro', 'ventas@desarrollospro.com', 'pass789', '', NULL, '2024-02-12 10:00:00', '2024-02-12 10:00:00'),
('99001122334455667788990011223344', 'Construcciones Modernas', 'admin@constmodernas.com', 'pass012', '', NULL, '2024-02-13 11:00:00', '2024-02-13 11:00:00'),
('00112233445566778899001122334455', 'Obras Civiles SA', 'obras@civiles.com', 'pass345', '', NULL, '2024-02-14 12:00:00', '2024-02-14 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banners`
--

CREATE TABLE `banners` (
  `id` varchar(32) NOT NULL,
  `tipo` int(1) NOT NULL,
  `tiponombre` varchar(32) NOT NULL,
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `enlace` varchar(500) NOT NULL DEFAULT '',
  `mail` longtext NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `banners`
--

INSERT INTO `banners` (`id`, `tipo`, `tiponombre`, `nombre`, `enlace`, `mail`, `created_at`, `updated_at`) VALUES
('22334455667788990011223344556677', 1, 'Principal', 'Banner Ofertas', 'https://empresa.com/ofertas', '', '2024-02-15 09:00:00', '2024-02-15 09:00:00'),
('33445566778899001122334455667788', 2, 'Secundario', 'Banner Nuevos Productos', 'https://empresa.com/nuevos', '', '2024-02-16 10:00:00', '2024-02-16 10:00:00'),
('44556677889900112233445566778899', 3, 'Promocional', 'Banner Descuentos', 'https://empresa.com/descuentos', '', '2024-02-17 11:00:00', '2024-02-17 11:00:00'),
('55667788990011223344556677889900', 1, 'Principal', 'Banner Invierno', 'https://empresa.com/invierno', '', '2024-02-18 12:00:00', '2024-02-18 12:00:00'),
('66778899001122334455667788990011', 2, 'Secundario', 'Banner Servicios', 'https://empresa.com/servicios', '', '2024-02-19 13:00:00', '2024-02-19 13:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `basculas`
--

CREATE TABLE `basculas` (
  `id` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `mail` varchar(150) NOT NULL,
  `pass` varchar(250) NOT NULL,
  `passtemp` varchar(20) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `basculas`
--

INSERT INTO `basculas` (`id`, `id_planta`, `nombre`, `mail`, `pass`, `passtemp`, `created_at`, `updated_at`) VALUES
('77889900112233445566778899001122', '12345678901234567890123456789012', 'Bascula Norte', 'bascula@planta1.com', 'bascula123', '', '2024-02-20 08:00:00', '2024-02-20 08:00:00'),
('88990011223344556677889900112233', '23456789012345678901234567890123', 'Bascula Sur', 'bascula@planta2.com', 'bascula456', '', '2024-02-21 09:00:00', '2024-02-21 09:00:00'),
('99001122334455667788990011223344', '34567890123456789012345678901234', 'Bascula Este', 'bascula@planta3.com', 'bascula789', '', '2024-02-22 10:00:00', '2024-02-22 10:00:00'),
('00112233445566778899001122334455', '45678901234567890123456789012345', 'Bascula Oeste', 'bascula@planta4.com', 'bascula012', '', '2024-02-23 11:00:00', '2024-02-23 11:00:00'),
('11223344556677889900112233445566', '56789012345678901234567890123456', 'Bascula Central', 'bascula@planta5.com', 'bascula345', '', '2024-02-24 12:00:00', '2024-02-24 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoriasmaterial`
--

CREATE TABLE `categoriasmaterial` (
  `id` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL DEFAULT '',
  `categoriamaterial` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categoriasmaterial`
--

INSERT INTO `categoriasmaterial` (`id`, `id_planta`, `categoriamaterial`, `created_at`, `updated_at`) VALUES
('33445566778899001122334455667788', '12345678901234567890123456789012', 'Áridos', '2024-03-01 08:00:00', '2024-03-01 08:00:00'),
('44556677889900112233445566778899', '23456789012345678901234567890123', 'Concretos', '2024-03-02 09:00:00', '2024-03-02 09:00:00'),
('55667788990011223344556677889900', '34567890123456789012345678901234', 'Prefabricados', '2024-03-03 10:00:00', '2024-03-03 10:00:00'),
('66778899001122334455667788990011', '45678901234567890123456789012345', 'Aceros', '2024-03-04 11:00:00', '2024-03-04 11:00:00'),
('77889900112233445566778899001122', '56789012345678901234567890123456', 'Maderas', '2024-03-05 12:00:00', '2024-03-05 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chalanes`
--

CREATE TABLE `chalanes` (
  `id` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL,
  `chalan` varchar(150) NOT NULL,
  `mail` varchar(150) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `passtemp` varchar(20) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `chalanes`
--

INSERT INTO `chalanes` (`id`, `id_planta`, `chalan`, `mail`, `pass`, `passtemp`, `created_at`, `updated_at`) VALUES
('88990011223344556677889900112233', '12345678901234567890123456789012', 'José Hernández', 'jose@empresa.com', 'chalan123', '', '2024-03-10 08:00:00', '2024-03-10 08:00:00'),
('99001122334455667788990011223344', '23456789012345678901234567890123', 'Miguel Torres', 'miguel@empresa.com', 'chalan456', '', '2024-03-11 09:00:00', '2024-03-11 09:00:00'),
('00112233445566778899001122334455', '34567890123456789012345678901234', 'Francisco Ruiz', 'francisco@empresa.com', 'chalan789', '', '2024-03-12 10:00:00', '2024-03-12 10:00:00'),
('11223344556677889900112233445566', '45678901234567890123456789012345', 'Roberto Díaz', 'roberto@empresa.com', 'chalan012', '', '2024-03-13 11:00:00', '2024-03-13 11:00:00'),
('22334455667788990011223344556677', '56789012345678901234567890123456', 'Javier Castro', 'javier@empresa.com', 'chalan345', '', '2024-03-14 12:00:00', '2024-03-14 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `choferes`
--

CREATE TABLE `choferes` (
  `id` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL DEFAULT '',
  `nombres` varchar(150) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `cuenta` varchar(30) NOT NULL DEFAULT '',
  `nombret` varchar(50) NOT NULL DEFAULT '',
  `banco` varchar(30) NOT NULL DEFAULT '',
  `licencia` varchar(150) NOT NULL,
  `telefono` varchar(50) NOT NULL DEFAULT '',
  `pass` varchar(255) NOT NULL DEFAULT '',
  `verificado` tinyint(4) NOT NULL DEFAULT 0,
  `telefonoverificado` tinyint(4) NOT NULL DEFAULT 0,
  `tipo` int(1) NOT NULL DEFAULT 0,
  `token` varchar(32) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `choferes`
--

INSERT INTO `choferes` (`id`, `id_planta`, `nombres`, `apellidos`, `cuenta`, `nombret`, `banco`, `licencia`, `telefono`, `pass`, `verificado`, `telefonoverificado`, `tipo`, `token`, `created_at`, `updated_at`) VALUES
('44556677889900112233445566778899', '12345678901234567890123456789012', 'Luis', 'Gómez', '1234567890', 'Luis Gómez', 'Bancomer', 'LIC123456789', '5512345678', 'chofer123', 1, 1, 1, '', '2024-03-15 08:00:00', '2024-03-15 08:00:00'),
('55667788990011223344556677889900', '23456789012345678901234567890123', 'Ricardo', 'Sánchez', '2345678901', 'Ricardo Sánchez', 'Santander', 'LIC234567890', '5523456789', 'chofer456', 1, 1, 1, '', '2024-03-16 09:00:00', '2024-03-16 09:00:00'),
('66778899001122334455667788990011', '34567890123456789012345678901234', 'Fernando', 'Ramírez', '3456789012', 'Fernando Ramírez', 'HSBC', 'LIC345678901', '5534567890', 'chofer789', 1, 1, 1, '', '2024-03-17 10:00:00', '2024-03-17 10:00:00'),
('77889900112233445566778899001122', '45678901234567890123456789012345', 'Alberto', 'Mendoza', '4567890123', 'Alberto Mendoza', 'BBVA', 'LIC456789012', '5545678901', 'chofer012', 1, 1, 1, '', '2024-03-18 11:00:00', '2024-03-18 11:00:00'),
('88990011223344556677889900112233', '56789012345678901234567890123456', 'Gabriel', 'Vargas', '5678901234', 'Gabriel Vargas', 'Scotia', 'LIC567890123', '5556789012', 'chofer345', 1, 1, 1, '', '2024-03-19 12:00:00', '2024-03-19 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` varchar(32) NOT NULL,
  `id_obra` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL DEFAULT '',
  `planta` varchar(150) NOT NULL,
  `plantaauto` varchar(150) NOT NULL,
  `direccionplanta` varchar(350) NOT NULL,
  `fechacita` datetime NOT NULL,
  `nautorizacion` varchar(100) NOT NULL,
  `distancia` float(7,2) NOT NULL DEFAULT 0.00,
  `razonsocial` mediumtext NOT NULL,
  `calleynumerofis` varchar(150) NOT NULL,
  `coloniafis` varchar(150) NOT NULL,
  `municipiofis` varchar(150) NOT NULL,
  `cpfis` varchar(150) NOT NULL,
  `obra` varchar(10000) NOT NULL,
  `calleynumeroobr` varchar(500) NOT NULL,
  `coloniaobr` varchar(500) NOT NULL,
  `municipioobr` varchar(150) NOT NULL,
  `cpobr` varchar(150) NOT NULL,
  `telefono` varchar(150) NOT NULL,
  `nombreres` varchar(150) NOT NULL DEFAULT '',
  `firmares` longtext NOT NULL DEFAULT '',
  `id_materialobra` varchar(32) NOT NULL,
  `categoria` varchar(150) NOT NULL DEFAULT '',
  `material` varchar(350) NOT NULL,
  `unidades` varchar(10) NOT NULL,
  `precio` float(20,2) NOT NULL,
  `cantidad` float(20,2) NOT NULL,
  `iva` float(5,2) NOT NULL DEFAULT 16.00,
  `vehiculo` varchar(100) NOT NULL,
  `marcaymodelo` varchar(100) NOT NULL,
  `matricula` varchar(100) NOT NULL,
  `ramir` varchar(100) NOT NULL,
  `regsct` varchar(100) NOT NULL,
  `id_chofer` varchar(32) NOT NULL DEFAULT '',
  `nombrecompleto` varchar(150) NOT NULL,
  `firmachof` longtext NOT NULL DEFAULT '',
  `combustible` varchar(50) NOT NULL,
  `condicionesmaterial` varchar(100) NOT NULL,
  `observacion` varchar(500) NOT NULL DEFAULT '',
  `recibio` varchar(150) NOT NULL DEFAULT '',
  `firmarecibio` longtext NOT NULL DEFAULT '',
  `cargo` varchar(150) NOT NULL DEFAULT '',
  `confirmacion` int(11) NOT NULL DEFAULT 0,
  `foliofiscal` varchar(50) NOT NULL DEFAULT '',
  `borrado` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `razonvehiculo` varchar(250) NOT NULL,
  `direccionvehiculo` varchar(500) NOT NULL,
  `telefonovehiculo` varchar(150) NOT NULL,
  `folio` int(20) DEFAULT 0,
  `latitud` varchar(50) NOT NULL DEFAULT '',
  `longitud` varchar(50) NOT NULL DEFAULT '',
  `CodigoSAP` varchar(50) NOT NULL DEFAULT '',
  `ProcesadoSAP` datetime DEFAULT NULL,
  `qr` int(1) NOT NULL DEFAULT 0,
  `infirebase` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id`, `id_obra`, `id_planta`, `planta`, `plantaauto`, `direccionplanta`, `fechacita`, `nautorizacion`, `distancia`, `razonsocial`, `calleynumerofis`, `coloniafis`, `municipiofis`, `cpfis`, `obra`, `calleynumeroobr`, `coloniaobr`, `municipioobr`, `cpobr`, `telefono`, `nombreres`, `firmares`, `id_materialobra`, `categoria`, `material`, `unidades`, `precio`, `cantidad`, `iva`, `vehiculo`, `marcaymodelo`, `matricula`, `ramir`, `regsct`, `id_chofer`, `nombrecompleto`, `firmachof`, `combustible`, `condicionesmaterial`, `observacion`, `recibio`, `firmarecibio`, `cargo`, `confirmacion`, `foliofiscal`, `borrado`, `created_at`, `updated_at`, `razonvehiculo`, `direccionvehiculo`, `telefonovehiculo`, `folio`, `latitud`, `longitud`, `CodigoSAP`, `ProcesadoSAP`, `qr`, `infirebase`) VALUES
('55667788990011223344556677889900', '667788990011223344556677889900', '12345678901234567890123456789012', 'Planta Norte', 'PN001', 'Av. Principal 123', '2024-03-20 09:00:00', 'AUT001', 15.50, 'Constructora ABC SA de CV', 'Reforma 456', 'Centro', 'Tlalnepantla', '54000', 'Torres Reforma', 'Insurgentes 789', 'Polanco', 'Miguel Hidalgo', '11560', '5512345678', 'Ing. Juan Pérez', '', '778899001122334455667788990011', 'Concreto', 'Concreto 250 kg/cm²', 'm³', 2500.00, 10.00, 16.00, 'Camión Revolvedor', 'Freightliner', 'ABC123', 'RAM001', 'SCT001', '44556677889900112233445566778899', 'Luis Gómez', '', 'Diesel', 'Nuevo', 'Entregar en muelle 3', 'Arq. Ana López', '', 'Residente', 1, '', 0, '2024-03-19 08:00:00', '2024-03-19 08:00:00', 'Transportes Rápidos SA', 'Periférico 321', '5566778899', 1001, '19.5369', '-99.1964', 'SAP001', NULL, 1, 1),
('66778899001122334455667788990011', '778899001122334455667788990011', '23456789012345678901234567890123', 'Planta Sur', 'PS002', 'Eje Central 456', '2024-03-21 10:00:00', 'AUT002', 12.30, 'Ingeniería XYZ SA', 'Hidalgo 789', 'Downtown', 'Naucalpan', '53100', 'Plaza Comercial', 'Juárez 101', 'Lomas', 'Naucalpan', '53600', '5523456789', 'Ing. María García', '', '889900112233445566778899001122', 'Grava', 'Grava 3/4', 'm³', 800.00, 15.00, 16.00, 'Volteo', 'International', 'DEF456', 'RAM002', 'SCT002', '55667788990011223344556677889900', 'Ricardo Sánchez', '', 'Gasolina', 'Reciclado', '', 'Ing. Carlos Ruiz', '', 'Supervisor', 1, '', 0, '2024-03-20 09:00:00', '2024-03-20 09:00:00', 'Carga Express', 'Circuito 654', '5577889900', 1002, '19.4786', '-99.2398', 'SAP002', NULL, 1, 1),
('77889900112233445566778899001122', '889900112233445566778899001122', '34567890123456789012345678901234', 'Planta Este', 'PE003', 'Periférico 789', '2024-03-22 11:00:00', 'AUT003', 8.70, 'Desarrollos Pro SA', 'Madero 123', 'Moderno', 'Ecatepec', '55000', 'Condominios Vista', '5 de Mayo 456', 'Industrial', 'Ecatepec', '55500', '5534567890', 'Arq. Pedro Martínez', '', '990011223344556677889900112233', 'Arena', 'Arena Lavada', 'm³', 600.00, 20.00, 16.00, 'Torton', 'Kenworth', 'GHI789', 'RAM003', 'SCT003', '66778899001122334455667788990011', 'Fernando Ramírez', '', 'Diesel', 'Nuevo', 'Material para cimentación', 'Ing. Roberto Díaz', '', 'Jefe de Obra', 1, '', 0, '2024-03-21 10:00:00', '2024-03-21 10:00:00', 'Fletes Veloz', 'Vía 987', '5588990011', 1003, '19.6099', '-99.0603', 'SAP003', NULL, 1, 1),
('88990011223344556677889900112233', '990011223344556677889900112233', '45678901234567890123456789012345', 'Planta Oeste', 'PO004', 'Carretera 101', '2024-03-23 12:00:00', 'AUT004', 18.20, 'Construcciones Modernas', 'Zaragoza 654', 'Norte', 'Toluca', '50000', 'Hospital Regional', 'Independencia 321', 'Centro', 'Toluca', '50100', '5545678901', 'Dr. Ana Rodríguez', '', '001122334455667788990011223344', 'Piedra', 'Piedra Bola', 'm³', 1200.00, 8.00, 16.00, 'Doble Remolque', 'Mack', 'JKL012', 'RAM004', 'SCT004', '77889900112233445566778899001122', 'Alberto Mendoza', '', 'Diesel', 'Natural', 'Para jardinería', 'Biól. Laura Castro', '', 'Directora', 1, '', 0, '2024-03-22 11:00:00', '2024-03-22 11:00:00', 'Transportes Toluca', 'Paseo 654', '5599001122', 1004, '19.2925', '-99.6532', 'SAP004', NULL, 1, 1),
('99001122334455667788990011223344', '001122334455667788990011223344', '56789012345678901234567890123456', 'Planta Central', 'PC005', 'Boulevard 202', '2024-03-24 13:00:00', 'AUT005', 22.50, 'Obras Civiles SA', 'Morelos 987', 'Sur', 'Cuautitlán', '54700', 'Escuela Primaria', 'Revolución 654', 'Oriente', 'Cuautitlán', '54800', '5556789012', 'Prof. Javier López', '', '112233445566778899001122334455', 'Base', 'Base Hidráulica', 'm³', 900.00, 12.00, 16.00, 'Camión Pipila', 'Peterbilt', 'MNO345', 'RAM005', 'SCT005', '88990011223344556677889900112233', 'Gabriel Vargas', '', 'Gas', 'Compactado', 'Para pavimentación', 'Ing. Sofía Vargas', '', 'Residente', 1, '', 0, '2024-03-23 12:00:00', '2024-03-23 12:00:00', 'Cargas Pesadas', 'Calzada 321', '5500112233', 1005, '19.6796', '-99.1795', 'SAP005', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` varchar(32) NOT NULL,
  `id_sireq` varchar(100) NOT NULL DEFAULT '',
  `clave_sireq` varchar(100) NOT NULL DEFAULT '',
  `nombres` varchar(150) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `mail` varchar(150) NOT NULL,
  `accept` tinyint(1) NOT NULL DEFAULT 0,
  `pass` varchar(150) NOT NULL,
  `passtemp` varchar(20) NOT NULL DEFAULT '',
  `confirmacion` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `puedepospago` int(11) NOT NULL DEFAULT 0,
  `CodigoSAP` varchar(50) NOT NULL DEFAULT '',
  `ProcesadoSAP` varchar(50) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `id_sireq`, `clave_sireq`, `nombres`, `apellidos`, `mail`, `accept`, `pass`, `passtemp`, `confirmacion`, `remember_token`, `puedepospago`, `CodigoSAP`, `ProcesadoSAP`, `created_at`, `updated_at`) VALUES
('00112233445566778899001122334455', 'SIREQ001', 'CLAVE001', 'Alejandro', 'Hernández', 'alejandro@cliente.com', 1, 'cliente123', '', 1, NULL, 1, 'SAPCLI001', '', '2024-03-25 08:00:00', '2024-03-25 08:00:00'),
('11223344556677889900112233445566', 'SIREQ002', 'CLAVE002', 'Beatriz', 'García', 'beatriz@cliente.com', 1, 'cliente456', '', 1, NULL, 1, 'SAPCLI002', '', '2024-03-26 09:00:00', '2024-03-26 09:00:00'),
('22334455667788990011223344556677', 'SIREQ003', 'CLAVE003', 'Cecilia', 'Martínez', 'cecilia@cliente.com', 1, 'cliente789', '', 1, NULL, 0, 'SAPCLI003', '', '2024-03-27 10:00:00', '2024-03-27 10:00:00'),
('33445566778899001122334455667788', 'SIREQ004', 'CLAVE004', 'Diego', 'López', 'diego@cliente.com', 1, 'cliente012', '', 1, NULL, 1, 'SAPCLI004', '', '2024-03-28 11:00:00', '2024-03-28 11:00:00'),
('44556677889900112233445566778899', 'SIREQ005', 'CLAVE005', 'Elena', 'Rodríguez', 'elena@cliente.com', 1, 'cliente345', '', 1, NULL, 0, 'SAPCLI005', '', '2024-03-29 12:00:00', '2024-03-29 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigos`
--

CREATE TABLE `codigos` (
  `id` varchar(32) NOT NULL,
  `id_pedido` varchar(32) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `codigos`
--

INSERT INTO `codigos` (`id`, `id_pedido`, `codigo`, `created_at`, `updated_at`) VALUES
('55667788990011223344556677889900', '667788990011223344556677889900', 'COD001', '2024-03-30 08:00:00', '2024-03-30 08:00:00'),
('66778899001122334455667788990011', '778899001122334455667788990011', 'COD002', '2024-03-31 09:00:00', '2024-03-31 09:00:00'),
('77889900112233445566778899001122', '889900112233445566778899001122', 'COD003', '2024-04-01 10:00:00', '2024-04-01 10:00:00'),
('88990011223344556677889900112233', '990011223344556677889900112233', 'COD004', '2024-04-02 11:00:00', '2024-04-02 11:00:00'),
('99001122334455667788990011223344', '001122334455667788990011223344', 'COD005', '2024-04-03 12:00:00', '2024-04-03 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `mail` varchar(150) NOT NULL,
  `pass` varchar(250) NOT NULL,
  `passtemp` varchar(20) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `id_planta`, `nombre`, `mail`, `pass`, `passtemp`, `created_at`, `updated_at`) VALUES
('66778899001122334455667788990011', '12345678901234567890123456789012', 'Compras Planta Norte', 'compras@planta1.com', 'compras123', '', '2024-04-04 08:00:00', '2024-04-04 08:00:00'),
('77889900112233445566778899001122', '23456789012345678901234567890123', 'Compras Planta Sur', 'compras@planta2.com', 'compras456', '', '2024-04-05 09:00:00', '2024-04-05 09:00:00'),
('88990011223344556677889900112233', '34567890123456789012345678901234', 'Compras Planta Este', 'compras@planta3.com', 'compras789', '', '2024-04-06 10:00:00', '2024-04-06 10:00:00'),
('99001122334455667788990011223344', '45678901234567890123456789012345', 'Compras Planta Oeste', 'compras@planta4.com', 'compras012', '', '2024-04-07 11:00:00', '2024-04-07 11:00:00'),
('00112233445566778899001122334455', '56789012345678901234567890123456', 'Compras Planta Central', 'compras@planta5.com', 'compras345', '', '2024-04-08 12:00:00', '2024-04-08 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicionmateriales`
--

CREATE TABLE `condicionmateriales` (
  `id` varchar(32) NOT NULL,
  `condicion` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `condicionmateriales`
--

INSERT INTO `condicionmateriales` (`id`, `condicion`, `created_at`, `updated_at`) VALUES
('77889900112233445566778899001122', 'Nuevo', '2024-04-09 08:00:00', '2024-04-09 08:00:00'),
('88990011223344556677889900112233', 'Reciclado', '2024-04-10 09:00:00', '2024-04-10 09:00:00'),
('99001122334455667788990011223344', 'Natural', '2024-04-11 10:00:00', '2024-04-11 10:00:00'),
('00112233445566778899001122334455', 'Compactado', '2024-04-12 11:00:00', '2024-04-12 11:00:00'),
('11223344556677889900112233445566', 'Lavado', '2024-04-13 12:00:00', '2024-04-13 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condonaciones`
--

CREATE TABLE `condonaciones` (
  `id` varchar(32) NOT NULL,
  `id_administrador` varchar(32) NOT NULL DEFAULT '',
  `id_cliente` varchar(32) NOT NULL DEFAULT '',
  `id_obra` varchar(32) NOT NULL DEFAULT '',
  `id_planta` varchar(32) NOT NULL,
  `monto` double(20,2) NOT NULL,
  `detalle` varchar(150) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `condonaciones`
--

INSERT INTO `condonaciones` (`id`, `id_administrador`, `id_cliente`, `id_obra`, `id_planta`, `monto`, `detalle`, `created_at`, `updated_at`) VALUES
('88990011223344556677889900112233', 'f67890123456789012345678901234', '00112233445566778899001122334455', '667788990011223344556677889900', '12345678901234567890123456789012', 5000.00, 'Promoción especial', '2024-04-14 08:00:00', '2024-04-14 08:00:00'),
('99001122334455667788990011223344', '789012345678901234567890123456', '11223344556677889900112233445566', '778899001122334455667788990011', '23456789012345678901234567890123', 3000.00, 'Descuento por volumen', '2024-04-15 09:00:00', '2024-04-15 09:00:00'),
('00112233445566778899001122334455', '890123456789012345678901234567', '22334455667788990011223344556677', '889900112233445566778899001122', '34567890123456789012345678901234', 7500.00, 'Compensación por retraso', '2024-04-16 10:00:00', '2024-04-16 10:00:00'),
('11223344556677889900112233445566', '901234567890123456789012345678', '33445566778899001122334455667788', '990011223344556677889900112233', '45678901234567890123456789012345', 2500.00, 'Cortesía comercial', '2024-04-17 11:00:00', '2024-04-17 11:00:00'),
('22334455667788990011223344556677', '012345678901234567890123456789', '44556677889900112233445566778899', '001122334455667788990011223344', '56789012345678901234567890123456', 6000.00, 'Bonificación fidelidad', '2024-04-18 12:00:00', '2024-04-18 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuraciones`
--

CREATE TABLE `configuraciones` (
  `id` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL DEFAULT '',
  `razonsocial` varchar(250) NOT NULL DEFAULT '',
  `iva` double(5,2) NOT NULL DEFAULT 0.00,
  `banco` varchar(255) DEFAULT '',
  `cuenta` varchar(20) NOT NULL DEFAULT '',
  `clabe` varchar(20) NOT NULL DEFAULT '',
  `referencia` varchar(10) NOT NULL DEFAULT '',
  `folio` int(20) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `configuraciones`
--

INSERT INTO `configuraciones` (`id`, `id_planta`, `razonsocial`, `iva`, `banco`, `cuenta`, `clabe`, `referencia`, `folio`, `created_at`, `updated_at`) VALUES
('33445566778899001122334455667788', '12345678901234567890123456789012', 'Materiales Construcción Norte SA', 16.00, 'Bancomer', '123456789012345678', '012345678901234567', 'REF001', 100, '2024-04-19 08:00:00', '2024-04-19 08:00:00'),
('44556677889900112233445566778899', '23456789012345678901234567890123', 'Materiales Construcción Sur SA', 16.00, 'Santander', '234567890123456789', '123456789012345678', 'REF002', 200, '2024-04-20 09:00:00', '2024-04-20 09:00:00'),
('55667788990011223344556677889900', '34567890123456789012345678901234', 'Materiales Construcción Este SA', 16.00, 'HSBC', '345678901234567890', '234567890123456789', 'REF003', 300, '2024-04-21 10:00:00', '2024-04-21 10:00:00'),
('66778899001122334455667788990011', '45678901234567890123456789012345', 'Materiales Construcción Oeste SA', 16.00, 'BBVA', '456789012345678901', '345678901234567890', 'REF004', 400, '2024-04-22 11:00:00', '2024-04-22 11:00:00'),
('77889900112233445566778899001122', '56789012345678901234567890123456', 'Materiales Construcción Central SA', 16.00, 'Scotia', '567890123456789012', '456789012345678901', 'REF005', 500, '2024-04-23 12:00:00', '2024-04-23 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coordenadas`
--

CREATE TABLE `coordenadas` (
  `id` varchar(32) NOT NULL,
  `id_cita` varchar(32) NOT NULL DEFAULT '',
  `id_referencia` varchar(32) NOT NULL DEFAULT '',
  `lat` double(30,15) DEFAULT 0.000000000000000,
  `lon` double(30,15) NOT NULL DEFAULT 0.000000000000000,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `coordenadas`
--

INSERT INTO `coordenadas` (`id`, `id_cita`, `id_referencia`, `lat`, `lon`, `created_at`, `updated_at`) VALUES
('44556677889900112233445566778899', '55667788990011223344556677889900', '', 19.536900000000000, -99.196400000000000, '2024-04-24 08:00:00', '2024-04-24 08:00:00'),
('55667788990011223344556677889900', '66778899001122334455667788990011', '', 19.478600000000000, -99.239800000000000, '2024-04-25 09:00:00', '2024-04-25 09:00:00'),
('66778899001122334455667788990011', '77889900112233445566778899001122', '', 19.609900000000000, -99.060300000000000, '2024-04-26 10:00:00', '2024-04-26 10:00:00'),
('77889900112233445566778899001122', '88990011223344556677889900112233', '', 19.292500000000000, -99.653200000000000, '2024-04-27 11:00:00', '2024-04-27 11:00:00'),
('88990011223344556677889900112233', '99001122334455667788990011223344', '', 19.679600000000000, -99.179500000000000, '2024-04-28 12:00:00', '2024-04-28 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dependencias`
--

CREATE TABLE `dependencias` (
  `id` varchar(32) NOT NULL,
  `id_municipio` varchar(32) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `mail` varchar(150) NOT NULL,
  `pass` varchar(150) NOT NULL,
  `passtemp` varchar(20) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `dependencias`
--

INSERT INTO `dependencias` (`id`, `id_municipio`, `nombre`, `mail`, `pass`, `passtemp`, `created_at`, `updated_at`) VALUES
('99001122334455667788990011223344', '11223344556677889900112233445566', 'Obras Públicas Tlalnepantla', 'obras@tlalnepantla.gob.mx', 'dependencia123', '', '2024-04-29 08:00:00', '2024-04-29 08:00:00'),
('00112233445566778899001122334455', '22334455667788990011223344556677', 'Ecología Naucalpan', 'ecologia@naucalpan.gob.mx', 'dependencia456', '', '2024-04-30 09:00:00', '2024-04-30 09:00:00'),
('11223344556677889900112233445566', '33445566778899001122334455667788', 'Desarrollo Urbano Ecatepec', 'urbano@ecatepec.gob.mx', 'dependencia789', '', '2024-05-01 10:00:00', '2024-05-01 10:00:00'),
('22334455667788990011223344556677', '44556677889900112233445566778899', 'Servicios Públicos Toluca', 'servicios@toluca.gob.mx', 'dependencia012', '', '2024-05-02 11:00:00', '2024-05-02 11:00:00'),
('33445566778899001122334455667788', '55667788990011223344556677889900', 'Protección Civil Cuautitlán', 'pcivil@cuautitlan.gob.mx', 'dependencia345', '', '2024-05-03 12:00:00', '2024-05-03 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `despachadores`
--

CREATE TABLE `despachadores` (
  `id` varchar(32) NOT NULL,
  `nombres` varchar(150) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `mail` varchar(150) NOT NULL,
  `pass` varchar(250) NOT NULL,
  `passtemp` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `despachadores`
--

INSERT INTO `despachadores` (`id`, `nombres`, `apellidos`, `mail`, `pass`, `passtemp`, `created_at`, `updated_at`) VALUES
('44556677889900112233445566778899', 'Raúl', 'Méndez', 'raul@despachos.com', 'despacho123', '', '2024-05-04 08:00:00', '2024-05-04 08:00:00'),
('55667788990011223344556677889900', 'Sandra', 'Cortés', 'sandra@despachos.com', 'despacho456', '', '2024-05-05 09:00:00', '2024-05-05 09:00:00'),
('66778899001122334455667788990011', 'Teresa', 'Ortega', 'teresa@despachos.com', 'despacho789', '', '2024-05-06 10:00:00', '2024-05-06 10:00:00'),
('77889900112233445566778899001122', 'Ulises', 'Paredes', 'ulises@despachos.com', 'despacho012', '', '2024-05-07 11:00:00', '2024-05-07 11:00:00'),
('88990011223344556677889900112233', 'Verónica', 'Quiroz', 'veronica@despachos.com', 'despacho345', '', '2024-05-08 12:00:00', '2024-05-08 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallepedidos`
--

CREATE TABLE `detallepedidos` (
  `id` varchar(32) NOT NULL,
  `id_pedido` varchar(32) NOT NULL,
  `id_obra` varchar(32) NOT NULL,
  `id_usuario` varchar(32) NOT NULL,
  `id_transporte` varchar(32) NOT NULL,
  `id_producto` varchar(32) NOT NULL,
  `categoria` varchar(150) NOT NULL,
  `producto` varchar(150) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `precio` double(20,2) NOT NULL,
  `unidades` varchar(10) NOT NULL DEFAULT 'm³',
  `cantidad` double(20,2) NOT NULL,
  `disponible` tinyint(1) NOT NULL DEFAULT 1,
  `transporte` tinyint(1) NOT NULL DEFAULT 0,
  `carrito` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detallepedidos`
--

INSERT INTO `detallepedidos` (`id`, `id_pedido`, `id_obra`, `id_usuario`, `id_transporte`, `id_producto`, `categoria`, `producto`, `descripcion`, `precio`, `unidades`, `cantidad`, `disponible`, `transporte`, `carrito`, `created_at`, `updated_at`) VALUES
('55667788990011223344556677889900', '667788990011223344556677889900', '778899001122334455667788990011', '889900112233445566778899001122', '990011223344556677889900112233', '001122334455667788990011223344', 'Concreto', 'Concreto 250 kg/cm²', 'Concreto para losa', 2500.00, 'm³', 10.00, 1, 0, 0, '2024-05-09 08:00:00', '2024-05-09 08:00:00'),
('66778899001122334455667788990011', '778899001122334455667788990011', '889900112233445566778899001122', '990011223344556677889900112233', '001122334455667788990011223344', '112233445566778899001122334455', 'Grava', 'Grava 3/4', 'Grava para cimentación', 800.00, 'm³', 15.00, 1, 0, 0, '2024-05-10 09:00:00', '2024-05-10 09:00:00'),
('77889900112233445566778899001122', '889900112233445566778899001122', '990011223344556677889900112233', '001122334455667788990011223344', '112233445566778899001122334455', '223344556677889900112233445566', 'Arena', 'Arena Lavada', 'Arena para mortero', 600.00, 'm³', 20.00, 1, 0, 0, '2024-05-11 10:00:00', '2024-05-11 10:00:00'),
('88990011223344556677889900112233', '990011223344556677889900112233', '001122334455667788990011223344', '112233445566778899001122334455', '223344556677889900112233445566', '334455667788990011223344556677', 'Piedra', 'Piedra Bola', 'Piedra para jardinería', 1200.00, 'm³', 8.00, 1, 0, 0, '2024-05-12 11:00:00', '2024-05-12 11:00:00'),
('99001122334455667788990011223344', '001122334455667788990011223344', '112233445566778899001122334455', '223344556677889900112233445566', '334455667788990011223344556677', '445566778899001122334455667788', 'Base', 'Base Hidráulica', 'Base para pavimento', 900.00, 'm³', 12.00, 1, 0, 0, '2024-05-13 12:00:00', '2024-05-13 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directores`
--

CREATE TABLE `directores` (
  `id` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL,
  `director` varchar(150) NOT NULL,
  `mail` varchar(150) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `passtemp` varchar(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `directores`
--

INSERT INTO `directores` (`id`, `id_planta`, `director`, `mail`, `pass`, `created_at`, `updated_at`, `passtemp`) VALUES
('66778899001122334455667788990011', '12345678901234567890123456789012', 'Dr. Roberto Álvarez', 'roberto@empresa.com', 'director123', '2024-05-14 08:00:00', '2024-05-14 08:00:00', ''),
('77889900112233445566778899001122', '23456789012345678901234567890123', 'Ing. Patricia Bermúdez', 'patricia@empresa.com', 'director456', '2024-05-15 09:00:00', '2024-05-15 09:00:00', ''),
('88990011223344556677889900112233', '34567890123456789012345678901234', 'Arq. Guillermo Cervantes', 'guillermo@empresa.com', 'director789', '2024-05-16 10:00:00', '2024-05-16 10:00:00', ''),
('99001122334455667788990011223344', '45678901234567890123456789012345', 'Lic. Daniela Domínguez', 'daniela@empresa.com', 'director012', '2024-05-17 11:00:00', '2024-05-17 11:00:00', ''),
('00112233445566778899001122334455', '56789012345678901234567890123456', 'Mtro. Ernesto Escamilla', 'ernesto@empresa.com', 'director345', '2024-05-18 12:00:00', '2024-05-18 12:00:00', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dosificadores`
--

CREATE TABLE `dosificadores` (
  `id` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL,
  `dosificador` varchar(150) NOT NULL,
  `cargo` varchar(150) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `passtemp` varchar(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `dosificadores`
--

INSERT INTO `dosificadores` (`id`, `id_planta`, `dosificador`, `cargo`, `mail`, `pass`, `remember_token`, `created_at`, `updated_at`, `passtemp`) VALUES
('77889900112233445566778899001122', '12345678901234567890123456789012', 'Oscar Fuentes', 'Dosificador Senior', 'oscar@empresa.com', 'dosificador123', NULL, '2024-05-19 08:00:00', '2024-05-19 08:00:00', ''),
('88990011223344556677889900112233', '23456789012345678901234567890123', 'Pablo Galván', 'Dosificador', 'pablo@empresa.com', 'dosificador456', NULL, '2024-05-20 09:00:00', '2024-05-20 09:00:00', ''),
('99001122334455667788990011223344', '34567890123456789012345678901234', 'Quintín Herrera', 'Ayudante Dosificador', 'quintin@empresa.com', 'dosificador789', NULL, '2024-05-21 10:00:00', '2024-05-21 10:00:00', ''),
('00112233445566778899001122334455', '45678901234567890123456789012345', 'Rosa Íñiguez', 'Dosificadora', 'rosa@empresa.com', 'dosificador012', NULL, '2024-05-22 11:00:00', '2024-05-22 11:00:00', ''),
('11223344556677889900112233445566', '56789012345678901234567890123456', 'Salvador Jiménez', 'Supervisor Dosificación', 'salvador@empresa.com', 'dosificador345', NULL, '2024-05-23 12:00:00', '2024-05-23 12:00:00', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresastransporte`
--

CREATE TABLE `empresastransporte` (
  `id` varchar(32) NOT NULL,
  `id_transportista` varchar(32) NOT NULL,
  `razonsocial` varchar(250) NOT NULL,
  `ramir` varchar(100) NOT NULL,
  `regsct` varchar(100) NOT NULL DEFAULT '',
  `domicilio` longtext NOT NULL,
  `correo` varchar(50) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `giro` varchar(250) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empresastransporte`
--

INSERT INTO `empresastransporte` (`id`, `id_transportista`, `razonsocial`, `ramir`, `regsct`, `domicilio`, `correo`, `telefono`, `giro`, `created_at`, `updated_at`) VALUES
('88990011223344556677889900112233', '990011223344556677889900112233', 'Transportes Rápidos SA de CV', 'TRANS001', 'SCT-TRANS001', 'Periférico Norte 123, Ciudad de México', 'info@transportesrapidos.com', '5551234567', 'Transporte de Carga', '2024-05-24 08:00:00', '2024-05-24 08:00:00'),
('99001122334455667788990011223344', '001122334455667788990011223344', 'Carga Express SA', 'TRANS002', 'SCT-TRANS002', 'Eje Central 456, Naucalpan', 'contacto@cargaexpress.com', '5552345678', 'Fletes y Mudanzas', '2024-05-25 09:00:00', '2024-05-25 09:00:00'),
('00112233445566778899001122334455', '112233445566778899001122334455', 'Fletes Veloz SA', 'TRANS003', 'SCT-TRANS003', 'Carretera Federal 789, Ecatepec', 'ventas@fletesveloz.com', '5553456789', 'Transporte de Materiales', '2024-05-26 10:00:00', '2024-05-26 10:00:00'),
('11223344556677889900112233445566', '223344556677889900112233445566', 'Transportes Toluca SA', 'TRANS004', 'SCT-TRANS004', 'Boulevard Toluca 101, Toluca', 'administracion@transportestoluca.com', '5554567890', 'Carga General', '2024-05-27 11:00:00', '2024-05-27 11:00:00'),
('22334455667788990011223344556677', '334455667788990011223344556677', 'Cargas Pesadas SA', 'TRANS005', 'SCT-TRANS005', 'Autopista México-Querétaro 202, Cuautitlán', 'operaciones@cargaspesadas.com', '5555678901', 'Transporte Pesado', '2024-05-28 12:00:00', '2024-05-28 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas`
--

CREATE TABLE `encuestas` (
  `id` varchar(32) NOT NULL,
  `plantilla` int(1) NOT NULL DEFAULT 0,
  `encuesta` varchar(250) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `encuestas`
--

INSERT INTO `encuestas` (`id`, `plantilla`, `encuesta`, `created_at`, `updated_at`) VALUES
('33445566778899001122334455667788', 1, 'Satisfacción del Cliente', '2024-05-29 08:00:00', '2024-05-29 08:00:00'),
('44556677889900112233445566778899', 1, 'Evaluación de Servicio', '2024-05-30 09:00:00', '2024-05-30 09:00:00'),
('55667788990011223344556677889900', 0, 'Calidad de Materiales', '2024-05-31 10:00:00', '2024-05-31 10:00:00'),
('66778899001122334455667788990011', 1, 'Inspección de Obra', '2024-06-01 11:00:00', '2024-06-01 11:00:00'),
('77889900112233445566778899001122', 0, 'Seguridad en Sitio', '2024-06-02 12:00:00', '2024-06-02 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidades`
--

CREATE TABLE `entidades` (
  `id` int(2) NOT NULL,
  `entidad` varchar(50) NOT NULL,
  `lat` double(30,15) NOT NULL,
  `lon` double(30,15) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `entidades`
--

INSERT INTO `entidades` (`id`, `entidad`, `lat`, `lon`, `created_at`, `updated_at`) VALUES
(1, 'Ciudad de México', 19.432600000000000, -99.133200000000000, '2024-06-03 08:00:00', '2024-06-03 08:00:00'),
(2, 'Estado de México', 19.283300000000000, -99.653200000000000, '2024-06-04 09:00:00', '2024-06-04 09:00:00'),
(3, 'Morelos', 18.921200000000000, -99.234200000000000, '2024-06-05 10:00:00', '2024-06-05 10:00:00'),
(4, 'Puebla', 19.041300000000000, -98.206200000000000, '2024-06-06 11:00:00', '2024-06-06 11:00:00'),
(5, 'Hidalgo', 20.091100000000000, -98.762400000000000, '2024-06-07 12:00:00', '2024-06-07 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `failed_jobs`
--

INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(1, '123e4567e89b12d3a456426614174000', 'database', 'default', '...', 'Error en procesamiento', '2024-06-08 08:00:00'),
(2, '234e5678e90b23d4b567537725285111', 'database', 'high', '...', 'Timeout exception', '2024-06-09 09:00:00'),
(3, '345e6789e01c34e5c678648836396222', 'redis', 'default', '...', 'Connection refused', '2024-06-10 10:00:00'),
(4, '456e7890e12d45f6d789759947507333', 'database', 'low', '...', 'Query exception', '2024-06-11 11:00:00'),
(5, '567e8901e23e56g7e890860058618444', 'sync', 'default', '...', 'Serialization error', '2024-06-12 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `finanzas`
--

CREATE TABLE `finanzas` (
  `id` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `cargo` varchar(150) NOT NULL,
  `firma` longtext NOT NULL DEFAULT '',
  `mail` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `rango` int(2) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `passtemp` varchar(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `finanzas`
--

INSERT INTO `finanzas` (`id`, `id_planta`, `nombre`, `cargo`, `firma`, `mail`, `pass`, `remember_token`, `rango`, `created_at`, `updated_at`, `passtemp`) VALUES
('66778899001122334455667788990011', '12345678901234567890123456789012', 'Lic. Laura Navarro', 'Gerente Financiero', '', 'laura@finanzas.com', 'finanzas123', NULL, 1, '2024-06-13 08:00:00', '2024-06-13 08:00:00', ''),
('77889900112233445566778899001122', '23456789012345678901234567890123', 'C.P. Manuel Ochoa', 'Contador', '', 'manuel@finanzas.com', 'finanzas456', NULL, 2, '2024-06-14 09:00:00', '2024-06-14 09:00:00', ''),
('88990011223344556677889900112233', '34567890123456789012345678901234', 'Lic. Nora Pérez', 'Analista Financiero', '', 'nora@finanzas.com', 'finanzas789', NULL, 2, '2024-06-15 10:00:00', '2024-06-15 10:00:00', ''),
('99001122334455667788990011223344', '45678901234567890123456789012345', 'C.P. Omar Quezada', 'Auditor', '', 'omar@finanzas.com', 'finanzas012', NULL, 3, '2024-06-16 11:00:00', '2024-06-16 11:00:00', ''),
('00112233445566778899001122334455', '56789012345678901234567890123456', 'Lic. Patricia Ríos', 'Tesorera', '', 'patricia@finanzas.com', 'finanzas345', NULL, 1, '2024-06-17 12:00:00', '2024-06-17 12:00:00', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fototemp`
--

CREATE TABLE `fototemp` (
  `id` varchar(32) NOT NULL,
  `id_cita` varchar(32) NOT NULL,
  `foto` longtext NOT NULL,
  `carpeta` varchar(32) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `fototemp`
--

INSERT INTO `fototemp` (`id`, `id_cita`, `foto`, `carpeta`, `created_at`, `updated_at`) VALUES
('77889900112233445566778899001122', '55667788990011223344556677889900', 'foto1_base64_data', 'carpeta001', '2024-06-18 08:00:00', '2024-06-18 08:00:00'),
('88990011223344556677889900112233', '66778899001122334455667788990011', 'foto2_base64_data', 'carpeta002', '2024-06-19 09:00:00', '2024-06-19 09:00:00'),
('99001122334455667788990011223344', '77889900112233445566778899001122', 'foto3_base64_data', 'carpeta003', '2024-06-20 10:00:00', '2024-06-20 10:00:00'),
('00112233445566778899001122334455', '88990011223344556677889900112233', 'foto4_base64_data', 'carpeta004', '2024-06-21 11:00:00', '2024-06-21 11:00:00'),
('11223344556677889900112233445566', '99001122334455667788990011223344', 'foto5_base64_data', 'carpeta005', '2024-06-22 12:00:00', '2024-06-22 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fridays`
--

CREATE TABLE `fridays` (
  `id` varchar(32) NOT NULL,
  `id_administrador` varchar(32) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `detalle` longtext NOT NULL,
  `prioridad` int(11) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `fridays`
--

INSERT INTO `fridays` (`id`, `id_administrador`, `titulo`, `detalle`, `prioridad`, `status`, `created_at`, `updated_at`) VALUES
('88990011223344556677889900112233', 'f67890123456789012345678901234', 'Mantenimiento Planta', 'Programar mantenimiento preventivo para julio', 1, '0', '2024-06-23 08:00:00', '2024-06-23 08:00:00'),
('99001122334455667788990011223344', '789012345678901234567890123456', 'Actualización de Precios', 'Revisar y actualizar listas de precios', 2, '1', '2024-06-24 09:00:00', '2024-06-24 09:00:00'),
('00112233445566778899001122334455', '890123456789012345678901234567', 'Capacitación Personal', 'Organizar curso de seguridad industrial', 1, '0', '2024-06-25 10:00:00', '2024-06-25 10:00:00'),
('11223344556677889900112233445566', '901234567890123456789012345678', 'Auditoría Interna', 'Preparar documentación para auditoría', 3, '0', '2024-06-26 11:00:00', '2024-06-26 11:00:00'),
('22334455667788990011223344556677', '012345678901234567890123456789', 'Compra de Equipo', 'Evaluar propuestas para nueva mezcladora', 2, '1', '2024-06-27 12:00:00', '2024-06-27 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fueras`
--

CREATE TABLE `fueras` (
  `id` varchar(32) NOT NULL,
  `id_cita` varchar(32) NOT NULL,
  `latitud` double(20,15) NOT NULL,
  `longitud` double(20,15) NOT NULL,
  `fuera` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `fueras`
--

INSERT INTO `fueras` (`id`, `id_cita`, `latitud`, `longitud`, `fuera`, `created_at`, `updated_at`) VALUES
('99001122334455667788990011223344', '55667788990011223344556677889900', 19.537000000000000, -99.197000000000000, 0, '2024-06-28 08:00:00', '2024-06-28 08:00:00'),
('00112233445566778899001122334455', '66778899001122334455667788990011', 19.479000000000000, -99.240000000000000, 1, '2024-06-29 09:00:00', '2024-06-29 09:00:00'),
('11223344556677889900112233445566', '77889900112233445566778899001122', 19.610000000000000, -99.061000000000000, 0, '2024-06-30 10:00:00', '2024-06-30 10:00:00'),
('22334455667788990011223344556677', '88990011223344556677889900112233', 19.293000000000000, -99.654000000000000, 1, '2024-07-01 11:00:00', '2024-07-01 11:00:00'),
('33445566778899001122334455667788', '99001122334455667788990011223344', 19.680000000000000, -99.180000000000000, 0, '2024-07-02 12:00:00', '2024-07-02 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generadores`
--

CREATE TABLE `generadores` (
  `id` varchar(32) NOT NULL,
  `id_cliente` varchar(32) NOT NULL,
  `razonsocial` mediumtext NOT NULL,
  `fisicaomoral` varchar(50) NOT NULL DEFAULT '',
  `usocfdi` varchar(100) NOT NULL DEFAULT '-------',
  `rfc` varchar(50) NOT NULL,
  `rfcpdf` varchar(100) NOT NULL DEFAULT '',
  `calle` varchar(500) NOT NULL DEFAULT '',
  `numeroext` varchar(20) NOT NULL DEFAULT '',
  `numeroint` varchar(20) NOT NULL DEFAULT '',
  `colonia` varchar(250) NOT NULL DEFAULT '',
  `entidad` varchar(100) NOT NULL DEFAULT '',
  `municipio` varchar(150) NOT NULL DEFAULT '',
  `cp` varchar(20) NOT NULL DEFAULT '',
  `telefono` varchar(50) NOT NULL DEFAULT '',
  `celular` varchar(50) NOT NULL DEFAULT '',
  `mail` varchar(150) NOT NULL DEFAULT '',
  `mail2` varchar(150) NOT NULL DEFAULT '',
  `nombresrepre` varchar(150) NOT NULL DEFAULT '',
  `apellidosrepre` varchar(150) NOT NULL DEFAULT '',
  `nacionalidadrepre` varchar(100) NOT NULL DEFAULT '',
  `identificacionrepre` varchar(50) NOT NULL DEFAULT '',
  `identificacionreprepdf` varchar(100) NOT NULL DEFAULT '',
  `rfcrepre` varchar(50) NOT NULL DEFAULT '',
  `rfcreprepdf` varchar(100) NOT NULL DEFAULT '',
  `fechaconst` varchar(50) NOT NULL DEFAULT '',
  `numeroactacont` varchar(100) NOT NULL DEFAULT '',
  `numeroactacontpdf` varchar(100) NOT NULL DEFAULT '',
  `domicilioempresapdf` varchar(100) NOT NULL DEFAULT '',
  `notario` varchar(250) NOT NULL DEFAULT '',
  `numeronotaria` varchar(150) NOT NULL DEFAULT '',
  `entidadnotaria` varchar(100) NOT NULL DEFAULT '',
  `nombresfisica` varchar(150) NOT NULL DEFAULT '',
  `apellidosfisica` varchar(150) NOT NULL DEFAULT '',
  `nacionalidadfisica` varchar(100) NOT NULL DEFAULT '',
  `identificacionfisica` varchar(50) NOT NULL DEFAULT '',
  `identificacionfisicapdf` varchar(100) NOT NULL DEFAULT '',
  `verificado` tinyint(1) NOT NULL DEFAULT 0,
  `borrado` int(11) NOT NULL DEFAULT 0,
  `CodigoSAP` varchar(50) NOT NULL DEFAULT '',
  `ProcesadoSAP` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `generadores`
--

INSERT INTO `generadores` (`id`, `id_cliente`, `razonsocial`, `fisicaomoral`, `usocfdi`, `rfc`, `rfcpdf`, `calle`, `numeroext`, `numeroint`, `colonia`, `entidad`, `municipio`, `cp`, `telefono`, `celular`, `mail`, `mail2`, `nombresrepre`, `apellidosrepre`, `nacionalidadrepre`, `identificacionrepre`, `identificacionreprepdf`, `rfcrepre`, `rfcreprepdf`, `fechaconst`, `numeroactacont`, `numeroactacontpdf`, `domicilioempresapdf`, `notario`, `numeronotaria`, `entidadnotaria`, `nombresfisica`, `apellidosfisica`, `nacionalidadfisica`, `identificacionfisica`, `identificacionfisicapdf`, `verificado`, `borrado`, `CodigoSAP`, `ProcesadoSAP`, `created_at`, `updated_at`) VALUES
('00112233445566778899001122334455', '00112233445566778899001122334455', 'Constructora ABC SA de CV', 'Moral', 'G03', 'CAB010101ABC', '', 'Reforma', '456', 'Piso 3', 'Centro', 'Ciudad de México', 'Cuauhtémoc', '06000', '5512345678', '5512345679', 'info@constructoraabc.com', 'contabilidad@constructoraabc.com', 'Juan', 'Pérez', 'Mexicana', 'INE123456', '', 'PERE800101ABC', '', '2005-03-15', 'ACTA001', '', '', 'Notario Público 1', '1', 'CDMX', '', '', '', '', '', 1, 0, 'SAPGEN001', NULL, '2024-07-03 08:00:00', '2024-07-03 08:00:00'),
('11223344556677889900112233445566', '11223344556677889900112233445566', 'Ingeniería XYZ SA', 'Moral', 'G03', 'IXY020202XYZ', '', 'Hidalgo', '789', '', 'Downtown', 'Estado de México', 'Naucalpan', '53100', '5523456789', '5523456790', 'contacto@ingenieriaxyz.com', 'admin@ingenieriaxyz.com', 'María', 'García', 'Mexicana', 'INE234567', '', 'GARC700202XYZ', '', '2010-06-20', 'ACTA002', '', '', 'Notario Público 2', '2', 'Estado de México', '', '', '', '', '', 1, 0, 'SAPGEN002', NULL, '2024-07-04 09:00:00', '2024-07-04 09:00:00'),
('22334455667788990011223344556677', '22334455667788990011223344556677', 'Desarrollos Pro SA', 'Moral', 'G03', 'DPR030303PRO', '', 'Madero', '123', 'Local B', 'Moderno', 'Estado de México', 'Ecatepec', '55000', '5534567890', '5534567891', 'ventas@desarrollospro.com', 'ventas2@desarrollospro.com', 'Pedro', 'Martínez', 'Mexicana', 'INE345678', '', 'MART650303PRO', '', '2015-09-10', 'ACTA003', '', '', 'Notario Público 3', '3', 'Estado de México', '', '', '', '', '', 1, 0, 'SAPGEN003', NULL, '2024-07-05 10:00:00', '2024-07-05 10:00:00'),
('33445566778899001122334455667788', '33445566778899001122334455667788', 'Construcciones Modernas SA', 'Moral', 'G03', 'CMO040404MOD', '', 'Zaragoza', '654', 'Piso 2', 'Norte', 'Estado de México', 'Toluca', '50000', '5545678901', '5545678902', 'admin@constmodernas.com', 'ventas@constmodernas.com', 'Ana', 'Rodríguez', 'Mexicana', 'INE456789', '', 'RODR750404MOD', '', '2008-11-25', 'ACTA004', '', '', 'Notario Público 4', '4', 'Estado de México', '', '', '', '', '', 1, 0, 'SAPGEN004', NULL, '2024-07-06 11:00:00', '2024-07-06 11:00:00'),
('44556677889900112233445566778899', '44556677889900112233445566778899', 'Obras Civiles SA', 'Moral', 'G03', 'OCS050505CIV', '', 'Morelos', '987', '', 'Sur', 'Estado de México', 'Cuautitlán', '54700', '5556789012', '5556789013', 'obras@civiles.com', 'direccion@civiles.com', 'Javier', 'López', 'Mexicana', 'INE567890', '', 'LOPE820505CIV', '', '2012-02-14', 'ACTA005', '', '', 'Notario Público 5', '5', 'Estado de México', '', '', '', '', '', 1, 0, 'SAPGEN005', NULL, '2024-07-07 12:00:00', '2024-07-07 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historiales`
--

CREATE TABLE `historiales` (
  `id` varchar(32) NOT NULL,
  `id_referencia` varchar(32) NOT NULL,
  `id_administrador` varchar(32) NOT NULL,
  `tabla` varchar(150) NOT NULL,
  `movimiento` varchar(500) NOT NULL,
  `detalle` varchar(1550) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `historiales`
--

INSERT INTO `historiales` (`id`, `id_referencia`, `id_administrador`, `tabla`, `movimiento`, `detalle`, `created_at`, `updated_at`) VALUES
('55667788990011223344556677889900', '667788990011223344556677889900', 'f67890123456789012345678901234', 'citas', 'Creación de cita', 'Se creó nueva cita para obra Torres Reforma', '2024-07-08 08:00:00', '2024-07-08 08:00:00'),
('66778899001122334455667788990011', '778899001122334455667788990011', '789012345678901234567890123456', 'obras', 'Actualización de obra', 'Se actualizó la cantidad de material requerido', '2024-07-09 09:00:00', '2024-07-09 09:00:00'),
('77889900112233445566778899001122', '889900112233445566778899001122', '890123456789012345678901234567', 'clientes', 'Verificación de cliente', 'Cliente verificado exitosamente', '2024-07-10 10:00:00', '2024-07-10 10:00:00'),
('88990011223344556677889900112233', '990011223344556677889900112233', '901234567890123456789012345678', 'pagos', 'Registro de pago', 'Pago registrado por $15,000.00', '2024-07-11 11:00:00', '2024-07-11 11:00:00'),
('99001122334455667788990011223344', '001122334455667788990011223344', '012345678901234567890123456789', 'materiales', 'Actualización de precio', 'Precio de concreto actualizado a $2,600.00', '2024-07-12 12:00:00', '2024-07-12 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inspecciones`
--

CREATE TABLE `inspecciones` (
  `id` varchar(32) NOT NULL,
  `id_encuesta` varchar(32) NOT NULL,
  `obra` varchar(500) NOT NULL,
  `razonsocial` varchar(500) NOT NULL,
  `repre` varchar(150) NOT NULL,
  `calle` varchar(500) NOT NULL,
  `numeroext` varchar(50) NOT NULL,
  `numeroint` varchar(50) NOT NULL,
  `colonia` varchar(500) NOT NULL,
  `municipio` varchar(500) NOT NULL,
  `entidad` varchar(50) NOT NULL,
  `fechainicio` varchar(50) NOT NULL,
  `fechafin` varchar(50) NOT NULL,
  `nbo` varchar(50) NOT NULL,
  `plan` varchar(150) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `inspecciones`
--

INSERT INTO `inspecciones` (`id`, `id_encuesta`, `obra`, `razonsocial`, `repre`, `calle`, `numeroext`, `numeroint`, `colonia`, `municipio`, `entidad`, `fechainicio`, `fechafin`, `nbo`, `plan`, `created_at`, `updated_at`) VALUES
('66778899001122334455667788990011', '33445566778899001122334455667788', 'Torres Reforma', 'Constructora ABC SA de CV', 'Ing. Juan Pérez', 'Insurgentes', '789', 'Torre A', 'Polanco', 'Miguel Hidalgo', 'CDMX', '2024-01-15', '2024-12-15', 'NBO001', 'PLAN001', '2024-07-13 08:00:00', '2024-07-13 08:00:00'),
('77889900112233445566778899001122', '44556677889900112233445566778899', 'Plaza Comercial', 'Ingeniería XYZ SA', 'Ing. María García', 'Juárez', '101', 'Local 5', 'Lomas', 'Naucalpan', 'EdoMex', '2024-02-01', '2024-11-30', 'NBO002', 'PLAN002', '2024-07-14 09:00:00', '2024-07-14 09:00:00'),
('88990011223344556677889900112233', '55667788990011223344556677889900', 'Condominios Vista', 'Desarrollos Pro SA', 'Arq. Pedro Martínez', '5 de Mayo', '456', 'Edificio B', 'Industrial', 'Ecatepec', 'EdoMex', '2024-03-10', '2025-02-10', 'NBO003', 'PLAN003', '2024-07-15 10:00:00', '2024-07-15 10:00:00'),
('99001122334455667788990011223344', '66778899001122334455667788990011', 'Hospital Regional', 'Construcciones Modernas', 'Dr. Ana Rodríguez', 'Independencia', '321', 'Pabellón 3', 'Centro', 'Toluca', 'EdoMex', '2024-04-05', '2025-03-05', 'NBO004', 'PLAN004', '2024-07-16 11:00:00', '2024-07-16 11:00:00'),
('00112233445566778899001122334455', '77889900112233445566778899001122', 'Escuela Primaria', 'Obras Civiles SA', 'Prof. Javier López', 'Revolución', '654', 'Aula 101', 'Oriente', 'Cuautitlán', 'EdoMex', '2024-05-20', '2025-04-20', 'NBO005', 'PLAN005', '2024-07-17 12:00:00', '2024-07-17 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inspectores`
--

CREATE TABLE `inspectores` (
  `id` varchar(32) NOT NULL,
  `id_uia` varchar(32) NOT NULL,
  `inspector` varchar(150) NOT NULL,
  `telefono` varchar(150) NOT NULL,
  `mail` varchar(150) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `passtemp` varchar(20) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `inspectores`
--

INSERT INTO `inspectores` (`id`, `id_uia`, `inspector`, `telefono`, `mail`, `pass`, `passtemp`, `created_at`, `updated_at`) VALUES
('77889900112233445566778899001122', '889900112233445566778899001122', 'Ing. Salvador Torres', '5566778899', 'salvador@inspecciones.com', 'inspector123', '', '2024-07-18 08:00:00', '2024-07-18 08:00:00'),
('88990011223344556677889900112233', '990011223344556677889900112233', 'Arq. Úrsula Uribe', '5577889900', 'ursula@inspecciones.com', 'inspector456', '', '2024-07-19 09:00:00', '2024-07-19 09:00:00'),
('99001122334455667788990011223344', '001122334455667788990011223344', 'Biól. Vicente Vega', '5588990011', 'vicente@inspecciones.com', 'inspector789', '', '2024-07-20 10:00:00', '2024-07-20 10:00:00'),
('00112233445566778899001122334455', '112233445566778899001122334455', 'Ing. Wendy Wong', '5599001122', 'wendy@inspecciones.com', 'inspector012', '', '2024-07-21 11:00:00', '2024-07-21 11:00:00'),
('11223344556677889900112233445566', '223344556677889900112233445566', 'Mtro. Xavier Xochitl', '5500112233', 'xavier@inspecciones.com', 'inspector345', '', '2024-07-22 12:00:00', '2024-07-22 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumos`
--

CREATE TABLE `insumos` (
  `id` varchar(32) NOT NULL,
  `id_proveedor` varchar(32) NOT NULL,
  `proveedor` varchar(250) NOT NULL,
  `id_planta` varchar(32) NOT NULL,
  `material` varchar(250) NOT NULL,
  `cantidad` double(20,2) NOT NULL,
  `matricula` varchar(20) NOT NULL,
  `chofer` varchar(250) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `insumos`
--

INSERT INTO `insumos` (`id`, `id_proveedor`, `proveedor`, `id_planta`, `material`, `cantidad`, `matricula`, `chofer`, `created_at`, `updated_at`) VALUES
('88990011223344556677889900112233', '990011223344556677889900112233', 'Cemento Cruz Azul', '12345678901234567890123456789012', 'Cemento Portland', 50.00, 'CAM001', 'Luis Camargo', '2024-07-23 08:00:00', '2024-07-23 08:00:00'),
('99001122334455667788990011223344', '001122334455667788990011223344', 'Grava San Juan', '23456789012345678901234567890123', 'Grava 3/4', 100.00, 'VOL002', 'Miguel Vargas', '2024-07-24 09:00:00', '2024-07-24 09:00:00'),
('00112233445566778899001122334455', '112233445566778899001122334455', 'Arena del Valle', '34567890123456789012345678901234', 'Arena Lavada', 80.00, 'TOR003', 'Francisco Torres', '2024-07-25 10:00:00', '2024-07-25 10:00:00'),
('11223344556677889900112233445566', '223344556677889900112233445566', 'Aditivos Químicos', '45678901234567890123456789012345', 'Aditivo Plastificante', 5.00, 'QUI004', 'Roberto Quintero', '2024-07-26 11:00:00', '2024-07-26 11:00:00'),
('22334455667788990011223344556677', '334455667788990011223344556677', 'Aceros Nacionales', '56789012345678901234567890123456', 'Varilla Corrugada', 10.00, 'ACE005', 'Javier Acosta', '2024-07-27 12:00:00', '2024-07-27 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logueos`
--

CREATE TABLE `logueos` (
  `id` varchar(32) NOT NULL,
  `id_usuario` varchar(32) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `logueos`
--

INSERT INTO `logueos` (`id`, `id_usuario`, `created_at`, `updated_at`) VALUES
('99001122334455667788990011223344', 'f67890123456789012345678901234', '2024-07-28 08:00:00', '2024-07-28 08:00:00'),
('00112233445566778899001122334455', '789012345678901234567890123456', '2024-07-29 09:00:00', '2024-07-29 09:00:00'),
('11223344556677889900112233445566', '890123456789012345678901234567', '2024-07-30 10:00:00', '2024-07-30 10:00:00'),
('22334455667788990011223344556677', '901234567890123456789012345678', '2024-07-31 11:00:00', '2024-07-31 11:00:00'),
('33445566778899001122334455667788', '012345678901234567890123456789', '2024-08-01 12:00:00', '2024-08-01 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

CREATE TABLE `materiales` (
  `id` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL DEFAULT '',
  `categoria` varchar(350) NOT NULL,
  `material` varchar(350) NOT NULL,
  `precio` double(20,2) NOT NULL,
  `sku` varchar(100) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `materiales`
--

INSERT INTO `materiales` (`id`, `id_planta`, `categoria`, `material`, `precio`, `sku`, `created_at`, `updated_at`) VALUES
('00112233445566778899001122334455', '12345678901234567890123456789012', 'Concreto', 'Concreto 250 kg/cm²', 2500.00, 'CON001', '2024-08-02 08:00:00', '2024-08-02 08:00:00'),
('11223344556677889900112233445566', '23456789012345678901234567890123', 'Grava', 'Grava 3/4', 800.00, 'GRA002', '2024-08-03 09:00:00', '2024-08-03 09:00:00'),
('22334455667788990011223344556677', '34567890123456789012345678901234', 'Arena', 'Arena Lavada', 600.00, 'ARE003', '2024-08-04 10:00:00', '2024-08-04 10:00:00'),
('33445566778899001122334455667788', '45678901234567890123456789012345', 'Piedra', 'Piedra Bola', 1200.00, 'PIE004', '2024-08-05 11:00:00', '2024-08-05 11:00:00'),
('44556677889900112233445566778899', '56789012345678901234567890123456', 'Base', 'Base Hidráulica', 900.00, 'BAS005', '2024-08-06 12:00:00', '2024-08-06 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materialesobra`
--

CREATE TABLE `materialesobra` (
  `id` varchar(32) NOT NULL,
  `id_obra` varchar(32) NOT NULL,
  `id_sireq` int(3) NOT NULL DEFAULT 0,
  `categoriamaterial` varchar(350) NOT NULL,
  `id_material` varchar(32) NOT NULL,
  `material` varchar(350) NOT NULL,
  `cantidad` float(20,2) NOT NULL,
  `precio` double(10,2) NOT NULL,
  `unidades` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `materialesobra`
--

INSERT INTO `materialesobra` (`id`, `id_obra`, `id_sireq`, `categoriamaterial`, `id_material`, `material`, `cantidad`, `precio`, `unidades`, `created_at`, `updated_at`) VALUES
('55667788990011223344556677889900', '667788990011223344556677889900', 1, 'Concreto', '00112233445566778899001122334455', 'Concreto 250 kg/cm²', 100.00, 2500.00, 'm³', '2024-08-07 08:00:00', '2024-08-07 08:00:00'),
('66778899001122334455667788990011', '778899001122334455667788990011', 2, 'Grava', '11223344556677889900112233445566', 'Grava 3/4', 150.00, 800.00, 'm³', '2024-08-08 09:00:00', '2024-08-08 09:00:00'),
('77889900112233445566778899001122', '889900112233445566778899001122', 3, 'Arena', '22334455667788990011223344556677', 'Arena Lavada', 200.00, 600.00, 'm³', '2024-08-09 10:00:00', '2024-08-09 10:00:00'),
('88990011223344556677889900112233', '990011223344556677889900112233', 4, 'Piedra', '33445566778899001122334455667788', 'Piedra Bola', 80.00, 1200.00, 'm³', '2024-08-10 11:00:00', '2024-08-10 11:00:00'),
('99001122334455667788990011223344', '001122334455667788990011223344', 5, 'Base', '44556677889900112233445566778899', 'Base Hidráulica', 120.00, 900.00, 'm³', '2024-08-11 12:00:00', '2024-08-11 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materialessireq`
--

CREATE TABLE `materialessireq` (
  `id` varchar(32) NOT NULL,
  `id_entidad` int(2) NOT NULL DEFAULT 0,
  `id_sireq` varchar(32) NOT NULL,
  `categoria` varchar(500) NOT NULL,
  `material` varchar(500) NOT NULL,
  `precio` double(10,2) NOT NULL,
  `sku` varchar(100) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `materialessireq`
--

INSERT INTO `materialessireq` (`id`, `id_entidad`, `id_sireq`, `categoria`, `material`, `precio`, `sku`, `created_at`, `updated_at`) VALUES
('66778899001122334455667788990011', 1, 'SIREQ001', 'Concreto', 'Concreto 250 kg/cm² CDMX', 2600.00, 'SIRCON001', '2024-08-12 08:00:00', '2024-08-12 08:00:00'),
('77889900112233445566778899001122', 2, 'SIREQ002', 'Grava', 'Grava 3/4 EdoMex', 850.00, 'SIRGRA002', '2024-08-13 09:00:00', '2024-08-13 09:00:00'),
('88990011223344556677889900112233', 2, 'SIREQ003', 'Arena', 'Arena Lavada EdoMex', 650.00, 'SIRARE003', '2024-08-14 10:00:00', '2024-08-14 10:00:00'),
('99001122334455667788990011223344', 2, 'SIREQ004', 'Piedra', 'Piedra Bola EdoMex', 1250.00, 'SIRPIE004', '2024-08-15 11:00:00', '2024-08-15 11:00:00'),
('00112233445566778899001122334455', 2, 'SIREQ005', 'Base', 'Base Hidráulica EdoMex', 950.00, 'SIRBAS005', '2024-08-16 12:00:00', '2024-08-16 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `microgeneradores`
--

CREATE TABLE `microgeneradores` (
  `id` varchar(32) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `telefono` varchar(40) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `calle` varchar(500) NOT NULL,
  `numeroext` varchar(50) NOT NULL,
  `numeroint` varchar(50) NOT NULL,
  `colonia` varchar(500) NOT NULL,
  `municipio` varchar(50) NOT NULL,
  `cp` varchar(20) NOT NULL,
  `material` varchar(255) NOT NULL,
  `cantidad` double(20,2) NOT NULL,
  `precio` double(20,2) NOT NULL,
  `iva` double(20,2) NOT NULL,
  `condicionmaterial` varchar(100) NOT NULL,
  `fechayhora` varchar(50) NOT NULL,
  `confirmacion` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `microgeneradores`
--

INSERT INTO `microgeneradores` (`id`, `nombre`, `telefono`, `correo`, `calle`, `numeroext`, `numeroint`, `colonia`, `municipio`, `cp`, `material`, `cantidad`, `precio`, `iva`, `condicionmaterial`, `fechayhora`, `confirmacion`, `created_at`, `updated_at`) VALUES
('77889900112233445566778899001122', 'José Luis Mendoza', '5511223344', 'jose@micro.com', 'Jazmines', '45', 'Casa 2', 'Las Flores', 'Tlalnepantla', '54020', 'Escombro', 5.00, 500.00, 80.00, 'Reciclado', '2024-08-17 09:00:00', 1, '2024-08-17 08:00:00', '2024-08-17 08:00:00'),
('88990011223344556677889900112233', 'María Elena Soto', '5522334455', 'maria@micro.com', 'Rosas', '78', '', 'Jardines', 'Naucalpan', '53110', 'Madera', 2.00, 300.00, 48.00, 'Natural', '2024-08-18 10:00:00', 1, '2024-08-18 09:00:00', '2024-08-18 09:00:00'),
('99001122334455667788990011223344', 'Carlos Ramírez', '5533445566', 'carlos@micro.com', 'Claveles', '123', 'Local A', 'Industrial', 'Ecatepec', '55010', 'Cartón', 1.00, 150.00, 24.00, 'Compactado', '2024-08-19 11:00:00', 1, '2024-08-19 10:00:00', '2024-08-19 10:00:00'),
('00112233445566778899001122334455', 'Ana Karen Díaz', '5544556677', 'ana@micro.com', 'Lirios', '56', '', 'Centro', 'Toluca', '50110', 'Plástico', 3.00, 450.00, 72.00, 'Reciclado', '2024-08-20 12:00:00', 1, '2024-08-20 11:00:00', '2024-08-20 11:00:00'),
('11223344556677889900112233445566', 'Pedro Ávila', '5555667788', 'pedro@micro.com', 'Margaritas', '89', 'Casa 5', 'Oriente', 'Cuautitlán', '54710', 'Vidrio', 0.50, 100.00, 16.00, 'Nuevo', '2024-08-21 13:00:00', 1, '2024-08-21 12:00:00', '2024-08-21 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2024_01_01_000001_create_plantas_table', 1),
(5, '2024_01_01_000002_create_clientes_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mododios`
--

CREATE TABLE `mododios` (
  `id` varchar(32) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `mail` varchar(150) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mododios`
--

INSERT INTO `mododios` (`id`, `nombre`, `mail`, `pass`, `created_at`, `updated_at`) VALUES
('88990011223344556677889900112233', 'Super Administrador', 'admin@mododios.com', 'mododios123', '2024-08-22 08:00:00', '2024-08-22 08:00:00'),
('99001122334455667788990011223344', 'Sistema Master', 'system@mododios.com', 'mododios456', '2024-08-23 09:00:00', '2024-08-23 09:00:00'),
('00112233445566778899001122334455', 'Root User', 'root@mododios.com', 'mododios789', '2024-08-24 10:00:00', '2024-08-24 10:00:00'),
('11223344556677889900112233445566', 'God Mode', 'god@mododios.com', 'mododios012', '2024-08-25 11:00:00', '2024-08-25 11:00:00'),
('22334455667788990011223344556677', 'Master Control', 'master@mododios.com', 'mododios345', '2024-08-26 12:00:00', '2024-08-26 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `multas`
--

CREATE TABLE `multas` (
  `id` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL,
  `id_negocio` varchar(32) NOT NULL,
  `monto` double(20,2) NOT NULL DEFAULT 0.00,
  `detalle` varchar(150) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `multas`
--

INSERT INTO `multas` (`id`, `id_planta`, `id_negocio`, `monto`, `detalle`, `status`, `created_at`, `updated_at`) VALUES
('99001122334455667788990011223344', '12345678901234567890123456789012', '667788990011223344556677889900', 2500.00, 'Retraso en entrega', 1, '2024-08-27 08:00:00', '2024-08-27 08:00:00'),
('00112233445566778899001122334455', '23456789012345678901234567890123', '778899001122334455667788990011', 1500.00, 'Material no conforme', 1, '2024-08-28 09:00:00', '2024-08-28 09:00:00'),
('11223344556677889900112233445566', '34567890123456789012345678901234', '889900112233445566778899001122', 3000.00, 'Incumplimiento de horario', 1, '2024-08-29 10:00:00', '2024-08-29 10:00:00'),
('22334455667788990011223344556677', '45678901234567890123456789012345', '990011223344556677889900112233', 2000.00, 'Daño a instalaciones', 1, '2024-08-30 11:00:00', '2024-08-30 11:00:00'),
('33445566778899001122334455667788', '56789012345678901234567890123456', '001122334455667788990011223344', 3500.00, 'Falta de documentación', 1, '2024-08-31 12:00:00', '2024-08-31 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `id` varchar(32) NOT NULL,
  `id_entidad` varchar(32) NOT NULL,
  `municipio` varchar(150) NOT NULL,
  `lat` double(30,15) NOT NULL,
  `lon` double(30,15) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`id`, `id_entidad`, `municipio`, `lat`, `lon`, `created_at`, `updated_at`) VALUES
('00112233445566778899001122334455', '1', 'Cuauhtémoc', 19.432600000000000, -99.133200000000000, '2024-09-01 08:00:00', '2024-09-01 08:00:00'),
('11223344556677889900112233445566', '2', 'Tlalnepantla', 19.536900000000000, -99.196400000000000, '2024-09-02 09:00:00', '2024-09-02 09:00:00'),
('22334455667788990011223344556677', '2', 'Naucalpan', 19.478600000000000, -99.239800000000000, '2024-09-03 10:00:00', '2024-09-03 10:00:00'),
('33445566778899001122334455667788', '2', 'Ecatepec', 19.609900000000000, -99.060300000000000, '2024-09-04 11:00:00', '2024-09-04 11:00:00'),
('44556677889900112233445566778899', '2', 'Toluca', 19.292500000000000, -99.653200000000000, '2024-09-05 12:00:00', '2024-09-05 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `negocios`
--

CREATE TABLE `negocios` (
  `id` varchar(32) NOT NULL,
  `id_generador` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL,
  `negocio` varchar(500) NOT NULL,
  `tiponegocio` varchar(150) NOT NULL,
  `categoria` int(1) NOT NULL,
  `calle` varchar(500) NOT NULL,
  `numeroext` varchar(10) NOT NULL,
  `numeroint` varchar(10) NOT NULL,
  `colonia` varchar(500) NOT NULL,
  `municipio` varchar(150) NOT NULL,
  `entidad` varchar(150) NOT NULL,
  `cp` varchar(10) NOT NULL,
  `latitud` varchar(50) NOT NULL,
  `longitud` varchar(50) NOT NULL,
  `contacto` varchar(150) NOT NULL DEFAULT '',
  `telefono` varchar(50) NOT NULL,
  `celular` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `iva` double(5,2) NOT NULL DEFAULT 0.00,
  `puedepospago` tinyint(1) NOT NULL DEFAULT 0,
  `verificado` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `negocios`
--

INSERT INTO `negocios` (`id`, `id_generador`, `id_planta`, `negocio`, `tiponegocio`, `categoria`, `calle`, `numeroext`, `numeroint`, `colonia`, `municipio`, `entidad`, `cp`, `latitud`, `longitud`, `contacto`, `telefono`, `celular`, `correo`, `iva`, `puedepospago`, `verificado`, `created_at`, `updated_at`) VALUES
('55667788990011223344556677889900', '00112233445566778899001122334455', '12345678901234567890123456789012', 'Restaurante El Portal', 'Restaurante', 2, 'Insurgentes', '789', 'Local 3', 'Polanco', 'Miguel Hidalgo', 'CDMX', '11560', '19.4330', '-99.1340', 'Lic. Laura Méndez', '5511223344', '5511223355', 'info@elportal.com', 16.00, 1, 1, '2024-09-06 08:00:00', '2024-09-06 08:00:00'),
('66778899001122334455667788990011', '11223344556677889900112233445566', '23456789012345678901234567890123', 'Hotel Plaza Central', 'Hotel', 3, 'Juárez', '101', 'Piso 5', 'Lomas', 'Naucalpan', 'EdoMex', '53600', '19.4790', '-99.2400', 'Ing. Carlos Ruiz', '5522334455', '5522334466', 'reservaciones@plazacentral.com', 16.00, 1, 1, '2024-09-07 09:00:00', '2024-09-07 09:00:00'),
('77889900112233445566778899001122', '22334455667788990011223344556677', '34567890123456789012345678901234', 'Supermercado Mega', 'Comercio', 1, '5 de Mayo', '456', 'Local A', 'Industrial', 'Ecatepec', 'EdoMex', '55500', '19.6100', '-99.0610', 'Sra. Rosa González', '5533445566', '5533445577', 'ventas@megasuper.com', 16.00, 0, 1, '2024-09-08 10:00:00', '2024-09-08 10:00:00'),
('88990011223344556677889900112233', '33445566778899001122334455667788', '45678901234567890123456789012345', 'Clínica Dental Sonrisa', 'Servicios', 2, 'Independencia', '321', 'Consultorio 2', 'Centro', 'Toluca', 'EdoMex', '50100', '19.2930', '-99.6540', 'Dra. Patricia López', '5544556677', '5544556688', 'citas@sonrisadental.com', 16.00, 0, 1, '2024-09-09 11:00:00', '2024-09-09 11:00:00'),
('99001122334455667788990011223344', '44556677889900112233445566778899', '56789012345678901234567890123456', 'Taller Mecánico Rápido', 'Taller', 1, 'Revolución', '654', 'Local 8', 'Oriente', 'Cuautitlán', 'EdoMex', '54800', '19.6800', '-99.1800', 'Mec. Jorge Torres', '5555667788', '5555667799', 'servicio@tallerrapido.com', 16.00, 0, 1, '2024-09-10 12:00:00', '2024-09-10 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL,
  `id_referencia` varchar(32) NOT NULL,
  `titulo` varchar(500) NOT NULL,
  `notificacion` mediumtext NOT NULL,
  `leido` int(11) NOT NULL DEFAULT 0,
  `importancia` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id`, `id_planta`, `id_referencia`, `titulo`, `notificacion`, `leido`, `importancia`, `created_at`, `updated_at`) VALUES
('66778899001122334455667788990011', '12345678901234567890123456789012', '55667788990011223344556677889900', 'Nueva Cita Programada', 'Se ha programado una nueva cita para el 20 de marzo', 1, 2, '2024-09-11 08:00:00', '2024-09-11 08:00:00'),
('77889900112233445566778899001122', '23456789012345678901234567890123', '66778899001122334455667788990011', 'Pago Confirmado', 'El pago de la factura 001 ha sido confirmado', 0, 1, '2024-09-12 09:00:00', '2024-09-12 09:00:00'),
('88990011223344556677889900112233', '34567890123456789012345678901234', '77889900112233445566778899001122', 'Material en Camino', 'El material para la obra ya está en camino', 1, 2, '2024-09-13 10:00:00', '2024-09-13 10:00:00'),
('99001122334455667788990011223344', '45678901234567890123456789012345', '88990011223344556677889900112233', 'Actualización de Precios', 'Se han actualizado los precios de los materiales', 0, 3, '2024-09-14 11:00:00', '2024-09-14 11:00:00'),
('00112233445566778899001122334455', '56789012345678901234567890123456', '99001122334455667788990011223344', 'Mantenimiento Programado', 'El mantenimiento de la planta será el próximo lunes', 1, 2, '2024-09-15 12:00:00', '2024-09-15 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obras`
--

CREATE TABLE `obras` (
  `id` varchar(32) NOT NULL,
  `id_generador` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL DEFAULT '',
  `id_uia` varchar(32) NOT NULL DEFAULT '',
  `obra` varchar(10000) NOT NULL,
  `publica` tinyint(4) NOT NULL DEFAULT 0,
  `ncontrato` varchar(50) NOT NULL DEFAULT '',
  `distancia` float(5,2) NOT NULL DEFAULT 0.00,
  `tipoobra` mediumtext NOT NULL,
  `subtipoobra` mediumtext NOT NULL,
  `cantidadobra` float(20,2) NOT NULL DEFAULT 0.00,
  `descuento` float(5,2) NOT NULL DEFAULT 0.00,
  `calle` varchar(500) NOT NULL,
  `numeroext` varchar(10) NOT NULL,
  `numeroint` varchar(10) NOT NULL,
  `colonia` varchar(500) NOT NULL,
  `municipio` varchar(150) NOT NULL,
  `entidad` varchar(150) NOT NULL,
  `cp` varchar(10) NOT NULL,
  `latitud` varchar(50) NOT NULL,
  `longitud` varchar(50) NOT NULL,
  `fechainicio` varchar(30) NOT NULL,
  `fechafin` varchar(30) NOT NULL,
  `superficie` varchar(150) NOT NULL DEFAULT '',
  `entregado` float(20,2) NOT NULL DEFAULT 0.00,
  `status` float(20,2) NOT NULL DEFAULT 0.00,
  `superunidades` varchar(10) NOT NULL DEFAULT '',
  `aplicaplan` tinyint(1) NOT NULL,
  `nautorizacion` varchar(100) NOT NULL DEFAULT '',
  `vigenciaplan` varchar(30) NOT NULL DEFAULT '',
  `declaratoria` varchar(150) NOT NULL DEFAULT '',
  `planmanejo` varchar(150) NOT NULL DEFAULT '',
  `contacto` varchar(100) NOT NULL DEFAULT '',
  `telefono` varchar(50) NOT NULL,
  `celular` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `correo2` varchar(100) NOT NULL,
  `transporte` tinyint(4) DEFAULT 0,
  `polizarc` tinyint(1) NOT NULL DEFAULT 0,
  `valorobra` float(20,2) NOT NULL DEFAULT 0.00,
  `ivaobra` float(5,2) NOT NULL DEFAULT 0.00,
  `verificado` tinyint(1) NOT NULL DEFAULT 0,
  `terminada` tinyint(4) NOT NULL DEFAULT 0,
  `deshabilitada` tinyint(4) NOT NULL DEFAULT 0,
  `contrato` tinyint(1) DEFAULT 0,
  `contratook` int(11) NOT NULL DEFAULT 0,
  `fechacontratook` datetime DEFAULT NULL,
  `trabajando` varchar(1) NOT NULL DEFAULT '0',
  `contraramir` tinyint(4) NOT NULL DEFAULT 0,
  `contrasindicato` tinyint(4) NOT NULL DEFAULT 0,
  `puedepospago` tinyint(1) NOT NULL DEFAULT 0,
  `esalcaldia` tinyint(1) NOT NULL DEFAULT 0,
  `limite` float(20,2) NOT NULL DEFAULT 0.00,
  `CodigoSAP` varchar(50) NOT NULL DEFAULT '',
  `ProcesadoSAP` datetime DEFAULT NULL,
  `cancelado` int(1) NOT NULL DEFAULT 0,
  `alerta` varchar(150) NOT NULL DEFAULT '',
  `id_sireq` int(11) NOT NULL DEFAULT 0,
  `folio_sireq` varchar(150) NOT NULL DEFAULT '',
  `mailrepre` varchar(150) NOT NULL DEFAULT '',
  `reciclaje` float(20,2) NOT NULL DEFAULT 0.00,
  `pago` float(20,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `obras`
--

INSERT INTO `obras` (`id`, `id_generador`, `id_planta`, `id_uia`, `obra`, `publica`, `ncontrato`, `distancia`, `tipoobra`, `subtipoobra`, `cantidadobra`, `descuento`, `calle`, `numeroext`, `numeroint`, `colonia`, `municipio`, `entidad`, `cp`, `latitud`, `longitud`, `fechainicio`, `fechafin`, `superficie`, `entregado`, `status`, `superunidades`, `aplicaplan`, `nautorizacion`, `vigenciaplan`, `declaratoria`, `planmanejo`, `contacto`, `telefono`, `celular`, `correo`, `correo2`, `transporte`, `polizarc`, `valorobra`, `ivaobra`, `verificado`, `terminada`, `deshabilitada`, `contrato`, `contratook`, `fechacontratook`, `trabajando`, `contraramir`, `contrasindicato`, `puedepospago`, `esalcaldia`, `limite`, `CodigoSAP`, `ProcesadoSAP`, `cancelado`, `alerta`, `id_sireq`, `folio_sireq`, `mailrepre`, `reciclaje`, `pago`, `created_at`, `updated_at`) VALUES
('667788990011223344556677889900', '00112233445566778899001122334455', '12345678901234567890123456789012', '889900112233445566778899001122', 'Torres Reforma - Edificio de oficinas de 20 pisos', 0, 'CON001', 15.50, 'Edificio', 'Oficinas', 10000.00, 5.00, 'Insurgentes', '789', 'Torre A', 'Polanco', 'Miguel Hidalgo', 'CDMX', '11560', '19.4330', '-99.1340', '2024-01-15', '2024-12-15', '5000', 2500.00, 25.00, 'm²', 1, 'AUT001', '2024-12-31', 'DEC001', 'PLAN001', 'Ing. Juan Pérez', '5512345678', '5512345679', 'juan@constructoraabc.com', 'proyectos@constructoraabc.com', 1, 1, 50000000.00, 16.00, 1, 0, 0, 1, 1, '2024-01-10 09:00:00', '1', 1, 1, 1, 0, 1000000.00, 'SAPOBR001', NULL, 0, '', 1, 'FOLIO001', 'juan@constructoraabc.com', 100.00, 10000000.00, '2024-09-16 08:00:00', '2024-09-16 08:00:00'),
('778899001122334455667788990011', '11223344556677889900112233445566', '23456789012345678901234567890123', '990011223344556677889900112233', 'Plaza Comercial Lomas - Centro comercial con 50 locales', 0, 'CON002', 12.30, 'Comercial', 'Plaza', 8000.00, 3.00, 'Juárez', '101', 'Local 5', 'Lomas', 'Naucalpan', 'EdoMex', '53600', '19.4790', '-99.2400', '2024-02-01', '2024-11-30', '3000', 4000.00, 50.00, 'm²', 1, 'AUT002', '2024-11-30', 'DEC002', 'PLAN002', 'Ing. María García', '5523456789', '5523456790', 'maria@ingenieriaxyz.com', 'direccion@ingenieriaxyz.com', 1, 1, 30000000.00, 16.00, 1, 0, 0, 1, 1, '2024-01-25 10:00:00', '1', 1, 0, 1, 0, 800000.00, 'SAPOBR002', NULL, 0, '', 2, 'FOLIO002', 'maria@ingenieriaxyz.com', 80.00, 8000000.00, '2024-09-17 09:00:00', '2024-09-17 09:00:00'),
('889900112233445566778899001122', '22334455667788990011223344556677', '34567890123456789012345678901234', '001122334455667788990011223344', 'Condominios Vista - Conjunto habitacional de 100 departamentos', 0, 'CON003', 8.70, 'Habitacional', 'Condominio', 12000.00, 7.00, '5 de Mayo', '456', 'Edificio B', 'Industrial', 'Ecatepec', 'EdoMex', '55500', '19.6100', '-99.0610', '2024-03-10', '2025-02-10', '6000', 6000.00, 50.00, 'm²', 1, 'AUT003', '2025-02-10', 'DEC003', 'PLAN003', 'Arq. Pedro Martínez', '5534567890', '5534567891', 'pedro@desarrollospro.com', 'ventas@desarrollospro.com', 1, 1, 40000000.00, 16.00, 1, 0, 0, 1, 1, '2024-02-28 11:00:00', '1', 1, 1, 1, 0, 1200000.00, 'SAPOBR003', NULL, 0, '', 3, 'FOLIO003', 'pedro@desarrollospro.com', 120.00, 12000000.00, '2024-09-18 10:00:00', '2024-09-18 10:00:00'),
('990011223344556677889900112233', '33445566778899001122334455667788', '45678901234567890123456789012345', '112233445566778899001122334455', 'Hospital Regional Toluca - Hospital de 200 camas', 1, 'CON004', 18.20, 'Salud', 'Hospital', 15000.00, 10.00, 'Independencia', '321', 'Pabellón 3', 'Centro', 'Toluca', 'EdoMex', '50100', '19.2930', '-99.6540', '2024-04-05', '2025-03-05', '8000', 7500.00, 50.00, 'm²', 1, 'AUT004', '2025-03-05', 'DEC004', 'PLAN004', 'Dr. Ana Rodríguez', '5545678901', '5545678902', 'ana@constmodernas.com', 'admin@constmodernas.com', 1, 1, 80000000.00, 16.00, 1, 0, 0, 1, 1, '2024-03-20 12:00:00', '1', 0, 0, 0, 1, 1500000.00, 'SAPOBR004', NULL, 0, '', 4, 'FOLIO004', 'ana@constmodernas.com', 150.00, 15000000.00, '2024-09-19 11:00:00', '2024-09-19 11:00:00'),
('001122334455667788990011223344', '44556677889900112233445566778899', '56789012345678901234567890123456', '223344556677889900112233445566', 'Escuela Primaria Cuautitlán - Escuela para 500 alumnos', 1, 'CON005', 22.50, 'Educación', 'Escuela', 5000.00, 15.00, 'Revolución', '654', 'Aula 101', 'Oriente', 'Cuautitlán', 'EdoMex', '54800', '19.6800', '-99.1800', '2024-05-20', '2025-04-20', '2500', 2500.00, 50.00, 'm²', 1, 'AUT005', '2025-04-20', 'DEC005', 'PLAN005', 'Prof. Javier López', '5556789012', '5556789013', 'javier@civiles.com', 'direccion@civiles.com', 1, 1, 20000000.00, 16.00, 1, 0, 0, 1, 1, '2024-04-15 13:00:00', '1', 0, 0, 0, 1, 500000.00, 'SAPOBR005', NULL, 0, '', 5, 'FOLIO005', 'javier@civiles.com', 50.00, 5000000.00, '2024-09-20 12:00:00', '2024-09-20 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` varchar(32) NOT NULL,
  `numero_pedido` varchar(50) NOT NULL,
  `id_planta` varchar(32) NOT NULL,
  `id_administrador` varchar(32) NOT NULL,
  `id_agregado` varchar(32) NOT NULL,
  `unidades` varchar(20) NOT NULL DEFAULT 'm³',
  `fecha_pedido` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `confirmacion_proveedor` tinyint(4) NOT NULL DEFAULT 0,
  `confirmacion_mina` tinyint(4) NOT NULL DEFAULT 0,
  `confirmacion_entregado` tinyint(4) NOT NULL DEFAULT 0,
  `cantidad_pedida` decimal(10,2) NOT NULL DEFAULT 0.00,
  `cantidad_despachada` decimal(10,2) NOT NULL DEFAULT 0.00,
  `cantidad_recibida` decimal(10,2) NOT NULL DEFAULT 0.00,
  `observaciones` text DEFAULT NULL,
  `fecha_confirmacion_proveedor` timestamp NULL DEFAULT NULL,
  `fecha_confirmacion_mina` timestamp NULL DEFAULT NULL,
  `fecha_confirmacion_entregado` timestamp NULL DEFAULT NULL,
  `mina` varchar(255) DEFAULT NULL,
  `chofer` varchar(255) DEFAULT NULL,
  `matricula` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id`, `numero_pedido`, `id_planta`, `id_administrador`, `id_agregado`, `unidades`, `fecha_pedido`, `created_at`, `updated_at`, `confirmacion_proveedor`, `confirmacion_mina`, `confirmacion_entregado`, `cantidad_pedida`, `cantidad_despachada`, `cantidad_recibida`, `observaciones`, `fecha_confirmacion_proveedor`, `fecha_confirmacion_mina`, `fecha_confirmacion_entregado`, `mina`, `chofer`, `matricula`) VALUES
('77889900112233445566778899001122', 'PED001', '12345678901234567890123456789012', 'f67890123456789012345678901234', '12345678901234567890123456789012', 'm³', '2024-09-21 08:00:00', '2024-09-21 08:00:00', '2024-09-21 08:00:00', 1, 1, 1, 100.00, 100.00, 100.00, 'Entrega urgente para obra', '2024-09-21 09:00:00', '2024-09-21 10:00:00', '2024-09-21 16:00:00', 'Mina Norte', 'Luis Gómez', 'ABC123'),
('88990011223344556677889900112233', 'PED002', '23456789012345678901234567890123', '789012345678901234567890123456', '23456789012345678901234567890123', 'm³', '2024-09-22 09:00:00', '2024-09-22 09:00:00', '2024-09-22 09:00:00', 1, 1, 0, 150.00, 150.00, 0.00, 'Material para cimentación', '2024-09-22 10:00:00', '2024-09-22 11:00:00', NULL, 'Mina Sur', 'Ricardo Sánchez', 'DEF456'),
('99001122334455667788990011223344', 'PED003', '34567890123456789012345678901234', '890123456789012345678901234567', '34567890123456789012345678901234', 'm³', '2024-09-23 10:00:00', '2024-09-23 10:00:00', '2024-09-23 10:00:00', 1, 0, 0, 200.00, 0.00, 0.00, 'Arena para mortero', '2024-09-23 11:00:00', NULL, NULL, 'Mina Este', 'Fernando Ramírez', 'GHI789'),
('00112233445566778899001122334455', 'PED004', '45678901234567890123456789012345', '901234567890123456789012345678', '45678901234567890123456789012345', 'm³', '2024-09-24 11:00:00', '2024-09-24 11:00:00', '2024-09-24 11:00:00', 0, 0, 0, 80.00, 0.00, 0.00, 'Piedra para jardinería', NULL, NULL, NULL, 'Mina Oeste', 'Alberto Mendoza', 'JKL012'),
('11223344556677889900112233445566', 'PED005', '56789012345678901234567890123456', '012345678901234567890123456789', '56789012345678901234567890123456', 'm³', '2024-09-25 12:00:00', '2024-09-25 12:00:00', '2024-09-25 12:00:00', 1, 1, 1, 120.00, 120.00, 120.00, 'Base para pavimento', '2024-09-25 13:00:00', '2024-09-25 14:00:00', '2024-09-25 18:00:00', 'Mina Central', 'Gabriel Vargas', 'MNO345');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` varchar(32) NOT NULL,
  `id_administrador` varchar(32) NOT NULL DEFAULT '',
  `id_planta` varchar(32) NOT NULL DEFAULT '',
  `id_cliente` varchar(32) NOT NULL,
  `id_obra` varchar(32) NOT NULL DEFAULT '',
  `id_pedido` varchar(32) NOT NULL DEFAULT '',
  `monto` double(20,2) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `direccion` varchar(500) NOT NULL,
  `cp` varchar(20) NOT NULL,
  `municipio` varchar(100) NOT NULL,
  `entidad` varchar(100) NOT NULL,
  `referencia` varchar(100) NOT NULL DEFAULT '',
  `descripcion` varchar(50) NOT NULL DEFAULT '',
  `detalle` varchar(150) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL DEFAULT 1,
  `CodigoSAP` varchar(50) NOT NULL DEFAULT '',
  `ProcesadoSAP` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `id_administrador`, `id_planta`, `id_cliente`, `id_obra`, `id_pedido`, `monto`, `nombre`, `direccion`, `cp`, `municipio`, `entidad`, `referencia`, `descripcion`, `detalle`, `status`, `CodigoSAP`, `ProcesadoSAP`, `created_at`, `updated_at`) VALUES
('88990011223344556677889900112233', 'f67890123456789012345678901234', '12345678901234567890123456789012', '00112233445566778899001122334455', '667788990011223344556677889900', '77889900112233445566778899001122', 250000.00, 'Constructora ABC SA de CV', 'Reforma 456, Centro', '06000', 'Cuauhtémoc', 'CDMX', 'REF001', 'Anticipo obra Torres Reforma', 'Pago del 50% del anticipo', 1, 'SAPPAG001', NULL, '2024-09-26 08:00:00', '2024-09-26 08:00:00'),
('99001122334455667788990011223344', '789012345678901234567890123456', '23456789012345678901234567890123', '11223344556677889900112233445566', '778899001122334455667788990011', '88990011223344556677889900112233', 120000.00, 'Ingeniería XYZ SA', 'Hidalgo 789, Downtown', '53100', 'Naucalpan', 'EdoMex', 'REF002', 'Parcialidad 1 Plaza Comercial', 'Primer pago programa', 1, 'SAPPAG002', NULL, '2024-09-27 09:00:00', '2024-09-27 09:00:00'),
('00112233445566778899001122334455', '890123456789012345678901234567', '34567890123456789012345678901234', '22334455667788990011223344556677', '889900112233445566778899001122', '99001122334455667788990011223344', 180000.00, 'Desarrollos Pro SA', 'Madero 123, Moderno', '55000', 'Ecatepec', 'EdoMex', 'REF003', 'Abono Condominios Vista', 'Segundo abono del mes', 1, 'SAPPAG003', NULL, '2024-09-28 10:00:00', '2024-09-28 10:00:00'),
('11223344556677889900112233445566', '901234567890123456789012345678', '45678901234567890123456789012345', '33445566778899001122334455667788', '990011223344556677889900112233', '00112233445566778899001122334455', 300000.00, 'Construcciones Modernas', 'Zaragoza 654, Norte', '50000', 'Toluca', 'EdoMex', 'REF004', 'Pago total Hospital Regional', 'Liquidación de factura', 1, 'SAPPAG004', NULL, '2024-09-29 11:00:00', '2024-09-29 11:00:00'),
('22334455667788990011223344556677', '012345678901234567890123456789', '56789012345678901234567890123456', '44556677889900112233445566778899', '001122334455667788990011223344', '11223344556677889900112233445566', 90000.00, 'Obras Civiles SA', 'Morelos 987, Sur', '54700', 'Cuautitlán', 'EdoMex', 'REF005', 'Anticipo Escuela Primaria', '30% de anticipo', 1, 'SAPPAG005', NULL, '2024-09-30 12:00:00', '2024-09-30 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagoschof`
--

CREATE TABLE `pagoschof` (
  `id` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL,
  `id_cita` varchar(32) NOT NULL,
  `id_chofer` varchar(32) NOT NULL,
  `precio` double(20,2) NOT NULL,
  `cantidad` double(20,2) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pagoschof`
--

INSERT INTO `pagoschof` (`id`, `id_planta`, `id_cita`, `id_chofer`, `precio`, `cantidad`, `status`, `created_at`, `updated_at`) VALUES
('99001122334455667788990011223344', '12345678901234567890123456789012', '55667788990011223344556677889900', '44556677889900112233445566778899', 500.00, 10.00, 1, '2024-10-01 08:00:00', '2024-10-01 08:00:00'),
('00112233445566778899001122334455', '23456789012345678901234567890123', '66778899001122334455667788990011', '55667788990011223344556677889900', 400.00, 15.00, 1, '2024-10-02 09:00:00', '2024-10-02 09:00:00'),
('11223344556677889900112233445566', '34567890123456789012345678901234', '77889900112233445566778899001122', '66778899001122334455667788990011', 350.00, 20.00, 0, '2024-10-03 10:00:00', '2024-10-03 10:00:00'),
('22334455667788990011223344556677', '45678901234567890123456789012345', '88990011223344556677889900112233', '77889900112233445566778899001122', 600.00, 8.00, 0, '2024-10-04 11:00:00', '2024-10-04 11:00:00'),
('33445566778899001122334455667788', '56789012345678901234567890123456', '99001122334455667788990011223344', '88990011223344556677889900112233', 450.00, 12.00, 1, '2024-10-05 12:00:00', '2024-10-05 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `id` varchar(32) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `password_resets`
--

INSERT INTO `password_resets` (`id`, `mail`, `token`, `created_at`, `updated_at`) VALUES
('00112233445566778899001122334455', 'juan@empresa.com', 'token1234567890abcdef', '2024-10-06 08:00:00', '2024-10-06 08:00:00'),
('11223344556677889900112233445566', 'maria@empresa.com', 'token2345678901bcdefg', '2024-10-07 09:00:00', '2024-10-07 09:00:00'),
('22334455667788990011223344556677', 'carlos@empresa.com', 'token3456789012cdefgh', '2024-10-08 10:00:00', '2024-10-08 10:00:00'),
('33445566778899001122334455667788', 'ana@empresa.com', 'token4567890123defghi', '2024-10-09 11:00:00', '2024-10-09 11:00:00'),
('44556677889900112233445566778899', 'pedro@empresa.com', 'token5678901234efghij', '2024-10-10 12:00:00', '2024-10-10 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` varchar(32) NOT NULL,
  `folio` int(11) NOT NULL DEFAULT 0,
  `id_planta` varchar(32) NOT NULL,
  `id_usuario` varchar(32) NOT NULL,
  `id_vendedor` varchar(32) NOT NULL DEFAULT '',
  `id_obra` varchar(32) NOT NULL,
  `obra` varchar(500) NOT NULL,
  `direccion` varchar(1500) NOT NULL,
  `latitud` varchar(50) NOT NULL,
  `longitud` varchar(50) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `instrucciones` mediumtext NOT NULL DEFAULT '',
  `comentario` varchar(500) NOT NULL DEFAULT '',
  `fechaentrega` datetime NOT NULL,
  `subtotal` double(20,2) NOT NULL,
  `iva` double(20,2) NOT NULL,
  `total` double(20,2) NOT NULL,
  `referencia` varchar(100) NOT NULL DEFAULT '',
  `confirmacion` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `folio`, `id_planta`, `id_usuario`, `id_vendedor`, `id_obra`, `obra`, `direccion`, `latitud`, `longitud`, `telefono`, `correo`, `instrucciones`, `comentario`, `fechaentrega`, `subtotal`, `iva`, `total`, `referencia`, `confirmacion`, `created_at`, `updated_at`) VALUES
('55667788990011223344556677889900', 1001, '12345678901234567890123456789012', '889900112233445566778899001122', '66778899001122334455667788990011', '667788990011223344556677889900', 'Torres Reforma', 'Insurgentes 789, Polanco, Miguel Hidalgo, CDMX, 11560', '19.4330', '-99.1340', '5512345678', 'juan@constructoraabc.com', 'Entregar en muelle de carga', 'Material urgente para losa', '2024-03-20 09:00:00', 25000.00, 4000.00, 29000.00, 'REF001', 1, '2024-10-11 08:00:00', '2024-10-11 08:00:00'),
('66778899001122334455667788990011', 1002, '23456789012345678901234567890123', '990011223344556677889900112233', '77889900112233445566778899001122', '778899001122334455667788990011', 'Plaza Comercial', 'Juárez 101, Lomas, Naucalpan, EdoMex, 53600', '19.4790', '-99.2400', '5523456789', 'maria@ingenieriaxyz.com', 'Llevar hasta el patio de maniobras', '', '2024-03-21 10:00:00', 12000.00, 1920.00, 13920.00, 'REF002', 1, '2024-10-12 09:00:00', '2024-10-12 09:00:00'),
('77889900112233445566778899001122', 1003, '34567890123456789012345678901234', '001122334455667788990011223344', '88990011223344556677889900112233', '889900112233445566778899001122', 'Condominios Vista', '5 de Mayo 456, Industrial, Ecatepec, EdoMex, 55500', '19.6100', '-99.0610', '5534567890', 'pedro@desarrollospro.com', 'Entregar en área de acopio', 'Material para cimentación', '2024-03-22 11:00:00', 12000.00, 1920.00, 13920.00, 'REF003', 1, '2024-10-13 10:00:00', '2024-10-13 10:00:00'),
('88990011223344556677889900112233', 1004, '45678901234567890123456789012345', '112233445566778899001122334455', '99001122334455667788990011223344', '990011223344556677889900112233', 'Hospital Regional', 'Independencia 321, Centro, Toluca, EdoMex, 50100', '19.2930', '-99.6540', '5545678901', 'ana@constmodernas.com', 'Acceso por puerta de servicios', 'Para área de jardines', '2024-03-23 12:00:00', 9600.00, 1536.00, 11136.00, 'REF004', 1, '2024-10-14 11:00:00', '2024-10-14 11:00:00'),
('99001122334455667788990011223344', 1005, '56789012345678901234567890123456', '223344556677889900112233445566', '00112233445566778899001122334455', '001122334455667788990011223344', 'Escuela Primaria', 'Revolución 654, Oriente, Cuautitlán, EdoMex, 54800', '19.6800', '-99.1800', '5556789012', 'javier@civiles.com', 'Entregar en patio principal', 'Base para cancha', '2024-03-24 13:00:00', 10800.00, 1728.00, 12528.00, 'REF005', 1, '2024-10-15 12:00:00', '2024-10-15 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantas`
--

CREATE TABLE `plantas` (
  `id` varchar(32) NOT NULL,
  `planta` varchar(150) NOT NULL,
  `siglas` varchar(20) NOT NULL DEFAULT '',
  `logo` varchar(200) NOT NULL DEFAULT '',
  `logo2` varchar(200) NOT NULL DEFAULT '',
  `direccion` varchar(500) NOT NULL,
  `latitud` varchar(50) NOT NULL DEFAULT '',
  `latitud2` varchar(50) NOT NULL DEFAULT '',
  `longitud` varchar(50) NOT NULL DEFAULT '',
  `longitud2` varchar(50) NOT NULL DEFAULT '',
  `telefono` varchar(50) NOT NULL DEFAULT '',
  `mail` varchar(150) NOT NULL DEFAULT '',
  `web` varchar(250) NOT NULL DEFAULT '',
  `codigo` varchar(500) NOT NULL,
  `plantaauto` varchar(100) NOT NULL,
  `tipo` int(11) NOT NULL DEFAULT 1,
  `color_primario` varchar(7) NOT NULL DEFAULT '',
  `domingoi` varchar(10) NOT NULL DEFAULT '9:00',
  `lunesi` varchar(10) NOT NULL DEFAULT '9:00',
  `martesi` varchar(10) NOT NULL DEFAULT '9:00',
  `miercolesi` varchar(10) NOT NULL DEFAULT '9:00',
  `juevesi` varchar(10) NOT NULL DEFAULT '9:00',
  `viernesi` varchar(10) NOT NULL DEFAULT '9:00',
  `sabadoi` varchar(10) NOT NULL DEFAULT '9:00',
  `domingof` varchar(10) NOT NULL DEFAULT '18:00',
  `lunesf` varchar(10) NOT NULL DEFAULT '18:00',
  `martesf` varchar(10) NOT NULL DEFAULT '18:00',
  `miercolesf` varchar(10) NOT NULL DEFAULT '18:00',
  `juevesf` varchar(10) NOT NULL DEFAULT '18:00',
  `viernesf` varchar(10) NOT NULL DEFAULT '18:00',
  `sabadof` varchar(10) NOT NULL DEFAULT '18:00',
  `intervalo` varchar(20) NOT NULL DEFAULT '12',
  `activa` tinyint(4) NOT NULL DEFAULT 1,
  `restriccion` tinyint(4) NOT NULL DEFAULT 0,
  `tiempo` int(11) NOT NULL DEFAULT 0,
  `recompensa` float(4,2) NOT NULL DEFAULT 0.00,
  `correosrc` mediumtext NOT NULL DEFAULT '',
  `correosobra` mediumtext NOT NULL DEFAULT '',
  `razonsocial` varchar(250) NOT NULL DEFAULT '',
  `iva` float(5,2) NOT NULL DEFAULT 0.00,
  `banco` varchar(50) NOT NULL DEFAULT '',
  `cuenta` varchar(20) NOT NULL DEFAULT '',
  `clabe` varchar(20) NOT NULL DEFAULT '',
  `referencia` varchar(10) NOT NULL DEFAULT '',
  `limitet` float(20,2) NOT NULL DEFAULT 0.00,
  `folio` int(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `plantas`
--

INSERT INTO `plantas` (`id`, `planta`, `siglas`, `logo`, `logo2`, `direccion`, `latitud`, `latitud2`, `longitud`, `longitud2`, `telefono`, `mail`, `web`, `codigo`, `plantaauto`, `tipo`, `color_primario`, `domingoi`, `lunesi`, `martesi`, `miercolesi`, `juevesi`, `viernesi`, `sabadoi`, `domingof`, `lunesf`, `martesf`, `miercolesf`, `juevesf`, `viernesf`, `sabadof`, `intervalo`, `activa`, `restriccion`, `tiempo`, `recompensa`, `correosrc`, `correosobra`, `razonsocial`, `iva`, `banco`, `cuenta`, `clabe`, `referencia`, `limitet`, `folio`, `created_at`, `updated_at`) VALUES
('12345678901234567890123456789012', 'Planta Norte', 'PN', 'logo_pn.png', 'logo2_pn.png', 'Av. Principal 123, Tlalnepantla, EdoMex', '19.5369', '19.5370', '-99.1964', '-99.1970', '5551234567', 'info@plantanorte.com', 'www.plantanorte.com', 'COD001', 'PN001', 1, '#FF0000', '9:00', '7:00', '7:00', '7:00', '7:00', '7:00', '7:00', '18:00', '19:00', '19:00', '19:00', '19:00', '19:00', '16:00', '12', 1, 0, 30, 5.00, 'src@plantanorte.com,admin@plantanorte.com', 'obras@plantanorte.com', 'Materiales Construcción Norte SA', 16.00, 'Bancomer', '123456789012345678', '012345678901234567', 'REF001', 1000000.00, 100, '2024-01-01 08:00:00', '2024-01-01 08:00:00'),
('23456789012345678901234567890123', 'Planta Sur', 'PS', 'logo_ps.png', 'logo2_ps.png', 'Eje Central 456, Naucalpan, EdoMex', '19.4786', '19.4790', '-99.2398', '-99.2400', '5552345678', 'info@plantasur.com', 'www.plantasur.com', 'COD002', 'PS002', 1, '#00FF00', '9:00', '8:00', '8:00', '8:00', '8:00', '8:00', '8:00', '18:00', '20:00', '20:00', '20:00', '20:00', '20:00', '17:00', '12', 1, 1, 45, 3.00, 'src@plantasur.com', 'obras@plantasur.com', 'Materiales Construcción Sur SA', 16.00, 'Santander', '234567890123456789', '123456789012345678', 'REF002', 800000.00, 200, '2024-01-02 09:00:00', '2024-01-02 09:00:00'),
('34567890123456789012345678901234', 'Planta Este', 'PE', 'logo_pe.png', 'logo2_pe.png', 'Periférico 789, Ecatepec, EdoMex', '19.6099', '19.6100', '-99.0603', '-99.0610', '5553456789', 'info@plantaeste.com', 'www.plantaeste.com', 'COD003', 'PE003', 2, '#0000FF', '10:00', '6:00', '6:00', '6:00', '6:00', '6:00', '6:00', '17:00', '18:00', '18:00', '18:00', '18:00', '18:00', '15:00', '8', 1, 0, 60, 7.00, 'src@plantaeste.com', 'obras@plantaeste.com', 'Materiales Construcción Este SA', 16.00, 'HSBC', '345678901234567890', '234567890123456789', 'REF003', 1200000.00, 300, '2024-01-03 10:00:00', '2024-01-03 10:00:00'),
('45678901234567890123456789012345', 'Planta Oeste', 'PO', 'logo_po.png', 'logo2_po.png', 'Carretera 101, Toluca, EdoMex', '19.2925', '19.2930', '-99.6532', '-99.6540', '5554567890', 'info@plantaoeste.com', 'www.plantaoeste.com', 'COD004', 'PO004', 1, '#FFFF00', '9:00', '7:30', '7:30', '7:30', '7:30', '7:30', '7:30', '18:30', '19:30', '19:30', '19:30', '19:30', '19:30', '16:30', '10', 1, 1, 40, 4.00, 'src@plantaoeste.com', 'obras@plantaoeste.com', 'Materiales Construcción Oeste SA', 16.00, 'BBVA', '456789012345678901', '345678901234567890', 'REF004', 1500000.00, 400, '2024-01-04 11:00:00', '2024-01-04 11:00:00'),
('56789012345678901234567890123456', 'Planta Central', 'PC', 'logo_pc.png', 'logo2_pc.png', 'Boulevard 202, Cuautitlán, EdoMex', '19.6796', '19.6800', '-99.1795', '-99.1800', '5555678901', 'info@plantacentral.com', 'www.plantacentral.com', 'COD005', 'PC005', 1, '#FF00FF', '8:00', '6:30', '6:30', '6:30', '6:30', '6:30', '6:30', '16:00', '18:00', '18:00', '18:00', '18:00', '18:00', '14:00', '15', 1, 0, 50, 6.00, 'src@plantacentral.com', 'obras@plantacentral.com', 'Materiales Construcción Central SA', 16.00, 'Scotia', '567890123456789012', '456789012345678901', 'REF005', 2000000.00, 500, '2024-01-05 12:00:00', '2024-01-05 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id` varchar(32) NOT NULL,
  `id_encuesta` varchar(32) NOT NULL,
  `pregunta` varchar(500) NOT NULL,
  `opciones` varchar(150) NOT NULL DEFAULT '',
  `tipo` float(5,2) NOT NULL,
  `orden` float(5,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id`, `id_encuesta`, `pregunta`, `opciones`, `tipo`, `orden`, `created_at`, `updated_at`) VALUES
('66778899001122334455667788990011', '33445566778899001122334455667788', '¿Cómo calificaría el servicio recibido?', 'Excelente,Bueno,Regular,Malo', 1.00, 1.00, '2024-10-16 08:00:00', '2024-10-16 08:00:00'),
('77889900112233445566778899001122', '44556677889900112233445566778899', '¿El material entregado cumplió con sus expectativas?', 'Sí,No,Parcialmente', 1.00, 2.00, '2024-10-17 09:00:00', '2024-10-17 09:00:00'),
('88990011223344556677889900112233', '55667788990011223344556677889900', '¿El personal fue amable y profesional?', 'Siempre,Generalmente,Rara vez,Nunca', 1.00, 3.00, '2024-10-18 10:00:00', '2024-10-18 10:00:00'),
('99001122334455667788990011223344', '66778899001122334455667788990011', '¿La entrega se realizó en el tiempo prometido?', 'Sí,No,Con retraso', 1.00, 4.00, '2024-10-19 11:00:00', '2024-10-19 11:00:00'),
('00112233445566778899001122334455', '77889900112233445566778899001122', '¿Recomendaría nuestros servicios a otros?', 'Definitivamente sí,Probablemente sí,No estoy seguro,Probablemente no', 1.00, 5.00, '2024-10-20 12:00:00', '2024-10-20 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preverificaciones`
--

CREATE TABLE `preverificaciones` (
  `id` varchar(32) NOT NULL,
  `telefono` varchar(32) NOT NULL,
  `codigo` varchar(5) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `preverificaciones`
--

INSERT INTO `preverificaciones` (`id`, `telefono`, `codigo`, `created_at`, `updated_at`) VALUES
('77889900112233445566778899001122', '5512345678', '12345', '2024-10-21 08:00:00', '2024-10-21 08:00:00'),
('88990011223344556677889900112233', '5523456789', '67890', '2024-10-22 09:00:00', '2024-10-22 09:00:00'),
('99001122334455667788990011223344', '5534567890', 'ABCDE', '2024-10-23 10:00:00', '2024-10-23 10:00:00'),
('00112233445566778899001122334455', '5545678901', 'FGHIJ', '2024-10-24 11:00:00', '2024-10-24 11:00:00'),
('11223344556677889900112233445566', '5556789012', 'KLMNO', '2024-10-25 12:00:00', '2024-10-25 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productofotos`
--

CREATE TABLE `productofotos` (
  `id` varchar(32) NOT NULL,
  `id_producto` varchar(32) NOT NULL,
  `foto` longtext NOT NULL,
  `orden` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productofotos`
--

INSERT INTO `productofotos` (`id`, `id_producto`, `foto`, `orden`, `created_at`, `updated_at`) VALUES
('88990011223344556677889900112233', '990011223344556677889900112233', 'foto_producto1_base64', 1, '2024-10-26 08:00:00', '2024-10-26 08:00:00'),
('99001122334455667788990011223344', '001122334455667788990011223344', 'foto_producto2_base64', 2, '2024-10-27 09:00:00', '2024-10-27 09:00:00'),
('00112233445566778899001122334455', '112233445566778899001122334455', 'foto_producto3_base64', 1, '2024-10-28 10:00:00', '2024-10-28 10:00:00'),
('11223344556677889900112233445566', '223344556677889900112233445566', 'foto_producto4_base64', 3, '2024-10-29 11:00:00', '2024-10-29 11:00:00'),
('22334455667788990011223344556677', '334455667788990011223344556677', 'foto_producto5_base64', 2, '2024-10-30 12:00:00', '2024-10-30 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL,
  `categoria` varchar(150) NOT NULL,
  `sku` varchar(150) NOT NULL DEFAULT '',
  `producto` varchar(150) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `precio` double(20,2) NOT NULL,
  `unidades` varchar(10) NOT NULL DEFAULT 'm³',
  `transporte` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `id_planta`, `categoria`, `sku`, `producto`, `descripcion`, `precio`, `unidades`, `transporte`, `created_at`, `updated_at`) VALUES
('99001122334455667788990011223344', '12345678901234567890123456789012', 'Concreto', 'PROD001', 'Concreto Premezclado 250', 'Concreto para losas y columnas', 2500.00, 'm³', 0, '2024-10-31 08:00:00', '2024-10-31 08:00:00'),
('00112233445566778899001122334455', '23456789012345678901234567890123', 'Grava', 'PROD002', 'Grava Triturada 3/4', 'Grava para cimentación y filtros', 800.00, 'm³', 0, '2024-11-01 09:00:00', '2024-11-01 09:00:00'),
('11223344556677889900112233445566', '34567890123456789012345678901234', 'Arena', 'PROD003', 'Arena de Río Lavada', 'Arena para mortero y acabados', 600.00, 'm³', 0, '2024-11-02 10:00:00', '2024-11-02 10:00:00'),
('22334455667788990011223344556677', '45678901234567890123456789012345', 'Piedra', 'PROD004', 'Piedra Bola Natural', 'Piedra para decoración y jardinería', 1200.00, 'm³', 0, '2024-11-03 11:00:00', '2024-11-03 11:00:00'),
('33445566778899001122334455667788', '56789012345678901234567890123456', 'Base', 'PROD005', 'Base Hidráulica Compactada', 'Base para pavimentos y terracerías', 900.00, 'm³', 0, '2024-11-04 12:00:00', '2024-11-04 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productosobras`
--

CREATE TABLE `productosobras` (
  `id` varchar(32) NOT NULL,
  `id_obra` varchar(32) NOT NULL,
  `id_producto` varchar(32) NOT NULL,
  `categoria` varchar(150) NOT NULL,
  `sku` varchar(150) NOT NULL DEFAULT '',
  `producto` varchar(150) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `precio` double(20,2) NOT NULL,
  `unidades` varchar(10) NOT NULL DEFAULT 'm³',
  `transporte` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productosobras`
--

INSERT INTO `productosobras` (`id`, `id_obra`, `id_producto`, `categoria`, `sku`, `producto`, `descripcion`, `precio`, `unidades`, `transporte`, `created_at`, `updated_at`) VALUES
('44556677889900112233445566778899', '667788990011223344556677889900', '99001122334455667788990011223344', 'Concreto', 'PROD001', 'Concreto Premezclado 250', 'Concreto para losas y columnas', 2500.00, 'm³', 0, '2024-11-05 08:00:00', '2024-11-05 08:00:00'),
('55667788990011223344556677889900', '778899001122334455667788990011', '00112233445566778899001122334455', 'Grava', 'PROD002', 'Grava Triturada 3/4', 'Grava para cimentación y filtros', 800.00, 'm³', 0, '2024-11-06 09:00:00', '2024-11-06 09:00:00'),
('66778899001122334455667788990011', '889900112233445566778899001122', '11223344556677889900112233445566', 'Arena', 'PROD003', 'Arena de Río Lavada', 'Arena para mortero y acabados', 600.00, 'm³', 0, '2024-11-07 10:00:00', '2024-11-07 10:00:00'),
('77889900112233445566778899001122', '990011223344556677889900112233', '22334455667788990011223344556677', 'Piedra', 'PROD004', 'Piedra Bola Natural', 'Piedra para decoración y jardinería', 1200.00, 'm³', 0, '2024-11-08 11:00:00', '2024-11-08 11:00:00'),
('88990011223344556677889900112233', '001122334455667788990011223344', '33445566778899001122334455667788', 'Base', 'PROD005', 'Base Hidráulica Compactada', 'Base para pavimentos y terracerías', 900.00, 'm³', 0, '2024-11-09 12:00:00', '2024-11-09 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` varchar(32) NOT NULL,
  `proveedor` varchar(150) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `passtemp` varchar(20) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `proveedor`, `telefono`, `mail`, `pass`, `passtemp`, `created_at`, `updated_at`) VALUES
('99001122334455667788990011223344', 'Cemento Cruz Azul', '5551112233', 'ventas@cruzazul.com', 'proveedor123', '', '2024-11-10 08:00:00', '2024-11-10 08:00:00'),
('00112233445566778899001122334455', 'Grava San Juan', '5552223344', 'contacto@gravasanjuan.com', 'proveedor456', '', '2024-11-11 09:00:00', '2024-11-11 09:00:00'),
('11223344556677889900112233445566', 'Arena del Valle', '5553334455', 'info@arenadelvalle.com', 'proveedor789', '', '2024-11-12 10:00:00', '2024-11-12 10:00:00'),
('22334455667788990011223344556677', 'Aditivos Químicos', '5554445566', 'quimicos@aditivos.com', 'proveedor012', '', '2024-11-13 11:00:00', '2024-11-13 11:00:00'),
('33445566778899001122334455667788', 'Aceros Nacionales', '5555556677', 'aceros@nacionales.com', 'proveedor345', '', '2024-11-14 12:00:00', '2024-11-14 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicidades`
--

CREATE TABLE `publicidades` (
  `id` varchar(32) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `mail` varchar(150) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `passtemp` varchar(20) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `publicidades`
--

INSERT INTO `publicidades` (`id`, `nombre`, `mail`, `pass`, `passtemp`, `created_at`, `updated_at`) VALUES
('44556677889900112233445566778899', 'Publicidad Express', 'contacto@pubexpress.com', 'publicidad123', '', '2024-11-15 08:00:00', '2024-11-15 08:00:00'),
('55667788990011223344556677889900', 'Marketing Total', 'ventas@marketingtotal.com', 'publicidad456', '', '2024-11-16 09:00:00', '2024-11-16 09:00:00'),
('66778899001122334455667788990011', 'Agencia Creativa', 'info@agenciacreativa.com', 'publicidad789', '', '2024-11-17 10:00:00', '2024-11-17 10:00:00'),
('77889900112233445566778899001122', 'Medios Digitales', 'admin@mediosdigitales.com', 'publicidad012', '', '2024-11-18 11:00:00', '2024-11-18 11:00:00'),
('88990011223344556677889900112233', 'Promociones Hoy', 'promo@promocioneshoy.com', 'publicidad345', '', '2024-11-19 12:00:00', '2024-11-19 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recepciones`
--

CREATE TABLE `recepciones` (
  `id` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `cargo` varchar(150) NOT NULL,
  `firma` longtext NOT NULL DEFAULT '',
  `mail` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `passtemp` varchar(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `recepciones`
--

INSERT INTO `recepciones` (`id`, `id_planta`, `nombre`, `cargo`, `firma`, `mail`, `pass`, `remember_token`, `created_at`, `updated_at`, `passtemp`) VALUES
('66778899001122334455667788990011', '12345678901234567890123456789012', 'Sofía Ramírez', 'Recepcionista', '', 'sofia@empresa.com', 'recepcion123', NULL, '2024-11-20 08:00:00', '2024-11-20 08:00:00', ''),
('77889900112233445566778899001122', '23456789012345678901234567890123', 'Tomás Sánchez', 'Auxiliar de Recepción', '', 'tomas@empresa.com', 'recepcion456', NULL, '2024-11-21 09:00:00', '2024-11-21 09:00:00', ''),
('88990011223344556677889900112233', '34567890123456789012345678901234', 'Valeria Torres', 'Recepcionista Senior', '', 'valeria@empresa.com', 'recepcion789', NULL, '2024-11-22 10:00:00', '2024-11-22 10:00:00', ''),
('99001122334455667788990011223344', '45678901234567890123456789012345', 'Walter Urías', 'Encargado de Recepción', '', 'walter@empresa.com', 'recepcion012', NULL, '2024-11-23 11:00:00', '2024-11-23 11:00:00', ''),
('00112233445566778899001122334455', '56789012345678901234567890123456', 'Ximena Vázquez', 'Recepcionista', '', 'ximena@empresa.com', 'recepcion345', NULL, '2024-11-24 12:00:00', '2024-11-24 12:00:00', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recoleccion`
--

CREATE TABLE `recoleccion` (
  `id` varchar(32) NOT NULL,
  `id_recolector` varchar(32) NOT NULL DEFAULT '',
  `id_negocio` varchar(32) NOT NULL,
  `negocio` varchar(500) NOT NULL,
  `fechavisita` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `recoleccion`
--

INSERT INTO `recoleccion` (`id`, `id_recolector`, `id_negocio`, `negocio`, `fechavisita`, `created_at`, `updated_at`) VALUES
('77889900112233445566778899001122', '88990011223344556677889900112233', '55667788990011223344556677889900', 'Restaurante El Portal', '2024-11-25 09:00:00', '2024-11-25 08:00:00', '2024-11-25 08:00:00'),
('88990011223344556677889900112233', '99001122334455667788990011223344', '66778899001122334455667788990011', 'Hotel Plaza Central', '2024-11-26 10:00:00', '2024-11-26 09:00:00', '2024-11-26 09:00:00'),
('99001122334455667788990011223344', '00112233445566778899001122334455', '77889900112233445566778899001122', 'Supermercado Mega', '2024-11-27 11:00:00', '2024-11-27 10:00:00', '2024-11-27 10:00:00'),
('00112233445566778899001122334455', '11223344556677889900112233445566', '88990011223344556677889900112233', 'Clínica Dental Sonrisa', '2024-11-28 12:00:00', '2024-11-28 11:00:00', '2024-11-28 11:00:00'),
('11223344556677889900112233445566', '22334455667788990011223344556677', '99001122334455667788990011223344', 'Taller Mecánico Rápido', '2024-11-29 13:00:00', '2024-11-29 12:00:00', '2024-11-29 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relaciones`
--

CREATE TABLE `relaciones` (
  `id` varchar(32) NOT NULL,
  `id_administrador` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL,
  `planta` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `relaciones`
--

INSERT INTO `relaciones` (`id`, `id_administrador`, `id_planta`, `planta`, `created_at`, `updated_at`) VALUES
('88990011223344556677889900112233', 'f67890123456789012345678901234', '12345678901234567890123456789012', 'Planta Norte', '2024-11-30 08:00:00', '2024-11-30 08:00:00'),
('99001122334455667788990011223344', '789012345678901234567890123456', '23456789012345678901234567890123', 'Planta Sur', '2024-12-01 09:00:00', '2024-12-01 09:00:00'),
('00112233445566778899001122334455', '890123456789012345678901234567', '34567890123456789012345678901234', 'Planta Este', '2024-12-02 10:00:00', '2024-12-02 10:00:00'),
('11223344556677889900112233445566', '901234567890123456789012345678', '45678901234567890123456789012345', 'Planta Oeste', '2024-12-03 11:00:00', '2024-12-03 11:00:00'),
('22334455667788990011223344556677', '012345678901234567890123456789', '56789012345678901234567890123456', 'Planta Central', '2024-12-04 12:00:00', '2024-12-04 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remisiones`
--

CREATE TABLE `remisiones` (
  `id` varchar(32) NOT NULL,
  `id_detallepedido` varchar(32) NOT NULL,
  `id_vendedor` varchar(32) NOT NULL DEFAULT '',
  `id_chofer` varchar(32) NOT NULL DEFAULT '',
  `orden` int(11) NOT NULL DEFAULT 0,
  `restantes` double(20,2) NOT NULL DEFAULT 0.00,
  `pedidos` double(20,2) NOT NULL DEFAULT 0.00,
  `entregados` double(20,2) NOT NULL DEFAULT 0.00,
  `planta` varchar(150) NOT NULL DEFAULT '',
  `planta_salida` datetime NOT NULL,
  `planta_entrada` datetime NOT NULL,
  `cr` varchar(150) NOT NULL DEFAULT '',
  `chofer` varchar(150) NOT NULL DEFAULT '',
  `firmachofer` longtext NOT NULL DEFAULT '',
  `matricula` varchar(20) NOT NULL DEFAULT '',
  `obra` varchar(500) NOT NULL DEFAULT '',
  `obra_domicilio` varchar(500) NOT NULL DEFAULT '',
  `obra_entrada` datetime NOT NULL,
  `obra_descarga` datetime NOT NULL,
  `obra_salida` datetime NOT NULL,
  `residente` varchar(150) NOT NULL DEFAULT '',
  `residente_telefono` varchar(500) NOT NULL DEFAULT '',
  `nombrerecibio` varchar(150) NOT NULL DEFAULT '',
  `firmares` longtext NOT NULL DEFAULT '',
  `observacion` varchar(500) NOT NULL DEFAULT '',
  `referencia` varchar(50) NOT NULL DEFAULT '',
  `latitud` varchar(50) NOT NULL DEFAULT '',
  `longitud` varchar(50) NOT NULL DEFAULT '',
  `confirmacion` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `remisiones`
--

INSERT INTO `remisiones` (`id`, `id_detallepedido`, `id_vendedor`, `id_chofer`, `orden`, `restantes`, `pedidos`, `entregados`, `planta`, `planta_salida`, `planta_entrada`, `cr`, `chofer`, `firmachofer`, `matricula`, `obra`, `obra_domicilio`, `obra_entrada`, `obra_descarga`, `obra_salida`, `residente`, `residente_telefono`, `nombrerecibio`, `firmares`, `observacion`, `referencia`, `latitud`, `longitud`, `confirmacion`, `created_at`, `updated_at`) VALUES
('99001122334455667788990011223344', '55667788990011223344556677889900', '66778899001122334455667788990011', '44556677889900112233445566778899', 1, 0.00, 10.00, 10.00, 'Planta Norte', '2024-03-20 08:00:00', '2024-03-20 08:30:00', 'CR001', 'Luis Gómez', '', 'ABC123', 'Torres Reforma', 'Insurgentes 789, Polanco', '2024-03-20 09:00:00', '2024-03-20 09:30:00', '2024-03-20 10:00:00', 'Ing. Juan Pérez', '5512345678', 'Arq. Ana López', '', 'Material entregado completo', 'REM001', '19.4330', '-99.1340', 1, '2024-12-05 08:00:00', '2024-12-05 08:00:00'),
('00112233445566778899001122334455', '66778899001122334455667788990011', '77889900112233445566778899001122', '55667788990011223344556677889900', 1, 0.00, 15.00, 15.00, 'Planta Sur', '2024-03-21 09:00:00', '2024-03-21 09:30:00', 'CR002', 'Ricardo Sánchez', '', 'DEF456', 'Plaza Comercial', 'Juárez 101, Lomas', '2024-03-21 10:00:00', '2024-03-21 10:45:00', '2024-03-21 11:00:00', 'Ing. María García', '5523456789', 'Ing. Carlos Ruiz', '', '', 'REM002', '19.4790', '-99.2400', 1, '2024-12-06 09:00:00', '2024-12-06 09:00:00'),
('11223344556677889900112233445566', '77889900112233445566778899001122', '88990011223344556677889900112233', '66778899001122334455667788990011', 1, 5.00, 20.00, 15.00, 'Planta Este', '2024-03-22 10:00:00', '2024-03-22 10:30:00', 'CR003', 'Fernando Ramírez', '', 'GHI789', 'Condominios Vista', '5 de Mayo 456, Industrial', '2024-03-22 11:00:00', '2024-03-22 11:30:00', '2024-03-22 12:00:00', 'Arq. Pedro Martínez', '5534567890', 'Ing. Roberto Díaz', '', 'Falta entregar 5m³', 'REM003', '19.6100', '-99.0610', 1, '2024-12-07 10:00:00', '2024-12-07 10:00:00'),
('22334455667788990011223344556677', '88990011223344556677889900112233', '99001122334455667788990011223344', '77889900112233445566778899001122', 1, 0.00, 8.00, 8.00, 'Planta Oeste', '2024-03-23 11:00:00', '2024-03-23 11:30:00', 'CR004', 'Alberto Mendoza', '', 'JKL012', 'Hospital Regional', 'Independencia 321, Centro', '2024-03-23 12:00:00', '2024-03-23 12:20:00', '2024-03-23 12:40:00', 'Dr. Ana Rodríguez', '5545678901', 'Biól. Laura Castro', '', 'Para área de jardines', 'REM004', '19.2930', '-99.6540', 1, '2024-12-08 11:00:00', '2024-12-08 11:00:00'),
('33445566778899001122334455667788', '99001122334455667788990011223344', '00112233445566778899001122334455', '88990011223344556677889900112233', 1, 0.00, 12.00, 12.00, 'Planta Central', '2024-03-24 12:00:00', '2024-03-24 12:30:00', 'CR005', 'Gabriel Vargas', '', 'MNO345', 'Escuela Primaria', 'Revolución 654, Oriente', '2024-03-24 13:00:00', '2024-03-24 13:25:00', '2024-03-24 13:50:00', 'Prof. Javier López', '5556789012', 'Ing. Sofía Vargas', '', 'Base para cancha', 'REM005', '19.6800', '-99.1800', 1, '2024-12-09 12:00:00', '2024-12-09 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `residentes`
--

CREATE TABLE `residentes` (
  `id` varchar(32) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `firma` longtext NOT NULL DEFAULT '',
  `mail` varchar(50) NOT NULL,
  `pass` varchar(150) NOT NULL,
  `passtemp` varchar(20) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `residentes`
--

INSERT INTO `residentes` (`id`, `nombre`, `firma`, `mail`, `pass`, `passtemp`, `created_at`, `updated_at`) VALUES
('44556677889900112233445566778899', 'Ing. Juan Pérez', '', 'juan@residente.com', 'residente123', '', '2024-12-10 08:00:00', '2024-12-10 08:00:00'),
('55667788990011223344556677889900', 'Ing. María García', '', 'maria@residente.com', 'residente456', '', '2024-12-11 09:00:00', '2024-12-11 09:00:00'),
('66778899001122334455667788990011', 'Arq. Pedro Martínez', '', 'pedro@residente.com', 'residente789', '', '2024-12-12 10:00:00', '2024-12-12 10:00:00'),
('77889900112233445566778899001122', 'Dr. Ana Rodríguez', '', 'ana@residente.com', 'residente012', '', '2024-12-13 11:00:00', '2024-12-13 11:00:00'),
('88990011223344556677889900112233', 'Prof. Javier López', '', 'javier@residente.com', 'residente345', '', '2024-12-14 12:00:00', '2024-12-14 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `residentesobras`
--

CREATE TABLE `residentesobras` (
  `id` varchar(32) NOT NULL,
  `id_residente` varchar(32) NOT NULL,
  `id_obra` varchar(32) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `residentesobras`
--

INSERT INTO `residentesobras` (`id`, `id_residente`, `id_obra`, `created_at`, `updated_at`) VALUES
('55667788990011223344556677889900', '44556677889900112233445566778899', '667788990011223344556677889900', '2024-12-15 08:00:00', '2024-12-15 08:00:00'),
('66778899001122334455667788990011', '55667788990011223344556677889900', '778899001122334455667788990011', '2024-12-16 09:00:00', '2024-12-16 09:00:00'),
('77889900112233445566778899001122', '66778899001122334455667788990011', '889900112233445566778899001122', '2024-12-17 10:00:00', '2024-12-17 10:00:00'),
('88990011223344556677889900112233', '77889900112233445566778899001122', '990011223344556677889900112233', '2024-12-18 11:00:00', '2024-12-18 11:00:00'),
('99001122334455667788990011223344', '88990011223344556677889900112233', '001122334455667788990011223344', '2024-12-19 12:00:00', '2024-12-19 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id` varchar(32) NOT NULL,
  `id_inspeccion` varchar(32) NOT NULL,
  `id_pregunta` varchar(32) NOT NULL,
  `respuesta` varchar(250) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`id`, `id_inspeccion`, `id_pregunta`, `respuesta`, `created_at`, `updated_at`) VALUES
('66778899001122334455667788990011', '66778899001122334455667788990011', '66778899001122334455667788990011', 'Excelente', '2024-12-20 08:00:00', '2024-12-20 08:00:00'),
('77889900112233445566778899001122', '77889900112233445566778899001122', '77889900112233445566778899001122', 'Sí', '2024-12-21 09:00:00', '2024-12-21 09:00:00'),
('88990011223344556677889900112233', '88990011223344556677889900112233', '88990011223344556677889900112233', 'Siempre', '2024-12-22 10:00:00', '2024-12-22 10:00:00'),
('99001122334455667788990011223344', '99001122334455667788990011223344', '99001122334455667788990011223344', 'Sí', '2024-12-23 11:00:00', '2024-12-23 11:00:00'),
('00112233445566778899001122334455', '00112233445566778899001122334455', '00112233445566778899001122334455', 'Definitivamente sí', '2024-12-24 12:00:00', '2024-12-24 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sedemas`
--

CREATE TABLE `sedemas` (
  `id` varchar(32) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `cargo` varchar(150) NOT NULL,
  `mail` varchar(150) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `passtemp` varchar(20) NOT NULL DEFAULT '',
  `principal` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sedemas`
--

INSERT INTO `sedemas` (`id`, `nombre`, `cargo`, `mail`, `pass`, `passtemp`, `principal`, `created_at`, `updated_at`) VALUES
('77889900112233445566778899001122', 'Lic. Alejandro Martínez', 'Director de Ecología', 'alejandro@sedema.com', 'sedema123', '', 1, '2024-12-25 08:00:00', '2024-12-25 08:00:00'),
('88990011223344556677889900112233', 'Biól. Beatriz Navarro', 'Subdirectora de Residuos', 'beatriz@sedema.com', 'sedema456', '', 0, '2024-12-26 09:00:00', '2024-12-26 09:00:00'),
('99001122334455667788990011223344', 'Ing. Carlos Ortiz', 'Inspector Ambiental', 'carlos@sedema.com', 'sedema789', '', 0, '2024-12-27 10:00:00', '2024-12-27 10:00:00'),
('00112233445566778899001122334455', 'Dra. Diana Paredes', 'Coordinadora de Calidad', 'diana@sedema.com', 'sedema012', '', 0, '2024-12-28 11:00:00', '2024-12-28 11:00:00'),
('11223344556677889900112233445566', 'Mtro. Ernesto Quiroz', 'Supervisor de Campo', 'ernesto@sedema.com', 'sedema345', '', 0, '2024-12-29 12:00:00', '2024-12-29 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL,
  `id_chofer` varchar(32) NOT NULL,
  `id_pagos` longtext NOT NULL,
  `monto` double(20,2) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id`, `id_planta`, `id_chofer`, `id_pagos`, `monto`, `status`, `created_at`, `updated_at`) VALUES
('88990011223344556677889900112233', '12345678901234567890123456789012', '44556677889900112233445566778899', '99001122334455667788990011223344', 5000.00, 1, '2024-12-30 08:00:00', '2024-12-30 08:00:00'),
('99001122334455667788990011223344', '23456789012345678901234567890123', '55667788990011223344556677889900', '00112233445566778899001122334455', 6000.00, 1, '2024-12-31 09:00:00', '2024-12-31 09:00:00'),
('00112233445566778899001122334455', '34567890123456789012345678901234', '66778899001122334455667788990011', '11223344556677889900112233445566', 7000.00, 0, '2025-01-01 10:00:00', '2025-01-01 10:00:00'),
('11223344556677889900112233445566', '45678901234567890123456789012345', '77889900112233445566778899001122', '22334455667788990011223344556677', 4800.00, 0, '2025-01-02 11:00:00', '2025-01-02 11:00:00'),
('22334455667788990011223344556677', '56789012345678901234567890123456', '88990011223344556677889900112233', '33445566778899001122334455667788', 5400.00, 1, '2025-01-03 12:00:00', '2025-01-03 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `soportes`
--

CREATE TABLE `soportes` (
  `id` varchar(32) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `soportes`
--

INSERT INTO `soportes` (`id`, `nombre`, `mail`, `pass`, `remember_token`, `created_at`, `updated_at`) VALUES
('99001122334455667788990011223344', 'Soporte Técnico 1', 'soporte1@empresa.com', 'soporte123', NULL, '2025-01-04 08:00:00', '2025-01-04 08:00:00'),
('00112233445566778899001122334455', 'Soporte Técnico 2', 'soporte2@empresa.com', 'soporte456', NULL, '2025-01-05 09:00:00', '2025-01-05 09:00:00'),
('11223344556677889900112233445566', 'Soporte Administrativo', 'soporte3@empresa.com', 'soporte789', NULL, '2025-01-06 10:00:00', '2025-01-06 10:00:00'),
('22334455667788990011223344556677', 'Soporte Sistemas', 'soporte4@empresa.com', 'soporte012', NULL, '2025-01-07 11:00:00', '2025-01-07 11:00:00'),
('33445566778899001122334455667788', 'Soporte General', 'soporte5@empresa.com', 'soporte345', NULL, '2025-01-08 12:00:00', '2025-01-08 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiponegocio`
--

CREATE TABLE `tiponegocio` (
  `id` varchar(32) NOT NULL,
  `tiponegocio` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tiponegocio`
--

INSERT INTO `tiponegocio` (`id`, `tiponegocio`, `created_at`, `updated_at`) VALUES
('00112233445566778899001122334455', 'Restaurante', '2025-01-09 08:00:00', '2025-01-09 08:00:00'),
('11223344556677889900112233445566', 'Hotel', '2025-01-10 09:00:00', '2025-01-10 09:00:00'),
('22334455667788990011223344556677', 'Comercio', '2025-01-11 10:00:00', '2025-01-11 10:00:00'),
('33445566778899001122334455667788', 'Servicios', '2025-01-12 11:00:00', '2025-01-12 11:00:00'),
('44556677889900112233445566778899', 'Taller', '2025-01-13 12:00:00', '2025-01-13 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoobras`
--

CREATE TABLE `tipoobras` (
  `id` varchar(32) NOT NULL,
  `tipoobra` varchar(150) NOT NULL,
  `subtipoobra` varchar(150) NOT NULL,
  `tag` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipoobras`
--

INSERT INTO `tipoobras` (`id`, `tipoobra`, `subtipoobra`, `tag`, `created_at`, `updated_at`) VALUES
('55667788990011223344556677889900', 'Edificio', 'Oficinas', 'comercial', '2025-01-14 08:00:00', '2025-01-14 08:00:00'),
('66778899001122334455667788990011', 'Comercial', 'Plaza', 'comercial', '2025-01-15 09:00:00', '2025-01-15 09:00:00'),
('77889900112233445566778899001122', 'Habitacional', 'Condominio', 'residencial', '2025-01-16 10:00:00', '2025-01-16 10:00:00'),
('88990011223344556677889900112233', 'Salud', 'Hospital', 'salud', '2025-01-17 11:00:00', '2025-01-17 11:00:00'),
('99001122334455667788990011223344', 'Educación', 'Escuela', 'educacion', '2025-01-18 12:00:00', '2025-01-18 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposvehiculo`
--

CREATE TABLE `tiposvehiculo` (
  `id` varchar(32) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `tipovehiculo` varchar(32) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tiposvehiculo`
--

INSERT INTO `tiposvehiculo` (`id`, `id_tipo`, `tipovehiculo`, `created_at`, `updated_at`) VALUES
('66778899001122334455667788990011', 1, 'Camión Revolvedor', '2025-01-19 08:00:00', '2025-01-19 08:00:00'),
('77889900112233445566778899001122', 2, 'Volteo', '2025-01-20 09:00:00', '2025-01-20 09:00:00'),
('88990011223344556677889900112233', 3, 'Torton', '2025-01-21 10:00:00', '2025-01-21 10:00:00'),
('99001122334455667788990011223344', 4, 'Doble Remolque', '2025-01-22 11:00:00', '2025-01-22 11:00:00'),
('00112233445566778899001122334455', 5, 'Camión Pipila', '2025-01-23 12:00:00', '2025-01-23 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transferencias`
--

CREATE TABLE `transferencias` (
  `id` varchar(32) NOT NULL,
  `folio` int(11) NOT NULL,
  `id_origen` varchar(32) NOT NULL,
  `id_destino` varchar(32) NOT NULL,
  `destino` varchar(500) NOT NULL DEFAULT '',
  `id_entrego` varchar(32) NOT NULL DEFAULT '',
  `entrego` varchar(150) NOT NULL DEFAULT '',
  `firma_entrego` longtext NOT NULL DEFAULT '',
  `empt` varchar(500) NOT NULL DEFAULT '',
  `chofer` longtext NOT NULL,
  `vehiculo` varchar(100) NOT NULL,
  `marcaymodelo` varchar(100) NOT NULL,
  `matricula` varchar(100) NOT NULL DEFAULT '',
  `firma_chofer` longtext NOT NULL DEFAULT '',
  `id_material` varchar(32) NOT NULL,
  `material` varchar(150) NOT NULL,
  `precio` float(20,2) NOT NULL DEFAULT 0.00,
  `iva` float(20,2) NOT NULL DEFAULT 0.00,
  `unidades` varchar(10) NOT NULL DEFAULT '',
  `cantidad` double(20,2) NOT NULL DEFAULT 0.00,
  `confirmacion` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `transferencias`
--

INSERT INTO `transferencias` (`id`, `folio`, `id_origen`, `id_destino`, `destino`, `id_entrego`, `entrego`, `firma_entrego`, `empt`, `chofer`, `vehiculo`, `marcaymodelo`, `matricula`, `firma_chofer`, `id_material`, `material`, `precio`, `iva`, `unidades`, `cantidad`, `confirmacion`, `created_at`, `updated_at`) VALUES
('77889900112233445566778899001122', 1001, '12345678901234567890123456789012', '23456789012345678901234567890123', 'Planta Sur', 'f67890123456789012345678901234', 'Juan Pérez', '', '', 'Luis Gómez', 'Camión Revolvedor', 'Freightliner', 'ABC123', '', '00112233445566778899001122334455', 'Concreto 250 kg/cm²', 2500.00, 400.00, 'm³', 50.00, 1, '2025-01-24 08:00:00', '2025-01-24 08:00:00'),
('88990011223344556677889900112233', 1002, '23456789012345678901234567890123', '34567890123456789012345678901234', 'Planta Este', '789012345678901234567890123456', 'María García', '', '', 'Ricardo Sánchez', 'Volteo', 'International', 'DEF456', '', '11223344556677889900112233445566', 'Grava 3/4', 800.00, 128.00, 'm³', 100.00, 1, '2025-01-25 09:00:00', '2025-01-25 09:00:00'),
('99001122334455667788990011223344', 1003, '34567890123456789012345678901234', '45678901234567890123456789012345', 'Planta Oeste', '890123456789012345678901234567', 'Carlos López', '', '', 'Fernando Ramírez', 'Torton', 'Kenworth', 'GHI789', '', '22334455667788990011223344556677', 'Arena Lavada', 600.00, 96.00, 'm³', 80.00, 0, '2025-01-26 10:00:00', '2025-01-26 10:00:00'),
('00112233445566778899001122334455', 1004, '45678901234567890123456789012345', '56789012345678901234567890123456', 'Planta Central', '901234567890123456789012345678', 'Ana Rodríguez', '', '', 'Alberto Mendoza', 'Doble Remolque', 'Mack', 'JKL012', '', '33445566778899001122334455667788', 'Piedra Bola', 1200.00, 192.00, 'm³', 40.00, 0, '2025-01-27 11:00:00', '2025-01-27 11:00:00'),
('11223344556677889900112233445566', 1005, '56789012345678901234567890123456', '12345678901234567890123456789012', 'Planta Norte', '012345678901234567890123456789', 'Pedro Martínez', '', '', 'Gabriel Vargas', 'Camión Pipila', 'Peterbilt', 'MNO345', '', '44556677889900112233445566778899', 'Base Hidráulica', 900.00, 144.00, 'm³', 60.00, 1, '2025-01-28 12:00:00', '2025-01-28 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transporteobras`
--

CREATE TABLE `transporteobras` (
  `id` varchar(32) NOT NULL,
  `id_obra` varchar(32) NOT NULL,
  `id_transporte` varchar(32) NOT NULL,
  `sku` varchar(150) NOT NULL DEFAULT '',
  `transporte` varchar(150) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `capacidad` double(20,2) NOT NULL,
  `cantidad` int(2) NOT NULL,
  `precio` double(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `transporteobras`
--

INSERT INTO `transporteobras` (`id`, `id_obra`, `id_transporte`, `sku`, `transporte`, `descripcion`, `capacidad`, `cantidad`, `precio`, `created_at`, `updated_at`) VALUES
('88990011223344556677889900112233', '667788990011223344556677889900', '99001122334455667788990011223344', 'TRANS001', 'Camión Revolvedor 8m³', 'Revolvedor para concreto', 8.00, 2, 800.00, '2025-01-29 08:00:00', '2025-01-29 08:00:00'),
('99001122334455667788990011223344', '778899001122334455667788990011', '00112233445566778899001122334455', 'TRANS002', 'Volteo 10m³', 'Volteo para materiales a granel', 10.00, 3, 600.00, '2025-01-30 09:00:00', '2025-01-30 09:00:00'),
('00112233445566778899001122334455', '889900112233445566778899001122', '11223344556677889900112233445566', 'TRANS003', 'Torton 12m³', 'Torton para carga general', 12.00, 1, 900.00, '2025-01-31 10:00:00', '2025-01-31 10:00:00'),
('11223344556677889900112233445566', '990011223344556677889900112233', '22334455667788990011223344556677', 'TRANS004', 'Doble Remolque 30m³', 'Para cargas pesadas', 30.00, 2, 1200.00, '2025-02-01 11:00:00', '2025-02-01 11:00:00'),
('22334455667788990011223344556677', '001122334455667788990011223344', '33445566778899001122334455667788', 'TRANS005', 'Camión Pipila 15m³', 'Para materiales pesados', 15.00, 1, 1000.00, '2025-02-02 12:00:00', '2025-02-02 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transportes`
--

CREATE TABLE `transportes` (
  `id` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL,
  `sku` varchar(150) NOT NULL DEFAULT '',
  `transporte` varchar(150) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `capacidad` double(20,2) NOT NULL,
  `precio` double(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `transportes`
--

INSERT INTO `transportes` (`id`, `id_planta`, `sku`, `transporte`, `descripcion`, `capacidad`, `precio`, `created_at`, `updated_at`) VALUES
('99001122334455667788990011223344', '12345678901234567890123456789012', 'TRANS001', 'Camión Revolvedor 8m³', 'Revolvedor para concreto premezclado', 8.00, 800.00, '2025-02-03 08:00:00', '2025-02-03 08:00:00'),
('00112233445566778899001122334455', '23456789012345678901234567890123', 'TRANS002', 'Volteo 10m³', 'Volteo para materiales a granel', 10.00, 600.00, '2025-02-04 09:00:00', '2025-02-04 09:00:00'),
('11223344556677889900112233445566', '34567890123456789012345678901234', 'TRANS003', 'Torton 12m³', 'Torton para carga general', 12.00, 900.00, '2025-02-05 10:00:00', '2025-02-05 10:00:00'),
('22334455667788990011223344556677', '45678901234567890123456789012345', 'TRANS004', 'Doble Remolque 30m³', 'Para cargas pesadas y grandes volúmenes', 30.00, 1200.00, '2025-02-06 11:00:00', '2025-02-06 11:00:00'),
('33445566778899001122334455667788', '56789012345678901234567890123456', 'TRANS005', 'Camión Pipila 15m³', 'Para materiales pesados y maquinaria', 15.00, 1000.00, '2025-02-07 12:00:00', '2025-02-07 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transportistas`
--

CREATE TABLE `transportistas` (
  `id` varchar(32) NOT NULL,
  `transportista` varchar(150) NOT NULL,
  `mail` varchar(150) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `confirmacion` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `transportistas`
--

INSERT INTO `transportistas` (`id`, `transportista`, `mail`, `pass`, `confirmacion`, `created_at`, `updated_at`) VALUES
('99001122334455667788990011223344', 'Transportes Rápidos SA', 'admin@transportesrapidos.com', 'transportista123', 1, '2025-02-08 08:00:00', '2025-02-08 08:00:00'),
('00112233445566778899001122334455', 'Carga Express SA', 'direccion@cargaexpress.com', 'transportista456', 1, '2025-02-09 09:00:00', '2025-02-09 09:00:00'),
('11223344556677889900112233445566', 'Fletes Veloz SA', 'gerente@fletesveloz.com', 'transportista789', 1, '2025-02-10 10:00:00', '2025-02-10 10:00:00'),
('22334455667788990011223344556677', 'Transportes Toluca SA', 'administracion@transportestoluca.com', 'transportista012', 0, '2025-02-11 11:00:00', '2025-02-11 11:00:00'),
('33445566778899001122334455667788', 'Cargas Pesadas SA', 'operaciones@cargaspesadas.com', 'transportista345', 1, '2025-02-12 12:00:00', '2025-02-12 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `uias`
--

CREATE TABLE `uias` (
  `id` varchar(32) NOT NULL,
  `uia` varchar(150) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `mail` varchar(150) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `passtemp` varchar(20) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `uias`
--

INSERT INTO `uias` (`id`, `uia`, `nombre`, `mail`, `pass`, `passtemp`, `created_at`, `updated_at`) VALUES
('88990011223344556677889900112233', 'UIA Consultores', 'Lic. Yolanda Zambrano', 'yolanda@uia.com', 'uia123', '', '2025-02-13 08:00:00', '2025-02-13 08:00:00'),
('99001122334455667788990011223344', 'Ambiental SA', 'Arq. Zacarías Zapata', 'zacarias@ambiental.com', 'uia456', '', '2025-02-14 09:00:00', '2025-02-14 09:00:00'),
('00112233445566778899001122334455', 'EcoConsultores', 'Biól. Adriana Aguilar', 'adriana@ecoconsultores.com', 'uia789', '', '2025-02-15 10:00:00', '2025-02-15 10:00:00'),
('11223344556677889900112233445566', 'Gestión Ambiental', 'Ing. Bruno Bravo', 'bruno@gestionambiental.com', 'uia012', '', '2025-02-16 11:00:00', '2025-02-16 11:00:00'),
('22334455667788990011223344556677', 'Consultores Verdes', 'Dra. Claudia Cabrera', 'claudia@consultoresverdes.com', 'uia345', '', '2025-02-17 12:00:00', '2025-02-17 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id` varchar(32) NOT NULL,
  `id_empresatransporte` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL DEFAULT '',
  `vehiculo` varchar(100) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `matricula` varchar(100) NOT NULL,
  `combustible` varchar(50) NOT NULL,
  `detalle` varchar(100) NOT NULL,
  `tipo` int(1) NOT NULL DEFAULT 0,
  `confirmacion` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id`, `id_empresatransporte`, `id_planta`, `vehiculo`, `marca`, `modelo`, `matricula`, `combustible`, `detalle`, `tipo`, `confirmacion`, `created_at`, `updated_at`) VALUES
('00112233445566778899001122334455', '88990011223344556677889900112233', '12345678901234567890123456789012', 'Camión Revolvedor', 'Freightliner', '2023', 'ABC123', 'Diesel', 'Color blanco, 8m³', 1, 1, '2025-02-18 08:00:00', '2025-02-18 08:00:00'),
('11223344556677889900112233445566', '99001122334455667788990011223344', '23456789012345678901234567890123', 'Volteo', 'International', '2022', 'DEF456', 'Gasolina', 'Color azul, 10m³', 2, 1, '2025-02-19 09:00:00', '2025-02-19 09:00:00'),
('22334455667788990011223344556677', '00112233445566778899001122334455', '34567890123456789012345678901234', 'Torton', 'Kenworth', '2021', 'GHI789', 'Diesel', 'Color rojo, 12m³', 3, 1, '2025-02-20 10:00:00', '2025-02-20 10:00:00'),
('33445566778899001122334455667788', '11223344556677889900112233445566', '45678901234567890123456789012345', 'Doble Remolque', 'Mack', '2020', 'JKL012', 'Diesel', 'Color negro, 30m³', 4, 1, '2025-02-21 11:00:00', '2025-02-21 11:00:00'),
('44556677889900112233445566778899', '22334455667788990011223344556677', '56789012345678901234567890123456', 'Camión Pipila', 'Peterbilt', '2023', 'MNO345', 'Gas', 'Color gris, 15m³', 5, 1, '2025-02-22 12:00:00', '2025-02-22 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedores`
--

CREATE TABLE `vendedores` (
  `id` varchar(32) NOT NULL,
  `id_planta` varchar(32) NOT NULL,
  `vendedor` varchar(150) NOT NULL,
  `mail` varchar(150) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `pospago` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `passtemp` varchar(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `vendedores`
--

INSERT INTO `vendedores` (`id`, `id_planta`, `vendedor`, `mail`, `pass`, `pospago`, `created_at`, `updated_at`, `passtemp`) VALUES
('66778899001122334455667788990011', '12345678901234567890123456789012', 'David Ramírez', 'david@ventas.com', 'vendedor123', 1, '2025-02-23 08:00:00', '2025-02-23 08:00:00', ''),
('77889900112233445566778899001122', '23456789012345678901234567890123', 'Elena Sánchez', 'elena@ventas.com', 'vendedor456', 1, '2025-02-24 09:00:00', '2025-02-24 09:00:00', ''),
('88990011223344556677889900112233', '34567890123456789012345678901234', 'Fernando Torres', 'fernando@ventas.com', 'vendedor789', 1, '2025-02-25 10:00:00', '2025-02-25 10:00:00', ''),
('99001122334455667788990011223344', '45678901234567890123456789012345', 'Gabriela Urías', 'gabriela@ventas.com', 'vendedor012', 1, '2025-02-26 11:00:00', '2025-02-26 11:00:00', ''),
('00112233445566778899001122334455', '56789012345678901234567890123456', 'Héctor Vázquez', 'hector@ventas.com', 'vendedor345', 1, '2025-02-27 12:00:00', '2025-02-27 12:00:00', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` varchar(32) NOT NULL,
  `id_vendedor` varchar(32) NOT NULL,
  `nombres` varchar(150) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `mail` varchar(150) NOT NULL,
  `pass` varchar(250) NOT NULL,
  `passtemp` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `id_vendedor`, `nombres`, `apellidos`, `mail`, `pass`, `passtemp`, `created_at`, `updated_at`) VALUES
('77889900112233445566778899001122', '66778899001122334455667788990011', 'Iván', 'Wong', 'ivan@ventasexternas.com', 'ventas123', '', '2025-02-28 08:00:00', '2025-02-28 08:00:00'),
('88990011223344556677889900112233', '77889900112233445566778899001122', 'Julia', 'Xochitl', 'julia@ventasexternas.com', 'ventas456', '', '2025-03-01 09:00:00', '2025-03-01 09:00:00'),
('99001122334455667788990011223344', '88990011223344556677889900112233', 'Kevin', 'Yáñez', 'kevin@ventasexternas.com', 'ventas789', '', '2025-03-02 10:00:00', '2025-03-02 10:00:00'),
('00112233445566778899001122334455', '99001122334455667788990011223344', 'Laura', 'Zamora', 'laura@ventasexternas.com', 'ventas012', '', '2025-03-03 11:00:00', '2025-03-03 11:00:00'),
('11223344556677889900112233445566', '00112233445566778899001122334455', 'Miguel', 'Álvarez', 'miguel@ventasexternas.com', 'ventas345', '', '2025-03-04 12:00:00', '2025-03-04 12:00:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adinspecciones`
--
ALTER TABLE `adinspecciones`
  ADD UNIQUE KEY `adinspecciones_id_unique` (`id`);

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD UNIQUE KEY `administradores_id_unique` (`id`),
  ADD KEY `administradores_id_planta_index` (`id_planta`),
  ADD KEY `administradores_mail_index` (`mail`);

--
-- Indices de la tabla `agregados`
--
ALTER TABLE `agregados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `appkeys`
--
ALTER TABLE `appkeys`
  ADD UNIQUE KEY `appkeys_id_unique` (`id`);

--
-- Indices de la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD UNIQUE KEY `asignaciones_id_unique` (`id`);

--
-- Indices de la tabla `asociados`
--
ALTER TABLE `asociados`
  ADD UNIQUE KEY `asociados_id_unique` (`id`);

--
-- Indices de la tabla `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `basculas`
--
ALTER TABLE `basculas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoriasmaterial`
--
ALTER TABLE `categoriasmaterial`
  ADD UNIQUE KEY `categoriasmaterial_id_unique` (`id`);

--
-- Indices de la tabla `chalanes`
--
ALTER TABLE `chalanes`
  ADD UNIQUE KEY `chalanes_id_unique` (`id`);

--
-- Indices de la tabla `choferes`
--
ALTER TABLE `choferes`
  ADD UNIQUE KEY `choferes_id_unique` (`id`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD UNIQUE KEY `citas_id_unique` (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD UNIQUE KEY `clientes_id_unique` (`id`),
  ADD UNIQUE KEY `clientes_mail_unique` (`mail`);

--
-- Indices de la tabla `codigos`
--
ALTER TABLE `codigos`
  ADD UNIQUE KEY `codigos_id_unique` (`id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `condicionmateriales`
--
ALTER TABLE `condicionmateriales`
  ADD UNIQUE KEY `condicionmateriales_id_unique` (`id`);

--
-- Indices de la tabla `condonaciones`
--
ALTER TABLE `condonaciones`
  ADD UNIQUE KEY `condonaciones_id_unique` (`id`);

--
-- Indices de la tabla `configuraciones`
--
ALTER TABLE `configuraciones`
  ADD UNIQUE KEY `configuraciones_id_unique` (`id`);

--
-- Indices de la tabla `coordenadas`
--
ALTER TABLE `coordenadas`
  ADD UNIQUE KEY `coordenadas_id_unique` (`id`);

--
-- Indices de la tabla `dependencias`
--
ALTER TABLE `dependencias`
  ADD UNIQUE KEY `dependencias_id_unique` (`id`),
  ADD UNIQUE KEY `dependencias_mail_unique` (`mail`);

--
-- Indices de la tabla `despachadores`
--
ALTER TABLE `despachadores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detallepedidos`
--
ALTER TABLE `detallepedidos`
  ADD UNIQUE KEY `detallepedidos_id_unique` (`id`);

--
-- Indices de la tabla `directores`
--
ALTER TABLE `directores`
  ADD UNIQUE KEY `directores_id_unique` (`id`);

--
-- Indices de la tabla `dosificadores`
--
ALTER TABLE `dosificadores`
  ADD UNIQUE KEY `dosificadores_id_unique` (`id`);

--
-- Indices de la tabla `empresastransporte`
--
ALTER TABLE `empresastransporte`
  ADD UNIQUE KEY `empresastransporte_id_unique` (`id`);

--
-- Indices de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD UNIQUE KEY `encuestas_id_unique` (`id`);

--
-- Indices de la tabla `entidades`
--
ALTER TABLE `entidades`
  ADD UNIQUE KEY `entidades_id_unique` (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `finanzas`
--
ALTER TABLE `finanzas`
  ADD UNIQUE KEY `finanzas_id_unique` (`id`);

--
-- Indices de la tabla `fridays`
--
ALTER TABLE `fridays`
  ADD UNIQUE KEY `fridays_id_unique` (`id`);

--
-- Indices de la tabla `fueras`
--
ALTER TABLE `fueras`
  ADD UNIQUE KEY `fueras_id_unique` (`id`);

--
-- Indices de la tabla `generadores`
--
ALTER TABLE `generadores`
  ADD UNIQUE KEY `generadores_id_unique` (`id`);

--
-- Indices de la tabla `historiales`
--
ALTER TABLE `historiales`
  ADD UNIQUE KEY `historiales_id_unique` (`id`);

--
-- Indices de la tabla `inspecciones`
--
ALTER TABLE `inspecciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inspectores`
--
ALTER TABLE `inspectores`
  ADD UNIQUE KEY `inspectores_id_unique` (`id`);

--
-- Indices de la tabla `insumos`
--
ALTER TABLE `insumos`
  ADD UNIQUE KEY `insumos_id_unique` (`id`);

--
-- Indices de la tabla `logueos`
--
ALTER TABLE `logueos`
  ADD UNIQUE KEY `logueos_id_unique` (`id`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD UNIQUE KEY `materiales_id_unique` (`id`);

--
-- Indices de la tabla `materialesobra`
--
ALTER TABLE `materialesobra`
  ADD UNIQUE KEY `materialesobra_id_unique` (`id`);

--
-- Indices de la tabla `materialessireq`
--
ALTER TABLE `materialessireq`
  ADD UNIQUE KEY `materialessireq_id_unique` (`id`);

--
-- Indices de la tabla `microgeneradores`
--
ALTER TABLE `microgeneradores`
  ADD UNIQUE KEY `microgeneradores_id_unique` (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mododios`
--
ALTER TABLE `mododios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `multas`
--
ALTER TABLE `multas`
  ADD UNIQUE KEY `multas_id_unique` (`id`);

--
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD UNIQUE KEY `municipios_id_unique` (`id`);

--
-- Indices de la tabla `negocios`
--
ALTER TABLE `negocios`
  ADD UNIQUE KEY `negocios_id_unique` (`id`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD UNIQUE KEY `notificaciones_id_unique` (`id`);

--
-- Indices de la tabla `obras`
--
ALTER TABLE `obras`
  ADD UNIQUE KEY `obras_id_unique` (`id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_numero_pedido_unique` (`numero_pedido`),
  ADD KEY `orders_id_planta_index` (`id_planta`),
  ADD KEY `orders_id_administrador_index` (`id_administrador`),
  ADD KEY `orders_id_agregado_index` (`id_agregado`),
  ADD KEY `orders_fecha_pedido_index` (`fecha_pedido`),
  ADD KEY `orders_confirmacion_proveedor_index` (`confirmacion_proveedor`),
  ADD KEY `orders_confirmacion_mina_index` (`confirmacion_mina`),
  ADD KEY `orders_confirmacion_entregado_index` (`confirmacion_entregado`),
  ADD KEY `orders_confirmacion_indexes` (`confirmacion_proveedor`,`confirmacion_mina`,`confirmacion_entregado`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD UNIQUE KEY `pagos_id_unique` (`id`);

--
-- Indices de la tabla `pagoschof`
--
ALTER TABLE `pagoschof`
  ADD UNIQUE KEY `pagoschof_id_unique` (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_resets_email_index` (`mail`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD UNIQUE KEY `pedidos_id_unique` (`id`);

--
-- Indices de la tabla `plantas`
--
ALTER TABLE `plantas`
  ADD UNIQUE KEY `plantas_id_unique` (`id`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD UNIQUE KEY `preguntas_id_unique` (`id`);

--
-- Indices de la tabla `preverificaciones`
--
ALTER TABLE `preverificaciones`
  ADD UNIQUE KEY `preverificaciones_id_unique` (`id`);

--
-- Indices de la tabla `productofotos`
--
ALTER TABLE `productofotos`
  ADD UNIQUE KEY `productofotos_id_unique` (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD UNIQUE KEY `productos_id_unique` (`id`);

--
-- Indices de la tabla `productosobras`
--
ALTER TABLE `productosobras`
  ADD UNIQUE KEY `productosobras_id_unique` (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD UNIQUE KEY `proovedores_id_unique` (`id`);

--
-- Indices de la tabla `publicidades`
--
ALTER TABLE `publicidades`
  ADD UNIQUE KEY `publicidades_id_unique` (`id`);

--
-- Indices de la tabla `recepciones`
--
ALTER TABLE `recepciones`
  ADD UNIQUE KEY `recepciones_id_unique` (`id`);

--
-- Indices de la tabla `recoleccion`
--
ALTER TABLE `recoleccion`
  ADD UNIQUE KEY `recoleccion_id_unique` (`id`);

--
-- Indices de la tabla `relaciones`
--
ALTER TABLE `relaciones`
  ADD UNIQUE KEY `relaciones_id_unique` (`id`);

--
-- Indices de la tabla `remisiones`
--
ALTER TABLE `remisiones`
  ADD UNIQUE KEY `remisiones_id_unique` (`id`);

--
-- Indices de la tabla `residentes`
--
ALTER TABLE `residentes`
  ADD UNIQUE KEY `residentes_id_unique` (`id`),
  ADD UNIQUE KEY `residentes_correo_unique` (`mail`);

--
-- Indices de la tabla `residentesobras`
--
ALTER TABLE `residentesobras`
  ADD UNIQUE KEY `residentesobras_id_unique` (`id`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD UNIQUE KEY `respuestas_id_unique` (`id`);

--
-- Indices de la tabla `sedemas`
--
ALTER TABLE `sedemas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD UNIQUE KEY `solicitudes_id_unique` (`id`);

--
-- Indices de la tabla `soportes`
--
ALTER TABLE `soportes`
  ADD UNIQUE KEY `soportes_id_unique` (`id`);

--
-- Indices de la tabla `tiponegocio`
--
ALTER TABLE `tiponegocio`
  ADD UNIQUE KEY `tiponegocio_id_unique` (`id`);

--
-- Indices de la tabla `tipoobras`
--
ALTER TABLE `tipoobras`
  ADD UNIQUE KEY `tipoobras_id_unique` (`id`);

--
-- Indices de la tabla `tiposvehiculo`
--
ALTER TABLE `tiposvehiculo`
  ADD UNIQUE KEY `tiposvehiculo_id_unique` (`id`);

--
-- Indices de la tabla `transferencias`
--
ALTER TABLE `transferencias`
  ADD PRIMARY KEY (`folio`),
  ADD UNIQUE KEY `transferencias_id_unique` (`id`);

--
-- Indices de la tabla `transporteobras`
--
ALTER TABLE `transporteobras`
  ADD UNIQUE KEY `transporteobras_id_unique` (`id`);

--
-- Indices de la tabla `transportes`
--
ALTER TABLE `transportes`
  ADD UNIQUE KEY `transportes_id_unique` (`id`);

--
-- Indices de la tabla `transportistas`
--
ALTER TABLE `transportistas`
  ADD UNIQUE KEY `transportistas_id_unique` (`id`);

--
-- Indices de la tabla `uias`
--
ALTER TABLE `uias`
  ADD UNIQUE KEY `uias_id_unique` (`id`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD UNIQUE KEY `vehiculos_id_unique` (`id`),
  ADD UNIQUE KEY `matricula_UNIQUE` (`matricula`);

--
-- Indices de la tabla `vendedores`
--
ALTER TABLE `vendedores`
  ADD UNIQUE KEY `directores_id_unique` (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD UNIQUE KEY `ventas_id_unique` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `transferencias`
--
ALTER TABLE `transferencias`
  MODIFY `folio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1006;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;