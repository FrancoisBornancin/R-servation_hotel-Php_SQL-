<?php $dbh = new PDO('mysql:host=localhost;dbname=php_expert_devoir2', 'root', ''); 
		session_start();	

		require('../class/Chambre.php');

		$ObjChambre = new Chambre($dbh);	

	$contraintPers = $_SESSION['personne'];
	$contraintChambre = $_SESSION['chambre'];

	if($contraintChambre > 1)
	{
		$ObjChambre->dropAvailableChambreByHotel();
		$ObjChambre->dropPropositionChambre();

		// Créé une Vue SQL récupèrant les chambres disponibles pour l'hotel voulu
		$ObjChambre->createAvailableChambreByHotel('"' . $_SESSION['hotel'] .'"');

		try
		{	
			// Crée la table qui récupèrera les propositions de combinaisons de chambre
			$ObjChambre->createPropositionChambre($contraintChambre);			
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			exit;
		}

		for($i = 1 ; $i < ($contraintChambre + 1) ; $i++)
		{
			$chambre[] = ('chambre' . $i);
		}

		$insert = implode(", ", $chambre);
		$hotel = ", hotel_nom";
		$insert_chambre_hotel = ($insert . $hotel);

		// Récupère les données qui permettront de remplir les propositions de chambre
		$ensemble = $ObjChambre->fillPropositionChambre();

		$index = 0;		
		// Fichier qui s'actualise selon que le nombre de chambre et personnes sélectionnées	
		require('client_sousEnsembleTri.php');				
		// Fichier qui remplit les propositions de chambre en fonction des contraintes
		require('client_insertValue.php');

		// A noter que j'ai essayé créer un algorithme de suppression des  doublons de propositions de chambre mais l'exécution de ce dernier était excessivement chronophage.

	}

	header('location: ../site/client_hotel-chambre.php?hotel='. $_SESSION['hotel'] .'');