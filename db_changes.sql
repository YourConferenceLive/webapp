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


