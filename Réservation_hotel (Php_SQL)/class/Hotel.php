<?php

	class Hotel
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

		public function createHotel(int $id)
		{		
			if($id <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{	?>
						<h3>Création d'un hotel</h3>

	<?php	 	if(isset($_POST['insertion_hotel']))
				{
					if(isset($_POST['hotel_nom']) AND isset($_POST['hotel_ville']) AND isset($_POST['hotel_adresse']))
					{
						$sql = 'INSERT INTO hotel(hotel_nom, hotel_ville, hotel_adresse) VALUES(:hotel_nom, :hotel_ville, :hotel_adresse);';
						$stmnt = $this->dbh->prepare($sql);
						$stmnt->bindParam(':hotel_nom', $_POST['hotel_nom']);	
						$stmnt->bindParam(':hotel_ville', $_POST['hotel_ville']);	
						$stmnt->bindParam(':hotel_adresse', $_POST['hotel_adresse']);												
						$stmnt->execute();	
					}
					else
					{
						echo "Il vous manque une donnée";
					}
				}	?>

				<form action="<?php echo 'admin_insertData' . $id . '.php' ?>" method="post">
					Nom : <input type="text" name="hotel_nom">
					Ville : <input type="text" name="hotel_ville">
					Adresse : <input type="text" name="hotel_adresse">
					<input type="submit" name="insertion_hotel">
				</form>					
<?php		}			
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}
		}	

		public function deleteHotel(int $id)
		{	
			if($id <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{	?>
				<h3>Suppression d'un hotel</h3>

	<?php			if(isset($_POST['suppression_hotel']))
					{
						if(isset($_POST['hotels']))
						{
							$sql = 'DELETE FROM hotel WHERE hotel_id = :hotel_id';
							$stmnt = $this->dbh->prepare($sql);
							$stmnt->bindParam(':hotel_id', $_POST['hotels']);								
							$stmnt->execute();

							$sql = 'ALTER TABLE hotel AUTO_INCREMENT = 1;';
							$stmnt = $this->dbh->prepare($sql);
							$stmnt->execute();
			
						}
					}	?>

					<form action="<?php echo 'admin_insertData' . $id . '.php' ?>" method="post">
						<label>Hotels : </label>
							<select name="hotels">
			<?php				$sql = 'SELECT *
								FROM hotel
								ORDER BY hotel_id
								;
								';
								$stmnt = $this->dbh->prepare($sql);
								$stmnt->execute();
								while ($row = $stmnt->fetch(PDO::FETCH_ASSOC)) 
								{			
									?>
								<option value="<?php echo $row['hotel_id'] ?>">
									<?php echo $row['hotel_id'] . " - " . 
											   $row['hotel_nom'] . " - " .
											   $row['hotel_ville'] . " - " .
											   $row['hotel_adresse']?>
								 </option>
			<?php				}	?>

							</select>
						<input type="submit" name="suppression_hotel">
					</form>				
<?php		}		
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}	
		}


		public function displayHotel_ville()
		{
			$sql = 'SELECT DISTINCT hotel_ville FROM hotel';
			$stmnt = $this->dbh->prepare($sql);
			$stmnt->execute();
			while($row = $stmnt->fetch(PDO::FETCH_ASSOC))
			{	
				$result[] = $row['hotel_ville'];
			}	
			return $result;
		}

		public function selectSumPers_CountChambre()
		{
			$sql = 'SELECT SUM(pers_max) AS pers_max, COUNT(chambre_id) AS chambre_id, hotel_nom
					FROM countchambre
					GROUP BY hotel_nom;';
			$stmnt = $this->dbh->prepare($sql);
			$stmnt->execute();
			while($row = $stmnt->fetch(PDO::FETCH_ASSOC))
			{	
				$result['pers_max'][] = $row['pers_max'];
				$result['chambre_id'][] = $row['chambre_id'];
				$result['hotel_nom'][] = $row['hotel_nom'];
			}
			return $result;
		}

		public function displayAvailableHotel(array $hotel, int $i)
		{	
			if($i < 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{	?>
					<form action="../process/client_write_file.php" method="post">
						<label>Hotels : </label>
							<select name="hotel">	
									<option value="<?php echo $hotel[$i] ?>"><?php echo $hotel[$i] ?></option>									
							</select>	
									<input type="hidden" name="personne" value="<?php echo $_POST['personne'] ?>">
									<input type="hidden" name="chambre" value="<?php echo $_POST['chambre'] ?>">	
									<input type="hidden" name="arrivee" value="<?php echo $_POST['arrivee'] ?>">
									<input type="hidden" name="depart" value="<?php echo $_POST['depart'] ?>">
									<input type="submit" name="valider">
					</form>					
<?php			}
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

