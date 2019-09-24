<?php

include_once 'connection.php';

//constructeur

//*****************************************************************************************//
//inserer un casier
function inserer_casier($idCasier,$code_Commune,$adr){
		
	//ouvrir la connexion
	$conn = OpenCon();

		$sql = "INSERT INTO casier VALUES ('$idCasier','$code_Commune','$adr')";

		if ($conn->query($sql) === TRUE) {
			echo "casier ajouté" . "<br>";
		} else {
			echo "erreur dans l'ajout du casier: " . $sql . "<br>" . $conn->error."<br>";}	
	
	//fermer la connexion
	CloseCon($conn);
	
	
	}

//****************************************************************************************//
//supprimer un casier
function supprimer_casier_IDCASIER($idCasier){
	//ouvrir la connexion
	$conn = OpenCon();
	
	//supprimer le casier identifié par idCasier
	//il retourne vrai si le casier n'existe pas
		$sql = "DELETE FROM casier WHERE idCasier= '$idCasier'";

		if ($conn->query($sql) === TRUE) {
			echo "casier supprimé" . "<br>";
		} else {
			echo "erreur dans la suppression du casier: " . $conn->error ."<br>";}
			
	//fermer la connexion
	CloseCon($conn);
}

//****************************************************************************************//
//modifier un casier
function modifier_casier_IDCASIER($idCasier, $code_Commune,$adresse){
	
	//ouvrir la connexion
	$conn = OpenCon();
	
	//modidier les attributs du casier identifié par idCasier
	//il retourne vrai si le casier n'existe pas
		$sql = "UPDATE casier SET adresse='$adresse' , code_Commune='$code_Commune' WHERE idCasier='$idCasier'";

		if ($conn->query($sql) === TRUE) {
			echo "casier modifié" . "<br>";
		} else {
			echo "erreur dans la modification du casier: " . $conn->error . "<br>";}

	//fermer la connexion
	CloseCon($conn);
}

//****************************************************************************************//
//RECHERCHER_CASIER_d'un commune

?>