<?php
if ($method == 'GET') // check the box state
{
    get_request($idColis);
    preAffectation_colis(16, $idColis);
} elseif ($method == 'POST') // add colis to the box
{
    if ($_POST != null) // if the body of post request is not null
    {
        extract($_POST);
      //  echo 'the id o the colis is '.$idColis;
        post_request($idColis,$idActeur,$typeOperation);
    } else {
        echo json_encode(['message' => 'Please pill in all the credentials', 'success' => false]);
    }
} elseif ($method == 'DELETE') //retrieve the colis from the box
{
    delete_request();
}
function post_request($idColis,$idActeur,$typeOperation)
{


    $colis_longeur = 0;//from another api
    $colis_largeur = 0;//from another api
    $colis_hauteur = 0;//from another api
    include_once 'modeles/classe_box.php';
    include_once 'modeles/classe_box_contient_colis.php';
    $Box = rechercher_box_colis($idColis);
    $idBox = $Box['idBox'];
    $idCasier = $Box['idCasier'];
    $etatBoxEnBDD = rechercher_etatBox_IDBOX($idBox, $idCasier);
    $dimonsionEnBDD = rechercher_dimensionsBox_IDBOX($idBox, $idCasier);
    $etat = $etatBoxEnBDD['etatBox'];
    $longeur = $dimonsionEnBDD['longueurBox'];
    $largeur = $dimonsionEnBDD['largeurBox'];
    $hauteur = $dimonsionEnBDD['hauteurBox'];
    if (($etat != "plein") && ($colis_longeur < $longeur) && ($colis_largeur < $largeur) && ($colis_hauteur < $hauteur)) {
        include_once 'modeles/classe_box_contient_colis.php';
        modifier_box_colis($idActeur, $idBox, $idCasier, $typeOperation);
       // inserer_box_colis($idActeur, $idBox, $idCasier, $idColis, null, $typeOperation);
        include_once 'modeles/classe_box.php';
        modifier_etatBox_IDBOX($idBox, $idCasier, 'plein');
    } else {
        echo json_encode(['message' => 'le box est deja occupe ou plus petit que la taille du colis', 'success' => false]);
    }

}

function delete_request()
{
    parse_str(file_get_contents("php://input"), $post_vars);//get the body of the DELETE request
    $idColis = $post_vars['idColis'];
    include_once 'modeles/classe_box_contient_colis.php';
    $data = rechercher_box_colis($idColis);
    $idBox = $data['idBox'];
    $idCasier = $data['idCasier'];
    if ($idBox && $idCasier) {
        supprimer_colis_box($idBox, $idCasier);
        include_once 'modeles/classe_box.php';
        modifier_etatBox_IDBOX($idBox, $idCasier, 'vide');
    }/**/
}

function get_state_box_state($idBox, $idCasier)
{
    include_once 'modeles/classe_box.php';
    $data = rechercher_etatBox_IDBOX($idBox, $idCasier);
    if ($data != null) {
        echo json_encode(['etat box' => $data['etatBox']]);
    } else {
        echo json_encode(['message' => 'BOX Not Found.']);
    }
}

function preAffectation_colis($commune, $idColis)
{
    include_once 'modeles/classe_box.php';
    $boxes = rechercher_LRU_BOX($commune, $idColis);
    if ($boxes) {
        $idBox = $boxes['idBox'];
        $idCasier = $boxes['idCasier'];
        //ouvrir la connexion
        $conn = OpenCon();
        $sql = "INSERT INTO box_contient_colis VALUES (null,$idBox,$idCasier,$idColis,null,null)";
        modifier_etatBox_IDBOX($idBox, $idCasier, 'affecte');
        if ($conn->query($sql) === TRUE) {
            echo "colis affecter";
        } else {
            echo "erreur dans l'affectation du colis: " . $sql . $conn->error;
        }
        CloseCon($conn);
    }
    //fermer la connexion

}
function get_request($idColis)
{
    include_once 'modeles/classe_box_contient_colis.php';
    $data = rechercher_box_colis($idColis);
   if($data){
    echo json_encode(['idBox' => $data['idBox'],
        'idCasier' => $data['idCasier']
    ]);}
}