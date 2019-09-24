<?php

include_once 'connection.php';

//constructeur????????????????

//*****************************************************************************************//
//affecter un box à un colis
function inserer_box_colis($idActeur, $idBox, $idCasier, $idColis, $dateOperation, $typeOperation)
{

    //ouvrir la connexion
    $conn = OpenCon();
    //inserer une ligne dans box_contient_colis
    $sql = "INSERT INTO box_contient_colis VALUES ('$idActeur','$idBox','$idCasier','$idColis',null ,'$typeOperation')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'ligne insere', 'success' => true]);
    } else {
        echo json_encode(['message' => "'erreur dans le l'inserstion: '. $conn->error'", 'success' => false]);
    }


    //fermer la connexion
    CloseCon($conn);
}


//****************************************************************************************//
//retirer le colis du box
function supprimer_colis_box($idBox, $idCasier)
{
    //ouvrir la connexion
    $conn = OpenCon();
    //supprimer la ligne identifiée par idBox et idCasier
    $sql = "DELETE FROM box_contient_colis WHERE idBox= '$idBox' and idCasier='$idCasier'";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'colis retire', 'success' => true]);
    } else {
        echo json_encode(['message' => "'erreur dans le retrait du colis: '. $conn->error'", 'success' => false]);
    }

    //fermer la connexion
    CloseCon($conn);
}

//****************************************************************************************//
//RECHERCHER quel box contient le colis
function rechercher_box_colis($idColis)
{
    //ouvrir la connexion
    $conn = OpenCon();
    //a partir d'un idColis, trouver le idBox et le idCasierS
    $sql = "SELECT idBox,idCasier FROM box_contient_colis WHERE idColis=$idColis";
    $result = $conn->query($sql);
    //retourner un tableau associatif
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            return $row;
        }
    } else {
        echo json_encode(['message' => "BOX NOT FOUND", 'success' => false]) ;
        return null;
    }
    //fermer la connexion
    CloseCon($conn);
}

?>