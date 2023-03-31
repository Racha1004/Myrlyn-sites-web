<?php
  session_start();
  include("Mesfonction/TousMesFichiersAinclure.php");
  $login= new Login();
  $user_data=$login->check_login($_SESSION['Mirlyn_id']);
 
// Effectuer ici la requête qui insère le message
// Puis rediriger vers minichat.php comme ceci :
?>
<!DOCTYPE html>
<html>
<head>
	<title> Messagerie|Mirlyn</title>
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

		<h2 class="titre"> Discussion privée </h2>
		
		<form action="" method="post" id="msg">
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
			if(isset($_GET ['id'])){
				$friend=$_GET['id'];
				$userid=$_SESSION['Mirlyn_id'];
		  	$reponse = $bdd->query("select * from user,messagerie where (user.user_id=$userid and messagerie.sender=$userid and messagerie.receiver=$friend) or ( user.user_id=$friend and messagerie.sender=$friend and messagerie.receiver=$userid) order by id "); 
		  	
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
			}
		?>
		 

		
		 <?php 
			if(isset($_POST['envoyer']) && !empty( $message=$_POST['message']))
			{

			  $id=$user_data['user_id'];
			  $receiver=$_GET['id'];
			  $message=$_POST['message'];
			  $date=date("y-m-d H:i:s");
			  $rep = $bdd->prepare("insert into messagerie(sender, receiver,message,date) values (?,?,?,?)"); 
			  $rep->execute(array($id,$receiver,$message,$date));
				header("location: msg.php?id=$receiver");
			}

		?> 




	 
	</section>



</body>
  <?php include ('footer.php'); ?>

</html>
