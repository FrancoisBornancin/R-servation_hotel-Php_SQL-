<?php 	require('../process/inc_connexion.php');
		$title = "Login";
		$connexion->DOCTYPE_html($title);	
		$admin = new Admin($dbh);	
	
	// Si le client peut se connecter, il sera redirigé vers la page d'accueil
	// Un index de connexion sera également crée permettant à plusieurs admin de travailler sur la BDD en même temps
		$admin->login();	?>

		</body>
</html>
