<?php
if ($method == 'GET') // check the box state
{
    include_once 'modeles/classe_box.php';
    $data = rechercher_etatBox_IDBOX($idBox, $idCasier);
    if ($data != null) {
        echo json_encode(['etat box' => $data['etatBox']]);
    } else {
        echo json_encode(['message' => 'BOX Not Found.']);
    }
} elseif ($method == 'POST') // add colis to the box
{
    if ($_POST != null) // if the body of post request is not null
    {
        extract($_POST);
        $colis_longeur = 0;//from another api
        $colis_largeur = 0;//from another api
        $colis_hauteur = 0;//from another api
        include_once 'modeles/classe_box.php';
        $etatBoxEnBDD = rechercher_etatBox_IDBOX($idBox, $idCasier);
        $dimonsionEnBDD = rechercher_dimensionsBox_IDBOX($idBox, $idCasier);
        $etat = $etatBoxEnBDD['etatBox'];
        $longeur = $dimonsionEnBDD['longueurBox'];
        $largeur = $dimonsionEnBDD['largeurBox'];
        $hauteur = $dimonsionEnBDD['hauteurBox'];
        if ($idCasier && ($etat != "plein") && ($colis_longeur < $longeur) && ($colis_largeur < $largeur) && ($colis_hauteur < $hauteur)) {
            include_once 'modeles/classe_box_contient_colis.php';
            inserer_box_colis($idActeur, $idBox, $idCasier, $idColis, null, $typeOperation);
            include_once 'modeles/classe_box.php';
            modifier_etatBox_IDBOX($idBox, $idCasier, 'plein');
        } else {
            echo json_encode(['message' => 'le box est deja occupe ou plus petit que la taille du colis', 'success' => false]);
        }
    } else {
        echo json_encode(['message' => 'Please pill in all the credentials', 'success' => false]);
    }
} elseif ($method == 'DELETE') //retrieve the colis from the box
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
