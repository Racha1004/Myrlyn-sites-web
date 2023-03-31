<?php
class Post
{
	private $error="";
	public function create_post($userid,$data,$files)
	{
		if(!empty($data['post']) || !empty($files['file']['name']))
		{
 			$a_uneimage=0;

			if(!empty($files['file']['name']))
			{

				 	$dossier="uploads/".$userid."/";

						//creer un dossier propre a l'utilisateur
					 	if(!file_exists($dossier))
					 	{
					 		mkdir($dossier,0777,true);
					 	}


						$myimage=$dossier.$_FILES['file']['name'];
						move_uploaded_file($_FILES['file']['tmp_name'],$myimage);

					$a_uneimage=1;
			}
			$post = htmlspecialchars($data['post']);
			$postid = $this->create_postid();
			//parent----------------------------
			$db = new Database();
			$parent=0;

			if(isset($data['parent']) && is_numeric($data['parent'])){
				$parent=$data['parent'];
				$sql="UPDATE posts set comments= comments +1 where post_id='$parent' limit 1";
				$db-> save($sql);

			}

			$query = "INSERT INTO posts(post_id,user_id,post,image,a_uneimage,parent) VALUES ('$postid','$userid','$post','$myimage','$a_uneimage','$parent')";
			//--------------------------------------

			
			$db-> save($query);


		}else
		{
			$this->error="Veuillez taper quelque chose a publier si vous le voulez bien ! ";
		}

			

		return  $this->error;
	}



	public function get_posts($id) 
	{
		$query="SELECT * FROM posts WHERE parent=0 AND user_id= '$id' ORDER BY id  DESC LIMIT 10";

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
	public function get_likes($id,$type){
		if(is_numeric($id))
		{
			$bdd=new Database();
			$query="SELECT likes FROM likes  WHERE type='$type' && contenu_id = '$id' limit 1";
			$result=$bdd->read($query);

			if(is_array($result))
			{
				$likes = json_decode($result[0]['likes'],true);
				return $likes;
			}
		}
		return false;
	}
	//-----------commentaire--------------------
	public function get_comments($id ) 
	{
		$query="SELECT * FROM posts WHERE parent= '$id' ORDER BY id asc LIMIT 10";

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

	//supprimer un post----------------------
	public function get_one_posts($postid) 
	{
		if (!is_numeric($postid)) {
			return false;
		}
		$query="SELECT * FROM posts WHERE post_id= '$postid' LIMIT 1";

		$bdd= new Database();
		$result=$bdd->read($query);

		if($result)
		{
			return $result[0];
		}else
		{
			return false;
		}

	}


	public function delete_post($postid) 
	{
		if (!is_numeric($postid)) {
			return false;
		}

		$bdd= new Database();
		$sql="SELECT parent from posts where post_id='$postid' limit 1";
		$result=$bdd->read($sql);

		if (is_array($result))	{
			if($result[0]['parent']>0){
				$parent=$result[0]['parent'];
				$sql="UPDATE posts set comments=comments-1 where post_id='$parent' limit 1";
				$bdd-> save($sql);

			}
		}

		$query="DELETE FROM posts WHERE post_id='$postid' OR parent='$postid'";
		$bdd->save($query);
		$query="DELETE FROM likes WHERE contenu_id='$postid'";
		$bdd->save($query);

	}
	public function delete_comments($postid){
		if (!is_numeric($postid)) {
			return false;
		}
		$bdd=new Database();
		$sql2="DELETE FROM posts WHERE parent='$postid' AND ";
		$bdd->save($sql2);
	}
 //------------------
	public function like_post($id,$type,$userid)
	{
		
			$bdd=new Database();

			//enregistrer les membres ayant aimé le post
			$query="SELECT likes FROM likes  WHERE type='$type' && contenu_id = '$id' limit 1";
			$result=$bdd->read($query);

			if(is_array($result))
			{
				//On va le rajouter a notre liste
				if(!empty($result[0]['likes'])) // si ce nest pas null 
				{
					$likes = json_decode($result[0]['likes'],true); //	afin d'obtenir un tableau et non une chaine de caracteres 

					$users_id = array_column($likes,"userid");


					//si il ne l'a pas encore aimé (il ne figure pas deja sur la liste)
					if(!in_array($userid, $users_id))
					{
						$tableau['userid'] = $userid;
						$tableau['date'] = date("y-m-d H:i:s");

						$likes[] = $tableau;

						$likes_string = json_encode($likes);				
						$query = "UPDATE likes SET likes='$likes_string' WHERE type ='$type' && contenu_id='$id' limit 1";
						$bdd->save($query);

						//incrementer le nombre de likes/followers
						if($type=='post')
						{
							$query="UPDATE posts SET likes=likes+1 WHERE post_id='$id' limit 1";
						}else if($type=='user')
						{
							$query="UPDATE user SET likes=likes+1 WHERE user_id='$id' limit 1";
						}
						

						$bdd->save($query);

					}else // si l'utilisateur a deja aimé le post bah s il reclique dessus ça va supprimer le j'aime!
					{
						$key = array_search($userid, $users_id); //on recupere la cle dans laquelle sont stockées les infos de user 
						unset($likes[$key]);					//et on la supprime 

						$likes_string = json_encode($likes);				
						$query = "UPDATE likes SET likes='$likes_string' WHERE type ='$type' && contenu_id='$id' limit 1";

						$bdd->save($query);

						//se desabonner ou retirer sson like
						if($type=='post')
						{
							$query="UPDATE posts SET likes=likes-1 WHERE post_id='$id' limit 1";
						}else if($type=='user')
						{
							$query="UPDATE user SET likes=likes-1 WHERE user_id='$id' limit 1";
						}

						$bdd->save($query);
					}
				}else{// si c'est null cela veut dire que la ligne existe c'est juste la colones likes qui est a null 
					//pas la peine donc d'en creer un autre il suffit de modier celle ci
						 $tableau['userid'] = $userid;
						$tableau['date'] = date("y-m-d H:i:s");

						$likes[] = $tableau;

						$likes_string = json_encode($likes);				
						$query = "UPDATE likes SET likes='$likes_string' WHERE type ='$type' && contenu_id='$id' limit 1";
						$bdd->save($query);

						//incrementer le nombre de likes/followers
						if($type=='post')
						{
							$query="UPDATE posts SET likes=likes+1 WHERE post_id='$id' limit 1";
						}else if($type=='user')
						{
							$query="UPDATE user SET likes=likes+1 WHERE user_id='$id' limit 1";
						}
						

						$bdd->save($query);
				}
				
				
			}else 		//si personne n'a encore aimé le post on se charge de creer le premeir tableau contenant notre premier 				fan!
			{

				$tableau["userid"]=$userid;
				$tableau['date']=date("y-m-d H:i:s");

				$likes[] = $tableau;

				//Javascript not•••ation json..	
				//pour pouvoir le convertir en chaine de caracteres et l enregistrer dans notre base de donnees (qui ne prend jamais de tableaux comme donnee)

				$likes_string=json_encode($likes);
				$query="INSERT INTO likes (type,contenu_id,likes) VALUES ('$type','$id','$likes_string')";
				$bdd->save($query);
				//incrementer le nombre de likes/followers
				if($type=='post')
				{
					$query="UPDATE posts SET likes=likes+1 WHERE post_id='$id' limit 1";
				}else if($type=='user')
				{
					$query="UPDATE user SET likes=likes+1 WHERE user_id='$id' limit 1";
				}

				$bdd->save($query);
			}

		
		
	}

	public function dejaabonné($id,$userid)
	{
		$bdd=new Database();

			$query="SELECT likes FROM likes  WHERE type='user' && contenu_id = '$id' limit 1";
			$result=$bdd->read($query);
			if(is_array($result))//si ce n'est pas le boolean false 
			{
				if(!empty($result[0]['likes']))//si ce n'est pas null
				{
					$likes = json_decode($result[0]['likes'],true); //	afin d'obtenir un tableau et non une chaine de caracteres 

					$users_id = array_column($likes,"userid");
					if(!in_array($userid, $users_id))//si le userd id figure dans le tableau donc il est abonne au ccompte de id
					{
						return false;
					}else
					{
						return true;
					}
				}else{
					return false;
				}
			}else
			{
				return false;
			}
	}


	private function create_postid()
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