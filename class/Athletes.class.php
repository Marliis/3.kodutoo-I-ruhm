<?php 
class Athlete {
	
	private $connection;
	
	function __construct($mysqli){
		
		$this->connection = $mysqli;
		
	}

/*TEISED FUNKTSIOONID */
	/*function delete($id){

		$stmt = $this->connection->prepare("UPDATE AthletesData_2 SET deleted=NOW() WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i",$id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "kustutamine õnnestus!";
		}
		
		$stmt->close();*/
		
		
	
	
	function get($q, $sort, $order) {
	
		$allowedSort = ["id", "gender", "age", "date", "TypeOfTraining", "WorkoutHours", "feeling"];
		
		if(!in_array($sort, $allowedSort)){
			//ei ole lubatud tulp
			$sort = "id";
		}
		
		
		$orderBy = "ASC";
		
		if($order == "DESC") {
		   $orderBY = "DESC";
		}
		echo "Sorteerin: ".$sort." ".$orderBy." ";
		
	
		//kas otsib
		if ($q != "") {
			
			echo "Otsib: ".$q;
			
			$stmt = $this->connection->prepare("
				SELECT id, gender, age, date, TypeOfTraining, WorkoutHours, feeling
				FROM AthletesData_2
				WHERE deleted IS NULL 
				AND (gender LIKE ? OR age LIKE ? OR date LIKE ? OR TypeOfTraining LIKE ? WorkoutHours LIKE ? feeling LIKE ?)
				ORDER BY $sort $orderBy
			");
			$searchWord = "%".$q."%".$q."%".$q."%".$q."%".$q."%";
			$stmt->bind_param("siisis", $searchWord, $searchWord, $searchWord, $searchWord, $searchWord, $searchWord);
			
		} else {
			$stmt = $this->connection->prepare("
				SELECT id, gender, age, date, TypeOfTraining, WorkoutHours, feeling
				FROM AthletesData_2
				WHERE deleted IS NULL
				ORDER BY $sort $orderBy
			");	
		}
		
		echo $this->connection->error;
		
		$stmt->bind_result($id, $gender, $age, $date, $TypeOfTraining, $WorkoutHours, $feeling);
		$stmt->execute();
		
		//tekitan massiivi
		$result = array();
		
		// tee seda seni, kuni on rida andmeid, mis vastab select lausele
		while ($stmt->fetch()) {
			
			//tekitan objekti
			$Athlete = new StdClass();	
			$Athlete->id = $id;
			$Athlete->gender = $gender;
			$Athlete->age = $age;
			$Athlete->date = $date;
			$Athlete->TypeOfTraining = $TypeOfTraining;
			$Athlete->WorkoutHours = $WorkoutHours;
			$Athlete->feeling = $feeling;
	
			// iga kord massiivi lisan juurde nr märgi
			array_push($result, $Athlete);
		}
		
		$stmt->close();
		
		return $result;
	}
	
	function getSingle($edit_id){

		$stmt = $this->connection->prepare("SELECT gender, age, date, TypeOfTraining, WorkoutHours, feeling FROM AthletesData_2 WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($gender, $age, $date, $TypeOfTraining, $WorkoutHours, $feeling);
		$stmt->execute();
		
		//tekitan objekti
		$Athlete = new Stdclass();
		
		//saime ühe rea andmeid
		if($stmt->fetch()){
			// saan siin alles kasutada bind_result muutujaid
			$Athlete->gender = $gender;
			$Athlete->age = $age;
			$Athlete->date = $date;
			$Athlete->TypeOfTraining = $TypeOfTraining;
			$Athlete->WorkoutHours = $WorkoutHours;
			$Athlete->feeling = $feeling;

	
		}else{
			// ei saanud rida andmeid kätte
			// sellist id'd ei ole olemas
			// see rida võib olla kustutatud
			header("Location: data.php");
			exit();
		}
		
		$stmt->close();
			
		return $Athlete;	
	}


	function save ($gender, $age, $date, $TypeOfTraining, $WorkoutHours, $feeling) {
			
			//käsk
			$stmt=$this->connection->prepare("INSERT INTO AthletesData_2 (gender, age, date, TypeOfTraining, WorkoutHours, feeling) VALUES(?, ?, ?, ?, ?, ?)");
			
			$stmt->bind_param("siisis",$gender, $age, $date, $TypeOfTraining, $WorkoutHours, $feeling);
			
			echo $this->connection->error;
		
			$stmt->bind_param("siisis", $gender, $age, $date, $TypeOfTraining, $WorkoutHours, $feeling);
		
			if($stmt->execute()) {
				echo "salvestamine õnnestus";
			} else {
		 		echo "ERROR ".$stmt->error;
			}
		
		$stmt->close();
			
	}		
		
	
	function update($id, $gender, $age, $date, $TypeOfTraining, $WorkoutHours, $feeling){
    	
		$stmt = $this->connection->prepare("UPDATE AthletesData_2 SET gender=?, age=?, date=?, TypeOfTraining=?, WorkoutHours=?, feeling=? WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("siisisi",$gender, $age, $date, $TypeOfTraining, $WorkoutHours, $feeling, $id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// ınnestus
			echo "salvestus õnnestus!";
		}
		
		$stmt->close();
			
	}
} 

?>	