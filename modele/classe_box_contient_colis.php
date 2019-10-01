<?php

//****************************************************************************************//
//affecter un box à un colis
function inserer_box_colis($idActeur,$idBox,$idCasier,$idColis,$idOperation,$dateOperation){
	
	try{
		//ouvrir la connexion
		$conn = OpenCon();
		
		$stmt = $conn->prepare("INSERT INTO Box_Contient_Colis (idActeur,idBox,idCasier,idColis,idOperation,dateOperation) 
														VALUES (:idActeur,:idBox,:idCasier,:idColis,:idOperation,:dateOperation)");
		$stmt->bindParam(':idActeur', $idActeur);
		$stmt->bindParam(':idBox', $idBox);
		$stmt->bindParam(':idCasier', $idCasier);
		$stmt->bindParam(':idColis', $idColis);
		$stmt->bindParam(':idOperation', $idOperation);
		$stmt->bindParam(':dateOperation', $dateOperation);
		
		$stmt->execute();
		echo "colis ajouté dans le box" . "<br>";
		
	}catch(PDOException $e)
    {
		echo "Error: " . $e->getMessage();
    }
	
	//fermer la connexion
	CloseCon($conn);
	
}
//****************************************************************************************//
//retirer le colis du box
function supprimer_colis_box($idBox,$idCasier){
	try{
		//ouvrir la connexion
		$conn = OpenCon();
		
		//supprimer la ligne identifiée par idBox et idCasier
		$stmt = $conn->prepare("DELETE FROM box_contient_colis WHERE idBox= :idBox and idCasier= :idCasier");
		$stmt->bindParam(':idBox', $idBox);
		$stmt->bindParam(':idCasier', $idCasier);
		
		$stmt->execute();
		echo "colis retiré" . "<br>";
		
	}catch(PDOException $e)
    {
		echo "Error: " . $e->getMessage();
    }
	
	//fermer la connexion
	CloseCon($conn);
}
//****************************************************************************************//
//RECHERCHER quel box contient le colis
function rechercher_box_colis($idColis){
	try{
	//ouvrir la connexion
	$conn = OpenCon();
	
		//a partir d'un idColis, trouver le idBox et le idCasier
		$stmt = $conn->prepare("SELECT idBox,idCasier FROM box_contient_colis WHERE idColis=:idColis and 
				dateOperation= (Select max(dateOperation) From box_contient_colis WHERE idColis=:idColis)");
		$stmt->bindParam(':idColis', $idColis);
		
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
//***************************************************************************************//
function rechercher_colis_IDBOX_IDCASIER($idBox,$idCasier)
{
	try{
	//ouvrir la connexion
	$conn = OpenCon();
	
	//trouver le idColis le plus recemment deposé dans un idBox et un idCasier donnés 
	$stmt = $conn->prepare("SELECT * FROM box_contient_colis WHERE idCasier=:idCasier and idBox=:idBox and 
				dateOperation= (Select max(dateOperation) From box_contient_colis WHERE idCasier=:idCasier and idBox=:idBox)");
		
		$stmt->bindParam(':idBox', $idBox);
		$stmt->bindParam(':idCasier', $idCasier);
		
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