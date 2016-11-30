<?php 
	//3.kodutöö

class User {
	
	private $connection;
	
	function __construct($mysqli){
		
		//this viitab klassile (this == User)
		$this->connection = $mysqli;	
	}
	
	/*TEISED FUNKTSIOONID*/
	
	function login($email, $password) {
		
		$error = "";
		
		$stmt = $this->connection->prepare("
			SELECT id, email, password, created 
			FROM user_sample
			WHERE email = ?");

		echo $this->connection->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//määran tupladele muutujad
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		//küsin rea andmeid
		if($stmt->fetch()) {
		
			// võrdlen paroole
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDb) {
				
				echo "Kasutaja logis sisse ".$id;
				
				$_SESSION["userId"] = $id;
				$_SESSION["email"] = $emailFromDb;	
				$_SESSION["message"] = "<h1>Tere tulemast!</h1>";
	
				//suunaks uuele lehele
				header("Location: data.php");
				exit();
				
			} else {
				$error = "parool vale";
			}	
		
		} else {
			//ei olnud 		
			$error = "sellise emailiga ".$email." kasutajat ei olnud";
		}
			
		return $error;
				
	}
	

	function signup ($name, $gender, $age, $email, $password) {
		
		$stmt = $this->connection->prepare("INSERT INTO user_sample (name, gender, age, email, password) VALUES (?, ?, ?, ?, ?)");
		echo $this->connection->error;
		//asendan küsimärgi väärtustega
		//iga muutuja kohta tuleb kirjutada üks täht, ehk mis tüüpi muutuja see on
		//s-stringi
		//i-integer
		//d-double/float
		$stmt->bind_param("ssiss", $name, $gender, $age, $email, $password);
		
		if ($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}
	
} 
?>