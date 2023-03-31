<div id="Mesphotos" >

	<div id="trait1"></div><h2> Photos publiées </h2><div id="trait1"></div>
	<?php


		$asb=new Post();
		$ab=$asb->dejaabonné($user_data['user_id'],$_SESSION['Mirlyn_id']);
	
		if($user_data['user_id'] == $_SESSION['Mirlyn_id']  || $ab ) //if $ab donc on peux voir et si $user_data['user_id'] == $_SESSION['Mirlyn_id']
		{													//donc je trouve sur notre profil on pourra les voirs aussi 
			$bdd= new Database();															
			$query="SELECT * FROM posts WHERE a_uneimage =1 && user_id = '".$user_data['user_id']."' ORDER BY id DESC";
			$photos=$bdd->read($query);

			if(is_array($photos))
			{
				foreach ($photos as $value) {
					echo "<img src='".$value['image']."' style='width:200px;height:200px;margin:10px;' />";
				}
				
			}else{
				echo '<div id="pasdimages" >Aucune image trouvée !';
			}
		}else{
			echo '<div id="pasdimages" >Aucune image trouvée !';
		}
	?>

</div>