<?php 

	$dbh = new PDO('mysql:host=localhost;dbname=php_expert_devoir2', 'root', '');	
/*	require('../class/Admin.php');
	$resa = new Admin($dbh);
	$resas = get_class_methods($resa);
	var_dump($resas);
*/

				for($i = 2 ; $i < (3 + 1) ; $i++)
				{
					$chambres = ('chambre' . $i); 
					$sql = 'ALTER TABLE couplechambre ADD :chambres varchar(255) NOT NULL;' ; 
					$stmnt = $dbh->prepare($sql);
					$stmnt->bindParam(':chambres', $chambres);						
					$stmnt->execute();
				}	







