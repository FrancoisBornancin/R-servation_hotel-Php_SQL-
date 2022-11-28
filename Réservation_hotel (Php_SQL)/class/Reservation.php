<?php

	class Reservation
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

		public function insertReservation(int $num_chambre, int $pers_max, string $hotel)
		{
			if($num_chambre <= 0 OR $pers_max <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{
				$sql = 'INSERT INTO reservation(num_chambre, pers_max, hotel_nom) VALUES(:num_chambre, :pers_max, :hotel_nom);';
				$stmnt = $this->dbh->prepare($sql);
				$stmnt->bindParam(':num_chambre', $num_chambre);	
				$stmnt->bindParam(':pers_max', $pers_max);	
				$stmnt->bindParam(':hotel_nom', $hotel);										
				$stmnt->execute();		
			}
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}
		}

		public function displayReservation()
		{
				$sql = 'SELECT num_chambre, pers_max, hotel_nom
				FROM reservation';
				$stmnt = $this->dbh->prepare($sql);
				$stmnt->execute();
				while($row = $stmnt->fetch(PDO::FETCH_ASSOC))
				{	?>
						<form action="client_reservation.php" method="post">
						<p><?php echo $row['hotel_nom']?>  Chambre <?php echo $row['num_chambre']?> ; Personnes max : <?php echo $row['pers_max']  ?>
							<input type="hidden" name="num_chambres" value=<?php echo $row['num_chambre']?>>
							<input type="submit" name="suppression" value="suppression">
						</form>	
			<?php
				} 

				if(isset($_POST['suppression']))
				{
					if(isset($_POST['num_chambres']))
					{
						$this->deleteReservation($_POST['num_chambres']);
						header('location: client_reservation.php');			
					}
				}

				try
				{
					$this->displayTotalReservation();			
				}
				catch(Exception $e)
				{
					echo $e->getMessage();
					exit;
				}
		}

		public function displayTotalReservation()
		{
			$sql = 'SELECT COUNT(num_chambre) AS num_chambre, SUM(pers_max) AS pers_max
					FROM reservation';
			$stmnt = $this->dbh->prepare($sql);
			$stmnt->execute();
			while($row = $stmnt->fetch(PDO::FETCH_ASSOC))
			{	?>
					<p>Total Chambre : <?php echo $row['num_chambre']?> ; Total Personnes : <?php echo $row['pers_max'] ?> </p>
	<?php	}  
		}

		public function displayReservationButton()
		{	?>
			<h3>Réservation : </h3>	
			<form action="client_result_reservation.php" method="post">
				<input type="submit" name="reservation">
			</form>				
<?php	}				

		public function deleteReservation(int $num_chambre)
		{
			if($num_chambre <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{
				$sql = 'DELETE FROM reservation WHERE num_chambre = :num_chambre;';
				$stmnt = $this->dbh->prepare($sql);
				$stmnt->bindParam(':num_chambre', $num_chambre);					
				$stmnt->execute();			
			}
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}
		}

		public function dropReservation()
		{
			$sql = 'DROP TABLE reservation;';
			$stmnt = $this->dbh->prepare($sql);
			$stmnt->execute();			
		}

		public function createReservation()
		{
			$sql = 'CREATE TABLE IF NOT EXISTS reservation (
					num_chambre int(30) NOT NULL,
					pers_max int(255) NOT NULL,
					hotel_nom varchar(255) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3
					;
					';	
			$stmnt = $this->dbh->prepare($sql);
			$stmnt->execute();	
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

