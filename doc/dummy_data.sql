--
-- Dumping data for table `issue_statuses`
--

/*!40000 ALTER TABLE `issue_statuses` DISABLE KEYS */;
INSERT INTO `issue_statuses` VALUES (2,'Assigned');
INSERT INTO `issue_statuses` VALUES (5,'Closed');
INSERT INTO `issue_statuses` VALUES (3,'In progress');
INSERT INTO `issue_statuses` VALUES (4,'Testing');
INSERT INTO `issue_statuses` VALUES (1,'Unassigned');
/*!40000 ALTER TABLE `issue_statuses` ENABLE KEYS */;


--
-- Dumping data for table `projects`
--

/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'Notifier','NOTIFIER','Notifier works as a messaging proxy.');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;

--
-- Dumping data for table `issue_types`
--

/*!40000 ALTER TABLE `issue_types` DISABLE KEYS */;
INSERT INTO `issue_types` VALUES (1,'Bug');
INSERT INTO `issue_types` VALUES (4,'Documentation');
INSERT INTO `issue_types` VALUES (2,'New feature');
INSERT INTO `issue_types` VALUES (3,'Task');
/*!40000 ALTER TABLE `issue_types` ENABLE KEYS */;

--
-- Dumping data for table `issues`
--

/*!40000 ALTER TABLE `issues` DISABLE KEYS */;
INSERT INTO `issues` VALUES (1,1,NULL,1,1,1,'issue','issue description');
INSERT INTO `issues` VALUES (2,1,NULL,1,3,1,'Issue in progress',NULL);
/*!40000 ALTER TABLE `issues` ENABLE KEYS */;

--
-- Dumping data for table `tags`
--

/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (2,'another tag');
INSERT INTO `tags` VALUES (1,'sometag');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;

--
-- Dumping data for table `issue_tags`
--

/*!40000 ALTER TABLE `issue_tags` DISABLE KEYS */;
INSERT INTO `issue_tags` VALUES (1,1);
INSERT INTO `issue_tags` VALUES (1,2);
/*!40000 ALTER TABLE `issue_tags` ENABLE KEYS */;

