
<?php 
?>
<?php
	include("Mesfonction/connect.php");
	include("Mesfonction/signup.php");

	$pseudo="";
	$age="";
	$sexe="";
	$mail1="";
	$mail2="";

	$result="";
	if(isset($_POST['submit']))
	{
		

		$signup=new Signup();
		$result=$signup->evaluate($_POST);

		if( $result=="")
		{
			header("Location: connexion.php");
			die;
		}
		$pseudo=htmlspecialchars($_POST['pseudo']);
		$age=intval(htmlspecialchars($_POST['age']));
		$sexe=htmlspecialchars($_POST['sexe']);
		$mail1=htmlspecialchars($_POST['mail1']);
		$mail2=htmlspecialchars($_POST['mail2']);
	}

?>



<!DOCTYPE html>
<html>
<head>
	<title> Mirlyn|Inscription </title>
	<link rel="stylesheet" type="text/css" href="stylei.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
	<div id="logo">
		<a href="../Accueil/Accueil.php"><h1>Mirlyn.Sym🍰</h1></a>
		<a href="../Formulaire/connexion.php" title="Me connecter"><h2> ★━━─ <i class="material-icons">account_circle</i> ─━━★</h2></a>
	</div>
	
	<div align="center" id="formulaire">
		<h2> Inscription </h2>
		<br /><br /><br />
		<form method="POST" action="">
			<input type="text" id="pseudo" name="pseudo" placeholder="Votre pseudo" 
			value="<?php echo $pseudo;?>"><br>

			<input type="text" id="age" name="age" placeholder="Votre age" 
			value="<?php echo $age;?>"><br>


			<select name="sexe" id="sexe">
				<option value="homme">Homme</option>
				<option value="femme">Femme</option>
			</select><br>
	
			<input type="email" id="mail1" name="mail1" placeholder="Votre mail"
			 value="<?php echo $mail1; ?>"><br>

			<input type="email" id="mail2" name="mail2" placeholder="Confirmer votre adresse mail " 
			value="<?php echo $mail2; ?>"><br>
	
			<input type="password" id="mdp" name="mdp" placeholder="Votre mot de passe"><br>
	
			<input type="password" id="mdp2" name="mdp2" placeholder="Confirmer votre mot de passe	"><br>

			<input type="submit" name="submit" value="Je m'inscris">
			<input type="reset" name="reset" value="Effacer">
			
		</form>
	</div>
	<?php
		if($result!=""){      //Affucher la liste des erreurs 
			echo '<div id="error">';
			echo "<h4>Please correct the following errors !</h4><ul>";
			echo $result;
			echo '</ul></div>';
		}
	?>

</body>

</html>
