<?php 	

	$dbh = new PDO('mysql:host=localhost;dbname=php_expert_devoir2', 'root', '');	
	require('Class_Role.php');
	require('Class_Admin.php');
	$role = new Role($dbh);
	$admin = new Admin($dbh);	

	session_start();

	if($_SESSION['admin_login - ' . $id] != null)
	{	?>
		<!DOCTYPE html>
		<html>
			<head>
				<title>Accueil</title>
				<meta charset="utf-8"></meta>
				<link rel="stylesheet" type="text/css" href="style.css">
			</head>
			<body>
				<h3>Admin</h3>	

<?php 			$role->get_navigationPage($id);	
				$admin->endConnexion($id);	?>

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


