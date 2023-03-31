<?php

session_start();

	include("Mesfonction/connect.php");
	include("Mesfonction/login.php");

	$pseudo="";
	$mdp="";
	$result="";
	if(isset($_POST['connexion']))
	{
		$login=new Login();
		$result=$login->evaluate($_POST);
	
		
		if($result=="")
		{
			header("Location: profil.php");
			die;
		}
		$pseudo=htmlspecialchars($_POST['pseudo']);
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Connexion</title>
	<link rel="stylesheet" type="text/css" href="stylec.css">
</head>
	<body>
	
		<div id="logo">
			<a href="../Accueil/Accueil.php"><h1>Mirlyn.Sym🍰</h1></a>
		</div>
		<!--<img src="image.png" width="350px" height="500px">-->

		<div id="salutation">
			<?php
				if($result!="")
				{
					echo '<div id="error">';
					echo "<h4>Please correct the following errors !😊</h4><ul>";
					echo $result;
					echo '</ul></div>';
				}
				
			?>
			<h1>Page de connexion</h1>
			<h2> Hello </h2>
			<div id="formulaire">
				<form action="" method="POST" >
					<input value="<?php echo $pseudo; ?>" type="text" name="pseudo" placeholder="Pseudo" required><br>
					<input type="password" name="mdp" placeholder="Mot de passe" required><br>
					<button type="submit" name="connexion">Connexion</button>
				</form>
				<div id="trait"></div>
				<a href="inscription.php">Créer un compte!</a>
			</div>
	
		</div>
</body>
	
</html>
<!--<?php/*
session_start();
	$host="localhost";
	$username="root";
	$password="";
	$db="PROJET";

	$connection=mysqli_connect($host,$username,$password,$db);
	$bdd= new PDO ('mysql:host=localhost;dbname=PROJET;charset=utf8','root','');
	if($connection)
	{
		if(isset($_POST['connexion']))
		{
			$mail=htmlspecialchars($_POST['email']);
			$mdp=password_hash($_POST['mdp'], PASSWORD_DEFAULT);
			if(!empty($mail) AND !empty($mdp))
			{
				$requser=$bdd->prepare("SELECT * FROM user WHERE mail = ? AND mdp = ? ");
				$requser->execute(array($mail,$mdp));
				$userexist=$requser->rowCount();
				if($userexist == 1)
				{
					$userinfo=$requser->fetch();
					$_SESSION['id']=$userinfo['id'];
					$_SESSION['pseudo']=$userinfo['pseudo'];
					$_SESSION['mail']=$userinfo['mail'];
					header('Location: profil.php?id='.$_SESSION['id']);
				}
				else
				{
					$error="Mauvais mail ou mot de passe";
				}
			}
			else
			{
				$error="Tous les chmaps doivent etre renseignés !";
			}
		}
	}else
	{
		echo mysql_error($connection);
	}*/
?>-->