<?php

	class Role
	{
		protected $dbh;
		protected static $error;
		const MSG_ERROR_ATTRIBUT = "L'attribut doit être positif ";

		public function __construct(PDO $dbh)
		{
			$this->setDb($dbh);
		}

		public function setDb(PDO $dbh)
		{
			$this->dbh = $dbh;
		}

		public function get_role_id(int $id)
		{
			if($id <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}	
			else
			{
				$sql = 'SELECT role_id
						FROM connexion 
						WHERE connexion_id = :connexion_id
						;';
				$stmnt = $this->dbh->prepare($sql);
				$stmnt->bindParam(':connexion_id', $id);				
				$stmnt->execute();
				$row = $stmnt->fetch(PDO::FETCH_ASSOC);	
				$role = $row['role_id'];
				return $role;				
			}		
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}		
		}

		public function get_role_navigationPage(int $id)
		{
			if($id <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}
			else
			{
				$role = $this->get_role_id($id);

				    $sql = 'SELECT nav_name, nav_description
					FROM role_see_nav
					INNER JOIN navigation
					WHERE role_id = :role_id
					AND role_see_nav.nav_id = navigation.nav_id
					;';
					$stmnt = $this->dbh->prepare($sql);
					$stmnt->bindParam(':role_id', $role);					
					$stmnt->execute();
					while($row = $stmnt->fetch(PDO::FETCH_ASSOC))
					{	?>
						<li><a href="<?php echo $row['nav_name'] . $id . '.php' ?>"><?php echo $row['nav_description'] . '.php' ?></a></li>
			<?php	}					
			}
			if(!(empty(self::$error)))
			{
				throw new Exception(self::$error);
			}	
		}

		public function get_navigationPage(int $id)
		{	
			if($id <= 0)
			{
				$this->setError(self::MSG_ERROR_ATTRIBUT);
			}		
			else
			{	?>
				</nav>
					<ul><li><a href="<?php echo 'admin_accueil' . $id . '.php' ?>">Accueil</a></li>
<?php 					$this->get_role_navigationPage($id);	?>
					</ul>
				</nav>				
<?php		}	
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