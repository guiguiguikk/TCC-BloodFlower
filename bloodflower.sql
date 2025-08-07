-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 06, 2025 at 04:44 PM
-- Server version: 8.0.27
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bloodflower`
--

-- --------------------------------------------------------

--
-- Table structure for table `avaliacoes`
--

DROP TABLE IF EXISTS `avaliacoes`;
CREATE TABLE IF NOT EXISTS `avaliacoes` (
  `id_avaliacao` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `produto_id` int NOT NULL,
  `comentario` text COLLATE utf8mb4_general_ci,
  `data_hora` datetime DEFAULT CURRENT_TIMESTAMP,
  `nota` int DEFAULT NULL,
  PRIMARY KEY (`id_avaliacao`),
  KEY `fk_avaliacoes_produto` (`produto_id`),
  KEY `fk_avaliacoes_usuario` (`usuario_id`)
) ;

-- --------------------------------------------------------

--
-- Table structure for table `carrinhos`
--

DROP TABLE IF EXISTS `carrinhos`;
CREATE TABLE IF NOT EXISTS `carrinhos` (
  `id_carrinho` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int DEFAULT NULL,
  PRIMARY KEY (`id_carrinho`),
  KEY `fk_carrinhos_usuario` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carrinhos`
--

INSERT INTO `carrinhos` (`id_carrinho`, `usuario_id`) VALUES
(9, 3),
(3, 7),
(4, 8),
(5, 10),
(6, 11),
(10, 13),
(11, 14),
(13, 16),
(14, 17);

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nome`) VALUES
(1, 'camiseta'),
(2, 'calça'),
(3, 'moletom');

-- --------------------------------------------------------

--
-- Table structure for table `enderecos`
--

DROP TABLE IF EXISTS `enderecos`;
CREATE TABLE IF NOT EXISTS `enderecos` (
  `id_endereco` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int DEFAULT NULL,
  `cep` varchar(9) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rua` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `numero` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bairro` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cidade` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` varchar(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_endereco`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enderecos`
--

INSERT INTO `enderecos` (`id_endereco`, `usuario_id`, `cep`, `rua`, `numero`, `bairro`, `cidade`, `estado`, `tipo`) VALUES
(2, 17, '97503710', 'albertino pires', '422', 'cabo', 'uruguaiana', 'RS', ''),
(3, 14, '97080400', 'dscbfdc ', '43543', 'tabajarar brites ', 'uruguaiana', 'RJ', ''),
(4, 16, '97503740', 'Monteiro lobaato ', '4406', 'tabajarar brites ', 'uruguaiana', 'RS', '');

-- --------------------------------------------------------

--
-- Table structure for table `favorito`
--

DROP TABLE IF EXISTS `favorito`;
CREATE TABLE IF NOT EXISTS `favorito` (
  `id_favorito` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  PRIMARY KEY (`id_favorito`),
  KEY `fk_favorito_usuario` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorito`
--

INSERT INTO `favorito` (`id_favorito`, `usuario_id`) VALUES
(1, 3),
(2, 16),
(3, 17);

-- --------------------------------------------------------

--
-- Table structure for table `item_favorito`
--

DROP TABLE IF EXISTS `item_favorito`;
CREATE TABLE IF NOT EXISTS `item_favorito` (
  `id_item_favorito` int NOT NULL AUTO_INCREMENT,
  `favorito_id` int NOT NULL,
  `produto_id` int NOT NULL,
  PRIMARY KEY (`id_item_favorito`),
  KEY `fk_item_favorito_favorito` (`favorito_id`),
  KEY `fk_item_favorito_produto` (`produto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_favorito`
--

INSERT INTO `item_favorito` (`id_item_favorito`, `favorito_id`, `produto_id`) VALUES
(1, 1, 27),
(4, 1, 30),
(5, 3, 27),
(6, 3, 24),
(7, 3, 32),
(8, 3, 25),
(9, 3, 30);

-- --------------------------------------------------------

--
-- Table structure for table `itens_carrinho`
--

DROP TABLE IF EXISTS `itens_carrinho`;
CREATE TABLE IF NOT EXISTS `itens_carrinho` (
  `id_item_carrinho` int NOT NULL AUTO_INCREMENT,
  `carrinho_id` int DEFAULT NULL,
  `produto_id` int DEFAULT NULL,
  `quantidade` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_item_carrinho`),
  KEY `produto_id` (`produto_id`),
  KEY `fk_itens_carrinho_carrinho` (`carrinho_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `itens_carrinho`
--

INSERT INTO `itens_carrinho` (`id_item_carrinho`, `carrinho_id`, `produto_id`, `quantidade`) VALUES
(4, 3, 1, 1),
(5, 3, 7, 1),
(6, 4, 6, 1),
(40, 14, 30, 9),
(41, 14, 27, 10);

-- --------------------------------------------------------

--
-- Table structure for table `itens_pedido`
--

DROP TABLE IF EXISTS `itens_pedido`;
CREATE TABLE IF NOT EXISTS `itens_pedido` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pedido` int NOT NULL,
  `id_produto` int NOT NULL,
  `quantidade` int NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_itens_pedido_pedido` (`id_pedido`),
  KEY `fk_itens_pedido_produto` (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `itens_pedido`
--

INSERT INTO `itens_pedido` (`id`, `id_pedido`, `id_produto`, `quantidade`, `preco`, `subtotal`) VALUES
(1, 2, 24, 90, '89.90', '8091.00'),
(2, 2, 25, 90909, '149.90', '13627259.10'),
(4, 2, 27, 1, '199.90', '199.90'),
(7, 4, 27, 7, '199.90', '1399.30'),
(8, 5, 27, 1, '199.90', '199.90'),
(9, 6, 27, 9, '199.90', '1799.10'),
(10, 7, 27, 1, '199.90', '199.90'),
(11, 8, 24, 1, '89.90', '89.90'),
(13, 8, 27, 1, '199.90', '199.90'),
(15, 9, 25, 1, '149.90', '149.90'),
(16, 10, 25, 60, '149.90', '8994.00'),
(17, 11, 30, 1, '10.00', '10.00'),
(18, 12, 24, 1, '89.90', '89.90'),
(19, 12, 25, 1, '149.90', '149.90');

-- --------------------------------------------------------

--
-- Table structure for table `marca`
--

DROP TABLE IF EXISTS `marca`;
CREATE TABLE IF NOT EXISTS `marca` (
  `id_marca` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_marca`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marca`
--

INSERT INTO `marca` (`id_marca`, `nome`) VALUES
(2, 'nike'),
(3, 'adidas'),
(4, 'acessorio');

-- --------------------------------------------------------

--
-- Table structure for table `pagamentos`
--

DROP TABLE IF EXISTS `pagamentos`;
CREATE TABLE IF NOT EXISTS `pagamentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pedido` int NOT NULL,
  `metodo_pagamento` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('pendente','aprovado','rejeitado') COLLATE utf8mb4_general_ci DEFAULT 'pendente',
  `data_pagamento` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_pagamentos_pedido` (`id_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `data_pedido` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pendente','pago','cancelado') COLLATE utf8mb4_general_ci DEFAULT 'pendente',
  `total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pedidos_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_usuario`, `data_pedido`, `status`, `total`) VALUES
(1, 3, '2025-05-27 16:43:32', 'pendente', '89.90'),
(2, 3, '2025-05-27 16:47:03', 'pendente', '13635609.90'),
(3, 13, '2025-06-18 13:42:00', 'pendente', '59.90'),
(4, 3, '2025-06-22 22:25:01', 'pendente', '1998.30'),
(5, 3, '2025-07-09 14:42:32', 'pendente', '199.90'),
(6, 3, '2025-07-11 22:24:09', 'pendente', '1799.10'),
(7, 3, '2025-07-18 09:21:44', 'pendente', '199.90'),
(8, 16, '2025-07-29 13:46:42', 'pendente', '349.70'),
(9, 3, '2025-07-29 17:53:18', 'pendente', '209.80'),
(10, 3, '2025-08-03 12:47:26', 'pendente', '8994.00'),
(11, 17, '2025-08-06 01:09:58', 'pendente', '10.00'),
(12, 17, '2025-08-06 01:13:08', 'pendente', '239.80');

-- --------------------------------------------------------

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_general_ci,
  `preco` decimal(10,2) NOT NULL,
  `preco_desconto` decimal(10,2) DEFAULT NULL,
  `estoque` int DEFAULT '0',
  `categoria_id` int DEFAULT NULL,
  `marca_id` int DEFAULT NULL,
  `imagem` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_produtos_categoria` (`categoria_id`),
  KEY `fk_produtos_marca` (`marca_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `preco_desconto`, `estoque`, `categoria_id`, `marca_id`, `imagem`) VALUES
(24, 'Camiseta Oversized Preta', 'Camiseta unissex em algodão premium com modelagem oversized.', '89.90', '69.90', 50, 1, 4, 'Camiseta-Oversized-Preto.jpeg'),
(25, 'Calça Cargo Caqui', 'Calça cargo masculina com bolsos utilitários e elástico na barra.', '149.90', '129.90', 30, 2, 2, 'Calça-Cargo-Sarja.jpeg'),
(27, 'Jaqueta Corta Vento Reflective', 'Jaqueta leve com tecido refletivo e zíper frontal, resistente ao vento.', '98.09', '179.90', 20, 1, 3, 'cortavento.jpeg'),
(30, 'Boina', 'Boina Chapéu Cinza Italiana Masculina', '10.00', '10.00', 10, 3, 3, 'Boina Chapéu Italiana Masculina Estilo Peaky Blinders.jpeg'),
(32, 'camisa', 'camisa branca', '100.00', '0.00', 100, 1, 3, 'camisa.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `produto_tamanhos`
--

DROP TABLE IF EXISTS `produto_tamanhos`;
CREATE TABLE IF NOT EXISTS `produto_tamanhos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `produto_id` int NOT NULL,
  `tamanho_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_produto_tamanhos_produto` (`produto_id`),
  KEY `fk_produto_tamanhos_tamanho` (`tamanho_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tamanhos`
--

DROP TABLE IF EXISTS `tamanhos`;
CREATE TABLE IF NOT EXISTS `tamanhos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `cpf` varchar(14) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `tipo_usuario` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `cpf` (`cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `email`, `senha`, `cpf`, `telefone`, `data_nascimento`, `tipo_usuario`) VALUES
(3, 'thiago', 'thiago@gmail.com', '$2y$10$t8jdbZDRDPw9XBxRzFKbweGImvmPZGCf4hK5hkhKD5R1Bo2SlFy3m', '5438934639659', '5458253485394', '2000-01-01', 0),
(4, 'guizao', 'gui@email.com', '$2y$10$r3u4sH4uib0XfSt85ZpnsOCjCYkskCJd90k9bDWHnm18aUi3jKSji', '235346564', '2353465645', '2000-11-11', 1),
(7, 'Nader Iad Choli', 'nader.2023319952@aluno.iffar.edu.br', '$2y$10$v6oTzIdBW8Z9l/dMLLMSqug5r3uom65mM452GnYqzyuCAupI8GxOC', '05808500052', '55999983729', '2007-09-12', 0),
(8, 'Jorge Gomes de Lima', 'jorge@gmail.com', '$2y$10$9DFJbYDtaQbq0xwZVQB5q.dAJN6b6mM8D6LTu6b.NMZo.nndQLnY6', '05790502032', '6969696969', '2025-05-02', 0),
(9, 'Fafas', 'abertolf@gmail.com', '$2y$10$lu5n.IgQ1.NGCrUnszCUue0b1btXEV6Iqr689RJ6PVr8VvCWDxa1S', '123456789787', '1234567891011', '2006-08-06', 0),
(10, 'guileme', 'pedro@gmail.com', '$2y$10$XaQI7cJaAE6kTEGZ9zLhiOaRQbqmvtrJORTO2VPR3N291mmSPavYi', '54353654', '41352352', '2010-10-10', 0),
(11, 'guileme', 'jonas@gmail.com', '$2y$10$DSnk4kI5LpNt4V0aP2/L.Ozwjy5F4Xqo7BoHSmFnaMD.Ka2kbqoTG', '5346903525923', '450634506', '2000-09-09', 0),
(13, 'Paulo ', 'paulo.2022310836@aluno.iffar.edu.br', '$2y$10$36P9kzlAmXllDBEwWlLlVOgD3OYPrhanLbHCHclEGa53lBidAWu8C', '04566672026', '55991423225', '2007-02-02', 0),
(14, 'dimitri fernandes', 'dimitri.2023317573@aluno.iffar.edu.br', '$2y$10$QF1wAzimNTZvS2nKLzh/nOBYcFcO3ZfWCooub64DLmQoa6DUKt91W', '32342424242424', '2342424242424', '2025-07-25', 0),
(16, 'camiesta cinza', 'darksity09@gmail.com', '$2y$10$W.b0S4U9ie.NDC0CsZnB0OF8XcuJknJ0ggxjBfzzZqP3i0xBr0K2.', '03713500002', '559998982313', '2025-08-07', 0),
(17, 'oguileme', 'guilherme@gmail.com', '$2y$10$OB3uxvWEJHUJ1t745PQekescfAMWe8NGaDsr8bu0lr/6bzYPujF6i', '12345678912', '6969696969', '2001-10-10', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD CONSTRAINT `fk_avaliacoes_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `fk_avaliacoes_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`);

--
-- Constraints for table `carrinhos`
--
ALTER TABLE `carrinhos`
  ADD CONSTRAINT `fk_carrinhos_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`);

--
-- Constraints for table `enderecos`
--
ALTER TABLE `enderecos`
  ADD CONSTRAINT `enderecos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`);

--
-- Constraints for table `favorito`
--
ALTER TABLE `favorito`
  ADD CONSTRAINT `fk_favorito_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`);

--
-- Constraints for table `item_favorito`
--
ALTER TABLE `item_favorito`
  ADD CONSTRAINT `fk_item_favorito_favorito` FOREIGN KEY (`favorito_id`) REFERENCES `favorito` (`id_favorito`),
  ADD CONSTRAINT `fk_item_favorito_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`);

--
-- Constraints for table `itens_carrinho`
--
ALTER TABLE `itens_carrinho`
  ADD CONSTRAINT `fk_itens_carrinho_carrinho` FOREIGN KEY (`carrinho_id`) REFERENCES `carrinhos` (`id_carrinho`);

--
-- Constraints for table `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD CONSTRAINT `fk_itens_pedido_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `fk_itens_pedido_produto` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`);

--
-- Constraints for table `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD CONSTRAINT `fk_pagamentos_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`);

--
-- Constraints for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Constraints for table `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_produtos_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id_categoria`),
  ADD CONSTRAINT `fk_produtos_marca` FOREIGN KEY (`marca_id`) REFERENCES `marca` (`id_marca`);

--
-- Constraints for table `produto_tamanhos`
--
ALTER TABLE `produto_tamanhos`
  ADD CONSTRAINT `fk_produto_tamanhos_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `fk_produto_tamanhos_tamanho` FOREIGN KEY (`tamanho_id`) REFERENCES `tamanhos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
