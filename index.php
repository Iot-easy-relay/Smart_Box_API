<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT');
$method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI']; // get the request URL
$valideRoots = ['API_Preaffectation', 'API_MaJ','API_etat_casier']; // the valide Roots used in the URL
$url = rtrim($request_uri, '/');
$url = filter_var($request_uri, FILTER_SANITIZE_URL);
$url = explode('/', $url); // convert the URL to an array
$url = explode('?', $url[2]);//get the r
$Root = (string)$url[0];
// exemple http://localhost/Smart_Box_API/API_etat_casier?idCasier=1  ==> root==API_etat_casier
if (in_array($Root, $valideRoots)) //if the table name exist in our database
{
    switch ($Root) {
        case "API_Preaffectation":
            include_once './API_Preaffectation.php';
            break;
        case "API_MaJ" :
            include_once './API_MaJ.php';
            break;
        case "API_etat_casier":
            include_once "./etat_casier.php";
            break;
    }
} else {
    echo json_encode(['message' => 'INVALID URL: Root does not exists']);
}/**/
