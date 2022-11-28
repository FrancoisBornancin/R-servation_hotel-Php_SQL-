<?php

	session_start();

	$dbh = new PDO('mysql:host=localhost;dbname=php_expert_devoir2', 'root', '');

	$sql = 'DELETE FROM reservation;';
	$stmnt = $dbh->prepare($sql);
	$stmnt->execute();

	header('location: ../index.php');


