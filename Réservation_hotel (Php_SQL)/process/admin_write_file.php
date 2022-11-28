<?php 	require('inc_connexion.php');

	$i = $_SESSION['id'];

	try
	{	
		// Récupère l'index de connexion
		// Redirige vers le fichier de destruction des fichiers de la partie admin
		$write_file->write_deconnexion_index_and_action($i);

		$filename = 'admin_accueil';
		// Récupère l'index de connexion		
		$write_file->write_connexion_index($filename, $i);
		// Ecrit le nom des fichiers de navigation dans des fichiers qui seront utilisés afin de ne pas surcharger le "header"		
		$write_file->write_filename($filename, $i);

		$filename = 'admin_dataManagement';
		$write_file->write_connexion_index($filename, $i);
		$write_file->write_filename($filename, $i);

		$filename = 'admin_insertData';
		$write_file->write_connexion_index($filename, $i);
		$write_file->write_filename($filename, $i);

		$filename = 'admin_adminManagement';
		$write_file->write_connexion_index($filename, $i);
		$write_file->write_filename($filename, $i);			
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		exit;
	}

// File_get_content

	// Variable qui permettra de ne pas surcharger le header
	$write = file_get_contents('write_admin_accueil' . $i . '.php');

// Fin de l'écriture des fichiers

 header('location: ' . $write);
