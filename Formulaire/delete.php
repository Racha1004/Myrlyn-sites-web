 <?php 
	
	session_start();

	include("Mesfonction/connect.php");
	include("Mesfonction/login.php");
	include("Mesfonction/user.php");
	include("Mesfonction/post.php");
	include("Mesfonction/profil.php");



	$login= new Login();
	$user_data=$login->check_login($_SESSION['Mirlyn_id']);
	$ERROR="";

	$Post= new Post();


	if(isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'],"delete.php")) 
		//L'adresse de la page (si elle existe) qui a conduit le client à la page courante
	{
		//pour revenir a la bpnnne page
		$_SESSION['return_to']=$_SERVER['HTTP_REFERER'];
	}

	if(isset($_GET['id'])){

		$ROW=$Post->get_one_posts($_GET['id']);

		if (!$ROW) {
			$ERROR="Le post n'a pas été trouvé !";
		}

	}else{
		$ERROR="Le post n'a pas été trouvé !";
	}
	 //si quelque chose a été posté 
	if($_SERVER['REQUEST_METHOD']=="POST"){
		echo "here";
		$Post->delete_post($_POST['postid']);
		

		$Post->delete_comments($_POST['postid']); ////////////Problemmmmmmmmmmmmmmmmmmmmmmmmme
		header("Location:".$_SESSION['return_to']);
		die;
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Delete | Mirlyn </title>
	<link rel="stylesheet" type="text/css" href="styleprofil.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body>
	
		<?php include ('header.php'); ?>

	<!-- Couverture -->
	<div id="couverture">
		

		<!--presentation -->
		<div id="presentation">

			<!-- publication space -->
			<div id="cotepublications" style="margin-top: 150px; ">
				
				<div id="zonedetexte">

					<h2> Supprimer le post</h2> 
					<form method="post">
						<?php 
							if($ERROR != ""){
		 						echo $ERROR;

							}
							if(isset($ROW) && $ROW){
								echo "Voulez-vous vraiment supprimer ce post ? <br>";
								$user = new user();
								$ROW_USER= $user-> get_user($ROW['user_id']);

								include("post_delete.php");
							}
						?>
						<input type="hidden" value="<?php echo $ROW['post_id']?>" name="postid" >

						<input id="boutton_post" type="submit" value="Supprimer" name="bout" >
						<br>

					</form>
				</div>
				
			</div>
		</div>
	</div>
</body>
<?php 
	include('footer.php');
	?>
</html>