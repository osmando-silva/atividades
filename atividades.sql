-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 14/12/2021 às 20:28
-- Versão do servidor: 8.0.27
-- Versão do PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `atividades`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `ATIVIDADES`
--

DROP TABLE IF EXISTS `ATIVIDADES`;
CREATE TABLE `ATIVIDADES` (
  `CODIGO` int NOT NULL,
  `TITULO` varchar(45) DEFAULT NULL,
  `DESCRICAO` varchar(255) DEFAULT NULL,
  `TIPO_CODIGO` int DEFAULT NULL,
  `STATUS` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `LOG`
--

DROP TABLE IF EXISTS `LOG`;
CREATE TABLE `LOG` (
  `CODIGO` int NOT NULL,
  `DATA_LOG` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `IP_ORIGEM` varchar(45) DEFAULT NULL,
  `ACAO` text NOT NULL,
  `USUARIO_CODIGO` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `MENU`
--

DROP TABLE IF EXISTS `MENU`;
CREATE TABLE `MENU` (
  `CODIGO` int NOT NULL,
  `TITULO` varchar(45) NOT NULL,
  `CODIGO_PAI` int NOT NULL,
  `POSICAO` int NOT NULL,
  `LINK` varchar(45) DEFAULT NULL,
  `ICONE` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `MENU`
--

INSERT INTO `MENU` (`CODIGO`, `TITULO`, `CODIGO_PAI`, `POSICAO`, `LINK`, `ICONE`) VALUES
(1, 'Administração', 0, 3, '#', 'fa fa-gears'),
(2, 'Atividades', 0, 0, '#', 'fa fa-check-circle'),
(5, 'Usuários', 1, 0, 'usuarios', 'fa fa-user'),
(6, 'Registros do Sistema (Log)', 1, 8, 'registros', 'fa fa-eye'),
(7, 'Cadastro', 2, 0, 'atividades', 'fa fa-check-circle'),
(8, 'Tipos de atividade', 1, 1, 'tipos', 'fa fa-gears');

-- --------------------------------------------------------

--
-- Estrutura para tabela `PERFIL`
--

DROP TABLE IF EXISTS `PERFIL`;
CREATE TABLE `PERFIL` (
  `CODIGO` int NOT NULL,
  `NOME` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ABREVIATURA` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `PERFIL`
--

INSERT INTO `PERFIL` (`CODIGO`, `NOME`, `ABREVIATURA`) VALUES
(1, 'Administrador', 'Admin'),
(2, 'Usuário', 'Usuário');

-- --------------------------------------------------------

--
-- Estrutura para tabela `PERFIL_MENU`
--

DROP TABLE IF EXISTS `PERFIL_MENU`;
CREATE TABLE `PERFIL_MENU` (
  `CODIGO` int NOT NULL,
  `PERFIL_CODIGO` int NOT NULL,
  `MENU_CODIGO` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `PERFIL_MENU`
--

INSERT INTO `PERFIL_MENU` (`CODIGO`, `PERFIL_CODIGO`, `MENU_CODIGO`) VALUES
(1, 1, 1),
(8, 1, 6),
(10, 1, 5),
(11, 1, 2),
(12, 1, 7),
(13, 2, 2),
(14, 2, 7),
(15, 1, 8);

-- --------------------------------------------------------

--
-- Estrutura para tabela `SESSIONS`
--

DROP TABLE IF EXISTS `SESSIONS`;
CREATE TABLE `SESSIONS` (
  `id` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ip_address` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `timestamp` int UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TIPO`
--

DROP TABLE IF EXISTS `TIPO`;
CREATE TABLE `TIPO` (
  `CODIGO` int NOT NULL,
  `DESCRICAO` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `TIPO`
--

INSERT INTO `TIPO` (`CODIGO`, `DESCRICAO`) VALUES
(1, 'Desenvolvimento'),
(2, 'Atendimento'),
(3, 'Manutenção'),
(4, 'Manutenção Urgente');

-- --------------------------------------------------------

--
-- Estrutura para tabela `USUARIO`
--

DROP TABLE IF EXISTS `USUARIO`;
CREATE TABLE `USUARIO` (
  `CODIGO` int NOT NULL,
  `LOGIN` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `NOME` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `CONTATO` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `SENHA` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ATIVO` int NOT NULL DEFAULT '1',
  `EMAIL` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Despejando dados para a tabela `USUARIO`
--

INSERT INTO `USUARIO` (`CODIGO`, `LOGIN`, `NOME`, `CONTATO`, `SENHA`, `ATIVO`, `EMAIL`) VALUES
(4, '99999999999', 'ADMINISTRADOR', '333121212', '$2a$10$suUkXqTnAfUxu0AfBdIgZOBSZVXXsatUel5nv4.4tKCPO84WK1lOm', 1, 'admin@admin');

-- --------------------------------------------------------

--
-- Estrutura para tabela `USUARIO_PERFIL`
--

DROP TABLE IF EXISTS `USUARIO_PERFIL`;
CREATE TABLE `USUARIO_PERFIL` (
  `CODIGO` int NOT NULL,
  `USUARIO_CODIGO` int NOT NULL,
  `PERFIL_CODIGO` int NOT NULL,
  `DATA_FIM` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `USUARIO_PERFIL`
--

INSERT INTO `USUARIO_PERFIL` (`CODIGO`, `USUARIO_CODIGO`, `PERFIL_CODIGO`, `DATA_FIM`) VALUES
(49, 4, 1, NULL),
(50, 4, 2, NULL);

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `ATIVIDADES`
--
ALTER TABLE `ATIVIDADES`
  ADD PRIMARY KEY (`CODIGO`);

--
-- Índices de tabela `LOG`
--
ALTER TABLE `LOG`
  ADD PRIMARY KEY (`CODIGO`),
  ADD KEY `IND_DATA_LOG` (`DATA_LOG`),
  ADD KEY `IND_USUARIO` (`USUARIO_CODIGO`);

--
-- Índices de tabela `MENU`
--
ALTER TABLE `MENU`
  ADD PRIMARY KEY (`CODIGO`);

--
-- Índices de tabela `PERFIL`
--
ALTER TABLE `PERFIL`
  ADD PRIMARY KEY (`CODIGO`);

--
-- Índices de tabela `PERFIL_MENU`
--
ALTER TABLE `PERFIL_MENU`
  ADD PRIMARY KEY (`CODIGO`),
  ADD KEY `IND_PERFIL` (`PERFIL_CODIGO`),
  ADD KEY `IND_MENU` (`MENU_CODIGO`);

--
-- Índices de tabela `SESSIONS`
--
ALTER TABLE `SESSIONS`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Índices de tabela `TIPO`
--
ALTER TABLE `TIPO`
  ADD PRIMARY KEY (`CODIGO`);

--
-- Índices de tabela `USUARIO`
--
ALTER TABLE `USUARIO`
  ADD PRIMARY KEY (`CODIGO`),
  ADD KEY `IND_LOGIN` (`LOGIN`);

--
-- Índices de tabela `USUARIO_PERFIL`
--
ALTER TABLE `USUARIO_PERFIL`
  ADD PRIMARY KEY (`CODIGO`),
  ADD KEY `IND_USUARIO` (`USUARIO_CODIGO`),
  ADD KEY `IND_PERFIL` (`PERFIL_CODIGO`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `ATIVIDADES`
--
ALTER TABLE `ATIVIDADES`
  MODIFY `CODIGO` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `LOG`
--
ALTER TABLE `LOG`
  MODIFY `CODIGO` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=260;

--
-- AUTO_INCREMENT de tabela `PERFIL_MENU`
--
ALTER TABLE `PERFIL_MENU`
  MODIFY `CODIGO` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `TIPO`
--
ALTER TABLE `TIPO`
  MODIFY `CODIGO` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `USUARIO`
--
ALTER TABLE `USUARIO`
  MODIFY `CODIGO` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `USUARIO_PERFIL`
--
ALTER TABLE `USUARIO_PERFIL`
  MODIFY `CODIGO` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
