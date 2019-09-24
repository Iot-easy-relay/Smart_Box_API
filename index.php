<?php

use http\Url;
use function Sodium\add;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT');
$method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI']; // get the request URL
$tables = ['box', 'box_contient_colis', 'casier']; // the tables of our database
$url = rtrim($request_uri, '/');
$url = filter_var($request_uri, FILTER_SANITIZE_URL);
$url = explode('/', $url); // convert the URL to an array
$idCasier = 0;
$idBox = 0;
$tableName = (string)$url[3];      // exemple http://localhost/Smart_Box_API_php/api/box/132/21  ==> tableName=url[3]==box
if (sizeof($url) > 4)
{
    $idCasier = (int)$url[4]; // exemple http://localhost/Smart_Box_API_php/api/box/132/21  ==> numcasier=url[4]==box
    $idBox = (int)$url[5];       //exemple http://localhost/Smart_Box_API_php/api/box/132/21  ==> numBox=url[5]==box
}
if (in_array($tableName, $tables)) //if the table name exist in our database
{
    include_once './api/API.php';
} else {
    echo json_encode(['message' => 'INVALID URL: Table does not exists']);
}