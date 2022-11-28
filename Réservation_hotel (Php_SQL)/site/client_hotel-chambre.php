<?php 	require('../process/inc_connexion.php');
		$title = "Chambre";
		$connexion->DOCTYPE_html($title);	

	 	$chambre->dropRoomsNotYetSelected();	?>

		</nav>
			<ul><li><a href="client_accueil.php">Accueil (ré-initialise les propositions de combinaisons)</a></li>

<?php 	// Si le client est connecté, on affiche la page de ce menu
		if($_SESSION['client_id'] != null)
		{	?>
				<li><a href="client_result_reservation.php?client=' . $_SESSION['client_id'] . '">Historique des réservations</a></li>	
<?php	}	?>
			</ul>
		</nav> 


	<h3>Rappel des critères de sélection : </h3>

	<p>Hotel : <?php echo $_SESSION['hotel'] ?><br>
	Arrivée : <?php echo $_SESSION['arrivee'] ?><br>	
	Départ : <?php echo $_SESSION['depart'] ?><br>	
	Chambre(s) : <?php echo $_SESSION['chambre'] ?><br>	
	Personne(s) : <?php echo $_SESSION['personne'] ?> ou plus</p>


<?php
	if($_SESSION['chambre'] == 1)
	{	
		try
		{	
			// Crée une Vue SQL qui affichera toutes les chambres disponibles selon les critères
			$chambre->createRoomsNotYetSelected_OneChambre($_SESSION['hotel'], $_SESSION['personne'], $_SESSION['arrivee'], $_SESSION['depart']);	
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			exit;
		}
	}
	else
	{
		try
		{	// Crée une Vue SQL qui affichera toutes les chambres disponibles
			$chambre->createRoomsNotYetSelected_MoreChambre($_SESSION['hotel'], $_SESSION['personne'], $_SESSION['arrivee'], $_SESSION['depart']);		
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			exit;
		}

		// Si on appuie sur "Plus", on passe à la proposition suivante
		// Si on appuie sur "Moins", on passe à la proposition précédente
		if(isset($_POST['plus']))
		{
			$_SESSION['incrementation'] = ($_SESSION['incrementation'] + 1);	
		}
		elseif(isset($_POST['moins']))
		{
			$_SESSION['incrementation'] = ($_SESSION['incrementation'] - 1);
		}
		try
		{
			$_chambre = $chambre->displayPropositionChambre($_SESSION['chambre']);
			$count = $chambre->countPropositionChambre($_SESSION['chambre']);	
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			exit;
		}
		?>

	<h3>Proposition de combinaison (<?php echo $count ?> possibles)</h3>

	<h4>Proposition n°<?php echo $_SESSION['incrementation']  + 1 ?></h4>

<!-- Deux boutons de sélection des propositions de chambre	-->
	<form action="client_hotel-chambre.php" method="post">
			<input type="hidden" name="plus" value=1 >
		Incrémentation : <input type="submit" name="valider" value="+">
	</form>	

	<form action="client_hotel-chambre.php" method="post">
			<input type="hidden" name="moins" value=1 >
		Décrémentation : <input type="submit" name="valider" value="-">
	</form>	

<?php
		if($count == 0)
		{
			echo "Aucune combinaison n'est possible pour " . $_SESSION['chambre'] . " chambres." . "<br>"; ?>
			<a href="client_accueil.php">Veuillez sélectionner une chambre supplémentaire.</a>
<?php	
		} 
		else
		{	
			if($_SESSION['incrementation'] >= $count OR $_SESSION['incrementation'] < 0)
			{
				echo "Aucune autre combinaison n'est possible. <br>";
				echo "Veuillez vous référer à une des combinaisons disponibles.";
			}
			else
			{	
				// Affiche les chambres concernées par les propositions de chambres
				for($i = 0 ; $i < $_SESSION['chambre'] ; $i++)
				{
					echo "Chambre" . $_chambre['chambre' . ($i + 1) .  " - " . ($_SESSION['incrementation'])] . "<br>";
				}					
			}
		}
	}
?>
	<h3>chambre - personnes</h3>
<?php

if($_SESSION['chambre'] == 1)
{
	try
	{	
		// Affiche les chambres qui n'ont pas été sélectionnées
		$chambre->displayRoomsNotYetSelected_OneChambre($_SESSION['personne']);			
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		exit;
	}
}
else
{
	// Affiche les chambres qui n'ont pas été sélectionnées
	$chambre->displayRoomsNotYetSelected_MoreChambre();
}	
 	require('../process/inc_deconnexion.php');	?>	
	</body>
</html>




