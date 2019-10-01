<?php
 
//****************************************************************************************//
//inserer un casier
function inserer_casier($idCasier,$code_Commune,$adr){
		
	try{
		//ouvrir la connexion
		$conn = OpenCon();
		
		// preparer la requete sql de l'insertion
		$stmt = $conn->prepare("INSERT INTO casier VALUES (:idCasier, :code_Commune, :adr)");
		$stmt->bindParam(':idCasier', $idCasier);
		$stmt->bindParam(':code_Commune', $code_Commune);
		$stmt->bindParam(':adr', $adr);

		$stmt->execute();
		echo "casier ajouté" . "<br>";
		
	}catch(PDOException $e)
    {
		echo "Error: " . $e->getMessage();
    }

	//fermer la connexion
	CloseCon($conn);
		
}

//****************************************************************************************//
//supprimer un casier
function supprimer_casier_IDCASIER($idCasier){
	
	try{
		//ouvrir la connexion
		$conn = OpenCon();
		
		//supprimer le casier identifié par idCasier
		$stmt = $conn->prepare("DELETE FROM casier WHERE idCasier= :idCasier");
		$stmt->bindParam(':idCasier', $idCasier);
		
		$stmt->execute();
		echo "casier supprimé" . "<br>";
		
	}catch(PDOException $e)
    {
		echo "Error: " . $e->getMessage();
    }
	//fermer la connexion
	CloseCon($conn);
}

//****************************************************************************************//
//modifier un casier
function modifier_casier_IDCASIER($idCasier, $code_Commune,$adresse){
	try{
	//ouvrir la connexion
	$conn = OpenCon();
	
	//modidier les attributs du casier identifié par idCasier
		$stmt = $conn->prepare("UPDATE casier SET adresse=:adresse , code_Commune=:code_Commune WHERE idCasier=:idCasier");
		$stmt->bindParam(':idCasier', $idCasier);
		$stmt->bindParam(':code_Commune', $code_Commune);
		$stmt->bindParam(':adresse', $adresse);
		
		$stmt->execute();
		echo "casier modifié" . "<br>";

	}catch(PDOException $e)
    {
		echo "Error: " . $e->getMessage();
    }
	//fermer la connexion
	CloseCon($conn);
}

//****************************************************************************************//
// Retourne le casier d'une commune donnée 

Function Rechercher_Casier_Commune($commune){
	try{
		$conn=OpenCon();
		//récépurer le casier d'une commune donnée 
		$stmt = $conn->prepare("SELECT * FROM Casier WHERE code_Commune=:commune");
		$stmt->bindParam(':commune', $commune);
		
		$stmt->execute();
		//retourner un tableau associatif
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	catch(PDOException $e)
    {
		echo "Error: " . $e->getMessage();
    }
	//fermer la connexion
	CloseCon($conn);
}



?>