<?php

include './modele/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	
	$idCasier = isset($_GET['idCasier']) ? $_GET['idCasier'] : "";
	
	//recuperer un tableau de idBox d'un casier définé par idCasier donné
	
	include './modele/classe_box.php';
	$boxes= rechercher_box_IDCASIER($idCasier);
	
		foreach ($boxes as $row) {
			
				//recuperer pour chaque idBox son etat
				$etatbox= rechercher_etatBox_IDBOX($row['idBox'],$idCasier);
				
				//pour un box occupe, recuperer le colis qu'il contient
				
				if ($etatbox[0]['etatBox'] == 1){ //soit 1 idetatbox occupe
					
					include_once'./modele/classe_box_contient_colis.php';
					
					//recuperer le colis qui se trouve dans le box occupe
					$msg = rechercher_colis_IDBOX_IDCASIER($row['idBox'],$idCasier);
					
					header('content-type: application/json');
					echo (json_encode($msg));
					
				}
				else{
					header('content-type: application/json');
					echo (json_encode($etatbox));
				}
			}
}
?>