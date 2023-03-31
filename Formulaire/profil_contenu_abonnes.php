<div id="Mesphotos" >

	<div id="trait1"></div><h2> Abonnés </h2><div id="trait1"></div>
	<?php
		$bdd= new Database();
		$post=new Post();
		$user=new User();
		$abonnés=$post->get_likes($user_data['user_id'],"user");
		if(is_array($abonnés) && !empty($abonnés))
		{
			echo '<table>';
			foreach ($abonnés as $value) {
				$FRIEND_ROW=$user->get_user($value['userid']);
				include("friend.php");
			}	
			echo '</table>';
		}else{
			echo '<div id="pasdimages" >Aucun abonné !</div>';
		}
	?>

</div>