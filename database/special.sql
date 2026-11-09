-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for osx10.10 (x86_64)
--
-- Host: localhost    Database: special
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `attendances`
--

DROP TABLE IF EXISTS `attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendances` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) unsigned NOT NULL,
  `date` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'present',
  `arrival_time` time DEFAULT NULL,
  `arrival_state` varchar(255) NOT NULL DEFAULT 'Calm',
  `transport_mode` varchar(255) NOT NULL DEFAULT 'School Bus',
  `bus_route` varchar(255) DEFAULT NULL,
  `transit_attendant` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attendances_student_id_date_unique` (`student_id`,`date`),
  CONSTRAINT `attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendances`
--

LOCK TABLES `attendances` WRITE;
/*!40000 ALTER TABLE `attendances` DISABLE KEYS */;
INSERT INTO `attendances` VALUES (1,1,'2026-11-08','present','09:05:00','Calm','School Bus','Route 3 - Andheri West','Sunita Verma','Boarded bus happily with sensory backpack.','2026-11-09 04:58:21','2026-11-09 04:58:21'),(2,3,'2026-11-05','present','08:45:00','Calm','School Bus','Route 3 - South Belt','Rekha Das','Arrived happily holding his weighted green dinosaur plush.','2026-11-09 05:17:37','2026-11-09 05:17:37'),(3,3,'2026-11-06','present','08:50:00','Anxious','School Bus','Route 3 - South Belt','Rekha Das','Rain noise caused sensory unease; attendant offered noise-cancelling headphones.','2026-11-09 05:17:37','2026-11-09 05:17:37'),(4,3,'2026-11-07','sensory_recovery_day',NULL,'Overstimulated','Parent Drop',NULL,NULL,'Parent called in: scheduled home sensory recovery after medical checkup.','2026-11-09 05:17:37','2026-11-09 05:17:37'),(5,3,'2026-11-08','present','08:40:00','Calm','Parent Drop',NULL,NULL,'Parent walked student into sensory room; high engagement in morning motor circuit.','2026-11-09 05:17:37','2026-11-09 05:17:37'),(6,3,'2026-11-09','present','08:42:00','Calm','School Bus','Route 3 - South Belt','Rekha Das','Morning greeting via high-five. Calm and ready for circle time.','2026-11-09 05:17:37','2026-11-09 05:17:37'),(7,3,'2026-11-10','present','08:45:00','Calm','School Bus','Route 3 - South Belt','Rekha Das','Test attendance automated verification','2026-11-09 05:28:37','2026-11-09 05:28:37');
/*!40000 ALTER TABLE `attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `behavioral_incidents`
--

DROP TABLE IF EXISTS `behavioral_incidents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `behavioral_incidents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) unsigned NOT NULL,
  `incident_date` date NOT NULL,
  `incident_time` time NOT NULL,
  `location` varchar(255) NOT NULL DEFAULT 'Classroom',
  `antecedent` text NOT NULL,
  `behavior_type` varchar(255) NOT NULL,
  `behavior_description` text DEFAULT NULL,
  `intensity` varchar(255) NOT NULL DEFAULT 'Moderate',
  `duration_minutes` smallint(5) unsigned NOT NULL DEFAULT 5,
  `intervention_used` text NOT NULL,
  `post_incident_state` text DEFAULT NULL,
  `logged_by_id` bigint(20) unsigned DEFAULT NULL,
  `notified_parent` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `behavioral_incidents_student_id_foreign` (`student_id`),
  KEY `behavioral_incidents_logged_by_id_foreign` (`logged_by_id`),
  CONSTRAINT `behavioral_incidents_logged_by_id_foreign` FOREIGN KEY (`logged_by_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `behavioral_incidents_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `behavioral_incidents`
--

LOCK TABLES `behavioral_incidents` WRITE;
/*!40000 ALTER TABLE `behavioral_incidents` DISABLE KEYS */;
INSERT INTO `behavioral_incidents` VALUES (1,1,'2026-11-07','11:45:00','Cafeteria Transit Hall','Sudden loud school bell rang while transitioning; sensory overstimulation.','Meltdown & Crying','Covered ears, sat on floor, cried intensely and displayed mild hand flapping distress.','Moderate',4,'Shadow aide applied weighted dinosaur vest, guided to quiet sensory tent.','Settled and calm after 5 minutes.',3,1,'2026-11-09 04:58:21','2026-11-09 04:58:21');
/*!40000 ALTER TABLE `behavioral_incidents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `daily_care_logs`
--

DROP TABLE IF EXISTS `daily_care_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `daily_care_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) unsigned NOT NULL,
  `log_date` date NOT NULL,
  `morning_mood` varchar(255) NOT NULL DEFAULT 'Happy',
  `afternoon_mood` varchar(255) NOT NULL DEFAULT 'Calm',
  `meal_intake` varchar(255) NOT NULL DEFAULT 'Full Meal',
  `meal_notes` varchar(255) DEFAULT NULL,
  `potty_training_log` varchar(255) NOT NULL DEFAULT 'Routine Success',
  `nap_minutes` smallint(5) unsigned NOT NULL DEFAULT 0,
  `meltdown_count` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `meltdown_triggers` varchar(255) DEFAULT NULL,
  `teacher_notes_for_parent` text DEFAULT NULL,
  `logged_by_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `daily_care_logs_student_id_foreign` (`student_id`),
  KEY `daily_care_logs_logged_by_id_foreign` (`logged_by_id`),
  CONSTRAINT `daily_care_logs_logged_by_id_foreign` FOREIGN KEY (`logged_by_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `daily_care_logs_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `daily_care_logs`
--

LOCK TABLES `daily_care_logs` WRITE;
/*!40000 ALTER TABLE `daily_care_logs` DISABLE KEYS */;
INSERT INTO `daily_care_logs` VALUES (1,1,'2026-11-08','Calm','Happy','Full Meal','Ate his whole paratha and sliced cucumber without resistance. Drank 250ml water.','Routine Success',40,0,NULL,'Aarav had a peaceful and productive day! Enjoyed circle time music and clapped along with the group.',3,'2026-11-09 02:58:23','2026-11-09 02:58:23'),(2,1,'2026-11-07','Anxious','Calm','Half Eaten','Ate roasted snack, hesitated with fruit cup due to wet texture.','Prompted Success',30,1,'Loud school bell during transit','Had a 3-minute distress when bell rang; caregiver gave him the weighted dinosaur vest and he settled down smoothly.',3,'2026-11-09 02:58:23','2026-11-09 02:58:23'),(3,2,'2026-11-09','Calm','Happy','Full Meal',NULL,'Routine Success',30,0,NULL,NULL,2,'2026-11-09 03:47:14','2026-11-09 03:47:14'),(4,2,'2026-11-10','Calm','Happy','Full Meal',NULL,'Routine Success',30,0,NULL,NULL,2,'2026-11-09 03:47:22','2026-11-09 03:47:22');
/*!40000 ALTER TABLE `daily_care_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diagnostic_assessments`
--

DROP TABLE IF EXISTS `diagnostic_assessments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `diagnostic_assessments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `assessment_no` varchar(255) NOT NULL,
  `enquiry_id` bigint(20) unsigned DEFAULT NULL,
  `child_name` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `assessment_date` date NOT NULL,
  `assessor_id` bigint(20) unsigned DEFAULT NULL,
  `assessor_name` varchar(255) DEFAULT NULL,
  `cars_score` decimal(4,1) DEFAULT NULL,
  `cars_severity` varchar(255) DEFAULT NULL,
  `isaa_score` decimal(5,1) DEFAULT NULL,
  `primary_diagnosis` varchar(255) NOT NULL,
  `severity_level` varchar(255) DEFAULT NULL,
  `speech_evaluation` text DEFAULT NULL,
  `motor_evaluation` text DEFAULT NULL,
  `sensory_profile` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`sensory_profile`)),
  `behavioral_observations` text DEFAULT NULL,
  `recommendation` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `diagnostic_assessments_assessment_no_unique` (`assessment_no`),
  KEY `diagnostic_assessments_enquiry_id_foreign` (`enquiry_id`),
  KEY `diagnostic_assessments_assessor_id_foreign` (`assessor_id`),
  CONSTRAINT `diagnostic_assessments_assessor_id_foreign` FOREIGN KEY (`assessor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `diagnostic_assessments_enquiry_id_foreign` FOREIGN KEY (`enquiry_id`) REFERENCES `enquiries` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diagnostic_assessments`
--

LOCK TABLES `diagnostic_assessments` WRITE;
/*!40000 ALTER TABLE `diagnostic_assessments` DISABLE KEYS */;
INSERT INTO `diagnostic_assessments` VALUES (1,'DIAG-2026-001',1,'Aarav Gupta','2021-08-09','Male','2026-09-09',2,'Dr. Priya Sharma',34.5,'Mild-to-Moderate Autism',88.0,'Autism Spectrum Disorder (ASD)','Level 2 (Requiring Substantial Support)','Receptive language ~18 months; Expressive language ~14 months. Uses isolated single sounds. No spontaneous sentences.','Mild hypotonia, fair gross motor skills, difficulty with pincer grasp and buttoning.','{\"auditory\":\"Hypersensitive (avoids blenders, drills, loud speakers)\",\"tactile\":\"Aversive to squishy\\/sticky textures (clay, slime)\",\"vestibular\":\"Seeks linear swinging, calms when rocked\",\"proprioceptive\":\"Responds well to deep pressure and joint compressions\"}','Poor eye contact (less than 2 secs), occasional hand flapping when excited, lines up toy cars.','Admit to Early Intervention Special Day Class. Prescribe Speech Therapy 3x/week and Occupational Sensory Therapy 3x/week.','admitted','2026-11-09 02:58:23','2026-11-09 02:58:23'),(2,'DIAG-2026-002',3,'Maya Nair','2020-10-09','Female','2026-11-07',2,'Dr. Priya Sharma',37.0,'Severe Autism',96.5,'Autism Spectrum Disorder (ASD) Non-Verbal','Level 2-3','Completely non-verbal. Strong candidate for PECS Phase 1-2 and AAC Tablet introduction.','Persistent toe walking, poor balance beam performance, requires vestibular regulation.','{\"auditory\":\"Under-responsive (doesn\'t orient to sudden noises)\",\"visual\":\"Fixates on repetitive lights and fans\",\"tactile\":\"Enjoys deep pressure massage\",\"vestibular\":\"Hypo-responsive, loves spinning and bouncing\"}','High energy, repetitive visual stimming, minimal shared attention.','Admission recommended for Junior Bloomers Class with dedicated Shadow Aide support. Start PECS immediately.','completed','2026-11-09 02:58:23','2026-11-09 02:58:23'),(3,'DIAG-2026-003',4,'paban jyoti bhuyan','2026-11-09','Male','2026-11-09',2,NULL,34.0,'Mild-to-Moderate Autism',88.0,'Autism Spectrum Disorder (ASD)','Level 2 (Requiring Substantial Support)','Receptive language ~18 months; Expressive language minimal. Uses isolated sounds. Ready for PECS Phase 1-2.','Mild toe walking, difficulty with bilateral hand coordination. Enjoys swinging.','{\"auditory\":\"Hypersensitive (covers ears with vacuum\\/blender noise)\",\"tactile\":\"Aversion to sticky clay\\/slime; seeks deep pressure hugs\",\"visual\":\"Fixates on spinning fan blades and lights\",\"vestibular\":\"Calms with linear swinging and weighted blanket\"}','Fleeting eye contact (<2 seconds). Hand flapping when excited. Responds to name when paired with visual cue.','Recommend enrollment in Early Intervention Special Class. Prescribe Speech Therapy 3x/week, Occupational Sensory Therapy 3x/week with Shadow Aide support during transition times.','admitted','2026-11-09 03:45:53','2026-11-09 03:46:33'),(4,'DIAG-2026-004',5,'Eyanur Rahman','2023-02-09','Male','2026-11-09',NULL,NULL,34.0,'Mild-to-Moderate Autism',NULL,'Autism Spectrum Disorder Non-Verbal','Level 1 (Requiring Support)','Receptive language ~18 months; Expressive language minimal. Uses isolated sounds. Ready for PECS Phase 1-2.','Mild toe walking, difficulty with bilateral hand coordination. Enjoys swinging.','{\"auditory\":\"Hypersensitive (covers ears with vacuum\\/blender noise)\",\"tactile\":\"Aversion to sticky clay\\/slime; seeks deep pressure hugs\",\"visual\":\"Fixates on spinning fan blades and lights\",\"vestibular\":\"Calms with linear swinging and weighted blanket\"}','Fleeting eye contact (<2 seconds). Hand flapping when excited. Responds to name when paired with visual cue.','Recommend enrollment in Early Intervention Special Class. Prescribe Speech Therapy 3x/week, Occupational Sensory Therapy 3x/week with Shadow Aide support during transition times.','admitted','2026-11-09 05:10:36','2026-11-09 05:12:07'),(5,'DIAG-2026-005',6,'Test Student','2018-02-09','Male','2026-11-09',NULL,NULL,34.0,'Mild-to-Moderate Autism',NULL,'Autism Spectrum Disorder (ASD)','Level 2 (Requiring Substantial Support)','Receptive language ~18 months; Expressive language minimal. Uses isolated sounds. Ready for PECS Phase 1-2.','Mild toe walking, difficulty with bilateral hand coordination. Enjoys swinging.','{\"auditory\":\"Hypersensitive (covers ears with vacuum\\/blender noise)\",\"tactile\":\"Aversion to sticky clay\\/slime; seeks deep pressure hugs\",\"visual\":\"Fixates on spinning fan blades and lights\",\"vestibular\":\"Calms with linear swinging and weighted blanket\"}','Fleeting eye contact (<2 seconds). Hand flapping when excited. Responds to name when paired with visual cue.','Recommend enrollment in Early Intervention Special Class. Prescribe Speech Therapy 3x/week, Occupational Sensory Therapy 3x/week with Shadow Aide support during transition times.','admitted','2026-11-09 05:44:38','2026-11-09 05:45:23');
/*!40000 ALTER TABLE `diagnostic_assessments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enquiries`
--

DROP TABLE IF EXISTS `enquiries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enquiries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `enquiry_no` varchar(255) NOT NULL,
  `child_name` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `parent_name` varchar(255) NOT NULL,
  `relation` varchar(255) NOT NULL DEFAULT 'Parent',
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `referred_by` varchar(255) DEFAULT NULL,
  `primary_concerns` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`primary_concerns`)),
  `notes` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `assessment_scheduled_at` datetime DEFAULT NULL,
  `handled_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `enquiries_enquiry_no_unique` (`enquiry_no`),
  KEY `enquiries_handled_by_foreign` (`handled_by`),
  CONSTRAINT `enquiries_handled_by_foreign` FOREIGN KEY (`handled_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enquiries`
--

LOCK TABLES `enquiries` WRITE;
/*!40000 ALTER TABLE `enquiries` DISABLE KEYS */;
INSERT INTO `enquiries` VALUES (1,'ENQ-2026-001','Aarav Gupta','2021-08-09','Male','Rajesh & Pooja Gupta','Father','+91 98111 22334','parent@specialcare.com','Flat 402, Sunshine Heights, Mumbai','Dr. Kulkarni (Pediatrician)','[\"Speech Delay\",\"No Eye Contact\",\"Repetitive Hand Flapping\",\"Sensory Meltdowns in Malls\"]','Child responds minimally to name call. Uses mother\'s hand as a tool. Does not eat solid/crunchy textures.','admitted','2026-09-09 08:28:23',1,'2026-11-09 02:58:23','2026-11-09 02:58:23'),(2,'ENQ-2026-002','Vivaan Mehra','2022-03-09','Male','Kavita Mehra','Mother','+91 98222 33445','kavita.mehra@gmail.com','12 Rosewood Villas, Mumbai','Play School Principal','[\"Hyperactivity\",\"Auditory Sensitivity\",\"Aggression when routine changes\"]','Covers ears whenever mixer or bell rings. Extremely energetic, difficulty sitting still for more than 2 minutes.','assessment_scheduled','2026-11-11 11:00:23',1,'2026-11-09 02:58:23','2026-11-09 02:58:23'),(3,'ENQ-2026-003','Maya Nair','2020-10-09','Female','Deepak Nair','Father','+91 98333 44556','deepak.nair@example.com','B-301 Palm Grove, Mumbai','Self / Online Search','[\"Non-Verbal Communication\",\"Toe Walking\",\"Sensory Seeking\"]','Likes spinning wheels and watching fans. Excellent visual memory but zero verbal functional speech.','assessed','2026-11-06 08:28:23',1,'2026-11-09 02:58:23','2026-11-09 02:58:23'),(4,'ENQ-2026-004','paban jyoti bhuyan','2026-11-09','Male','Parent 4','Father','+919854209873','zzubizubi@gmail.com','Guwahati, Down Town',NULL,'[\"Speech Delay (Non-Verbal \\/ Few Words)\",\"Poor or Inconsistent Eye Contact\"]',NULL,'admitted',NULL,NULL,'2026-11-09 03:44:51','2026-11-09 03:46:33'),(5,'ENQ-2026-005','Eyanur Rahman','2023-02-09','Male','Parent 4','Father','+917002484119','zzubizubi@gmail.com','01 GMCH',NULL,'[\"Speech Delay (Non-Verbal \\/ Few Words)\"]',NULL,'admitted','2026-11-11 10:30:00',1,'2026-11-09 05:09:18','2026-11-09 05:12:07'),(6,'ENQ-2026-006','Test Student','2018-02-09','Male','Test Parent','Father','+919706785872','notificationsiwd@gmail.com','G.S Road, Christian Basti, Nilomoni Phukan Path',NULL,'[\"Speech Delay (Non-Verbal \\/ Few Words)\",\"Hyperactivity \\/ Inattention\"]',NULL,'admitted','2026-11-11 10:30:00',1,'2026-11-09 05:42:40','2026-11-09 05:45:23');
/*!40000 ALTER TABLE `enquiries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fee_packages`
--

DROP TABLE IF EXISTS `fee_packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fee_packages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `billing_cycle` varchar(255) NOT NULL DEFAULT 'Monthly',
  `sessions_count` smallint(5) unsigned NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee_packages`
--

LOCK TABLES `fee_packages` WRITE;
/*!40000 ALTER TABLE `fee_packages` DISABLE KEYS */;
INSERT INTO `fee_packages` VALUES (1,'Full Day Specialized Schooling & Care','5 days/week special education, shadow aide, meals, sensory room.',18000.00,'Monthly',0,1,'2026-11-09 04:58:21','2026-11-09 04:58:21'),(2,'Speech & OT Integrated Therapy Bundle (12 Sessions)','6 Speech Therapy + 6 Sensory Integration OT sessions.',12000.00,'Monthly',12,1,'2026-11-09 04:58:21','2026-11-09 04:58:21'),(3,'Individual Speech & Language Therapy (Per Session)','1-on-1 45-minute clinical speech & AAC articulation session.',1200.00,'Per Session',1,1,'2026-11-09 05:16:55','2026-11-09 05:16:55'),(4,'Occupational Therapy & Sensory Integration (Per Session)','1-on-1 45-minute sensory diet, fine motor, and vestibular regulation session.',1500.00,'Per Session',1,1,'2026-11-09 05:16:55','2026-11-09 05:16:55'),(5,'Behavioral Intervention / ABA Therapy (Per Session)','Targeted positive behavioral reinforcement and antecedent coping.',1400.00,'Per Session',1,1,'2026-11-09 05:16:55','2026-11-09 05:16:55'),(6,'Half-Day Early Intervention Classroom Tuition','Morning 3-hour batch with shadow teacher assistance and circle time socialization.',10000.00,'Monthly',0,1,'2026-11-09 05:16:55','2026-11-09 05:16:55');
/*!40000 ALTER TABLE `fee_packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `iep_goals`
--

DROP TABLE IF EXISTS `iep_goals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iep_goals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) unsigned NOT NULL,
  `domain` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `baseline` text DEFAULT NULL,
  `target_date` date DEFAULT NULL,
  `progress_percentage` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'in_progress',
  `evaluator_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `iep_goals_student_id_foreign` (`student_id`),
  CONSTRAINT `iep_goals_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iep_goals`
--

LOCK TABLES `iep_goals` WRITE;
/*!40000 ALTER TABLE `iep_goals` DISABLE KEYS */;
INSERT INTO `iep_goals` VALUES (1,1,'Speech & Communication','Functional Requesting using PECS & 2-Word approximations','Aarav will exchange picture cards (PECS Phase 3) to request preferred snacks and items (\"Want Water\", \"Want Car\") with 80% accuracy over 3 consecutive weeks.','Was pulling teacher\'s hand without vocalization or visual cue.','2027-01-09',70,'in_progress','Aarav now independently discriminates between \"Juice\" and \"Biscuit\" cards on the communication board!','2026-11-09 02:58:23','2026-11-09 02:58:23'),(2,1,'Occupational & Sensory','Sensory Modulation & Fine Motor Pincer Grasp','Tolerate 5 minutes of sensory tactile table (finger paint / therapy putty) without distress and pick up 10 small beads using thumb-index pincer grasp.','Refused any contact with sticky textures; displayed defensive withdrawal.','2027-02-09',85,'in_progress','Great breakthrough: Aarav played with dry lentils and medium therapy putty for 6 minutes today without needing calming tools!','2026-11-09 02:58:23','2026-11-09 02:58:23'),(3,1,'Social & Play Skills','Parallel Play and 3-Turn Ball Rolling with Peer','Aarav will participate in rolling a ball back and forth with a classmate for 3 consecutive turns with verbal/visual prompting.','Isolated play only; walked away when peers approached.','2026-12-09',50,'in_progress','Rolls ball twice before losing focus; responds well when music cue is played.','2026-11-09 02:58:23','2026-11-09 02:58:23'),(4,1,'Life Skills (ADL)','Independent Handwashing Routine with Visual Schedule','Complete the 5-step hand washing sequence (Turn tap, Wet hands, Soap, Scrub, Dry) using visual strip with maximum 1 prompt.','Needed full physical assistance (hand-over-hand) at every step.','2026-12-09',90,'in_progress','Mastered turning tap, soaping, and towel drying. Only requires minor prompt for rinsing soap bubbles thoroughly.','2026-11-09 02:58:23','2026-11-09 02:58:23'),(5,2,'Speech & Communication','Functional communication & requesting (PECS & Emerging 2-Word Phrases)','Target spontaneous requests for everyday items with high independence.','Initial baseline established during diagnostic intake.','2027-02-09',15,'in_progress',NULL,'2026-11-09 03:46:33','2026-11-09 03:46:33'),(6,2,'Occupational & Sensory','Sensory regulation & coping with primary triggers','Tolerate classroom sensory stimulus using sensory diet & calming techniques.','Sudden loud bells, fluorescent light flickering, scratchy shirt tags, crowded halls','2027-02-09',20,'in_progress',NULL,'2026-11-09 03:46:33','2026-11-09 03:46:33'),(7,3,'Speech & Communication','Functional communication & requesting (PECS & Emerging 2-Word Phrases)','Target spontaneous requests for everyday items with high independence.','Initial baseline established during diagnostic intake.','2027-02-09',15,'in_progress',NULL,'2026-11-09 05:12:07','2026-11-09 05:12:07'),(8,3,'Occupational & Sensory','Sensory regulation & coping with primary triggers','Tolerate classroom sensory stimulus using sensory diet & calming techniques.','Sudden loud bells, fluorescent light flickering, scratchy shirt tags, crowded halls','2027-02-09',20,'in_progress',NULL,'2026-11-09 05:12:07','2026-11-09 05:12:07'),(9,4,'Speech & Communication','Functional communication & requesting (PECS & Emerging 2-Word Phrases)','Target spontaneous requests for everyday items with high independence.','Initial baseline established during diagnostic intake.','2027-02-09',15,'in_progress',NULL,'2026-11-09 05:45:23','2026-11-09 05:45:23'),(10,4,'Occupational & Sensory','Sensory regulation & coping with primary triggers','Tolerate classroom sensory stimulus using sensory diet & calming techniques.','Sudden loud bells, fluorescent light flickering, scratchy shirt tags, crowded halls','2027-02-09',20,'in_progress',NULL,'2026-11-09 05:45:23','2026-11-09 05:45:23');
/*!40000 ALTER TABLE `iep_goals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `iep_milestones`
--

DROP TABLE IF EXISTS `iep_milestones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iep_milestones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iep_goal_id` bigint(20) unsigned NOT NULL,
  `milestone_title` varchar(255) NOT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT 0,
  `completed_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `iep_milestones_iep_goal_id_foreign` (`iep_goal_id`),
  CONSTRAINT `iep_milestones_iep_goal_id_foreign` FOREIGN KEY (`iep_goal_id`) REFERENCES `iep_goals` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iep_milestones`
--

LOCK TABLES `iep_milestones` WRITE;
/*!40000 ALTER TABLE `iep_milestones` DISABLE KEYS */;
INSERT INTO `iep_milestones` VALUES (1,1,'Phase 1: Physical exchange of single card to trainer',1,'2026-10-19','2026-11-09 02:58:23','2026-11-09 02:58:23'),(2,1,'Phase 2: Traveling distance to communication book',1,'2026-11-02','2026-11-09 02:58:23','2026-11-09 02:58:23'),(3,1,'Phase 3: Picture discrimination between preferred and non-preferred item',0,NULL,'2026-11-09 02:58:23','2026-11-09 02:58:23'),(4,1,'Phase 4: Sentence strip (\"I Want...\")',0,NULL,'2026-11-09 02:58:23','2026-11-09 02:58:23');
/*!40000 ALTER TABLE `iep_milestones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(255) NOT NULL,
  `student_id` bigint(20) unsigned NOT NULL,
  `fee_package_id` bigint(20) unsigned DEFAULT NULL,
  `item_description` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date NOT NULL,
  `paid_date` date DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `transaction_reference` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoices_invoice_no_unique` (`invoice_no`),
  KEY `invoices_student_id_foreign` (`student_id`),
  KEY `invoices_fee_package_id_foreign` (`fee_package_id`),
  CONSTRAINT `invoices_fee_package_id_foreign` FOREIGN KEY (`fee_package_id`) REFERENCES `fee_packages` (`id`) ON DELETE SET NULL,
  CONSTRAINT `invoices_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (1,'INV-2026-001',1,1,'Full Day Specialized Schooling & Care - November 2026',18000.00,'2026-11-01','2026-11-11','2026-11-04','UPI / GPay','UPI/9876543210/AXIS','paid','Paid in full by Rajesh Gupta.','2026-11-09 04:58:21','2026-11-09 04:58:21'),(2,'INV-2026-002',1,2,'Speech & OT Integrated Bundle (12 Sessions) - November 2026',12000.00,'2026-11-01','2026-11-16',NULL,NULL,NULL,'pending','Awaiting payment confirmation.','2026-11-09 04:58:21','2026-11-09 04:58:21'),(3,'INV-2026-003',3,6,'November 2026 Early Intervention Classroom Tuition (Monthly)',10000.00,'2026-11-01','2026-11-07','2026-11-02','UPI / GPay','UPI-REF-99281982','paid','Paid on time via GooglePay by Father.','2026-11-09 05:17:37','2026-11-09 05:17:37'),(4,'INV-2026-004',3,3,'Speech & Language Therapy - 4 Individual Sessions (Per Class ₹1,200)',4800.00,'2026-11-03','2026-11-10','2026-11-04','Cash','RCP-CASH-4021','paid','Cash received at reception desk with printed receipt.','2026-11-09 05:17:37','2026-11-09 05:17:37'),(5,'INV-2026-005',3,4,'Sensory Integration OT (Per Class ₹1,500 x 2 Sessions)',3000.00,'2026-11-08','2026-11-15',NULL,NULL,NULL,'pending','Scheduled for next week sensory gym sessions.','2026-11-09 05:17:37','2026-11-09 05:17:37'),(6,'INV-2026-006',3,NULL,'Test Speech Therapy Session (Per Class)',1200.00,'2026-11-10','2026-11-17',NULL,'UPI / GPay',NULL,'pending','Automated test invoice','2026-11-09 05:28:37','2026-11-09 05:28:37');
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_11_09_082507_add_role_and_details_to_users_table',2),(5,'2026_11_09_082508_create_enquiries_table',2),(6,'2026_11_09_082509_create_diagnostic_assessments_table',2),(7,'2026_11_09_082510_create_students_table',2),(8,'2026_11_09_082511_create_iep_tables',2),(9,'2026_11_09_082512_create_therapy_sessions_table',2),(10,'2026_11_09_082513_create_daily_care_logs_table',2),(11,'2026_11_09_090747_create_attendances_table',3),(12,'2026_11_09_090747_create_behavioral_incidents_table',3),(13,'2026_11_09_090747_create_fee_and_invoices_tables',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('005kiykp82dkzc3reYFIk7V6KFQ93f1yMTgv7ir6',1,'::1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJaMFp1Mk5uczdrSHNFVVkzQ0lKNThzNVpzMkloQ3hqSFJnbGtBajlVIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvbG9jYWxob3N0XC9zcGVjaWFsXC9wdWJsaWNcL3BhcmVudFwvcHJvZ3Jlc3M/c3R1ZGVudF9pZD0xIiwicm91dGUiOiJwYXJlbnQucHJvZ3Jlc3MifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsInBhc3N3b3JkX2hhc2hfd2ViIjoiN2ZmM2JhYTU1N2I4YWUxOGQ1ODdlNDIxMGIyMjM4ZDU0MzA0OWM2MjA5ZWRhN2M3YTI0YWI3ZDJlNzJjZGY4OCJ9',1794223628),('38FQRYsC71MtKaPAQhgdijRDG37tkT5AzAIbrGPN',NULL,'::1','curl/8.7.1','eyJfdG9rZW4iOiJNOFRYSkRNYXdCWGNpTG5zMTl4aGU0aGNNclFvQ0xOTmcxSEVoamhqIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvc3BlY2lhbFwvcHVibGljXC9kaWFnbm9zdGljc1wvY3JlYXRlP2VucXVpcnlfaWQ9NCIsInJvdXRlIjoiZGlhZ25vc3RpY3MuY3JlYXRlIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1794216276),('5uRALDuPVpD1uT2376dYW8w03iHXvTWgo0jVyBQZ',NULL,'::1','curl/8.7.1','eyJfdG9rZW4iOiJkSmpNdm9pTWhuTUg1YjBudDJLVEJVVTdTaElZZW5TZzQxRW5SVzJ1IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794215349),('8IEoTZOJj5V0xaa2MhdzHOS6l7I8Am50QCACH297',1,'127.0.0.1','Symfony','eyJfdG9rZW4iOiJYWTZuWWpVWlhkRnREb0owa1JnZWlJd1dIWDlQdUhKclZsd1E0OHNpIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsInBhc3N3b3JkX2hhc2hfd2ViIjoiN2ZmM2JhYTU1N2I4YWUxOGQ1ODdlNDIxMGIyMjM4ZDU0MzA0OWM2MjA5ZWRhN2M3YTI0YWI3ZDJlNzJjZGY4OCIsInN1Y2Nlc3MiOiJTaWduZWQgaW4gYXMgQWRtaW4gRGlyZWN0b3IgKGFkbWluKSIsIl9mbGFzaCI6eyJuZXciOltdLCJvbGQiOlsic3VjY2VzcyJdfSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvcXVpY2stbG9naW5cL2FkbWluQHNwZWNpYWxjYXJlLmNvbSIsInJvdXRlIjoibG9naW4ucXVpY2sifX0=',1794216569),('BEwEq2WBSYcatcDPEsaj0Tyy335VxIQPnPDHWPWA',NULL,'::1','curl/8.7.1','eyJfdG9rZW4iOiJGY3FOcE5HaG5McFpWdU9wc21aYlhDUWc0NDlWVUpHYWdURlpjYjdkIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvc3BlY2lhbFwvcHVibGljXC9kYXNoYm9hcmQiLCJyb3V0ZSI6ImRhc2hib2FyZCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1794216408),('D7DcAn3hBCtIJJBjRV1vYbNZ787Wf14bWV8Nbm5B',2,'127.0.0.1','Symfony','eyJfdG9rZW4iOiJCUGd0RXdOSEpJZ2d6UGpwNm9KSWpzWWUzcVFDa1BHOHA1UUxiTmExIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjIsInBhc3N3b3JkX2hhc2hfd2ViIjoiMTRhOTFkZDdhMDBhYjc2MmJhNmIzMDIyMTZlMGI3N2RjZDA5ODU5NTI4N2JkMDFkZWI0ZjIzODQwYzA0YmI5YiIsInN1Y2Nlc3MiOiJTaWduZWQgaW4gYXMgRHIuIFByaXlhIFNoYXJtYSAodGhlcmFwaXN0KSIsIl9mbGFzaCI6eyJuZXciOltdLCJvbGQiOlsic3VjY2VzcyJdfSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvcXVpY2stbG9naW5cL3ByaXlhQHNwZWNpYWxjYXJlLmNvbSIsInJvdXRlIjoibG9naW4ucXVpY2sifX0=',1794216569),('DA9iljgmW0NQYDeHchOl2VEk7EFDtAgjAjUG7rBp',NULL,'127.0.0.1','curl/8.7.1','eyJfdG9rZW4iOiJRbGZZRWFiVXR6U1lQQkFPaDhTenhhU0RPeVRsVmZadjdiYUN5dnkxIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794215360),('E2DQoOd9DqLkNPMCtoRDBKfApNGdLoUAAyoOImh1',1,'::1','curl/8.7.1','eyJfdG9rZW4iOiI4cEFVbnlUY0RVSWZrT3BNWFZTb2UzTVBCa3pUVkFGWVJ4TFg3aExSIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsInBhc3N3b3JkX2hhc2hfd2ViIjoiN2ZmM2JhYTU1N2I4YWUxOGQ1ODdlNDIxMGIyMjM4ZDU0MzA0OWM2MjA5ZWRhN2M3YTI0YWI3ZDJlNzJjZGY4OCIsIl9mbGFzaCI6eyJuZXciOltdLCJvbGQiOltdfSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvc3BlY2lhbFwvcHVibGljXC9zdHVkZW50c1wvMz90YWI9YmlsbGluZyIsInJvdXRlIjoic3R1ZGVudHMuc2hvdyJ9fQ==',1794221957),('FO45t35qsuSDbhtAkxjxCF2e6Tsb8HnmTVVPxMcK',1,'127.0.0.1','Symfony','eyJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MSwiX3Rva2VuIjoiRUgwb2hiZHN0UVQxOGw3ZDhqR083MUJUam5QZURndDFZSGI0NUV2cCIsInBhc3N3b3JkX2hhc2hfd2ViIjoiN2ZmM2JhYTU1N2I4YWUxOGQ1ODdlNDIxMGIyMjM4ZDU0MzA0OWM2MjA5ZWRhN2M3YTI0YWI3ZDJlNzJjZGY4OCIsIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2RpYWdub3N0aWNzXC80Iiwicm91dGUiOiJkaWFnbm9zdGljcy5zaG93In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1794221032),('FSXNarW3bi7N3zFvEjuJtTvx9XVT9hlBgbiHhv96',NULL,'::1','curl/8.7.1','eyJfdG9rZW4iOiJDaURvVWxNTFZydkptQTNlZmhvZzN4UUhyaHlvZG91Sm5YSUYxeUwwIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvbG9jYWxob3N0XC9zcGVjaWFsXC9wdWJsaWMifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794216540),('IBwwXrCQy3aB3oKBxkK3q0eEAF8z0m5sqC0LemTw',NULL,'::1','curl/8.7.1','eyJfdG9rZW4iOiI0SmpMV0pNcFZkMm03bGU1YWV4QVZmWWZNVFJ3RUIwRUVxSkM1WUVxIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvc3BlY2lhbFwvcHVibGljXC9lbnF1aXJpZXMiLCJyb3V0ZSI6ImVucXVpcmllcy5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1794214562),('iET6R2A5RrDnDPLwHUihmzg6lgdRH6GFIbQTbvdm',NULL,'::1','curl/8.7.1','eyJfdG9rZW4iOiI0eWpKOTA3V1B4a05oRmN3QlE2UjRIZktSV2t6NTdpOUtMSXIya3pYIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794216539),('jibtTaJsYkloxCaWmiAihzA0JEUIt7hGH3FMOoq2',NULL,'::1','curl/8.7.1','eyJfdG9rZW4iOiIwbG1VWUZ5eHMwN3VjUldmbk1CSW1scGVvSFZuQWFtYW1pandZNllwIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794215360),('OM7vdaoCIcmW4BTc7qqUVUP7TyVcFmsLOypZYAG9',NULL,'::1','curl/8.7.1','eyJfdG9rZW4iOiJLMjVDRldaVE9DMkRHZWZLN1dSV0Y0clhDaGdTVkRKSVZhMXh2OVVXIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvc3BlY2lhbFwvcHVibGljXC9zdHVkZW50cyIsInJvdXRlIjoic3R1ZGVudHMuaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794214563),('PAtmek6pOUcVtcuZlWD9W6JPKooB3RHjAGhU6MUy',6,'127.0.0.1','Symfony','eyJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6NiwiX3Rva2VuIjoiQ21KTVlkUGxlWXlXTzJmOThHMGExWTFXWUdDUTFsRTlrNmJ6dGVWdSIsInBhc3N3b3JkX2hhc2hfd2ViIjoiY2FkMzYxZWZiMDYzNGEyMWQyYWUzNjgwMzBkMzY5MGEyNmY4ZDdhNmU5YTJkYmEwYWNlMzgxODE1ODg0YmRiZiIsIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC9sb2NhbGhvc3RcL3BhcmVudFwvcHJvZ3Jlc3MiLCJyb3V0ZSI6InBhcmVudC5wcm9ncmVzcyJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1794220174),('PcZhtQZrUWGmcD7YrOEpa2jLg9SP1TtFgNLYPlgw',NULL,'::1','curl/8.7.1','eyJfdG9rZW4iOiI5Rll1UlJzQmNGNXpjamJMS1BjU0tuTHJqSFdVa3dlc1Jra2lVekVvIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvc3BlY2lhbFwvcHVibGljXC9wYXJlbnRcL3Byb2dyZXNzIiwicm91dGUiOiJwYXJlbnQucHJvZ3Jlc3MifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794214563),('pSmEvkSPWocrV92iRpbiz2MhDZp8DcIAMQsFus23',NULL,'::1','curl/8.7.1','eyJfdG9rZW4iOiI1aEhrNmdlY0RTVTdHVklSaDFNa0NSQXNxcmwzWTd4cU9HeENFanZvIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvbG9jYWxob3N0XC9zcGVjaWFsXC9wdWJsaWMifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794216540),('ryKc0iLO0IaVuqexAGapBUtqmgKjNzACFH4jcq9e',NULL,'::1','curl/8.7.1','eyJfdG9rZW4iOiJwZTlJbm9TZGhLUVF4THRlNENOb2ltYkdiaG5CSWtVOHpxMkx6R2twIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794216302),('sdfsGc6nROdh8LnZkx6pYZU472dtv8bQufPM5Dng',6,'127.0.0.1','Symfony','eyJfdG9rZW4iOiJTY1VWSkZFQ0ltSmJDU3BWVHdIWFZyN0hmelJPNWR1ZE83WThnNVlRIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjYsInBhc3N3b3JkX2hhc2hfd2ViIjoiY2FkMzYxZWZiMDYzNGEyMWQyYWUzNjgwMzBkMzY5MGEyNmY4ZDdhNmU5YTJkYmEwYWNlMzgxODE1ODg0YmRiZiIsInN1Y2Nlc3MiOiJTaWduZWQgaW4gYXMgUmFqZXNoIEd1cHRhIChQYXJlbnQgUG9ydGFsKSIsIl9mbGFzaCI6eyJuZXciOltdLCJvbGQiOlsic3VjY2VzcyJdfSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvcXVpY2stbG9naW5cL3BhcmVudEBzcGVjaWFsY2FyZS5jb20iLCJyb3V0ZSI6ImxvZ2luLnF1aWNrIn19',1794216569),('U7yqlJEHNZnWyM7SlRUOkJfZKWyY2sxiVsIpfYub',1,'127.0.0.1','curl/8.7.1','eyJfdG9rZW4iOiJHUEJKV1FHSDQ1dUNwOWhGT0h3R2QxTGsxSG5Zd2NYSHhLZlp3cmNCIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsInBhc3N3b3JkX2hhc2hfd2ViIjoiN2ZmM2JhYTU1N2I4YWUxOGQ1ODdlNDIxMGIyMjM4ZDU0MzA0OWM2MjA5ZWRhN2M3YTI0YWI3ZDJlNzJjZGY4OCIsIl9mbGFzaCI6eyJuZXciOltdLCJvbGQiOltdfSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9zdHVkZW50c1wvMyIsInJvdXRlIjoic3R1ZGVudHMuc2hvdyJ9fQ==',1794221703),('ubkSAk9CTglANeRw6HV9LUsO7BQxWi73OjjrWJRn',NULL,'::1','curl/8.7.1','eyJfdG9rZW4iOiJpRElqRVR4ZDUzMWdRc3VaazI4SnF0N0diQTNOWmx3TUdyek5JZVpuIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvbG9jYWxob3N0XC9zcGVjaWFsXC9wdWJsaWMifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794216540),('uFV4qThRt5ZukaBVtk0cuaBgdbP5E6aatScZMw1u',NULL,'::1','curl/8.7.1','eyJfdG9rZW4iOiJOaVA0WGIyTExPem9OV2dOdE9zVkRMRUZEb1VJNUFTanpSMFpaMXlGIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvc3BlY2lhbFwvcHVibGljIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1794214557),('UHz9aP5i9LA4ihIAujE4mqjX1JNF1yXh8EHdLVPd',NULL,'::1','curl/8.7.1','eyJfdG9rZW4iOiJWN2F4Um42RVcxSDVBVXlObzhiN3VEN29oWFBuaUExRkI4RDFKTnZLIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvbG9jYWxob3N0XC9zcGVjaWFsXC9wdWJsaWMifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794216540),('UXf6vGpjh589pC1tFJMwOyEqHr5UST9dU5nvqWVs',NULL,'::1','curl/8.7.1','eyJfdG9rZW4iOiIycE1oM0U1dkdxQXNtUnYyWTg2cWxQZkJWcDhEeFhwNm5kbFc0eWVLIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvc3BlY2lhbFwvcHVibGljXC9kaWFnbm9zdGljcyIsInJvdXRlIjoiZGlhZ25vc3RpY3MuaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794214563),('VfiQtXxJRprCpWZbWRar6XuidvRLo9GDZng0CAxP',NULL,'::1','curl/8.7.1','eyJfdG9rZW4iOiI2d1B0aE1PNE5LNExYOFRWWmFxNmZIanQ2NlhoNjlyWklORWVJQno3IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794215875),('vYt2NXJR5BuMzm8TZSIQEt0XrrBVULK9s7y1JCI1',NULL,'::1','curl/8.7.1','eyJfdG9rZW4iOiJlUkIwektzMkl0Mkt4Z2Z4Rmw0bE4zdlloOFpVZG81U084SlhrSDJ4IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794215937),('WzDRUIJClbERjRw3FimwFXFNU7ehn7owFfJk83YE',1,'127.0.0.1','Symfony','eyJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MSwiX3Rva2VuIjoibk5iNzV5NUhOYkg5Y2d6NnpzNUhUUTVKTGlhOE1vWHQxQjBRRDd0TSIsInBhc3N3b3JkX2hhc2hfd2ViIjoiN2ZmM2JhYTU1N2I4YWUxOGQ1ODdlNDIxMGIyMjM4ZDU0MzA0OWM2MjA5ZWRhN2M3YTI0YWI3ZDJlNzJjZGY4OCIsIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC9sb2NhbGhvc3RcL3BhcmVudFwvcHJvZ3Jlc3M/c3R1ZGVudF9pZD0yIiwicm91dGUiOiJwYXJlbnQucHJvZ3Jlc3MifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794220182),('Xz5F5pAwO3zqEhjCzi67mDCnAruvjs9jVErMVfCu',NULL,'::1','curl/8.7.1','eyJfdG9rZW4iOiJ3VDBaRDZHMVdZR0FyT0xReXhNTmI4elMyOFU0YUVZckhVQ0R1U2JoIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794215876),('yZKIUs0TUip5cAS7cI64LI54mf4k7Nb1s5WXlO90',NULL,'::1','curl/8.7.1','eyJfdG9rZW4iOiIxNTloNVNMOGZZdWhmc0djZkRkaWRGWjk0clh5NEpQc1hHT1F0V1NFIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794216546);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admission_no` varchar(255) NOT NULL,
  `enquiry_id` bigint(20) unsigned DEFAULT NULL,
  `diagnostic_assessment_id` bigint(20) unsigned DEFAULT NULL,
  `parent_user_id` bigint(20) unsigned DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `dob` date NOT NULL,
  `gender` varchar(255) NOT NULL,
  `blood_group` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `admission_date` date NOT NULL,
  `classroom_batch` varchar(255) NOT NULL DEFAULT 'Early Intervention Batch',
  `primary_educator_id` bigint(20) unsigned DEFAULT NULL,
  `shadow_teacher` varchar(255) DEFAULT NULL,
  `primary_diagnosis` varchar(255) NOT NULL,
  `severity_level` varchar(255) DEFAULT NULL,
  `communication_mode` varchar(255) NOT NULL DEFAULT 'Verbal',
  `sensory_triggers` text DEFAULT NULL,
  `calming_methods` text DEFAULT NULL,
  `comfort_item` varchar(255) DEFAULT NULL,
  `food_texture_preferences` text DEFAULT NULL,
  `allergies` text DEFAULT NULL,
  `medical_notes` text DEFAULT NULL,
  `guardian_name` varchar(255) NOT NULL,
  `guardian_relation` varchar(255) NOT NULL DEFAULT 'Mother',
  `guardian_phone` varchar(255) NOT NULL,
  `guardian_email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `emergency_contact_phone` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `students_admission_no_unique` (`admission_no`),
  KEY `students_enquiry_id_foreign` (`enquiry_id`),
  KEY `students_diagnostic_assessment_id_foreign` (`diagnostic_assessment_id`),
  KEY `students_parent_user_id_foreign` (`parent_user_id`),
  KEY `students_primary_educator_id_foreign` (`primary_educator_id`),
  CONSTRAINT `students_diagnostic_assessment_id_foreign` FOREIGN KEY (`diagnostic_assessment_id`) REFERENCES `diagnostic_assessments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `students_enquiry_id_foreign` FOREIGN KEY (`enquiry_id`) REFERENCES `enquiries` (`id`) ON DELETE SET NULL,
  CONSTRAINT `students_parent_user_id_foreign` FOREIGN KEY (`parent_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `students_primary_educator_id_foreign` FOREIGN KEY (`primary_educator_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,'SC-2026-001',1,1,6,'Aarav','Gupta','2021-08-09','Male','B+',NULL,'2026-09-24','Early Intervention - Batch Lotus',3,'Sunita Verma (Caregiver Aide)','Autism Spectrum Disorder (ASD)','Level 2','PECS & Emerging 2-Word Phrases','Sudden loud claps/bells, scratchy clothing tags, bright fluorescent flicker.','Weighted green dino vest, 3-minute linear hammock swing, deep squeeze hug, bubble blowing.','Blue textured sensory teether ring & dinosaur plush','Prefers crispy snacks (dosa, crackers). Rejects mixed gravies/slime foods.','Mild lactose intolerance (almond/soy milk preferred)','No seizures reported. Regular multivitamin supplement.','Rajesh Gupta','Father','+91 98111 22334','parent@specialcare.com','Flat 402, Sunshine Heights, Andheri West, Mumbai','+91 98111 22335 (Mother: Pooja)','active','2026-11-09 02:58:23','2026-11-09 02:58:23'),(2,'SC-2026-002',4,3,7,'paban','jyoti bhuyan','2026-11-09','Male','B+',NULL,'2026-11-09','Junior Bloomers (Age 4-7)',2,'Sunita Verma (Dedicated Aide)','Autism Spectrum Disorder (ASD)','Level 2 (Requiring Substantial Support)','PECS & Emerging 2-Word Phrases','Sudden loud bells, fluorescent light flickering, scratchy shirt tags, crowded halls','Weighted vest, linear hammock swing, deep squeeze hug, bubble blowing, quiet corner','Weighted green dinosaur vest & sensory teether','Prefers crispy snacks. Rejects mixed wet textures.','Mild lactose intolerance (almond milk preferred)','No seizure history. Regular multivitamin.','Parent 4','Father','+919854209873','zzubizubi@gmail.com','Guwahati, Down Town','+91 98111 22335 (Mother: Pooja)','active','2026-11-09 03:46:33','2026-11-09 03:46:33'),(3,'SC-2026-003',5,4,7,'Eyanur','Rahman','2023-02-09','Male','B+',NULL,'2026-11-09','Early Intervention - Batch Lotus',NULL,'Sunita Verma (Dedicated Aide)','Autism Spectrum Disorder Non-Verbal','Level 1 (Requiring Support)','PECS & Emerging 2-Word Phrases','Sudden loud bells, fluorescent light flickering, scratchy shirt tags, crowded halls','Weighted vest, linear hammock swing, deep squeeze hug, bubble blowing, quiet corner','Weighted green dinosaur vest & sensory teether','Prefers crispy snacks. Rejects mixed wet textures.','Mild lactose intolerance (almond milk preferred)','No seizure history. Regular multivitamin.','Parent 4','Father','+917002484119','zzubizubi@gmail.com','01 GMCH','+91 98111 22335 (Mother: Pooja)','active','2026-11-09 05:12:07','2026-11-09 05:12:07'),(4,'SC-2026-004',6,5,8,'Test','Student','2018-02-09','Male','B+',NULL,'2026-11-09','Early Intervention - Batch Lotus',NULL,'Sunita Verma (Dedicated Aide)','Autism Spectrum Disorder (ASD)','Level 2 (Requiring Substantial Support)','PECS & Emerging 2-Word Phrases','Sudden loud bells, fluorescent light flickering, scratchy shirt tags, crowded halls','Weighted vest, linear hammock swing, deep squeeze hug, bubble blowing, quiet corner','Weighted green dinosaur vest & sensory teether','Prefers crispy snacks. Rejects mixed wet textures.','Mild lactose intolerance (almond milk preferred)','No seizure history. Regular multivitamin.','Test Parent','Father','+919706785872','notificationsiwd@gmail.com','G.S Road, Christian Basti, Nilomoni Phukan Path','+91 98111 22335 (Mother: Pooja)','active','2026-11-09 05:45:23','2026-11-09 05:45:23');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `therapy_sessions`
--

DROP TABLE IF EXISTS `therapy_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `therapy_sessions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) unsigned NOT NULL,
  `therapist_id` bigint(20) unsigned DEFAULT NULL,
  `therapist_name` varchar(255) DEFAULT NULL,
  `therapy_type` varchar(255) NOT NULL,
  `session_date` date NOT NULL,
  `duration_minutes` smallint(5) unsigned NOT NULL DEFAULT 45,
  `activities_performed` text DEFAULT NULL,
  `engagement_level` varchar(255) NOT NULL DEFAULT 'Good',
  `clinical_soap_notes` text DEFAULT NULL,
  `parent_summary` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `therapy_sessions_student_id_foreign` (`student_id`),
  KEY `therapy_sessions_therapist_id_foreign` (`therapist_id`),
  CONSTRAINT `therapy_sessions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `therapy_sessions_therapist_id_foreign` FOREIGN KEY (`therapist_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `therapy_sessions`
--

LOCK TABLES `therapy_sessions` WRITE;
/*!40000 ALTER TABLE `therapy_sessions` DISABLE KEYS */;
INSERT INTO `therapy_sessions` VALUES (1,1,4,'Vikram Sen','Speech Therapy','2026-11-08',45,'Oral motor blowing bubbles, PECS discrimination game, syllable imitation (/ba/, /ma/, /pa/).','Excellent','S: Child arrived smiling and eager. O: Successfully pointed to requested picture 8/10 times. Vocalized /pa/ for balloon. A: Significant improvement in vocal imitation. P: Continue Phase 3 PECS with real objects next session.','Aarav did wonderfully today! He used the \"Ball\" picture card twice independently and happily imitated \"Ba-Ba\" while playing with bubbles.','2026-11-09 02:58:23','2026-11-09 02:58:23'),(2,1,5,'Neha Patel','Occupational Therapy','2026-11-07',45,'Suspended platform swing, obstacle balance beam crawl, textured dough bead retrieval, weighted blanket calming.','Good','S: Arrived slightly overwhelmed after transit. O: 10 mins linear swinging organized his nervous system. Pincer grasp exercise: 8/10 success. A: Sensory threshold stabilized quickly. P: Progress to firmer putty.','Aarav loved the sensory swing today! He retrieved 8 hidden marbles from the therapy putty with great finger strength.','2026-11-09 02:58:23','2026-11-09 02:58:23'),(3,2,1,'Admin Director','Speech Therapy','2026-11-09',45,NULL,'Good',NULL,'He said ball twice','2026-11-09 03:47:43','2026-11-09 03:47:43');
/*!40000 ALTER TABLE `therapy_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'staff',
  `phone` varchar(255) DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin Director','admin@specialcare.com','admin','+91 98765 43210','School Administration & SEN Management',1,NULL,'$2y$12$UTTEdNS5WPC0VZD0EaawoO0gJm3pmHKFfC.1nmsO4gr6kQ9x7JBl6',NULL,'2026-11-09 02:58:22','2026-11-09 02:58:22'),(2,'Dr. Priya Sharma','priya@specialcare.com','therapist','+91 98765 11111','Clinical Child Psychologist & Diagnostic Specialist',1,NULL,'$2y$12$WgvP2nbLiZmeqUFtBQb6YeQwwYEKDNFYKwgOXvwTpB7bA84GAUBNm',NULL,'2026-11-09 02:58:22','2026-11-09 02:58:22'),(3,'Ananya Roy','ananya@specialcare.com','educator','+91 98765 22222','Lead Special Educator (Early Intervention)',1,NULL,'$2y$12$7FfMZjw5goCDWrz4OdYDBObKNdS45yO07HyURwvX4kLZuf4T9bvxm',NULL,'2026-11-09 02:58:22','2026-11-09 02:58:22'),(4,'Vikram Sen','vikram@specialcare.com','therapist','+91 98765 33333','Speech & Language Pathologist',1,NULL,'$2y$12$lxQcb0MeSwPLeKuvNrIe7e7BtOGYWjF8lMOD6fSEqttep/Mqb1x0m',NULL,'2026-11-09 02:58:22','2026-11-09 02:58:22'),(5,'Neha Patel','neha@specialcare.com','therapist','+91 98765 44444','Occupational & Sensory Integration Therapist',1,NULL,'$2y$12$aHvvmYZqUdMFYFnMKobn8eBGm6.0TrPgUdTi.kAFy4jMZZaIuXUGG',NULL,'2026-11-09 02:58:23','2026-11-09 02:58:23'),(6,'Rajesh Gupta','parent@specialcare.com','parent','+91 98111 22334',NULL,1,NULL,'$2y$12$e1DVmnMZKWCt9xefUoVq3uUtPQso0eqOi/3Y8RflvDYouQ7qD1CS.',NULL,'2026-11-09 02:58:23','2026-11-09 02:58:23'),(7,'Parent 4','zzubizubi@gmail.com','parent','+919854209873',NULL,1,NULL,'$2y$12$DYRkeiiU5OjslZ.PjIOz/eCjQc79BfbESFxH0zh8.Xkp6grwLguTm',NULL,'2026-11-09 03:46:33','2026-11-09 03:46:33'),(8,'Test Parent','notificationsiwd@gmail.com','parent','+919706785872',NULL,1,NULL,'$2y$12$FbBDsV/Ff17/Kvq8SxlBF.dBuA36X.2uihQ5bRo8fle.pZ9lokNl6',NULL,'2026-11-09 05:45:23','2026-11-09 05:45:23');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-09 17:04:23
