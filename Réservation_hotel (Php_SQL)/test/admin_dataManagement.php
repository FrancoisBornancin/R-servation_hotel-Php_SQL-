<?php 	
		$dbh = new PDO('mysql:host=localhost;dbname=php_expert_devoir2', 'root', '');	
		require('Class_Role.php');
		require('Class_Admin.php');
		require('Class_Booking.php');
		$role = new Role($dbh);
		$admin = new Admin($dbh);
		$booking = new Booking($dbh);
		session_start();

	 				$role->get_navigationPage($id);	
					$date = date('Y-m-d');	?>

					<h3>Historique des réservations</h3>

					<h4>clientID - clientNom - clientMail - hotel - chambre - pers - deb_resa - fin_resa - création</h4>

<?php				$booking->admin_displayFuturBooking($id, $date);	
					$booking->admin_displayPastBooking($id, $date);		
					$booking->admin_insertReservation($id, $date);

					$admin->endConnexion($id);	?>

			</body>
		</html>

