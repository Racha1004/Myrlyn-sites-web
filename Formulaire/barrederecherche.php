	<meta charset="utf-8">
	<?php 
	$bdd= new PDO ('mysql:host=localhost;dbname=test;charser=utf8','root','');
	if(isset($_GET['Recherche']) AND !empty($_GET['Recherche']))
	{	
		$Recherche=htmlspecialchars($_GET['Recherche']);
		$donnees=$bdd->query('SELECT nom FROM jeux_video WHERE nom LIKE "%'.$Recherche.'%" ORDER BY id DESC');
		if($donnees->rowCount() == 0){
			$donnees=$bdd->query('SELECT nom FROM jeux_video WHERE CONCAT( nom," ",console) LIKE "%'.$Recherche.'%" ORDER BY id DESC');
		}
	}
	else
	{
		echo '<font color="red">Aucun parametre reçu ! </font>';
	}

	?>
	<form method="GET">
		<input type="search" name="Recherche" placeholder="Rechercher..">
		<input type="submit" name="valider" placeholder="Valider" value="Valider">
	</form>
	<?php 
	if(isset($donnees) AND $donnees->rowCount()>0) { ?>
		<ul>
			<?php while($s=$donnees->fetch()) {?>
				<li><?= $s['nom'] ?></li>
			<?php } ?>
		</ul>
	<?php
	}
	else if (isset($Recherche))
		{ 
	?>
		Aucun resultat pour<font color="pink"> <?= $Recherche ?> !
	<?php } ?> </font>
		
