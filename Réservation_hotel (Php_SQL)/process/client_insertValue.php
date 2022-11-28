<?php
for($j = 0 ; $j < count($ensembleTri) ; $j++)
{
	if(($ensembleTri[$j]['pers_max'] < $contraintPers) 
		OR  (  	($ensembleTri[$j]['chambre1'] == $ensembleTri[$j]['chambre2'])
		  	) 
	)
	{continue;}
	else
	{

		$insert_chambre_hotel = ($insert . $hotel);

		for($i = 0 ; $i < $contraintChambre ; $i++)
		{
			$insert_value[$j][] = $ensembleTri[$j]['chambre'. ($i + 1)];
		}

		$insert_value[$j][] = $ensembleTri[$j]['hotels'];

		$insert_final_value = implode("\",\"", $insert_value[$j]);

		$sql = 'INSERT INTO couplechambre(' . $insert_chambre_hotel . ') VALUES("'. $insert_final_value .'");';
		$stmnt = $dbh->prepare($sql);
		$stmnt->execute();	

	}
}