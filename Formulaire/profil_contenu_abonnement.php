<div id="Mesphotos" >

	<div id="trait1"></div><h2> Abonnement </h2><div id="trait1"></div>
	<?php
		$bdd= new Database();
		$post=new Post();
		$user=new User();
		$abonnement=$user->get_following($user_data['user_id'],"user");
		if(is_array($abonnement) && !empty($abonnement))
		{
			foreach ($abonnement as $value) {
				$FRIEND_ROW=$user->get_user($value['userid']);
				include("friend.php");
			}	
		}else{
			echo '<div id="pasdimages" >Aucun abonnement !</div>';
		}
	?>

</div>