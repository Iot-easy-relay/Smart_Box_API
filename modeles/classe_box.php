<?php
include_once 'connection.php';
//constructeur
//******************************************************************************************//
//inserer un box
function inserer_box($idBox, $idCasier, $etatBox, $longueurBox, $largeurBox, $hauteurBox)
{

    //ouvrir la connexion
    $conn = OpenCon();

    $sql = "INSERT INTO box VALUES ('$idBox','$idCasier','$etatBox','$longueurBox','$largeurBox','$hauteurBox')";

    if ($conn->query($sql) === TRUE) {
        echo "box ajouté" . "<br>";
    } else {
        echo "erreur dans l'ajout du box: " . $sql . "<br>" . $conn->error . "<br>";
    }
    //fermer la connexion
    CloseCon($conn);

}

//****************************************************************************************//
//supprimer un box
function supprimer_box_IDBOX($idBox, $idCasier)
{
    //ouvrir la connexion
    $conn = OpenCon();

    //supprimer le box identifié par idBox et l'idCasier
    $sql = "DELETE FROM box WHERE idBox= '$idBox' and idCasier='$idCasier'";

    if ($conn->query($sql) === TRUE) {
        echo "box supprimé" . "<br>";
    } else {
        echo "erreur dans la suppression du box: " . $conn->error . "<br>";
    }

    //fermer la connexion
    CloseCon($conn);
}

//****************************************************************************//
//get the least recently used box
function rechercher_LRU_BOX($commune,$idColis)
{
    //ouvrir la connexion
    $conn = OpenCon();
    $data = array();
    $sql1 = "SELECT * FROM `box_contient_colis` WHERE idColis=$idColis";
    $result1 = $conn->query($sql1);
    if ($result1->num_rows == 0) {
        $sql = "SELECT * FROM box b JOIN casier c on b.idCasier=c.idcasier WHERE b.etatBox='vide' and c.code_commune=$commune ORDER BY derniereUtilisation ASC LIMIT 1 ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            //retourner un tableau associatif
            while ($row = $result->fetch_assoc()) {
                return $row;
            }
        } else {
            echo "0 results";
            return null;
        }
    }
    //fermer la connexion
    CloseCon($conn);
}

//****************************************************************************************//
//modifier un etatBox
function modifier_etatBox_IDBOX($idBox, $idCasier, $etatBox)
{
    //ouvrir la connexion
    $con = OpenCon();
    $sql = "UPDATE box SET derniereUtilisation=null ,etatBox='$etatBox' WHERE idBox=$idBox and idCasier=$idCasier";
    if ($con->query($sql) === TRUE) {
        echo json_encode(['message' => 'etatBox modifie', 'success' => true]);
    } else {
        echo "erreur dans la modification de l'etatBox: " . $con->error . "<br>";
    }
    //fermer la connexion
    CloseCon($con);
}
//****************************************************************************************//
//modifier les dimensions d'un box
function modifier_dimensionBox_IDBOX($idBox, $idCasier, $longueurBox, $largeurBox, $hauteurBox)
{

    //ouvrir la connexion
    $conn = OpenCon();

    //modidier les dimensions du box identifié par idBox
    $sql = "UPDATE box SET longueurBox='$longueurBox' , largeurBox='$largeurBox', hauteurBox='$hauteurBox' WHERE idBox='$idBox' and idCasier='$idCasier'";

    if ($conn->query($sql) === TRUE) {
        echo "dimensions Box modifiées" . "<br>";
    } else {
        echo "erreur dans la modification de dimensions Box: " . $conn->error . "<br>";
    }

    //fermer la connexion
    CloseCon($conn);
}

//****************************************************************************************//
//trouver l'etatBox d'un box donné
function rechercher_etatBox_IDBOX($idBox, $idCasier)
{
    //ouvrir la connexion
    $conn = OpenCon();
    $sql = "SELECT etatBox FROM box WHERE idBox='$idBox' and idCasier='$idCasier'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        //retourner un tableau associatif
        while ($row = $result->fetch_assoc()) {
            return $row;
        }
    } else {
        echo "0 results";
        return null;
    }

    //fermer la connexion
    CloseCon($conn);
}

//****************************************************************************************//
//trouver les dimensions d'un box donné
function rechercher_dimensionsBox_IDBOX($idBox, $idCasier)
{
    //ouvrir la connexion
    $conn = OpenCon();

    $sql = "SELECT longueurBox,largeurBox,hauteurBox FROM Box WHERE idBox='$idBox' and idCasier='$idCasier'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        //retourner un tableau associatif
        while ($row = $result->fetch_assoc()) {
            return $row;
        }
    } else {
        echo "0 results";
        return null;
    }
    //fermer la connexion
    CloseCon($conn);
}

?>