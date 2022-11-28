<?php

	class Admin
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

		public function createAdmin(int $id)
		{	
			if($id <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{	?>
				<h3>Création d'un admin</h3>

	<?php		if(isset($_POST['creation_admin']))
				{
					if(isset($_POST['admin_nom']) AND isset($_POST['admin_mail']) AND isset($_POST['admin_roles']))
					{
						$sql = 'SELECT role_id 
								FROM role
								WHERE role_name = :role_name;';
						$stmnt = $this->dbh->prepare($sql);
						$stmnt->bindParam(':role_name', $_POST['admin_roles']);						
						$stmnt->execute();
						while($row = $stmnt->fetch(PDO::FETCH_ASSOC))
						{
							$role_id = $row['role_id'];
						}			

						$sql = 'INSERT INTO admin(admin_nom, admin_mail, role_id) VALUES(:admin_nom, :admin_mail, :role_id);';
						$stmnt = $this->dbh->prepare($sql);
						$stmnt->bindParam(':admin_nom', $_POST['admin_nom']);
						$stmnt->bindParam(':admin_mail', $_POST['admin_mail']);
						$stmnt->bindParam(':role_id', $role_id);																			
						$stmnt->execute();	
					}
				}	?>

					<form action="<?php echo 'admin_adminManagement' . $id . '.php' ?>" method="post">
						Nom : <input type="text" name="admin_nom">
						Mail : <input type="text" name="admin_mail">
					<label>Hotel ID : </label>
						<select name="admin_roles">
								<option value="super_admin">super_admin</option>
								<option value="admin_data">admin_data</option>
								<option value="admin_resa">admin_resa</option>
						</select>
						<input type="submit" name="creation_admin">
					</form>				
<?php		}
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}
		}

		public function deleteAdmin(int $id)
		{	
			if($id <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{	?>
				<h3>Suppression d'un admin</h3>

	<?php		if(isset($_POST['suppression_admin']))
				{
					if(isset($_POST['admins']))
					{
						$sql = 'DELETE FROM admin WHERE admin_id = :admin_id';
						$stmnt = $this->dbh->prepare($sql);
						$stmnt->bindParam(':admin_id', $_POST['admins']);						
						$stmnt->execute();

						$sql = 'ALTER TABLE admin AUTO_INCREMENT = 1;';
						$stmnt = $this->dbh->prepare($sql);
						$stmnt->execute();
					}
				}	?>

					<form action="<?php echo 'admin_adminManagement' . $id . '.php' ?>" method="post">
						<label>Admin : </label>
							<select name="admins">
			<?php				$sql = 'SELECT admin_id, admin_nom, role_name
								FROM admin
								INNER JOIN role
								WHERE admin.role_id = role.role_id
								ORDER BY admin_id ASC
								;
								';
								$stmnt = $this->dbh->prepare($sql);
								$stmnt->execute();
								while ($row = $stmnt->fetch(PDO::FETCH_ASSOC)) 
								{			
									?>
								<option value="<?php echo $row['admin_id'] ?>">
									<?php echo $row['admin_id'] . " - " . 
											   $row['admin_nom'] . " - " .
											   $row['role_name']?>
								 </option>
			<?php				}	?>

							</select>
						<input type="submit" name="suppression_admin">
					</form>				
<?php		}
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}

	}

		public function login()
		{	?>
			<p>Veuillez saisir votre nom et mail pour ouvrir votre session</p>
			<form action="admin_login.php" method="post">
				Nom : <input type="text" name="nom_admin">
				Mail : <input type="text" name="mail_admin">	
				<input type="submit" name="valider">
			</form>	

<?php		if(isset($_POST['valider']))
			{
				if($_POST['nom_admin'] == "" OR $_POST['mail_admin'] == "")
				{
					echo "Le champ Nom ou Mail est manquant"; 
				}		
				else
				{
					$sql = 'SELECT admin_nom
							FROM admin
							WHERE admin_nom = :admin_nom';
					$stmnt = $this->dbh->prepare($sql);
					$stmnt->bindParam(':admin_nom', $_POST['nom_admin']);						
					$stmnt->execute();
					$row = $stmnt->fetch(PDO::FETCH_ASSOC);
					if($row == 0)
					{    
						echo "Votre nom n'est pas reconnu"; ?>
			<?php	}
					else
					{
						$sql = 'SELECT *
						FROM admin
						WHERE admin_nom = :admin_nom';
						$stmnt = $this->dbh->prepare($sql);
						$stmnt->bindParam(':admin_nom', $_POST['nom_admin']);						
						$stmnt->execute();
						$row = $stmnt->fetch(PDO::FETCH_ASSOC);	
						if(crypt($_POST['mail_admin'], $row['admin_mail']) == $row['admin_mail'])
						{
							$this->startConnexion($_POST['mail_admin'], $_POST['nom_admin'], $row['admin_id'], $row['role_id']);
						}
						else
						{
							echo "Votre nom est reconnu mais pas votre mail" . "<br>"; 
						}
					}
				}
			}
		}


		public function startConnexion(string $mail, string $nom_admin, int $admin_id, int $role_id)
		{
			if($admin_id <= 0 OR $role_id <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{
				$insert[] = $admin_id;
				$insert[] = $role_id;

				$insertConnexion = implode("\", \"", $insert);

				echo $insertConnexion . "<br>";

				// La table Connexion permet de voir qui est connecté ou non
				$sql = 'INSERT INTO connexion(admin_id, role_id, connecte)
						VALUES("' . $insertConnexion . '", "YES")
						;'
						;
				$stmnt = $this->dbh->prepare($sql);				
				$stmnt->execute();
				$row = $stmnt->fetch(PDO::FETCH_ASSOC);

				// Elle permet également de récupérer les index de connexion.
				$count = 0;
				$sql = 'SELECT connexion_id FROM connexion;';
				$stmnt = $this->dbh->prepare($sql);
				$stmnt->execute();
				while($row = $stmnt->fetch(PDO::FETCH_ASSOC))
				{
					$count++;
				}

				session_start();
				// Index de connexion
				$_SESSION['id'] = $count++;

				$_SESSION['admin_login - ' . $_SESSION['id']] = "session ouverte";
				$_SESSION['admin_nom - ' . $_SESSION['id']] = $nom_admin;
				$_SESSION['admin_mail - ' . $_SESSION['id']] = $mail;
				header('location: ../process/admin_write_file.php');				
			}
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}
		}

		public function update_endConnexion(int $id)
		{
			if($id <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{
				$sql = 'UPDATE connexion SET connecte = "NO" WHERE connexion_id = :connexion_id;';
				$stmnt = $this->dbh->prepare($sql);
				$stmnt->bindParam(':connexion_id', $id);				
				$stmnt->execute();

				$_SESSION['destroy'] = $id;
				header('location: admin_destroy_file.php');				
			}
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}
		}

		public function endConnexion(int $id)
		{			
			if($id <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{	?>
				<h3>Deconnexion : </h3>
				<form action="<?php echo 'admin_deconnexion' . $id . '.php' ?>" method="post">
					<input type="submit" name="valider">
				</form>					
<?php		}
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}
		}

		public function deleteConnexion()
		{
			$sql = 'SELECT connecte
					FROM connexion 
					WHERE connecte = "YES"
					;'
					;
			$stmnt = $this->dbh->prepare($sql);
			$stmnt->execute();
			$row = $stmnt->fetch(PDO::FETCH_ASSOC);	
			
			if($row == "")
			{
				$sql = 'DELETE FROM connexion'
					;
				$stmnt = $this->dbh->prepare($sql);
				$stmnt->execute();

				$sql = 'ALTER TABLE connexion AUTO_INCREMENT = 1;'
					;
				$stmnt = $this->dbh->prepare($sql);
				$stmnt->execute();

				header('location: admin_login.php');
			}
		}


		public function displayAdminConnexion(int $id)
		{	
			if($id <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{	?>
				<h3>Connexion des admin</h3>

	<?php		$sql = 'SELECT connexion_id, admin_nom, role_name, connecte
						FROM connexion
						INNER JOIN admin
						INNER JOIN role
						WHERE admin.admin_id = connexion.admin_id
						AND connexion.role_id = role.role_id
						EXCEPT 
						SELECT connexion_id, admin_nom, role_name, connecte
						FROM connexion
						INNER JOIN admin
						INNER JOIN role
						WHERE admin.admin_id = connexion.admin_id
						AND connexion.role_id = role.role_id
						AND connecte = "NO";';
				$stmnt = $this->dbh->prepare($sql);
				$stmnt->execute();
				while($row = $stmnt->fetch(PDO::FETCH_ASSOC))
				{	?>
							<form action="<?php echo 'admin_deconnexion' . $row['connexion_id'] . '.php' ?>" method="post">
	<?php					echo $row['connexion_id'] . " - "	;
							echo $row['admin_nom'] . " - "	;
							echo $row['role_name'];?>
							<input type="hidden" name="id" value="<?php echo $id ?>">
							<input type="submit" name="suppression_session" value="suppression">
							</form>	
	<?php		}					
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

