
<div id="post">
	<div>
		<?php    //Afin de mettre l'image par defaut 

			$image="socialimages/female.jpg";
			if($ROW_USER['sexe'] == "homme")
			{
				$image="socialimages/male.jpg";
			}

		?>
		<img src="<?=  $image; ?>" style="width: 75px;margin-right: 4px;">
	</div>
	<div>			

		<div style="font-weight: bold;color: purple;"> 
			<?=$ROW_USER['pseudo'];?>
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

	</div>
</div>