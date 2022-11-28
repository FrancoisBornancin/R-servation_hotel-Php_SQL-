<?php 	require('inc_connexion.php');

	if($_SESSION['admin_login - ' . $id] != null)
	{	
		$title = "Accueil";
		$connexion->DOCTYPE_html($title);	?>
		<h3>Admin</h3>	
<?php 			
		try
		{	
			// Affiche les pages de navigation en fonction du rôle administrateur
			$role->get_navigationPage($id);	
			// Affiche le bouton de déconnexion
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
<?php
	}
	else
	{
		echo "La session est fermée";	?>
		<a href="admin_login.php">Veuillez vous authentifier</a>	<?php
	}


?>


