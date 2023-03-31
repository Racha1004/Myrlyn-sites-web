<?php
class Signup
{
	private $error="";

	public function Valide_Pseudo($s)
	{
		$query="SELECT pseudo FROM user WHERE pseudo = '".$s."'";
		$bdd = new Database();
		$resultat = $bdd->read($query);
		if($resultat != false && count($resultat)!=0)
		{
			return false;
		}else
		{
			return true;
		}
	}
	public function evaluate($data)
	{
		foreach ($data as $key => $value) {

			if(empty($value))						//verifier si tous nos champs ont été remplis
			{
				$this->error=$this->error."<li>".$key." est vide ! </li>";
			}

			if($key == "pseudo")
			{
				if(!$this->Valide_Pseudo($value))				 //verifier si le pseudo a deja été utilisé
				{
					$this->error=$this->error."<li>".$key." deja utilisé ! </li>";
					
				}
				if(strlen($value) >=20){     //fixer la taille maximale de nos pseudo a 20
					$this->error=$this->error."<li>".$key."  trop long ! </li>";
				}
			}

			if($key == "age")							//verifier s l'age de notre utilisateur est superieur a 18 ans
			{
				if(is_numeric($value))
				{
					if($value <= 18)
					{
						$this->error=$this->error."<li>Ce site est reservé aux personnes de plus de 18 ans ! </li>";
					}
				}else{
					$this->error=$this->error."<li>Veuillez inserer une valeur numerique s'il vous plait! </li>";
				}
				
			}

			if($key == "email")							//verifier si le mail est valide
			{
				if(preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $value))
				{
					$this->error = $this->error."<li>Adresse mail invalide ! </li>";
				}
			}
		}



		if($data['mail1'] != $data['mail2'])					//Si les deux emails correspondent 
		{
			$this->error=$this->error."<li> Vos emails ne conrrespondent pas ! </li>";
		}



		if($data['mdp'] != $data['mdp2'])						//si les deux mots de passe saisis sont les memes
		{
			$this->error=$this->error."<li>Vos mots de passe ne conrrespondent pas ! </li>";

		}

		if(!empty($data['mdp'])){
			if(strlen($data['mdp'])!=8 OR !preg_match("/[A-Za-z0-9]/i",$data['mdp']))//exiger une longuer, une majuscule,une minuscule et un chiffre
			{
				$this->error=$this->error."<li>Le mot de passe doit contenir 8 
				caracteres dont au moins un chiffre, une majuscule et une minuscule!</li>";

			}

		}
		

		if($this->error=="")								//si tout va bien donc aucune erreur on enregistre
		{
			$this->create_user($data);
		}
		else
		{
			return $this->error;						//sinon on affiche les erreurs
		}
	}

	public function create_user($data)
	{	
		//Pour se proteger des injections sql
		$bdd = new Database();
		$connect=$bdd->connect();
		$pseudo=$connect-> real_escape_string($data['pseudo']);
		$age=intval($connect-> real_escape_string($data['age']));
		$sexe=$connect-> real_escape_string($data['sexe']);
		$mail1=$connect-> real_escape_string($data['mail1']);
		$mail2=$connect-> real_escape_string($data['mail2']);
		$mdp=password_hash($data['mdp'], PASSWORD_DEFAULT);

		

		//on genere l'id 
		$url_adresse=strtolower($pseudo);
		$user_id=$this->create_userid();
		$query="INSERT INTO user(user_id,pseudo,age,sexe,mail,mdp,url_adresse) 
			VALUES ('$user_id','$pseudo','$age','$sexe','$mail1','$mdp','$url_adresse')";
		$bdd->save($query);
	}

	private function create_userid()
	{
		$longuer = rand(4,19);
		$number="";
		for($i=0;$i<$longuer;$i++)
		{
			$new_rand=rand(0,9);
			$number=$number.$new_rand;
		}
		return intval($number);
	}
}




?>