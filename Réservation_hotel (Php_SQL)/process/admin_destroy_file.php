<?php 	require('inc_connexion.php');
	
	// Si aucun admin n'est connecté, on vide la table de connexion
	$admin->deleteConnexion();

	if($_SESSION['suppression_session'] != null)
	{	
		try
		{	
			// Cible du formulaire de déconnexion d'un "autre" admin pouvant être utilisé par le role Super_admin
			$write_file->destroy_OtherConnexionFiles($_SESSION['destroy'], $_SESSION['suppression_session']);		
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			exit;
		}	
	}
	else
	{
		try
		{
			// Cible du formulaire de déconnexion de n'importe quel admin
			$write_file->destroy_ThisConnexionFiles($_SESSION['destroy']);		
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			exit;
		}	
	}





