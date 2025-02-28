-- MySQL Script generated by MySQL Workbench
-- Sun Nov 12 11:03:19 2023
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema troca_verde
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema troca_verde
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `troca_verde` DEFAULT CHARACTER SET utf8 ;
USE `troca_verde` ;

-- -----------------------------------------------------
-- Table `troca_verde`.`usuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `troca_verde`.`usuarios` ;

CREATE TABLE IF NOT EXISTS `troca_verde`.`usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `password_hash` VARCHAR(60) NOT NULL,
  `sexo` CHAR(1) NOT NULL,
  `logradouro` VARCHAR(200) NOT NULL,
  `numero` VARCHAR(30) NOT NULL,
  `complemento` VARCHAR(30) NULL,
  `bairro` VARCHAR(100) NOT NULL,
  `cidade` VARCHAR(100) NOT NULL,
  `uf` CHAR(2) NOT NULL,
  `descricao` TEXT,
  `created_at` TIMESTAMP NULL,
  `updated_At` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `troca_verde`.`tipos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `troca_verde`.`tipos` ;

CREATE TABLE IF NOT EXISTS `troca_verde`.`tipos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nome_UNIQUE` (`nome` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `troca_verde`.`especies`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `troca_verde`.`especies` ;

CREATE TABLE IF NOT EXISTS `troca_verde`.`especies` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `troca_verde`.`plantas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `troca_verde`.`plantas` ;

CREATE TABLE IF NOT EXISTS `troca_verde`.`plantas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `usuario_id` INT NOT NULL,
  `tipo_id` INT NOT NULL,
  `especie_id` INT NOT NULL,
  `foto` VARCHAR(255) NULL,
  `descricao` TEXT,
  `donated_to` INT,
  `donated_at` TIMESTAMP NULL,
  `disabled_at` TIMESTAMP NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,

  PRIMARY KEY (`id`),
  INDEX `fk_plantas_usuarios_idx` (`usuario_id` ASC),
  INDEX `fk_plantas_tipos1_idx` (`tipo_id` ASC),
  INDEX `fk_plantas_especies1_idx` (`especie_id` ASC),
  INDEX `fk_plantas_donated_to_idx` (`donated_to` ASC),
  CONSTRAINT `fk_plantas_usuarios`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `troca_verde`.`usuarios` (`id`),
  CONSTRAINT `fk_plantas_tipos1`
    FOREIGN KEY (`tipo_id`)
    REFERENCES `troca_verde`.`tipos` (`id`),
  CONSTRAINT `fk_plantas_especies1`
    FOREIGN KEY (`especie_id`)
    REFERENCES `troca_verde`.`especies` (`id`),
  CONSTRAINT `fk_plantas_donated_to`
    FOREIGN KEY (`donated_to`)
    REFERENCES `troca_verde`.`usuarios` (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `troca_verde`.`solicitacao_cancelamento_motivos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `troca_verde`.`solicitacao_cancelamento_motivos` ;

CREATE TABLE IF NOT EXISTS `troca_verde`.`solicitacao_cancelamento_motivos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nome_UNIQUE` (`nome` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `troca_verde`.`solicitacao_tipos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `troca_verde`.`solicitacao_tipos` ;

CREATE TABLE IF NOT EXISTS `troca_verde`.`solicitacao_tipos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nome_UNIQUE` (`nome` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `troca_verde`.`solicitacoes`
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `troca_verde`;

DROP TABLE IF EXISTS `troca_verde`.`solicitacoes` ;

CREATE TABLE IF NOT EXISTS `troca_verde`.`solicitacoes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `planta_id` INT NOT NULL,
  `solicitante_id` INT NOT NULL,
  `solicitante_planta_id` INT NULL,
  `propriet_accepted_at` DATETIME NULL,
  `solic_accepted_at` DATETIME NULL,
  `canceled_at` DATETIME NULL,
  `canceled_by` INTEGER NULL,
  `cancelamento_motivo_id` INT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_planta_solicitacoes_plantas1_idx` (`planta_id` ASC),
  INDEX `fk_planta_solicitacoes_solicitante1_idx` (`solicitante_id` ASC),
  INDEX `fk_solicitacoes_solicitante_planta1_idx` (`solicitante_planta_id` ASC),
  INDEX `fk_solicitacoes_canceled_by_idx` (`canceled_by` ASC),
  INDEX `fk_solicitacoes_cancelamento_motivo_idx` (`cancelamento_motivo_id` ASC),
  CONSTRAINT `fk_planta_solicitacoes_plantas1`
    FOREIGN KEY (`planta_id`)
    REFERENCES `troca_verde`.`plantas` (`id`),
  CONSTRAINT `fk_planta_solicitacoes_solicitantes1`
    FOREIGN KEY (`solicitante_id`)
    REFERENCES `troca_verde`.`usuarios` (`id`),
  CONSTRAINT `fk_solicitacoes_solicitante_planta1`
    FOREIGN KEY (`solicitante_planta_id`)
    REFERENCES `troca_verde`.`plantas` (`id`),
  CONSTRAINT `fk_solicitacoes_canceled_by1`
    FOREIGN KEY (`canceled_by`)
    REFERENCES `troca_verde`.`usuarios` (`id`),
  CONSTRAINT `fk_solicitacoes_cancelamento_motivo1`
    FOREIGN KEY (`cancelamento_motivo_id`)
    REFERENCES `troca_verde`.`solicitacao_cancelamento_motivos` (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `troca_verde`.`favoritos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `troca_verde`.`favoritos` ;

CREATE TABLE IF NOT EXISTS `troca_verde`.`favoritos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `usuario_id` INT NOT NULL,
  `especie_id` INT NOT NULL,
  `created_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_favoritos_usuarios1_idx` (`usuario_id` ASC),
  INDEX `fk_favoritos_especies1_idx` (`especie_id` ASC),
  CONSTRAINT `fk_favoritos_usuarios1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `troca_verde`.`usuarios` (`id`),
  CONSTRAINT `fk_favoritos_especies1`
    FOREIGN KEY (`especie_id`)
    REFERENCES `troca_verde`.`especies` (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `troca_verde`.`solicitacao_mensagens`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `troca_verde`.`solicitacao_mensagens` ;

CREATE TABLE IF NOT EXISTS `troca_verde`.`solicitacao_mensagens` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `solicitacao_id` INT NOT NULL,
  `usuario_id` INT NOT NULL,
  `mensagem` TEXT NOT NULL,
  `created_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_solicitacao_mensagens_solicitacoes1_idx` (`solicitacao_id` ASC),
  INDEX `fk_solicitacao_mensagens_usuarios1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_solicitacao_mensagens_solicitacoes1`
    FOREIGN KEY (`solicitacao_id`)
    REFERENCES `troca_verde`.`solicitacoes` (`id`),
  CONSTRAINT `fk_solicitacao_mensagens_usuarios1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `troca_verde`.`usuarios` (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `troca_verde`.`solicitacao_transacoes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `troca_verde`.`solicitacao_transacoes` ;

CREATE TABLE IF NOT EXISTS `troca_verde`.`solicitacao_transacoes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `solicitacao_id` INT NOT NULL,
  `usuario_de_id` INT NOT NULL,
  `usuario_para_id` INT NOT NULL,
  `created_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_solicitacao_transacoes_solicitacoes1_idx` (`solicitacao_id` ASC),
  INDEX `fk_solicitacao_transacoes_usuarios1_idx` (`usuario_de_id` ASC),
  INDEX `fk_solicitacao_transacoes_usuarios2_idx` (`usuario_para_id` ASC),
  CONSTRAINT `fk_solicitacao_transacoes_solicitacoes1`
    FOREIGN KEY (`solicitacao_id`)
    REFERENCES `troca_verde`.`solicitacoes` (`id`),
  CONSTRAINT `fk_solicitacao_transacoes_usuarios1`
    FOREIGN KEY (`usuario_de_id`)
    REFERENCES `troca_verde`.`usuarios` (`id`),
  CONSTRAINT `fk_solicitacao_transacoes_usuarios2`
    FOREIGN KEY (`usuario_para_id`)
    REFERENCES `troca_verde`.`usuarios` (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
