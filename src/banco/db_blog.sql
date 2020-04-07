-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema db_blog
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema db_blog
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_blog` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `db_blog` ;

-- -----------------------------------------------------
-- Table `db_blog`.`categorias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_blog`.`categorias` (
  `idcategoria` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idcategoria`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_blog`.`noticias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_blog`.`noticias` (
  `idnoticia` INT NOT NULL AUTO_INCREMENT,
  `data_noticia` DATETIME NOT NULL,
  `corpo` LONGTEXT NOT NULL,
  `imagem` VARCHAR(255) NULL,
  `idcategoria` INT NOT NULL,
  PRIMARY KEY (`idnoticia`),
  INDEX `fk_noticias_categorias1_idx` (`idcategoria` ASC),
  CONSTRAINT `fk_noticias_categorias1`
    FOREIGN KEY (`idcategoria`)
    REFERENCES `db_blog`.`categorias` (`idcategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_blog`.`tipos_usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_blog`.`tipos_usuarios` (
  `idtipo_usuario` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `tipo` CHAR(1) NOT NULL,
  PRIMARY KEY (`idtipo_usuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_blog`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_blog`.`usuarios` (
  `idusuario` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  `idtipo_usuario` INT NOT NULL,
  PRIMARY KEY (`idusuario`),
  INDEX `fk_usuarios_tipos_usuarios_idx` (`idtipo_usuario` ASC),
  CONSTRAINT `fk_usuarios_tipos_usuarios`
    FOREIGN KEY (`idtipo_usuario`)
    REFERENCES `db_blog`.`tipos_usuarios` (`idtipo_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_blog`.`comentarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_blog`.`comentarios` (
  `idcomentario` INT NOT NULL AUTO_INCREMENT,
  `idusuario` INT NOT NULL,
  `idnoticia` INT NOT NULL,
  `data_comentario` DATETIME NOT NULL,
  `comentario` LONGTEXT NULL,
  INDEX `fk_usuarios_has_noticias_noticias1_idx` (`idnoticia` ASC),
  INDEX `fk_usuarios_has_noticias_usuarios1_idx` (`idusuario` ASC),
  PRIMARY KEY (`idcomentario`),
  CONSTRAINT `fk_usuarios_has_noticias_usuarios1`
    FOREIGN KEY (`idusuario`)
    REFERENCES `db_blog`.`usuarios` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_has_noticias_noticias1`
    FOREIGN KEY (`idnoticia`)
    REFERENCES `db_blog`.`noticias` (`idnoticia`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
