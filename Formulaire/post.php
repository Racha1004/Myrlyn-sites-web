
<div id="post">
	<div>

		<?php    //Afin de mettre l'image par defaut 

			$image="socialimages/female.jpg";
			if($ROW_USER['sexe'] == "homme")
			{
				$image="socialimages/male.jpg";
			}

			if(file_exists($ROW_USER['photo_profil']))
			{
				$image=$ROW_USER['photo_profil'];
			}


		?>
		<img src="<?=  $image; ?>" id="imageuser" >
	</div>
	<div style="width: 100%;">			

		<div id="nomuser"> 
			<a href="profil.php?id=<?= $ROW_USER['user_id']; ?>">
				<?=$ROW_USER['pseudo'];?>
			</a>
		</div>

			<?=  $ROW['post']; ?>   <!-- Le post  -->

			<br> <br>

			<?php
				if(file_exists($ROW['image']))
				{
					$post_image=$ROW['image'];
					echo "<img src ='$post_image' style ='width:300px;height:300px;' />"; 
				}
			 	
			?> 

		<br> <br>

		<!-- Pour les likes -->
		<?php
			$likes="";
			$likes = ($ROW['likes']>0)?"(".$ROW['likes'].")":"";
		?>	
		<a href="like.php?type=post&id=<?php echo $ROW['post_id'];  ?>">Like <?php echo $likes;?>
			<span class="material-icons">
				thumb_up	
			</span>
		</a>.|.
		<!-- compter les commentaires------------------->
		<?php
			$comments="";
			if($ROW['comments']>=0){
				$comments="(".$ROW['comments'].")";
			}
		?>
		<a href="single_post.php?id=<?php echo $ROW['post_id']?>">Comment<?php echo $comments; ?></a> .|.
		<span style="color: grey">
			<?= $ROW['date']; ?>     <!--La date -->
		</span>

		<!-- delete --    //Verifier si on a le droit de supprimer le post-(admin ou propritaire)------------------------------------------>
		<?php

		$user=new User();
			$admin=$user->isAdministrateur($_SESSION['Mirlyn_id']);
			if($admin || $user_data['user_id'] == $_SESSION['Mirlyn_id']){
			
		?>

		<span style=" float: right">
			<a href="delete.php?id=<?php echo $ROW['post_id'] ?>">
				Supprimer
			</a> 
			
		</span>

		<?php
			}
		?>
	</div>
</div>