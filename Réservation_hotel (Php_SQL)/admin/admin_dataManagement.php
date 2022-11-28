<?php 	require('inc_connexion.php');
		$title = "Résa";
		$connexion->DOCTYPE_html($title);	

	 				$role->get_navigationPage($id);	
					$date = date('Y-m-d');	?>

<?php				try
					{	
						// Formulaire de création des nouvelles réservations
						$booking->admin_insertReservation($id, $date);	?>

						<h3>Historique des réservations</h3>
						<h4>clientID - clientNom - clientMail - hotel - chambre - pers - deb_resa - fin_resa - création</h4>

<?php					// Visualisation des réservations passées et futures avec possibilités de suppressions	
						$booking->admin_displayFuturBooking($id, $date);	
						$booking->admin_displayPastBooking($id, $date);		

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

