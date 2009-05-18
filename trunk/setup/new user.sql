ALTER TABLE `collegekhabri`.`users` CHANGE COLUMN `cet_marks` `cet_score` SMALLINT(6)  DEFAULT NULL,
 CHANGE COLUMN `aieee_marks` `aieee_score` SMALLINT(6)  DEFAULT NULL,
 MODIFY COLUMN `gender` ENUM('male','female')  CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
 ADD COLUMN `projected_aieee_score` smallint(6)  AFTER `status`,
 ADD COLUMN `projected_cet_score` smallint(6)  AFTER `projected_aieee_score`;
