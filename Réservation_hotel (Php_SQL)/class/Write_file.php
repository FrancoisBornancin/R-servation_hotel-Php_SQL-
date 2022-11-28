<?php

	class Write_file
	{

		protected static $error;
		const MSG_ERROR_ATTRIBUT = "L'attribut doit être positif ";

		public function write_connexion_index(string $filename, int $i)
		{
			if($i <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}	
			else
			{
			    $nomdefichier = $filename . $i . '.php';

			    $fichier = fopen($nomdefichier, 'a');

				ftruncate($fichier, 0);

				$lign[] = '<?php 	$string = "' . $filename . '";';	
				$lign[] = "\n" . '		$strlen = strlen($string);';
				$lign[] = "\n" . '		$string2 = basename(__FILE__, \'.php\');';
				$lign[] = "\n" . '		$id = substr($string2, $strlen);';
				$lign[] = "\n" . '		require(\'../admin/' . $filename . '.php\');	?>';

				for($j = 0 ; $j < count($lign) ; $j++)
				{
					fwrite($fichier, $lign[$j]);		
				}

			    fclose($fichier);				
			}	
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}						
		}

		public function write_filename(string $filename, int $i)
		{
			if($i <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}	
			else
			{
			    $nomdefichier = 'write_' . $filename . $i . '.php';

			    $fichier = fopen($nomdefichier, 'a');

				ftruncate($fichier, 0);

				$ligne1 = $filename . $i . '.php';
				fwrite($fichier, $ligne1);

			    fclose($fichier);				
			}			
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}	
		}

		public function write_deconnexion_index_and_action(int $i)
		{
			if($i <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}	
			else
			{
			    $nomdefichier = 'admin_deconnexion' . $i . '.php';

			    $fichier = fopen($nomdefichier, 'a');

				ftruncate($fichier, 0);

				$lign[] = '<?php 	$dbh = new PDO(\'mysql:host=localhost;dbname=php_expert_devoir2\', \'root\', \'\');	';
				$lign[] = "\n" . '		require(\'../class/Admin.php\');';
				$lign[] = "\n" . '		$admin = new Admin($dbh);';
				$lign[] = "\n" . '		session_start();';
				$lign[] = "\n" . '		if(isset($_POST[\'suppression_session\']))';
				$lign[] = "\n" . '		{$_SESSION[\'suppression_session\'] = $_POST[\'id\'];}';
				$lign[] = "\n" . '		else{$_SESSION[\'suppression_session\'] = null;}';
				$lign[] = "\n" . '		$string = "admin_deconnexion";';
				$lign[] = "\n" . '		$strlen = strlen($string);';
				$lign[] = "\n" . '		$string2 = basename(__FILE__, \'.php\');';
				$lign[] = "\n" . '		$id = substr($string2, $strlen);';
				$lign[] = "\n" . '		$admin->update_endConnexion($id);';


				for($j = 0 ; $j < count($lign) ; $j++)
				{
					fwrite($fichier, $lign[$j]);		
				}

				unset($lign);

			    fclose($fichier);				
			}			
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}				
		}

		public function destroy_ConnexionFiles(int $destroy)
		{
			if($destroy <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}	
			else
			{
				unlink('admin_accueil' . $destroy . '.php');
				unlink('admin_dataManagement' . $destroy . '.php');
				unlink('admin_insertData' . $destroy . '.php');
				unlink('admin_adminManagement' . $destroy . '.php');
				unlink('admin_deconnexion' . $destroy . '.php');

				unlink('write_admin_accueil' . $destroy . '.php');
				unlink('write_admin_insertData' . $destroy . '.php');
				unlink('write_admin_dataManagement' . $destroy . '.php');
				unlink('write_admin_adminManagement' . $destroy . '.php');				
			}			
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}	
		}

		public function destroy_ThisConnexionFiles(int $destroy)
		{
			if($destroy <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}	
			else
			{
				$this->destroy_ConnexionFiles($destroy);
				header('location: ../admin/admin_login.php');				
			}		
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}	
		}

		public function destroy_OtherConnexionFiles(int $destroy, int $suppression_session)
		{
			if($destroy <= 0 OR $suppression_session <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}			
			else
			{
				$this->destroy_ConnexionFiles($destroy);
				$write_admin_adminManagement = file_get_contents('write_admin_adminManagement' . $suppression_session . '.php') ;
				header('location: ' . $write_admin_adminManagement);				
			}	
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}	
		}

		public function setError($msg)
		{
			self::$error = $msg;
		}

		public function getError()
		{
			return self::$error;
		}

	}

