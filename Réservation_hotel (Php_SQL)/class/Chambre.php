<?php

	class Chambre
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

		public function dropAvailableChambre()
		{
			$sql = 'DROP VIEW countchambre;' ; 
			$stmnt = $this->dbh->prepare($sql);
			$stmnt->execute();
		}

		public function dropAvailableChambreByHotel()
		{
			$sql = 'DROP VIEW selectchambre;' ; 
			$stmnt = $this->dbh->prepare($sql);
			$stmnt->execute();
		}

		public function dropPropositionChambre()
		{
			$sql = 'DROP TABLE couplechambre;' ; 
			$stmnt = $this->dbh->prepare($sql);
			$stmnt->execute();
		}

		public function dropRoomsNotYetSelected()
		{
			$sql = 'DROP VIEW hotelchambre';
			$stmnt = $this->dbh->prepare($sql);
			$stmnt->execute();
		}

		public function deleteRoom(int $id)
		{	
			if($id <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}	
			else
			{	?>
				<h3>Suppression d'une chambre</h3>

	<?php 		if(isset($_POST['suppression_chambre']))
				{
					if(isset($_POST['chambres']))
					{
						$sql = 'DELETE FROM chambre WHERE chambre_id = :chambre_id';
						$stmnt = $this->dbh->prepare($sql);
						$stmnt->bindParam(':chambre_id', $_POST['chambres']);							
						$stmnt->execute();

						$sql = 'ALTER TABLE chambre AUTO_INCREMENT = 1;';
						$stmnt = $this->dbh->prepare($sql);
						$stmnt->execute();	
					}
				}	?>

						<form action="<?php echo 'admin_insertData' . $id . '.php' ?>" method="post">
							<label>Chambres : </label>
								<select name="chambres">
				<?php				$sql = 'SELECT *
									FROM chambre
									ORDER BY hotel_id ASC, num_chambre ASC
									;
									';
									$stmnt = $this->dbh->prepare($sql);
									$stmnt->execute();
									while ($row = $stmnt->fetch(PDO::FETCH_ASSOC)) 
									{			
										?>
									<option value="<?php echo $row['chambre_id'] ?>">
										<?php echo "chambre_id : " . $row['chambre_id'] . " - " .
												   "num_chambre : " . $row['num_chambre'] . " - " . 
												   "pers_max : " . $row['pers_max'] . " - " .
												   "hotel_id : " . $row['hotel_id']?>
									 </option>
				<?php				}	?>
								</select>
							<input type="submit" name="suppression_chambre">
						</form>				
<?php		}		
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}
		}


		public function createRoom(int $id)
		{	
			if($id <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}		
			else
			{	?>
				<h3>Création d'une chambre</h3>

	<?php		if(isset($_POST['insertion_chambre']))
				{
					if(isset($_POST['num_chambre']) AND isset($_POST['pers_max']) AND isset($_POST['hotel_id']))
					{
						$sql = 'INSERT INTO chambre(num_chambre, pers_max, hotel_id) VALUES(:num_chambre, :pers_max, :hotel_id);';
						$stmnt = $this->dbh->prepare($sql);
						$stmnt->bindParam(':num_chambre', $_POST['num_chambre']);
						$stmnt->bindParam(':pers_max', $_POST['pers_max']);
						$stmnt->bindParam(':hotel_id', $_POST['hotel_id']);							
						$stmnt->execute();
					}
				}	?>

				<form action="<?php echo 'admin_insertData' . $id . '.php' ?>" method="post">
					Num_chambre : <input type="text" name="num_chambre">
					Pers_max : <input type="text" name="pers_max">
					<label>Hotel ID : </label>
						<select name="hotel_id">
		<?php				$sql = 'SELECT DISTINCT hotel_id
							FROM hotel
							;
							';
							$stmnt = $this->dbh->prepare($sql);
							$stmnt->execute();
							while ($row = $stmnt->fetch(PDO::FETCH_ASSOC)) 
							{			
								?>
							<option value="<?php echo $row['hotel_id'] ?>">
								<?php echo $row['hotel_id'] ?>
							 </option>
		<?php				}	?>
						</select>
					<input type="submit" name="insertion_chambre">
				</form>					
<?php		}	
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}
		}


		public function createAvailableChambre(string $ville, string $arrivee, string $depart)
		{
			$sql = 'CREATE VIEW countchambre AS
					SELECT chambre_id, num_chambre, pers_max, hotel_nom, chambre.hotel_id AS hotel_id
				    FROM chambre
				    INNER JOIN hotel
				    WHERE chambre.hotel_id = hotel.hotel_id
	            	AND hotel_ville = :ville
				EXCEPT
				    (SELECT booking.chambre_id, num_chambre, chambre.pers_max, hotel.hotel_nom, chambre.hotel_id AS hotel_id
				    FROM booking
				    INNER JOIN chambre
				    INNER JOIN hotel
				    	WHERE booking.chambre_id = chambre.chambre_id
				     	AND chambre.hotel_id = hotel.hotel_id
					 	AND ((:arrivee <= deb_resa   AND :arrivee < fin_resa)
					 		AND (:depart > deb_resa AND :depart <= fin_resa))
					 	OR  ((:arrivee > deb_resa AND :arrivee < fin_resa)
					         AND(:depart > deb_resa AND :depart < fin_resa))
					 	OR	((:arrivee >= deb_resa AND :arrivee < fin_resa)
					         AND(:depart > deb_resa AND :depart >= fin_resa))
				     	OR	((:arrivee < deb_resa AND :arrivee < fin_resa)
				             AND(:depart > deb_resa AND :depart > fin_resa))
				        )
                EXCEPT	
                (SELECT chambre.chambre_id, reservation.num_chambre, reservation.pers_max, reservation.hotel_nom, chambre.hotel_id AS hotel_id
                 FROM reservation
                 INNER JOIN chambre
                 WHERE chambre.num_chambre = reservation.num_chambre
                 );' ; 
				$stmnt = $this->dbh->prepare($sql);
				$stmnt->bindParam(':ville', $ville);
				$stmnt->bindParam(':arrivee', $arrivee);
				$stmnt->bindParam(':depart', $depart);								
				$stmnt->execute();
		}

		public function createAvailableChambreByHotel(string $hotel)
		{
			$sql = 'CREATE VIEW selectchambre AS 
					SELECT num_chambre, pers_max, hotel_nom
					FROM countchambre
					WHERE hotel_nom = ' . $hotel . '
					;' ; 
			$stmnt = $this->dbh->prepare($sql);
			$stmnt->execute();
		}

		public function createPropositionChambre(int $contraintChambre)
		{
			if($contraintChambre <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{
				$sql = 'CREATE TABLE IF NOT EXISTS couplechambre
						(chambre1 varchar(255) NOT NULL);' ; 
				$stmnt = $this->dbh->prepare($sql);
				$stmnt->execute();

				for($i = 2 ; $i < ($contraintChambre + 1) ; $i++)
				{
					$chambres = ('chambre' . $i); 
					$sql = 'ALTER TABLE couplechambre ADD ' . $chambres . ' varchar(255) NOT NULL;' ; 
					$stmnt = $this->dbh->prepare($sql);					
					$stmnt->execute();
				}

					$sql = 'ALTER TABLE couplechambre ADD hotel_nom varchar(255) NOT NULL;' ; 
					$stmnt = $this->dbh->prepare($sql);
					$stmnt->execute();			
			}
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}
		}

		public function createRoomsNotYetSelected_OneChambre(string $hotel, int $personne, string $arrivee, string $depart)
		{
			if($personne <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{
					$sql = 'CREATE VIEW hotelchambre AS
					SELECT chambre_id, num_chambre, pers_max, hotel_nom
					FROM chambre
					INNER JOIN hotel
					WHERE chambre.hotel_id = hotel.hotel_id
		            AND hotel_nom = :hotel_nom
					AND pers_max >= :nbrPers
					EXCEPT
					(SELECT booking.chambre_id, num_chambre, chambre.pers_max, hotel_nom
					FROM booking
					INNER JOIN chambre
					INNER JOIN hotel
					 	WHERE chambre.hotel_id = hotel.hotel_id
						AND booking.chambre_id = chambre.chambre_id
					 	AND ((:arrivee <= deb_resa   AND :arrivee < fin_resa)
					 		AND (:depart > deb_resa AND :depart <= fin_resa))
					 	OR  ((:arrivee > deb_resa AND :arrivee < fin_resa)
					         AND(:depart > deb_resa AND :depart < fin_resa))
					 	OR	((:arrivee >= deb_resa AND :arrivee < fin_resa)
					         AND(:depart > deb_resa AND :depart >= fin_resa))
				     	OR	((:arrivee < deb_resa AND :arrivee < fin_resa)
				             AND(:depart > deb_resa AND :depart > fin_resa))
					)
	                EXCEPT	
	                (SELECT chambre.chambre_id, reservation.num_chambre, reservation.pers_max, reservation.hotel_nom
	                 FROM reservation
	                 INNER JOIN chambre
	                 WHERE chambre.num_chambre = reservation.num_chambre
	                 );
					';
					$stmnt = $this->dbh->prepare($sql);
					$stmnt->bindParam(':hotel_nom', $hotel);	
					$stmnt->bindParam(':nbrPers', $personne);	
					$stmnt->bindParam(':arrivee', $arrivee);	
					$stmnt->bindParam(':depart', $depart);						
					$stmnt->execute();			
			}
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}
		}

		public function createRoomsNotYetSelected_MoreChambre(string $hotel, int $personne, string $arrivee, string $depart)
		{
			if($personne <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{
				$sql = 'CREATE VIEW hotelchambre AS
				SELECT chambre_id, num_chambre, pers_max, hotel_nom
				FROM chambre
				INNER JOIN hotel
				WHERE chambre.hotel_id = hotel.hotel_id
	            AND hotel_nom = :hotel_nom
				EXCEPT
				(SELECT booking.chambre_id, num_chambre, chambre.pers_max, hotel_nom
				FROM booking
				INNER JOIN chambre
				INNER JOIN hotel
				 	WHERE chambre.hotel_id = hotel.hotel_id
					AND booking.chambre_id = chambre.chambre_id
				 	AND ((:arrivee <= deb_resa   AND :arrivee < fin_resa)
				 		AND (:depart > deb_resa AND :depart <= fin_resa))
				 	OR  ((:arrivee > deb_resa AND :arrivee < fin_resa)
				         AND(:depart > deb_resa AND :depart < fin_resa))
				 	OR	((:arrivee >= deb_resa AND :arrivee < fin_resa)
				         AND(:depart > deb_resa AND :depart >= fin_resa))
			     	OR	((:arrivee < deb_resa AND :arrivee < fin_resa)
			             AND(:depart > deb_resa AND :depart > fin_resa))
				)
                EXCEPT	
                (SELECT chambre.chambre_id, reservation.num_chambre, reservation.pers_max, reservation.hotel_nom
                 FROM reservation
                 INNER JOIN chambre
                 WHERE chambre.num_chambre = reservation.num_chambre
                 );
				';
				$stmnt = $this->dbh->prepare($sql);
				$stmnt->bindParam(':hotel_nom', $hotel);		
				$stmnt->bindParam(':arrivee', $arrivee);		
				$stmnt->bindParam(':depart', $depart);													
				$stmnt->execute();				
			}
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}
		}

		public function displayRoomsNotYetSelected_OneChambre(int $personne)
		{	
			if($personne <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{
				$sql = 'SELECT num_chambre, pers_max 
						FROM hotelchambre
						WHERE pers_max >= :NbrPers';
				$stmnt = $this->dbh->prepare($sql);
				$stmnt->bindParam(':NbrPers', $personne);				
				$stmnt->execute();
				while($row = $stmnt->fetch(PDO::FETCH_ASSOC))
				{	
					$num_chambre[] = $row['num_chambre'];
					$pers_max[] = $row['pers_max'];
				}	

				if(!isset($num_chambre))
				{
					echo "Aucune chambre ne peut accueillir autant de personne pour ces dates" . "<br>" ?>
					<a href="client_accueil.php">Veuillez sélectionnez plus de chambres</a>
		  <?php } 
				elseif(isset($num_chambre))
				{
					for($i = 0 ; $i < count($num_chambre) ; $i++)
					{	?>

							<form action="client_reservation.php" method="post">
							<p>Chambre <?php echo $num_chambre[$i] ?> ; Personnes max : <?php echo $pers_max[$i] ?>
								<input type="hidden" name="num_chambre" value="<?php echo $num_chambre[$i] ?>">
								<input type="hidden" name="pers_max" value="<?php echo $pers_max[$i] ?>">	
								<input type="submit" name="valider" value="Selectionner">
							</p>
						</form>	
			<?php	}
				}				
			}
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}

		}

		public function displayRoomsNotYetSelected_MoreChambre()
		{
			$sql = 'SELECT chambre_id, num_chambre, pers_max, hotel_nom 
			FROM hotelchambre';
			$stmnt = $this->dbh->prepare($sql);
			$stmnt->execute();
			while($row = $stmnt->fetch(PDO::FETCH_ASSOC))
			{	
				$num_chambre[] = $row['num_chambre'];
				$pers_max[] = $row['pers_max'];
			}
				for($i = 0 ; $i < count($num_chambre) ; $i++)
				{	?>
						<form action="client_reservation.php" method="post">
						<p>Chambre <?php echo $num_chambre[$i] ?> ; Personnes max : <?php echo $pers_max[$i] ?>
							<input type="hidden" name="num_chambre" value="<?php echo $num_chambre[$i] ?>">
							<input type="hidden" name="pers_max" value="<?php echo $pers_max[$i] ?>">	
							<input type="submit" name="valider">
						</p>
					</form>	
			<?php	}
		}

		public function displayPropositionChambre(int $nombreChambre)
		{
			if($nombreChambre <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{
				$countchmbre = $this->countPropositionChambre($nombreChambre);
				if($countchmbre != 0)
				{
					$count = 0;
					$sql = 'SELECT * FROM couplechambre';
					$stmnt = $this->dbh->prepare($sql);
					$stmnt->execute();
					while ($row = $stmnt->fetch(PDO::FETCH_ASSOC))
					{
						for($i = 0 ; $i < $nombreChambre ; $i++)
						{
							$_chambre['chambre' . ($i + 1) .  " - " . $count] = $row['chambre' . ($i + 1)];
						}	
						$count++;		
					}	
					return $_chambre;	
				}
			}	
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}		
		}

		public function countPropositionChambre(int $nombreChambre)
		{	
			if($nombreChambre <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{
				$count = 0;
				$sql = 'SELECT * FROM couplechambre';
				$stmnt = $this->dbh->prepare($sql);
				$stmnt->execute();
				while ($row = $stmnt->fetch(PDO::FETCH_ASSOC))
				{
					for($i = 0 ; $i < $nombreChambre ; $i++)
					{
						$_chambre['chambre' . ($i + 1) .  " - " . $count] = $row['chambre' . ($i + 1)];
					}	
					$count++;		
				}	
				return $count;				
			}
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}
		}

		public function fillPropositionChambre()
		{
			$i = 0;

			$sql = 'SELECT pers_max, num_chambre, hotel_nom FROM selectchambre';
			$stmnt = $this->dbh->prepare($sql);
			$stmnt->execute();
			while($row = $stmnt->fetch(PDO::FETCH_ASSOC))
			{	
				$result[$i]['pers_max'] = $row['pers_max'];
				$result[$i]['num_chambre'] = $row['num_chambre'];
				$result[$i]['hotel_nom'] = $row['hotel_nom'];
				$i++;
			}	
			return $result;
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
