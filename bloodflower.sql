-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 19-Out-2025 às 18:28
-- Versão do servidor: 8.0.27
-- versão do PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bloodflower`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacoes`
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

--
-- Extraindo dados da tabela `avaliacoes`
--

INSERT INTO `avaliacoes` (`id_avaliacao`, `usuario_id`, `produto_id`, `comentario`, `data_hora`, `nota`) VALUES
(3, 3, 24, 'Chegou rápido, tecido de ótima qualidade. Recomendo muito!', '2025-09-14 18:39:19', 5),
(4, 16, 24, 'Muito bonito, mas poderia ser um pouco mais ajustado no corpo.', '2025-09-14 18:39:19', 4),
(5, 3, 25, 'Super confortável, melhor do que eu esperava.', '2025-09-14 18:39:19', 5),
(6, 16, 25, 'Gostei do design, mas a cor não é exatamente como na foto.', '2025-09-14 18:39:19', 3),
(7, 16, 27, 'Peça bem estilosa, chamou atenção. Recomendo.', '2025-09-14 18:39:19', 4),
(8, 7, 27, 'Perfeito! Combina com tudo e o material é resistente.', '2025-09-14 18:39:19', 5),
(9, 8, 30, 'Melhor compra que já fiz na loja. Vou comprar de novo.', '2025-09-14 18:39:19', 5),
(10, 3, 30, 'Gostei bastante, mas poderia ter mais opções de tamanho.', '2025-09-14 18:39:19', 4),
(13, 3, 24, 'Chegou rápido, tecido de ótima qualidade. Recomendo muito!', '2025-09-14 18:39:43', 5),
(14, 16, 24, 'Muito bonito, mas poderia ser um pouco mais ajustado no corpo.', '2025-09-14 18:39:43', 4),
(15, 3, 25, 'Super confortável, melhor do que eu esperava.', '2025-09-14 18:39:43', 5),
(16, 16, 25, 'Gostei do design, mas a cor não é exatamente como na foto.', '2025-09-14 18:39:43', 3),
(17, 16, 27, 'Peça bem estilosa, chamou atenção. Recomendo.', '2025-09-14 18:39:43', 4),
(18, 7, 27, 'Perfeito! Combina com tudo e o material é resistente.', '2025-09-14 18:39:43', 5),
(19, 8, 30, 'Melhor compra que já fiz na loja. Vou comprar de novo.', '2025-09-14 18:39:43', 5),
(20, 3, 30, 'Gostei bastante, mas poderia ter mais opções de tamanho.', '2025-09-14 18:39:43', 4),
(21, 16, 32, 'Excelente acabamento e muito estiloso. Vale cada centavo.', '2025-09-14 18:39:43', 5),
(22, 16, 32, 'Entrega foi um pouco demorada, mas o produto é ótimo.', '2025-09-14 18:39:43', 4),
(23, 23, 27, 'muito bom', '2025-10-19 13:44:15', 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinhos`
--

DROP TABLE IF EXISTS `carrinhos`;
CREATE TABLE IF NOT EXISTS `carrinhos` (
  `id_carrinho` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int DEFAULT NULL,
  PRIMARY KEY (`id_carrinho`),
  KEY `fk_carrinhos_usuario` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `carrinhos`
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
(21, 19),
(27, 20),
(24, 21),
(25, 21),
(28, 22),
(29, 22),
(30, 23),
(31, 23);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nome`) VALUES
(1, 'camiseta'),
(2, 'calça'),
(3, 'moletom'),
(4, 'Jaqueta'),
(5, 'Vestido'),
(6, 'Saia'),
(7, 'Tênis'),
(8, 'Boné'),
(9, 'Acessórios'),
(10, 'Top'),
(11, 'Moletom Oversized'),
(12, 'Blusa de Manga Longa'),
(13, 'Colete'),
(14, 'Bermuda'),
(15, 'Bolsa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `enderecos`
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `enderecos`
--

INSERT INTO `enderecos` (`id_endereco`, `usuario_id`, `cep`, `rua`, `numero`, `bairro`, `cidade`, `estado`, `tipo`) VALUES
(2, 17, '97503710', 'albertino pires', '422', 'cabo', 'uruguaiana', 'RS', ''),
(3, 14, '97080400', 'dscbfdc ', '43543', 'tabajarar brites ', 'uruguaiana', 'RJ', ''),
(4, 16, '97503740', 'Monteiro lobaato ', '4406', 'tabajarar brites ', 'uruguaiana', 'RS', ''),
(6, 18, '97503710', 'Rua Albertino Pires', '1001', 'Cabo Luís Quevedo', 'Uruguaiana', 'RS', ''),
(8, 20, '97503710', 'Rua Albertino Pires', '4222', 'Cabo Luís Quevedo', 'Uruguaiana', 'RS', ''),
(9, 20, '97501500', 'Praça Barão de Rio Branco', '122', 'Centro', 'Uruguaiana', 'RS', ''),
(10, 23, '97503740', 'Rua Roberto Kraemer', '6', 'Cabo Luís Quevedo', 'Uruguaiana', 'RS', ''),
(12, 23, '88330116', 'Avenida Marginal Leste', '096', 'Centro', 'Balneário Camboriú', 'SC', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `favorito`
--

DROP TABLE IF EXISTS `favorito`;
CREATE TABLE IF NOT EXISTS `favorito` (
  `id_favorito` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  PRIMARY KEY (`id_favorito`),
  KEY `fk_favorito_usuario` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `favorito`
--

INSERT INTO `favorito` (`id_favorito`, `usuario_id`) VALUES
(1, 3),
(2, 16),
(3, 17),
(4, 18),
(5, 20),
(6, 21),
(7, 22),
(8, 23);

-- --------------------------------------------------------

--
-- Estrutura da tabela `interacoes_produto_usuario`
--

DROP TABLE IF EXISTS `interacoes_produto_usuario`;
CREATE TABLE IF NOT EXISTS `interacoes_produto_usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `produto_id` int NOT NULL,
  `tipo` enum('visto','comprado','favorito') COLLATE utf8mb4_general_ci NOT NULL,
  `data_hora` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_interacoes_usuario` (`usuario_id`),
  KEY `fk_interacoes_produto` (`produto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `item_favorito`
--

DROP TABLE IF EXISTS `item_favorito`;
CREATE TABLE IF NOT EXISTS `item_favorito` (
  `id_item_favorito` int NOT NULL AUTO_INCREMENT,
  `favorito_id` int NOT NULL,
  `produto_id` int NOT NULL,
  PRIMARY KEY (`id_item_favorito`),
  KEY `fk_item_favorito_favorito` (`favorito_id`),
  KEY `fk_item_favorito_produto` (`produto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `item_favorito`
--

INSERT INTO `item_favorito` (`id_item_favorito`, `favorito_id`, `produto_id`) VALUES
(1, 1, 27),
(4, 1, 30),
(5, 3, 27),
(6, 3, 24),
(7, 3, 32),
(8, 3, 25),
(9, 3, 30),
(12, 4, 27),
(13, 4, 24),
(15, 5, 27),
(16, 5, 24),
(17, 5, 30),
(22, 7, 30);

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens_carrinho`
--

DROP TABLE IF EXISTS `itens_carrinho`;
CREATE TABLE IF NOT EXISTS `itens_carrinho` (
  `id_item_carrinho` int NOT NULL AUTO_INCREMENT,
  `carrinho_id` int DEFAULT NULL,
  `produto_id` int DEFAULT NULL,
  `quantidade` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_item_carrinho`),
  KEY `fk_itens_carrinho_carrinho` (`carrinho_id`),
  KEY `fk_itens_carrinho_produto` (`produto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `itens_carrinho`
--

INSERT INTO `itens_carrinho` (`id_item_carrinho`, `carrinho_id`, `produto_id`, `quantidade`) VALUES
(66, 30, 27, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens_pedido`
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
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `itens_pedido`
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
(19, 12, 25, 1, '149.90', '149.90'),
(20, 13, 30, 9, '10.00', '90.00'),
(21, 13, 27, 10, '98.09', '980.90'),
(22, 14, 24, 1, '89.90', '89.90'),
(23, 15, 27, 1, '98.09', '98.09'),
(24, 16, 24, 1, '89.90', '89.90'),
(25, 16, 25, 1, '149.90', '149.90'),
(26, 17, 24, 1, '89.90', '89.90'),
(27, 18, 24, 1, '89.90', '89.90'),
(28, 19, 25, 20, '149.90', '2998.00'),
(29, 20, 27, 7, '98.09', '686.63'),
(30, 21, 27, 1, '98.09', '98.09'),
(31, 22, 24, 1, '89.90', '89.90'),
(32, 23, 27, 1, '98.09', '98.09'),
(33, 23, 25, 1, '149.90', '149.90'),
(34, 24, 24, 10, '89.90', '899.00'),
(35, 24, 30, 1, '10.00', '10.00'),
(36, 25, 24, 1, '89.90', '89.90'),
(37, 26, 27, 1, '98.09', '98.09');

-- --------------------------------------------------------

--
-- Estrutura da tabela `marca`
--

DROP TABLE IF EXISTS `marca`;
CREATE TABLE IF NOT EXISTS `marca` (
  `id_marca` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_marca`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `marca`
--

INSERT INTO `marca` (`id_marca`, `nome`) VALUES
(2, 'nike'),
(3, 'adidas'),
(4, 'acessorio'),
(5, 'Converse'),
(6, 'Urban Edge'),
(7, 'Black Flower'),
(8, 'Rebel Wear'),
(9, 'Alternative Style'),
(10, 'Dark Threads'),
(11, 'Gothic Roots'),
(12, 'Skull & Roses'),
(13, 'Vans');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamentos`
--

DROP TABLE IF EXISTS `pagamentos`;
CREATE TABLE IF NOT EXISTS `pagamentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pedido` int NOT NULL,
  `metodo_pagamento` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('Pago','Parecelado','Cancelado') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Pago',
  `data_pagamento` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_pagamentos_pedido` (`id_pedido`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `pagamentos`
--

INSERT INTO `pagamentos` (`id`, `id_pedido`, `metodo_pagamento`, `status`, `data_pagamento`) VALUES
(1, 13, 'Cartão', '', '2025-08-06 13:47:01'),
(2, 14, 'Cartão', '', '2025-08-06 13:50:28'),
(3, 15, 'Cartão', '', '2025-08-06 14:54:58'),
(4, 16, 'Cartão', '', '2025-08-06 15:05:13'),
(5, 17, 'Pix', '', '2025-08-06 15:18:24'),
(6, 18, 'Cartão', 'Pago', '2025-08-07 01:07:21'),
(7, 19, 'Cartão', 'Pago', '2025-08-10 20:51:36'),
(8, 20, 'Cartão', 'Pago', '2025-08-13 08:16:35'),
(9, 21, 'Pix', 'Pago', '2025-08-13 10:57:33'),
(10, 22, 'Cartão', 'Pago', '2025-08-13 13:03:54'),
(11, 23, 'Cartão', 'Pago', '2025-08-13 13:45:11'),
(12, 24, 'Cartão', 'Pago', '2025-08-19 12:10:16'),
(13, 25, 'Cartão', 'Pago', '2025-09-09 16:47:15'),
(14, 26, 'Pix', 'Pago', '2025-10-19 13:17:15');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `data_pedido` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Aguardando','Enviado','Entregue','Cancelado') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Aguardando',
  `total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pedidos_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_usuario`, `data_pedido`, `status`, `total`) VALUES
(1, 3, '2025-05-27 16:43:32', '', '89.90'),
(2, 3, '2025-05-27 16:47:03', '', '13635609.90'),
(3, 13, '2025-06-18 13:42:00', '', '59.90'),
(4, 3, '2025-06-22 22:25:01', '', '1998.30'),
(5, 3, '2025-07-09 14:42:32', '', '199.90'),
(6, 3, '2025-07-11 22:24:09', '', '1799.10'),
(7, 3, '2025-07-18 09:21:44', '', '199.90'),
(8, 16, '2025-07-29 13:46:42', '', '349.70'),
(9, 3, '2025-07-29 17:53:18', '', '209.80'),
(10, 3, '2025-08-03 12:47:26', '', '8994.00'),
(11, 17, '2025-08-06 01:09:58', 'Enviado', '10.00'),
(12, 17, '2025-08-06 01:13:08', '', '239.80'),
(13, 17, '2025-08-06 13:47:01', '', '1070.90'),
(14, 17, '2025-08-06 13:50:28', 'Entregue', '89.90'),
(15, 17, '2025-08-06 14:54:58', 'Aguardando', '98.09'),
(16, 17, '2025-08-06 15:05:13', 'Aguardando', '239.80'),
(17, 17, '2025-08-06 15:18:24', 'Aguardando', '89.90'),
(18, 18, '2025-08-07 01:07:21', 'Aguardando', '89.90'),
(19, 18, '2025-08-10 20:51:36', 'Aguardando', '2998.00'),
(20, 20, '2025-08-13 08:16:35', 'Aguardando', '686.63'),
(21, 20, '2025-08-13 10:57:33', 'Aguardando', '98.09'),
(22, 20, '2025-08-13 13:03:53', 'Aguardando', '89.90'),
(23, 20, '2025-08-13 13:45:11', 'Aguardando', '247.99'),
(24, 20, '2025-08-19 12:10:16', 'Aguardando', '909.00'),
(25, 22, '2025-09-09 16:47:15', 'Entregue', '89.90'),
(26, 23, '2025-10-19 13:17:15', 'Entregue', '98.09');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
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
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `preco_desconto`, `estoque`, `categoria_id`, `marca_id`, `imagem`) VALUES
(1, 'Camiseta Dark Skull', 'Camiseta preta com estampa de caveira e detalhes vermelhos.', '89.90', '79.90', 20, 1, 10, 'camiseta-dark-skull.jpg'),
(2, 'Moletom Rebel', 'Moletom cinza com capuz e bordado da marca Rebel Wear.', '159.90', '149.90', 15, 3, 7, 'moletom-rebel.jpg'),
(3, 'Calça Urban Edge', 'Calça jogger preta com detalhes cinza da Urban Edge.', '129.90', '119.90', 10, 2, 6, 'calca-urban-edge.jpg'),
(4, 'Camiseta Gothic Rose', 'Camiseta com estampa de rosas góticas.', '99.90', '89.90', 25, 1, 11, 'camiseta-gothic-rose.jpg'),
(5, 'Moletom Skull & Bones', 'Moletom preto com estampa de caveira estilizada.', '169.90', '159.90', 12, 3, 12, 'moletom-skull-bones.jpg'),
(6, 'Calça Vans Street', 'Calça estilo streetwear com logo da Vans.', '119.90', '109.90', 18, 2, 4, 'calca-vans-street.jpg'),
(7, 'Camiseta Converse All Star', 'Camiseta branca com logo clássico da Converse.', '89.90', '79.90', 30, 1, 5, 'camiseta-converse.jpg'),
(8, 'Moletom Black Flower', 'Moletom preto oversized da marca Black Flower.', '159.90', '149.90', 20, 3, 8, 'moletom-black-flower.jpg'),
(9, 'Calça Dark Threads Jogger', 'Calça jogger preta com detalhes vermelhos.', '139.90', '129.90', 15, 2, 10, 'calca-dark-threads.jpg'),
(10, 'Camiseta Rebel Wear Logo', 'Camiseta cinza com logo Rebel Wear estampado.', '95.90', '85.90', 25, 1, 7, 'camiseta-rebel-logo.jpg'),
(11, 'Moletom Alternative Style Hoodie', 'Moletom cinza com capuz da Alternative Style.', '149.90', '139.90', 18, 3, 9, 'moletom-alternative-style.jpg'),
(12, 'Calça Adidas Street', 'Calça preta com listras brancas clássicas Adidas.', '129.90', '119.90', 20, 2, 3, 'calca-adidas-street.jpg'),
(13, 'Camiseta Nike Urban', 'Camiseta preta com logo minimalista Nike.', '99.90', '89.90', 30, 1, 2, 'camiseta-nike-urban.jpg'),
(14, 'Moletom Vans Capuz', 'Moletom cinza com capuz da Vans.', '159.90', '149.90', 15, 3, 4, 'moletom-vans.jpg'),
(15, 'Calça Converse Slim', 'Calça preta slim fit da Converse.', '119.90', '109.90', 18, 2, 5, 'calca-converse-slim.jpg'),
(24, 'Camiseta Oversized Preta', 'Camiseta unissex em algodão premium com modelagem oversized.', '89.90', '69.90', 50, 1, 4, 'Camiseta-Oversized-Preto.jpeg'),
(25, 'Calça Cargo Caqui', 'Calça cargo masculina com bolsos utilitários e elástico na barra.', '149.90', '129.90', 30, 2, 2, 'Calça-Cargo-Sarja.jpeg'),
(27, 'Jaqueta Corta Vento Reflective', 'Jaqueta leve com tecido refletivo e zíper frontal, resistente ao vento.', '98.09', '179.90', 20, 1, 3, 'cortavento.jpeg'),
(30, 'Boina', 'Boina Chapéu Cinza Italiana Masculina', '10.00', '10.00', 10, 3, 3, 'Boina Chapéu Italiana Masculina Estilo Peaky Blinders.jpeg'),
(32, 'camisa', 'camisa branca', '100.00', '0.00', 100, 1, 3, 'camisa.jpeg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_tamanhos`
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
-- Estrutura da tabela `tamanhos`
--

DROP TABLE IF EXISTS `tamanhos`;
CREATE TABLE IF NOT EXISTS `tamanhos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
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
(17, 'oguileme', 'guilherme@gmail.com', '$2y$10$OB3uxvWEJHUJ1t745PQekescfAMWe8NGaDsr8bu0lr/6bzYPujF6i', '12345678912', '6969696969', '2001-10-10', 1),
(18, 'victoriaa', 'vic3@gmail.com', '$2y$10$Z5euwQeMjukSTv9sOonTA.zQyju3UTN5sb1c0dcKAOf.GMepddzpe', '12345678977', '305948595734', '2000-10-10', 0),
(19, 'jorge', 'jorge1@gmail.com', '$2y$10$7n7ro4ywGzvDLI.4ex7vguivmk5YpupQprwEapK1xtw673awe.JaG', '1234567890', '559998982313', '2000-08-11', 0),
(20, 'asddevfgf', 'guilherme1@gmail.com', '$2y$10$gjtcFwI8dnszh41d0gBam.iCt2uZ.Lp8Vz8z8h70QE6dWZcjxmCCm', '12345678919', '6969696968', '2011-11-11', 1),
(21, 'paulo', 'paulo@gmail.com', '$2y$10$y9NKVMXuQl/3hkCERYB1JO6DNwAnfuCeJ/UunTD3y1CMFisvycbyK', '12345678905', '9999999999', '2007-02-02', 0),
(22, 'aaaa', 'guilherme12@gmail.com', '$2y$10$NfsDpkOOz/m9CIaoRXFKt.5ooqw6isA6KBiWasc3E.XxvZmNtVUW.', '00000000001', '2232342423', '2000-12-12', 0),
(23, 'guilherme moreira', 'gui.moreira@gmail.com', '$2y$10$oTr87IAlt0c/h3fq8bs5GePRcJFeGtYjkkwtj0HW/cETRZtTCdjMa', '0987654321', '77777777777', '2000-12-12', 0);

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD CONSTRAINT `fk_avaliacoes_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `fk_avaliacoes_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`);

--
-- Limitadores para a tabela `carrinhos`
--
ALTER TABLE `carrinhos`
  ADD CONSTRAINT `fk_carrinhos_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`);

--
-- Limitadores para a tabela `enderecos`
--
ALTER TABLE `enderecos`
  ADD CONSTRAINT `enderecos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`);

--
-- Limitadores para a tabela `favorito`
--
ALTER TABLE `favorito`
  ADD CONSTRAINT `fk_favorito_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`);

--
-- Limitadores para a tabela `interacoes_produto_usuario`
--
ALTER TABLE `interacoes_produto_usuario`
  ADD CONSTRAINT `fk_interacoes_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `fk_interacoes_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`);

--
-- Limitadores para a tabela `item_favorito`
--
ALTER TABLE `item_favorito`
  ADD CONSTRAINT `fk_item_favorito_favorito` FOREIGN KEY (`favorito_id`) REFERENCES `favorito` (`id_favorito`),
  ADD CONSTRAINT `fk_item_favorito_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`);

--
-- Limitadores para a tabela `itens_carrinho`
--
ALTER TABLE `itens_carrinho`
  ADD CONSTRAINT `fk_itens_carrinho_carrinho` FOREIGN KEY (`carrinho_id`) REFERENCES `carrinhos` (`id_carrinho`),
  ADD CONSTRAINT `fk_itens_carrinho_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`);

--
-- Limitadores para a tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD CONSTRAINT `fk_itens_pedido_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `fk_itens_pedido_produto` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`);

--
-- Limitadores para a tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD CONSTRAINT `fk_pagamentos_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`);

--
-- Limitadores para a tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_produtos_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id_categoria`),
  ADD CONSTRAINT `fk_produtos_marca` FOREIGN KEY (`marca_id`) REFERENCES `marca` (`id_marca`);

--
-- Limitadores para a tabela `produto_tamanhos`
--
ALTER TABLE `produto_tamanhos`
  ADD CONSTRAINT `fk_produto_tamanhos_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `fk_produto_tamanhos_tamanho` FOREIGN KEY (`tamanho_id`) REFERENCES `tamanhos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
