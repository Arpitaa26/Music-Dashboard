# Learning Portal Database Schema 
#### by Monirul Middya

---

> ## Version 1.0.0

**************************
Changelog of settings

## Table name : tbl_user
#### Date : 01/04/2023
```bash

CREATE TABLE `tbl_users` (
  `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
  `user_type_id` bigint(22) NOT NULL,
  `user_pronoun_id` bigint(22) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL DEFAULT '',
  `last_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_no` varchar(14) NOT NULL,
  `password` text NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `address` longtext NOT NULL,
  `dob` date NOT NULL,
  `otp` varchar(8) NOT NULL,
  `referal_code` varchar(30) NOT NULL,
  `no_of_referals` int(11) DEFAULT NULL,
  `last_login` datetime NOT NULL,
  `ip` varchar(50) NOT NULL,
  `created_by` bigint(22) NOT NULL,
  `updated_by` bigint(22) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `status` enum('pending','active','inactive','blocked','banned') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

```
```bash

CREATE TABLE `tbl_user_types` 
(
    `id` BIGINT(22) NOT NULL AUTO_INCREMENT ,
     `type` VARCHAR(50) NOT NULL ,
      `status` TINYINT(1) NOT NULL DEFAULT '1' , 
      `created_by` BIGINT NOT NULL , 
      `updated_by` BIGINT NOT NULL , 
      `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
      `updated_on` DATETIME on update CURRENT_TIMESTAMP NULL DEFAULT NULL , 
      PRIMARY KEY (`id`)
) ENGINE = InnoDB;

```
```bash

CREATE TABLE `tbl_user_pronouns` 
(
    `id` BIGINT(22) NOT NULL AUTO_INCREMENT ,
     `pronoun` VARCHAR(50) NOT NULL ,
      `status` TINYINT(1) NOT NULL DEFAULT '1' , 
      `created_by` BIGINT NOT NULL , 
      `updated_by` BIGINT NOT NULL , 
      `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
      `updated_on` DATETIME on update CURRENT_TIMESTAMP NULL DEFAULT NULL , 
      PRIMARY KEY (`id`)
) ENGINE = InnoDB;

```

```bash

ALTER TABLE
    `tbl_users` ADD CONSTRAINT `ut_rel` FOREIGN KEY(`user_type_id`) REFERENCES `tbl_user_types`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE
    `tbl_users` ADD CONSTRAINT `up_rel` FOREIGN KEY(`user_pronoun_id`) REFERENCES `tbl_user_pronouns`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

```

#### Change log : 03/04/2023

```bash

CREATE TABLE `tbl_files`(
    `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
    `file_name` VARCHAR(100) NOT NULL,
    `mime_type` VARCHAR(50) NOT NULL,
    `path` TEXT NOT NULL,
    `status` TINYINT(1) NOT NULL DEFAULT '0',
    `created_by` BIGINT NOT NULL,
    `updated_by` BIGINT NOT NULL,
    `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(`id`)
) ENGINE = InnoDB;

```

#### Change log  : 05/04/2023

```bash

CREATE TABLE `tbl_courses`(
    `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(50) NOT NULL,
    `name` VARCHAR(200) NOT NULL,
    `role` ENUM("paid", "free") NOT NULL,
    `price` DOUBLE NOT NULL,
    `description` LONGTEXT NOT NULL,
    `status` TINYINT(1) NOT NULL,
    `created_by` BIGINT(22) NOT NULL,
    `updated_by` BIGINT(22) NOT NULL,
    `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(`id`)
) ENGINE = InnoDB;

```

#### Change log : 06/04/2023

```bash 

CREATE TABLE `tbl_questions`(
    `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
    `course_id` BIGINT(22) NOT NULL,
    `module_id` BIGINT(22) NOT NULL,
    `type` ENUM( "INPUT", "SINGLE_SELECT", "MULTI_SELECT", "DATE", "FILE" ) NOT NULL,
    `name` TEXT NOT NULL,
    `answer` VARCHAR(200) NOT NULL,
    `created_by` BIGINT(22) NOT NULL,
    `updated_by` BIGINT(22) NOT NULL,
    `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
    `status` TINYINT(1) NOT NULL,
    PRIMARY KEY(`id`)
) ENGINE = InnoDB;

```

```bash 

CREATE TABLE `tbl_course_levels`(
    `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
    `level` VARCHAR(200) NOT NULL,
    `description` VARCHAR(200) NOT NULL,
    `created_by` BIGINT(22) NOT NULL,
    `updated_by` BIGINT(22) NOT NULL,
    `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
    `status` TINYINT(1) NOT NULL,
    PRIMARY KEY(`id`)
) ENGINE = InnoDB;

```

```bash

CREATE TABLE `tbl_modules`(
    `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
    `course_id` BIGINT(22) NOT NULL,
    `course_level_id` BIGINT(22) NOT NULL,
    `name` VARCHAR(200) NOT NULL,
    `description` VARCHAR(200) NOT NULL,
    `status` TINYINT(1) NOT NULL,
    `created_by` BIGINT(22) NOT NULL,
    `updated_by` BIGINT(22) NOT NULL,
    `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(`id`)
) ENGINE = InnoDB;

```

```bash

ALTER TABLE
    `tbl_modules` ADD CONSTRAINT `course_rel` FOREIGN KEY(`course_id`) REFERENCES `tbl_courses`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE
    `tbl_modules` ADD CONSTRAINT `course_level_rel` FOREIGN KEY(`course_level_id`) REFERENCES `tbl_course_levels`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

```

#### change log : 11/04/2023

```bash

ALTER TABLE `tbl_users` ADD UNIQUE `unique_username` (`username`);

```

#### change log : 12/04/2023

```bash

ALTER TABLE
    `tbl_questions` ADD CONSTRAINT `q_course_rel` FOREIGN KEY(`course_id`) REFERENCES `tbl_courses`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
    
ALTER TABLE
    `tbl_questions` ADD CONSTRAINT `q_module_rel` FOREIGN KEY(`module_id`) REFERENCES `tbl_modules`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

```

```bash

ALTER TABLE `tbl_courses` ADD UNIQUE `unique_code` (`code`);

```

#### change log : 14/04/2023

```bash

CREATE TABLE `tbl_question_options`(
    `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
    `question_id` BIGINT(22) NOT NULL,
    `option` TEXT NOT NULL,
    `is_correct` TINYINT(1) NOT NULL,
    `status` TINYINT(1) NOT NULL,
    `created_by` BIGINT(22) NOT NULL,
    `updated_by` BIGINT(22) NOT NULL,
    `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(`id`)
) ENGINE = InnoDB;

ALTER TABLE
    `tbl_question_options` ADD CONSTRAINT `qt_q_rel` FOREIGN KEY(`question_id`) REFERENCES `tbl_questions`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

```

#### change log : 15/04/2023

```bash

CREATE TABLE `tbl_batches`(
    `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(50) NOT NULL,
    `course_id` BIGINT(22) NOT NULL,
    `description` LONGTEXT NULL,
    `start_date` DATE NOT NULL,
    `no_of_students_allowed` INT NOT NULL,
    `status` TINYINT(1) NOT NULL,
    `created_by` BIGINT(22) NOT NULL,
    `updated_by` BIGINT(22) NOT NULL,
    `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(`id`)
) ENGINE = InnoDB;

ALTER TABLE
    `tbl_batches` ADD CONSTRAINT `tb_b_rel` FOREIGN KEY(`course_id`) REFERENCES `tbl_courses`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `tbl_batches` ADD UNIQUE `unique_batch_code` (`code`);

```

```bash

CREATE TABLE `tbl_session_types`(
    `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
    `type` VARCHAR(50) NOT NULL,
    `status` TINYINT(1) NOT NULL,
    `created_by` BIGINT(22) NOT NULL,
    `updated_by` BIGINT(22) NOT NULL,
    `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(`id`)
) ENGINE = InnoDB;

```

```bash

CREATE TABLE `tbl_class_status`(
    `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `status` TINYINT(1) NOT NULL,
    `created_by` BIGINT(22) NOT NULL,
    `updated_by` BIGINT(22) NOT NULL,
    `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(`id`)
) ENGINE = InnoDB;

```

```bash

CREATE TABLE `tbl_scheduled_classes`(
    `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
    `batch_id` BIGINT(22) NOT NULL,
    `session_id` BIGINT(22) NOT NULL,
    `module_id` BIGINT(22) NOT NULL,
    `status_id` BIGINT(22) NOT NULL,
    `start_time` DATE NOT NULL,
    `end_time` DATE NOT NULL,
    `description` LONGTEXT NULL,
    `link` TEXT NULL,
    `recorded_link` TEXT NULL,
    `level` VARCHAR(50) NULL,
    `created_by` BIGINT(22) NOT NULL,
    `updated_by` BIGINT(22) NOT NULL,
    `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(`id`)
) ENGINE = InnoDB;

ALTER TABLE
    `tbl_scheduled_classes` ADD CONSTRAINT `sc_btc_rel` FOREIGN KEY(`batch_id`) REFERENCES `tbl_batches`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE
    `tbl_scheduled_classes` ADD CONSTRAINT `sc_ses_rel` FOREIGN KEY(`session_id`) REFERENCES `tbl_session_types`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE
    `tbl_scheduled_classes` ADD CONSTRAINT `sc_module_rel` FOREIGN KEY(`module_id`) REFERENCES `tbl_modules`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE
    `tbl_scheduled_classes` ADD CONSTRAINT `sc_cls_status_rel` FOREIGN KEY(`status_id`) REFERENCES `tbl_class_status`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

```

#### change logs : 19/04/2023

```bash

CREATE TABLE `tbl_batch_teacher`(
    `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
    `batch_id` BIGINT(22) NOT NULL,
    `module_id` BIGINT(22) NOT NULL,
    `user_id` BIGINT(22) NOT NULL,
    `status` TINYINT(1) NOT NULL,
    `created_by` BIGINT(22) NOT NULL,
    `updated_by` BIGINT(22) NOT NULL,
    `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(`id`)
) ENGINE = InnoDB;


ALTER TABLE `tbl_batch_teacher` CHANGE `user_id` `user_id` BIGINT(22) NOT NULL COMMENT 'user_id of users where type is TEACHER';

ALTER TABLE
    `tbl_batch_teacher` ADD CONSTRAINT `tbtb_rel` FOREIGN KEY(`batch_id`) REFERENCES `tbl_batches`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE
    `tbl_batch_teacher` ADD CONSTRAINT `tbtu_rel` FOREIGN KEY(`user_id`) REFERENCES `tbl_users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE
    `tbl_batch_teacher` ADD CONSTRAINT `tbtm_rel` FOREIGN KEY(`module_id`) REFERENCES `tbl_modules`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

```

#### change logs : 20/04/2023

```bash 

CREATE TABLE `tbl_courses_enrollment`(
    `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT(22) NOT NULL COMMENT 'user_id of users where type is STUDENT',
    `course_id` BIGINT(22) NOT NULL,
    `batch_id` BIGINT(22) NULL,
    `referral_code_used` VARCHAR(100) NULL,
    `modules_completed` TINYINT(1) NULL DEFAULT '0',
    `attendance` TINYINT(1) NULL DEFAULT '0',
    `classes_purchased` TINYINT(1) NULL DEFAULT '0',
    `classes_used` TINYINT(1) NULL DEFAULT '0',
    `status` TINYINT(1) NOT NULL DEFAULT '0',
    `created_by` BIGINT(22) NOT NULL,
    `updated_by` BIGINT(22) NOT NULL,
    `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(`id`)
) ENGINE = InnoDB;

ALTER TABLE
    `tbl_courses_enrollment` ADD CONSTRAINT `tceb_rel` FOREIGN KEY(`batch_id`) REFERENCES `tbl_batches`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE
    `tbl_courses_enrollment` ADD CONSTRAINT `tceu_rel` FOREIGN KEY(`user_id`) REFERENCES `tbl_users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE
    `tbl_courses_enrollment` ADD CONSTRAINT `tcec_rel` FOREIGN KEY(`course_id`) REFERENCES `tbl_courses`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;


ALTER TABLE `tbl_courses_enrollment` ADD UNIQUE `cenrolement_user_course_unique` (`user_id`, `course_id`);


```

```bash

CREATE TABLE `tbl_user_attendance`(
    `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT(22) NOT NULL COMMENT 'user_id of users where type is STUDENT/TEACHER',
    `class_id` BIGINT(22) NOT NULL,
    `batch_id` BIGINT(22) NULL,
    `feedback` TEXT NULL,
    `status` ENUM("ATTENDED", "MISSED", "REQUEST_RESCHEDULE") NOT NULL,
    `left_on` DATETIME NULL,
    `created_by` BIGINT(22) NOT NULL,
    `updated_by` BIGINT(22) NOT NULL,
    `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(`id`)
) ENGINE = InnoDB;

ALTER TABLE
    `tbl_user_attendance` ADD CONSTRAINT `tuab_rel` FOREIGN KEY(`batch_id`) REFERENCES `tbl_batches`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE
    `tbl_user_attendance` ADD CONSTRAINT `tuau_rel` FOREIGN KEY(`user_id`) REFERENCES `tbl_users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE
    `tbl_user_attendance` ADD CONSTRAINT `tuac_rel` FOREIGN KEY(`class_id`) REFERENCES `tbl_scheduled_classes`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

```

```bash

CREATE TABLE `tbl_user_availability`(
    `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT(22) NOT NULL COMMENT 'user_id of users where type is TEACHER',
    `status` TINYINT(1) NULL DEFAULT '0' COMMENT 'is_available as status',
    `from` DATETIME NOT NULL,
    `to` DATETIME NOT NULL,
    `created_by` BIGINT(22) NOT NULL,
    `updated_by` BIGINT(22) NOT NULL,
    `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(`id`)
) ENGINE = InnoDB;

ALTER TABLE
    `tbl_user_availability` ADD CONSTRAINT `tuavalu_rel` FOREIGN KEY(`user_id`) REFERENCES `tbl_users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

```

```bash

CREATE TABLE `tbl_courses_teacher`(
    `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT(22) NOT NULL COMMENT 'user_id of users where type is TEACHER',
    `course_id` BIGINT(22) NOT NULL,
    `is_accepted_for_course`  TINYINT(1) NULL DEFAULT '0',
    `status` TINYINT(1) NULL DEFAULT '0',
    `created_by` BIGINT(22) NOT NULL,
    `updated_by` BIGINT(22) NOT NULL,
    `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(`id`)
) ENGINE = InnoDB;


ALTER TABLE
    `tbl_courses_teacher` ADD CONSTRAINT `tctu_rel` FOREIGN KEY(`user_id`) REFERENCES `tbl_users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
 
 ALTER TABLE
    `tbl_courses_teacher` ADD CONSTRAINT `tctc_rel` FOREIGN KEY(`course_id`) REFERENCES `tbl_courses`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;



    CREATE TABLE `tbl_class_reschedule_request`(
    `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT(22) NOT NULL COMMENT 'user_id of users where type is STUDENT/TEACHER',
    `class_id` BIGINT(22) NOT NULL,
    `reason_for_reschedule` TEXT NULL,
    `status` TINYINT(1) NULL DEFAULT '0',
    `created_by` BIGINT(22) NOT NULL,
    `updated_by` BIGINT(22) NOT NULL,
    `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(`id`)
) ENGINE = InnoDB;

ALTER TABLE
    `tbl_class_reschedule_request` ADD CONSTRAINT `tcrrur_rel` FOREIGN KEY(`user_id`) REFERENCES `tbl_users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
 
 ALTER TABLE
    `tbl_class_reschedule_request` ADD CONSTRAINT `tcrrsc_rel` FOREIGN KEY(`class_id`) REFERENCES `tbl_scheduled_classes`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
    

```

#### change logs : 28/04/2023

```bash

ALTER TABLE `tbl_files` ADD `slug` VARCHAR(100) NOT NULL AFTER `file_name`, ADD `category` ENUM('TUTORIAL','PROFILE_PIC','HOMEWORK') NOT NULL AFTER `slug`;

```

#### change logs : 29/04/2023

```bash

ALTER TABLE `tbl_scheduled_classes` DROP FOREIGN KEY `sc_cls_status_rel`;

ALTER TABLE `tbl_scheduled_classes` DROP INDEX `sc_cls_status_rel`;

ALTER TABLE `tbl_scheduled_classes` CHANGE `status_id` `status` ENUM('NOT_STARTED','STARTED','APPROVED','ENDED','CANCELLED','RESCHEDULED') NOT NULL;

DROP TABLE `tbl_class_status`

```

```bash

CREATE TABLE `tbl_tutorial`(
    `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
    `module_id` BIGINT(22) NOT NULL,
    `title` VARCHAR(250) NOT NULL,
    `description` LONGTEXT NULL,
    `status` TINYINT(1) NULL DEFAULT '0',
    `created_by` BIGINT(22) NOT NULL,
    `updated_by` BIGINT(22) NOT NULL,
    `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(`id`)
) ENGINE = InnoDB;

ALTER TABLE
    `tbl_tutorial` ADD CONSTRAINT `tttm_rel` FOREIGN KEY(`module_id`) REFERENCES `tbl_modules`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

```

#### change logs : 01/05/2023

```bash

ALTER TABLE `tbl_files` ADD UNIQUE `file_unique_slug` (`slug`);

```

#### change logs : 02/05/2023

```bash

CREATE TABLE `tbl_tutorial_files`(
    `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
    `totorial_id` BIGINT(22) NOT NULL,
    `file_id` BIGINT(22) NOT NULL,
    `order` INT(11) NOT NULL,
    `status` TINYINT(1) NULL DEFAULT '0',
    `created_by` BIGINT(22) NOT NULL,
    `updated_by` BIGINT(22) NOT NULL,
    `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(`id`)
) ENGINE = InnoDB;

ALTER TABLE
    `tbl_tutorial_files` ADD CONSTRAINT `ttftt_rel` FOREIGN KEY(`totorial_id`) REFERENCES `tbl_tutorial`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
    
    
ALTER TABLE
    `tbl_tutorial_files` ADD CONSTRAINT `ttftf_rel` FOREIGN KEY(`file_id`) REFERENCES `tbl_files`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
    
ALTER TABLE `tbl_tutorial_files` CHANGE `totorial_id` `tutorial_id` BIGINT(22) NOT NULL;

```

#### chang logs : 04/05/2023

```bash

ALTER TABLE `tbl_questions` CHANGE `answer` `hints` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

ALTER TABLE `tbl_questions` ADD `order` INT(11) NOT NULL AFTER `name`, ADD `marks` INT(11) NOT NULL AFTER `order`;

ALTER TABLE `tbl_question_options` ADD `order` INT(11) NOT NULL AFTER `option`;
ALTER TABLE `tbl_modules` ADD `order` INT(11) NOT NULL AFTER `description`;
ALTER TABLE `tbl_questions` ADD `file_name` VARCHAR(200) NULL DEFAULT NULL AFTER `hints`;
```

#### chang logs : 09/05/2023

```bash

CREATE TABLE `tbl_course_material`(
    `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
    `course_id` BIGINT(22) NOT NULL,
    `module_id` BIGINT(22) NOT NULL,
    `file_id` BIGINT(22) NOT NULL,
    `description` LONGTEXT NULL,
    `status` TINYINT(1) NULL DEFAULT '0',
    `created_by` BIGINT(22) NOT NULL,
    `updated_by` BIGINT(22) NOT NULL,
    `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(`id`)
) ENGINE = InnoDB;

ALTER TABLE
    `tbl_course_material` ADD CONSTRAINT `tcm_tc_rel` FOREIGN KEY(`course_id`) REFERENCES `tbl_courses`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE
    `tbl_course_material` ADD CONSTRAINT `tcm_tm_rel` FOREIGN KEY(`module_id`) REFERENCES `tbl_modules`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE
    `tbl_course_material` ADD CONSTRAINT `tcm_tf_rel` FOREIGN KEY(`file_id`) REFERENCES `tbl_files`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;


ALTER TABLE `tbl_files` CHANGE `category` `category` ENUM('TUTORIAL','PROFILE_PIC','HOMEWORK','COURSE_MATERIAL') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

```

```bash

CREATE TABLE `tbl_course_homeworks`(
    `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
    `batch_id` BIGINT(22) NOT NULL,
    `class_id` BIGINT(22) NOT NULL,
    `file_id` BIGINT(22) NOT NULL,
    `description` LONGTEXT NULL,
    `due_date` date NULL,
    `status` TINYINT(1) NULL DEFAULT '0',
    `created_by` BIGINT(22) NOT NULL,
    `updated_by` BIGINT(22) NOT NULL,
    `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(`id`)
) ENGINE = InnoDB;

ALTER TABLE
    `tbl_course_homeworks` ADD CONSTRAINT `tchw_tb_rel` FOREIGN KEY(`batch_id`) REFERENCES `tbl_batches`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE
    `tbl_course_homeworks` ADD CONSTRAINT `tchw_tsc_rel` FOREIGN KEY(`class_id`) REFERENCES `tbl_scheduled_classes`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE
    `tbl_course_homeworks` ADD CONSTRAINT `tchw_tf_rel` FOREIGN KEY(`file_id`) REFERENCES `tbl_files`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;


ALTER TABLE `tbl_files` CHANGE `category` `category` ENUM('TUTORIAL','PROFILE_PIC','HOMEWORK','COURSE_MATERIAL','COURSE_HOMEWORK') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

```

#### chang logs : 12/05/2023

```bash

ALTER TABLE `tbl_batches` ADD `course_level_id` BIGINT(22) NOT NULL AFTER `course_id`;

ALTER TABLE `tbl_scheduled_classes` CHANGE `start_time` `start_time` DATETIME NOT NULL;

ALTER TABLE `tbl_scheduled_classes` CHANGE `end_time` `end_time` DATETIME NOT NULL;

```

#### chang logs : 13/05/2023

```bash

ALTER TABLE
    `tbl_batches` ADD CONSTRAINT `tbt_tcl_rel` FOREIGN KEY(`course_level_id`) REFERENCES `tbl_course_levels`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

DROP TABLE `tbl_question_types`


ALTER TABLE `tbl_scheduled_classes` ADD `user_id` BIGINT(22) NOT NULL AFTER `module_id`;

ALTER TABLE `tbl_courses_enrollment` ADD `course_level_id` BIGINT(22) NOT NULL AFTER `course_id`;

ALTER TABLE `tbl_courses_enrollment` ADD CONSTRAINT `tce_tcl_rel` FOREIGN KEY(`course_level_id`) REFERENCES `tbl_course_levels`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

```

#### chang logs : 19/05/2023

```bash

ALTER TABLE `tbl_courses` ADD `short_description` TEXT NULL DEFAULT NULL AFTER `description`;
ALTER TABLE `tbl_tutorial` ADD `order` INT(10) NOT NULL AFTER `description`;

```


#### chang logs : 25/05/2023

```bash

CREATE TABLE `tbl_tasks` (
  `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
  `task_title` tinytext NOT NULL,
  `description` longtext DEFAULT NULL,
  `user_id` BIGINT NOT NULL,
  `role` enum('SUPPORT','ADMIN') NOT NULL DEFAULT 'SUPPORT',
  `file_name` varchar(200) DEFAULT NULL,
  `task_date` datetime DEFAULT NULL,
  `status`  TINYINT(11) NOT NULL,
  `created_by` BIGINT(22) NOT NULL,
  `updated_by` BIGINT(22) NOT NULL,
  `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY(`id`)
) ENGINE = InnoDB;


    
CREATE TABLE `tbl_tasks_template` (
  `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
  `title` tinytext NOT NULL,
  `category` varchar(200) NOT NULL,
  `description` longtext DEFAULT NULL,
  `file` varchar(200) DEFAULT NULL,
  `delta_time` varchar(200) DEFAULT NULL,
  `status`  TINYINT(1) NOT NULL,
  `created_by` BIGINT(22) NOT NULL,
  `updated_by` BIGINT(22) NOT NULL,
  `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY(`id`)
) ENGINE = InnoDB;

ALTER TABLE `tbl_tasks_template` CHANGE `delta_time` `delta_time` TIME NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `tbl_questions` ADD `category` ENUM("COURSE_MODULE","BATCH","BATCH_STUDENT") NOT NULL AFTER `type`;

ALTER TABLE `tbl_courses_enrollment` ADD `category` ENUM("CLUSTER","ONE_ON_ONE") NOT NULL AFTER `batch_id`;


ALTER TABLE `tbl_courses_enrollment` ADD UNIQUE `cenrolement_user_course_unique` (`user_id`, `course_id`,`course_level_id`);

ALTER TABLE `tbl_tasks` ADD `task_type` ENUM("SUPPORT","GENERAL") NOT NULL AFTER `task_title`;

ALTER TABLE `tbl_tasks` CHANGE `user_id` `user_id` BIGINT(20) NULL DEFAULT NULL;

```

#### chang logs : 09/06/2023

```bash

ALTER TABLE `tbl_files` ADD `description` LONGTEXT NULL DEFAULT NULL AFTER `path`;

CREATE TABLE `tbl_country` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(200) NOT NULL,
  `country_code` varchar(50) NOT NULL,
  `course_currency` varchar(50) NOT NULL,
  `status` tinyint(11) NOT NULL,
  `created_by` BIGINT(22) NOT NULL,
  `updated_by` BIGINT(22) NOT NULL,
  `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
   PRIMARY KEY(`id`)
) ENGINE = InnoDB;


CREATE TABLE `tbl_country_pricing` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `course_id` bigint(20) NOT NULL,
  `course_level_id` bigint(20) NOT NULL,
  `country_id` bigint(20) NOT NULL,
  `session_type_id` bigint(20) NOT NULL,
  `cost_per_class` double NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` bigint(22) DEFAULT NULL,
  `updated_by` bigint(22) DEFAULT NULL,
  PRIMARY KEY(`id`)
) ENGINE = InnoDB;

ALTER TABLE `tbl_country_pricing` ADD CONSTRAINT `tcp_tcl_rel` FOREIGN KEY(`course_level_id`) REFERENCES `tbl_course_levels`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `tbl_country_pricing` ADD CONSTRAINT `tcp_tc_rel` FOREIGN KEY(`course_id`) REFERENCES `tbl_courses`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `tbl_country_pricing` ADD CONSTRAINT `tcp_tst_rel` FOREIGN KEY(`session_type_id`) REFERENCES `tbl_session_types`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `tbl_country_pricing` ADD CONSTRAINT `tcp_tcc_rel` FOREIGN KEY(`country_id`) REFERENCES `tbl_country`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;



CREATE TABLE `tbl_task_comments` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `task_id` bigint(20) NOT NULL,
  `task_comment` longtext NOT NULL,
  `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB ;


UPDATE `tbl_session_types` SET `type` = 'Cluster' WHERE `tbl_session_types`.`id` = 2;
UPDATE `tbl_session_types` SET `type` = 'One On One' WHERE `tbl_session_types`.`id` = 1;

ALTER TABLE `tbl_scheduled_classes` ADD `actual_start_time` DATETIME NULL DEFAULT NULL AFTER `end_time`, ADD `actual_end_time` DATETIME NULL DEFAULT NULL AFTER `actual_start_time`;

```



#### chang logs : 09/06/2023

```bash

CREATE TABLE `tbl_payment` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `tnx_id` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `currency` varchar(25) NOT NULL,
  `payment_type` varchar(25) NOT NULL,
  `user_id` bigint(22) NOT NULL,
  `course_id` bigint(22) NOT NULL,
  `course_level_id` bigint(22) NOT NULL,
  `name` bigint(22) NOT NULL,
  `card_number` bigint(20) NOT NULL,
  `card_exp_month` varchar(2) NOT NULL,
  `card_exp_year` varchar(5) NOT NULL,
  `payment_status` varchar(25) NOT NULL,
  `created_by` BIGINT(22) NOT NULL,
  `updated_by` BIGINT(22) NOT NULL,
  `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
   PRIMARY KEY(`id`)
) ENGINE=InnoDB;

ALTER TABLE `tbl_course_homeworks` ADD `user_id` BIGINT(22) NOT NULL AFTER `class_id`, ADD `question_id` BIGINT(22) NOT NULL AFTER `user_id`;


ALTER TABLE
    `tbl_course_homeworks` ADD CONSTRAINT `tchw_tu_rel` FOREIGN KEY(`user_id`) REFERENCES `tbl_users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;


ALTER TABLE `tbl_questions` ADD `file` VARCHAR(200) NULL DEFAULT NULL AFTER `name`;

ALTER TABLE `tbl_files` CHANGE `category` `category` ENUM('TUTORIAL','PROFILE_PIC','HOMEWORK','COURSE_MATERIAL','COURSE_HOMEWORK','AUDIO_ARCHIVE','COURSE_MODULE','BATCH','BATCH_STUDENT','RESUME') NOT NULL ;

```

#### chang logs : 07/07/2023

```bash
ALTER TABLE `tbl_class_reschedule_request` ADD `availability_id` BIGINT(22) NULL DEFAULT NULL AFTER `class_id`;

ALTER TABLE `tbl_class_reschedule_request` ADD `rescheduled_date` DATETIME NULL DEFAULT NULL AFTER `availability_id`;

ALTER TABLE `tbl_user_availability` ADD `class_id` BIGINT(22) NULL DEFAULT NULL AFTER `user_id`;

ALTER TABLE `tbl_class_reschedule_request` CHANGE `status` `status` TINYINT(1) NULL DEFAULT '0' COMMENT '0-pending,1-approved,-1 rejected';

ALTER TABLE `tbl_scheduled_classes` ADD `rescheduled_date` DATETIME NULL DEFAULT NULL AFTER `status`;

ALTER TABLE `tbl_scheduled_classes` ADD `rescheduled_by` BIGINT(22) NULL DEFAULT NULL AFTER `rescheduled_date`;

ALTER TABLE `tbl_scheduled_classes` ADD `teacher_note` LONGTEXT NULL DEFAULT NULL AFTER `description`, ADD `home_work` LONGTEXT NULL DEFAULT NULL AFTER `teacher_note`;

ALTER TABLE `tbl_users` ADD `other_details` JSON NULL DEFAULT NULL AFTER `no_of_referals`, ADD `file_id`BIGINT(22) NULL DEFAULT NULL AFTER `others_details`;

ALTER TABLE `tbl_scheduled_classes` ADD `rescheduled_by_name` VARCHAR(200) NULL DEFAULT NULL AFTER `rescheduled_by`;


```

#### chang logs : 07/07/2023

```bash



CREATE TABLE `tbl_email_templates` (
  `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(220) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB ;

CREATE TABLE `tbl_email_template_variables` (
  `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
  `template_id` int(11) NOT NULL,
  `variable_name` varchar(250)  NULL DEFAULT,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp(),
   PRIMARY KEY (`id`)
) ENGINE=InnoDB ;


DROP TABLE IF EXISTS `tbl_general_settings`;

CREATE TABLE `tbl_general_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `favicon` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `application_name` varchar(255) DEFAULT NULL,
  `admin_email` varchar(225) NOT NULL,
  `email_from` varchar(100) NOT NULL,
  `smtp_host` varchar(255) DEFAULT NULL,
  `smtp_port` int(11) DEFAULT NULL,
  `smtp_user` varchar(50) DEFAULT NULL,
  `smtp_pass` varchar(50) DEFAULT NULL,
  `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;


CREATE TABLE `tbl_question_answer`(
  `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(22) NOT NULL,
  `course_id` bigint(22) DEFAULT NULL,
  `course_level_id` bigint(22) DEFAULT NULL,
  `module_id` bigint(22) DEFAULT NULL,
  `tutorial_id` bigint(22) DEFAULT NULL,
  `question_id` bigint(22) NOT NULL,
  `option_id` bigint(22) NOT NULL,
  `answer` varchar(200) NOT NULL,
  `created_by` bigint(22) NOT NULL,
  `updated_by` bigint(22) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL,
    PRIMARY KEY(`id`)
) ENGINE = InnoDB;


ALTER TABLE `tbl_questions` ADD `tutorial_id` BIGINT(22) NULL DEFAULT NULL AFTER `module_id`;
ALTER TABLE `tbl_course_homeworks` ADD `question_id` BIGINT(22) NULL DEFAULT NULL AFTER `class_id`;

ALTER TABLE
    `tbl_question_answer` ADD CONSTRAINT `tbtu_rel` FOREIGN KEY(`user_id`) REFERENCES `tbl_users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;


ALTER TABLE `tbl_users` CHANGE `status` `status` ENUM('pending','active','inactive','blocked','banned') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

ALTER TABLE `tbl_tasks` CHANGE `task_date` `task_date` DATE NULL DEFAULT NULL;

ALTER TABLE `tbl_tasks` CHANGE `updated_by` `updated_by` BIGINT(22) NULL DEFAULT NULL;

ALTER TABLE `tbl_users` ADD `other_details` LONGTEXT DEFAULT NULL AFTER `no_of_referals`, ADD `availability` LONGTEXT DEFAULT NULL AFTER `other_details`, ADD `performance` LONGTEXT DEFAULT NULL AFTER `availability`;

CREATE TABLE `tbl_course_history` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `course_id` bigint(20) NOT NULL,
  `course_level_id` bigint(20) NOT NULL,
  `category` ENUM('ONE_ON_ONE','CLUSTER') NOT NULL,
  `batch_id` bigint(20) NOT NULL,
  `module_id` bigint(20) NOT NULL,
  `tutorial_id` bigint(20) DEFAULT NULL,
  `status` bigint(20) NOT NULL,
  `created_by` bigint(22) NOT NULL,
  `updated_by` bigint(22) NOT NULL,
  `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB ;


ALTER TABLE `tbl_questions` ADD `course_level_id` BIGINT(22) NULL DEFAULT NULL AFTER `course_id`;


ALTER TABLE `tbl_batches` ADD `order` INT(11) NOT NULL DEFAULT '0' AFTER `status`;

ALTER TABLE `tbl_files` ADD `original_name` VARCHAR(100) NULL DEFAULT NULL AFTER `file_name`;

```

#### chang logs : 01/09/2023

```bash

CREATE TABLE `tbl_course_performance` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `course_id` bigint(22) NOT NULL,
  `course_level_id` bigint(22) NOT NULL,
  `session_type` ENUM('ONE_ON_ONE','CLUSTER') NOT NULL,
  `user_id` bigint(22) NOT NULL COMMENT 'student_id from enroll',
  `status` bigint(22) NOT NULL,
  `created_by` bigint(22) DEFAULT NULL,
  `updated_by` bigint(22) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY(`id`)
) ENGINE=InnoDB;

ALTER TABLE `tbl_course_performance` ADD `enrollment_id` BIGINT(22) NOT NULL AFTER `id`;


ALTER TABLE
    `tbl_course_performance` ADD CONSTRAINT `tcps_rel` FOREIGN KEY(`user_id`) REFERENCES `tbl_users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE
    `tbl_course_performance` ADD CONSTRAINT `tcpc_rel` FOREIGN KEY(`course_id`) REFERENCES `tbl_courses`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
    
ALTER TABLE
    `tbl_course_performance` ADD CONSTRAINT `tcpcl_rel` FOREIGN KEY(`course_level_id`) REFERENCES `tbl_course_levels`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;


CREATE TABLE `tbl_performance_results` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `batch_id` bigint(22) DEFAULT NULL,
  `module_id` bigint(22) DEFAULT NULL,
  `user_id` bigint(22) NOT NULL COMMENT 'teacher_id ',
  `result_type` enum('CWA','COA','') DEFAULT NULL,
  `marks` bigint(22) NOT NULL,
  `certificate_file` varchar(200) NOT NULL,
  `performance_id` bigint(22) NOT NULL,
  `status` bigint(22) NOT NULL DEFAULT '1',
  `created_by` bigint(22) DEFAULT NULL,
  `updated_by` bigint(22) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp(),
   PRIMARY KEY(`id`)
) ENGINE=InnoDB ;


ALTER TABLE
    `tbl_performance_results` ADD CONSTRAINT `tprp_rel` FOREIGN KEY(`performance_id`) REFERENCES `tbl_course_performance`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `tbl_performance_results` ADD `file_id` BIGINT(22) NULL DEFAULT NULL AFTER `certificate_file`; 

ALTER TABLE `tbl_course_levels` ADD `order` INT(11) NOT NULL AFTER `description`;

ALTER TABLE `tbl_users` ADD `profile_file` VARCHAR(200) NULL DEFAULT NULL AFTER `no_of_referals`;

ALTER TABLE `tbl_task_comments` ADD `status` ENUM('','OPEN','PENDDING','RESOLVED','CLOSS') NULL DEFAULT NULL AFTER `task_comment`; 

ALTER TABLE `tbl_task_comments` ADD `created_by` BIGINT(22) NULL DEFAULT NULL AFTER `status`;

ALTER TABLE `tbl_task_comments` ADD `updated_by` BIGINT(22) NULL DEFAULT NULL AFTER `created_by`;



# ALTER TABLE `tbl_course_performance` ADD `session_type` ENUM('ONE_ON_ONE','CLUSTER') NOT NULL AFTER `course_level_id`;
# ALTER TABLE `tbl_performance_results` CHANGE `CWA` `marks` BIGINT(22) NULL DEFAULT NULL;


```

#### chang logs : 09/13/2023

```bash

ALTER TABLE `tbl_country` ADD `created_by` BIGINT(22) NULL DEFAULT NULL AFTER `status`,
 ADD `updated_by` BIGINT(22) NULL DEFAULT NULL AFTER `created_by`, 
 ADD `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `updated_by`,
 ADD `updated_on` DATETIME on update CURRENT_TIMESTAMP NULL DEFAULT NULL AFTER `created_on`;

```