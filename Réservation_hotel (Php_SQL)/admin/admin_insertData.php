<?php 	require('inc_connexion.php');
		$title = "Data";
		$connexion->DOCTYPE_html($title);	

		try
		{
	 		$role->get_navigationPage($id);	?>

			<h2>Gestion des hotels</h2>
	<?php 	// Formulaire de création d'hotels
			$hotel->createHotel($id); 
			// Formulaire de suppression d'hotels
			$hotel->deleteHotel($id); 
	?>
			<h2>Gestion des chambres</h2>
	<?php 	// Formulaire de création de chambres
			$chambre->createRoom($id);
			// Formulaire de suppression de chambres
			$chambre->deleteRoom($id); 

			$admin->endConnexion($id);			
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			exit;
		}	?>

			</body>
		</html>
