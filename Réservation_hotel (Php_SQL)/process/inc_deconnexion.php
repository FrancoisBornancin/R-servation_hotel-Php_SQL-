<?php 	

	// Si le client est connecté, il peut se déconnecter

 	if($_SESSION['client_id'] != null)
	{	
			$client->displayClientDisconnectionButton();
	}		