<?php
session_start();
include "db.php";
if (isset($_POST["f_name"])) {

	$f_name = $_POST["f_name"];
	$l_name = $_POST["l_name"];
	$ced = $_POST["ced"];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$repassword = $_POST['repassword'];
	$mobile = $_POST['mobile'];
	$provincia = $_POST['provincia'];
	$canton = $_POST['canton'];
	$distrito = $_POST['distrito'];
	$address2 = $_POST['address2'];
	$name = "/^[a-zA-Z ]+$/";
	$emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";
	$number = "/^[0-9]+$/";

if(empty($f_name) || empty($l_name) || empty($email) || empty($password) || empty($repassword) ||
	empty($mobile) || empty($provincia) || empty($address2) || empty($provincia)|| empty($canton) || empty($distrito) || empty($ced)){
		
		/*echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Por favor rellene todos los campos!</b>
			</div>
		";*/
		echo "<script>
		alert('Por favor rellene todos los campos');
		
		</script>";
		exit();
	} else {
		if(!preg_match($name,$f_name)){
		/*echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>Nombre $f_name no es valido</b>
			</div>
		";*/
		echo "<script>
		alert('Nombre $f_name no es valido');
		
		</script>";
		exit();
	}
	if(!preg_match($name,$l_name)){
		/*echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>Apellido $l_name no es valido</b>
			</div>
		";*/
		echo "<script>
		alert('Apellido $l_name no es valido');
		
		</script>";
		exit();
	}
	if(!preg_match($emailValidation,$email)){
		/*echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>Email $email no es valido</b>
			</div>
		";*/
		echo "<script>
		alert('Email $email no es valido');
		
		</script>";
		exit();
	}
	if(strlen($password) < 5 ){
		/*echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>Contraseña es muy debil</b>
			</div>
		";*/
		echo "<script>
		alert('Contraseña muy debil');
		
		</script>";
		exit();
	}
	if(strlen($repassword) < 3 ){
		/*echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>Contraseña es muy debil</b>
			</div>
		";*/
		echo "<script>
		alert('Las contraseñas no coinciden');
		
		</script>";
		exit();
	}
	if($password != $repassword){
		/*echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>Las contraseñas no coinciden</b>
			</div>
		";*/
		echo "<script>
		alert('Las contraseñas no coinciden');
		
		</script>";
		exit();
	}
	if(!preg_match($number,$mobile)){
		/*echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>Numero $mobile no es un numero de telefono valido</b>
			</div>
		";*/
		echo "<script>
		alert('El numero $mobile no es un numero de telefono valido');
		
		</script>";
		exit();
	}
	//existing email address in our database
	$sql = "SELECT user_id FROM user_info WHERE email = '$email' LIMIT 1" ;
	$check_query = mysqli_query($con,$sql);
	$count_email = mysqli_num_rows($check_query);
	if($count_email > 0){
		/*echo "
			<div class='alert alert-danger'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>El email ya esta registrado</b>
			</div>
		";*/
		echo "<script>
		alert('El Email utilizado ya esta registrado');
		
		</script>";
		exit();
	} else {
		$password = md5($password);
		$sql = "INSERT INTO `user_info` 
		(`user_id`, `first_name`, `last_name`, `email`, 
		`password`, `mobile`, `provincia`, `address2`,`canton`, `distrito`, `ced`) 
		VALUES (NULL, '$f_name', '$l_name', '$email', 
		'$password', '$mobile', '$provincia', '$address2','$canton', '$distrito', '$ced' )";
		$run_query = mysqli_query($con,$sql);
		$_SESSION["uid"] = mysqli_insert_id($con);
		$_SESSION["name"] = $f_name;
		$_SESSION["provincia"] = $provincia;
		$_SESSION["canton"] = $canton;
		$_SESSION["distrito"] = $distrito;
		$_SESSION["ced"] = $ced;
		$_SESSION["address2"] = $address2;
		$_SESSION["nombreC"] = $f_name.$l_name;
		$_SESSION["telefono"] = $mobile;
		$_SESSION["email"] = $email;
		$ip_add = getenv("REMOTE_ADDR");
		$sql = "UPDATE cart SET user_id = '$_SESSION[uid]' WHERE ip_add='$ip_add' AND user_id = -1";
		if(mysqli_query($con,$sql)){
			/*echo "Se ha registrado correctamente";*/
			echo '<script>
			alert("Se ha registrado correctamente");
			</script>';
			header("Location: profile.php");
			exit();
		}
	}
	
	}
	
}



?>






















































