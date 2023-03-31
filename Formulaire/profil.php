		<?php 
	
	session_start();

	include("Mesfonction/TousMesFichiersAinclure.php");


	//verifier si une session a  été ouverte

	$login= new Login();
	$user_data=$login->check_login($_SESSION['Mirlyn_id']);

	//Notre classe profil qui collectera toutes les donnees d un utilisateur
	if(isset($_GET['id']))
	{
		$profil= new Profil();
		$profil_data=$profil->get_profile($_GET['id']);

		if(is_array($profil_data))
		{
			$user_data=$profil_data[0];
		}

	}


	// Publications

	if($_SERVER['REQUEST_METHOD']=="POST")       
	//isset($_POST['bout'])
	{

		$id=$_SESSION['Mirlyn_id'];
		$post = new Post();
		$result=$post->create_post($id,$_POST,$_FILES);

		if($result=="")
		{
			header("Location: profil.php");
			die;
		}else
		{
			echo '<div id="error">';
			echo "<h4>Please correct the following errors !</h4><ul>";
			echo $result;
			echo '</ul></div>';
		}
	}

	//Poster les publications

	$id=$user_data['user_id'];
	$post = new Post();

	$posts=$post->get_posts($id);

	//Barre d'amis

	$user = new User();
	$friends=$user->get_friends($id);
	/*$friends=$user->get_following($user_data['user_id'],"user");*/




?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Myrlin | Profil </title>
	<link rel="stylesheet" type="text/css" href="styleprofil.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body>
	
		<?php include ('header.php'); ?>

	<!----------------------------------------Couverture------------------------------------------------------------------------------------->
	<div id="couverture">
		<div id="fondphotodecouverture" > 

			<?php    //Afin de mettre l'image par defaut 

					$image1="socialimages/female.jpg";
					if($user_data['sexe'] == "homme")
					{
						$image1="socialimages/male.jpg";
					}
					//Afficher la photo de profil choisie par le user si elle existe
					if(file_exists($user_data['photo_couverture']))
					{
						$image1=$user_data['photo_couverture'];
					}


				?>

			<img id="taillephotodecouverture" src="<?php echo $image1; ?>" >



			<span id="lienmodifierphotoprofiletcouverture">
				<?php    //Afin de mettre l'image par defaut 

					$image="socialimages/female.jpg";
					if($user_data['sexe'] == "homme")
					{
						$image="socialimages/male.jpg";
					}

					if(file_exists($user_data['photo_profil']))
					{
						$image=$user_data['photo_profil'];
					}


				?>
			 <!-----------------------------------MODIFICATION PHOTO PROFIL/COUVERTURE----------------------------------------------------------------->

				<img id="photodeprofil" src="<?php echo $image; ?>"><br>	


				<?php //on doit pouvoir modifier sa photo de profile seulement si on est connecté a notre compte
					if($user_data['user_id'] == $_SESSION['Mirlyn_id'] )
					{
				?>
				<form method="post" enctype="multipart/form-data" action="photodeprofil.php" id="form" style="display: none;">

						<div id="espacemodification">
							<input type="hidden" name="precision" id="phototype" value="profil">
							<input type="file" name="file" id='file-input'>
							<input  type="submit" value="Changer" name="bout" >

							<br>
						</div>		
				</form>
					<a href="#" id="imageprofil">     Modifer ma photo de profil</a> |	
					<a href="#" id="imagecouverture">     Modifer ma photo de couverture</a> 
				<?php
					}
				?>
			</span> 
			<br>
			<!----------------------------------------PSEUDO-------------------------------------------------------------------------------------->

			<a href="profil.php?id=<?php echo $user_data['user_id']; ?>">
				<div id="pseudo"><?= $user_data['pseudo'] ?></div>
			</a>
			<?php
				$user=new User();
				$admin=$user->isAdministrateur($_SESSION['Mirlyn_id']);
				if($admin && $user_data['user_id'] ==  $_SESSION['Mirlyn_id'] ){
					echo '<i class="material-icons" title="Admin">ADMIN<br>stars</i>';   //Afficher une etoile pour un copmte administrateur
				}
			?>
			<!-------------------------------------------Forum-------------------------------------------------------------->
			<!-- forum -->
			<?php //on doit pouvoir modifier sa photo de profile seulement si on est connecté a notre compte
					if($user_data['user_id'] == $_SESSION['Mirlyn_id'] )
					{
				?>
			<a href="forum.php?id=<?php echo $user_data['user_id']; ?>">
				<input type="button" id="boutton_post" value="Forum" style="width: 90px; margin-right: 10px;">
			</a>

			<?php
				}
			?>
			<!----------------------------------------ABONNEMENT---------------------------------------------------------------------------------->
				<?php //on doit pouvoir modifier sa photo de profile seulement si on est connecté a notre compte
					if($user_data['user_id'] != $_SESSION['Mirlyn_id'] )
					{
				?>
				<div id="boutton_follow">
					<?php
						$asb=new Post();
						$ab=$asb->dejaabonné($user_data['user_id'],$_SESSION['Mirlyn_id']);//Afin de mettre follow ou unfollow
					?>
					<a href="like.php?type=user&id=<?php echo $user_data['user_id']; ?>">
						<input type="button" id="boutton_post" value="<?php if($ab){echo 'Unfollow';}else{echo 'Follow';} ?>">
					</a>

				</div>
				<a href="msg.php?id=<?php echo $user_data['user_id']; ?>">
					<input type="button" id="boutton_post" value="Ecrire" style="width: 90px; margin-right: 10px;">
				</a>
				<?php
					}
				?>
			<!----------------------------------------RECUPERER LE NOMBRE D'ABONNÉS ET DES FOLLOWING-------------------------------------------->
			<?php
				$mesfollowers=$user_data['likes'];
				$following=0;
				$bdd= new Database();
				$post=new Post();
				$user=new User();
				$abonnement=$user->get_following($user_data['user_id'],"user");
				if(is_array($abonnement) && !empty($abonnement))
				{
					$following=count($abonnement);
				}

			?>
			<!-----------------------------------------LIENS VERS PHOTOS/ABONNES/ABONNEMENT------------------------------------------------------>
			<a href="index.php">
				<div id="menu_b">Fil d'actualité<i class="material-icons">web</i></div> 
			</a>
			<a href="profil.php?contenu=abonnes&id=<?php echo $user_data['user_id']; ?>">
				<div id="menu_b" title="Abonnés">Abonnés<?php echo '('.$mesfollowers.')'; ?><br><i class="material-icons">people_outline</i></div>
			</a>
			<a href="profil.php?contenu=abonnement&id=<?php echo $user_data['user_id']; ?>">
				<div id="menu_b" title="Abonnement">Abonnement<?php echo '('.$following.')'; ?><br><i class="material-icons">group</i></div>
			</a>
			<a href="profil.php?contenu=photos&id=<?php echo $user_data['user_id']; ?>">
				<div id="menu_b" title="Photos">Photos <br><i class="material-icons">insert_photo</i></div>
			</a>

		</div>

		<!-------------------------------------------CORPS ET CONTENU DE MA PAGE---------------------------------------------------------------->
		<!-- Contenu de mon profil -->
		<?php

			$contenu="pardefaut"; //pour afficher le profil de l'utilisateur 
			if(isset($_GET['contenu']))
			{
				$contenu=$_GET['contenu'];
			}

			if($contenu=="pardefaut")      //Ici nous avons 3 possibilités soit 'photos' ou 'amis' ou rien est dans 
			{								// ce cas là on aura l'affichage du profil de l'utilisateur connecté
				include('contenu_profil_pardefaut.php');
			}else if($contenu=="photos")
			{
				include('contenu_profil_photo.php');				
			}else if($contenu=="abonnes")
			{
				include('profil_contenu_abonnes.php');				
			}else if($contenu=="abonnement")
			{
				include('profil_contenu_abonnement.php');				
			}
		?>

		
	</div>

	<!-----------------------------JAVA SCRIPT POUR LA MODIFICATION DE MA PHOTO DE PROFIL ET COUVERTURE------------------------------------------------>
	<?php //on doit pouvoir modifier sa photo de profile seulement si on est connecté a notre compte
		if($user_data['user_id'] == $_SESSION['Mirlyn_id'] )
		{
	?>
	<script type="text/javascript">
		(function (){
			document.getElementById('imageprofil').onclick=function(){
				document.getElementById('phototype').value='profil';
				document.getElementById('file-input').click()
			};

			document.getElementById('imagecouverture').onclick=function(){
				document.getElementById('phototype').value='couverture';
				document.getElementById('file-input').click()
			};

			document.getElementById('file-input').onchange=function(){
				document.getElementById('form').submit()
			}	
		})();
	</script>
	<?php
		}
	?>
</body>
<?php
	
	include('footer.php');


?>
</html>