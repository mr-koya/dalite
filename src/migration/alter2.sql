SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

ALTER TABLE `dalite`.`assignment` ENGINE = InnoDB , DROP COLUMN `students_done` , DROP COLUMN `is_group` , DROP COLUMN `in_class` , CHANGE COLUMN `id` `assignment_` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT  , CHANGE COLUMN `accessible` `published` TINYINT(1) NOT NULL  ;

ALTER TABLE `dalite`.`assignment_question` ENGINE = InnoDB , CHANGE COLUMN `id` `assignment_question_` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT  , CHANGE COLUMN `assignment` `assignment_` INT(11) UNSIGNED NOT NULL  , CHANGE COLUMN `question` `question_` INT(11) UNSIGNED NOT NULL  , CHANGE COLUMN `ord` `order` INT(11) UNSIGNED NOT NULL DEFAULT '0'  , 
  ADD CONSTRAINT `fk_assignment_question_1`
  FOREIGN KEY (`assignment_` )
  REFERENCES `dalite`.`assignment` (`assignment_` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_assignment_question_2`
  FOREIGN KEY (`question_` )
  REFERENCES `dalite`.`question` (`question_` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `fk_assignment_question_1` (`assignment_` ASC) 
, ADD INDEX `fk_assignment_question_2` (`question_` ASC) ;

ALTER TABLE `dalite`.`grp_member` ENGINE = InnoDB , DROP COLUMN `grp` , CHANGE COLUMN `id` `student_course_` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT  , CHANGE COLUMN `student` `student_` INT(10) UNSIGNED NOT NULL  , CHANGE COLUMN `assignment` `course_` INT(10) UNSIGNED NOT NULL  , 
  ADD CONSTRAINT `fk_student_course_1`
  FOREIGN KEY (`course_` )
  REFERENCES `dalite`.`course` (`course_` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_student_course_2`
  FOREIGN KEY (`student_` )
  REFERENCES `dalite`.`student` (`student_` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `fk_student_course_1` (`course_` ASC) 
, ADD INDEX `fk_student_course_2` (`student_` ASC) , RENAME TO  `dalite`.`student_course` ;

ALTER TABLE `dalite`.`question` ENGINE = InnoDB, CHANGE COLUMN `id` `question_` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT  , CHANGE COLUMN `second_best` `second_choice` CHAR(1) NOT NULL  , CHANGE COLUMN `rational` `rationale` VARCHAR(1024) NOT NULL  , CHANGE COLUMN `second_best_rational` `second_choice_rationale` VARCHAR(512) NOT NULL  ;

ALTER TABLE `dalite`.`response` 
  ADD CONSTRAINT `fk_response_1`
  FOREIGN KEY (`question_` )
  REFERENCES `dalite`.`question` (`question_` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_response_2`
  FOREIGN KEY (`student_` )
  REFERENCES `dalite`.`student` (`student_` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_response_3`
  FOREIGN KEY (`assignment_` )
  REFERENCES `dalite`.`assignment` (`assignment_` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `fk_response_1` (`question_` ASC) 
, ADD INDEX `fk_response_2` (`student_` ASC) 
, ADD INDEX `fk_response_3` (`assignment_` ASC) ;

ALTER TABLE `dalite`.`student` ENGINE = InnoDB , DROP COLUMN `is_group` , CHANGE COLUMN `id` `student_` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT  , CHANGE COLUMN `passwd` `password` VARCHAR(24) NOT NULL  , CHANGE COLUMN `prof` `is_professor` TINYINT(1) NULL DEFAULT NULL  ;

CREATE  TABLE IF NOT EXISTS `dalite`.`course_assignment` (
  `course_assignment_` INT(10) UNSIGNED NOT NULL ,
  `course_` INT(10) UNSIGNED NOT NULL ,
  `assignment_` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`course_assignment_`) ,
  INDEX `fk_course_assignment_1` (`course_` ASC) ,
  INDEX `fk_course_assignment_2` (`assignment_` ASC) ,
  CONSTRAINT `fk_course_assignment_1`
    FOREIGN KEY (`course_` )
    REFERENCES `dalite`.`course` (`course_` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_course_assignment_2`
    FOREIGN KEY (`assignment_` )
    REFERENCES `dalite`.`assignment` (`assignment_` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;

CREATE  TABLE IF NOT EXISTS `dalite`.`course` (
  `course_` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(80) NOT NULL ,
  `accessible` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`course_`) )
ENGINE = InnoDB
AUTO_INCREMENT = 10733
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

ALTER TABLE `dalite`.`question` ADD COLUMN `media2` VARCHAR(45) NULL  AFTER `media1` , ADD COLUMN `alpha` TINYINT NOT NULL  AFTER `second_choice_rationale` , CHANGE COLUMN `uuid` `media1` VARCHAR(36) NOT NULL DEFAULT '""'  ;
ALTER TABLE `course` ADD `professor_` INT( 10 ) NOT NULL AFTER `course_`;
UPDATE `course` SET `professor_` = '200' WHERE `course`.`course_` =200;
ALTER TABLE `student` CHANGE `fname` `firstname` VARCHAR( 24 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
CHANGE `lname` `lastname` VARCHAR( 24 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE `course` CHANGE `accessible` `accessible` TINYINT( 1 ) NOT NULL DEFAULT '1';
