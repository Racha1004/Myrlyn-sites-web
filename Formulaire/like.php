<?php 

	session_start();

	include("Mesfonction/TousMesFichiersAinclure.php");


	//verifier si une session a  été ouverte i.e si quelqu un est deja connecté'

	$login= new Login();
	$user_data=$login->check_login($_SESSION['Mirlyn_id']);

	if(isset($_SERVER['HTTP_REFERER']))
	{
		$return_to=$_SERVER['HTTP_REFERER'];
	}else
	{
		$return_to="profil.php";	
	}
		
		if(isset($_GET['type']) && isset($_GET['id']))
		{
			if(is_numeric($_GET['id']))
			{
				//on peut aimer un post , un profil(en s y abonnant , ou commenter)
				$possibilités[]= 'post'; //reaction post (j'aime)
				$possibilités[]= 'user'; // abonnement
				$possibilités[]= 'comment'; //commentaires

				if(in_array($_GET['type'], $possibilités))
				{
					$post=new Post();
					$user=new User();
					$post->like_post($_GET['id'],$_GET['type'],$_SESSION['Mirlyn_id']);//on enregiste notre j'aime
					if($_GET['type']=="user")//////////// ici si le type est user donc c'etait plutot un follow , donc on doit mettre a jour nos following
					{
						$user->follow_user($_GET['id'],$_GET['type'],$_SESSION['Mirlyn_id']);
					}
				}
			}
			
		}

		header("Location: ".$return_to);
		die;
?>