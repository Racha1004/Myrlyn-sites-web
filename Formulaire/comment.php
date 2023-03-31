
<div id="post">
	<div>
		

		<?php    //Afin de mettre l'image par defaut 

			$image="socialimages/female.jpg";
			if($user_data['sexe'] == "homme")
			{
				$image="socialimages/male.jpg";
			}

			if(file_exists($user_data['photo_profil']))
			{
				$image=$user_data['photo_profil'];
			}


		?>
		<img src="<?=  $image; ?>" style="width: 75px;height:75px;margin-right: 4px; border-radius: 50%;">
	</div>
	<div style="width: 100%;">		
	


		<div style="font-weight: bold;color: purple;"> 
			<?php
		//----------------petit lien vers le profil
			echo "<a href='profil.php?id=".$ROW['user_id']."'>";
			echo htmlentities($user_data['pseudo']);
			echo "</a>";
		?>	
		</div>

			<?=  $COMMENT['post']; ?>   <!-- Le post  -->

			<br> <br>

			<?php
				if(file_exists($COMMENT['image']))
				{
					$post_image=$COMMENT['image'];
					echo "<img src ='$post_image' style ='width:300px;height:300px;' />"; 
				}
			 	
			?> 

		<br> <br>

		<!-- Pour les likes -->
		<?php
			$likes="";
			$likes = ($COMMENT['likes']>0)?"(".$COMMENT['likes'].")":"";
		?>	
		<a href="like.php?type=post&id=<?php echo $COMMENT['post_id'];  ?>"> Like<?php echo $likes;?><span class="material-icons">
				thumb_up	
			</span></a>
		
		<span style="color: grey">
			<?= $COMMENT['date']; ?>     <!--La date -->
		</span>
		<!-- delete -->
		<span style="color: grey; float: right">
			<a href="/PROJET IO/ProjetBis/Formulaire/delete.php?id=<?php echo $COMMENT['post_id'] ?>">
				Supprimer
			</a> 
			
		</span>
	</div>
</div>