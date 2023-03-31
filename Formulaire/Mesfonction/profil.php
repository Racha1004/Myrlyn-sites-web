<?php 
 class Profil
 {
  public function get_profile($id)
  {

  	$query="SELECT * FROM user WHERE user_id='$id' LIMIT 1";
  	$bdd=new Database();
  	return $bdd->read($query);
  }
 }

?>