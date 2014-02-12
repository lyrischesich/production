<?php

//Wenn dieser View aufgerufen wird, dann existiert die Datenbank noch nicht -> Erstellen

App::uses('DatabaseManager', 'Model');
$dbManager = new DatabaseManager();
$dbManager->createDatabaseStructure();

//Installation einleiten
//header("Location: /Cafeteria/install");
$this->redirect(array('controller' => 'install', 'action' => 'index'));
?>