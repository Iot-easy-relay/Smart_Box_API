<?php

  include "./modele/connection.php";
  include "./modele/classe_box.php";
	
  $request_method = $_SERVER["REQUEST_METHOD"];  
  
  switch($request_method)
  {
    case 'GET':
	
	  $idCommune= isset($_GET['idCommune']) ? $_GET['idCommune']:""; 
	  $idColis= isset($_GET['idColis']) ? $_GET['idColis']:""; 
	  $longeurColis= isset($_GET['longeurColis']) ? $_GET['longeurColis']:""; 
	  $largeurColis= isset($_GET['largeurColis']) ? $_GET['largeurColis']:""; 
	  $hauteurColis= isset($_GET['hauteurColis']) ? $_GET['hauteurColis']:""; 
      PreAffectation ($idCommune,$idColis,$longeurColis,$largeurColis,$hauteurColis);
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
  
  
  
  Function PreAffectation ($idCommune,$idColis,$longeurColis,$largeurColis,$hauteurColis){
	  try{
	  $conn= OpenCon();
	  $box=recherche_Box ($idCommune,$idColis,$longeurColis,$largeurColis,$hauteurColis);
	  if ($box){
      $idBox= $box[0];
      $idCasier=$box[1]; 
	  //$DateOperation = date('Y-m-d'); 
	 
	  
	  $sql = "INSERT INTO box_contient_colis VALUES (null,$idBox,$idCasier,$idColis,2,CURRENT_DATE())";
	  $result1 = $conn->query($sql);
	  modifier_etatBox_IDBOX($idBox, $idCasier,2);
        
	  }
	  }catch(PDOException $e)
    {
		echo "Error: " . $e->getMessage();
    }
	
	//fermer la connexion
	CloseCon($conn);
  }
?>