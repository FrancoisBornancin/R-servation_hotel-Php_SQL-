<?php 	require('../process/inc_connexion.php');
		$title = "Historique";
		$connexion->DOCTYPE_html($title);	?>

<?php 	
		if($_SESSION['client_id'] == null)
		{
			$_SESSION['nom'] = $_POST['nom'];
			$_SESSION['mail'] = $_POST['mail'];			
		}
	
?>
		</nav>
			<ul><li><a href="client_accueil.php">Accueil</a></li>
				<li><a href="client_reservation.php">Reservation</a></li>
			</ul>
		</nav>

<?php
		if($_SESSION['nom'] == "" AND $_SESSION['mail'] == "")
		{
			echo "Vous ne vous êtes pas authentifié";	?>
			<h3><a href="client_accueil.php">Retour à la sélection des hotels</a></h3> 
<?php	}
		elseif($_SESSION['nom'] == "" OR $_SESSION['mail'] == "")
		{
			echo "Le champ Nom ou Mail est manquant"; ?>
<?php	}		
		else
		{	
			// Recherche le nom du client dans la Base de données
			$selectClient_Nom = $authentification->selectClient_Nom($_SESSION['nom']);
			if($selectClient_Nom == 0)
			{   
				// Si le nom du client n'est pas connu, on lui propose de se créer un nouveau compte 
				$authentification->displayNouveauCompteButton($_SESSION['nom'], $_SESSION['mail']);

				if(isset($_POST['nouveau_compte']))
				{	
					// S'il clique sur Ok, un formulaire de création de compte s'affiche
					$authentification->displayClientCreationForm($_SESSION['nom'], $_SESSION['mail']);
				}	

				if(isset($_POST['insert_nouveau_compte']))
				{	
					if($_POST['nouveau_compte_nom'] == "" OR $_POST['nouveau_compte_mail'] == "")
					{
						echo "Le champ Nom ou Mail est manquant <br>"; 	
					}
					else
					{	
						$client->createClient($_POST['nouveau_compte_nom'], $_POST['nouveau_compte_mail']);
						echo "Le compte a bien été créé"; 	
					}	
				}	
			}
			else
			{
				$selectClient_Mail = $authentification->selectClient_Mail($_SESSION['nom'], $_SESSION['mail']);
				if($selectClient_Mail == 0)
				{
					echo "Votre nom est reconnu mais pas votre mail" . "<br>"; 
				}
				else
				{
					$date = date('Y-m-d');

					// Compte le nombre de chambre sélectionnées pour réservation
					$count = $booking->getCountReservation();

					if($count > 0)
					{	
						try
						{	
							// Si des chambres sont sélectionnées, on les insère dans une table dédiée
							$booking->client_insertReservation($_SESSION['nom'], $_SESSION['mail'], $_SESSION['arrivee'], $_SESSION['depart'], $date);
							echo "La réservation a bien été prise en compte" . "<br>";			
						}
						catch(Exception $e)
						{
							echo $e->getMessage();
							exit;
						}
					}	?>

					<h3>Historique des réservations :</h3>	
<?php					
						try
						{	
							// Affichage des réservations à venir avec possibilité de suppression
							$booking->client_displayFuturBooking($_SESSION['client_id'], $date);

							// Affichage des réservations à venir sans possibilité de suppression	
							$booking->client_displayPastBooking($_SESSION['client_id'], $date);	
						}
						catch(Exception $e)
						{
							echo $e->getMessage();
							exit;
						}

						// On vide et recrée la table des sélections de chambre pour que l'utilisateur puisse faire une nouvelle sélection si voulu
						$reservation->dropReservation();
						$reservation->createReservation();
				}
			}
		}	
	 	require('../process/inc_deconnexion.php');	?>


	</body>
</html>

