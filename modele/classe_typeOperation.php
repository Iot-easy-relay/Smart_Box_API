<?php 

function inserer_typeOperation($idOperation,$designationOperation){
	
	try{
		//ouvrir la connexion
		$conn = OpenCon();
		
		$stmt = $conn->prepare("INSERT INTO TypeOperation VALUES (:idOperation,:designationOperation)");
		$stmt->bindParam(':idOperation', $idOperation);
		$stmt->bindParam(':designationOperation', $designationOperation);
		
		$stmt->execute();
		echo "Operation ajoutée" . "<br>";
		
	}catch(PDOException $e)
    {
		echo "Error: " . $e->getMessage();
    }
	//fermer la connexion
	CloseCon($conn);
}


include 'connection.php';

inserer_typeOperation(3,"depot");
?>