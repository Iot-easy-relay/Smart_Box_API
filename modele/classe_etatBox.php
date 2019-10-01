<?php 

//ajouter un etatBox
function inserer_etatBox($idEtatBox,$designationEtatBox){
	
	try{
		//ouvrir la connexion
		$conn = OpenCon();
		
		// prepare sql and bind parameters
		$stmt = $conn->prepare("INSERT INTO EtatBox VALUES (:idEtatBox,:designationEtatBox)");
		$stmt->bindParam(':idEtatBox', $idEtatBox);
		$stmt->bindParam(':designationEtatBox', $designationEtatBox);
		
		$stmt->execute();
		echo "etat ajouté" . "<br>";
		
	}catch(PDOException $e)
    {
		echo "Error: " . $e->getMessage();
    }
	
	//fermer la connexion
	CloseCon($conn);
	
}

//****************************************************************************************//
//Trouver la designation d'un idEtatBox
function rechercher_designation_idEtatBox($idEtatBox){
	try{
	//ouvrir la connexion
	$conn = OpenCon();
	
		$stmt = $conn->prepare("SELECT designationEtatBox FROM EtatBox WHERE idEtatBox=:idEtatBox");
		$stmt->bindParam(':idEtatBox', $idEtatBox);
		
		$stmt->execute();
		//retourner un tableau associatif
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		
	}catch(PDOException $e)
    {
		echo "Error: " . $e->getMessage();
		return null;
    }
	//fermer la connexion
	CloseCon($conn);
	
}


?>