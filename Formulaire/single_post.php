 <?php 
	
	session_start();

	include("Mesfonction/connect.php");
	include("Mesfonction/login.php");
	include("Mesfonction/user.php");
	include("Mesfonction/post.php");
	include("Mesfonction/profil.php");
	


	$login= new Login();
	$user_data=$login->check_login($_SESSION['Mirlyn_id']);
	$User=$user_data;

	$Post= new Post();
	if(isset($_GET['id']) && is_numeric($_GET['id'])){
		$profile=new Profil();
		$profile_data= $profile->get_profile($_GET['id']);

		if (is_array($profile_data)){
			$user_data=$profile_data[0];
		}
	}
	// Publications

	if($_SERVER['REQUEST_METHOD']=="POST")       
	//isset($_POST['bout'])
	{

		$id=$_SESSION['Mirlyn_id'];
		$post = new Post();
		$result=$post->create_post($id,$_POST,$_FILES);

		if($result=="")
		{
			header("Location: single_post.php?id=$_GET[id]");
			die;
		}else
		{
			echo '<div id="error">';
			echo "<h4>Please correct the following errors !</h4><ul>";
			echo $result;
			echo '</ul></div>';
		}
	}

	// Publications

	$Post=new Post();
	$ROW=false;
	$ERROR="";
	if(isset($_GET['id'])){
		$ROW=$Post->get_one_posts($_GET['id']);
	}else{
		$ERROR="no post was found ";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Myrlin | Profil </title>
	<link rel="stylesheet" type="text/css" href="styleprofil.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

	
<body>
	
		<?php include ('header.php'); ?>

	<!-- Couverture -->
		<div  id="couverture">
		

		<!--presentation -->
			<div id="presentation">

			<!-- publication space -->
				<div id="cotepublications" style="margin-top: 150px;">
				
					<div style="border:solid thin purple; padding: 10px; background-color: white;">
						<?php 
						$User=new User();

						if(is_array($ROW)){
							$ROW_USER=$User->get_user($ROW['user_id']);
							include("post.php");
						}
						?>
						<br style="clear: both;">

						<!-- espace commentaire -->
						<div style="border: solid thin #aaa; padding: 10px;background-color white;">
							<form method="post" enctype="multipart/form-data">
								<textarea name="post" placeholder=" Ajouter un commentaire"></textarea>
								<input type="file" name="file">
								<input type="hidden" name="parent" value="<?php echo $ROW['post_id'] ?>">

								<input type="submit" id="boutton_post" value="Poster">
								<br>
							</form>
						</div>

						<?php 
						if($ROW)
						{
							$comments= $Post->get_comments($ROW['post_id']);

							if(is_array($comments)){
								foreach ($comments as $COMMENT) {
									include("comment.php");
								}
							}
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