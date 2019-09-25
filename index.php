<?php

use http\Url;
use function Sodium\add;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT');
$method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI']; // get the request URL
$valideRoots = ['findColis', 'addColis']; // the valide Roots used in the URL
$url = rtrim($request_uri, '/');
$url = filter_var($request_uri, FILTER_SANITIZE_URL);
$url = explode('/', $url); // convert the URL to an array
$idCasier = 0;
$idBox = 0;
$Root = (string)$url[3];      // exemple http://localhost/Smart_Box_API_php/api/findColis/132/21  ==> root=url[3]==findColis
if (sizeof($url) > 5) {
    $commune = (int)$url[4];//exemple http://localhost/Smart_Box_API_php/api/findColis/16/132 ==> commune=url[4]==16
    $idColis = (int)$url[5];// exemple http://localhost/Smart_Box_API_php/api/findColis/16/132 ==> idColis=url[5]==132
}
if (in_array($Root, $valideRoots)) //if the table name exist in our database
{
    include_once './api/API.php';
} else {
    echo json_encode(['message' => 'INVALID URL: Table does not exists']);
}/**/
