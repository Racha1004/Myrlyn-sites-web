<div id="ami">

	<?php    //Afin de mettre l'image par defaut 

		$image="socialimages/female.jpg";
		if($FRIEND_ROW['sexe'] == "homme")
		{
			$image="socialimages/male.jpg";
		}
		if(file_exists($FRIEND_ROW['photo_profil']))
		{
			$image=$FRIEND_ROW['photo_profil'];
		}


	?>
	<a href="profil.php?id=<?= $FRIEND_ROW['user_id']; ?>">
	<img id="img_ami" src="<?= $image; ?>">
	<?php echo $FRIEND_ROW['pseudo']; ?>
	</a>
	
</div>