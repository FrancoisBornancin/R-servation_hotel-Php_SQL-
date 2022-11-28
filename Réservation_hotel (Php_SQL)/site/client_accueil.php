<?php 	require('../process/inc_connexion.php');
		$title = "Accueil";
		$connexion->DOCTYPE_html($title);

// Affiche tous les hotels
		$displayHotel_ville = $hotel->displayHotel_ville();	
?>
		<h3>Trouvez votre prochain séjour</h3>

		</nav>
			<ul><li><a href="client_accueil.php">Accueil</a></li>				
<?php 	if($_SESSION['client_id'] != null)
		{	?>
				<li><a href="client_result_reservation.php?client=' . $_SESSION['client_id'] . '">Historique des réservations</a></li>	
<?php	}	?>
			</ul>
		</nav>

		<form action="client_hotel.php" method="post">
			<label>Votre ville : </label>
				<select name="villes">
<?php		 for($i = 0 ; $i < count($displayHotel_ville) ; $i++)
			{	?>
				<option value="<?php echo $displayHotel_ville[$i] ?>"><?php echo $displayHotel_ville[$i] ?></option>
<?php			}	?>
				</select>
			<input type="date" name="arrivee">
			<input type="date" name="depart">		
 			<label>Chambre(s) : </label>
				<select name="chambre">
<?php 				for($i = 1 ; $i < 6 ; $i++)
					{    ?>
						<option value="<?php echo $i ?>"><?php echo $i ?></option>		
<?php				} ?>
				</select>
 			<label>Personne(s) : </label>
				<select name="personne">
<?php 				for($i = 1 ; $i < 20 ; $i++)
					{   ?> 
						<option value="<?php echo $i ?>"><?php echo $i ?></option>
<?php					} ?>
				</select>
			<input type="submit" name="envoyer">
		</form>

<?php 	require('../process/inc_deconnexion.php')	?>		



	</body>
</html>

