<?php
	
	$i = 0;

	for($i = 0 ; $i < 30 ; $i++)
	{
	    $nomdefichier = 'test' . $i . '.txt';

	    $fichier = fopen($nomdefichier, 'a');

		ftruncate($fichier, 0);

		fwrite($fichier, 'Voici le ' . $i . ' fichier');		

	    fclose($fichier);

	    sleep(1);
	}



		



