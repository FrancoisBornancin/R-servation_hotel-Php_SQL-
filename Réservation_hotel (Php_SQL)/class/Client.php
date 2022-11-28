<?php

	class Client
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

		public function createClient(string $nom, string $mail)
		{	
			$sql = 'INSERT INTO client(client_nom, client_email) VALUES(:client_nom, :client_mail);';
			$stmnt = $this->dbh->prepare($sql);
			$stmnt->bindParam(':client_nom', $nom);	
			$stmnt->bindParam(':client_mail', $mail);				
			$stmnt->execute();		
		}

		public function displayClientDisconnectionButton()
		{	?>
			<h3>Deconnexion : </h3>
			<form action="../process/client_deconnexion.php" method="post">
				<input type="submit" name="valider">
			</form>			
<?php	}		

	}

