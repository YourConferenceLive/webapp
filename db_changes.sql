ALTER TABLE `user` ADD `credentials` VARCHAR(255) NULL AFTER `password`;
ALTER TABLE `user` ADD `disclosures` TEXT NULL AFTER `credentials`;

ALTER TABLE `sessions` ADD `agenda` TEXT NULL AFTER `description`;

ALTER TABLE `user_project_access` CHANGE `level` `level` ENUM('attendee','moderator','presenter','admin','exhibitor') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `sponsor_booth_admin` DROP `project_id`;
ALTER TABLE `sponsor_booth_admin` ADD UNIQUE `admin_per_booth` (`user_id`, `booth_id`);

ALTER TABLE `sessions` ADD `zoom_link` TEXT NULL DEFAULT NULL AFTER `presenter_embed_code`;

ALTER TABLE `sponsor_booth` ADD `created_on` DATETIME NULL AFTER `level`, ADD `created_by` INT NULL AFTER `created_on`, ADD `updated_on` DATETIME NULL AFTER `created_by`, ADD `updated_by` INT NULL AFTER `updated_on`;

#Rexter - Evaluation Page

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

CREATE TABLE `evaluation` (
                              `id` int(11) NOT NULL,
                              `project_id` int(11) NOT NULL,
                              `name` varchar(555) DEFAULT NULL,
                              `title` text DEFAULT NULL,
                              `description` text DEFAULT NULL,
                              `instruction` text DEFAULT NULL,
                              `confirm_title` text DEFAULT NULL,
                              `confirm_message` text DEFAULT NULL,
                              `success_title` text DEFAULT NULL,
                              `success_message` text DEFAULT NULL,
                              `date_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evaluation`
--

INSERT INTO `evaluation` (`id`, `project_id`, `name`, `title`, `description`, `instruction`, `confirm_title`, `confirm_message`, `success_title`, `success_message`, `date_created`) VALUES
(1, 3, '2021 COS Annual Meeting', 'Evaluation  /  Évaluation', 'Thank you for attending the 2021 COS Annual Meeting and Exhibition. We look forward to your feedback on this educational event. |  Merci d’avoir assisté au  Congrès annuel et exposition 2021 de la SCO. Nous avons hâte de recevoir vos commentaires au sujet de cet événement éducatif.', 'Please consider the meeting’s learning objectives and reflect upon your learning. |<br> <span style=\"color: #4773C5\">  En regard desobjectifs d’apprentissage de la réunion, veuillez réfléchir aux connaissances que vous avez acquises. </span> <br>Rank by the following scale: | <span style=\"color: #4773C5\"> Veuillez coter à l’aide de l’échelle suivante: </span><br>Strongly disagree | <span style=\"color: #4773C5\"> Fortement en désaccord </span> – 1  <br>Disagree |   <span style=\"color: #4773C5\"> En désaccord </span>– 2 <br>Neutral |  <span style=\"color: #4773C5\"> Neutre </span>– 3 <br>Agree |  <span style=\"color: #4773C5\"> D’accord </span>– 4 <br> Strongly agree | <span style=\"color: #4773C5\"> Tout à fait d’accord </span>– 5 <br>', 'Submit Evaluation <br><span style=\'color: #4773C5\'>Soumettre une évaluation</span>', 'You can update this evaluation by evaluating again <br> <span style=\'color:#4773C5\'>Vous pouvez mettre à jour cette évaluation en évaluant à nouveau</span>', 'Evaluation Successfully Saved!<br> <span style=\'color #4773C5\'>Évaluation enregistrée avec succès!</span>', '<p style=\'word-wrap: normal ; text-dark; font-size:14px\'>Thank you for participating in this evaluation and in our virtual meeting. We look forward to seeing you in Halifax, Nova Scotia June 9 – 12 for the 2022 COS Annual Meeting and Exhibition. <br><span style=\'color: #4773C5\'>Merci d’avoir participé à notre assemblée virtuelle. Au plaisir de vous voir à Halifax (N.-É.), du 9 au 12 juin, pour le Congrès annuel et exposition 2022 de la SCO.</span></p>', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `evaluation`
--
ALTER TABLE `evaluation`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `evaluation`
--
ALTER TABLE `evaluation`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_question`
--

CREATE TABLE `evaluation_question` (
                                       `id` int(11) NOT NULL,
                                       `name` text NOT NULL,
                                       `translation` text DEFAULT NULL,
                                       `question_type` varchar(255) DEFAULT NULL,
                                       `question_order` int(11) NOT NULL,
                                       `is_subquestion` tinyint(1) NOT NULL DEFAULT 0,
                                       `evaluation_id` int(11) NOT NULL,
                                       `is_required` tinyint(1) NOT NULL DEFAULT 0,
                                       `date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evaluation_question`
--

INSERT INTO `evaluation_question` (`id`, `name`, `translation`, `question_type`, `question_order`, `is_subquestion`, `evaluation_id`, `is_required`, `date_time`) VALUES
(1, '1) The 2021 COS Annual Meeting met my educational expectations', 'La formation offerte au Congrès annuel 2021 de la SCO a été à la hauteur de mes attentes:', 'radio_opt', 1, 0, 1, 1, NULL),
(2, '2) After attending the 2021 COS Annual Meeting, I am able to:', 'Après avoir assisté au Congrès annuel 2021 de la SCO, je suis en mesure:', NULL, 2, 0, 1, 0, NULL),
(3, 'a. Integrate into my practice, knowledge and skills gained from the sharing of Canadian and international research and scientific studies.', 'D’intégrer à ma pratique des connaissances et des compétences acquises par le partage de recherches et d’études scientifiques canadiennes et internationales', 'radio_opt', 3, 1, 1, 1, NULL),
(4, 'b. Discuss recent advances in the diagnosis and treatment of eye diseases. ', 'De discuter des avancées récentes dans le diagnostic et le traitement des maladies oculaires', 'radio_opt', 4, 1, 1, 1, NULL),
(5, 'c. Compare and contrast core concepts, new advances and clinical experiences.', 'De comparer et contraster des concepts de base, de nouvelles avancées et des expériences cliniques', 'radio_opt', 5, 1, 1, 1, NULL),
(6, 'd. Appraise new and innovative technology and discuss developments in treatment and\r\nmedical devices with industry representatives in the virtual Exhibition Hall.', 'D’évaluer des\r\ntechnologies nouvelles et innovatrices et de discuter des nouveautés dans le traitement et\r\nles dispositifs médicaux avec des représentants de l&#39;industrie au Salon d’exposition virtuel', 'radio_opt', 6, 1, 1, 1, NULL),
(7, '3)	I found the ePoster viewing easy to navigate. ', 'J’ai pu naviguer aisément avec l’outil ePoster pour ', 'radio_opt', 7, 0, 1, 1, NULL),
(8, '4)	I found the virtual conference platform easy to navigate. ', 'J’ai pu naviguer aisément sur la plateforme du congrès virtuel  ', 'radio_opt', 8, 0, 1, 1, NULL),
(9, '5)	What part of the meeting was most valuable to you? Why? ', 'Quel élément du Congrès a été le plus utile pour vous?', 'text_input', 9, 0, 1, 0, NULL),
(10, '6)	What part of the meeting was least valuable to you? Why? ', '| Quel élément du Congrès a été le moins utile pour vous?', 'text_input', 10, 0, 1, 0, NULL),
(11, '7)	What topics would you like to see discussed at a future meeting? ', 'Quels sujets les prochains congrès devraient-ils aborder?', 'text_input', 11, 0, 1, 1, NULL),
(12, '8)	Please comment on your experience with the virtual Exhibition Hall. ', 'S’il vous plaît décrire votre\r\nexpérience à la salle d’exposition virtuel.', 'text_input', 12, 0, 1, 0, NULL),
(13, '9)	Did you engage in a one-on-one chat with an industry representative? Why or why not? ', 'Avez-\r\nvous entretenu une discussion ou clavardé (chat) en privé avec un représentant de l&#39;industrie?\r\nPourquoi?', 'text_input', 13, 0, 1, 0, NULL),
(15, '10)	Do you have any additional comments on the above elements of the 2020 COS Annual Meeting?  ', 'Avez-vous d’autres commentaires à ajouter au sujet des éléments du Congrès annuel 2021 de la SCO énumérés ci-dessus?', 'text_input', 14, 0, 1, 1, NULL),
(16, '11)	Do you think that you would travel to attend the June 2022 COS Annual Meeting in-person in Halifax?', 'Pensez-vous que vous vous déplaceriez pour assister en personne à la réunion de juin 2022 à Halifax?', 'yes_no', 15, 0, 1, 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `evaluation_question`
--
ALTER TABLE `evaluation_question`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `evaluation_question`
--
ALTER TABLE `evaluation_question`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_answer`
--

CREATE TABLE `evaluation_answer` (
                                     `id` int(11) NOT NULL,
                                     `evaluation_id` int(11) NOT NULL,
                                     `question_id` int(11) NOT NULL,
                                     `user_id` int(11) NOT NULL,
                                     `answer` varchar(255) DEFAULT NULL,
                                     `project_id` int(11) NOT NULL,
                                     `date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `evaluation_answer`
--
ALTER TABLE `evaluation_answer`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `evaluation_answer`
--
ALTER TABLE `evaluation_answer`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

# Rexter - Evaluation Page End


# Athul - Session Host Chat
CREATE TABLE `session_host_chat` ( `id` INT NOT NULL AUTO_INCREMENT , `session_id` INT NOT NULL , `chat_from` INT NOT NULL , `chat_text` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `session_host_chat` ADD `date_time` DATETIME NOT NULL AFTER `chat_text`;
ALTER TABLE `session_host_chat` CHANGE `chat_from` `from_id` INT(11) NOT NULL;
ALTER TABLE `session_host_chat` CHANGE `chat_text` `message` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

alter table user add photo varchar(255) null after password;

ALTER TABLE `sessions` ADD `created_by` INT NOT NULL AFTER `end_date_time`, ADD `created_on` DATETIME NOT NULL AFTER `created_by`, ADD `updated_by` INT NOT NULL AFTER `created_on`, ADD `updated_on` DATETIME NOT NULL AFTER `updated_by`;

create table session_keynote_speakers
(
    id int auto_increment
        primary key,
    speaker_id int not null,
    session_id int not null,
    added_on datetime not null,
    added_by int not null
);

create table session_moderators
(
    id int auto_increment
        primary key,
    moderator_id int not null,
    session_id int not null,
    added_on datetime not null,
    added_by int not null
);


# Imran Tariq - ePosters Tables with Data

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `your_conference_live`
--

-- --------------------------------------------------------

--
-- Table structure for table `eposters`
--

DROP TABLE IF EXISTS `eposters`;
CREATE TABLE IF NOT EXISTS `eposters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `track_id` int(11) NOT NULL,
  `control_number` varchar(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('eposter','surgical_video') NOT NULL DEFAULT 'eposter',
  `prize` enum('first prize','second prize','third prize','hot topic') DEFAULT NULL,
  `eposter` varchar(150) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1 = active, 0 = inactive',
  `created_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `eposters`
--

TRUNCATE TABLE `eposters`;
--
-- Dumping data for table `eposters`
--

INSERT INTO `eposters` (`id`, `project_id`, `track_id`, `control_number`, `title`, `type`, `prize`, `eposter`, `video_url`, `status`, `created_datetime`, `updated_datetime`) VALUES
(1, 3, 1, '102', 'Surgical Video Wei Wei Lee 127\r\n', 'surgical_video', NULL, '1101060403_640.jpg', 'https://vimeo.com/532026715', 1, '2021-06-14 15:42:01', '2021-06-15 22:08:29'),
(2, 3, 2, '104', 'March 12 Exhibitors Demonstration', 'surgical_video', NULL, '1082949085_640.jpg', 'https://vimeo.com/522947563', 1, '2021-06-14 15:42:01', '2021-06-15 22:09:11'),
(3, 3, 3, '106', 'Zoom Demo to Exhibitors March 5 B\r\n', 'surgical_video', NULL, '1077654749_640.jpg', 'https://vimeo.com/520357865', 1, '2021-06-14 15:47:31', '2021-06-15 22:07:45'),
(4, 3, 4, '108', 'SS COS2021 Poster', 'eposter', 'hot topic', 'SSS_COS2021_Poster.jpg', NULL, 1, '2021-06-14 15:47:31', '2021-06-16 03:15:01'),
(5, 3, 5, '110', 'Agiliti Kickoff RECAP VIDEO\r\n', 'surgical_video', NULL, '1077649948_640.jpg', 'https://vimeo.com/520352760', 1, '2021-06-14 23:02:03', '2021-06-15 22:06:07'),
(6, 3, 6, '112', 'Sponsor Video Chat\r\n', 'surgical_video', '', '1076239343_640.jpg', 'https://vimeo.com/519707141', 1, '2021-06-14 23:02:03', '2021-06-15 22:10:21'),
(7, 3, 4, '208', 'SS COS2021 Poster', 'eposter', 'second prize', 'SS_COS2021_Poster.jpg', NULL, 1, '2021-06-14 15:47:31', '2021-06-15 22:11:05'),
(8, 3, 4, '210', 'Muzychuk COS Poster', 'eposter', 'third prize', '5_Muzychuk_COS_Poster_2021_06_07_AM.jpg', NULL, 1, '2021-06-14 15:47:31', '2021-06-14 23:33:14'),
(9, 3, 4, '220', 'Preoperative Fasting Catsx COS ePoster', 'eposter', 'first prize', '2021_03_22_Preoperative-Fasting-Catsx-COS-ePoster.jpg', NULL, 1, '2021-06-14 15:47:31', '2021-06-15 22:20:01');

-- --------------------------------------------------------

--
-- Table structure for table `eposter_authors`
--

DROP TABLE IF EXISTS `eposter_authors`;
CREATE TABLE IF NOT EXISTS `eposter_authors` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `eposter_id` int(11) NOT NULL,
  `contact` tinyint(1) DEFAULT NULL COMMENT '1 = can be contacted, 0= cannot be contacted',
  `created_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `eposter_authors`
--

TRUNCATE TABLE `eposter_authors`;
--
-- Dumping data for table `eposter_authors`
--

INSERT INTO `eposter_authors` (`id`, `user_id`, `eposter_id`, `contact`, `created_datetime`, `updated_datetime`) VALUES
(1, 12, 1, 1, '2021-06-14 18:54:10', '2021-06-16 02:37:05'),
(2, 241, 1, NULL, '2021-06-14 18:54:10', '2021-06-14 21:23:42'),
(3, 243, 2, 1, '2021-06-14 18:54:21', '2021-06-16 02:38:46'),
(4, 244, 1, NULL, '2021-06-14 18:54:21', '2021-06-14 21:23:42'),
(5, 244, 2, NULL, '2021-06-14 18:54:26', '2021-06-14 21:23:42'),
(6, 452, 5, 1, '2021-06-14 23:09:42', '2021-06-16 02:38:58'),
(7, 359, 6, 1, '2021-06-14 23:10:04', '2021-06-16 02:39:03'),
(8, 323, 4, 1, '2021-06-14 23:25:11', '2021-06-16 02:38:54'),
(9, 413, 4, NULL, '2021-06-14 23:25:29', '2021-06-14 23:25:29'),
(10, 244, 4, NULL, '2021-06-14 23:25:53', '2021-06-14 23:25:53'),
(11, 244, 3, 1, '2021-06-14 23:26:08', '2021-06-16 02:38:50'),
(12, 245, 2, NULL, '2021-06-14 18:54:26', '2021-06-14 21:23:42'),
(13, 246, 3, NULL, '2021-06-14 23:26:08', '2021-06-14 23:26:08'),
(14, 247, 3, NULL, '2021-06-14 23:26:08', '2021-06-14 23:26:08'),
(15, 254, 5, NULL, '2021-06-14 23:09:42', '2021-06-14 23:24:38'),
(16, 358, 5, NULL, '2021-06-14 23:09:42', '2021-06-14 23:24:38'),
(17, 347, 6, NULL, '2021-06-14 23:10:04', '2021-06-14 23:10:04'),
(18, 470, 6, NULL, '2021-06-14 23:10:04', '2021-06-14 23:10:04'),
(19, 470, 9, 1, '2021-06-14 23:10:04', '2021-06-16 02:39:12'),
(20, 347, 8, 1, '2021-06-14 23:10:04', '2021-06-16 02:39:09'),
(21, 359, 7, 1, '2021-06-14 23:10:04', '2021-06-16 02:39:06'),
(22, 254, 9, NULL, '2021-06-14 23:09:42', '2021-06-14 23:24:38'),
(23, 452, 7, NULL, '2021-06-14 23:09:42', '2021-06-14 23:24:38'),
(24, 244, 8, NULL, '2021-06-14 23:25:53', '2021-06-14 23:25:53');

-- --------------------------------------------------------

--
-- Table structure for table `eposter_comments`
--

DROP TABLE IF EXISTS `eposter_comments`;
CREATE TABLE IF NOT EXISTS `eposter_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `eposter_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` mediumtext NOT NULL,
  `is_deleted` tinyint(1) NOT NULL COMMENT '1 = yes, 0 = no',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = active, 0 = inactive',
  `created_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `eposter_comments`
--

TRUNCATE TABLE `eposter_comments`;
--
-- Dumping data for table `eposter_comments`
--

INSERT INTO `eposter_comments` (`id`, `project_id`, `eposter_id`, `user_id`, `comment`, `is_deleted`, `status`, `created_datetime`, `updated_datetime`) VALUES
(1, 13, 1, 12, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla in commodo urna. Curabitur eget felis eget enim cursus convallis. Etiam at orci et mi pharetra aliquam. Curabitur eu hendrerit odio. Aliquam eget quam consequat, tempus nisl eu, aliquet metus. Nulla commodo erat sapien, ut pellentesque magna varius et. Aenean lobortis metus a neque pretium aliquam ac ut est. Integer commodo nibh quis neque venenatis, at imperdiet arcu efficitur. Vivamus at turpis at turpis tempor sodales.\r\n\r\nFusce vitae lorem facilisis, interdum lectus eget, laoreet elit. Vestibulum vehicula rutrum urna, vitae tristique lectus. Sed vel augue tellus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Integer tempus nisi nulla, eu egestas sem faucibus eget. Ut hendrerit, leo eu mollis lacinia, ipsum ipsum congue sapien, at sodales est tortor eget sem. Nam ullamcorper quam ut metus tincidunt, vel imperdiet nisi volutpat. Vestibulum lacinia purus a velit blandit, eu posuere ipsum pulvinar. Curabitur porta, velit sed elementum dignissim, dui magna blandit augue, sit amet laoreet nunc urna id mi. Curabitur volutpat aliquet nisl a posuere. Quisque vestibulum dignissim augue, in posuere tortor. Duis sed fermentum augue. In eleifend tortor ac vulputate rutrum. Aliquam posuere aliquet sem. Etiam maximus tellus eros, eget interdum lectus consequat at.\r\n\r\nQuisque id eros libero. Vivamus vestibulum eget magna vel suscipit. Vestibulum turpis lectus, accumsan non sodales id, rutrum a ante. Donec in elit sed tortor ultricies volutpat ac porttitor lacus. Sed euismod urna lacus, non consequat velit aliquet nec. Aenean in dui ac diam semper maximus sit amet a diam. Nulla hendrerit tortor libero, non hendrerit lacus egestas vitae. Aliquam purus tellus, laoreet vel mauris id, vulputate tincidunt ligula. Donec nisi odio, dignissim sit amet pharetra a, semper non odio. Maecenas sed lacinia odio. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec dignissim ipsum ut nibh euismod, a consequat augue porta. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam id auctor dui.\r\n\r\nInteger risus metus, faucibus non gravida nec, congue id odio. Ut fermentum vel ligula nec pharetra. Praesent ornare semper sem, nec accumsan ipsum condimentum eu. Nunc arcu ipsum, faucibus sed scelerisque volutpat, iaculis nec sapien. Vestibulum facilisis mattis ligula et imperdiet. Donec ultrices augue in mi sodales, at ornare lorem pulvinar. Morbi pulvinar neque quis feugiat scelerisque. Nam tempor nisl ac nunc bibendum, malesuada vestibulum ligula ultricies. Etiam dapibus purus sed turpis condimentum, in mollis enim gravida. Integer ut est porttitor, ullamcorper orci non, pretium ante. Nulla lobortis pretium maximus. Phasellus laoreet commodo felis quis bibendum.\r\n\r\nVestibulum est tortor, rutrum ac nisi ullamcorper, dictum vestibulum urna. Aenean ac eros ultrices quam aliquam egestas ac eu dolor. Quisque id lacus lorem. Nullam eget sem ac libero pretium sollicitudin ut eget enim. Phasellus pretium turpis non malesuada pellentesque. Vestibulum posuere mattis nunc ut euismod. Pellentesque maximus eros non ipsum imperdiet lacinia.', 0, 1, '2021-06-14 15:26:36', '2021-06-14 21:40:51');

-- --------------------------------------------------------

--
-- Table structure for table `eposter_tracks`
--

DROP TABLE IF EXISTS `eposter_tracks`;
CREATE TABLE IF NOT EXISTS `eposter_tracks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `track` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = active, 0 = inactive',
  `created_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `eposter_tracks`
--

TRUNCATE TABLE `eposter_tracks`;
--
-- Dumping data for table `eposter_tracks`
--

INSERT INTO `eposter_tracks` (`id`, `project_id`, `track`, `status`, `created_datetime`, `updated_datetime`) VALUES
(1, 3, 'Neuro-Ophthalmology', 1, '2021-06-14 18:37:29', '2021-06-14 18:37:29'),
(2, 3, 'Retina', 1, '2021-06-14 18:40:40', '2021-06-14 18:40:40'),
(3, 3, 'Cataract Surgery', 1, '2021-06-14 18:40:40', '2021-06-14 18:40:40'),
(4, 3, 'Glaucoma', 1, '2021-06-14 18:40:40', '2021-06-14 18:40:40'),
(5, 3, 'Cornea, External Disease & Refractive Surgery', 1, '2021-06-14 18:40:40', '2021-06-14 18:40:40'),
(6, 3, 'Global and Public Health Ophthalmology', 1, '2021-06-14 18:40:40', '2021-06-14 18:40:40'),
(7, 3, 'Paediatric Ophthalmology and Strabismus', 1, '2021-06-14 18:40:40', '2021-06-14 18:40:40'),
(8, 3, 'Uveitis', 1, '2021-06-14 18:40:40', '2021-06-14 18:40:40'),
(9, 3, 'Vision Rehabilitation', 1, '2021-06-14 18:40:41', '2021-06-14 18:40:41');
COMMIT;

create table session_questions
(
    id int auto_increment,
    session_id int not null,
    user_id int not null,
    question text null collate utf8_general_ci,
    asked_on datetime not null,
    constraint session_questions_pk
        primary key (id)
);


ALTER TABLE `sponsor_booth`
ADD COLUMN `left_banner` TEXT NULL AFTER `level`,
ADD COLUMN `right_banner` TEXT NULL AFTER `left_banner`,
ADD COLUMN `tv_banner` TEXT NULL AFTER `right_banner`,
ADD COLUMN `left_table` TEXT NULL AFTER `tv_banner`,
ADD COLUMN `right_table` TEXT NULL AFTER `left_table`;

# ####### Adding column bio to user
ALTER TABLE `user` ADD `bio` TEXT NULL DEFAULT NULL AFTER `credentials`;
#

-- Imran Tariq
-- Table structure for table `notes`
-- 18th Jun 2021

DROP TABLE IF EXISTS `notes`;
CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `origin_type` enum('eposter','session') NOT NULL DEFAULT 'eposter',
  `origin_type_id` int(11) DEFAULT NULL COMMENT 'session_id / eposter_id',
  `user_id` int(11) NOT NULL,
  `note_text` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL COMMENT '1 = yes, 0 = no',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = active, 0 = inactive',
  `created_datetime` datetime NOT NULL,
  `updated_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Athul - June 18th 2021
ALTER TABLE `session_moderators` ADD `is_invisible` BOOLEAN NOT NULL DEFAULT FALSE AFTER `session_id`;
ALTER TABLE `sessions` ADD `is_deleted` BOOLEAN NOT NULL DEFAULT FALSE AFTER `updated_on`;


ALTER TABLE `sponsor_booth`
    ADD COLUMN `left_banner_url` TEXT NULL AFTER `right_table`,
ADD COLUMN `right_banner_url` TEXT NULL AFTER `left_banner_url`,
ADD COLUMN `left_table_url` TEXT NULL AFTER `right_banner_url`,
ADD COLUMN `right_table_url` TEXT NULL AFTER `left_table_url`;


-- Athul - June 19th 2021
ALTER TABLE `sessions` ADD `credits` FLOAT NOT NULL DEFAULT '0' AFTER `track`;

-- Imran Tariq
-- Evolution page data
-- 20th June, 2021
UPDATE `evaluation` SET `name` = '2021 COS Annual Meeting',`title` = 'Evaluation  / <span style=\"color: #284050;\">  Évaluation </span>',`description` = 'Thank you for attending the 2021 COS Annual Meeting and Exhibition. We look forward to your feedback on this educational event. <br> <span style=\"color: #284050;\">Merci d’avoir assisté au  Congrès annuel et exposition 2021 de la SCO. Nous avons hâte de recevoir vos commentaires au sujet de cet événement éducatif.</span>',`instruction` = 'Please consider the meeting’s learning objectives and reflect upon your learning. <br> <span style=\"color: #284050\">  En regard desobjectifs d’apprentissage de la réunion, veuillez réfléchir aux connaissances que vous avez acquises. <br> </span> <br>Rank by the following scale: | <span style=\"color: #284050\"> Veuillez coter à l’aide de l’échelle suivante: </span><br><br>Strongly disagree | <span style=\"color: #284050\"> Fortement en désaccord </span> <br>Disagree |   <span style=\"color: #284050\"> En désaccord </span> <br>Neutral |  <span style=\"color: #284050\"> Neutre </span> <br>Agree |  <span style=\"color: #284050\"> D’accord </span><br> Strongly agree | <span style=\"color: #284050\"> Tout à fait d’accord </span><br>',`confirm_title` = 'Submit Evaluation <br><span style=\'color: #284050\'>Soumettre une évaluation</span>',`confirm_message` = 'You can update this evaluation by evaluating again <br> <span style=\'color:#284050\'>Vous pouvez mettre à jour cette évaluation en évaluant à nouveau</span>',`success_title` = 'Evaluation Successfully Saved!<br> <span style=\'color #284050\'>Évaluation enregistrée avec succès!</span>',`success_message` = '<p style=\'word-wrap: normal ; text-dark; font-size:14px\'>Thank you for participating in this evaluation and in our virtual meeting. We look forward to seeing you in Halifax, Nova Scotia June 9 – 12 for the 2022 COS Annual Meeting and Exhibition. <br><span style=\'color: #284050\'>Merci d’avoir participé à notre assemblée virtuelle. Au plaisir de vous voir à Halifax (N.-É.), du 9 au 12 juin, pour le Congrès annuel et exposition 2022 de la SCO.</span></p>',`date_created` = NULL WHERE `evaluation`.`id` = 1;


ALTER TABLE `sponsor_booth`
    ADD COLUMN `hunting_icon` INT NULL AFTER `category_id`;

CREATE TABLE `scavenger_hunt_items` (
`id` INT NOT NULL AUTO_INCREMENT,
`user_id` INT NULL,
`booth_id` INT NULL,
`icon_name` VARCHAR(45) NULL,
`date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`));

-- Imran Tariq
-- Table structure for table `user_credits`
-- 20th June, 2021
DROP TABLE IF EXISTS `user_credits`;
CREATE TABLE IF NOT EXISTS `user_credits` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `origin_type` enum('eposter','session') NOT NULL DEFAULT 'eposter',
  `origin_type_id` int(11) NOT NULL COMMENT 'session_id / eposter_id',
  `user_id` int(11) NOT NULL,
  `credit` float(3,2) NOT NULL,
  `claimed_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_id` (`origin_type`,`origin_type_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ePoster credit field
-- 20th June, 2021
ALTER TABLE `eposters` ADD `credits` FLOAT(3,2) NOT NULL DEFAULT '0.5' AFTER `track_id`;

ALTER TABLE `eposters` CHANGE `credits` `credits` FLOAT(3,2) NOT NULL;


-- My Agenda by Athul
-- 20th June 2021
CREATE TABLE `user_agenda` (
    `id` INT NOT NULL AUTO_INCREMENT ,
    `user_id` INT NOT NULL ,
    `project_id` INT NOT NULL ,
    `session_id` INT NOT NULL ,
    `added_datetime` DATETIME NOT NULL ,
    PRIMARY KEY  (`id`)) ENGINE = InnoDB;


ALTER TABLE `user` ADD `city` VARCHAR(50) NULL AFTER `disclosures`, ADD `country` VARCHAR(50) NULL AFTER `city`, ADD `rcp_number` VARCHAR(100) NULL AFTER `country`;

-- Session types
CREATE TABLE `session_types` ( `id` INT NOT NULL AUTO_INCREMENT , `type_code` VARCHAR(10) NOT NULL , `type_name` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `session_types` ADD UNIQUE(`type_code`);
INSERT INTO `session_types` (`id`, `type_code`, `type_name`) VALUES (NULL, 'gs', 'General Session'), (NULL, 'zm', 'Zoom Meeting');
ALTER TABLE `sessions` ADD `session_type` VARCHAR(10) NOT NULL DEFAULT 'gs' AFTER `track`;



ALTER TABLE `sponsor_booth`
ADD COLUMN `show_group_chat` INT NULL DEFAULT 1 AFTER `right_table_url`;
ALTER TABLE `sponsor_booth`
ADD COLUMN `template` INT NULL DEFAULT 1 AFTER `show_group_chat`;

ALTER TABLE `sponsor_booth`
ADD COLUMN `facebook_link2` VARCHAR(255) NULL AFTER `facebook_link`;

ALTER TABLE `sponsor_booth`
ADD COLUMN `twitter_link2` VARCHAR(255) NULL AFTER `twitter_link`;

ALTER TABLE `sponsor_booth`
ADD COLUMN `special_link` VARCHAR(255) NULL AFTER `template`;

ALTER TABLE `sponsor_booth`
ADD COLUMN `special_link_title` VARCHAR(255) NULL AFTER `special_link`;

-- COS API
ALTER TABLE `project` ADD `api_url` VARCHAR(255) NULL AFTER `timezone`, ADD `api_username` VARCHAR(255) NULL AFTER `api_url`, ADD `api_password` VARCHAR(255) NULL AFTER `api_username`;
ALTER TABLE `user` ADD `name_prefix` VARCHAR(50) NULL AFTER `photo`;
ALTER TABLE `user` ADD `membership_type` VARCHAR(10) NULL AFTER `rcp_number`;
ALTER TABLE `user` ADD `isFromApi` BOOLEAN NOT NULL DEFAULT FALSE AFTER `membership_type`, ADD `IdFromApi` VARCHAR(255) NULL AFTER `isFromApi`;
ALTER TABLE `user` ADD `membership_sub_type` VARCHAR(50) NULL AFTER `membership_type`;



ALTER TABLE `sessions` CHANGE `agenda` `agenda` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `project` ADD `google_analytics_code` VARCHAR(255) NULL AFTER `api_password`;

ALTER TABLE `sponsor_booth` ADD `extra_video_1` VARCHAR(255) NULL AFTER `main_video_description`, ADD `extra_video_2` VARCHAR(255) NULL AFTER `extra_video_1`;


ALTER TABLE `sponsor_booth` ADD COLUMN `double_banner` INT NULL DEFAULT 0 AFTER `extra_video_2`;

-- Imran Tariq
-- Notes table change
-- 23rd June, 2021
ALTER TABLE `notes` CHANGE `note_text` `note_text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;


# Live support chat
--
-- Table structure for table `live_support_chat`
--
CREATE TABLE `live_support_chat` (
    `id` int(11) NOT NULL,
    `project_id` int(11) DEFAULT NULL,
    `chat_from_type` enum('admin','attendee') NOT NULL DEFAULT 'attendee',
    `from_id` int(11) NOT NULL,
    `to_id` int(11) NOT NULL,
    `text` text NOT NULL,
    `isRead` tinyint(1) NOT NULL DEFAULT 0,
    `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `live_support_chat`
    ADD PRIMARY KEY (`id`);
ALTER TABLE `live_support_chat`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
CREATE TABLE `live_support_chat_status` (
    `id` int(11) NOT NULL,
    `project_id` int(11) DEFAULT NULL,
    `name` varchar(20) NOT NULL,
    `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `live_support_chat_status` (`id`, `project_id`, `name`, `status`) VALUES
(1, NULL, 'isOn', 1);

ALTER TABLE `live_support_chat_status`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `live_support_chat_status`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

# End Live support chat


ALTER TABLE `sponsor_booth` ADD `website_link_2` VARCHAR(255) NULL AFTER `website_link`, ADD `website_link_3` VARCHAR(255) NULL AFTER `website_link_2`;


ALTER TABLE `sessions` ADD `external_meeting_link` VARCHAR(255) NULL AFTER `session_type`;
ALTER TABLE `session_types` ADD `is_external` BOOLEAN NOT NULL DEFAULT FALSE AFTER `type_name`;
UPDATE `session_types` SET `is_external` = '1' WHERE `session_types`.`type_code` = 'zm';

CREATE TABLE `lounge_group_chat` ( `id` INT NOT NULL AUTO_INCREMENT , `project_id` INT NOT NULL , `from_id` INT NOT NULL , `message` VARCHAR(255) NOT NULL , `date_time` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `lounge_direct_chat` ( `id` INT NOT NULL AUTO_INCREMENT , `project_id` INT NOT NULL , `from_id` INT NOT NULL , `to_id` INT NOT NULL , `message` VARCHAR(255) NOT NULL , `date_time` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;


