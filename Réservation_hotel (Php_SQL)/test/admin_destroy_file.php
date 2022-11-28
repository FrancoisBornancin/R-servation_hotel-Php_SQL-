<?php 	$dbh = new PDO('mysql:host=localhost;dbname=php_expert_devoir2', 'root', '');	

	session_start();

	$sql = 'SELECT connecte
		FROM connexion 
		WHERE connecte = "YES"
		;'
		;
	$stmnt = $dbh->prepare($sql);
	$stmnt->execute();
	$row = $stmnt->fetch(PDO::FETCH_ASSOC);	
	
	if($row == "")
	{
		$sql = 'DELETE FROM connexion'
			;
		$stmnt = $dbh->prepare($sql);
		$stmnt->execute();

		$sql = 'ALTER TABLE connexion AUTO_INCREMENT = 1;'
			;
		$stmnt = $dbh->prepare($sql);
		$stmnt->execute();

		header('location: admin_login.php');
	}

	if($_SESSION['suppression_session'] != null)
	{	
		unlink('admin_accueil' . $_SESSION['destroy'] . '.php');
		unlink('admin_dataManagement' . $_SESSION['destroy'] . '.php');
		unlink('admin_insertData' . $_SESSION['destroy'] . '.php');
		unlink('admin_adminManagement' . $_SESSION['destroy'] . '.php');
		unlink('admin_deconnexion' . $_SESSION['destroy'] . '.php');

		unlink('write_admin_accueil' . $_SESSION['destroy'] . '.php');
		unlink('write_admin_insertData' . $_SESSION['destroy'] . '.php');
		unlink('write_admin_dataManagement' . $_SESSION['destroy'] . '.php');
		unlink('write_admin_adminManagement' . $_SESSION['destroy'] . '.php');

		$write_admin_adminManagement = file_get_contents('write_admin_adminManagement' . $_SESSION['suppression_session'] . '.php') ;
		header('location: ' . $write_admin_adminManagement);
	}
	else
	{
		unlink('admin_accueil' . $_SESSION['destroy'] . '.php');
		unlink('admin_dataManagement' . $_SESSION['destroy'] . '.php');
		unlink('admin_insertData' . $_SESSION['destroy'] . '.php');
		unlink('admin_adminManagement' . $_SESSION['destroy'] . '.php');
		unlink('admin_deconnexion' . $_SESSION['destroy'] . '.php');

		unlink('write_admin_accueil' . $_SESSION['destroy'] . '.php');
		unlink('write_admin_insertData' . $_SESSION['destroy'] . '.php');
		unlink('write_admin_dataManagement' . $_SESSION['destroy'] . '.php');
		unlink('write_admin_adminManagement' . $_SESSION['destroy'] . '.php');

		header('location: admin_login.php');		
	}





