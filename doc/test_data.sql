--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'username','username','email@test.be','email@test.be',1,'owcy4utzzzksc8sck0w4wgkook84cg4','xJXKZOQcmMAwQUX7dDW2rOlE0Wsf8HdlUM8vVur3DkxVw5Nxw2L3XyB+HAXC6WPCnun5WGG5Uu4yuPgC7euPfQ==','2013-07-04 22:27:32',0,0,NULL,NULL,NULL,'a:0:{}',0,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `issue_statuses`
--
LOCK TABLES `issue_statuses` WRITE;
/*!40000 ALTER TABLE `issue_statuses` DISABLE KEYS */;
INSERT INTO `issue_statuses` VALUES (1,'Unassigned');
INSERT INTO `issue_statuses` VALUES (2,'Assigned');
INSERT INTO `issue_statuses` VALUES (3,'In progress');
INSERT INTO `issue_statuses` VALUES (4,'Testing');
INSERT INTO `issue_statuses` VALUES (5,'Closed');
/*!40000 ALTER TABLE `issue_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `issue_priorities`
--
LOCK TABLES `issue_priorities` WRITE;
/*!40000 ALTER TABLE `issue_priorities` DISABLE KEYS */;
INSERT INTO `issue_priorities` VALUES (1,'Normal',0);
INSERT INTO `issue_priorities` VALUES (2,'Blocker',2);
INSERT INTO `issue_priorities` VALUES (3,'Critical',1);
INSERT INTO `issue_priorities` VALUES (4,'Minor',-1);
INSERT INTO `issue_priorities` VALUES (5,'Trivial',-2);
/*!40000 ALTER TABLE `issue_priorities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `issue_types`
--
LOCK TABLES `issue_types` WRITE;
/*!40000 ALTER TABLE `issue_types` DISABLE KEYS */;
INSERT INTO `issue_types` VALUES (1,'Bug');
INSERT INTO `issue_types` VALUES (2,'New feature');
INSERT INTO `issue_types` VALUES (3,'Task');
INSERT INTO `issue_types` VALUES (4,'Documentation');
/*!40000 ALTER TABLE `issue_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `workflows`
--
LOCK TABLES `workflows` WRITE;
/*!40000 ALTER TABLE `workflows` DISABLE KEYS */;
INSERT INTO `workflows` VALUES (1,'Basic');
/*!40000 ALTER TABLE `workflows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `workflow_steps`
--
LOCK TABLES `workflow_steps` WRITE;
/*!40000 ALTER TABLE `workflow_steps` DISABLE KEYS */;
INSERT INTO `workflow_steps` VALUES (1,1,1,0,1,0,0);
INSERT INTO `workflow_steps` VALUES (2,1,2,1,0,0,1);
INSERT INTO `workflow_steps` VALUES (3,1,3,2,0,0,0);
INSERT INTO `workflow_steps` VALUES (4,1,5,3,0,1,0);
/*!40000 ALTER TABLE `workflow_steps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `workflow_step_actions`
--
LOCK TABLES `workflow_step_actions` WRITE;
/*!40000 ALTER TABLE `workflow_step_actions` DISABLE KEYS */;
INSERT INTO `workflow_step_actions` VALUES (1,1,2);
INSERT INTO `workflow_step_actions` VALUES (2,2,1);
INSERT INTO `workflow_step_actions` VALUES (3,2,3);
INSERT INTO `workflow_step_actions` VALUES (4,3,1);
INSERT INTO `workflow_step_actions` VALUES (5,3,2);
INSERT INTO `workflow_step_actions` VALUES (6,3,4);
INSERT INTO `workflow_step_actions` VALUES (7,4,1);
/*!40000 ALTER TABLE `workflow_step_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,1,1,'project','project',NULL);
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `issues`
--

LOCK TABLES `issues` WRITE;
/*!40000 ALTER TABLE `issues` DISABLE KEYS */;
INSERT INTO `issues` VALUES (1,1,NULL,1,1,1,NULL,5,'issue',NULL,'2013-07-04 22:28:01','2013-07-04 22:28:01');
/*!40000 ALTER TABLE `issues` ENABLE KEYS */;
UNLOCK TABLES;
