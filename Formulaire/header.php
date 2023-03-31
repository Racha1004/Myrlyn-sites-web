	<!--Top bar -->
	<?php 
	
	//Ici pour la petite photo de notre barre d'info on diot garder celle du user connecté non
	//celle de la personne dont on visite le profil , donc on recupere les infos du user connecté
		$profil= new Profil();
		$profil_data=$profil->get_profile($_SESSION['Mirlyn_id']);

		if(is_array($profil_data))
		{
			$profil_data=$profil_data[0];
			$petite_image="socialimages/female.jpg";
			if($profil_data['sexe'] == "homme")
			{
				$petite_image="socialimages/male.jpg";
			}

			if(file_exists($profil_data['photo_profil']))
			{
				$petite_image=$profil_data['photo_profil'];
			}
		}


	
	?>
	<div id="pink_bar">
		<form method="get" action="search.php">
			<div id="contenubarre" >
				<a href="index.php"  id="logoMir">Mirlyn.Sym🍰</a> 
				&nbsp &nbsp  &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp
				<input type="text" name="find" id="search_box" placeholder="Recherchez des amis ..!">

				<a href="profil.php">
					<img id="petitephotobarre" src="<?= $petite_image; ?>">
				</a>
				<!--<select>
					<option>se deconnecter</option>
					<option>mon profil</option>
				</select>-->
				<a href="deconnexion.php">
					<span id="deconnexion" title="Se deconnecter">
					<i class="material-icons">power_settings_new</i>
				</span>
			</a>
			</div>	 
		  </form>
	</div>