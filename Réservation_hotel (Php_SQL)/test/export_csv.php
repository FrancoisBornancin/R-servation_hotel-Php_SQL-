<?php 	$dbh = new PDO('mysql:host=localhost;dbname=php_expert_devoir2', 'root', '');

		$sql = 'SHOW TABLES FROM php_expert_devoir2';
		$stmnt = $dbh->prepare($sql);
		$stmnt->execute();
		while($row = $stmnt->fetch(PDO::FETCH_ASSOC))
		{
			for($i = 0 ; $i < count($row) ; $i++)
			{
				$tables[] = $row['Tables_in_php_expert_devoir2'];
			}
		}

		for($i = 0 ; $i < count($tables) ; $i++)
		{
			$sql = 'SHOW FIELDS FROM ' . $tables[$i] . '';
			$stmnt = $dbh->prepare($sql);
			$stmnt->execute();
			while($row = $stmnt->fetch(PDO::FETCH_ASSOC))
			{
					$table[$i][] = $row['Field'] . "<br>";
			}
		}

		for($i = 0 ; $i < count($tables) ; $i++)
		{	
			$count = 0;
			$sql = 'SELECT * FROM ' . $tables[$i] . '';
			$stmnt = $dbh->prepare($sql);
			$stmnt->execute();
			while($row = $stmnt->fetch(PDO::FETCH_ASSOC))
			{	
				for($j = 0 ; $j < count($row) ; $j++)
				{
					$value[$i][$count][] = $row[substr($table[$i][$j], 0, strlen($table[$i][$j]) - 4)];
				}	
				$values[$i][$count] = implode(";", $value[$i][$count]);
				$count++;
			}	
		}

		for($i = 0 ; $i < count($table) ; $i++)
		{
			for($j = 0 ; $j < count($table[$i]) ; $j++)
			{
				$tabless[$i][$j] = substr($table[$i][$j], 0, strlen($table[$i][$j]) - 4);
			}
		}

		for($i = 0 ; $i < count($tabless) ; $i++)
		{
			$tablesss[$i] = implode(";", $tabless[$i]);
		}

//		print_r($tablesss);

		for($k = 0 ; $k < count($tables) ; $k++)
		{
			$nomdefichier = ($tables[$k] . '.csv');
			$fichier = fopen($nomdefichier, 'a');
			ftruncate($fichier, 0);

				$ligne1 = $tablesss[$k];	
	    		fwrite($fichier, $ligne1);

			for($l = 0 ; $l < count($values[$k]) ; $l++)
			{
				$ligne1 = "\n" . $values[$k][$l];	
	    		fwrite($fichier, $ligne1);
			}
	    		fclose($fichier);
		}





/*
	    $nomdefichier = ('test' . $i . '.txt');

	    $fichier = fopen($nomdefichier, 'a');

	    ftruncate($fichier, 0);

	    $test = implode(";", $nom[$i][$j][$j]);

	    $ligne1 = $test;
	    fwrite($fichier, $ligne1);

	    fclose($fichier);
*/
		

		
		
