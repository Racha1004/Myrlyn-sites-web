<?php 
session_start(); 
if(isset($_POST['precision'])){
	setcookie("precision",htmlspecialchars($_POST['precision']));

}
	
	echo $_COOKIE["precision"];

	include("Mesfonction/TousMesFichiersAinclure.php");

	//verifier si une session a  été ouverte
	//je le garde pour pouvoir le recupere en get apres , car je l'insert dans mon action 
									//  dans le formulaire interne de la page" action="photodeprofil.php?local=<?php echo $_COOKIE['precision']; 

	$login= new Login();
	$user_data=$login->check_login($_SESSION['Mirlyn_id']);


	// Publications
	$error="";
	if($_SERVER['REQUEST_METHOD']=="POST")        
	{
		if(isset($_FILES['file']['name']) && $_FILES['file']['name']!="")
		{

			if($_FILES['file']['type'] == "image/jpeg")
			{
				$taillepermise=(1024*1024)*3;
				if ($_FILES['file']['size'] <$taillepermise ) 
				{

				 	$dossier="uploads/".$user_data['user_id']."/";

					//creer un dossier propre a l'utilisateur
				 	if(!file_exists($dossier))
				 	{
				 		mkdir($dossier,0777,true);
				 	}


					$filename=$dossier.$_FILES['file']['name'];
					move_uploaded_file($_FILES['file']['tmp_name'],$filename);
	
					$userid=$user_data['user_id'];	
					$change="profil";
					//Modifier soit la photo de profil / de couverture selon le GET envoyé
					if(isset($_POST['precision']))  //ICI one verifis si c'est la page de profil qui nous conduit jusqu'ici
					{
						$change=htmlspecialchars($_POST['precision']);
					}else if(!empty($_GET['local'])) {//si cen'est pas le cas c'est que y'a eu un erreur pour a selection du fichier,
														// donc c'est le frmulaire interne qui a envoyé les nouvelles information
						$change=htmlspecialchars($_GET['local']);
					}
					$bdd= new Database();
					$connect=$bdd->connect();
					$filename=mysqli_real_escape_string($connect,$filename); //Pour eviter les injections sql
					if($change=='couverture')
					{
						$query="UPDATE user SET photo_couverture='$filename' WHERE user_id='$userid' LIMIT 1";
					}else
					{
						$query="UPDATE user SET photo_profil='$filename' WHERE user_id='$userid' LIMIT 1";
					}
					$bdd->save($query);
					header("Location: profil.php");
					die;
					
				}else
				{
					$error="<li>Seulemnt les images de taille 3Mb ou moins sont acceptées !</li>";				
				}
			}else
			{
				$error="<li>Seulemnt les images de type Jpeg sont acceptées!</li>";
			}
		}
	}
	





?>


<!DOCTYPE html>
<html>
<head>
	<title>Myrlin | Photo de profil </title>
	<link rel="stylesheet" type="text/css" href="stylephotodeprofil.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
	
		<?php include ('header.php'); ?>

	<!-- Contenu -->
	<div id="contenu">
	<?php

		echo '<div id="error" style="color:red;">';
		echo "<h4>Please correct the following errors !</h4><ul>";
		echo $error;
		echo "<li>Réessayez juste ICI!</li>";	
		echo '</ul></div>';


	?>
			
		<form method="post" enctype="multipart/form-data" action="photodeprofil.php?local=<?php if(isset($_COOKIE['precision'])){echo $_COOKIE['precision'];} ?>">

			<div id="espacemodification" style="margin-bottom: 250px;" >

					<input type="file" name="file">
					<input id="boutton_post" type="submit" value="Changer" name="bout" >
					<br>
			</div>
			
		</form>
	</div>

</body>
<?php
	include 'footer.php';
	?>
</html>