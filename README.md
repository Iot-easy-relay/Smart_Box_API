# Smart_Box_API_php
this is a simple api to check the state of a box and to add a package(colis) to the box.

**************** how to use *********************

1)-to get the box number of the colis
use a GET request with this link: http://localhost/smart_box_api_php/api/findColis/numeroDeColis
and it will affect the colis to the least recently used boxx from that casier.

2)-to add a package(colis) to the box , use a POST request to this link http://localhost/Smart_Box_API_php/api/box_contient_colis
and set all the information in a json format 
exemple 
     {
     "idActeur":"1",
     "idColis":"545",
     "typeOperation":"depot",
     "commune":"16"
     }
    
3)-to retrive (delete) a package(colis) from the box , use a DELETE request to this link http://localhost/Smart_Box_API_php/api/box_contient_colis
and mention the idColis in a json format 
exemple 
	{
		"idColis":"13"
	}
	
