<?php 
	// 3.kodutöö M
	require("../functions.php");
	
	require("../class/Athletes.class.php");
	$Athlete=new Athlete($mysqli);
	
	require("../class/Helper.class.php");
	$Helper=new Helper();
	
	// kas on sisseloginud, kui ei ole siis
	// suunata login lehele
	if (!isset ($_SESSION["userId"])) {
		
		header("Location: login.php");
		exit();
		
	}
	
	//kui on logout aadressireal, siis login välja
	if (isset($_GET["logout"])) {
		
		session_destroy();
		header("Location: login.php");
		exit();
		
	}
	
	$msg = "";
	if(isset($_SESSION["message"])){
		$msg = $_SESSION["message"];
		
		//kui ühe näitame siis kustuta ära, et pärast refreshi ei näitaks
		unset($_SESSION["message"]);
	}
	
	
	
	if ( isset($_POST["gender"]) && 
		isset($_POST["age"]) && 
		isset($_POST["date"]) && 
		isset($_POST["TypeOfTraining"]) && 
		isset($_POST["WorkoutHours"]) && 
		isset($_POST["feeling"]) && 
		!empty($_POST["gender"]) && 
		!empty($_POST["age"]) && 
		!empty($_POST["date"]) && 
		!empty($_POST["TypeOfTraining"]) && 
		!empty($_POST["WorkoutHours"]) && 
		!empty($_POST["feeling"]) 
	  ) {
		  
		$Athlete->save($Helper->cleanInput($_POST["gender"]), $Helper->cleanInput($_POST["age"]), $Helper->cleanInput($_POST["date"]), $Helper->cleanInput($_POST["TypeOfTraining"]), $Helper->cleanInput($_POST["WorkoutHours"]), $Helper->cleanInput($_POST["feeling"]));
		
	}
	
	
	//saan kõik treenija andmed
	
	//kas otsib
	if(isset($_GET["q"])){
		
		// kui otsib, võtame otsisõna aadressirealt
		$q = $_GET["q"];
		
	}else{
		
		// otsisõna tühi
		$q = "";
	}
	
	$sort = "id";
	$order = "ASC";
	
	if(isset($_GET["sort"]) && isset($_GET["order"])) {
		$sort = $_GET["sort"];
		$order = $_GET["order"];
	}
	
	//otsisõna fn sisse
	$AthleteData = $Athlete->get($q, $sort, $order);
	
?>
<h1>Treeningu andmete sisestamine</h1>
<?=$msg;?>
<p>
	Tere tulemast! <a href="user.php"></a>
	<a href="?logout=1">Logi välja</a>
</p>


<h1>Salvesta andmed</h1>
<form method="POST">
			
	<label>Sugu</label><br>
	<input type="radio" name="gender" value="male" > Mees<br>
	<input type="radio" name="gender" value="female" > Naine<br>
	<input type="radio" name="gender" value="Unknown" > Ei oska öelda<br>
	
	<!--<input type="text" name="gender" ><br>-->
	
	<br><br>
	<label>Vanus</label><br>
	<input name="age" type="age" placeholder="Vanus"> 
	
	<br><br>
	<label><h3>Kuupäev</h3></label>
	<input name="date" type="date" placeholder="Kuupäev">
	
	<br><br>
	<label><h3>Treeningu tüüp</h3></label>
	<input name="TypeOfTraining" type="TypeOfTraining" placeholder="Treeningu tüüp">
	
	<br><br>
	<label><h3>Treeningu tunnid</h3></label>
	<input name="WorkoutHours" type="WorkoutHours" placeholder="Treeningu tunnid">
	
	<br><br>
	<label><h3>Enesetunne</h3></label>
	<input name="feeling" type="feeling" placeholder="Enesetunne">
	
	<br><br>
	<input type="submit" value="Salvesta">
	
</form>


<br><br>
<h2>Kasutajate andmed</h2>

<form>
	
	<input type="search" name="q" value="<?=$q;?>">
	<input type="submit" value="Otsi">

</form>

<?php

	$html = "<table class='table table-striped'>";


	$html .= "<tr>";
	
		$idOrder = "ASC";
		$arrow = "&darr;";
		if (isset($_GET["order"]) && $_GET["order"] == "ASC"){
			$idOrder = "DESC";
			$arrow = "&uarr;";
		}
	
		$html .= "<th>
					<a href='?q=".$q."&sort=id&order=".$idOrder."'>
						id ".$arrow."
					</a>
				 </th>";
				 
			
		$genderOrder = "ASC";
		$arrow = "&darr;";
		if (isset($_GET["order"]) && $_GET["order"] == "ASC"){
			$genderOrder = "DESC";
			$arrow = "&uarr;";
		}
	
		$html .= "<th>
					<a href='?q=".$q."&sort=gender&order=".$genderOrder."'>
						Sugu ".$arrow."
					</a>
				 </th>";
				 
				 
				 
				 
				 
		$ageOrder = "ASC";
		$arrow = "&darr;";
		if (isset($_GET["order"]) && $_GET["order"] == "ASC"){
			$ageOrder = "DESC";
			$arrow = "&uarr;";
		}
	
		$html .= "<th>
					<a href='?q=".$q."&sort=age&order=".$ageOrder."'>
						Vanus ".$arrow."
					</a>
				 </th>";
				 
				 
				 
				 
				 
				 
				 
		$dateOrder = "ASC";
		$arrow = "&darr;";
		if (isset($_GET["order"]) && $_GET["order"] == "ASC"){
			$dateOrder = "DESC";
			$arrow = "&uarr;";
		}
	
		$html .= "<th>
					<a href='?q=".$q."&sort=date&order=".$dateOrder."'>
						Kuupäev ".$arrow."
					</a>
				 </th>";
				 
				 
				 
				 
		$TypeOfTrainingOrder = "ASC";
		$arrow = "&darr;";
		if (isset($_GET["order"]) && $_GET["order"] == "ASC"){
			$TypeOfTrainingOrder = "DESC";
			$arrow = "&uarr;";
		}
	
		$html .= "<th>
					<a href='?q=".$q."&sort=TypeOfTraining&order=".$TypeOfTrainingOrder."'>
						Treeningu tüüp ".$arrow."
					</a>
				 </th>";
				 
				 
				 
				 
				 
		$WorkoutHoursOrder = "ASC";
		$arrow = "&darr;";
		if (isset($_GET["order"]) && $_GET["order"] == "ASC"){
			$WorkoutHoursOrder = "DESC";
			$arrow = "&uarr;";
		}
	
		$html .= "<th>
					<a href='?q=".$q."&sort=WorkoutHours&order=".$WorkoutHoursOrder."'>
						Treeningtunnid ".$arrow."
					</a>
				 </th>";
				 
			
			
			
				 
		$feelingOrder = "ASC";
		$arrow = "&darr;";
		if (isset($_GET["order"]) && $_GET["order"] == "ASC"){
			$feelingOrder = "DESC";
			$arrow = "&uarr;";
		}
		$html .= "<th>
					<a href='?q=".$q."&sort=feeling&order=".$feelingOrder."'>
						Enesetunne
					</a>
				 </th>";
	$html .= "</tr>";


	//iga liikme kohta massiivis
	foreach($AthleteData as $c){
		// iga treenija on $c
		//echo $c->TypeOfTraining."<br>";
		
		$html .= "<tr>";
			$html .= "<td>".$c->id."</td>";
			$html .= "<td>".$c->gender."</td>";
			$html .= "<td>".$c->age."</td>";
			$html .= "<td>".$c->date."</td>";
			$html .= "<td>".$c->TypeOfTraining."</td>";
			$html .= "<td>".$c->WorkoutHours."</td>";
			$html .= "<td>".$c->feeling."</td>";
			//$html .= "<td style='background-color:".$c->AthleteTypeOfTraining."'>".$c->AthleteTypeOfTraining."</td>";
			$html .= "<td><a class='btn btn-default btn-sm' href='edit.php?id=".$c->id."'><span class='glyphicon glyphicon-pencil'></span> Muuda</a></td>";
			
		$html .= "</tr>";
	}
	
	$html .= "</table>";
	
	echo $html;
	
	
	$listHtml = "<br><br>";
	
	foreach($AthleteData as $c){
		
		
		//$listHtml .= "<h1 style='color:".$c->AthleteTypeOfTraining."'>".$c->TypeOfTraining."</h1>";
		//$listHtml .= "<p>color = ".$c->AthleteTypeOfTraining."</p>";
	}
	
	echo $listHtml;
	
	
	

?>
