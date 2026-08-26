-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26-Ago-2026 às 19:53
-- Versão do servidor: 8.0.29
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `rafapj`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `areas`
--

CREATE TABLE `areas` (
  `id` int UNSIGNED NOT NULL,
  `nome` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `sexo` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doencas` text COLLATE utf8mb4_unicode_ci,
  `sintomas` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `situacao_atual` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `informacoes_adicionais` text COLLATE utf8mb4_unicode_ci,
  `area_recomendada` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `motivos` json DEFAULT NULL,
  `observacao` text COLLATE utf8mb4_unicode_ci,
  `necessita_conferencia` tinyint(1) NOT NULL DEFAULT '0',
  `confianca` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `consultas`
--

CREATE TABLE `consultas` (
  `id` int NOT NULL,
  `nome_paciente` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_paciente` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone_paciente` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `endereco_paciente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `especialidade` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `motivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `problema` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `objetivo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observacoes` text COLLATE utf8mb4_unicode_ci,
  `data_consulta` date NOT NULL,
  `hora_consulta` time NOT NULL,
  `status` enum('agendada','cancelada','concluida') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'agendada',
  `criado_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `consultas`
--

INSERT INTO `consultas` (`id`, `nome_paciente`, `email_paciente`, `telefone_paciente`, `endereco_paciente`, `especialidade`, `motivo`, `problema`, `objetivo`, `observacoes`, `data_consulta`, `hora_consulta`, `status`, `criado_em`) VALUES
(1, 'Rafael Felipe Prestes', 'adrianprestes7@gmail.com', '6546545665r', 'hg,jg,ygygyg', 'Odontologia', 'fkygkuyg', 'buygkugyky', 'Retorno', 'mjgmygkuy', '2026-08-17', '14:00:00', 'agendada', '2026-08-17 00:19:51'),
(2, 'Rafael Felipe Prestes', 'prestes.rafael75@gmail.com', '55429988292781', 'Atravessa O Cerro Azul', 'Clínica Geral', 'Dor de cabeça crônica', 'Asmatico', 'Consulta / avaliação', 'OOO', '2026-11-04', '08:30:00', 'agendada', '2026-08-19 17:03:02');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `hora_triagem` time DEFAULT NULL,
  `historico` text COLLATE utf8mb4_general_ci,
  `medicamentos` text COLLATE utf8mb4_general_ci,
  `alergias` text COLLATE utf8mb4_general_ci,
  `pressao` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `temperatura` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `frequencia` int DEFAULT NULL,
  `saturacao` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dor` int DEFAULT NULL,
  `risco` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `data_triagem` date DEFAULT NULL,
  `queixa_principal` text COLLATE utf8mb4_general_ci,
  `sintomas` text COLLATE utf8mb4_general_ci,
  `exibir` tinyint(1) NOT NULL DEFAULT '1',
  `gestante` tinyint(1) DEFAULT '0',
  `imunossuprimido` tinyint(1) DEFAULT '0',
  `cronico` tinyint(1) DEFAULT '0',
  `consciencia` varchar(20) COLLATE utf8mb4_general_ci DEFAULT 'normal',
  `hemorragia` tinyint(1) DEFAULT '0',
  `trauma` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `pacientes`
--

INSERT INTO `pacientes` (`id`, `nome`, `data_nascimento`, `hora_triagem`, `historico`, `medicamentos`, `alergias`, `pressao`, `temperatura`, `frequencia`, `saturacao`, `dor`, `risco`, `criado_em`, `data_triagem`, `queixa_principal`, `sintomas`, `exibir`, `gestante`, `imunossuprimido`, `cronico`, `consciencia`, `hemorragia`, `trauma`) VALUES
(1, 'Pedro Gabriel Prestes', '2006-11-04', '01:26:00', 'Asmático, já foi internado por possuir crises respitratória', 'Aerolin', 'Alergia ocular crônica', '140x80', '39', 91, '80', 9, 'Vermelho', '2026-08-16 23:28:25', '2026-08-17', 'Dor forte de cabeça', 'Dor forte de cabeça que induz ao desmaio', 0, 0, 0, 0, 'normal', 0, 0),
(2, 'Maria Eduarda', '2009-01-22', '18:50:00', 'Dor de cabeça e lombar', 'Paracetamol', 'Sem', '120x80', '37', 80, '99', 6, 'Vermelho', '2026-08-19 16:51:20', '2026-08-19', 'Dor de cabeça e lombar', 'Dor de cabeça e lombar', 1, 0, 0, 0, 'normal', 0, 0),
(3, 'Maria BBs', '2008-05-03', '19:05:00', 'Dor de cabeça aguda', 'Dipirona', 'A pó', '120x80', '38', 95, '97', 10, 'Vermelho', '2026-08-19 17:07:39', '2026-08-19', 'Dor de cabeça aguda', 'Dor de cabeça aguda', 1, 0, 0, 0, 'normal', 0, 0),
(4, 'Jailton', '1990-11-07', '22:22:00', 'Dor de cabeça forte', 'Neusadina', 'A poeira', '120x80', '39', 80, '99', 7, 'Vermelho', '2026-08-19 20:29:26', '2026-08-19', 'Dor de cabeça forte', 'Dor de cabeça forte', 1, 0, 0, 0, 'normal', 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `criado_em`) VALUES
(1, 'Rafael Felipe', 'rafael@hospital.com', '$2y$10$MyckpXjHkG5rkzvg6SMYIeYsljumxVz7EfFqXiTpgW07W6rJyEY3m', '2026-08-16 23:26:32'),
(2, 'Rafael Felipe', 'rafael@gmail.com', '$2y$10$IyqvpF9F3ChVgrZpXDdRxuzqu6NkNs/RFhsTBNhm2V9F4wBl4Za7q', '2026-08-16 23:32:36');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_data_hora` (`data_consulta`,`hora_consulta`),
  ADD KEY `idx_status` (`status`);

--
-- Índices para tabela `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
