<?php 	
	session_start();

	$i = $_SESSION['id'];

	echo $i . "<br>";

// Fichier admin write_admin_deconnexion_wrap.php
    $nomdefichier = 'admin_deconnexion' . $i . '.php';

    $fichier = fopen($nomdefichier, 'a');

	ftruncate($fichier, 0);

	$lign[] = '<?php 	$dbh = new PDO(\'mysql:host=localhost;dbname=php_expert_devoir2\', \'root\', \'\');	';
	$lign[] = "\n" . '		session_start();';
	$lign[] = "\n" . '		if(isset($_POST[\'suppression_session\']))';
	$lign[] = "\n" . '		{$_SESSION[\'suppression_session\'] = $_POST[\'id\'];}';
	$lign[] = "\n" . '		else{$_SESSION[\'suppression_session\'] = null;}';
	$lign[] = "\n" . '		$string = "admin_deconnexion";';
	$lign[] = "\n" . '		$strlen = strlen($string);';
	$lign[] = "\n" . '		$string2 = basename(__FILE__, \'.php\');';
	$lign[] = "\n" . '		echo substr($string2, $strlen) . "<br>";';
	$lign[] = "\n" . '		$id = substr($string2, $strlen);';
	$lign[] = "\n" . '$sql = \'UPDATE connexion SET connecte = "NO" WHERE connexion_id = \' . $id . \';\';';
	$lign[] = "\n" . '$stmnt = $dbh->prepare($sql);';
	$lign[] = "\n" . '$stmnt->execute();';
	$lign[] = "\n" . '		$_SESSION[\'destroy\'] = $id;';
	$lign[] = "\n" . '		header(\'location: admin_destroy_file.php\');';

	for($j = 0 ; $j < count($lign) ; $j++)
	{
		fwrite($fichier, $lign[$j]);		
	}

	unset($lign);

    fclose($fichier);

// Fichier admin write_admin_accueil_wrap.php
    $nomdefichier = 'admin_accueil' . $i . '.php';

    $fichier = fopen($nomdefichier, 'a');

	ftruncate($fichier, 0);

	$lign[] = '<?php 	$string = "admin_accueil";';	
	$lign[] = "\n" . '		$strlen = strlen($string);';
	$lign[] = "\n" . '		$string2 = basename(__FILE__, \'.php\');';
	$lign[] = "\n" . '		$id = substr($string2, $strlen);';
	$lign[] = "\n" . '		require(\'admin_accueil.php\');	?>';

	for($j = 0 ; $j < count($lign) ; $j++)
	{
		fwrite($fichier, $lign[$j]);		
	}

	unset($lign);

    fclose($fichier);

// Fichier admin write_admin_dataManagement_wrap.php
    $nomdefichier = 'admin_dataManagement' . $i . '.php';

    $fichier = fopen($nomdefichier, 'a');

	ftruncate($fichier, 0);

	$lign[] = '<?php 	$string = "admin_dataManagement";';	
	$lign[] = "\n" . '		$strlen = strlen($string);';
	$lign[] = "\n" . '		$string2 = basename(__FILE__, \'.php\');';
	$lign[] = "\n" . '		$id = substr($string2, $strlen);';
	$lign[] = "\n" . '		require(\'admin_dataManagement.php\');	?>';

	for($j = 0 ; $j < count($lign) ; $j++)
	{
		fwrite($fichier, $lign[$j]);		
	}

	unset($lign);

    fclose($fichier);

// Fichier admin write_admin_insertData_wrap.php
    $nomdefichier = 'admin_insertData' . $i . '.php';

    $fichier = fopen($nomdefichier, 'a');

	ftruncate($fichier, 0);

	$lign[] = '<?php 	$string = "admin_insertData";';	
	$lign[] = "\n" . '		$strlen = strlen($string);';
	$lign[] = "\n" . '		$string2 = basename(__FILE__, \'.php\');';
	$lign[] = "\n" . '		$id = substr($string2, $strlen);';
	$lign[] = "\n" . '		require(\'admin_insertData.php\');	?>';

	for($j = 0 ; $j < count($lign) ; $j++)
	{
		fwrite($fichier, $lign[$j]);		
	}

	unset($lign);

    fclose($fichier);

// Fichier admin write_admin_adminManagement_wrap.php
    $nomdefichier = 'admin_adminManagement' . $i . '.php';

    $fichier = fopen($nomdefichier, 'a');

	ftruncate($fichier, 0);

	$lign[] = '<?php 	$string = "admin_adminManagement";';	
	$lign[] = "\n" . '		$strlen = strlen($string);';
	$lign[] = "\n" . '		$string2 = basename(__FILE__, \'.php\');';
	$lign[] = "\n" . '		$id = substr($string2, $strlen);';
	$lign[] = "\n" . '		require(\'admin_adminManagement.php\');	?>';

	for($j = 0 ; $j < count($lign) ; $j++)
	{
		fwrite($fichier, $lign[$j]);		
	}

	unset($lign);

    fclose($fichier);

// Fichier admin write_admin_accueil.php
    $nomdefichier = 'write_admin_accueil' . $i . '.php';

    $fichier = fopen($nomdefichier, 'a');

	ftruncate($fichier, 0);

	$ligne1 = 'admin_accueil' . $i . '.php';
	fwrite($fichier, $ligne1);

    fclose($fichier);

// Fichier admin write_admin_insertData.php
    $nomdefichier = 'write_admin_insertData' . $i . '.php';

    $fichier = fopen($nomdefichier, 'a');

	ftruncate($fichier, 0);

	$ligne1 = 'admin_insertData' . $i . '.php';
	fwrite($fichier, $ligne1);

    fclose($fichier);

// Fichier admin write_admin_dataManagement.php
    $nomdefichier = 'write_admin_dataManagement' . $i . '.php';

    $fichier = fopen($nomdefichier, 'a');

	ftruncate($fichier, 0);

	$ligne1 = 'admin_dataManagement' . $i . '.php';
	fwrite($fichier, $ligne1);

    fclose($fichier);    

// Fichier admin write_admin_adminManagement.php
    $nomdefichier = 'write_admin_adminManagement' . $i . '.php';

    $fichier = fopen($nomdefichier, 'a');

	ftruncate($fichier, 0);

	$ligne1 = 'admin_adminManagement' . $i . '.php';
	fwrite($fichier, $ligne1);

    fclose($fichier);

// File_get_content

	$write = file_get_contents('write_admin_accueil' . $i . '.php');

// Fin de l'écriture des fichiers

 header('location: ' . $write);
