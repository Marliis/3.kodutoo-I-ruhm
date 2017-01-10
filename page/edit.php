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
	$AthleteData = $Athlete->getSingle($_GET["id"]);
	//var_dump($c);
	
	if(isset($_GET["success"])){
		echo "salvestamine õnnestus";
	}
	
?>

<!DOCTYPE html>
<html>
<head>

<h2>Muuda andmeid</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["id"];?>" > 
  	<label for="gender" >Sugu</label><br>
	<input id="gender" name="gender" type="text" value="<?php echo $AthleteData->gender;?>" ><br><br>
	
  	<label for="age" >Vanus</label><br>
	<input id="age" name="age" type="text" value="<?=$AthleteData->age;?>"><br><br>
	
	<label for="date" >Kuupäev</label><br>
	<input id="date" name="date" type="text" value="<?=$AthleteData->date;?>"><br><br>
	
	<label for="TypeOfTraining" >Treeningu tüüp</label><br>
	<input id="TypeOfTraining" name="TypeOfTraining" type="text" value="<?=$AthleteData->TypeOfTraining;?>"><br><br>
	
	<label for="WorkoutHours" >Treeningu tunnid</label><br>
	<input id="WorkoutHours" name="WorkoutHours" type="text" value="<?=$AthleteData->WorkoutHours;?>"><br><br>
	
	<label for="feeling" >Enesetunne</label><br>
	<input id="feeling" name="feeling" type="text" value="<?=$AthleteData->feeling;?>"><br><br>
	
  	
	<input type="submit" name="update" value="Salvesta">
  </form>
  

  <br>
  <a href="?id=<?=$_GET["id"];?>&delete=true">Kustuta</a>
  <br><br>
  <a href="data.php">Tagasi</a>
  
</body>
</html>
