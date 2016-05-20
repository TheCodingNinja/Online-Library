-- MySQL Script generated by MySQL Workbench
-- 05/20/16 14:40:52
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema Library
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `Library` ;

-- -----------------------------------------------------
-- Schema Library
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Library` DEFAULT CHARACTER SET utf8 ;
USE `Library` ;

-- -----------------------------------------------------
-- Table `Library`.`book`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Library`.`book` ;

CREATE TABLE IF NOT EXISTS `Library`.`book` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `Title` VARCHAR(75) NOT NULL,
  `Description` VARCHAR(200) NOT NULL,
  `Author` VARCHAR(50) NULL,
  `Pages` INT NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Library`.`count`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Library`.`count` ;

CREATE TABLE IF NOT EXISTS `Library`.`count` (
  `Copies` INT NULL,
  `book_ID` INT NOT NULL,
  PRIMARY KEY (`book_ID`),
  CONSTRAINT `fk_count_book1`
    FOREIGN KEY (`book_ID`)
    REFERENCES `Library`.`book` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Library`.`subject`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Library`.`subject` ;

CREATE TABLE IF NOT EXISTS `Library`.`subject` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(75) NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Library`.`roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Library`.`roles` ;

CREATE TABLE IF NOT EXISTS `Library`.`roles` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(75) NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Library`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Library`.`user` ;

CREATE TABLE IF NOT EXISTS `Library`.`user` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `Username` VARCHAR(75) NULL,
  `Password` LONGTEXT NULL,
  `roles_ID` INT NOT NULL,
  PRIMARY KEY (`ID`, `roles_ID`),
  INDEX `fk_Users_roles1_idx` (`roles_ID` ASC),
  CONSTRAINT `fk_Users_roles1`
    FOREIGN KEY (`roles_ID`)
    REFERENCES `Library`.`roles` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Library`.`booksubject`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Library`.`booksubject` ;

CREATE TABLE IF NOT EXISTS `Library`.`booksubject` (
  `subject_ID` INT NOT NULL,
  `book_ID` INT NOT NULL,
  PRIMARY KEY (`subject_ID`, `book_ID`),
  INDEX `fk_booksubject_book1_idx` (`book_ID` ASC),
  CONSTRAINT `fk_booksubject_subject`
    FOREIGN KEY (`subject_ID`)
    REFERENCES `Library`.`subject` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_booksubject_book1`
    FOREIGN KEY (`book_ID`)
    REFERENCES `Library`.`book` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Library`.`rented`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Library`.`rented` ;

CREATE TABLE IF NOT EXISTS `Library`.`rented` (
  `Date` DATETIME NOT NULL,
  `Users_ID` INT NOT NULL,
  `book_ID` INT NOT NULL,
  PRIMARY KEY (`Date`, `Users_ID`, `book_ID`),
  INDEX `fk_rented_Users1_idx` (`Users_ID` ASC),
  INDEX `fk_rented_book1_idx` (`book_ID` ASC),
  CONSTRAINT `fk_rented_Users1`
    FOREIGN KEY (`Users_ID`)
    REFERENCES `Library`.`user` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_rented_book1`
    FOREIGN KEY (`book_ID`)
    REFERENCES `Library`.`book` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
