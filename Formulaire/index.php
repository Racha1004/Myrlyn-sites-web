<?php 
	
	session_start();

	include("Mesfonction/TousMesFichiersAinclure.php");



	$login= new Login();
	$user_data=$login->check_login($_SESSION['Mirlyn_id']);

	//PPur nos publications

	if($_SERVER['REQUEST_METHOD']=="POST")       
	//isset($_POST['bout'])
	{

		$id=$_SESSION['Mirlyn_id'];
		$post = new Post();
		$result=$post->create_post($id,$_POST,$_FILES);

		if($result=="")
		{
			header("Location: index.php");
			die;
		}else
		{
			echo '<div id="error">';
			echo "<h4>Please correct the following errors !</h4><ul>";
			echo $result;
			echo '</ul></div>';
		}
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Myrlin | fil d'actualité </title>
	<link rel="stylesheet" type="text/css" href="styleindex.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>
<body>
	<?php include ('header.php'); ?>

	<!-- Contenu -->
	<div id="contenu" >
		

		<!--presentation -->
		<div id="presentation" >

			<!--PhotoProfil -->
			<div id="photodeprofil" >
				
				<div id="espacephoto">
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
					<a href="profil.php">
						<img src="<?php echo $image; ?>" style="width: 200px;height: 200px;"
						id="laphoto"><br>
						 <?=  $user_data['pseudo']; ?>
					</a>
				</div>

			</div>

			<!-- publication space -->
			<div id="publications" >
			<!--	//IIIIIIIIICCCCCCCCCCCCCCCCCCCCCCCCCCIIIIIIIII-->
				<div id="champdetexte" >

					<form method="post" enctype="multipart/form-data">

						<textarea name="post" placeholder="What's on your mind ..?"></textarea>
						<input type="file" name="file">
						<input id="boutton_post" type="submit" value="Post" name="bout">
						<br>

					</form>
				</div>


				<!--publication -->
				<div id="post_bar">
					<?php
						$bdd=new Database();
						$user=new User();

						$id_abonnes=false;
						$abonnes=$user->get_following($_SESSION['Mirlyn_id'],'user'); //on recupere nos abonnés
						if(is_array($abonnes))
						{
							//on recupere leurs ids
							$id_abonnes=array_column($abonnes, 'userid');
							$id_abonnes=implode("','", $id_abonnes);   

						}	

						
						$myuserid=$_SESSION['Mirlyn_id'];
						$query="SELECT * FROM posts WHERE  parent=0 AND ( user_id ='$myuserid' OR user_id IN('".$id_abonnes."'))  ORDER BY id DESC";
						$posts=$bdd->read($query);
						
					

						if(isset($posts) && $posts)
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
	</div>
</body>
<?php
	include('footer.php');
?>
</html>