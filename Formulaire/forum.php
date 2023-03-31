<?php
  session_start();
  include("Mesfonction/TousMesFichiersAinclure.php");
  $login= new Login();
	$user_data=$login->check_login($_SESSION['Mirlyn_id']);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Mirlyn | Forum</title>
 <meta charset="utf-8">
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
	 <?php include ('header.php'); ?>

	<section>
	<!-- <h1 class="titre">Bienvenue dans le forum de Mirlyn </h1>--> 
	</section>

	<section id="sect">

		<h2 class="titre"> Forum public </h2>

		<form action="" method="post">
		    <textarea name="message"  placeholder="Votre message" id="messagez"></textarea>
		    <input type="submit" name="envoyer" value="Envoyer" class="boutton">
	  	</form>

	 
	  <?php
		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=PROJET;charset=utf8', 'root', '');
		}
		catch(Exception $e)
		{
		        die('Erreur : '.$e->getMessage());
		}
		// on a bien recu un message non vide 
		if(isset($_POST['envoyer']) && (!empty($_POST['message'])))//pour pas envoyer un message vide
			{

			  $id=$user_data['user_id'];
			  $message=$_POST['message'];
			  $date=date("y-m-d H:i:s");
			  $rep = $bdd->prepare("insert into forum(user_id,message,date) values (?,?,?)"); 
			  $rep->execute(array($id, $message,$date));
				header("location:forum.php");
			}

	  	$reponse = $bdd->query("select * from user,forum where user.user_id= forum.user_id order by msg_id DESC "); 
	  	
		while ($donnees = $reponse->fetch())
		{

			echo '<div id="div1">';
		?>
		<?php 

			$image="socialimages/female.jpg";
			if($donnees['sexe'] == "homme")
			{
				$image="socialimages/male.jpg";
			}

			if(file_exists($donnees['photo_profil']))
			{
				$image=$donnees['photo_profil'];
			}

		?>
	        <img src="<?php echo $image; ?>" class="photo" width="30px" height="30px">
	    <?php
				echo '<br><a href="profil.php?id='.$donnees['user_id'].'">'.$donnees['pseudo'].'</a></div>';
				echo '<div id="div2"><div id="date">Posté le : '.$donnees['date'];
				echo '</div><br>'.$donnees['message'].'</div>';
			}

			$reponse->closeCursor();
	  
		?>
		 	

		
		

	</section>



</body>
<?php 
	include('footer.php');
	?>
</html>

