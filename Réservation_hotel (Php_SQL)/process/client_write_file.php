<?php

	session_start();
	$_SESSION['hotel'] = $_POST['hotel'];
	$_SESSION['personne'] = $_POST['personne'];
	$_SESSION['chambre'] = $_POST['chambre'];
	$_SESSION['arrivee'] = $_POST['arrivee'];
	$_SESSION['depart'] = $_POST['depart'];

	$contraintChambre = $_SESSION['chambre'];

// Fichier client_sousEnsembleTri.php : Permettra de récupérer les combinaisons de chambres satisfaisant les contraintes client
    $nomdefichier = 'client_sousEnsembleTri.php';

    $fichier = fopen($nomdefichier, 'a');

    ftruncate($fichier, 0);

    $ligne1 = '<?php';
    fwrite($fichier, $ligne1);

	for($i = 0 ; $i < $contraintChambre ; $i++)
	{	 
		$string[] = strtolower(chr(73 + $i));
	}

// Ecrit dans le fichier : Initie les différentes boucles
	for($i = 0 ; $i < $contraintChambre ; $i++)
	{	
	    $ligne1 = "\n" . 'for($'. $string[$i] .' = 0 ; $'. $string[$i] .' < count($ensemble) ; $'. $string[$i] .'++){';
	    fwrite($fichier, $ligne1);
	}

// Ecrit dans le fichier : Initie la 1re partie des contraintes de personnes max
    $ligne1 = "\n" . '$resultPers_max = (';
    $ligne2 = '$ensemble[$i][\'pers_max\']';
    fwrite($fichier, $ligne1);
    fwrite($fichier, $ligne2);

// Ecrit dans le fichier : Initie la 2me partie des contraintes de personnes max (les boucles)
	for($i = 1 ; $i < $contraintChambre ; $i++)
	{	
	    $ligne1 = ' + $ensemble[$' . $string[$i] . '][\'pers_max\']';
	    fwrite($fichier, $ligne1);
	}	

// Ecrit dans le fichier : Initie la 1re partie des contraintes de Chambre ID
    $ligne1 = ');';
    $ligne2 = "\n" . '$resultNum_chambre = (';
    $ligne3 = '$ensemble[$i][\'num_chambre\']';

    fwrite($fichier, $ligne1);
    fwrite($fichier, $ligne2);
    fwrite($fichier, $ligne3);
// Ecrit dans le fichier : Initie la 2me partie des contraintes de Chambre ID
	for($i = 1 ; $i < $contraintChambre ; $i++)
	{	
	    $ligne1 = ' + $ensemble[$' . $string[$i] . '][\'num_chambre\']';
	    fwrite($fichier, $ligne1);
	}	
    $ligne1 = ');';
    $ligne2 = "\n" . '{';

    fwrite($fichier, $ligne1);
    fwrite($fichier, $ligne2);

// Ecrit dans le fichier : Initie les différentes valeurs 
	for($i = 0 ; $i < $contraintChambre ; $i++)
	{
	    $ligne1 = "\n" . '$ensembleTri[$index][\'chambre' . ($i + 1) . '\'] = $ensemble[$' . $string[$i] . '][\'num_chambre\'];';	
	    fwrite($fichier, $ligne1);
	}

    $ligne1 = "\n" . '$ensembleTri[$index][\'hotels\'] = $ensemble[$j][\'hotel_nom\'];';
    fwrite($fichier, $ligne1);		

	for($i = 0 ; $i < $contraintChambre ; $i++)
	{
	    $ligne1 = "\n" . '$ensembleTri[$index][\'pers_max' . ($i + 1) . '\'] = $ensemble[$' . $string[$i] . '][\'pers_max\'];';	
	    fwrite($fichier, $ligne1);	
	}

// Ecrit dans le fichier : $index++ et saut de ligne
    $ligne1 = "\n" . '$ensembleTri[$index][\'pers_max\'] = $resultPers_max;';
    $ligne2 = "\n" . '$index++;';

    fwrite($fichier, $ligne1);
    fwrite($fichier, $ligne2);

// Ecrit dans le fichier : Ferme les accolades
	for($i = 0 ; $i < ($contraintChambre + 1) ; $i++)
	{
	    $ligne1 = "\n" . '}';
	    fwrite($fichier, $ligne1);
	}

    fclose($fichier);

// Fichier client_insertValue.php : Permettra d'insérer les combinaisons de chambres dans une table dédiée

    $nomdefichiers = 'client_insertValue.php';

    $fichiers = fopen($nomdefichiers, 'a');

    ftruncate($fichiers, 0);

	$lign[] = '<?php';
	$lign[] = "\n" . 'for($j = 0 ; $j < count($ensembleTri) ; $j++)';		
	$lign[] = "\n" . '{';		
	$lign[] = "\n" . '	if(($ensembleTri[$j][\'pers_max\'] < $contraintPers) ';
	$lign[] = "\n" . '		OR  (';

	for($j = 1 ; $j < $contraintChambre ; $j++)
	{
		for($i = 1 ; $i < $contraintChambre ; $i++)
		{	
			if($i >= $j)
			{
				if($j == ($contraintChambre - 1) AND $i == ($contraintChambre - 1))
				{
					$lign[] = '  	($ensembleTri[$j][\'chambre'. $j .'\'] == $ensembleTri[$j][\'chambre'. ($i + 1) .'\'])';
					$lign[] = "\n" . '		  	) ';

				}
				else
				{
					$lign[] = '  	($ensembleTri[$j][\'chambre'. $j .'\'] == $ensembleTri[$j][\'chambre'. ($i + 1) .'\'])';
					$lign[] = "\n" . '		  	OR ';
					
				}
			}
			else
			{
				$lign[] = '  	($ensembleTri[$j][\'chambre'. $j .'\'] == $ensembleTri[$j][\'chambre'. $i .'\'])';
				$lign[] = "\n" . '		  	OR ';
			}
		}	
	}

	$lign[] = "\n" . '	)';				
	$lign[] = "\n" . '	{continue;}';
	$lign[] = "\n" . '	else';
	$lign[] = "\n" . '	{';
	$lign[] = "\n";
	$lign[] = "\n" . '		$insert_chambre_hotel = ($insert . $hotel);';
	$lign[] = "\n";
	$lign[] = "\n" . '		for($i = 0 ; $i < $contraintChambre ; $i++)';
	$lign[] = "\n" . '		{';
	$lign[] = "\n" . '			$insert_value[$j][] = $ensembleTri[$j][\'chambre\'. ($i + 1)];';
	$lign[] = "\n" . '		}';
	$lign[] = "\n";
	$lign[] = "\n" . '		$insert_value[$j][] = $ensembleTri[$j][\'hotels\'];';
	$lign[] = "\n";
	$lign[] = "\n" . '		$insert_final_value = implode("\",\"", $insert_value[$j]);';	
	$lign[] = "\n";
	$lign[] = "\n" . '		$sql = \'INSERT INTO couplechambre(\' . $insert_chambre_hotel . \') VALUES("\'. $insert_final_value .\'");\';';	
	$lign[] = "\n" . '		$stmnt = $dbh->prepare($sql);';
	$lign[] = "\n" . '		$stmnt->execute();	';
	$lign[] = "\n";
	$lign[] = "\n" . '	}';
	$lign[] = "\n" . '}';

	for($i = 0 ; $i < count($lign) ; $i++)
	{
		fwrite($fichiers, $lign[$i]);
	}

    fclose($fichiers);

	header('Location: client_unique.php');




