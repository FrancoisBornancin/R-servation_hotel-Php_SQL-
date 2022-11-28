<?php 	require('../process/inc_connexion.php');
		$title = "Hotel";
		$connexion->DOCTYPE_html($title);	?>
		</nav>
			<ul><li><a href="client_accueil.php">Accueil</a></li>


<?php 	// Affiche la page du menu si le client est connecté	
		if($_SESSION['client_id'] != null)
		{	?>
				<li><a href="client_result_reservation.php?client=' . $_SESSION['client_id'] . '">Historique des réservations</a></li>	
<?php	}	?>
			</ul>
		</nav> 
	
<?php	$date = date('Y-m-d');

	if($_POST['arrivee'] == "" OR $_POST['depart'] == "")
	{	
		echo "Vous n'avez pas sélectionné de date";
	}	
	elseif($_POST['arrivee'] < $date)
	{
		echo "La date d'arrivée est antérieure à la date du jour";
	}	
	elseif($_POST['arrivee'] > $_POST['depart'])
	{
		echo "Attention : La date d'arrivée est postérieure à la date de départ." ?>
		<a href="client_accueil.php">Retour à l'Accueil</a>
<?php	
	}
	else
	{		
			// Supprime et créé des Vues SQL affichant toutes les chambres disponibles sur les dates et villes sélectionnées 
			$chambre->dropAvailableChambre();	
	        $chambre->createAvailableChambre($_POST['villes'], $_POST['arrivee'], $_POST['depart']);  

	        // Permettra d'afficher les hotels pouvant satisfaire les contraintes de chambre, personnes, ville et dates 
	        $selectSumPers_CountChambre = $hotel->selectSumPers_CountChambre();

			$count = 0;
			for($i = 0 ; $i < count($selectSumPers_CountChambre['pers_max']) ; $i++)
			{
				if($selectSumPers_CountChambre['pers_max'][$i] < $_POST['personne'] OR $selectSumPers_CountChambre['chambre_id'][$i] < $_POST['chambre'])
				{	
					$count++;
					continue;
				}
				else
				{	
					try
					{	
						// Si des hotels satisfont les contraintes, ont les affiche
						$hotel->displayAvailableHotel($selectSumPers_CountChambre['hotel_nom'], $i);			
					}
					catch(Exception $e)
					{
						echo $e->getMessage();
						exit;
					}
				}			
			}
		
			if($count == count($selectSumPers_CountChambre['pers_max']))
			{
				echo "Tous les hotels sont complets dans cette ville!"; ?>
	<?php	} 
	}	?>

<?php 	require('../process/inc_deconnexion.php');	

	$_SESSION['incrementation'] = 0;

			?>	
	</body>
</html>



	























