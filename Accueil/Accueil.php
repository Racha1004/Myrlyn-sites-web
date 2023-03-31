<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Accueil</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body>
	<header>
		<nav>

			<ul>
				<li id="logo"> <a href="#">Mirlyn.Sym🍰</a></li>
				<li> <a href="../Formulaire/inscription.php">M'inscrire</a></li>
				<li> <a href="../Formulaire/connexion.php">Me connecter</a></li>
			</ul>
		</nav>

		<div id="imageprincipale">
			<h1>Mirlyn</h1>
			<div id="premierTrait"></div>
			<h3>Share your meal with us!</h3>
		</div>
	</header>

	<section id="presentation">
		<div id="textIntro">
			<h2>
				Retrouvez les meilleures recettes avec Mirlyn Cuisine
			</h2>
			<p>
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sed metus vitae elit dictum lacinia nec sed mi. In consequat arcu id porta egestas. Mauris rhoncus enim quis orci mattis feugiat. Aenean feugiat velit in auctor cursus. Curabitur bibendum laoreet sodales. Vivamus sit amet lectus sed ligula porttitor rutrum. Maecenas venenatis aliquam enim, in accumsan quam auctor ut. Phasellus eu semper ante, quis condimentum sapien.  
			</p>
		</div>

		<div id="prestations">
		 	<div class="imagesPrestations">
		 		<h4>Entrées</h4>
		 		<a href="../Formulaire/connexion.php"><img src="Images/salade3.jpg"height="300" width="250"></a>
		 	</div>
		 	<div class="imagesPrestations">
		 		<h4>Plats chauds</h4>
		 		<a href="../Formulaire/connexion.php"><img src="Images/platchaud.jpg" height="300" width="250"></a>
		 	</div>
			<div class="imagesPrestations">
		 		<h4>Desserts</h4>
		 		<a href="../Formulaire/connexion.php"><img src="Images/dessert2.jpg" height="300" width="250"></a>
		 	</div>	
		</div>
	</section >

	<section id="plats">
		<h2>Et tant a decouvrir....!</h2>

		<ul>
			<li id="entree"> 
				<p>Entrée</p>
			</li>
			<li id="platchaud">
				<p>Plats chauds</p>
			</li>
			<li id="dessert"> 
				<p>Dessert</p>
			</li>
		</ul>
	</section>

	<?php
	include('footer.php');
	?>

</body>
</html>