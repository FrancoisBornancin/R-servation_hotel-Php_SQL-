<?php 	
		$dbh = new PDO('mysql:host=localhost;dbname=php_expert_devoir2', 'root', '');	
		require('Class_Role.php');
		require('Class_Admin.php');
		require('Class_Hotel.php');
		require('Class_Chambre.php');
		$role = new Role($dbh);
		$admin = new Admin($dbh);
		$hotel = new Hotel($dbh);
		$chambre = new Chambre($dbh);
		session_start();

 		$role->get_navigationPage($id);	?>

		<h2>Gestion des hotels</h2>
<?php 	$hotel->createHotel($id); 
		$hotel->deleteHotel($id); 
?>
		<h2>Gestion des chambres</h2>
<?php 	$chambre->createRoom($id);
		$chambre->deleteRoom($id); 

		$admin->endConnexion($id);	?>

			</body>
		</html>
