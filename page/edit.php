<?php
	//3.kodutöö

	require("../functions.php");
	
	require("../class/Athletes.class.php");
	$Athlete = new Athlete($mysqli);
	
	require("../class/Helper.class.php");
	$Helper = new Helper();
	
	//var_dump($_POST);
	
	//kas kasutaja uuendab andmeid
	if(isset($_POST["update"])){
		
		$Athlete->update($Helper->cleanInput($_POST["id"]), $Helper->cleanInput($_POST["gender"]), $Helper->cleanInput($_POST["age"]), $Helper->cleanInput($_POST["date"]), $Helper->cleanInput($_POST["TypeOfTraining"]), $Helper->cleanInput($_POST["WorkoutHours"]), $Helper->cleanInput($_POST["feeling"]));
		
		header("Location: edit.php?id=".$_POST["id"]."&success=true");
        exit();	
		
	}
	
	//kustutan
	if(isset($_GET["delete"])){
		
		$Athlete->delete($_GET["id"]);
		
		header("Location: data.php");
		exit();
	}
	

	// kui ei ole id'd aadressireal, siis suunan
	if(!isset($_GET["id"])){
		header("Location: data.php");
		exit();
	}
	
	//saadan kaasa id
	$c = $Athlete->getSingle($_GET["id"]);
	//var_dump($c);
	
	if(isset($_GET["success"])){
		echo "salvestamine õnnestus";
	}
	
?>

<br><br>
<a href="data.php"> tagasi </a>

<h2>Muuda kirjet</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["id"];?>" > 
  	<label for="number_plate" >auto nr</label><br>
	<input id="number_plate" name="plate" type="text" value="<?php echo $c->plate;?>" ><br><br>
  	<label for="color" >värv</label><br>
	<input id="color" name="color" type="color" value="<?=$c->color;?>"><br><br>
  	
	<input type="submit" name="update" value="Salvesta">
  </form>