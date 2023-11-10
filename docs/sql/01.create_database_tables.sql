CREATE DATABASE troca_verde

DROP TABLE IF EXISTS `troca_verde`.`usuarios` ;

CREATE TABLE IF NOT EXISTS `troca_verde`.`usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `password_hash` VARCHAR(60) NOT NULL,
  `cidade` VARCHAR(100) NULL,
  `estado` VARCHAR(2) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;



DROP TABLE IF EXISTS `troca_verde`.`planta_especies` ;

CREATE TABLE IF NOT EXISTS `troca_verde`.`planta_especies` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;



DROP TABLE IF EXISTS `troca_verde`.`planta_tipos` ;

CREATE TABLE IF NOT EXISTS `troca_verde`.`planta_tipos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `troca_verde`.`usuario_plantas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `usuario_id` INT NOT NULL,
  `especie_id` INT NOT NULL,
  `tipo_id` INT NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `dt_doacao` DATETIME,
  `dt_anuncio` DATETIME,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_usuario_plantas_usuarios`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `troca_verde`.`usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_plantas_especies`
    FOREIGN KEY (`especie_id`)
    REFERENCES `troca_verde`.`planta_especies` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_plantas_tipos`
    FOREIGN KEY (`tipo_id`)
    REFERENCES `troca_verde`.`planta_tipos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `troca_verde`.`planta_transacoes` ;

CREATE TABLE IF NOT EXISTS `troca_verde`.`planta_transacoes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `dt_transacao` DATETIME NULL,
  `usuario_plantas_id` INT NOT NULL,
  `usuarios_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_planta_transacoes_usuario_plantas1_idx` (`usuario_plantas_id` ASC),
  INDEX `fk_planta_transacoes_usuarios1_idx` (`usuarios_id` ASC),
  CONSTRAINT `fk_planta_transacoes_usuario_plantas1`
    FOREIGN KEY (`usuario_plantas_id`)
    REFERENCES `troca_verde`.`usuario_plantas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_planta_transacoes_usuarios1`
    FOREIGN KEY (`usuarios_id`)
    REFERENCES `troca_verde`.`usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `troca_verde`.`planta_interesses` ;

CREATE TABLE IF NOT EXISTS `troca_verde`.`planta_interesses` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `usuario_id` INT NOT NULL,
  `especie_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_planta_interesses_usuarios1_idx` (`usuario_id` ASC),
  INDEX `fk_planta_interesses_planta_especies1_idx` (`especie_id` ASC),
  CONSTRAINT `fk_planta_interesses_usuarios1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `troca_verde`.`usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_planta_interesses_planta_especies1`
    FOREIGN KEY (`especie_id`)
    REFERENCES `troca_verde`.`planta_especies` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;