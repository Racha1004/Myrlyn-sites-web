 <?php 
	
	session_start();

	include("Mesfonction/connect.php");
	include("Mesfonction/login.php");
	include("Mesfonction/user.php");
	include("Mesfonction/post.php");
	include("Mesfonction/profil.php");
	


	$login= new Login();
	$user_data=$login->check_login($_SESSION['Mirlyn_id']);
	$pseudo=$user_data["pseudo"] ;
	$results="";
	if(isset($_GET['find'])){
		$find= addslashes($_GET['find']);
 		$sql="SELECT * from user where pseudo !='$pseudo' AND pseudo like '%$find%'";
 		$db= new Database ();
 		$results=$db->read($sql);
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
		<div  style="width: 800px;margin: auto;min-height: 400px;">
		

		<!--presentation -->
			<div style="display: flex;">

			<!-- publication space -->
				<div style="min-height: 400px;flex: 2.5; padding: 20px;margin-top: 150px; padding-right: 0px;">
				
					<div style="border:solid thin purple; padding: 10px; background-color: white;">
						<?php 
						$User=new User();

						if(is_array($results)){
							foreach ($results as $row) {
								$FRIEND_ROW=$User->get_user($row['user_id']);
								include("friend.php");
							}
						}else{
							echo "Aucun résultat trouvé";
						}
						?>
						<br style="clear: both;">

					</div>
				</div>
			</div>
		</div>
</body>
</html> 