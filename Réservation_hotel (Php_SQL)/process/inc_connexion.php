<?php
	try
	{
		$dbh = new PDO('mysql:host=localhost;dbname=php_expert_devoir2', 'root', '');		
	}
	catch(Exception $e)
	{
		echo "La connexion à la Bdd ne peut pas se faire";
		exit;
	}
	
	session_start();

	// Toutes les classes sont récupérées et un objet de chaque class est initié ici afin de ne pas avoir à le faire dans les autres fichiers

	require('../class/Admin.php');	
	require('../class/Authentification.php');
	require('../class/Booking.php');
	require('../class/Chambre.php');	
	require('../class/Client.php');	
	require('../class/Connexion.php');
	require('../class/Hotel.php');		
	require('../class/Reservation.php');	
	require('../class/Role.php');
	require('../class/Write_file.php');	

	$admin = new Admin($dbh);		
	$authentification = new Authentification($dbh);
	$booking = new Booking($dbh);
	$chambre = new Chambre($dbh);
	$client = new Client($dbh);
	$connexion = new Connexion();
	$hotel = new Hotel($dbh);
	$reservation = new Reservation($dbh);
	$role = new Role($dbh);
	$write_file = new Write_file($dbh);



