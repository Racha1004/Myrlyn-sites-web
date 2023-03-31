		<!--presentation -->
		<div id="presentation">

			<!--Amis -->
			<div id="barreamis">
				
				<div id="liste_amis">
					<div id="aucunepub"> Connaissez-vous peut-être ? </div>
					<?php
						/*if($friends && is_array($friends) && !empty($friends))
						{
							foreach ($friends as $value)
								{
									$FRIEND_ROW=$user->get_user($value['userid']);
									include("friend.php");
								}
						}else
						{
							echo "<div id='aucunepub'> Aucun amis! </div>";
						}*/

						if($friends)
						{
							if($friends)
							{
								foreach ($friends as $FRIEND_ROW) {
									include("friend.php");
								}

							}
						}

					?>
					
				</div>

			</div>

			<!-- publication space -->
			<div id="cotepublications" >
				<!--Pour notre zone de texte -->
				<?php 
					if($user_data['user_id'] == $_SESSION['Mirlyn_id'] )
					{

				?>
				<div id="zonedetexte" >

					<form method="post" enctype="multipart/form-data">

						<textarea name="post" placeholder="What's on your mind ..?"></textarea>
						<input type="file" name="file">
						<input id="boutton_post" type="submit" value="Post" name="bout">
						<br>

					</form>
				</div>

				<?php
					}
				?>
				<!--publication -->
				<div id="post_bar">
					<?php
						$asb=new Post();
						$ab=$asb->dejaabonné($user_data['user_id'],$_SESSION['Mirlyn_id']);
					
						if($posts && ( $user_data['user_id'] == $_SESSION['Mirlyn_id']  || $ab )) //if $ab donc on peux voir et si $user_data['user_id'] == $_SESSION['Mirlyn_id']
																									//donc je trouve sur notre profil on pourra les voirs aussi 
						{
							foreach ($posts as $ROW) 
							{
								$user=new User();
								$ROW_USER= $user->get_user($ROW['user_id']);
								include('post.php');			
							}
						}else
						{
							echo "<div id='aucunepub'> Aucune publication ! </div>";
						}
				

					?>
				</div>
			</div>
			
		</div>