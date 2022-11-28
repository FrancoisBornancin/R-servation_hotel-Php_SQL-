<?php 	require('inc_connexion.php');
		$title = "Admin";
		$connexion->DOCTYPE_html($title);	

 			$role->get_navigationPage($id);	?>

			<h2>Gestion des admin</h2>
<?php 		
			try
			{	
				// Formulaire de création des admin
				$admin->createAdmin($id);	
				// Formulaire de suppression des admin
				$admin->deleteAdmin($id);	
				// Formulaire de visualisation des connections et de déconnexion des admin
				$admin->displayAdminConnexion($id);	

				$admin->endConnexion($id);				
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
				exit;
			}
?>
			</body>
		</html>

