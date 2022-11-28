<?php 	$dbh = new PDO('mysql:host=localhost;dbname=php_expert_devoir2', 'root', '');	

		$string = "admin_deconnexion";
		$strlen = strlen($string);
		echo strlen($string) . "<br>";
//		$string2 = "admin_deconnexion46";
		$string2 = basename(__FILE__, '.php');
		$strlen2 = strlen($string);
		echo substr($string2, $strlen) . "<br>";
		$id = substr($string2, $strlen);

	session_start();

		$sql = 'UPDATE connexion 
				SET connecte = "NO" 
				WHERE admin_id = ' . $id . '
				;';
		$stmnt = $dbh->prepare($sql);
		$stmnt->execute();
		$row = $stmnt->fetch(PDO::FETCH_ASSOC);	

//		$_SESSION['admin_login' . $_SESSION['count']] = null;

//		header('location: admin_login.php');


