<?php
		$dbh = new PDO('mysql:host=localhost;dbname=php_expert_devoir2', 'root', '');	
		session_start();	

		$write_admin_adminManagement = file_get_contents('write_admin_adminManagement' . $id . '.php') ; 

		$sql = 'SELECT role_id
		FROM connexion 
		WHERE connexion_id = "' . $id . '"
		;';
		$stmnt = $dbh->prepare($sql);
		$stmnt->execute();
		$row = $stmnt->fetch(PDO::FETCH_ASSOC);	
		$role = $row['role_id'];	?>

				</nav>
					<ul><li><a href="<?php echo 'admin_accueil' . $id . '.php' ?>">Accueil</a></li>

<?php   $sql = 'SELECT nav_name, nav_description
		FROM role_see_nav
		INNER JOIN navigation
		WHERE role_id = ' . $role . '
		AND role_see_nav.nav_id = navigation.nav_id
		;';
		$stmnt = $dbh->prepare($sql);
		$stmnt->execute();
		while($row = $stmnt->fetch(PDO::FETCH_ASSOC))
		{	?>
			<li><a href="<?php echo $row['nav_name'] . $id . '.php' ?>"><?php echo $row['nav_description'] . '.php' ?></a></li>
<?php	}	?>
					</ul>
				</nav>

			<h2>Gestion des admin</h2>
			<h3>Création d'un admin</h3>

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

<?php		if(isset($_POST['creation_admin']))
			{
				if(isset($_POST['admin_nom']) AND isset($_POST['admin_mail']) AND isset($_POST['admin_roles']))
				{
					$sql = 'SELECT role_id 
							FROM role
							WHERE role_name = "' . $_POST['admin_roles'] . '";';
					$stmnt = $dbh->prepare($sql);
					$stmnt->execute();	
					while($row = $stmnt->fetch(PDO::FETCH_ASSOC))
					{
						$role_id = $row['role_id'];
					}			

					$sql = 'INSERT INTO admin(admin_nom, admin_mail, role_id) VALUES("' . $_POST['admin_nom'] . '", "' . $_POST['admin_mail'] . '", "' . $role_id . '");';
					$stmnt = $dbh->prepare($sql);
					$stmnt->execute();

					header('location: ' . $write_admin_adminManagement);		
				}
			}	?>

			<h3>Suppression d'un admin</h3>
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
							$stmnt = $dbh->prepare($sql);
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


<?php		if(isset($_POST['suppression_admin']))
			{
				if(isset($_POST['admins']))
				{
					$sql = 'DELETE FROM admin WHERE admin_id = '. $_POST['admins'] .'';
					$stmnt = $dbh->prepare($sql);
					$stmnt->execute();

					$sql = 'ALTER TABLE admin AUTO_INCREMENT = 1;';
					$stmnt = $dbh->prepare($sql);
					$stmnt->execute();

					header('location: ' . $write_admin_adminManagement);	
				}
			}	?>

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
			$stmnt = $dbh->prepare($sql);
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

<?php			}	?>


			<h3>Deconnexion : </h3>
			<form action="<?php echo 'admin_deconnexion' . $id . '.php' ?>" method="post">
				<input type="submit" name="valider">
			</form>	

			</body>
		</html>

