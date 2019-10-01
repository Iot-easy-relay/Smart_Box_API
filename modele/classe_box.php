<?php

include "classe_casier.php";


//****************************************************************************************//
//inserer un box
function inserer_box($idBox,$idCasier,$etatBox,$longueurBox,$largeurBox,$hauteurBox){
	
	try{
		//ouvrir la connexion
		$conn = OpenCon();
		
		$stmt = $conn->prepare("INSERT INTO box(idBox,idCasier,etatBox,longueurBox,largeurBox,hauteurBox)
									VALUES (:idBox,:idCasier,:etatBox,:longueurBox,:largeurBox,:hauteurBox)");
		$stmt->bindParam(':idBox', $idBox);
		$stmt->bindParam(':idCasier', $idCasier);
		$stmt->bindParam(':etatBox', $etatBox);
		$stmt->bindParam(':longueurBox', $longueurBox);
		$stmt->bindParam(':largeurBox', $largeurBox);
		$stmt->bindParam(':hauteurBox', $hauteurBox);
		
		$stmt->execute();
		echo "box ajouté" . "<br>";
		
	}catch(PDOException $e)
    {
		echo "Error: " . $e->getMessage();
    }
	
	//fermer la connexion
	CloseCon($conn);	
}

//****************************************************************************************//
//supprimer un box
function supprimer_box_IDBOX($idBox,$idCasier){
	
		try{
		//ouvrir la connexion
		$conn = OpenCon();
		
		//supprimer le box identifié par idBox et l'idCasier
		$stmt = $conn->prepare("DELETE FROM box WHERE idBox= :idBox and idCasier= :idCasier");
		$stmt->bindParam(':idBox', $idBox);
		$stmt->bindParam(':idCasier', $idCasier);
		
		$stmt->execute();
		echo "box supprimé" . "<br>";
		
	}catch(PDOException $e)
    {
		echo "Error: " . $e->getMessage();
    }
	
	//fermer la connexion
	CloseCon($conn);
}

//****************************************************************************************//
//modifier un etatBox
function modifier_etatBox_IDBOX($idBox,$idCasier,$etatBox){
	
	try{
	//ouvrir la connexion
	$conn = OpenCon();
	
	//modidier l'etat_box identifié par idBox et idCasier
		
		$stmt = $conn->prepare("UPDATE box SET etatBox=:etatBox WHERE idBox=:idBox and idCasier=:idCasier");
		$stmt->bindParam(':idBox', $idBox);
		$stmt->bindParam(':idCasier', $idCasier);
		$stmt->bindParam(':etatBox', $etatBox);
		
		$stmt->execute();
		echo "etat box modifié" . "<br>";


	} catch(PDOException $e)
    {
		echo "Error: " . $e->getMessage();
    }
	//fermer la connexion
	CloseCon($conn);
}
//****************************************************************************************//

//modifier les dimensions d'un box
function modifier_dimensionBox_IDBOX($idBox,$idCasier,$longueurBox,$largeurBox,$hauteurBox){
	
	try{
	//ouvrir la connexion
	$conn = OpenCon();
	
	//modidier les dimensions du box identifié par idBox et idCasier
		
		$stmt = $conn->prepare("UPDATE box SET longueurBox=:longueurBox , largeurBox=:largeurBox, hauteurBox=:hauteurBox WHERE idBox=:idBox and idCasier=:idCasier");
		$stmt->bindParam(':idBox', $idBox);
		$stmt->bindParam(':idCasier', $idCasier);
		$stmt->bindParam(':longueurBox', $longueurBox);
		$stmt->bindParam(':largeurBox', $largeurBox);
		$stmt->bindParam(':hauteurBox', $hauteurBox);
		
		$stmt->execute();
		echo "dimensions box modifiées" . "<br>";

	} catch(PDOException $e)
    {
		echo "Error: " . $e->getMessage();
    }
	//fermer la connexion
	CloseCon($conn);
}

//****************************************************************************************//
//trouver l'etatBox d'un box donné
function rechercher_etatBox_IDBOX($idBox,$idCasier){
	try{
	//ouvrir la connexion
	$conn = OpenCon();
	
		$stmt = $conn->prepare("SELECT idBox,etatBox FROM box WHERE idBox= :idBox and idCasier= :idCasier");
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

//****************************************************************************************//
//trouver les dimensions d'un box donné
function rechercher_dimensionsBox_IDBOX($idBox,$idCasier){
	try{
	//ouvrir la connexion
	$conn = OpenCon();
	
		$stmt = $conn->prepare("SELECT idBox,longueurBox,largeurBox,hauteurBox FROM box WHERE idBox= :idBox and idCasier= :idCasier");
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

//trouver les box d'un idCasier donné
function rechercher_box_IDCASIER($idCasier)
{
	try{
	//ouvrir la connexion
	$conn = OpenCon();
	
		$stmt = $conn->prepare("SELECT idBox FROM box WHERE idCasier= :idCasier");
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

//get the least recently used box
function rechercher_LRU_BOX($commune, $idColis)
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

 Function Rechercher_Box_Vide($casier)

{    try{
	$conn=OpenCon();
	//récépurer les box vide d'un casier
		$stmt = $conn->prepare("SELECT * FROM Box WHERE etatBox=0 and idCasier=:casier"); // VIDE
		$stmt->bindParam(':casier', $casier);
		$stmt->execute();
		//retourner un tableau associatif
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }catch (PDOException $e)
    {
		echo "Error: " . $e->getMessage();
		return null;
    }
	//fermer la connexion
	CloseCon($conn);
	
}

Function comparer_dimensions ($longeurColis,$largeurColis,$hauteurColis){
	
	$longeur=12;
    $largeur=12;
	$hauteur=12;
	
	$conn=OpenCon();
if ($longeurColis>=$longeur){
		if( $longeurColis>=$largeur){
			if($longeurColis>=$hauteur){
				echo "pas de box";
			}else {
				// longeur passe avec la hauteur
			if ($largeurColis>=$longeur)	{
				if ($largeurColis>=$largeur){
					echo "pas de box"; 
					
				}else {
					// largeur passe avec largeur
				if ($hauteurColis>=$longeur){
					
					echo "pas de box";
				}else {
					
					//la hauteur passe avec la longeur
					echo "box dispo";
				}
				}
			}else {
				// la largeur passe avec la longeur
				if($hauteurColis>=$largeur){
					echo "pas de box"; 
				}else{
				//la hauteur passe avec la largeur 
					echo "box dispo";
				}
			}
			}
		}else {
			// la longeur passe avec la largeur 
			if ($largeurColis>=$longeur){
				if ($largeurColis>=$hauteur){
					echo "pas de box";
				}else {
					// la largeur passe avec la hauteur
					if (hauteurColis>=longeur){
						echo "pas de box";
					}else {
						echo "box dispo";
					}
				}
			}else {
				// la largeur passe avec la longeur
				if ($hauteurColis>=$hauteur){
					// pas de box
				}else {
					
					echo "box dispo";
				}
				
			}
			
		}
		
		}else {
			// la longeur passe avec la longeur 
			if ($largeurColis>$largeur){
				if ($largeurColis>$hauteur){
					echo "pas de box";
				}else {
					// largeur passe avec la hauteur
					if ($hauteurColis>$largeur){
						echo "pas de box";
					}else {
						// hauteur passe avec largeur
						echo "box dispo";
					}
				}
			}else{
				// la largeur passe avec la largeur
				if ($hauteurColis>$hauteur){
					echo "pas de box";
				}else{
					// hauteur passe avec hauteur
					echo "box dispo";
				}
			}
		}
	
	
	 
		CloseCon($conn);
}

Function recherche_Box ($commune,$idColis,$longeurColis,$largeurColis,$hauteurColis){
	try {
	$conn=OpenCon();
	$casier= Rechercher_Casier_Commune($commune); // recuperer le casier d'une commune donnée 
	$boxes=Rechercher_Box_Vide($casier[0]['idCasier']); // recuperer les box vides d'un casier donné // un casier par commune 
	
	$i=0;
    foreach ($boxes as $row) { // récuperer dans la var $B les boxs ou peut entrer le colis  
	$longeur = $row['longueurBox'];
    $largeur = $row['largeurBox'];
    $hauteur = $row['hauteurBox'];
	
	//echo $longeur ; echo $largeur; echo $hauteur; echo "            ";
	// boucle imbriqué de comparaison de dimensions
	if ($longeurColis>$longeur){
		if( $longeurColis>$largeur){
			if($longeurColis>$hauteur){
				//echo "non";
			}else {
				// longeur passe avec la hauteur
			if ($largeurColis>$longeur)	{
				if ($largeurColis>$largeur){
					
					//echo "non";
				}else {
					// largeur passe avec largeur
				if ($hauteurColis>$longeur){
					//echo "non";
					
				}else {
					
					//la hauteur passe avec la longeur
				
				$B[$i]=$row;
				$i++;
				
				}
				}
			}else {
				// la largeur passe avec la longeur
				if($hauteurColis>$largeur){
					//echo "non";
				}else{
				//la hauteur passe avec la largeur 
					
					$B[$i]=$row;
					$i++;
				    
				}
			}
			}
		}else {
			// la longeur passe avec la largeur 
			if ($largeurColis>$longeur){
				if ($largeurColis>$hauteur){
					//echo "non";
				}else {
					// la largeur passe avec la hauteur
					if (hauteurColis>$longeur){
					//	echo "non";
						
					}else {
						
						$B[$i]=$row;
						$i++;
				        
					}
				}
			}else {
				// la largeur passe avec la longeur
				if ($hauteurColis>$hauteur){
					//echo "non";
					
				}else {
					
					
					$B[$i]=$row;
					$i++;
				    
				}
				
			}
			
		}
		
		}else {
			// la longeur passe avec la longeur 
			if ($largeurColis>$largeur){
				if ($largeurColis>$hauteur){
					//echo "non";
					
				}else {
					// largeur passe avec la hauteur
					if ($hauteurColis>$largeur){
						//echo "non";
						
					}else {
						// hauteur passe avec largeur
						
						$B[$i]=$row;
						$i++;
				        
					}
				}
			}else{
				// la largeur passe avec la largeur
				if ($hauteurColis>$hauteur){
					//echo "non";
					
				}else{
					// hauteur passe avec hauteur
					
					$B[$i]=$row;
					$i++;
				    
				}
			}
		}
	
			
	} if ($i==0){
		       header('Content-Type: application/json');
		       echo json_encode(['Message'=>'Box non disponible']);
			   return 0;
	}
	
	
	
	$date=$B[0]['dateDerniereUtilisation'];
	$idBox=$B[0]['idBox'];
	$idCasier=$B[0]['idCasier'];
	//echo $date; echo $idBox; echo $idCasier; echo "        ";
	
	foreach( $B as $row){
		if ( $row['dateDerniereUtilisation'] < $date) {
	    $date=$row['dateDerniereUtilisation'];
        $idBox=$row['idBox'];
		$idCasier=$row['idCasier'];
		}
	}
	
	
	
	$msg[0]= $idBox;
	$msg[1]=$idCasier;
	header('Content-Type: application/json');
	echo json_encode($msg);
	return $msg;
	
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
		return null;
	}
	
	CloseCon($conn);
	
}

/// TEST RECHERCHE BOX , RESULTAT 3 1 
/*$msg=recherche_Box (1601,1,1,1,1);
echo $msg[0];
echo $msg[1];*/





?>