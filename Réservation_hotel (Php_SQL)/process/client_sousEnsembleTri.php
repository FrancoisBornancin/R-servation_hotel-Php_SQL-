<?php
for($i = 0 ; $i < count($ensemble) ; $i++){
for($j = 0 ; $j < count($ensemble) ; $j++){
$resultPers_max = ($ensemble[$i]['pers_max'] + $ensemble[$j]['pers_max']);
$resultNum_chambre = ($ensemble[$i]['num_chambre'] + $ensemble[$j]['num_chambre']);
{
$ensembleTri[$index]['chambre1'] = $ensemble[$i]['num_chambre'];
$ensembleTri[$index]['chambre2'] = $ensemble[$j]['num_chambre'];
$ensembleTri[$index]['hotels'] = $ensemble[$j]['hotel_nom'];
$ensembleTri[$index]['pers_max1'] = $ensemble[$i]['pers_max'];
$ensembleTri[$index]['pers_max2'] = $ensemble[$j]['pers_max'];
$ensembleTri[$index]['pers_max'] = $resultPers_max;
$index++;
}
}
}