<?php 
class User
{
	public function get_data($id)
	{
		$query="SELECT * FROM user WHERE user_id ='$id' LIMIT 1 ";

		$bdd= new Database();
		$result=$bdd->read($query);

		if($result)
		{
			$row=$result[0];
			return $row;
		}else
		{
			return false;
		}
	}

	public function get_user($id)
	{
		$query="SELECT * FROM user WHERE user_id ='$id' LIMIT 1 ";

		$bdd= new Database();
		$result=$bdd->read($query);

		if($result)
		{
			$row=$result[0];
			return $row;
		}else
		{
			return false;
		}
	}

	public function get_friends($id)
	{
		$query="SELECT * FROM user WHERE user_id !='$id' ";

		$bdd= new Database();
		$result=$bdd->read($query);

		if($result)
		{
			return $result;
		}else
		{
			return false;
		}
	}

	public function get_following($id,$type){
		$bdd=new Database();

		if(is_numeric($id))
		{
			$bdd=new Database();
			$query="SELECT following FROM likes  WHERE type='$type' && contenu_id = '$id' limit 1";
			$result=$bdd->read($query);

			if(is_array($result))
			{
				$likes = json_decode($result[0]['following'],true);
				return $likes;
			}
		}
		return false;
	}

		public function follow_user($id,$type,$mirlyn_userid)
		{
		
			$bdd=new Database();

			$query="SELECT following FROM likes  WHERE type='$type' && contenu_id = '$mirlyn_userid' limit 1";
			$result=$bdd->read($query);

			if(is_array($result))
			{
				//On va le r ajouter a notre liste
				if(!empty($result[0]['following'])) //si ce n'est pas null
				{
					$likes = json_decode($result[0]['following'],true); //	afin d'obtenir un tableau et non une chaine de caracteres 

					$users_id = array_column($likes,"userid");


					//si il ne l'a pas encore aimé (il ne figure pas deja sur la liste)
					if(!in_array($id, $users_id))
					{
						$tableau['userid'] = $id;
						$tableau['date'] = date("y-m-d H:i:s");

						$likes[] = $tableau;

						$likes_string = json_encode($likes);				
						$query = "UPDATE likes SET following='$likes_string' WHERE type ='$type' && contenu_id='$mirlyn_userid' limit 1";
						$bdd->save($query);

					}else // si l'utilisateur a deja aimé le post bah s il reclique dessus ça va supprimer le j'aime!
					{
						$key = array_search($id, $users_id); //on recupere la cle dans laquelle est stocké les infos de user 
						unset($likes[$key]);					//et on le supprime 

						$following_string = json_encode($likes);				
						$query = "UPDATE likes SET following='$following_string' WHERE type ='$type' && contenu_id='$mirlyn_userid' limit 1";

						$bdd->save($query);

					}
				}else{
					$tableau['userid'] = $id;
						$tableau['date'] = date("y-m-d H:i:s");

						$likes[] = $tableau;

						$likes_string = json_encode($likes);				
						$query = "UPDATE likes SET following='$likes_string' WHERE type ='$type' && contenu_id='$mirlyn_userid' limit 1";
						$bdd->save($query);
				}

			}else
			{
				//on inscrit notre 1 er user au quel on s'est inscris
				$tableau["userid"]=$id;
				$tableau['date']=date("y-m-d H:i:s");

				$likes[] = $tableau;

				//Javascript not•••ation json..	
				//pour pouvoir le convertir en chaine de caracteres et l enregistrer dans notre base de donnees (qui ne prend jamais de tableaux comme donnee)

				$following_string=json_encode($likes);
				$query="INSERT INTO likes (type,contenu_id,following) VALUES ('$type','$mirlyn_userid','$following_string')";
				$bdd->save($query);
				
			}


			/**************************** Ici nous verifions si l'utilisateur a depassé les 5 followers pour le definir comme etant une compte administrateur********************/
			$post=new Post();
			$info=$post->get_likes($id,$type);
			if($info){
				$nombredabonnes=count($info);
				if($info>=5)
				{
					$query="UPDATE user SET admin=1 WHERE user_id='$id' limit 1";
					$bdd->save($query);
				}
				
			}
		}
	

	public function isAdministrateur($id){
		$bdd=new Database();
		$user=new User();
		$donnees=$user->get_user($id);

		if($donnees)
		{
			if($donnees['admin'] == 0){
				return false;
			}else
			{
				return true;
			}
		}else{
			return false;
		}
	}

}
?>