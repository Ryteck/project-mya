--
-- Banco de Dados: `projeto_bd`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagem`
--

CREATE TABLE IF NOT EXISTS `imagem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idusuario` int(11) NOT NULL,
  `nome` varchar(250) NOT NULL,
  `nome_arquivo` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_imagem_usuario` (`idusuario`)
) ENGINE=MyISAM;

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(250) NOT NULL,
  `usuario` varchar(250) NOT NULL,
  `senha` varchar(250) NOT NULL,
  `foto` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`),
  UNIQUE KEY `foto_UNIQUE` (`foto`)
) ENGINE=MyISAM;
