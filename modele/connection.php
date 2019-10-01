<?php
function OpenCon()
 {
 $dbhost = "localhost";		//@ip du server ovh
 $dbuser = "root";
 $dbpass = "";			//"X7ecLlU7KQB83T2c";
 $db = "smart_box";
 	
	try {
		$conn = new PDO("mysql:host=$dbhost;dbname=$db", $dbuser, $dbpass);	//array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
		
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "Connected successfully";
		
	}catch(PDOException $e){
		echo "Connection failed: " . $e->getMessage();
    }
		return $conn;
 }
 
function CloseCon($conn)
 {
	$conn = null;
 }
   
?>
