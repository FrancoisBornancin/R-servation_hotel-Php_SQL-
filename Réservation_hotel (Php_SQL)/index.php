<?php
	
	session_start();

// Les valeurs de sessions sont initiées sur null car des opérations seront effectuées dans le cas où elles ne seront pas nulles ou null
// Le header permet de rediriger directement le client vers l'accueil.

	$_SESSION['client_id'] = null;
	$_SESSION['hotel'] = null;
	$_SESSION['personne'] = null;
	$_SESSION['chambre'] = null;
	$_SESSION['arrivee'] = null;
	$_SESSION['depart'] = null;
	$_SESSION['nom'] = null;
	$_SESSION['mail'] = null;

	header('location: site/client_accueil.php');