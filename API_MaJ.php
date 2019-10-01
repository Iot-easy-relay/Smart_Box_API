<?php

include "./modele/connection.php";

$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'GET':  // envoyé par la RPI aprés la fermeture d'une porte 
        // Mise à jour de la table box_contient_colis avec idActeur idOperation dateOperation
        try {
            $conn = OpenCon();
            $idActeur = isset($_GET['idActeur']) ? $_GET['idActeur'] : "";
            $idOperation = isset($_GET['idOperation']) ? $_GET['idOperation'] : "";
            $idBox = isset($_GET['idBox']) ? $_GET['idBox'] : "";
            $idCasier = isset($_GET['idCasier']) ? $_GET['idCasier'] : "";
            $idColis = isset($_GET['idColis']) ? $_GET['idColis'] : "";
            $stmt = $conn->prepare("UPDATE box_contient_colis SET idActeur=:idActeur,idOperation=:idOperation,dateOperation=CURRENT_DATE() WHERE idBox=:idBox AND idCasier=:idCasier AND idColis=:idColis ");
            $stmt->bindParam(':idActeur', $idActeur);
            $stmt->bindParam(':idOperation', $idOperation);
            $stmt->bindParam(':idBox', $idBox);
            $stmt->bindParam(':idCasier', $idCasier);
            $stmt->bindParam(':idColis', $idColis);
            $stmt->execute();
            // Mise à jour de la table box avec etatBox et dateDerniereUtilisation
            if ($idOperation == 0) $etatBox = 1;
            if ($idOperation == 1) $etatBox = 0;
            $stmt = $stmt = $conn->prepare("UPDATE box SET etatBox=:etatBox,dateDerniereUtilisation=CURRENT_DATE() WHERE idBox=:idB AND idCasier=:idC");
            $stmt->bindParam(':etatBox', $etatBox);
            $stmt->bindParam(':idB', $idBox);
            $stmt->bindParam(':idC', $idCasier);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        //fermer la connexion
        CloseCon($conn);
        break;
    case 'POST':
        break;
    case 'PUT':
        break;

    default:
        // Requête invalide
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

?>