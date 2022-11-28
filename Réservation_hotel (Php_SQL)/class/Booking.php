<?php

	class Booking
	{
		protected $dbh;
		protected static $error;
		const MSG_ERROR_ATTRIBUT = "L'attribut doit être positif ";

		public function __construct(PDO $dbh)
		{
			$this->setDb($dbh);
		}

		public function setDb(PDO $dbh)
		{
			$this->dbh = $dbh;
		}

		public function getCountReservation()
		{	
			$count = 0;
			$sql = 'SELECT chambre.chambre_id
					FROM reservation INNER JOIN chambre INNER JOIN hotel
					WHERE reservation.num_chambre = chambre.num_chambre AND chambre.hotel_id = hotel.hotel_id AND hotel.hotel_nom = reservation.hotel_nom;';
			$stmnt = $this->dbh->prepare($sql);
			$stmnt->execute();
			while($row = $stmnt->fetch(PDO::FETCH_ASSOC))
			{	
				$result[] = $row['chambre_id'];
				$count++;
			}	
			return $count;
		}

		public function getReservation()
		{
			$sql = 'SELECT chambre.chambre_id
					FROM reservation INNER JOIN chambre INNER JOIN hotel
					WHERE reservation.num_chambre = chambre.num_chambre AND chambre.hotel_id = hotel.hotel_id AND hotel.hotel_nom = reservation.hotel_nom;';
			$stmnt = $this->dbh->prepare($sql);
			$stmnt->execute();
			while($row = $stmnt->fetch(PDO::FETCH_ASSOC))
			{	
				$result[] = $row['chambre_id'];
			}	
			return $result;
		}	

		public function client_insertReservation(string $nom, string $mail, $deb_resa, string $fin_resa, string $creation)
		{	
			$_SESSION['client_id'] = $this->displayClient_id($nom, $mail);
			$chambre_id = $this->getReservation();
			for($i = 0 ; $i < count($chambre_id) ; $i++)
			{	
				$this->insertReservation($_SESSION['client_id'], $chambre_id[$i], $deb_resa, $fin_resa, $creation);
			}	
		}	

		public function admin_insertReservation(int $id, string $date)
		{	
			if($id <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}	
			else
			{
				?>
				<h3>Insertion d'une réservation</h3>					

	<?php 		if(isset($_POST['insertion']))
				{
					if(isset($_POST['client_id']) AND isset($_POST['chambre_id']) AND isset($_POST['deb_resa']) AND isset($_POST['fin_resa']))
					{
						$this->insertReservation($_POST['client_id'], $_POST['chambre_id'], $_POST['deb_resa'], $_POST['fin_resa'], $date);				
					}
					else
					{
						echo "Il vous manque une donnée";
					}
				}	?>
				<form action="<?php echo 'admin_dataManagement' . $id . '.php' ?>" method="post">
					Client_id : <input type="text" name="client_id">
					Chambre_id: <input type="text" name="chambre_id">
					Deb_resa : <input type="date" name="deb_resa">
					Fin_resa : <input type="date" name="fin_resa">
					<input type="hidden" name="creation" value="<?php echo $date ?>">
					<input type="submit" name="insertion">
				</form>					
<?php		}		
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}
		}	

		public function insertReservation(int $client, int $chambre, string $deb_resa, string $fin_resa, string $creation)
		{
			if($client <= 0 OR $chambre <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{
				$sql = 'INSERT INTO booking(client_id, chambre_id, deb_resa, fin_resa, creation) VALUES(:client_id, :chambre_id, :deb_resa, :fin_resa, :creation);';		
				$stmnt = $this->dbh->prepare($sql);
				$stmnt->bindParam(':client_id', $client);
				$stmnt->bindParam(':chambre_id', $chambre);
				$stmnt->bindParam(':deb_resa', $deb_resa);
				$stmnt->bindParam(':fin_resa', $fin_resa);
				$stmnt->bindParam(':creation', $creation);				
				$stmnt->execute();				
			}
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}
		}

		public function displayClient_id(string $nom, string $mail)
		{	
			$sql = 'SELECT client_id FROM client 
			WHERE client_nom = :client_nom
			AND client_email = :client_mail ;';
			$stmnt = $this->dbh->prepare($sql);
			$stmnt->bindParam(':client_nom', $nom);
			$stmnt->bindParam(':client_mail', $mail);							
			$stmnt->execute();
			$row = $stmnt->fetch(PDO::FETCH_ASSOC);
			return $row['client_id'];			
		}

		public function client_displayFuturBooking($client, string $date)
		{	?>
					<h4>Réservations à venir :</h4>
					<p>hotel - chambre - arrivée - départ - réservation</p>

		<?php		
					$sql = 'SELECT booking.chambre_id, hotel_nom, num_chambre, deb_resa, fin_resa, creation
					FROM booking 
					INNER JOIN chambre
					INNER JOIN hotel
					WHERE booking.chambre_id = chambre.chambre_id
					AND chambre.hotel_id = hotel.hotel_id
					AND client_id = :client_id
					AND deb_resa >= :thisDate
					ORDER BY deb_resa ASC
					;
					';
					$stmnt = $this->dbh->prepare($sql);
					$stmnt->bindParam(':client_id', $client);	
					$stmnt->bindParam(':thisDate', $date);									
					$stmnt->execute();
					while ($row = $stmnt->fetch(PDO::FETCH_ASSOC))	
					{	?>
						<form action="client_result_reservation.php" method="post">	
			<?php					echo $row['hotel_nom'] . " - ";
									echo "chambre" . $row['num_chambre'] . " - ";
									echo $row['deb_resa'] . " - ";
									echo $row['fin_resa'] . " - ";
									echo $row['creation']; 	?>
							<input type="hidden" name="chambre_id" value=<?php echo $row['chambre_id'] ?>>
							<input type="submit" name="suppressions" value="suppression">
						</form>		<?php		
					} 		

					if(isset($_POST['suppressions']))
					{	
						if(isset($_POST['chambre_id']))
						{
							try
							{
								$this->chambre_deleteBooking($_POST['chambre_id']);									
							}
							catch(Exception $e)
							{
								echo $e->getMessage();
								exit;
							}
						}	
					}		
		}

		public function admin_displayFuturBooking(int $id, string $date)
		{			
			if($id <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{		?>
				<h4>Réservations à venir</h4>

	<?php		if(isset($_POST['suppression']))
				{
					if(isset($_POST['booking']))
					{
						$this->bookingId_deleteBooking($_POST['booking']);			
					}
				}	

						$sql = 'SELECT client.client_id, client.client_nom, client.client_email, hotel.hotel_nom, chambre.chambre_id, chambre.num_chambre, chambre.pers_max, booking.booking_id, booking.deb_resa, booking.fin_resa, booking.creation 
							FROM booking
							INNER JOIN client
							INNER JOIN chambre
							INNER JOIN hotel
							WHERE booking.chambre_id = chambre.chambre_id
							AND chambre.hotel_id = hotel.hotel_id
							AND booking.client_id = client.client_id
							AND deb_resa >= :thisDate
							ORDER BY booking.deb_resa ASC
							;';
						$stmnt = $this->dbh->prepare($sql);
						$stmnt->bindParam(':thisDate', $date);						
						$stmnt->execute();
						while ($row = $stmnt->fetch(PDO::FETCH_ASSOC)) 
						{	?>
							<form action="<?php echo 'admin_dataManagement' . $id . '.php' ?>" method="post">
	<?php					echo "ID : " . $row['client_id'] . " - ";
							echo "Nom : " . $row['client_nom'] . " - ";
							echo "Mail : " . $row['client_email'] . " - ";
							echo $row['hotel_nom'] . " - ";
							echo "Chambre : " . $row['num_chambre'] . " - ";
							echo "Pers : " . $row['pers_max'] . " - ";
							echo $row['deb_resa'] . " - ";
							echo $row['fin_resa'] . " - ";
							echo $row['creation'];	?>
							<input type="hidden" name="booking" value=<?php echo $row['booking_id'] ?>>
								<input type="submit" name="suppression" value="suppression">
							</form>	
	<?php				}					
			}
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}
		}

		public function admin_displayPastBooking(int $id, string $date)
		{			
			if($id <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{	?>
				<h4>Réservations passées</h4>

	<?php		if(isset($_POST['suppression']))
				{
					if(isset($_POST['booking']))
					{
						$this->bookingId_deleteBooking($_POST['booking']);			
					}
				}	

						$sql = 'SELECT client.client_id, client.client_nom, client.client_email, hotel.hotel_nom, chambre.chambre_id, chambre.num_chambre, chambre.pers_max, booking.booking_id, booking.deb_resa, booking.fin_resa, booking.creation 
							FROM booking
							INNER JOIN client
							INNER JOIN chambre
							INNER JOIN hotel
							WHERE booking.chambre_id = chambre.chambre_id
							AND chambre.hotel_id = hotel.hotel_id
							AND booking.client_id = client.client_id
							AND deb_resa < :thisDate
							ORDER BY booking.deb_resa ASC
							;';
						$stmnt = $this->dbh->prepare($sql);
						$stmnt->bindParam(':thisDate', $date);							
						$stmnt->execute();
						while ($row = $stmnt->fetch(PDO::FETCH_ASSOC)) 
						{	?>
							<form action="<?php echo 'admin_dataManagement' . $id . '.php' ?>" method="post">
	<?php					echo "ID : " . $row['client_id'] . " - ";
							echo "Nom : " . $row['client_nom'] . " - ";
							echo "Mail : " . $row['client_email'] . " - ";
							echo $row['hotel_nom'] . " - ";
							echo "Chambre : " . $row['num_chambre'] . " - ";
							echo "Pers : " . $row['pers_max'] . " - ";
							echo $row['deb_resa'] . " - ";
							echo $row['fin_resa'] . " - ";
							echo $row['creation'];	?>
							<input type="hidden" name="booking" value=<?php echo $row['booking_id'] ?>>
								<input type="submit" name="suppression" value="suppression">
							</form>	
	<?php				}					
			}
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}						
		}

		public function client_displayPastBooking($client, string $date)
		{	?>
					<h4>Réservations passées :</h4>
					<p>hotel - chambre - arrivée - départ - réservation</p>

<?php				$sql = 'SELECT hotel_nom, num_chambre, deb_resa, fin_resa, creation
					FROM booking 
					INNER JOIN chambre
					INNER JOIN hotel
					WHERE booking.chambre_id = chambre.chambre_id
					AND chambre.hotel_id = hotel.hotel_id
					AND client_id = :client_id
					AND deb_resa < :thisDate
					ORDER BY deb_resa ASC
					;
					';
					$stmnt = $this->dbh->prepare($sql);
					$stmnt->bindParam(':client_id', $client);					
					$stmnt->bindParam(':thisDate', $date);					
					$stmnt->execute();
					while ($row = $stmnt->fetch(PDO::FETCH_ASSOC))	
					{
						echo $row['hotel_nom'] . " - ";
						echo "chambre" . $row['num_chambre'] . " - ";
						echo $row['deb_resa'] . " - ";
						echo $row['fin_resa'] . " - ";
						echo $row['creation'] . "<br>";
					} 
		}

		public function bookingId_deleteBooking(int $booking)
		{
			if($booking <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{
				$sql = 'DELETE FROM booking WHERE booking_id = :booking_id';
				$stmnt = $this->dbh->prepare($sql);
				$stmnt->bindParam(':booking_id', $booking);					
				$stmnt->execute();		
			}
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}
		}

		public function chambre_deleteBooking(int $chambre)
		{
			if($chambre <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{
				$sql = 'DELETE FROM booking WHERE chambre_id = :chambre_id';
				$stmnt = $this->dbh->prepare($sql);
				$stmnt->bindParam(':chambre_id', $chambre);					
				$stmnt->execute();
				header('location: client_result_reservation.php');				
			}
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}
		}

		public function setError($msg)
		{
			self::$error = $msg;
		}

		public function getError()
		{
			return self::$error;
		}


	}

