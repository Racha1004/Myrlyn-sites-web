<?php 

class Login
{
	private $error="";

	public function evaluate($data)
	{	
		$pseudo=htmlspecialchars($data['pseudo']);
		$mdp=htmlspecialchars($data['mdp']);

		$query="SELECT * FROM user WHERE pseudo = '$pseudo' LIMIT 1";

		$bdd = new Database();
		$result =$bdd->read($query);

		if($result)				//Verfier si on a bien un utilisateur ayant l email saisi
		{
			$row=$result[0];

			if(password_verify($mdp, $row['mdp']))		//Verifier l'egalité des deux mots de passe
			{ 
			// Creer la session
				$_SESSION['Mirlyn_id']=$row['user_id'];

			}else
			{
				$this->error=$this->error."<li>Mot de passe erroné !</li>";
			}
		}else
		{
			$this->error=$this->error."<li>Le pseudo n'existe pas ! </li>";
		}

		return $this->error;
	}

	public function check_login ($id)
	{
		if(is_numeric($id))
		{
			$query="SELECT * FROM user WHERE user_id = '$id' LIMIT 1";

			$bdd = new Database();
			$result =$bdd->read($query);

			if($result)	
			{
				$user_data=$result[0];
				return $user_data;
			}else
			{
				header("Location: connexion.php ");
					die;
			}
		}else 									
		{
			header("Location: connexion.php ");
			die;
		}

	}

}




?>