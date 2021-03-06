<?php
	//3.kodutöö
	//võtab ja kopeerib faili sisu
	require("../functions.php");
	
	require("../class/User.class.php");
	$User=new User($mysqli);
	
	require("../class/Helper.class.php");
	$Helper=new Helper($mysqli);
	
	//kas kasutaja on sisse logitud
	if (isset ($_SESSION["userId"])) {
		
		header("Location: data.php");
		exit();	
	}
	
	//var_dump(5.5);
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	// MUUTUJAD
	$signupName="";
	$gender="";
	$signupAge="";
	$signupEmail="";
	$signupgenderError="";
	$signupAgeError="";
	$signupEmailError = "";
	$signupPasswordError = "";
	$signupNameError = "";
	$loginEmail = "";
	$loginEmailError = "";
	$loginPassword = "";
	$loginPasswordError = "";
	
	
	// kas sisse logimisel oli e-post olemas
	if ( isset ( $_POST["loginEmail"] ) ) {
			
		if ( empty ( $_POST["loginEmail"] ) ) {
			
			// oli email, kuid see oli tühi
			$loginEmailError = "See väli on kohustuslik!";
			
		} else {
			
			// email on õige, salvestan väärtuse muutujasse
			$loginEmail = $_POST["loginEmail"];		
		}	
	}
	
	
	// kas kasutaja loomisel oli e-post olemas
	if ( isset ( $_POST["signupEmail"] ) ) {
		
		if ( empty ( $_POST["signupEmail"] ) ) {
			
			// oli email, kuid see oli tühi
			$signupEmailError = "See väli on kohustuslik!";
			
		} else {
			
			// email on õige, salvestan väärtuse muutujasse
			$signupEmail = $_POST["signupEmail"];
			
		}
		
	}
	
	
	// kas sisse logimisel oli parool olemas
	if ( isset ( $_POST["loginPassword"] ) ) {
		
		if ( empty ( $_POST["loginPassword"] ) ) {
			
			// oli parool, kuid see oli tühi
			$loginPasswordError = "See väli on kohustuslik!";
			
		} else {
			
			// tean et parool on ja see ei olnud tühi
			// VÄHEMALT 8
			
			if ( strlen($_POST["loginPassword"]) < 8 ) {
				
				$loginPasswordError = "Parool peab olema vähemalt 8 tähemärkki pikk";
				
			}
			
		}
		
	}
	
	
	
	// kas kasutaja loomisel oli parool olemas
	if ( isset ( $_POST["signupPassword"] ) ) {
		
		if ( empty ( $_POST["signupPassword"] ) ) {
			
			// oli parool, kuid see oli tühi
			$signupPasswordError = "See väli on kohustuslik!";
			
		} else {
			
			// tean et parool on ja see ei olnud tühi
			// VÄHEMALT 8
			
			if ( strlen($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Parool peab olema vähemalt 8 tähemärkki pikk";
				
			}
			
		}
		
	}
	
	
	$gender = "male";
	// KUI Tühi
	// $gender = "";
	
	if ( isset ( $_POST["gender"] ) ) {
		if ( empty ( $_POST["gender"] ) ) {
			$genderError = "See väli on kohustuslik!";
		} else {
			$gender = $_POST["gender"];
		}
	}
	
	
	
	if ( isset($_POST["signupName"] ) ) {
		if ( empty( $_POST["signupName"] ) ) {
			$signupNameError = "See väli on kohustuslik!";
		} else {
			$signupName = $_POST["signupName"];
		}
	}
	
	
	
	
	if ( isset($_POST["gender"] ) ) {
		if ( empty( $_POST["gender"] ) ) {
			$signupNameError = "See väli on kohustuslik!";
		} else {
			$signupName = $_POST["gender"];
		}
	}
	
	
	
	if ( isset($_POST["signupAge"] ) ) {
		if ( empty( $_POST["signupAge"] ) ) {
			$signupAgeError = "See väli on kohustuslik!";
		} else {
			$signupAge = $_POST["signupAge"];
		}
	}
	
	
	
	// Kus tean et ühtegi viga ei olnud ja saan kasutaja andmed salvestada
	if ( isset($_POST["signupName"]) &&
		 isset($_POST["gender"]) && 
		 isset($_POST["signupAge"]) &&
		 isset($_POST["signupEmail"]) &&
		 isset($_POST["signupPassword"]) &&	
		 empty($signupNameError) && 
		 empty($signupgenderError) && 
		 empty($signupAgeError) && 
		 empty($signupEmailError) && 
		 empty($signupPasswordError)
	   ) {
		
		echo "Salvestan...<br>";
		//echo "email ".$signupEmail."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		//echo "parool ".$_POST["signupPassword"]."<br>";
		//echo "räsi ".$password."<br>";
		
		//echo $serverPassword;
		
		$signupEmail=cleanInput($signupEmail);
		$signupPassword=cleanInput($password);
		$User->signup($signupName, $signupAge, $signupEmail, $Helper->cleanInput($password), $gender);
	   
  
		
	}
	
	$error = "";
	// kontrollin, et kasutaja täitis välja ja võib sisse logida
	if ( isset($_POST["loginEmail"]) && isset($_POST["loginPassword"]) && !empty($_POST["loginEmail"]) && !empty($_POST["loginPassword"])) {
		
		//echo "siin";
		//$_POST["loginEmail"]=cleanInput($_POST["loginEmail"]);
		//$_POST["loginPassword"]=cleanInput($_POST["loginPassword"]);
		//login sisse
		$error=$User->login($Helper->cleanInput($_POST["loginEmail"]), $Helper->cleanInput($_POST["loginPassword"]));
		
	}
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimise lehekülg</title>
	</head>
	<body>

		<h1>Logi sisse</h1>
		
		<form method="POST">
			<p style="color:red;"><?=$error;?></p>
			<label>E-post</label><br>
			<input name="loginEmail" type="email" value="<?=$loginEmail;?>"> <?php echo $loginEmailError;?>
			
			<br><br>
			
			<input name="loginPassword" type="password" placeholder="Parool"><?php echo $loginPasswordError;?>
			
			<br><br>
			
			<input type="submit" value="Logi sisse">
			
		</form>
		
		<h1>Loo kasutaja</h1>
		
		<form method="POST">
			
			<input name="signupName" type="name" placeholder="Nimi" value="<?=$signupName;?>"> <?php echo $signupNameError; ?>
			
			<br><br>
			
			<input name="signupAge" type="age" placeholder="Vanus" value="<?=$signupAge;?>"> <?php echo $signupAgeError; ?>
			
			<br><br>
			
			<input name="signupEmail" type="email" placeholder="E-post" value="<?=$signupEmail;?>"> <?php echo $signupEmailError; ?>
			
			<br><br>
			
			<input name="signupPassword" type="password" placeholder="Parool"> <?php echo $signupPasswordError; ?>
			
			<br><br>
			
			 <?php if($gender == "male") { ?>
				<input type="radio" name="gender" value="male" checked> Male<br>
			 <?php } else { ?>
				<input type="radio" name="gender" value="male" > Male<br>
			 <?php } ?>
			 
			 <?php if($gender == "female") { ?>
				<input type="radio" name="gender" value="female" checked> Female<br>
			 <?php } else { ?>
				<input type="radio" name="gender" value="female" > Female<br>
			 <?php } ?>
			 
			 <?php if($gender == "other") { ?>
				<input type="radio" name="gender" value="other" checked> Other<br>
			 <?php } else { ?>
				<input type="radio" name="gender" value="other" > Other<br>
			 <?php } ?>
			 
			
			<input type="submit" value="Loo kasutaja">
			
				</form>
			</div>
							
		</div>
		
	</div>
