<?php 	require('../process/inc_connexion.php');
		$title = "Résa";
		$connexion->DOCTYPE_html($title);	?>

		</nav>
			<ul><li><a href="client_accueil.php">Accueil</a></li>

<?php 	if($_SESSION['client_id'] != null)
		{	?>
			<li><a href="client_result_reservation.php?client=' . $_SESSION['client_id'] . '">Historique des réservations</a></li>			
<?php	}	?>
			<li><a href="client_hotel-chambre.php?hotel=<?php echo $_SESSION['hotel']  ?>">Sélection des chambres</a></li>
			</ul>
		</nav>

	<h3>Rappel des critères de sélection : </h3>

	<p>Hotel : <?php echo $_SESSION['hotel'] ?><br>
	Arrivée : <?php echo $_SESSION['arrivee'] ?><br>	
	Départ : <?php echo $_SESSION['depart'] ?><br>	
	Chambre(s) : <?php echo $_SESSION['chambre'] ?><br>	
	Personne(s) : <?php echo $_SESSION['personne'] ?></p>

<?php $dbh = new PDO('mysql:host=localhost;dbname=php_expert_devoir2', 'root', '');  

	if(isset($_POST['num_chambre']) AND $_POST['pers_max'])
	{	
		// Insert les valeurs dans une table permettant de voir la sélection de l'utilisateur
		$reservation->insertReservation($_POST['num_chambre'], $_POST['pers_max'], $_SESSION['hotel']);
	}	?>

	<h3>Sélection en cours</h3>

<?php   // Affiche la sélection de l'utilisateur
	 	$reservation->displayReservation();

	 	// Si le client n'est pas authentifié, il doit le faire pour réserver une chambre
		if($_SESSION['client_id'] == null)
		{	
			$authentification->displayAuthentificationForm();
		}	
		else
		{	
			// Si le client est connecté/authentifié, il clique sur le bouton pour réserver une chambre
			$reservation->displayReservationButton();
			// Il pourra aussi se déconnecter
	 		require('../process/inc_deconnexion.php');
		}	?>
	</body>
</html>
