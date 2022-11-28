<?php

	class Authentification
	{
		protected $dbh;

		public function __construct(PDO $dbh)
		{
			$this->setDb($dbh);
		}

		public function setDb(PDO $dbh)
		{
			$this->dbh = $dbh;
		}

		public function displayAuthentificationForm()
		{	?>
			<h3>Authentification : </h3>

			<p>Veuillez saisir votre nom et mail pour réserver la sélection</p>
			<form action="client_result_reservation.php" method="post">
				Nom : <input type="text" name="nom">
				Mail : <input type="text" name="mail">	
				<input type="submit" name="valider">
			</form>	
<?php	}	

		public function selectClient_Nom(string $nom)
		{
			$sql = 'SELECT client_nom FROM client WHERE client_nom = :client_nom';
			$stmnt = $this->dbh->prepare($sql);
			$stmnt->bindParam(':client_nom', $nom);			
			$stmnt->execute();
			$row = $stmnt->fetch(PDO::FETCH_ASSOC);
			return $row;
		}

		public function selectClient_Mail(string $nom, string $mail)
		{
			$sql = 'SELECT client_email FROM client 
					WHERE client_nom = :client_nom
					AND client_email = :client_mail';
			$stmnt = $this->dbh->prepare($sql);
			$stmnt->bindParam(':client_nom', $nom);	
			$stmnt->bindParam(':client_mail', $mail);							
			$stmnt->execute();
			$row = $stmnt->fetch(PDO::FETCH_ASSOC);
			return $row;
		}

		public function displayNouveauCompteButton(string $_nom, string $_mail)
		{	?>
				<h3>Votre nom n'est pas reconnu<h3> 
				<h4>Voulez-vous vous créer un compte? Attention si un compte existe déjà, l'historique des réservations ne sera pas visible</h4>

				<form action="client_result_reservation.php" method="post">	
				<p>Création d'un nouveau compte
					<input type="hidden" name="nom" value="<?php echo $_nom ?>">
					<input type="hidden" name="mail" value="<?php echo $_mail ?>">
					<input type="submit" name="nouveau_compte" value="ok">
				</p>
				</form>		
<?php	}	

		public function displayClientCreationForm(string $_nom, string $_mail)
		{	?>
				<form action="client_result_reservation.php" method="post">
					Nom : <input type="text" name="nouveau_compte_nom">
					Mail : <input type="text" name="nouveau_compte_mail">
					<input type="hidden" name="nom" value="<?php echo $_nom ?>">
					<input type="hidden" name="mail" value="<?php echo $_mail ?>">	
					<input type="submit" name="insert_nouveau_compte">
				</form>				
<?php	}

	}

